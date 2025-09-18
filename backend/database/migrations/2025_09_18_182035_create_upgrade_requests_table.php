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
        Schema::create('upgrade_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('organization_name')->nullable();
            $table->string('documents')->nullable(); // مسار الملفات أو روابط
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('reason')->nullable(); // سبب الرفض
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upgrade_requests');
    }
};
