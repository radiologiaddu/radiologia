@extends('layouts.layout')
@section('title','Tipos de estudios')
@section('leve','setting')
@section('subleve','Estudios')
@section('breadcrumb')
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Editar pregunta</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('types') }}">Tipos de estudios</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('seeType',['id' => $question->type->id]) }}">{{$question->type->type}}</a></li>
                    <li class="breadcrumb-item"><a href="#">Editar pregunta</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@php
    $x = 0;
@endphp
@section('content')
    <div class="col-sm-12">
        <form id="formulario" class="form-horizontal style-form col-sm-12" method="POST" action="{{route('updateQuestion',['id' => $question->id])}}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="card">
                <div class="card-header">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label class="form-label">Pregunta</label>
                            <input name="question" type="text" class="form-control" value="{{$question->question}}" placeholder="Pregunta" required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label class="form-label">Tipo de respuesta</label>
                            <select id="kind" name="kind" class="custom-select" required>
                                <option class="text-muted" value="" selected disabled>Selecciona el tipo de respuesta</option>
                                <option class="text-muted" value="check" 
                                    @if ($question->kind =="check")
                                        selected
                                    @endif
                                >Multiple</option>
                                <option class="text-muted" value="radio"
                                    @if ($question->kind =="radio")
                                        selected
                                    @endif
                                >Unica</option>
                                <option class="text-muted" value="texto"
                                    @if ($question->kind =="texto")
                                        selected
                                    @endif
                                >Texto</option>
                             </select>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <div class="form-row">
                        <div class="form-group">
                            <div class="checkbox checkbox-success checkbox-fill d-inline">
                                <input type="checkbox" name="dependencia" id="dependencia" 
                                @if (count($question->dependency)>0)
                                    checked  
                                @endif
                                @if ($question->kind !="texto")
                                    disabled
                                @endif
                                >
                                <label for="dependencia" class="cr">Depende de una respuesta para activar la pregunta (Solo tipo de respuesta "Texto")</label>
                            </div>
                        </div>
                    </div>
                    <div id="questions" class="form-row
                        @if (count($question->dependency)<1)
                            d-none  
                        @endif
                    " style="padding: 0px 25px;">
                        <span class="mb-3">* Para habilitar la pregunta durante la realización del estudio se debe marca por lo menos una de las respuestas escogidas.</span>
                            @foreach ($question->type->questions as $questionIn)
                                @if ($questionIn->kind != "texto" && $question->id !== $questionIn->id)
                                    @if (count($questionIn->answer)>0)
                                        <div class=" col-md-6 col-12"> 
                                            <h5>{{$questionIn->question}}</h5>
                                            @foreach ($questionIn->answer as $answer)
                                                <div class="">
                                                    <div class="checkbox checkbox-success d-inline">
                                                        <input type="checkbox" id="checkbox-{{$answer->id}}" name="response[]" value="{{$answer->id}}"
                                                        @if (count($question->dependency->where('answer_id', $answer->id))>0)
                                                            checked
                                                        @endif
                                                        >
                                                        <label for="checkbox-{{$answer->id}}" class="cr">{{$answer->answer}}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                                
                            @endforeach
                    </div>
                </div>
                <div class="card-block">
                    <div id="answers" class="form-row">
                        <div class="form-group col-md-12 col-sm-12">
                            <label class="form-label">Agrega las posibles respuestas que existen para este aspecto a valuar</label>
                            <div id="myList" class="form-group col-md-12 col-sm-12">
                                
                                @forelse ($question->answer as $answer)
                                    <div class="col-md col-md-12 float-left answer{{$x}}">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input name="prev[]" type="hidden" class="form-control" placeholder="Respuesta" value="{{$answer->id}}">
                                                <input name="prev{{$answer->id}}" type="text" class="form-control" placeholder="Respuesta" value="{{$answer->answer}}">
                                                <span class="input-group-append">
                                                    <button id="answer{{$x}}" class="btn btn-danger delete" type="button">X</button>
                                                </span>
                                            </div>
                                            <div class="input-group">
                                                <div class="col-md-6 p-0">
                                                    <label for="answercost" class="cr">Costo</label>
                                                    <input name="prev{{$answer->id}}cost" type="text" class="form-control autonumber" value="{{$answer->cost}}" data-a-sign="$" placeholder="Costo">
                                                </div>
                                                <div class="col-md-6 p-0">
                                                    <label class="cr">Costo doctor</label>
                                                    <input name="prev{{$answer->id}}costDoctor" type="text" class="form-control autonumber" value="{{$answer->costDoctor}}" data-a-sign="$" placeholder="Costo doctor">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <input name="prev{{$answer->id}}study_time" type="text" class="form-control hours" value="{{$answer->study_time}}" data-mask="99:99" placeholder="Tiempo estudio" pattern="[0-9]{2}:[0-9]{2}">
                                                <input name="prev{{$answer->id}}preparation_time" type="text" class="form-control hours" value="{{$answer->preparation_time}}" data-mask="99:99" placeholder="Tiempo de preparación" pattern="[0-9]{2}:[0-9]{2}">
                                                <input name="prev{{$answer->id}}exit_time" type="text" class="form-control hours" value="{{$answer->exit_time}}" data-mask="99:99" placeholder="Tiempo de salida del paciente" pattern="[0-9]{2}:[0-9]{2}">
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $x++;
                                    @endphp
                                @empty
                                    <div class="col-md col-md-12 float-left answer{{$x}}">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input name="answers[]" type="hidden" value="answer{{$x}}">
                                                <input name="answer{{$x}}" type="text" class="form-control" placeholder="Respuesta">
                                                <input name="answer{{$x}}cost" type="text" class="form-control autonumber" data-a-sign="$" placeholder="Costo">
                                                   <span class="input-group-append">
                                                    <button id="answer{{$x}}" class="btn btn-danger delete" type="button">X</button>
                                                </span>
                                                <div class="input-group">
                                                    <input name="answer{{$x}}study_time" type="text" class="form-control hours" data-mask="99:99" placeholder="Tiempo estudio" pattern="[0-9]{2}:[0-9]{2}">
                                                    <input name="answer{{$x}}preparation_time" type="text" class="form-control hours" data-mask="99:99" placeholder="Tiempo de preparación" pattern="[0-9]{2}:[0-9]{2}">
                                                    <input name="answer{{$x}}exit_time" type="text" class="form-control hours" data-mask="99:99" placeholder="Tiempo de salida del paciente" pattern="[0-9]{2}:[0-9]{2}">    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-md-12 col-sm-12 mt-2">
                                <button id="plus" class="btn btn-round btn-success float-right">
                                    <i class="fa fa-plus"></i> Añadir nuevo valor
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-12 row">
                        <div class="col-md-6">
                            <fieldset class="form-group">
                                <div class="row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Añadir nota</label>
                                    <div class="col-sm-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios" id="none" value="none"
                                            @if (is_null($question->class_note))
                                                checked
                                            @endif
                                            >
                                            <label class="form-check-label" for="none" style="font-size: 14px;">No añadir</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios" id="simpleNote" value="simpleNote"
                                            @if ($question->class_note == "simpleNote")
                                                checked
                                            @endif>
                                            <label class="form-check-label" for="simpleNote" style="font-size: 14px;">Normal</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios" id="highlightedNote" value="highlightedNote"
                                            @if ($question->class_note == "highlightedNote")
                                                checked
                                            @endif
                                            >
                                            <label class="form-check-label" for="highlightedNote" style="font-size: 14px;">
                                                <div style="background: rgb(110,123,222);
                                                border-radius: 50%;
                                                height: 30px;
                                                width: 30px;
                                                text-align: center;
                                                align-items: center;
                                                display: flex;
                                                float: left;">
                                                    <img src="{{ asset('/image/blanco100.png') }}" style="width: 20px;
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
                                                display: inherit;">
                                                    Resaltado
                                                </span>
                                                <div class="clearfix"></div>
    
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div> 
                        <div class="col-md-6 col-12">
                            <textarea id="note" name="note" class="form-control" aria-label="With textarea" style="
                                @if (is_null($question->class_note))
                                    display:none;
                                @endif
                                    height: 100px;">{{$question->note}}</textarea>

                        </div>
                        <button class="btn btn-primary shadow-2 mb-4 mt-4">Registrar</button>
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

    <!-- form-picker-custom Js -->
    <script src="{{ asset('/assets/js/pages/form-masking-custom.js') }}"></script>

    <script type="text/javascript">  
        $("input:radio[name=gridRadios]").change(function(evt){
            var kind = $(this).val();
            if(kind != 'none'){
                document.getElementById('note').style.display ='block';
            }else{
                document.getElementById('note').style.display ='none';
            }
        });
        var y = 1;
        $(document).ready(function() {
            $(".hours").inputmask({
                mask: "99:99"
            });
            var kind = $("#kind").val();
            if(kind == 'texto'){
                document.getElementById('answers').style.display ='none';
                $(".answer").prop('required',false);
            }else{
                document.getElementById('answers').style.display = 'block';
                $(".answer").prop('required',true);
            }
        });
        
        document.getElementById("plus").addEventListener("click", function(event){
            event.preventDefault();  
            var input=$('<div class="col-md col-md-12 float-left new'+y+'"><div class="form-group"><div class="input-group"> <input name="answers[]" type="hidden" value="answer'+y+'"><input name="answer'+y+'" type="text" class="form-control" placeholder="Respuesta" required><span class="input-group-append"><button id="new'+y+'" class="btn btn-danger delete" type="button">X</button></span><div class="input-group"><div class="col-md-6 p-0"><label class="cr">Costo</label><input name="answer'+y+'cost" type="text" class="form-control autonumber" data-a-sign="$" placeholder="Costo"></div><div class="col-md-6 p-0"><label class="cr">Costo doctor</label><input name="answer'+y+'costDoctor" type="text" class="form-control autonumber" data-a-sign="$" placeholder="Costo doctors"></div><div class="input-group"><input name="answer'+y+'study_time" type="text" class="form-control hours" data-mask="99:99" placeholder="Tiempo estudio" pattern="[0-9]{2}:[0-9]{2}"> <input name="answer'+y+'preparation_time" type="text" class="form-control hours" data-mask="99:99" placeholder="Tiempo de preparación" pattern="[0-9]{2}:[0-9]{2}"> <input name="answer'+y+'exit_time" type="text" class="form-control hours" data-mask="99:99" placeholder="Tiempo de salida del paciente" pattern="[0-9]{2}:[0-9]{2}"></div></div></div></div>');
            $('#myList').append(input);
            $( '#new'+y ).click(function(event) {
                event.preventDefault();
                var id = $(this).attr("id");
                $( '.'+id ).remove();
            });
            $('.autonumber').autoNumeric('init');
            $(".hours").inputmask({
                mask: "99:99"
            });
            y++;
        });

        $( ".delete" ).click(function(event){
            event.preventDefault();  
            var id = $(this).attr("id");
            $( '.'+id ).remove();
        });

        $("#dependencia").change(function(evt){
            if ($('#dependencia').is(':checked')) {
                $( "#questions" ).removeClass( "d-none" )
            }else{
                $( "#questions" ).addClass( "d-none" )
            }
        });

        $("#kind").change(function(evt){
            var kind = $(this).val();
            if(kind == 'texto'){
                document.getElementById('answers').style.display ='none';
                $(".answer").prop('required',false);
                $( "#dependencia" ).prop( "disabled", false );
                if ($('#dependencia').is(':checked')) {
                    $( "#questions" ).removeClass( "d-none" )
                }else{
                    $( "#questions" ).addClass( "d-none" )
                }
            }else{
                document.getElementById('answers').style.display = 'block';
                $(".answer").prop('required',true);
                $( "#dependencia" ).prop( "disabled", true );
                $( "#questions" ).addClass( "d-none" )
            }
        });
    </script>

@endsection
