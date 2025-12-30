<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\Instructor;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')
            ->withCount(['courses' => function ($query) {
                $query->where('status', 'active');
            }])
            ->having('courses_count', '>', 0)
            ->take(8)
            ->get();

        $categoryCourses = Course::where('status', 'active')
            ->latest()
            ->take(4)
            ->get();
        $totalCourses = Course::where('status', 'active')->count();

        // Get courses for the courses section (grouped by category or just latest)
        $popularCourses = Course::where('status', 'active')
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        // Get Lectures, Materials, Quizzes for landing segments
        $featuredLectures = Lecture::where('status', 'active')->latest()->take(6)->get();
        $learningMaterials = Material::latest()->take(6)->get();
        $practiceQuizzes = Quiz::latest()->take(6)->get();

        // Get Instructors
        $instructors = Instructor::with('user')->where('status', 'active')->take(4)->get();

        return view('landing', compact(
            'categories',
            'categoryCourses',
            'totalCourses',
            'popularCourses',
            'featuredLectures',
            'learningMaterials',
            'practiceQuizzes',
            'instructors'
        ));
    }

    public function allCategories()
    {
        $categories = Category::where('status', 'active')
            ->withCount(['courses' => function ($query) {
                $query->where('status', 'active');
            }])
            ->get();

        return view('frontend.categories', compact('categories'));
    }
}
