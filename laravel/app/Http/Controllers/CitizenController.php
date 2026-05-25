<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CitizenController extends Controller
{
    // Display all citizens
    public function index(): View
    {
        $citizens = Citizen::latest()
            ->paginate(10)
            ->appends(request()->query());

        return view('citizens.index', compact('citizens'));
    }

    // Show create form
    public function create(): View
    {
        $states = [
            'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh',
            'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand',
            'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur',
            'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab',
            'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura',
            'Uttar Pradesh', 'Uttarakhand', 'West Bengal'
        ];

        return view('citizens.create', compact('states'));
    }

    // Store citizen
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'aadhaar_number' => 'required|digits:12|unique:citizens,aadhaar_number',
            'mobile_number' => 'required|digits:10|unique:citizens,mobile_number',
            'email_address' => 'nullable|email|unique:citizens,email_address',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date|before:today',
            'state' => 'required|string',
            'district' => 'required|string',
            'full_address' => 'required|string|max:500',
            'pension_status' => 'required|in:Active,Pending,None',
        ]);

        Citizen::create($validated);

        return redirect()->route('citizens.index')
            ->with('success', 'Citizen registered successfully!');
    }

    // Show citizen details
    public function show(Citizen $citizen): View
    {
        $citizen->load('pensionAssignments.pensionScheme');
        return view('citizens.show', compact('citizen'));
    }

    // Show edit form
    public function edit(Citizen $citizen): View
    {
        $states = [
            'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh',
            'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand',
            'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur',
            'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab',
            'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura',
            'Uttar Pradesh', 'Uttarakhand', 'West Bengal'
        ];

        return view('citizens.edit', compact('citizen', 'states'));
    }

    // Update citizen
    public function update(Request $request, Citizen $citizen): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'aadhaar_number' => 'required|digits:12|unique:citizens,aadhaar_number,' . $citizen->id,
            'mobile_number' => 'required|digits:10|unique:citizens,mobile_number,' . $citizen->id,
            'email_address' => 'nullable|email|unique:citizens,email_address,' . $citizen->id,
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date|before:today',
            'state' => 'required|string',
            'district' => 'required|string',
            'full_address' => 'required|string|max:500',
            'pension_status' => 'required|in:Active,Pending,None',
        ]);

        $citizen->update($validated);

        return redirect()->route('citizens.index')
            ->with('success', 'Citizen updated successfully!');
    }

    // Delete citizen
    public function destroy(Citizen $citizen): RedirectResponse
    {
        $citizen->delete();

        return redirect()->route('citizens.index')
            ->with('success', 'Citizen deleted successfully!');
    }
}
