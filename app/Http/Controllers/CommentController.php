<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Like;
use App\Models\Comment;
class CommentController extends Controller
{
    public function addComment(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

   
public function like($commentId)
{
    $comment = Comment::findOrFail($commentId);
    $userId = auth()->id();

    $existingLike = Like::where('user_id', $userId)
                        ->where('comment_id', $commentId)
                        ->first();

    if ($existingLike) {
     
        return response()->json(['likes_count' => $comment->likes_count]);
    }


    $comment->increment('likes_count');

    Like::create([
        'user_id' => $userId,
        'comment_id' => $commentId,
    ]);

    return response()->json(['likes_count' => $comment->likes_count]);
}

public function unlike($commentId)
{
    $comment = Comment::findOrFail($commentId);
    $userId = auth()->id();

    $existingLike = Like::where('user_id', $userId)
                        ->where('comment_id', $commentId)
                        ->first();

    if (!$existingLike) {
    
        return response()->json(['likes_count' => $comment->likes_count]);
    }

    $comment->decrement('likes_count');


    $existingLike->delete();

    return response()->json(['likes_count' => $comment->likes_count]);
}

}
