<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Boleta Manual</title>{{--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
        <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
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
        @page {
            size: A4;
            font-size: 55% !important;
        }
        </style>
    </head>
    <body class="white-bg">
        <table style="width: 100%;border-collapse:separate;height: auto;">
            <tr>
                @include('layout_cabecera_ventas_pdf')
                <td style="width: 29%; ;border: 1px #3D3D3D solid;border-radius: 8px;margin: 2px 0px" align="right">
                    <center>
                        <h3 style="text-align: center;margin-top: 0px"> R.U.C {{$empresa->ruc}}</h3>
                        <h2 style="text-align: center;margin: 4px" >BOLETA ELECTRÓNICA</h2>
                        <h4 style="text-align: center;margin-bottom: 0px" >{{$boleta->codigo_boleta}}</h4>
                    </center>
                </td>
            </tr>
        </table>
        <div class="wrapper wrapper-content animated fadeIn" style="margin-top: -40px ">
            <table style="width: 100%;border-collapse:separate;margin-top: -20px">
                <tr>
                    <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto" >
                        <strong>Señor(es)</strong>&nbsp;
                        @if(isset($boleta->cliente_id)){{$boleta->cliente->nombre}}
                        @else{{$facturacion->cotizacion->cliente->nombre}}
                        @endif<br>
                        <strong>N° de Doc. :</strong>&nbsp;
                        @if(isset($boleta->cliente_id)){{$boleta->cliente->numero_documento}}
                        @else{{$boleta->cotizacion->cliente->numero_documento}}
                        @endif&nbsp;&nbsp;<br>
                        <strong>Dirección:</strong>&nbsp;
                        @if(isset($boleta->cliente_id)){{$boleta->cliente->direccion}}
                        @else{{$boleta->cotizacion->cliente->direccion}}
                        @endif<br>
                        <strong>Condiciones de Pago:</strong>&nbsp;@if(isset($boleta->cliente_id)){{$boleta->forma_pago->nombre }}
                        @else{{$boleta->cotizacion->forma_pago->nombre }}
                        @endif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>Tipo de Moneda:</strong>&nbsp;
                        @if(isset($boleta->cliente_id)){{$boleta->moneda->nombre }}
                        @else{{$boleta->cotizacion->moneda->nombre }}
                        @endif<br>
                    </td>
                    <th style="width: 5%;border-color: white"></th>
                    <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto">
                        <!-- <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center> <br> -->
                        <strong>Orden de Compra:</strong>&nbsp;{{$boleta->orden_compra}}<br>
                        <strong>Guía de Remisión:</strong> &nbsp;{{$boleta->guia_remision}}<br>
                        <strong>Fecha de Emisión:</strong> &nbsp;{{$boleta->fecha_emision}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                        <strong>Fecha de Vencimiento:</strong> &nbsp;{{$boleta->fecha_vencimiento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    </td>
                </tr>
            </table>
            <div class="form-control" style="border: none;height: auto" >
                <div align="left">

                </div>
            </div>
            <div class="table-responsive">
                <table class="table " style="border-top: 0px;border-color: #808080" >
                    <thead style="border-color: #808080">
                        <tr style="text-align: left;font-weight: bold;border-top-width:  0px ">
                            <th  style="text-align: center;width: 5%">ITEM</th>
                            <th  style="text-align: center;width: 13%">CÓDIGO</th>
                            <th style="text-align: left">DESCRIPCIÓN</th>
                            <th  style="text-align: center;width: 11%">CANT.</th>
                            <th  style="text-align: right;width: 8%">P. UNIT.</th>
                            <th  style="text-align: right;width: 8%">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($boleta_registro as $boleta_registros)
                        <tr>
                            <td style="text-align:center;">{{$j++}} </td>
                            @if(isset($boleta_registros->producto))
                                <td style="text-align:center;">{{$boleta_registros->producto->codigo_producto}}</td>
                                <td>{{$boleta_registros->producto->nombre}} {{$boleta_registros->descripcion_item}} @if(isset($boleta_registros->numero_serie))<br><strong>N/S:</strong> {{$boleta_registros->numero_serie}}@endif</td>
                            @else
                                <td style="text-align:center;">{{$boleta_registros->servicio->codigo_servicio}}</td>
                                <td>{{$boleta_registros->servicio->nombre}} {{$boleta_registros->descripcion_item}}
                            @endif
                            <td style="text-align:center;">{{$boleta_registros->cantidad}}</td>
                            <td style="text-align: right;">{{number_format($boleta_registros->precio,2)}}</td>
                            <td style="text-align: right;">{{number_format($boleta_registros->precio * $boleta_registros->cantidad ,2)}}</td>
                            <td style="display: none">
                                {{$sub_total=($boleta->op_gravada)}}
                                {{$sub_total_gravado=($boleta->op_gravada)+($boleta->op_inafecta)+($boleta->op_exonerada)}}
                                {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                {{$end2=number_format(round($sub_total, 2)+round($igv_p, 2),2)}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table >
            </div>
            <footer style="padding-top: 120px">
                <table  style="width: 100%;border-collapse:collapse;margin-bottom: -10px; border-radius: 8px">
                <tr>
                        <td style="width: 50%;border: none;padding-top: 0px;padding-bottom: 0px">
                            <h3 align="left" style="margin: 0px;"> 
                                <?php use Luecano\NumeroALetras\NumeroALetras;
                                    $v=new NumeroALetras() ;
                                    $letra=($v->toInvoice($end, 2));
                                    // $letra_final = ucfirst(strstr($letra, 'soles',true));
                                    // $end_final_point=strstr($end2, '.',false);
                                    // $end_final=str_replace('.', '',$end_final_point);
                                ?>
                                Son : {{ucfirst(mb_strtolower($letra,'UTF-8'))}} {{$boleta->moneda->nombre}}
                            </h3>
                            <br>
                            <small style="font-size: 70%">
                                Representación Impresa de <strong>BOLETA ELECTRÓNICA</strong>
                            </small> <br>
                            <small style="font-size: 70%">
                                Esta puede ser consultada en www.codecta.pe
                            </small> <br>
                            <small style="font-size: 70%">
                                Autorizado mediante Resolución de Intendencia N° 0180050001374/SUNAT
                            </small>
                        </td>
                        <td class="qr-container">
                            <div class="qr-box">
                                @if(!empty($qrCode))
                                    <img src="{{ $qrCode }}" alt="Código QR" class="qr-image">
                                @else
                                    <span class="qr-placeholder">QR</span>
                                @endif
                            </div>
                        </td>
                        <td   style="width: auto;border: 1px #808080 solid;margin-top: 0px;border-right: none;margin-right: 15px;border-collapse:collapse;" align="left">
                            <span > Sub Total:</span><br>
                            <span > Op. Agravada:</span><br>
                            <span > Op. Inafecta:</span><br>
                            <span > Op. Exonerada:</span><br>
                            <span > I.G.V.:</span> <br>
                            <span > Importe Total:</span><br>
                        </td>
                        <td   style="width: auto;border: 1px #808080 solid;border-top-left-radius: 8px 8px 8px 8px;margin-top: 0px;border-left: none;border-collapse:collapse;" align="right">
                            <span>{{$simbologia=$boleta->moneda->simbolo}} {{number_format($sub_total, 2)}}</span><br>
                            <span>{{$simbologia}} {{number_format($boleta->op_gravada,2)}}</span><br>
                            <span>{{$simbologia}} {{number_format($boleta->op_inafecta,2)}}</span><br>
                            <span>{{$simbologia}} {{number_format($boleta->op_exonerada,2)}}</span><br>
                            <span>{{$simbologia}} {{number_format(round($igv_p, 2),2)}}</span><br>
                            <span>{{$simbologia}} {{number_format($end,2)}}</span>
                        </td>
                    </tr>
                </table>
                <br>
                <br>
                <table style="width: 100%;height: 120px;border-collapse:separate;margin-bottom: -10px">
                    <tr>
                        <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto">
                            <strong>Observaciones:</strong><br>
                            {{$boleta->observacion}}
                        </td>
                    </tr>
                </table>
                <!-- Fin Totales de Productos -->
                @include('layout_bancos_pdf')
                <div class="row">
                    <br>
                </div>
            </footer>
        </div>
        <style>

            *{color: black;font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";color: black}
            .cero{
                margin-bottom: 0px;

            }
            .table-bordered .blanco {
                border: none;
            }
            .blanco{
                border: none;
                border-color: #3D3D3D ;
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
            .qr-container {
                display: flex;
                justify-content: center;
                align-items: center;
                border: none;
                padding-top: 0px;
                padding-bottom: 0px
            }

            .qr-box {
                width: 70px;
                height: 70px;
                border: 2px solid #3D3D3D;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 3px;
                background: white;
            }

            .qr-image {
                max-width: 100%;
                max-height: 100%;
                display: block;
            }

            .qr-placeholder {
                font-size: 12px;
                color: #999;
                text-align: center;
            }
        </style>
    </body>
</html>
