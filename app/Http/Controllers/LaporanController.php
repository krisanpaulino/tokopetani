<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    function pembelian(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $title = 'Laporan';

        // dd($dari);

        $model = Pembelian::select('*');
        if ($dari != null)
            $model->where(DB::raw('CAST(tanggal_pesan AS DATE)'), '>=', $dari);
        if ($sampai != null)
            $model->where(DB::raw('CAST(tanggal_pesan AS DATE)'), '<=', $sampai);
        $laporan = $model->get();

        if (Session::get('type') == 'petani') {
            $petani = Petani::where('user_id', Session::get('user_id'))->first();
            $pembelian = Pembelian::select('*', DB::raw('SUM(detailpembelian.harga_detail) as total_detail'), DB::raw('SUM(pengiriman.biaya) as total_ongkir'))
                ->join('detailpembelian', 'detailpembelian.pembelian_id', '=', 'pembelian.pembelian_id')
                ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
                ->join('pengiriman', 'pengiriman.pembelian_id', '=', 'pembelian.pembelian_id')
                // ->where('status_pembelian', '=', 'diproses')
                ->where('produk.petani_id', '=', $petani->petani_id)
                ->where('status_pengiriman', '=', 'selesai')
                ->groupBy('pembelian.pembelian_id');
            if ($dari != null)
                $pembelian->where(DB::raw('CAST(tanggal_pesan AS DATE)'), '>=', $dari);
            if ($sampai != null)
                $pembelian->where(DB::raw('CAST(tanggal_pesan AS DATE)'), '<=', $sampai);
            $laporan = $pembelian->get();
        }

        return view('backend.laporan_pembelian', compact('laporan', 'dari', 'sampai', 'title'));
    }

    function cetak(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        // $title = 'Laporan';

        // dd($dari);

        $model = Pembelian::select('*');
        if ($dari != null)
            $model->where(DB::raw('CAST(tanggal_pesan AS DATE)'), '>=', $dari);
        if ($sampai != null)
            $model->where(DB::raw('CAST(tanggal_pesan AS DATE)'), '<=', $sampai);
        $laporan = $model->get();

        if (Session::get('type') == 'petani') {
            $petani = Petani::where('user_id', Session::get('user_id'))->first();
            $pembelian = Pembelian::select('*', DB::raw('SUM(detailpembelian.harga_detail) as total_detail'), DB::raw('SUM(pengiriman.biaya) as total_ongkir'))
                ->join('detailpembelian', 'detailpembelian.pembelian_id', '=', 'pembelian.pembelian_id')

                ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
                ->join('pengiriman', 'pengiriman.pembelian_id', '=', 'pembelian.pembelian_id')
                // ->where('status_pembelian', '=', 'diproses')
                ->where('produk.petani_id', '=', $petani->petani_id)
                ->where('pengiriman.petani_id', '=', $petani->petani_id)
                ->where('status_pengiriman', '=', 'selesai')
                ->groupBy('pembelian.pembelian_id');
            if ($dari != null)
                $pembelian->where(DB::raw('CAST(tanggal_pesan AS DATE)'), '>=', $dari);
            if ($sampai != null)
                $pembelian->where(DB::raw('CAST(tanggal_pesan AS DATE)'), '<=', $sampai);
            $laporan = $pembelian->get();
            // dd($laporan);
        }

        $data = [
            'title' => 'Laporan Pembelian',
            'tanggal' => date('Y-m-d'),
            'laporan' => $laporan,
            'dari' => $dari,
            'sampai' => $sampai
        ];
        $pdf = Pdf::loadView('backend.laporan_pdf', $data);

        return $pdf->download('laporan-pembelian.pdf');
    }
}
