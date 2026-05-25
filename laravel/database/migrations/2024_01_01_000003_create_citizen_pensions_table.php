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
        Schema::create('citizen_pensions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('citizen_id');
            $table->unsignedBigInteger('pension_scheme_id');
            $table->string('enrollment_number')->unique();
            $table->date('pension_start_date');
            $table->decimal('monthly_benefit_amount', 10, 2);
            $table->enum('pension_status', ['Active', 'Pending', 'Suspended', 'Completed', 'Rejected'])->default('Pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('citizen_id')->references('id')->on('citizens')->onDelete('cascade');
            $table->foreign('pension_scheme_id')->references('id')->on('pension_schemes')->onDelete('restrict');
            $table->index('citizen_id');
            $table->index('pension_scheme_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizen_pensions');
    }
};
