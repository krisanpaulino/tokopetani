<?php

namespace App\Http\Controllers;

use App\Models\Petani;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetaniController extends Controller
{
    function index()
    {
        $title = 'Data Petani';
        $petani = Petani::all();
        return view('backend.petani_index', compact('petani', 'title'));
    }
    function view($id)
    {
        $petani = Petani::find($id);
        $title = 'Detail Petani';
        return view('backend.petani_detail', compact('petani', 'title'));
    }
    function tambah()
    {
        // $petani = Petani::find($id);
        $title = 'Tambah Petani';
        return view('backend.petani_tambah', compact('title'));
    }
    function insert(Request $request): RedirectResponse
    {

        //Validasi
        $validated = $request->validate([
            'petani_nama' => 'required',
            'petani_hp' => 'required',
            'petani_jk' => 'required',
            'petani_tempatlahir' => 'required',
            'petani_tgllahir' => 'required',
            'petani_alamat' => 'required',

        ]);
        $userdata = $request->validate([
            'username' => 'required|unique:user,username',
            'user_password' => 'required|confirmed:password_confirmation',
            'password_confirmation' => 'required'
        ]);
        unset($userdata['password_confirmation']);
        $userdata['user_type'] = 'petani';
        // dd($userdata['user_password']);
        $userdata['user_password'] = Hash::make($userdata['user_password']);

        $user = new User();
        $user->fill($userdata);

        $user->save();

        $validated['user_id'] = $user->user_id;
        Petani::insert($validated);

        return redirect(route('petani.tambah'));
    }
}
