<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización</title>{{--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
    <style type="text/css">
        .form-control,
        .single-line {
            background-color: #FFFFFF;
            background-image: none;
            border: 1px solid #3D3D3D;
            border-radius: 10px;
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
                    <h2 style="text-align: center;margin: 2px">COTIZACIÓN ELECTRONICA</h2>
                    <h4 style="text-align: center;margin-bottom: 2px">{{ $cotizacion->cod_cotizacion }}</h4>
                </center>
            </td>
        </tr>
    </table>
    <div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">
        <table style="width: 100%;border-collapse:separate;margin-top: -20px">
            <tr>
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto">
                    <center><strong style="align-content: center;margin: 5px">Contacto Cliente </strong></center><br>
                    <strong>Nombre o Empresa:</strong>&nbsp;{{ $cotizacion->cliente->nombre }}<br>
                    <strong>{{ $cotizacion->cliente->documento_identificacion }}
                        :</strong>&nbsp;{{ $cotizacion->cliente->numero_documento }}&nbsp;&nbsp;<br>
                    <strong>Dirección:</strong>&nbsp;{{ $cotizacion->cliente->direccion }}<br>
                    <strong>N° Contacto:</strong>&nbsp;{{ $cotizacion->cliente->celular }}
                    @if (isset($cotizacion->cliente->telefono))
                        / {{ $cotizacion->cliente->celular }}
                    @endif
                </td>
                <th style="width: 5%;border-color: white"></th>
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto">
                    <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center>
                    <br>
                    <strong>Forma de
                        Pago:</strong>&nbsp;{{ $cotizacion->forma_pago->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha:</strong>&nbsp;{{ $cotizacion->created_at }}<br>
                    <strong>Validez :</strong> &nbsp;{{ $cotizacion->validez }}<br>
                    <strong>Garantía:</strong>
                    &nbsp;{{ $cotizacion->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <strong>Tipo de Moneda:</strong>
                    &nbsp;{{ $cotizacion->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                </td>
            </tr>
        </table>
        <div class="form-control" style="border: none;height: auto">
            <div align="left">
                <strong>Observaciones:</strong> &nbsp;{{ $cotizacion->observacion }}<br>
            </div>
        </div>
        <br>
        <div class="">
            <table class="table " style="border-top: 0px;">
                <thead style="">
                    <tr style="text-align: left;font-weight: bold;border-top-width:  0px ">
                        <td style="width: 4% !important;text-align: center">ITEM</td>
                        <td style="width: 13% !important;text-align: center">CÓDIGO</td>
                        <td style="width: 380px !important;">DESCRIPCION</td>
                        <td style="text-align: center;">CANT.</td>
                        <td style="text-align:right;width: 60px;">P. UNIT.</td>
                        <td style="text-align:right;width: 60px;">TOTAL <span hidden="hidden">{{ $simbologia = $cotizacion->moneda->simbolo }}</span></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cotizacion_registro as $cotizacion_registros)
                        <tr style="border-bottom-width:   0px white">
                            <td style="text-align: center">{{ $i++ }} </td>
                            @if (isset($cotizacion_registros->producto_id))
                                <td style="text-align: center">{{ $cotizacion_registros->producto->codigo_producto }}</td>
                                <td style="">{{ $cotizacion_registros->producto->nombre }}
                                    <br>{{ $cotizacion_registros->descripcion_item }}</span></td>
                            @else
                                <td style="text-align: center">{{ $cotizacion_registros->servicio->codigo_servicio }}</td>
                                <td style="">{{ $cotizacion_registros->servicio->nombre }}
                                    <br>{{ $cotizacion_registros->descripcion_item }}</span></td>
                            @endif
                            <td style="text-align: center;">{{ $cotizacion_registros->cantidad }}</td>
                            <td style="text-align: right">{{ number_format($cotizacion_registros->precio_unitario_comi, 2) }}</td>
                            <td style="text-align: right">
                                {{ number_format($cotizacion_registros->cantidad * $cotizacion_registros->precio_unitario_comi, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /table-responsive -->
        <footer style="padding-top: 120px">
            <table style="width: 100%;border-collapse:collapse;margin-bottom: -10px">
                <tr>
                    <td style="width: 70%;border: none">
                        <h3 align="left" style="margin-bottom: 0px;margin-top: 0px">
                            <?php use Luecano\NumeroALetras\NumeroALetras;
                            $v = new NumeroALetras();
                            $letra = $v->toInvoice($end, 2);
                            //  $letra_final = ucfirst(strstr($letra, 'soles',true));
                            //  $end_final_point=strstr($end2, '.', false);
                            //  $end_final=str_replace('.', '',$end_final_point);
                            ?>
                            Son : {{ ucfirst(strtolower($letra)) }} {{ $cotizacion->moneda->nombre }}
                        </h3>
                    </td>
                    <td style="width: auto; ;border: 1px #3D3D3D solid;border-top-right-radius: 8px 0 0 8px;margin-top: 0px;border-right: none;margin-right: 15px;border-collapse:collapse;"
                        align="left">
                        <span> Subtotal:</span>
                        <br>
                        <span> Op. Agravada:</span> <br>
                        <span> Op. Inafecta:</span> <br>
                        <span> Op. Exonerada:</span> <br>
                        <span> I.G.V.:</span> <br>
                        <span> Importe Total:</span> <br>
                    </td>
                    <td style="width: auto; border: 1px #3D3D3D solid;border-top-left-radius: 8px 0 0 8px;margin-top: 0px;border-left: none;border-collapse:collapse;"
                        align="right">
                        <span>{{ $simbologia = $cotizacion->moneda->simbolo }}
                            {{ number_format($sub_total, 2) }}</span><br>
                        <span>{{ $simbologia }} {{ number_format($cotizacion->op_gravada, 2) }}</span><br>
                        <span>{{ $simbologia }} {{ number_format($cotizacion->op_inafecta, 2) }}</span><br>
                        <span>{{ $simbologia }} {{ number_format($cotizacion->op_exonerada, 2) }}</span><br>
                        <span>{{ $simbologia }} {{ number_format(round($igv_p, 2), 2) }}</span><br>
                        <span>{{ $simbologia }} {{ number_format($end, 2) }}</span><br>
                    </td>
                </tr>
            </table>
        </footer>
        <br>
        @include('layout_bancos_pdf')
        <!-- Fin Totales de Productos -->
        <br>
        <div class="">
            <table>
                <tr>
                    <td style="border: none">
                        <p><u>Atendido por: </u></p>

                        Teléfono : {{ $empresa->telefono }}<br>
                        Celular : {{ $cotizacion->user_personal->celular }}<br>
                        Email : {{ $cotizacion->user_personal->email_user }}<br>
                        Web : {{ $empresa->pagina_web }} <br>
                    </td>
                    <td style="border: none">
                        <br>
                        <br>
                        <br>
                        <br>
                        @if (isset($firma))
                            <center><img src="{{ asset('archivos/imagenes/firma_digital/' . $firma) }}" style=""
                                    width="150px" height="100px"></center>
                        @else
                            <br>
                            <br>
                        @endif
                        <hr>
                        <center>{{ $cotizacion->user_personal->nombre }}</center>
                    </td>
                </tr>
            </table>
        </div>
    </div>
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
</body>

</html>
