@extends('layouts.layout')
@section('title','Radiólogos')
@section('leve','Radiologos')
@section('breadcrumb')
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Radiólogos</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Radiólogos</a></li>
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
                <button type="button" class="addRadiolog btn btn-rounded btn-primary btn-glow float-right">
                    <i class="feather icon-plus"></i>
                    Nuevo
                </button>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table id="zero-configurationo" class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($radiologists as $radiologist)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            @if (is_null($radiologist->status))
                                                <div class="switch switch-alternative d-inline">
                                                    <input class="delete" type="checkbox" id="{{$radiologist->id}}" checked>
                                                    <label for="{{$radiologist->id}}" class="cr"></label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <label>Activo</label>
                                            @else
                                                <div class="switch switch-alternative d-inline">
                                                    <input class="delete" type="checkbox" id="{{$radiologist->id}}">
                                                    <label for="{{$radiologist->id}}" class="cr"></label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <label>Inactivo</label>
                                            @endif
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="textRadio text{{$radiologist->id}}">
                                            {{$radiologist->name}}
                                        </div>
                                        <div style="display:none" class="inputRadio input{{$radiologist->id}}" >
                                            <div class="form-group col-md-12 col-sm-12">
                                                <input id="Radio{{$radiologist->id}}" style="font-size: 16px;" type="text" name="Radio" class="form-control" placeholder="Categoría" value="{{$radiologist->name}}" required>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12">
                                                <div class="float-left col-md-6 col-sm-6">
                                                    <a id="{{$radiologist->id}}" class="label theme-bg5 f-12 text-white btn-rounded cancel" title="Cancelar"><i class="feather icon-x-circle mr-0"></i></a>
                                                    <!--
                                                    <button type="button" class="btn btn-round btn-secondary cancel">Cancelar</button>
                                                    -->
                                                </div>
                                                <div class="float-right col-md-6 col-sm-6">
                                                    <a id="{{$radiologist->id}}" class="label theme-bg3 f-12 text-white btn-rounded update" title="Guardar"><i class="fas fa-save mr-0"></i></a>
                                                    <!--
                                                    <button type="button" class="btn btn-round btn-primary update" id="{{ $radiologist->id }}">Guardar</button>
                                                    -->
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a title="Editar" class=" btn-rounded text-white label theme-bg4 f-12 edit" id="{{$radiologist->id}}" val="{{$radiologist->name}}">
                                            <i class="feather icon-edit mr-0"></i>
                                        </a>
                                        <!--
                                        <button val="{{$radiologist->name}}" type="button" class="btn btn-round btn-success edit" id="{{ $radiologist->id }}">Editar</button>
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
        $("body").on("click",".addRadiolog", function () {
            swal("Escribe el nombre del Radiologo a guardar", {
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
                        url: "{{ route('addRadiologo')}}",
                        data: {_token : '{{ csrf_token() }}',"name":value},
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
            $('.textRadio').show();
            $('.inputRadio').hide();

            $('.text'+id).hide();
            $('.input'+id).show();
            $( "#Radio"+id).focus();

        });

        $("body").on("click",".cancel", function () {
            $('.textRadio').show();
            $('.inputRadio').hide();
        });

        $("body").on("click",".update", function () {
            var id = $(this).attr("id");
            var value = $("#Radio"+id).val(); 
            $.ajax({
                type: "POST",
                url: "{{ url('/updateRadiologo/') }}/" + id,
                data: {_method: 'put', _token : '{{ csrf_token() }}',"name":value},
                dataType: "json",
                success: function (response) {
                    $('.loader').show();
                    location.reload();
                }
            });
        });

        $(".delete").change(function(evt){
            var id = $(this).attr("id");
            if ($(this).is(':checked')) {
                swal({
                    title: "Habilitar radiologo",
                    text: "¿Deseas habilitar radiologo?",
                    icon: "info",
                    buttons: true,
                    buttons: ["Cerrar", "Habilitar"],
                }).then((willDelete) => {
                    if (willDelete) {
                        $('.loader').show();
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/RestRadiologo/') }}/" + id,
                            data: {_method: 'PUT', _token : '{{ csrf_token() }}'},
                            dataType: "json",
                            success: function (response) {
                                swal({
                                        title: "Radiologo habilitado",
                                        text: "El radiologo se a habilitado exitosamente",
                                        icon: "success",
                                        buttons: true,
                                        buttons: "Cerrar",
                                    })
                                .then((value) => {
                                    location.reload();
                                });
                            }
                        });
                    }else {
                        $(this).prop('checked', false);
                    }
                });
            }else{
                swal({
                    title: "Deshabilitar radiologo",
                    text: "¿Deseas deshabilitar el radiologo?",
                    icon: "info",
                    buttons: true,
                    buttons: ["Cerrar", "Eliminar"],
                }).then((willDelete) => {
                    if (willDelete) {
                        $('.loader').show();
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/deleteRadiolog/') }}/" + id,
                            data: {_method: 'delete', _token : '{{ csrf_token() }}'},
                            dataType: "json",
                            success: function (response) {
                                swal({
                                        title: "Radiologo inhabilitado",
                                        text: "Radiologo se a inhabilitado exitosamente",
                                        icon: "success",
                                        buttons: true,
                                        buttons: "Cerrar",
                                    })
                                .then((value) => {
                                    location.reload();
                                });
                            }
                        });
                    }else {
                        $(this).prop('checked', true);
                    }
                });
            }
        });
        /*
        $("body").on("click",".delete", function () {
            var id = $(this).attr("id");
            swal({
                title: "Eliminar radiologo",
                text: "¿Deseas eliminar el radiologo?",
                icon: "info",
                buttons: true,
                buttons: ["Cerrar", "Eliminar"],
            }).then((willDelete) => {
                if (willDelete) {
                    $('.loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/deleteRadiolog/') }}/" + id,
                        data: {_method: 'delete', _token : '{{ csrf_token() }}'},
                        dataType: "json",
                        success: function (response) {
                            swal({
                                    title: "Radiologo eliminado",
                                    text: "El Radiologo se eliminó exitosamente",
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
        */
    </script>
@endsection
