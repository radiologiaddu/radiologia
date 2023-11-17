@extends('layouts.layout')
@section('title','Editar tipo de estudio')
@section('leve','setting')
@section('subleve','Estudios')
@section('breadcrumb')
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Editar tipo de estudio</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('types') }}">Tipos de estudios</a></li>
                    <li class="breadcrumb-item"><a href="#">Editar {{$type->type}}</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="card-block">
                <form method="POST" action="{{ route('updateType', $type->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Tipo de estudio</label>
                                <input id="typeStudie" class="form-control {{ $errors->has('typeStudie') ? ' is-invalid' : '' }}" placeholder="Tipo de estudio" type="text" name="typeStudie" value="{{ old('typeStudie', $type->type) }}" required autofocus >
                                @if ($errors->has('typeStudie'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('typeStudie') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="form-group">
                                <div class="row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Añadir nota</label>
                                    <div class="col-sm-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios" id="none" value="none" 
                                            @if (is_null($type->class_note))
                                                checked
                                            @endif>
                                            <label class="form-check-label" for="none" style="font-size: 14px;">No añadir</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios" id="simpleNote" value="simpleNote"
                                            @if ($type->class_note == "simpleNote")
                                                checked
                                            @endif>
                                            <label class="form-check-label" for="simpleNote" style="font-size: 14px;">Normal</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios" id="highlightedNote" value="highlightedNote"
                                            @if ($type->class_note == "highlightedNote")
                                                checked
                                            @endif>
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
                        <div class="col-12">
                            <textarea id="note" name="note" class="form-control" aria-label="With textarea" style="
                                @if (is_null($type->class_note))
                                    display:none;
                                @endif
                                 height: 100px;">{{$type->note}}</textarea>
                        </div>                       
                    </div>
                    <button class="btn btn-primary shadow-2 mt-4 mb-4">Guardar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- jquery-validation Js -->
    <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <!-- form-picker-custom Js -->
    <script src="assets/js/pages/form-validation.js"></script>
@endsection
@section('css')
    <script type="text/javascript"> 
        $("input:radio[name=gridRadios]").change(function(evt){
            var kind = $(this).val();
            if(kind != 'none'){
                document.getElementById('note').style.display ='block';
            }else{
                document.getElementById('note').style.display ='none';
            }
        });
    </script>
@endsection
