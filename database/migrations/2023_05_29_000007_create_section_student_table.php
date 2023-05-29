<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('section_student', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('section_id');
            $table->boolean('has_dropped');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_student');
    }
};
