<!DOCTYPE html>
<html lang="es">
    <head>
        <title>DDU | Doctores Depósito</title>
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
        <!-- bootstrap-tagsinput-latest css -->
        <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap-tagsinput-latest/css/bootstrap-tagsinput.css') }}">

        <!-- Smart Wizard css -->
        <link rel="stylesheet" href="{{ asset('/assets/plugins/smart-wizard/css/smart_wizard.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/plugins/smart-wizard/css/smart_wizard_theme_arrows.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/plugins/smart-wizard/css/smart_wizard_theme_circles.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/plugins/smart-wizard/css/smart_wizard_theme_dots.min.css') }}">

        <!-- vendor css -->
        <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
        <style>
            .auth-content{
                width: 80% !important;
            }
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
            #school{
                display: none;
            } 
            @media (max-width: 991px) {
                .div-cedula{
                    margin-top: 16px !important;  
                }
            }
            @media (min-width: 768px) {
                .div-absolute{
                    position: absolute; 
                    bottom: 0; 
                    width: 100%; 
                    padding-right: 30px;
                }
                .label-cedula{
                    margin: 0; 
                    position: absolute; 
                    top: 50%; 
                    -ms-transform: translateY(-50%); 
                    transform: translateY(-50%);
                }
            }
            @media (max-width: 690px) {
                .checkbox{
                    position: absolute !important;
                }
                .input-show{
                    margin-top: 40px;
                }
            }

            @media (max-width: 560px) {
                .div-cedula{
                    max-width: 100% !important;
                    flex: 0 0 100%; 
                    margin-top: 0px !important;  
               
                }
                .n-cedula{
                    margin-top: 50px !important;  
                }
            }
            @media (max-width: 425px) {
                .auth-content{
                width: 100% !important;
                }
            }
        </style>
    </head>
    @php
        setlocale(LC_TIME, "spanish");
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
        $yearConst = $year;
    @endphp
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
                    <div class="card-header text-center">
                        <div class="mb-4">
                            <i class="fas fa-clipboard auth-icon"></i>
                        </div>
                        <h3 class="mb-4">FORMULARIO DDU</h3>
                    </div>
                    
                    <form id="formulario" method="POST" action="{{ route('completeDocsdepo') }}">
                        @csrf
                        <div class="card-body ">
                            <h5 class="mb-4">DATOS GENERALES</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Nombre (s) <span style="color:red">*</span></label>
                                        <input id="name" class="form-control text-uppercase {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" value="{{ old('name') }}" required>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Primer Apellido<span style="color:red">*</span></label>
                                        <input id="paternalSurname" class="form-control text-uppercase {{ $errors->has('paternalSurname') ? ' is-invalid' : '' }}" type="text" name="paternalSurname" value="{{ old('paternalSurname') }}" required>
                                        @if ($errors->has('paternalSurname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('paternalSurname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Segundo Apellido<span style="color:red">*</span></label>
                                        <input id="maternalSurname" class="form-control text-uppercase {{ $errors->has('maternalSurname') ? ' is-invalid' : '' }}" type="text" name="maternalSurname" value="{{ old('maternalSurname') }}" required >
                                        @if ($errors->has('maternalSurname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('maternalSurname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="text-left">
                                        <label class="form-label">Fecha de nacimiento<span style="color:red">*</span></label>                                       
                                        @php
                                            $dateBirthday = [
                                                0 => $year,
                                                1 => 01,
                                                2 => 01
                                            ];
                                        @endphp  
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="form-label">Día</label>
                                                <select class="form-control {{ $errors->has('day') ? ' is-invalid' : '' }}" id="day" name="day" required>
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
                                            <div class="col-4">
                                                <label class="form-label">Mes</label>
                                                <select class="form-control {{ $errors->has('month') ? ' is-invalid' : '' }}" id="month" name="month" required>
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
                                            <div class="col-4">
                                                <label class="form-label">Año</label>
                                                <select class="form-control {{ $errors->has('year') ? ' is-invalid' : '' }}" id="year" name="year" required>
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
                                <div class="col-md-4 mt-3">
                                    <div class="input-group">
                                        <div class="form-group col-12 p-0 mb-0 text-left">
                                            <label class="form-label">Género<span style="color:red">*</span></label>
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
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="input-group">
                                        <div class="form-group col-12 p-0 mb-0 text-left">
                                            <label class="form-label">Celular<span style="color:red">*</span></label>
                                            <input type="text"  id="phone" name="phone" class="form-control mob_noPersonal {{ $errors->has('phone') ? ' is-invalid' : '' }}" data-mask="444-555-6677" value="{{ old('phone') }}" placeholder="999-999-9999" required>
                                            @if ($errors->has('phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group">
                                        <label class="form-label">Email<span style="color:red">*</span></label>
                                        <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group div-absolute">
                                        <label class="form-label">RFC</label>
                                        <input id="rfc" class="form-control text-uppercase {{ $errors->has('rfc') ? ' is-invalid' : '' }}" type="text" name="rfc" value="{{ old('rfc') }}">
                                        @if ($errors->has('rfc'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('rfc') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mt-0">
                                    <div class="form-group">
                                        <label class="form-label">Mis pacientes o colegas me conocen como: (Alias)</label>
                                        <input id="alias" class="form-control {{ $errors->has('alias') ? ' is-invalid' : '' }}" placeholder="Ej. Dr. Muelitas / Dra. Gina / Dr. Cruz" type="text" name="alias" value="{{ old('alias') }}">
                                        @if ($errors->has('alias'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('alias') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-body ">
                            <h5 class="mb-4">MI ESPECIALIDAD </h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Especialidad <span style="color:red">*</span></label>
                                        <select class="form-control {{ $errors->has('specialty') ? ' is-invalid' : '' }}" id="specialty" name="specialty" required>
                                            <option value="" selected disabled>Selecciona una</option>
                                            <option value="Ortodoncia">Ortodoncia</option>
                                            <option value="Endodoncia">Endodoncia</option>
                                            <option value="Periodoncia">Periodoncia</option>
                                            <option value="Odontopediatría">Odontopediatría</option>
                                            <option value="Rehabilitador">Rehabilitador</option>
                                            <option value="Dentista General">Dentista General</option>
                                            <option value="Soy Estudiante">Soy Estudiante</option>
                                        </select>
                                        @if ($errors->has('specialty'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('specialty') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="grades" class="card-body">
                            <h5 class="mb-4">MIS GRADOS PROFESIONALES</h5>
                            <p class="text-center"><a style="color:#007bff" target="_blank" href="https://cedulaprofesional.sep.gob.mx/cedula/presidencia/indexAvanzada.action">Consulta tu Cedula Profesional aquí</a></p>
                            <div class="row">
                                <div class="col-sm-12 row pr-0">
                                    <div class="col-md-12 col-lg-1">
                                        <label class="form-label label-cedula" style="">Cédula 1</label>                                    
                                    </div>
                                    <div class="col-7 col-md-8 pr-0 div-cedula">
                                        <div class="form-group">
                                            <label class="form-label">Plantel Educativo <span style="color:red">*</span></label>
                                            <input id="plantel1" class="form-control {{ $errors->has('plantel1') ? ' is-invalid' : '' }}" type="text" name="plantel1" value="{{ old('plantel1') }}" required>
                                            @if ($errors->has('plantel1'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('plantel1') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-5 col-md-4 col-lg-3 pr-0 div-cedula">
                                        <label class="form-label">Año de Expedición <span style="color:red">*</span></label>
                                        <select class="form-control {{ $errors->has('year1') ? ' is-invalid' : '' }}" id="year1" name="year1" required>
                                            <option value="" selected disabled>Selecciona el año de expedición:</option>
                                            @for ($i = $yearConst; $i >= 1950; $i--)
                                                <option value="{{$i}}" 
                                                    @if ($i == $yearConst )
                                                        selected
                                                    @endif
                                                >{{$i}}</option>
                                            @endfor
                                        </select>  
                                    </div>
                                </div>
                                <div class="col-12 row pr-0 n-cedula">
                                    <div class="col-md-12 col-lg-1">
                                        <label class="form-label label-cedula">Cédula 2</label>                                    
                                    </div>
                                    <div class="col-7 col-md-8 pr-0 div-cedula">
                                        <div class="form-group">
                                            <label class="form-label">Plantel Educativo</label>
                                            <input id="plantel2" class="form-control {{ $errors->has('plantel2') ? ' is-invalid' : '' }}" type="text" name="plantel2" value="{{ old('plantel2') }}">
                                            @if ($errors->has('plantel2'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('plantel2') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-5 col-md-4 col-lg-3 pr-0 div-cedula">
                                        <label class="form-label">Año de Expedición</label>
                                        <select class="form-control {{ $errors->has('year2') ? ' is-invalid' : '' }}" id="year2" name="year2" >
                                            <option value="" selected disabled>Selecciona el año de expedición:</option>
                                            @for ($i = $yearConst; $i >= 1950; $i--)
                                                <option value="{{$i}}" 
                                                    @if ($i == $yearConst )
                                                        selected
                                                    @endif
                                                >{{$i}}</option>
                                            @endfor
                                        </select>  
                                    </div>
                                </div>
                                <div class="col-12 row pr-0 n-cedula">
                                    <div class="col-md-12 col-lg-1">
                                        <label class="form-label label-cedula">Cédula 3</label>                                    
                                    </div>
                                    <div class="col-7 col-md-8 pr-0 div-cedula">
                                        <div class="form-group">
                                            <label class="form-label">Plantel Educativo</label>
                                            <input id="plantel3" class="form-control {{ $errors->has('plantel3') ? ' is-invalid' : '' }}" type="text" name="plantel3" value="{{ old('plantel3') }}">
                                            @if ($errors->has('plantel3'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('plantel3') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-5 col-md-4 col-lg-3 pr-0 div-cedula">
                                        <label class="form-label">Año de Expedición</label>
                                        <select class="form-control {{ $errors->has('year3') ? ' is-invalid' : '' }}" id="year3" name="year3" >
                                            <option value="" selected disabled>Selecciona el año de expedición:</option>
                                            @for ($i = $yearConst; $i >= 1950; $i--)
                                                <option value="{{$i}}" 
                                                    @if ($i == $yearConst )
                                                        selected
                                                    @endif
                                                >{{$i}}</option>
                                            @endfor
                                        </select>  
                                    </div>
                                </div>
                                <div class="col-12 row pr-0 n-cedula">
                                    <div class="col-md-12 col-lg-1">
                                        <label class="form-label label-cedula">Cédula 4</label>                                    
                                    </div>
                                    <div class="col-7 col-md-8 pr-0 div-cedula">
                                        <div class="form-group">
                                            <label class="form-label">Plantel Educativo</label>
                                            <input id="plantel4" class="form-control {{ $errors->has('plantel4') ? ' is-invalid' : '' }}" type="text" name="plantel4" value="{{ old('plantel4') }}">
                                            @if ($errors->has('plantel4'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('plantel4') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-5 col-md-4 col-lg-3 pr-0 div-cedula">
                                        <label class="form-label">Año de Expedición</label>
                                        <select class="form-control {{ $errors->has('year4') ? ' is-invalid' : '' }}" id="year4" name="year4" >
                                            <option value="" selected disabled>Selecciona el año de expedición:</option>
                                            @for ($i = $yearConst; $i >= 1950; $i--)
                                                <option value="{{$i}}" 
                                                    @if ($i == $yearConst )
                                                        selected
                                                    @endif
                                                >{{$i}}</option>
                                            @endfor
                                        </select>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="school" class="card-body">
                            <h5 class="mb-4">MIS GRADOS PROFESIONALES</h5>
                            <div class="row">
                                <div class="col-12 row">
                                    <div class="col-lg-4  col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Carrera<span style="color:red">*</span></label>
                                            <input id="career" class="form-school form-control {{ $errors->has('career') ? ' is-invalid' : '' }}" type="text" name="career" value="{{ old('career') }}">
                                            @if ($errors->has('career'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('career') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4  col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Plantel Educativo<span style="color:red">*</span></label>
                                            <input id="plantelSchool" class="form-school form-control {{ $errors->has('plantelSchool') ? ' is-invalid' : '' }}" type="text" name="plantelSchool" value="{{ old('plantelSchool') }}">
                                            @if ($errors->has('plantelSchool'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('plantelSchool') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4  col-md-6 col-sm-12">
                                        <label class="form-label">Ingresé en<span style="color:red">*</span></label>
                                        <select class="form-school form-control {{ $errors->has('yearSchool') ? ' is-invalid' : '' }}" id="yearSchool" name="yearSchool">
                                            <option value="" selected disabled>Selecciona el año de ingreso:</option>
                                            @for ($i = $yearConst; $i >= 1950; $i--)
                                                <option value="{{$i}}" 
                                                    @if ($i == $yearConst )
                                                        selected
                                                    @endif
                                                >{{$i}}</option>
                                            @endfor
                                        </select>  
                                    </div>
                                    <div class="col-lg-4  col-md-6 col-sm-12">
                                        <label class="form-label">Grado<span style="color:red">*</span></label>
                                        <select class="form-school form-control {{ $errors->has('degreeSchool') ? ' is-invalid' : '' }}" id="degreeSchool" name="degreeSchool">
                                            <option value="" selected disabled>Selecciona una opción</option>
                                            <option value="Especialidad">Especialidad</option>
                                            <option value="Posgrado">Posgrado</option>
                                            <optgroup label="Plan Semestral">
                                                <option value="Primer Semestre">Primer Semestre</option>
                                                <option value="Segundo Semestre">Segundo Semestre</option>
                                                <option value="Tercer Semestre">Tercer Semestre</option>
                                                <option value="Cuarto Semestre">Cuarto Semestre</option>
                                                <option value="Quinto Semestre">Quinto Semestre</option>
                                                <option value="Sexto Semestre">Sexto Semestre</option>
                                                <option value="Séptimo Semestre">Séptimo Semestre</option>
                                                <option value="Octavo Semestre">Octavo Semestre</option>
                                                <option value="Noveno Semestre">Noveno Semestre</option>
                                                <option value="Décimo Semestre">Décimo Semestre</option>
                                            </optgroup>
                                            <optgroup label="Plan Cuatrimestral">
                                                <option value="Primer Cuatrimestre">Primer Cuatrimestre</option>
                                                <option value="Segundo Cuatrimestre">Segundo Cuatrimestre</option>
                                                <option value="Tercer Cuatrimestre">Tercer Cuatrimestre</option>
                                                <option value="Cuarto Cuatrimestre">Cuarto Cuatrimestre</option>
                                                <option value="Quinto Cuatrimestre">Quinto Cuatrimestre</option>
                                                <option value="Sexto Cuatrimestre">Sexto Cuatrimestre</option>
                                                <option value="Séptimo Cuatrimestre">Séptimo Cuatrimestre</option>
                                                <option value="Octavo Cuatrimestre">Octavo Cuatrimestre</option>
                                                <option value="Noveno Cuatrimestre">Noveno Cuatrimestre</option>
                                                <option value="Décimo Cuatrimestre">Décimo Cuatrimestre</option>
                                                <option value="Décimo primer Cuatrimestre">Décimo primer Cuatrimestre</option>
                                                <option value="Décimo segundo Cuatrimestre">Décimo segundo Cuatrimestre</option>
                                                <option value="Décimo tercer Cuatrimestre">Décimo tercer Cuatrimestre</option>
                                                <option value="Décimo cuarto Cuatrimestre">Décimo cuarto Cuatrimestre</option>
                                                <option value="Décimo quinto Cuatrimestre">Décimo quinto Cuatrimestre</option>
                                            </optgroup>
                                        </select>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-body ">
                            <h5 class="mb-4">¿DONDE TRABAJO?</h5>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="checkbox" name="ownOffice" id="ownOffice">
                                            <label for="ownOffice" class="cr">Tengo Consultorio Propio</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show ownOfficeActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Dirección</label>
                                        <input id="officeAddress" class="form-control {{ $errors->has('officeAddress') ? ' is-invalid' : '' }}" type="text" name="officeAddress" value="{{ old('officeAddress') }}">
                                        @if ($errors->has('officeAddress'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('officeAddress') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show ownOfficeActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Ubicación en Google Maps (Link)</label>
                                        <input id="officeLink" class="form-control {{ $errors->has('officeLink') ? ' is-invalid' : '' }}" type="text" name="officeLink" value="{{ old('officeLink') }}">
                                        @if ($errors->has('officeLink'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('officeLink') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 mt-3 ownOfficeActive d-none">
                                    <div class="input-group">
                                        <div class="form-group col-12 p-0 mb-0 text-left">
                                            <label class="form-label">Teléfono de Consultorio</label>
                                            <input type="text"  id="officePhone" name="officePhone" class="form-control mob_noPersonal {{ $errors->has('officePhone') ? ' is-invalid' : '' }}" data-mask="444-555-6677" value="{{ old('officePhone') }}" placeholder="999-999-9999">
                                            @if ($errors->has('officePhone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('officePhone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3 ownOfficeActive d-none">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="checkbox" name="ownAssistant" id="ownAssistant">
                                            <label for="ownAssistant" class="cr">Tengo recepcionista / asistente</label>
                                        </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show ownOfficeActive ownAssistantActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Nombre de su asistente</span></label>
                                        <input id="nameAssistant" class="form-control text-uppercase {{ $errors->has('nameAssistant') ? ' is-invalid' : '' }}" type="text" name="nameAssistant" value="{{ old('nameAssistant') }}">
                                        @if ($errors->has('nameAssistant'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nameAssistant') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
    
                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="checkbox" name="clinic" id="clinic">
                                            <label for="clinic" class="cr">Soy parte de una Clínica</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 input-show clinicActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">¿Cómo se llama la clínica?</label>
                                        <input id="clinicName" class="form-control {{ $errors->has('clinicName') ? ' is-invalid' : '' }}" type="text" name="clinicName" value="{{ old('clinicName') }}">
                                        @if ($errors->has('clinicName'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('clinicName') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <label class="col-12 form-label clinicActive d-none">¿Dónde se encuentra ubicada?</label>                            
                                <div class="col-sm-12 col-md-6 input-show clinicActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Dirección</label>
                                        <input id="clinicAddress" class="form-control {{ $errors->has('clinicAddress') ? ' is-invalid' : '' }}" type="text" name="clinicAddress" value="{{ old('clinicAddress') }}">
                                        @if ($errors->has('clinicAddress'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('clinicAddress') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show clinicActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Ubicación en Google Maps (Link)</label>
                                        <input id="clinicLink" class="form-control {{ $errors->has('clinicLink') ? ' is-invalid' : '' }}" type="text" name="clinicLink" value="{{ old('clinicLink') }}">
                                        @if ($errors->has('clinicLink'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('clinicLink') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 input-show clinicActive d-none">
                                    <label class="form-label">Mis colegas que son parte de la clínica son: (Da enter para agregar nuevo colega)</label>
                                    <input data-role="tagsinput" id="colleagues" class="form-control {{ $errors->has('colleagues') ? ' is-invalid' : '' }}" type="text" name="colleagues" value="{{ old('colleagues') }}">
                                    @if ($errors->has('colleagues'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('colleagues') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="checkbox" name="variousClinics" id="variousClinics">
                                            <label for="variousClinics" class="cr">Atiendo en varios consultorios</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 input-show variousClinicsActive d-none">
                                    <label class="form-label">Nombre de los Planteles de Salud: (Da enter para agregar nuevo plantel)</label>
                                    <input data-role="tagsinput" id="variousClinicsName" class="form-control {{ $errors->has('variousClinicsName') ? ' is-invalid' : '' }}" type="text" name="variousClinicsName" value="{{ old('variousClinicsName') }}">
                                    @if ($errors->has('variousClinicsName'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('variousClinicsName') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 input-show variousClinicsActive d-none">
                                    <label class="form-label">Atiendo en varias ciudades: (Da enter para agregar nueva ciudad)</label>
                                    <input data-role="tagsinput" id="variousClinicsCity" class="form-control {{ $errors->has('variousClinicsCity') ? ' is-invalid' : '' }}" type="text" name="variousClinicsCity" value="{{ old('variousClinicsCity') }}">
                                    @if ($errors->has('variousClinicsCity'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('variousClinicsCity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="checkbox" name="student" id="student">
                                            <label for="student" class="cr">Soy estudiante pero trabajo de aprendiz / becario en un consultorio</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 input-show studentActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Colaboro en el Consultorio del Dr./Dra.</label>
                                        <input id="studentDoctor" class="form-control {{ $errors->has('studentDoctor') ? ' is-invalid' : '' }}" type="text" name="studentDoctor" value="{{ old('studentDoctor') }}">
                                        @if ($errors->has('studentDoctor'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('studentDoctor') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 input-show studentActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Colaboro en una Clínica (Coloca el nombre de la clínica)</label>
                                        <input id="studentName" class="form-control {{ $errors->has('studentName') ? ' is-invalid' : '' }}" type="text" name="studentName" value="{{ old('studentName') }}">
                                        @if ($errors->has('studentName'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('studentName') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 input-show studentActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Donde trabajo se encuentra ubicado en (Ubicación en Google Maps)</label>
                                        <input id="studentLink" class="form-control {{ $errors->has('studentLink') ? ' is-invalid' : '' }}" type="text" name="studentLink" value="{{ old('studentLink') }}">
                                        @if ($errors->has('studentLink'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('studentLink') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="checkbox" name="noWork" id="noWork">
                                            <label for="noWork" class="cr">Aún no trabajo, soy estudiante</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-body ">
                            <h5 class="mb-4">REDES SOCIALES</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 input-show">
                                    <div class="form-group">
                                        <label class="form-label">Doctoralia (Link)</label>
                                        <input id="doctoralia" class="form-control {{ $errors->has('doctoralia') ? ' is-invalid' : '' }}" type="text" name="doctoralia" value="{{ old('doctoralia') }}">
                                        @if ($errors->has('doctoralia'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('doctoralia') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="checkbox" name="personalBranding" id="personalBranding">
                                            <label for="personalBranding" class="cr">Mi nombre de Doctor lo manejo como Marca Personal Profesional</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show personalBrandingActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Facebook de mi perfil profesional (Link)</label>
                                        <input id="personalBrandingFB" class="form-control {{ $errors->has('personalBrandingFB') ? ' is-invalid' : '' }}" type="text" name="personalBrandingFB" value="{{ old('personalBrandingFB') }}">
                                        @if ($errors->has('personalBrandingFB'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('personalBrandingFB') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show personalBrandingActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Instagram de mi perfil profesional (Link)</label>
                                        <input id="personalBrandingIg" class="form-control {{ $errors->has('personalBrandingIg') ? ' is-invalid' : '' }}" type="text" name="personalBrandingIg" value="{{ old('personalBrandingIg') }}">
                                        @if ($errors->has('personalBrandingIg'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('personalBrandingIg') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show personalBrandingActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">TikTok de mi perfil profesional (Link)</label>
                                        <input id="personalBrandingTik" class="form-control {{ $errors->has('personalBrandingTik') ? ' is-invalid' : '' }}" type="text" name="personalBrandingTik" value="{{ old('personalBrandingTik') }}">
                                        @if ($errors->has('personalBrandingTik'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('personalBrandingTik') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show personalBrandingActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">LinkedIn de mi perfil profesional (Link)</label>
                                        <input id="personalBrandingLI" class="form-control {{ $errors->has('personalBrandingLI') ? ' is-invalid' : '' }}" type="text" name="personalBrandingLI" value="{{ old('personalBrandingLI') }}">
                                        @if ($errors->has('personalBrandingLI'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('personalBrandingLI') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show personalBrandingActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Website de mi perfil profesional (Link)</label>
                                        <input id="personalBrandingWeb" class="form-control {{ $errors->has('personalBrandingWeb') ? ' is-invalid' : '' }}" type="text" name="personalBrandingWeb" value="{{ old('personalBrandingWeb') }}">
                                        @if ($errors->has('personalBrandingWeb'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('personalBrandingWeb') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="checkbox" name="trademark" id="trademark">
                                            <label for="trademark" class="cr">Manejo mi consultorio como una marca comercial</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show trademarkActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">La marca de mi consultorio se llama</label>
                                        <input id="trademarkName" class="form-control {{ $errors->has('trademarkName') ? ' is-invalid' : '' }}" type="text" name="trademarkName" value="{{ old('trademarkName') }}">
                                        @if ($errors->has('trademarkName'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('trademarkName') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show trademarkActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Facebook de mi consultorio (Link)</label>
                                        <input id="trademarkFB" class="form-control {{ $errors->has('trademarkFB') ? ' is-invalid' : '' }}" type="text" name="trademarkFB" value="{{ old('trademarkFB') }}">
                                        @if ($errors->has('trademarkFB'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('trademarkFB') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show trademarkActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Instagram de mi consultorio (Link)</label>
                                        <input id="trademarkIg" class="form-control {{ $errors->has('trademarkIg') ? ' is-invalid' : '' }}" type="text" name="trademarkIg" value="{{ old('trademarkIg') }}">
                                        @if ($errors->has('trademarkIg'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('trademarkIg') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show trademarkActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">TikTok de mi consultorio (Link)</label>
                                        <input id="trademarkTik" class="form-control {{ $errors->has('trademarkTik') ? ' is-invalid' : '' }}" type="text" name="trademarkTik" value="{{ old('trademarkTik') }}">
                                        @if ($errors->has('trademarkTik'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('trademarkTik') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show trademarkActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">LinkedIn de mi consultorio (Link)</label>
                                        <input id="trademarkLI" class="form-control {{ $errors->has('trademarkLI') ? ' is-invalid' : '' }}" type="text" name="trademarkLI" value="{{ old('trademarkLI') }}">
                                        @if ($errors->has('trademarkLI'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('trademarkLI') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show trademarkActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Website de mi consultorio (Link)</label>
                                        <input id="trademarkWeb" class="form-control {{ $errors->has('trademarkWeb') ? ' is-invalid' : '' }}" type="text" name="trademarkWeb" value="{{ old('trademarkWeb') }}">
                                        @if ($errors->has('trademarkWeb'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('trademarkWeb') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>    
                                <div class="col-12 mt-5">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="checkbox" name="workClinic" id="workClinic">
                                            <label for="workClinic" class="cr">Las redes de la clínica donde trabajo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show workClinicActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">La clínica se llama</label>
                                        <input id="workClinicName" class="form-control {{ $errors->has('workClinicName') ? ' is-invalid' : '' }}" type="text" name="workClinicName" value="{{ old('workClinicName') }}">
                                        @if ($errors->has('workClinicName'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('workClinicName') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show workClinicActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Facebook de la Clínica (Link)</label>
                                        <input id="workClinicFB" class="form-control {{ $errors->has('workClinicFB') ? ' is-invalid' : '' }}" type="text" name="workClinicFB" value="{{ old('workClinicFB') }}">
                                        @if ($errors->has('workClinicFB'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('workClinicFB') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show workClinicActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Instagram de la Clínica (Link)</label>
                                        <input id="workClinicIg" class="form-control {{ $errors->has('workClinicIg') ? ' is-invalid' : '' }}" type="text" name="workClinicIg" value="{{ old('workClinicIg') }}">
                                        @if ($errors->has('workClinicIg'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('workClinicIg') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show workClinicActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">TikTok de de la Clínica (Link)</label>
                                        <input id="workClinicTik" class="form-control {{ $errors->has('workClinicTik') ? ' is-invalid' : '' }}" type="text" name="workClinicTik" value="{{ old('workClinicTik') }}">
                                        @if ($errors->has('workClinicTik'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('workClinicTik') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show workClinicActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">LinkedIn de la Clínica (Link)</label>
                                        <input id="workClinicLI" class="form-control {{ $errors->has('workClinicLI') ? ' is-invalid' : '' }}" type="text" name="workClinicLI" value="{{ old('workClinicLI') }}">
                                        @if ($errors->has('workClinicLI'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('workClinicLI') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 input-show workClinicActive d-none">
                                    <div class="form-group">
                                        <label class="form-label">Website de la Clínica (Link)</label>
                                        <input id="workClinicWeb" class="form-control {{ $errors->has('workClinicWeb') ? ' is-invalid' : '' }}" type="text" name="workClinicWeb" value="{{ old('workClinicWeb') }}">
                                        @if ($errors->has('workClinicWeb'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('workClinicWeb') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h3>
                                Gracias por tu tiempo.
                            </h3>
                            <br>
                            <h5>
                                Completar tu información nos ayuda a conocerte mejor y brindarte mejores servicios para atender las necesidades de nuestra comunidad dental.        
                            </h5>
                            <div class="mt-5">
                                <p class="mt-2 mb-2 text-muted"><a href="{{ route('Privacy') }}" target="_blank">AVISO DE PRIVACIDAD</a></p>
                                <p class="mt-2 mb-2 text-muted"><a href="{{ route('Terminos') }}" target="_blank">TÉRMINOS Y CONDICIONES</a></p>    
                            </div>
                            
                        </div>
                    </form>
                        <div class="card-body text-center">
                            <button class="btn btn-primary shadow-2 mb-3" id="save">Guardar datos</button>
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
            
        <!-- Smart Wizard Js -->
        <script src="{{ asset('/assets/plugins/smart-wizard/js/jquery.smartWizard.min.js') }}"></script>
        <script src="{{ asset('/assets/js/pages/wizard-custom.js') }}"></script>

        <!-- bootstrap-tagsinput-latest Js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
        <script src="{{ asset('/assets/plugins/bootstrap-tagsinput-latest/js/bootstrap-tagsinput.min.js') }}"></script>


        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if(\Session::has('success'))
            <script>
                Swal.fire({
                    title: 'Datos guardados',
                    confirmButtonText: 'Cerrar',
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $(location).attr('href',"https://ddu.mx/");
                    } else{
                    }
                })
            </script>
        @endif

        <script type="text/javascript">
             $("#specialty").change(function(){
                var specialty = $(this).val();
                if(specialty == "Soy Estudiante"){
                    $('#plantel1').removeAttr("required");
                    $('.form-school').prop("required", true);
                    $('#grades').hide(); 
                    $('#school').show();                                                         
                }else{
                    $('#plantel1').prop("required", true);
                    $('.form-school').removeAttr("required");
                    $('#grades').show();
                    $('#school').hide();                     
                }
             });
            $( "#ownOffice" ).click(function() {
                if ($(this).is(':checked')) {
                    $(".ownOfficeActive").removeClass( "d-none" );
                    if ($("#ownAssistant").is(':checked')) {
                        $(".ownAssistantActive").removeClass( "d-none" );
                    }else{
                        $(".ownAssistantActive").addClass( "d-none" );
                    }
                }else{
                    $(".ownOfficeActive").addClass( "d-none" );
                }
            });           

            $( "#ownAssistant" ).click(function() {
                if ($(this).is(':checked')) {
                    $(".ownAssistantActive").removeClass( "d-none" );
                }else{
                    $(".ownAssistantActive").addClass( "d-none" );
                }
            });

            $( "#clinic" ).click(function() {
                if ($(this).is(':checked')) {
                    $(".clinicActive").removeClass( "d-none" );
                }else{
                    $(".clinicActive").addClass( "d-none" );
                }
            });

            $( "#variousClinics" ).click(function() {
                if ($(this).is(':checked')) {
                    $(".variousClinicsActive").removeClass( "d-none" );
                }else{
                    $(".variousClinicsActive").addClass( "d-none" );
                }
            });
            
            $( "#student" ).click(function() {
                if ($(this).is(':checked')) {
                    $(".studentActive").removeClass( "d-none" );
                }else{
                    $(".studentActive").addClass( "d-none" );
                }
            });

            $( "#personalBranding" ).click(function() {
                if ($(this).is(':checked')) {
                    $(".personalBrandingActive").removeClass( "d-none" );
                }else{
                    $(".personalBrandingActive").addClass( "d-none" );
                }
            });
            
            $( "#trademark" ).click(function() {
                if ($(this).is(':checked')) {
                    $(".trademarkActive").removeClass( "d-none" );
                }else{
                    $(".trademarkActive").addClass( "d-none" );
                }
            });

            $( "#workClinic" ).click(function() {
                if ($(this).is(':checked')) {
                    $(".workClinicActive").removeClass( "d-none" );
                }else{
                    $(".workClinicActive").addClass( "d-none" );
                }
            });

            $( "#save" ).click(function() {
                var valid = true;
                $.each($("input[required]"), function (index, value) {
                    if(!$(value).val()){
                        console.log($( this ).attr('id'));
                        valid = false;
                    }
                });
                $.each($("select[required]"), function (index, value) {
                    if(!$(value).val()){
                        console.log($( this ).attr('id'));
                        valid = false;
                    }
                });
                if(valid){
                    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    var regexPhone = /^([0-9]{3})+(-)+([0-9]{3})+(-)+([0-9]{4})/;
                    if(!regex.test($("#email").val()) || !regexPhone.test($("#phone").val())){
                        console.log("Formato incorrecto: "+$( this ).attr('id'));
                        valid = false;
                    }
                    if(valid){
                        $( "body" ).addClass('overflow-hidden');
                        Swal.fire({
                            title: 'Guardando...',  
                        })
                        Swal.showLoading();
                        $('#formulario').submit();
                    }else{
                        Swal.fire(
                            'Formulario incorrecto',
                            'Los datos son incorrectos, revisa el formato de Celular y Email',
                        )
                    }
                } 
                else{
                    Swal.fire(
                        'Formulario incompleto',
                        'Debes llenar todos los campos obligatorios',
                    )
                }
            });
        </script>
    </body>
</html>