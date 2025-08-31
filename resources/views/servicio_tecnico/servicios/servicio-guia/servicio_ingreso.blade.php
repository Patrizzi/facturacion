<br>
<div class="table-responsive">
    <table id="servicio-guias-ingresos" class="table table-striped table-bordered table-hover">
        <thead class="bg-white">
            <tr>
                <th>Equipo</th>
                <th>Serie</th>
                <th>Observación</th>
                <th>Fecha registrada</th>
            </tr>
        </thead>
        <tbody>
            {{-- total equipos ingresos --}}
            <input type="hidden" name="total_serv_ingresos" value={{ $servIngresoEquipos->count() }}>

            @foreach ($servIngresoEquipos as $ingresoEquipo)
                <tr class="gradeX">
                    <td>{{ $ingresoEquipo->nombre_equipo }}</td>
                    <td>{{ $ingresoEquipo->nro_serie }}</td>
                    <td>{{ $ingresoEquipo->observacion }}</td>
                    <td>{{ $ingresoEquipo->fecha_agregada }}</td>
                </tr>
           @endforeach
        </tbody>
    </table>
</div>
