@extends('layouts.layoutHost')
@section('title','Doctores')
@section('leve','Doctores')
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
        .switch input[type=checkbox] {
            display: none;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
        }
        input:checked + .slider {
            background-color: #2196F3;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }
        .slider.round:before {
            border-radius: 50%;
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
            background: linear-gradient(-135deg, #2FCB1E 0%, #04431B 100%);
        }
        .theme-bg7{
            background: linear-gradient(-135deg, #90CB1E 0%, #04CC1B 100%);
        }
    </style>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('nuevoDoctorCoo') }}">
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
                                
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Cash Back</th>
                                <th>Disponible</th>
                                <th>Status</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
       
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
                                    @if (!is_null($user->email_verified_at))
                                        <div class="float-left col-md-6 col-sm-6">
                                            <a href="/perfil-doctor/{{$user->id}}?showCashBackOnly=true" class="label theme-bg7 f-12 text-white btn-rounded cancel" title="Reporte Anual"><i class="feather icon-file mr-0"></i></a>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
    <label class="switch">
        <input type="checkbox" class="status-switch"
               data-id="{{ $user->id }}"
               {{ $user->doctorReports && $user->doctorReports->status === 'Activo' ? 'checked' : '' }}
        >
        <span class="slider round"></span>
    </label>
</td>






                                    <td>
                                        @if (is_null($user->email_verified_at))
                                            Sin verificar
                                        @else
                                            Verificado
                                        @endif
                                    </td>
                                    <td>
                                    @if (!is_null($user->email_verified_at))
                                        <div class="float-left col-md-6 col-sm-6">
                                            <a href="/perfil-doctor/{{$user->id}}" class="label theme-bg6 f-12 text-white btn-rounded cancel" title="Reporte Anual"><i class="feather icon-file mr-0"></i></a>
                                        </div>
                                        @endif

                                        <div class="buttonAll">
                                            
                                            @if (is_null($user->email_verified_at) && !$user->status && false)
                                                <a id="{{$user->id}}" class="label theme-bg5 f-12 text-white btn-rounded remove" title="Eliminar"><i class="feather icon-trash-2 mr-0"></i></a>

                                                <a title="Editar" class=" btn-rounded text-white label theme-bg4 f-12 edit" id="{{$user->id}}">
                                                    <i class="feather icon-edit mr-0"></i>
                                                </a>
                                                
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
                                "targets": [ 2 ],
                                "searchable": false
                            },
                            {
                                "targets": [ 3 ],
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
                        url: "{{ url('/admin/updateDoctorCoo') }}/" + id,
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
                        url: "{{ url('/removeDoctorCoo/') }}/" + id,
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

        // Delegar el evento de cambio para el checkbox de estado
    $(document).on('change', '.status-switch', function() {
        var userId = $(this).data('id');
        var isChecked = $(this).prop('checked');
        var status = isChecked ? 'Activo' : 'Inactivo';

        // Envía la solicitud AJAX para actualizar el estado
        $.ajax({
            url: '/actualizar-estatus/' + userId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                console.log("Actualizado");
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });


    </script>
@endsection
