<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimelineEvent;
use App\Models\Article;
use Auth;
class TimelineEventController extends Controller
{
    public function index()
    {
        $timelineEvents = TimelineEvent::where('user_id', Auth::id())->get();
        $colors = ['#1e90ff', '#ff6347', '#32cd32', '#ff69b4', '#ffa500', '#8a2be2'];
        return view('timeline.index', compact('timelineEvents', 'colors'));
    }
    

    public function create()
    {
        return view('timeline.create');
    }

     
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'date_from' => 'required|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'description' => 'required|string',
        ]);
    
        // Get the user's ID from the 'register' table
        $userId = Article::where('email', auth()->user()->email)->value('id');
    
        // Create the TimelineEvent with the user's ID
        TimelineEvent::create([
            'user_id' => $userId,
            'title' => $request->title,
            'company_name' => $request->company_name,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'description' => $request->description,
        ]);
    
        return redirect()->route('profile.show', ['id' => auth()->user()->id])->with('success', 'Timeline event added successfully');



    }
    public function edit($id)
    {
        $event = TimelineEvent::findOrFail($id);
        return view('edit_timeline_event', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'date_from' => 'required|date',
            'date_to' => 'nullable|date',
            'description' => 'required|string',
        ]);

        $event = TimelineEvent::findOrFail($id);
        $event->company_name = $request->input('company_name');
        $event->date_from = $request->input('date_from');
        $event->date_to = $request->input('date_to');
        $event->description = $request->input('description');

        $event->save();

        return redirect()->route('profile.show', Auth::id())->with('success', 'Timeline event updated successfully.');
    }
    public function destroy($id)
    {
        $event = TimelineEvent::findOrFail($id);
        $event->delete();

        return redirect()->route('profile.show', Auth::id())->with('success', 'Timeline event deleted successfully.');
    }
}
