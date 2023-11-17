<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DDU | Facturar</title>
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
                        <form id="formulario" method="POST" action="{{ route('addInvoice', $study->id) }}">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="mb-4">
                                <i class="feather icon-calendar auth-icon"></i>
                            </div>
                            <h3 class="mb-4">Factura</h3>
                            <div style="height: 53vh;overflow: overlay;">                                
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">RFC</label>
                                        <input id="rfc" class="form-control text-uppercase {{ $errors->has('rfc') ? ' is-invalid' : '' }}" placeholder="RFC" type="text" name="rfc" value="{{ old('rfc') }}" required>
                                        @if ($errors->has('rfc'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('rfc') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">Razón Social</label>
                                        <input id="razon" class="form-control text-uppercase {{ $errors->has('razon') ? ' is-invalid' : '' }}" placeholder="Razón social" type="text" name="razon" value="{{ old('razon') }}" required>
                                        @if ($errors->has('razon'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('razon') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">Código Postal</label>
                                        <input type="text" class="form-control" id="cp" name="cp" placeholder="CÓDIGO POSTAL"  value="{{ old('cp') }}" required>
                                        @if ($errors->has('cp'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cp') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">CFDI</label>
                                        <select class="form-control {{ $errors->has('cfdi') ? ' is-invalid' : '' }}" id="cfdi" name="cfdi" required>
                                            <option value="" selected disabled>Selecciona una opcion</option>
                                            @foreach ($cfdis as $cfdi)
                                                <option value="{{$cfdi->key_cfdi}}" >{{$cfdi->key_cfdi}} - {{$cfdi->cfdi}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('cfdi'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cfdi') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>  
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">Regimen fiscal</label>
                                        <select class="form-control {{ $errors->has('tax') ? ' is-invalid' : '' }}" id="tax" name="tax" required>
                                            <option value="" selected disabled>Selecciona una opcion</option>
                                            @foreach ($taxes as $tax)
                                                <option value="{{$tax->key_regimen}}" >{{$tax->key_regimen}} - {{$tax->regimen}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('tax'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tax') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>  
                            </div>
                                                    
                            <button  id="save" type="button" class="btn btn-primary shadow-2 mb-1 mt-2">Solicitar factura</button>
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
            $("#cp").inputmask({
                mask: "99999"
            });
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
                        title: 'Enviando informacion...',  
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