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

        <link rel="stylesheet" href="{{ asset('/css/doctor.css') }}">
        <style>
            .odd{
                background: white !important;
            }
            .odd:hover {
                background-color: rgba(4, 169, 245, 0.05) !important;
            }
            .card{
                overflow-wrap: anywhere !important;
            }
            .btn-newL{
                -webkit-box-shadow: 12px 13px 30px 10px rgba(59,59,59,0.75); 
                box-shadow: 12px 13px 30px 10px rgba(59,59,59,0.75);
                border-color:  #13c095;
                border-bottom: 5px solid #13c095;
            }           
            .btn-newL:hover {
                border-color:  #06624b;
            }
            #btn-newPluse{
                display: none;
            }
            .btn-newStudyHRCel{
                display: none;
            }
            @media (max-width: 1200px) {
                #btn-newPluse{
                    display: inline;
                }
                #btn-newText{
                    display: none;
                }
            }
            @media (max-width: 991px) {
                .btn-newStudyHR{
                    display: none;
                }
                .btn-newStudyHRCel{
                    display: block;
                }
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
                    @if (auth()->user()->hasRole('Hostess'))
                    @endif
                    @if (auth()->user()->hasRole('Recepcion'))
                        <div class="col-12 text-center btn-newStudyHR">
                            <a href="{{route('nuevoEstudioRec')}}">
                                <button type="button" class="btn btn-rounded btn-success btn-newL">
                                    <span id="btn-newText">Nuevo Estudio</span>
                                    <span id="btn-newPluse"><i class="fas fa-plus-circle"></i></span>
                                </button>
                            </a>
                        </div>
                    @endif
                    <ul class="nav pcoded-inner-navbar">
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                        @if (trim($__env->yieldContent('leve')) == "Nuevos")
                            active
                        @endif">
                        @if (auth()->user()->hasRole('Coordinador'))
                            <a href="{{route('coordinador')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-vial"></i></span><span class="pcoded-mtext">Nuevos</span></a>                            
                        @else
                            @if (auth()->user()->hasRole('Radiologo'))
                                <a href="{{route('Radiologo')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-vial"></i></span><span class="pcoded-mtext">Nuevos</span></a>                            
                            @else
                                <a href="{{route('recepcion')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-vial"></i></span><span class="pcoded-mtext">Nuevos</span></a>                            
                            @endif
                        @endif
                        </li>
                        @if (auth()->user()->hasRole('Hostess'))
                            <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                            @if (trim($__env->yieldContent('leve')) == "Precios")
                                active
                            @endif">
                                <a href="{{route('prices')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-dollar-sign"></i></span><span class="pcoded-mtext">Precios</span></a>
                            </li>
                            <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                            @if (trim($__env->yieldContent('leve')) == "Pasados")
                                active
                            @endif">
                                <a href="{{route('pasados')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-hourglass"></i></span><span class="pcoded-mtext">Pasados</span></a>
                            </li>
                        @endif
                         
                        @if (auth()->user()->hasRole('Recepcion'))
                            <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                            @if (trim($__env->yieldContent('leve')) == "Envios")
                                active
                            @endif">
                                <a href="{{route('sendStudy')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-envelope"></i></span><span class="pcoded-mtext">Buzón de envíos</span></a>
                            </li>
                            <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                            @if (trim($__env->yieldContent('leve')) == "Historial")
                                active
                            @endif">
                                <a href="{{route('recordRec')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-folder"></i></span><span class="pcoded-mtext">Historial</span></a>
                            </li>
                            <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                                @if (trim($__env->yieldContent('leve')) == "Agenda")
                                    active
                                @endif">
                                <a href="{{route('AgendaRecepcion')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-calendar"></i></span><span class="pcoded-mtext">Agenda</span></a>
                            </li>
                        @endif
                        @if (auth()->user()->hasRole('Coordinador'))
                            <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                            @if (trim($__env->yieldContent('leve')) == "Doctores")
                                active
                            @endif">
                                <a href="{{route('doctoresCoor')}}" class="nav-link"><span class="pcoded-micon"><i class="mdi mdi-doctor"></i></span><span class="pcoded-mtext">Doctores</span></a>
                            </li>
                            <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                                @if (trim($__env->yieldContent('leve')) == "Agenda")
                                    active
                                @endif">
                                <a href="{{route('agenda')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-calendar"></i></span><span class="pcoded-mtext">Agenda</span></a>
                            </li>
                            <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                            @if (trim($__env->yieldContent('leve')) == "Historial")
                                active
                            @endif">
                                <a href="{{route('recordCoo')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-folder"></i></span><span class="pcoded-mtext">Historial</span></a>
                            </li>
                        @endif
                        @if (auth()->user()->hasRole('Radiologo'))
                            <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item
                                @if (trim($__env->yieldContent('leve')) == "Agenda")
                                    active
                                @endif">
                                <a href="{{route('AgendaRadiologo')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-calendar"></i></span><span class="pcoded-mtext">Agenda</span></a>
                            </li>
                        @endif
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
                <a href="#" class="b-brand logo-doctor">
                    <img style="width:100px;" src="{{ asset('/image/blanco200.png') }}" alt="logo">
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
                                    <img src="{{ asset('/assets/images/user/Mail-DDU.png') }}" class="img-radius" alt="User-Profile-Image">
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