

<table id="servicio-informes" class="table table-striped table-bordered table-hover">
    <thead class="bg-white">
        <tr>
            <th>Cliente</th>
            <th>Número Documento</th>
            <th>Servicio Tec.</th>
            <th>Orden Servicio</th>
            <th>Fecha Registrada</th>
        </tr>
    </thead>
    <tbody>
        @if($informeTecnico)
            <tr class="gradeX">
                <td>{{ $informeTecnico->servicioGuia->cliente->nombre }}</td>
                <td>{{ $informeTecnico->servicioGuia->cliente->numero_documento }}</td>
                <td>{{ $informeTecnico->servicioGuia->nro_servicio_guia }}</td>
                <td>{{ $informeTecnico->servicioGuia->orden_servicio }}</td>
                <td>{{ $informeTecnico->servicioGuia->fecha_creacion }}</td>
            </tr>
        @else
            <tr>
                <td colspan="6">No se encontró información del informe técnico.</td>
            </tr>
        @endif
    </tbody>
</table>

<!-- nueva tabla -->
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
        @else
            <tr>
                <td colspan="4">No hay egresos registrados para este informe técnico.</td>
            </tr>
        @endif
    </tbody>
</table>
