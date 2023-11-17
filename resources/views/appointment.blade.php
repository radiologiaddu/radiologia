<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DDU | Agendar cita</title>
        <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 10]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        <meta name="author" content="CodedThemes" />

        <!-- Favicon icon -->
        <link rel="icon" href="{{ asset('/image/menta100.png') }} " type="image/x-icon">
        <!-- fontawesome icon -->
        <link rel="stylesheet" href="{{ asset('/assets/fonts/fontawesome/css/fontawesome-all.min.css') }}">
        <!-- animation css -->
        <link rel="stylesheet" href="{{ asset('/assets/plugins/animation/css/animate.min.css') }}">
        <!-- material datetimepicker css -->
        <link rel="stylesheet" href="{{ asset('/assets/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
        <!-- Bootstrap datetimepicker css -->
        <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/fonts/material/css/materialdesignicons.min.css') }}">
        <!-- vendor css -->
        <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
        <style>
            ::-webkit-scrollbar {
                -webkit-appearance: none;
                width: 3px;
                height: 4px;
                margin-left: 16px;
                margin-right: 16px;
            }
            ::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: #6e7bde;
            -webkit-box-shadow: 0 0 1px #6e7bde;
            }
        </style>
    </head>

    <body>
        <div class="auth-wrapper">
            <div class="auth-content">
                <div class="auth-bg">
                    <span class="r"></span>
                    <span class="r s"></span>
                    <span class="r s"></span>
                    <span class="r"></span>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <form id="formulario" method="POST" action="{{ route('schedule', $study->id) }}">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="mb-4">
                                <i class="feather icon-calendar auth-icon"></i>
                            </div>
                            <h3 class="mb-4">Agendar cita</h3>
                            <div style="height: 53vh;overflow: overlay;">                                
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">FECHA DE CITA</label>
                                        <input type="text" id="personal_date" name="personal_date" class="form-control {{ $errors->has('personal_date') ? ' is-invalid' : '' }}" placeholder="FECHA DE CITA" value="{{ old('personal_date') }}" required>
                                        @if ($errors->has('personal_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('personal_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">HORARIO</label>
                                        <select class="form-control {{ $errors->has('hour') ? ' is-invalid' : '' }}" id="hour" name="hour" required>
                                            <option value="" selected disabled>Selecciona un horario</option>
                                        </select>
                                        @if ($errors->has('hour'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('hour') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>  
                            </div>
                                                    
                            <button  id="save" type="button" class="btn btn-primary shadow-2 mb-1 mt-2">Agendar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Required Js -->
        <script src="{{ asset('/assets/js/vendor-all.min.js') }}"></script>
        <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/assets/js/pcoded.min.js') }}"></script>

        <!-- Input mask Js -->
        <script src="{{ asset('/assets/plugins/inputmask/js/inputmask.min.js') }}"></script>
        <script src="{{ asset('/assets/plugins/inputmask/js/jquery.inputmask.min.js') }}"></script>
        <script src="{{ asset('/assets/plugins/inputmask/js/autoNumeric.js') }}"></script>

        <!-- material datetimepicker Js -->
        <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
        <script src="{{ asset('/assets/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
        <!-- form-picker-custom Js -->
        <script src="{{ asset('/assets/js/pages/form-picker-custom.js') }}"></script>
        <script src="{{ asset('/assets/js/pages/form-masking-custom.js') }}"></script>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            
            $('#personal_date').bootstrapMaterialDatePicker({
                minDate : new Date(),
                weekStart: 0,
                time: false,
                lang : 'es',
            });
            
            $("#personal_date").change(function(evt){
                var value = $( this ).val();
                $.ajax({
                    type: "POST",
                    url: "{{ url('/getHour') }}",
                    data: {"fecha":value, _token : '{{ csrf_token() }}'},
                    success: function (opciones) {
                        $("#hour").html(opciones);                     
                    }

                });
                
            });
            $( "#save" ).click(function() {
                var valid = true;
                $.each($("input[required]"), function (index, value) {
                    if(!$(value).val()){
                    valid = false;
                    }
                });
                $.each($("select[required]"), function (index, value) {
                    if(!$(value).val()){
                    valid = false;
                    }
                });
                
                
                if(valid){
                    Swal.fire({
                        title: 'Agendando cita...',  
                    })
                    Swal.showLoading();
                    $('#formulario').submit();
                } 
                else{
                    Swal.fire(
                    'Formulario incompleto',
                    'Debes llenar todos los campos',
                    )
                }
            });
        </script>
    </body>
</html>