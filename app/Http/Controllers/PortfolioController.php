<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PortfolioPost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class PortfolioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'work_experience' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
        ]);

        $post = new PortfolioPost();
        $post->user_id = auth()->id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->work_experience = $request->work_experience;
        $post->link = $request->link;

        if ($request->hasFile('image')) {
            $filename = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('portfolio_images'), $filename);
            $post->image = 'portfolio_images/' . $filename;
        }

        $post->save();

        return redirect()->back()->with('success', 'Portfolio post created successfully!');
    }

    public function edit($id)
    {
        $post = PortfolioPost::findOrFail($id);
        return view('portfolio.edit', compact('post'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'work_experience' => 'nullable|string|max:255',
        'image' => 'nullable|image|max:2048',
        'link' => 'nullable|url',
    ]);

    $post = PortfolioPost::findOrFail($id);
    $post->title = $request->title;
    $post->description = $request->description;
    $post->work_experience = $request->work_experience;
    $post->link = $request->link;

    if ($request->hasFile('image')) {
   
        if ($post->image && File::exists(public_path('portfolio_images/' . $post->image))) {
            File::delete(public_path('portfolio_images/' . $post->image));
        }

        $filename = $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('portfolio_images'), $filename);
        $post->image = $filename;
    }

    $post->save();

    return redirect()->route('profile.show', ['id' => $post->user_id])->with('success', 'Portfolio updated successfully!');
}
}
