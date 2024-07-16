<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VacancyApplication;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::all();
        return view('vacancies.index', compact('vacancies'));
    }

    public function create()
    {
        return view('vacancies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'minimum_qualification' => 'required|string|max:255',
        ]);

        Vacancy::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'type' => $request->type,
            'experience' => $request->experience,
            'minimum_qualification' => $request->minimum_qualification,
        ]);

        return redirect()->route('vacancies.index')->with('success', 'Vacancy created successfully.');
    }

    public function show($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        return view('vacancies.show', compact('vacancy'));
    }

    public function edit($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        return view('vacancies.edit', compact('vacancy'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'minimum_qualification' => 'required|string|max:255',
        ]);

        $vacancy = Vacancy::findOrFail($id);
        $vacancy->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'type' => $request->type,
            'experience' => $request->experience,
            'minimum_qualification' => $request->minimum_qualification,
        ]);

        return redirect()->route('vacancies.index')->with('success', 'Vacancy updated successfully.');
    }

    public function destroy($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->delete();

        return redirect()->route('vacancies.index')->with('success', 'Vacancy deleted successfully.');
    }
    public function apply(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to login to apply.');
        }
    
        $userId = Auth::id();
        \Log::info('User ID: ' . $userId);
        \Log::info('Vacancy ID: ' . $id);
    
        $existingApplication = VacancyApplication::where('user_id', $userId)->where('vacancy_id', $id)->first();
        if ($existingApplication) {
            \Log::info('Existing Application Found');
            return redirect()->back()->with('error', 'You have already applied for this vacancy.');
        }
    
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
            'photo' => 'required|image|max:2048',
        ]);
    
        $cvPath = $request->file('cv')->store('cv', 'public');
        $photoPath = $request->file('photo')->store('photos', 'public');
    
        \Log::info('CV Path: ' . $cvPath);
        \Log::info('Photo Path: ' . $photoPath);
    
        $application = VacancyApplication::create([
            'user_id' => $userId,
            'vacancy_id' => $id,
            'cv' => $cvPath,
            'photo' => $photoPath,
            'status' => 'pending',
        ]);
    
        \Log::info('Application Created: ' . $application->id);
    
        return redirect()->back()->with('success', 'Application submitted successfully.');
    }
    
}
