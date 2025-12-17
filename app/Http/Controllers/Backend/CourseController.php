<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Course::with('category')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function($row){
                    return $row->category ? $row->category->name : 'N/A';
                })
                ->addColumn('status', function($row){
                    $badgeClass = $row->status === 'active' ? 'bg-success' : 'bg-secondary';
                    return '<span class="badge '.$badgeClass.'">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('price', function($row){
                    return '₹ ' . number_format($row->price, 2);
                })
                ->addColumn('image', function($row){
                    if ($row->image) {
                        return '<img src="'.asset('storage/'.$row->image).'" alt="'.$row->title.'" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('action', function($row){
                    $editUrl = route('backend.courses.edit', $row->id);
                    $deleteUrl = route('backend.courses.destroy', $row->id);

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
                ->rawColumns(['category', 'status', 'image', 'action'])
                ->make(true);
        }
        return view('backend.courses.index');
    }

    public function create()
    {
        return view('backend.courses.create');
    }

    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        Course::create($data);

        return response()->json([
            'success' => 'Course created successfully',
            'url' => route('backend.courses.index')
        ]);
    }

    public function edit($id)
    {
        $course = Course::with('category')->findOrFail($id);
        return view('backend.courses.edit', compact('course'));
    }

    public function update(StoreCourseRequest $request, $id)
    {
        $course = Course::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($course->image && Storage::exists('public/' . $course->image)) {
                Storage::delete('public/' . $course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        } else {
            // Keep existing image if no new image is uploaded
            unset($data['image']);
        }

        $course->update($data);

        return response()->json([
            'success' => 'Course updated successfully',
            'url' => route('backend.courses.index')
        ]);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Delete image
        if ($course->image && Storage::exists('public/' . $course->image)) {
            Storage::delete('public/' . $course->image);
        }

        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }
}
