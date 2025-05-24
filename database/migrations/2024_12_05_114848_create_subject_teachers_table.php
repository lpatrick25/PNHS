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
        Schema::create('subject_teachers', function (Blueprint $table) {
            $table->id('subject_listing');
            $table->string('subject_code');
            $table->string('teacher_id');
            $table->string('school_year');
            $table->enum('grade_level', [7,8,9,10,11,12]);
            $table->string('section');

            $table->foreign('subject_code')->references('subject_code')->on('subjects')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers')->onDelete('restrict')->onUpdate('cascade');
            $table->unique(['subject_code', 'grade_level', 'section', 'school_year'], 'unique_subject_assignment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_teachers');
    }
};
