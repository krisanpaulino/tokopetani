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
                        <div class="card">
                            <div class="card-body">
                                <h4 class="box-title">{{$title}}</h4>
                             @isset($petani)
                                <span>Nama Petani : {{$petani->petani_nama}}</span>
                             @endisset
                            </div>
                            <div class="card-body">
                                <br>
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
                                                <th>Petani</th>
                                                {{-- <th>Action</th> --}}
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
                                                    <td> <span class="product">{{ $r->petani->petani_nama }}</span> </td>
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
    </div><!-- .content -->
@endsection
