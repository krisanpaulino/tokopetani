<?php

namespace App\Http\Controllers;

use App\Models\Detailpembelian;
use App\Models\Pembelian;
use App\Models\Pengiriman;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
    protected $user;
    function __construct()
    {
        $this->user = User::where('username', Session::get('email'))->first();
    }
    function masuk()
    {
        $title = 'Order Masuk';

        if ($this->user->user_type == 'admin')
            $pembelian = Pembelian::where('status_pembelian', '=', 'verifikasi pembayaran')->get();
        else
            $pembelian = Pembelian::join('detailpembelian', 'detailpembelian.pembelian_id', '=', 'pembelian.pembelian_id')
                ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
                ->where('status_pembelian', '=', 'diproses')
                ->where('petani_id', '=', $this->user->petani->petani_id)
                ->groupBy('pembelian.pembelian_id')
                ->get();
        // dd($pembelian);
        return view('backend.order-masuk', compact('pembelian', 'title'));
    }

    function order()
    {
        $title = 'Order';

        if ($this->user->user_type == 'admin')
            $pembelian = Pembelian::get();
        else
            $pembelian = Pembelian::join('detailpembelian', 'detailpembelian.pembelian_id', '=', 'pembelian.pembelian_id')
                ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
                ->where('status_pembelian', '!=', 'menunggu pembayaran')
                ->where('status_pembelian', '!=', 'verifikasi pembayaran')
                ->where('petani_id', '=', $this->user->petani->petani_id)
                ->groupBy('pembelian.pembelian_id')
                ->get();
        // dd($pembelian);
        return view('backend.order-masuk', compact('pembelian', 'title'));
    }

    function detail($id)
    {
        $title = 'Detail Order';
        $pembelian = Pembelian::find($id);
        $detail = Detailpembelian::join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
            ->where('petani_id', '=', $this->user->petani->petani_id)->where('pembelian_id', '=', $id)->get();
        $subtotal = Detailpembelian::join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
            ->where('petani_id', '=', $this->user->petani->petani_id)->where('pembelian_id', '=', $id)->sum(DB::raw('jumlah_beli * harga'));
        $ongkir = Pengiriman::where('petani_id', '=', $this->user->petani->petani_id)
            ->where('pembelian_id', '=', $id)
            ->first();
        $total = $subtotal + $ongkir->biaya;
        return view('backend.order-detail', compact('pembelian', 'detail', 'ongkir', 'total', 'title'));
    }
    function detailAdmin($id)
    {
        $title = 'Detail Order';
        $pembelian = Pembelian::find($id);
        $detail = $pembelian->detailpembelian;
        // $detail = Detailpembelian::join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
        //     ->where('pembelian_id', '=', $id)->get();
        // dd($detail);
        $ongkir = new Pengiriman();
        $ongkir->biaya = $pembelian->ongkir;
        $total = $pembelian->ongkir + $pembelian->total_bayar;
        return view('backend.order-detail', compact('pembelian', 'detail', 'ongkir', 'total', 'title'));
    }
    function diproses()
    {
        $title = 'Order Diproses';

        if ($this->user->user_type == 'admin')
            $pembelian = Pembelian::where('status_pembelian', '=', 'diproses')->get();
        else
            $pembelian = Pembelian::join('detailpembelian', 'detailpembelian.pembelian_id', '=', 'pembelian.pembelian_id')
                ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
                ->join('pengiriman', 'pengiriman.pembelian_id', '=', 'pembelian.pembelian_id')
                // ->where('status_pembelian', '=', 'diproses')
                ->where('produk.petani_id', '=', $this->user->petani->petani_id)
                ->where('status_pengiriman', '=', 'dikirim')
                ->groupBy('pembelian.pembelian_id')
                ->get();
        // dd($pembelian);
        return view('backend.order-masuk', compact('pembelian', 'title'));
    }
    function selesai()
    {
        $title = 'Order Selesai';

        if ($this->user->user_type == 'admin')
            $pembelian = Pembelian::where('status_pembelian', '=', 'selesai')->get();
        else
            $pembelian = Pembelian::join('detailpembelian', 'detailpembelian.pembelian_id', '=', 'pembelian.pembelian_id')
                ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
                ->join('pengiriman', 'pengiriman.pembelian_id', '=', 'pembelian.pembelian_id')
                // ->where('status_pembelian', '=', 'diproses')
                ->where('produk.petani_id', '=', $this->user->petani->petani_id)
                ->where('status_pengiriman', '=', 'selesai')
                ->groupBy('pembelian.pembelian_id')
                ->get();
        // dd($pembelian);
        return view('backend.order-masuk', compact('pembelian', 'title'));
    }

    function kirimPost(Request $request): RedirectResponse
    {
        $pembelian_id = $request->pembelian_id;
        $user = User::where('username', Session::get('email'))->first();
        $pengiriman =  Pengiriman::where('petani_id', '=', $user->petani->petani_id)
            ->where('pembelian_id', '=', $pembelian_id)
            ->first();
        dd($request->estimasi);
        $pengiriman->status_pengiriman = 'dikirim';
        $pengiriman->resi = $request->resi;
        $pengiriman->estimasi = $request->estimasi;
        $pengiriman->update();
        return back()->with('message', 'succesToast("Berhasil proses pengiriman")');
    }
    function prosesPost(Request $request)
    {
        $pembelian_id = $request->pembelian_id;
        $pembelian = Pembelian::find($pembelian_id);
        $pembelian->status_pembelian = 'diproses';
        $pembelian->update();

        Pengiriman::where('pembelian_id', '=', $pembelian_id)->update(['status_pengiriman' => 'dikemas']);
        return back()->with('message', 'succesToast("Berhasil proses pengiriman")');
    }
    function selesaiPost(Request $request)
    {
        $pembelian_id = $request->pembelian_id;
        $pengiriman =  Pengiriman::where('petani_id', '=', $this->user->petani->petani_id)
            ->where('pembelian_id', '=', $pembelian_id)
            ->first();

        $pengiriman->status_pengiriman = 'selesai';
        $pengiriman->resi = $request->resi;
        $pengiriman->estimasi = $request->estimasi;
        $pengiriman->update();

        if (!Pengiriman::where('pembelian_id', '=', $pembelian_id)->where('status_pengiriman', '=', 'dikirim')->exists()) {
            $pembelian = Pembelian::find($pembelian_id);
            $pembelian->status_pembelian = 'selesai';
            $pembelian->update();
        }
        return back()->with('message', 'succesToast("Berhasil proses selesai")');
    }
}
