@extends('layouts.layout')
@section('title','Descuentos')
@section('leve','setting')
@section('subleve','referral')
@section('breadcrumb')
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Referidos</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Descuentos</a></li>
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
    </style>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                
                    <button type="button" class="btn btn-rounded btn-primary btn-glow float-right plus">
                        <i class="feather icon-plus"></i>
                        Nuevo
                    </button>
            </div>
            <div class="table-border-style">
                <div class="table-responsive">
                    <table id="zero-configurationo" class="table">
                        <thead>
                            <tr>
                                <th>Referido</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($referrals as $referral)
                                <tr>
                                    <td>
                                        <div class="textDr textDr{{$referral->id}}" id="textName{{$referral->id}}">{{$referral->name}}</div>
                                        <div style="display:none" class="inputDr input{{$referral->id}}" >
                                            <div class="form-group col-md-12 col-sm-12">
                                                <input id="type{{$referral->id}}" style="font-size: 14px; width: max-content;" type="text" name="name" class="form-control" placeholder="Descuento" value="{{$referral->name}}" required>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="buttonAll">
                                            <a id="{{$referral->id}}" class="label theme-bg5 f-12 text-white btn-rounded remove" title="Eliminar"><i class="feather icon-trash-2 mr-0"></i></a>
                                            <a title="Editar" class=" btn-rounded text-white label theme-bg4 f-12 edit" id="{{$referral->id}}">
                                                <i class="feather icon-edit mr-0"></i>
                                            </a>
                                        </div>
                                        <div style="display:none" class="inputDr input{{$referral->id}}">
                                            <div class="form-group col-md-12 col-sm-12">
                                                <div class="float-left col-md-6 col-sm-6">
                                                    <a id="{{$referral->id}}" class="label theme-bg5 f-12 text-white btn-rounded cancel" title="Cancelar"><i class="feather icon-x-circle mr-0"></i></a>
                                                </div>
                                                <div class="float-right col-md-6 col-sm-6">
                                                    <a id="{{$referral->id}}" class="label theme-bg3 f-12 text-white btn-rounded update" title="Guardar"><i class="fas fa-save mr-0"></i></a>
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
                                "targets": [ 0 ],
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
            var name = $("#type"+id).val(); 
            if (name != '') {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/updateReferral') }}/" + id,
                    data: {_method: 'put', _token : '{{ csrf_token() }}',"name":name},
                    dataType: "json",
                    success: function (response) {
                        swal({
                                title: "Referido modificado",
                                text: "El referido se modifico exitosamente",
                                icon: "success",
                                buttons: true,
                                buttons: "Cerrar",
                            })
                        .then((value) => {
                            location.reload();
                        });
                    }
                });
            }else{
                swal({
                        title: "Error",
                        text: "Nombre es necesario",
                        icon: "error",
                        buttons: true,
                        buttons: "Cerrar",
                    })
            }
        });
    
        
        $("body").on("click",".remove", function () {
            var id = $(this).attr("id");
            swal({
                title: "Eliminar referido",
                text: "¿Deseas eliminar el referido?",
                icon: "info",
                buttons: true,
                buttons: ["Cerrar", "Eliminar"],
            }).then((willDelete) => {
                if (willDelete) {
                    $('.loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/removeReferral/') }}/" + id,
                        data: {_method: 'delete', _token : '{{ csrf_token() }}'},
                        dataType: "json",
                        success: function (response) {
                            swal({
                                    title: "Referido eliminado",
                                    text: "El referido se eliminó exitosamente",
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

        $("body").on("click",".plus", function () {
            swal("Escribe el nombre de referido a guardar", {
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
                        url: "{{ route('addReferral')}}",
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
    </script>
@endsection
