@extends('layouts.layoutDr')
@section('title','Mis estudios')
@section('leve','setting')
@section('subleve','Estudios')
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
    <div class="col-sm-12">
        <div class="card" style="border-radius: 25px">
            <div class="card-block text-center">
                <div class="row">
                    <h3 class="col-12">
                        DATOS DEL PACIENTE
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
                                de {{strtoupper($months[strftime("%m",strtotime($study->birthday))])}}
                                {{strftime("%Y",strtotime($study->birthday))}}
                            </h4>
                            <h4 class="col-12">Edad: {{$study->edad()  + 0}} años
                            </h4>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-block text-center">
                <div class="row">
                    <h3 class="col-12">
                        SUS ESTUDIOS
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
                        <h4 class="col-12">
                            <h4 class="mb-3">
                                <strong>Cita:</strong>
                                @if (isset($study->appointment))
                                    {{$weekMap[strftime("%w",strtotime($study->appointment->date))]}}
                                    Para el {{strftime("%d",strtotime($study->appointment->date))}}
                                    de {{strtoupper($months[strftime("%m",strtotime($study->appointment->date))])}}
                                    del {{strftime("%Y",strtotime($study->appointment->date))}}
                                     -
                                    a las {{$study->appointment->time}} hrs.
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
                                        <li>
                                            {{$answer}}
                                        </li>
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
                            <strong>Notas adicionales:</strong> 
                            <h4 class="col-12">
                                {!! nl2br($study->observations) !!}
                            </h4>
                        </h4>
                        @if ($study->status === 'Enviado' OR $study->status === 'Realizado')
                        <h4 class="mb-3">
                            <strong>Observaciones Radiologo:</strong> 
                            <h4 class="col-12">
                                {!! nl2br($study->obs_rad ?? 'Sin observaciones de Radiología') !!}
                            </h4>
                        </h4>
                        <h4 class="mb-3">
                            <strong>Observaciones Recepción:</strong> 
                            <h4 class="col-12">
                                {!! nl2br($study->obs_recep ?? 'Sin observaciones de Recepción') !!}
                            </h4>
                        </h4>
                        @endif
                        <h4 class="mb-3">
                            <strong>Tiempo de estudio:</strong> 
                            <h4 class="col-12">
                                {{$study->duration}}
                            </h4>
                        </h4>
                        <h4 class="mb-3">
                            <strong>Total:</strong> 
                            <h4 class="col-12">
                                {{sprintf('$ %s', number_format($study->total, 2)) }} MXN.
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
                                @if ($study->tax != null)
                                    <li>{{$study->tax}} - {{$study->TAX->regimen}}</li>
                                @endif
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
                <a href="{{route('Misestudios')}}">
                    <button type="button" class="btn btn-rounded btn-new">Volver</button>
                </a>
            </div>
        </div>
    </div>
@endsection