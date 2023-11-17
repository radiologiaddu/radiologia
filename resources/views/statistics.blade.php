@extends('layouts.layout')
@section('title','Estadisitcas')
@section('leve','Statistics')
@section('breadcrumb')
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Estadisticas</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Estadisticas</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- data tables css -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/data-tables/css/datatables.min.css') }}">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="card-block">
                <!-- [ statistic-line chat ] start -->
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Estadisticas</h5>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <!-- [ bitcoin-wallet section ] start-->
                                <div class="col-md-6 col-xl-4">
                                    <div class="card theme-bg bitcoin-wallet">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Doctores</h5>
                                            <h2 class="text-white mb-2 f-w-300">{{$doctors}}</h2>
                                            <span class="text-white d-block">Total de doctores registrados</span>
                                            <i class="mdi mdi-doctor f-70 text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="card theme-bg2 bitcoin-wallet">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Estudios</h5>
                                            <h2 class="text-white mb-2 f-w-300">{{$studies}}</h2>
                                            <span class="text-white d-block">Total de estudios registrados</span>
                                            <i class="fas fa-vial f-70 text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-4">
                                    <div class="card bg-c-blue bitcoin-wallet">
                                        <div class="card-block">
                                            <h5 class="text-white mb-2">Total</h5>
                                            <h4 class="text-white mb-2 f-w-200">{{sprintf('$ %s', number_format($total, 2)) }}</h4>
                                            <span class="text-white d-block">Total de estudios pagados</span>
                                            <i class="fas fa-dollar-sign f-70 text-white"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ bitcoin-wallet section ] end-->
                            </div>
                            <div>
                                <h5 class="mb-2">Estudios</h5>
                            </div>
                            <div id="line-areaNow" class="lineAreaDashboard" style="height:330px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('/assets/plugins/data-tables/js/datatables.min.js') }} "></script>
    <script src="{{ asset('/assets/js/pages/tbl-datatable-custom.js') }} "></script>

        <!-- amchart js -->
        <script src="{{ asset('/assets/plugins/amchart/js/amcharts.js') }}"></script>
        <script src="{{ asset('/assets/plugins/amchart/js/gauge.js') }}"></script>
        <script src="{{ asset('/assets/plugins/amchart/js/serial.js') }}"></script>
        <script src="{{ asset('/assets/plugins/amchart/js/light.js') }}"></script>
        <script src="{{ asset('/assets/plugins/amchart/js/pie.min.js') }}"></script>
        <script src="{{ asset('/assets/plugins/amchart/js/ammap.min.js') }}"></script>
        <script src="{{ asset('/assets/plugins/amchart/js/usaLow.js') }}"></script>
        <script src="{{ asset('/assets/plugins/amchart/js/radar.js') }}"></script>
        <script src="{{ asset('/assets/plugins/amchart/js/worldLow.js') }}"></script>
    
        <!-- Float Chart js -->
        <script src="{{ asset('/assets/plugins/flot/js/jquery.flot.js') }}"></script>
        <script src="{{ asset('/assets/plugins/flot/js/jquery.flot.categories.js') }}"></script>
        <script src="{{ asset('/assets/plugins/flot/js/curvedLines.js') }}"></script>
        <script src="{{ asset('/assets/plugins/flot/js/jquery.flot.tooltip.min.js') }}"></script>
    
        <!-- dashboard-custom js -->
        <script src="{{ asset('/assets/js/pages/dashboard-crypto.js') }}"></script>
        <script>
            // [ Line with Area Chart 2 ] start
                var chart = AmCharts.makeChart("line-areaNow", {
                    "type": "serial",
                    "theme": "light",
                    "marginTop": 10,
                    "marginRight": 0,
                    "dataProvider": [{
                        "year": "Ene",
                        "value": '{{$ene}}',
                        "value2": '{{$eneT}}',
                    }, {
                        "year": "Feb",
                        "value": "{{$feb}}",
                        "value2": "{{$febT}}",
                    }, {
                        "year": "Mar",
                        "value": "{{$mar}}",
                        "value2": "{{$marT}}",
                    }, {
                        "year": "Abr",
                        "value": "{{$abr}}",
                        "value2": "{{$abrT}}",
                    }, {
                        "year": "May",
                        "value": "{{$may}}",
                        "value2": "{{$mayT}}",
                    }, {
                        "year": "Jun",
                        "value": "{{$jun}}",
                        "value2": "{{$junT}}",
                    }, {
                        "year": "Jul",
                        "value": "{{$jul}}",
                        "value2": "{{$julT}}",
                    }, {
                        "year": "Ago",
                        "value": "{{$ago}}",
                        "value2": "{{$agoT}}",
                    }, {
                        "year": "Sep",
                        "value": "{{$sep}}",
                        "value2": "{{$sepT}}",
                    }, {
                        "year": "Oct",
                        "value": "{{$oct}}",
                        "value2": "{{$octT}}",
                    }, {
                        "year": "Nov",
                        "value": "{{$nov}}",
                        "value2": "{{$novT}}",
                    }, {
                        "year": "Dic",
                        "value": "{{$dic}}",
                        "value2": "{{$dicT}}",
                    }],
                    "valueAxes": [{
                        "axisAlpha": 0,
                        "position": "left"
                    }],
                    "graphs": [{
                        "id": "g1",
                        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
                        "bullet": "round",
                        "lineColor": "#1de9b6",
                        "lineThickness": 3,
                        "negativeLineColor": "#1de9b6",
                        "valueField": "value",
                        "title": "Recibidos",
                    }, {
                        "id": "g2",
                        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
                        "bullet": "round",
                        "lineColor": "#10adf5",
                        "lineThickness": 3,
                        "negativeLineColor": "#10adf5",
                        "valueField": "value2",
                        "title": "Terminados",
                    }],
                    "chartCursor": {
                        "cursorAlpha": 0,
                        "valueLineEnabled": true,
                        "valueLineBalloonEnabled": true,
                        "valueLineAlpha": 0.3,
                        "fullWidth": true
                    },
                    "categoryField": "year",
                    "categoryAxis": {
                        "minorGridAlpha": 0,
                        "minorGridEnabled": true,
                        "gridAlpha": 0,
                        "axisAlpha": 0,
                        "lineAlpha": 0
                    },
                    "legend": {
                        "useGraphSettings": true,
                        "position": "top"
                    },
                });
            // [ Line with Area Chart 2 ] end
        </script>
@endsection
