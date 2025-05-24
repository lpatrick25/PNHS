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
        Schema::create('advisers', function (Blueprint $table) {
            $table->id('adviser_id');
            $table->string('teacher_id');
            $table->enum('grade_level', [7,8,9,10,11,12]);
            $table->string('section', 20)->unique();
            $table->string('school_year', 10);
            $table->timestamps();

            $table->foreign('teacher_id')->references('teacher_id')->on('teachers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisers');
    }
};
