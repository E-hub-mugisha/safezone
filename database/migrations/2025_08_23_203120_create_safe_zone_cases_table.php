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
        Schema::create('safe_zone_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // reporter
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null'); // assigned RIB agent
            $table->foreignId('medical_id')->nullable()->constrained('users')->onDelete('set null'); // assigned medical staff
            $table->enum('type', ['physical', 'sexual', 'psychological']);
            $table->text('description');
            $table->string('location')->nullable();
            $table->enum('status', ['pending', 'verified', 'in_progress', 'resolved'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safe_zone_cases');
    }
};
