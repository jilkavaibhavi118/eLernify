<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Order;
use App\Models\Lecture;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Check if user is an Instructor and NOT an Admin (Admins see everything)
        if (($user->hasRole('Instructores') || $user->hasRole('Instructor')) && !$user->hasRole('Admin')) {
            $instructorId = $user->instructor ? $user->instructor->id : 0;

            // Instructor specific stats
            $totalCourses = Course::where('instructor_id', $instructorId)->count();
            $totalLectures = Lecture::whereHas('course', function($q) use ($instructorId) {
                $q->where('instructor_id', $instructorId);
            })->count();
            
            // "Students" = Unique users who bought my courses
            $totalUsers = Order::whereHas('items.course', function($q) use ($instructorId) {
                $q->where('instructor_id', $instructorId);
            })->distinct('user_id')->count('user_id');

            // "Orders" = Total enrollments in my courses
            $totalOrders = Order::whereHas('items.course', function($q) use ($instructorId) {
                $q->where('instructor_id', $instructorId);
            })->count();

            // Recent Orders for my courses
            $recentOrders = Order::with(['user', 'items.course'])
                ->whereHas('items.course', function($q) use ($instructorId) {
                    $q->where('instructor_id', $instructorId);
                })
                ->latest()
                ->take(5)
                ->get();
            
            // Helper for view to know if we are showing instructor stats
            $isInstructor = true;
            $totalInstructors = 0; // Not relevant for instructor view

        } else {
            // Admin Global Stats
            $totalUsers = User::role('student')->count();
            $totalInstructors = User::role(['Instructor', 'Instructores'])->count(); // Use correct role name
            $totalCourses = Course::count();
            $totalLectures = Lecture::count();
            
            $totalOrders = Order::count();
            $recentOrders = Order::with(['user', 'items.course'])->latest()->take(5)->get();
            
            $isInstructor = false;
        }

        return view('dashboard', compact(
            'totalUsers', 
            'totalInstructors', 
            'totalCourses', 
            'totalLectures',
            'totalOrders',
            'recentOrders',
            'isInstructor'
        ));
    }
}
