<?php
namespace App\Http\Controllers;

use App\Models\DevPost;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $devPosts = collect();
        $userRecommendations = collect();

        $user = Auth::user();
        $followingIds = $user->following->pluck('id');

        if ($followingIds->isEmpty()) {
            $userRecommendations = Article::where('id', '!=', $user->id)
                                          ->where('role', '!=', 'admin')
                                          ->with(['profile', 'portfolioPosts'])
                                          ->inRandomOrder()
                                          ->limit(10)
                                          ->get();
        } else {
            $devPosts = DevPost::with(['postImages', 'comments'])
                               ->whereIn('user_id', $followingIds)
                               ->get();

            $userRecommendations = Article::where('id', '!=', $user->id)
                                          ->where('role', '!=', 'admin')
                                          ->whereNotIn('id', $followingIds)
                                          ->with(['profile', 'portfolioPosts'])
                                          ->limit(10)
                                          ->get();
        }

        return view('landing', [
            'devPosts' => $devPosts,
            'userRecommendations' => $userRecommendations
        ]);
    }
}
