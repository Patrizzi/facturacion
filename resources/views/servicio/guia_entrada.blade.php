@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
<table>
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
</table>

<table>
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
</table>

@endsection

