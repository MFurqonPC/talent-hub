<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('skill_name');
            $table->string('level')->nullable(); // contoh: Beginner/Intermediate/Advanced
            $table->string('evidence_file')->nullable(); // bukti pendukung (opsional)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('point_value')->default(0);
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
