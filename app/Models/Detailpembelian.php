<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Detailpembelian extends Model
{
    protected $table = 'detailpembelian';
    protected $primaryKey = 'detailpembelian_id';
    public $timestamps = false;
    protected $fillable = [
        'pembelian_id',
        'jumlah_beli',
        'harga_detail',
        'produk_id',
    ];

    function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }

    function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'pembelian_id');
    }

    // function pengiriman() : BelongsTo {
    //     return $this->pembelian->;
    // }
    // function detail() : HasMany {
    //     return $this->hasMany(Detailpembelian::class, 'produk_id', 'produk_id')->hasN;

    // }
}
