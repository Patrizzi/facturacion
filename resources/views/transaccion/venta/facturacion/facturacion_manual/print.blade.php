<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Facturación Manual/Print</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- <script src="@yield('vue_js', '#')" defer></script> -->

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        // function cerrar() {
        //     window.close();
        // }
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

    .qr-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .qr-box {
        width: 120px;
        height: 120px;
        border: 2px solid #3D3D3D;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
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

</head>

<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">

    <div class=" animated fadeInRight">

        {{-- <div class="ibox-tools">
               <a class="btn btn-success"  href="{{route('facturacion.print' , $facturacion->id)}}" target="_blank">Imprimir</a>
           </div>
       </div> --}}

        <div class="row">
            <div class="col-lg-12" style="margin-top: -5px;">
                @if ($facturacion->f_electronica == 2 || $facturacion->nota_credito == 1)
                    <div id="watermark">
                        <p>Anulado</p>
                    </div>
                @else
                @endif
                <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                    <div class="row" style="align-items: center; justify-content: center">
                        {{-- Cabecera logo y informacion --}}
                        @include('layout_cabecera_ventas')
                        <div class="col-sm-4 ">
                            <div class="form-control ruc" style="height: 125px">
                                <center>
                                    <h3 style="padding-top:10px ">R.U.C : {{ $empresa->ruc }}</h3>
                                    <h2>FACTURA ELECTRONICA</h2>
                                    <h5> {{ $facturacion->codigo_fac }}</h5>
                                </center>
                            </div>
                        </div>
                    </div><br>
                    <div class="row" align="center" style="padding-bottom: 5px">
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <!-- <h3> Datos Generales</h3> -->
                                <div align="left">
                                    <strong>Cliente:</strong>
                                    @if (isset($facturacion->cliente_id))
                                        {{ $facturacion->cliente->nombre }}
                                        @else{{ $facturacion->cotizacion->cliente->nombre }}
                                    @endif <br>
                                    <strong>R.U.C:</strong>
                                    @if (isset($facturacion->cliente_id))
                                        {{ $facturacion->cliente->numero_documento }}
                                        @else{{ $facturacion->cotizacion->cliente->numero_documento }}
                                    @endif <br>
                                    <strong>Dirección:</strong>
                                    @if (isset($facturacion->cliente_id))
                                        {{ $facturacion->cliente->direccion }}
                                        @else{{ $facturacion->cotizacion->cliente->direccion }}
                                    @endif <br>
                                    <strong>Condiciones de Pago:</strong>
                                    @if (isset($facturacion->cliente_id))
                                        {{ $facturacion->forma_pago->nombre }}
                                        @else{{ $facturacion->cotizacion->forma_pago->nombre }}
                                    @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Tipo de Moneda:</strong>
                                    @if (isset($facturacion->cliente_id))
                                        {{ $facturacion->moneda->nombre }}
                                        @else{{ $facturacion->cotizacion->moneda->nombre }}
                                    @endif <br>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <!-- <h3>Condiciones Generales</h3> -->
                                <div align="left">
                                    <strong>Orden de Compra:</strong>
                                    {{ $facturacion->orden_compra }} <br>
                                    <strong>Guia de Remisión:</strong>
                                    {{ $facturacion->guia_remision }} <br>
                                    <strong>Fecha Emisión:</strong>
                                    {{ $facturacion->fecha_emision }} <br>
                                    <strong>Fecha de Vencimiento:</strong>
                                    {{ $facturacion->fecha_vencimiento }} <br>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" align="center">
                            <div class="form-control" style="border: none;height: auto">
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
                                    <th style="text-align:center;width: 50px;">ITEM</th>
                                    <th style="text-align:center;width: 120px">CÓDIGO</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th style="text-align:center;width: 70px">CANT.</th>
                                    <th style="text-align:right;width: 110px">P. UNIT.</th>
                                    <th style="text-align:right;width: 110px;">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="text-align: center">
                                    <span hidden="hidden">{{ $i = 1 }} </span>
                                    @foreach ($facturacion_registro as $facturacion_registros)
                                <tr>
                                    <td style="text-align:center">{{ $i }} </td>
                                    @if (isset($facturacion_registros->producto))
                                        <td style="text-align:center">
                                            {{ $facturacion_registros->producto->codigo_producto }}</td>
                                        <td>{{ $facturacion_registros->producto->nombre }}
                                            {{ $facturacion_registros->descripcion_item }} @if (isset($facturacion_registros->numero_serie))
                                                <br><strong>N/S:</strong> {{ $facturacion_registros->numero_serie }}
                                            @endif
                                        </td>
                                    @else
                                        <td style="text-align:center">
                                            {{ $facturacion_registros->servicio->codigo_servicio }}</td>
                                        <td>{{ $facturacion_registros->servicio->nombre }}
                                            {{ $facturacion_registros->descripcion_item }}
                                    @endif
                                    <td style="text-align:center">{{ $facturacion_registros->cantidad }}</td>
                                    <td style="text-align:right">{{ number_format($facturacion_registros->precio, 2) }}
                                    </td>

                                    <td style="text-align:right">
                                        {{ number_format($facturacion_registros->precio * $facturacion_registros->cantidad - ($facturacion_registros->precio * $facturacion_registros->cantidad * $facturacion_registros->descuento) / 100, 2) }}
                                    </td>

                                    <td style="display: none">
                                        {{ $sub_total = $facturacion_registros->factura_ids->op_gravada + $facturacion_registros->factura_ids->op_inafecta + $facturacion_registros->factura_ids->op_exonerada }}
                                        {{ $sub_total_gravado = $facturacion_registros->factura_ids->op_gravada }}
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
                    </div><br><br><br><br>

                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3 align="left">
                                        <?php use Luecano\NumeroALetras\NumeroALetras;
                                        $v = new NumeroALetras();
                                        $letra = $v->toInvoice($end, 2);
                                        // $end_final_point = strstr($end2, '.', false);
                                        // $end_final = str_replace('.', '', $end_final_point);
                                        ?>
                                        Son : {{ ucfirst(mb_strtolower($letra,'UTF-8')) }} {{ $facturacion->moneda->nombre }}
                                        {{-- {{$end2}} --}}
                                    </h3>
                                    <br>
                                    <small style="font-size: 70%">
                                        Representación Impresa de <strong>FACTURA ELECTRÓNICA</strong>
                                    </small>
                                    <small style="font-size: 70%">
                                        Esta puede ser consultada en www.codecta.pe
                                    </small>
                                    <small style="font-size: 70%">
                                        Autorizado mediante Resolución de Intendencia N° 0180050001374/SUNAT
                                    </small>
                                </div>
                                <div class="col-sm-4 qr-container">
                                    <div class="qr-box">
                                        @if(!empty($qrCode))
                                            <img src="{{ $qrCode }}" alt="Código QR" class="qr-image">
                                        @else
                                            <span class="qr-placeholder">QR</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 form-control">
                            {{-- <div class="col-sm-4 form-control" > --}}
                            <span style="display: block;float: left"> Sub Total:</span>
                            <span style="display: block;float: right;">
                                {{ $simbologia = $facturacion->moneda->simbolo }}
                                {{ number_format($sub_total, 2) }}</span>
                            <br>
                            <span style="display: block;float: left"> Op. Agravada: </span>
                            <span style="display: block;float: right">{{ $simbologia }}
                                {{ number_format($facturacion->op_gravada, 2) }}</span><br>
                            <span style="display: block;float: left"> Op. Inafecta: </span>
                            <span style="display: block;float: right">{{ $simbologia }}
                                {{ number_format($facturacion->op_inafecta, 2) }}</span><br>
                            <span style="display: block;float: left"> Op. Exonerada: </span>
                            <span style="display: block;float: right">{{ $simbologia }}
                                {{ number_format($facturacion->op_exonerada, 2) }} </span><br>
                            <span style="display: block;float: left"> I.G.V.: </span>
                            <span style="display: block;float: right">{{ $facturacion->moneda->simbolo }}
                                {{ number_format(round($igv_p, 2), 2) }}</span><br>
                            <span style="display: block;float: left"> Importe Total: </span>
                            <span style="display: block;float: right">{{ $facturacion->moneda->simbolo }}
                                {{ number_format(round($end, 2), 2) }}</span>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        @if ($detraccion == 'not')
                            <div class="col-sm-12 form-control" style="height:  120px">
                                <strong>Observaciones:</strong><br>
                                {{ $facturacion->observacion }}
                            </div>
                        @else
                            <div class="col-sm-6 ">
                                <div class="form-control" style="height:  100px !important">
                                    <strong>Informacion de Detraccion:</strong><br>
                                    <strong>Tipo de Detraccion:</strong>
                                    {{ $detraccion->tipo_detraccion->descripcion }} -
                                    {{ $detraccion->porcentaje_detraccion }} %<br>
                                    <strong>Medio de Pago:</strong>
                                    {{ $detraccion->medio_pago->descripcion }} <br>
                                    <strong>Monto de Detraccion:</strong>
                                    S/. {{ number_format($detraccion->monto_detraccion, 2) }} <br>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-control" style="height:  100px !important">
                                    <strong>Observaciones:</strong><br>
                                    {{ $facturacion->observacion }}
                                </div>
                            </div>
                        @endif
                    </div>
                    <br>
                    @if ($cuotas != 'not')
                        <strong>Informacion de Crédito:</strong><br>
                        <div class="row" style="justify-content: left">
                            @foreach ($cuotas as $cuota)
                                <div style="display: none">
                                    @if ($facturacion->moneda->id == 1)
                                        {{ $monto_total_det = $cuota->monto - $detraccion->monto_detraccion }}
                                    @else
                                        {{ $mont_porc = $end * ($detraccion->porcentaje_detraccion / 100) }}
                                        {{ $monto_total_det = $end - $mont_porc }}
                                    @endif
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-control">
                                        <strong>Cuota:</strong><br>
                                        {{ $cuota->numero_cuota }}<br>
                                        <strong>Monto:</strong><br>
                                        {{ $facturacion->moneda->simbolo }} {{ number_format($monto_total_det, 2) }}
                                        <br>
                                        <strong>Fecha de Vencimiento:</strong><br>
                                        {{ Carbon\Carbon::parse($cuota->fecha_pago)->format('d-m-Y') }} <br>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <br>
                    @include('layout_bancos')
                    <br>
                </div>
            </div>



            <style type="text/css">
                .ruc {
                    border-radius: 10px;
                    height: 150px;
                }

                .form-control {
                    border-radius: 10px;
                }

                .a {
                    height: 30px;
                    margin: 0;
                    border-radius: 0px;
                    text-align: center;
                }
            </style>
            {{-- Modal Configuración --}}
            <div class="modal fade" id="config" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                        </div>
                        <div style="padding-left: 15px;padding-right: 15px;">
                            {{-- ccccccccccccccccc --}}
                            <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                <form action="{{ route('email.config') }}" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="row">
                                        <fieldset>
                                            <legend> Agregar Configuración </legend>
                                            {{-- <div> --}}
                                            <div class="panel-body" align="left">
                                                <div class="row">
                                                    <label class="col-sm-2 col-form-label">Email:</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control"
                                                            name="email" style="height: 75%;border-radius: 2px ">
                                                    </div>

                                                    <label class="col-sm-2 col-form-label">Contraseña:</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group m-b">
                                                            <input type="password" class="form-control"
                                                                name="password" id="txtPassword" required=""
                                                                style="height: 35.2px;border-radius: 2px ">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-addon"
                                                                    style="height: 35.22222px;margin-top: 5px;">
                                                                    <i class="fa fa-eye-slash " id="ojo"
                                                                        onclick="mostrarPassword()"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-2 col-form-label">SMPT:</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="smtp"
                                                            placeholder="smtp.gmail.com" required=""
                                                            style="border-radius: 2px">
                                                    </div>

                                                    <label class="col-sm-2 col-form-label">PORT:</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="port"
                                                            value="110 " style="border-radius: 2px">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-2 col-form-label">Encryption:</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" name="encryp" required=""
                                                            style="height: 85%;border-radius: 2px;padding-top: 4px">
                                                            <option value="">Ninguno</option>
                                                            <option value="SSL">SSL</option>
                                                            <option value="TLS">TLS</option>
                                                        </select>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <label class="col-sm-2 col-form-label">Firma (opcional):</label>
                                                    <div class="col-sm-10">
                                                        <input type="file" id="archivoInput" name="firma"
                                                            onchange="return validarExt()"
                                                            style="border-radius: 2px" />
                                                        <span id="visorArchivo">
                                                            <!--Aqui se desplegará el fichero-->
                                                            <img name="firma" src="" width="390px"
                                                                height="200px" />
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-2 col-form-label">Ancho(px)</label>
                                                    <div class="col-sm-4">
                                                        <input type="number" class="form-control"
                                                            name="ancho_firma">
                                                    </div>
                                                    <label class="col-sm-2 col-form-label">Alto(px)</label>
                                                    <div class="col-sm-4">
                                                        <input type="number" class="form-control" name="alto_firma">
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Grabar</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Fin de modal configuración --}}
            <style>
                * {
                    color: black !important;
                }

                .table>thead>tr>th,
                .table>tbody>tr>th,
                .table>tfoot>tr>th,
                .table>thead>tr>td,
                .table>tbody>tr>td,
                .table>tfoot>tr>td {
                    border-top-width: 0px;
                    border-color: #3D3D3D
                }

                #auto {
                    /*padding: -100px;*/
                    /*background: orange;*/
                    /*width: 95px;*/
                    cursor: pointer;
                    /*margin-top: 10px;*/
                    /*margin-bottom: 10px;*/
                    box-shadow: 0px 0px 1px #000;
                    display: inline-block;
                }

                #auto:hover {
                    opacity: .8;
                }

                #div-mostrar {
                    /*width: 50%;*/
                    margin: auto;
                    height: 0px;
                    /*margin-top: -5px*/
                    /*background: #000;*/
                    /*box-shadow: 10px 10px 3px #D8D8D8;*/
                    transition: height .4s;
                    color: white;
                    text-align: right;
                }

                #auto:hover {
                    opacity: .8;
                }

                #auto:hover+#div-mostrar {
                    height: 50px;
                }
            </style>

            <style>
                .form-control {
                    margin-top: 5px;
                    border-radius: 5px;
                    border-color: #3D3D3D;
                }

                p#texto {
                    text-align: center;
                    color: black;
                }

                input#archivoInput {
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    right: 0px;
                    bottom: 0px;
                    width: 100%;
                    height: 100%;
                    opacity: 0;
                }

                #watermark {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 0;
                }

                #watermark p {
                    position: absolute;
                    color: rgba(120, 120, 120, 0);
                    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
                    font-weight: bolder;
                    font-size: 95px !important;
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

                p.form-control {
                    border-color: #3D3D3D;
                }
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
