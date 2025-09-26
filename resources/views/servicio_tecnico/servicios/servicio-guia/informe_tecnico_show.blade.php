<!-- Contacto Cliente y Condiciones Generales - Cuadros Separados -->
<div class="row" style="padding-bottom: 20px">
    <!-- Contacto Cliente -->
    <div class="col-sm-6">
        <div class="form-control" style="height: auto; min-height: 180px;">
            <h4 style="text-align: center; padding: 10px 0; margin-bottom: 15px; color: #666; font-weight: bold; background-color: #f8f9fa; margin: -1px -1px 15px -1px; border-bottom: 1px solid #ddd;">
                Contacto Cliente
            </h4>

            @if($informeTecnico)
                <div style="text-align: left; padding: 0 15px;">
                    <div style="margin-bottom: 12px;">
                        <strong>Señor(es):</strong> {{ $informeTecnico->servicioGuia->cliente->nombre }}
                    </div>
                    <div style="margin-bottom: 12px;">
                        <strong>DNI:</strong> {{ $informeTecnico->servicioGuia->cliente->numero_documento }}
                    </div>
                    <div style="margin-bottom: 12px;">
                        <strong>Dirección:</strong> {{ $informeTecnico->servicioGuia->cliente->direccion ?? 'No especificada' }}
                    </div>
                    <div class="row">
                        <div class="col-sm-6" style="margin-bottom: 12px;">
                            <strong>Teléfono:</strong> {{ $informeTecnico->servicioGuia->cliente->telefono ?? '00000' }}
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 12px;">
                            <strong>Celular:</strong> {{ $informeTecnico->servicioGuia->cliente->celular ?? '0000000' }}
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info" style="margin: 15px;">
                    <i class="fa fa-info-circle"></i> No se encontró información del cliente.
                </div>
            @endif
        </div>
    </div>

    <!-- Condiciones Generales -->
    <div class="col-sm-6">
        <div class="form-control" style="height: auto; min-height: 180px;">
            <h4 style="text-align: center; padding: 10px 0; margin-bottom: 15px; color: #666; font-weight: bold; background-color: #f8f9fa; margin: -1px -1px 15px -1px; border-bottom: 1px solid #ddd;">
                Condiciones Generales
            </h4>

            @if($informeTecnico)
                <div style="text-align: left; padding: 0 15px;">
                    <div style="margin-bottom: 12px;">
                        <strong>Forma De Pago:</strong> Crédito
                    </div>
                    <div style="margin-bottom: 12px;">
                        <strong>Validez:</strong> 1 día
                    </div>
                    <div style="margin-bottom: 12px;">
                        <strong>Garantía:</strong> A CONVENIR
                    </div>
                    <div style="margin-bottom: 12px;">
                        <strong>Tipo de Moneda:</strong> soles
                    </div>
                    <div style="margin-bottom: 12px;">
                        <strong>Fecha:</strong> {{ $informeTecnico->servicioGuia->fecha_creacion }}
                    </div>
                </div>
            @else
                <div class="alert alert-info" style="margin: 15px;">
                    <i class="fa fa-info-circle"></i> No se encontró información del servicio.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Información del Servicio Técnico - Simplificada -->
