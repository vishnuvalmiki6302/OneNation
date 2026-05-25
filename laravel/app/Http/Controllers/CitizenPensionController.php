<?php

namespace App\Http\Controllers;

use App\Models\CitizenPension;
use App\Models\Citizen;
use App\Models\PensionScheme;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CitizenPensionController extends Controller
{
    public function index(): View
    {
        $assignments = CitizenPension::with(['citizen', 'pensionScheme'])
            ->latest()
            ->paginate(10)
            ->appends(request()->query());

        return view('citizen_pensions.index', compact('assignments'));
    }

    public function create(): View
    {
        $citizens = Citizen::orderBy('full_name')->get();
        $schemes = PensionScheme::where('status', 'Active')->orderBy('scheme_name')->get();

        return view('citizen_pensions.create', compact('citizens', 'schemes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'citizen_id' => 'required|exists:citizens,id',
            'pension_scheme_id' => 'required|exists:pension_schemes,id',
            'enrollment_number' => 'required|string|unique:citizen_pensions',
            'pension_start_date' => 'required|date',
            'monthly_benefit_amount' => 'required|numeric|min:0',
            'pension_status' => 'required|in:Active,Pending,Suspended,Completed',
            'notes' => 'nullable|string',
        ]);

        CitizenPension::create($validated);

        return redirect()->route('citizen-pensions.index')
            ->with('success', 'Pension assignment created successfully!');
    }

    public function show(CitizenPension $citizenPension): View
    {
        $citizenPension->load(['citizen', 'pensionScheme']);
        return view('citizen_pensions.show', compact('citizenPension'));
    }

    public function edit(CitizenPension $citizenPension): View
    {
        $citizens = Citizen::orderBy('full_name')->get();
        $schemes = PensionScheme::orderBy('scheme_name')->get();

        return view('citizen_pensions.edit', compact('citizenPension', 'citizens', 'schemes'));
    }

    public function update(Request $request, CitizenPension $citizenPension): RedirectResponse
    {
        $validated = $request->validate([
            'citizen_id' => 'required|exists:citizens,id',
            'pension_scheme_id' => 'required|exists:pension_schemes,id',
            'enrollment_number' => 'required|string|unique:citizen_pensions,enrollment_number,' . $citizenPension->id,
            'pension_start_date' => 'required|date',
            'monthly_benefit_amount' => 'required|numeric|min:0',
            'pension_status' => 'required|in:Active,Pending,Suspended,Completed',
            'notes' => 'nullable|string',
        ]);

        $citizenPension->update($validated);

        return redirect()->route('citizen-pensions.index')
            ->with('success', 'Pension assignment updated successfully!');
    }

    public function destroy(CitizenPension $citizenPension): RedirectResponse
    {
        $citizenPension->delete();

        return redirect()->route('citizen-pensions.index')
            ->with('success', 'Pension assignment deleted successfully!');
    }
}
