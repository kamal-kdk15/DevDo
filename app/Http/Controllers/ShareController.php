<?php

namespace App\Http\Controllers;


use App\Models\Share;
use Illuminate\Http\Request;
use Auth;

class ShareController extends Controller
{
    public function sharePost(Request $request, $postId)
    {
        Share::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
        ]);

        return back()->with('success', 'Post shared successfully.');
    }
}
