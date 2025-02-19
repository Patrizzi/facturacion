@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
@include('servicio\_shared\tabs')
    <style>

    </style>
    <nav>
        <a href="{{ route('servicio.index') }}">Guia de Entrada</a>
        <a href="{{ route('servicio.guiasalida') }}">Guía de salida</a>
    </nav>
    <h2>GUÍA DE SALIDA</h2>
    <div>
        <div>
            <h3>CLIENTES</h3>
            <form action="">
                <div>
                    <label for="">DNI/RUC:</label>
                    <input type="text" value="93949494939">
                    <label for="">Nombre:</label>
                    <input type="text" value="Juana">
                </div>
                <div>
                    <label for="">Dirección:</label>
                    <input type="text" value="..........">
                </div>
                <div>
                    <label for="">Contacto:</label>
                    <input type="text" value="juana@gmail.com">
                    <label for="">Teléfono:</label>
                    <input type="text" value="989678569">
                </div>
                <div>
                    <label for="">Sucursal:</label>
                    <input type="text" value=".........">
                </div>
            </form>
        </div>
        <div>
            <h3>DATOS GENERALES</h3>
            <form action="">
                <div>
                    <label for="">Recepcionista:</label>
                    <input type="text" value="Julio">
                    <label for="">Fecha de ingreso:</label>
                    <input type="text" value="2022-02-16">
                </div>
                <div>
                    <label for="">Orden de servicio:</label>
                    <input type="text" value="EP-00000001">
                    <label for="">Fecha estimada:</label>
                    <input type="text" value="22/02/2025">
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped table-bordered table-hover dataTables-example">
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
                        <option value="">Ver</option>
                        <option value="">Eliminar</option>
                        <option value="">Editar</option>
                    </select>
                </td>
            </tr>
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
                        <option value="">Ver</option>
                        <option value="">Eliminar</option>
                        <option value="">Editar</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
