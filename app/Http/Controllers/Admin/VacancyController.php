<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Auth;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::all();
        return view('vendor.adminlte.vacancies.index', compact('vacancies'));
    }

    public function create()
    {
        return view('vendor.adminlte.vacancies.create');
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

        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy created successfully.');
    }

    public function show(Vacancy $vacancy)
    {
        
        $vacancy->load('applications.user');
        
        return view('vendor.adminlte.vacancies.show', compact('vacancy'));
    }

    public function edit(Vacancy $vacancy)
    {
        return view('vendor.adminlte.vacancies.edit', compact('vacancy'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'minimum_qualification' => 'required|string|max:255',
        ]);

        $vacancy->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'type' => $request->type,
            'experience' => $request->experience,
            'minimum_qualification' => $request->minimum_qualification,
        ]);

        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy updated successfully.');
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy deleted successfully.');
    }
}
