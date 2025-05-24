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
        Schema::create('municipalities', function (Blueprint $table) {
            $table->bigInteger('municipality_code')->unsigned()->primary();
            $table->string('municipality_name', 100);
            $table->bigInteger('region_code')->unsigned();
            $table->bigInteger('province_code')->unsigned();
            $table->string('zip_code', 10);
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipalities');
    }
};
