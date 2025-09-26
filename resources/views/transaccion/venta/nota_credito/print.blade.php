<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nota de Credito- Impresion</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="@yield('vue_js', '#')" defer></script>

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">
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
    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
            window.close();
        }
    </SCRIPT>
    <style>
    @media print {
    body {
        margin: 0 !important;
        padding: 0 !important;
    }
    .avoid-break {
        page-break-inside: avoid;
    }
    }
    </style>

</head>
<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">
    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
        <div class="row">
            {{-- <div class="col-sm-4 text-left" align="left"> --}}
                @include('layout_cabecera_ventas')
            {{-- </div> --}}
            <div class="col-sm-4 ">
                <div class="form-control ruc" style="height: 125px">
                    <center>
                        <h3 style="padding-top:10px ">R.U.C : {{$empresa->ruc}}</h3>
                        <h2>NOTA DE CREDITO</h2>
                        {{$notas_credito->codigo_n_c}}
                    </center>
                </div>
            </div>
        </div><br>
        <div class="row" align="center" style="padding-bottom: 5px">
            @if($notas_credito->n_electronica == 2)
                <div id="watermark">
                    <p>Anulado</p>
                </div>
            @endif
            <div class="col-sm-6" align="center">
                <div class="form-control">
                    {{-- <h3> Datos Generales</h3> --}}
                    <div align="left">
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
                        @elseif($estado==3)
                            <strong>Cliente:</strong>
                            @if(isset($notas_credito->nota_i_boleta_manual->cliente_id)){{$notas_credito->nota_i_boleta_manual->cliente->nombre}}
                            @else{{$notas_credito->nota_i_boleta_manual->cotizacion->cliente->nombre}}
                            @endif <br>
                            <strong>R.U.C:</strong>
                            @if(isset($notas_credito->nota_i_boleta_manual->cliente_id)){{$notas_credito->nota_i_boleta_manual->cliente->numero_documento}}
                            @else{{$notas_credito->nota_i_boleta_manual->cotizacion->cliente->numero_documento}}
                            @endif <br>
                            <strong>Direccion:</strong>
                            @if(isset($notas_credito->nota_i_boleta_manual->cliente_id)){{$notas_credito->nota_i_boleta_manual->cliente->direccion}}
                            @else{{$notas_credito->nota_i_boleta_manual->cotizacion->cliente->direccion}}
                            @endif <br>
                            <strong>Condiciones de Pago:</strong>
                            @if(isset($notas_credito->nota_i_boleta_manual->cliente_id)){{$notas_credito->nota_i_boleta_manual->forma_pago->nombre }}
                            @else{{$notas_credito->nota_i_boleta_manual->cotizacion->forma_pago->nombre }}
                            @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Tipo de Moneda:</strong>
                            @if(isset($notas_credito->nota_i_boleta_manual->cliente_id)){{$notas_credito->nota_i_boleta_manual->moneda->nombre }}
                            @else{{$notas_credito->nota_i_boleta_manual->cotizacion->moneda->nombre }}
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
                    </div>
                </div>
            </div>
            <div class="col-sm-6" align="center">
                <div class="form-control" >
                    {{-- <h3>Condiciones Generales</h3> --}}
                    <div align="left">
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
                                @case(06)
                                Devolucion total<br>
                                @break
                            @endswitch
                            <strong>Tipo de sustento:</strong>
                            {{$notas_credito->tipo}}<br>
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
                                @case(06)
                                Devolucion total<br>
                                @break
                            @endswitch
                            <strong>Tipo de sustento:</strong>
                            {{$notas_credito->tipo}}<br>
                        @elseif($estado==3) {{--boleta manual--}}
                            <strong>Documento:</strong>
                            {{$notas_credito->nota_i_boleta_manual->codigo_boleta}}<br>
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
                                @case(06)
                                Devolucion total<br>
                                @break
                            @endswitch
                            <strong>Tipo de sustento:</strong>
                            {{$notas_credito->tipo}}<br>
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
                                @case(06)
                                Devolucion total<br>
                                @break
                            @endswitch
                            <strong>Tipo de sustento:</strong>
                            {{$notas_credito->tipo}}<br>
                        @endif
                        <strong>Fecha Emision:</strong>
                            @if(isset($notas_credito->fecha_emision))
                                {{$notas_credito->fecha_emision}}
                            @else
                                {{$notas_credito->created_at}}<br>
                            @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-12" align="center">
                <div class="form-control" style="border: none;height: auto" >
                    <div align="left">
                    </div>
                </div>
            </div>
        </div>
        <br>
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th style="width: 8%">ITEM</th>
                            <th style="width: 15%">Codigo Producto</th>
                            <th >Descripción</th>
                            <th style="width: 11%">Cantidad</th>
                            <th style="text-align: center;width: 8%">Pr. Unit</th>
                            <th style="text-align: center;width: 8%">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <span hidden="hidden">{{$u=1}} </span>
                        <tr>
                            @foreach($notas_credito_registros as $e => $notas_credito_registro)
                                <tr>
                                    <td>{{$u++}}</td>
                                    @if(isset($notas_credito_registro->producto_id))
                                        <td>{{$notas_credito_registro->producto->codigo_producto}}</td>
                                    @else
                                        <td>{{$notas_credito_registro->servicio->codigo_servicio}}</td>
                                    @endif

                                    <td>
                                        {{$notas_credito_registro->descripcion}}
                                        {{$doc_reg[$e]->descripcion_item}}
                                        {{-- <br><strong>N/S:</strong> --}}
                                        {{-- {{$notas_credito_registro->numero_serie}} --}}
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
                        </tr>

                       <tr>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br><br><br><br>
        <div class="row">
            <div class="col-sm-8">
                <h3 align="left">
                    <?php $v=new CifrasEnLetras() ;
                    $letra=($v->convertirEurosEnLetras($end));
                    $letra_final = ucfirst(strstr($letra, 'soles',true));
                    $end_final_point=strstr($end2, '.',false);
                    $end_final=str_replace('.', '',$end_final_point);
                ?>
                Son: {{$letra_final}} con {{$end_final}}/100
                @if(isset($notas_credito->facturacion_id))
                    {{$notas_credito->nota_i_facturacion->moneda->nombre}}
                @elseif(isset($notas_credito->boleta_id))
                    {{$notas_credito->nota_i_boleta->moneda->nombre}}
                @elseif(isset($notas_credito->boleta_m_id))
                    {{$notas_credito->nota_i_boleta_manual->moneda->nombre}}
                @else
                    {{$notas_credito->nota_i_fac_manual->moneda->nombre}}
                @endif
               {{  }}end2}} --}}
            </h3>
        </div>
        <div class="col-sm-4 form-control">
            {{-- <div class="col-sm-4 form-control" > --}}
                <span style="display: block;float: left"> Subtotal:</span>
                <span style="display: block;float: right;">
                    @if(isset($notas_credito->facturacion_id))
                        {{$simbologia=$notas_credito->nota_i_facturacion->moneda->simbolo}}
                    @elseif(isset($notas_credito->boleta_id))
                        {{$simbologia=$notas_credito->nota_i_boleta->moneda->simbolo}}
                    @elseif(isset($notas_credito->boleta_m_id))
                        {{$simbologia=$notas_credito->nota_i_boleta_manual->moneda->simbolo}}
                    @else
                        {{$simbologia=$notas_credito->nota_i_fac_manual->moneda->simbolo}}
                    @endif
                        {{number_format($sub_total, 2)}}</span>
                <br>
                <span style="display: block;float: left"> Op. Gravada: </span>
                <span style="display: block;float: right">{{$simbologia}} {{number_format($notas_credito->op_gravada,2)}}</span><br>
                <span style="display: block;float: left"> Op. Inafecta: </span>
                <span style="display: block;float: right">{{$simbologia}} {{ number_format($notas_credito->op_inafecta,2)}}</span><br>
                <span style="display: block;float: left"> Op. Exonerada: </span>
                <span style="display: block;float: right">{{$simbologia}} {{number_format($notas_credito->op_exonerada,2)}} </span><br>
                <span style="display: block;float: left"> I.G.V.: </span>
                <span style="display: block;float: right">{{$simbologia}} {{number_format(round($igv_p, 2),2)}}</span><br>
                <span style="display: block;float: left"> Importe Total: </span>
                <span style="display: block;float: right">{{$simbologia}} {{number_format(round($end, 2),2)}}</span>

            </div>
        </div>
        <br>
        {{-- <div class="row">
            <div class="col-sm-12 form-control" style="height:  120px">
                <strong>Observaciones:</strong><br>
                {{$notas_credito->observacion}}
            </div>
        </div> --}}
        <br>
      <br>
    </div>
</div>
</body>
<style type="text/css">

    .form-control{border-radius: 10px; padding: 10px }
    .ibox-tools a{color: white !important}
    .a{height: 37px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}
    #watermark {
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 0;
    }
    #watermark p {
        position: absolute;
        color:   rgba(120, 120, 120, 0.31);
        font-weight: bolder;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        font-size: 95px;
        pointer-events: none;
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        top: 45%;
        right: 40%;
        z-index: 100;
    }
</style>

<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>

{{-- IMPRIMIR --}}
<script type="text/javascript">
    window.print();
</script>
</html>
