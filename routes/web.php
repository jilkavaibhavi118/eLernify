<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\LectureController;
use App\Http\Controllers\Backend\MaterialController;
use App\Http\Controllers\Backend\QuizController;

// ✅ Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// ✅ Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
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
});
