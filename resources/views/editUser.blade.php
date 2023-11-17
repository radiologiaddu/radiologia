@extends('layouts.layout')
@section('title','Nuevo usuario')
@section('leve','Usuarios')
@section('breadcrumb')
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Editar usuario</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users') }}">Usuarios</a></li>
                    <li class="breadcrumb-item"><a href="#">Editar usuario</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Editar datos</h5>  
            </div>
            <div class="card-block">
                <form method="POST" action="{{ route('updateUser', $user->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nombre</label>
                                <input id="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nombre" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus >
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
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email"  name="email" value="{{ old('email', $user->email) }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tipo de usuario</label>
                                <select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" id="type" name="type" required>
                                    <option value="" selected disabled>Selecciona una</option>
                                    <option value="Administrador"
                                        @if (old('type',$role) == 'Administrador')
                                            selected
                                        @endif
                                    >Administrador</option>
                                    <option type="Recepcion"
                                        @if (old('type',$role) == 'Recepcion')
                                            selected
                                        @endif
                                    >Recepción</option>
                                    <option type="Hostess"
                                        @if (old('type',$role) == 'Hostess')
                                            selected
                                        @endif
                                    >Hostess</option>
                                    <option type="Caja"
                                        @if (old('type',$role) == 'Caja')
                                            selected
                                        @endif
                                    >Caja</option>
                                    <option type="Coordinador"
                                        @if (old('type',$role) == 'Coordinador')
                                            selected
                                        @endif
                                    >Coordinador</option>
                                    <option value="Radiologo"
                                        @if (old('type',$role) == 'Radiologo')
                                            selected
                                        @endif
                                    >Radiologo</option>

                                </select>
                                @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                        
                    </div>
                    <button class="btn btn-primary shadow-2 mb-4">Actualizar</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Cambiar contraseña</h5>
            </div>
            <div class="card-block">
                <form method="POST" action="{{ route('changePassword', $user->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Contraseña</label>
                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Contraseña" id="password" name="password" required autocomplete="new-password">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" placeholder="Confirmar contraseña" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary shadow-2 mb-4">Cambiar contraseña</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <!-- jquery-validation Js -->
    <script src="{{ asset('/assets/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <!-- form-picker-custom Js -->
    <script src="{{ asset('/assets/js/pages/form-validation.js') }}"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if ($vA)  
    <script type="text/javascript">
        $(document).ready(function() {
            swal("Usuario modificado","El usuario se ha actualizado correctamente", "success");
        });
    </script>
@endif
@endsection