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
                ->addIndexColumn()
                ->addColumn('lecture', function($row){
                    return $row->lecture ? $row->lecture->title : 'N/A';
                })
                ->addColumn('file', function($row){
                    $fileName = basename($row->file_path);
                    return '<a href="'.asset('storage/'.$row->file_path).'" target="_blank" class="btn btn-sm btn-info">
                            <i class="fa fa-download"></i> '.$fileName.'
                        </a>';
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
                ->rawColumns(['file', 'action'])
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
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
            'lecture_id' => 'required|exists:lectures,id',
        ]);

        $filePath = $request->file('file')->store('materials', 'public');

        Material::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'lecture_id' => $request->lecture_id,
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
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'lecture_id' => 'required|exists:lectures,id',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'lecture_id' => $request->lecture_id,
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::exists('public/' . $material->file_path)) {
                Storage::delete('public/' . $material->file_path);
            }
            $data['file_path'] = $request->file('file')->store('materials', 'public');
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
