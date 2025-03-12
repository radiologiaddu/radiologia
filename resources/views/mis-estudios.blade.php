@extends('layouts.layoutDr')
@section('title','Mis estudios')
@section('leve','setting')
@section('subleve','Estudios')
@section('breadcrumb')

@endsection
@section('content')
<link rel="stylesheet" href="{{ asset('/css/misEstudios.css') }}">
<style>
            .study-header {
                position: relative; /* Necesario para que el icono absoluto esté posicionado dentro de este contenedor */
            }

            .comentarios {
    position: absolute;
    right: 13px;
    top: 15%;
    z-index: 1;
    font-size: 20px;
    color: #6e7bde;
    animation: pulse 2s infinite; /* Añade la animación "pulse" con duración de 2 segundos */
}

@keyframes pulse {
    0% {
        transform: scale(1); /* Tamaño original */
    }
    50% {
        transform: scale(1.2); /* Aumenta el tamaño al 120% */
    }
    100% {
        transform: scale(1); /* Vuelve al tamaño original */
    }
}


        </style>
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
                        <h4>Cash Back: {{$annualReturnFormatted}}</h4>
                        <a href="https://ddu.mx/shop">
                            <button type="button" class="btn btn-rounded btn-new">Tienda en Línea</button>
                        </a>
                    </div>
                @endif
            </div>
            <div class="card-block card-btn">
                <!-- Agregar este bloque en la sección donde quieras mostrar los cupones Editado para actualizar-->
                @if (count($cupones) > 0)
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
                                                                            case 'Cupon20':
                                                                                $descuento = '20% de Descuento';
                                                                                break;
                                                                            case 'Cupon15':
                                                                                $descuento = '15% de Descuento';
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
                                @if ($study->obs_recep != "" || $study->obs_rad !="")<i class="fa fa-comments comentarios" aria-hidden="true"></i>@endif
                                    <h4 class="mt-3 mb-3 bold color-indigo">{{$study->patient_name}} {{$study->paternal_surname}}</h4>
                                    <p>
                                        Recibido <strong> hace:  
                                            @if (($study->dias() + 0) == 0)
                                                @if (($study->horas() + 0) == 0)
                                                    {{ $study->minutos() + 0 }} minutos

                                                @else
                                                    {{ $study->horas() + 0 }} horas
                                                @endif

                                            @else
                                                {{ $study->dias() + 0 }} días

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
                                            {{strftime("%d",strtotime($study->appointment->date))}}
                                            de {{strtoupper($months[strftime("%m",strtotime($study->appointment->date))])}}
                                            del {{strftime("%Y",strtotime($study->appointment->date))}}
                                            <br>
                                            A las {{$study->appointment->time}}
                                        @else
                                            Sin agendar cita
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
    
@endsection
@section('css')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @if ($vA)  
        <script type="text/javascript">
            $(document).ready(function() {
                swal("Nuevo estudio generado","Se ha enviado un correo con código QR a tu paciente.", "success");
            });
        </script>
        @php
            session()->forget('flagModal');
        @endphp
    @endif
@endsection

