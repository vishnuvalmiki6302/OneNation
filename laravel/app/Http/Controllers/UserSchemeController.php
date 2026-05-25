<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\PensionScheme;
use App\Models\CitizenPension;
use App\Models\CitizenApplication;
use App\Http\Requests\CitizenPensionApplicationRequest;
use App\Services\EligibilityCheckService;
use Illuminate\Support\Facades\Storage;

class UserSchemeController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();
        if (!$user->citizen) {
            return redirect()->route('profile.create')->with('error', 'Please complete your profile first.');
        }

        // Get all active schemes
        $schemes = PensionScheme::where('status', 'Active')->get();
        
        // Get user's current applications
        $myApplications = CitizenPension::where('citizen_id', $user->citizen->id)
                            ->pluck('pension_scheme_id')
                            ->toArray();

        return view('user.schemes.index', compact('schemes', 'myApplications'));
    }

    public function apply(PensionScheme $scheme): View|RedirectResponse
    {
        $user = auth()->user();
        if (!$user->citizen) {
            return redirect()->route('profile.create');
        }

        // Check if already applied
        $exists = CitizenPension::where('citizen_id', $user->citizen->id)
            ->where('pension_scheme_id', $scheme->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already applied for this scheme.');
        }

        return view('user.schemes.apply', [
            'scheme' => $scheme,
            'citizen' => $user->citizen
        ]);
    }

    public function storeApplication(CitizenPensionApplicationRequest $request, PensionScheme $scheme, EligibilityCheckService $eligibilityService): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->citizen) {
            return redirect()->route('profile.create');
        }

        $validated = $request->validated();
        
        // Handle file uploads
        $fileFields = [
            'aadhaar_file', 'address_proof_file', 'disability_certificate_file',
            'income_certificate_file', 'annual_income_tax_return', 'bank_statement_file',
            'caste_certificate_file', 'ews_certificate_file', 'medical_certificate_file',
            'education_proof_file'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('applications/documents', 'public');
            }
        }

        // Run eligibility check
        $eligibilityResult = $eligibilityService->checkSchemeEligibility($scheme, $validated);

        if (!$eligibilityResult['eligible']) {
            return back()->withInput()->with('error', 'You do not meet the eligibility criteria: ' . implode(', ', $eligibilityResult['reason']));
        }

        $validated['citizen_id'] = $user->citizen->id;
        $validated['pension_scheme_id'] = $scheme->id;
        $validated['application_number'] = 'APP-' . date('Y') . '-' . strtoupper(uniqid());
        $validated['status'] = 'Pending';

        // Store comprehensive application record
        CitizenApplication::create($validated);

        // Create the core assignment link
        $enrollment_number = 'ENR-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

        CitizenPension::create([
            'citizen_id' => $user->citizen->id,
            'pension_scheme_id' => $scheme->id,
            'enrollment_number' => $enrollment_number,
            'pension_start_date' => now(), // Admin can adjust upon approval
            'monthly_benefit_amount' => $eligibilityResult['estimatedBenefit'] ?? $scheme->monthly_benefit_amount,
            'pension_status' => 'Pending',
            'notes' => 'Applied via comprehensive portal on ' . now()->format('d M Y'),
        ]);

        if ($user->citizen->pension_status === 'None') {
            $user->citizen->update(['pension_status' => 'Pending']);
        }

        return redirect()->route('user.schemes.index')->with('success', "Your comprehensive application for {$scheme->scheme_name} has been submitted successfully!");
    }
}
