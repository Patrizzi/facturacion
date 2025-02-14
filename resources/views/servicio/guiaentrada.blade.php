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
        <a class="navbar-brand" href="#">ㅤㅤㅤㅤㅤㅤㅤ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <!-- Enlace a la tabla de Guía de Entrada -->
                <li class="nav-item">
                    <a class="nav-link active" id="nav_entrada" href="javascript:void(0)" onclick="mostrarTabla(1)">Guía de Entrada</a>
                </li>
                <!-- Enlace a la tabla de Guía de Salida -->
                <li class="nav-item">
                    <a class="nav-link" id="nav_guia_salida" href="javascript:void(0)" onclick="mostrarTabla(2)">Guía de Salida</a>
                </li>
                <!-- Enlace a Informe de Servicio -->
                <li class="nav-item">
                    <a class="nav-link" id="nav_informe_servicio" href="javascript:void(0)" onclick="mostrarContenido(3)">Informe de Servicio</a>
                </li>
                <!-- Enlace a Solicitud de Servicio -->
                <li class="nav-item">
                    <a class="nav-link" id="nav_solicitud_servicio" href="javascript:void(0)" onclick="mostrarContenido(4)">Solicitud de Servicio</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="table_entrada" class="container mt-4">
    <table class="table table-striped table-bordered table-hover">
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
                <th>Laptop acer si encender</th>
                <th>La primera vista del tecnico al producto</th>
                <th>Rey</th>
                <th>10/12/24</th>
                <th>Bateria de laptop dañada</th>
                <th>Aceptado</th>
            </tr>
            <tr>
                <th>002</th>
                <th>OL98</th>
                <th>Impresora no imprime a color</th>
                <th>La primera vista del tecnico al producto</th>
                <th>Juana</th>
                <th>10/01/25</th>
                <th>Falta de mantenimiento</th>
                <th>Aprobado</th>
            </tr>
            <tr>
                <th>003</th>
                <th>UR28</th>
                <th>Computadora que no reconoce ningun puerto usb</th>
                <th>La primera vista del tecnico al producto</th>
                <th>Yerson</th>
                <th>30/01/25</th>
                <th>Falta de drivers</th>
                <th>Aprobado</th>
            </tr>
        </tbody>
    </table>
</div>

<div id="table_guia_salida" class="container mt-4">
    <table class="table table-striped table-bordered table-hover">
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
                <th>Laptop acer si encender</th>
                <th>La primera vista del tecnico al producto</th>
                <th>Rey</th>
                <th>10/12/24</th>
                <th>Bateria de laptop dañada</th>
                <th>Aprobado</th>
                <th>Rey</th>
                <th>18/12/24</th>
                <th>Reparada</th>
                <th>No usar constantemente la laptop con cargador</th>
                <th>AÑADIR imagen</th>
                <th><button type="button">VER</button></th>
            </tr>
            <tr>
                <th>002</th>
                <th>OL98</th>
                <th>Impresora no imprime a color</th>
                <th>La primera vista del tecnico al producto</th>
                <th>Juana</th>
                <th>10/01/25</th>
                <th>Falta de mantenimiento</th>
                <th>Aprobado</th>
                <th>Juana</th>
                <th>20/01/25</th>
                <th>Reparada</th>
                <th>Realizar el mantenimiento cada 2 semanas</th>
                <th>AÑADIR imagen</th>
                <th><button type="button">VER</button></th>
            </tr>
            <tr>
                <th>003</th>
                <th>UR28</th>
                <th>Computadora que no reconoce ningun puerto usb</th>
                <th>La primera vista del tecnico al producto</th>
                <th>Yerson</th>
                <th>30/01/25</th>
                <th>Falta de drivers</th>
                <th>Aprobado</th>
                <th>Yerson</th>
                <th>07/02/25</th>
                <th>Reparada</th>
                <th>No realizar modificaciones a los drivers</th>
                <th>AÑADIR imagen</th>
                <th><button type="button">VER</button></th>
            </tr>
        </tbody>
    </table>
</div>

<!-- Contenido para Informe de Servicio (vacío) -->
<div id="contenido_informe_servicio" class="container mt-4" style="display: none;">
    <h3>Informe de Servicio</h3>
    <p>Aquí se presentaría el informe de servicio.</p>
</div>

<!-- Contenido para Solicitud de Servicio (vacío) -->
<div id="contenido_solicitud_servicio" class="container mt-4" style="display: none;">
    <h3>Solicitud de Servicio</h3>
    <p>Aquí se presentaría la solicitud de servicio.</p>
</div>

<!-- Script para alternar entre las tablas y otros contenidos -->
<script>
    // Función para mostrar la tabla seleccionada o el contenido de servicio
    function mostrarTabla(tabla) {
        // Ocultar ambas tablas inicialmente
        document.getElementById("table_entrada").style.display = "none";
        document.getElementById("table_guia_salida").style.display = "none";

        // Ocultar los contenidos adicionales
        document.getElementById("contenido_informe_servicio").style.display = "none";
        document.getElementById("contenido_solicitud_servicio").style.display = "none";

        // Mostrar la tabla seleccionada
        if (tabla === 1) {
            document.getElementById("table_entrada").style.display = "block";
            document.getElementById("nav_entrada").classList.add("active");
            document.getElementById("nav_guia_salida").classList.remove("active");
        } else if (tabla === 2) {
            document.getElementById("table_guia_salida").style.display = "block";
            document.getElementById("nav_guia_salida").classList.add("active");
            document.getElementById("nav_entrada").classList.remove("active");
        }
    }

    // Función para mostrar el contenido adicional
    function mostrarContenido(contenido) {
        // Ocultar ambas tablas inicialmente
        document.getElementById("table_entrada").style.display = "none";
        document.getElementById("table_guia_salida").style.display = "none";

        // Ocultar los otros contenidos
        document.getElementById("contenido_informe_servicio").style.display = "none";
        document.getElementById("contenido_solicitud_servicio").style.display = "none";

        // Mostrar el contenido seleccionado
        if (contenido === 3) {
            document.getElementById("contenido_informe_servicio").style.display = "block";
            document.getElementById("nav_informe_servicio").classList.add("active");
            document.getElementById("nav_solicitud_servicio").classList.remove("active");
        } else if (contenido === 4) {
            document.getElementById("contenido_solicitud_servicio").style.display = "block";
            document.getElementById("nav_solicitud_servicio").classList.add("active");
            document.getElementById("nav_informe_servicio").classList.remove("active");
        }
    }

    // Mostrar la primera tabla (Entrada) al cargar la página
    window.onload = function() {
        mostrarTabla(1);
    };
</script>


@endsection


