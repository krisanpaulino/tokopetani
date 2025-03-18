<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'pembelian_id';
    public $timestamps = false;
    protected $fillable = [
        'tanggal_pesan',
        'status_pembelian',
        'pembeli_id',
        'total_bayar',
        'produk_id',
        'jumlah_beli',
    ];

    function pembeli(): BelongsTo
    {
        return $this->belongsTo(Pembeli::class, 'pembeli_id', 'pembeli_id');
    }

    function detailpembelian(): HasMany
    {
        return $this->hasMany(Detailpembelian::class, 'pembelian_id', 'pembelian_id');
    }
    function pengiriman(): HasMany
    {
        return $this->hasMany(Pengiriman::class, 'pembelian_id', 'pembelian_id');
    }
    function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'pembelian_id', 'pembelian_id');
    }
}
