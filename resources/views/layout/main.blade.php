<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MISAS Morgue Management System:: @yield('title')</title>
    <link rel="shortcut icon" href="/misaslogo.png" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- IonIcons -->
    {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

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
            <ul class="navbar-nav loading_test">
                {{-- lodaing spinner --}}
                <div class="overlay-wrapper" hidden id="overlay-wrapper">
                    <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                </div>
                {{-- end loading spinner --}}
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">{{ Auth::user()->name ?? 'Admin' }} ( {{ucfirst(session()->get('user_type')) }} )</a>
                </li>
                @if (Auth::user() && Auth::user()->type == 'admin')
                    <li class="nav-item d-none d-sm-inline-block">
                        <select class="form-control form-control-sm" name="user_type" id="user_type"
                            style="width: 100%;" required>
                            {{-- @forelse (\App\Models\User::distinct()->get('type') as $type)
                                <option value="{{ $type->type }}">{{ ucfirst($type->type) ?? '-' }}
                                </option>
                            @empty
                                <option value="">Not availbe</option>
                            @endforelse --}}
                            <option selected="selected" value="">Select</option>
                            <option value="reception">Reception</option>
                            <option value="accounts">Accounts</option>
                            <option value="admin">Admin</option>
                        </select>
                    </li>
                @endif

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}" role="button">
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
                <img src="/misaslogo.png" alt="Misas Logo " class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                {{-- <img src="/misaslogo.png" style="width:40px" class="mb-2" alt="Misas Logo"> --}}
                <span class="brand-text font-weight-light text-white">MISAS <sub>Morgue System</sub></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                        @if (Auth::user() && Auth::user()->type != 'none')
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}"
                                    class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/dashboard'? 'active': '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                        <i class="right"></i>
                                    </p>
                                </a>

                            </li>

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
                                <a href="{{ route('reports') }}"
                                    class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/reports'? 'active': '' }}">
                                    <i class="nav-icon  fas fa-folder-open"></i>
                                    <p>
                                        Reports
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

                            @if (Auth::user() && session()->get('user_type') == 'admin')
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
                            @endif

                            <li class="nav-item">
                                <a href="{{ route('payment_history') }}"
                                    class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/payment_history'? 'active': '' }}">
                                    <i class="nav-icon fas fa-money-check-alt"></i>
                                    <p>
                                        Payment History
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item {{ (request()->route() &&(request()->route()->uri() == 'admin/inventory' ||request()->route()->uri() == 'admin/item_request' ||request()->route()->uri() == 'admin/request_list' ||request()->route()->uri() == 'admin/inventory/history' ||request()->route()->uri() == 'admin/inventory/expenses')? 'menu-open': '' ||(request()->route() &&request()->route()->uri() == 'admin/inventory/expense_category'))? 'menu-open': '' }}"
                                id="inventory">
                                <a href="#"
                                    class="nav-link {{ (request()->route() &&(request()->route()->uri() == 'admin/inventory' ||request()->route()->uri() == 'admin/item_request' ||request()->route()->uri() == 'admin/request_list' ||request()->route()->uri() == 'admin/inventory/history' ||request()->route()->uri() == 'admin/inventory/expenses')? 'active': '' ||(request()->route() &&request()->route()->uri() == 'admin/inventory/expense_category'))? 'active': '' }}">
                                    <i class="nav-icon fas fa-warehouse"></i>
                                    <p>
                                        Inventory
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('inventory') }}"
                                            class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/inventory'? 'active': '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Inventory
                                            </p>
                                        </a>
                                    </li>

                                    @if(Auth::user() && session()->get('user_type') != 'admin')
                                    <li class="nav-item">
                                        <a href="{{ route('item_request') }}"
                                            class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/item_request'? 'active': '' }}">
                                            <i class="far fa-circle nav-icon text-primary"></i>
                                            <p>
                                                Requisition
                                            </p>
                                        </a>
                                    </li>
                                    @endif

                                    @if (Auth::user() && session()->get('user_type') == 'admin')
                                        <li class="nav-item">
                                            <a href="{{ route('request_list') }}"
                                                class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/request_list'? 'active': '' }}">
                                                <i class="far fa-circle nav-icon text-warning"></i>
                                                <p>
                                                    Requests
                                                </p>
                                            </a>
                                        </li>
                                    @endif

                                    <li class="nav-item">
                                        <a href="{{ route('history') }}"
                                            class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/inventory/history'? 'active': '' }}">
                                            <i class="far fa-circle nav-icon text-success"></i>
                                            <p>
                                                History
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('expenses') }}"
                                            class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/inventory/expenses'? 'active': '' }}">
                                            <i class="far fa-circle nav-icon text-danger"></i>
                                            <p>
                                                Expense Journal
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('expense_category') }}"
                                            class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/inventory/expense_category'? 'active': '' }}">
                                            <i class="far fa-circle nav-icon text-secondary"></i>
                                            <p>
                                                Expense Category
                                            </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                             <li class="nav-item">
                                    <a href="{{ route('referrals') }}"
                                        class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/referrals'? 'active': '' }}">
                                        <i class="nav-icon fas fa-user-cog"></i>
                                        <p>
                                            Referrals
                                        </p>
                                    </a>
                                </li>

                            @if (Auth::user() && session()->get('user_type') == 'admin')
                                <li class="nav-item">
                                    <a href="{{ route('users') }}"
                                        class="nav-link {{ request()->route() &&request()->route()->uri() == 'admin/users'? 'active': '' }}">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>
                                            Users
                                        </p>
                                    </a>
                                </li>
                            @endif
                             <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>
                                        Log Out

                                    </p>
                                </a>
                            </li>
                        @else
                            {{-- Log out --}}
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>
                                        Log Out

                                    </p>
                                </a>
                            </li>
                        @endif
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
    <!-- AdminLTE -->
    <script src="/dist/js/adminlte.js"></script>
    <!-- Toastr -->
    <script src="/plugins/toastr/toastr.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/plugins/jszip/jszip.min.js"></script>
    <script src="/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/plugins/pdfmake/vfs_fonts.js"></script>

    <script>
          var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });
        $('#user_type').change(function() {
            $('.loading_test').find('#overlay-wrapper').attr('hidden', false);
            const user_type = $(this).val();
            console.log('user tyoe', user_type)
            // Make the AJAX request
            $.ajax({
                url: "{{ route('switch_user') }}",
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    user_type: user_type,
                    _token: "{{ csrf_token() }}",
                }),
                success: function(response) {
                    // Request was successful, handle the response here
                    Toast.fire({
                        icon: 'success',
                        title: `${response?.message?? 'Something went wrong!'}`
                    })
                    $('.loading_test').find('#overlay-wrapper').attr('hidden', true);
                    console.log(response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    $('.loading_test').find('#overlay-wrapper').attr('hidden', true);
                    Swal.fire(
                        'Error!',
                        `${result?.message?? 'Something went wrong!'}`,
                        // `Something went wrong!.`,
                        'error'
                    )
                    // Request failed, handle the error here
                    console.error('Request failed. Status:', xhr.status);
                }
            });
        });
    </script>

    @yield('scripts')


</body>

</html>
