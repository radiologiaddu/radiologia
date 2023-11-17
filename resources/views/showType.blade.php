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
                    <li class="breadcrumb-item"><a href="{{ route('types') }}">Tipos de estudios</a></li>
                    <li class="breadcrumb-item"><a href="#">{{$type->type}}</a></li>
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
                <a href="{{ route('newQuestion',['id' => $type->id]) }}">
                    <button type="button" class="btn btn-rounded btn-primary btn-glow float-right">
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
                                <th>Pregunta</th>
                                <th>Tipo de respuesta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($type->questions as $question)
                                <tr>
                                    <td>{{$question->question}}</td>
                                    <td>
                                        @switch($question->kind)
                                            @case("check")
                                                Multiple
                                                @break
                                            @case("radio")
                                                Unica
                                                @break
                                            @case("texto")
                                                Texto
                                                @break
                                            @default

                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <!--
                                        <a href="{{route('editQuestion',['id' => $question->id])}}">
                                            <button type="button" class="btn btn-success edit" title="Editar">Editar</button>
                                        </a>
                                        <button id="{{$question->id}}" type="button" class="btn btn-danger delete" title="Eliminar">Eliminar</button>
                                        -->
                                        <a  href="{{route('editQuestion',['id' => $question->id])}}" title="Editar" class=" btn-rounded text-white label theme-bg4 f-12 edit">
                                            <i class="feather icon-edit mr-0"></i>
                                        </a>
                                        <a id="{{$question->id}}" class="label theme-bg5 f-12 text-white btn-rounded delete" title="Eliminar"><i class="feather icon-trash-2 mr-0"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
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
                title: "Eliminar pregunta",
                text: "¿Deseas eliminar la pregunta?",
                icon: "info",
                buttons: true,
                buttons: ["Cerrar", "Eliminar"],
            }).then((willDelete) => {
                if (willDelete) {
                    $('.loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/deleteQuestion/') }}/" + id,
                        data: {_method: 'delete', _token : '{{ csrf_token() }}'},
                        dataType: "json",
                        success: function (response) {
                            swal({
                                    title: "Pregunta eliminada",
                                    text: "La pregunta se eliminó exitosamente",
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
    </script>
@endsection
