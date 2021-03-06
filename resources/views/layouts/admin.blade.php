<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Easy Business| Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href={{ asset('plugins/fontawesome-free/css/all.min.css') }}>
    <!-- Ionicons -->
    <link rel="stylesheet" href={{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}>
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href={{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}>
    <!-- iCheck -->
    <link rel="stylesheet" href={{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}>
    <!-- JQVMap -->
    <link rel="stylesheet" href={{ asset('plugins/jqvmap/jqvmap.min.css') }}>
    <!-- Theme style -->
    <link rel="stylesheet" href={{ asset('dist/css/adminlte.min.css') }}>
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href={{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}>
    <!-- Daterange picker -->
    <link rel="stylesheet" href={{ asset('plugins/daterangepicker/daterangepicker.css') }}>
    <!-- summernote -->
    <link rel="stylesheet" href={{ asset('plugins/summernote/summernote-bs4.min.css') }}>

    <!-- JQuery DataTables css-->
    {{-- <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" href={{asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}>
    <link rel="stylesheet" href={{asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}>
    <link rel="stylesheet" href={{asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}>

    <!-- jQuery -->
    <script src={{ asset('plugins/jquery/jquery.min.js') }}></script>

    {{-- sweet alert.js ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    {{-- select2 styles --}}
    <link rel="stylesheet" href="{{ asset('/plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.css') }}">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href={{ route('home') }} class="nav-link">Home</a>
                </li>
            </ul>
            <!-- Right navbar -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">My Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Notifications</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href={{ route('home') }} class="brand-link">
                <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Easy Business</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2 side_nav">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                          with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href={{ route('home') }} class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                              All Masters
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href={{route('categories.index')}} class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                  Category
                                </p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href={{route("taxSlabMaster.index")}} class="nav-link">
                                <i class="nav-icon ion ion-alert-circled"></i>
                                <p>Tax Slab</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href={{ route('products.index') }} class="nav-link">
                                  <i class="nav-icon ion ion-bag"></i>
                                  <p>
                                      Products
                                  </p>
                              </a>
                            </li>
                            <li class="nav-item">
                                <a href={{ route('customers.index') }} class="nav-link">
                                    <i class="nav-icon ion ion-person-add"></i>
                                    <p>
                                        Customers
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href={{ route('suppliers.index') }} class="nav-link">
                                    <i class="nav-icon ion ion-person"></i>
                                    <p>
                                        Suppliers
                                    </p>
                                </a>
                            </li>
                          </ul>
                        </li>
                        <li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                              Purchase
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href={{ route('addPurchase.index') }} class="nav-link">
                                  <i class="nav-icon ion ion-clipboard"></i>
                                  <p>Add Purchase</p>
                              </a>
                            </li>
                            <li class="nav-item">
                                <a href={{ route('viewPurchase.index') }} class="nav-link">
                                    <i class="nav-icon ion ion-clipboard"></i>
                                    <p>
                                        View Purchase
                                    </p>
                                </a>
                            </li>
                          </ul>
                        </li>
                        <li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                              Sales
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href={{ route('sales.index') }} class="nav-link">
                                  <i class="nav-icon ion ion-calendar"></i>
                                  <p>
                                      Add Sale
                                  </p>
                              </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('viewSales')}}" class="nav-link">
                                    <i class="nav-icon ion ion-calendar"></i>
                                    <p>
                                        View Sale
                                    </p>
                                </a>
                            </li>
                          </ul>
                        </li> 
                        <li class="nav-item">
                            <a href="{{route('credits.index')}}" class="nav-link">
                                <i class="nav-icon ion ion-compose"></i>
                                <p>
                                    Credits
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payback.index') }}" class="nav-link">
                                <i class="nav-icon ion ion-cash"></i>
                                <p>
                                    Pay Back
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('returnOrder.index') }}" class="nav-link">
                                <i class="nav-icon ion ion-compose"></i>
                                <p>
                                    Return Orders List
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                              <i class="nav-icon fas fa-tachometer-alt"></i>
                              <p>
                                Reports
                                <i class="right fas fa-angle-left"></i>
                              </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href={{ route('salesReport.index') }} class="nav-link">
                                        <i class="nav-icon ion ion-calendar"></i>
                                        <p>
                                            Sales Report
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                  <a href="{{ route('purchaseReport.index') }}" class="nav-link">
                                      <i class="nav-icon ion ion-calendar"></i>
                                      <p>
                                          Purchase Report
                                      </p>
                                  </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ReturnOrdersReport.index') }}" class="nav-link">
                                        <i class="nav-icon ion ion-calendar"></i>
                                        <p>
                                            Return Orders Report
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('PaymentReport.index') }}" class="nav-link">
                                        <i class="nav-icon ion ion-calendar"></i>
                                        <p>
                                            Payment Report
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('PayBackReport.index') }}" class="nav-link">
                                        <i class="nav-icon ion ion-calendar"></i>
                                        <p>
                                            PayBack Report
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('StockReport.index') }}" class="nav-link">
                                        <i class="nav-icon ion ion-calendar"></i>
                                        <p>
                                            Stock Report
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('settings.index') }}" class="nav-link">
                                <i class="nav-icon ion ion-android-settings"></i>
                                <p>
                                    Settings
                                </p>
                            </a>
                        </li> 
                        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="nav-icon far fa-circle text-danger"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
          </li> --}}
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; <a href="#">Preet-Mehta</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> RMS1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery UI 1.11.4 -->
    <script src={{ asset('plugins/jquery-ui/jquery-ui.min.js') }}></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <!-- ChartJS -->
    <script src={{ asset('plugins/chart.js/Chart.min.js') }}></script>
    <!-- Sparkline -->
    <script src={{ asset('plugins/sparklines/sparkline.js') }}></script>
    <!-- jQuery Knob Chart -->
    <script src={{ asset('plugins/jquery-knob/jquery.knob.min.js') }}></script>
    <!-- daterangepicker -->
    <script src={{ asset('plugins/moment/moment.min.js') }}></script>
    <script src={{ asset('plugins/daterangepicker/daterangepicker.js') }}></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src={{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}></script>
    <!-- Summernote -->
    <script src={{ asset('plugins/summernote/summernote-bs4.min.js') }}></script>
    <!-- overlayScrollbars -->
    <script src={{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}></script>
    <!-- AdminLTE App -->
    <script src={{ asset('dist/js/adminlte.js') }}></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src={{asset("dist/js/demo.js")}}></script> --}}

    <script src="{{asset('/plugins/jquery/jquery.min.js')}}"></script>
    <!-- JQuery DataTable JS-->
    {{-- <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script> --}}
    <script src={{asset("plugins/datatables/jquery.dataTables.min.js")}}></script>
    <script src={{asset("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}></script>
    <script src={{asset("plugins/datatables-responsive/js/dataTables.responsive.min.js")}}></script>
    <script src={{asset("plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}></script>
    <script src={{asset("plugins/datatables-buttons/js/dataTables.buttons.min.js")}}></script>
    <script src={{asset("plugins/datatables-buttons/js/buttons.bootstrap4.min.js")}}></script>
    <script src={{asset("plugins/jszip/jszip.min.js")}}></script>
    <script src={{asset("plugins/pdfmake/pdfmake.min.js")}}></script>
    <script src={{asset("plugins/pdfmake/vfs_fonts.js")}}></script>
    <script src={{asset("plugins/datatables-buttons/js/buttons.html5.min.js")}}></script>
    <script src={{asset("plugins/datatables-buttons/js/buttons.print.min.js")}}></script>
    <script src={{asset("plugins/datatables-buttons/js/buttons.colVis.min.js")}}></script>

    <!-- Bootstrap 4 -->
    <script src={{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}></script>
    
    {{-- sweetalert.cdn--------++++++++++++++------------ --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- script to use select2 ------------------------------------------------------------ --}}
    <script src={{ asset('/plugins/select2/js/select2.full.min.js') }} defer></script>

    {{-- script to active nav tag dynamically as per the page --}}
    <script>
        $(".nav a").each(function() {
            var pageUrl = window.location.href.split(/[?#]/)[0];

            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("active"); // add active to li of the current link
                //                $(this).parent().parent().addClass("in");
                $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
                $(this).parent().parent().parent().addClass("menu-open");


                $(this).parent().parent().parent().parent().prev().addClass(
                "active"); // add active class to an anchor
                $(this).parent().parent().parent().parent().addClass("menu-open");

                $(this).parent().parent().parent().parent().prev().next().attr("style", "display: block;");

                //                $(this).parent().parent().parent().parent().addClass("in"); // add active to li of the current link
                //                $(this).parent().parent().parent().parent().parent().addClass("active");
            }
        });
    </script>
</body>

</html>
