 <!-- Topbar Start -->
 <div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        
        <li class="dropdown notification-list d-none d-md-inline-block">
            <a href="#" id="btn-fullscreen" class="nav-link waves-effect waves-light">
                <i class="mdi mdi-crop-free noti-icon"></i>
            </a>
        </li>
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" 
            aria-haspopup="false" aria-expanded="false">
                {{-- <img src="assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle"> --}}
                {{Auth::user()->name}}
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Bienvenid@ !</h6>
                </div>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="mdi mdi-face-profile"></i>
                    <span>Perfil</span>
                </a>
               
                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="{{ route('logout') }}" class="dropdown-item notify-item"
                    onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-power-settings"></i>
                    <span>Cerrar Sesión</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                
                
                

            </div>
        </li>

        {{-- <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                <i class="mdi mdi-settings-outline noti-icon"></i>
            </a>
        </li> --}}

    </ul>    


    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="mdi mdi-menu"></i>
            </button>
        </li>

        {{-- <br>         --}}
        {{-- <p style="color: white"> <font SIZE=4>SISTEMA DE MONITOREO REGIONAL - SISMORE</font></p> --}}

        {{-- BUSQUEDA--}}
        {{-- <li class="d-none d-sm-block">
            <form class="app-search">
                <div class="app-search-box">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                            <button class="btn" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </li>  --}}
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{ route('home') }}" class="logo text-center logo-dark">
            <span class="logo-lg">
                <img src="{{ asset('/') }}assets/images/logo-GRU-a1.png" alt="" height="16">
                <!-- <span class="logo-lg-text-dark">SISMORE</span> -->
            </span>
            <span class="logo-sm">
                <!-- <span class="logo-lg-text-dark">M</span> -->
                <img src="{{ asset('/') }}assets/images/logo-GRU-a1.png" alt="" height="25">
            </span>
        </a>

        <a href="{{ route('home') }}" class="logo text-center logo-light">
            <span class="logo-lg">
                <img src="{{ asset('/') }}assets/images/logo-light-blanco.png" alt="" height="28"> 
                {{-- inicial --}}
                <!-- <span class="logo-lg-text-dark">SISMORE</span> -->
            </span>
            <span class="logo-sm">
                <!-- <span class="logo-lg-text-dark">M</span> -->
                <img src="{{ asset('/') }}assets/images/logo-light-blanco.png" alt="" height="28">
            </span>
        </a>
    </div> 


    {{-- <div>
        <br><h3>SISTEMA DE MONITOREO REGIONAL </h3>
    </div>
    --}}

<!-- LOGO -->
</div>
<!-- end Topbar -->

