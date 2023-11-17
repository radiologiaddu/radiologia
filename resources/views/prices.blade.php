@extends('layouts.layoutHost')
@section('title','Bienvenido')
@section('leve',$page)
@section('breadcrumb')

@endsection
@section('content')
<style>
    #zero-configurationo_length{
        margin-left: 50px;
    }
</style>

<link rel="stylesheet" href="{{ asset('/css/allStudy.css') }}">
    <!-- data tables css -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/data-tables/css/datatables.min.css') }}">
    <div class="col-sm-12">
        <div class="card-columns">
            @foreach ($arrayType as $type)
                <div class="card card-border-c-blue">
                    <div class="card-header">
                        <h5>{{$type->type}}</h5>
                    </div>
                    @foreach ($type->question as $question)
                        <div class="card-block block-r" style="font-weight: bold; color:black; padding: 5px 25px;">
                            <li class="mb-3">{{$question->question}}</li>
                            @foreach ($question->answer as $answer)
                                <h6 class="text-muted" style="font-weight: bold;">{{$answer->answer}} <span class="float-right" style="color:blueviolet">{{sprintf('$ %s', number_format($answer->cost, 2))}}</span></h6>
                                <hr>
                            @endforeach
                        </div>
                    @endforeach                
                </div>
            @endforeach
        </div>
    </div>
    
@endsection
@section('css')
@endsection
