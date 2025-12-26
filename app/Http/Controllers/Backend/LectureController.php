<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLectureRequest;
use App\Models\Lecture;
use App\Models\Course;
use App\Notifications\LiveClassNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LectureController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Lecture::with('course')->latest();

            // Filter by instructor if not admin
            if (!auth()->user()->hasRole('Admin')) {
                $instructorId = auth()->user()->instructor ? auth()->user()->instructor->id : 0;
                $query->whereHas('course', function($q) use ($instructorId) {
                    $q->where('instructor_id', $instructorId);
                });
            }

            $data = $query->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $badgeClass = $row->status === 'active' ? 'bg-success' : 'bg-secondary';
                    return '<span class="badge '.$badgeClass.'">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('live_class', function($row){
                    if ($row->live_class_available) {
                        $date = \Carbon\Carbon::parse($row->live_date)->format('M d, Y');
                        $time = \Carbon\Carbon::parse($row->live_time)->format('h:i A');
                        return '<span class="badge bg-success">Live: ' . $date . ' @ ' . $time . '</span>';
                    }
                    return '<span class="badge bg-secondary">Disabled</span>';
                })
                ->addColumn('price', function($row){
                    if ($row->is_free) {
                        return '<span class="badge bg-success">Free</span>';
                    }
                    return '₹ ' . number_format($row->price, 2);
                })
                ->addColumn('action', function($row){
                    $editUrl = route('backend.lectures.edit', $row->id);
                    $deleteUrl = route('backend.lectures.destroy', $row->id);

                    $btn = '<div class="d-flex gap-2">';

                    // Edit Button
                    $btn .= '<a href="' . $editUrl . '" class="btn btn-warning btn-sm d-flex align-items-center gap-1" title="Edit">';
                    $btn .= '<svg class="icon icon-sm"><use xlink:href="' . asset('vendors/@coreui/icons/svg/free.svg') . '#cil-pencil"></use></svg>';
                    $btn .= '<span>Edit</span></a>';

                    // Delete Button
                    $btn .= '<a href="javascript:void(0)" data-url="'.$deleteUrl.'" class="btn btn-danger btn-sm d-flex align-items-center gap-1 delete-btn" title="Delete">';
                    $btn .= '<svg class="icon icon-sm"><use xlink:href="' . asset('vendors/@coreui/icons/svg/free.svg') . '#cil-trash"></use></svg>';
                    $btn .= '<span>Delete</span></a>';

                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['status', 'live_class', 'price', 'action'])
                ->make(true);
        }
        return view('backend.lectures.index');
    }

    public function create()
    {
        $query = Course::where('status', 'active');

        // Filter courses by instructor if not admin
        if (!auth()->user()->hasRole('Admin')) {
            $instructorId = auth()->user()->instructor ? auth()->user()->instructor->id : 0;
            $query->where('instructor_id', $instructorId);
        }

        $courses = $query->orderBy('title')->get(['id', 'title']);

        return view('backend.lectures.create', compact('courses'));
    }

    public function store(StoreLectureRequest $request)
    {
        $course = Course::findOrFail($request->course_id);
        
        // Security check for instructors
        if (auth()->user()->hasRole('Instructores') && $course->instructor_id != auth()->user()->instructor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $lecture = Lecture::create($request->validated());

        if ($lecture->live_class_available) {
            $students = \App\Models\User::whereHas('enrollments', function($q) use ($lecture) {
                $q->where('course_id', $lecture->course_id)->whereIn('status', ['active', 'completed']);
            })->get();

            if ($students->count() > 0) {
                Notification::send($students, new LiveClassNotification($lecture));
            }
        }

        return response()->json([
            'success' => 'Lecture created successfully',
            'url' => route('backend.lectures.index')
        ]);
    }

    public function edit($id)
    {
        $lecture = Lecture::findOrFail($id);

        // Security check for instructors
        if (auth()->user()->hasRole('Instructores')) {
            if ($lecture->course->instructor_id != auth()->user()->instructor->id) {
                abort(403, 'Unauthorized action.');
            }
        }

        $query = Course::where('status', 'active');
        if (!auth()->user()->hasRole('Admin')) {
            $instructorId = auth()->user()->instructor ? auth()->user()->instructor->id : 0;
            $query->where('instructor_id', $instructorId);
        }

        $courses = $query->orderBy('title')->get(['id', 'title']);

        return view('backend.lectures.edit', compact('lecture', 'courses'));
    }

    public function update(StoreLectureRequest $request, $id)
    {
        $lecture = Lecture::findOrFail($id);

        // Security check for instructors
        if (auth()->user()->hasRole('Instructores')) {
            if ($lecture->course->instructor_id != auth()->user()->instructor->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $lecture->update($request->validated());

        if ($lecture->live_class_available) {
            $students = \App\Models\User::whereHas('enrollments', function($q) use ($lecture) {
                $q->where('course_id', $lecture->course_id)->whereIn('status', ['active', 'completed']);
            })->get();

            if ($students->count() > 0) {
                Notification::send($students, new LiveClassNotification($lecture));
            }
        }

        return response()->json([
            'success' => 'Lecture updated successfully',
            'url' => route('backend.lectures.index')
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->get('q');
        $page = $request->get('page', 1);
        $perPage = 10;

        $query = Lecture::query();

        if ($term) {
            $query->where('title', 'LIKE', "%{$term}%")
                  ->orWhere('description', 'LIKE', "%{$term}%");
        }

        $total = $query->count();
        $lectures = $query->skip(($page - 1) * $perPage)
                          ->take($perPage)
                          ->get(['id', 'title']);

        $results = $lectures->map(function($lecture) {
            return [
                'id' => $lecture->id,
                'text' => $lecture->title
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }

    public function destroy($id)
    {
        $lecture = Lecture::findOrFail($id);

        // Security check for instructors
        if (auth()->user()->hasRole('Instructores') && $lecture->course->instructor_id != auth()->user()->instructor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $lecture->delete();
        return response()->json([
            'success' => true,
            'message' => 'Lecture deleted successfully'
        ]);
    }
}
