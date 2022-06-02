<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Boleta Manual/Print</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- <script src="@yield('vue_js', '#')" defer></script> -->

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

    <link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
            window.close();
        }
    </SCRIPT>

</head>
<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">
    <div class="row">
        <div class="col-lg-12" style="margin-top: -5px;">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    @include('layout_cabecera_ventas')
                    <div class="col-sm-4 ">
                        <div class="form-control ruc" style="height: 125px">
                            <center>
                                <h3 style="padding-top:10px ">R.U.C : {{ $empresa->ruc }}</h3>
                                <h2>BOLETA ELECTRONICA</h2>
                                <h5> {{ $boleta->codigo_boleta }}</h5>
                            </center>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <div align="left">
                                <strong>Cliente:</strong>
                                    @if (isset($boleta->cliente_id))
                                        {{ $boleta->cliente->nombre }}
                                    @else
                                        {{ $boleta->cotizacion->cliente->nombre }}
                                    @endif 
                                <br>
                                <strong>N° de Documento:</strong>
                                    @if (isset($boleta->cliente_id))
                                        {{ $boleta->cliente->numero_documento }}
                                        @else
                                        {{ $boleta->cotizacion->cliente->numero_documento }}
                                    @endif 
                                <br>
                                <strong>Dirección:</strong>
                                    @if (isset($boleta->cliente_id))
                                        {{ $boleta->cliente->direccion }}
                                    @else
                                        {{ $boleta->cotizacion->cliente->direccion }}
                                    @endif 
                                <br>
                                <strong>Condiciones de Pago:</strong>
                                    @if (isset($boleta->cliente_id))
                                        {{ $boleta->forma_pago->nombre }}
                                    @else
                                        {{ $boleta->cotizacion->forma_pago->nombre }}
                                    @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Tipo de Moneda:</strong>
                                    @if (isset($boleta->cliente_id))
                                        {{ $boleta->moneda->nombre }}
                                    @else
                                        {{ $boleta->cotizacion->moneda->nombre }}
                                    @endif 
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-control">
                            <div align="left">
                                <strong>Orden de Compra:</strong>
                                {{ $boleta->orden_compra }} 
                                <br>
                                <strong>Guia de Remisión:</strong>
                                {{ $boleta->guia_remision }} 
                                <br>
                                <strong>Fecha Emisión:</strong>
                                {{ $boleta->fecha_emision }} 
                                <br>
                                <strong>Fecha de Vencimiento:</strong>
                                {{ $boleta->fecha_vencimiento }} 
                                <br> 
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center">Item</th>
                                <th style="text-align:center">Código Producto</th>
                                <th>Descripción</th>
                                <th style="text-align:center">Cantidad</th>
                                <th style="text-align:center">Valor Unitario</th>

                                <th style="text-align:center">Valor Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <span hidden="hidden">{{ $i = 1 }} </span>
                            <tr>
                                @foreach ($boleta_registro as $boletas_registros)
                                    <td style="text-align:center">{{ $i }} </td>
                                    @if (isset($boletas_registros->producto_id))
                                        <td style="text-align:center">
                                            {{ $boletas_registros->producto->codigo_producto }}
                                        </td>
                                        <td>
                                            {{ $boletas_registros->producto->nombre }}
                                            {{ $boletas_registros->descripcion_item }} 
                                            @if (isset($boletas_registros->numero_serie))
                                                <br><strong>N/S:</strong> {{ $boletas_registros->numero_serie }}
                                            @endif
                                        </td>
                                    @else
                                        <td style="text-align:center">{{ $boletas_registros->servicio->codigo_servicio }}</td>
                                        <td>
                                            {{ $boletas_registros->servicio->nombre }} 
                                            {{ $boletas_registros->descripcion_item }} 
                                            @if (isset($boletas_registros->numero_serie))
                                                <br><strong>N/S:</strong> {{ $boletas_registros->numero_serie }} 
                                            @endif
                                        </td>
                                    @endif
                                    <td style="text-align:center">{{ $boletas_registros->cantidad }}</td>
                                    <td style="text-align:center">{{number_format($boletas_registros->precio,2)}}</td>

                                    <td style="text-align:center">{{number_format( $boletas_registros->precio * $boletas_registros->cantidad - ($boletas_registros->precio * $boletas_registros->cantidad * $boletas_registros->descuento/100),2) }}</td>

                                <td style="display: none">
                                    {{ $sub_total =$boletas_registros->boleta_i->op_gravada + $boletas_registros->boleta_i->op_inafecta +$boletas_registros->boleta_i->op_exonerada }}
                                    {{ $sub_total_gravado = $boletas_registros->boleta_i->op_gravada }}
                                    {{ $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100 }}
                                    {{ $end = round($sub_total, 2) + round($igv_p, 2) }}
                                    {{ $end2 = number_format(round($sub_total, 2) + round($igv_p, 2), 2) }}
                                </td>
                            </tr>
                            <span hidden="hidden">{{ $i++ }}</span>
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-8">
                        <h3 align="left">
                            <?php $v = new CifrasEnLetras();
                            $letra = $v->convertirEurosEnLetras($end);
                            $letra_final = ucfirst(strstr($letra, 'soles', true));
                            $end_final_point = strstr($end2, '.', false);
                            $end_final = str_replace('.', '', $end_final_point);
                            ?>
                            Son: {{ $letra_final }} con {{ $end_final }}/100 {{ $boleta->moneda->nombre }}
                            {{-- {{$end2}} --}}
                        </h3>
                    </div>
                    <div class="col-sm-4 form-control">
                        {{-- <div class="col-sm-4 form-control" > --}}
                        <span style="display: block;float: left"> Sub Total:</span>
                        <span style="display: block;float: right;"> {{ $simbologia = $boleta->moneda->simbolo }}
                            {{ number_format($sub_total, 2) }}</span>
                        <br>
                        <span style="display: block;float: left"> Op. Agravada: </span>
                        <span style="display: block;float: right">{{ $simbologia }}
                            {{ number_format($boleta->op_gravada, 2) }}</span><br>
                        <span style="display: block;float: left"> Op. Inafecta: </span>
                        <span style="display: block;float: right">{{ $simbologia }}
                            {{ number_format($boleta->op_inafecta, 2) }}</span><br>
                        <span style="display: block;float: left"> Op. Exonerada: </span>
                        <span style="display: block;float: right">{{ $simbologia }}
                            {{ number_format($boleta->op_exonerada, 2) }} </span><br>
                        <span style="display: block;float: left"> I.G.V.: </span>
                        <span style="display: block;float: right">{{ $boleta->moneda->simbolo }}
                            {{ number_format(round($igv_p, 2), 2) }}</span><br>
                        <span style="display: block;float: left"> Importe Total: </span>
                        <span style="display: block;float: right">{{ $boleta->moneda->simbolo }}
                            {{ number_format(round($end, 2), 2) }}</span>

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 form-control" align="center" style="margin-top: 8px">
                        <div align="left">
                            <strong>Observación:</strong>
                            <p> {{$boleta->observacion }} </p>
                        </div>
                    </div>
                </div>
                <br>
                @include('layout_bancos')
                <br>
            </div>
        </div>
    </div>

</div>
<style type="text/css">
    .ruc{border-radius: 10px; height: 150px;}
    .form-control{border-radius: 10px;border-color: #808080}
    .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}

</style>
<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

{{-- IMPRIMIR --}}
<script type="text/javascript">
    window.print();
</script>

</body>
</html>