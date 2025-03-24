<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Pembeli;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class PembeliController extends Controller
{
    function index()
    {
        $title = 'Data Pembeli';
        $pembeli = Pembeli::all();
        return view('backend.pembeli_index', compact('pembeli', 'title'));
    }
    function edit($id)
    {
        $pembeli = Pembeli::find($id);
        $provinsi = Province::get();
        $kota = City::get();
        $title = 'Edit Pembeli';
        return view('backend.pembeli_edit', compact('pembeli', 'title', 'provinsi', 'kota'));
    }
    function update(Request $request): RedirectResponse
    {

        //Validasi
        $validated = $request->validate([
            'nama_pembeli' => 'required',
            'no_telp' => 'required',
            'alamat_jalan' => 'required',
            'alamat_desa' => 'required',
            'alamat_kota' => 'required',
            'alamat_provinsi' => 'required',
            'alamat_kodepos' => 'required',
        ]);
        $pembeli_id = $request->pembeli_id;
        if (Session::get('type') == 'admin') {
            $pembeli = Pembeli::find($pembeli_id);
            // dd('here');
            $userdata = $request->validate([
                'username' => ['required', Rule::unique('user', 'username')->ignore($pembeli->user->user_id, 'user_id')]
            ]);


            $user = User::find($pembeli->user->user_id);
            $user->update($userdata);
        }
        if (Session::get('type') == 'pembeli') {
            $pembeli = Pembeli::where('user_id', '=', Session::get('user_id'))->first();
            $userdata = $request->validate([
                'username' => ['required', Rule::unique('user', 'username')->ignore(Session::get('user_id'), 'user_id')],
                // 'user_password' => 'required|confirmed:password_confirmation',
                // 'password_confirmation' => 'required'
            ]);
            // unset($userdata['password_confirmation']);
            // $userdata['user_password'] = Hash::make($userdata['user_password']);

            $user = User::find($pembeli->user->user_id);
            $user->update($userdata);
        }
        // $pembeli = Pembeli::find($pembeli_id);
        $pembeli->update($validated);


        return redirect(route('front.profil'));
    }
}
