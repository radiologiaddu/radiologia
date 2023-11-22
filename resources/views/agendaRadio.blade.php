@extends('layouts.layoutHost')
@section('title','Bienvenido')
@section('leve','Agenda')
@section('breadcrumb')

@endsection
@section('content')
<style>
    #zero-configurationo_length{
        margin-left: 50px;
    }
</style>
<link rel="stylesheet" href="{{ asset('/css/allStudy.css') }}">
    <!-- data tables css -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/data-tables/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/plugins/data-tables/css/datatables.min.css') }}">
    <!-- material datetimepicker css -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<!-- Wysiwyg editor -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/fullcalendar/css/fullcalendar.min.css') }}">

<style>
    #div1, #div2 {
      float: left;
      width: 100px;
      height: 35px;
      margin: 10px;
      padding: 10px;
      border: 1px solid black;
    }
</style>
<style>
    .display {
      display: flex;
    }
    .dropzone {
      display: block;
      width: 25%;
      height: 200px;
      margin: 25px;
      margin-left: 0;
      padding: 10px;
      background-color: navy;
      overflow: auto;
      color: aqua;
      font-size: large;
    }
    .container {
      display: block;
      width: 25%;
    }
    .content {
      width: 80%;
      height: 25%;
      margin: 1em;
    }
    [color~="Tomato"] {
        background: Tomato !important;
    }
    [color~="Aqua"] {
        background: Aqua !important;
    }
    .BlueViolet {
        background: BlueViolet !important;
    }
    .Green {
        background: Green !important;
    }
    [color~="Brown"] {
        background: Brown !important;
    }
    [color~="DarkCyan"] {
        background: DarkCyan !important;
    }
    [color~="Cyan"] {
        background: Cyan !important;
    }
    [color~="DarkOrange"] {
        background: DarkOrange !important;
    }
    [color~="ForestGreen"] {
        background: ForestGreen !important;
    }
    [color~="Gold"] {
        background: Gold !important;
    }
    [color~="Green"] {
        background: Green !important;
    }
    [color~="HotPink"] {
        background: HotPink !important;
    }
    .finish:disabled {
        background: #868686 !important;
        border-color:#868686 !important;
    }
</style>
<style>
    h3{
        margin: 30px 0 0 0;
    }
    p{
        margin: 0
    }
    pre{
        margin: 0;
        color : #555;
    }
    .rect {
        height: 100px;
        width : 100%;
        background : #ccc;
        top: 10px;
        left: 10px;
        margin-bottom: 20px;
        z-index: 1000;
        overflow-y: scroll;
    }
    /* width */
    .rect::-webkit-scrollbar {
    width: 10px;
    }

    /* Track */
    .rect::-webkit-scrollbar-track {
    background: #f1f1f1; 
    }
    
    /* Handle */
    .rect::-webkit-scrollbar-thumb {
    background: #65c6c9; 
    border-radius: 10px;
    }

    /* Handle on hover */
    .rect::-webkit-scrollbar-thumb:hover {
    background: #499093; 
    }

    .container{
        margin-bottom: 20px;
        width : 160px;
        min-height: 100px;
        padding : 10px;
        position: relative;
        display: inline-block;
        vertical-align: top;
        border : 4px solid #bbb;
    }
    .fc-right{
        display: none;
    }
