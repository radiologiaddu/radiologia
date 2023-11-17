@extends('layouts.layoutHost')
@section('title','Mis estudios')
@section('leve','Nuevos')
@section('breadcrumb')
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
@endsection
@section('content')
   <style type="text/css">
        .input-group{
            background-color: #ffffff;
        }
    </style>
    <div class="col-sm-12">
        <div class="card" style="border-radius: 25px">
            <div class="card-block text-center">
                <div class="col-12 row">
                    <h3 class="col-12">
                        Datos Paciente
                    </h3>
                    <div class="text-justify">
                        <h4 class="col-12">
                            {{$study->patient_name}} {{$study->paternal_surname}} {{$study->maternal_surname}}
                        </h4>
                        <h4 class="col-12">
                            {{$study->patient_email}}
                        </h4>
                        <h4 class="col-12">
                            {{$study->patient_phone}}
                        </h4>
                        @if (isset($study->birthday)) 
                            <h4 class="col-12">
                                {{strftime("%d",strtotime($study->birthday))}}
                                {{strtoupper($months[strftime("%m",strtotime($study->birthday))])}}
                                {{strftime("%Y",strtotime($study->birthday))}}
                            </h4>
                            <h4 class="col-12">Edad: {{$study->edad()  + 0}} Años
                            </h4>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="col-12 row">
                    <h3 class="col-12">
                        Doctor
                    </h3>
                    <div class="text-justify">
                        @if ($study->doctor_id == 0)
                            <h4 class="col-12">
                                {{$study->doctor_name}}
                            </h4>
                        @else
                            <h4 class="col-12">
                                {{$study->doctor->alias}}
                            </h4>
                            <h4 class="col-12">
                                {{$study->doctor->user->name}} {{$study->doctor->paternalSurname}} {{$study->doctor->maternalSurname}}
                            </h4>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="col-12 row">
                    <h3 class="col-12">
                        Datos estudios
                    </h3>
                    <div class="text-justify">
                        <h4 class="col-12">
                            <h4 class="mb-3">
                                <strong>Folio:</strong> 
                                @if ($study->internal == 1)
                                    R{{sprintf('%06d',$study->folio)}}
                                @else
                                    D{{sprintf('%06d',$study->folio)}}
                                @endif
                            </h4>
                        </h4>
                        @if (!is_null($study->referral))
                            <h4 class="mb-3">
                                <strong>REFERIDOR:</strong> {{$study->referral}}
                            </h4>
                        @endif
                        <h4 class="col-12">
                            <h4 class="mb-3">
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
                            </h4>
                        </h4>
                        @foreach ($arrayStudies as $itemStudy)
                            <h4 class="mt-3 mb-3">
                                {{$itemStudy->title}}
                                @foreach ($itemStudy->questions as $question)
                                    <h5 class="mb-3">
                                        {{$question->question}}
                                    </h5>
                                    @foreach ($question->answers as $answer)
                                        <h5 class="mb-3" style="color:rgb(110,123,222);font-weight: 900;">
                                            <li>
                                                {{$answer}}
                                            </li>
                                        </h5>
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
                            </h4>
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
                        <h4 class="mb-3">
                            <strong>Observaciones adicionales:</strong> 
                            <h4 class="col-12">
                                {!! nl2br($study->observations) !!}
                            </h4>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="col-12 row">
                    <h3 class="col-12">
                        Factura
                    </h3>
                    <div class="text-justify">
                        @if (!is_null($study->rfc))
                            <h4 class="col-12">
                                RFC:
                            </h4>
                            <h5 class="col-12">
                                <li>{{$study->rfc}}</li>
                            </h5>
                            <h4 class="col-12">
                                Razón Social
                            </h4>
                            <h5 class="col-12">
                                <li>{{$study->company_name}}</li>
                            </h5>
                            <h4 class="col-12">
                                Regimen fiscal
                            </h4>
                            <h5 class="col-12">
                                <li>{{$study->tax}}</li>
                            </h5>
                            <h4 class="col-12">
                                CFDI
                            </h4>    
                            <h5 class="col-12">
                                <li>{{$study->CFDI}} - {{$study->cfdi->cfdi}}</li>
                            </h5>  
                            <h4 class="col-12">
                                Código postal
                            </h4>    
                            <h5 class="col-12">
                                <li>{{$study->cp}}</li>
                            </h5>                      
                        @else  
                            Factura no solicitada
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="col-12 row">
                    <div class="text-justify">   
                        @if (is_null($study->discount))
                            @php
                                $total = $study->total;
                            @endphp
                        @else
                            <h4 class="mb-3">
                                <strong>Subtotal:</strong> 
                                <h4 class="col-12">
                                    {{sprintf('$ %s', number_format($study->total, 2)) }}
                                </h4>
                            </h4>

                            <h4 class="mb-3">
                                <strong>Descuento:</strong> 
                                <h4 class="col-12">
                                    {{$study->discount}}%
                                    @if (isset($study->descuento))
                                        {{$study->descuento->type}}
                                    @endif
                                </h4>
                                @php
                                    $total = $study->total - (($study->total * $study->discount) / 100);
                                @endphp
                            </h4>
                        @endif
                        <h4 class="mb-3">
                            <strong>Total:</strong> 
                            <h4 class="col-12">
                                {{sprintf('$ %s', number_format($total, 2)) }}
                            </h4>
                        </h4>
                        @if (!is_null($study->payment))
                        <h4 class="mb-3">

                            <strong>Método de pago:</strong> 
                            <h4 class="col-12">
                                {{$study->payment}}
                            </h4>
                        </h4>
                        @endif
                    </div>
                </div>
            </div>
            @if ($study->status == "Pagado")
                <div class="card-block text-center">
                    <h4 class="mb-3">
                        <strong>Asigna un radiologo para el estudio:</strong> 
                    </h4>
                    <select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" id="radiologo" name="radiologo" required>
                        <option value="" selected disabled>Selecciona un radiologo</option>
                        @foreach ($radiologists as $radiologist)
                            <option value="{{$radiologist->id}}">{{$radiologist->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="card-block text-center">
                    <a href="{{route('historialCoo',['id' => $study->id])}}">
                        <button type="button" class="btn btn-rounded btn-success">VER HISTORIAL</button>
                    </a>
                    <button id="changeStatus" type="button" class="btn btn-rounded btn-primary">EMPEZAR</button>
                </div>
            @else
                <div class="card-block text-center">
                    <a href="{{route('historialCoo',['id' => $study->id])}}">
                        <button type="button" class="btn btn-rounded btn-success">VER HISTORIAL</button>
                    </a>
                    @if ($study->status == "Empezado")
                     <button id="finish" type="button" class="btn btn-rounded btn-danger">TERMINAR ESTUDIO</button>
                    @endif
                </div>
            @endif

        </div>
    </div>
@endsection
@section('css')


<!-- form-advance custom js -->
<script src="{{ asset('/assets/js/pages/form-advance-custom.js') }}"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() { 
        document.getElementById("changeStatus").addEventListener("click", function(event){
            var radiologo = $("#radiologo").val();
            if(radiologo === null){
                swal("Error","Debes seleccionar un radiologo", "error")
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{ url('/start') }}",
                    data: {"id": '{{$study->qr}}' ,_token : '{{ csrf_token() }}',"radiologo": radiologo},
                    success: function (flag) {
                        if(flag){
                            swal("Exito","Estudio asignado correctamente", "success")
                            .then((value) => {
                                window.location = "{{ route('caja') }}"
                            });
                        }else{
                            swal("Error","A ocurrido un error al asiganr el estudio", "error")
                            .then((value) => {
                                window.location.reload();
                            });
                        }
                    }
                });
            }
           
        });
    });
    $(document).ready(function() { 
        document.getElementById("finish").addEventListener("click", function(event){
                $.ajax({
                    type: "POST",
                    url: "{{ url('/finish') }}",
                    data: {"id": '{{$study->qr}}' ,_token : '{{ csrf_token() }}'},
                    success: function (flag) {
                        if(flag){
                            swal("Exito","Estudio finalizo correctamente", "success")
                            .then((value) => {
                                window.location = "{{ route('coordinador') }}"
                            });
                        }else{
                            swal("Error","A ocurrido un error al finalizar el estudio", "error")
                            .then((value) => {
                                window.location.reload();
                            });
                        }
                    }
                });
           
        });
    });
</script>
@endsection



