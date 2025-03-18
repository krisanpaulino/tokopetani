@extends('front');
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Signup</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4 d-flex justify-content-center">
                    <div class="col-12">
                        <div class="text-center mx-auto" style="max-width: 700px;">
                            <h1 class="text-primary">Sign Up</h1>
                            <p class="mb-4">Daftar sekarang untuk melakukan transaksi!</p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('signup.post') }}" method="post" class="">
                            @csrf
                            <input type="text"
                                class="w-100 form-control border-0 py-3 mb-4 @error('nama_pembeli') is-invalid @enderror"
                                placeholder="Nama Lengkap" name="nama_pembeli" value="{{ old('nama_pembeli') }}">
                            @error('nama_pembeli')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <input type="email"
                                class="w-100 form-control border-0 py-3 mb-4 @error('username') is-invalid @enderror"
                                placeholder="Email" name="username" value="{{ old('username') }}">
                            @error('username')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <input type="text"
                                class="w-100 form-control border-0 py-3 mb-4 @error('no_telp') is-invalid @enderror"
                                placeholder="No HP" name="no_telp" value="{{ old('no_telp') }}">
                            @error('no_telp')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <input type="text"
                                class="w-100 form-control border-0 py-3 mb-4 @error('alamat_jalan') is-invalid @enderror"
                                placeholder="Alamat Jalan" name="alamat_jalan" value="{{ old('alamat_jalan') }}">
                            @error('alamat_jalan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <input type="text"
                                class="w-100 form-control border-0 py-3 mb-4 @error('alamat_desa') is-invalid @enderror"
                                placeholder="Desa/Kelurahan" name="alamat_desa" value="{{ old('alamat_desa') }}">
                            @error('alamat_desa')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <select type="text"
                                class="w-100 form-control border-0 py-3 mb-4 @error('alamat_provinsi') is-invalid @enderror"
                                placeholder="Provinsi" name="alamat_provinsi" >
                            <option value="">Provinsi</option>
                            @foreach ($provinsi as $r)
                                <option value="{{ $r->province_id }}" {{(old('alamat_provinsi') == $r->province_id) ? 'selected' : ''}}>{{ $r->province }}</option>
                            @endforeach
                            </select>
                            @error('alamat_provinsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <select type="text"
                            class="w-100 form-control border-0 py-3 mb-4 @error('alamat_kota') is-invalid @enderror"
                            placeholder="Provinsi" name="alamat_kota" >
                            <option value="">Kota</option>
                            @foreach ($kota as $r)
                                <option value="{{ $r->city_id }}" {{(old('alamat_kota') == $r->city_id) ? 'selected' : ''}}>{{ $r->city }}</option>
                            @endforeach
                            </select>
                            @error('alamat_kota')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <input type="text"
                                class="w-100 form-control border-0 py-3 mb-4 @error('alamat_kodepos') is-invalid @enderror"
                                placeholder="Kode Pos" name="alamat_kodepos" value="{{ old('alamat_kodepos') }}">
                            @error('alamat_kodepos')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <hr>
                            <input type="password"
                                class="w-100 form-control border-0 py-3 mb-4 @error('user_password') is-invalid @enderror"
                                placeholder="Password" name="user_password" value="{{ old('user_password') }}">
                            @error('user_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <input type="password"
                                class="w-100 form-control border-0 py-3 mb-4 @error('password_confirmation') is-invalid @enderror"
                                placeholder="Konfirmasi Password" name="password_confirmation"
                                value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary "
                                type="submit">Signup</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
