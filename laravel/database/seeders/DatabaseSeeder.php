<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Citizen;
use App\Models\PensionScheme;
use App\Models\CitizenPension;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@onecitizen.gov.in'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'), // default password for testing
                'role' => 'Admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $operator = User::firstOrCreate(
            ['email' => 'operator@onecitizen.gov.in'],
            [
                'name' => 'Data Operator',
                'password' => Hash::make('password'),
                'role' => 'Operator',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 2. Create Pension Schemes
        $schemes = [
            [
                'scheme_name' => 'National Old Age Pension Scheme',
                'scheme_code' => 'NOAPS-2024',
                'scheme_type' => 'Old Age',
                'provider_type' => 'Government',
                'monthly_benefit_amount' => 3000.00,
                'eligibility_criteria' => 'Age > 60 years, Below Poverty Line',
                'status' => 'Active',
            ],
            [
                'scheme_name' => 'State Disability Pension',
                'scheme_code' => 'SDP-MHA',
                'scheme_type' => 'Disability',
                'provider_type' => 'Government',
                'monthly_benefit_amount' => 2500.00,
                'eligibility_criteria' => 'Disability > 40%, Certified by Medical Board',
                'status' => 'Active',
            ],
            [
                'scheme_name' => 'Widow Pension Support',
                'scheme_code' => 'WPS-001',
                'scheme_type' => 'Social Security',
                'provider_type' => 'Government',
                'monthly_benefit_amount' => 2000.00,
                'eligibility_criteria' => 'Widow, No primary source of income',
                'status' => 'Active',
            ],
            [
                'scheme_name' => 'Atal Pension Yojana',
                'scheme_code' => 'APY-GOI',
                'scheme_type' => 'Old Age',
                'provider_type' => 'Government',
                'monthly_benefit_amount' => 5000.00,
                'eligibility_criteria' => 'Subscriber age 18-40, Contributions made',
                'status' => 'Active',
            ]
        ];

        foreach ($schemes as $schemeData) {
            PensionScheme::firstOrCreate(['scheme_code' => $schemeData['scheme_code']], $schemeData);
        }

        // 3. Create Citizens
        $citizens = [
            [
                'full_name' => 'Ramesh Kumar',
                'aadhaar_number' => '123456789012',
                'mobile_number' => '9876543210',
                'email_address' => 'ramesh.k@example.com',
                'date_of_birth' => '1955-04-15',
                'gender' => 'Male',
                'full_address' => '123 MG Road, Colaba',
                'district' => 'Mumbai',
                'state' => 'Maharashtra',
                'pension_status' => 'Active',
            ],
            [
                'full_name' => 'Sunita Sharma',
                'aadhaar_number' => '987654321098',
                'mobile_number' => '9123456780',
                'date_of_birth' => '1960-08-22',
                'gender' => 'Female',
                'full_address' => '45 Civil Lines',
                'district' => 'Jaipur',
                'state' => 'Rajasthan',
                'pension_status' => 'Active',
            ],
            [
                'full_name' => 'Vikram Singh',
                'aadhaar_number' => '456789123012',
                'mobile_number' => '9988776655',
                'date_of_birth' => '1985-11-30',
                'gender' => 'Male',
                'full_address' => 'Sector 14, Huda Market',
                'district' => 'Gurugram',
                'state' => 'Haryana',
                'pension_status' => 'Pending',
            ],
            [
                'full_name' => 'Meera Bai',
                'aadhaar_number' => '789012345678',
                'mobile_number' => '9871234560',
                'date_of_birth' => '1970-02-10',
                'gender' => 'Female',
                'full_address' => 'Navrangpura',
                'district' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pension_status' => 'None',
            ],
            // Deliberate duplicate for testing
            [
                'full_name' => 'Ramesh Kumar',
                'aadhaar_number' => '123456789015', // Slight difference in Aadhaar
                'mobile_number' => '9876543210',   // Same mobile
                'date_of_birth' => '1955-04-15',   // Same DOB
                'gender' => 'Male',
                'full_address' => 'Colaba, Mumbai',
                'district' => 'Mumbai',
                'state' => 'Maharashtra',
                'pension_status' => 'Pending',
            ],
        ];

        foreach ($citizens as $citizenData) {
            Citizen::firstOrCreate(['aadhaar_number' => $citizenData['aadhaar_number']], $citizenData);
        }

        // 4. Create Pension Assignments
        $c1 = Citizen::where('aadhaar_number', '123456789012')->first();
        $s1 = PensionScheme::where('scheme_code', 'NOAPS-2024')->first();
        
        if ($c1 && $s1) {
            CitizenPension::firstOrCreate(
                ['citizen_id' => $c1->id, 'pension_scheme_id' => $s1->id],
                [
                    'enrollment_number' => 'ENR-2024-0001',
                    'pension_start_date' => Carbon::parse('2024-01-01'),
                    'monthly_benefit_amount' => $s1->monthly_benefit_amount,
                    'pension_status' => 'Active',
                    'notes' => 'Verified and approved by block officer.',
                ]
            );
        }

        $c2 = Citizen::where('aadhaar_number', '987654321098')->first();
        $s2 = PensionScheme::where('scheme_code', 'WPS-001')->first();

        if ($c2 && $s2) {
            CitizenPension::firstOrCreate(
                ['citizen_id' => $c2->id, 'pension_scheme_id' => $s2->id],
                [
                    'enrollment_number' => 'ENR-2024-0002',
                    'pension_start_date' => Carbon::parse('2024-03-15'),
                    'monthly_benefit_amount' => $s2->monthly_benefit_amount,
                    'pension_status' => 'Active',
                    'notes' => 'Documentation complete.',
                ]
            );
        }

        $c3 = Citizen::where('aadhaar_number', '456789123012')->first();
        $s3 = PensionScheme::where('scheme_code', 'SDP-MHA')->first();

        if ($c3 && $s3) {
            CitizenPension::firstOrCreate(
                ['citizen_id' => $c3->id, 'pension_scheme_id' => $s3->id],
                [
                    'enrollment_number' => 'ENR-2024-0003',
                    'pension_start_date' => Carbon::parse('2024-05-01'),
                    'monthly_benefit_amount' => $s3->monthly_benefit_amount,
                    'pension_status' => 'Pending',
                    'notes' => 'Awaiting medical board certificate verification.',
                ]
            );
        }
    }
}