</style>
    @php
        setlocale(LC_TIME, "spanish");
        $weekMap = [
            0 => 'Dom',
            1 => 'Lun',
            2 => 'Mar',
            3 => 'Mie',
            4 => 'Jue',
            5 => 'Vie',
            6 => 'Sáb',
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
    <script type="text/javascript">
        var radioStudy = {};
        var radiologists = [];
        var eventExisting = [];
        var todayJS = '{{$today}}';
        var idLast = '{{$idLast}}'; 
        idLast++; 
                // Convert a time in hh:mm format to minutes
                function timeToMins(time) {
            var b = time.split(':');
            return b[0]*60 + +b[1];
        }

        // Convert minutes to a time in format hh:mm
        // Returned value is in range 00  to 24 hrs
        function timeFromMins(mins) {
            function z(n){return (n<10? '0':'') + n;}
            var h = (mins/60 |0) % 24;
            var m = mins % 60;
            return z(h) + ':' + z(m);
        }

        // Add two times in hh:mm format
        function addTimes(t0, t1) {
            return timeFromMins(timeToMins(t0) + timeToMins(t1));
        }

        // Add two times in hh:mm format
        function minTimes(t0, t1) {
            return timeFromMins(timeToMins(t0) - timeToMins(t1));
        }

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;

            return [year, month, day].join('-');
        }
    </script>

    <audio id="myAudio">
        <source src="https://app.ddu.mx/assets/sound/Bell.mp3" type="audio/mpeg">
    </audio>
    @foreach ($radiologists as $radiologist)

        <script type="text/javascript">
            var x = document.getElementById("myAudio"); 
            x.muted = true;

            function playAudio() { 
            x.play();
            } 
            radiologists.push(
                {
                    "id": "{{$radiologist->id}}",
                    "name": "{{$radiologist->name}}",
                    "color": "{{$radiologist->color}}"
                }
            );
        </script>
    @endforeach
    <div class="col-sm-12">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-12 ">
                        <div class="card fullcalendar-card">
                            <div class="card-header">
                                <h5>Agenda</h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="modal-sound" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-soundTitle" aria-hidden="true" onclick="playAudio()">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="md-content card">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modal-soundTitle">Notificaciones</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">   
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <p>
                                                                    Se activará el sonido en las notificaciones para cuando se reciba un nuevo evento o se haga una modificación en la agenda
                                                                </p>

                                                                <button onclick="playAudio()" class="btn btn-primary md-close">Entendido</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="modalOutTime" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalOutTimeTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalOutTimeTitle">Tiempo fuera</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">   
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Tipo de tiempo fuera</label>
                                                                <select id="inputType" class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}"name="inputType" required>
                                                                    <option id="default" value="" selected disabled>Selecciona un tipo de tiempo fuera</option>
                                                                    <option value="Comida">Comida</option>
                                                                    <option value="Junta">Junta</option>
                                                                    <option value="Otra">Otra</option>
                                                                </select>
                                                                <label class="mt-2">Duración</label>
                                                                <input id="durationOver" name="durationOver" type="text" class="form-control hours" value="00:15" data-mask="12:00" placeholder="Duración" pattern="[0-9]{2}:[0-9]{2}">
                                                                <div class="mt-2 text-center">
                                                                    <button id="addEvent" type="button" class="btn btn-rounded btn-success">
                                                                        <span>Agregar</span>
                                                                    </button>
                                                                </div>
                                                            </div>        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-0">
                                        <div id='external-events' class="external-events">
                                            @foreach ($studies as $study)
                                                @if ($study->internal == 1)
                                                    @php
                                                        $letter = "R";
                                                    @endphp
                                                @else
                                                    @php
                                                        $letter = "D";
                                                    @endphp
                                                @endif
                                                <div id="modal{{$letter}}{{sprintf('%06d',$study->folio)}}" class="modal fade {{$study->status}}" tabindex="-1" role="dialog" aria-labelledby="modal{{$study->id}}Title" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modal{{$study->id}}Title">Datos del estudio:</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card card-border-c-blue">
                                                                    <div class="card-header d-block">
                                                                        <a href="#!" class="text-secondary">
                                                                        {{$letter}}{{sprintf('%06d',$study->folio)}} - {{$study->patient_name}} {{$study->paternal_surname}} {{$study->maternal_surname}} </a>
                                                                        <br>
                                                                        <strong>Cita:</strong>
                                                                        @if (isset($study->appointment))
                                                                            {{$weekMap[strftime("%w",strtotime($study->appointment->date))]}}
                                                                            {{strftime("%d",strtotime($study->appointment->date))}}
                                                                            {{strtoupper($months[strftime("%m",strtotime($study->appointment->date))])}}
                                                                            {{strftime("%Y",strtotime($study->appointment->date))}}
                                                                            -
                                                                            {{$study->appointment->time}} hrs.
                                                                            @php
                                                                                $cita = $weekMap[strftime("%w",strtotime($study->appointment->date))].' '.strftime("%d",strtotime($study->appointment->date)).' '.strtoupper($months[strftime("%m",strtotime($study->appointment->date))]).' '.strftime("%Y",strtotime($study->appointment->date)).'\n'.$study->appointment->time;
                                                                            @endphp
                                                                        @else
                                                                            Sin agendar cita
                                                                            @php
                                                                                $cita = "Sin agendar cita";
                                                                            @endphp
                                                                        @endif
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                {{$study->patient_email}}
                                                                                <br>
                                                                                {{$study->patient_phone}}
                                                                            </div>
                                                                            
                                                                            @if (isset($study->birthday)) 
                                                                                <div class="col-md-6">
                                                                                    {{strftime("%d",strtotime($study->birthday))}}
                                                                                    {{strtoupper($months[strftime("%m",strtotime($study->birthday))])}}
                                                                                    {{strftime("%Y",strtotime($study->birthday))}}
                                                                                    <br>
                                                                                    Edad: {{$study->edad()  + 0}} Años
                                                                                </div>                                                        
                                                                            @endif
                                                                        </div>
                                                                        @if (!is_null($study->radiologist) && $study->radiologist != "")
                                                                            <div class="mt-1">
                                                                                <p class="task-due"><strong> Radiólogo: </strong><strong class="label label-primary">{{$study->radiologist}}</strong></p>
                                                                            </div>
                                                                        @endif
                                                                        <div class="row">
                                                                            <div class="mt-1 text-center col-12">
                                                                                Doctor
                                                                            </div>
                                                                            <div class="text-justify">
                                                                                @if ($study->doctor_id == 0)
                                                                                    <div class="col-12">
                                                                                        {{$study->doctor_name}}
                                                                                    </div>
                                                                                @else
                                                                                    <div class="col-12">
                                                                                        {{$study->doctor->alias}}
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        {{$study->doctor->user->name}} {{$study->doctor->paternalSurname}} {{$study->doctor->maternalSurname}}
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-block card-task pt-0">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                @foreach ($study->arrayStudies as $itemStudy)
                                                                                    <div class="mt-3 mb-3">
                                                                                        {{$itemStudy->title}}
                                                                                        @foreach ($itemStudy->questions as $question)
                                                                                            <div class="mb-3">
                                                                                                {{$question->question}}
                                                                                            </div>
                                                                                            @foreach ($question->answers as $answer)
                                                                                                <div class="mb-3" style="color:rgb(110,123,222);font-weight: 900;">
                                                                                                    <li>
                                                                                                        {{$answer}}
                                                                                                    </li>
                                                                                                </div>
                                                                                            @endforeach
                                                                                            @if (!is_null($question->class_note))
                                                                                                @if ($question->class_note == "simpleNote")
                                                                                                    <div class="form-group mt-3">
                                                                                                    <label class="form-check-label" for="simpleNote" style="font-size: 14px;">
                                                                                                        {!! nl2br($question->note) !!}                          
                                                                                                    </label>
                                                                                                    </div>
                                                                                                @else
                                                                                                    <div class="form-group mt-3">
                                                                                                    <label class="form-check-label" for="highlightedNote" style="font-size: 14px;">
                                                                                                        <div style="background: rgb(110,123,222);
                                                                                                        border-radius: 50%;
                                                                                                        height: 30px;
                                                                                                        width: 30px;
                                                                                                        text-align: center;
                                                                                                        align-items: center;
                                                                                                        display: flex;
                                                                                                        float: left;">
                                                                                                            <img src="https://app.ddu.mx/image/blanco100.png" style="width: 20px;
                                                                                                            height: 20px;
                                                                                                            margin-left: auto;
                                                                                                            margin-right: auto;" alt="User-Profile-Image">
                                                                                                        </div>
                                                                                                        <span style="background: rgb(110,123,222);
                                                                                                        color: white;
                                                                                                        font-size: 16px;
                                                                                                        margin-left: 5px;
                                                                                                        padding: 5px;
                                                                                                        align-items: center;
                                                                                                        display: flex;">
                                                                                                        {!! nl2br($question->note) !!}                          
                                                                                                        </span>
                                                                                                        <div class="clearfix"></div>
                                                                                                    </label>
                                                                                                    </div>
                                                                                                @endif
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </div>
                                                                                    @if (!is_null($itemStudy->class_note))
                                                                                        @if ($itemStudy->class_note == "simpleNote")
                                                                                            <div class="form-group mt-3">
                                                                                            <label class="form-check-label" for="simpleNote" style="font-size: 14px;">
                                                                                                {!! nl2br($itemStudy->note) !!}                          
                                                                                            </label>
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="form-group mt-3">
                                                                                            <label class="form-check-label" for="highlightedNote" style="font-size: 14px;">
                                                                                                <div style="background: rgb(110,123,222);
                                                                                                border-radius: 50%;
                                                                                                height: 30px;
                                                                                                width: 30px;
                                                                                                text-align: center;
                                                                                                align-items: center;
                                                                                                display: flex;
                                                                                                float: left;">
                                                                                                    <img src="https://app.ddu.mx/image/blanco100.png" style="width: 20px;
                                                                                                    height: 20px;
                                                                                                    margin-left: auto;
                                                                                                    margin-right: auto;" alt="User-Profile-Image">
                                                                                                </div>
                                                                                                <span style="background: rgb(110,123,222);
                                                                                                color: white;
                                                                                                font-size: 16px;
                                                                                                margin-left: 5px;
                                                                                                padding: 5px;
                                                                                                align-items: center;
                                                                                                display: flex;">
                                                                                                {!! nl2br($itemStudy->note) !!}                          
                                                                                                </span>
                                                                                                <div class="clearfix"></div>
                        
                                                                                            </label>
                                                                                            </div>
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <strong>Observaciones adicionales:</strong> 
                                                                            <div class="col-12">
                                                                                {!! nl2br($study->observations) !!}
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="task-list-table">
                                                                            @if ($study->status != 'Realizado') 
                                                                                <button class="btn btn-primary btn-sm finish" type="button" qr="{{$study->qr}}" id="button{{$letter}}{{sprintf('%06d',$study->folio)}}" 
                                                                                    @if ($study->status != 'Empezado') 
                                                                                        disabled
                                                                                    @endif
                                                                                    >TERMINAR ESTUDIO</button>
                                                                                @php
                                                                                    $colorClass = '';
                                                                                @endphp
                                                                            @else
                                                                                    @php
                                                                                        $colorClass = 'Green';
                                                                                    @endphp
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script type="text/javascript">
                                                    var  index = radiologists.findIndex(object => {
                                                        return object.id === '{{$study->radiologist_id}}';
                                                    });
                                                    var diferencia = '{{$dayWeek}}'-index;
                                                    var today = new Date();
                                                    var thisDate = formatDate(today.setDate(today.getDate()-diferencia));
                                                    eventExisting.push(
                                                                {
                                                                    title: "{{$letter}}{{sprintf('%06d',$study->folio)}}\n{{$study->patient_name}} {{$study->paternal_surname}} {{$study->maternal_surname}}\n{{$cita}}",
                                                                    start: thisDate+'T{{$study->time}}',
                                                                    end: thisDate+'T'+addTimes('{{$study->time}}','{{$study->duration}}'),
                                                                    className: '{{$colorClass}}',
                                                                    id: "{{$letter}}{{sprintf('%06d',$study->folio)}}"
                                                                }
                                                            );
                                                </script>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-12">
                                        <div id="divCalendar">                                        
                                            <div id='calendar' class='calendar'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

    <!-- Full calendar js -->
    <script src="{{ asset('/assets/plugins/fullcalendar/js/lib/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/fullcalendar/js/lib/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/fullcalendar/js/fullcalendar.min.js') }}"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/locale/es.js'></script>

    <!-- Input mask Js -->
    <script src="{{ asset('/assets/plugins/inputmask/js/inputmask.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/inputmask/js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/inputmask/js/autoNumeric.js') }}"></script>
    <!-- material datetimepicker Js -->
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="{{ asset('/assets/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

    <!-- form-picker-custom Js -->
    <script src="{{ asset('/assets/js/pages/form-picker-custom.js') }}"></script>
    <script type="text/javascript">
        var x = document.getElementById("myAudio"); 

        function PlaySound(soundObj) {
            x.play(); 
        }

        $(".hours").inputmask({
            mask: "99:99"
        });
        function padWithLeadingZeros(num, totalLength) {
            return String(num).padStart(totalLength, '0');
        }
        $("body").on("click",".finish", function () {
                var id = $(this).attr("qr");
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/finishRadio') }}",
                        data: {"id": id ,_token : '{{ csrf_token() }}'},
                        success: function (flag) {
                            if(flag){
                                swal("Exito","Estudio finalizo correctamente", "success")
                                .then((value) => {
                                    $(".modal").modal('hide');
                                });
                            }else{
                                swal("Error","A ocurrido un error al finalizar el estudio", "error")
                                .then((value) => {

                                });
                            }
                        }
                    });
            
            });

        @foreach ($freesTime as $freeTime)
            var  index = radiologists.findIndex(object => {
                return object.id === '{{$freeTime->radiologist_id}}';
            });
            var diferencia = '{{$dayWeek}}'-index;
            var today = new Date();
            var thisDate = formatDate(today.setDate(today.getDate()-diferencia));
            eventExisting.push(
                {
                    title: "{{$freeTime->type}}",
                    start: thisDate+'T{{$freeTime->time}}',
                    end: thisDate+'T'+addTimes('{{$freeTime->time}}','{{$freeTime->duration}}'),
                    className: 'BlueViolet',
                    id: '{{$freeTime->id}}'
                }
            );
        @endforeach
        
        // Full calendar
        $(window).on('load', function() {
            toggleFullScreen();
            $('#modal-sound').modal('show');
            console.log("myArrayradiologists ",radiologists);
            $('#external-events .fc-event').each(function() {
                thisDuration = $(this).attr('duration');
                if(thisDuration == ""){
                    thisDuration = '00:15'
                }
                $(this).data('event', {
                    title: $.trim($(this).text()),
                    duration: thisDuration,
                    stick: false
                }); 
                
                $(this).draggable({
                    zIndex: 999,
                    revert: true,
                    revertDuration: 0
                });
                
            }); 
            $( ".fc-event" ).click(function() {
                id = $(this).attr('id');
                $('#modal'+id).modal('show');

            });

            calendar = $('#calendar').fullCalendar({
                slotDuration: '00:05:00',
                slotLabelInterval: "00:05",
                minTime: '08:00:00', /* calendar start Timing */
                maxTime: '19:00:00',  /* calendar end Timing */
                defaultView: 'agendaWeek',
                defaultDate: todayJS,
                editable: false,
                droppable: false,
                allDaySlot: false,
                firstDay:0,
                locale: 'es',
                defaultTimedEventDuration: '00:05',
                timeFormat: 'h:mm',
                events: eventExisting,
                eventClick: function(calEvent, jsEvent, view) {
                    id = $(this).attr('id');
                    $('#modal'+id).modal('show');
                    /* 
                    console.log('View', view);

                    alert($(this).attr('id'));
                    $(this).addClass("red");

                    alert('Event: ' + calEvent.title);
                    alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                    alert('View: ' + view.name);
                    radioStudy[id] = 1;

                    console.log("myArray ",radioStudy);
                    */
                },
            });
            $('.fc-left').html("<h4>{{$weekMap[strftime('%w',strtotime($today))]}} {{strftime('%d',strtotime($today))}} {{strtoupper($months[strftime('%m',strtotime($today))])}}</h4>")
            dayHeader = $('.fc-day-header');
            dayHeader.each(function(i,element) {
                if(radiologists[i] != undefined){
                    console.log(radiologists[i])
                    dayHeader[i].innerHTML = radiologists[i]['name'];
                }else{
                    dayHeader[i].innerHTML = '';
                }
                console.log(element)
            });
        });
    </script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
          <script>

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;
        
            var pusher = new Pusher('40f1cc1099b2ed243080', {
              cluster: 'us2'
            });
        
            var channel = pusher.subscribe('my-channel');
            channel.bind('App\\Events\\finishEvent', function(data) {
                console.log("finish"+data)
                var id = data.message;
                var modalid = id.replace('button','')

                console.log("id"+id)
                $("#"+id).remove();
                $('#modal'+modalid).modal('hide');
                $( "#"+modalid ).addClass( "Green" );
            });
    
            channel.bind('App\\Events\\myEvent', function(data) {
                console.log("AQUUUI");
                x.muted = false;
                x.play();
                var fecha = todayJS
                $.ajax({
                    type: "POST",
                    url: "{{ url('/newDateRadio') }}",
                    data: {_token : '{{ csrf_token() }}',"fecha": fecha },
                    success: function (array) {
                        $( ".Empezado" ).remove();
                        $( ".Realizado" ).remove();
                        $( ".Enviado" ).remove();
                        eventExisting=[];
                        console.log("object ",array);
                        for (const [key, value] of Object.entries(array['freesTime'])) {
                            console.log(`${key}: ${value['id']}`);
                            var  index = radiologists.findIndex(objecto => {
                                console.log("radiologist_id:", value['radiologist_id']);

                                return objecto.id === value['radiologist_id'].toString();
                            });
                            console.log("RADIO:", index);

                            //alert(array['dayWeek']);
                            //alert(index);
                            var diferencia = array['dayWeek']-index;
                            var today = new Date('"'+fecha+'"');

                            //alert(today);
                            var thisDate = formatDate(today.setDate(today.getDate()-diferencia));
                            //alert(thisDate);

                            eventExisting.push(
                                {
                                    title: value['type'],
                                    start: thisDate+'T'+value['time'],
                                    end: thisDate+'T'+addTimes(value['time'],value['duration']),
                                    className: 'BlueViolet',
                                    id: value['id']
                                }
                            );

                        }
                        
                        for (const [key, value] of Object.entries(array['studies'])) {
                            if(value['radiologist_id'] == 1){
                                var letter = "R"
                            }else{
                                var letter = "D"
                            }
                            if(value['appointment'] != null){
                                var cita = 'Cita:'+value['appointment'].date+'<br>'+value['appointment'].time;
                            }else{
                                var cita = 'Sin agendar cita';
                            }

                            var  index = radiologists.findIndex(objecto => {
                                return objecto.id === value['radiologist_id'].toString();
                            });
                            var diferencia = array['dayWeek']-index;
                            var today = new Date('"'+fecha+'"');
                            var thisDate = formatDate(today.setDate(today.getDate()-diferencia));

                            var Main = $('<div id="modal'+letter+padWithLeadingZeros(value['folio'], 6)+'" class="modal fade '+value['status']+'" tabindex="-1" role="dialog" aria-labelledby="modal'+value['id']+'Title" aria-hidden="true"></div>');
                            var Second = $('<div class="modal-dialog modal-dialog-centered" role="document"></div>');
                            var Third = $('<div class="modal-content"></div>');
                            var FourthH = $('<div class="modal-header"></div>');
                            $(FourthH).append('<h5 class="modal-title" id="modal'+value['id']+'Title">Datos del estudio:</h5>');
                            $(FourthH).append('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
                            var FourthB = $('<div class="modal-body"></div>');
                            var Fifth = $('<div class="card card-border-c-blue"></div>');
                            var SixthH = $('<div class="card-header d-block"></div>');
                            $(SixthH).append('<a href="#!" class="text-secondary">'+letter+padWithLeadingZeros(value['folio'], 6)+' - '+value['patient_name']+' '+value['paternal_surname']+' '+value['maternal_surname']+' </a>');
                            $(SixthH).append(cita);
                            var SeventhH1 = $('<div class="row"></div>');
                            $(SeventhH1).append('<div class="col-md-6">'+value['patient_email']+'<br>'+value['patient_phone']+'</div>');
                            if (value['birthday'] != null) {
                                $(SeventhH1).append('<div class="col-md-6">'+value['birthday']+'<br>Edad: '+value['old']+' Años</div>');
                            }
                            if (value['radiologist'] != null && value['radiologist'] != "" ) {
                                $(SeventhH1).append('<div class="mt-1"><p class="task-due"><strong> Radiólogo: </strong><strong class="label label-primary">'+value['radiologist']+'</strong></p></div>');
                            }
                            var SeventhH2 = $('<div class="row"></div>');
                            $(SeventhH2).append('<div class="mt-1 text-center col-12">Doctor</div>');
                            var EighthH2 = $('<div class="text-justify"></div>');
                            if (value['doctor_id'] == 0) {
                                $(EighthH2).append('<div class="col-12">'+value['doctor_name']+'</div>');
                            }else{
                                $(EighthH2).append('<div class="col-12">'+value['doctor'].alias+'</div>');
                                $(EighthH2).append('<div class="col-12">'+value['doctor'].user.name+' '+value['doctor'].paternalSurname+' '+value['doctor'].maternalSurname+'</div>');
                            }
                            $(SeventhH2).append(EighthH2);
                            $(SixthH).append(SeventhH1);
                            $(SixthH).append(SeventhH2);
                            $(Fifth).append(SixthH);

                            var SixthB = $('<div class="card-block card-task pt-0"></div>');
                            var SeventhB1 = $('<div class="row"><div>');
                            var EighthB1 = $('<div class="col-sm-12"></div>');

                            Object.entries(value['arrayStudies']).forEach(itemStudy => {
                                const [key, value] = itemStudy;
                                console.log(key, value);
                                console.log("tipeof: "+typeof value["title"])
                                console.log("value: "+ value["title"])
                                var NinthB1 = $('<div class="mt-3 mb-3">'+value["title"]+'</div>');

                                Object.entries(value["questions"]).forEach(itemQuestion => {
                                const [key, question] = itemQuestion;
                                console.log(key, question);

                                    var TenthB1 = $('<div class="mb-3">'+question.question+'</div>');
                                    
                                    Object.entries(question.answers).forEach(itemAnswer => {
                                        const [key, answer] = itemAnswer;
                                        console.log(answer);
                                        $(TenthB1).append('<div class="mb-3" style="color:rgb(110,123,222);font-weight: 900;"><li>'+answer+'</li></div>');
                                    });
                                    console.log("class:"+question.class_note);
                                
                                    if (question.class_note != null) {
                                        if (question.class_note !== 'simpleNote') {
                                            $(TenthB1).append('<div class="form-group mt-3"><label class="form-check-label" for="simpleNote" style="font-size: 14px;">'+question.note+'</label></div>');                                                     
                                        }else{
                                            $(TenthB1).append('<div class="form-group mt-3">\
                                                                        <label class="form-check-label" for="highlightedNote" style="font-size: 14px;">\
                                                                            <div style="background: rgb(110,123,222);\
                                                                            border-radius: 50%;\
                                                                            height: 30px;\
                                                                            width: 30px;\
                                                                            text-align: center;\
                                                                            align-items: center;\
                                                                            display: flex;\
                                                                            float: left;">\
                                                                                <img src="https://app.ddu.mx/image/blanco100.png" style="width: 20px;\
                                                                                height: 20px;\
                                                                                margin-left: auto;\
                                                                                margin-right: auto;" alt="User-Profile-Image">\
                                                                            </div>\
                                                                            <span style="background: rgb(110,123,222);\
                                                                            color: white;\
                                                                            font-size: 16px;\
                                                                            margin-left: 5px;\
                                                                            padding: 5px;\
                                                                            align-items: center;\
                                                                            display: flex;">\
                                                                            '+question.note+'</span>\
                                                                            <div class="clearfix"></div>\
                                                                        </label>\
                                                                    </div>');                                                     
                                        }
                                    }        
                                    
                                    $(NinthB1).append(TenthB1);
                                });

                                $(EighthB1).append(NinthB1);
                            });

                            $(SeventhB1).append(EighthB1);
                            if (value['observations'] != null) {
                                var observations = value['observations'];
                            }else{
                                var observations = "";
                            }
                            var SeventhB2 = $('<div class="row"><strong>Observaciones adicionales:</strong><div class="col-12">'+observations+'</div></div><hr>');
                            var SeventhB3 = $('<div class="task-list-table"></div>');
                            $(SixthB).append(SeventhB1);
                            $(SixthB).append(SeventhB2);
                            $(SixthB).append(SeventhB3);
                            if(value['status'] != 'Realizado'){
                                $(SixthB).append('<button class="btn btn-primary btn-sm finish" type="button" qr="'+value['qr']+'" id="button'+letter+padWithLeadingZeros(value['folio'], 6)+'">TERMINAR ESTUDIO</button>');
                                var colorClass = '';
                            }else{
                                var colorClass = 'Green';
                            }
                            $(Fifth).append(SixthB);

                            $(FourthB).append(Fifth);
                            $(Third).append(FourthH);
                            $(Third).append(FourthB);
                            $(Second).append(Third);
                            $(Main).append(Second);
                            $("#external-events").prepend(Main);

                            eventExisting.push(
                                        {
                                            title: letter+padWithLeadingZeros(value['folio'], 6)+'\n'+value['patient_name']+' '+value['paternal_surname']+' '+value['maternal_surname']+' ',
                                            start: thisDate+'T'+value['time'],
                                            end: thisDate+'T'+addTimes(value['time'],value['duration']),
                                            className: colorClass,
                                            id:  letter+padWithLeadingZeros(value['folio'], 6)
                                        }
                                    );
                        } 
                        
                        $('#divCalendar').html("<div id='calendar' class='calendar'></div>");
                        console.log("eventExisting ",eventExisting);

                        calendar = $('#calendar').fullCalendar({
                            slotDuration: '00:05:00',
                            slotLabelInterval: "00:05",
                            minTime: '08:00:00', /* calendar start Timing */
                            maxTime: '19:00:00',  /* calendar end Timing */
                            defaultView: 'agendaWeek',
                            defaultDate: fecha,
                            editable: false,
                            droppable: false,
                            allDaySlot: false,
                            firstDay:0,
                            locale: 'es',
                            defaultTimedEventDuration: '00:05',
                            timeFormat: 'h:mm',
                            events: eventExisting,
                            eventClick: function(calEvent, jsEvent, view) {
                                id = $(this).attr('id');
                                $('#modal'+id).modal('show');
                                /* 
                                console.log('View', view);

                                alert($(this).attr('id'));
                                $(this).addClass("red");

                                alert('Event: ' + calEvent.title);
                                alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                                alert('View: ' + view.name);
                                radioStudy[id] = 1;

                                console.log("myArray ",radioStudy);
                                */
                            },
                        });
                        $('.fc-left').html("<h4>"+array['date']+"</h4>");
                        dayHeader = $('.fc-day-header');
                        dayHeader.each(function(i,element) {
                            if(radiologists[i] != undefined){
                                console.log(radiologists[i])
                                dayHeader[i].innerHTML = radiologists[i]['name'];
                            }else{
                                dayHeader[i].innerHTML = '';
                            }
                            console.log(element)
                        });
                    }
                });
                
                
            });
          </script>
@endsection



