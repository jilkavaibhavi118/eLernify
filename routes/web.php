<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\LectureController;
use App\Http\Controllers\Backend\MaterialController;
use App\Http\Controllers\Backend\QuizController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Frontend\CourseController as FrontendCourseController;
use App\Http\Controllers\Frontend\UserPanelController;

// ✅ Landing Page
Route::get('/', function () {
    $categoryCourses = \App\Models\Course::where('status', 'active')
        ->latest()
        ->take(4)
        ->get();
    $totalCourses = \App\Models\Course::where('status', 'active')->count();

    // Get courses for the courses section (grouped by category or just latest)
    $popularCourses = \App\Models\Course::where('status', 'active')
        ->with('category')
        ->latest()
        ->take(6)
        ->get();

    return view('landing', compact('categoryCourses', 'totalCourses', 'popularCourses'));
})->name('landing');

// ✅ Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ✅ Frontend Pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/courses', function () {
    return view('courses');
})->name('courses');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// ✅ Course Detail Page
Route::get('/course/{id}', [FrontendCourseController::class, 'show'])->name('course.detail');

// ✅ Payment Routes (Auth Required)
Route::middleware(['auth'])->group(function () {
    Route::post('/course/{id}/pay', [FrontendCourseController::class, 'initiatePayment'])->name('course.pay');
    Route::post('/payment/verify', [FrontendCourseController::class, 'verifyPayment'])->name('payment.verify');
});

// ✅ User Panel Routes (Auth Required)
Route::middleware(['auth'])->prefix('my')->name('user.')->group(function () {
    Route::get('/dashboard', [UserPanelController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [UserPanelController::class, 'myCourses'])->name('courses');
    Route::get('/course/{enrollmentId}', [UserPanelController::class, 'courseView'])->name('course.view');
    Route::get('/lecture/{lectureId}', [UserPanelController::class, 'lectureView'])->name('lecture.view');
    Route::get('/quiz/{quizId}', [UserPanelController::class, 'quizView'])->name('quiz.view');
    Route::post('/quiz/{quizId}/submit', [UserPanelController::class, 'quizSubmit'])->name('quiz.submit');
});


// ✅ Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('backend.')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('roles', RoleController::class);
    Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
    Route::post('roles/{role}/permissions', [RoleController::class, 'syncPermissions'])->name('roles.permissions.update');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('users', UserController::class);

    Route::get('lectures/search', [LectureController::class, 'search'])->name('lectures.search');
    Route::resource('lectures', LectureController::class);

    Route::resource('materials', MaterialController::class);
    Route::resource('quizzes', QuizController::class);

    Route::get('categories/search', [CategoryController::class, 'search'])->name('categories.search');
    Route::resource('categories', CategoryController::class);

    Route::resource('courses', CourseController::class);

    Route::get('instructors/search', [InstructorController::class, 'search'])->name('instructors.search');
    Route::resource('instructors', InstructorController::class);

    Route::resource('orders', OrderController::class)->only(['index']);
    Route::post('orders/{id}/refund', [OrderController::class, 'refund'])->name('orders.refund');
});
