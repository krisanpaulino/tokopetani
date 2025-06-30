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
                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="#">Order</a></li>
                                <li class="active">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Data Transaksi</strong>
                        </div>
                        <div class="card-body">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pesan</th>
                                        <th>Status</th>
                                        <th>Pembeli</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($pembelian as $r)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $r->tanggal_pesan }}</td>
                                            <td>{{ $r->status_pembelian }} @if ($r->status_pembelian == 'belum diterima')
                                                    <span class="badge bg-danger"><i class="fa fa-exclamation"></i></span>
                                                @endif
                                            </td>
                                            <td>{{ $r->pembeli->nama_pembeli }}</td>
                                            <td>
                                                <a class="btn btn-link btn-sm"
                                                    href="{{ route(Session::get('type') . '.order.detail', $r->pembelian_id) }}"><i
                                                        class="fa fa-eye"></i>&nbsp; Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
