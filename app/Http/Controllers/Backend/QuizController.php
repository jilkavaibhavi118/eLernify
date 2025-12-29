<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Lecture;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Quiz::with('lecture.course')->latest();

            // Filter by instructor if not admin
            if (!auth()->user()->hasRole('Admin')) {
                $instructorId = auth()->user()->instructor ? auth()->user()->instructor->id : 0;
                $query->whereHas('lecture.course', function($q) use ($instructorId) {
                    $q->where('instructor_id', $instructorId);
                });
            }

            $data = $query->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('lecture', function($row){
                    return $row->lecture ? $row->lecture->title : 'N/A';
                })
                ->addColumn('duration', function($row){
                    return $row->duration . ' mins';
                })
                ->addColumn('pricing', function($row){
                    if ($row->is_free) {
                        return '<span class="badge bg-success">Free</span>';
                    }
                    return '<span class="badge bg-primary">₹'.number_format($row->price, 2).'</span>';
                })
                ->addColumn('questions_count', function($row){
                    return $row->questions()->count();
                })
                ->addColumn('action', function($row){
                    return view('layouts.includes.list-actions', [
                        'module' => 'quizzes',
                        'routePrefix' => 'backend.quizzes',
                        'data' => $row
                    ])->render();
                })
                ->rawColumns(['pricing', 'action'])
                ->make(true);
        }
        return view('backend.quizzes.index');
    }

    public function create()
    {
        $query = Lecture::query();
        if (!auth()->user()->hasRole('Admin')) {
            $instructorId = auth()->user()->instructor ? auth()->user()->instructor->id : 0;
            $query->whereHas('course', function($q) use ($instructorId) {
                $q->where('instructor_id', $instructorId);
            });
        }
        $lectures = $query->orderBy('title')->get(['id', 'title']);
        return view('backend.quizzes.create', compact('lectures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'duration' => 'required|integer|min:1',
            'instructions' => 'nullable|string',
            'lecture_id' => 'required|exists:lectures,id',
            'is_free' => 'nullable|boolean',
            'price' => 'required_if:is_free,0|nullable|numeric|min:0',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.explanation' => 'nullable|string',
            'questions.*.options' => 'required|array|min:4|max:4',
            'questions.*.options.*.option_text' => 'required|string',
            'questions.*.correct_option' => 'required|integer|min:0|max:3',
        ]);

        $lecture = Lecture::findOrFail($request->lecture_id);
        if ((auth()->user()->hasRole('Instructor') || auth()->user()->hasRole('Instructores')) && $lecture->course->instructor_id != auth()->user()->instructor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        DB::beginTransaction();
        try {
            $quiz = Quiz::create([
                'course_id' => $lecture->course_id,
                'title' => $request->title,
                'short_description' => $request->short_description,
                'duration' => $request->duration,
                'instructions' => $request->instructions,
                'lecture_id' => $request->lecture_id,
                'is_free' => $request->has('is_free'),
                'price' => $request->price,
            ]);

            foreach ($request->questions as $index => $questionData) {
                $question = $quiz->questions()->create([
                    'question_text' => $questionData['question_text'],
                    'explanation' => $questionData['explanation'] ?? null,
                    'order' => $index + 1,
                ]);

                foreach ($questionData['options'] as $optionIndex => $optionData) {
                    $question->options()->create([
                        'option_text' => $optionData['option_text'],
                        'is_correct' => $optionIndex == $questionData['correct_option'],
                        'order' => $optionIndex + 1,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => 'Quiz created successfully',
                'url' => route('backend.quizzes.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create quiz: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $quiz = Quiz::with(['lecture.course', 'questions.options'])->findOrFail($id);

        if ((auth()->user()->hasRole('Instructor') || auth()->user()->hasRole('Instructores')) && $quiz->lecture->course->instructor_id != auth()->user()->instructor->id) {
            abort(403, 'Unauthorized action.');
        }

        $query = Lecture::query();
        if (!auth()->user()->hasRole('Admin')) {
            $instructorId = auth()->user()->instructor ? auth()->user()->instructor->id : 0;
            $query->whereHas('course', function($q) use ($instructorId) {
                $q->where('instructor_id', $instructorId);
            });
        }
        $lectures = $query->orderBy('title')->get(['id', 'title']);

        return view('backend.quizzes.edit', compact('quiz', 'lectures'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::with('lecture.course')->findOrFail($id);

        if ((auth()->user()->hasRole('Instructor') || auth()->user()->hasRole('Instructores')) && $quiz->lecture->course->instructor_id != auth()->user()->instructor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'duration' => 'required|integer|min:1',
            'instructions' => 'nullable|string',
            'lecture_id' => 'required|exists:lectures,id',
            'is_free' => 'nullable|boolean',
            'price' => 'required_if:is_free,0|nullable|numeric|min:0',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.explanation' => 'nullable|string',
            'questions.*.options' => 'required|array|min:4|max:4',
            'questions.*.options.*.option_text' => 'required|string',
            'questions.*.correct_option' => 'required|integer|min:0|max:3',
        ]);

        DB::beginTransaction();
        try {
            $quiz->update([
                'course_id' => $quiz->lecture->course_id,
                'title' => $request->title,
                'short_description' => $request->short_description,
                'duration' => $request->duration,
                'instructions' => $request->instructions,
                'lecture_id' => $request->lecture_id,
                'is_free' => $request->has('is_free'),
                'price' => $request->price,
            ]);

            // Delete old questions and options
            $quiz->questions()->delete();

            // Create new questions
            foreach ($request->questions as $index => $questionData) {
                $question = $quiz->questions()->create([
                    'question_text' => $questionData['question_text'],
                    'explanation' => $questionData['explanation'] ?? null,
                    'order' => $index + 1,
                ]);

                foreach ($questionData['options'] as $optionIndex => $optionData) {
                    $question->options()->create([
                        'option_text' => $optionData['option_text'],
                        'is_correct' => $optionIndex == $questionData['correct_option'],
                        'order' => $optionIndex + 1,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => 'Quiz updated successfully',
                'url' => route('backend.quizzes.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update quiz: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $quiz = Quiz::with('lecture.course')->findOrFail($id);

        // Security check for instructors
        if ((auth()->user()->hasRole('Instructor') || auth()->user()->hasRole('Instructores')) && $quiz->lecture->course->instructor_id != auth()->user()->instructor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $quiz->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Quiz deleted successfully'
        ]);
    }

    public function results(Request $request)
    {
        if ($request->ajax()) {
            $query = QuizAttempt::with(['user', 'quiz.lecture.course', 'quiz.course'])->latest();

            // Filter by instructor if not admin
            if (!auth()->user()->hasRole('Admin')) {
                $instructorId = auth()->user()->instructor ? auth()->user()->instructor->id : 0;
                $query->where(function($q) use ($instructorId) {
                    $q->whereHas('quiz.course', function($sq) use ($instructorId) {
                        $sq->where('instructor_id', $instructorId);
                    })->orWhereHas('quiz.lecture.course', function($sq) use ($instructorId) {
                        $sq->where('instructor_id', $instructorId);
                    });
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('user_name', function($row){
                    return $row->user->name;
                })
                ->addColumn('user_email', function($row){
                    return $row->user->email;
                })
                ->addColumn('quiz_title', function($row){
                    return $row->quiz->title;
                })
                ->addColumn('course_title', function($row){
                    if ($row->quiz->course) {
                        return $row->quiz->course->title;
                    }
                    if ($row->quiz->lecture && $row->quiz->lecture->course) {
                        return $row->quiz->lecture->course->title;
                    }
                    return 'N/A';
                })
                ->addColumn('score_display', function($row){
                    if ($row->total_questions > 0) {
                        $percentage = ($row->score / $row->total_questions) * 100;
                        $colorClass = $percentage >= 80 ? 'text-success' : ($percentage >= 50 ? 'text-warning' : 'text-danger');
                        return '<div class="fw-bold '.$colorClass.'">' . $row->score . ' / ' . $row->total_questions . '</div>' . 
                               '<div class="text-muted" style="font-size: 0.75rem;">' . round($percentage, 1) . '%</div>';
                    }
                    return '0 / 0';
                })
                ->addColumn('date', function($row){
                    return $row->completed_at ? $row->completed_at->format('M d, Y') . '<br><small class="text-muted">' . $row->completed_at->format('h:i A') . '</small>' : 
                                               $row->created_at->format('M d, Y') . '<br><small class="text-muted">' . $row->created_at->format('h:i A') . '</small>';
                })
                ->rawColumns(['score_display', 'date'])
                ->make(true);
        }
        return view('backend.quizzes.results');
    }
}
