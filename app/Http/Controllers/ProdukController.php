<?php

namespace App\Http\Controllers;

use App\Models\Detailpembelian;
use App\Models\Pembelian;
use App\Models\Petani;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProdukController extends Controller
{
    function index()
    {
        $title = 'Data Produk';
        $user = User::where('username', Session::get('email'))->first();

        $produk = Produk::where('petani_id', $user->petani->petani_id)->get();
        return view('backend.produk_index', compact('produk', 'title'));
    }
    function tambah()
    {
        // $petani = Petani::find($id);
        $title = 'Tambah Produk';
        return view('backend.produk_tambah', compact('title'));
    }
    function edit($id)
    {
        $produk = Produk::find($id);
        $title = 'Edit Produk';
        return view('backend.produk_edit', compact('title', 'produk'));
    }
    function insert(Request $request): RedirectResponse
    {
        $user = User::where('username', Session::get('email'))->first();

        //Validasi
        $validated = $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'satuan' => 'required',
            'deskripsi' => 'required',
        ]);
        $validated['harga'] = str_replace(',', '', $validated['harga']);
        $path = $request->file('gambar')->storePublicly('produk', 'public');
        $validated['gambar'] = $path;
        $validated['petani_id'] = $user->petani->petani_id;


        Produk::insert($validated);

        return redirect(route('produk.index'));
    }
    function update(Request $request): RedirectResponse
    {
        $user = User::where('username', Session::get('email'))->first();
        $produk_id = $request->produk_id;
        //Validasi
        $validated = $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'satuan' => 'required',
            'deskripsi' => 'required',
        ]);
        $validated['harga'] = str_replace(',', '', $validated['harga']);
        if ($request->file('gambar') != null) {
            $path = $request->file('gambar')->storePublicly('produk', 'public');
            $validated['gambar'] = $path;
        }


        $produk = Produk::find($produk_id);
        $produk->fill($validated);
        $produk->save();

        return redirect(route('produk.index'));
    }
    function updateStok(Request $request)
    {
        $produk_id = $request->produk_id;
        $produk = Produk::find($produk_id);
        $stok = $request->stok;
        $produk->increment('stok', $stok);
        return redirect(route('produk.index'));
    }

    function delete(Request $request)
    {
        $produk_id = $request->produk_id;
        $detail = Detailpembelian::join('produk', 'produk.produk_id', '=', 'detailpembelian.produk_id')
            ->join('pembelian', 'pembelian.pembelian_id', '=', 'detailpembelian.pembelian_id')
            ->where('status_pembelian', '=', 'in cart')
            ->get();
        foreach ($detail as $key => $data) {
            if ($data->pembelian != null) {
                $data->pembelian->decrement('total_bayar', $data->produk->harga);
                if ($data->pembelian->total_harga == 0)
                    Pembelian::destroy($data->pembelian_id);
            }
        }

        Produk::destroy($produk_id);
        return back()->with('success', 'Data produk berhasil dihapus')->with('message', 'successToast("Data produk berhasil dihapus")');
    }

    //Untuk Admin
    function tersedia()
    {
        $title = 'Produk Tersedia';
        $produk = Produk::where('stok', '>', '0')->get();

        return view('backend.produk_tersedia', compact('title', 'produk'));
    }

    function byPetani($petani_id)
    {
        $petani = Petani::find($petani_id);
        $produk = Produk::where('petani_id', '=', $petani_id)->get();
        $title = 'Produk Petani';
        $back = 'petani.index';

        return view('backend.produk_tersedia', compact('title', 'produk', 'petani', 'back'));
    }
}
