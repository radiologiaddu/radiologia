@extends('layouts.layoutHost')
@section('title','Mis estudios')
@section('leve','Nuevos')
@section('breadcrumb')

@endsection
@section('content')
    <!-- select2 css -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/newStudy.css') }}">
    <!-- material datetimepicker css -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
    <!-- Bootstrap datetimepicker css -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/fonts/material/css/materialdesignicons.min.css') }}">
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
    $index = 1;
@endphp
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
    <div class="col-sm-12 padding-0">
        <form id="formulario" class="form-horizontal style-form col-sm-12" method="POST" action="{{route('updateStudy',['id' => $study->id])}}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="card" style="border-radius: 25px">
                <div class="card-block text-center">
                    <div class="col-12 row m-0">
                        <h3 class="col-12">
                            Datos del paciente
                        </h3>
                        <h6 class="mt-5 mb-3"><span style="color:red">*</span> Campo obligatorio</h6>
                        <div class="card-block text-left padding-0">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"><span style="color:red">*</span> Nombre del paciente:</label>
                                        <input id="patient_name" class="form-control" placeholder="Ej. Ramiro Alberto" type="text" name="patient_name" value="{{ $study->patient_name, old('patient_name') }}" required>
                                    </div>        
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"><span style="color:red">*</span> Primer apellido del paciente:</label>
                                        <input id="paternal_surname" class="form-control" placeholder="Ej. Sánchez" type="text" name="paternal_surname" value="{{ $study->paternal_surname, old('paternal_surname') }}" required>
                                    </div>        
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Segundo apellido del paciente:</label>
                                        <input id="maternal_surname" class="form-control" placeholder="Ej. Mendieta" type="text" name="maternal_surname" value="{{ $study->maternal_surname, old('maternal_surname') }}">
                                    </div>        
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"><span style="color:red">*</span> Correo electrónico del paciente:</label>
                                        <input id="patient_email" class="form-control" placeholder="Ej. ramsanmend@gmail.com" type="email" name="patient_email" value="{{ $study->patient_email, old('patient_email') }}"  required>
                                    </div>        
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"><span style="color:red">*</span> Número de contacto del paciente:</label>
                                        <input type="text"  id="patient_phone" name="patient_phone" class="form-control mob_noPersonal {{ $errors->has('patient_phone') ? ' is-invalid' : '' }}" data-mask="999-999-9999" value="{{ $study->patient_phone, old('patient_phone') }}" placeholder="999-999-9999" required>            
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">SU FECHA DE NACIMIENTO</label>
                                        @if (is_null($study->birthday))
                                            @php
                                                $dateBirthday = [
                                                    0 => $year,
                                                    1 => 01,
                                                    2 => 01
                                                ];
                                            @endphp  
                                        @else
                                            @php
                                                $dateBirthday = explode("-", $study->birthday);
                                            @endphp   
                                        @endif
                                         
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label class="form-label"><span style="color:red">*</span> DÍA</label>
                                                <select class="js-example-basic-single form-control {{ $errors->has('day') ? ' is-invalid' : '' }}" id="day" name="day" required>
                                                    <option value="" selected disabled>Selecciona su día de nacimiento:</option>
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
                                                <label class="form-label"><span style="color:red">*</span> MES</label>
                                                <select class="js-example-basic-single form-control {{ $errors->has('month') ? ' is-invalid' : '' }}" id="month" name="month" required>
                                                    <option value="" selected disabled>Selecciona el mes de su nacimiento:</option>
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
                                                <label class="form-label"><span style="color:red">*</span> AÑO</label>
                                                <select class="js-example-basic-single form-control {{ $errors->has('year') ? ' is-invalid' : '' }}" id="year" name="year" required>
                                                    <option value="" selected disabled>Selecciona el año de su nacimiento:</option>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-block padding-0 text-center">
                    <div class="col-12 row">
                        <h3 class="col-12">
                            Datos del estudio
                        </h3>
                        <div class="col-12 card-block padding-0 text-left">
                            <div class="col-12">
                                <form id="formulario" class="form-horizontal style-form col-sm-12" method="POST" action="{{route('addStudy',['id' => auth()->user()->id])}}">
                                    {{ csrf_field() }}
                                    <div class="card-transparent tab-content" id="pills-tabContent">
                                        <div class="card-block">
                                            <div id="newStudy">
                                                @foreach ($arrayStudies as $itemStudy)
                                                    <div id="new{{$index}}">
                                                        <div class="title-block">
                                                            <h5>Selecciona la categoría de estudio:</h5>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="form-group col-12 p-0 mb-0 text-left">
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input name="arrayTypeOld[]" type="hidden" value="old{{$itemStudy->oldId}}">
                                                                            <select class="typeSelect required form-control {{ $errors->has('old'.$itemStudy->id) ? ' is-invalid' : '' }}" id="old{{$itemStudy->oldId}}" name="old{{$itemStudy->oldId}}" required>
                                                                                <option value="" selected disabled>Mostrar opciones:</option>
                                                                                @foreach ($types as $type)           
                                                                                    <option value="{{ $type->id }}"
                                                                                        @if ($type->id == $itemStudy->id )
                                                                                            selected
                                                                                        @endif    
                                                                                    >
                                                                                    {{ $type->type }}
                                                                                    </option>   
                                                                                @endforeach
                                                                            </select>
                                                                            @if ($index != 1)
                                                                                <span class="input-group-append pl-1"><button id="w{{$index}}" class="btn btn-danger delete" type="button">X</button></span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                        <div class="input-group mb-3" id="questionold{{$itemStudy->oldId}}">
                                                            @foreach ($itemStudy->questions as $question)
                                                                <div class="form-group col-12 p-0 mb-0 text-left">
                                                                    <div class="title-block">
                                                                        <input name="old{{$itemStudy->oldId}}question[]" type="hidden" value="{{$question->id}}">
                                                                        <h6 class="title old{{$itemStudy->oldId}}" id="question{{$question->id}}">{{$question->question}}</h6>
                                                                        @if ($question->kind == "radio")
                                                                            @if (count($question->answer)>1)
                                                                                @foreach ($question->answer as $answer)
                                                                                    @if ($answer->answer == "11" || $answer->answer == "21")
                                                                                        <div class="col-6">
                                                                                    @endif
                                                                                    @if ($answer->answer == "31" || $answer->answer == "41")
                                                                                        <div class="col-6 mt-4">
                                                                                    @endif
                                                                                    @php
                                                                                        $labelCost = '';
                                                                                        $cost = 0;
                                                                                        $labelDep = '';
                                                                                    @endphp
                                                                                    @if ($study->internal == 0)
                                                                                        @php
                                                                                            $answerCost = $answer->costDoctor;
                                                                                        @endphp
                                                                                    @else
                                                                                        @php
                                                                                            $answerCost = $answer->cost;
                                                                                        @endphp
                                                                                    @endif
                                                                                    @if (!is_null($answerCost))
                                                                                        @php
                                                                                            $labelCost = ' ('.sprintf('$ %s', number_format($answerCost, 2)).')';
                                                                                            $cost = $answerCost;
                                                                                        @endphp
                                                                                    @endif
                                                                                    <div class="form-check col-12 pl-5">
                                                                                        @if(count($answer->dependency)>0)
                                                                                            @php
                                                                                               $labelDep .= 'dependency'
                                                                                            @endphp
                                                                                            @foreach($answer->dependency as $dependency)
                                                                                                @php
                                                                                                    $labelDep .= " old".$itemStudy->oldId."question".$dependency->question_id
                                                                                                @endphp
                                                                                            @endforeach
                                                                                        @endif
                                                                                        <input study_time="{{$answer->study_time}}" preparation_time="{{$answer->preparation_time}}" exit_time="{{$answer->exit_time}}" cost="{{$cost}}" class="{{$labelDep}} form-check-input answer-inputtype answer-inputold{{$itemStudy->oldId}}" type="radio" name="old{{$itemStudy->oldId}}question{{$question->id}}" value="{{$answer->id}}" data-name="{{$answer->answer}}"
                                                                                        @if (in_array($answer->id, $question->answers) )
                                                                                            checked
                                                                                        @endif
                                                                                        >
                                                                                        <label class="form-check-label" for="old{{$itemStudy->oldId}}question{{$question->id}}" style="font-size: 14px;">{{$answer->answer.$labelCost}}</label>
                                                                                    </div>
                                                                                    @if ($answer->answer == "18" || $answer->answer == "28" || $answer->answer == "38" || $answer->answer == "48")
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                @foreach ($question->answer as $answer)
                                                                                    @php
                                                                                        $labelCost = '';
                                                                                        $cost = 0;
                                                                                        $labelDep = '';
                                                                                    @endphp
                                                                                    @if ($study->internal == 0)
                                                                                        @php
                                                                                            $answerCost = $answer->costDoctor;
                                                                                        @endphp
                                                                                    @else
                                                                                        @php
                                                                                            $answerCost = $answer->cost;
                                                                                        @endphp
                                                                                    @endif
                                                                                    @if (!is_null($answerCost))
                                                                                        @php
                                                                                            $labelCost = ' ('.sprintf('$ %s', number_format($answerCost, 2)).')';
                                                                                            $cost = $answerCost;
                                                                                        @endphp
                                                                                    @endif
                                                                                    <div class="custom-control custom-checkbox col-12 pl-5">
                                                                                        @if(count($answer->dependency)>0)
                                                                                            @php
                                                                                               $labelDep .= 'dependency'
                                                                                            @endphp
                                                                                            @foreach($answer->dependency as $dependency)
                                                                                                @php
                                                                                                    $labelDep .= " old".$itemStudy->oldId."question".$dependency->question_id
                                                                                                @endphp
                                                                                            @endforeach
                                                                                        @endif
                                                                                        <input study_time="{{$answer->study_time}}" preparation_time="{{$answer->preparation_time}}" exit_time="{{$answer->exit_time}}" cost="{{$cost}}" class="{{$labelDep}} custom-control-input answer-inputtype answer-inputold{{$itemStudy->oldId}}" type="checkbox" id="elementold{{$itemStudy->oldId}}question{{$question->id}}answer{{$answer->id}}" name="old{{$itemStudy->oldId}}question{{$question->id}}[]" value="{{$answer->id}}"
                                                                                            @if (in_array($answer->id, $question->answers) )
                                                                                                checked
                                                                                            @endif
                                                                                        >
                                                                                        <label class="custom-control-label" for="elementold{{$itemStudy->oldId}}question{{$question->id}}answer{{$answer->id}}" style="font-size: 14px;">{{$answer->answer.$labelCost}}</label>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        @else
                                                                            @if ($question->kind == "check")
                                                                                @foreach ($question->answer as $answer)
                                                                                    @if ($answer->answer == "11" || $answer->answer == "21")
                                                                                        <div class="col-6">
                                                                                    @endif
                                                                                    @if ($answer->answer == "31" || $answer->answer == "41")
                                                                                        <div class="col-6 mt-4">
                                                                                    @endif
                                                                                    @php
                                                                                        $labelCost = '';
                                                                                        $cost = 0;
                                                                                        $labelDep = '';
                                                                                    @endphp
                                                                                     @if ($study->internal == 0)
                                                                                        @php
                                                                                            $answerCost = $answer->costDoctor;
                                                                                        @endphp
                                                                                    @else
                                                                                        @php
                                                                                            $answerCost = $answer->cost;
                                                                                        @endphp
                                                                                    @endif
                                                                                    @if (!is_null($answerCost))
                                                                                        @php
                                                                                            $labelCost = ' ('.sprintf('$ %s', number_format($answerCost, 2)).')';
                                                                                            $cost = $answerCost;
                                                                                        @endphp
                                                                                    @endif
                                                                                    <div class="custom-control custom-checkbox col-12 pl-5">
                                                                                        @if(count($answer->dependency)>0)
                                                                                            @php
                                                                                               $labelDep .= 'dependency'
                                                                                            @endphp
                                                                                            @foreach($answer->dependency as $dependency)
                                                                                                @php
                                                                                                    $labelDep .= " old".$itemStudy->oldId."question".$dependency->question_id
                                                                                                @endphp
                                                                                            @endforeach
                                                                                        @endif
                                                                                        <input study_time="{{$answer->study_time}}" preparation_time="{{$answer->preparation_time}}" exit_time="{{$answer->exit_time}}" cost="{{$cost}}" class="{{$labelDep}} custom-control-input answer-inputtype answer-inputold{{$itemStudy->oldId}}" type="checkbox" id="elementold{{$itemStudy->oldId}}question{{$question->id}}answer{{$answer->id}}" name="old{{$itemStudy->oldId}}question{{$question->id}}[]" value="{{$answer->id}}"
                                                                                            @if (in_array($answer->id, $question->answers) )
                                                                                                checked
                                                                                            @endif
                                                                                        >
                                                                                        <label class="custom-control-label" for="elementold{{$itemStudy->oldId}}question{{$question->id}}answer{{$answer->id}}" style="font-size: 14px;">{{$answer->answer.$labelCost}}</label>
                                                                                    </div>
                                                                                    @if ($answer->answer == "18" || $answer->answer == "28" || $answer->answer == "38" || $answer->answer == "48")
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                @php
                                                                                    $labelDep = '';
                                                                                @endphp
                                                                                <div class="form-group">
                                                                                    <div class="input-group">
                                                                                        <input
                                                                                        @if(count($question->dependency)>0)
                                                                                            @php
                                                                                               $labelDep .= 'dependent'
                                                                                            @endphp
                                                                                            disabled
                                                                                        @endif
                                                                                         name="old{{$itemStudy->oldId}}question{{$question->id}}" type="text" class="{{$labelDep}} form-control answer answer-inputtype answer-inputold{{$itemStudy->oldId}}" placeholder="Respuesta"
                                                                                        @if(!empty($question->answers))
                                                                                            value="{{$question->answers[0]}}"
                                                                                        @endif
                                                                                        >                                                                          
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
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

                                                                    </div>
                                                                </div>

                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @php
                                                        $index++;
                                                    @endphp
                                                @endforeach
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group col-md-12 col-sm-12 mt-2">
                                                <button type="button" id="plus" class="btn btn-round btn-success float-right">
                                                    <i class="fa fa-plus"></i> Añadir estudio
                                                </button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                        
                                    </div>
                                </form>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Observaciones adicionales:</label>
                                <textarea id="note" name="note" class="form-control" aria-label="With textarea" style="height: 100px;">{{$study->observations}}</textarea>
                            </div>
                            <div class="text-justify text-duration">
                                <h4 class="mb-3">
                                    <strong id="labelDuration">Tiempo de estudio:</strong> 
                                    <h4 id="p-Duration"></h4>
                                    <input id="durationInput" name="duration" type="hidden">
                                </h4>
                            </div>

                            <div class="text-justify text-total">
                                <h4 class="mb-3">
                                    <strong>Total:</strong> 
                                    <h4 id="p-Cost"></h4>
                                    <input id="totalInput" name="total" type="hidden">
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" id="save" class="btn btn-rounded btn-warning">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('css')
    <!-- Input mask Js -->
    <script src="{{ asset('/assets/plugins/inputmask/js/inputmask.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/inputmask/js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/inputmask/js/autoNumeric.js') }}"></script>

