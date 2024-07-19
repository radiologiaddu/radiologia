@extends('layouts.layoutDr')
@section('title','Perfil')
@section('leve','Perfil')
@section('breadcrumb')

@endsection
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header row">
                <div class="col-4"> 
                    <div class="ext-logo-image">
                        <div class="int-logo-image">
                            @if (is_null(auth()->user()->doctor->photo))
                                <img src="{{ asset('assets/images/user/defaultProfile.png')}}" class="img-radius" alt="User-Profile-Image">
                            @else
                                <img src="{{auth()->user()->doctor->photo}}" class="img-radius" alt="User-Profile-Image">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-1"> 
                </div>
                <div class="text-mis-estudios mt-3 col-6">
                    <h2 style="font-weight: bold;font-size: 32px;">
                        {{auth()->user()->name}}
                        {{auth()->user()->doctor->paternalSurname}}
                        {{auth()->user()->doctor->maternalSurname}}
                    </h2>
                </div>
            </div>
            <div class="card-block row text-center">
                <div class="col-md-4">
                    <h4>Email:</h4>
                    <p>
                        {{auth()->user()->email}}
                    </p>
                </div>
                <div class="col-md-4">
                    <h4>Alias:</h4>
                    <p>
                        {{auth()->user()->doctor->alias}}
                    </p>
                </div>
                <div class="col-md-4">
                    <h4>Teléfono:</h4>
                    <p>
                        {{auth()->user()->doctor->phone}}
                    </p>
                </div>
                <div class="col-md-4">
                    <h4>Fecha de nacimiento:</h4>
                    <p>
                        {{auth()->user()->doctor->birthday}}
                    </p>
                </div>
                <div class="col-md-4">
                    <h4>Genero:</h4>
                    <p>
                        {{auth()->user()->doctor->gender}}
                    </p>
                </div>
                <div class="col-md-4">
                    <h4>Especialidad:</h4>
                    <p>
                        {{auth()->user()->doctor->specialty}}
                    </p>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-12 col-sm-12 mt-2">
                    <a href="{{route('EditProfil')}}">
                        <button id="save" type="button" class="btn btn-rounded btn-new">Editar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    @if ($status === 'Activo')
    <div class="col-sm-12" id="report-dr">
        <div class="card">
            <div class="card-block row text-center">
                <div class="col-md-12">
                    <h2 style="font-weight: bold; font-size: 32px;">REPORTE ANUAL</h2>
                    @if($studies->isEmpty())
                        <p>No hay estudios disponibles.</p>
                    @else
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Nombre del Paciente</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studies as $study)
                                    @if($study->status == 'Enviado')
                                        <tr>
                                            <td>
                                                @if ($study->internal == 1)
                                                    R{{ sprintf('%06d', $study->folio) }}
                                                @else
                                                    D{{ sprintf('%06d', $study->folio) }}
                                                @endif
                                            </td>
                                            <td>{{ $study->patient_name }}</td>
                                            <td>{{ $study->formatted_date }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="annual-return">
                                    <td colspan="2" style="text-align: right;"><strong>Cash Back DDU:</strong></td>
                                    <td><strong>${{ $annualReturnFormatted }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    @endif
                    <div class="logo-container">
                        <img src="https://res.cloudinary.com/ddu/image/upload/v1716922445/Descubriendo_Sonrisas_Logo_idrc2e.png" alt="Logo">
                    </div>
                    <h2>Gracias por ser parte de nuestro equipo</h2>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('css')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style>
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        border: 4px solid black;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 15px; /* Espacio debajo de la tabla */
    }
    .custom-table th, .custom-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .custom-table th {
        background-color: #6E7BDE;
        color: white;
    }
    .custom-table tr:nth-child(even) {
        background-color: #F9F9F9;
    }
    .custom-table tr:hover {
        background-color: #ddd;
    }
    .custom-table tfoot td {
        background-color: #F2F2F2;
        font-weight: bold;
    }
    .annual-return td {
        font-size: 16px; /* Aumentar 2px del tamaño de fuente predeterminado de 14px */
        font-weight: bold; /* Negritas para la fila de Rendimiento Anual */
    }
    h2 {
        margin-top: 15px;
        font-size: 22px; /* Disminuir el tamaño del texto */
    }
    .logo-container {
        text-align: center;
        margin-top: 15px;
    }
    .logo-container img {
        max-width: 20%;
        height: auto;
    }
    </style>
@endsection
