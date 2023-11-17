@extends('layouts.layoutHost')
@section('title','Nuevo estudio')
@section('leve','setting')
@section('subleve','Estudios')
@section('breadcrumb')

@endsection
@section('content')
<link rel="stylesheet" href="{{ asset('/css/newStudy.css') }}">
<!-- material datetimepicker css -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
<!-- Bootstrap datetimepicker css -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/fonts/material/css/materialdesignicons.min.css') }}">
<!-- select2 css -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}">

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
<div class="card-blue">
    <div class="card-header">
        <h4>RADIOLOGÍA</h4>
    </div>
    <div class="card-header card-subheader">
        <h4>GENERANDO NUEVA ORDEN</h4>
    </div>
</div>
<div class="col-sm-12">
    <div class="card full">
        <div class="card-header">
            <h4>¿QUÉ ESTUDIO MANDARÁS REALIZAR?</h4>
        </div>
    </div>
    <form id="formulario" class="form-horizontal style-form col-sm-12" method="POST" action="{{route('addStudyRec')}}">
        {{ csrf_field() }}
        <div class="card-transparent tab-content" id="pills-tabContent">
            <div class="card-block tab-pane fade show active" id="pills-studies" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="title-block">
                    <h5>Selecciona la categoría de estudio:</h5>
                </div>
                <div class="input-group mb-3">
                    <div class="form-group col-12 p-0 mb-0 text-left">
                        <input name="arrayType[]" type="hidden" value="type">
                        <select class="required form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" id="type" name="type" required>
                            <option value="" selected disabled>Mostrar opciones:</option>
                            @foreach ($types as $type)           
                                <option ok="true" value="{{ $type->id }}">
                                    {{ $type->type }}
                                </option>   
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-group mb-3" id="question">
                    
                </div>
                <div id="newStudy">
                    
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-12 col-sm-12 mt-2">
                    <button type="button" id="plus" class="btn btn-round btn-success float-right">
                        <i class="fa fa-plus"></i> ¿Otro estudio?
                    </button>
                </div>
                <div class="clearfix"></div>
                <div class="mt-2">
                    <button type="button" id="btn-next-studies" class="btn btn-rounded btn-new pills-patient" >Continuar</button>
                </div>
            </div>
            <div class="card-block tab-pane fade" id="pills-patient" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="title-block">
                    <h5>REFERIDOR</h5>
                </div>
                <div class="row">
                    <div class="col-12">
                        <select class="js-example-basic-single form-control {{ $errors->has('referral') ? ' is-invalid' : '' }}" id="referral" name="referral">
                            <option value="" selected disabled>Selecciona el referidor</option>
                            @foreach ($referrals as $referral)
                                <option value="{{$referral->name}}">{{$referral->name}}</option>
                            @endforeach
                        </select>                                    
                    </div>
                </div>
                <div class="title-block">
                    <h5>Datos del doctor:</h5>
                    <h6 class="mt-5 mb-3"><span style="color:red">*</span> Campo obligatorio</h6>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label"><span style="color:red">*</span> Nombre (s) del doctor:</label>
                            <div class="col-xl-12 mb-5">
                                <select id="doctor_name" class="form-control js-example-tags col-sm-12" multiple="multiple" name="doctor_name" required>
                                    @foreach ($doctors as $doctor)
                                        @if (!is_null($doctor->doctor))
                                            <option value="{{$doctor->id}}">{{$doctor->name}} {{$doctor->doctor->paternalSurname}} {{$doctor->doctor->maternalSurname}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div id="input-doctor-email" class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label"> Correo electrónico del doctor:</label>
                                    <input id="doctor_email" class="form-control" placeholder="Ej: rmarialm@gmail.com" type="email" name="doctor_email" >
                                </div>        
                            </div>
                        </div>        
                    </div>
                </div>
                <div class="title-block">
                    <h5>Datos de tu paciente:</h5>
                    <h6 class="mt-5 mb-3"><span style="color:red">*</span> Campo obligatorio</h6>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label"><span style="color:red">*</span> Nombre (s) de tu paciente:</label>
                            <input style="text-transform:uppercase;" id="patient_name" class="form-control" placeholder="Ej. Rosa María" type="text" name="patient_name" required>
                        </div>        
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label"><span style="color:red">*</span> Primer apellido de tu paciente:</label>
                            <input style="text-transform:uppercase;" id="paternal_surname" class="form-control" placeholder="Ej. López" type="text" name="paternal_surname" required>
                        </div>        
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Segundo apellido de tu paciente:</label>
                            <input style="text-transform:uppercase;" id="maternal_surname" class="form-control" placeholder="Ej. Martínez" type="text" name="maternal_surname">
                        </div>        
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">¿SU FECHA DE NACIMIENTO?</label>
                            @php
                            $dateBirthday = [
                                0 => $year,
                                1 => 01,
                                2 => 01
                            ];
                        @endphp  
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label"> <span style="color:red">*</span> DÍA</label>
                                <select class="js-example-basic-single form-control {{ $errors->has('day') ? ' is-invalid' : '' }}" id="day" name="day" required>
                                    <option value="" selected disabled>Selecciona el día de su nacimiento</option>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{sprintf('%02d',$i)}}" 
                                            @if (sprintf('%02d',$i) == $dateBirthday[2] )
                                                selected
                                            @endif
                                        >{{sprintf('%02d',$i)}}</option>
                                    @endfor
                                </select>                                    
                            </div>
                            <div class="col-12">
                                <label class="form-label"><span style="color:red">*</span> MES</label>
                                <select class="js-example-basic-single form-control {{ $errors->has('month') ? ' is-invalid' : '' }}" id="month" name="month" required>
                                    <option value="" selected disabled>Selecciona el mes de su nacimiento</option>
                                    @for ($j = 1; $j <= 12; $j++)
                                        <option value="{{sprintf('%02d',$j)}}" 
                                            @if (sprintf('%02d',$j) == $dateBirthday[1] )
                                                selected
                                            @endif
                                        >{{$months[sprintf('%02d',$j)]}}</option>
                                    @endfor
                                </select>                                    
                            </div>
                            <div class="col-12">
                                <label class="form-label"><span style="color:red">*</span> AÑO</label>
                                <select class="js-example-basic-single form-control {{ $errors->has('year') ? ' is-invalid' : '' }}" id="year" name="year" required>
                                    <option value="" selected disabled>Selecciona el año de su nacimiento</option>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label"><span style="color:red">*</span> Correo electrónico de tu paciente:</label>
                            <input style="text-transform:lowercase;" id="patient_email" class="form-control" placeholder="Ej: rmarialm@gmail.com" type="email" name="patient_email" required>
                        </div>        
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label"><span style="color:red">*</span> Número de contacto de tu paciente:</label>
                            <input type="text"  id="patient_phone" name="patient_phone" class="form-control mob_noPersonal {{ $errors->has('patient_phone') ? ' is-invalid' : '' }}" data-mask="999-999-9999" value="{{ old('patient_phone') }}" placeholder="999-999-9999" required>            
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Observaciones adicionales:</label>
                        <textarea id="note" name="note" class="form-control" placeholder="** Agrega un comentario sólo si es necesario, de lo contrario, dejar en blanco." aria-label="With textarea" style="height: 100px;"></textarea>
                    </div>   
                </div>
                <br>
                <br>
                <div class="row mt-2">
                    <div class="col-6 text-right">
                        <button type="button" class="btn btn-rounded btn-new pills-studies">Regresar</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-rounded btn-new pills-review">Siguiente</button>
                    </div>
                </div>
            </div>
            <div class="card-block tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="title-block">
                    <h5>Resumen de la orden:</h5>
                </div>
                <div> 
                    <div class="title-block">
                        <h6>REFERIDOR</h6>
                    </div>
                    <div class="p-divView">
                        <p id="p-referidor">
                        </p>     
                    </div>
                    <div class="title-block">
                        <h6>Datos del doctor</h6>
                    </div>
                    <div class="p-divView">
                        <strong class="text-dark">
                            Nombre (s): 
                        </strong>
                        <p id="dr-name">
                        </p>
                        <strong class="text-dark dr-email">
                            Correo electrónico: 
                        </strong>
                        <p class="dr-email" id="dr-email"></p>
                    </div>
                    <div class="title-block">
                        <h6>Datos del paciente</h6>
                    </div>
                    <div class="p-divView">
                        <strong class="text-dark">
                            Nombre (s): 
                        </strong>
                        <p style="text-transform:uppercase;" id="p-name">
                        </p>
                        <strong class="text-dark">
                            Primer apellido:
                        </strong>
                        <p style="text-transform:uppercase;" id="p-psurname">
                        </p>
                        <strong class="text-dark">
                            Segundo apellido: 
                        </strong>
                        <p style="text-transform:uppercase;" id="p-msurname">
                        </p>
                        <strong class="text-dark">
                            Fecha de nacimiento: 
                        </strong>
                        <p id="p-birthday">
                            <span id="birthday-day"></span> de <span id="birthday-month"></span> de <span id="birthday-year"></span>
                        </p>
                        <strong class="text-dark">
                            Correo electrónico: 
                        </strong>
                        <p style="text-transform:lowercase;" id="p-email"></p>
                        <strong class="text-dark">
                            Teléfono: 
                        </strong>
                        <p id="p-phone"></p>
                    </div>
                </div>
                <div> 
                    <div class="title-block">
                        <h6>Estudios a realizar:</h6>
                    </div>
                    <div id="divView">
                        <div id="reView">
    
                        </div>
                    </div>
                    <br>
                    <div class="title-block">
                        <h6>NOTA:</h6>
                    </div>
                    <div class="p-divView"> 
                        <p id="p-note"></p>
                    </div>
                    <div class="title-block">
                        <h6 id="labelDuration"></h6>
                    </div>
                    <div class="p-divView"> 
                        <h4 id="p-Duration"></h4>
                        <input id="durationInput" name="duration" type="hidden">
                    </div>
                    <div class="title-block">
                        <h6>EL TOTAL DE SUS ESTUDIOS SERÁ DE:</h6>
                    </div>
                    <div class="p-divView"> 
                        <h4 id="p-Cost"> MXN</h4>
                        <input id="totalInput" name="total" type="hidden">
                    </div>
                </div>
                <br>
                <div>
                    <div class="text-center title-block mb-3">
                        <h3>¿Es correcta tu orden?</h3>
                        <h6>Verifica antes de continuar</h6>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-rounded btn-new pills-patient">Regresar</button>
                        </div>
                        <div class="col-6">
                            <button id="save" type="button" class="btn btn-rounded btn-new">Confirmar</button>
                        </div>
                    </div>
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

    <!-- material datetimepicker Js -->
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="{{ asset('/assets/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <!-- form-picker-custom Js -->
    <script src="{{ asset('/assets/js/pages/form-picker-custom.js') }}"></script>
    <script src="{{ asset('/assets/js/pages/form-masking-custom.js') }}"></script>

    <!-- select2 Js -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>   
    <!-- multi-select Js -->
    <script src="{{ asset('/assets/plugins/multi-select/js/jquery.quicksearch.js') }}"></script>   
    <script src="{{ asset('/assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script>   

    <!-- form-select-custom Js -->
    <script src="{{ asset('/assets/js/pages/form-select-custom.js') }}"></script>   

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(\Session::has('success'))
        <script>
        Swal.fire(
        'Nuevo estudio generado',
        'Se ha enviado un correo con código QR al correo del paciente.',
        'success'
        )
        </script>
    @endif
    <script type="text/javascript">
        $("#birthday-day").html($("#day").val());
        $("#birthday-month").html($("#month option:selected").text());
        $("#birthday-year").html($("#year").val());

    var x = 1;
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
    /*
    $('.required').change(function() {
        var empty_flds = 0;
        $(".required").each(function() {
            if(!$.trim($(this).val())) {
                empty_flds++;
            }    
        });
        if (empty_flds) { 
            $("#btn-next-studies").show();
        } else {
            $("#btn-next-studies").hide();
        }
    });*/
  
    $("#type").change(function(evt){
        var value = $( this ).val();
        var id = $( this ).attr('id');
        $.ajax({
            type: "POST",
            url: "{{ url('/questionRec') }}",
            data: {"id":value, "idElement":"type" , _token : '{{ csrf_token() }}'},
            success: function (opciones) {
                $("#question").html(opciones);
                var typeText = $( "#type option:selected" ).text();
                $('#reView').html('<p id="typeView" ><strong class="title-Review"><i class="fas fa-play-circle"></i>'+typeText+'</strong></p>');  
                $(".titletype").each(function() {
                    $('#reView').append('<h6>'+$(this).html()+'</h6>'); 
                    var question=$('<div id="retype'+$(this).attr('id')+'"></div>');
                    $('#reView').append(question);
                    //console.log($(this).html());
                    //console.log($(this).attr('id'));
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
                    var typeA =  $( this ).attr('type');
                    var nameA =  $( this ).attr('name').replace('[]', '');
                    var cost =  $( this ).attr('cost');
                    var study_time =  $( this ).attr('study_time');
                    var preparation_time =  $( this ).attr('preparation_time');
                    var exit_time =  $( this ).attr('exit_time');
                    if(typeA == "text"){
                        var answer = $( this ).val();
                        $( '#'+nameA ).remove();
                        $('#re'+nameA).append('<p class="col-12" id="'+nameA+'" >'+answer+'</p>');
                    }else if (typeA == "radio"){
                        var answer = $( "input[name='"+nameA+"']:checked" ).data('name');
                        if(cost > 0){
                            var locale = 'en-US';;
                            var options = {style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2};
                            var formatter = new Intl.NumberFormat(locale, options);
                            var labelCost = ' ('+formatter.format(cost)+')';
                        }else{
                            var labelCost = '';
                        }
                        $( '#'+nameA ).remove();
                        $('#re'+nameA).append('<p study_time="'+study_time+'" preparation_time="'+preparation_time+'" exit_time="'+exit_time+'" cost="'+cost+'" class="col-12 reviewTotal" id="'+nameA+'" >'+answer+labelCost+'</p>')
                    }else{
                        var idA = $( this ).attr('id');
                        if ($(this).is(':checked')) {
                            var answer = $( this ).next('label').text();
                            $('#re'+nameA).append('<p study_time="'+study_time+'" preparation_time="'+preparation_time+'" exit_time="'+exit_time+'" cost="'+cost+'" class="col-12 reviewTotal" id="re'+idA+'" >'+answer+'</p>')                        }else{
                            $( '#re'+idA ).remove();
                        }
                    }
                });
            }

        });
    });

    $( ".pills-patient" ).click(function() { 
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
        if(valid){
            $( "#pills-studies" ).removeClass( "show active" );
            $( "#pills-review" ).removeClass( "show active" );
            $( "#pills-patient" ).addClass( "show active" );
        }else{
            Swal.fire(
                'Formulario incompleto',
                'Debes llenar los campos',
            )
        }
    });

    $( ".pills-studies" ).click(function() {
        $( "#pills-review" ).removeClass( "show active" )
        $( "#pills-patient" ).removeClass( "show active" );
        $( "#pills-studies" ).addClass( "show active" );
    });

    $( ".pills-review" ).click(function() {
        var valid = true;
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
                var total = 0;
                var duration = '00:00';
                $.each($(".reviewTotal"), function (index, value) {
                    var cost = parseFloat($(value).attr('cost'))
                    total = total+cost;
                    if($(value).attr('study_time') != ""){
                        duration = addTimes(duration, $(value).attr('study_time'))
                    }
                    if($(value).attr('preparation_time') != ""){
                        duration = addTimes(duration, $(value).attr('preparation_time'))
                    }
                    if($(value).attr('exit_time') != ""){
                        duration = addTimes(duration, $(value).attr('exit_time'))
                    }
                });
                var locale = 'en-US';;
                var options = {style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2};
                var formatter = new Intl.NumberFormat(locale, options);
                var labelCost = formatter.format(total);
                $( "#p-Cost" ).html( labelCost )
                $( "#totalInput" ).val( total )
                if(duration == '00:00'){
                    $( "#p-Duration" ).html('')
                    $( "#labelDuration" ).html('')

                }else{
                    $( "#labelDuration" ).html('Tiempo de estudio: ')
                    $( "#p-Duration" ).html(duration )
                }
                $( "#durationInput" ).val( duration )
                        
                $( "#pills-studies" ).removeClass( "show active" );
                $( "#pills-patient" ).removeClass( "show active" );
                $( "#pills-review" ).addClass( "show active" );
            }else{
                Swal.fire(
                    'Formulario incorrecto',
                    'Los datos del paciente o doctor son incorrectos, revisa el formato',
                )
            }
        } 
        else{
            Swal.fire(
                'Formulario incompleto',
                'Debes llenar todos los campos',
            )
        }

        

    });

    
    
    $( "#save" ).click(function() {
        var valid = true;
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
                    'Los datos del paciente son incorrectos, revisa el formato',
                )
            }
        } 
        else{
            Swal.fire(
                'Formulario incompleto',
                'Debes llenar todos los campos',
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
                data: {"id":value, "idElement":id ,_token : '{{ csrf_token() }}'},
                success: function (opciones) {
                    $("#question"+id).html(opciones);
                    var typeText = $( "#"+id+" option:selected" ).text();
                    $('#reView'+id.replace('type', '')).html('<p id="typeView'+id.replace('type', '')+'" ><strong class="title-Review"><i class="fas fa-play-circle"></i>'+typeText+'</strong></p>'); 

                    $(".title"+id).each(function() {
                        $('#reView'+id.replace('type', '')).append('<h6>'+$(this).html()+'</h6>'); 
                        var question=$('<div id="re'+id+$(this).attr('id')+'"></div>');
                        $('#reView'+id.replace('type', '')).append(question);

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

                    $(".answer-input"+id).change(function(evt){
                        var typeA =  $( this ).attr('type');
                        var nameA =  $( this ).attr('name').replace('[]', '');
                        var idA = nameA.split("question")[0];
                        var cost =  $( this ).attr('cost');
                        var study_time =  $( this ).attr('study_time');
                        var preparation_time =  $( this ).attr('preparation_time');
                        var exit_time =  $( this ).attr('exit_time');
                        if(typeA == "text"){
                            var answer = $( this ).val();
                            $( '#'+nameA ).remove();
                            $('#re'+nameA).append('<p class="col-12" id="'+nameA+'" >'+answer+'</p>')
                        }else if (typeA == "radio"){
                            var answer = $( "input[name='"+nameA+"']:checked" ).data('name');
                            if(cost > 0){
                                var locale = 'en-US';;
                                var options = {style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2};
                                var formatter = new Intl.NumberFormat(locale, options);
                                var labelCost = ' ('+formatter.format(cost)+')';
                            }else{
                                var labelCost = '';
                            }
                            $( '#'+nameA ).remove();
                            $('#re'+nameA).append('<p cost="'+cost+'" class="col-12 reviewTotal" id="'+nameA+'" >'+answer+labelCost+'</p>')
                        }else{
                            var idA = $( this ).attr('id');
                        if ($(this).is(':checked')) {
                            var answer = $( this ).next('label').text();
                            $('#re'+nameA).append('<p study_time="'+study_time+'" preparation_time="'+preparation_time+'" exit_time="'+exit_time+'" cost="'+cost+'" class="col-12 reviewTotal" id="re'+idA+'" >'+answer+'</p>')
                        }else{
                            $( '#re'+idA ).remove();
                        }
                    }
                });
                }

            });
        });
        $( ".delete" ).click(function() {
            var id = $(this).attr("id");
            $( '#ne'+id ).remove();
            $('#reView'+id.replace('w', '')).remove();
        });
        x++;

        
    });

    //Llenado de vista previa
    var nameDoctor;
    $("#referral").change(function(evt){
        var value = $(this).val();
        $("#p-referidor").html(value);
    });
    $("#doctor_name").change(function(evt){
        
        if(nameDoctor != null){
            $.each(nameDoctor, function(i,e){
                $("#doctor_name option[value='" + e + "']").prop("selected", false);
            });
        }
        nameDoctor = $( "#doctor_name" ).val();
        if($("#doctor_name option:selected").attr("data-select2-tag")){
            $("#input-doctor-email").show();
            $(".dr-email").show();

        }else{
            $("#input-doctor-email").hide();
            $(".dr-email").hide();
        }
        var value = $( "#doctor_name option:selected" ).text();
        $("#dr-name").html(value);

    });

    $("#doctor_email").change(function(evt){
        var value = $(this).val();
        $("#dr-email").html(value);
    });

    $("#patient_name").change(function(evt){
        var value = $(this).val();
        $("#p-name").html(value);
    });
    $("#paternal_surname").change(function(evt){
        var value = $(this).val();
        $("#p-psurname").html(value);
    });
    $("#maternal_surname").change(function(evt){
        var value = $(this).val();
        $("#p-msurname").html(value);
    });
    $("#day").change(function(evt){
        var value = $(this).val();
        $("#birthday-day").html(value);
    });
    $("#month").change(function(evt){
        var value = $("#month option:selected").text();
        $("#birthday-month").html(value);
    });
    $("#year").change(function(evt){
        var value = $(this).val();
        $("#birthday-year").html(value);
    });
    
    $("#patient_email").change(function(evt){
        var value = $(this).val();
        $("#p-email").html(value);
    });
    $("#patient_phone").change(function(evt){
        var value = $(this).val();
        $("#p-phone").html(value);
    });
    $("#note").change(function(evt){
        var value = $(this).val();
        value=value.replace(/\n/g,"<br>");
        $("#p-note").html(value);
    });
</script>

@endsection
