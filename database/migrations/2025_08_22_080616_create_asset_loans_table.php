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
        Schema::create('asset_loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_number')->unique();
            $table->foreignId('asset_id')->constrained();
            $table->foreignId('borrowed_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('purpose');
            $table->date('requested_from');
            $table->date('requested_until');
            $table->date('actual_return_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'active', 'returned', 'overdue', 'rejected'])->default('pending');
            $table->text('approval_notes')->nullable();
            $table->text('return_notes')->nullable();
            $table->text('condition_on_loan')->nullable();
            $table->text('condition_on_return')->nullable();
            $table->timestamps();
            
            $table->index(['asset_id', 'status']);
            $table->index(['borrowed_by', 'status']);
            $table->index(['status', 'requested_until']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_loans');
    }
};
