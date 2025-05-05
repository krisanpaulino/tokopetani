@extends('template.admin')
@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1><a href="{{ route('petani.index') }}" class="text-primary">
                                    << Petani</a>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">{{ $title }}</a></li>
                                <li><a href="{{ route('petani.index') }}">Petani</a></li>
                                <li class="active">Detail</li>
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

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Detail Petani</strong>
                        </div>
                        <div class="card-body">
                            <img class="align-self-center rounded-circle mr-3" style="width:85px; height:85px;"
                                alt="" src="{{ asset('images') }}/admin.jpg">

                            <table class="table table-borderless">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $petani->petani_nama }}</td>
                                </tr>
                                <tr>
                                    <th>JK</th>
                                    <td>{{ $petani->petani_jk }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $petani->user->username }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat Lahir</th>
                                    <td>{{ $petani->petani_tempatlahir }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>{{ $petani->petani_tgllahir }}</td>
                                </tr>
                                <tr>
                                    <th>Telp</th>
                                    <td>{{ $petani->petani_hp }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
