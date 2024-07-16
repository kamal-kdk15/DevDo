<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DesignPhilosophy;
use Illuminate\Support\Facades\Auth;
class DesignerPhilosophyController extends Controller
{
   
    public function store(Request $request)
    {
        $request->validate([
            'design_philosophy' => 'required|string',
            'adaptability' => 'required|string',
        ]);

        $user = Auth::user();

        $designPhilosophy = new DesignPhilosophy();
        $designPhilosophy->user_id = $user->id;
        $designPhilosophy->design_philosophy = $request->design_philosophy;
        $designPhilosophy->adaptability = $request->adaptability;
        $designPhilosophy->save();

        return redirect()->route('profile.show', $user->id)->with('success', 'Design philosophy added successfully.');
    }
    public function edit($id)
    {
        $designPhilosophy = DesignPhilosophy::findOrFail($id);
        return view('edit_design_philosophy', compact('designPhilosophy'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'design_philosophy' => 'required|string',
            'adaptability' => 'required|string',
        ]);

        $designPhilosophy = DesignPhilosophy::findOrFail($id);
        $designPhilosophy->design_philosophy = $request->design_philosophy;
        $designPhilosophy->adaptability = $request->adaptability;
        $designPhilosophy->save();

        return redirect()->route('profile.show', Auth::id())->with('success', 'Design philosophy updated successfully!');
    }

    public function delete($id)
    {
        $designPhilosophy = DesignPhilosophy::findOrFail($id);
        $designPhilosophy->delete();

        return redirect()->route('profile.show', Auth::id())->with('success', 'Design philosophy deleted successfully!');
    }
}
