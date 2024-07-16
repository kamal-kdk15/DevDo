<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DesignerPortfolioPost;
use Illuminate\Support\Facades\Storage;

class DesignerPortfolioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
            'design_tools' => 'nullable|string|max:255',
            'design_specialization' => 'nullable|string|max:255',
        ]);

        $post = new DesignerPortfolioPost();
        $post->user_id = auth()->id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->link = $request->link;
        $post->design_tools = $request->design_tools;
        $post->design_specialization = $request->design_specialization;

        if ($request->hasFile('image')) {
            $filename = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('portfolio_images', $filename, 'public');
            $post->image = 'portfolio_images/' . $filename;
        }

        $post->save();

        return redirect()->back()->with('success', 'Designer portfolio post created successfully!');
    }
    public function edit($id)
    {
        $post = DesignerPortfolioPost::findOrFail($id);
        return view('designer_portfolio.edit', compact('post'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
            'design_tools' => 'nullable|string|max:255',
            'design_specialization' => 'nullable|string|max:255',
        ]);
    
        $post = DesignerPortfolioPost::findOrFail($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->design_tools = $request->design_tools;
        $post->design_specialization = $request->design_specialization;
    
        if ($request->hasFile('image')) {
         
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
    
            $filename = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('portfolio_images', $filename, 'public');
            $post->image = 'portfolio_images/' . $filename;
        }
    
        $post->save();
    
        return redirect()->route('profile.show', auth()->id())->with('success', 'Portfolio item updated successfully!');
    }
    
}
