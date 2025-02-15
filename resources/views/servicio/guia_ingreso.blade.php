@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
@include('servicio\_shared\tabs')

<style>
.wrapper {
    display: flex;
    align-items: flex-start;
    margin: 10px;
    gap: 15px;
}

.container {
    width: 100%;
    max-width: 500px;
    padding: 5px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
}

.container-title {
    font-size: 1.2em;
    margin-bottom: 15px;
}

.input-group {
    gap: 6px;
    margin-bottom: 5px;
}

.input-label {
    font-size: 0.85em;
    padding-right: 3px;
}

.input-field {
    font-size: 0.85em;
    padding: 6px;
    border-radius: 3px;
}

.full-width {
    width: 100%;
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

<div class="wrapper">
<!-- Contenedor izquierdo -->
<div class="container" style="align-self: flex-start;">
    <h2 class="container-title">Datos del Cliente</h2>

    <div class="input-group">
        <label for="dni" class="input-label">DNI/RUC:</label>
        <input type="number" id="dni" name="dni" class="input-field" placeholder="Ingrese DNI/RUC" required>
        <label for="nombre" class="input-label">Nombre:</label>
        <input type="text" id="nombre" name="nombre" class="input-field" placeholder="Ingrese Nombre" required>
    </div>

    <div class="input-group full-width">
        <label for="direccion" class="input-label">Dirección:</label>
        <input type="text" id="direccion" name="direccion" class="input-field full-width" placeholder="Ingrese Dirección" required>
    </div>

    <div class="input-group">
        <label for="contacto" class="input-label">Contacto:</label>
        <input type="text" id="contacto" name="contacto" class="input-field" placeholder="Ingrese Contacto" required>
        <label for="telefono" class="input-label">Teléfono:</label>
        <input type="number" id="telefono" name="telefono" class="input-field" placeholder="Ingrese Teléfono" required>
    </div>

    <div class="input-group full-width">
        <label for="sucursal" class="input-label">Sucursal:</label>
        <input type="text" id="sucursal" name="sucursal" class="input-field full-width" placeholder="Ingrese Sucursal" required>
    </div>
</div>

<!-- Contenedor derecho -->
<div class="container" style="align-self: flex-end;">
    <h2 class="container-title">Datos del Servicio</h2>

    <div class="input-group">
        <label for="recepcionista" class="input-label">Recepcionista:</label>
        <input type="text" id="recepcionista" name="recepcionista" class="input-field" placeholder="Ingrese Recepcionista" required>
        <label for="fecha_ingreso" class="input-label">Fecha Ingreso:</label>
        <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="input-field" required>
    </div>

    <div class="input-group">
        <label for="orden_servicio" class="input-label">Orden de servicio:</label>
        <input type="text" id="orden_servicio" name="orden_servicio" class="input-field" placeholder="Ingrese Orden" required>
        <label for="fecha_estimada" class="input-label">Fecha Estimada:</label>
        <input type="date" id="fecha_estimada" name="fecha_estimada" class="input-field" required>
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
