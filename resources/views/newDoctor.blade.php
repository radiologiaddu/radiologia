@extends('layouts.layout')
@section('title','Nuevo doctor')
@section('leve','Doctores')
@section('breadcrumb')
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Nuevo doctor</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('doctores') }}">Doctores</a></li>
                    <li class="breadcrumb-item"><a href="#">Nuevo doctor</a></li>
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
                <form method="POST" action="{{ route('addDoctor') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nombre</label>
                                <input id="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nombre" type="text" name="name" value="{{ old('name') }}" required autofocus >
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email"  name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
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
@section('content')
    <!-- jquery-validation Js -->
    <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <!-- form-picker-custom Js -->
    <script src="assets/js/pages/form-validation.js"></script>
@endsection