
<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="user-box">
    
                {{-- <div class="float-left">
                    <img src="{{ asset('/') }}assets/images/users/avatar-1.jpg" alt="" class="avatar-md rounded-circle">
                </div> --}}
                
                <div class="user-info">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{Auth::user()->usuario}} <i class="mdi mdi-chevron-down"></i> </a>
                        <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 29px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-face-profile mr-2"></i> Perfil<div class="ripple-wrapper"></div></a></li>
                            <li><a href="{{ route('logout') }}" class="dropdown-item"  onclick="event.preventDefault(); 
                                 document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-power-settings mr-2"></i> Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                    <p class="font-13 text-muted m-0"> EDUCACION</p>
                </div>
            </div>

            <ul class="metismenu" id="side-menu">

                <li>
                    <a href="{{route('sistema_acceder','1')}}" class="waves-effect">
                        <i class="mdi mdi-home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-folder-upload-outline"></i>
                        <span> Importar </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{route('PadronWeb.importar')}}">Padron Web - Inst. Educativas</a></li>
                        <li><a href="{{route('CuadroAsigPersonal.importar')}}">Asignacion de Personal</a></li>
                        <li><a href="{{route('ece.importar')}}">Eval. Censal de Estudiantes</a></li>      
                        <li><a href="{{route('Censo.importar')}}">Censo Educativo</a></li>                 
                    </ul>
                </li>

                <li>
                    <a href="{{route('importacion.inicio')}}" class="waves-effect">
                        <i class="mdi mdi-check-bold"></i>
                        <span> Aprobar Importación</span>                  
                    </a>                   
                </li>

                <li>
                    <a href="{{route('Clasificador.menu','01')}}" class="waves-effect">
                        <i class="mdi mdi-equalizer-outline"></i>
                        <span> Indicadores </span>
                    </a>                    
                </li>

                <li>
                    <a href="{{route('Clasificador.menu','04')}}" class="waves-effect">
                        <i class="mdi mdi-chart-tree"></i>
                        <span> PDRC </span>
                    </a>                    
                </li>

                <li>
                    <a href="{{route('Clasificador.menu','05')}}" class="waves-effect">
                        <i class="mdi mdi-equalizer"></i>
                        <span> Obj. Estrat. Instit. </span>
                    </a>                    
                </li>

                <li>
                    <a href="{{route('Clasificador.menu','06')}}" class="waves-effect">                        
                        <i class="mdi mdi-poll-box"></i>
                        <span> Act. Estrat. Instit. </span>
                    </a>                    
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-view-list"></i>
                        <span> Inst. Educativas </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="tables-basic.html">Basic Tables</a></li>
                        <li><a href="tables-datatable.html">Data Table</a></li>
                        <li><a href="tables-editable.html">Editable Table</a></li>
                        <li><a href="tables-responsive.html">Responsive Table</a></li>
                    </ul>
                </li>
           
{{-- 

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-email"></i>
                        <span> Mail </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="mail-inbox.html">Inbox</a></li>
                        <li><a href="mail-compose.html">Compose Mail</a></li>
                        <li><a href="mail-read.html">View Mail</a></li>
                    </ul>
                </li>

                <li>
                    <a href="calendar.html" class="waves-effect">
                        <i class=" mdi mdi-calendar"></i>
                        <span> Calendar </span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-palette"></i>
                        <span> Elements </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="ui-typography.html">Typography</a></li>
                        <li><a href="ui-buttons.html">Buttons</a></li>
                        <li><a href="ui-cards.html">Cards</a></li>
                        <li><a href="ui-checkbox-radio.html">Checkboxs-Radios</a></li>
                        <li><a href="ui-tabs-accordions.html">Tabs &amp; Accordions</a></li>
                        <li><a href="ui-modals.html">Modals</a></li>
                        <li><a href="ui-bootstrap.html">BS Elements</a></li>
                        <li><a href="ui-progressbars.html">Progress Bars</a></li>
                        <li><a href="ui-notification.html">Notification</a></li>
                        <li><a href="ui-sweet-alert2.html">Sweet-Alert2</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-invert-colors"></i>
                        <span> Components </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="components-grid.html">Grid</a></li>
                        <li><a href="components-portlets.html">Portlets</a></li>
                        <li><a href="components-widgets.html">Widgets</a></li>
                        <li><a href="components-nestable-list.html">Nestable</a></li>
                        <li><a href="components-rangeslider.html">Sliders </a></li>
                        <li><a href="components-gallery.html">Gallery </a></li>
                        <li><a href="components-pricing.html">Pricing Table </a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-atom-variant"></i>
                        <span> Icons </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="icons-material.html">Material Design</a></li>
                        <li><a href="icons-ion.html">Ion Icons</a></li>
                        <li><a href="icons-fontawesome.html">Font awesome</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-widgets"></i>
                        <span> Forms </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="form-elements.html">General Elements</a></li>
                        <li><a href="form-validation.html">Form Validation</a></li>
                        <li><a href="form-advanced.html">Advanced Form</a></li>
                        <li><a href="form-wizard.html">Form Wizard</a></li>
                        <li><a href="form-quilljs.html">Quilljs Editor</a></li>
                        <li><a href="form-uploads.html">Multiple File Upload</a></li>
                        <li><a href="form-xeditable.html">X-editable</a></li>
                    </ul>
                </li>

                

                

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-map-marker"></i>
                        <span> Maps </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="maps-google.html"> Google Map</a></li>
                        <li><a href="maps-vector.html"> Vector Map</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-table-plus"></i>
                        <span> Layouts </span>
                        <span class="badge badge-danger badge-pill float-right">New</span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="layouts-horizontal.html">Horizontal</a></li>
                        <li><a href="layouts-dark-sidebar.html">Dark Sidebar</a></li>
                        <li><a href="layouts-small-sidebar.html">Small Sidebar</a></li>
                        <li><a href="layouts-sidebar-collapsed.html">Sidebar Collapsed</a></li>
                        <li><a href="layouts-unsticky.html">Unsticky Layout</a></li>
                        <li><a href="layouts-boxed.html">Boxed Layout</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-google-pages"></i>
                        <span> Pages </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="pages-profile.html">Profile</a></li>
                        <li><a href="pages-timeline.html">Timeline</a></li>
                        <li><a href="pages-invoice.html">Invoice</a></li>
                        <li><a href="pages-email-template.html">Email template</a></li>
                        <li><a href="pages-contact.html">Contact-list</a></li>
                        <li><a href="pages-login.html">Login</a></li>
                        <li><a href="pages-register.html">Register</a></li>
                        <li><a href="pages-recoverpw.html">Recover Password</a></li>
                        <li><a href="pages-lock-screen.html">Lock Screen</a></li>
                        <li><a href="pages-blank.html">Blank Page</a></li>
                        <li><a href="pages-maintenance.html">Maintenance</a></li>
                        <li><a href="pages-coming-soon.html">Coming-soon</a></li>
                        <li><a href="pages-404.html">404 Error</a></li>
                        <li><a href="pages-404_alt.html">404 alt</a></li>
                        <li><a href="pages-500.html">500 Error</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-share-variant"></i>
                        <span> Multi Level </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="false">
                        <li>
                            <a href="javascript: void(0);">Level 1.1</a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" aria-expanded="false">Level 1.2
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-third-level nav" aria-expanded="false">
                                <li>
                                    <a href="javascript: void(0);">Level 2.1</a>
                                </li>
                                <li>
                                    <a href="javascript: void(0);">Level 2.2</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul> --}}

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->