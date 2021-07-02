<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>SISMORE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @yield('css')  
        <meta content="Responsive bootstrap 4 admin template" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Plugins css-->
        <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
        {{-- {{assets('/')}} --}}
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">            

            @auth()               
                @include('layouts.navbars.navs.auth')
                @include('layouts.navbars.sidebar')
                {{-- @include('layouts.navbars.sidebarRight') --}}
                <div class="content-page">
                    <div class="content">
                        <div class="container-fluid">
                            @yield('content')  
                        </div>
                    </div>
                </div>
                @include('layouts.footers.auth')  
                          
            @endauth

            @guest()                        
                @yield('content')
            @endguest

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        
       
        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <script src="assets/libs/moment/moment.min.js"></script>
        <script src="assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
        <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
        
        <!-- Chat app -->
        <script src="assets/js/pages/jquery.chat.js"></script>

        <!-- Todo app -->
        <script src="assets/js/pages/jquery.todo.js"></script>

        <!-- flot chart -->
        {{-- <script src="assets/libs/flot-charts/jquery.flot.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.time.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.resize.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.pie.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.selection.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.stack.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.crosshair.js"></script> --}}

        <!-- Dashboard init JS -->
        {{-- <script src="assets/js/pages/dashboard.init.js"></script> --}}

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        @yield('js')
    </body>

</html>