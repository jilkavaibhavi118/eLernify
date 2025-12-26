<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'lecture_id' => 'required|exists:lectures,id',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'lecture_id' => $request->lecture_id,
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment posted successfully!',
                'comment' => $comment->load('user'),
                'is_reply' => !empty($request->parent_id)
            ]);
        }

        return back()->with('success', 'Comment posted successfully!');
    }

    public function react(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $userId = Auth::id();

        $reaction = \App\Models\CommentReaction::where('user_id', $userId)
            ->where('comment_id', $id)
            ->first();

        if ($reaction) {
            $reaction->delete();
            $status = 'removed';
        } else {
            \App\Models\CommentReaction::create([
                'user_id' => $userId,
                'comment_id' => $id,
                'type' => 'like'
            ]);
            $status = 'added';
        }

        return response()->json([
            'success' => true,
            'status' => $status,
            'count' => $comment->reactions()->count()
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }
}
