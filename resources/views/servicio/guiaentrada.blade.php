@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')
@include('servicio._shared.tabs')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Guia de ingreso</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Guia de salida</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Informe de servicios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Solicitud de servicios</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


<table class="table table-striped table-bordered table-hover dataTables-example" id="table_entrada">
    <thead>
        <tr>
            <th>Item</th>
            <th>Serie</th>
            <th>Descripción</th>
            <th>Observación</th>
            <th>Tecnico de diagnostico</th>
            <th>Fecha</th>
            <th>Diagnostico</th>
            <th>Estado de aprobacion</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>001</th>
            <th>HP32</th>
            <th>Laptop acer si encender </th>
            <th>La primera vista del tecnico al producto <br>
                donde nota cosas que el cliente no</th>
            <th>Rey</th>
            <th>10/12/24</th>
            <th>Bateria de laptop dañada</th>
            <th>Aceptado</th>
        </tr>
        <tr>
            <th>002</th>
            <th>OL98</th>
            <th>Impresora no imprime a color</th>
            <th>La primera vista del tecnico al producto <br>
                donde nota cosas que el cliente no</th>
            <th>Juana</th>
            <th>10/01/25</th>
            <th>Falta de mantenimiento</th>
            <th>Aprobado</th>
        </tr>
        <tr>
            <th>003</th>
            <th>UR28</th>
            <th>Computadora que no reconoce ningun puerto usb</th>
            <th>La primera vista del tecnico al producto <br>
                donde nota cosas que el cliente no</th>
            <th>Yerson</th>
            <th>30/01/25</th>
            <th>Falta de drivers</th>
            <th>Aprobado</th>
        </tr>
    </tbody>
</table>
<br>
<br>
<br>
<table class="table table-striped table-bordered table-hover dataTables-example" id="table_guia_salida">
    <thead>
        <tr>
            <th>Item</th>
            <th>Serie</th>
            <th>Descripción</th>
            <th>Observación</th>
            <th>Tecnico de diagnostico</th>
            <th>Fecha</th>
            <th>Diagnostico</th>
            <th>Estado de aprobacion</th>
            <th>Tecnico de reparacion</th>
            <th>Fecha de reparacion</th>
            <th>Estado de reparacion</th>
            <th>Recomendaciones</th>
            <th>Añadir imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>001</th>
            <th>HP32</th>
            <th>Laptop acer si encender </th>
            <th>La primera vista del tecnico al producto <br>
                donde nota cosas que el cliente no</th>
            <th>Rey</th>
            <th>10/12/24</th>
            <th>Bateria de laptop dañada</th>
            <th>Aprobado</th>
            <th>Rey</th>
            <th>18/12/24</th>
            <th>Reparada</th>
            <th>No usar constantemente la laptop con <br>
                el cargador conectado</th>
            <th <link rel="" type="" href="">>AÑADIR imagen</th>
            <th><button type="button">VER</button></th>
        </tr>
        <tr>
            <th>002</th>
            <th>OL98</th>
            <th>Impresora no imprime a color</th>
            <th>La primera vista del tecnico al producto <br>
                donde nota cosas que el cliente no</th>
            <th>Juana</th>
            <th>10/01/25</th>
            <th>Falta de mantenimiento</th>
            <th>Aprobado</th>
            <th>Juana</th>
            <th>20/01/25</th>
            <th>Reparada</th>
            <th>Realizar el mantenimiento cada 2 <br>
                semanas</th>
            <th <link rel="" type="" href="">>AÑADIR imagen</th>
            <th><button type="button">VER</button></th>
        </tr>
        <tr>
            <th>003</th>
            <th>UR28</th>
            <th>Computadora que no reconoce ningun puerto usb</th>
            <th>La primera vista del tecnico al producto <br>
                donde nota cosas que el cliente no</th>
            <th>Yerson</th>
            <th>30/01/25</th>
            <th>Falta de drivers</th>
            <th>Aprobado</th>
            <th>Yerson</th>
            <th>07/02/25</th>
            <th>Reparada</th>
            <th>No realizar modificaciones a los drivers <br>
                si no tiene conocimiento</th>
            <th <link rel="" type="" href="">>AÑADIR imagen</th>
            <th><button type="button">VER</button></th>
        </tr>
    </tbody>
</table>

@endsection

