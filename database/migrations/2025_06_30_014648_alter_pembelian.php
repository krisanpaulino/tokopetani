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
        Schema::table('pembelian', function (Blueprint $table) {
            $table->enum('status_pembelian', ['menunggu pembayaran', 'diproses', 'selesai', 'batal', 'in cart', 'verifikasi pembayaran', 'dikirim', 'belum diterima'])->default('menunggu pembayaran')->change();
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
