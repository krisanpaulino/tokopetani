<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    function cekStok(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;
        $data['available'] = true;
        if (!Produk::where('produk_id', '=', $id)->where('stok', '>=', $qty)->exists()) {
            $data['available'] = false;
        }
        echo json_encode($data);
    }
}
