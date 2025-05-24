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
        Schema::create('principals', function (Blueprint $table) {
            $table->string('principal_id')->primary();
            $table->unsignedBigInteger('user_id');
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
            $table->string('civil_status', 15);
            $table->string('email', 50);
            $table->string('contact', 20);
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
        Schema::dropIfExists('principals');
    }
};
