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
                                {{$study->doctor->alias ?? 'Alias no disponible'}}
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
                            @if (!is_null($study->sae))
                                <h4 class="mb-3">
                                    <strong>Folio SAE:</strong> {{$study->sae}}
                                </h4>
                            @endif
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
                            <strong>Observaciones adicionales:</strong> 
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
                        
                        @if (!is_null($study->detail))
                            <h4 class="col-12">
                                {!! nl2br($study->detail) !!}
                            </h4>
                        @endif
                    </div>
                </div>
            </div>
            @if ( $study->status == "Caja" || $study->status == "Pagado" || $study->status == "Empezado" || $study->status == "Realizado" || $study->status == "Enviado")
                <div id="modalChange" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalChangeTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal{{$study->id}}Title">Datos de Factura:</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body text-center">
                                <form class="col-12" id="formulario" method="POST" action="{{ route('addInvoiceRec', $study->id) }}">
                                    @csrf
                                    {{ method_field('PUT') }}
                                    <div style="">                                
                                        <div class="input-group mb-3">
                                            <div class="form-group col-12 p-0 mb-0 text-left">
                                                <label class="form-label">RFC</label>
                                                <input id="rfc" class="form-control text-uppercase {{ $errors->has('rfc') ? ' is-invalid' : '' }}" placeholder="RFC" type="text" name="rfc" value="{{ $study->rfc,old('rfc') }}" required>
                                                @if ($errors->has('rfc'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('rfc') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="form-group col-12 p-0 mb-0 text-left">
                                                <label class="form-label">Razón Social</label>
                                                <input id="razon" class="form-control text-uppercase {{ $errors->has('razon') ? ' is-invalid' : '' }}" placeholder="Razón social" type="text" name="razon" value="{{ $study->company_name,old('razon') }}" required>
                                                @if ($errors->has('razon'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('razon') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="form-group col-12 p-0 mb-0 text-left">
                                                <label class="form-label">Código Postal</label>
                                                <input type="text" class="form-control" id="cp" name="cp" placeholder="CÓDIGO POSTAL" value="{{ $study->cp,old('cp') }}" required>
                                                @if ($errors->has('cp'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('cp') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="form-group col-12 p-0 mb-0 text-left">
                                                <label class="form-label">CFDI</label>
                                                <select class="form-control {{ $errors->has('cfdi') ? ' is-invalid' : '' }}" id="cfdi" name="cfdi" required>
                                                    <option value="" selected disabled>Selecciona una opcion</option>
                                                    @foreach ($cfdis as $cfdi)
                                                        <option value="{{$cfdi->key_cfdi}}" 
                                                        @if ($cfdi->key_cfdi == $study->CFDI )
                                                            selected
                                                        @endif
                                                            >{{$cfdi->key_cfdi}} - {{$cfdi->cfdi}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('cfdi'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('cfdi') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>  
                                        <div class="input-group mb-3">
                                            <div class="form-group col-12 p-0 mb-0 text-left">
                                                <label class="form-label">Regimen fiscal</label>
                                                <select class="form-control {{ $errors->has('tax') ? ' is-invalid' : '' }}" id="tax" name="tax" required>
                                                    <option value="" selected disabled>Selecciona una opcion</option>
                                                    @foreach ($taxes as $tax)
                                                        <option value="{{$tax->key_regimen}}" 
                                                        @if ($tax->key_regimen == $study->tax )
                                                            selected
                                                        @endif
                                                            >{{$tax->key_regimen}} - {{$tax->regimen}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('tax'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('tax') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>  
                                    </div>
                                                            
                                    <button  type="submit" class="btn btn-primary shadow-2 mb-1 mt-2">
                                       Guardar
                                    </button>
                                </form>
                            </div>
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
                    <button  id="save" type="submit" class="btn btn-primary shadow-2 mb-1 mt-2"  data-toggle="modal" data-target="#modalChange">
                        @if (is_null($study->rfc))
                            Solicita factura
                        @else
                            EDITAR DATOS DE FACTURACIÓN
                        @endif
                    </button>
                </div>
            @endif
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
   
            @if ( $study->status == "Llegada")
                <div class="card-block text-center">
                    <div class="col-12 row">
                        <h3 class="col-12">
                            ¿Requiere factura?
                        </h3>
                        <div class="form-group">
                            <div class="switch d-inline m-r-10">
                                <input type="checkbox" id="switch-1"
                                @if (!is_null($study->rfc))
                                    checked
                                @endif
                                >
                                <label for="switch-1" class="cr"></label>
                            </div>
                            <label>Solicitar factura</label>
                        </div>
                    </div>
                    <div class="col-12 row">
                        <form class="col-12 
                        @if (is_null($study->rfc))
                            d-none
                        @endif
                        " id="formulario" method="POST" action="{{ route('addInvoiceRec', $study->id) }}">
                            @csrf
                            {{ method_field('PUT') }}
                            <div style="">                                
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">RFC</label>
                                        <input id="rfc" class="form-control text-uppercase {{ $errors->has('rfc') ? ' is-invalid' : '' }}" placeholder="RFC" type="text" name="rfc" value="{{ $study->rfc,old('rfc') }}" required>
                                        @if ($errors->has('rfc'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('rfc') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">Razón Social</label>
                                        <input id="razon" class="form-control text-uppercase {{ $errors->has('razon') ? ' is-invalid' : '' }}" placeholder="Razón social" type="text" name="razon" value="{{ $study->company_name,old('razon') }}" required>
                                        @if ($errors->has('razon'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('razon') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">Código Postal</label>
                                        <input type="text" class="form-control" id="cp" name="cp" placeholder="CÓDIGO POSTAL" value="{{ $study->cp,old('cp') }}" required>
                                        @if ($errors->has('cp'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cp') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">CFDI</label>
                                        <select class="form-control {{ $errors->has('cfdi') ? ' is-invalid' : '' }}" id="cfdi" name="cfdi" required>
                                            <option value="" selected disabled>Selecciona una opcion</option>
                                            @foreach ($cfdis as $cfdi)
                                                <option value="{{$cfdi->key_cfdi}}" 
                                                @if ($cfdi->key_cfdi == $study->CFDI )
                                                    selected
                                                @endif
                                                    >{{$cfdi->key_cfdi}} - {{$cfdi->cfdi}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('cfdi'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cfdi') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>  
                                <div class="input-group mb-3">
                                    <div class="form-group col-12 p-0 mb-0 text-left">
                                        <label class="form-label">Regimen fiscal</label>
                                        <select class="form-control {{ $errors->has('tax') ? ' is-invalid' : '' }}" id="tax" name="tax" required>
                                            <option value="" selected disabled>Selecciona una opcion</option>
                                            @foreach ($taxes as $tax)
                                                <option value="{{$tax->key_regimen}}" 
                                                @if ($tax->key_regimen == $study->tax )
                                                    selected
                                                @endif
                                                    >{{$tax->key_regimen}} - {{$tax->regimen}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('tax'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tax') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>  
                            </div>
                                                    
                            <button  id="save" type="submit" class="btn btn-primary shadow-2 mb-1 mt-2">
                                @if (is_null($study->rfc))
                                    Solicita factura
                                @else
                                    EDITAR DATOS DE FACTURACIÓN
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
                @if ($discounts->count() > 0 && strpos($study->observations, 'El doctor hizo un descuento del') === false)
                    <div class="card-block text-center">
                        <div class="col-12 row">
                            <h3 class="col-12">
                                Descuento -
                            </h3>
                            <div class="form-group col-md-6 mb-0 text-left">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="pay0" value="0" name="discount" class="custom-control-input" checked="">
                                    <label class="custom-control-label" for="pay0">No aplicar descuento</label>
                                </div>
                                @foreach ($discounts as $discount)
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="pay{{$discount->id}}" value="{{$discount->id}}" name="discount" class="custom-control-input"
                                        @if ($study->id_discount ==  $discount->id)
                                            checked=""
                                        @endif>
                                        <label class="custom-control-label" for="pay{{$discount->id}}">{{$discount->type}} ({{$discount->percentage}}%)</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if ( $study->status == "Llegada")
                <div class="text-center">
                    <a href="{{route('editRecepcion',['id' => $study->id])}}">
                        <button type="button" class="btn btn-rounded btn-warning">EDITAR DATOS PERSONALES</button>
                    </a>
                </div>
            @endif
            <div class="card-block text-center">
                <a href="{{route('historialRec',['id' => $study->id])}}">
                    <button type="button" class="btn btn-rounded btn-success">VER HISTORIAL</button>
                </a>
                @if ( $study->status == "Llegada")
                    <button id="changeStatus" type="button" class="btn btn-rounded btn-primary">PASAR A CAJA</button>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('css')
    <!-- Input mask Js -->
    <script src="{{ asset('/assets/plugins/inputmask/js/inputmask.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/inputmask/js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/inputmask/js/autoNumeric.js') }}"></script>

<!-- form-advance custom js -->
<script src="{{ asset('/assets/js/pages/form-advance-custom.js') }}"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    $("#cp").inputmask({
        mask: "99999"
    });
    $(document).ready(function() { 
        
        $("#switch-1").change(function(evt){
            if ($(this).is(':checked')) {
                $( "#formulario" ).removeClass( "d-none" )
            }else{
                $( "#formulario" ).addClass( "d-none" )
            }
        });
        document.getElementById("changeStatus").addEventListener("click", function(event){
            var discount = $('input:radio[name=discount]:checked').val();

            $.ajax({
                type: "POST",
                url: "{{ url('/cashier') }}",
                data: {"id": '{{$study->qr}}' ,_token : '{{ csrf_token() }}',"discount": discount},
                success: function (flag) {
                    if(flag){
                        swal("Éxito","El paciente pasó a caja", "success")
                        .then((value) => {
                            window.location = "{{ route('recepcion') }}"
                        });
                    }else{
                        swal("Error","A ocurrido un error al realizar el paso a caja", "error")
                        .then((value) => {
                            window.location.reload();
                        });
                    }
                }
            });
            
        });
    });
</script>
@if ($vA)  
    <script type="text/javascript">
        $(document).ready(function() {
            swal("Estudio actualizado","El estudio se ha actualizado correctamente", "success");
        });
    </script>
@endif
@endsection



