<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLectureRequest;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LectureController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Lecture::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $badgeClass = $row->status === 'active' ? 'bg-success' : 'bg-secondary';
                    return '<span class="badge '.$badgeClass.'">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('live_class', function($row){
                    return $row->live_class_available ? 
                        '<span class="badge bg-info">Yes</span>' : 
                        '<span class="badge bg-warning">No</span>';
                })
                ->addColumn('price', function($row){
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
                ->rawColumns(['status', 'live_class', 'action'])
                ->make(true);
        }
        return view('backend.lectures.index');
    }

    public function create()
    {
        return view('backend.lectures.create');
    }

    public function store(StoreLectureRequest $request)
    {
        Lecture::create($request->validated());
    
        return response()->json([
            'success' => 'Lecture created successfully',
            'url' => route('backend.lectures.index')
        ]);
    }

    public function edit($id)
    {
        $lecture = Lecture::findOrFail($id);
        return view('backend.lectures.edit', compact('lecture'));
    }

    public function update(StoreLectureRequest $request, $id)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->update($request->validated());
    
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
        Lecture::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Lecture deleted successfully'
        ]);
    }
}
