<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
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
        // Load lecture with course and its hierarchy (lectures -> quizzes)
        $lecture = Lecture::with([
                'course.lectures.quizzes', // Hierarchical data for sidebar
                'materials',
                'quizzes'
            ])->findOrFail($lectureId);

        // Verify user is enrolled in this course
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $lecture->course_id)
            ->firstOrFail();

        // Calculate Progress
        $lectures = $enrollment->course->lectures->sortBy('id')->values();
        $totalLectures = max(1, $lectures->count());
        $currentIndex = $lectures->search(fn ($l) => $l->id === $lecture->id);
        
        // Simple progress: (Current Index + 1) / Total Lectures
        if ($currentIndex !== false) {
             // Logic could be improved to account for quizzes too, but keeping simple for now
            $progressFromLectures = (($currentIndex + 1) / $totalLectures) * 100;
            $enrollment->updateProgress($progressFromLectures);
        }

        // Navigation Logic (Next/Previous)
        $next_url = null;
        $prev_url = null;

        // Flatten the content sequence: Lecture -> [Quizzes] -> Next Lecture
        $sequence = collect([]);
        foreach ($enrollment->course->lectures as $l) {
            // Add Lecture (Video)
            $sequence->push(['type' => 'lecture', 'id' => $l->id, 'url' => route('user.lecture.view', $l->id)]);
            
            // Add Quizzes for this Lecture
            if ($l->quizzes) {
                foreach ($l->quizzes as $q) {
                    $sequence->push(['type' => 'quiz', 'id' => $q->id, 'url' => route('user.quiz.view', $q->id)]);
                }
            }
        }

        // Find current position
        $currentPosition = $sequence->search(function ($item) use ($lecture) {
            return $item['type'] === 'lecture' && $item['id'] === $lecture->id;
        });

        if ($currentPosition !== false) {
            // Previous
            if ($currentPosition > 0) {
                $prev_url = $sequence[$currentPosition - 1]['url'];
            }
            // Next
            if ($currentPosition < $sequence->count() - 1) {
                $next_url = $sequence[$currentPosition + 1]['url'];
            }
        }

        return view('frontend.user-panel.lecture-view', compact('lecture', 'enrollment', 'next_url', 'prev_url'));
    }

    public function quizView($quizId)
    {
        $quiz = Quiz::with(['course.lectures.quizzes', 'questions.options', 'lecture'])->findOrFail($quizId); // Load hierarchy

        // Robust Course ID Check: Use Quiz's course_id, fallback to Lecture's course_id
        $courseId = $quiz->course_id ?? ($quiz->lecture ? $quiz->lecture->course_id : null);

        if (!$courseId) {
            abort(404, 'Course not found for this quiz.');
        }

        // Verify user is enrolled in this course
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->firstOrFail();

        // Navigation Logic (Next/Previous)
        $next_url = null;
        $prev_url = null;

        // Ensure we have the course loaded on enrollment for traversal
        if (!$enrollment->relationLoaded('course')) {
             $enrollment->load('course.lectures.quizzes');
        }

        $sequence = collect([]);
        // Safety check regarding course existence
        if ($enrollment->course && $enrollment->course->lectures) {
            foreach ($enrollment->course->lectures as $l) {
                $sequence->push(['type' => 'lecture', 'id' => $l->id, 'url' => route('user.lecture.view', $l->id)]);
                if ($l->quizzes) {
                    foreach ($l->quizzes as $q) {
                        $sequence->push(['type' => 'quiz', 'id' => $q->id, 'url' => route('user.quiz.view', $q->id)]);
                    }
                }
            }
        }

        $currentPosition = $sequence->search(function ($item) use ($quiz) {
            return $item['type'] === 'quiz' && $item['id'] === $quiz->id;
        });

        if ($currentPosition !== false) {
            if ($currentPosition > 0) $prev_url = $sequence[$currentPosition - 1]['url'];
            if ($currentPosition < $sequence->count() - 1) $next_url = $sequence[$currentPosition + 1]['url'];
        }

        return view('frontend.user-panel.quiz-view', compact('quiz', 'enrollment', 'next_url', 'prev_url'));
    }

    public function quizSubmit(Request $request, $quizId)
    {
        $quiz = Quiz::with(['questions.options', 'lecture'])->findOrFail($quizId);

        // Robust Course ID Check: Use Quiz's course_id, fallback to Lecture's course_id
        $courseId = $quiz->course_id ?? ($quiz->lecture ? $quiz->lecture->course_id : null);

        if (!$courseId) {
            abort(404, 'Course not found for this quiz.');
        }

        // Verify enrollment
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->firstOrFail();

        $answers = $request->input('answers', []);
        $score = 0;
        $totalQuestions = $quiz->questions->count();

        // Create Attempt
        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => 0, // Will update later
            'total_questions' => $totalQuestions,
            'completed_at' => now(),
        ]);

        foreach ($quiz->questions as $question) {
            $userAnswerId = $answers[$question->id] ?? null;
            $correctOption = $question->options->where('is_correct', true)->first();
            $isCorrect = false;

            if ($userAnswerId && $correctOption && $userAnswerId == $correctOption->id) {
                $score++;
                $isCorrect = true;
            }

            // Store Answer
            QuizAttemptAnswer::create([
                'quiz_attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'question_option_id' => $userAnswerId, // Can be null if skipped
                'is_correct' => $isCorrect,
            ]);
        }

        // Update Attempt Score
        $attempt->update(['score' => $score]);

        $percentage = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;
        
        // Update Enrollment Progress if needed (optional logic could go here)

        return redirect()->route('user.quiz.result', $attempt->id);
    }

    public function quizResult($attemptId)
    {
        $attempt = QuizAttempt::where('id', $attemptId)
            ->where('user_id', Auth::id())
            ->with(['quiz.questions.options', 'quiz.lecture', 'answers'])
            ->firstOrFail();

        $quiz = $attempt->quiz;
        
        // Robust Course ID Check
        $courseId = $quiz->course_id ?? ($quiz->lecture ? $quiz->lecture->course_id : null);

        if (!$courseId) {
            abort(404, 'Course not found for this quiz.');
        }

        // Verify enrollment to ensure they still have access
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->firstOrFail();

        return view('frontend.user-panel.quiz-result', compact('attempt', 'quiz', 'enrollment'));
    }
}
