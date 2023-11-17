@extends('layouts.layout')
@section('title','Todos los estudios')
@section('leve','Doctores')
@section('breadcrumb')

@endsection
@section('content')
<link rel="stylesheet" href="{{ asset('/css/allStudy.css') }}">
    <!-- data tables css -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/data-tables/css/datatables.min.css') }}">

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
            <div class="card-block block-r">
                <div class="table-responsive">
                    <table id="zero-configurationo" class="display table nowrap table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="tMovil">Folio</th>
                                <th>Paciente</th>
                                <th class="tMovil">Cita</th>
                                <th class="tMovil">Estatus</th>
                                <th class="tMovil">Recibido hace</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studies as $study)
                            <tr>
                                <td class="tMovil">
                                    @if ($study->internal == 1)
                                        R{{sprintf('%06d',$study->folio)}}
                                    @else
                                        D{{sprintf('%06d',$study->folio)}}
                                    @endif    
                                </td>
                                <td>{{$study->patient_name}} {{$study->paternal_surname}} {{$study->maternal_surname}}</td>
                                <td class="tMovil">
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
                                </td>
                                <td class="tMovil">{{$study->status}}</td>
                                <td class="tMovil">
                                    @if (($study->dias() + 0) == 0)
                                        @if (($study->horas() + 0) == 0)
                                            {{ $study->minutos() + 0 }} Minutos

                                        @else
                                            {{ $study->horas() + 0 }} Horas
                                        @endif

                                    @else
                                        {{ $study->dias() + 0 }} Días

                                    @endif    
                                </td>
                                <td>
                                    <a href="{{route('seeStudy',['id' => $study->id])}}">
                                        <button type="button" class="btn-status btn btn-rounded btn-success">Ver</button>
                                    </a>
                                </td>
                            </tr>
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
                    "columnDefs": [
                        {
                            "targets": [ 2 ],
                            "searchable": false
                        },
                        {
                            "targets": [ 3 ],
                            "searchable": false
                        },
                        {
                            "targets": [ 4 ],
                            "searchable": false
                        },
                        {
                            "targets": [ 5 ],
                            "searchable": false
                        }
                    ],
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

