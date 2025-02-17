@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
@include('servicio\_shared\tabs')

<style>
    .table thead {
        background-color: white;
        color: #15338a;
        text-align: center;
    }

    .table {
        border: 2px solid black;
    }

    .table th, .table td {
        border: 1px solid black !important;
        padding: 10px;
        text-align: center;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .btn-estado {
        background-color: #15338a;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn-estado:hover {
        background-color: black;
    }
</style>

<h2>CLIENTES</h2>
<table class="table table-striped table-bordered table-hover dataTables-example">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>APELLIDO</th>
            <th>DNI</th>
            <th>CELULAR</th>
            <th>CORREO</th>
            <th>ACCIÓN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>01</td>
            <td>Carlos Daniel</td>
            <td>Roman Berru</td>
            <td>73588510</td>
            <td>936292675</td>
            <td>danielrberru@gmail.com</td>
            <td><button class="btn-estado">Guia</button></td>
        </tr>
        <tr>
            <td>02</td>
            <td>Christopher Javier</td>
            <td>Huaman Guevara</td>
            <td>74894537</td>
            <td>934361536</td>
            <td>christojhg@gmail.com</td>
            <td><button class="btn-estado">Guia</button></td>
        </tr>
        <tr>
            <td>03</td>
            <td>Sandra Maria</td>
            <td>Saavedra Perez</td>
            <td>73623005</td>
            <td>963784109</td>
            <td>marisandrag@gmail.com</td>
            <td><button class="btn-estado">Guia</button></td>
        </tr>
        <tr>
            <td>04</td>
            <td>Joshua Ronald</td>
            <td>Araujo Do Santos</td>
            <td>76325412</td>
            <td>950314752</td>
            <td>dosantosj@gmail.com</td>
            <td><button class="btn-estado">Guia</button></td>
        </tr>
    </tbody>
</table>
@endsection
