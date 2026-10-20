@extends('layout')

@section('title', 'Boleta ')
@section('breadcrumb', 'Boleta')
@section('breadcrumb2', 'Boleta')
@section('href_accion', route('boleta.index'))
@section('value_accion', 'Inicio')
@section('button2', 'Nueva Boleta')
@section('onclick', "event.preventDefault();document.getElementById('nueva_cots').submit();")
@section('content')

    <form action="{{ route('boleta.create') }}"enctype="multipart/form-data" method="post" id="nueva_cots">
        @csrf
        <input type="text" hidden="hidden" name="almacen" value="{{ $boleta->almacen_id }}">
        <input hidden="hidden" type="submit" />
    </form>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title d-flex justify-content-between" style="padding-right: 3.1%">
                @include('transaccion.comprobantes._shared.btn_create_with_almacen', [
                    'routeCreate' => 'boleta.create',
                    'almacen' => $almacen,
                    'useAlmacen' => true,
                    'method' => 'POST',
                ])
                <div class="ibox-tools" style="margin-top: 5px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up text-muted"></i>
                    </a>
                    <a href="{{ route('comprobantes.index_boleta') }}" title="Cerrar">
                        <i class="fa fa-times text-muted"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row align-items-center">
                    <div class="col-12 col-md-5">
                        <h3 style="margin: 0;">{{ $boleta->codigo_boleta }}</h5>
                            <strong style="margin: 0;">R.U.C : </strong>{{ $empresa->ruc }}
                    </div>
                    <div class="col-12 col-md-2 text-center">
                        <h2 class="mb-0 text-nowrap">
                            BOLETA ELECTRÓNICA
                        </h2>
                    </div>
                    <div class="col-12 col-md-5 d-flex flex-wrap justify-content-end align-items-center" style="gap: 4px;">
                        @phpuse Carbon\Carbon;
                        use App\Boleta; @endphp
                        @if ($boleta->nota_credito != 0)
                            <div class="d-flex align-items-center" style="overflow: hidden;">
                                {{-- Botón NC (oculto por defecto) --}}
                                <div id="nc-slider" style="width: 0; overflow: hidden; transition: width 0.3s ease;">
                                    <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom"
                                        data-original-title="Motivo: {{ Boleta::search_motivo_nc($boleta->id) }}"
                                        href="{{ route('nota-credito.show', Boleta::nota_credito_id($boleta->id)) }}"
                                        style="white-space: nowrap; margin-right: 4px;">
                                        <i class="fa fa-file-text fa-lg"></i>
                                    </a>
                                </div>
                                {{-- Flecha toggle --}}
                                <button id="nc-toggle" onclick="toggleNC()" class="btn btn-sm btn-default"
                                    style="border: 1px solid #ccc; padding: 5px 8px; transition: transform 0.3s;">
                                    <i class="fa fa-chevron-left" id="nc-arrow"></i>
                                </button>
                            </div>
                            {{-- Divisor --}}
                            <div style="width: 1px; height: 30px; background-color: #ccc; margin: 0 6px;"></div>
                        @endif
                        <form class="btn" style="padding: 0;" action="{{ route('pdf_bol', $boleta->id) }}">
                            <input type="text" name="name" maxlength="50" hidden value="{{ $boleta->codigo_boleta }}">
                            <button type="submit" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom"
                                data-original-title="Descargar PDF"><i class="fa fa-file-pdf-o fa-lg"></i></button>
                        </form>

                        <a href="{{ route('boleta.ticket', $boleta->id) }}" class="btn btn-sm btn-info" target="_blank">
                            <i class="fa fa-ticket fa-lg"></i>
                        </a>

                        <a class="btn btn-sm btn-success" href="{{ route('boleta.print', $boleta->id) }}" target="_blank"
                            data-toggle="tooltip" data-placement="bottom" data-original-title="Imprimir">
                            <i class="fa fa-print fa-lg"></i>
                        </a>

                        @if (Auth::user()->email_creado == 1)
                            <form action="{{ route('email.boleta', $boleta->id) }}" method="post" style="padding: 0;"
                                class="btn">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                    data-placement="bottom" data-original-title="Enviar por correo" formtarget="_blank">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </button>
                            </form>
                        @endif

                        <div style="position: relative; display: inline-block;">
                            <div id="auto" onclick="divAuto()">
                                <a class="btn btn-sm btn-success" style="background: green; border-color: green;">
                                    <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                </a>
                            </div>
                        </div>

                        @if ($boleta->estado == 0)
                            <button class="btn btn-sm btn-warning btn-editar" id="edit" onclick="click_editar()">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn-no-editar no_mostrar btn btn-warning btn-sm" onclick="click_cancelar_editar()">
                                <i class="fa fa-times"></i>
                            </button>
                        @endif

                        <div id="div-mostrar" style="height: 0px; overflow: hidden; width: 100%; transition: height .4s;">
                            <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="btn"
                                style="text-align: none;padding-right: 0;padding-left: 0;">
                                @csrf
                                <input type="tel" name="numero" value="{{ $boleta->cliente->celular }}" />
                                <input type="text" name="mensaje" id="texto_orden" hidden />
                                <input type="text" hidden name="url"
                                    value="{{ route('boleta_manual.pdf', $boleta->id) }}?archivo=">
                                <input type="text" name="name_sin_cambio" hidden
                                    value="BoletaM_{{ $boleta->codigo_boleta }}" />
                                <button type="submit" class="btn btn-success btn-sm"
                                    style="background: green;border-color: green;" formtarget="_blank"
                                    data-toggle="tooltip" data-placement="bottom"
                                    data-original-title="Enviar por Whatsapp">
                                    <i class="fa fa-send fa-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-top: -26px;">
                <div class="ibox-content" style=" margin-bottom: 20px;padding-bottom: 50px;">
                    @if ($boleta->b_electronica != 0 || ($boleta->nota_credito == 1 && $boleta->motivo == '01'))
                        <div id="watermark">
                            <p>Anulado</p>
                        </div>
                        @endif
                    <br>
                    <div class="table-no mostrar">
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3> Datos Generales</h3>
                                    <div align="left">
                                        <strong>Cliente:</strong>
                                        @if (isset($boleta->cliente_id))
                                            {{ $boleta->cliente->nombre }}
                                            @else{{ $boleta->cotizacion->cliente->nombre }}
                                        @endif <br>
                                        <strong>N° de Documento:</strong>
                                        @if (isset($boleta->cliente_id))
                                            {{ $boleta->cliente->numero_documento }}
                                            @else{{ $boleta->cotizacion->cliente->numero_documento }}
                                        @endif <br>
                                        <strong>Dirección:</strong>
                                        @if (isset($boleta->cliente_id))
                                            {{ $boleta->cliente->direccion }}
                                            @else{{ $boleta->cotizacion->cliente->direccion }}
                                        @endif <br>
                                        <strong>Condiciones de Pago:</strong>
                                        @if (isset($boleta->cliente_id))
                                            {{ $boleta->forma_pago->nombre }}
                                            @else{{ $boleta->cotizacion->forma_pago->nombre }}
                                        @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Tipo de
                                            Moneda:</strong>
                                        @if (isset($boleta->cliente_id))
                                            {{ $boleta->moneda->nombre }}
                                            @else{{ $boleta->cotizacion->moneda->nombre }}
                                        @endif <br>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Condiciones Generales</h3>
                                    <div align="left">
                                        <strong>Orden de Compra:</strong>
                                        {{ $boleta->orden_compra }} <br>
                                        <strong>Guía de Remisión:</strong>
                                        {{ $boleta->guia_remision }} <br>
                                        <strong>Fecha Emisión:</strong>
                                        {{ $boleta->fecha_emision }} <br>
                                        <strong>Fecha de Vencimiento:</strong>
                                        {{ $boleta->fecha_vencimiento }} <br>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="table-no mostrar ">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Código de Item</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Valor Unitario</th>
                                    <th>Dscto. %</th>
                                    <th>P. Unitario Desc.</th>
                                    <th>Comisión</th>
                                    <th>P. Unitario Com.</th>
                                    <th>Valor Venta </th>
                                </tr>
                            </thead>
                            <tbody>


                                <tr>
                                    <span hidden="hidden">{{ $i = 1 }} </span>
                                    @foreach ($boleta_registro as $boleta_registros)
                                <tr>
                                    <td>{{ $i++ }} </td>
                                    @if (isset($boleta_registros->producto))
                                        <td>{{ $boleta_registros->producto->codigo_producto }}</td>
                                        {{-- <td>{{$boleta_registros->producto->unidad_i_producto->medida}}</td> --}}
                                        <td>{{ $boleta_registros->producto->nombre }}
                                            {{ $boleta_registros->descripcion_item }}@if (isset($boleta_registros->numero_serie))
                                                <br><strong>N/S:</strong> {{ $boleta_registros->numero_serie }}
                                            @endif
                                        </td>
                                    @else
                                        <td>{{ $boleta_registros->servicio->codigo_servicio }}</td>
                                        {{-- <td>{{$boleta_registros->producto->unidad_i_producto->medida}}</td> --}}
                                        <td>{{ $boleta_registros->servicio->nombre }}
                                            {{ $boleta_registros->descripcion_item }}@if (isset($boleta_registros->numero_serie))
                                                <br><strong>N/S:</strong> {{ $boleta_registros->numero_serie }}
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ $boleta_registros->cantidad }}</td>
                                    <td>{{ number_format(round($boleta_registros->precio, 2), 2) }}</td>
                                    <td>{{ $boleta_registros->descuento }}%</td>
                                    <td>{{ number_format(round($boleta_registros->precio_unitario_desc, 2), 2) }}</td>
                                    <td>{{ $boleta_registros->comision }}%</td>
                                    <td>{{ number_format(round($boleta_registros->precio_unitario_comi, 2), 2) }}</td>
                                    <td>{{ number_format(round($boleta_registros->precio_unitario_comi * $boleta_registros->cantidad, 2), 2) }}
                                    </td>
                                    <td style="display: none">
                                        {{-- {{$sub_total=(($boleta_registros->precio_unitario_comi * $boleta_registros->cantidad)+$sub_total)}} --}}
                                        {{ $sub_total = $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada }}
                                        {{ $sub_total_gravado = $boleta_registros->boleta_i->op_gravada }}
                                        {{ $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100 }}
                                        {{ $end = round($sub_total, 2) + round($igv_p, 2) }}
                                        {{ $end2 = number_format(round($sub_total, 2) + round($igv_p, 2), 2) }}
                                    </td>
                                </tr>
                                {{-- <span hidden="hidden">{{$i++}}</span> --}}
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                        <footer style="padding-top: 120px">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3 align="left">
                                        <?php
                                        use Luecano\NumeroALetras\NumeroALetras;
                                        
                                        $v = new NumeroALetras();
                                        $letra = $v->toInvoice($end, 2);
                                        ?>
                                        Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $boleta->moneda->nombre }}

                                    </h3>
                                </div>
                                <div class="col-sm-4 ">
                                    <div class="form-control">
                                        <span style="display: block;float: left"> Subtotal:</span>
                                        <span style="display: block;float: right;">
                                            {{ $simbologia = $boleta->moneda->simbolo }}
                                            {{ number_format($sub_total, 2) }}</span>
                                        <br>
                                        <span style="display: block;float: left"> Op. Gravada: </span>
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
                                            {{ number_format(round($end, 2), 2) }}</span><br>
                                    </div>
                                </div>
                            </div>
                        </footer>
                        <br>
                    </div>
                    <div class="table-no mostrar">
                        <div class="row">
                            @if ($boleta->detracciones)
                                <div class="col-sm-6 ">
                                    <div class="form-control" style="height: 100% !important">
                                        <strong>Observaciones:</strong><br>
                                        {{ $boleta->observacion }}
                                    </div>
                                </div>
                                <div class="col-sm-6 ">
                                    <div class="form-control" style="height: 100% !important">
                                        <strong>Informacion de Detraccion:</strong><br>
                                        <strong>Tipo de Detraccion:</strong>
                                        {{ $boleta->detracciones->tipo_detraccion->descripcion }} -
                                        {{ $boleta->detracciones->porcentaje_detraccion }} %<br>
                                        <strong>Medio de Pago:</strong>
                                        {{ $boleta->detracciones->medio_pago->descripcion }} <br>
                                        <strong>Monto de Detraccion:</strong>
                                        S/. {{ number_format($boleta->detracciones->monto_detraccion, 2) }} <br>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-12 form-control" style="height:  100px">
                                    <strong>Observaciones:</strong><br>
                                    {{ $boleta->observacion }}
                                </div>
                            @endif
                        </div>
                        <br>
                    </div>
                    <div class="div-editar no_mostrar">
                        @if ($boleta->estado == 0)
                            @include('transaccion.venta.boleta.edit')
                        @endif
                    </div>
                    <br>
                    @include('layout_bancos')
                    <br>
                </div>
            </div>
        </div>
    </div>

    <style>
        .input-group > .select2-container {
            width: auto;
            flex: 1 1 auto;
        }

        .input-group > .select2-container .select2-selection--single {
            height: 100%;
            line-height: inherit;
        }
        .check {
            -webkit-appearance: none;
            height: 34px;
            background-color: #ffffff00;
            -moz-appearance: none;
            border: none;
            appearance: none;
            width: 90px;
            border-radius: 10px;
        }

        .div_check {
            position: relative;
            top: -33px;
            left: 0px;
            background-color: #ffffff00;
            top: -35;
        }

        .check:checked {
            background: #0375bd6b;
        }

        .text_des {
            border-radius: 10px;
            border: 1px solid #e5e6e7;
            width: 80px;
            padding: 6px 12px;
        }

        #div-mostrar {
            margin: auto;
            margin-right: 15px;
            height: 0px;
            transition: height .4s;
            color: white;
            text-align: right;
            width: 100%;
        }

        #div-mostrar>form {
            text-align: none;
            padding-right: 0;
            padding-left: 0;
            margin-top: 10px;
            margin-right: 0px;
        }

        .no_mostrar {
            display: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            /* font-size: 12px; */
        }

        .select2-container--default .select2-selection--single {
            border: none;
        }

        span.select2.select2-container.select2-container--default {
            background-color: #FFFFFF;
            background-image: none;
            border-radius: 1px;
            display: block;
            padding: 3px 12px;
            border: 1px solid #e5e6e7;
        }

        /* Renovacion */
        .renovacion {
            padding: 0;
            margin-bottom: 15px;
            margin-top: 8px;
        }

        .switch-container {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            margin: 0;
            flex-shrink: 0;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .3s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        input:checked+.slider {
            background-color: #1ab394;
        }

        input:focus+.slider {
            box-shadow: 0 0 2px #1ab394;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .switch-label {
            font-size: 13px;
            color: #676a6c;
            font-weight: 500;
            cursor: pointer;
            user-select: none;
            margin: 0;
            line-height: 24px;
            white-space: nowrap;
        }

        #renovacion_container {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .renovacion select:focus {
            outline: none;
            box-shadow: none;
            border-color: #e5e6e7;
        }

        .renovacion hr {
            display: none;
        }

        #renovacion_container select {
            font-size: 13px;
            height: 34px;
            padding: 0.375rem 0.75rem;
            line-height: 1.5;
            border: 1px solid #e5e6e7;
            width: 100%;
        }

        #extra_selects select {
            font-size: 13px;
            height: 34px;
            padding: 0.375rem 0.75rem;
            line-height: 1.5;
            margin-bottom: 0;
            border: 1px solid #e5e6e7;
            width: 100%;
        }

        .renovacion .row {
            margin-bottom: 6px;
        }

        .row_articulo {
            width: 45% !important;
            max-width: 45% !important;
        }

        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1000px;
            }
        }

        .dataTables_wrapper {
            padding: 0px;
        }

        #DataTables_Table_0_wrapper {
            display: flex;
            flex-direction: column !important;
            justify-content: space-between !important;
            height: 100% !important;
        }

        #DataTables_Table_0_wrapper>.top {
            display: none;
        }

        #DataTables_Table_0_wrapper>.row>.col-sm-12 {
            padding: 0px !important;
        }

        .data_table_multiple {
            border: 1px solid #e7eaec;
            margin-bottom: 0px !important;
        }

        #DataTables_Table_0_info {
            margin-bottom: 5px !important;
        }

        span.select2.select2-container.select2-container--default.select2-container--below {
            /* max-width: 400px !important; */
            /* min-width: 400px !important; */
        }

        .word-style select,
        .word-style input,
        .word-style textarea,
        .word-style span {
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .select2-nowrap .select2-results__option {
            white-space: nowrap;
        }

        .select2-nowrap {
            min-width: 400px;
        }

        .limp {
            min-width: 85px !important;
        }
        .detracc_campo_required, .retenc_campo_required {
            display: none;
            color: red;
        }
        span.select2-container.select2-container--default.select2-container--open {
            z-index: 999999;
        }
        .td-width{
            min-width: 85px;
        }
    </style>
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
    <!-- Sweet alert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    {{-- //TICKET --}}
    <!-- TouchSpin -->
    <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

    <script>
        var clic = 1;

        function divAuto() {
            if (clic == 1) {
                document.getElementById("div-mostrar").style.height = "50px";
                clic = clic + 1;
            } else {
                document.getElementById("div-mostrar").style.height = "0px";
                clic = 1;
            }
        }
    </script>
    <script>
        var clic = 1;

        function divAuto() {
            if (clic == 1) {
                document.getElementById("div-mostrar").style.height = "50px";
                clic = clic + 1;
            } else {
                document.getElementById("div-mostrar").style.height = "0px";
                clic = 1;
            }
        }

        function click_editar() {
            // MOSTRAR LOS INPUTS
            $('.div-editar').removeClass('no_mostrar');
            $('.div-editar').addClass('mostrar');
            // OCULTAR TABLA
            $('.table-no').addClass('no_mostrar');
            // BOTONES
            $('.btn-no-editar').removeClass('no_mostrar');
            $('.btn-editar').addClass('no_mostrar');
        }

        function click_cancelar_editar() {
            // OCULTAR INPUTS
            $('.div-editar').removeClass('mostrar');
            $('.div-editar').addClass('no_mostrar');
            // MOSTRAR TABLA
            $('.table-no').removeClass('no_mostrar');
            $('.table-no').addClass('mostrar');

            $('.btn-editar').removeClass('no_mostrar');
            $('.btn-no-editar').addClass('no_mostrar');
        }
    </script>
    @include('transaccion.venta.boleta._shared._edit_script')
    <script>
        $(document).ready(function() {
            @if (session('success'))
                toastr.success("{{ session('success') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}", '', {
                    timeOut: 3000
                });
            @endif
        });
    </script>

    <script>
        var ncAbierto = false;

        function toggleNC() {
            var slider = document.getElementById('nc-slider');
            var arrow = document.getElementById('nc-arrow');

            if (ncAbierto) {
                slider.style.width = '0';
                arrow.classList.remove('fa-chevron-right');
                arrow.classList.add('fa-chevron-left');
            } else {
                slider.style.width = '42px';
                arrow.classList.remove('fa-chevron-left');
                arrow.classList.add('fa-chevron-right');
            }

            ncAbierto = !ncAbierto;
        }
    </script>
    @include('transaccion.venta.clientes.modal_create')
@endsection
