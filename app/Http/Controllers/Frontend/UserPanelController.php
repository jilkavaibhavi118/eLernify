<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPanelController extends Controller
{
    public function dashboard()
    {
        $enrollments = Enrollment::where('user_id', Auth::id())
            ->with('course.category')
            ->latest('enrolled_at')
            ->get();

        $stats = [
            'total' => $enrollments->count(),
            'active' => $enrollments->where('status', 'active')->count(),
            'completed' => $enrollments->where('status', 'completed')->count(),
            'avg_progress' => $enrollments->avg('progress') ?? 0
        ];

        return view('frontend.user-panel.dashboard', compact('enrollments', 'stats'));
    }

    public function myCourses()
    {
        $enrollments = Enrollment::where('user_id', Auth::id())
            ->with('course.category', 'course.instructor')
            ->latest('enrolled_at')
            ->paginate(12);

        return view('frontend.user-panel.my-courses', compact('enrollments'));
    }

    public function courseView($enrollmentId)
    {
        $enrollment = Enrollment::where('id', $enrollmentId)
            ->where('user_id', Auth::id())
            ->with(['course.lectures', 'course.quizzes', 'course.instructor'])
            ->firstOrFail();

        return view('frontend.user-panel.course-view', compact('enrollment'));
    }

    public function lectureView($lectureId)
    {
        $lecture = Lecture::with('course')->findOrFail($lectureId);

        // Verify user is enrolled in this course
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $lecture->course_id)
            ->firstOrFail();

        return view('frontend.user-panel.lecture-view', compact('lecture', 'enrollment'));
    }

    public function quizView($quizId)
    {
        $quiz = Quiz::with(['course', 'questions.options'])->findOrFail($quizId);

        // Verify user is enrolled in this course
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $quiz->course_id)
            ->firstOrFail();

        return view('frontend.user-panel.quiz-view', compact('quiz', 'enrollment'));
    }

    public function quizSubmit(Request $request, $quizId)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($quizId);

        // Verify enrollment
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $quiz->course_id)
            ->firstOrFail();

        $answers = $request->input('answers', []);
        $score = 0;
        $totalQuestions = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $correctOption = $question->options->where('is_correct', true)->first();

            if ($userAnswer && $correctOption && $userAnswer == $correctOption->id) {
                $score++;
            }
        }

        $percentage = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;

        return redirect()->route('user.course.view', $enrollment->id)
            ->with('quiz_result', [
                'score' => $score,
                'total' => $totalQuestions,
                'percentage' => round($percentage, 2)
            ]);
    }
}
