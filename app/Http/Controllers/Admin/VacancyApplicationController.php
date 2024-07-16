<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VacancyApplication;
use App\Models\Vacancy;

class VacancyApplicationController extends Controller
{
    public function index()
    {
        $applications = VacancyApplication::with('vacancy')->get();
        return view('vendor.adminlte.vacancyapplications.index', compact('applications'));
    }

    public function show(VacancyApplication $application)
    {
        $vacancy = $application->vacancy;
        return view('vendor.adminlte.vacancyapplications.show', compact('application', 'vacancy'));
    }

    public function updateStatus(Request $request, VacancyApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $application->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.applications.index')->with('success', 'Application status updated successfully.');
    }
    public function destroy(VacancyApplication $application)
    {
        $application->delete();
        return redirect()->route('admin.applications.index')->with('success', 'Vacancy application deleted successfully.');
    }
}
