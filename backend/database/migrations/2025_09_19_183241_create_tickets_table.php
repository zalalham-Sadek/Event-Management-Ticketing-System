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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id'); // لكل فعالية
            $table->string('type');                   // VIP, Regular, Early Bird
            $table->decimal('price', 10, 2);
            $table->integer('quantity');              // العدد الكلي المتاح
            $table->integer('sold')->default(0);      // عدد المباعة
            $table->timestamps();

            $table->foreign('event_id')
                  ->references('id')->on('events')
                  ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
