<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Detailpembelian;
use App\Models\Lokasitoko;
use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\Pembeli;
use App\Models\Pembelian;
use App\Models\Pengiriman;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    function index()
    {
        $title = 'Home Page';
        $produk = Produk::join('petani', 'petani.petani_id', '=', 'produk.petani_id')
            ->where('produk.stok', '>', '0')->paginate(12);
        return view('frontend.home', compact('title', 'produk'));
    }

    function search(Request $request)
    {
        $title = 'Search';
        $keyword = $request->keyword;
        $produk = Produk::where('nama_produk', 'LIKE', "%{$keyword}%")->orderBy('produk_id', 'desc')->paginate(12);
        return view('frontend.home', compact('title', 'produk', 'keyword'));
    }

    function orderPost(Request $request): RedirectResponse
    {
        // $cart =
        //Validasi
        $validated = $request->validate([
            'produk_id' => 'required',
            'jumlah_beli' => 'required'
        ]);

        //Cek Stok
        if (!Produk::where('produk_id', "=", $validated['produk_id'])->where('stok', '>=', $validated['jumlah_beli'])->exists()) {
            return back()->with('message', "dangerToast('Pesanan tidak boleh melebihi stok');");
        }

        $produk = Produk::find($validated['produk_id']);
        // $produk->decrement('stok', $validated['jumlah_beli']);
        // Petani::insert($validated);

        $pembeli = Pembeli::where('user_id', '=', Session::get('user_id'))->first();

        $totalbayar = $produk->harga * $validated['jumlah_beli'];
        $data['pembeli_id'] = $pembeli->pembeli_id;

        $pembelian = Pembelian::where('pembeli_id', '=', $data['pembeli_id'])->where('status_pembelian', '=', 'in cart')->first();

        if ($pembelian) {
            $pembelian->increment('total_bayar', $totalbayar);
            $pembelian->update($data);
        } else {
            $data['status_pembelian'] = 'in cart';
            $data['total_bayar'] = $totalbayar;
            $pembelian = new Pembelian();
            $pembelian->fill($data);
            $pembelian->save();
        }
        $validated['pembelian_id'] = $pembelian->pembelian_id;
        $validated['harga_detail'] = $totalbayar;
        Detailpembelian::insert($validated);

        return back();
    }

    function cart()
    {
        $pembeli = Pembeli::where('user_id', '=', Session::get('user_id'))->first();
        $pembelian = Pembelian::where('pembeli_id', '=', $pembeli->pembeli_id)->where('status_pembelian', '=', 'in cart')->first();
        if ($pembelian != null) {
            $detail = Detailpembelian::join('produk', 'produk.produk_id', '=', 'detailpembelian.produk_id')->where('pembelian_id', '=', $pembelian->pembelian_id)->get();
            if ($detail == null)
                $pembelian->destroy();
        } else
            $detail = null;
        // dd($pembeli);

        return view('frontend.cart', compact('pembelian', 'detail'));
    }
    function deleteCart(Request $request): RedirectResponse
    {

        $detailpembelian_id  = $request->detailpembelian_id;
        $datadetail = Detailpembelian::find($detailpembelian_id);

        Pembelian::where('pembelian_id', $datadetail->pembelian_id)->decrement('total_bayar', $datadetail->harga_detail);
        Detailpembelian::destroy($detailpembelian_id);
        return back();
    }
    function checkout($pembelian_id)
    {
        $pembeli = Pembeli::where('user_id', '=', Session::get('user_id'))->first();
        $pembelian = Pembelian::find($pembelian_id);

        //Pisahkan Petani
        $petani = DB::table('detailpembelian')
            ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
            ->join('petani', 'produk.petani_id', '=', 'petani.petani_id')
            ->where('detailpembelian.pembelian_id', '=', $pembelian_id)->groupBy('produk.petani_id')->get();
        // dd($petani);
        foreach ($petani as $key => $p) {
            $detail = Detailpembelian::join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')->where('petani_id', $p->petani_id)->where('detailpembelian.pembelian_id', '=', $pembelian_id)->groupBy('produk.petani_id')->get();
            $petani[$key]->detail = $detail;
        }
        // $petani = Petani::whereIn('')
        // $detail = Detailpembelian::where('pembelian_id', '=', $pembelian_id)->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')->groupBy('petani_id')->get();
        $sumBerat = Detailpembelian::sum('jumlah_beli');

        $destination = $pembeli->lokasi_id;


        //Lokasi Toko
        $lokasi = Lokasitoko::first();

        //Lokasi Pembeli

        $curl = curl_init();
        //         curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_POSTFIELDS => array(
                'origin' => '35096',
                'destination' => $destination,
                'weight' => 1000,
                'courier' => 'lion'
            ),
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "key: 6f236992378c17b751f3b051fbe73779"
            )
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        }
        $array_response = json_decode($response, TRUE);
        $ongkir = $array_response["data"];
        if ($pembeli->city_name == $lokasi->city_name) {
            $ongkir[] = [
                'cost' => 10000,
                'etd' => '0 day',
                'name' => 'Jasa Kirim Toko',
                'description' => 'Berlaku dalam kota yang sama',
            ];
        }
        // dd($array_response);

        // $detail = Detailpembelian::where('pembelian_id', '=', $pembelian->pembelian_id)->get();
        // $pembelian->status_pembelian = 'menunggu pembayaran';
        // $pembelian->ongkir = $data['ongkir'];
        // $pembelian->save();
        // return redirect(route('payment'));
        return view('frontend.checkout', compact('ongkir', 'pembelian', 'pembeli', 'petani'));
    }

    function placeOrder(Request $request): RedirectResponse
    {

        $pembelian_id = $request->pembelian_id;
        $pembelian = Pembelian::find($pembelian_id);
        $pembelian->status_pembelian = 'menunggu pembayaran';
        $now = date('Y-m-d H:i:s');
        $batas = strtotime($now . ' +1 day');
        $pembelian->batas_bayar = $batas;
        $ongkir = $request->ongkir;
        $totalongkir = 0;
        foreach ($ongkir as $key => $o) {
            $arr = explode('|', $o);
            $totalongkir += $arr[0];
            $estimasi = $arr[1];
            $data = [
                'pembelian_id' => $pembelian_id,
                'kurir' => 'JNE',
                'petani_id' => $key,
                'biaya' => $arr[0],
                'estimasi' => $estimasi
            ];
            Pengiriman::insert($data);
        }
        $pembelian->ongkir = $totalongkir;
        $pembelian->save();

        foreach ($pembelian->detailpembelian as $key => $detail) {
            $produk = Produk::find($detail->produk_id);
            $produk->decrement('stok', $detail->jumlah_beli);
        }

        return redirect(route('order.detail', $pembelian_id));
    }

    function detail($pembelian_id)
    {
        $pembeli = Pembeli::where('user_id', '=', Session::get('user_id'))->first();
        $pembelian = Pembelian::find($pembelian_id);

        //Pisahkan Petani
        $petani = Detailpembelian::join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
            ->join('petani', 'produk.petani_id', '=', 'petani.petani_id')
            ->where('detailpembelian.pembelian_id', '=', $pembelian_id)->groupBy('produk.petani_id')->get();
        // dd($petani);
        foreach ($petani as $key => $p) {
            $detail = Detailpembelian::join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')->where('petani_id', $p->petani_id)->where('detailpembelian.pembelian_id', '=', $pembelian_id)->groupBy('produk.petani_id')->get();
            $petani[$key]->detail = $detail;
        }
        // $pembelian = Pembelian::find($pembelian_id);
        // $pembeli = Pembeli::where('user_id', '=', Session::get('user_id'))->first();

        if ($pembelian->status_pembelian == 'in cart')
            return redirect(route('cart'));
        // $detail = $pembelian

        return view('frontend.orderdetail', compact('pembelian', 'pembeli',  'petani'));
    }

    function uploadBukti(Request $request)
    {
        $pembelian_id = $request->pembelian_id;
        $pembelian = Pembelian::find($pembelian_id);
        $path = $request->file('bukti')->storePublicly('bukti', 'public');
        $data = [
            'pembelian_id' => $pembelian_id,
            'metode_bayar' => 'transfer',
            'jumlah_bayar' => $pembelian->jumlah_bayar + $pembelian->ongkir,
            'bukti_bayar' => $path,
        ];
        $pembayaran = Pembayaran::where('pembelian_id', '=', $pembelian_id)->first();
        if ($pembayaran == null) {
            $pembayaran = new Pembayaran();
            $pembayaran->fill($data);
            $pembayaran->save();
        } else {
            $pembayaran->update($data);
        }
        $pembelian->status_pembelian = 'verifikasi pembayaran';
        $pembelian->save();
        return back()->with('message', "successToast('pembayaran diterima, menunggu verifikasi')");
    }

    function orderList()
    {

        $pembeli = Pembeli::where('user_id', '=', Session::get('user_id'))->first();
        $pembelian = Pembelian::where('pembeli_id', $pembeli->pembeli_id)->orderBy('tanggal_pesan', 'desc')->get();
        return view('frontend.order-list', compact('pembelian', 'pembeli'));
    }
    function profil()
    {
        $title = 'Profil';
        $user = User::find(Session::get('user_id'));
        return view('frontend.profil', compact('user', 'title'));
    }
    function editProfil()
    {
        $title = 'Edit Profil';
        $user = User::find(Session::get('user_id'));
        $provinsi = Province::get();
        $kota = City::get();
        $pembeli = Pembeli::where('user_id', '=', Session::get('user_id'))->first();
        return view('frontend.profil-edit', compact('user', 'title', 'pembeli', 'provinsi', 'kota'));
    }
    function komplain(Request $request)
    {
        $pembelian_id = $request->pembelian_id;
        $pembelian = Pembelian::find($pembelian_id);
        $pembelian->status_pembelian = 'belum diterima';
        $pembelian->save();
        return back()->with('message', "successToast('Komplain berhasil dikirim, silahkan menunggu respon admin')");
    }
}
