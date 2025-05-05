@extends('template.' . Session::get('type'))
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
                                <li><a href="{{ url(Session::get('type') . '.produk.index') }}">Produk</a></li>
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
                            <strong class="card-title">Edit Produk</strong>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('produk.update') }}" method="post" enctype="multipart/form-data">

                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->produk_id }}">
                                <div class="form-group mb-4">
                                    <label for="">Nama Produk</label>
                                    <input value="{{ old('nama_produk', $produk->nama_produk) }}" type="text"
                                        name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror">
                                    @error('nama_produk')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <label for="">Harga</label>
                                    <input value="{{ old('harga', number_format($produk->harga)) }}" type="text"
                                        pattern="\d+((\.|,)\d+)?" name="harga"
                                        class="form-control just-number price-format-input @error('harga') is-invalid @enderror">
                                    @error('harga')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <label for="">Satuan</label>
                                    <input value="{{ old('satuan', $produk->satuan) }}" type="text" name="satuan"
                                        class="form-control @error('satuan') is-invalid @enderror">
                                    @error('satuan')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <label for="">Stok</label>
                                    <input value="{{ old('stok', $produk->stok) }}" type="number" name="stok"
                                        class="form-control @error('stok', $produk->stok) is-invalid @enderror">
                                    @error('stok')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <label for="">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="">Gambar</label>
                                    <input value="{{ old('gambar') }}" type="file" name="gambar"
                                        class="form-control @error('gambar') is-invalid @enderror">
                                    @error('gambar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
@section('scripts')
    <script>
        $(document).on("keypress", ".just-number", function(e) {
            let charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
        });
        $(document).on('keyup', '.price-format-input', function(e) {
            let val = this.value;
            val = val.replace(/,/g, "");
            if (val.length > 3) {
                let noCommas = Math.ceil(val.length / 3) - 1;
                let remain = val.length - (noCommas * 3);
                let newVal = [];
                for (let i = 0; i < noCommas; i++) {
                    newVal.unshift(val.substr(val.length - (i * 3) - 3, 3));
                }
                newVal.unshift(val.substr(0, remain));
                this.value = newVal;
            } else {
                this.value = val;
            }
        });
    </script>
@endsection
