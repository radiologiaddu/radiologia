@extends('layouts.layoutHost')
@section('title', 'Todos los estudios')
@section('leve', 'Historial')
@section('breadcrumb')

@endsection
@section('content')
<link rel="stylesheet" href="{{ asset('/css/allStudy.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/plugins/data-tables/css/datatables.min.css') }}">
<style>
    tr {
        background: white !important
    }
    tr:hover {
        background: rgba(4, 169, 245, 0.05) !important
    }
    .table td, .table th {
        white-space: normal;
    }
    @media (max-width: 991px) {
        .card .card-header .card-header-right {
            display: block !important;
        }
    }
    @media (max-width: 767px) {
        .td-full {
            display: none !important;
        }
        .responisve {
            display: block !important;
        }
    }
</style>
@php
setlocale(LC_TIME, "spanish");
$weekMap = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
$months = [
    '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo',
    '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
    '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
];
@endphp

<div class="col-sm-12">
    <div class="shadow card">
        <div class="card-header">
            <h5>
                <span class="label label-success text-white f-12 btn-rounded">{{ $study->status }}</span>
                <br><br>FOLIO:
                @if ($study->internal == 1)
                    R{{ sprintf('%06d', $study->folio) }}
                @else
                    D{{ sprintf('%06d', $study->folio) }}
                @endif
            </h5>
            <div class="card-header-right">
                <div class="btn-group card-option">
                    <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expand="false" aria-expanded="false">
                        <i class="feather icon-more-horizontal"></i>
                    </button>
                    <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item"><a href="{{ route('showStudyRecep', ['id' => $id]) }}"><span><i class="feather icon-eye"></i>Ver estudio</span></a></li>
                        <li class="dropdown-item"><a href="{{ url()->previous() }}"><span><i class="feather icon-arrow-left"></i>Volver</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-block">
            <h5 class="d-inline">Paciente:
                <p class="d-inline">
                    {{ $study->patient_name }} {{ $study->paternal_surname }} {{ $study->maternal_surname }}
                </p>
            </h5>
            <br>
            <h5 class="d-inline">Doctor:
                <p class="d-inline">
                    @if ($study->doctor_id == 0)
                        {{ $study->doctor_name }}
                    @else
                        {{ $study->doctor->alias }}
                    @endif
                </p>
            </h5>
            <div class="card-block">
                <h5 class="d-inline">Observaciones de Recepción:</h5>
                <div class="col-12">
                    @if ($study->status === 'Enviado')
                        <!-- Mostrar texto cuando el estatus es "Enviado" -->
                        <p>{!! nl2br(e($study->obs_recep ?? 'Sin observaciones de recepción')) !!}</p>
                    @else
                        <!-- Formulario para editar y guardar observaciones -->
                        <form action="{{ route('studies.updateObsRecep', $study->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="obs_recep" id="obsRecep{{ $study->id }}" class="form-control" rows="3" placeholder="Agrega observaciones">{{ $study->obs_recep }}</textarea>
                            <button type="submit" class="btn btn-primary mt-2">Guardar Observaciones</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de registros -->
<div class="col-sm-12">
    <div class="card">
        <div class="card-block block-r">
            <div class="table-responsive">
                <table id="records" class="display table nowrap table-striped table-hover" style="width:100%">
                    <tbody>
                        @php $x = 1; @endphp
                        @foreach ($records as $record)
                        <tr>
                            <td class="td-full">
                                <h4>
                                    {{ $weekMap[date('w', strtotime($record->created_at))] }}
                                    {{ date('d', strtotime($record->created_at)) }}
                                    {{ strtoupper($months[date('m', strtotime($record->created_at))]) }}
                                    {{ date('Y', strtotime($record->created_at)) }}
                                </h4>
                                <br>
                                <h5>{{ date('H:i:s', strtotime($record->created_at)) }}</h5>
                            </td>
                            <td>
                                @if ($x > 1)
                                    <i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>
                                @else
                                    <i class="feather icon-disc f-30 text-c-green"></i>
                                @endif
                            </td>
                            <td>
                                <h4>{{ $record->action }}</h4>
                                <p>{{ $record->user }}<br>{{ $record->user_email }}</p>
                            </td>
                        </tr>
                        @php $x++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('/assets/plugins/data-tables/js/datatables.min.js') }}"></script>
<script src="{{ asset('/assets/js/pages/tbl-datatable-custom.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#records').DataTable({
            responsive: false,
            ordering: false,
            language: {
                emptyTable: "No se encontró información",
                info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                paginate: { next: "Siguiente", previous: "Anterior" }
            }
        });
    });
</script>
@endsection
