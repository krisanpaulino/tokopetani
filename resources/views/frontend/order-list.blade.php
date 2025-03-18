@extends('front');
@section('content')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Cart</h1>
</div>
<!-- Single Page Header End -->
<!-- Cart Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Waktu</th>
                        <th scope="col">Total Bayar</th>
                        <th scope="col">Total Ongkir</th>
                        <th scope="col">Status</th>
                        <th scope="col">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembelian as $item)
                        <tr>
                            <td>{{$item->tanggal_pesan}}</td>
                            <td>Rp{{number_format($item->total_bayar)}}</td>
                            <td>Rp{{number_format($item->ongkir)}}</td>
                            <td>{{$item->status_pembelian}}</td>
                            <td><a href="{{route('order.detail', $item->pembelian_id)}}" class="btn border btn-sm border-secondary rounded-pill px-3 text-primary">Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Cart Page End -->
@endsection
