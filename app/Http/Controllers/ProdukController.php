<?php

namespace App\Http\Controllers;

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
}
