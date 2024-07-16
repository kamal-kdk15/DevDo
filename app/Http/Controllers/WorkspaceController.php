<?php

namespace App\Http\Controllers;
use App\Models\Message;
use App\Events\MessageSent;

use Illuminate\Http\Request;
use App\Models\Workspace;
use App\Models\Idea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
class WorkspaceController extends Controller
{
    public function joinWorkspace(Request $request)
    {
        $request->validate([
            'idea_id' => 'required|exists:ideas,id',
        ]);

        $idea = Idea::findOrFail($request->idea_id);

        
        if ($idea->workspace && Auth::id() !== $idea->user_id) {
          
            $idea->workspace->users()->syncWithoutDetaching([Auth::id()]);

            return response()->json(['message' => 'Joined workspace successfully.']);
        } else {
            return response()->json(['message' => 'Cannot join workspace.']);
        }
    }
    public function show($id)
    {
        $workspace = Workspace::with('messages.register')->findOrFail($id); // Eager load messages and their associated user from register table
    
        $files = $workspace->files;
    
        return view('workspaces.show', compact('workspace', 'files'));
    }
    
    public function uploadFile(Request $request, $workspaceId)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf,doc,docx,txt|max:2048',
        ]);
    
        $workspace = Workspace::findOrFail($workspaceId);
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName(); 
            $filePath = $file->storeAs('uploads', $fileName, 'public');
    
            File::create([
                'workspace_id' => $workspace->id,
                'original_name' => $fileName,
                'file_path' => $filePath,
            ]);
    
            return redirect()->back()->with('success', 'File uploaded successfully.');
        }
    
        return redirect()->back()->with('error', 'File upload failed.');
    }
    
    public function downloadFile($workspaceId, $fileId)
    {
        $file = File::findOrFail($fileId);
    
    
        $filePath = storage_path('app/public/' . $file->file_path);
    

        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $file->original_name);
    }
    

    public function deleteFile($workspaceId, $fileId)
    {
        $file = File::findOrFail($fileId);

        \Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->route('workspaces.show', $workspaceId)->with('success', 'File deleted successfully.');
    }
    public function sendMessage(Request $request, $workspaceId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'user_id' => auth()->id(),
            'workspace_id' => $workspaceId,
            'content' => $request->input('content'),
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return redirect()->back()->with('success', 'Message sent successfully.');
    }
}
