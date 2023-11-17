@extends('layouts.layout')
@section('title','Tipos de estudios')
@section('leve','setting')
@section('subleve','Estudios')
@section('breadcrumb')
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Tipos de estudios</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Tipos de estudios</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- data tables css -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/data-tables/css/datatables.min.css') }}">
    <style>
        .theme-bg4{
            background: linear-gradient(-135deg, #e9d51d 0%, #eff16e 100%);
        } 
        .theme-bg5{
            background: linear-gradient(-135deg, #e91d1d 0%, #e7765a 100%);
        }   
        .theme-bg3{
            background: linear-gradient(-135deg, #1d23e9 0%, #1dbae9 100%);
        } 
    </style>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <a href="{{route('newType')}}">
                    <button type="button" class="btn btn-rounded btn-primary btn-glow float-right add">
                        <i class="feather icon-plus"></i>
                        Nuevo
                    </button>
                </a>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table id="zero-configurationo" class="table">
                        <thead>
                            <tr>
                                <th>Tipo de estudio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($types as $type)
                                <tr>
                                    <td>{{$type->type}}</td>
                                    <td>
                                        <!--
                                        <a href="{{route('seeType',['id' => $type->id])}}">
                                            <button type="button" class="btn btn-primary" title="Visualizar">Ver</button>
                                        </a>
                                        <a href="{{route('editType',['id' => $type->id])}}">
                                            <button id="{{$type->id}}" type="button" class="btn btn-success edit" title="Editar" value="{{$type->type}}">Editar</button>
                                        </a>
                                        <button id="{{$type->id}}" type="button" class="btn btn-danger delete" title="Eliminar">Eliminar</button>
                                        -->
                                        <a href="{{route('seeType',['id' => $type->id])}}" title="VER" class="label theme-bg text-white f-12 btn-rounded"><i class="feather icon-eye mr-0"></i></a>
                                        <a href="{{route('editType',['id' => $type->id])}}" title="Editar" class=" btn-rounded text-white label theme-bg4 f-12 edit" id="{{$type->id}}">
                                            <i class="feather icon-edit mr-0"></i>
                                        </a>
                                        <a id="{{$type->id}}" class="label theme-bg5 f-12 text-white btn-rounded delete" title="Eliminar"><i class="feather icon-trash-2 mr-0"></i></a>
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
            var table =  $('#zero-configurationo').DataTable(
                {
                    "responsive": false,
                    "ordering": true,
                    "searching": false,
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
        });
        $("body").on("click",".delete", function () {
            var id = $(this).attr("id");
            swal({
                title: "Eliminar tipo de estudio",
                text: "¿Deseas eliminar el tipo de estudio?",
                icon: "info",
                buttons: true,
                buttons: ["Cerrar", "Eliminar"],
            }).then((willDelete) => {
                if (willDelete) {
                    $('.loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/deleteType/') }}/" + id,
                        data: {_method: 'delete', _token : '{{ csrf_token() }}'},
                        dataType: "json",
                        success: function (response) {
                            swal({
                                    title: "Tipo de estudio eliminado",
                                    text: "El doctor se eliminó exitosamente",
                                    icon: "success",
                                    buttons: true,
                                    buttons: "Cerrar",
                                })
                            .then((value) => {
                                location.reload();
                            });
                        }
                    });
                } 
            });
        });
    /*
    $("body").on("click",".add", function () {
        swal("Escribe el nombre del tipo de estudio a guardar", {
        content: "input",
        buttons: ["Cerrar", "Guardar"],
        closeOnClickOutside: true,
        closeOnEsc: true,
        icon: "warning",
        })
        .then((value) => {
            if(value != ""){
                $.ajax({
                    type: "POST",
                    url: "{{ route('addType')}}",
                    data: {_token : '{{ csrf_token() }}',"typeStudie":value},
                    dataType: "json",
                    success: function (response) {
                        $('.loader').show();
                        location.reload();
                    },error:function(e){

                    }
                });
            }
        });
    });
    
    $("body").on("click",".edit", function () {
        var id = $(this).attr("id");
        swal("Escribe el nombre del tipo de estudio a guardar", {
            content: {
                element: 'input',
                attributes: {
                    defaultValue: $(this).attr("value"),
                }
            },
            buttons: ["Cerrar", "Guardar"],
            closeOnClickOutside: true,
            closeOnEsc: true,
            icon: "warning",
        })
        .then((value) => {
            if(value != ""){
                $.ajax({
                    type: "POST",
                    url: "{{ url('/updateType/') }}/" + id,
                    data: {_method: 'put',_token : '{{ csrf_token() }}',"typeStudie":value},
                    dataType: "json",
                    success: function (response) {
                        $('.loader').show();
                        location.reload();
                    },error:function(e){

                    }
                });
            }
        });
    });
    */

    </script>
@endsection
