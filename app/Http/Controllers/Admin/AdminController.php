<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CollaborationRequest;
class AdminController extends Controller
{
    public function collaborationRequests()
    {
        $requests = CollaborationRequest::with('user', 'idea')->where('status', '!=', 'pending')->get();
        return view('vendor.adminlte.collaboration-requests.index', compact('requests'));
    }

    public function respondToRequest($id, $status)
    {
        $request = CollaborationRequest::findOrFail($id);
        $request->status = $status;
        $request->save();

        return redirect()->route('admin.collaboration-requests.index')->with('success', 'Request updated successfully');
    }
}
