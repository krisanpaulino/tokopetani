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
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Alamat Jalan</th>
                                    <th>Desa/Kelurahan</th>
                                    <th>Kota</th>
                                    <th>Provinsi</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pembeli as $r)
                                <tr>
                                    <td>{{ $r->nama_pembeli }}</td>
                                    <td>{{ $r->user->username }}</td>
                                    <td>{{ $r->alaman_jalan }}</td>
                                    <td>{{ $r->alamat_desa }}</td>
                                    <td>{{ $r->city->city }}</td>
                                    <td>{{ $r->province->province }}</td>
                                    {{-- <td>{{ $r->petani_hp }}</td> --}}
                                    {{-- <td>
                                        <a class="btn btn-link btn-sm" href="{{ route('petani.detail', $r->petani_id) }}"><i class="fa fa-eye"></i>&nbsp; Detail</a>
                                    </td> --}}
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
