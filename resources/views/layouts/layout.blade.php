<!DOCTYPE html>
<html lang="es">

    <head>
        <title>DDU | @yield('title')</title>
        <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 10]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Datta Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
        <meta name="keywords" content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, datta able, datta able bootstrap admin template">
        <meta name="author" content="Codedthemes" />

        <!-- Favicon icon -->
        <link rel="icon" href="{{ asset('/image/menta100.png') }}" type="image/x-icon">
        <!-- fontawesome icon -->
        <link rel="stylesheet" href="{{ asset('/assets/fonts/fontawesome/css/fontawesome-all.min.css') }}">
        <!-- animation css -->
        <link rel="stylesheet" href="{{ asset('/assets/plugins/animation/css/animate.min.css') }}">
        <!-- vendor css -->
        <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
        <!-- material icon -->
        <link rel="stylesheet" href="{{ asset('/assets/fonts/material/css/materialdesignicons.min.css') }}">
        <style>
            .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300{
                display: none;
            }
            .relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300{
                display: none;
            }
            p.text-sm.text-gray-700.leading-5 {
                visibility: hidden;
            }
            .table-responsive {
                overflow-y: clip;
            }
            .odd{
                background: white !important;
            }
            .odd:hover {
                background-color: rgba(4, 169, 245, 0.05) !important;
            }
            .card{
                overflow-wrap: anywhere !important;
            }
            .navbar-content{
                overflow: scroll;
            }
            .navbar-content::-webkit-scrollbar {
                    -webkit-appearance: none;
                    -webkit-appearance: none;
                    width: 3px;
                    height: 4px;
                    margin-left: 16px;
                    margin-right: 16px;
                }
            .navbar-content::-webkit-scrollbar-thumb{
                border-radius: 4px;
                background-color: #1dc4e9;
                -webkit-box-shadow: 0 0 1px #1dc4e9;
            }
        </style>
    </head>

    <body>
        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        <!-- [ Pre-loader ] End -->

        <!-- [ navigation menu ] start -->
        <nav class="pcoded-navbar">
            <div class="navbar-wrapper">
                <div class="navbar-brand header-logo">
                    <a href="{{route('users')}}" class="b-brand">
                        <img style="width:70px;" src="{{ asset('/image/menta200.png') }}" alt="logo">
                    </a>
                    <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
                </div>
                <div class="navbar-content scroll-div">
                    <ul class="nav pcoded-inner-navbar">
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item 
                        @if (trim($__env->yieldContent('leve')) == "Usuarios")
                            active
                        @endif">
                            <a href="{{route('users')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-user"></i></span><span class="pcoded-mtext">Usuarios</span></a>
                        </li>
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                        @if (trim($__env->yieldContent('leve')) == "Doctores")
                            active
                        @endif">
                            <a href="{{route('doctores')}}" class="nav-link"><span class="pcoded-micon"><i class="mdi mdi-doctor"></i></span><span class="pcoded-mtext">Doctores</span></a>
                        </li>
                        
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                        @if (trim($__env->yieldContent('leve')) == "DoctoresDDU")
                            active
                        @endif">
                            <a href="{{route('DoctoresDDU')}}" class="nav-link"><span class="pcoded-micon"><i class="mdi mdi-tooth-outline"></i></span><span class="pcoded-mtext">Doctores DDU</span></a>
                        </li>

                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                        @if (trim($__env->yieldContent('leve')) == "Radiologos")
                            active
                        @endif">
                            <a href="{{route('radiologia')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-clipboard"></i></span><span class="pcoded-mtext">Radiólogos</span></a>
                        </li>
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                        @if (trim($__env->yieldContent('leve')) == "Historial")
                            active
                        @endif">
                            <a href="{{route('record')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-folder"></i></span><span class="pcoded-mtext">Historial</span></a>
                        </li>
                        
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                            @if (trim($__env->yieldContent('leve')) == "Agenda")
                                active
                            @endif">
                            <a href="{{route('AgendaAdmin')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-calendar"></i></span><span class="pcoded-mtext">Agenda</span></a>
                        </li>
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                            @if (trim($__env->yieldContent('leve')) == "Statistics")
                                active
                            @endif">
                            <a href="{{route('statisticsAdmin')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-bar-chart"></i></span><span class="pcoded-mtext">Estadisiticas</span></a>
                        </li>
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item pcoded-hasmenu 
                            @if (trim($__env->yieldContent('leve')) == "setting")
                                active pcoded-trigger
                            @endif">
                            <a href="#!" class="nav-link"><span class="pcoded-micon"><i class="feather icon-settings"></i></span><span class="pcoded-mtext">Configuraciones</span></a>
                            <ul class="pcoded-submenu">
                                <li class="nav-item
                                    @if (trim($__env->yieldContent('subleve')) == "referral")
                                        active
                                    @endif">
                                    <a href="{{route('referidos')}}" class="">Referidos</a>
                                </li>
                                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                                    @if (trim($__env->yieldContent('subleve')) == "discounts")
                                        active
                                    @endif">
                                    <a href="{{route('discounts')}}" class="nav-link">
                                        <span class="pcoded-mtext">Descuentos</span>
                                    </a>
                                </li>
                                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                                @if (trim($__env->yieldContent('subleve')) == "Estudios")
                                    active
                                @endif">
                                    <a href="{{route('types')}}" class="nav-link">
                                        <span class="pcoded-mtext">Tipos de estudios</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item nav-logout">
                            <a href="{{ route('logout') }}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-log-out"></i></span><span class="pcoded-mtext">CERRAR SESIÓN</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- [ navigation menu ] end -->

        <!-- [ Header ] start -->
        <header class="navbar pcoded-header navbar-expand-lg navbar-light">
            <div class="m-header">
                <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
                <a href="{{route('users')}}" class="b-brand">
                    <img style="width:70px;" src="{{ asset('/image/menta200.png') }}" alt="logo">
                </a>
            </div>
            <a class="mobile-menu" id="mobile-header" href="#!">
                <i class="feather icon-more-horizontal"></i>
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li><a href="#!" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a></li>                  
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li>
                        <div class="dropdown drp-user">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon feather icon-settings"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-notification">
                                <div class="pro-head">
                                    <img src="{{ asset('/assets/images/user/Mail-DDU.png')}}" class="img-radius" alt="User-Profile-Image">
                                    <span>{{auth()->user()->name}}</span>
                                    <a href="{{ route('logout') }}" class="dud-logout" title="Logout">
                                        <i class="feather icon-log-out"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <!-- [ Header ] end -->

        <!-- [ Main Content ] start -->
        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <!-- [ breadcrumb ] start -->
                        <div class="page-header">
                            @yield('breadcrumb')
                        </div>
                        <!-- [ breadcrumb ] end -->
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- [ Main Content ] start -->
                                <div class="row">
                                    <!-- [ sample-page ] start -->
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->

        <!-- Warning Section Starts -->
        <!-- Older IE warning message -->
        <!--[if lt IE 11]>
            <div class="ie-warning">
                <h1>Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade
                <br/>to any of the following web browsers to access this website.
                </p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="assets/images/browser/chrome.png" alt="Chrome">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="assets/images/browser/firefox.png" alt="Firefox">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="assets/images/browser/opera.png" alt="Opera">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="assets/images/browser/safari.png" alt="Safari">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="assets/images/browser/ie.png" alt="">
                                <div>IE (11 & above)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->
        <!-- Warning Section Ends -->

        <!-- Required Js -->
        <script src="{{ asset('/assets/js/vendor-all.min.js') }}"></script>
        <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/assets/js/pcoded.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.loader-bg').hide();
            });
        </script>
        @yield('css')


    </body>
</html>