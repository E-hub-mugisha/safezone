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
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('safe_zone_cases')->onDelete('cascade');
            $table->foreignId('medical_id')->constrained('users')->onDelete('cascade'); // doctor/nurse who uploads
            $table->text('report')->nullable(); // treatment notes
            $table->string('file_path')->nullable(); // attached medical doc (PDF, image, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_reports');
    }
};
