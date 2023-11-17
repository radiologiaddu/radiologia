@extends('layouts.layout')
@section('title','Usuarios')
@section('leve','Usuarios')
@section('breadcrumb')
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Usuarios</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- data tables css -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/data-tables/css/datatables.min.css') }}">
    <style>
        .theme-bg{
            background: linear-gradient(-135deg, #e9d51d 0%, #eff16e 100%);
        } 
        .theme-bg2{
            background: linear-gradient(-135deg, #e91d1d 0%, #e7765a 100%);
        }   
        .theme-bg3{
            background: linear-gradient(-135deg, #1d23e9 0%, #1dbae9 100%);
        } 
    </style>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('newUser') }}">
                    <button type="button" class="btn btn-rounded btn-primary btn-glow float-right">
                        <i class="feather icon-plus"></i>
                        Nuevo
                    </button>
                </a>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table id="zero-configurationo" class="display table nowrap table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    @php
                                        $rol = $user->getRoleNames(); 
                                    @endphp
                                    <td>
                                        {{$rol[0]}}
                                    </td>
                                    <td>
                                        @if (is_null($user->deleted_at))
                                        <a title="Editar" class=" btn-rounded text-white label theme-bg f-12" href="{{route('editarUsuario',['id' => $user->id])}}">
                                            <i class="feather icon-edit mr-0"></i>
                                        </a>
                                        
                                        <a id="{{$user->id}}" class="label theme-bg2 f-12 text-white btn-rounded delete" title="Baja"><i class="feather icon-trash-2 mr-0"></i></a>
                                            <!--
                                            <a href="{{route('editarUsuario',['id' => $user->id])}}">
                                                <button type="button" class="btn btn-success " title="Editar">Editar</button>
                                            </a>
                                            <button id="{{$user->id}}" type="button" class="btn btn-danger delete" title="Baja">Baja</button>
                                            -->
                                        @else
                                            <a id="{{$user->id}}" class="label theme-bg3 f-12 text-white btn-rounded rest" title="Restaurar"><i class="fas fa-thumbs-up mr-0"></i></a>

                                            <!--
                                            <button id="{{$user->id}}" type="button" class="btn btn-primary rest" title="Restaurar">Restaurar</button>
                                            -->
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
@endsection
@section('css')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                title: "Baja Registro",
                text: "¿Deseas dar de baja el registro?",
                icon: "info",
                buttons: true,
                buttons: ["Cerrar", "Baja"],
            }).then((willDelete) => {
                if (willDelete) {
                    $('.loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/deleteUser/') }}/" + id,
                        data: {_method: 'delete', _token : '{{ csrf_token() }}'},
                        dataType: "json",
                        success: function (response) {
                            swal({
                                    title: "Registro eliminado",
                                    text: "El registro se eliminó exitosamente",
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

        $("body").on("click",".rest", function () {
            var id = $(this).attr("id");
            swal({
                title: "Restaurar Registro",
                text: "¿Deseas restaurar el registro?",
                icon: "info",
                buttons: true,
                buttons: ["Cerrar", "Restaurar"],
            }).then((willDelete) => {
                if (willDelete) {
                    $('.loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/RestUser/') }}/" + id,
                        data: {_method: 'PUT', _token : '{{ csrf_token() }}'},
                        dataType: "json",
                        success: function (response) {
                            swal({
                                    title: "Registro restaurado",
                                    text: "El registro se restauro exitosamente",
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
