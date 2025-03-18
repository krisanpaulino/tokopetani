@extends('template.'.Session::get('type'))
@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>{{ $title }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">Produk</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="animated fadeIn">
            <div class="orders">

                <div class="row">
                    <div class="col-xl-12">
                        <a href="{{ route('produk.tambah') }}" class="btn btn-primary mb-4">Tambah Produk</a>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="box-title">Produk </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-stats order-table ov-h">
                                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="serial">#</th>
                                                <th class="avatar">Produk</th>
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th>Stok</th>
                                                <th>Satuan</th>
                                                <th>Deskripsi</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            @foreach ($produk as $r)
                                                <tr>
                                                    <td class="serial">{{ $no++ }}</td>
                                                    <td class="avatar">
                                                        <div class="round-img"><a href="#"><img class="rounded-circle"
                                                                    src="{{ asset('storage/' . $r->gambar) }}"
                                                                    alt=""></a>
                                                        </div>
                                                    </td>
                                                    <td> <span class="name">{{ $r->nama_produk }}</span> </td>
                                                    <td>{{ number_format($r->harga) }} </td>
                                                    <td><span class="count">{{ $r->stok }}</span></td>
                                                    <td> <span class="product">{{ $r->satuan }}</span> </td>
                                                    <td> <span class="product">{{ $r->deskripsi }}</span> </td>
                                                    <td>
                                                        <a class="badge badge-complete"
                                                            href="{{ route('produk.edit', $r->produk_id) }}">Edit</a>
                                                        <a class="badge badge-danger" href="#" data-target="#hapus"
                                                            data-toggle="modal">Hapus</a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div> <!-- /.table-stats -->
                            </div>
                        </div> <!-- /.card -->
                    </div> <!-- /.col-lg-8 -->

                </div>
            </div>
        </div><!-- .animated -->
        <div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mediumModalLabel">Hapus Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <p>
                                Yakin ingin menghapus produk ?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- .content -->
@endsection
