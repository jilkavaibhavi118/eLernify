<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Material::with('lecture')->latest()->get();
            return DataTables::of($data)
                ->addColumn('lecture', function($row){
                    return $row->lecture ? $row->lecture->title : 'N/A';
                })
                ->addColumn('pricing', function($row){
                    if ($row->is_free) {
                        return '<span class="badge bg-success">Free</span>';
                    }
                    return '<span class="badge bg-primary">₹'.number_format($row->price, 2).'</span>';
                })
                ->addColumn('file', function($row){
                    $html = '';
                    
                    if (!empty($row->file_path)) {
                        $fileName = basename($row->file_path);
                        $html .= '<a href="'.asset('storage/'.$row->file_path).'" target="_blank" class="btn btn-sm btn-info me-1" title="'.$fileName.'">
                                <i class="fa fa-file-pdf"></i> Doc
                            </a>';
                    }

                    if (!empty($row->video_path)) {
                        $videoName = basename($row->video_path);
                        $html .= '<a href="'.asset('storage/'.$row->video_path).'" target="_blank" class="btn btn-sm btn-success me-1" title="'.$videoName.'">
                                <i class="fa fa-video"></i> Video
                            </a>';
                    }

                    if (!empty($row->content_url)) {
                        $html .= '<a href="'.$row->content_url.'" target="_blank" class="btn btn-sm btn-primary me-1">
                                <i class="fa fa-link"></i> Link
                            </a>';
                    }

                    return $html ?: 'N/A';
                })
                ->addColumn('action', function($row){
                    $editUrl = route('backend.materials.edit', $row->id);
                    $deleteUrl = route('backend.materials.destroy', $row->id);
                    
                    $btn = '<div class="d-flex gap-2">';
                    $btn .= '<a href="' . $editUrl . '" class="btn btn-warning btn-sm">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" data-url="'.$deleteUrl.'" class="btn btn-danger btn-sm delete-btn">Delete</a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['pricing', 'file', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backend.materials.index');
    }

    public function create()
    {
        return view('backend.materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'lecture_id' => 'required|exists:lectures,id',
            'file' => 'nullable|file|max:10240', // 10MB Doc
            'video' => 'nullable|file|max:102400', // 100MB Video
            'content_url' => 'nullable|url',
            'is_free' => 'nullable|boolean',
            'price' => 'required_if:is_free,0|nullable|numeric|min:0',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('materials', 'public');
        }

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos', 'public');
        }

        Material::create([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'file_path' => $filePath,
            'video_path' => $videoPath,
            'lecture_id' => $request->lecture_id,
            'content_url' => $request->content_url,
            'is_free' => $request->has('is_free'),
            'price' => $request->price,
        ]);

        return response()->json([
            'success' => 'Material created successfully',
            'url' => route('backend.materials.index')
        ]);
    }

    public function edit($id)
    {
        $material = Material::with('lecture')->findOrFail($id);
        return view('backend.materials.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'lecture_id' => 'required|exists:lectures,id',
            'file' => 'nullable|file|max:10240',
            'video' => 'nullable|file|max:102400',
            'content_url' => 'nullable|url',
            'is_free' => 'nullable|boolean',
            'price' => 'required_if:is_free,0|nullable|numeric|min:0',
        ]);

        $data = [
            'title' => $request->title,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'lecture_id' => $request->lecture_id,
            'content_url' => $request->content_url,
            'is_free' => $request->has('is_free'),
            'price' => $request->price,
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($material->file_path && Storage::exists('public/' . $material->file_path)) {
                Storage::delete('public/' . $material->file_path);
            }
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }

        if ($request->hasFile('video')) {
            // Delete old video
            if ($material->video_path && Storage::exists('public/' . $material->video_path)) {
                Storage::delete('public/' . $material->video_path);
            }
            $data['video_path'] = $request->file('video')->store('videos', 'public');
        }

        $material->update($data);

        return response()->json([
            'success' => 'Material updated successfully',
            'url' => route('backend.materials.index')
        ]);
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        
        // Delete file
        if (Storage::exists('public/' . $material->file_path)) {
            Storage::delete('public/' . $material->file_path);
        }
        
        $material->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Material deleted successfully'
        ]);
    }
}