<div class="row" style="padding-bottom: 20px">
    <div class="col-sm-12" align="center">
        <div class="form-control" style="height: auto;">
            <h3 style="padding-top:10px; margin-bottom: 20px; color: #333; font-weight: bold;">INFORMACIÓN DEL SERVICIO TÉCNICO</h3>

            @if($informeTecnico)
                <div class="row" style="text-align: left; margin-top: 15px;">
                    <div class="col-sm-6">
                        <div style="margin-bottom: 10px;">
                            <strong>Servicio Téc.:</strong> &nbsp;{{ $informeTecnico->servicioGuia->nro_servicio_guia }}
                        </div>
                        <div style="margin-bottom: 10px;">
                            <strong>Orden Servicio:</strong> &nbsp;{{ $informeTecnico->servicioGuia->orden_servicio }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div style="margin-bottom: 10px;">
                            <strong>Fecha Registrada:</strong> &nbsp;{{ $informeTecnico->servicioGuia->fecha_creacion }}
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info" style="margin-top: 15px;">
                    <i class="fa fa-info-circle"></i> No se encontró información del informe técnico.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Detalle de Equipos y Reparaciones - Tabla Mejorada -->
<div class="table-responsive mt-4">
    <table id="egresos-detalle" class="table table-bordered table-striped table-hover">
        <thead class="bg-white">
            <tr>
                <th style="text-align: center; padding: 12px;">Nombre del Equipo</th>
                <th style="text-align: center; padding: 12px;">Número de Serie</th>
                <th style="text-align: center; padding: 12px;">Observación</th>
                <th style="text-align: center; padding: 12px;">Fecha Inicio Reparación</th>
                <th style="text-align: center; padding: 12px;">Fecha Fin Reparación</th>
                <th style="text-align: center; padding: 12px;">Diagnóstico</th>
                <th style="text-align: center; padding: 12px;">Descripción OS</th>
            </tr>
        </thead>
        <tbody>
            @if($informeTecnico && $informeTecnico->servicioGuia->servicioGuiaIngreso->count() > 0)
                @foreach($informeTecnico->servicioGuia->servicioGuiaIngreso as $ingreso)
                    @if($ingreso->servicioGuiaEgreso->count() > 0)
                        @foreach($ingreso->servicioGuiaEgreso as $egreso)
                            <tr>
                                <td style="padding: 10px;">{{ $ingreso->nombre_equipo ?? '—' }}</td>
                                <td style="padding: 10px;">{{ $ingreso->nro_serie ?? '—' }}</td>
                                <td style="padding: 10px;">{{ $ingreso->observacion ?? '—' }}</td>
                                <td style="padding: 10px; text-align: center;">{{ $egreso->fecha_inicio_reparacion ?? '—' }}</td>
                                <td style="padding: 10px; text-align: center;">{{ $egreso->fecha_fin_reparacion ?? '—' }}</td>
                                <td style="padding: 10px;">{{ $egreso->diagnostico ?? '—' }}</td>
                                <td style="padding: 10px;">{{ $egreso->descripcion_os ?? '—' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="padding: 10px;">{{ $ingreso->nombre_equipo ?? '—' }}</td>
                            <td style="padding: 10px;">{{ $ingreso->nro_serie ?? '—' }}</td>
                            <td style="padding: 10px;">{{ $ingreso->observacion ?? '—' }}</td>
                            <td style="padding: 10px; text-align: center;" colspan="4">
                                <span class="badge badge-warning">Sin egresos registrados</span>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #666;">
                        <i class="fa fa-info-circle"></i> No hay equipos registrados para este informe técnico.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Resumen de Costos/Totales -->
<div class="row" style="padding-top: 40px">
    <div class="col-sm-8">
        <h3 align="left">
            Son: Cuarenta y dos con 48/100 soles
        </h3>
    </div>
    <div class="col-sm-4 form-control">
        <span style="display: block;float: left">Subtotal:</span>
        <span style="display: block;float: right;">S/ 36.00</span>
        <br>
        <span style="display: block;float: left">Op. Gravada:</span>
        <span style="display: block;float: right">S/ 36.00</span><br>
        <span style="display: block;float: left">Op. Inafecta:</span>
        <span style="display: block;float: right">S/ 0.00</span><br>
        <span style="display: block;float: left">Op. Exonerada:</span>
        <span style="display: block;float: right">S/ 0.00</span><br>
        <span style="display: block;float: left">I.G.V.:</span>
        <span style="display: block;float: right">S/ 6.48</span><br>
        <span style="display: block;float: left">Importe Total:</span>
        <span style="display: block;float: right">S/ 42.48</span>
    </div>
</div>

<!-- Información de Contacto -->
<div class="row" style="margin-top: 30px; padding: 20px 0; border-top: 2px solid #ddd;">
    <div class="col-sm-8">
        <div style="font-size: 14px; line-height: 1.5;">
            <strong>Atendido por:</strong><br><br>
            <strong>Teléfono:</strong> 013308292<br>
            <strong>Celular:</strong> 910675119<br>
            <strong>Email:</strong> desarrollo@jypsac.com<br>
            <strong>Web:</strong> www.jypsac.com/
        </div>
    </div>
    <div class="col-sm-4" style="text-align: right;">
        <div style="font-size: 16px; font-weight: bold; color: #555;">
            JYP Periféricos SAC
        </div>
    </div>
</div>




<style>
/* Estilos adicionales para mejorar la apariencia */
.form-control {
    border-radius: 8px;
    border: 1px solid #ddd;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.badge-info {
    background-color: #17a2b8;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.table thead th {
    background-color: #f8f9fa !important;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
    border-radius: 6px;
}

/* Estilos para los cuadros de contacto y condiciones */
h4 {
    font-size: 16px;
}

/* Estilos para la sección bancaria */
.col-sm-3 > div {
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Responsive para móviles */
@media (max-width: 768px) {
    .col-sm-3, .col-sm-6 {
        margin-bottom: 15px;
    }

    .row[style*="text-align: left"] .col-sm-6 {
        margin-bottom: 10px;
    }
}
</style>
                    <br>
                    @include('layout_bancos')
                    <br>

<!-- <table id="servicio-informes" class="table table-striped table-bordered table-hover">
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

nueva tabla -->
<!-- <table id="egresos-detalle" class="table table-bordered table-striped table-hover mt-4">
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
</table>  -->
