@extends('layouts.layoutHost')

@section('title','PerfilDoctor')
@section('leve','PerfilDoctor')

@section('breadcrumb')
@endsection

@section('content')
<div class="col-sm-12">
    <div class="imprimir">
        @if($showCashBackOnly)
            <button class="print-button" onclick="generateImageAndPrint()">Imprimir</button>
        @endif
    </div>
    <div class="card" id="cash-back">
        <div class="card-block row text-center">
            <div class="text-mis-estudios mt-3 col-12">
                <h2 style="font-weight: bold; font-size: 32px;">
                    {{ $user->name }}
                    {{ $doctor->paternalSurname }}
                    {{ $doctor->maternalSurname }}
                </h2>
            </div>
            <div class="col-md-12">
                @if($showCashBackOnly)
                    <div class="cash-back-container">
                        <p><strong>Cash Back DDU:</strong> ${{ $annualReturnFormatted }}</p>
                        <h2>Gracias por ser parte de nuestro equipo</h2>
                    </div>
                @else
                    <h2 style="font-weight: bold; font-size: 32px;">REPORTE ANUAL</h2>
                    @if($studies->isEmpty())
                        <p>No hay estudios disponibles.</p>
                    @else
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Nombre del Paciente</th>
                                    <th>Fecha</th>
                                    <!--<th>Total</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studies as $study)
                                    @if($study->status == 'Enviado')
                                        <tr>
                                            <td>
                                                @if ($study->internal == 1)
                                                    R{{ sprintf('%06d', $study->folio) }}
                                                @else
                                                    D{{ sprintf('%06d', $study->folio) }}
                                                @endif
                                            </td>
                                            <td>{{ $study->patient_name }}</td>
                                            <td>{{ $study->formatted_date }}</td>
                                            <!--<td>{{ number_format($study->total, 2, ',', '.') }}</td>-->
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <!--<tr>
                                    <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                                    <td><strong>${{ $totalSumFormatted }}</strong></td>
                                </tr>-->
                                <tr class="annual-return">
                                    <td colspan="2" style="text-align: right;"><strong>Cash Back DDU:</strong></td>
                                    <td><strong>${{ $annualReturnFormatted }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    @endif
                @endif
                <div class="logo-container">
                    <img src="https://res.cloudinary.com/ddu/image/upload/v1716922445/Descubriendo_Sonrisas_Logo_idrc2e.png" alt="Logo">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function generateImageAndPrint() {
        var printWindow = window.open('', '_blank');
        var printDocument = printWindow.document;

        // Construct the HTML content for printing
        var htmlContent = `
            <html>
            <head>
                <title>Impresión</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                    }
                    .card {
                        border: none;
                        box-shadow: none;
                        margin-bottom: 30px;
                    }
                    .card-block {
                        padding: 15px;
                    }
                    .text-mis-estudios h2 {
                        font-weight: bold;
                        font-size: 32px;
                        margin-bottom: 20px;
                    }
                    .cash-back-container {
                        margin-top: 20px;
                        text-align: center;
                    }
                    .cash-back-container p {
                        font-size: 24px;
                        color: #9c9c9c;
                        font-weight: bold;
                        margin-bottom: 10px;
                    }
                    .cash-back-container h2 {
                        font-size: 28px;
                        font-weight: bold;
                        margin-top: 10px;
                    }
                    .custom-table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    .custom-table th, .custom-table td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                    }
                    .custom-table th {
                        background-color: #6E7BDE;
                        color: white;
                    }
                    .custom-table tbody tr:nth-child(even) {
                        background-color: #f9f9f9;
                    }
                    .custom-table tbody tr:hover {
                        background-color: #f2f2f2;
                    }
                    .custom-table tfoot td {
                        background-color: #F2F2F2;
                        font-weight: bold;
                    }
                    .logo-container {
                        text-align: center;
                        margin-top: 20px;
                    }
                    .logo-container img {
                        max-width: 20%;
                        height: auto;
                    }
                </style>
            </head>
            <body>
                <div class="card-block row text-center">
                    <div class="text-mis-estudios mt-3 col-12">
                        <h2 style="font-weight: bold; font-size: 32px; text-align: center;">
                            {{ $user->name }}
                            {{ $doctor->paternalSurname }}
                            {{ $doctor->maternalSurname }}
                        </h2>
                    </div>
                    <div class="col-md-12">
                        @if($showCashBackOnly)
                            <div class="cash-back-container">
                                <p style="color: #677aec;"><strong>Cash Back DDU:</strong> ${{ $annualReturnFormatted }}</p>
                                <h2>Gracias por ser parte de nuestro equipo</h2>
                            </div>
                        @else
                            <h2 style="font-weight: bold; font-size: 32px;">REPORTE ANUAL</h2>
                            @if($studies->isEmpty())
                                <p>No hay estudios disponibles.</p>
                            @else
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Nombre del Paciente</th>
                                            <th>Fecha</th>
                                            <!--<th>Total</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($studies as $study)
                                            @if($study->status == 'Enviado')
                                                <tr>
                                                    <td>
                                                        @if ($study->internal == 1)
                                                            R{{ sprintf('%06d', $study->folio) }}
                                                        @else
                                                            D{{ sprintf('%06d', $study->folio) }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $study->patient_name }}</td>
                                                    <td>{{ $study->formatted_date }}</td>
                                                    <!--<td>{{ number_format($study->total, 2, ',', '.') }}</td>-->
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <!--<td colspan="3" style="text-align: right;"><strong>Total:</strong></td>-->
                                            <!--<td><strong>${{ $totalSumFormatted }}</strong></td>-->
                                            <td colspan="2" style="text-align: right;"><strong>Cash Back DDU:</strong></td>
                                            <td><strong>${{ $annualReturnFormatted }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                        @endif
                        <div class="logo-container">
                            <img src="https://res.cloudinary.com/ddu/image/upload/v1716922445/Descubriendo_Sonrisas_Logo_idrc2e.png" alt="Logo">
                        </div>
                    </div>
                </div>
            </body>
            </html>
        `;

        // Write the HTML content to the print document
        printDocument.open();
        printDocument.write(htmlContent);
        printDocument.close();

        // After loading the content, focus and print the window
        printWindow.onload = function() {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        };
    }
</script>
@endsection

@section('css')
<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
    }
    .card {
        border: none;
        box-shadow: none;
        margin-bottom: 30px;
    }
    .card-block {
        padding: 15px;
    }
    .text-mis-estudios h2 {
        font-weight: bold;
        font-size: 32px;
        margin-bottom: 20px;
    }
    .cash-back-container {
        margin-top: 20px;
        text-align: center;
    }
    .cash-back-container p {
        font-size: 24px;
        color: #677aec;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .cash-back-container h2 {
        font-size: 28px;
        font-weight: bold;
        margin-top: 10px;
    }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .custom-table th, .custom-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .custom-table th {
        background-color: #6E7BDE;
        color: white;
    }
    .custom-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .custom-table tbody tr:hover {
        background-color: #f2f2f2;
    }
    .custom-table tfoot td {
        background-color: #F2F2F2;
        font-weight: bold;
    }
    .logo-container {
        text-align: center;
        margin-top: 20px;
    }
    .logo-container img {
        max-width: 20%;
        height: auto;
    }
    .print-button {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        color: white;
        background-color: #677aec;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .print-button:hover {
        background-color: #5769c8;
    }
</style>
@endsection
