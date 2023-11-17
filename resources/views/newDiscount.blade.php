@extends('layouts.layout')
@section('title','Nuevo descuento')
@section('leve','setting')
@section('subleve','discounts')
@section('breadcrumb')
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Nuevo descuento</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('discounts') }}">Descuentos</a></li>
                    <li class="breadcrumb-item"><a href="#">Nuevo descuento</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
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
        <!-- select2 css -->
        <link rel="stylesheet" href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="card-block">
                <form method="POST" action="{{ route('addDiscount') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Descuento</label>
                                <input id="descuento" name="descuento" type="text" class="form-control" required>
                                @if ($errors->has('descuento'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('descuento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Porcentaje</label>
                                <input id="porcentaje" name="porcentaje" type="text" class="form-control autonumberInt" required>
                                @if ($errors->has('porcentaje'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('porcentaje') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary shadow-2 mb-4">Registrar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <!-- jquery-validation Js -->
    <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <!-- form-picker-custom Js -->
    <script src="assets/js/pages/form-validation.js"></script>

        <!-- Input mask Js -->
        <script src="{{ asset('/assets/plugins/inputmask/js/inputmask.min.js') }}"></script>
        <script src="{{ asset('/assets/plugins/inputmask/js/jquery.inputmask.min.js') }}"></script>
        <script src="{{ asset('/assets/plugins/inputmask/js/autoNumeric.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.autonumberInt').autoNumeric('init', {aSep: '',mDec: '0', vMin: '0',  vMax: '100'});
        });
    </script>

@endsection