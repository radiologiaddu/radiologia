@extends('layouts.layoutHost')
@section('title','Bienvenido')
@section('leve','Envios')

@section('breadcrumb')

@endsection
@section('content')
    <style>
        .custom-file-input ~ .custom-file-label::after {
            content: "Elegir";
        }
    </style>
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
    <link type="text/css" rel="stylesheet" href="{{asset('libs/image-uploader-master/dist/image-uploader.min.css')}}">

    <div class="col-sm-12">
        <div class="card">
            <div class="card-block block-r">
                @if (is_null($study))
                    <form id="formulario" class="form-horizontal style-form col-sm-12" method="POST" action="{{ route('sendEmailStudy') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Estudio</label>
                                <select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" id="selectStudy" name="selectStudy" required>
                                    <option value="" selected disabled>Selecciona un paciente</option>
                                    @foreach ($studies as $oneStudy)
                                        <option value="{{$oneStudy->id}}">{{$oneStudy->patient_name}} {{$oneStudy->paternal_surname}} {{$oneStudy->maternal_surname}} - {{$oneStudy->study_type[0]->type->type}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <h4 class="text-center col-12 mb-3">
                                    Datos de Estudio
                                </h4>
                                <div id="study-data" class="text-center col-12 row">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="physical">
                            <h5 class="mt-4 mb-4 form-label">Añade los estudios que se enviaran por correo, o pega un link para poder descargar los estudios.</h5>

                            <div class="form-row">
                                <p>El tamaño maximo de archivos que puedes enviar es de <strong>25 MB</strong></p>
                                <div class="form-row col-md-12" style="margin-bottom: 25px">
                                    <div class="input-images col-md-12"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Link de descarga</label>
                                    <input id="link" class="form-control" placeholder="Link" type="text" name="link">
                                </div>        
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-12 mt-3 text-center">
                            <button id="save" type="button" class="physical btn-primary btn btn-rounded btn-new">Enviar</button>
                            <button id="finish" type="button" class="btn-success btn btn-rounded btn-new">Entrega física</button>
                        </div>
                @else
                    <form id="formulario" method="POST" action="{{ route('sendEmailStudy', $study->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="row">
                                <h4 class="text-center col-12 mb-3">
                                    Datos de Estudio
                                </h4>
                                <div class="text-center col-12 row">
                                    <div class="col-12 col-md-6">
                                        <h6 class="col-12">
                                            Folio: 
                                            @if ($study->internal == 1)
                                                R{{sprintf('%06d',$study->folio)}}
                                            @else
                                                D{{sprintf('%06d',$study->folio)}}
                                            @endif
                                        </h6>
                                        <h6 class="col-12">
                                            Doctor: 
                                            @if ($study->doctor_id == 0)
                                                {{$study->doctor_name}}
                                            @else
                                                {{$study->doctor->alias}}
                                            @endif
                                        </h6>
                                        <!--<h6 class="col-12">
                                            Correo del doctor: 
                                                {{$study->doctor->user->email}}
                                            </h6>-->
                                        <h6 class="col-12">
                                            Cita:
                                            @if (isset($study->appointment))
                                                {{$weekMap[strftime("%w",strtotime($study->appointment->date))]}}
                                                {{strftime("%d",strtotime($study->appointment->date))}}
                                                {{strtoupper($months[strftime("%m",strtotime($study->appointment->date))])}}
                                                {{strftime("%Y",strtotime($study->appointment->date))}} hrs.
                                                <br>
                                                {{$study->appointment->time}}
                                            @else
                                                Sin agendar cita
                                        @endif
                                        </h6>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <h5 class="col-12">
                                            Datos Paciente:
                                        </h5>
                                        <h6 class="col-12">
                                        {{$study->patient_name}} <!--{{$study->paternal_surname}} {{$study->maternal_surname}}-->
                                        </h6>
                                        <h6 class="col-12">
                                            {{$study->patient_email}}
                                        </h6>
                                        <h6 class="col-12">
                                            {{$study->patient_phone}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="mt-4 mb-4 form-label">Añade los estudios que se enviaran por correo, o pega un link para poder descargar los estudios.</h5>

                        <div class="form-row">
                            <p>El tamaño maximo de archivos que puedes enviar es de: <strong>25 MB</strong></p>
                            <div class="form-row col-md-12" style="margin-bottom: 25px">
                                <div class="input-images col-md-12"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Link de descarga</label>
                                <input id="link" class="form-control" placeholder="Link" type="text" name="link">
                            </div>        
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-12 mt-3 text-center">
                            <button id="save" type="button" class="btn-primary btn btn-rounded btn-new">Enviar</button>
                            <button id="finish" type="button" class="btn-success btn btn-rounded btn-new">Entrega física</button>
                        </div>
                @endif
                    </form>
            </div>
        </div>
    </div>
    
@endsection
@section('css')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="{{asset('libs/image-uploader-master/dist/image-uploader.min.js')}}"></script>
    @if (is_null($study))
        <script type="text/javascript">
            var studyId = null;
            var reloadFlag = true;
        </script>
    @else
        <script type="text/javascript">
            var studyId = {{$study->id}}
            var reloadFlag = false;
        </script>
    @endif
    <script type="text/javascript">

        $( "#finish" ).click(function() {
            if(studyId == null){
                Swal.fire(
                            'Error',
                            'Selecciona el estudio.',
                            'error'
                        )
            }else{
                Swal.fire({
                title: 'Terminar estudio',
                text: "¿Deseas terminar el estudio sin enviar archivos o link?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Finalizar'
                }).then((result) => {
                    if(result.isConfirmed){
                        Swal.fire({
                                    title: 'Enviando...',  
                                })
                        Swal.showLoading();
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/finishRecepcion/') }}/" + studyId,
                            data: {_token : '{{ csrf_token() }}'},
                            dataType: "json",
                            success: function (response) {
                                if(reloadFlag){
                                    location.reload();
                                }else{
                                    location.replace("/enviarEstudios")
                                }
                            }
                        });
                    }
                })
            }
            
        });

        $( "#save" ).click(function() {
            var files = $('input[name="images[]"]')[0].files;
            sizeTotal = 0;
            $.each(files, function (index, value) {
                var filesize = ((files[index].size/1024)/1024).toFixed(4); // MB
                sizeTotal += parseFloat(filesize);
            });
            if(sizeTotal > 0 && sizeTotal <= 25){
                if($("#selectStudy").length > 0) {
                    if($("#selectStudy").val() != null){
                        Swal.fire({
                            title: 'Enviando...',  
                        })
                        Swal.showLoading();
                        $('#formulario').submit();
                    }else{
                        Swal.fire(
                            'Error',
                            'Selecciona el estudio.',
                            'error'
                        )
                    }
                }else{
                    Swal.fire({
                        title: 'Enviando...',  
                    })
                    Swal.showLoading();
                    $('#formulario').submit();
                }               
            }else{
                if(sizeTotal > 25){
                    Swal.fire(
                        'Haz excedido el tamaño permitido',
                        'El tamaño máximo de archivos que puedes enviar es de 25 MB',
                        'error'
                    )
                }else{
                    if($('#link').val() != "" || sizeTotal > 0){
                        if($("#selectStudy").length > 0) {
                            if($("#selectStudy").val() != ""){
                                Swal.fire({
                                    title: 'Enviando...',  
                                })
                                Swal.showLoading();
                                $('#formulario').submit();
                            }else{
                                Swal.fire(
                                    'Error',
                                    'Selecciona el estudio.',
                                    'error'
                                )
                            }
                        }else{
                            Swal.fire({
                                title: 'Enviando...',  
                            })
                            Swal.showLoading();
                            $('#formulario').submit();
                        }
                        
                    }else{
                        Swal.fire(
                            'Correo vacio',
                            'Selecciona un archivo para enviar o escribe un link',
                            'error'
                        ) 
                    }
                    
                }
            }
        });

        var sizeTotal = 0;
        $('.input-images').imageUploader({
            label: 'Arrastra y suelta archivos aquí o haz clic',
            extensions: [],
            mimes: [],
            maxSize: 25 * 1024 * 1024,
        });

        $('input[name="images[]"]').on("change",function(e) {
            var files = $('input[name="images[]"]')[0].files;
            sizeTotal = 0;
            $.each(files, function (index, value) {
                var filesize = ((files[index].size/1024)/1024).toFixed(4); // MB
                sizeTotal += parseFloat(filesize);
            });
            
            $("img").on("error", function () {
                $(this).attr("src", "https://app.ddu.mx/image/azul100.png");
            });
            
                $( ".delete-image" ).click(function() {
                    var files = $('input[name="images[]"]')[0].files;
                    sizeTotal = 0;
                    $.each(files, function (index, value) {
                        var filesize = ((files[index].size/1024)/1024).toFixed(4); // MB
                        sizeTotal += parseFloat(filesize);
                    });
                   
                });

                
            

        });
        $('#selectStudy').change(function() {
            var id = $( this ).val();
            studyId = id;
            $.ajax({
                type: "POST",
                url: "{{ url('/getStudy') }}",
                data: {"id":id, _token : '{{ csrf_token() }}'},
                success: function (opciones) {
                    $("#study-data").html(opciones);
                    if($( "#reloadDrName" ).attr("value") == "true"){
                        $('.physical').show();
                    }else{
                        $('.physical').hide();                    
                    }
                }
            });
            var files = $('input[name="images[]"]')[0].files;
            sizeTotal = 0;
            $.each(files, function (index, value) {
                var filesize = ((files[index].size/1024)/1024).toFixed(4); // MB
                sizeTotal += parseFloat(filesize);
            });
            
        });

           
    </script>
@endsection



