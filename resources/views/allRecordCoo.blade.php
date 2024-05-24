@extends('layouts.layoutHost')
@section('title','Bienvenido')
@section('leve','Historial')
@section('breadcrumb')

@endsection
@section('content')
<style>
    #zero-configurationo_length{
        margin-left: 50px;
    }
</style>
<link rel="stylesheet" href="{{ asset('/css/allStudy.css') }}">
    <!-- data tables css -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/data-tables/css/datatables.min.css') }}">

@php
setlocale(LC_TIME, "spanish");
$weekMap = [
        0 => 'Dom',
        1 => 'Lun',
        2 => 'Mar',
        3 => 'Mie',
        4 => 'Jue',
        5 => 'Vie',
        6 => 'Sáb',
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
                <a href="/export/Admin">
                    <button type="button" class="btn btn-rounded btn-success btn-glow float-right">
                        <i class="fas fa-file-excel"></i>
                        Excel
                    </button>
                </a>
            </div>
            <div class="card-block block-r">
                <div class="table-responsive" style="min-height: 50px;">
                    <div class="position-absolute" style="width: 50px;z-index: 999;">
                        <button id="reload" class="btn btn-reload" type="button">
                            <i class="feather icon-refresh-ccw"></i>
                        </button>
                        <button id="loading" class="btn btn-reload d-none" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                        </button>
                    </div>
                    <div class="col-12" id="div-table">
                        <table id="zero-configurationo" class="display table nowrap table-striped table-hover" style="width:100%">
                        <thead>
                                <tr>
                                    <th class="tMovil">Folio</th>
                                    <th class="tMovil">SAE</th>
                                    <th>Paciente</th>
                                    <th class="tMovil">Fecha de Emisión</th> <!-- Antes Recibido hace-->
                                    <th class="tMovil">Estatus</th>
                                    <th class="tMovil">Fecha de estudio realizado</th>
                                    <th></th>
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
                                    <td class="tMovil">{{$study->sae}}</td>
                                    <td>{{$study->patient_name}} {{$study->paternal_surname}} {{$study->maternal_surname}}</td>
                                    <td class="tMovil">
                                        <span>{{$study->created_at}}</span>
                                        <!-- <?php /*
                                        class="d-none" //No se muestra en pantalla
                                        @if (($study->dias() + 0) == 0)
                                            @if (($study->horas() + 0) == 0)
                                                {{ $study->minutos() + 0 }} Minutos
                                            @else
                                                {{ $study->horas() + 0 }} Horas
                                            @endif
                                        @else
                                            {{ $study->dias() + 0 }} Días
                                        @endif  */ ?> -->
                                    </td>
                                    <td class="tMovil">{{$study->status}}</td>
                                    <td class="tMovil">
                                        @if ($study->date)
                                            {{ $study->date }}
                                        @else
                                            No Registrada
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('showStudyCoo',['id' => $study->id])}}" title="VER" class="label theme-bg text-white f-12 btn-rounded"><i class="feather icon-eye mr-0"></i></a>
                                        <a href="{{route('historialCoo',['id' => $study->id])}}" title="HISTORIAL" class="label theme-record text-white f-12 btn-rounded" ><i class="feather icon-folder mr-0"></i></a>
                                        <!--
                                        <a href="{{route('showStudyCoo',['id' => $study->id])}}">
                                            <button type="button" class="btn-status btn btn-rounded btn-success">VER</button>
                                        </a>
                                        <a href="{{route('historialCoo',['id' => $study->id])}}">
                                            <button id="changeStatus" type="button" class="btn btn-rounded btn-primary">VER HISTORIAL</button>
                                        </a>
                                        -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
    $( "#reload" ).click(function() {
            $( "#loading" ).removeClass( "d-none" );
            $( "#div-table" ).addClass( "d-none" );
            $( "#reload" ).addClass( "d-none" );

            $.ajax({
                type: "POST",
                url: "{{ url('/recordCooReload') }}",
                data: {_token : '{{ csrf_token() }}'},
                success: function (opciones) {
                    $("#div-table").html(opciones);
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
                            "ordering": true,
                            "columnDefs": [
                                {
                                    "targets": [ 3 ],
                                    "searchable": false
                                },
                                {
                                    "targets": [ 4 ],
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
                    $( "#loading" ).addClass( "d-none" );
                    $( "#div-table" ).removeClass( "d-none" );
                    $( "#reload" ).removeClass( "d-none" );   
                }

            });
        });
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
                    "ordering": true,
                    "columnDefs": [
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
                            "searchable": true
                        }
                    ],
                    "order": [[3, "desc"]],
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



