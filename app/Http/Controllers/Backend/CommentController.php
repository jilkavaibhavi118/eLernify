<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Comment::with(['user', 'lecture.course'])->latest();

            // Filter by instructor if not admin
            if (!auth()->user()->hasRole('Admin')) {
                $instructorId = auth()->user()->instructor ? auth()->user()->instructor->id : 0;
                $query->whereHas('lecture.course', function($q) use ($instructorId) {
                    $q->where('instructor_id', $instructorId);
                });
            }

            $data = $query->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function($row){
                    return $row->user->name;
                })
                ->addColumn('course', function($row){
                    return $row->lecture && $row->lecture->course ? $row->lecture->course->title : 'N/A';
                })
                ->addColumn('lecture', function($row){
                    return $row->lecture ? $row->lecture->title : 'N/A';
                })
                ->addColumn('content', function($row){
                    return \Illuminate\Support\Str::limit($row->content, 50);
                })
                ->addColumn('type', function($row){
                    return $row->parent_id ? '<span class="badge bg-info">Reply</span>' : '<span class="badge bg-primary">Comment</span>';
                })
                ->addColumn('date', function($row){
                    return $row->created_at->format('d M Y, h:i A');
                })
                ->addColumn('action', function($row){
                    $viewUrl = route('user.lecture.view', ['lectureId' => $row->lecture_id]);
                    
                    $extra = '';
                    // Reply Button (Triggers Modal)
                    if (!$row->parent_id) {
                        $extra .= '<a href="javascript:void(0)" class="btn btn-primary btn-sm d-flex align-items-center gap-1 reply-btn" data-id="'.$row->id.'" data-content="'.e($row->content).'" title="Reply">
                            <svg class="icon icon-sm"><use xlink:href="' . asset('vendors/@coreui/icons/svg/free.svg') . '#cil-reply"></use></svg>
                            <span>Reply</span></a>';
                    }

                    // View Button
                    $extra .= '<a href="' . $viewUrl . '" target="_blank" class="btn btn-info btn-sm d-flex align-items-center gap-1" title="View in Lecture">
                        <svg class="icon icon-sm"><use xlink:href="' . asset('vendors/@coreui/icons/svg/free.svg') . '#cil-external-link"></use></svg>
                        <span>View</span></a>';

                    return view('layouts.includes.list-actions', [
                        'module' => 'comments',
                        'routePrefix' => 'backend.comments',
                        'data' => $row,
                        'extra' => $extra
                    ])->render();
                })
                ->rawColumns(['type', 'action'])
                ->make(true);
        }
        return view('backend.comments.index');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Security check for instructors
        if (!auth()->user()->hasRole('Admin')) {
            $instructorId = auth()->user()->instructor ? auth()->user()->instructor->id : 0;
            if ($comment->lecture->course->instructor_id != $instructorId) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }
    public function reply(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $parentComment = Comment::findOrFail($id);

        // Security check for instructors
        if (!auth()->user()->hasRole('Admin')) {
            $instructorId = auth()->user()->instructor ? auth()->user()->instructor->id : 0;
            if ($parentComment->lecture->course->instructor_id != $instructorId) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $reply = Comment::create([
            'user_id' => auth()->id(),
            'lecture_id' => $parentComment->lecture_id,
            'parent_id' => $parentComment->id,
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reply sent successfully!',
            'reply' => $reply
        ]);
    }
}
