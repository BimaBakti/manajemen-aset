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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('location_id')->nullable()->constrained();
            $table->string('serial_number')->nullable();
            $table->string('model')->nullable();
            $table->string('brand')->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->enum('status', ['available', 'in_use', 'maintenance', 'retired', 'lost'])->default('available');
            $table->enum('condition', ['excellent', 'good', 'fair', 'poor'])->default('excellent');
            $table->text('notes')->nullable();
            $table->string('qr_code')->nullable();
            $table->json('specifications')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->date('assigned_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'category_id']);
            $table->index(['assigned_to', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
