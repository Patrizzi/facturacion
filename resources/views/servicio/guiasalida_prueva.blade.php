@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
    <style>
        
    </style>
    <nav>
        <a href="{{ route('servicio.index') }}">Guia de Entrada</a>
        <a href="{{ route('servicio.guiasalida') }}">Guía de salida</a>
    </nav>
    <h2>GUÍA DE SALIDA</h2>
    <table>
        <thead>
            <tr>
                <th>ITEM</th>
                <th>SERIE</th>
                <th>DESCRIPCIÓN</th>
                <th>OBSERVACIÓN</th>
                <th>TÉCNICO DE DIAGNÓSTICO</th>
                <th>FECHA</th>
                <th>DIAGNÓSTICO</th>
                <th>ESTADO DE APROBACIÓN</th>
                <th>RECOMENDACIONES</th>
                <th>AÑADIR IMAGEN</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>001</td>
                <td>SN-2024X001</td>
                <td>Laptop Dell Inspiron 15</td>
                <td>La pantalla parpadea intermitentemente</td>
                <td>Juan Pérez</td>
                <td>2025-02-12</td>
                <td>Falla en la conexión del cable flex de la pantalla</td>
                <td>Aprobado</td>
                <td>Reemplazo del cable flex y prueba de estabilidad</td>
                <td><button>Subir IMG</button></td>
                <td>
                    <select name="option" id="">
                        <option value="">Eliminar</option>
                        <option value="">Editar</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
