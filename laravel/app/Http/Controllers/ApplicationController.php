<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\CitizenPension;
use App\Models\CitizenApplication;

class ApplicationController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isOperator()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $applications = CitizenPension::with(['citizen', 'pensionScheme'])
                        ->where('pension_status', 'Pending')
                        ->latest()
                        ->get();

        return view('admin.applications.index', compact('applications'));
    }

    public function show(CitizenPension $application): View|RedirectResponse
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isOperator()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        // Fetch the detailed comprehensive application
        $detailedApplication = CitizenApplication::where('citizen_id', $application->citizen_id)
            ->where('pension_scheme_id', $application->pension_scheme_id)
            ->first();

        // If for some reason they don't have a detailed application, just show the basic one
        return view('admin.applications.show', compact('application', 'detailedApplication'));
    }

    public function update(Request $request, CitizenPension $application): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isOperator()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Active,Rejected',
            'notes' => 'nullable|string'
        ]);

        $application->update([
            'pension_status' => $validated['status'],
            'notes' => $validated['notes'] ?? $application->notes,
        ]);

        // If approved, ensure citizen status is active
        if ($validated['status'] === 'Active') {
            $application->citizen->update(['pension_status' => 'Active']);
        }

        // Also update the detailed CitizenApplication if it exists
        $detailedApplication = CitizenApplication::where('citizen_id', $application->citizen_id)
            ->where('pension_scheme_id', $application->pension_scheme_id)
            ->where('status', 'Pending')
            ->first();

        if ($detailedApplication) {
            $detailedApplication->update([
                'status' => $validated['status'] === 'Active' ? 'Approved' : 'Rejected'
            ]);
        }

        return redirect()->route('applications.index')->with('success', "Application status updated to {$validated['status']}.");
    }
}
