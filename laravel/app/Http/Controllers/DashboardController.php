<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\PensionScheme;
use App\Models\CitizenPension;
use App\Models\DuplicateLog;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function dashboard(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user && $user->isUser()) {
            if (!$user->citizen) {
                return redirect()->route('profile.create');
            }
            return view('user.dashboard', compact('user'));
        }
        $totalCitizens = Citizen::count();
        $activeSchemes = PensionScheme::where('status', 'Active')->count();
        $totalAssignments = CitizenPension::count();
        $activeAssignments = CitizenPension::where('pension_status', 'Active')->count();
        $pendingAssignments = CitizenPension::where('pension_status', 'Pending')->count();
        $duplicateRecords = DuplicateLog::where('status', 'pending')->count();

        $recentCitizens = Citizen::with('pensionAssignments')
            ->latest()
            ->take(5)
            ->get();

        $topSchemes = PensionScheme::withCount('citizenPensions')
            ->orderByDesc('citizen_pensions_count')
            ->take(5)
            ->get();

        $totalBenefitsPaid = CitizenPension::where('pension_status', 'Active')
            ->sum('monthly_benefit_amount');

        return view('dashboard', compact(
            'totalCitizens',
            'activeSchemes',
            'totalAssignments',
            'activeAssignments',
            'pendingAssignments',
            'duplicateRecords',
            'recentCitizens',
            'topSchemes',
            'totalBenefitsPaid'
        ));
    }
}
