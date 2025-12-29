<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class InstructorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Instructor::with('user')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_email', function ($row) {
                    return $row->user ? $row->user->email : 'Not Linked';
                })
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
                    return view('layouts.includes.list-actions', [
                        'module' => 'instructors',
                        'routePrefix' => 'backend.instructors',
                        'data' => $row
                    ])->render();
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
            'user_id' => 'required|exists:users,id|unique:instructors,user_id',
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:instructors',
            'phone'   => 'nullable|string',
            'bio'     => 'nullable|string',
            'status'  => 'required|in:active,inactive',
            'image'   => 'nullable|image|max:2048',
            'designation' => 'nullable|string|max:255',
            'specialty'   => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'website_url' => 'nullable|url',
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
        $instructor = Instructor::with('user')->findOrFail($id);
        return view('backend.instructors.edit', compact('instructor'));
    }

    public function update(Request $request, $id)
    {
        $instructor = Instructor::findOrFail($id);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id|unique:instructors,user_id,'.$id,
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:instructors,email,'.$id,
            'phone'   => 'nullable|string',
            'bio'     => 'nullable|string',
            'status'  => 'required|in:active,inactive',
            'image'   => 'nullable|image|max:2048',
            'designation' => 'nullable|string|max:255',
            'specialty'   => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'website_url' => 'nullable|url',
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
