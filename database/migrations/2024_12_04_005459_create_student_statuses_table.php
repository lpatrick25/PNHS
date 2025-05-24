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
        Schema::create('student_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('student_lrn');
            $table->unsignedBigInteger('adviser_id');
            $table->enum('grade_level', [7,8,9,10,11,12]);
            $table->string('school_year');
            $table->string('section', 20);
            $table->enum('status', ['ENROLLED', 'DROPPED'])->default('ENROLLED');
            $table->timestamps();

            $table->foreign('student_lrn')->references('student_lrn')->on('students')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('adviser_id')->references('adviser_id')->on('advisers')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_statuses');
    }
};
