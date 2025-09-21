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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Unique order identifier
            $table->unsignedBigInteger('user_id'); // Customer who made the order
            $table->unsignedBigInteger('event_id'); // Event for this order
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'refunded'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable(); // cash, card, bank_transfer, etc.
            $table->string('payment_reference')->nullable(); // Payment gateway reference
            $table->decimal('subtotal', 10, 2); // Total before taxes/fees
            $table->decimal('tax_amount', 10, 2)->default(0); // Tax amount
            $table->decimal('service_fee', 10, 2)->default(0); // Service fee
            $table->decimal('total_amount', 10, 2); // Final total
            $table->text('notes')->nullable(); // Order notes
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index(['user_id', 'status']);
            $table->index(['event_id', 'status']);
            $table->index('order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
