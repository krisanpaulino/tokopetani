<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';
    protected $primaryKey = 'pengiriman_id';
    public $incrementing = true;
    public $timestamps = false;
    public $guarded = ['pengiriman_id'];

    function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'pembelian_id');
    }
    function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'alamat_kota', 'city_id');
    }
    function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'alamat_provinsi', 'province_id');
    }
}
