@extends('layouts.layoutHost')
@section('title','Bienvenido')
@section('leve','Nuevos')
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
    <div class="col-sm-12">
        <div class="card">
            <div class="card-block block-r">
                <div>
                    <!-- [ Main Content ] start -->
                    <div class="row">
                        <!-- [ task-board ] start -->
                        <div class="col-xl-12 col-lg-12 filter-bar">
                            <nav class="navbar m-b-30 p-10">
                                <div class="nav-item nav-grid f-view">
                                    <button id="reload" class="btn btn-icon m-0 btn-reload" type="button">
                                        <i class="feather icon-refresh-ccw"></i>
                                    </button>
                                    <button id="loading" class="btn btn-icon m-0 btn-reload d-none" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"></span>
                                    </button>
                                </div>
                                <div class="form-group p-0 mb-0 text-left">
                                    <select class="form-control" id="radiologist" name="radiologist" required>
                                        <option value="all" selected>Todos los estudios</option>
                                        @foreach ($radiologists as $radiologist)
                                            <option value="{{$radiologist->name}}">{{$radiologist->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </nav>
                            <div class="row divCard">
                                @foreach ($studies as $study)
                                    <div class="divRadiologist col-md-6 col-sm-12" radiologo="{{$study->radiologist}}">
                                        <div class="card card-border-c-blue">
                                            <div class="card-header d-block">
                                                <a href="#!" class="text-secondary">
                                                    @if ($study->internal == 1)
                                                        R{{sprintf('%06d',$study->folio)}}
                                                    @else
                                                        D{{sprintf('%06d',$study->folio)}}
                                                    @endif - {{$study->patient_name}} {{$study->paternal_surname}} {{$study->maternal_surname}} </a>
                                                <br>
                                                <strong>Cita:</strong>
                                                @if (isset($study->appointment))
                                                    {{$weekMap[strftime("%w",strtotime($study->appointment->date))]}}
                                                    {{strftime("%d",strtotime($study->appointment->date))}}
                                                    {{strtoupper($months[strftime("%m",strtotime($study->appointment->date))])}}
                                                    {{strftime("%Y",strtotime($study->appointment->date))}}
                                                    -
                                                    {{$study->appointment->time}} hrs.
                                                @else
                                                    Sin agendar cita
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
                                                <div class="mt-1">
                                                    <p class="task-due"><strong> Radiólogo: </strong><strong class="label label-primary">{{$study->radiologist}}</strong></p>
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
                                                    <button class="btn btn-primary btn-sm finish" type="button" id="{{$study->qr}}" >TERMINAR ESTUDIO</button>
                                                </div>
                                                <!--
                                                <div class="task-board">
                                                </div>
                                                -->
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <!-- [ task-board ] end -->
                    </div>
                    <!-- [ Main Content ] end -->
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
    
    <!-- task-board js -->
    <script src="{{ asset('/assets/js/pages/task-board.js') }} "></script>

    <script type="text/javascript">
        $(document).ready(function() { 
            $("body").on("click",".finish", function () {
                var id = $(this).attr("id");
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/finishRadio') }}",
                        data: {"id": id ,_token : '{{ csrf_token() }}'},
                        success: function (flag) {
                            if(flag){
                                swal("Exito","Estudio finalizo correctamente", "success")
                                .then((value) => {
                                    $( "#divCard" ).addClass( "d-none" )

                                    $.ajax({
                                        type: "POST",
                                        url: "{{ url('/RadiologoReload') }}",
                                        data: {_token : '{{ csrf_token() }}'},
                                        success: function (opciones) {
                                            $(".divCard").html(opciones);
                                            var val = $("#radiologist").val();
                                            if(val == "all"){
                                                $(".divRadiologist").removeClass( "d-none" );
                                            }else{
                                                $.each($(".divRadiologist"), function (index, value) {
                                                    if($(value).attr('radiologo') == val){
                                                        $(value).removeClass( "d-none" );
                                                    }else{
                                                        $(value).addClass( "d-none" );
                                                    }
                                                });
                                            }
                                            $( "#divCard" ).removeClass( "d-none" )
                                        }

                                    });
                                
                                });
                            }else{
                                swal("Error","A ocurrido un error al finalizar el estudio", "error")
                                .then((value) => {
                                    $( "#divCard" ).addClass( "d-none" )

                                    $.ajax({
                                        type: "POST",
                                        url: "{{ url('/RadiologoReload') }}",
                                        data: {_token : '{{ csrf_token() }}'},
                                        success: function (opciones) {
                                            $(".divCard").html(opciones);
                                            var val = $("#radiologist").val();
                                            if(val == "all"){
                                                $(".divRadiologist").removeClass( "d-none" );
                                            }else{
                                                $.each($(".divRadiologist"), function (index, value) {
                                                    if($(value).attr('radiologo') == val){
                                                        $(value).removeClass( "d-none" );
                                                    }else{
                                                        $(value).addClass( "d-none" );
                                                    }
                                                });
                                            }
                                            $( "#divCard" ).removeClass( "d-none" )
                                        }

                                    });
                                });
                            }
                        }
                    });
            
            });
        });
        $("#radiologist").change(function(evt){
            var val = $(this).val();
            if(val == "all"){
                $(".divRadiologist").removeClass( "d-none" );
            }else{
                $.each($(".divRadiologist"), function (index, value) {
                    if($(value).attr('radiologo') == val){
                        $(value).removeClass( "d-none" );
                    }else{
                        $(value).addClass( "d-none" );
                    }
                });
            }
            
        });

        $( "#reload" ).click(function() {
            $( "#loading" ).removeClass( "d-none" )
            $( "#divCard" ).addClass( "d-none" )
            $( "#reload" ).addClass( "d-none" );

            $.ajax({
                type: "POST",
                url: "{{ url('/RadiologoReload') }}",
                data: {_token : '{{ csrf_token() }}'},
                success: function (opciones) {
                    $(".divCard").html(opciones);
                    var val = $("#radiologist").val();
                    if(val == "all"){
                        $(".divRadiologist").removeClass( "d-none" );
                    }else{
                        $.each($(".divRadiologist"), function (index, value) {
                            if($(value).attr('radiologo') == val){
                                $(value).removeClass( "d-none" );
                            }else{
                                $(value).addClass( "d-none" );
                            }
                        });
                    }
                    $( "#loading" ).addClass( "d-none" )
                    $( "#divCard" ).removeClass( "d-none" )
                    $( "#reload" ).removeClass( "d-none" );   
                }

            });
        });
    </script>
@endsection



