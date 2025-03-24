@extends('template.'.Session::get('type'))
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
                        Filter Tanggal
                    </div>
                    <div class="card-body">
                        <form action="{{ route(Session::get('type').'.laporan') }}" method="get">
                            <div class="row">
                                <div class="col-4">
                                    <label for="">Dari Tanggal</label>
                                    <input type="date" name="dari" id="" value="{{ $dari }}" class="form-control">
                                </div>
                                <div class="col-4">
                                    <label for="">Sampai Tanggal</label>
                                    <input type="date" name="sampai" id="" value="{{ $sampai }}" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Filter</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Laporan Transaksi</strong>
                    </div>
                    <div class="card-body">
                        <div class="text-right">
                            <form action="{{ route(Session::get('type').'.cetak-laporan') }}" method="get">
                                @csrf
                                <input type="hidden" name="dari" value="{{ $dari }}">
                                <input type="hidden" name="sampai" value="{{ $sampai }}">
                                <button type="submit" class="btn btn-warning">Cetak</button>

                            </form>
                        </div>
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pesan</th>
                                    <th>Status</th>
                                    <th>Total Poduk</th>
                                    <th>Total Ongkir</th>
                                    <th>Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach ($laporan as $r)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $r->tanggal_pesan }}</td>
                                    <td>{{ $r->status_pembelian }}</td>
                                    @if (Session::get('type') == 'admin')
                                    <td>Rp{{ number_format($r->total_bayar) }}</td>
                                    <td>Rp{{ number_format($r->ongkir) }}</td>
                                    <td>Rp{{ number_format($r->total_bayar + $r->ongkir) }}</td>
                                    @endif
                                    @if (Session::get('type') == 'petani')
                                    <td>Rp{{ number_format($r->total_detail) }}</td>
                                    <td>Rp{{ number_format($r->total_ongkir) }}</td>
                                    <td>Rp{{ number_format($r->total_detail + $r->total_detail) }}</td>
                                    @endif
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
