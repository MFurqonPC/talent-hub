<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->enum('category', ['personal', 'freelance', 'industri']);
            $table->text('description')->nullable();
            $table->string('file_path')->nullable(); // upload file (opsional)
            $table->string('link')->nullable();      // atau link eksternal (github, behance, dll)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('point_value')->default(0);
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
