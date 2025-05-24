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
        Schema::create('students', function (Blueprint $table) {
            $table->string('student_lrn')->primary();
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('rfid_no')->unsigned();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('extension_name')->nullable();
            $table->bigInteger('province_code')->unsigned();
            $table->bigInteger('municipality_code')->unsigned();
            $table->bigInteger('brgy_code')->unsigned();
            $table->integer('zip_code');
            $table->string('religion', 50);
            $table->date('birthday');
            $table->string('sex', 6);
            $table->string('disability', 50);
            $table->string('email', 50);
            $table->string('parent_contact', 20);
            $table->string('contact', 20);
            $table->bigInteger('present_province_code')->unsigned();
            $table->bigInteger('present_municipality_code')->unsigned();
            $table->bigInteger('present_brgy_code')->unsigned();
            $table->integer('present_zip_code');
            $table->string('mother_first_name');
            $table->string('mother_middle_name')->nullable();
            $table->string('mother_last_name');
            $table->string('mother_address');
            $table->string('father_first_name');
            $table->string('father_middle_name')->nullable();
            $table->string('father_last_name');
            $table->string('father_suffix')->nullable();
            $table->string('father_address');
            $table->string('guardian')->nullable();
            $table->string('guardian_address')->nullable();
            $table->string('image', 50)->default('dist/img/avatar2.png');
            $table->timestamps();

            $table->foreign('province_code')
                ->references('province_code')
                ->on('brgys')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('municipality_code')
                ->references('municipality_code')
                ->on('brgys')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('brgy_code')
                ->references('brgy_code')
                ->on('brgys')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('present_province_code')
                ->references('province_code')
                ->on('brgys')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('present_municipality_code')
                ->references('municipality_code')
                ->on('brgys')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('present_brgy_code')
                ->references('brgy_code')
                ->on('brgys')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
