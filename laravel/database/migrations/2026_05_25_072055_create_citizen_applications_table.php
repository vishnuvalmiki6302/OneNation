<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('citizen_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citizen_id')->constrained()->onDelete('cascade');
            $table->foreignId('pension_scheme_id')->constrained()->onDelete('cascade');
            
            // Basic Status
            $table->enum('status', ['Draft', 'Pending', 'Verified', 'Approved', 'Rejected'])->default('Draft');
            $table->string('application_number')->unique()->nullable();
            
            // Personal & Family
            $table->string('marital_status');
            $table->string('religion')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_aadhaar', 12)->nullable();
            $table->integer('number_of_dependents')->default(0);
            $table->integer('financial_dependents')->default(0);
            
            // Additional IDs
            $table->string('pan_number')->nullable();
            $table->string('voter_id')->nullable();
            
            // Employment & Income
            $table->string('employment_status');
            $table->string('occupation_type')->nullable();
            $table->string('organization_name')->nullable();
            $table->decimal('monthly_income', 12, 2);
            $table->json('income_source')->nullable();
            $table->decimal('total_assets', 15, 2)->nullable();
            
            // Category & Health
            $table->string('caste_category');
            $table->string('bpl_status')->nullable();
            $table->string('health_status');
            $table->string('disability_status')->default('No');
            $table->json('chronic_diseases')->nullable();
            $table->string('health_insurance_status');
            
            // Education
            $table->string('education_level');
            $table->enum('currently_studying', ['Yes', 'No'])->default('No');
            
            // File Paths
            $table->string('aadhaar_file')->nullable();
            $table->string('address_proof_file')->nullable();
            $table->string('disability_certificate_file')->nullable();
            $table->string('income_certificate_file')->nullable();
            $table->string('annual_income_tax_return')->nullable();
            $table->string('bank_statement_file')->nullable();
            $table->string('caste_certificate_file')->nullable();
            $table->string('ews_certificate_file')->nullable();
            $table->string('medical_certificate_file')->nullable();
            $table->string('education_proof_file')->nullable();
            
            // Legal
            $table->boolean('consent')->default(false);
            $table->boolean('data_verification')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citizen_applications');
    }
};
