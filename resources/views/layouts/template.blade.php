<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Point of Sales</title>
      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/fontawesome-free/css/all.min.css') }}">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Tempusdominus Bootstrap 4 -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
      <!-- iCheck -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
      <!-- JQVMap -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/jqvmap/jqvmap.min.css') }}">
      <!-- Theme style -->
      <link rel="stylesheet" href="{{ asset('admins/dist/css/adminlte.min.css') }}">
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/daterangepicker/daterangepicker.css') }}">
      <!-- summernote -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/summernote/summernote-bs4.min.css') }}">
      <!-- DataTables -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('admins/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('admins/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
      <!-- SweetAlert2 -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
      <!-- Select2 -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/select2/css/select2.min.css') }}">
      <link rel="stylesheet" href="{{ asset('admins/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
      <!-- Bootstrap4 Duallistbox -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
      <!-- BS Stepper -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/bs-stepper/css/bs-stepper.min.css') }}">
      <!-- dropzonejs -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/dropzone/min/dropzone.min.css') }}">
      <!-- daterange picker -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/daterangepicker/daterangepicker.css') }}">
      <!-- Toastr -->
      <link rel="stylesheet" href="{{ asset('admins/plugins/toastr/toastr.min.css') }}">
      <!-- jQuery -->
      <script src="{{ asset('admins/plugins/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
      

   </head>
   <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
         <!-- Preloader -->
         <div class="preloader flex-column justify-content-center align-items-center">
            {{-- <img class="animation__shake" src="{{ asset('admins/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60"> --}}
            <div class="overlay" style="display: flex;">
               <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
         </div>
         <!-- Navbar -->
         <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
               </li>
               <li class="nav-item d-none d-sm-inline-block">
                  <a href="/" class="nav-link">Home</a>
               </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
               <!-- Navbar Search -->
               <li class="nav-item">
                  <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                  <i class="fas fa-search"></i>
                  </a>
                  <div class="navbar-search-block">
                     <form class="form-inline">
                        <div class="input-group input-group-sm">
                           <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                           <div class="input-group-append">
                              <button class="btn btn-navbar" type="submit">
                              <i class="fas fa-search"></i>
                              </button>
                              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                              <i class="fas fa-times"></i>
                              </button>
                           </div>
                        </div>
                     </form>
                  </div>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                  <i class="fas fa-expand-arrows-alt"></i>
                  </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                  <i class="fas fa-th-large"></i>
                  </a>
               </li>
            </ul>
         </nav>
         <!-- /.navbar -->
         <!-- Main Sidebar Container -->
         <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
            <img src="{{ asset('admins/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
               <!-- Sidebar user panel (optional) -->
               <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                  <div class="image">
                     <img src="{{ asset('admins/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                  </div>
                  <div class="info">
                     <a href="#" class="d-block">Alexander Pierce</a>
                  </div>
               </div>
               <!-- SidebarSearch Form -->
               <div class="form-inline">
                  <div class="input-group" data-widget="sidebar-search">
                     <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                     <div class="input-group-append">
                        <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                        </button>
                     </div>
                  </div>
               </div>
               <!-- Sidebar Menu -->
               <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                  <li class="nav-header">Main Menu</li>
                  <li class="nav-item">
                     <a href="/" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                           Dashboard
                        </p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="/pos" class="nav-link {{ Request::is('pos') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                           POS System
                        </p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="/reports" class="nav-link {{ Request::is('reports') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-paste"></i>
                        <p>
                           Reporting
                        </p>
                     </a>
                  </li>
                  <li class="nav-header">Data Master</li>
                  <li class="nav-item {{ Request::is('transactions*') || Request::is('payments*') ? 'menu-open' : '' }}">
                     <a href="#" class="nav-link {{ Request::is('transactions*') || Request::is('payments*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>
                           Transactions
                           <i class="right fas fa-angle-left"></i>
                        </p>
                     </a>
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="/transactions" class="nav-link {{ Request::is('transactions') ? 'active' : '' }}">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Transactions List</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="/payments" class="nav-link {{ Request::is('payments') ? 'active' : '' }}">
                            <i class="far fa-credit-card nav-icon"></i>
                            <p>Payments History</p>
                          </a>
                        </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                     <a href="/products" class="nav-link {{ Request::is('products') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-barcode"></i>
                        <p>
                           Products
                        </p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="/categories" class="nav-link {{ Request::is('categories') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>
                           Categories
                        </p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="/customers" class="nav-link {{ Request::is('customers') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                           Customers
                        </p>
                     </a>
                  </li>
                  <li class="nav-header">Options</li>
                  <li class="nav-item">
                     <a href="pages/widgets.html" class="nav-link">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                           User Settings
                        </p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="pages/widgets.html" class="nav-link">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>
                           Preferences
                        </p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="pages/widgets.html" class="nav-link">
                        <i class="nav-icon fas fa-door-open"></i>
                        <p>
                           Logout
                        </p>
                     </a>
                  </li>
               </nav>
               <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
         </aside>
         <!-- /.content -->
         @yield('content')
         <!-- /.content-wrapper -->
         <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
               <b>Version</b> 3.2.0
            </div>
         </footer>
         <!-- Control Sidebar -->
         <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
         </aside>
         <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->
      <!-- jQuery -->
      <script src="{{ asset('admins/plugins/jquery/jquery.min.js') }}"></script>
      <!-- jQuery UI 1.11.4 -->
      <script src="{{ asset('admins/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
      <script>
         $.widget.bridge('uibutton', $.ui.button)
      </script>
      <!-- Bootstrap 4 -->
      <script src="{{ asset('admins/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <!-- ChartJS -->
      <script src="{{ asset('admins/plugins/chart.js/Chart.min.js') }}"></script>
      <!-- Sparkline -->
      <script src="{{ asset('admins/plugins/sparklines/sparkline.js') }}"></script>
      <!-- JQVMap -->
      <script src="{{ asset('admins/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
      <!-- jQuery Knob Chart -->
      <script src="{{ asset('admins/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
      <!-- daterangepicker -->
      <script src="{{ asset('admins/plugins/moment/moment.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/daterangepicker/daterangepicker.js') }}"></script>
      <!-- Tempusdominus Bootstrap 4 -->
      <script src="{{ asset('admins/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
      <!-- Summernote -->
      <script src="{{ asset('admins/plugins/summernote/summernote-bs4.min.js') }}"></script>
      <!-- overlayScrollbars -->
      <script src="{{ asset('admins/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
      <!-- AdminLTE App -->
      <script src="{{ asset('admins/dist/js/adminlte.js') }}"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="{{ asset('admins/dist/js/demo.js') }}"></script>
      <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
      <script src="{{ asset('admins/dist/js/pages/dashboard.js') }}"></script>
      <!-- DataTables  & Plugins -->
      <script src="{{ asset('admins/plugins/datatables/jquery.dataTables.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/jszip/jszip.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/pdfmake/pdfmake.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/pdfmake/vfs_fonts.js') }}"></script>
      <script src="{{ asset('admins/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
      <!-- Select2 -->
      <script src="{{ asset('admins/plugins/select2/js/select2.full.min.js') }}"></script>
      <!-- Bootstrap4 Duallistbox -->
      <script src="{{ asset('admins/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
      <!-- InputMask -->
      <script src="{{ asset('admins/plugins/moment/moment.min.js') }}"></script>
      <script src="{{ asset('admins/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
      <!-- Bootstrap Switch -->
      <script src="{{ asset('admins/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
      <!-- BS-Stepper -->
      <script src="{{ asset('admins/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
      <!-- dropzonejs -->
      <script src="{{ asset('admins/plugins/dropzone/min/dropzone.min.js') }}"></script>
      <!-- SweetAlert2 -->
      <script src="{{ asset('admins/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
      <!-- Toastr -->
      <script src="{{ asset('admins/plugins/toastr/toastr.min.js') }}"></script>
      <!-- date-range-picker -->
      <script src="{{ asset('admins/plugins/daterangepicker/daterangepicker.js')}}"></script>

      <script>
         $(function () {
            $('.select2').select2()
            $('.select2bs4').select2({
               theme: 'bootstrap4'
            })
            $("#example1").DataTable({
               "responsive": true, "lengthChange": true, "autoWidth": true,
               "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
               "paging": true,
               "lengthChange": false,
               "searching": true,
               "ordering": true,
               "info": true,
               "autoWidth": false,
               "responsive": true,
            });
         });
      </script>
   </body>
</html>