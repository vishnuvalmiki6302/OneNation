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
        Schema::create('duplicate_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_citizen_id');
            $table->unsignedBigInteger('duplicate_citizen_id');
            $table->decimal('match_percentage', 5, 2);
            $table->text('match_reason');
            $table->enum('status', ['pending', 'reviewed', 'merged', 'dismissed'])->default('pending');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('original_citizen_id')->references('id')->on('citizens')->onDelete('cascade');
            $table->foreign('duplicate_citizen_id')->references('id')->on('citizens')->onDelete('cascade');
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
            $table->index('original_citizen_id');
            $table->index('duplicate_citizen_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duplicate_logs');
    }
};
