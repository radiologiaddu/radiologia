@extends('layouts.layoutHost')
@section('title','Todos los estudios')
@section('leve','Historial')
@section('breadcrumb')

@endsection
@section('content')
<link rel="stylesheet" href="{{ asset('/css/allStudy.css') }}">
    <!-- data tables css -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/data-tables/css/datatables.min.css') }}">
<style>
    tr{
        background: white !important
    }
    tr:hover{
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
        .responisve{
            display: block !important;
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
        <div class="shadow card">
            <div class="card-header">
                <h5>
                    <span class="label label-success text-white f-12 btn-rounded">{{$study->status}}</span> <br><br>FOLIO: 
                    @if ($study->internal == 1)
                        R{{sprintf('%06d',$study->folio)}}
                    @else
                        D{{sprintf('%06d',$study->folio)}}
                    @endif
                </h5>
                <div class="card-header-right">
                    <div class="btn-group card-option">
                        <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expand="false" aria-expanded="false">
                            <i class="feather icon-more-horizontal"></i>
                        </button>
                        <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-115px, 45px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <li class="dropdown-item"><a href="{{route('showStudyCoo',['id' => $id])}}"><span><i class="feather icon-eye"></i>Ver estudio</span></a></li>
                            <li class="dropdown-item"><a href="{{ url()->previous() }}"><span><i class="feather icon-arrow-left"></i>Volver</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <h5 class="d-inline">Paciente:
                    <p class="d-inline">
                        {{$study->patient_name}} {{$study->paternal_surname}} {{$study->maternal_surname}}
                    </p>
                </h5>
                <br>
                <h5 class="d-inline">Doctor:
                    <p class="d-inline">
                        @if ($study->doctor_id == 0)
                            {{$study->doctor_name}}
                        @else
                            {{$study->doctor->alias}}
                        @endif
                    </p>
                </h5>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-block block-r">
                <div class="table-responsive">
                    <!--
                    <table id="zero-configurationo" class="display table nowrap table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="tMovil">Usuario</th>
                                <th class="tMovil">Correo de usuario</th>
                                <th class="tMovil">Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                            <tr>
                                <td class="tMovil">{{$record->user}}</td>
                                <td class="tMovil">{{$record->user_email}}</td>
                                <td class="tMovil">
                                        {{$weekMap[strftime("%w",strtotime($record->created_at))]}}
                                        {{strftime("%d",strtotime($record->created_at))}}
                                        {{strtoupper($months[strftime("%m",strtotime($record->created_at))])}}
                                        {{strftime("%Y",strtotime($record->created_at))}}
                                        <br>
                                        {{strftime("%T",strtotime($record->created_at))}}
                                </td>
                                <td>{{$record->action}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    -->
                    <table id="records" class="display table nowrap table-striped table-hover" style="width:100%">
                        <tbody>
                            @php
                                $x = 1;
                            @endphp
                            @foreach ($records as $record)
                            <tr>
                                <td class="td-full">
                                    <h4>
                                        {{$weekMap[strftime("%w",strtotime($record->created_at))]}}
                                        {{strftime("%d",strtotime($record->created_at))}}
                                        {{strtoupper($months[strftime("%m",strtotime($record->created_at))])}}
                                        {{strftime("%Y",strtotime($record->created_at))}}
                                    </h4>
                                    <br>
                                    <h5>
                                        {{strftime("%T",strtotime($record->created_at))}}
                                    </h5>
                                    
                                </td>
                                <td>
                                    @if ($x > 1)
                                        <i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>
                                    @else
                                        <i class="feather icon-disc f-30 text-c-green"></i>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-none responisve">
                                        <h4>
                                            {{$weekMap[strftime("%w",strtotime($record->created_at))]}}
                                            {{strftime("%d",strtotime($record->created_at))}}
                                            {{strtoupper($months[strftime("%m",strtotime($record->created_at))])}}
                                            {{strftime("%Y",strtotime($record->created_at))}}
                                        </h4>
                                        <h5>
                                            {{strftime("%T",strtotime($record->created_at))}}
                                        </h5>
                                        <hr>
                                    </div>
                                    <h4>
                                        {{$record->action}}
                                    </h4>
                                    <p>
                                        {{$record->user}}
                                        <br>
                                        {{$record->user_email}}
                                    </p>
                                </td>
                            </tr>
                            @php
                                $x++;
                            @endphp
                            @endforeach
                    </table>
                </div>
            </div>
            <div class="card-block text-center">
                <a href="{{route('showStudyCoo',['id' => $id])}}">
                    <button type="button" class="btn-status btn btn-rounded btn-success">Mostrar Estudio</button>
                </a>
                <a href="{{ url()->previous() }}">
                    <button type="button" class="btn btn-rounded btn-primary">Volver</button>
                </a>
            </div>
        </div>
    </div>
    
@endsection
@section('css')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- datatable Js -->
    <script src="{{ asset('/assets/plugins/data-tables/js/datatables.min.js') }} "></script>
    <script src="{{ asset('/assets/js/pages/tbl-datatable-custom.js') }} "></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $.fn.dataTableExt.ofnSearch['string'] = function ( data ) {
            return ! data ?
                '' :
                typeof data === 'string' ?
                    data
                        .replace( /\n/g, ' ' )
                        .replace( /á/g, 'a' )
                        .replace( /é/g, 'e' )
                        .replace( /í/g, 'i' )
                        .replace( /ó/g, 'o' )
                        .replace( /ú/g, 'u' )
                        .replace( /ê/g, 'e' )
                        .replace( /î/g, 'i' )
                        .replace( /ô/g, 'o' )
                        .replace( /è/g, 'e' )
                        .replace( /ï/g, 'i' )
                        .replace( /ü/g, 'u' )
                        .replace( /ç/g, 'c' ) :
                    data;
            };
            var table =  $('#zero-configurationo').DataTable(
                {
                    "responsive": false,
                    "ordering": false,
                    "searchable": false,
                    language: {
                        "decimal": "",
                        "emptyTable": "No se encontró información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                        "infoEmpty": "Mostrando 0 entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    pageLength : 25,
                    lengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'Todos']]
                }
            );
            // Remove accented character from search input as well
            jQuery('#zero-configurationo_filter input').keyup( function () {
                table
                .search(
                    jQuery.fn.DataTable.ext.type.search.string( this.value )
                )
                .draw();
            } );
        });
    </script>
@endsection

