<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Citizen;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $citizens = Citizen::all();
        foreach ($citizens as $citizen) {
            if ($citizen->pensionAssignments()->count() > 0) {
                $scheme = $citizen->pensionAssignments()->first()->pensionScheme;
                for ($i = 1; $i <= 3; $i++) {
                    Transaction::create([
                        'citizen_id' => $citizen->id,
                        'pension_scheme_id' => $scheme->id,
                        'transaction_reference' => 'TXN-' . time() . '-' . rand(1000, 9999) . '-' . $i,
                        'amount' => $scheme->monthly_benefit_amount,
                        'status' => 'Success',
                        'description' => 'Monthly pension disbursal for ' . now()->subMonths($i)->format('M Y'),
                        'transaction_date' => now()->subMonths($i)->startOfMonth(),
                    ]);
                }
            }
        }
    }
}
