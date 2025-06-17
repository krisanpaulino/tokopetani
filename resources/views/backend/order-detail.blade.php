@extends('template.' . Session::get('type'))
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
                                {{-- <li class="active">Produk</li> --}}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Detail Pembeli</h4>
                </div>
                <div class="card-body">
                    <div class="">
                        <h2 class="h2">{{ $pembelian->pembeli->nama_pembeli }}</h2> </br>
                        <span>{{ $pembelian->pembeli->alamat_jalan }}, {{ $pembelian->pembeli->alamat_desa }},
                            {{ $pembelian->pembeli->city->city }}, {{ $pembelian->pembeli->alamat_provinsi }}
                        </span><br>
                        <span>HP : {{ $pembelian->pembeli->no_telp }}</span><br>
                        <span>Email : {{ $pembelian->pembeli->user->username }}</span><br>
                    </div>
                </div>
            </div>
            <div class="orders">

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="box-title">Detail Transaksi </h4>
                            </div>
                            <div class="card-body">
                                @if (Session::get('type') == 'petani')
                                    <p class="text-dark"><b>Status Pengiriman : </b>{{ $ongkir->status_pengiriman }}</p>
                                    <p class="text-dark"><b>Perkiraan Sampai :
                                        </b>{{ date('d-m-Y', strtotime($ongkir->estimasi)) }}</p>
                                @endif
                                @if (Session::get('type') == 'admin')
                                    <span><b>Status Pesanan : </b>{{ $pembelian->status_pembelian }}</span>
                                @endif

                                <div class="table-stats order-table ov-h">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th class="serial">#</th>
                                                <th class="avatar">Produk</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            @foreach ($detail as $r)
                                                @php
                                                    if ($r->gambar == null) {
                                                        $r->gambar = '';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td class="serial">{{ $no++ }}</td>
                                                    <td class="avatar">
                                                        <div class="round-img"><a href="#"><img class="rounded-circle"
                                                                    src="{{ Storage::disk('public')->exists($r->gambar) ? asset('storage/' . $r->gambar) : asset('storage/produk/default.jpg') }}"
                                                                    alt=""></a>
                                                        </div>
                                                    </td>
                                                    <td> <span class="name">{{ $r->produk->nama_produk }}</span> </td>
                                                    <td>{{ number_format($r->produk->harga) }} </td>
                                                    <td><span class="count">{{ $r->jumlah_beli }}</span></td>
                                                    <td> <span
                                                            class="product">{{ $r->produk->harga * $r->jumlah_beli }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="5" class="text-right">Ongkir</td>
                                                <td>Rp{{ number_format($ongkir->biaya) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-right">Total</td>
                                                <td>Rp{{ number_format($total) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- /.table-stats -->

                                @if (Session::get('type') == 'petani')
                                    @if ($ongkir->status_pengiriman == 'dikemas')
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#Pengiriman">Proses Kirim</button>
                                    @endif
                                    @if ($ongkir->status_pengiriman == 'dikirim')
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#Selesai">Selesai</button>
                                    @endif
                                @endif
                                @if (Session::get('type') == 'admin')
                                    @if ($pembelian->status_pembelian == 'verifikasi pembayaran')
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#Proses">Cek Bukti</button>
                                    @endif
                                    {{-- @if ($pembelian->status_pembelian == 'dikirim')
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#Selesai">Selesai</button>
                                    @endif --}}
                                @endif
                            </div>
                        </div> <!-- /.card -->
                    </div> <!-- /.col-lg-8 -->

                </div>
            </div>
        </div><!-- .animated -->
        @if (Session::get('type') == 'petani')
            <div class="modal fade" id="Pengiriman" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Proses Pengiriman</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('order.kirim') }}" method="post">
                            @csrf
                            <input type="hidden" name="pembelian_id" value="{{ $pembelian->pembelian_id }}">
                            <div class="modal-body">
                                <div class="form-group mb-4">
                                    {{-- <label for="">Nomor Resi</label>
                                    <input value="{{ old('resi') }}" type="text" name="resi"
                                        class="form-control @error('resi') is-invalid @enderror" required>
                                    @error('resi')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror --}}
                                </div>
                                <div class="form-group mb-4">
                                    <label for="">Estimasi</label>
                                    <span class="fs-4">{{ $pembelian->pengiriman->first()->estimasi }}</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Proses Pengiriman</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="Selesai" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Selesaikan Transaksi</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('order.selesai') }}" method="post">
                            @csrf
                            <input type="hidden" name="pembelian_id" value="{{ $pembelian->pembelian_id }}">
                            <div class="modal-body">
                                Pastikan pengiriman sudah selesai!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Proses Selesai</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @if (Session::get('type') == 'admin' && $pembelian->pembayaran != null)
            <div class="modal fade" id="Proses" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Verifikasi Pembayaran</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('order.proses') }}" method="post">
                            @csrf
                            <input type="hidden" name="pembelian_id" value="{{ $pembelian->pembelian_id }}">
                            <div class="modal-body">
                                <img src="{{ asset('storage/' . $pembelian->pembayaran->bukti_bayar) }}" alt=""
                                    class="img-relative">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Proses Pesanan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

    </div><!-- .content -->
@endsection
