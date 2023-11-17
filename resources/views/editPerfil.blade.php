@extends('layouts.layoutDr')
@section('title','Perfil')
@section('leve','Perfil')
@section('breadcrumb')

@endsection
@section('content')
    <!-- material datetimepicker css -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
    <!-- Bootstrap datetimepicker css -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/fonts/material/css/materialdesignicons.min.css') }}">
    <!-- select2 css -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}">
    <style>
        .custom-file-input ~ .custom-file-label::after {
            content: "Elegir";
        }
        .custom-file-label{
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
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
        @media (max-width: 425px) {
            .padding-0 {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
            .text-total{
                text-align: center !important;
            }
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
    <div class="col-sm-12">
        <form method="POST" action="{{ route('updateDoctor', $user->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="card">
                <div class="card-header row">
                    <div class=col-12>
                        <div > 
                            <div class="ext-logo-image" style="margin-left: auto;margin-right: auto;">
                                <div class="int-logo-image">

                                    @if (is_null(auth()->user()->doctor->photo))
                                        <img src="{{ asset('assets/images/user/defaultProfile.png')}}" class="img-radius" alt="User-Profile-Image">
                                    @else
                                        <img src="{{auth()->user()->doctor->photo}}" class="img-radius" alt="User-Profile-Image">

                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="custom-file mt-2">
                            <input name="customFileLang" type="file" class="custom-file-input" id="customFileLang" lang="es">
                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="text-left">
                            <label class="form-label">NOMBRE (S)</label>
                            <input id="name" class="form-control text-uppercase {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nombre (S)" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="text-left">
                            <label class="form-label">APELLIDO PATERNO</label>
                            <input id="paternalSurname" class="form-control text-uppercase {{ $errors->has('paternalSurname') ? ' is-invalid' : '' }}" placeholder="Apellido Paterno" type="text" name="paternalSurname" value="{{ old('paternalSurname',$doctor->paternalSurname) }}" required>
                            @if ($errors->has('paternalSurname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('paternalSurname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="text-left">
                            <label class="form-label">APELLIDO MATERNO</label>
                            <input id="maternalSurname" class="form-control text-uppercase {{ $errors->has('maternalSurname') ? ' is-invalid' : '' }}" placeholder="Apellido Materno" type="text" name="maternalSurname" value="{{ old('maternalSurname',$doctor->maternalSurname) }}" required >
                            @if ($errors->has('maternalSurname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('maternalSurname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div><div class="col-md-6 mt-3">
                        <div class="text-left">
                            <label class="form-label">ALIAS ¿Como te conocen?</label>
                            <input id="alias" class="form-control {{ $errors->has('alias') ? ' is-invalid' : '' }}" placeholder="Dr. Canchola / Dra. Mari" type="text" name="alias" value="{{ old('alias', $doctor->alias) }}" required>
                            @if ($errors->has('alias'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('alias') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <!--
                    <div class="col-md-6 mt-3">
                        <div class="text-left">
                            <label class="form-label">TÍTULO</label>
                            <select class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" id="title" name="title" required>
                                <option value="Sin especificar"
                                    @if ($doctor->title == "Sin especificar")
                                        selected
                                    @endif  
                                >Sin especificar</option>
                                <option value="Dr"
                                    @if ($doctor->title == "Dr")
                                        selected
                                    @endif
                                >Dr.</option>
                                <option value="Dra"
                                    @if ($doctor->title == "Dra")
                                        selected
                                    @endif
                                >Dra.</option>
                            </select>
                            @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    -->
                    <div class="col-md-6 mt-3">
                        <div class="text-left">
                            <label class="form-label">ESPECIALIDAD</label>
                            <select class="form-control {{ $errors->has('specialty') ? ' is-invalid' : '' }}" id="specialty" name="specialty" required>
                                <option value="" disabled>Selecciona una</option>
                                <option value="Ortodoncia"
                                    @if ($doctor->specialty == "Ortodoncia")
                                        selected
                                    @endif
                                >Ortodoncia</option>
                                <option value="Endodoncia"
                                    @if ($doctor->specialty == "Endodoncia")
                                        selected
                                    @endif
                                >Endodoncia</option>
                                <option value="Periodoncia"
                                    @if ($doctor->specialty == "Periodoncia")
                                        selected
                                    @endif
                                >Periodoncia</option>
                                <option value="Odontopediatría"
                                    @if ($doctor->specialty == "Odontopediatría")
                                        selected
                                    @endif
                                >Odontopediatría</option>
                                <option value="Rehabilitador"
                                    @if ($doctor->specialty == "Rehabilitador")
                                        selected
                                    @endif
                                >Rehabilitador</option>
                                <option value="Dentista General"
                                    @if ($doctor->specialty == "Dentista General")
                                        selected
                                    @endif
                                >Dentista General</option>
                            </select>
                            @if ($errors->has('specialty'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('specialty') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div><div class="col-md-12 mt-3">
                        <div class="text-left">
                            <label class="form-label">FECHA DE NACIMIENTO</label>
                            @if (is_null($doctor->birthday))
                                @php
                                    $dateBirthday = [
                                        0 => $year,
                                        1 => 01,
                                        2 => 01
                                    ];
                                @endphp  
                            @else
                                @php
                                    $dateBirthday = explode("-", $doctor->birthday);
                                @endphp   
                            @endif
                                
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <label class="form-label">DÍA</label>
                                    <select class="js-example-basic-single form-control {{ $errors->has('day') ? ' is-invalid' : '' }}" id="day" name="day" required>
                                        <option value="" selected disabled>Selecciona el dia de nacimiento</option>
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{sprintf('%02d',$i)}}" 
                                                @if (sprintf('%02d',$i) == $dateBirthday[2] )
                                                    selected
                                                @endif
                                            >{{sprintf('%02d',$i)}}</option>
                                        @endfor
                                    </select>                                    
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label">MES</label>
                                    <select class="js-example-basic-single form-control {{ $errors->has('month') ? ' is-invalid' : '' }}" id="month" name="month" required>
                                        <option value="" selected disabled>Selecciona el mes de nacimiento</option>
                                        @for ($j = 1; $j <= 12; $j++)
                                            <option value="{{sprintf('%02d',$j)}}" 
                                                @if (sprintf('%02d',$j) == $dateBirthday[1] )
                                                    selected
                                                @endif
                                            >{{$months[sprintf('%02d',$j)]}}</option>
                                        @endfor
                                    </select>                                    
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label">AÑO</label>
                                    <select class="js-example-basic-single form-control {{ $errors->has('year') ? ' is-invalid' : '' }}" id="year" name="year" required>
                                        <option value="" selected disabled>Selecciona el dia de nacimiento</option>
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
                    </div><div class="col-md-6 mt-3">
                        <div class="text-left">
                            <label class="form-label">GÉNERO</label>
                            <select class="form-control {{ $errors->has('gender') ? ' is-invalid' : '' }}" id="gender" name="gender" required>
                                <option value="" disabled>Selecciona una</option>
                                <option value="Femenino"
                                    @if ($doctor->gender == "Femenino")
                                        selected
                                    @endif
                                >Femenino</option>
                                <option vlaue="Masculino"
                                    @if ($doctor->gender == "Masculino")
                                        selected
                                    @endif
                                >Masculino</option>
                                <option value="No binario"
                                    @if ($doctor->gender == "No binario")
                                        selected
                                    @endif
                                >No binario</option>                                       
                            </select>
                            @if ($errors->has('gender'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div><div class="col-md-6 mt-3">
                        <div class="text-left">
                            <label class="form-label">NÚMERO DE CONTACTO</label>
                            <input type="text"  id="phone" name="phone" class="form-control mob_noPersonal {{ $errors->has('phone') ? ' is-invalid' : '' }}" data-mask="999-999-9999" value="{{ old('phone',$doctor->phone) }}" placeholder="999-999-9999" required>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group row mt-2">
                    <button id="save" type="submit" class="btn btn-rounded btn-new" style="margin-left: auto;margin-right: auto; max-width: 200px;">Guardar</button>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-header">
                <h5>Cambiar contraseña</h5>
            </div>
            <div class="card-block">
                <form method="POST" action="{{ route('changePasswordDr', $user->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Contraseña</label>
                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Contraseña" id="password" name="password" required autocomplete="new-password">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" placeholder="Confirmar contraseña" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group row mt-2">
                        <button type="submit" class="btn btn-rounded btn-new" style="margin-left: auto;margin-right: auto; max-width: 200px;">Cambiar contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection
@section('css')
    <!-- Input mask Js -->
    <script src="{{ asset('/assets/plugins/inputmask/js/inputmask.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/inputmask/js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/inputmask/js/autoNumeric.js') }}"></script>

    <!-- select2 Js -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>   
    <!-- multi-select Js -->
    <script src="{{ asset('/assets/plugins/multi-select/js/jquery.quicksearch.js') }}"></script>   
    <script src="{{ asset('/assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script>   

    <!-- form-select-custom Js -->
    <script src="{{ asset('/assets/js/pages/form-select-custom.js') }}"></script>   

    <!-- material datetimepicker Js -->
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="{{ asset('/assets/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <!-- form-picker-custom Js -->
    <script src="{{ asset('/assets/js/pages/form-picker-custom.js') }}"></script>
    <script src="{{ asset('/assets/js/pages/form-masking-custom.js') }}"></script>
    
    <script type="text/javascript">
        $(".mob_noPersonal").inputmask({
            mask: "999-999-9999"
        });
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('#customFileLang').on("change",function() {
            var i = $(this).next('label').clone();
            var file = $('#customFileLang')[0].files[0].name;
            $(this).next('label').text(file);
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
            {
                var reader = new FileReader();

                reader.onload = function (e) {
                $('.img-radius').attr('src', e.target.result);
                }
            reader.readAsDataURL(input.files[0]);
            }

        });
        $('#date').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            lang : 'es',
        });
    </script>
@endsection

