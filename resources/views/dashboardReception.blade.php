@extends('layouts.layoutHost')
@section('title','Bienvenido')
@section('leve','Nuevos')
@section('breadcrumb')
<div class="col-12 text-center btn-newStudyHRCel">
    <a href="{{route('nuevoEstudioRec')}}">
        <button type="button" class="btn btn-rounded btn-success">
            <span style="font-size: large;">Nuevo Estudio</span>
        </button>
    </a>
</div>
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
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
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
<audio id="myAudio">
    <source src="https://app.ddu.mx/assets/sound/SD_ALERT_44.mp3" type="audio/mpeg">
</audio>
<script type="text/javascript">
    var x = document.getElementById("myAudio"); 
        x.muted = true;

        function playAudio() { 
        x.play();
        } 
</script>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-block block-r">
                <div class="row">
                    <div class="col-12">
                        <div id="modal-sound" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-soundTitle" aria-hidden="true" onclick="playAudio()">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="md-content card">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal-soundTitle">Notificaciones</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">   
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <p>
                                                    Se activará el sonido en las notificaciones para cuando se reciba un nuevo evento o se haga una modificación en la agenda
                                                </p>

                                                <button onclick="playAudio()" class="btn btn-primary md-close">Entendido</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <th>ID</th>
                                    <th class="tMovil">Folio</th>
                                    <th class="tMovil">Folio SAE</th>
                                    <th>Paciente</th>
                                    <th>Estudio</th>
                                    <th class="tMovil">Estatus</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studies as $study)
                                <tr>
                                    <th>{{$study->id}}</th>
                                    <td class="tMovil">
                                        @if ($study->internal == 1)
                                            R{{sprintf('%06d',$study->folio)}}
                                        @else
                                            D{{sprintf('%06d',$study->folio)}}
                                        @endif
                                    </td>
                                    <td class="tMovil">{{$study->sae}}</td>
                                    <td>{{$study->patient_name}} {{$study->paternal_surname}} {{$study->maternal_surname}}</td>
                                    <td>
                                        @if($study->study_type->count() > 0)
                                            {{$study->study_type[0]->type->type}}
                                        @endif
                                    </td>
                                    <td class="tMovil">{{$study->status}}</td>
                                    <td>
                                        @if ($study->status == "Realizado")
                                            <a href="{{route('sendStudy',['id' => $study->id])}}" class="label theme-bg2 f-12 text-white btn-rounded borrar" title="ENVIAR"><i class="feather icon-mail mr-0"></i></a>
                                            <!--
                                            <a href="{{route('sendStudy',['id' => $study->id])}}">
                                                <button type="button" class="btn-status btn btn-rounded btn-primary">Enviar</button>
                                            </a>
                                            -->
                                            <a href="{{route('historialRec',['id' => $study->id])}}" title="HISTORIAL" class="label theme-record text-white f-12 btn-rounded" ><i class="feather icon-folder mr-0"></i></a>
                                            <!--
                                            <a href="{{route('historialRec',['id' => $study->id])}}">
                                                <button type="button" class="btn btn-rounded btn-success">VER HISTORIAL</button>
                                            </a>
                                            -->
                                        @else
                                            <a href="{{route('showStudyRecep',['id' => $study->id])}}" title="VER" class="label theme-bg text-white f-12 btn-rounded"><i class="feather icon-eye mr-0"></i></a>
                                            <!--
                                            <a href="{{route('showStudyRecep',['id' => $study->id])}}">
                                                <button type="button" class="btn-status btn btn-rounded btn-success">VER</button>
                                            </a>
                                            -->
                                        @endif
                                        @if ($study->status != "Llegada")
                                            <div id="modal{{$study->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal{{$study->id}}Title" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal{{$study->id}}Title">Folio SAE:</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">FOLIO SAE:</label>
                                                                    <input id="{{$study->id}}SAE" class="form-control" placeholder="FOLIO" type="text" name="{{$study->id}}SAE" value="{{$study->sae}}" required>
                                                                </div>        
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button id="{{$study->id}}" type="button" class="btn btn-primary folio" data-dismiss="modal">Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a title="FOLIO" class="label theme-folio f-12 btn-rounded" data-toggle="modal" data-target="#modal{{$study->id}}"><i class="fas fa-file-alt mr-0"></i></a>

                                        @endif
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
        $(window).on('load', function() {
            $('#modal-sound').modal('show');
        });

        Pusher.logToConsole = true;

    var pusher = new Pusher('40f1cc1099b2ed243080', {
        cluster: 'us2'
    });
    var channel = pusher.subscribe('my-channel');
    channel.bind('App\\Events\\checkEvent', function(data) {
        x.muted = false;
        x.play();
        $( "#loading" ).removeClass( "d-none" )
        $( "#div-table" ).addClass( "d-none" )
        $( "#reload" ).addClass( "d-none" );
        $.ajax({
            type: "POST",
            url: "{{ url('/RecepcionReload') }}",
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
                        "order": [[0, 'desc']],
                        "responsive": false,
                        "ordering": true,
                        "columnDefs": [
                            {
                                "targets": [ 0 ],
                                "bVisible": false,
                                "searchable": false
                            },
                            {
                                "targets": [ 6 ],
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
                $( "#loading" ).addClass( "d-none" )
                $( "#div-table" ).removeClass( "d-none" )
                $( "#reload" ).removeClass( "d-none" );   
            }

        });
    });
    channel.bind('App\\Events\\finishEvent', function(data) {
        x.muted = false;
        x.play();
        $( "#loading" ).removeClass( "d-none" )
        $( "#div-table" ).addClass( "d-none" )
        $( "#reload" ).addClass( "d-none" );
        $.ajax({
            type: "POST",
            url: "{{ url('/RecepcionReload') }}",
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
                        "order": [[0, 'desc']],
                        "responsive": false,
                        "ordering": true,
                        "columnDefs": [
                            {
                                "targets": [ 0 ],
                                "bVisible": false,
                                "searchable": false
                            },
                            {
                                "targets": [ 6 ],
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
                $( "#loading" ).addClass( "d-none" )
                $( "#div-table" ).removeClass( "d-none" )
                $( "#reload" ).removeClass( "d-none" );   
            }

        });
    });
    channel.bind('App\\Events\\buyEvent', function(data) {
        x.muted = false;
        x.play();
        $( "#loading" ).removeClass( "d-none" )
        $( "#div-table" ).addClass( "d-none" )
        $( "#reload" ).addClass( "d-none" );
        $.ajax({
            type: "POST",
            url: "{{ url('/RecepcionReload') }}",
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
                        "order": [[0, 'desc']],
                        "responsive": false,
                        "ordering": true,
                        "columnDefs": [
                            {
                                "targets": [ 0 ],
                                "bVisible": false,
                                "searchable": false
                            },
                            {
                                "targets": [ 6 ],
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
                $( "#loading" ).addClass( "d-none" )
                $( "#div-table" ).removeClass( "d-none" )
                $( "#reload" ).removeClass( "d-none" );   
            }

        });
    });
        $( "#reload" ).click(function() {
            $( "#loading" ).removeClass( "d-none" )
            $( "#div-table" ).addClass( "d-none" )
            $( "#reload" ).addClass( "d-none" );

            $.ajax({
                type: "POST",
                url: "{{ url('/RecepcionReload') }}",
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
                            "order": [[0, 'desc']],
                            "responsive": false,
                            "ordering": true,
                            "columnDefs": [
                                {
                                    "targets": [ 0 ],
                                    "bVisible": false,
                                    "searchable": false
                                },
                                {
                                    "targets": [ 6 ],
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
                    $( "#loading" ).addClass( "d-none" )
                    $( "#div-table" ).removeClass( "d-none" )
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
                    "order": [[0, 'desc']],
                    "responsive": false,
                    "ordering": true,
                    "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "bVisible": false,
                            "searchable": false
                        },
                        {
                            "targets": [ 6 ],
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

        $("body").on("click",".folio", function () {
            var id = $(this).attr("id");
            var sae = $("#"+id+"SAE").val();
           
            $.ajax({
                type: "POST",
                url: "{{ url('/folio/') }}/" + id,
                data: {"sae":sae, _token : '{{ csrf_token() }}'},
                dataType: "json",
                success: function (response) {
                    swal("Folio añadido","Se ha añadido el folio al estudio", "success").
                        then((value) => {
                            location.reload();
                        });
                }
            });
            
        });
    </script>

@if ($vA)  
    <script type="text/javascript">
        $(document).ready(function() {
            swal("Estudio enviado","El estudio se ha le envió al paciente y al doctor", "success");
        });
    </script>
    @php
        session()->forget('flagModalR');
    @endphp
@endif
@if(\Session::has('success'))
    <script>
        swal("Nuevo estudio generado","Se ha enviado un correo con código QR al correo del paciente.", "success");
    </script>
@endif
@endsection



