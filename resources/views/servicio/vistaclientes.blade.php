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
                <td><button>Ver estado</button></td>
            </tr>
            <tr>
                <td>02</td>
                <td>Christopher Javier</td>
                <td>Huaman Guevara</td>
                <td>74894537</td>
                <td>934361536</td>
                <td>christojhg@gmail.com</td>
                <td><button>Ver estado</button></td>
            </tr>
        </tbody>
    </table>
@endsection
