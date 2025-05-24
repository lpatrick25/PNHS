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
        Schema::create('brgys', function (Blueprint $table) {
            $table->bigInteger('brgy_code')->unsigned()->primary();
            $table->string('brgy_name', 100);
            $table->bigInteger('region_code')->unsigned();
            $table->bigInteger('province_code')->unsigned();
            $table->bigInteger('municipality_code')->unsigned();
            $table->timestamps();

            $table->foreign('region_code')
                  ->references('region_code')
                  ->on('regions')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('province_code')
                  ->references('province_code')
                  ->on('provinces')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('municipality_code')
                  ->references('municipality_code')
                  ->on('municipalities')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brgys');
    }
};
