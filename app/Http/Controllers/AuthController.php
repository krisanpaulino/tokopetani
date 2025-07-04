<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Pembeli;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

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
            'lokasi_id' => 'required',
            'lokasi_string' => 'required',
        ]);
        $lokasi = explode('|', $validated['lokasi_id']);
        $validated['lokasi_id'] = $lokasi[0];
        $validated['city_name'] = $lokasi[1];
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

        return redirect(route('login'))->with('success', 'Registrasi Berhasil, silahkan login menggunakan akun anda.');
    }

    function logout()
    {
        Session::flush();
        return redirect('/');
    }

    //here
    function gantiPassword(Request $request)
    {
        $user = User::find(Session::get('user_id'));
        if (Hash::check($request->current_password, $user->user_password)) {
            $userdata = $request->validate([
                'username' => ['required', Rule::unique('user', 'username')->ignore(Session::get('user_id'), 'user_id')],
                'user_password' => 'required|confirmed:password_confirmation',
                'password_confirmation' => 'required'
            ]);
            unset($userdata['password_confirmation']);
            $userdata['user_password'] = Hash::make($userdata['user_password']);

            $user->update($userdata);
        }
    }
}
