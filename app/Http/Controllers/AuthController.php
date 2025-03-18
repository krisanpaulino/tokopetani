<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Pembeli;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function loginPage()
    {
        return view('login');
    }
    public function loginPost(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $data = User::where('username', $email)->first();
        if ($data) { //apakah email tersebut ada atau tidak
            if (Hash::check($password, $data->user_password)) {
                Session::put('user_id', $data->user_id);
                Session::put('email', $data->username);
                Session::put('type', $data->user_type);
                Session::put('login_' . $data->user_type, TRUE);
                return redirect(route('dashboard'));
            } else {
                return redirect('login')->with('alert', 'Password anda salah!');
            }
        } else {
            return redirect('login')->with('alert', 'Email anda salah / Belum terdaftar!');
        }
    }
    function registrasiPembeli()
    {
        $provinsi = Province::get();
        $kota = City::get();

        return view('frontend.signup-pembeli', compact('provinsi', 'kota'));
    }
    public function registrasiPost(Request $request)
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
        $userdata = $request->validate([
            'username' => 'required|unique:user,username',
            'user_password' => 'required|confirmed:password_confirmation',
            'password_confirmation' => 'required',
            'user_type' => 'pelanggan'
        ]);
        unset($userdata['password_confirmation']);
        $userdata['user_type'] = 'pembeli';
        // dd($userdata['user_password']);
        $userdata['user_password'] = Hash::make($userdata['user_password']);

        $user = new User();
        $user->fill($userdata);

        $user->save();

        $validated['user_id'] = $user->user_id;
        Pembeli::insert($validated);

        return redirect(route('login'));
    }

    function logout()
    {
        Session::flush();
        return redirect('/');
    }
}
