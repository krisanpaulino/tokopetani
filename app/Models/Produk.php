<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'produk_id';
    public $timestamps = false;
    protected $fillable = [
        'nama_produk',
        'petani_id',
        'harga',
        'stok',
        'satuan',
        'gambar',
        'deskripsi',
    ];

    function petani(): BelongsTo
    {
        return $this->belongsTo(Petani::class, 'petani_id', 'petani_id');
    }
}
