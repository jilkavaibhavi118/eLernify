<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class InstructorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Instructor::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('status', function ($row) {
                    $badgeClass = $row->status === 'active' ? 'bg-success' : 'bg-secondary';
                    return '<span class="badge '.$badgeClass.'">'.ucfirst($row->status).'</span>';
                })

                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="'.asset('storage/'.$row->image).'"
                                style="width:50px;height:50px;object-fit:cover;border-radius:4px;">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })

                ->addColumn('action', function ($row) {
                    $editUrl   = route('backend.instructors.edit', $row->id);
                    $deleteUrl = route('backend.instructors.destroy', $row->id);

                    $btn  = '<div class="d-flex gap-2">';
                    $btn .= '<a href="'.$editUrl.'" class="btn btn-warning btn-sm d-flex gap-1">';
                    $btn .= '<svg class="icon icon-sm"><use xlink:href="'.asset('vendors/@coreui/icons/svg/free.svg').'#cil-pencil"></use></svg>Edit</a>';

                    $btn .= '<a href="javascript:void(0)" data-url="'.$deleteUrl.'"
                                class="btn btn-danger btn-sm d-flex gap-1 delete-btn">';
                    $btn .= '<svg class="icon icon-sm"><use xlink:href="'.asset('vendors/@coreui/icons/svg/free.svg').'#cil-trash"></use></svg>Delete</a>';

                    $btn .= '</div>';
                    return $btn;
                })

                ->rawColumns(['status','image','action'])
                ->make(true);
        }

        return view('backend.instructors.index');
    }

    public function create()
    {
        return view('backend.instructors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:instructors',
            'phone'  => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image'  => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('instructors', 'public');
        }

        Instructor::create($data);

        return response()->json([
            'success' => 'Instructor created successfully',
            'url' => route('backend.instructors.index')
        ]);
    }

    public function edit($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('backend.instructors.edit', compact('instructor'));
    }

    public function update(Request $request, $id)
    {
        $instructor = Instructor::findOrFail($id);

        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:instructors,email,'.$id,
            'phone'  => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image'  => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($instructor->image && Storage::exists('public/'.$instructor->image)) {
                Storage::delete('public/'.$instructor->image);
            }
            $data['image'] = $request->file('image')->store('instructors', 'public');
        } else {
            unset($data['image']);
        }

        $instructor->update($data);

        return response()->json([
            'success' => 'Instructor updated successfully',
            'url' => route('backend.instructors.index')
        ]);
    }

    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);

        if ($instructor->image && Storage::exists('public/'.$instructor->image)) {
            Storage::delete('public/'.$instructor->image);
        }

        $instructor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Instructor deleted successfully'
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('q', '');
        $page = $request->get('page', 1);
        $perPage = 10;

        $query = Instructor::where('status', 'active')
            ->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });

        $total = $query->count();
        $instructors = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get(['id', 'name', 'email']);

        $results = $instructors->map(function($instructor) {
            return [
                'id' => $instructor->id,
                'text' => $instructor->name . ' (' . $instructor->email . ')'
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }
}
