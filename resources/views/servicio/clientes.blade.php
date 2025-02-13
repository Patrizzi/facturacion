@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
@include('servicio\_shared\tabs')
    <style>

    </style>
    <h2>CLIENTES</h2>
    <table class="table table-striped table-bordered table-hover dataTables-example">
        <thead>
            <tr>
                <th>ITEM</th>
                <th>Nro. GUÍA</th>
                <th>ORDEN DE SERVICIO</th>
                <th>RUC/DNI</th>
                <th>CLIENTE</th>
                <th>FECHA DE EMISIÓN</th>
                <th>ESTADO DE PROCESAMIENTO</th>
                <th>ACCIÓN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->empresa }}</td>
                    <td>{{ $cliente->ubigeo ?? 'No especificado' }}</td>
                    <td><button>Ver estado</button></td>
                </tr>
            @endforeach
            <tr>
                <td>01</td>
                <td>#0012</td>
                <td>#00000</td>
                <td>235345345635</td>
                <td>Juan Pérez</td>
                <td>10/02/25</td>
                <td>Procesamiento</td>
                <td><button>Ver estado</button></td>
            </tr>
            <tr>
                <td>02</td>
                <td>#0013</td>
                <td>#00001</td>
                <td>12345678901</td>
                <td>María López</td>
                <td>12/02/25</td>
                <td>Pendiente</td>
                <td><button>Ver estado</button></td>
            </tr>
        </tbody>
    </table>
@endsection