<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Citizen;

class ProfileController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $user = auth()->user();
        $citizen = $user->citizen;
        return view('user.profile_create', compact('citizen'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $citizen = $user->citizen;

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'aadhaar_number' => 'required|string|size:12|unique:citizens,aadhaar_number' . ($citizen ? ',' . $citizen->id : ''),
            'mobile_number' => 'required|string|size:10|unique:citizens,mobile_number' . ($citizen ? ',' . $citizen->id : ''),
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'state' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'full_address' => 'required|string',
        ]);

        if ($citizen) {
            $citizen->update($validated);
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
        } else {
            $validated['user_id'] = $user->id;
            $validated['email_address'] = $user->email;
            $validated['pension_status'] = 'None';
            Citizen::create($validated);
            return redirect()->route('dashboard')->with('success', 'Profile completed successfully! You can now apply for pension schemes.');
        }
    }
}
