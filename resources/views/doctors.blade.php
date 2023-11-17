@extends('layouts.layout')
@section('title','Doctores')
@section('leve','Doctores')
@section('breadcrumb')
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Doctores</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Doctores</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- data tables css -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/data-tables/css/datatables.min.css') }}">
    <style>
        .switch input[type=checkbox] {
            display: contents;
        }
        #zero-configurationo_wrapper{
            padding-right: 15px;
            padding-left: 15px;
        }
        tr{
            background: white !important
        }
        tr:hover{
            background: rgba(4, 169, 245, 0.05) !important
        }
        .table td, .table th {
            white-space: normal;
        }
        @media (max-width: 700px) {
            #zero-configurationo_wrapper{
                width: max-content !important;
            }
        }
        
    </style>
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
        .theme-bg6{
            background: linear-gradient(-135deg, #24e91d 0%, #7be75a 100%);
        }
    </style>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('nuevoDoctor') }}">
                    <button type="button" class="btn btn-rounded btn-primary btn-glow float-right">
                        <i class="feather icon-plus"></i>
                        Nuevo
                    </button>
                </a>
            </div>
            <div class="table-border-style">
                <div class="table-responsive">
                    <table id="zero-configurationo" class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Status</th>
                                <th>Coord</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            @if (is_null($user->deleted_at))
                                                <div class="switch switch-alternative d-inline">
                                                    <input class="delete" type="checkbox" id="{{$user->id}}" checked>
                                                    <label for="{{$user->id}}" class="cr"></label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <label>Activo</label>
                                            @else
                                                <div class="switch switch-alternative d-inline">
                                                    <input class="delete" type="checkbox" id="{{$user->id}}">
                                                    <label for="{{$user->id}}" class="cr"></label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <label>Inactivo</label>
                                            @endif
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="textDr textDr{{$user->id}}" id="textName{{$user->id}}">{{$user->name}}</div>
                                        @if (!is_null($user->doctor))
                                            <div>{{$user->doctor->paternalSurname}} {{$user->doctor->maternalSurname}}</div>
                                        @endif
                                        <div style="display:none" class="inputDr input{{$user->id}}" >
                                            <div class="form-group col-md-12 col-sm-12">
                                                <input id="name{{$user->id}}" style="font-size: 14px; width: max-content;" type="text" name="name" class="form-control" placeholder="Categoría" value="{{$user->name}}" required>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="textDr textDr{{$user->id}}" id="textEmail{{$user->id}}">{{$user->email}}</div>
                                        <div style="display:none" class="inputDr input{{$user->id}}" >
                                            <div class="form-group col-md-12 col-sm-12">
                                                <input id="email{{$user->id}}" style="font-size: 14px; width: max-content;" type="email" name="email" class="form-control" placeholder="Categoría" value="{{$user->email}}" required>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if (is_null($user->email_verified_at))
                                            Sin verificar
                                        @else
                                            Verificado
                                        @endif
                                    </td>
                                    <td>
                                        @if (!is_null($user->status))
                                            OK
                                        @endif
                                    </td>
                                    <td>
                                        @if (!is_null($user->status) && !$user->status)
                                            <a id="{{$user->id}}" class="label theme-bg6 f-12 text-white btn-rounded validar" title="Validar"><i class="feather icon-check-square mr-0"></i></a>
                                            <a id="{{$user->id}}" class="label theme-bg5 f-12 text-white btn-rounded remove" title="Eliminar"><i class="feather icon-trash-2 mr-0"></i></a>

                                        @else

                                            <div class="buttonAll">
                                                <!--
                                                <a href="{{route('seeDoctor',['id' => $user->id])}}">
                                                    <button type="button" class="btn btn-primary" title="Visualizar">Ver</button>
                                                </a>
                                                -->
                                                <a href="{{route('seeDoctor',['id' => $user->id])}}" title="VER" class="label theme-bg text-white f-12 btn-rounded"><i class="feather icon-eye mr-0"></i></a>
                                                <a id="{{$user->id}}" class="label theme-bg5 f-12 text-white btn-rounded remove" title="Eliminar"><i class="feather icon-trash-2 mr-0"></i></a>

                                                <!--
                                                <button id="{{$user->id}}" type="button" class="btn btn-danger remove" title="Eliminar">Eliminar</button>

                                                @if ($user->email != "interino@ddu.com")
                                                    <button id="{{$user->id}}" type="button" class="btn btn-danger delete" title="Eliminar">Eliminar</button>
                                                    
                                                @endif
                                                -->
                                                @if (is_null($user->email_verified_at) && is_null($user->deleted_at))
                                                    <a title="Editar" class=" btn-rounded text-white label theme-bg4 f-12 edit" id="{{$user->id}}">
                                                        <i class="feather icon-edit mr-0"></i>
                                                    </a>
                                                    <a id="{{$user->id}}" class="label theme-bg2 f-12 text-white btn-rounded resend" title="Reenviar correo"><i class="feather icon-mail mr-0"></i></a>
                                                    <!--
                                                    <button id="{{$user->id}}" type="button" class="btn btn-warning resend" title="Reenviar correo de verificación">Reenviar</button>
                                                    -->
                                                @endif
                                            </div>
                                            <div style="display:none" class="inputDr input{{$user->id}}">
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <div class="float-left col-md-6 col-sm-6">
                                                        <a id="{{$user->id}}" class="label theme-bg5 f-12 text-white btn-rounded cancel" title="Cancelar"><i class="feather icon-x-circle mr-0"></i></a>
                                                        <!--
                                                        <button type="button" class="btn btn-round btn-secondary cancel" id="{{ $user->id }}">Cancelar</button>
                                                        -->
                                                    </div>
                                                    <div class="float-right col-md-6 col-sm-6">
                                                        <a id="{{$user->id}}" class="label theme-bg3 f-12 text-white btn-rounded update" title="Guardar"><i class="fas fa-save mr-0"></i></a>
                                                        <!--
                                                        <button type="button" class="btn btn-round btn-primary update" id="{{ $user->id }}">Guardar</button>
                                                        -->
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
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
        <!-- datatable Js -->
        <script src="{{ asset('/assets/plugins/data-tables/js/datatables.min.js') }} "></script>
        <script src="{{ asset('/assets/js/pages/tbl-datatable-custom.js') }} "></script>
        <script type="text/javascript">
            var table;
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
                table =  $('#zero-configurationo').DataTable(
                    {
                        fixedHeader: true,
                        "responsive": false,
                        "ordering": true,
                        "columnDefs": [
                            {
                                "targets": [ 0 ],
                                "searchable": false
                            },
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
            });
        </script>
    <script type="text/javascript">
        $("body").on("click",".edit", function () {
            var id = $(this).attr("id");
            $('.textDr').show();
            $('.inputDr').hide();
            $('.buttonAll').hide();

            $('.textDr'+id).hide();
            $('.input'+id).show();
            $( "#name"+id).focus();
            table.draw();
        });
        $("body").on("click",".cancel", function () {
            var id = $(this).attr("id");
            
            $("#name"+id).val($("#textName"+id).text()); 
            $("#email"+id).val($("#textEmail"+id).text());

            $('.buttonAll').show();
            $('.textDr').show();
            $('.inputDr').hide();
        });

        $("body").on("click",".update", function () {
            var id = $(this).attr("id");
            var name = $("#name"+id).val(); 
            var email = $("#email"+id).val(); 
            if (name != '' && email != '') {
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/admin/updateDoctor') }}/" + id,
                        data: {_method: 'put', _token : '{{ csrf_token() }}',"name":name, "email":email},
                        dataType: "json",
                        success: function (response) {
                            if(response.status){
                                $('.loader').show();
                                location.reload()
                            }else{
                                swal({
                                    title: "Error",
                                    text: response.data,
                                    icon: "error",
                                    buttons: true,
                                    buttons: "Cerrar",
                                })
                            }
                        }
                    });
                }else{
                    swal({
                        title: "Error",
                        text: "Correo no valido",
                        icon: "error",
                        buttons: true,
                        buttons: "Cerrar",
                    })
                }
            }else{
                swal({
                        title: "Error",
                        text: "Nombre y correo son necesarios",
                        icon: "error",
                        buttons: true,
                        buttons: "Cerrar",
                    })
            }
        });
        
        $(".delete").change(function(evt){
            var id = $(this).attr("id");
            if ($(this).is(':checked')) {
                swal({
                    title: "Habilitar doctor",
                    text: "¿Deseas habilitar el doctor?",
                    icon: "info",
                    buttons: true,
                    buttons: ["Cerrar", "Habilitar"],
                }).then((willDelete) => {
                    if (willDelete) {
                        $('.loader').show();
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/RestDoctor/') }}/" + id,
                            data: {_method: 'PUT', _token : '{{ csrf_token() }}'},
                            dataType: "json",
                            success: function (response) {
                                swal({
                                        title: "Doctor habilitado",
                                        text: "El doctor se a habilitado exitosamente",
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
                    title: "Deshabilitar doctor",
                    text: "¿Deseas deshabilitar el doctor?",
                    icon: "info",
                    buttons: true,
                    buttons: ["Cerrar", "Deshabilitar"],
                }).then((willDelete) => {
                    if (willDelete) {
                        $('.loader').show();
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/deleteDoctor/') }}/" + id,
                            data: {_method: 'delete', _token : '{{ csrf_token() }}'},
                            dataType: "json",
                            success: function (response) {
                                swal({
                                        title: "Doctor inhabilitado",
                                        text: "El doctor se a inhabilitado exitosamente",
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
        
        $("body").on("click",".remove", function () {
            var id = $(this).attr("id");
            swal({
                title: "Eliminar doctor",
                text: "¿Deseas eliminar el doctor?",
                icon: "info",
                buttons: true,
                buttons: ["Cerrar", "Eliminar"],
            }).then((willDelete) => {
                if (willDelete) {
                    $('.loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/removeDoctor/') }}/" + id,
                        data: {_method: 'delete', _token : '{{ csrf_token() }}'},
                        dataType: "json",
                        success: function (response) {
                            swal({
                                    title: "Doctor eliminado",
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
        $("body").on("click",".validar", function () {
            var id = $(this).attr("id");
            swal({
                title: "Validar doctor",
                text: "¿Deseas validar el doctor?",
                icon: "info",
                buttons: true,
                buttons: ["Cerrar", "Validar"],
            }).then((willDelete) => {
                if (willDelete) {
                    $('.loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/validarDoctor/') }}/" + id,
                        data: {_method: 'PUT', _token : '{{ csrf_token() }}'},
                        dataType: "json",
                        success: function (response) {
                            swal({
                                    title: "Doctor validado",
                                    text: "El doctor ha sido validado y se enviar correo de verificacion",
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
        
        $("body").on("click",".resend", function () {
            var id = $(this).attr("id");
            swal({
                title: "Reenviar correo",
                text: "¿Deseas reenviar correo de verificación al doctor?",
                icon: "info",
                buttons: true,
                buttons: ["Cerrar", "Reenviar"],
            }).then((willDelete) => {
                if (willDelete) {
                    $('.loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/resendMail/') }}/" + id,
                        data: {_token : '{{ csrf_token() }}'},
                        dataType: "json",
                        success: function (response) {
                            swal({
                                    title: "Correo reenviado",
                                    text: "El correo se ha enviado exitosamente",
                                    icon: "success",
                                    buttons: true,
                                    buttons: "Cerrar",
                                })
                            .then((value) => {

                            });
                        }
                    });
                } 
            });
        });
    </script>
@endsection
