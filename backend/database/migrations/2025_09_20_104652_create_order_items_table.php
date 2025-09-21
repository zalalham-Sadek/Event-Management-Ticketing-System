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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // Reference to orders table
            $table->unsignedBigInteger('ticket_id'); // Reference to tickets table
            $table->string('ticket_type'); // Store ticket type at time of purchase
            $table->decimal('unit_price', 10, 2); // Price per ticket at time of purchase
            $table->integer('quantity'); // Number of tickets
            $table->decimal('total_price', 10, 2); // Total price for this item (unit_price * quantity)
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index(['order_id']);
            $table->index(['ticket_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
