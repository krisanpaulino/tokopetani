<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembeli extends Model
{
    protected $table = 'pembeli';
    protected $primaryKey = 'pembeli_id';
    public $incrementing = true;
    public $timestamps = false;
    public $guarded = ['pembeli_id'];

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id')->withDefault([
            'username' => 'no data'
        ]);
    }
    function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'alamat_kota', 'city_id')->withDefault([
            'city' => 'no data'
        ]);
    }
    function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'alamat_provinsi', 'province_id')->withDefault([
            'province' => 'no data'
        ]);
    }
    function pembelian(): HasMany
    {
        return $this->hasMany(Pembelian::class, 'pembeli_id', 'pembeli_id');
    }
}
