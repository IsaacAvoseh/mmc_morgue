<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MMC Morgue:: @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css" /> --}}

    <!-- daterange picker -->
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">{{ Auth::user()->name ?? 'Admin' }}</a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link btn btn-primary text-white btn-sm rounded"> <i class=" fas fa-folder-plus fa-1x"></i>  Admit</a>
                </li> --}}
             
            
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                   {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('corpses') }}" class="nav-link btn btn-success text-white btn-sm rounded"><i class=" fas fa-folder-minus"></i>  Release</a>
                </li> --}}
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                {{-- <img src="" alt="Conference App" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
                <i class="ms-3 fas fa-th"></i>
                <span class="brand-text font-weight-light">MMC <sub>Morgue</sub></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                        <li class="nav-item menu-open">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/dashboard'? 'active': '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <i class="right"></i>
                                </p>
                            </a>

                        </li>
                        {{-- <li class="nav-item">
                            <a href="pages/widgets.html" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Widgets

                                </p>
                            </a>
                        </li> --}}

                         <li class="nav-item">
                            <a href="{{ route('corpses') }}"
                                class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/corpses'? 'active': '' }}">
                                <i class="nav-icon fas fa-bed"></i>
                                <p>
                                    Corpses
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admit') }}"
                                class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/corpses/admit'? 'active': '' }}">
                               
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>
                                    Admit
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('release_list') }}"
                                class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/release_list'? 'active': '' }}">
        
                                <i class="nav-icon  fas fa-sign-out-alt"></i>
                            
                                <p>
                                    Released
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('racks') }}"
                                class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/racks'? 'active': '' }}">
                                <i class="nav-icon fas fa-truck-loading"></i>
                                <p>
                                    Racks
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('services') }}"
                                class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/services'? 'active': '' }}">
                                <i class="nav-icon fas fa-poll-h"></i>
                                <p>
                                    Services
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('documents') }}"
                                class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/documents'? 'active': '' }}">
                                <i class="nav-icon fas fa-folder-open"></i>
                                <p>
                                    Documents
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('create_session') }}"
                                class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/create_session'? 'active': '' }}">
                                <i class="nav-icon fas fa-business-time"></i>
                                <p>
                                    Audit Periods
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('generate_report') }}"
                                class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/generate_report'? 'active': '' }}">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Reports
                                </p>
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a href="{{ route('users') }}"
                                class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/users'? 'active': '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>
                        {{-- Log out --}}
                        <li class="nav-item">
                            <a href="/logout" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Log Out

                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
                @include('flash.flash')
            </div>
            <!-- /.content-header -->
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <small>
                Powered by <a href="https://www.ftsl-ng.com/" target="_blank">Flyte Technologies and Solutions
                    Limited</a>
            </small>

        </footer>


    </div>
    <!-- ./wrapper -->
   
    
    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr -->
    <script src="/plugins/toastr/toastr.min.js"></script>
    <!-- jQuery -->
    <!-- SweetAlert2 -->
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/plugins/jszip/jszip.min.js"></script>
    <script src="/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
      <script src="/plugins/chart.js/Chart.min.js"></script>
    <script src="/dist/js/pages/dashboard3.js"></script>
    <!-- AdminLTE -->
    <script src="/dist/js/adminlte.js"></script>

</body>

</html>
