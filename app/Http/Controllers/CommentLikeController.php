<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\CommentLike;
class CommentLikeController extends Controller
{
    public function toggleLikeComment(Request $request)
    {
      
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        $userId = auth()->id();
        
       
        $commentId = $request->input('comment_id');

        $like = CommentLike::where('comment_id', $commentId)
                           ->where('user_id', $userId)
                           ->first();

        $comment = Comment::find($commentId);

        if ($like) {
      
            $like->delete();
            $comment->decrement('likes_count');
            return response()->json(['success' => true, 'liked' => false, 'likes_count' => $comment->likes_count]);
        } else {
       
            CommentLike::create([
                'comment_id' => $commentId,
                'user_id' => $userId
            ]);
            $comment->increment('likes_count');
            return response()->json(['success' => true, 'liked' => true, 'likes_count' => $comment->likes_count]);
        }
    }
}
