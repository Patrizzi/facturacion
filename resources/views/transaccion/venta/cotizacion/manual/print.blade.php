<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cotizacion- Impresion</title>

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
    <div class="">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                        <div class="row">
                            @include('layout_cabecera_ventas')
                            <div class="col-sm-4">
                                <div class="form-control" align="center" style="height: auto;">
                                    <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                    <h2 style="font-size: 19px">COTIZACION ELECTRONICA</h2>
                                    <h5> {{$cotizacion_m->cod_cotizacion}}</h5>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>Señor(es):</strong> &nbsp;{{$cotizacion_m->cliente->nombre}}<br>
                                        <strong>{{$cotizacion_m->cliente->documento_identificacion}} :</strong> &nbsp;{{$cotizacion_m->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Fecha:</strong> &nbsp;{{$cotizacion_m->fecha_emision}}<br>
                                        <strong>Direccion:</strong>&nbsp; {{$cotizacion_m->cliente->direccion}}<br>
                                        <strong>Telefono:</strong>&nbsp; {{$cotizacion_m->cliente->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Celular:</strong>&nbsp; {{$cotizacion_m->cliente->celular}}<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control" >
                                    <h3>Condiciones Generales</h3>
                                    <div align="left">
                                        <strong>Forma De Pago:</strong> &nbsp;{{$cotizacion_m->forma_pago->nombre  }}<br>
                                        <strong>Validez :</strong> &nbsp;{{$cotizacion_m->validez}}<br>
                                        <strong>Garantia:</strong> &nbsp;{{$cotizacion_m->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <strong>Tipo de Moneda:</strong> &nbsp;{{$cotizacion_m->moneda->nombre}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-sm-12" align="center">
                                    <div class="form-control" style="border: none;height: auto" >
                                        <div align="left">
                                            <strong>observaciones:</strong> &nbsp;{{$cotizacion_m->observacion }}<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table " >
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">ITEM </th>
                                            <th style="text-align:center;">Codigo </th>
                                            <th>Descripcion</th>
                                            <th style="text-align:center;">Cantidad</th>
                                            <th style="text-align:center;">P.Unitario</th>
                                            <th style="text-align:center;">Total<span >{{$cotizacion_m->moneda->simbolo}}</span></th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <span hidden="">{{$i=1}}</span>
                                        @foreach($cotizacion_m_reg as $cotizacion_registros)
                                        <tr>
                                            <td>{{$j++}} </td>
                                            @if(isset($cotizacion_registros->producto->codigo_producto))
                                                <td>
                                                    {{$cotizacion_registros->producto->codigo_producto}}
                                                </td>
                                                <td>
                                                    {{$cotizacion_registros->producto->nombre}} | {{$cotizacion_registros->descripcion_item}} </span>
                                                </td>
                                            @else
                                                <td>
                                                    {{$cotizacion_registros->servicio->codigo_servicio}}
                                                </td>
                                                <td>
                                                    {{$cotizacion_registros->servicio->nombre}} | {{$cotizacion_registros->descripcion_item}} </span>
                                                </td>
                                            @endif                        
                                            <td>{{$cotizacion_registros->cantidad}}</td>
                                            <td>{{number_format($cotizacion_registros->precio,2)}}</td>
                                            <td>{{number_format($cotizacion_registros->cantidad*$cotizacion_registros->precio,2)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3 align="left">
                                        <?php $v=new CifrasEnLetras() ;
                                        $letra=($v->convertirEurosEnLetras($end));
                                        $letra_final = ucfirst(strstr($letra, 'soles',true));
                                        $end_final_point=strstr($end2, '.', false);
                                        $end_final=str_replace('.', '',$end_final_point);
                                        ?>
                                        Son : {{$letra_final}} con {{$end_final}}/100 {{$cotizacion_m->moneda->nombre }}
                                    </h3>         
                                </div>
                                <div class="col-sm-4 form-control ">
                                        <span style="display: block;float: left"> Subtotal:</span>
                                        <span style="display: block;float: right;"> {{$simbologia=$cotizacion_m->moneda->simbolo}} {{number_format($sub_total, 2)}}</span>
                                        <br>
                                        <span style="display: block;float: left"> Op. Gravada: </span>
                                        <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion_m->op_gravada,2)}}</span><br>
                                        <span style="display: block;float: left"> Op. Inafecta: </span>
                                        <span style="display: block;float: right">{{$simbologia}} {{ number_format($cotizacion_m->op_inafecta,2)}}</span><br>
                                        <span style="display: block;float: left"> Op. Exonerada: </span>
                                        <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion_m->op_exonerada,2)}} </span><br>
                                        <span style="display: block;float: left"> I.G.V.: </span>
                                        <span style="display: block;float: right">{{$cotizacion_m->moneda->simbolo}} {{number_format(round($igv, 2),2)}}</span><br>
                                        <span style="display: block;float: left"> Importe Total: </span>
                                        <span style="display: block;float: right">{{$cotizacion_m->moneda->simbolo}} {{number_format($end,2)}}</span>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <br>
                            @include('layout_bancos')
                            <br>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p><u>centro de Atencion : </u></p>
                                    Telefono : {{$cotizacion_m->user_personal->personal->telefono }}<br>
                                    Celular : {{$cotizacion_m->user_personal->personal->celular }}<br>
                                    Email : {{$cotizacion_m->user_personal->personal->email }}<br>
                                    Web : {{$empresa->pagina_web}} <br>
                                </div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3"><br><br>
                                    <hr>
                                    <center>{{$cotizacion_m->user_personal->personal->nombres }}</center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<style>
    .form-control{margin-top: 5px; border-radius: 5px}
    p#texto{
        text-align: center;
        color:black;
    }

    input#archivoInput{
        position:absolute;
        top:0px;
        left:0px;
        right:0px;
        bottom:0px;
        width:100%;
        height:100%;
        opacity: 0  ;
    }
</style>
<style type="text/css">
    .form-control{border-radius: 10px; padding: 10px;border-color: #3D3D3D }
    .ibox-tools a{color: white !important}
    .a{height: 37px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;border-color: #3D3D3D}
    *{
        color: black;
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
