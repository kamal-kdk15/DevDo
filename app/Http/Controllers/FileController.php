<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
class FileController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'workspace_id' => 'required|exists:workspaces,id',
            'file_path' => 'required',
        ]);

        $file = File::create($validated);

        return redirect()->route('workspaces.show', $validated['workspace_id'])->with('success', 'File uploaded successfully.');
    }

    public function destroy($id)
    {
  
        $file = File::findOrFail($id);
        $workspaceId = $file->workspace_id;
        $file->delete();

        return redirect()->route('workspaces.show', $workspaceId)->with('success', 'File deleted successfully.');
    }
}
