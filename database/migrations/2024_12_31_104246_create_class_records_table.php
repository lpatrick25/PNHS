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
        Schema::create('class_records', function (Blueprint $table) {
            $table->id('records_id');
            $table->string('records_name', 50);
            $table->string('student_lrn');
            $table->unsignedBigInteger('subject_listing');
            $table->string('school_year');
            $table->integer('total_score')->nullable();
            $table->integer('student_score')->default(0);
            $table->enum('records_type', ['Written Works', 'Performance Tasks', 'Quarterly Assessment']);
            $table->enum('quarter', ['1st Quarter', '2nd Quarter', '3rd Quarter', '4th Quarter'])->default('1st Quarter');
            $table->timestamps();

            $table->foreign('student_lrn')->references('student_lrn')->on('students')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('subject_listing')->references('subject_listing')->on('subject_teachers')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_records');
    }
};
