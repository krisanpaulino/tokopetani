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
            <form action="{{ route('profil.update') }}" method="post">
                @csrf
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Nama</th>
                                <td>
                                    <input type="text" name="nama_pembeli"
                                        value="{{ old('nama_pembeli', $pembeli->nama_pembeli) }}"
                                        class="form-control @error('nama_pembeli') is-invalid @enderror"">
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>
                                    <input type="email" name="username"
                                        value="{{ old('username', $pembeli->user->username) }}"
                                        class="form-control @error('username') is-invalid @enderror"">
                                </td>
                            </tr>
                            <tr>
                                <th>No Telp</th>
                                <td>
                                    <input type="text" name="no_telp" value="{{ old('no_telp', $pembeli->no_telp) }}"
                                        class="form-control @error('no_telp') is-invalid @enderror"">
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>
                                    <input type="text"
                                        class="w-100 form-control border-0 py-3 mb-4 @error('alamat_jalan') is-invalid @enderror"
                                        placeholder="Alamat Jalan" name="alamat_jalan"
                                        value="{{ old('alamat_jalan', $pembeli->alamat_jalan) }}">
                                </td>
                            </tr>
                            <tr>
                                <th>Kecamata/Desa/Kelurahan/Kota/Kabupaten/Provinsi</th>
                                <td>
                                    <select id="mySelect2" style="width: 100%" name="lokasi_id">
                                        <option value="">Cari Kota / Kecamatan</option>
                                    </select>
                                    @error('lokasi_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="hidden" name="lokasi_string" value={{ $pembeli->lokasi_id }}
                                        id="stringLokasi">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-start">
                    <button type="submit"
                        class="btn border border-secondary rounded-pill px-3 text-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection
@section('cssplugins')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('jsplugins')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('scripts')
    <script>
        $('#mySelect2').on('change', function(e) {
            var lokasi = $('#mySelect2').val()
            $('#stringLokasi').val($('#mySelect2 option:selected').text());
            // $('#ongkir').empty();
        })
    </script>
@endsection
