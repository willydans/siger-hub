<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content'    => 'required|string',
            'article_id' => 'required|exists:articles,id',
            'parent_id'  => 'nullable|exists:comments,id'
        ]);

        $comment = Comment::create([
            'user_id'    => auth()->id(),
            'article_id' => $request->article_id,
            'parent_id'  => $request->parent_id,
            'content'    => $request->content,
            'status'     => 'published',
            'likes'      => 0
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }

    // ✅ FITUR LIKE TOGGLE
    public function like($id)
    {
        $comment = Comment::findOrFail($id);
        $user = auth()->user();

        $existingLike = CommentLike::where('comment_id', $comment->id)
                                    ->where('user_id', $user->id)
                                    ->first();

        if ($existingLike) {
            $existingLike->delete();
            $comment->decrement('likes');
            $liked = false;
        } else {
            CommentLike::create([
                'comment_id' => $comment->id,
                'user_id'    => $user->id
            ]);
            $comment->increment('likes');
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'likes'   => $comment->fresh()->likes,
            'liked'   => $liked
        ]);
    }

    // ✅ FITUR EDIT (Hanya Pemilik)
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses.'], 403);
        }

        $request->validate(['content' => 'required|string']);
        $comment->update(['content' => $request->content]);

        return response()->json([
            'success' => true,
            'content' => $comment->content
        ]);
    }

    // ✅ FITUR HAPUS (Hanya Pemilik)
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses.'], 403);
        }

        $comment->delete();

        return response()->json(['success' => true]);
    }
}