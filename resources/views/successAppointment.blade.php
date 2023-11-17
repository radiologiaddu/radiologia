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
                        <div class="mb-4">
                            <i class="feather icon-calendar auth-icon"></i>
                        </div>
                        <h3 class="mb-4">Tu cita</h3>
                        <div style="height: 53vh;overflow: overlay;">                                
                            <div class="input-group mb-3">
                                <div class="form-group col-12 p-0 mb-0 text-left">
                                    <label class="form-label font-weight-bold">FECHA DE CITA</label>
                                    <p>
                                        <label>
                                            {{$weekMap[strftime("%w",strtotime($newAppointment->date))]}}
                                            {{strftime("%d",strtotime($newAppointment->date))}}
                                            {{strtoupper($months[strftime("%m",strtotime($newAppointment->date))])}}
                                            {{strftime("%Y",strtotime($newAppointment->date))}}
                                        </label>
                                    </p>
                                    
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="form-group col-12 p-0 mb-0 text-left">
                                    <label class="form-label font-weight-bold">HORARIO</label>
                                    <p>
                                        <label>
                                            {{$newAppointment->time}}
                                        </label>
                                    </p>
                                </div>
                            </div>  
                            @if (!is_null($study->rfc))
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label font-weight-bold">Solicitud de factura</label>
                                        <p>
                                            <label>
                                                <label class="form-label font-weight-bold">RFC: </label>
                                                {{$study->rfc}}
                                                <br>
                                                <label class="form-label font-weight-bold">Razón Social: </label>
                                                {{$study->company_name}}
                                                <br>
                                                <label class="form-label font-weight-bold">Regimen fiscal: </label>
                                                {{$study->tax}}
                                                <br>
                                                <label class="form-label font-weight-bold">Uso de CFDI: </label>
                                                {{$study->CFDI}} - {{$study->cfdi->cfdi}}
                                                <label class="form-label font-weight-bold">Código postal: </label>
                                                {{$study->cp}}
                                            </label>
                                        </p>
                                    </div>
                                </div> 
                                
                            @endif
                            <a href="https://goo.gl/maps/nTTyunyR53QozLPP6" target="_blank">
                                <button class="btn btn-success shadow-2 mb-1 mt-2">¿CÓMO LLEGAR?</button>
                            </a>
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

        @if ($success)  
            <script type="text/javascript">
                $(document).ready(function() {
                    swal("Cita agendada","Tu cita ha sido agendada", "success")
                    .then((value) => {
                        swal({
                            title: "Factura",
                            text: "¿Vas a requerir factura?",
                            icon: "info",
                            buttons: true,
                            buttons: ["NO", "SI"],
                        }).then((willDelete) => {
                            if (willDelete) {
                                var id = "{{$id}}";
                                window.location = "{{ route('invoice', $id) }}"
                            } 
                        });
                    });
                });
            </script>
        @endif
    </body>
</html>