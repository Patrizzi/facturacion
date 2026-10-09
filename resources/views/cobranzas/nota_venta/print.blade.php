<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detalle de Pago - {{ $nota_venta->cod_nota_venta }}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="@yield('vue_js', '#')" defer></script>
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">

    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
            window.close();
        }
    </SCRIPT>
</head>

<body class="white-bg">
    <div class=" animated fadeInRight">
        <div class=" animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                        <div class="row">
                            {{-- Cabecera logo y informacion --}}
                            @include('layout_cabecera_ventas')
                            <div class="col-sm-4">
                                <div class="form-control" align="center" style="height: auto;">
                                    <h3 style="padding-top:10px ">R.U.C {{ $empresa->ruc }}</h3>
                                    <h2 style="font-size: 19px">REPORTE DE PAGOS</h2>
                                    <h5>{{ $nota_venta->cod_nota_venta }} </h5>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>Señor(es):</strong> {{ $nota_venta->cliente->nombre }}<br>
                                        <strong>{{ $nota_venta->cliente->documento_identificacion }} :</strong>
                                        {{ $nota_venta->cliente->numero_documento }}<br>
                                        <strong>Dirección:</strong> {{ $nota_venta->cliente->direccion }}<br>
                                        <strong>N° Contacto:</strong> {{ $nota_venta->cliente->celular }}
                                        @if (isset($nota_venta->cliente->telefono))
                                            / {{ $nota_venta->cliente->telefono }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Condiciones Generales</h3>
                                    <div align="left">
                                        <strong>Forma De Pago: </strong>{{ $nota_venta->forma_pago }}<br>
                                        <strong>Fecha: </strong>
                                        {{ Carbon\Carbon::parse($nota_venta->created_at)->format('d-m-Y h:m:s') }}<br>
                                        <strong> </strong>
                                        <strong>Tipo de Moneda:</strong>
                                        {{ $nota_venta->moneda->nombre }}<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" align="center">
                                <div class="" style="border: none;height: auto;margin: 15px 0px">
                                    <div align="left">
                                        <strong>Observaciones:</strong> Emitimos la siguiente informacion <br>
                                    </div>
                                </div>
                            </div>
                            <br>

                        </div>
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Codigo de Pago</th>
                                                <th>Estado</th>
                                                <th>Monto</th>
                                                <th>Monto Cancelado</th>
                                                <th>Fecha de Vencimiento</th>
                                                <th>Metodo de Pago</th>
                                                <th>Fecha de Pago</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- {{$boleta}} --}}
                                            {{-- @foreach ($empresa as $index => $item) --}}
                                            {{-- <span
                                                hidden>{{ $subtotal = $nota_venta->op_gravada + $nota_venta->op_inafecta + $nota_venta->op_exonerada }}</span> --}}
                                            <tr>
                                                <td>1</td>
                                                <td>N° de Cuota 1</td>
                                                <td>
                                                    @if ($nota_venta->estado_pago == 2)
                                                        <strong>PAGADA</strong>
                                                    @else
                                                        <strong>SIN PAGAR</strong>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $nota_venta->moneda->simbolo }}
                                                    {{ number_format(round($nota_venta->total_nota_venta(), 2), 2) }}
                                                </td>
                                                <td>
                                                    @if ($nota_venta->estado_pago == 2)
                                                        {{ $nota_venta->moneda->simbolo }}
                                                        {{ $pagos_reg[0]->comprobante_pago->monto_pago }}
                                                    @else
                                                        {{ $nota_venta->moneda->simbolo }} 0.00
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ Carbon\Carbon::parse($nota_venta->fecha_vencimiento)->format('d-m-Y') }}
                                                </td>

                                                @if ($nota_venta->estado_pago == 2)
                                                    <td>
                                                        {{ ucfirst($pagos[0]->tipo_pago) }}
                                                    </td>
                                                    <td>{{ Carbon\Carbon::parse($nota_venta->fecha_registro)->format('d-m-Y') }}
                                                    </td>
                                                @else
                                                    <td>
                                                        <i>Aun no ha sido Cancelado</i>
                                                    </td>
                                                    <td>
                                                        <i>Aun no ha sido Cancelado</i>
                                                    </td>
                                                @endif
                                            </tr>
                                            {{-- @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                                {{-- @endif --}}
                            </div>
                            <br>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="" style=" margin-bottom: 20px;padding-bottom: 50px;">
                            <div>
                                <div class="row">
                                    <div class="col-sm-8" align="center">
                                    </div>
                                    <div class="col-sm-4" align="center">
                                        <div class="form-control">
                                            <div align="left">
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <p><strong>Monto Total de Deuda:</strong></p>
                                                        <p><strong>Monto Pagado:</strong></p>
                                                        <p><strong>Monto Total Deuda:</strong></p>
                                                    </div>
                                                    <div style="display: none">
                                                        @if ($nota_venta->estado_pago == 0)
                                                            {{ $pagado = round($nota_venta->total_nota_venta()) }}
                                                            {{ $total = 0 }}
                                                        @else
                                                            {{ $total = floatval($pagos[0]->monto_pago) }}
                                                            {{ $pagado = floatval($pagos[0]->monto_pago) }}
                                                        @endif
                                                        {{ $all_tot = $pagado - $total }}
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <p>{{ $nota_venta->moneda->simbolo }}
                                                            {{ number_format($pagado, 2) }}
                                                        </p>
                                                        <p>{{ $nota_venta->moneda->simbolo }}
                                                            {{ number_format($total, 2) }}
                                                        </p>
                                                        <p>{{ $nota_venta->moneda->simbolo }}
                                                            {{ number_format($all_tot, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                            </div>
                            @include('layout_bancos')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<style type="text/css">
    .form-control {
        border-radius: 10px;
        height: auto;
        border-color: #3D3D3D
    }

    .ibox-tools a {
        color: white !important
    }

    .a {
        height: 30px;
        margin: 0;
        border-radius: 0px;
        text-align: center;
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

    #watermark {
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 0;
    }

    #watermark p {
        position: absolute;
        color: rgba(120, 120, 120, 0.31);
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

    * {
        color: black;
    }

    p.form-control {
        border-color: #3D3D3D;
    }

    footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 350px;
        /* altura de pie de página */
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
