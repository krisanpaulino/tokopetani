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
        Schema::create('lokasitoko', function (Blueprint $table) {
            $table->integer('lokasitoko_id');
            $table->string('label');
            $table->string('province_name');
            $table->string('city_name');
            $table->string('district_name');
            $table->string('subdistrict_name');
            $table->string('zip_code');
            $table->primary('lokasitoko_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasitoko');
    }
};
