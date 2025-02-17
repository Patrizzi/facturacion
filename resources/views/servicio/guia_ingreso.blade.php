@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
@include('servicio\_shared\tabs')

<style>
.wrappercontenedor {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
}

.containercontenedor {
    border: 2px solid #000;
    color: black;
    border-radius: 10px;
    padding: 20px;
    box-sizing: border-box;
}


.button-container {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin: 20px;
}

.action-button {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    background-color: #007BFF;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 0.9em;
}

.action-button:hover {
    background-color: #0056b3;
}
</style>

<div class="wrappercontenedor">
    <!-- Contenedor izquierdo -->
    <div class="containercontenedor" style="align-self: flex-start;">
        <h2 class="container-titlecontenedor">Datos del Cliente</h2>

        <div class="input-groupcontenedor">
            <label for="dni" class="input-labelcontenedor">DNI/RUC:</label>
            <input type="number" id="dni" name="dni" class="input-fieldcontenedor" placeholder="Ingrese DNI/RUC" required>
            <label for="nombre" class="input-labelcontenedor">Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="input-fieldcontenedor" placeholder="Ingrese Nombre" required>
        </div>

        <div class="input-groupcontenedor full-widthcontenedor">
            <label for="direccion" class="input-labelcontenedor">Dirección:</label>
            <input type="text" id="direccion" name="direccion" class="input-fieldcontenedor full-widthcontenedor" placeholder="Ingrese Dirección" required>
        </div>

        <div class="input-groupcontenedor">
            <label for="contacto" class="input-labelcontenedor">Contacto:</label>
            <input type="text" id="contacto" name="contacto" class="input-fieldcontenedor" placeholder="Ingrese Contacto" required>
            <label for="telefono" class="input-labelcontenedor">Teléfono:</label>
            <input type="number" id="telefono" name="telefono" class="input-fieldcontenedor" placeholder="Ingrese Teléfono" required>
        </div>

        <div class="input-groupcontenedor full-widthcontenedor">
            <label for="sucursal" class="input-labelcontenedor">Sucursal:</label>
            <input type="text" id="sucursal" name="sucursal" class="input-fieldcontenedor full-widthcontenedor" placeholder="Ingrese Sucursal" required>
        </div>
    </div>

    <!-- Contenedor derecho -->
    <div class="containercontenedor" style="align-self: flex-end;">
        <h2 class="container-titlecontenedor">Datos del Servicio</h2>

        <div class="input-groupcontenedor">
            <label for="recepcionista" class="input-labelcontenedor">Recepcionista:</label>
            <input type="text" id="recepcionista" name="recepcionista" class="input-fieldcontenedor" placeholder="Ingrese Recepcionista" required>
            <label for="fecha_ingreso" class="input-labelcontenedor">Fecha Ingreso:</label>
            <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="input-fieldcontenedor" required>
        </div>

        <div class="input-groupcontenedor">
            <label for="orden_servicio" class="input-labelcontenedor">Orden de servicio:</label>
            <input type="text" id="orden_servicio" name="orden_servicio" class="input-fieldcontenedor" placeholder="Ingrese Orden" required>
            <label for="fecha_estimada" class="input-labelcontenedor">Fecha Estimada:</label>
            <input type="date" id="fecha_estimada" name="fecha_estimada" class="input-fieldcontenedor" required>
        </div>
    </div>
    </div>

<div class="button-container">
    <button class="action-button">Editar</button>
    <button class="action-button">Eliminar</button>
    <button class="action-button">Ingresar</button>
</div>

    <h2>CLIENTES</h2>
    <table class="table table-striped table-bordered table-hover dataTables-example">
        <thead>
            <tr>
                <th>ITEM</th>
                <th>Serie</th>
                <th>Descripción</th>
                <th>Observación</th>
                <th>Tecnico de diagnostico</th>
                <th>Fecha</th>
                <th>Diagnostico</th>
                <th>Estado de Aprobacion</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>01</td>
                <td>LKDO</td>
                <td>laptop ph con lentitud</td>
                <td>la primera vista del tecnico al producto
                donde nota cosas que el cliente no</td>
                <td>Juana</td>
                <td>10/10/23</td>
                <td>Disco duro roto</td>
                <td><button>Aceptado</button></td>
            </tr>
            <tr>
                <td>02</td>
                <td>L10L</td>
                <td>impresora epson no imprime</td>
                <td>la primera vista del tecnico al producto
                donde nota cosas que el cliente no</td>
                <td>Angel</td>
                <td>10/10/23</td>
                <td>Falta de refrigeranción</td>
                <td><button>Aceptado</button></td>
            </tr>
        </tbody>
    </table>
@endsection
