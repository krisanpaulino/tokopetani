@extends('front');
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Checkout</h1>
    </div>
    <!-- Single Page Header End -->
    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Order details</h1>
            <form action="{{ route('order.upload') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="pembelian_id" value="{{ $pembelian->pembelian_id }}">
                <div class="row g-5">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="table-responsive">
                            @foreach ($petani as $p)
                                <h5>{{ $p->petani_nama }}</h5>
                                @if ($pembelian->status_pembelian != 'menunggu pembayaran')
                                    <span>Status Pengiriman : {{$p->pembelian->pengiriman->where('petani_id', $p->petani_id)->first()->status_pengiriman}}</span>
                                @endif
                                <span></span>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Products</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($p->detail as $r)
                                            <tr>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ Storage::disk('public')->exists($r->gambar) ? asset('storage/' . $r->gambar) : asset('storage/produk/default.jpg') }}"
                                                            class="img-fluid me-5 rounded-circle"
                                                            style="width: 80px; height: 80px;" alt="">
                                                    </div>
                                                </th>
                                                <td>
                                                    <p class="mb-0 mt-4">{{ $r->nama_produk }}</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 mt-4">Rp{{ number_format($r->harga) }}</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 mt-4">{{ $r->jumlah_beli }}</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 mt-4"></p>Rp{{ $r->harga_detail }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                        <div class="table-responsive">

                            {{-- <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Products</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembelian->detailpembelian as $r)
                                        <tr>
                                            <th scope="row">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ Storage::disk('public')->exists($r->produk->gambar) ? asset('storage/' . $r->produk->gambar) : asset('storage/produk/default.jpg') }}"
                                                        class="img-fluid me-5 rounded-circle"
                                                        style="width: 80px; height: 80px;" alt="">
                                                </div>
                                            </th>
                                            <td>
                                                <p class="mb-0 mt-4">{{ $r->produk->nama_produk }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4">Rp{{ number_format($r->produk->harga) }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4">{{ $r->jumlah_beli }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4"></p>Rp{{ $r->harga_detail }}</p>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table> --}}
                            <table class="table">
                                <tr>
                                    <th scope="row">
                                    </th>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark text-uppercase py-3">Sub Total</p>
                                    </td>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                            <p class="mb-0 text-dark">
                                                Rp{{ number_format($pembelian->total_bayar) }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                    </th>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark text-uppercase py-3">Pengiriman</p>
                                    </td>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                            <p class="mb-0 text-dark" id="shipping">
                                                Rp{{ number_format($pembelian->ongkir) }}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                    </th>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                    </td>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                            <p class="mb-0 text-dark" id="Total">
                                                Rp{{ number_format($pembelian->total_bayar + $pembelian->ongkir) }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                    </th>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark text-uppercase py-3">Status Pembayaran</p>
                                    </td>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                            <p class="mb-0 text-dark" id="Total">
                                                <b>{{ $pembelian->status_pembelian }}</b>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">


                                @if ($pembelian->status_pembelian == 'menunggu pembayaran')
                                    <div class="form-check text-start my-3">
                                        <label for="Transfer-1">Direct Bank Transfer</label>
                                        <p class="text-start text-dark">Pembayaran dilakukan melalui rekening bank BCA :
                                            <b>10101010</b>.
                                            <br> A.n : <b>Jovi</b>
                                        </p>
                                    </div>
                                    <div class="form-check text-start my-3">
                                        <label for="">Upload Bukti Pembayaran</label>
                                        <input type="file" name="bukti" class="form-control" id="" required>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <label class="form-check-label" for="Transfer-1">Pengiriman</label>
                                    <p class="text-start text-dark">Alamat Kirim : {{ $pembeli->alamat_jalan }},
                                        {{ $pembeli->alamat_desa }}, {{ $pembeli->city->city }},
                                        {{ $pembeli->alamat_provinsi }},
                                        {{ $pembeli->alamat_kodepos }}</p>
                                </div>

                            </div>
                        </div>
                        @if ($pembelian->status_pembelian == 'menunggu pembayaran')
                            <div class="row g-4 text-end align-items-center justify-content-center pt-4">
                                <button type="submit"
                                    class="btn border-secondary py-3 px-4 text-uppercase text-primary">Upload
                                    Butki</button>
                        @endif
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
    <!-- Checkout Page End -->
@endsection
@section('scripts')
    <script>
        $('#ongkir').on('change', function(e) {
            var ongkir = parseFloat($(this).val())
            if (ongkir != null) {
                $('#shipping').text('Rp' + ongkir.toLocaleString('en-US'))
                var total = ongkir + {{ $pembelian->total_bayar }}
                $('#Total').text('Rp' + total.toLocaleString('en-Us'))

            }
        })
    </script>
@endsection
