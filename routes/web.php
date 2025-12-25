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
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Frontend\CourseController as FrontendCourseController;
use App\Http\Controllers\Frontend\UserPanelController;

// ✅ Landing Page
Route::get('/', function () {
    $categories = \App\Models\Category::where('status', 'active')
        ->withCount(['courses' => function ($query) {
            $query->where('status', 'active');
        }])
        ->having('courses_count', '>', 0)
        ->take(8)
        ->get();

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

    // Get Lectures, Materials, Quizzes for landing segments
    $featuredLectures = \App\Models\Lecture::where('status', 'active')->latest()->take(6)->get();
    $learningMaterials = \App\Models\Material::latest()->take(6)->get();
    $practiceQuizzes = \App\Models\Quiz::latest()->take(6)->get();

    return view('landing', compact(
        'categories',
        'categoryCourses',
        'totalCourses',
        'popularCourses',
        'featuredLectures',
        'learningMaterials',
        'practiceQuizzes'
    ));
})->name('landing');

// ✅ Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ✅ Google Auth Routes
Route::get('auth/google', [App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\SocialAuthController::class, 'handleGoogleCallback']);


// ✅ Purchase Flow
Route::post('/purchase/initiate', [App\Http\Controllers\Frontend\PurchaseController::class, 'initiate'])->name('purchase.initiate');
Route::post('/purchase/verify', [App\Http\Controllers\Frontend\PurchaseController::class, 'verify'])->name('purchase.verify');

// ✅ Resource Viewing with Access Check
Route::get('/lecture/{id}/view', [App\Http\Controllers\Frontend\ResourceController::class, 'viewLecture'])->name('lecture.view')->middleware(['auth', 'access.check:lecture']);
Route::get('/material/{id}/view', [App\Http\Controllers\Frontend\ResourceController::class, 'viewMaterial'])->name('material.view')->middleware(['auth', 'access.check:material']);
Route::get('/quiz/{id}/view', [App\Http\Controllers\Frontend\ResourceController::class, 'viewQuiz'])->name('quiz.view')->middleware(['auth', 'access.check:quiz']);

Route::get('/view-lectures', [App\Http\Controllers\Frontend\ResourceController::class, 'indexLectures'])->name('lectures.index');
Route::get('/view-materials', [App\Http\Controllers\Frontend\ResourceController::class, 'indexMaterials'])->name('materials.index');
Route::get('/view-quizzes', [App\Http\Controllers\Frontend\ResourceController::class, 'indexQuizzes'])->name('quizzes.index');

// ✅ Frontend Pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/courses', [FrontendCourseController::class, 'index'])->name('courses');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/instructors', function () {
    $instructors = \App\Models\Instructor::where('status', 'active')->get();
    return view('partials.instructors', compact('instructors'));
})->name('instructors');

// ✅ Course Detail Page
Route::get('/course/{id}', [FrontendCourseController::class, 'show'])->name('course.detail');

// ✅ Payment Routes (Auth Required)
Route::middleware(['auth', 'check.user.status'])->group(function () {
    Route::post('/course/{id}/pay', [FrontendCourseController::class, 'initiatePayment'])->name('course.pay');
    Route::post('/payment/verify', [FrontendCourseController::class, 'verifyPayment'])->name('payment.verify');
});

// ✅ User Panel Routes (Auth Required)
Route::middleware(['auth', 'check.user.status'])->prefix('my')->name('user.')->group(function () {
    Route::get('/dashboard', [UserPanelController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [UserPanelController::class, 'myCourses'])->name('courses');
    Route::get('/course/{enrollmentId}', [UserPanelController::class, 'courseView'])->name('course.view');
    Route::get('/lecture/{lectureId}/{materialId?}', [UserPanelController::class, 'lectureView'])->name('lecture.view');
    Route::get('/quiz/{quizId}', [UserPanelController::class, 'quizView'])->name('quiz.view');
    Route::post('/quiz/{quizId}/submit', [UserPanelController::class, 'quizSubmit'])->name('quiz.submit');
    Route::get('/quiz/result/{attemptId}', [UserPanelController::class, 'quizResult'])->name('quiz.result'); // New Route
    Route::get('/profile', [UserPanelController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserPanelController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/certificate/download/{enrollmentId}', [UserPanelController::class, 'downloadCertificate'])->name('certificate.download');
    Route::post('/profile/experience', [UserPanelController::class, 'addExperience'])->name('profile.experience.add');
    Route::delete('/profile/experience/{id}', [UserPanelController::class, 'deleteExperience'])->name('profile.experience.delete');
    Route::post('/profile/education', [UserPanelController::class, 'addEducation'])->name('profile.education.add');
    Route::delete('/profile/education/{id}', [UserPanelController::class, 'deleteEducation'])->name('profile.education.delete');
    Route::post('/profile', [UserPanelController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/purchases', [UserPanelController::class, 'purchases'])->name('purchases');
});


// ✅ Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('backend.')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('roles', RoleController::class);
    Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
    Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-status',[UserController::class, 'toggleStatus'])->name('backend.users.toggle-status');


    Route::get('lectures/search', [LectureController::class, 'search'])->name('lectures.search');
    Route::resource('lectures', LectureController::class);

    Route::resource('materials', MaterialController::class);
    Route::resource('quizzes', QuizController::class);

    Route::get('categories/search', [CategoryController::class, 'search'])->name('categories.search');
    Route::resource('categories', CategoryController::class);

    Route::resource('courses', CourseController::class);

    Route::get('instructors/search', [InstructorController::class, 'search'])->name('instructors.search');
    Route::resource('instructors', InstructorController::class);

    Route::resource('orders', OrderController::class)->only(['index', 'show']);
    Route::post('orders/{id}/refund', [OrderController::class, 'refund'])->name('orders.refund');

    Route::resource('payments', PaymentController::class)->only(['index', 'show']);
});
