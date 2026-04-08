<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Técnico PDF</title>
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
</head>

<style type="text/css">
    .form-control,
    .single-line {
        background-color: #FFFFFF;
        background-image: none;
        border: 1px solid #808080;
        border-radius: 10px;
        color: inherit;
        display: block;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        width: 100%;
    }

    * {
        color: black;
        font-family: apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        border-color: #3D3D3D;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
        border-top-width: 0px;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 6px 8px;
        vertical-align: top;
    }

    .border {
        border-color: #3D3D3D;
        border-width: 1px;
        border-style: solid;
    }

    #watermark {
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 0;
    }

    #watermark p {
        position: absolute;
        color: rgba(120, 120, 120, 0.31);
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
        font-weight: bolder;
        font-size: 95px;
        pointer-events: none;
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        top: 35%;
        right: 33%;
        z-index: 0;
    }

    .small-print {
        font-size: 70%;
    }

</style>

<body class="white-bg">
    <table style="width: 100%; border-collapse: separate; margin-bottom: -10px;">
        <tr>
            @include('layout_cabecera_ventas_pdf')
            <td style="width: 30%; border: 1px #3D3D3D solid; border-radius: 8px;" align="right">
                <center>
                    <h3 style="text-align: center; margin-top: 2px">R.U.C {{ $empresa->ruc ?? '-' }}</h3>
                    <h2 style="text-align: center; margin: 2px">INFORME TÉCNICO</h2>
                    <h4 style="text-align: center; margin-bottom: 2px">{{ $servicioGuia->nro_servicio_guia ?? '-' }}</h4>
                </center>
            </td>
        </tr>
    </table>

    <div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px;">
        <table style="width: 100%; border-collapse: separate; margin-top: -20px;">
            <tr>
                <td colspan="2" style="border: 1px #3D3D3D solid; border-radius: 8px; width: auto;">
                    <strong>Cliente:</strong>&nbsp;{{ $servicioGuia->cliente->nombre ?? '-' }}<br>
                    <strong>{{ $servicioGuia->cliente->documento_identificacion ?? 'DNI' }}:</strong>&nbsp;{{ $servicioGuia->cliente->numero_documento ?? '-' }}<br>
                    <strong>Dirección:</strong>&nbsp;{{ $servicioGuia->cliente->direccion ?? 'No especificada' }}<br>
                    <strong>Teléfono:</strong>&nbsp;{{ $servicioGuia->cliente->telefono ?? '-' }}&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Celular:</strong>&nbsp;{{ $servicioGuia->cliente->celular ?? '-' }}<br>
                    <strong>Correo:</strong>&nbsp;{{ $servicioGuia->cliente->email ?? 'No especificado' }}<br>
                </td>

                <th style="width: 5%; border-color: white;"></th>

                <td colspan="2" style="border: 1px #3D3D3D solid; border-radius: 8px; width: auto;">
                    <strong>N° Servicio Técnico:</strong>&nbsp;{{ $servicioGuia->nro_servicio_guia ?? '-' }}<br>
                    <strong>Orden de Servicio:</strong>&nbsp;{{ $servicioGuia->orden_servicio ?? '-' }}<br>
                    <strong>Fecha de Registro:</strong>&nbsp;{{ !empty($servicioGuia->fecha_creacion) ? date('d/m/Y', strtotime($servicioGuia->fecha_creacion)) : '-' }}<br>
                    <strong>Fecha de Informe:</strong>&nbsp;{{ !empty($informeTecnico->created_at) ? \Carbon\Carbon::parse($informeTecnico->created_at)->format('d/m/Y') : '-' }}<br>
                </td>
            </tr>
        </table>

        <br>

        <div class="table-responsive">
            <table class="table" style="border-top: 0px; border-color: #808080;">
                <thead style="border-color: #808080;">
                    <tr>
                        <th style="text-align: center; width: 5%;">ITEM</th>
                        <th style="text-align: left; width: 16%;">EQUIPO</th>
                        <th style="text-align: center; width: 12%;">N° SERIE</th>
                        <th style="text-align: left; width: 16%;">OBSERVACIÓN</th>
                        <th style="text-align: center; width: 12%;">F. INICIO</th>
                        <th style="text-align: center; width: 12%;">F. FIN</th>
                        <th style="text-align: left; width: 14%;">DIAGNÓSTICO</th>
                        <th style="text-align: left; width: 13%;">DESCRIPCIÓN O/S</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp

                    @forelse ($servIngresoEquipos as $ingreso)
                    @php
                    $egresosRelacionados = $servEgresosEquipos->where('servicio_g_ingreso_id', $ingreso->id);
                    @endphp

                    @if ($egresosRelacionados->count() > 0)
                    @foreach ($egresosRelacionados as $egreso)
                    <tr>
                        <td style="text-align:center;">{{ $i++ }}</td>
                        <td>{{ $ingreso->nombre_equipo ?? '-' }}</td>
                        <td style="text-align:center;">{{ $ingreso->nro_serie ?? '-' }}</td>
                        <td>{{ $ingreso->observacion ?? '-' }}</td>
                        <td style="text-align:center;">
                            {{ !empty($egreso->fecha_inicio_reparacion) ? \Carbon\Carbon::parse($egreso->fecha_inicio_reparacion)->format('d/m/Y') : '—' }}
                        </td>
                        <td style="text-align:center;">
                            {{ !empty($egreso->fecha_fin_reparacion) ? \Carbon\Carbon::parse($egreso->fecha_fin_reparacion)->format('d/m/Y') : '—' }}
                        </td>
                        <td>{{ $egreso->diagnostico ?? '—' }}</td>
                        <td>{{ $egreso->descripcion_os ?? '—' }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td style="text-align:center;">{{ $i++ }}</td>
                        <td>{{ $ingreso->nombre_equipo ?? '-' }}</td>
                        <td style="text-align:center;">{{ $ingreso->nro_serie ?? '-' }}</td>
                        <td>{{ $ingreso->observacion ?? '-' }}</td>
                        <td style="text-align:center;">—</td>
                        <td style="text-align:center;">—</td>
                        <td>—</td>
                        <td>—</td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;">No hay registros para mostrar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <br><br>

        <table style="width: 100%; border-collapse: separate;">
            <tr>
                <td style="border: 1px #808080 solid; border-radius: 8px; width: 100%; min-height: 120px;">
                    <strong>Conclusión / Resumen del Informe:</strong><br><br>
                    {{ $informeTecnico->observacion ?? $informeTecnico->descripcion ?? 'Sin observaciones registradas.' }}
                </td>
            </tr>
        </table>

        <br>

        <small class="small-print">
            Representación impresa de <strong>INFORME TÉCNICO</strong>
        </small><br>
        <small class="small-print">
            Documento generado desde el módulo de Servicio Técnico
        </small>
    </div>
</body>
</html>
