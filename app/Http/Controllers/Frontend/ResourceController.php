<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\Material;
use App\Models\Quiz;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function viewLecture($id)
    {
        $lecture = Lecture::with(['course', 'materials', 'quizzes'])->findOrFail($id);
        return view('frontend.resources.lecture', compact('lecture'));
    }

    public function viewMaterial($id)
    {
        $material = Material::findOrFail($id);
        
        // Handle different types of material
        if ($material->file_path) {
            return response()->file(storage_path('app/public/' . $material->file_path));
        } elseif ($material->video_path) {
            return view('frontend.resources.video', compact('material'));
        } elseif ($material->content_url) {
            return redirect()->away($material->content_url);
        }

        return redirect()->back()->with('error', 'Material content not found.');
    }

    public function viewQuiz($id)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($id);
        return view('frontend.resources.quiz', compact('quiz'));
    }

    public function indexLectures(Request $request)
    {
        $query = Lecture::where('status', 'active')->with('course');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $lectures = $query->latest()->paginate(12);
        return view('frontend.resources.lectures', compact('lectures'));
    }

    public function indexMaterials(Request $request)
    {
        $query = Material::with('lecture');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $materials = $query->latest()->paginate(12);
        return view('frontend.resources.materials', compact('materials'));
    }

    public function indexQuizzes(Request $request)
    {
        $query = Quiz::with('lecture');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $quizzes = $query->latest()->paginate(12);
        return view('frontend.resources.quizzes', compact('quizzes'));
    }
}
