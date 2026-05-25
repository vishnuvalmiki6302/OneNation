<?php
namespace App\Services;

use App\Models\CitizenApplication;
use App\Models\PensionScheme;
use Carbon\Carbon;

class EligibilityCheckService
{
    /**
     * Check eligibility for all active schemes
     */
    public function checkAllSchemeEligibility(array $citizenData): array
    {
        $schemes = PensionScheme::where('status', 'Active')->get();
        $eligibleSchemes = [];

        foreach ($schemes as $scheme) {
            $isEligible = $this->checkSchemeEligibility($scheme, $citizenData);
            
            if ($isEligible['eligible']) {
                $eligibleSchemes[] = [
                    'scheme' => $scheme,
                    'reason' => $isEligible['reason'],
                    'estimatedBenefit' => $this->calculateEstimatedBenefit($scheme, $citizenData),
                    'missingDocuments' => $isEligible['missingDocs'] ?? []
                ];
            }
        }

        return $eligibleSchemes;
    }

    /**
     * Check eligibility for specific scheme
     */
    public function checkSchemeEligibility(PensionScheme $scheme, array $data): array
    {
        $age = $this->calculateAge($data['date_of_birth']);
        $annualIncome = ($data['monthly_income'] ?? 0) * 12;
        
        $result = [
            'eligible' => false,
            'reason' => [],
            'missingDocs' => []
        ];

        // Age check
        if (!is_null($scheme->min_age) && $age < $scheme->min_age) {
            $result['reason'][] = "You must be at least {$scheme->min_age} years old";
            return $result;
        }

        if (!is_null($scheme->max_age) && $age > $scheme->max_age) {
            $result['reason'][] = "Maximum age limit for this scheme is {$scheme->max_age} years";
            return $result;
        }

        // Income check
        if (!is_null($scheme->max_income) && $annualIncome > $scheme->max_income) {
            $result['reason'][] = "Your annual income exceeds the limit of ₹" . number_format($scheme->max_income);
            return $result;
        }

        // Marital status check
        if (!empty($scheme->required_marital_status) && 
            $data['marital_status'] !== $scheme->required_marital_status) {
            $result['reason'][] = "This scheme is only for {$scheme->required_marital_status} individuals";
            return $result;
        }

        // Disability check
        if ($scheme->requires_disability && ($data['disability_status'] ?? 'No') === 'No') {
            $result['reason'][] = "This scheme requires documented disability";
            return $result;
        }

        // Category check (SC/ST/OBC)
        if (!empty($scheme->required_category) && 
            !in_array($data['caste_category'], $scheme->required_category)) {
            $result['reason'][] = "This scheme is reserved for specific categories: " . implode(', ', $scheme->required_category);
            return $result;
        }

        // Employment status check
        if (!empty($scheme->required_employment_status) && 
            $data['employment_status'] !== $scheme->required_employment_status) {
            $result['reason'][] = "This scheme requires {$scheme->required_employment_status} status";
            return $result;
        }

        // State-specific check
        if ($scheme->state_specific && !empty($scheme->applicable_states) && !in_array($data['state'], $scheme->applicable_states)) {
            $result['reason'][] = "This scheme is not available in your state";
            return $result;
        }

        // Asset check
        if (!is_null($scheme->max_assets) && ($data['total_assets'] ?? 0) > $scheme->max_assets) {
            $result['reason'][] = "Your total assets exceed the limit of ₹" . number_format($scheme->max_assets);
            return $result;
        }

        // Check for required documents
        $requiredDocs = $scheme->required_documents ?? [];
        if (!empty($requiredDocs)) {
            $missingDocs = $this->checkDocuments($data, $requiredDocs);

            if (!empty($missingDocs)) {
                $result['reason'][] = "Please upload required documents to complete application";
                $result['missingDocs'] = $missingDocs;
            }
        }

        // If all checks pass
        $result['eligible'] = true;
        $result['reason'] = ["Congratulations! You are eligible for this scheme"];

        return $result;
    }

    /**
     * Calculate estimated benefit amount
     */
    public function calculateEstimatedBenefit(PensionScheme $scheme, array $data): float
    {
        $benefit = $scheme->base_benefit_amount ?? $scheme->monthly_benefit_amount;

        // Add category-based benefit
        if (in_array($data['caste_category'] ?? '', ['SC', 'ST'])) {
            $benefit *= 1.10; // 10% additional for SC/ST
        }

        // Add disability-based benefit
        if (($data['disability_status'] ?? 'No') !== 'No') {
            $benefit *= 1.20; // 20% additional for disabled
        }

        // Reduce based on income
        $annualIncome = ($data['monthly_income'] ?? 0) * 12;
        if ($annualIncome > 0 && !is_null($scheme->max_income) && $scheme->max_income > 0) {
            $incomePercentage = $annualIncome / $scheme->max_income;
            $benefit *= (1 - ($incomePercentage * 0.3)); // Reduce up to 30%
        }

        // Add family size consideration
        if ($scheme->dependent_allowance > 0) {
            $dependents = $data['number_of_dependents'] ?? 0;
            $benefit += ($dependents * $scheme->dependent_allowance);
        }

        return max($benefit, $scheme->minimum_benefit_amount ?? 0);
    }

    /**
     * Check required documents
     */
    private function checkDocuments(array $data, array $requiredDocs): array
    {
        $missing = [];

        foreach ($requiredDocs as $doc) {
            if ($doc === 'aadhaar' && empty($data['aadhaar_file'])) {
                $missing[] = 'Aadhaar Card';
            }
            if ($doc === 'age_proof' && empty($data['age_proof_file'])) {
                $missing[] = 'Age Proof (Birth Certificate/School Certificate)';
            }
            if ($doc === 'income_certificate' && empty($data['income_certificate_file'])) {
                $missing[] = 'Income Certificate';
            }
            if ($doc === 'caste_certificate' && empty($data['caste_certificate_file']) && 
                in_array($data['caste_category'] ?? '', ['SC', 'ST', 'OBC'])) {
                $missing[] = 'Caste Certificate';
            }
            if ($doc === 'disability_certificate' && empty($data['disability_certificate_file']) && 
                ($data['disability_status'] ?? 'No') !== 'No') {
                $missing[] = 'Disability Certificate';
            }
            if ($doc === 'address_proof' && empty($data['address_proof_file'])) {
                $missing[] = 'Address Proof';
            }
        }

        return $missing;
    }

    /**
     * Calculate age from date of birth
     */
    private function calculateAge($dob): int
    {
        if (empty($dob)) return 0;
        return Carbon::parse($dob)->age;
    }
}
