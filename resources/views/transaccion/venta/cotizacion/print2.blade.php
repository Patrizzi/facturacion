<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cotización- Impresión</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="@yield('vue_js', '#')" defer></script>
    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
        window.close();
        }
    </SCRIPT>
</head>
{{-- LLAMADO AL BODY EN FUNCION CERRAR CON UNA DURACION DE 10 SEGUNDOS --}}
<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                        <div class="row">
                            {{-- Cabecera logo y informacion --}}
                            @include('layout_cabecera_ventas')
                            <div class="col-sm-4">
                                <div class="form-control" align="center" style="height: auto;">
                                    <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                    <h2 style="font-size: 19px">COTIZACIÓN ELECTRONICA</h2>
                                    <h5>{{$cotizacion->cod_cotizacion}} </h5>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>Señor(es):</strong> &nbsp;{{$cotizacion->cliente->nombre}}<br>
                                        <strong>{{$cotizacion->cliente->documento_identificacion}} :</strong> &nbsp;{{$cotizacion->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <strong>Dirección:</strong>&nbsp; {{$cotizacion->cliente->direccion}}<br>
                                        <strong>N° Contacto:</strong>&nbsp; {{$cotizacion->cliente->celular}}
                                        @if(isset($cotizacion->cliente->telefono))
                                            / {{$cotizacion->cliente->telefono}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                            <div class="form-control" >
                                <h3>Condiciones Generales</h3>
                                <div align="left">
                                        <strong>Forma De Pago:</strong> &nbsp;{{$cotizacion->forma_pago->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha:</strong> &nbsp;{{$cotizacion->created_at}}<br>
                                        <strong>Validez:</strong> &nbsp;{{$cotizacion->validez}}<br>
                                        <strong>Garantía:</strong> &nbsp;{{$cotizacion->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <strong>Tipo de Moneda:</strong> &nbsp;{{$cotizacion->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" align="center">
                            <div class="form-control" style="border: none;height: auto" >
                                <div align="left">
                                    <strong>Observaciones:</strong> &nbsp;{{$cotizacion->observacion }}<br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table " >
                            <thead>
                                <tr>
                                    <th style="width: 4%">Item</th>
                                    <th style="width: 12%">Código</th>
                                    <th>Descripción</th>
                                    <th style="width: 12%">Cantidad</th>
                                    <th style="width: 12%">P.Unitario</th>
                                    <th style="width: 12%">Total<span hidden="hidden">{{$simbologia=$cotizacion->moneda->simbolo}}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotizacion_registro as $cotizacion_registros)
                                <tr>
                                    <td>{{$i++}} </td>
                                    @if(isset($cotizacion_registros->producto_id))
                                    <td>{{$cotizacion_registros->producto->codigo_producto}}</td>
                                    <td>{{$cotizacion_registros->producto->nombre}} <br>{{$cotizacion_registros->descipcion_item}}</span></td>
                                    @else
                                    <td>{{$cotizacion_registros->servicio->codigo_servicio}}</td>
                                    <td>{{$cotizacion_registros->servicio->nombre}} <br>{{$cotizacion_registros->descipcion_item}}</span></td>
                                    @endif
                                    
                                    <td>{{$cotizacion_registros->cantidad}}</td>
                                    <td style="text-align: right;padding-right: 5%">{{number_format($cotizacion_registros->precio_unitario_comi,2)}}</td>
                                    <td style="text-align: right;padding-right: 5%">{{number_format($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi,2)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- /table-responsive -->
                <footer style="padding-top: 120px">
                    <div class="row">
                        <div class="col-sm-8 ">
                            <h3 align="left">
                                <?php $v=new CifrasEnLetras() ;
                                    $letra=($v->convertirEurosEnLetras($end));
                                    $letra_final = ucfirst(strstr($letra, 'soles',true));
                                    $end_final_point=strstr($end2, '.', false); 
                                    $end_final=str_replace('.', '',$end_final_point);
                                ?>
                                Son : {{$letra_final}} con {{$end_final}}/100 {{$cotizacion->moneda->nombre }}
                            </h3>
                        </div>
                        <div class="col-sm-4 form-control" >
                            <span style="display: block;float: left"> Subtotal:</span>
                            <span style="display: block;float: right;"> {{$simbologia=$cotizacion->moneda->simbolo}} {{number_format($sub_total, 2)}}</span>
                            <br>
                            <span style="display: block;float: left"> Op. Agravada: </span>
                            <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion->op_gravada,2)}}</span><br>
                            <span style="display: block;float: left"> Op. Inafecta: </span>
                            <span style="display: block;float: right">{{$simbologia}} {{ number_format($cotizacion->op_inafecta,2)}}</span><br>
                            <span style="display: block;float: left"> Op. Exonerada: </span>
                            <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion->op_exonerada,2)}} </span><br>
                            <span style="display: block;float: left"> I.G.V.: </span>
                            <span style="display: block;float: right">{{$cotizacion->moneda->simbolo}} {{number_format(round($igv_p, 2),2)}} </span><br>
                            <span style="display: block;float: left"> Importe Total: </span>
                            <span style="display: block;float: right">{{$cotizacion->moneda->simbolo}} {{number_format($end,2)}}</span> 
                        </div>
                    </div>
                </footer>
                <br>
                <!-- Fin Totales de Productos -->
                @include('layout_bancos')
                <br>
                @include('layout_firma_pie_hoja')        
                </div>
            </div>
        </div>
    </div>
</body>
{{--  --}}
<style type="text/css">
    .form-control{border-radius: 10px; padding: 10px }
    .ibox-tools a{color: white !important}
    .a{height: 37px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}
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
