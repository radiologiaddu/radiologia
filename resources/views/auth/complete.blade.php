<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DDU | Completar Registro</title>
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
               
        <!-- select2 css -->
        <link rel="stylesheet" href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}">

        <style type="text/css">
            .input-group{
                background-color: #ffffff;
            }
            .select2-selection--single{
                background: #f4f7fa !important;
            }
            .card-transparent{
                padding: 0px !important;
            }
        </style>
        @php
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
                        <form method="POST" action="{{ route('complete', $user->id) }}">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="mb-4">
                                <i class="feather icon-user-plus auth-icon"></i>
                            </div>
                            <h3 class="mb-4">Completa tu Registro</h3>
                            <div style="height: 53vh;overflow: overlay; overflow-x: hidden; padding: 1px;">
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">NOMBRE (S)</label>
                                        <input id="name" class="form-control text-uppercase {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">APELLIDO PATERNO</label>
                                        <input id="paternalSurname" class="form-control text-uppercase {{ $errors->has('paternalSurname') ? ' is-invalid' : '' }}" type="text" name="paternalSurname" value="{{ old('paternalSurname') }}" required>
                                        @if ($errors->has('paternalSurname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('paternalSurname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">APELLIDO MATERNO</label>
                                        <input id="maternalSurname" class="form-control text-uppercase {{ $errors->has('maternalSurname') ? ' is-invalid' : '' }}" type="text" name="maternalSurname" value="{{ old('maternalSurname') }}" required >
                                        @if ($errors->has('maternalSurname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('maternalSurname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">ALIAS ¿Cómo te conocen?</label>
                                        <input id="alias" class="form-control {{ $errors->has('alias') ? ' is-invalid' : '' }}" placeholder="Dra. Mari / Dr. Arreola" type="text" name="alias" value="{{ old('alias') }}" required>
                                        @if ($errors->has('alias'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('alias') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <!--
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">TÍTULO</label>
                                        <select class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" required>
                                            <option value="Sin especificar" selected>Sin especificar</option>
                                            <option value="Dr">Dr.</option>
                                            <option value="Dra">Dra.</option>
                                        </select>
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                -->
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">ESPECIALIDAD</label>
                                        <select class="form-control {{ $errors->has('specialty') ? ' is-invalid' : '' }}" id="specialty" name="specialty" required>
                                            <option value="" selected disabled>Selecciona una</option>
                                            <option value="Ortodoncia">Ortodoncia</option>
                                            <option value="Endodoncia">Endodoncia</option>
                                            <option value="Periodoncia">Periodoncia</option>
                                            <option value="Odontopediatría">Odontopediatría</option>
                                            <option value="Rehabilitador">Rehabilitador</option>
                                            <option value="Dentista General">Dentista General</option>
                                        </select>
                                        @if ($errors->has('specialty'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('specialty') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">FECHA DE NACIMIENTO</label>
                                        @php
                                            $dateBirthday = [
                                                0 => $year,
                                                1 => 01,
                                                2 => 01
                                            ];
                                        @endphp  
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label">DÍA</label>
                                                <select class="js-example-basic-single form-control {{ $errors->has('day') ? ' is-invalid' : '' }}" id="day" name="day" required>
                                                    <option value="" selected disabled>Selecciona el día de tu nacimiento:</option>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{sprintf('%02d',$i)}}" 
                                                            @if (sprintf('%02d',$i) == $dateBirthday[2] )
                                                                selected
                                                            @endif
                                                        >{{sprintf('%02d',$i)}}</option>
                                                    @endfor
                                                </select>                                    
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">MES</label>
                                                <select class="js-example-basic-single form-control {{ $errors->has('month') ? ' is-invalid' : '' }}" id="month" name="month" required>
                                                    <option value="" selected disabled>Selecciona el mes de tu nacimiento:</option>
                                                    @for ($j = 1; $j <= 12; $j++)
                                                        <option value="{{sprintf('%02d',$j)}}" 
                                                            @if (sprintf('%02d',$j) == $dateBirthday[1] )
                                                                selected
                                                            @endif
                                                        >{{$months[sprintf('%02d',$j)]}}</option>
                                                    @endfor
                                                </select>                                    
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">AÑO</label>
                                                <select class="js-example-basic-single form-control {{ $errors->has('year') ? ' is-invalid' : '' }}" id="year" name="year" required>
                                                    <option value="" selected disabled>Selecciona el año de tu nacimiento:</option>
                                                    @for ($i = 1; $i <= 100; $i++)
                                                        <option value="{{$year}}" 
                                                            @if ($year == $dateBirthday[0] )
                                                                selected
                                                            @endif
                                                        >{{$year}}</option>
                                                        @php
                                                            $year--;
                                                        @endphp
                                                    @endfor
                                                </select>                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">GÉNERO</label>
                                        <select class="form-control {{ $errors->has('gender') ? ' is-invalid' : '' }}" id="gender" name="gender" required>
                                            <option value="" selected disabled>Selecciona una</option>
                                            <option value="Femenino">Femenino</option>
                                            <option vlaue="Masculino">Masculino</option>
                                            <option value="No binario">No binario</option>                                       
                                        </select>
                                        @if ($errors->has('gender'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('gender') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">NÚMERO DE CONTACTO</label>
                                        <input type="text"  id="phone" name="phone" class="form-control mob_noPersonal {{ $errors->has('phone') ? ' is-invalid' : '' }}" data-mask="444-555-6677" value="{{ old('phone') }}" placeholder="999-999-9999" required>
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">TU CONTRASEÑA</label>
                                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Contraseña" id="password" name="password" required autocomplete="new-password">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">CONFIRMAR CONTRASEÑA</label>
                                        <input type="password" class="form-control" placeholder="Confirmar contraseña" id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                </div>    
                            </div>
                            <p class="mt-2 mb-2 text-muted"><a href="{{ route('Privacy') }}" target="_blank">AVISO DE PRIVACIDAD</a></p>
                 
                            <button class="btn btn-primary shadow-2 mb-1 mt-2">Registrar</button>
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
        
        <!-- select2 Js -->
        <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>     

        <!-- form-select-custom Js -->
        <script src="{{ asset('/assets/js/pages/form-select-custom.js') }}"></script>  

        <!-- form-picker-custom Js -->
        <script src="{{ asset('/assets/js/pages/form-picker-custom.js') }}"></script>
        <script src="{{ asset('/assets/js/pages/form-masking-custom.js') }}"></script>
        <script>
            $(".mob_noPersonal").inputmask({
                mask: "999-999-9999"
            });
        </script>
    </body>
</html>