<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Auth;
class LikeController extends Controller
{
    public function likePost(Request $request, $postId)
    {
        $like = Like::where('user_id', Auth::id())->where('post_id', $postId)->first();

        if ($like) {
            $like->delete();
            return back()->with('success', 'Post unliked successfully.');
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $postId,
            ]);
            return back()->with('success', 'Post liked successfully.');
        }
    }
}
