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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->string('student_lrn');
            $table->unsignedBigInteger('subject_listing');
            $table->string('school_year');
            $table->date('attendance_date');
            $table->enum('status', ['PRESENT', 'ABSENT', 'LATE', 'EXCUSED'])->default('PRESENT');
            $table->string('remarks', 255)->nullable();
            $table->timestamps();

            $table->foreign('student_lrn')->references('student_lrn')->on('students')->onDelete('cascade');
            $table->foreign('subject_listing')->references('subject_listing')->on('subject_teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
