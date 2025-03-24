@extends('front');
@section('content')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Profil</h1>
</div>
<!-- Single Page Header End -->
<!-- Cart Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
       <form action="{{route('profil.update')}}" method="post">
        @csrf
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Nama</th>
                        <td>
                            <input type="text" name="nama_pembeli" value="{{old('nama_pembeli',$pembeli->nama_pembeli)}}" class="form-control @error('nama_pembeli') is-invalid @enderror"">
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>
                            <input type="email" name="username" value="{{old('username',$pembeli->user->username)}}" class="form-control @error('username') is-invalid @enderror"">
                        </td>
                    </tr>
                    <tr>
                        <th>No Telp</th>
                        <td>
                            <input type="text" name="no_telp" value="{{old('no_telp',$pembeli->no_telp)}}" class="form-control @error('no_telp') is-invalid @enderror"">
                        </td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>
                            <input type="text" name="alamat_jalan" value="{{old('alamat_jalan',$pembeli->alamat_jalan)}}" class="form-control @error('alamat_jalan') is-invalid @enderror"">
                        </td>
                    </tr>
                    <tr>
                        <th>Desa/Kelurahan</th>
                        <td>
                            <input type="text" name="alamat_desa" value="{{old('alamat_desa',$pembeli->alamat_desa)}}" class="form-control @error('alamat_desa') is-invalid @enderror"">
                        </td>
                    </tr>
                    <tr>
                        <th>Kota</th>
                        <td>
                            <select type="text"
                            class="w-100 form-control border-0 py-3 mb-4 @error('alamat_kota') is-invalid @enderror"
                            placeholder="Provinsi" name="alamat_kota" >
                            <option value="">Kota</option>
                            @foreach ($kota as $r)
                                <option value="{{ $r->city_id }}" {{(old('alamat_kota', $pembeli->alamat_kota) == $r->city_id) ? 'selected' : ''}}>{{ $r->city }}</option>
                            @endforeach
                            </select>
                            @error('alamat_kota')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <th>Provinsi</th>
                        <td>
                            <select type="text"
                            class="w-100 form-control border-0 py-3 mb-4 @error('alamat_provinsi') is-invalid @enderror"
                            placeholder="Provinsi" name="alamat_provinsi" >
                            <option value="">Provinsi</option>
                            @foreach ($provinsi as $r)
                                <option value="{{ $r->province_id }}" {{(old('alamat_provinsi', $pembeli->alamat_provinsi) == $r->province_id) ? 'selected' : ''}}>{{ $r->province }}</option>
                            @endforeach
                            </select>
                            @error('alamat_provinsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <th>Kode Pos</th>
                        <td>
                            <input type="text" name="alamat_kodepos" value="{{old('alamat_kodepos',$pembeli->alamat_kodepos)}}" class="form-control @error('alamat_kodepos') is-invalid @enderror"">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-start">
            <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">Simpan</button>
        </div>
       </form>
    </div>
</div>
<!-- Cart Page End -->
@endsection
