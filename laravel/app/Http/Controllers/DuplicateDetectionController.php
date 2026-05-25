<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\DuplicateLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DuplicateDetectionController extends Controller
{
    public function index(): View
    {
        $duplicates = DuplicateLog::with(['originalCitizen', 'duplicateCitizen', 'reviewedBy'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('duplicate_detection.index', compact('duplicates'));
    }

    public function scan(): RedirectResponse
    {
        $citizens = Citizen::all();
        $threshold = 0.85; // 85% match

        foreach ($citizens as $key => $citizen) {
            $remaining = $citizens->slice($key + 1);

            foreach ($remaining as $otherCitizen) {
                $matchPercentage = $this->calculateMatch($citizen, $otherCitizen);

                if ($matchPercentage >= $threshold) {
                    DuplicateLog::updateOrCreate(
                        [
                            'original_citizen_id' => $citizen->id,
                            'duplicate_citizen_id' => $otherCitizen->id,
                        ],
                        [
                            'match_percentage' => $matchPercentage * 100,
                            'match_reason' => $this->getMatchReason($citizen, $otherCitizen),
                            'status' => 'pending',
                        ]
                    );
                }
            }
        }

        return back()->with('success', 'Duplicate scan completed!');
    }

    public function review(DuplicateLog $duplicate, Request $request): RedirectResponse
    {
        $action = $request->get('action'); // 'merged', 'dismissed'

        $duplicate->update([
            'status' => $action,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'notes' => $request->get('notes'),
        ]);

        return back()->with('success', 'Duplicate record reviewed!');
    }

    private function calculateMatch(Citizen $citizen1, Citizen $citizen2): float
    {
        $matches = 0;
        $total = 0;

        // Aadhaar match (40 weight)
        if ($citizen1->aadhaar_number === $citizen2->aadhaar_number) {
            $matches += 40;
        }
        $total += 40;

        // Name similarity (30 weight)
        $nameSimilarity = $this->stringSimilarity(
            strtolower($citizen1->full_name),
            strtolower($citizen2->full_name)
        );
        $matches += $nameSimilarity * 30;
        $total += 30;

        // Mobile match (20 weight)
        if ($citizen1->mobile_number === $citizen2->mobile_number) {
            $matches += 20;
        }
        $total += 20;

        // DOB match (10 weight)
        if ($citizen1->date_of_birth && $citizen2->date_of_birth &&
            $citizen1->date_of_birth->equalTo($citizen2->date_of_birth)) {
            $matches += 10;
        }
        $total += 10;

        return ($matches / $total);
    }

    private function stringSimilarity(string $str1, string $str2): float
    {
        $len = max(strlen($str1), strlen($str2));
        if ($len === 0) return 1.0;

        return 1 - (levenshtein($str1, $str2) / $len);
    }

    private function getMatchReason(Citizen $citizen1, Citizen $citizen2): string
    {
        $reasons = [];

        if ($citizen1->aadhaar_number === $citizen2->aadhaar_number) {
            $reasons[] = 'Exact Aadhaar match';
        }

        if ($citizen1->mobile_number === $citizen2->mobile_number) {
            $reasons[] = 'Exact mobile match';
        }

        if ($citizen1->date_of_birth && $citizen2->date_of_birth &&
            $citizen1->date_of_birth->equalTo($citizen2->date_of_birth)) {
            $reasons[] = 'Same date of birth';
        }

        return implode(', ', $reasons) ?: 'Name similarity detected';
    }
}
