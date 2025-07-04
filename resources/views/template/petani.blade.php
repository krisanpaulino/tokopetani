<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Toko Tani</title>
    <meta name="description" content="Toko Tani">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/style.css">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('/') }}assets/css/lib/chosen/chosen.min.css">

    <style>
        #weatherWidget .currentDesc {
            color: #ffffff !important;
        }

        .traffic-chart {
            min-height: 335px;
        }

        #flotPie1 {
            height: 150px;
        }

        #flotPie1 td {
            padding: 3px;
        }

        #flotPie1 table {
            top: 20px !important;
            right: -10px !important;
        }

        .chart-container {
            display: table;
            min-width: 270px;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        #flotLine5 {
            height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }

        #cellPaiChart {
            height: 160px;
        }

        .navbar-nav li,
        .navbar-nav ul li a {
            color: #ffffff;
        }
    </style>
</head>

<body>
    @php
        $user = App\Models\User::where('username', Session::get('email'))->first();
        $complain = App\Models\Pembelian::where('status_pembelian', '=', 'belum diterima')
            ->join('detailpembelian', 'detailpembelian.pembelian_id', 'pembelian.pembelian_id')
            ->join('produk', 'produk.produk_id', 'detailpembelian.produk_id')
            ->where('produk.petani_id', $user->petani->petani_id)
            ->count('pembelian.pembelian_id');
    @endphp
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel bg-success">
        <nav class="navbar navbar-expand-sm navbar-default bg-success">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="menu-item">
                        <a class="text-light" href="{{ route('dashboard') }}"><i
                                class="menu-icon text-light fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="menu-title text-light">Toko</li><!-- /.menu-title -->
                    <li class="menu-item">
                        <a class="text-light" href="{{ route('produk.index') }}"> <i
                                class="menu-icon text-light ti-bag"></i>Produk </a>
                    </li>
                    <li class="menu-title text-light">Order</li><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a class="text-light" href="#" class="dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"> <i
                                class="menu-icon text-light ti-shopping-cart"></i>Order @if ($complain > 0)
                                <span class="badge bg-danger"><i class="fa fa-exclamation"></i></span>
                            @endif
                        </a>
                        <ul class="sub-menu children dropdown-menu bg-success">
                            <li class="menu-item">
                                <a class="text-light" href="{{ route(Session::get('type') . '.order') }}"> Semua </a>
                            </li>
                            <li class="menu-item">
                                <a class="text-light" href="{{ route(Session::get('type') . '.order.masuk') }}"> Orderan
                                    Masuk
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="text-light" href="{{ route(Session::get('type') . '.order.diproses') }}">
                                    Orderan Diproses @if ($complain > 0)
                                        <span class="badge bg-danger">.</span>
                                    @endif
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="text-light" href="{{ route(Session::get('type') . '.order.selesai') }}">
                                    Orderan Selesai
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="menu-item">
                        <a class="text-light" href="{{ route(Session::get('type') . '.laporan') }}"> <i
                                class="menu-icon text-light ti-clipboard"></i>Laporan </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    @php
        $user = App\Models\User::find(Session::get('user_id'));
        $notif = App\Models\Pembelian::join(
            'detailpembelian',
            'detailpembelian.pembelian_id',
            '=',
            'pembelian.pembelian_id',
        )
            ->join('produk', 'detailpembelian.produk_id', '=', 'produk.produk_id')
            ->where('status_pembelian', '=', 'diproses')
            ->where('produk.petani_id', '=', $user->petani->petani_id)
            ->groupBy('pembelian.pembelian_id')
            ->count();
    @endphp
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header bg-success">
            <div class="top-left">
                <div class="navbar-header bg-success">
                    <a class="navbar-brand" href="./"><b class="text-light">TokoTani</b></a>
                    {{-- <a class="navbar-brand" href="./"><img src="{{ asset('images') }}/logo.png" --}}
                    {{-- alt="Logo"></a> --}}
                    {{-- <a class="navbar-brand hidden" href="./"><img src="{{ asset('images') }}/logo2.png"
                            alt="Logo"></a> --}}
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">

                        <div class="dropdown for-notification">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell text-light"></i>
                                <span class="count bg-danger">{{ $notif }}</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="notification">
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-cart text-light"></i>
                                    <p>Anda punya {{ $notif }} pesanan masuk!</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="{{ asset('images') }}/petani.png"
                                alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">


                            <a class="nav-link" href="{{ route('logout') }}"><i
                                    class="fa fa-power-off"></i>Logout</a>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- /#header -->
        <!-- Content -->
        @yield('content')
        <!-- /.content -->
        <div class="clearfix"></div>
        <!-- Footer -->
        {{-- <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        Copyright &copy; 2018 Ela Admin
                    </div>
                    <div class="col-sm-6 text-right">
                        Designed by <a href="https://colorlib.com">Colorlib</a>
                    </div>
                </div>
            </div>
        </footer> --}}
        <!-- /.site-footer -->
    </div>
    <!-- /#right-panel -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="{{ asset('/') }}assets/js/main.js"></script>

    <!--  Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

    <!--Chartist Chart-->
    <script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
    <script src="{{ asset('/') }}assets/js/init/weather-init.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
    <script src="{{ asset('/') }}assets/js/init/fullcalendar-init.js"></script>

    {{-- Plugins --}}
    <script src="{{ asset('/') }}assets/js/lib/data-table/datatables.min.js"></script>
    <script src="{{ asset('/') }}assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="{{ asset('/') }}assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/') }}assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="{{ asset('/') }}assets/js/lib/data-table/jszip.min.js"></script>
    <script src="{{ asset('/') }}assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="{{ asset('/') }}assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="{{ asset('/') }}assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="{{ asset('/') }}assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="{{ asset('/') }}assets/js/init/datatables-init.js"></script>
    <script src="{{ asset('/') }}assets/js/lib/chartjs/js/chart.min.js"></script>

    <script src="{{ asset('/') }}assets/js/lib/chosen/chosen.jquery.min.js"></script>
    @yield('scripts')

    <!--Local Stuff-->
    <script>
        jQuery(document).ready(function() {
            jQuery(".standardSelect").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });
        });
        $(document).ready(function() {
            console.log('{{ URL::current() }}');
            $(".menu-item").find("a[href='{{ URL::current() }}']").parent().addClass('active')
            var a = $(".menu-item").find("a[href='{{ URL::current() }}']")
            console.log(a);

        });
    </script>
</body>

</html>
