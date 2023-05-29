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
        Schema::table('classrooms', function (Blueprint $table) {
            $table
                ->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('lecturer_id')
                ->references('id')
                ->on('lecturers')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['lecturer_id']);
        });
    }
};
