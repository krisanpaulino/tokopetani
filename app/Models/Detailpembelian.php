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
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id')->withDefault([
            'nama_produk' => 'deleted',
            'gambar' => 'deleted',
        ]);
    }

    function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'pembelian_id');
    }

    static function cartCount($pembeli_id)
    {
        return self::join('pembelian', 'pembelian.pembelian_id', '=', 'detailpembelian.pembelian_id')
            ->join('produk', 'produk.produk_id', '=', 'detailpembelian.produk_id')
            ->where('status_pembelian', '=', 'in cart')
            ->where('pembelian.pembeli_id', '=', $pembeli_id)
            ->count();
    }
    static function detailProduk($pembelian_id)
    {
        return self::join('pembelian', 'pembelian.pembelian_id', '=', 'detailpembelian.pembelian_id')
            ->where('detailpembelian.pembelian_id', '=', $pembelian_id)
            ->get();
    }
    // function pengiriman() : BelongsTo {
    //     return $this->pembelian->;
    // }
    // function detail() : HasMany {
    //     return $this->hasMany(Detailpembelian::class, 'produk_id', 'produk_id')->hasN;

    // }
}
