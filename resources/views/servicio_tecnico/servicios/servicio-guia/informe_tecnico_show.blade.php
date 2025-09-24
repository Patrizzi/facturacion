@extends('layout')

@section('title', 'Ver Informe Técnico de Servicio')
@section('breadcrumb', 'Ver Informe Técnico de Servicio')
@section('breadcrumb2', 'Informe Técnico')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')

@section('button2', 'Inicio')
@section('config', route('servicio.index'))

@section('content')

    <!-- Contenedor principal con cuadro blanco -->
    <div class="row">
        <div class="col-lg-12" style="margin-top: -2px">
            <div class="ibox-content p-xl" style="margin-bottom: 2px;padding-bottom: 50px;">
            
                <!-- Información del cliente y condiciones generales -->
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control" style="height: 90%">
                            <h3>Contacto Cliente</h3>
                            @if($informeTecnico)
                                <div align="left">
                                    <strong>Señor(es):</strong> &nbsp;{{$informeTecnico->servicioGuia->cliente->nombre}}<br>
                                    <strong>{{$informeTecnico->servicioGuia->cliente->documento_identificacion ?? 'DNI'}} :</strong> &nbsp;{{$informeTecnico->servicioGuia->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Teléfono:</strong>&nbsp;{{$informeTecnico->servicioGuia->cliente->telefono ?? '00000'}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Correo:</strong>&nbsp; {{$informeTecnico->servicioGuia->cliente->email ?? 'No especificado'}}<br>
                                    <strong>Dirección:</strong>&nbsp; {{$informeTecnico->servicioGuia->cliente->direccion ?? 'No especificada'}}<br>
                                    <strong>Celular:</strong>&nbsp; {{$informeTecnico->servicioGuia->cliente->celular ?? '0000000'}}<br>
                                </div>
                            @else
                                <div align="left">
                                    <em>No hay información del cliente disponible</em>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" style="height: 90%">
                            <h3>Condiciones Generales</h3>
                            @if($informeTecnico)
                                <div align="left">
                                    <strong>Servicio Técnico:</strong>&nbsp;{{$informeTecnico->servicioGuia->nro_servicio_guia}}<br>
                                    <strong>Orden de Servicio:</strong>&nbsp;{{$informeTecnico->servicioGuia->orden_servicio}}<br>
                                    <strong>Fecha Registro:</strong>&nbsp;{{date("d/m/Y", strtotime($informeTecnico->servicioGuia->fecha_creacion))}}<br>
                                </div>
                            @else
                                <div align="left">
                                    <em>No hay información de condiciones disponible</em>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <br>

                <!-- Nueva tabla de egresos -->
                <table id="egresos-detalle" class="table table-bordered table-striped table-hover mt-4">
                    <thead class="bg-white">
                        <tr>
                            <th>Nombre del Equipo</th>
                            <th>Número del Serie</th>
                            <th>Observación</th>
                            <th>Fecha Inicio Reparación</th>
                            <th>Fecha Fin Reparación</th>
                            <th>Diagnóstico</th>
                            <th>Descripción OS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($informeTecnico)
                            @foreach($informeTecnico->servicioGuia->servicioGuiaIngreso as $ingreso)
                                @foreach($ingreso->servicioGuiaEgreso as $egreso)
                                    <tr>
                                        <td>{{ $ingreso->nombre_equipo}}</td>
                                        <td>{{ $ingreso->nro_serie}}</td>
                                        <td>{{ $ingreso->observacion}}</td>
                                        <td>{{ $egreso->fecha_inicio_reparacion ?? '—' }}</td>
                                        <td>{{ $egreso->fecha_fin_reparacion ?? '—' }}</td>
                                        <td>{{ $egreso->diagnostico ?? '—' }}</td>
                                        <td>{{ $egreso->descripcion_os ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endif
                    </tbody>
                </table>
        
            </div>
        </div>
    </div>

<style>
#auto {
    cursor: pointer;
    box-shadow: 0px 0px 1px #000;
    display: inline-block;
}

#auto:hover {
    opacity: .8;
}

#div-mostrar {
    margin: auto;
    height: 0px;
    transition: height .4s;
    color: white;
    text-align: right;
}

#auto:hover + #div-mostrar {
    height: 50px;
}

.ibox-content {
    background-color: #ffffff;
    border: 1px solid #e7eaec;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}

.form-control {
    background-color: #ffffff;
    border: 1px solid #e5e6e7;
    border-radius: 1px;
    color: #676a6c;
    display: block;
    font-size: 14px;
    line-height: 1.5; /* un poco más espacio entre líneas */
    padding: 40px 20px; /* más espacio arriba, abajo, izquierda y derecha */
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    width: 100%;
    box-sizing: border-box; /* para que el padding no rompa el tamaño */
}
</style>

<!-- Scripts necesarios -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

@endsection
