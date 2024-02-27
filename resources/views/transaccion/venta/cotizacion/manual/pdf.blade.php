<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cotizacion</title>{{--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
        <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
        <style type="text/css">
            .form-control, .single-line {
                background-color: #FFFFFF;
                background-image: none;
                border: 1px solid black;
                border-radius: 1px;
                color: inherit;
                display: block;
                padding: 6px 12px;
                transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
                width: 100%;
            }
            @page { 
                size: A4;
                font-size: 55%;
            }
        </style>
    </head>
    <body class="white-bg">
        <table style="width: 100%;border-collapse:separate;height: auto;">
            <tr>
                @include('layout_cabecera_ventas_pdf')
                <td style="width: 30%; border: 1px black solid;border-radius: 8px;margin-top: 0px" align="right">
                    <center>
                        <h3 style="text-align: center;margin-top: 2px"> R.U.C {{$empresa->ruc}}</h3>
                        <h2 style="text-align: center;margin: 2px" >COTIZACIÓN ELECTRONICA</h2>
                        <h4 style="text-align: center;margin-bottom: 2px" >{{$cotizacion_m->cod_cotizacion}}</h4>
                    </center>
                </td>
            </tr>
        </table>
        <div class="wrapper wrapper-content animated fadeIn" style="margin-top: -40px ">
            <table style="width: 100%;border-collapse:separate;margin-top: -20px">
                <tr >
                    <td colspan="2" style="border: 1px black solid;border-radius: 8px;width: auto" >
                        <center><strong style="align-content: center;margin: 5px">Contacto Cliente </strong></center><br>
                        <strong>Señor(es):</strong>&nbsp;{{$cotizacion_m->cliente->nombre}}<br>
                        <strong>{{$cotizacion_m->cliente->documento_identificacion}} :</strong>&nbsp;{{$cotizacion_m->cliente->numero_documento}}&nbsp;&nbsp;<br>
                        <strong>Fecha:</strong>&nbsp;{{$cotizacion_m->fecha_emision}}<br>
                        <strong>Telefono:</strong>&nbsp;{{$cotizacion_m->cliente->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>Celular:</strong>&nbsp;{{$cotizacion_m->cliente->celular}}<br>
                    </td>
                    <th style="width: 5%;border-color: white"></th>
                    <td colspan="2" style="border: 1px black solid;border-radius: 8px;width: auto">
                        <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center><br>
                        <strong>Forma de Pago:</strong>&nbsp;{{$cotizacion_m->forma_pago->nombre }}<br>
                        <strong>Validez :</strong> &nbsp;{{$cotizacion_m->validez}}<br>
                        <strong>Garantia:</strong> &nbsp;{{$cotizacion_m->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                        <strong>Tipo de Moneda:</strong> &nbsp;{{$cotizacion_m->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    </td>
                </tr>
            </table>
        <div class="form-control" style="border: none;height: auto" >
            <div align="left">
                <strong>Observaciones:</strong> &nbsp;{{$cotizacion_m->observacion }}<br>
            </div>
        </div>
        <br>
        <span hidden="" style="color:white;">{{$i=1}}</span>
        <div class="table-responsive">
            <table class="table " style="border-top: 0px" >
                <thead align="left">
                    <tr style="text-align: left;font-weight: bold;border-top-width:  0px ">
                        <th style="text-align:center;width: 10px;">ITM </th>
                        <th style="text-align:center;width: 70px;">CÓDIGO </th>
                        <th >DESCRIPCION</th>
                        <th style="text-align:center;width: 30px;" >CANT.</th>
                        <th style="text-align:center;width: 50px;">P. UNIT.</th>
                        <th style="text-align:center;width: 50px;">TOTAL <span hidden="hidden">{{$cotizacion_m->moneda->simbolo}}</span></th>
                    </tr>
                </thead>
                <tbody align="left">
                    @foreach($cotizacion_m_reg as $cotizacion_registros)
                    <tr>
                        <td style="text-align: center">{{$j++}} </td>
                        @if(isset($cotizacion_registros->producto->codigo_producto))
                            <td style="text-align: center">
                                {{$cotizacion_registros->producto->codigo_producto}}
                            </td>
                            <td>
                                {{$cotizacion_registros->producto->nombre}} | {{$cotizacion_registros->descripcion_item}} </span>
                            </td>
                        @else
                            <td style="text-align: center">
                                {{$cotizacion_registros->servicio->codigo_servicio}}
                            </td>
                            <td >
                                {{$cotizacion_registros->servicio->nombre}} | {{$cotizacion_registros->descripcion_item}} </span>
                            </td>
                        @endif                        
                        <td style="text-align: center">{{$cotizacion_registros->cantidad}}</td>
                        <td style="text-align: right">{{number_format($cotizacion_registros->precio,2)}}</td>
                        <td style="text-align: right">{{number_format($cotizacion_registros->cantidad*$cotizacion_registros->precio,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /table-responsive -->
        <footer style="padding-top: 120px">
            <table  style="width: 100%;border-collapse:collapse;margin-bottom: -10px; border-radius: 8px">
                <tr>
                    <td style="width: 70%;border: none">
                        <h3 align="left">
                            <?php use Luecano\NumeroALetras\NumeroALetras;
                            $v=new NumeroALetras() ;
                            $letra=($v->toInvoice($end, 2));
                            // $letra_final = ucfirst(strstr($letra, 'soles',true));
                            // $end_final_point=strstr($end2, '.',false);
                            // $end_final=str_replace('.', '',$end_final_point);
                        ?>
                        Son : {{ucfirst(strtolower($letra))}} {{$cotizacion_m->moneda->nombre }}
                        </h3>
                    </td>
                    <td   style="width: auto;border: 1px #808080 solid;margin-top: 0px;border-right: none;margin-right: 15px;border-collapse:collapse;" align="left">
                        <span > Subtotal:</span><br>
                        <span > Op. Gravada:</span><br>
                        <span > Op. Inafecta:</span><br>
                        <span > Op. Exonerada:</span><br>
                        <span > I.G.V.:</span> <br>
                        <span > Importe Total:</span><br>
                    </td>
                    <td   style="width: auto;border: 1px #808080 solid;border-top-left-radius: 8px 8px 8px 8px;margin-top: 0px;border-left: none;border-collapse:collapse;" align="right">
                        <span>{{$simbologia=$cotizacion_m->moneda->simbolo}} {{number_format($sub_total, 2)}}</span><br>
                        <span>{{$simbologia}} {{number_format($cotizacion_m->op_gravada,2)}}</span><br>
                        <span>{{$simbologia}} {{number_format($cotizacion_m->op_inafecta,2)}}</span><br>
                        <span>{{$simbologia}} {{number_format($cotizacion_m->op_exonerada,2)}}</span><br>
                        <span>{{$simbologia}} {{number_format(round($igv, 2),2)}}</span><br>
                        <span>{{$simbologia}} {{number_format($end,2)}}</span>
                    </td>
                </tr>
            </table>  
        </footer>
        <br>
        <!-- Fin Totales de Productos -->
        <br>
        @include('layout_bancos_pdf')
        <div class="">
            <table >
                <tr>
                    <td style="border: none">
                        <p><u>Atendido por: </u></p>

                        Teléfono : {{$empresa->telefono}}<br>
                        Celular : {{$cotizacion_m->user_personal->celular }}<br>
                        Email : {{$cotizacion_m->user_personal->email_user}}<br>
                        Web : {{$empresa->pagina_web}} <>
                    </td>
                    <td style="border: none">
                        <br>
                        <br>
                        <br>
                        <br>
                        @if(isset($firma))
                            <center><img src="{{asset('archivos/imagenes/firma_digital/'.$firma)}}" style="" width="150px" height="100px"></center>
                        @else
                            <br>
                            <br>
                        @endif
                        <hr style="width:250px">
                        <center>{{$cotizacion_m->user_personal->nombre}}</center>
                    </td>
                </tr>
            </table>
        </div>
        <style>
            *{
                color: black;
                font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"
            }
            .cero{
                margin-bottom: 0px;
        
            }
            .table-bordered .blanco {
                border: none;
            }
            .blanco{
                border: none;
                border: black ;
            }
            .border {
                border-color: black;
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