<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Guía de Remisión Manual</title>

    <style>
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

        .logo {
            max-height: 67px;
        }

        .ruc-box {
            border: 1px solid #111;
            border-radius: 6px;
            padding: 8px 10px;
            text-align: center;
            min-width: 210px;
        }

        .title {
            margin: 3px 0px;
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

        @media print {
            @page {
                size: auto;
                margin: 0mm;
            }

            body {
                font-size: 8.6px;
                margin: 10mm 15mm;
            }
        }
    </style>

    <script>
        // Imprime automáticamente al abrir y cierra la ventana al terminar (si fue popup)
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.focus();
                window.print();
            }, 150);
        });
        window.addEventListener('afterprint', function() {
            if (window.opener) {
                try {
                    window.close();
                } catch (e) {}
            }
        });
    </script>
</head>

<body>
    <div class="sheet">
        {{-- Encabezado --}}
        <div class="row" style="align-items:flex-start; margin-bottom:8px;">
            <div class="col">
                <div class="row" style="align-items:center !important; gap:10px;">
                    @if (!empty($empresa->foto))
                        <img class="logo" src="{{ asset('img/logos/' . $empresa->foto) }}" alt="logo">
                    @else
                        <div style="font-size:14px; font-weight:700;">{{ $empresa->nombre ?? 'EMPRESA' }}</div>
                    @endif
                </div>
                <div class="muted" style="margin-top:4px;">{{ $empresa->calle ?? '' }}</div>
                {{-- <div class="muted">R.U.C.: {{ $empresa->ruc ?? '' }}</div> --}}
            </div>

            <div class="ruc-box">
                <div style="font-weight:700;">R.U.C. N° {{ $empresa->ruc ?? '' }}</div>
                <div class="title">GUÍA DE REMISIÓN<br>ELECTRÓNICA</div>
                <div class="serie">{{ $guia_remision_m->cod_guia }}</div>
            </div>
        </div>
        @if ($guia_remision_m->g_electronica == 2 || $guia_remision_m->estado_anulado == 1)
            <div id="watermark">
                <p>Anulado</p>
            </div>
        @endif
        {{-- Partida / Llegada --}}
        <div class="grid-2">
            <div class="box">
                <div class="box-title">DOMICILIO DE PARTIDA</div>
                <div><b>Dirección:</b> {{ $guia_remision_m->almacen->direccion ?? '' }}</div>
                <div><b>Ubigeo:</b> {{ $guia_remision_m->almacen->cod_postal ?? '' }}</div>
                <div><b>Código:</b> {{ $guia_remision_m->almacen->cod_postal ?? '' }}</div>
            </div>
            <div class="box">
                <div class="box-title">DOMICILIO DE LLEGADA</div>
                <div><b>Dirección:</b>
                    @if (isset($guia_remision_m->sucursal_cliente))
                        {{ $guia_remision_m->sucursal_cliente }}
                    @else
                        {{ $guia_remision_m->cliente->direccion ?? '' }}
                    @endif
                </div>
                <div><b>Ubigeo:</b>
                    @if (isset($guia_remision_m->cod_postal_cliente))
                        {{ $guia_remision_m->cod_postal_cliente }}
                    @else
                        {{ $guia_remision_m->cliente->cod_postal ?? '' }}
                    @endif
                </div>
                <div><b>Código:</b>
                    @if (isset($guia_remision_m->cod_postal_cliente))
                        {{ $guia_remision_m->cod_postal_cliente }}
                    @else
                        {{ $guia_remision_m->cliente->cod_postal ?? '' }}
                    @endif
                </div>
            </div>
        </div>

        {{-- Destinatario + Transporte / Envío --}}
        <div class="grid-gap" style="margin-top:8px;">
            <div class="box">
                <div class="box-title">DESTINATARIO</div>
                <div><b>Señor(es):</b> {{ $guia_remision_m->cliente->nombre ?? '' }}</div>
                <div><b>N° Identificación:</b> {{ $guia_remision_m->cliente->numero_documento ?? '' }}</div>
                <div><b>Dirección:</b>
                    @if (isset($guia_remision_m->sucursal_cliente))
                        {{ $guia_remision_m->sucursal_cliente }}
                    @else
                        {{ $guia_remision_m->cliente->direccion ?? '' }}
                    @endif
                </div>
            </div>

            <div class="grid-2">
                <div class="box">
                    <div class="box-title">UNIDAD DE TRANSPORTE/CONDUCTOR</div>
                    @if (isset($guia_remision_m->vehiculo_id))
                        <div><b>Placa del Vehículo:</b> {{ $guia_remision_m->vehiculo->placa ?? '' }}</div>
                        <div><b>Marca del Vehículo:</b> {{ $guia_remision_m->vehiculo->marca ?? '' }}</div>
                        <div><b>Conductor:</b> {{ $guia_remision_m->personal->nombres ?? '' }}</div>
                        <div><b>N° Licencia:</b> -</div>
                    @elseif(isset($guia_remision_m->vehiculo_publico))
                        <div><b>Empresa:</b> {{ $guia_remision_m->vehiculo_publicos->nombre ?? '' }}</div>
                        <div><b>RUC:</b> {{ $guia_remision_m->vehiculo_publicos->ruc ?? '' }}</div>
                        <div><b>Nota:</b> Esta Empresa es Pública</div>
                        <div><b>N° Licencia:</b> -</div>
                    @else
                        <div><b>Placa del Vehículo:</b> No Hay Vehículo</div>
                        <div><b>Marca del Vehículo:</b> No Hay Vehículo</div>
                        <div><b>Conductor:</b>
                            @if (isset($guia_remision_m->conductor_id))
                                {{ $guia_remision_m->personal->nombres ?? '' }}
                            @else
                                No Hay Conductor
                            @endif
                        </div>
                        <div><b>N° Licencia:</b> -</div>
                    @endif
                </div>

                <div class="box">
                    <div class="box-title">DATOS DE ENVÍO</div>
                    <div><b>Motivo de traslado:</b> {{ $guia_remision_m->motivo_traslado ?? '' }}</div>
                    @php
                        $pesoTotal = 0;
                        foreach ($guia_remision_m_reg as $reg) {
                            $pesoTotal += $reg->cantidad * $reg->peso;
                        }
                    @endphp
                    <div><b>Peso bruto total carga:</b> {{ number_format($pesoTotal, 2) }} kg</div>
                    <div><b>N° Bultos o Pallets:</b> -</div>
                    <div><b>Modalidad:</b> -</div>
                    <div><b>Fecha Emisión:</b> {{ $guia_remision_m->fecha_emision ?? '' }}</div>
                    <div><b>Inicio traslado:</b> {{ $guia_remision_m->fecha_entrega ?? '' }}</div>
                </div>
            </div>
        </div>

        <div class="box" style="margin-top:8px;">
            <div class="box-title">BIENES A TRASLADAR</div>
            <table>
                <thead>
                    <tr>
                        <th style="width:5%" class="tac">N°</th>
                        <th style="width:11%" class="tac">CÓDIGO</th>
                        {{-- <th style="width:80px" class="tac">CÓDIGO SUNAT</th> --}}
                        <th>DESCRIPCIÓN</th>
                        <th style="width:10%" class="tac">UNIDAD</th>
                        <th style="width:10%" class="tac">CANTIDAD</th>
                        <th style="width:10%" class="tac">PESO U.</th>
                        <th style="width:10%" class="tac">PESO TOT</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i = 1)
                    @foreach ($guia_remision_m_reg as $guia_registros)
                        @php($pesoItem = $guia_registros->cantidad * $guia_registros->peso)
                        @php($tota[]= $pesoItem)
                        <tr>
                            <td class="tac">{{ $i++ }}</td>
                            <td class="tac">{{ $guia_registros->producto->codigo_producto ?? '-' }}</td>
                            {{-- <td class="tac">{{ $guia_registros->producto->codigo_sunat ?? '-' }}</td> --}}
                            <td>
                                {{ $guia_registros->producto->nombre ?? '' }}
                                @if (!empty($guia_registros->numero_serie) || !empty($guia_registros->descripcion))
                                    <div class="desc-small">
                                        {{ $guia_registros->numero_serie }}
                                        @if (!empty($guia_registros->descripcion))
                                            — {{ $guia_registros->descripcion }}
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="tac">{{ $guia_registros->producto->unidad_i_producto->medida ?? 'NIU' }}</td>
                            <td class="tac">{{ $guia_registros->cantidad }}</td>
                            <td class="tac">{{ $guia_registros->peso }}</td>
                             <td class="tac">{{ number_format( $pesoItem, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" class="tar"><b>Peso Total:</b></td>
                        <td class="tac"><b>{{ number_format(array_sum($tota), 2) }} KGM</b></td>
                    </tr>
                   
                </tbody>
            </table>
        </div>

        <div class="footer-wrap">
            <div class="footer">
                <div class="col">
                    <div class="desc-small">
                        REPRESENTACIÓN IMPRESA DE GUÍA DE REMISIÓN ELECTRÓNICA.
                        LA MERCADERÍA VIAJA POR RIESGO Y CUENTA DEL CLIENTE.
                    </div>
                    @if (!empty($guia_remision_m->observacion))
                        <div class="desc-small" style="margin-top:6px;">
                            <b>Observación:</b> {{ $guia_remision_m->observacion }}
                        </div>
                    @endif
                </div>
                <div class="qr">
                    @if (!empty($qrCode))
                        <img src="{{ $qrCode }}" alt="Código QR">
                    @else
                        <span class="qr-placeholder">QR</span>
                    @endif
                </div>
                <div class="sign-wrap">
                    <div class="sign"></div>
                    <div class="sign-caption">RECIBÍ<br>CONFORME</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
