@extends('template.admin')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('#') }}">{{ $title }}</a></li>
                            <li><a href="{{ url('petani.index') }}">Petani</a></li>
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
                        <strong class="card-title">Edit Petani</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{route('petani.update')}}" method="post">
                            @csrf
                            <input type="hidden" name="petani_id" value="{{$petani->petani_id}}">
                            <div class="form-group mb-4">
                                <label for="">Petani Nama</label>
                                <input value="{{ old('petani_nama', $petani->petani_nama) }}" type="text" name="petani_nama" class="form-control @error('petani_nama') is-invalid @enderror">
                                @error('petani_nama')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="">Jenis Kelamin</label>
                                <select name="petani_jk" data-placeholder="Pilih Jenis Kelamin" class="standardSelect" tabindex="1">
                                    <option value="" label="default"></option>
                                    <option value="L" {{ (old('petani_jk', $petani->petani_jk) == 'L') ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="P" {{ (old('petani_jk', $petani->petani_jk) == 'P') ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('petani_tempatlahir')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Tempat Lahir</label>
                                <input value="{{ old('petani_tempatlahir', $petani->petani_tempatlahir) }}" type="text" name="petani_tempatlahir" class="form-control @error('petani_tempatlahir') is-invalid @enderror">
                                @error('petani_tempatlahir')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Tanggal Lahir</label>
                                <input value="{{ old('petani_tgllahir', $petani->petani_tgllahir) }}" type="date" name="petani_tgllahir" class="form-control @error('petani_tgllahir') is-invalid @enderror">
                                @error('petani_tgllahir')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Petani HP</label>
                                <input value="{{ old('petani_hp', $petani->petani_hp) }}" type="text" name="petani_hp" class="form-control @error('petani_hp') is-invalid @enderror">
                                @error('petani_hp')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Alamat</label>
                                <input value="{{ old('petani_alamat', $petani->petani_alamat) }}" type="text" name="petani_alamat" class="form-control @error('petani_alamat') is-invalid @enderror">
                                @error('petani_alamat')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Email</label>
                                <input value="{{ old('username', $petani->user->username) }}" type="email" name="username" class="form-control @error('username') is-invalid @enderror">
                                @error('username')
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
            @if (Session::get('type') == 'petani')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Ganti Password</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{route('petani.insert')}}" method="post">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="">Password Sekarang</label>
                                <input value="{{ old('current_password') }}" type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Password</label>
                                <input value="{{ old('user_password') }}" type="password" name="user_password" class="form-control @error('user_password') is-invalid @enderror">
                                @error('user_password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Konfirmasi Password</label>
                                <input value="{{ old('password_confirmation') }}" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
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
