<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\Idea;
use App\Models\Article;
class WorkspaceController extends Controller
{
    public function index()
    {
        $workspaces = Workspace::with('idea', 'user')->orderByDesc('created_at')->get();
        return view('vendor.adminlte.workspaces.index', compact('workspaces'));
    }
    public function show(Workspace $workspace)
    {
        $workspace->load('idea', 'user');
        return view('vendor.adminlte.workspaces.show', compact('workspace'));
    }
    public function edit(Workspace $workspace)
    {
        $ideas = Idea::all();
        $users = Article::all();

        return view('vendor.adminlte.workspaces.edit', compact('workspace', 'ideas', 'users'));
    }

    public function update(Request $request, Workspace $workspace)
    {
        $request->validate([
            'idea_id' => 'required|exists:ideas,id',
            'user_id' => 'required|exists:articles,id',
        ]);

        $workspace->update([
            'idea_id' => $request->input('idea_id'),
            'user_id' => $request->input('user_id'),
        ]);

        return redirect()->route('admin.workspaces.index')->with('success', 'Workspace updated successfully.');
    }
}
