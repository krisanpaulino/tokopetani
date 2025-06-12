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

        Schema::table('pembeli', function (Blueprint $table) {
            $table->integer('lokasi_id');
            $table->text('lokasi_string');
            $table->dropColumn(['alamat_desa', 'alamat_kota', 'alamat_provinsi', 'alamat_kodepos']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
