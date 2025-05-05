@extends('template.admin')
@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1><a href="{{ route('pembeli.index') }}" class="text-primary">
                                    << pembeli</a>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="{{ route('dashboard') }}">{{ $title }}</a></li>
                                <li><a href="{{ route('pembeli.index') }}">Pembeli</a></li>
                                <li class="active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row d-flex justify-content-center">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Edit Pembeli</strong>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pembeli.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="pembeli_id" value="{{ $pembeli->pembeli_id }}">
                                <div class="form-group mb-4">
                                    <label for="">Nama Pembeli</label>
                                    <input value="{{ old('nama_pembeli', $pembeli->nama_pembeli) }}" type="text"
                                        name="nama_pembeli"
                                        class="form-control @error('nama_pembeli') is-invalid @enderror">
                                    @error('nama_pembeli')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="">No Telp</label>
                                    <input value="{{ old('no_telp', $pembeli->no_telp) }}" type="text" name="no_telp"
                                        class="form-control @error('no_telp') is-invalid @enderror">
                                    @error('no_telp')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <label for="">Email</label>
                                    <input value="{{ old('username', $pembeli->user->username) }}" type="email"
                                        name="username" class="form-control @error('username') is-invalid @enderror">
                                    @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="">Provinsi</label>
                                    <select name="alamat_provinsi" data-placeholder="Pilih Provinsi" class="standardSelect"
                                        tabindex="1">
                                        <option value="" label="default"></option>
                                        @foreach ($provinsi as $r)
                                            <option value="{{ $r->province_id }}"
                                                {{ old('alamat_provinsi', $pembeli->alamat_provinsi) == $r->province_id ? 'selected' : '' }}>
                                                {{ $r->province }}</option>
                                        @endforeach
                                    </select>
                                    @error('petani_tempatlahir')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <label for="">Kota/Kabupaten</label>
                                    <select name="alamat_kota" data-placeholder="Pilih Kota" class="standardSelect"
                                        tabindex="1">
                                        <option value="" label="default"></option>
                                        @foreach ($kota as $r)
                                            <option value="{{ $r->city_id }}"
                                                {{ old('alamat_kota', $pembeli->alamat_kota) == $r->city_id ? 'selected' : '' }}>
                                                {{ $r->city }}</option>
                                        @endforeach
                                    </select>
                                    @error('petani_tempatlahir')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="">Alamat Desa</label>
                                    <input value="{{ old('alamat_desa', $pembeli->alamat_desa) }}" type="text"
                                        name="alamat_desa" class="form-control @error('alamat_desa') is-invalid @enderror">
                                    @error('alamat_desa')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="">Alamat Jalan</label>
                                    <input value="{{ old('alamat_jalan', $pembeli->alamat_jalan) }}" type="text"
                                        name="alamat_jalan"
                                        class="form-control @error('alamat_jalan') is-invalid @enderror">
                                    @error('alamat_jalan')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="">Kode Pos</label>
                                    <input value="{{ old('alamat_kodepos', $pembeli->alamat_kodepos) }}" type="text"
                                        name="alamat_kodepos"
                                        class="form-control @error('alamat_kodepos') is-invalid @enderror">
                                    @error('alamat_kodepos')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if (Session::get('type') == 'pembeli')
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Ganti Password</strong>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('pembeli.insert') }}" method="post">
                                    @csrf
                                    <div class="form-group mb-4">
                                        <label for="">Password Sekarang</label>
                                        <input value="{{ old('current_password') }}" type="password"
                                            name="current_password"
                                            class="form-control @error('current_password') is-invalid @enderror">
                                        @error('current_password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="">Password</label>
                                        <input value="{{ old('user_password') }}" type="password" name="user_password"
                                            class="form-control @error('user_password') is-invalid @enderror">
                                        @error('user_password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="">Konfirmasi Password</label>
                                        <input value="{{ old('password_confirmation') }}" type="password"
                                            name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror">
                                        @error('password_confirmation')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Ganti Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
