<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DDU | Cita</title>
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
        <div class="auth-wrapper">
            <div class="auth-content">
                <div class="auth-bg">
                    <span class="r"></span>
                    <span class="r s"></span>
                    <span class="r s"></span>
                    <span class="r"></span>
                </div>
                <div class="card">

                </div>
                <div class="col-sm-12">
                    <div class="card" style="border-radius: 25px">
                    <div class="card-header text-center">
    <div class="row">
        <h3 class="col-12">
            Su nombre es:
        </h3>
            <h4 class="col-12 ">
                <b>
                {{$study->patient_name}} {{$study->paternal_surname}} {{$study->maternal_surname}}
                </b>
            </h4>
        <div class="text-center">
            <h4 class="col-12">
                <!-- Mostrar correo del paciente si existe -->
                @if($study->patient_email)
                    Correo del paciente: {{$study->patient_email}}
                @endif
            </h4>
        </div>
        <div class="text-center">
            <h4 class="col-12">
                <!-- Mostrar edad y fecha de nacimiento del paciente -->
                Fecha de nacimiento: {{ \Carbon\Carbon::parse($study->birthday)->format('d/m/Y') }}
                <br>
                Edad: {{ $study->edad() }} años
                <br>
                Telefono: {{$study->patient_phone}}
            </h4>
        </div>
    </div>
</div>

@if ($study->doctor_id == 0)
    <div class="card-header text-center">
        <div class="row">
            <h3 class="col-12">
                Viene de parte de
            </h3>
            <div class="text-center">
                <h4 class="col-12">
                    {{$study->doctor_name}}
                </h4>
    <h4 class="col-12">
            Correo del doctor: {{$study->doctor->user->email}}
    </h4>


            </div>
        </div>
    </div> 
@else
    <div class="card-header text-center">
        <div class="row">
            <h3 class="col-12">
                Viene de parte de
            </h3>
            <div class="text-center">
                <h4 class="col-12">
                    {{$study->doctor->alias}}
                </h4>
                <!-- Mostrar correo del doctor si existe -->
                    <h4 class="col-12">
                    Correo del doctor: {{$study->doctor->user->email}}
                    </h4>
            </div>
        </div>
    </div>
@endif

                        
                        <div class="card-body text-center">
                            <div class="mb-4">
                                <i class="feather icon-calendar auth-icon"></i>
                            </div>
                            <h3 class="mb-4">Tiene cita para</h3>
                            <div class="text-center">
                                <h4 class="col-12">
                                    <h4 class="mb-3">
                                        @if (isset($study->appointment))
                                            {{$weekMap[strftime("%w",strtotime($study->appointment->date))]}}
                                            {{strftime("%d",strtotime($study->appointment->date))}}
                                            de {{strtoupper($months[strftime("%m",strtotime($study->appointment->date))])}}
                                            del {{strftime("%Y",strtotime($study->appointment->date))}}
                                             <br>
                                            a las {{$study->appointment->time}} hrs.
                                        @else
                                            No agendó cita, pero no se preocupe.
                                        @endif
                                    </h4>
                                </h4>
                            </div>
                        </div>

                        <div class="card-block text-center">
                            <div class="row">
                                <h3 class="col-12">
                                    Los estudios que se va a realizar: 
                                </h3>
                                <div class="text-left">
                                    @foreach ($arrayStudies as $itemStudy)
                                        <h4 class="mt-3 mb-3">
                                            <li>{{$itemStudy->title}}</li>
                                        </h4>
                                    @endforeach
                                </div>
                                <div class="mt-3 col-12">
                                    @if ($study->status == "Creado" || $study->status == "Agendado")
                                            <button id="changeStatus" class="btn btn-success shadow-2 mb-1 mt-2">
                                                Check-In                                                 
                                            </button>
                                    @endif
                                </div>
                            </div>
                        </div>
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

        <script type="text/javascript">
            $(document).ready(function() { 
                document.getElementById("changeStatus").addEventListener("click", function(event){
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/changeStatus') }}",
                        data: {"id": '{{$study->qr}}' ,_token : '{{ csrf_token() }}'},
                        success: function (flag) {
                            if(flag){
                                swal("Exito","Check In exitoso", "success")
                                .then((value) => {
                                    window.location = "{{ route('hostess') }}"
                                });
                            }else{
                                swal("Error","A ocurrido un error al realizar el Check In", "error")
                                .then((value) => {
                                    window.location.reload();
                                });
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>