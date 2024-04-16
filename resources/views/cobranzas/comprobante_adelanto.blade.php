<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adelanto/PDF</title>{{--
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
    <style type="text/css">
        .form-control,
        .single-line {
            background-color: #FFFFFF;
            background-image: none;
            border: 1px solid #e5e6e7;
            border-radius: 1px;
            color: inherit;
            display: block;
            padding: 6px 12px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
            width: 100%;
        }

        @page {
            size: A4;
            font-size: 55% !important;
        }
    </style>
</head>

<body class="white-bg">
    <table style="width: 100%;border-collapse:separate;margin-bottom: -10px">
        <tr>
            @include('layout_cabecera_ventas_pdf')
            <td style="width: 30%; border: 1px #3D3D3D solid;border-radius: 8px;margin-top: 0px" align="right">
                <center>
                    <h3 style="text-align: center;margin-top: 2px"> R.U.C {{ $empresa->ruc }}</h3>
                    <h2 style="text-align: center;margin: 2px">Registro de Adelanto</h2>
                    <h4 style="text-align: center;margin-bottom: 2px">{{ $comprobante_num }}</h4>
                </center>
            </td>
        </tr>
    </table>
    <div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">
        <table style="width: 100%;border-collapse:separate;margin-top: -20px">
            <tr>
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto">
                    <center><strong style="align-content: center;margin: 5px">Contacto Cliente </strong></center><br>
                    <strong>Nombre o Empresa:</strong>&nbsp;{{ $cliente->nombre }}<br>
                    <strong>{{ $cliente->documento_identificacion }}
                        :</strong>&nbsp;{{ $cliente->numero_documento }}&nbsp;&nbsp;<br>
                    <strong>Dirección:</strong>&nbsp;{{ $cliente->direccion }}<br>
                    <strong>N° Contacto:</strong>&nbsp;{{ $cliente->celular }}
                    @if (isset($cliente->telefono))
                        / {{ $cliente->celular }}
                    @endif
                </td>
                <th style="width: 5%;border-color: white"></th>
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto">
                    <center><strong style="align-content: center;margin: 5px">Datos de Comprobante</strong></center>
                    <br>
                    <strong>Tipo de Moneda:</strong>
                    @if ($adelanto_reg->cuota_cread_id == null)
                        {{-- CREDITO --}}
                        <strong>Cuota al:</strong>&nbsp;&nbsp;Crédito<br>
                        <strong>Cuota N°:</strong>&nbsp;&nbsp;{{ $n_cuota = $adelanto_reg->cuotas->numero_cuota }} <br>
                    @else
                        <strong>Cuota al:</strong>&nbsp;&nbsp;Contado<br>
                        <strong>Cuota N°:</strong>&nbsp;&nbsp; {{ $n_cuota = 1 }}
                    @endif
                    <strong>Tipo de Moneda:</strong>
                    &nbsp;{{ $moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                </td>
            </tr>
        </table>
        <br>
        <div>
            <p>Espero que este mensaje te encuentre bien. En nombre de {{ $empresa->razon_social }}, me complace
                confirmar que hemos recibido un adelanto de dinero por la cantidad de {{ $moneda->simbolo }}
                {{ number_format($adelanto_reg->montos_input, 2) }} en relación con la cuota número
                {{ $n_cuota }} del comprobante {{ $comprobante_num }}.</p>
            <strong>Detalles del Adelanto </strong>
        </div>
        @switch(true)
            @case($adelanto_reg->tipo_pago == 'cheque')
                <table class="table " style="border-top: 0px;">
                    <tbody>
                        <tr>
                            <td><strong>¿Es Diferido?</strong></td>
                            <td>
                                @if ($adelanto_reg->option_input == 1)
                                    Si
                                @else
                                    No
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Numero de Cheque</strong></td>
                            <td>{{ $adelanto_reg->numero_input }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de Cobro</strong></td>
                            <td>{{ Carbon\Carbon::parse($adelanto_reg->fechas_input)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Banco Emisor</strong></td>
                            <td>{{ $adelanto_reg->bancos_input }}</td>
                        </tr>
                        <tr>
                            <td><strong>Beneficiario</strong></td>
                            <td>{{ $adelanto_reg->persona_input }}</td>
                        </tr>
                        <tr>
                            <td><strong>Monto</strong></td>
                            <td>{{ $moneda->simbolo }} {{ number_format($adelanto_reg->montos_input, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>N° de Cuenta</strong></td>
                            <td>{{ $adelanto_reg->adicional_input }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de Emision</strong></td>
                            <td>{{ Carbon\Carbon::parse($adelanto_reg->fecha_emision_input)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Comprobante</strong></td>
                            <td>
                                @if ($adelanto_reg->comprobante == null)
                                    <i>Sin comprobante</i>
                                @else
                                    Con Documento Asociado
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Notas Adicionales</strong></td>
                            <td>
                                @if ($adelanto_reg->notas_adicionales == null)
                                    <i>Sin comprobante</i>
                                @else
                                    {{ $adelanto_reg->notas_adicionales }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @break

            @case($adelanto_reg->tipo_pago == 'tarjeta')
                <table class="table " style="border-top: 0px;">
                    <tbody>
                        <tr>
                            <td><strong>Titular de la Tarjeta</strong></td>
                            <td>{{ $adelanto_reg->persona_input }}</td>
                        </tr>
                        <tr>
                            <td><strong>Banco</strong></td>
                            <td>{{ $adelanto_reg->bancos_input }}</td>
                        </tr>
                        <tr>
                            <td><strong>Monto</strong></td>
                            <td>{{ $moneda->simbolo }} {{ number_format($adelanto_reg->montos_input, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha</strong></td>
                            <td>{{ Carbon\Carbon::parse($adelanto_reg->fechas_input)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Comprobante</strong></td>
                            <td>
                                @if ($adelanto_reg->comprobante == null)
                                    <i>Sin comprobante</i>
                                @else
                                    Con Documento Asociado
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Notas Adicionales</strong></td>
                            <td>
                                @if ($adelanto_reg->notas_adicionales == null)
                                    <i>Sin comprobante</i>
                                @else
                                    {{ $adelanto_reg->notas_adicionales }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @break

            @case($adelanto_reg->tipo_pago == 'efectivo')
                <table class="table " style="border-top: 0px;">
                    <tbody>
                        <tr>
                            <td><strong>Persona que cancela</strong></td>
                            <td>{{ $adelanto_reg->persona_input }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha</strong></td>
                            <td>{{ Carbon\Carbon::parse($adelanto_reg->fechas_input)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Monto</strong></td>
                            <td>{{ $moneda->simbolo }} {{ number_format($adelanto_reg->montos_input, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Notas Adicionales</strong></td>
                            <td>
                                @if ($adelanto_reg->notas_adicionales == null)
                                    <i>Sin comprobante</i>
                                @else
                                    {{ $adelanto_reg->notas_adicionales }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @break

            @case($adelanto_reg->tipo_pago == 'transferencia')
                <table class="table " style="border-top: 0px;">
                    <tbody>
                        <tr>
                            <td><strong>Titular</strong></td>
                            <td>{{ $adelanto_reg->persona_input }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha</strong></td>
                            <td>{{ Carbon::parse($adelanto_reg->fechas_input)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>N° de Cuenta Bancaria</strong></td>
                            <td>{{ $adelanto_reg->adicional_input }}</td>
                        </tr>
                        <tr>
                            <td><strong>N° de Operacion</strong></td>
                            <td>{{ $adelanto_reg->numero_input }}</td>
                        </tr>
                        <tr>
                            <td><strong>Banco Emisior</strong></td>
                            <td>{{ $adelanto_reg->bancos_input }}</td>
                        </tr>
                        <tr>
                            <td><strong>Monto</strong></td>
                            <td>{{ $moneda->simbolo }} {{ number_format($adelanto_reg->montos_input, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Comprobante</strong></td>
                            <td>
                                @if ($adelanto_reg->comprobante == null)
                                    <i>Sin comprobante</i>
                                @else
                                    Con Documento Asociado
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Notas Adicionales</strong></td>
                            <td>
                                @if ($adelanto_reg->notas_adicionales == null)
                                    <i>Sin comprobante</i>
                                @else
                                    {{ $adelanto_reg->notas_adicionales }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @break

        @endswitch
    </div>
</body>
<style>
    * {
        color: black;
        font-family: apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        color: black
    }

    .cero {
        margin-bottom: 0px;

    }

    .table-bordered .blanco {
        border: none;
    }

    .blanco {
        border: none;
        border-color: #3D3D3D;
    }

    .border {
        border-color: #3D3D3D;
        border-width: 1px;
        border-style: solid;
    }

    .table {
        /* width: 100%;
                max-width: 100%; */
        margin-bottom: 1rem;
        background-color: transparent;
        border-top-width: 0px;

    }
</style>

</html>
