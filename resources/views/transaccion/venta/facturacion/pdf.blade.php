<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Facturación</title>{{--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
        <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
    </head>
    <style type="text/css">
        .form-control, .single-line {
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
        /*@page {
            size: A4;
            font-size: 55%;
        }*/
    </style>
    <body class="white-bg">
        <table style="width: 100%;border-collapse:separate;margin-bottom: -10px">
            <tr>
                @include('layout_cabecera_ventas_pdf')
                <td style="width: 30%; ;border: 1px #3D3D3D solid;border-radius: 8px;margin-top: 0px" align="right">
                    <center>
                        {{-- <h3 style="text-align: center;padding-top:15px;margin-bottom: -28px;margin-top: -10px"> R.U.C {{$empresa->ruc}}</h3><br>
                        <h2 style="font-size: 17px;text-align: center;margin-bottom: -28px" >FACTURA ELECTRÓNICA</h2><br>
                        <h5 style="text-align: center;margin-bottom: -1px" >{{$facturacion->codigo_fac}}</h5> --}}
                        <h3 style="text-align: center;margin-top: 2px"> R.U.C {{ $empresa->ruc }}</h3>
                        <h2 style="text-align: center;margin: 2px">FACTURA ELECTRONICA</h2>
                        <h4 style="text-align: center;margin-bottom: 2px">{{ $facturacion->codigo_fac }}</h4>
                    </center>
                </td>
            </tr>
        </table>
        <div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">
            @if($facturacion->f_electronica == 2 || $facturacion->nota_credito == 1)
                <div id="watermark">
                    <p>Anulado</p>
                </div>
            @endif
            <table style="width: 100%;border-collapse:separate;margin-top: -20px">
                <tr >
                    <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto" >
                        <!-- <center><strong style="align-content: center;margin: 5px">Datos Generales </strong></center><br> -->
                        <strong>Señor(es):</strong>&nbsp;
                        @if(isset($facturacion->cliente_id))
                            {{$facturacion->cliente->nombre}}
                        @else
                            {{$facturacion->cotizacion->cliente->nombre}}
                        @endif
                        <br>
                        <strong>R.U.C:</strong>&nbsp;
                        @if(isset($facturacion->cliente_id))
                            {{$facturacion->cliente->numero_documento}}
                        @else
                            {{$facturacion->cotizacion->cliente->numero_documento}}
                        @endif&nbsp;&nbsp;<br>
                        <strong>Dirección:</strong>&nbsp;
                        @if(isset($facturacion->cliente_id))
                            {{$facturacion->cliente->direccion}}
                        @else
                            {{$facturacion->cotizacion->cliente->direccion}}
                        @endif
                        <br>
                        <strong>Condiciones de Pago:</strong>&nbsp;
                        @if(isset($facturacion->cliente_id))
                            {{$facturacion->forma_pago->nombre }}
                        @else
                            {{$facturacion->cotizacion->forma_pago->nombre }}
                        @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>Tipo de Moneda:</strong>&nbsp;
                        @if(isset($facturacion->cliente_id))
                            {{$facturacion->moneda->nombre }}
                        @else
                            {{$facturacion->cotizacion->moneda->nombre }}
                        @endif
                        <br>
                    </td>
                    <th style="width: 5%;border-color: white"></th>
                    <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto">
                        <!-- <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center> <br> -->
                        <strong>Orden de Compra:</strong>&nbsp;{{$facturacion->orden_compra}}<br>
                        <strong>Guía de Remisión:</strong> &nbsp;{{$facturacion->guia_remision}}<br>
                        <strong>Fecha de Emisión:</strong> &nbsp;{{$facturacion->fecha_emision}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                        <strong>Fecha de Vencimiento:</strong> &nbsp;{{$facturacion->fecha_vencimiento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    </td>
                </tr>
            </table>
            <br>
            {{--  --}}
            <div class="table-responsive">
                <table class="table " style="border-top: 0px;border-color: #808080" >
                    <thead style="border-color: #808080">
                        <tr >
                        <th style="text-align: center;width: 5%">ITEM</th>
                        <th style="text-align: center;width: 13%">CÓDIGO</th>
                        <th style="text-align: left;">DESCRIPCIÓN</th>
                        <th style="width: 11%">CANT.</th>
                        <th  style="text-align: right;width: 8%">P. UNIT.</th>
                        <th  style="text-align: right;width: 8%">TOTAL</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($facturacion_registro as $facturacion_registros)
                    <tr>
                        <td style="text-align:center;">{{$i++}} </td>
                        @if(isset($facturacion_registros->producto))
                        <td style="text-align:center;">{{$facturacion_registros->producto->codigo_producto}}</td>
                        <td>{{$facturacion_registros->producto->nombre}} {{$facturacion_registros->descripcion_item}} @if(isset($facturacion_registros->numero_serie))<br><strong>N/S:</strong> {{$facturacion_registros->numero_serie}}@endif</td>
                        @else
                        <td style="text-align:center;">{{$facturacion_registros->servicio->codigo_servicio}}</td>
                        <td>{{$facturacion_registros->servicio->nombre}} {{$facturacion_registros->descripcion_item}}
                            @endif
                            <td style="text-align:center;">{{$facturacion_registros->cantidad}}</td>
                            <td style="text-align: right;">{{number_format($facturacion_registros->precio_unitario_comi,2)}}</td>
                            <td style="text-align: right;">{{number_format($facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad ,2)}}</td>
                            <td style="display: none">
                                {{$sub_total=($facturacion->op_gravada)}}
                                {{$sub_total_gravado=($facturacion->op_gravada)+($facturacion->op_inafecta)+($facturacion->op_exonerada)}}
                                {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                {{$end2=number_format(round($sub_total, 2)+round($igv_p, 2),2)}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table >
            </div>
        {{--  --}}
        <footer style="padding-top: 120px">

            <table  style="width: 100%;border-collapse:collapse;margin-bottom: -10px; border-radius: 8px">
            <tr>
                <td style="width: 70%;border: none">
                        <h3 align="left">
                            <?php  use Luecano\NumeroALetras\NumeroALetras;
                            $v=new NumeroALetras() ;
                            $letra=($v->toInvoice($end, 2));
                            // $letra_final = ucfirst(strstr($letra, 'soles',true));
                            // $end_final_point=strstr($end2, '.',false);
                            // $end_final=str_replace('.', '',$end_final_point);
                        ?>
                        Son : {{ucfirst(mb_strtolower($letra,'UTF-8'))}} {{$facturacion->moneda->nombre }}
                        </h3>
                        <br>
                        <small style="font-size: 70%">
                            Representación Impresa de <strong>FACTURA ELECTRÓNICA</strong>
                        </small> <br>
                        <small style="font-size: 70%">
                            Esta puede ser consultada en www.codecta.pe
                        </small> <br>
                        <small style="font-size: 70%">
                            Autorizado mediante Resolución de Intendencia N° 0180050001374/SUNAT
                        </small>
                    </td>
                    <td style="width: auto;border: 1px #808080 solid;margin-top: 0px;border-right: none;margin-right: 15px;border-collapse:collapse;" align="left">
                        <span > Subtotal:</span><br>
                        <span > Op. Gravada:</span><br>
                        <span > Op. Inafecta:</span><br>
                        <span > Op. Exonerada:</span><br>
                        <span > I.G.V.:</span> <br>
                        <span > Importe Total:</span><br>
                    </td>
                    <td   style="width: auto;border: 1px #808080 solid;border-top-left-radius: 8px 8px 8px 8px;margin-top: 0px;border-left: none;border-collapse:collapse;" align="right">
                        <span>{{$simbologia=$facturacion->moneda->simbolo}} {{number_format($sub_total, 2)}}</span><br>
                        <span>{{$simbologia}} {{number_format($facturacion->op_gravada,2)}}</span><br>
                        <span>{{$simbologia}} {{number_format($facturacion->op_inafecta,2)}}</span><br>
                        <span>{{$simbologia}} {{number_format($facturacion->op_exonerada,2)}}</span><br>
                        <span>{{$simbologia}} {{number_format(round($igv_p, 2),2)}}</span><br>
                        <span>{{$simbologia}} {{number_format($end,2)}}</span>
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            @if ($detraccion == "not")

                <table style="width: 100%;height: 120px;border-collapse:separate">
                    <tr>
                        <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto">
                            <strong>Observaciones:</strong><br>
                            {{$facturacion->observacion}}
                        </td>

                    </tr>
                </table>
            @else
                <table style="width: 100%;border-collapse:separate;margin-top: -20px">
                    <tr >
                        <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto" >
                            <strong>Informacion de Detraccion:</strong><br>
                            <strong>Tipo de Detraccion:</strong>
                            {{$detraccion->tipo_detraccion->descripcion}} - {{$detraccion->porcentaje_detraccion}} %<br>
                            <strong>Medio de Pago:</strong>
                            {{$detraccion->medio_pago->descripcion}} <br>
                            <strong>Monto de Detraccion:</strong>
                            S/. {{number_format($detraccion->monto_detraccion,2)}} <br>
                        </td>
                        <th style="width: 5%;border-color: white"></th>
                        <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto">
                            <strong>Observaciones:</strong><br>
                            {{$facturacion->observacion}}
                        </td>
                    </tr>
                </table>
                @if ($cuotas != 'not')
                    <strong><h3>Informacion de Credito</h3></strong>
                    <table style="width: 100%;border-collapse:separate;">
                        <tr >
                            @foreach ($cuotas as $cuota)
                                <td  style="border: 1px #808080 solid;border-radius: 8px;width: 25%" >
                                    <strong>Cuota:</strong> <br>
                                    {{$cuota->numero_cuota}} <br>
                                    <strong>Monto:</strong> <br>
                                    <div style="display: none" >
                                        {{-- Siempre soles --}}
                                        @if ($facturacion->moneda->id == 1)
                                            {{$monto_total_det = ($cuota->monto) -  ($detraccion->monto_detraccion)}}
                                        @else
                                            {{$mont_porc = $end *  ($detraccion->porcentaje_detraccion / 100)}}
                                            {{$monto_total_det = $end - $mont_porc}}
                                        @endif
                                    </div>
                                    {{$facturacion->moneda->simbolo}}   {{number_format($monto_total_det,2)}} <br>
                                    <strong>Fecha de Vencimiento:</strong> <br>
                                    {{Carbon\Carbon::parse($cuota->fecha_pago)->format('d-m-Y')}} <br>
                                </td>
                            @endforeach
                            <th style="width: 5%;border-color: white"></th>
                            <th style="width: 50%;border-color: white"></th>

                        </tr>
                    </table>
                @endif
            @endif
            <!-- Fin Totales de Productos -->
            <br>
            <br>
    <!-- EXTENSION PARA LLAMAR AL LAYOUT DE BANCOS -->
            @include('layout_bancos_pdf')
        </footer>
    </body>

    <style>

        *{
            color: black;
            font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
            border-color: #3D3D3D
        }
        .cero{
            margin-bottom: 0px;

        }
        .table-bordered .blanco {
            border: none;
        }
        .blanco{border: none;
            border-color: #808080 ;
        }
        .border {
            border-color: #3D3D3D;
            border-width: 1px;
            border-style: solid;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-top-width: 0px;

        }
        #watermark {
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 0;
        }
        #watermark p {
            position: absolute;
            color:   rgba(120, 120, 120, 0.31);
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
            font-weight: bolder;
            font-size: 95px;
            pointer-events: none;
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            top: 35%;
            right: 35%;
            z-index: 0;
        }
        .form-control {
            background-color: transparent !important;
        }
        .tr_table_item{
            border-top: 0px white;
            text-align: initial;
        }
    </style>
</html>
