@extends('template.admin')
@section('content')
    <div class="content">
        <div class="animated fadeIn">
            <div class="row d-flex justify-content-center">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-1">
                                    <i class="ti-shopping-cart"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $masuk }}</span></div>
                                        <div class="stat-heading">Pesanan masuk</div>
                                        <div>

                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('admin.order.masuk') }}" class="text-primary text-small">Lihat
                                        Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-2">
                                    <i class="ti-truck"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $diproses }}</span></div>
                                        <div class="stat-heading">Pesanan Diproses</div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('admin.order.diproses') }}" class="text-primary text-small">Lihat
                                        Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-3">
                                    <i class="ti-check-box"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">{{ $selesai }}</span></div>
                                        <div class="stat-heading">Pesanan Selesai</div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('admin.order.selesai') }}" class="text-primary text-small">Lihat
                                        Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="chart-container-1 mt-3">
                                <canvas id="chart4" width="345" height="325"
                                    style="display: block; box-sizing: border-box; height: 260px; width: 276px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection
@section('scripts')
    <script>
        var ctx = document.getElementById('chart4').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach ($pembelian as $row)
                        <?= "'" . $row->tanggal . "', " ?>
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach ($pembelian as $row)
                            {{ $row->jumlah . ', ' }}
                        @endforeach
                    ],
                    label: 'Penjualan 7 Hari Terakhir',
                    // backgroundColor: [
                    //     '#0d6efd',
                    //     '#6f42c1',
                    //     '#d63384',
                    //     '#fd7e14',
                    //     '#15ca20',
                    // ],
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        display: true,
                    }
                },

            }
        });
    </script>
@endsection
