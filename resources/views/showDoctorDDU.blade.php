@extends('layouts.layout')
@section('title','Doctor '.$doctor->name)
@section('leve','DoctoresDDU')
@section('breadcrumb')
@php
setlocale(LC_TIME, "spanish");

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
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('DoctoresDDU') }}">Doctores DDU</a></li>
                    <li class="breadcrumb-item"><a href="#">{{$doctor->name}}</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5><span class="p-l-5">{{$doctor->name}}</span></h5>
            </div>
            <div class="card-body">
                <h5 class="mb-3"><i class="feather icon-user text-c-blue wid-20"></i>DATOS GENERALES</h5>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="">Nombre (s)</td>
                            <td class="">:</td>
                            <td class="">{{$doctor->name}}</td>
                        </tr>
                        <tr>
                            <td class="">Primer Apellido</td>
                            <td class="">:</td>
                            <td class="">{{$doctor->paternalSurname}}</td>
                        </tr>
                        <tr>
                            <td class="">Segundo Apellido</td>
                            <td class="">:</td>
                            <td class="">{{$doctor->maternalSurname}}</td>
                        </tr>
                        <tr>
                            <td class="">Alias</td>
                            <td class="">:</td>
                            <td class="">{{$doctor->alias}}</td>
                        </tr>
                        <tr>
                            <td class="">Fecha de nacimiento</td>
                            <td class="">:</td>
                            <td class="">
                                {{strftime("%d",strtotime($doctor->birthday))}} de 
                                {{strtoupper($months[strftime("%m",strtotime($doctor->birthday))])}} del
                                {{strftime("%Y",strtotime($doctor->birthday))}}
                            </td>                            
                        </tr>
                        <tr>
                            <td class="">Género</td>
                            <td class="">:</td>
                            <td class="">{{$doctor->gender}}</td>
                        </tr>
                        <tr>
                            <td class="">Celular</td>
                            <td class="">:</td>
                            <td class="">{{$doctor->phone}}</td>
                        </tr>
                        <tr>
                            <td class="">Email</td>
                            <td class="">:</td>
                            <td class="">{{$doctor->email}}</td>
                        </tr>
                        <tr>
                            <td class="">RFC</td>
                            <td class="">:</td>
                            <td class="">{{$doctor->rfc}}</td>
                        </tr>
                    </tbody>
                </table>
                <h5 class="mt-5 mb-4 pb-3"><i class="mdi mdi-tooth-outline text-c-blue wid-20"></i>MI ESPECIALIDAD</h5>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="">Especialidad</td>
                            <td class="">:</td>
                            <td class="">{{$doctor->specialty}}</td>
                        </tr>
                    </tbody>
                </table>
                <h5 class="mt-5 mb-4 pb-3 border-bottom"><i class="mdi mdi-certificate text-c-blue wid-20"></i>MIS GRADOS PROFESIONALES</h5>
                @foreach ($doctor->cedula as $cedula)
                    <div class="row align-items-center mb-3 border-bottom">
                        <div class="col-sm-3">
                            <h5>{{$cedula->year}}</h5>
                        </div>
                        <div class="col-sm-9 border-start">
                            <h6>{{$cedula->campus}}</h6>
                        </div>
                    </div>
                @endforeach
                @if (!is_null($doctor->career))
                    <div class="row align-items-center mb-3">
                        <div class="col-sm-3">
                            <h5>{{$doctor->career->year}}</h5><span>{{$doctor->career->degree}}</span>
                        </div>
                        <div class="col-sm-9 border-start">
                            <h6>{{$doctor->career->career}}</h6>
                            <p>{{$doctor->career->campus}}</p>
                        </div>
                    </div>
                @endif
            
                <h5 class="mt-5 mb-4 pb-3 border-bottom"><i class="mdi mdi-worker text-c-blue wid-20"></i>TRABAJO</h5>
                @foreach ($doctor->jobs as $job)
                    <div class="row align-items-center mb-3 border-bottom">
                        @switch($job->type)
                            @case("ownOffice")
                                <div class="col-sm-3">
                                    <h5>
                                        Tengo Consultorio Propio
                                    </h5>
                                </div>
                                <div class="col-sm-9 border-start">
                                    @if (!is_null($job->address))
                                        <h6 class="mt-3">Dirección</h6>
                                        <p class="mb-1">
                                            {{$job->address}}
                                        </p>
                                    @endif
                                    @if (!is_null($job->location))
                                        <h6 class="mt-3">Ubicación en Google Maps</h6>
                                        <p class="mb-1">
                                            {{$job->location}}
                                        </p>
                                    @endif
                                    @if (!is_null($job->phone))
                                        <h6 class="mt-3">Teléfono</h6>
                                        <p class="mb-1">
                                            {{$job->phone}}
                                        </p>
                                    @endif
                                    @if (!is_null($job->nameAssistant))
                                        <h6 class="mt-3">Asistente</h6>
                                        <p class="mb-1">
                                            {{$job->nameAssistant}}
                                        </p>
                                    @endif
                                </div>
                                @break
                            @case("clinic")
                                <div class="col-sm-3">
                                    <h5>
                                        Soy parte de una Clínica
                                    </h5>
                                </div>
                                <div class="col-sm-9 border-start">
                                    @if (!is_null($job->name))
                                        <h6 class="mt-3">Clínica</h6>
                                        <p class="mb-1">
                                            {{$job->name}}
                                        </p>
                                    @endif
                                    @if (!is_null($job->address))
                                        <h6 class="mt-3">Dirección</h6>
                                        <p class="mb-1">
                                            {{$job->address}}
                                        </p>
                                    @endif
                                    @if (!is_null($job->location))
                                        <h6 class="mt-3">Ubicación en Google Maps</h6>
                                        <p class="mb-1">
                                            {{$job->location}}
                                        </p>
                                    @endif
                                    @if (!is_null($job->colleagues))
                                        <h6>Colegas</h6>
                                        @foreach ($job->colleagues as $colleague)
                                            <li>{{$colleague->name}}</li>
                                        @endforeach
                                    @endif
                                </div>
                                @break
                            @case("variousClinics")
                                <div class="col-sm-3">
                                    <h5>
                                        Atiendo en varios consultorios
                                    </h5>
                                </div>
                                <div class="col-sm-9 border-start">
                                    @if (!is_null($job->clinicas))
                                        <h6>Planteles de Salud</h6>
                                        @foreach ($job->clinicas as $clinica)
                                            <li>{{$clinica->name}}</li>
                                        @endforeach
                                    @endif
                                    @if (!is_null($job->cities))
                                        <h6>Ciudades</h6>
                                        @foreach ($job->cities as $city)
                                            <li>{{$city->name}}</li>
                                        @endforeach
                                    @endif
                                </div>
                                @break
                            @case("student")
                                <div class="col-sm-4">
                                    <h5>
                                        Soy estudiante pero trabajo de aprendiz / becario en un consultorio
                                    </h5>
                                </div>

                                <div class="col-sm-8 border-start">
                                    @if (!is_null($job->nameDoctor))
                                        <h6>Colaboro en el consultorio del Dr./Dra.</h6>
                                        <p class="mb-1">
                                            {{$job->nameDoctor}}
                                        </p>
                                    @endif
                                    @if (!is_null($job->name))
                                        <h6 class="mt-3">Colaboro en la clínica</h6>
                                        <p class="mb-1">
                                            {{$job->name}}
                                        </p>
                                    @endif
                                    @if (!is_null($job->location))
                                        <h6 class="mt-3">Ubicación en Google Maps</h6>
                                        <p class="mb-1">
                                            {{$job->location}}
                                        </p>
                                    @endif
                                </div>
                                @break
                            @case("noWork")
                                <div class="col-sm-12">
                                    <h5>
                                        Aún no trabajo, soy estudiante
                                    </h5>
                                </div>
                                @break
                            @default
                                
                        @endswitch

                    </div>
                @endforeach
               

                <h5 class="mt-5 mb-4 pb-3 border-bottom">
                    <i class="mdi mdi-account-group text-c-blue wid-20"></i>REDES SOCIALES
                </h5>
                @foreach ($doctor->networks as $network)
                    <div class="row align-items-center mt-3">
                        @switch($network->type)
                            @case("personalBranding")
                                <div class="col-12 mb-3">
                                    <h5 class="m-b-10 text-muted">Personales</h5>
                                </div>
                                @break
                            @case("trademark")
                                <div class="col-12 mb-3">
                                    <h5 class="m-b-10 text-muted">Marca comercial</h5>
                                </div>
                                @if (!is_null($network->name))
                                    <div class="col-md-6 mb-3">
                                        <h6 class="m-b-10 text-muted">Nombre de marca</h6>
                                        <p class="mb-1">
                                            {{$network->name}}
                                        </p>
                                    </div>                                    
                                @endif
                                @break
                            @case("workClinic")
                                <div class="col-12 mb-3">
                                    <h5 class="m-b-10 text-muted">Clinica donde trabajo</h5>
                                </div>
                                @if (!is_null($network->name))
                                    <div class="col-md-6 mb-3">
                                        <h6 class="m-b-10 text-muted">Nombre de clínica</h6>
                                        <p class="mb-1">
                                            {{$network->name}}
                                        </p>
                                    </div>                                    
                                @endif
                                @break
                            @default
                                
                        @endswitch
                        @if (!is_null($network->facebook))
                            <div class="col-md-6 mb-3">
                                <h6 class="m-b-10 text-muted">Facebook</h6>
                                <p class="mb-1">
                                    {{$network->facebook}}
                                </p>
                            </div>                                    
                        @endif
                        @if (!is_null($network->instagram))
                            <div class="col-md-6 mb-3">
                                <h6 class="m-b-10 text-muted">Instagram</h6>
                                <p class="mb-1">
                                    {{$network->instagram}}
                                </p>
                            </div>                                    
                        @endif
                        @if (!is_null($network->tiktok))
                            <div class="col-md-6 mb-3">
                                <h6 class="m-b-10 text-muted">TikTok</h6>
                                <p class="mb-1">
                                    {{$network->tiktok}}
                                </p>
                            </div>                                    
                        @endif
                        @if (!is_null($network->linkedin))
                            <div class="col-md-6 mb-3">
                                <h6 class="m-b-10 text-muted">LinkedIn</h6>
                                <p class="mb-1">
                                    {{$network->linkedin}}
                                </p>
                            </div>                                    
                        @endif
                        @if (!is_null($network->website))
                            <div class="col-md-6 mb-3">
                                <h6 class="m-b-10 text-muted">Website</h6>
                                <p class="mb-1">
                                    {{$network->website}}
                                </p>
                            </div>                                    
                        @endif
                        @if (!is_null($network->doctoralia))
                        <div class="col-md-6 mb-3">
                            <h6 class="m-b-10 text-muted">Doctoralia</h6>
                            <p class="mb-1">
                                {{$network->doctoralia  }}
                            </p>
                        </div>                                    
                    @endif
                    </div>
                    <hr>
                @endforeach
                
            </div>
        </div>
    </div>
    
@endsection