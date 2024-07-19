<!DOCTYPE html>
<html lang="es">
    @php
    setlocale(LC_TIME, "spanish");
    $weekMap = [
        0 => 'domingo',
        1 => 'lunes',
        2 => 'martes',
        3 => 'miércoles',
        4 => 'jueves',
        5 => 'viernes',
        6 => 'sábado',
    ];
    $months = [
        '01' => 'Enero',
        '02' => 'Febrero',
        '03' => 'Marzo',
        '04' => 'Abril',
        '05' => 'Mayo',
        '06' => 'Junio',
        '07' => 'Julio',
        '08' => 'Agosto',
        '09' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre',
    ];
    @endphp
    <head>
        <title>DDU | Radiología</title>
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
        <link rel="icon" href="image/menta100.png" type="image/x-icon">
        <!-- fontawesome icon -->
        <link rel="stylesheet" href="assets/fonts/fontawesome/css/fontawesome-all.min.css">
        <!-- animation css -->
        <link rel="stylesheet" href="assets/plugins/animation/css/animate.min.css">
        <!-- vendor css -->
        <link rel="stylesheet" href="assets/css/style.css">

        <link rel="stylesheet" href="css/welcome.css">

        <link rel="stylesheet" href="{{ asset('/css/misEstudios.css') }}">
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
                        <img style="width:70px;" src="image/menta200.png" alt="logo">
                    </a>
                    <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
                </div>
                <div class="navbar-content scroll-div">
                    <ul class="nav pcoded-inner-navbar">
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item active">
                            <a href="{{route('Misestudios')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-vial"></i></span><span class="pcoded-mtext">MIS ESTUDIOS</span></a>
                        </li>
                        <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item">
                            <a href="{{route('Perfil')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-user-edit"></i></span><span class="pcoded-mtext">MI PERFIL</span></a>
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
                <a href="{{route('users')}}" class="b-brand logo-welcome">
                    <img style="width:100px;" src="image/blanco200.png" alt="logo">
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
                                    @if (is_null(auth()->user()->doctor->photo))
                                        <img src="{{ asset('assets/images/user/defaultProfile.png')}}" class="img-radius" alt="User-Profile-Image">
                                    @else
                                            <img src="{{auth()->user()->doctor->photo}}" class="img-radius" alt="User-Profile-Image">
                                    @endif
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

                        </div>
                        <!-- [ breadcrumb ] end -->
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- [ Main Content ] start -->
                                <div class="row viewPC">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="ext-logo-image">
                                                    <div class="int-logo-image">
                                                        @if (is_null(auth()->user()->doctor->photo))
                                                            <img src="{{ asset('assets/images/user/defaultProfile.png')}}" class="img-radius" alt="User-Profile-Image">
                                                        @else
                                                            <img src="{{auth()->user()->doctor->photo}}" class="img-radius" alt="User-Profile-Image">

                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="text-mis-estudios">
                                                    <h2>Hola, {{auth()->user()->name}}</h2>
                                                    <h4>¡Genera un nuevo estudio para tu paciente!</h4>
                                                </div>
                                                @if($doctorReport === 'Activo')
                                                <div>
                                                    <h5>Cash Back: {{$annualReturnFormatted}}</h5>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="card-block card-btn">
                                                <!-- Agregar este bloque en la sección donde quieras mostrar los cupones Editado para actualizar-->
                                                @if (count($cupones) > 0 && false)
                                                    <div class="card-block">
                                                        <div class="title-block">
                                                            <h4 style="color: #6E7BDE; animation: blink 3s infinite;">Tus Cupones</h4>
                                                        </div>
                                                        <div>
                                                            @php
                                                                $cupon10_count = 0;
                                                            @endphp
                                                            @foreach ($cupones as $cupon)
                                                                @if (strpos($cupon->nombre_cupon, 'Cupon10_') !== false)
                                                                    @if ($cupon->estatus == 'Activo')
                                                                        @php
                                                                            $cupon10_count++;
                                                                        @endphp
                                                                    @endif
                                                                @else
                                                                    @php
                                                                        $descuento = '';
                                                                        switch ($cupon->nombre_cupon) {
                                                                            /* case 'Cupon75':
                                                                                $descuento = '75% de Descuento';
                                                                                break; */
                                                                            case 'Cupon50':
                                                                                $descuento = '50% de Descuento';
                                                                                break;
                                                                            case 'Cupon25':
                                                                                $descuento = '25% de Descuento';
                                                                                break;
                                                                            default:
                                                                                $descuento = $cupon->nombre_cupon;
                                                                                break;
                                                                        }
                                                                    @endphp
                                                                    <div>{{ $descuento }}</div>
                                                                @endif
                                                            @endforeach
                                                            @if ($cupon10_count > 0)
                                                                <div>10% de descuento ({{ $cupon10_count }})</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endif
                                                <a href="{{route('Nuevoestudio')}}">
                                                    <button type="button" class="btn btn-rounded btn-new">NUEVO ESTUDIO</button>
                                                </a>
                                            </div>
                                            <div class="card-block">
                                                <div class="title-block">
                                                    <h4>ÓRDENES SOLICITADAS</h4>
                                                </div>
                                                <div class="link-block">
                                                    <h6>Los 6 estudios más recientes:</h6>
                                                    <a href="{{route('Todosestudios')}}">
                                                        <h6>Ver todos</h6>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-block">
                                                <div class="row scroll-studies">
                                                    @foreach ($studies as $study)
                                                        <div class="col-11 col-sm-6 col-md-6 col-xl-4">
                                                            <div class="card carrucel">
                                                                <div class="card-header study-header">
                                                                    <h4 class="mt-3 mb-3 bold color-indigo">{{$study->patient_name}} {{$study->paternal_surname}}</h4>
                                                                    <p>
                                                                        Recibido <strong> hace: 
                                                                        @if (($study->dias() + 0) == 0)
                                                                            @if (($study->horas() + 0) == 0)
                                                                                {{ $study->minutos() + 0 }} Minutos
                            
                                                                            @else
                                                                                {{ $study->horas() + 0 }} Horas
                                                                            @endif
                            
                                                                        @else
                                                                            {{ $study->dias() + 0 }} Días
                            
                                                                        @endif
                                                                        </strong>
                                                                    </p>
                                                                </div>
                                                                <div class="card-block card-status">
                                                                    <h4 class="mb-3 color-light-gray">
                                                                        <strong>Folio:</strong> 
                                                                        @if ($study->internal == 1)
                                                                            R{{sprintf('%06d',$study->folio)}}
                                                                        @else
                                                                            D{{sprintf('%06d',$study->folio)}}
                                                                        @endif
                                                                    </h4>
                                                                    <h6>
                                                                        @if (isset($study->appointment))
                                                                            Para el {{$weekMap[strftime("%w",strtotime($study->appointment->date))]}}
                                                                            de {{strftime("%d",strtotime($study->appointment->date))}}
                                                                            {{strtoupper($months[strftime("%m",strtotime($study->appointment->date))])}}
                                                                            del {{strftime("%Y",strtotime($study->appointment->date))}}
                                                                            <br>
                                                                            A las {{$study->appointment->time}}
                                                                        @else
                                                                            No ha agendado cita.
                                                                    @endif
                                                                    </h6>
                                                                    <div class="text-right">
                                                                        <a href="{{route('showStudy',['id' => $study->id])}}">
                                                                            <button type="button" class="btn-status btn btn-rounded btn-success">Ver</button>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row viewCell">
                                    <!-- [ sample-page ] start -->
                                    <div class="ext-logo-image">
                                        <div class="int-logo-image">
                                            @if (is_null(auth()->user()->doctor->photo))
                                                <img src="{{ asset('assets/images/user/defaultProfile.png')}}" class="img-radius" alt="User-Profile-Image">
                                            @else
                                                <img src="{{auth()->user()->doctor->photo}}" class="img-radius" alt="User-Profile-Image">

                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-welcome">
                                        <h4>¡Hola {{auth()->user()->doctor->alias}}!</h4>
                                    </div>
                                    <div class="button-welcome"> 
                                        <a href="{{route('Misestudios')}}">
                                            <button type="button" class="btn btn-rounded btn-light d-block">MIS ESTUDIOS</button>
                                        </a>
                                        <a href="{{route('Perfil')}}">
                                            <button type="button" class="btn btn-rounded btn-light d-block">MI PERFIL</button>
                                        </a>
                                    </div>
                                    <div class="logout-welcome"> 
                                        <a href="{{ route('logout') }}">
                                            CERRAR SESIÓN
                                        </a>
                                    </div>
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
        <script src="assets/js/vendor-all.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/pcoded.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.loader-bg').hide();
            });
        </script>
    </body>
</html>