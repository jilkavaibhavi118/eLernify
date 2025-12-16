<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Quiz::with('lecture')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('lecture', function($row){
                    return $row->lecture ? $row->lecture->title : 'N/A';
                })
                ->addColumn('duration', function($row){
                    return $row->duration . ' mins';
                })
                ->addColumn('questions_count', function($row){
                    return $row->questions()->count();
                })
                ->addColumn('action', function($row){
                    $editUrl = route('backend.quizzes.edit', $row->id);
                    $deleteUrl = route('backend.quizzes.destroy', $row->id);
                    
                    $btn = '<div class="d-flex gap-2">';
                    $btn .= '<a href="' . $editUrl . '" class="btn btn-warning btn-sm">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" data-url="'.$deleteUrl.'" class="btn btn-danger btn-sm delete-btn">Delete</a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.quizzes.index');
    }

    public function create()
    {
        return view('backend.quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'instructions' => 'nullable|string',
            'lecture_id' => 'required|exists:lectures,id',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.explanation' => 'nullable|string',
            'questions.*.options' => 'required|array|min:4|max:4',
            'questions.*.options.*.option_text' => 'required|string',
            'questions.*.correct_option' => 'required|integer|min:0|max:3',
        ]);

        DB::beginTransaction();
        try {
            $quiz = Quiz::create([
                'title' => $request->title,
                'duration' => $request->duration,
                'instructions' => $request->instructions,
                'lecture_id' => $request->lecture_id,
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
        $quiz = Quiz::with(['lecture', 'questions.options'])->findOrFail($id);
        return view('backend.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'instructions' => 'nullable|string',
            'lecture_id' => 'required|exists:lectures,id',
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
                'title' => $request->title,
                'duration' => $request->duration,
                'instructions' => $request->instructions,
                'lecture_id' => $request->lecture_id,
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
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Quiz deleted successfully'
        ]);
    }
}
