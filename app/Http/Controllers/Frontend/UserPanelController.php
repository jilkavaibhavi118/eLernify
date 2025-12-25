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
            'avg_progress' => $enrollments->avg('progress') ?? 0,
            'total_items' => \App\Models\OrderItem::whereHas('order', function($q) {
                $q->where('user_id', Auth::id())->where('status', 'completed');
            })->count()
        ];

        // Recommended Courses: Active courses the user is NOT enrolled in
        $enrolledCourseIds = $enrollments->pluck('course_id')->toArray();
        $recommendedCourses = \App\Models\Course::where('status', 'active') // Assuming 'active' is the status for visible courses
            ->whereNotIn('id', $enrolledCourseIds)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('frontend.user-panel.dashboard', compact('enrollments', 'stats', 'recommendedCourses'));
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

    public function lectureView($lectureId, $materialId = null)
    {
        // Load lecture with course and its hierarchy (lectures -> quizzes)
        $lecture = Lecture::with([
                'course.lectures.materials', 
                'course.lectures.quizzes',
                'materials',
                'quizzes'
            ])->findOrFail($lectureId);

        // Verify user is enrolled in this course
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $lecture->course_id)
            ->firstOrFail();

        // Find the specific material if provided, otherwise default to first video material
        $activeMaterial = null;
        if ($materialId) {
            $activeMaterial = $lecture->materials->find($materialId);
        }
        
        if (!$activeMaterial) {
            $activeMaterial = $lecture->materials->filter(fn($m) => !empty($m->video_path) || !empty($m->content_url))->first();
        }

        // Navigation Logic (Next/Previous)
        $next_url = null;
        $prev_url = null;

        // Flatten the content sequence: Lecture -> [Materials/Videos] -> [Quizzes] -> Next Lecture
        $sequence = collect([]);
        foreach ($enrollment->course->lectures as $l) {
            // Add Video Materials for this Lecture
            foreach ($l->materials as $m) {
                if (!empty($m->video_path) || !empty($m->content_url)) {
                    $sequence->push([
                        'type' => 'material', 
                        'id' => $m->id, 
                        'title' => $m->title,
                        'lecture_id' => $l->id,
                        'url' => route('user.lecture.view', ['lectureId' => $l->id, 'materialId' => $m->id])
                    ]);
                }
            }
            
            // Add Quizzes for this Lecture
            if ($l->quizzes) {
                foreach ($l->quizzes as $q) {
                    $sequence->push([
                        'type' => 'quiz', 
                        'id' => $q->id, 
                        'title' => 'Quiz: ' . $q->title,
                        'lecture_id' => $l->id,
                        'url' => route('user.quiz.view', $q->id)
                    ]);
                }
            }
        }

        // Find current position in sequence
        $currentPosition = $sequence->search(function ($item) use ($lecture, $activeMaterial) {
            if ($item['type'] === 'material') {
                return $activeMaterial && $item['id'] === $activeMaterial->id;
            }
            return false; // Quizzes are handled on the quiz view page anyway
        });

        $prev_title = null;
        $next_title = null;
        if ($currentPosition !== false) {
            // Update Progress: (Total items viewed / Total items) * 100
            $totalItems = max(1, $sequence->count());
            $newProgress = (($currentPosition + 1) / $totalItems) * 100;
            
            // Only update if it's an improvement (to handle going back)
            if ($newProgress > ($enrollment->progress ?? 0)) {
                $enrollment->updateProgress($newProgress);
            }

            if ($currentPosition > 0) {
                $prev_url = $sequence[$currentPosition - 1]['url'];
                $prev_title = $sequence[$currentPosition - 1]['title'];
            }
            if ($currentPosition < $sequence->count() - 1) {
                $next_url = $sequence[$currentPosition + 1]['url'];
                $next_title = $sequence[$currentPosition + 1]['title'];
            }
        }

        return view('frontend.user-panel.lecture-view', compact('lecture', 'activeMaterial', 'enrollment', 'next_url', 'prev_url', 'next_title', 'prev_title'));
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
                // Add Video Materials
                foreach ($l->materials as $m) {
                    if (!empty($m->video_path) || !empty($m->content_url)) {
                        $sequence->push([
                            'type' => 'material', 
                            'id' => $m->id, 
                            'title' => $m->title,
                            'lecture_id' => $l->id,
                            'url' => route('user.lecture.view', ['lectureId' => $l->id, 'materialId' => $m->id])
                        ]);
                    }
                }

                // Add Quizzes
                if ($l->quizzes) {
                    foreach ($l->quizzes as $q) {
                        $sequence->push([
                            'type' => 'quiz', 
                            'id' => $q->id, 
                            'title' => 'Quiz: ' . $q->title,
                            'lecture_id' => $l->id,
                            'url' => route('user.quiz.view', $q->id)
                        ]);
                    }
                }
            }
        }

        $currentPosition = $sequence->search(function ($item) use ($quiz) {
            return $item['type'] === 'quiz' && $item['id'] === $quiz->id;
        });

        if ($currentPosition !== false) {
            // Update Progress for Quiz (optional, usually quizzes also count towards progress)
            $totalItems = max(1, $sequence->count());
            $newProgress = (($currentPosition + 1) / $totalItems) * 100;
            if ($newProgress > ($enrollment->progress ?? 0)) {
                $enrollment->updateProgress($newProgress);
            }

            if ($currentPosition > 0) {
                $prev_url = $sequence[$currentPosition - 1]['url'];
                $prev_title = $sequence[$currentPosition - 1]['title'];
            }
            if ($currentPosition < $sequence->count() - 1) {
                $next_url = $sequence[$currentPosition + 1]['url'];
                $next_title = $sequence[$currentPosition + 1]['title'];
            }
        }
        
        $prev_title = $prev_title ?? null;
        $next_title = $next_title ?? null;

        return view('frontend.user-panel.quiz-view', compact('quiz', 'enrollment', 'next_url', 'prev_url', 'next_title', 'prev_title'));
    }

    public function quizSubmit(Request $request, $quizId)
    {
        $quiz = Quiz::with(['questions.options', 'lecture'])->findOrFail($quizId);

        // Define courseId for enrollment check
        $courseId = $quiz->course_id ?? ($quiz->lecture ? $quiz->lecture->course_id : null);

        // Verify access (either free, enrolled, or purchased)
        $hasAccess = $quiz->is_free || auth()->user()->hasPurchased('quiz', $quizId);
        
        if (!$hasAccess && $courseId) {
             $hasAccess = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $courseId)
                ->exists();
        }

        if (!$hasAccess) {
            return redirect()->route('landing')->with('error', 'You do not have access to this quiz.');
        }

        $enrollment = null;
        if ($courseId) {
            $enrollment = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $courseId)
                ->first();
        }

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
        $courseId = $quiz->course_id ?? ($quiz->lecture ? $quiz->lecture->course_id : null);
        
        // Verify access (either free, enrolled, or purchased)
        $hasAccess = $quiz->is_free || auth()->user()->hasPurchased('quiz', $quiz->id);
        
        if (!$hasAccess && $courseId) {
             $hasAccess = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $courseId)
                ->exists();
        }

        if (!$hasAccess) {
             return redirect()->route('landing')->with('error', 'You do not have access to this quiz result.');
        }

        $enrollment = null;
        if ($courseId) {
            $enrollment = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $courseId)
                ->first();
        }

        return view('frontend.user-panel.quiz-result', compact('attempt', 'quiz', 'enrollment'));
    }

    public function profile()
    {
        $user = Auth::user()->load(['experiences', 'educations']);
        return view('frontend.user-panel.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'occupation' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'occupation', 'bio', 'phone', 'address']);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && \Storage::disk('public')->exists($user->profile_photo)) {
                \Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $data['profile_photo'] = $path;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function addExperience(Request $request)
    {
        $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        Auth::user()->experiences()->create($request->all());

        return redirect()->back()->with('success', 'Experience added successfully!');
    }

    public function deleteExperience($id)
    {
        Auth::user()->experiences()->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Experience deleted successfully!');
    }

    public function addEducation(Request $request)
    {
        $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        Auth::user()->educations()->create($request->all());

        return redirect()->back()->with('success', 'Education added successfully!');
    }

    public function deleteEducation($id)
    {
        Auth::user()->educations()->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Education deleted successfully!');
    }

    public function purchases()
    {
        $orders = \App\Models\Order::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->with(['items.course', 'items.material', 'items.lecture', 'items.quiz'])
            ->latest()
            ->get();

        return view('frontend.user-panel.purchases', compact('orders'));
    }

    public function downloadCertificate($enrollmentId)
    {
        $enrollment = Enrollment::where('id', $enrollmentId)
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->with('course', 'user')
            ->firstOrFail();

        // Generate PDF certificate
        $pdf = \PDF::loadView('frontend.certificates.template', compact('enrollment'))
            ->setPaper('a4', 'landscape'); // Landscape/Rectangle format

        return $pdf->download('certificate-' . str_replace(' ', '-', $enrollment->course->title) . '.pdf');
    }
}
