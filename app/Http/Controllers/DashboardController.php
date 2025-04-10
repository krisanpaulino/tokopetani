<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

            $sampai = date('Y-m-d');
            $dari = date('Y-m-d', strtotime($sampai . ' - 7 days'));

            $pembelian = Pembelian::select([DB::raw('CAST(tanggal_pesan AS DATE) as tanggal'), DB::raw('count(pembelian_id) as jumlah')])->where(DB::raw('CAST(tanggal_pesan AS DATE)'), '<=', $sampai)->where(DB::raw('CAST(tanggal_pesan AS DATE)'), '>=', $dari)->groupBy('tanggal')->get();
            // dd($pembelian);

            return view('backend.dashboard-admin', compact('title', 'diproses', 'masuk', 'selesai', 'pembelian'));
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

            $pembelian = Pembelian::select([DB::raw('CAST(tanggal_pesan AS DATE) as tanggal'), DB::raw('count(pembelian.pembelian_id) as jumlah')])->join('detailpembelian', 'detailpembelian.pembelian_id', '=', 'pembelian.pembelian_id')
                ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
                ->where('produk.petani_id', '=', $user->petani->petani_id)
                ->groupBy('tanggal')->get();
            return view('backend.dashboard-petani', compact('title', 'diproses', 'masuk', 'selesai', 'pembelian'));
        } else {
            return  redirect('/');
        }
    }
}
