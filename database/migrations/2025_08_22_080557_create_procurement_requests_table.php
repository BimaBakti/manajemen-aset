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
        Schema::create('procurement_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique();
            $table->foreignId('requested_by')->constrained('users');
            $table->foreignId('department_id')->constrained();
            $table->string('title');
            $table->text('description');
            $table->text('justification');
            $table->decimal('estimated_budget', 15, 2);
            $table->date('needed_by')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['draft', 'submitted', 'under_review', 'approved', 'rejected', 'cancelled'])->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_notes')->nullable();
            $table->foreignId('vendor_id')->nullable()->constrained();
            $table->decimal('actual_cost', 15, 2)->nullable();
            $table->date('order_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'department_id']);
            $table->index(['requested_by', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_requests');
    }
};
