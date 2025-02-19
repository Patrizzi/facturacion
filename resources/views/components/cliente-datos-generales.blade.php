@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<style>
<style>
    .boton-container {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin: 10px;
    }

    .boton {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
    }

    .boton:hover {
        background-color: #0056b3;
    }

    .numero {
        display: inline-block;
        width: 20px;
        height: 20px;
        font-size: 14px;
        font-weight: bold;
        color: white;
        background-color: #ff0000;
        text-align: center;
        line-height: 20px;
        border-radius: 3px;
    }

    .contenido {
        display: none;
    }

    .contenido.activo {
        display: block;
    }
</style>

<div class="boton-container">
    <button class="boton" onclick="mostrarSeccion('seccion1')">
        <span class="numero">1</span> Guía de Ingreso
    </button>

    <button class="boton" onclick="mostrarSeccion('seccion2')">
        <span class="numero">2</span> Guía de Salida
    </button>

    <button class="boton" onclick="mostrarSeccion('seccion3')">
        <span class="numero">3</span> Informe Técnico
    </button>

    <button class="boton" onclick="mostrarSeccion('seccion4')">
        <span class="numero">4</span> Solicitud de Servicio
    </button>
</div>





<style>
    .boton-container {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin: 10px;
    }

    .boton {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        background-color: #007bff;
        border: 2px solid black;
        border-bottom: 2px solid black;
        border-radius: 5px 5px 0 0;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
    }

    .boton:hover {
        background-color: #0056b3;
    }

    .numero {
        display: inline-block;
        width: 20px;
        height: 20px;
        font-size: 14px;
        font-weight: bold;
        color: white;
        background-color: #ff0000;
        text-align: center;
        line-height: 20px;
        border-radius: 3px;
    }

    .contenido {
        display: none;
        border: 2px solid black;
        border-top: none;
        padding: 20px;
    }

    /* Cuando se selecciona una sección con :target */
    #seccion1:target,
    #seccion2:target,
    #seccion3:target,
    #seccion4:target {
        display: block;
    }

    /* Quita el borde inferior del botón activo */
    #seccion1:target ~ .boton-container .boton[href="#seccion1"],
    #seccion2:target ~ .boton-container .boton[href="#seccion2"],
    #seccion3:target ~ .boton-container .boton[href="#seccion3"],
    #seccion4:target ~ .boton-container .boton[href="#seccion4"] {
        border-bottom: none;
        background-color: #0056b3;
    }
</style>

<!-- Botones de navegación -->
<div class="boton-container">
    <a href="#seccion1" class="boton">
        <span class="numero">1</span> Guía de Ingreso
    </a>

    <a href="#seccion2" class="boton">
        <span class="numero">2</span> Guía de Salida
    </a>

    <a href="#seccion3" class="boton">
        <span class="numero">3</span> Informe Técnico
    </a>

    <a href="#seccion4" class="boton">
        <span class="numero">4</span> Solicitud de Servicio
    </a>
</div>

<!-- Contenido de cada sección -->
<div id="seccion1" class="contenido">Contenido de Guía de Ingreso</div>
<div id="seccion2" class="contenido">Contenido de Guía de Salida</div>
<div id="seccion3" class="contenido">Contenido de Informe Técnico</div>
<div id="seccion4" class="contenido">Contenido de Solicitud de Servicio</div>



@endsection
