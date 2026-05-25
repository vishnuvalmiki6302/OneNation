<?php

namespace App\Http\Controllers;

use App\Models\PensionScheme;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PensionSchemeController extends Controller
{
    public function index(): View
    {
        $schemes = PensionScheme::latest()
            ->paginate(10)
            ->appends(request()->query());

        return view('pension_schemes.index', compact('schemes'));
    }

    public function create(): View
    {
        return view('pension_schemes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'scheme_name' => 'required|string|max:255|unique:pension_schemes',
            'scheme_code' => 'required|string|max:50|unique:pension_schemes',
            'scheme_type' => 'required|in:Social Security,Healthcare,Disability,Old Age,Other',
            'provider_type' => 'required|in:Government,Private,NGO',
            'eligibility_criteria' => 'required|string',
            'monthly_benefit_amount' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Draft,Inactive',
            'description' => 'nullable|string',
        ]);

        PensionScheme::create($validated);

        return redirect()->route('pension-schemes.index')
            ->with('success', 'Pension scheme created successfully!');
    }

    public function show(PensionScheme $pensionScheme): View
    {
        $pensionScheme->load('citizenPensions.citizen');
        return view('pension_schemes.show', compact('pensionScheme'));
    }

    public function edit(PensionScheme $pensionScheme): View
    {
        return view('pension_schemes.edit', compact('pensionScheme'));
    }

    public function update(Request $request, PensionScheme $pensionScheme): RedirectResponse
    {
        $validated = $request->validate([
            'scheme_name' => 'required|string|max:255|unique:pension_schemes,scheme_name,' . $pensionScheme->id,
            'scheme_code' => 'required|string|max:50|unique:pension_schemes,scheme_code,' . $pensionScheme->id,
            'scheme_type' => 'required|in:Social Security,Healthcare,Disability,Old Age,Other',
            'provider_type' => 'required|in:Government,Private,NGO',
            'eligibility_criteria' => 'required|string',
            'monthly_benefit_amount' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Draft,Inactive',
            'description' => 'nullable|string',
        ]);

        $pensionScheme->update($validated);

        return redirect()->route('pension-schemes.index')
            ->with('success', 'Pension scheme updated successfully!');
    }

    public function destroy(PensionScheme $pensionScheme): RedirectResponse
    {
        $pensionScheme->delete();

        return redirect()->route('pension-schemes.index')
            ->with('success', 'Pension scheme deleted successfully!');
    }
}
