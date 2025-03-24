<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    function index()
    {
        // dd(Session::get('type'));
        $title = 'Dashboard';
        if (Session::get('type') == 'admin') {
            //Jumlah pesanan masuk
            $masuk = Pembelian::where('status_pembelian', '=', 'verifikasi pembayaran')->count('pembelian_id');
            // dd($pembelian);
            //Total pesanan diproses
            $diproses = Pembelian::where('status_pembelian', '=', 'diproses')->count('pembelian_id');
            //Total pesanan selesai
            $selesai = Pembelian::where('status_pembelian', '=', 'selesai')->count('pembelian_id');

            return view('backend.dashboard-admin', compact('title', 'diproses', 'masuk', 'selesai'));
        } elseif (Session::get('type') == 'petani') {
            $user = User::find(Session::get('user_id'));
            $masuk = Pembelian::join('detailpembelian', 'detailpembelian.pembelian_id', '=', 'pembelian.pembelian_id')
                ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
                ->where('status_pembelian', '=', 'diproses')
                ->where('produk.petani_id', '=', $user->petani->petani_id)
                ->groupBy('pembelian.pembelian_id')
                ->count();
            $diproses = Pembelian::join('detailpembelian', 'detailpembelian.pembelian_id', '=', 'pembelian.pembelian_id')
                ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
                ->join('pengiriman', 'pengiriman.pembelian_id', '=', 'pembelian.pembelian_id')
                // ->where('status_pembelian', '=', 'diproses')
                ->where('produk.petani_id', '=', $user->petani->petani_id)
                ->where('status_pengiriman', '=', 'dikirim')
                ->groupBy('pembelian.pembelian_id')
                ->count();
            $selesai = Pembelian::join('detailpembelian', 'detailpembelian.pembelian_id', '=', 'pembelian.pembelian_id')
                ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
                ->join('pengiriman', 'pengiriman.pembelian_id', '=', 'pembelian.pembelian_id')
                // ->where('status_pembelian', '=', 'diproses')
                ->where('produk.petani_id', '=', $user->petani->petani_id)
                ->where('status_pengiriman', '=', 'selesai')
                ->groupBy('pembelian.pembelian_id')
                ->count();
            return view('backend.dashboard-petani', compact('title', 'diproses', 'masuk', 'selesai'));
        } else {
            return  redirect('/');
        }
    }
}
