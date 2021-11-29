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
        <link rel="shortcut icon" href="{{ asset('/') }}assets/images/favicon.ico">

        <!-- Plugins css-->
        <link href="{{ asset('/') }}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="{{ asset('/') }}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="{{ asset('/') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/') }}assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

        {{-- {{assets('/')}} --}}
        <!-- estilos personalizados XD-->
        <link rel="stylesheet" href="{{ asset('/') }}assets/css/otros/personalizado.css"  type='text/css'>
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">            

            @auth()               
                @include('layouts.navbars.navs.auth')
                @include('layouts.navbars.sidebar')
                {{-- @include('layouts.navbars.sidebarRight') --}}
                   <!-- start page title -->
                
                <div class="content-page">
                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    @if ($titlePage!='')
                                    <div class="page-title-box">
                                        <h4 class="page-title">{{ $titlePage }}</h4>  
                                        <div class="page-title-right">
                                            <ol class="breadcrumb p-0 m-0">
                                                @isset($breadcrumb)
                                                    @foreach ($breadcrumb as $key => $item)
                                                        @if ($key==count($breadcrumb)-1)
                                                        <li class="breadcrumb-item">{{$item['titulo']}}</li>    
                                                        @else
                                                        <li class="breadcrumb-item"><a href="{{$item['url']}}">{{$item['titulo']}}</a></li>
                                                        @endif
                                                    @endforeach
                                                @endisset
                                            </ol>
                                        </div>                                       
                                        <div class="clearfix"></div>
                                    </div>                                        
                                    @else
                                        <br>
                                    @endif

                                </div>
                            </div>

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
        <script src="{{ asset('/') }}assets/js/vendor.min.js"></script>

        <script src="{{ asset('/') }}assets/libs/moment/moment.min.js"></script>
        <script src="{{ asset('/') }}assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
        <script src="{{ asset('/') }}assets/libs/sweetalert2/sweetalert2.min.js"></script>
        
        <!-- Chat app -->
        <script src="{{ asset('/') }}assets/js/pages/jquery.chat.js"></script>

        <!-- Todo app -->
        <script src="{{ asset('/') }}assets/js/pages/jquery.todo.js"></script>

        <script src="{{ asset('/') }}assets/libs/toastr/toastr.min.js"></script>
        <script src="{{ asset('/') }}assets/js/bootbox.js"></script>
        

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
        <script src="{{ asset('/') }}assets/js/app.min.js"></script>
        <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000"
            } 
        </script>
        @yield('js')
    </body>

</html>