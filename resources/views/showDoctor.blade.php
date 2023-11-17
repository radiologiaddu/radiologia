@extends('layouts.layout')
@section('title','Doctor '.$user->name)
@section('leve','Doctores')
@section('breadcrumb')
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
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Doctor: {{$user->name}}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('doctores') }}">Todos</a></li>
                    <li class="breadcrumb-item"><a href="#">{{$user->name}}</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <link rel="stylesheet" href="{{ asset('/css/doctor.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/misEstudios.css') }}">

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="ext-logo-image">
                    <div class="int-logo-image">
                        @if (!is_null($user->doctor))
                            <img
                                @if (!is_null($user->doctor->photo))
                                        src="{{ $user->doctor->photo}}" 
                                @else 
                                    src="{{ asset('/assets/images/user/defaultProfile.png')}}" 
                                @endif
                            class="img-radius" alt="User-Profile-Image">
                        @else
                            <img src="{{ asset('/assets/images/user/defaultProfile.png')}}" class="img-radius" alt="User-Profile-Image">
                        @endif
                        
                    </div>
                </div>
                <div class="text-mis-estudios">
                    <h2>{{$user->name}} 
                        @if (!is_null($user->doctor))
                            {{$user->doctor->paternalSurname}} {{$user->doctor->maternalSurname}}
                        @endif
                    </h2>
                    @if (!is_null($user->doctor))
                        <h4>{{$user->doctor->alias}}</h4>
                    @endif
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <h5>Email: </h5> <p>{{$user->email}}</p>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <h5>Status: </h5> 
                        @if (is_null($user->email_verified_at))
                            Sin verificar
                        @else
                            Verificado
                        @endif
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <h5>Fecha de alta: </h5> 
                        <p>
                            {{strftime("%d",strtotime($user->created_at))}} de 
                            {{strtoupper($months[strftime("%m",strtotime($user->created_at))])}} del
                            {{strftime("%Y",strtotime($user->created_at))}}               
                        </p>
                    </div>
                    @if (!is_null($user->doctor))
                        <div class="col-md-6 col-xl-4">
                            <h5>Fecha de verificación: </h5> 
                            <p>
                                {{strftime("%d",strtotime($user->email_verified_at))}} de 
                                {{strtoupper($months[strftime("%m",strtotime($user->email_verified_at))])}} del
                                {{strftime("%Y",strtotime($user->email_verified_at))}} 
                            </p>
                        </div>
                        <!--
                        <div class="col-md-6 col-xl-4">
                            <h5>Título: </h5> <p>{{$user->doctor->title}}</p>
                        </div>
                        -->
                        <div class="col-md-6 col-xl-4">
                            <h5>Especialidad: </h5> <p>{{$user->doctor->specialty}}</p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <h5>Género: </h5> <p>{{$user->doctor->gender}}</p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <h5>Fecha de Nacimiento: </h5> 
                            <p>
                                {{strftime("%d",strtotime($user->doctor->birthday))}} de 
                                {{strtoupper($months[strftime("%m",strtotime($user->doctor->birthday))])}} del
                                {{strftime("%Y",strtotime($user->doctor->birthday))}} 
                            </p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <h5>Teléfono: </h5> <p>{{$user->doctor->phone}}</p>
                        </div>
                    @endif
                </div>
            </div>
            @if (!is_null($studies))
                <div class="card-block">
                    <div class="title-block">
                        <h4>SUS ESTUDIOS</h4>
                        <a href="{{route('TodosestudiosAdmin',['id' => $user->doctor->id])}}">
                            <button type="button" class="btn-status btn btn-rounded btn-success">Ver todos sus estudios</button>
                        </a>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row scroll-studies">
                        @foreach ($studies as $study)
                            <div class="col-11 col-sm-6 col-md-6 col-xl-4">
                                <div class="card carrucel">
                                    <div class="card-header study-header">
                                        <h4 class="mt-3 mb-3 bold color-indigo">{{$study->patient_name}} {{$study->paternal_surname}} {{$study->maternal_surname}}</h4>
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
                                                {{$weekMap[strftime("%w",strtotime($study->appointment->date))]}}
                                                {{strftime("%d",strtotime($study->appointment->date))}}
                                                {{strtoupper($months[strftime("%m",strtotime($study->appointment->date))])}}
                                                {{strftime("%Y",strtotime($study->appointment->date))}}
                                                <br>
                                                {{$study->appointment->time}}
                                            @else
                                                Sin agendar cita
                                        @endif
                                        </h6>
                                        <div class="text-right">
                                            <a href="{{route('seeStudy',['id' => $study->id])}}">
                                                <button type="button" class="btn-status btn btn-rounded btn-success">Ver</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                </div> 
            @endif
            
        </div>
    </div>
    
@endsection