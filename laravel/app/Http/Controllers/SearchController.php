<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\PensionScheme;
use App\Models\CitizenPension;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->get('q', '');
        $results = [
            'citizens' => collect(),
            'schemes' => collect(),
            'assignments' => collect(),
        ];
        $totalResults = 0;

        if ($query && strlen($query) >= 2) {
            $results['citizens'] = Citizen::where('full_name', 'LIKE', "%{$query}%")
                ->orWhere('aadhaar_number', 'LIKE', "%{$query}%")
                ->orWhere('mobile_number', 'LIKE', "%{$query}%")
                ->orWhere('email_address', 'LIKE', "%{$query}%")
                ->limit(10)
                ->get();

            $results['schemes'] = PensionScheme::where('scheme_name', 'LIKE', "%{$query}%")
                ->orWhere('scheme_code', 'LIKE', "%{$query}%")
                ->limit(10)
                ->get();

            $results['assignments'] = CitizenPension::where('enrollment_number', 'LIKE', "%{$query}%")
                ->with(['citizen', 'pensionScheme'])
                ->limit(10)
                ->get();

            $totalResults = $results['citizens']->count() +
                           $results['schemes']->count() +
                           $results['assignments']->count();
        }

        return view('search.index', compact('query', 'results', 'totalResults'));
    }
}
