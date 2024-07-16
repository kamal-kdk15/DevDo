<?php

namespace App\Http\Controllers;


use App\Models\Vacancy;
use App\Models\VacancyApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VacancyApplicationController extends Controller
{
    public function apply(Request $request, $vacancy)
    {
        $request->validate([
        'cv' => 'required|mimes:pdf,doc,docx|max:2048',
        'photo' => 'required|image|max:2048',
    ]);
    

        Log::info('CV File Details:', [
            'name' => $request->file('cv')->getClientOriginalName(),
            'size' => $request->file('cv')->getSize(),
            'mime_type' => $request->file('cv')->getMimeType(),
        ]);

        Log::info('Photo File Details:', [
            'name' => $request->file('photo')->getClientOriginalName(),
            'size' => $request->file('photo')->getSize(),
            'mime_type' => $request->file('photo')->getMimeType(),
        ]);

        $cvPath = $request->file('cv')->store('uploads/cvs', 'public');
        $photoPath = $request->file('photo')->store('uploads/photos', 'public');

        $application = new VacancyApplication();
        $application->user_id = auth()->id();
        $application->vacancy_id = $vacancy;
        $application->cv = $cvPath;
        $application->photo = $photoPath;
        $application->save();

        return redirect()->back()->with('success', 'Application submitted successfully.');
    }
   public function applications()
    {
        $applications = VacancyApplication::where('user_id', Auth::id())->with('vacancy')->get();

        return view('applications', compact('applications'));
    }

    public function showApplications(Vacancy $vacancy)
    {
        $applications = VacancyApplication::where('vacancy_id', $vacancy->id)->with('user')->get();

        return view('vacancies.applications', compact('vacancy', 'applications'));
    }

    public function updateStatus(Request $request, VacancyApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $application->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }

    
}