<!-- form-advance custom js -->
<script src="{{ asset('/assets/js/pages/form-advance-custom.js') }}"></script>   

    <!-- select2 Js -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>   

    <!-- multi-select Js -->
    <script src="{{ asset('/assets/plugins/multi-select/js/jquery.quicksearch.js') }}"></script>   
    <script src="{{ asset('/assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script>   

    <!-- form-select-custom Js -->
    <script src="{{ asset('/assets/js/pages/form-select-custom.js') }}"></script>   

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        var x = '{{$index}}';
        var total = 0;
        var duration = '00:00';

        $(".dependency").change(function(evt){
            $(".dependent").each(function() {
                var dependentName = $( this ).attr('name');
                if ($('.'+dependentName).filter(':checked').length > 0){
                    $( this ).prop( "disabled", false );
                    $( this ).addClass( "required" );
                }else{
                    $( this ).val( "");
                    $( this ).prop( "disabled", true );
                    $( this ).removeClass( "required" );
                    var nameA =  $( this ).attr('name').replace('[]', '');
                    $( '#'+nameA ).remove();
                }   
            }); 
        });

        $( ".delete" ).click(function() {
            var id = $(this).attr("id");
            $( '#ne'+id ).remove();
            $('#reView'+id.replace('w', '')).remove();
            total = 0
            duration = '00:00';

            $('input').each(function () {
                if ($(this).is(':checked')) {
                    if($(this).attr('id') === "elementold4352question28answer141"){
                        // Obtener el valor de la respuesta
                        var respuesta = $('input[name="old4352question36"]').val();

                        // Dividir el valor por comas y contar los elementos
                        var valores = respuesta.split(',');
                        var numeroElementos = valores.length;
                        total += (parseFloat($( this ).attr('cost')) * numeroElementos);

                    }else{
                        total +=  parseFloat($( this ).attr('cost'));
                    }
                    if($(this).attr('study_time') != ""){
                        duration = addTimes(duration, $(this).attr('study_time'))
                    }
                    if($(this).attr('preparation_time') != ""){
                        duration = addTimes(duration, $(this).attr('preparation_time'))
                    }
                    if($(this).attr('exit_time') != ""){
                        duration = addTimes(duration, $(this).attr('exit_time'))
                    }
                }
            });
            var locale = 'en-US';
            var options = {style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2};
            var formatter = new Intl.NumberFormat(locale, options);
            var labelCost = formatter.format(total);
            $( "#p-Cost" ).html( labelCost );
            $( "#totalInput" ).val( total );

                    $( "#labelDuration" ).html('Tiempo de estudio: ')
                    $( "#p-Duration" ).html(duration )
                
                $( "#durationInput" ).val( duration )
        });

        $(".mob_noPersonal").inputmask({
            mask: "999-999-9999"
        });
            
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

        $(".typeSelect").change(function(evt){
            var value = $( this ).val();
            var id = $( this ).attr('id');

            $.ajax({
                type: "POST",
                url: "{{ url('/questionRec') }}",
                data: {"id":value, "idElement":id , _token : '{{ csrf_token() }}',"internal": '{{ $study->internal }}'},
                success: function (opciones) {
                    $("#question"+id).html(opciones);
                    var typeText = $( "#type option:selected" ).text();
                    total = 0;
                    duration = '00:00';
                    $('input').each(function () {
                        if ($(this).is(':checked')) {
                            if($(this).attr('id') === "elementold4352question28answer141"){
                        // Obtener el valor de la respuesta
                        var respuesta = $('input[name="old4352question36"]').val();

                        // Dividir el valor por comas y contar los elementos
                        var valores = respuesta.split(',');
                        var numeroElementos = valores.length;
                        total += (parseFloat($( this ).attr('cost')) * numeroElementos);

                    }else{
                        total +=  parseFloat($( this ).attr('cost'));
                    }
                            if($(this).attr('study_time') != ""){
                                duration = addTimes(duration, $(this).attr('study_time'))
                            }
                            if($(this).attr('preparation_time') != ""){
                                duration = addTimes(duration, $(this).attr('preparation_time'))
                            }
                            if($(this).attr('exit_time') != ""){
                                duration = addTimes(duration, $(this).attr('exit_time'))
                            }
                        }
                    });
                    var locale = 'en-US';
                    var options = {style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2};
                    var formatter = new Intl.NumberFormat(locale, options);
                    var labelCost = formatter.format(total);
                    $( "#p-Cost" ).html( labelCost );
                    $( "#totalInput" ).val( total );

                    $( "#labelDuration" ).html('Tiempo de estudio: ')
                    $( "#p-Duration" ).html(duration )
                    
                    $( "#durationInput" ).val( duration )

                    $(".dependency").change(function(evt){
                        $(".dependent").each(function() {
                            var dependentName = $( this ).attr('name');
                            if ($('.'+dependentName).filter(':checked').length > 0){
                                $( this ).prop( "disabled", false );
                                $( this ).addClass( "required" );
                            }else{
                                $( this ).val( "");
                                $( this ).prop( "disabled", true );
                                $( this ).removeClass( "required" );
                                var nameA =  $( this ).attr('name').replace('[]', '');
                                $( '#'+nameA ).remove();
                            }   
                        }); 
                    });

                    $(".answer-input"+id).change(function(evt){
                        total = 0
                        duration = '00:00';

                        $('input').each(function () {
                            if ($(this).is(':checked')) {
                                if($(this).attr('id') === "elementold4352question28answer141"){
                        // Obtener el valor de la respuesta
                        var respuesta = $('input[name="old4352question36"]').val();

                        // Dividir el valor por comas y contar los elementos
                        var valores = respuesta.split(',');
                        var numeroElementos = valores.length;
                        total += (parseFloat($( this ).attr('cost')) * numeroElementos);

                    }else{
                        total +=  parseFloat($( this ).attr('cost'));
                    }
                                if($(this).attr('study_time') != ""){
                                    duration = addTimes(duration, $(this).attr('study_time'))
                                }
                                if($(this).attr('preparation_time') != ""){
                                    duration = addTimes(duration, $(this).attr('preparation_time'))
                                }
                                if($(this).attr('exit_time') != ""){
                                    duration = addTimes(duration, $(this).attr('exit_time'))
                                }
                            }
                        });
                        var locale = 'en-US';
                        var options = {style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2};
                        var formatter = new Intl.NumberFormat(locale, options);
                        var labelCost = formatter.format(total);
                        $( "#p-Cost" ).html( labelCost );
                        $( "#totalInput" ).val( total );

                            $( "#labelDuration" ).html('Tiempo de estudio: ')
                            $( "#p-Duration" ).html(duration )
                        
                        $( "#durationInput" ).val( duration )
                    });
                }
    
            });
        }); 
        
        $(".dependency").change(function(evt){
            $(".dependent").each(function() {
                var dependentName = $( this ).attr('name');
                if ($('.'+dependentName).filter(':checked').length > 0){
                    $( this ).prop( "disabled", false );
                    $( this ).addClass( "required" );
                }else{
                    $( this ).val( "");
                    $( this ).prop( "disabled", true );
                    $( this ).removeClass( "required" );
                    var nameA =  $( this ).attr('name').replace('[]', '');
                    $( '#'+nameA ).remove();
                }   
            }); 
        });

        $(".answer-inputtype").change(function(evt){           
            total = 0
            duration = '00:00';

            $('input').each(function () {
                if ($(this).is(':checked')) {
                    if($(this).attr('id') === "elementold4352question28answer141"){
                        // Obtener el valor de la respuesta
                        var respuesta = $('input[name="old4352question36"]').val();

                        // Dividir el valor por comas y contar los elementos
                        var valores = respuesta.split(',');
                        var numeroElementos = valores.length;
                        total += (parseFloat($( this ).attr('cost')) * numeroElementos);

                    }else{
                        total +=  parseFloat($( this ).attr('cost'));
                    }
                    if($(this).attr('study_time') != ""){
                        duration = addTimes(duration, $(this).attr('study_time'))
                    }
                    if($(this).attr('preparation_time') != ""){
                        duration = addTimes(duration, $(this).attr('preparation_time'))
                    }
                    if($(this).attr('exit_time') != ""){
                        duration = addTimes(duration, $(this).attr('exit_time'))
                    }
                }
            });
            var locale = 'en-US';
            var options = {style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2};
            var formatter = new Intl.NumberFormat(locale, options);
            var labelCost = formatter.format(total);
            $( "#p-Cost" ).html( labelCost );
            $( "#totalInput" ).val( total );

                $( "#labelDuration" ).html('Tiempo de estudio: ')
                $( "#p-Duration" ).html(duration )
            
            $( "#durationInput" ).val( duration )

        });

        $( "#save" ).click(function() {
            var valid = true;
            $.each($(".required"), function (index, value) {
                if(!$(value).val()){
                    valid = false;
                }else{
                    if($(value).attr('type') != 'text'){
                        var valueID = $(value).attr('id');
                        if ($('.answer-input'+valueID).filter(':checked').length < 1){
                            valid = false;  
                        }
                    }
                }
            });
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
                if(!regex.test($("#patient_email").val()) || !regexPhone.test($("#patient_phone").val())){
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
                        'Los datos del paciente son incorrectos, revisa el formulario.',
                    )
                }
            } 
            else{
                Swal.fire(
                    'Formulario incompleto',
                    'Debes llenar todos los campos obligatorios.',
                )
            }
        });
        
    
        document.getElementById("plus").addEventListener("click", function(event){
            //event.preventDefault();
            $('#arrayType').val();
    
            var select=$('<input name="arrayType[]" type="hidden" value="type'+x+'"><select class="required form-control" id="type'+x+'" name="type'+x+'" required></select>');
            select.append('<option value="" selected disabled>Selecciona:</option>');   
            @foreach ($types as $type)
                select.append('<option value="'+{{ $type->id }}+'" >{{ $type->type }}</option>');  
            @endforeach 
            var div1=$('<div id="new'+x+'"></div>');
                div1.append('<div class="title-block"><h5>Selecciona el estudio:</h5></div>');
            var div2=$('<div class="input-group mb-3"></div>');
            var div3=$('<div class="form-group col-12 p-0 mb-0 text-left"></div>');
            var div4=$('<div class="form-group"></div>');
            var div5=$('<div class="input-group"></div>');                              
                div5.append(select);
                div5.append('<span class="input-group-append pl-1"><button id="w'+x+'" class="btn btn-danger delete" type="button">X</button></span>');
                div4.append(div5);
                div3.append(div4);
                div2.append(div3);
                div1.append(div2);
                div1.append('<div class="input-group mb-3" id="questiontype'+x+'"></div>');
    
            $('#newStudy').append(div1);  
            $('#divView').append('<div id="reView'+x+'"></div>');  
    
            $("#type"+x).change(function(evt){
                var id = $(this).attr("id");
                var value = $( this ).val();
                $.ajax({
                    type: "POST",
                    url: "{{ url('/questionRec') }}",
                    data: {"id":value, "idElement":id ,_token : '{{ csrf_token() }}',"internal": '{{ $study->internal }}'},
                    success: function (opciones) {
                        $("#question"+id).html(opciones);
                        var typeText = $( "#"+id+" option:selected" ).text();
                        total = 0
                        duration = '00:00';

                        $('input').each(function () {
                            if ($(this).is(':checked')) {
                                if($(this).attr('id') === "elementold4352question28answer141"){
                        // Obtener el valor de la respuesta
                        var respuesta = $('input[name="old4352question36"]').val();

                        // Dividir el valor por comas y contar los elementos
                        var valores = respuesta.split(',');
                        var numeroElementos = valores.length;
                        total += (parseFloat($( this ).attr('cost')) * numeroElementos);

                    }else{
                        total +=  parseFloat($( this ).attr('cost'));
                    }
                                if($(this).attr('study_time') != ""){
                                    duration = addTimes(duration, $(this).attr('study_time'))
                                }
                                if($(this).attr('preparation_time') != ""){
                                    duration = addTimes(duration, $(this).attr('preparation_time'))
                                }
                                if($(this).attr('exit_time') != ""){
                                    duration = addTimes(duration, $(this).attr('exit_time'))
                                }
                            }
                        });
                        var locale = 'en-US';
                        var options = {style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2};
                        var formatter = new Intl.NumberFormat(locale, options);
                        var labelCost = formatter.format(total);
                        $( "#p-Cost" ).html( labelCost );
                        $( "#totalInput" ).val( total );

                            $( "#labelDuration" ).html('Tiempo de estudio: ')
                            $( "#p-Duration" ).html(duration )
                        
                        $( "#durationInput" ).val( duration )
                        
                        $(".dependency").change(function(evt){
                            $(".dependent").each(function() {
                                var dependentName = $( this ).attr('name');
                                if ($('.'+dependentName).filter(':checked').length > 0){
                                    $( this ).prop( "disabled", false );
                                    $( this ).addClass( "required" );
                                }else{
                                    $( this ).val( "");
                                    $( this ).prop( "disabled", true );
                                    $( this ).removeClass( "required" );
                                    var nameA =  $( this ).attr('name').replace('[]', '');
                                    $( '#'+nameA ).remove();
                                }   
                            }); 
                        });

                        $(".answer-input"+id).change(function(evt){
                            total = 0
                            duration = '00:00';

                            $('input').each(function () {
                                if ($(this).is(':checked')) {
                                    if($(this).attr('id') === "elementold4352question28answer141"){
                        // Obtener el valor de la respuesta
                        var respuesta = $('input[name="old4352question36"]').val();

                        // Dividir el valor por comas y contar los elementos
                        var valores = respuesta.split(',');
                        var numeroElementos = valores.length;
                        total += (parseFloat($( this ).attr('cost')) * numeroElementos);

                    }else{
                        total +=  parseFloat($( this ).attr('cost'));
                    }
                                    if($(this).attr('study_time') != ""){
                                        duration = addTimes(duration, $(this).attr('study_time'))
                                    }
                                    if($(this).attr('preparation_time') != ""){
                                        duration = addTimes(duration, $(this).attr('preparation_time'))
                                    }
                                    if($(this).attr('exit_time') != ""){
                                        duration = addTimes(duration, $(this).attr('exit_time'))
                                    }
                                }
                            });
                            var locale = 'en-US';
                            var options = {style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2};
                            var formatter = new Intl.NumberFormat(locale, options);
                            var labelCost = formatter.format(total);
                            $( "#p-Cost" ).html( labelCost );
                            $( "#totalInput" ).val( total );

                                $( "#labelDuration" ).html('Tiempo de estudio: ')
                                $( "#p-Duration" ).html(duration )
                            
                            $( "#durationInput" ).val( duration )
                        });
                    }
    
                });
            });
            $( ".delete" ).click(function() {
                var id = $(this).attr("id");
                $( '#ne'+id ).remove();
                $('#reView'+id.replace('w', '')).remove();

                total = 0
                duration = '00:00';

                $('input').each(function () {
                    if ($(this).is(':checked')) {
                        if($(this).attr('id') === "elementold4352question28answer141"){
                        // Obtener el valor de la respuesta
                        var respuesta = $('input[name="old4352question36"]').val();

                        // Dividir el valor por comas y contar los elementos
                        var valores = respuesta.split(',');
                        var numeroElementos = valores.length;
                        total += (parseFloat($( this ).attr('cost')) * numeroElementos);

                    }else{
                        total +=  parseFloat($( this ).attr('cost'));
                    }
                        if($(this).attr('study_time') != ""){
                            duration = addTimes(duration, $(this).attr('study_time'))
                        }
                        if($(this).attr('preparation_time') != ""){
                            duration = addTimes(duration, $(this).attr('preparation_time'))
                        }
                        if($(this).attr('exit_time') != ""){
                            duration = addTimes(duration, $(this).attr('exit_time'))
                        }
                    }
                });
                var locale = 'en-US';
                var options = {style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2};
                var formatter = new Intl.NumberFormat(locale, options);
                var labelCost = formatter.format(total);
                $( "#p-Cost" ).html( labelCost );
                $( "#totalInput" ).val( total );

                    $( "#labelDuration" ).html('Tiempo de estudio: ')
                    $( "#p-Duration" ).html(duration )
                
                $( "#durationInput" ).val( duration )
            });
            x++;
    
            
        });
        $(document).ready(function() { 

            $(".dependent").each(function() {
                var dependentName = $( this ).attr('name');
                if ($('.'+dependentName).filter(':checked').length > 0){
                    $( this ).prop( "disabled", false );
                    $( this ).addClass( "required" );
                }else{
                    $( this ).val( "");
                    $( this ).prop( "disabled", true );
                    $( this ).removeClass( "required" );
                    var nameA =  $( this ).attr('name').replace('[]', '');
                    $( '#'+nameA ).remove();
                }   
            });
            
            $('input').each(function () {
                if ($(this).is(':checked')) {
                    if($(this).attr('id') === "elementold4352question28answer141"){
                        // Obtener el valor de la respuesta
                        var respuesta = $('input[name="old4352question36"]').val();

                        // Dividir el valor por comas y contar los elementos
                        var valores = respuesta.split(',');
                        var numeroElementos = valores.length;
                        total += (parseFloat($( this ).attr('cost')) * numeroElementos);

                    }else{
                        total +=  parseFloat($( this ).attr('cost'));
                    }
                    if($(this).attr('study_time') != ""){
                        duration = addTimes(duration, $(this).attr('study_time'))
                    }
                    if($(this).attr('preparation_time') != ""){
                        duration = addTimes(duration, $(this).attr('preparation_time'))
                    }
                    if($(this).attr('exit_time') != ""){
                        duration = addTimes(duration, $(this).attr('exit_time'))
                    }
                }
            });
            var locale = 'en-US';
            var options = {style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2};
            var formatter = new Intl.NumberFormat(locale, options);
            var labelCost = formatter.format(total);
            $( "#p-Cost" ).html( labelCost );
            $( "#totalInput" ).val( total );

                $( "#labelDuration" ).html('Tiempo de estudio: ')
                $( "#p-Duration" ).html(duration )
            
            $( "#durationInput" ).val( duration )
        });
       
        $(document).ready(function () {
    // Escuchar cambios en el input con name="old4352question36"
    $('input[name="old4352question36"]').on('input', function () {
        // Obtener el valor actual del input y dividirlo por comas
        var respuesta = $(this).val().trim();
        var valores = respuesta.split(',').filter(function (value) {
            return value.trim() !== ''; // Filtrar elementos vacíos
        });
        var numeroElementos = valores.length;

        // Verificar si el checkbox está marcado
        var checkbox = $('input[id="elementold4352question28answer141"]');
        if (checkbox.is(':checked')) {
            // Obtener el costo del checkbox
            var costo = parseFloat(checkbox.attr('cost'));

            // Calcular el costo multiplicado por el número de elementos
            var costoTotal = costo * numeroElementos;

            // Obtener el valor actual del <h4 id="p-Cost">
            var montoActualTexto = $('#p-Cost').text().replace(/[^0-9.-]+/g, ''); // Remover símbolos y obtener solo números
            var montoActual = parseFloat(montoActualTexto) || 0;

            // Calcular el nuevo monto
            var nuevoMonto = montoActual + costoTotal - costo;

            // Actualizar el valor de <h4 id="p-Cost">
            var formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            var nuevoMontoFormateado = formatter.format(nuevoMonto);

            console.log('Costo del checkbox:', costo);
            console.log('Número de elementos:', numeroElementos);
            console.log('Costo total:', costoTotal);
            console.log('Monto actualizado:', nuevoMontoFormateado);
        }
    });
    $('#p-Cost').text(nuevoMontoFormateado);

            // Actualizar el valor del input hidden
            $('#totalInput').val(nuevoMonto);
});


    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection