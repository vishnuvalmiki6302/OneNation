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
        Schema::table('pension_schemes', function (Blueprint $table) {
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->decimal('max_income', 12, 2)->nullable();
            $table->string('required_marital_status')->nullable();
            $table->boolean('requires_disability')->default(false);
            $table->json('required_category')->nullable();
            $table->string('required_employment_status')->nullable();
            $table->boolean('state_specific')->default(false);
            $table->json('applicable_states')->nullable();
            $table->decimal('max_assets', 15, 2)->nullable();
            $table->json('required_documents')->nullable();
            $table->decimal('base_benefit_amount', 10, 2)->nullable();
            $table->decimal('dependent_allowance', 10, 2)->default(0);
            $table->decimal('minimum_benefit_amount', 10, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pension_schemes', function (Blueprint $table) {
            $table->dropColumn([
                'min_age', 'max_age', 'max_income', 'required_marital_status', 
                'requires_disability', 'required_category', 'required_employment_status', 
                'state_specific', 'applicable_states', 'max_assets', 'required_documents',
                'base_benefit_amount', 'dependent_allowance', 'minimum_benefit_amount'
            ]);
        });
    }
};
