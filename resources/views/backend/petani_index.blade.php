@extends('template.admin')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Petani</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="active">Petani</li>
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
                        <strong class="card-title">Petani</strong>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>HP</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($petani as $r)
                                <tr>
                                    <td>{{ $r->petani_nama }}</td>
                                    <td>{{ $r->user->username }}</td>
                                    <td>{{ $r->petani_jk }}</td>
                                    <td>{{ $r->petani_alamat }}</td>
                                    <td>{{ $r->petani_tempatlahir }}</td>
                                    <td>{{ $r->petani_tgllahir }}</td>
                                    <td>{{ $r->petani_hp }}</td>
                                    <td>
                                        <a class="btn btn-link btn-sm" href="{{ route('petani.detail', $r->petani_id) }}"><i class="fa fa-eye"></i>&nbsp; Detail</a>
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
