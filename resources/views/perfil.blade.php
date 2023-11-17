@extends('layouts.layoutDr')
@section('title','Perfil')
@section('leve','Perfil')
@section('breadcrumb')

@endsection
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header row">
                <div class="col-4"> 
                    <div class="ext-logo-image">
                        <div class="int-logo-image">
                            @if (is_null(auth()->user()->doctor->photo))
                                <img src="{{ asset('assets/images/user/defaultProfile.png')}}" class="img-radius" alt="User-Profile-Image">
                            @else
                                <img src="{{auth()->user()->doctor->photo}}" class="img-radius" alt="User-Profile-Image">

                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-1"> 
                </div>
                <div class="text-mis-estudios mt-3 col-6">
                    <h2 style="font-weight: bold;font-size: 32px;">
                        {{auth()->user()->name}}
                        {{auth()->user()->doctor->paternalSurname}}
                        {{auth()->user()->doctor->maternalSurname}}
                    </h2>
                    
                </div>
            </div>
            <div class="card-block row text-center">
                <div class="col-md-4">
                    <h4>Email:</h4>
                    <p>
                        {{auth()->user()->email}}
                    </p>
                </div>
                
                <div class="col-md-4">
                    <h4>Alias:</h4>
                    <p>
                        {{auth()->user()->doctor->alias}}
                    </p>
                </div>
                <!--
                <div class="col-md-4">
                    <h4>Titulo:</h4>
                    <p>
                        {{auth()->user()->doctor->title}}
                    </p>
                </div>
                -->
                <div class="col-md-4">

                    <h4>Teléfono:</h4>
                    <p>
                        {{auth()->user()->doctor->phone}}
                    </p>
                </div>
                <div class="col-md-4">

                    <h4>Fecha de nacimiento:</h4>
                    <p>
                        {{auth()->user()->doctor->birthday}}
                    </p>
                </div>
                <div class="col-md-4">

                    <h4>Genero:</h4>
                    <p>
                        {{auth()->user()->doctor->gender}}
                    </p>
                </div>
                <div class="col-md-4">

                    <h4>Especialidad:</h4>
                    <p>
                        {{auth()->user()->doctor->specialty}}
                    </p>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-12 col-sm-12 mt-2">
                    <a href="{{route('EditProfil')}}">
                        <button id="save" type="button" class="btn btn-rounded btn-new">Editar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('css')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endsection

