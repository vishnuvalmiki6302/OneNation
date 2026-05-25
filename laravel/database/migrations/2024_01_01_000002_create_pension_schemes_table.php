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
        Schema::create('pension_schemes', function (Blueprint $table) {
            $table->id();
            $table->string('scheme_name');
            $table->string('scheme_code', 50)->unique();
            $table->enum('scheme_type', ['Social Security', 'Healthcare', 'Disability', 'Old Age', 'Other']);
            $table->enum('provider_type', ['Government', 'Private', 'NGO']);
            $table->text('eligibility_criteria');
            $table->decimal('monthly_benefit_amount', 10, 2);
            $table->enum('status', ['Active', 'Draft', 'Inactive'])->default('Draft');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pension_schemes');
    }
};
