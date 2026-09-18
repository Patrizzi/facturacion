<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía de Remisión</title>
    <style>
        /* ========== BASE ========== */
        html,
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
        }

        body {
            font-size: 9px;
            line-height: 1.25;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            background: #fff;
            margin: 0;
            padding: 20px;
        }

        /* ========== LAYOUT ========== */
        .row {
            display: flex;
            gap: 8px;
        }

        .col {
            flex: 1 1 0;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .grid-gap {
            display: grid;
            gap: 8px;
        }

        /* ========== COMPONENTES ========== */

        .ruc-box {
            border: 1px solid #111;
            border-radius: 6px;
            padding: 8px 10px;
            text-align: center;
            min-width: 210px;
        }

        .ruc-box .title,
        .ruc-box .serie {
            font-weight: 700;
            font-size: 12px;
        }

        .box {
            border: 1px solid #111;
            border-radius: 6px;
            padding: 6px;
        }

        .box-title {
            font-weight: 700;
            margin-bottom: 4px;
        }

        /* ========== TABLA ========== */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #111;
            padding: 4px 5px;
            vertical-align: top;
        }

        th {
            background: #f2f2f2;
            font-weight: 700;
        }

        /* ========== PIE DE PÁGINA ========== */
        .footer {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 10px;
        }

        .qr {
            width: 90px;
            height: 90px;
            border: 1px solid #111;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2px;
            flex-shrink: 0;
            background: #fff;
        }

        .qr img {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }

        .qr-placeholder {
            font-size: 10px;
            color: #999;
            text-align: center;
        }

        .sign {
            width: 130px;
            height: 60px;
            border: 1px solid #111;
            border-radius: 8px;
            display: block;
        }

        .sign-wrap {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .sign-caption {
            font-weight: 700;
            line-height: 1;
            text-align: center;
            font-size: 10px;
            text-transform: uppercase;
        }

        /* ========== UTILIDADES ========== */
        .muted {
            color: #444;
        }

        .tac {
            text-align: center;
        }

        .tar {
            text-align: right;
        }

        .desc-small {
            font-size: 8px;
            color: #333;
            margin-top: 2px;
        }

        @page {
            size: A4;
            /* font-size: 60% !important; */
        }

        table,
        tr,
        td,
        th {
            page-break-inside: avoid !important;
        }

        .box,
        .footer {
            page-break-inside: avoid !important;
        }

        @media print {
            body {
                page-break-after: avoid !important;
                page-break-before: avoid !important;
            }
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
            font-size: 95px !important;
            pointer-events: none;
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            top: 25%;
            right: 25%;
            z-index: 0;
        }
    </style>
</head>

<body class="white-bg" >
    <div class="sheet" >
        {{-- Encabezado --}}
        <table style="width: 100%;border-collapse:separate;margin-bottom: 0px; page-break-inside: avoid;">
            <tr>
                <td style="width: 30%;border-color: white" >
                    @if (!empty($empresa->foto))
                        <img class="logo" src="{{ asset('img/logos/' . $empresa->foto) }}"
                            style="max-height: 60px; !important" alt="logo">
                    @else
                        <div style="font-size:14px; font-weight:700;">{{ $empresa->nombre ?? 'EMPRESA' }}</div>
                    @endif
                    <div class="muted" style="margin-top:3px;color: #444;font-size: 6px !important">{{ $empresa->calle ?? '' }}</div>
                </td>
                <td style="width: 30%;border-color: white;text-align: center;">
                </td>
                <td style="width: 30%; border: 1px solid #111; border-radius: 8px;margin-top: 0px" align="right">
                    <center>
                        <h3 style="text-align: center;margin: 1px">R.U.C N° {{ $empresa->ruc }}</h3>
                        <h2 style="font-size: 15px;text-align: center;margin: 1px">GUIA REMISION<br>ELECTRÓNICA</h2>
                        <h4 style="text-align: center;margin: 1px">{{ $guia_remision->cod_guia }}</h5>
                    </center>
                </td>
            </tr>
        </table>

        {{-- Partida / Llegada --}}
        <table style="width: 100%;border-collapse:separate;margin-bottom: 5px;border-color: white; page-break-inside: avoid;">
            <tr style="margin: 0px;padding: 0px">
                <td style="width: 50%;border-color: white;margin: 0px;padding: 0px;padding-right: 4px">
                    <div class="box">
                        <div class="box-title">DOMICILIO DE PARTIDA</div>
                        <div><b>Dirección:</b> {{ $guia_remision->almacen->direccion ?? '' }}</div>
                        <div><b>Ubigeo:</b> {{ $guia_remision->almacen->cod_postal ?? '' }}</div>
                        <div><b>Código:</b> {{ $guia_remision->almacen->cod_postal ?? '' }}</div>
                    </div>
                </td>
                <td style="width: 50%;border-color: white;margin: 0px;padding: 0px;padding-left: 4px">
                    <div class="box">
                        <div class="box-title">DOMICILIO DE LLEGADA</div>
                        <div><b>Dirección:</b>
                            @if (isset($guia_remision->sucursal_cliente))
                                {{ $guia_remision->sucursal_cliente }}
                            @else
                                {{ $guia_remision->cliente->direccion ?? '' }}
                            @endif
                        </div>
                        <div><b>Ubigeo:</b>
                            @if (isset($guia_remision->cod_postal_cliente))
                                {{ $guia_remision->cod_postal_cliente }}
                            @else
                                {{ $guia_remision->cliente->cod_postal ?? '' }}
                            @endif
                        </div>
                        <div><b>Código:</b>
                            @if (isset($guia_remision->cod_postal_cliente))
                                {{ $guia_remision->cod_postal_cliente }}
                            @else
                                {{ $guia_remision->cliente->cod_postal ?? '' }}
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Destinatario + Transporte / Envío --}}
        <table style="width: 100%;border-collapse:separate;margin-bottom: 5px;border-color: white; page-break-inside: avoid;">
            <tr style="margin: 0px;padding: 0px">
                <td style="width: 100%;border-color: white;margin: 0px;padding: 0px;">
                    <div class="box">
                        <div class="box-title">DESTINATARIO</div>
                        <div><b>Señor(es):</b> {{ $guia_remision->cliente->nombre ?? '' }}</div>
                        <div><b>N° Identificación:</b> {{ $guia_remision->cliente->numero_documento ?? '' }}</div>
                        <div><b>Dirección:</b>
                            @if (isset($guia_remision->sucursal_cliente))
                                {{ $guia_remision->sucursal_cliente }}
                            @else
                                {{ $guia_remision->cliente->direccion ?? '' }}
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        @if ($guia_remision->g_electronica == 2 || $guia_remision->estado_anulado == 1)
            <div id="watermark">
                <p>Anulado</p>
            </div>
        @endif
        <table style="width: 100%;border-collapse:separate;margin-bottom: 5px;border-color: white;page-break-inside: avoid;">
            <tr style="margin: 0px;padding: 0px">
                <td style="width: 50%;border-color: white;margin: 0px;padding: 0px;padding-right: 4px">
                    <div class="box">
                        <div class="box-title">UNIDAD DE TRANSPORTE/CONDUCTOR</div>
                        @if (isset($guia_remision->vehiculo_id))
                            <div><b>Placa del Vehículo:</b> {{ $guia_remision->vehiculo->placa ?? '' }}</div>
                            <div><b>Marca del Vehículo:</b> {{ $guia_remision->vehiculo->marca ?? '' }}</div>
                            <div><b>Conductor:</b> {{ $guia_remision->personal->nombres ?? '' }}</div>
                            <div><b>N° Licencia:</b> {{ $guia_remision->personal->licencia ?? '-' }}</div>
                        @elseif(isset($guia_remision->vehiculo_publico))
                            <div><b>Empresa:</b> {{ $guia_remision->vehiculo_publicos->nombre ?? '' }}</div>
                            <div><b>RUC:</b> {{ $guia_remision->vehiculo_publicos->ruc ?? '' }}</div>
                            <div><b>Nota:</b> Esta Empresa es Pública</div>
                            <div><b>N° Licencia:</b> -</div>
                        @else
                            <div><b>Placa del Vehículo:</b> No Hay Vehículo</div>
                            <div><b>Marca del Vehículo:</b> No Hay Vehículo</div>
                            <div><b>Conductor:</b>
                                @if (isset($guia_remision->conductor_id))
                                    {{ $guia_remision->personal->nombres ?? '' }}
                                @else
                                    No Hay Conductor
                                @endif
                            </div>
                            <div><b>N° Licencia:</b> -</div>
                        @endif
                    </div>
                </td>
                <td style="width: 50%;border-color: white;margin: 0px;padding: 0px;padding-left: 4px">
                    <div class="box">
                        <div class="box-title">DATOS DE ENVÍO</div>
                        <div><b>Motivo de traslado:</b> {{ $guia_remision->motivo_traslado ?? '' }}</div>
                        <div><b>Peso bruto total carga:</b> {{ number_format($guia_registro->sum('peso'), 2) }} kg
                        </div>
                        <div><b>N° Bultos o Pallets:</b> -</div>
                        <div><b>Modalidad:</b> -</div>
                        <div><b>Fecha Emisión:</b> {{ $guia_remision->fecha_emision ?? '' }}</div>
                        <div><b>Inicio traslado:</b> {{ $guia_remision->fecha_entrega ?? '' }}</div>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Tabla de ítems --}}
        <table style="width: 100%;margin-bottom: 5px;border-color: white;">
            <tr style="margin: 0px;padding: 0px">
                <td style="width: 100%;border-color: white;margin: 0px;padding: 0px;">
                    <div class="box">
                        <div class="box-title">BIENES A TRASLADAR</div>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:5%" class="tac">N°</th>
                                    <th style="width:12%" class="tac">CÓDIGO</th>
                                    <th style="width:12%" class="tac">MARCA</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th style="width:10%" class="tac">UNIDAD</th>
                                    <th style="width:10%" class="tac">CANTIDAD</th>
                                    <th style="width:10%" class="tac">PESO U.</th>
                                    <th style="width:10%" class="tac">PESO T.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach ($guia_registro as $guia_registros)
                                    @php($pesoItem = ($guia_registros->peso / $guia_registros->cantidad ))
                                    @php($tota[] = $pesoItem)
                                    <tr>
                                        <td class="tac">{{ $i++ }}</td>
                                        <td class="tac">{{ $guia_registros->producto->codigo_original ?? '-' }}</td>
                                        <td class="tac">
                                            {{ $guia_registros->producto->marcas_i_producto->nombre ?? '-' }}</td>
                                        <td>
                                            {{ $guia_registros->producto->nombre ?? '' }}
                                            @if (!empty($guia_registros->numero_serie) || !empty($guia_registros->descripcion))
                                                <div class="desc-small">
                                                    @if (!empty($guia_registros->numero_serie))
                                                        N/S: {{ $guia_registros->numero_serie }}
                                                    @endif
                                                    @if (!empty($guia_registros->descripcion))
                                                        {{ $guia_registros->descripcion }}
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="tac">
                                            {{ $guia_registros->producto->unidad_i_producto->medida ?? 'NIU' }}</td>
                                        <td class="tac">{{ $guia_registros->cantidad }}</td>
                                        <td class="tac">{{ number_format($pesoItem,2) }}</td>
                                        <td class="tac">{{ number_format($guia_registros->peso, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7" class="tar"><b>Peso Total:</b></td>
                                    <td class="tac"><b>{{ number_format(array_sum($tota),2) }} kg</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Pie fijo al fondo --}}
        <div class="footer">
            <table style="width: 100%;margin-bottom: 5px;border-color: white;">
                <tr style="margin: 0px;padding: 0px">
                    <td style="width: 60%;border-color: white;margin: 0px;padding: 0px;">
                        <div class="desc-small">
                            REPRESENTACIÓN IMPRESA DE GUÍA DE REMISIÓN ELECTRÓNICA.
                            LA MERCADERÍA VIAJA POR RIESGO Y CUENTA DEL CLIENTE.
                        </div>
                        @if (!empty($guia_remision->observacion))
                            <div class="desc-small" style="margin-top:6px;">
                                <b>Observación:</b> {{ $guia_remision->observacion }}
                            </div>
                        @endif
                    </td>
                    <td style="width: 20%;border-color: white;margin: 0px;padding: 0px;">
                        {{-- Código QR --}}
                        <div class="qr">
                            @if (!empty($qrCode))
                                <img src="{{ $qrCode }}" alt="Código QR">
                            @else
                                <span class="qr-placeholder">QR</span>
                            @endif
                        </div>
                    </td>
                    <td style="width: 20%;border-color: white;margin: 0px;padding: 0px;">
                        {{-- Firma --}}
                        <div class="sign-wrap">
                            <div class="sign"></div>
                            <div class="sign-caption" style="margin-top: 5px">RECIBÍ<br>CONFORME</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
