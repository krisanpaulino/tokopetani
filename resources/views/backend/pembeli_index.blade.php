@extends('template.admin')
@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Pembeli</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            {{-- <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Table</a></li>
                            <li class="active">Data table</li>
                        </ol> --}}
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
                            <strong class="card-title">Data Pembeli</strong>
                        </div>
                        <div class="card-body">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Alamat</th>

                                        <th>Riwayat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($pembeli as $r)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $r->nama_pembeli }}</td>
                                            <td>{{ $r->user->username }}</td>
                                            <td>{{ $r->alaman_jalan }}, {{ $r->lokasi_string }}</td>
                                            <td>{{ $r->pembelian->count() }} <a
                                                    href="{{ route('admin.riwayat-pembeli', $r->pembeli_id) }}"
                                                    class="text-primary">Lihat</a>
                                            </td>
                                            {{-- <td>{{ $r->petani_hp }}</td> --}}
                                            <td>
                                                <a class="btn btn-link btn-sm"
                                                    href="{{ route('pembeli.edit', $r->pembeli_id) }}"><i
                                                        class="fa fa-pencil"></i>&nbsp; Edit</a>
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
