<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DevPost;
use Illuminate\Support\Facades\Auth;
use App\Models\PostImage;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class DevPostController extends Controller
{
    public function edit($id)
    {
        $post = DevPost::with('postImages')->findOrFail($id);
        return view('edit_dev_post', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'images.*' => 'nullable|image|max:2048',
            'project_link' => 'nullable|url',
        ]);

        $devPost = DevPost::findOrFail($id);
        $devPost->title = $request->input('title');
        $devPost->subtitle = $request->input('subtitle');
        $devPost->description = $request->input('description');
        $devPost->project_link = $request->input('project_link');

        if ($request->has('remove_images')) {
            foreach ($request->input('remove_images') as $imageId) {
                $image = PostImage::find($imageId);
                if ($image) {
                    File::delete(public_path($image->image_path));
                    $image->delete();
                }
            }
        }
     
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = $image->getClientOriginalName();
                $image->move(public_path('post_images'), $filename);
                PostImage::create([
                    'dev_post_id' => $devPost->id,
                    'image_path' => 'post_images/' . $filename,
                ]);
            }
        }
        
        $devPost->save();

        return redirect()->route('profile.show', Auth::id())->with('success', 'Dev post updated successfully.');
    }
    public function destroy($id)
    {
        $devPost = DevPost::findOrFail($id);
        $devPost->delete();

        return redirect()->route('profile.show', Auth::id())->with('success', 'Dev post deleted successfully.');
    }
    public function like($id)
    {
        $post = DevPost::findOrFail($id);
        $like = $post->likes()->where('user_id', auth()->id())->first();

        if ($like) {
           
            $like->delete();
        } else {
       
            $post->likes()->create([
                'user_id' => auth()->id(),
            ]);
        }

        return back();
    }

    public function comment(Request $request, $postId)
    {
        $post = DevPost::findOrFail($postId);
    
        $post->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);
    
        return response()->json(['success' => true]);
    }
    
    public function share(Request $request, $id)
    {
        $post = DevPost::findOrFail($id);
        $shareEmail = $request->shareEmail;

        $post->shares()->create([
            'user_id' => auth()->id(),
            'shared_with' => $shareEmail,
        ]);

        return back();
    }
  
    public function showProfile($id)
    {
        $user = Article::findOrFail($id);

        
        $devPosts = DevPost::where('user_id', $id)->with('category')->get();

      
        return view('profile.dev_posts', [
            'user' => $user,
            'devPosts' => $devPosts,
        ]);
    }

    public function explore()
    {
        $user = auth()->user();
    
        $followingIds = $user->following()->pluck('followed_id');
    
        $devPosts = DevPost::whereNotIn('user_id', $followingIds)
                        ->where('user_id', '!=', $user->id)
                        ->with(['postImages', 'likes', 'comments'])
                        ->get();
    
        return view('explore', compact('devPosts'));
    }
    
}
