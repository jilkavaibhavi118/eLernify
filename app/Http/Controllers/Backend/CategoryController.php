<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::withCount('courses')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $badgeClass = $row->status === 'active' ? 'bg-success' : 'bg-secondary';
                    return '<span class="badge '.$badgeClass.'">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('image', function($row){
                    if ($row->image) {
                        return '<img src="'.asset('storage/'.$row->image).'" alt="'.$row->name.'" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('courses_count', function($row){
                    return '<span class="badge bg-info">'.$row->courses_count.'</span>';
                })
                ->addColumn('action', function($row){
                    $editUrl = route('backend.categories.edit', $row->id);
                    $deleteUrl = route('backend.categories.destroy', $row->id);

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
                ->rawColumns(['status', 'image', 'courses_count', 'action'])
                ->make(true);
        }
        return view('backend.categories.index');
    }

    public function create()
    {
        return view('backend.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return response()->json([
            'success' => 'Category created successfully',
            'url' => route('backend.categories.index')
        ]);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.categories.edit', compact('category'));
    }

    public function update(StoreCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && Storage::exists('public/' . $category->image)) {
                Storage::delete('public/' . $category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        } else {
            // Keep existing image if no new image is uploaded
            unset($data['image']);
        }

        $category->update($data);

        return response()->json([
            'success' => 'Category updated successfully',
            'url' => route('backend.categories.index')
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete image
        if ($category->image && Storage::exists('public/' . $category->image)) {
            Storage::delete('public/' . $category->image);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->get('q');
        $page = $request->get('page', 1);
        $perPage = 10;

        $query = Category::where('status', 'active');

        if ($term) {
            $query->where('name', 'LIKE', "%{$term}%");
        }

        $total = $query->count();
        $categories = $query->skip(($page - 1) * $perPage)
                          ->take($perPage)
                          ->get(['id', 'name']);

        $results = $categories->map(function($category) {
            return [
                'id' => $category->id,
                'text' => $category->name
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
