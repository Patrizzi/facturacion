<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nota de Credito</title>{{--
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
        @page { size: 420mm 297mm landscape; }
    </style>
    <body class="white-bg">
        <table style="width: 100%;border-collapse:separate;margin-bottom: -10px">
            <tr>
                @include('layout_cabecera_ventas_pdf')
                <td style="width: 30%; ;border: 1px #808080 solid;border-radius: 8px;margin-top: 0px" align="right">
                    <center>
                        <h3 style="text-align: center;padding-top:15px;margin-bottom: -28px;margin-top: -10px"> R.U.C {{$empresa->ruc}}</h3><br>
                        <h2 style="font-size: 19px;text-align: center;margin-bottom: -28px" >FACTURA ELECTRÓNICA</h2><br>
                        <h5 style="text-align: center;margin-bottom: -1px" >{{$notas_credito->codigo_n_c}}</h5>
                    </center>
                </td>
            </tr>
        </table>
        {{-- CONTENIDO DE DATOS --}}
        <div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">
            <table style="width: 100%;border-collapse:separate;margin-top: -20px">
                <tr >
                    <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto" >
                        {{-- DATOS GENERALES --}}
                        @if($estado==0)
                            <strong>Cliente:</strong>
                            @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->cliente->nombre}}
                            @else{{$notas_credito->nota_i_facturacion->cotizacion->cliente->nombre}}
                            @endif <br>
                            <strong>R.U.C:</strong>
                            @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->cliente->numero_documento}}
                            @else{{$notas_credito->nota_i_facturacion->cotizacion->cliente->numero_documento}}
                            @endif <br>
                            <strong>Direccion:</strong>
                            @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->cliente->direccion}}
                            @else{{$notas_credito->nota_i_facturacion->cotizacion->cliente->direccion}}
                            @endif <br>
                            <strong>Condiciones de Pago:</strong>
                            @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->forma_pago->nombre }}
                            @else{{$notas_credito->nota_i_facturacion->cotizacion->forma_pago->nombre }}
                            @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Tipo de Moneda:</strong>
                            @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->moneda->nombre }}
                            @else{{$notas_credito->nota_i_facturacion->cotizacion->moneda->nombre }}
                            @endif<br>
                        @elseif($estado==1)
                            <strong>Cliente:</strong>
                            @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->cliente->nombre}}
                            @else{{$notas_credito->nota_i_boleta->cotizacion->cliente->nombre}}
                            @endif <br>
                            <strong>R.U.C:</strong>
                            @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->cliente->numero_documento}}
                            @else{{$notas_credito->nota_i_boleta->cotizacion->cliente->numero_documento}}
                            @endif <br>
                            <strong>Direccion:</strong>
                            @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->cliente->direccion}}
                            @else{{$notas_credito->nota_i_boleta->cotizacion->cliente->direccion}}
                            @endif <br>
                            <strong>Condiciones de Pago:</strong>
                            @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->forma_pago->nombre }}
                            @else{{$notas_credito->nota_i_boleta->cotizacion->forma_pago->nombre }}
                            @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Tipo de Moneda:</strong>
                            @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->moneda->nombre }}
                            @else{{$notas_credito->nota_i_boleta->cotizacion->moneda->nombre }}
                            @endif<br>
                        @else
                            <strong>Cliente:</strong>
                            @if(isset($notas_credito->nota_i_fac_manual->cliente_id)){{$notas_credito->nota_i_fac_manual->cliente->nombre}}
                            @else{{$notas_credito->nota_i_fac_manual->cotizacion->cliente->nombre}}
                            @endif <br>
                            <strong>R.U.C:</strong>
                            @if(isset($notas_credito->nota_i_fac_manual->cliente_id)){{$notas_credito->nota_i_fac_manual->cliente->numero_documento}}
                            @else{{$notas_credito->nota_i_fac_manual->cotizacion->cliente->numero_documento}}
                            @endif <br>
                            <strong>Direccion:</strong>
                            @if(isset($notas_credito->nota_i_fac_manual->cliente_id)){{$notas_credito->nota_i_fac_manual->cliente->direccion}}
                            @else{{$notas_credito->nota_i_fac_manual->cotizacion->cliente->direccion}}
                            @endif <br>
                            <strong>Condiciones de Pago:</strong>
                            @if(isset($notas_credito->nota_i_fac_manual->cliente_id)){{$notas_credito->nota_i_fac_manual->forma_pago->nombre }}
                            @else{{$notas_credito->nota_i_fac_manual->cotizacion->forma_pago->nombre }}
                            @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Tipo de Moneda:</strong>
                            @if(isset($notas_credito->nota_i_fac_manual->cliente_id)){{$notas_credito->nota_i_fac_manual->moneda->nombre }}
                            @else{{$notas_credito->nota_i_fac_manual->cotizacion->moneda->nombre }}
                            @endif<br>
                        @endif
                    </td>
                    <th style="width: 5%;border-color: white"></th>
                    <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto">
                        @if($estado==0)
                            <strong>Documento:</strong>
                            {{$notas_credito->nota_i_facturacion->codigo_fac}}<br>
                            <strong>Tipo de operacion:</strong>
                            @switch($notas_credito->motivo)
                                @case(01)
                                Anulacion de la operacion<br>
                                @break
                                @case(02)
                                Anulacion por error en el ruc<br>
                                @break
                                @case(03)
                                Correcion por error en la descripcion<br>
                                @break
                                @case(04)
                                Devolucion total<br>
                                @break
                            @endswitch
                            <strong>Tipo de sustento:</strong>
                            {{$notas_credito->tipo}}<br>
                            <strong>Fecha Emision:</strong>
                            {{$notas_credito->created_at}}<br>
                        @elseif($estado==1)
                            <strong>Documento:</strong>
                            {{$notas_credito->nota_i_boleta->codigo_boleta}}<br>
                            <strong>Tipo de operacion:</strong>
                            @switch($notas_credito->motivo)
                                @case(01)
                                Anulacion de la operacion<br>
                                @break
                                @case(02)
                                Anulacion por error en el ruc<br>
                                @break
                                @case(03)
                                Correcion por error en la descripcion<br>
                                @break
                                @case(04)
                                Devolucion total<br>
                                @break
                            @endswitch
                            <strong>Tipo de sustento:</strong>
                            {{$notas_credito->tipo}}<br>
                            <strong>Fecha Emision:</strong>
                            {{$notas_credito->created_at}}<br>
                        @else
                            <strong>Documento:</strong>
                            {{$notas_credito->nota_i_fac_manual->codigo_fac}}<br>
                            <strong>Tipo de operacion:</strong>
                            @switch($notas_credito->motivo)
                                @case(01)
                                Anulacion de la operacion<br>
                                @break
                                @case(02)
                                Anulacion por error en el ruc<br>
                                @break
                                @case(03)
                                Correcion por error en la descripcion<br>
                                @break
                                @case(04)
                                Devolucion total<br>
                                @break
                            @endswitch
                            <strong>Tipo de sustento:</strong>
                            {{$notas_credito->tipo}}<br>
                            <strong>Fecha Emision:</strong>
                            @if(isset($notas_credito->fecha_emision))
                                {{$notas_credito->fecha_emision}}
                            @else
                                {{$notas_credito->created_at}}<br>
                            @endif
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        <div class="form-control" style="border: none;height: auto" >
            <div align="left">
    
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table " style="border-top: 0px;border-color: #808080" >
                <thead style="border-color: #808080">
                    <tr>
                        <th style="width: 8%">Item</th>
                        <th style="width: 15%">Cod. de Item</th>
                        <th>Descripción</th>
                        <th style="width: 11%">Cantidad</th>
                        <th  style="text-align: center;width: 8%">P. Unit.</th>
                        <th  style="text-align: center;width: 8%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- <span hidden="hidden">{{$u=1}} </span> --}}
                    @foreach($notas_credito_registros as $e => $notas_credito_registro)
                        <tr>
                            <td>{{$u++}}</td>
                            @if(isset($notas_credito_registro->producto_id))
                                <td>{{$notas_credito_registro->producto->codigo_producto}}</td>
                            @else
                                <td>{{$notas_credito_registro->servicio->codigo_servicio}}</td>
                            @endif
                            

                            <td>
                                {{-- @if(isset($notas_credito_registro->producto_id))
                                    {{$notas_credito_registro->producto->nombre}} 
                                @else
                                    {{$notas_credito_registro->servicio->nombre}} 
                                @endif --}}
                                {{$notas_credito_registro->descripcion}} 
                                {{$doc_reg[$e]->descripcion_item}}
                                {{-- <br><strong>N/S:</strong>
                                {{$notas_credito_registro->numero_serie}} --}}
                            </td>
                            <td>{{$notas_credito_registro->cantidad}}</td>
                            <td>{{$notas_credito_registro->precio}}</td>
                            <td>{{$notas_credito_registro->precio* $notas_credito_registro->cantidad }}</td>
                            <td style="display: none">
                                
                                {{$sub_total=($notas_credito_registro->nota_credito_ids->op_gravada)+($notas_credito_registro->nota_credito_ids->op_inafecta)+($notas_credito_registro->nota_credito_ids->op_exonerada)}}
                                {{$sub_total_gravado=($notas_credito_registro->nota_credito_ids->op_gravada)}}
                                {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                {{$end=round($sub_total, 2)+round($igv_p, 2)}} 
                                {{$end2=number_format(round($sub_total, 2)+round($igv_p, 2),2)}}
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>  
            </table >
        </div>
        <table  style="width: 100%;border-collapse:collapse;margin-bottom: -10px; border-radius: 8px">
            <tr>
                <td style="width: 70%;border: none">
                    <h3 align="left">
                        <?php $v=new CifrasEnLetras() ;
                            $letra=($v->convertirEurosEnLetras($end));
                            $letra_final = ucfirst(strstr($letra, 'soles',true));
                            $end_final_point=strstr($end2, '.',false);
                            $end_final=str_replace('.', '',$end_final_point);
                        ?>
                        Son : {{$letra_final}} con {{$end_final}}/100 
                        @if(isset($notas_credito->facturacion_id))
                            {{$notas_credito->nota_i_facturacion->moneda->nombre}} 
                        @elseif(isset($notas_credito->boleta_id))
                            {{$notas_credito->nota_i_boleta->moneda->nombre}} 
                        @else
                            {{$notas_credito->nota_i_fac_manual->moneda->nombre}} 
                        @endif 
                            {{-- {{number_format($sub_total, 2)}}</span> --}}
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
                    <span>
                        @if(isset($notas_credito->facturacion_id))
                            {{$simbologia = $notas_credito->nota_i_facturacion->moneda->simbolo}} 
                        @elseif(isset($notas_credito->boleta_id))
                            {{ $simbologia= $notas_credito->nota_i_boleta->moneda->simbolo}} 
                        @else
                            {{ $simbologia = $notas_credito->nota_i_fac_manual->moneda->simbolo}} 
                        @endif 
                        {{number_format($sub_total, 2)}}</span><br>
                    <span>{{$simbologia}} {{number_format($notas_credito->op_gravada,2)}}</span><br>
                    <span>{{$simbologia}} {{number_format($notas_credito->op_inafecta,2)}}</span><br>
                    <span>{{$simbologia}} {{number_format($notas_credito->op_exonerada,2)}}</span><br>
                    <span>{{$simbologia}} {{number_format(round($igv_p, 2),2)}}</span><br>
                    <span>{{$simbologia}} {{number_format($end,2)}}</span>
                </td>
            </tr>
        </table>
    </body>
    <style>

        *{font-size: 14px;color: #495057;font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}
        .cero{
        margin-bottom: 0px;
    
        }
         .table-bordered .blanco {
        border: none;
    }
        .blanco{border: none;
            border: medium transparent;
            }
        .border {
            border-color: #aaaaaa;
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
    </style>
</html>