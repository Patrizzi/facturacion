@extends('layout')
@section('title', 'Boleta Manual')
@section('atributo_actu', 'hidden')
@section('href_accion', route('boleta_manual.create'))
@section('value_accion', 'Agregar')
@section('content')

    {{-- obtener errores --}}
    @if ($errors->any())
        <div style="padding-top: 20px;">
            <div class="alert alert-danger">
                <a class="alert-link" href="#">
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </a>
            </div>
        </div>
    @endif

    {{-- obtener errores --}}
    @if (Session::has('successMsg'))
        <div style="padding-top: 20px;">
            <div class="alert alert-warning">
                <a class="alert-link" href="#">
                    <li style="color: black">{{ Session::get('successMsg') }}</li>
                </a>
            </div>
        </div>
    @endif

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title d-flex justify-content-between" style="padding-right: 3.1%">
                @include('transaccion.comprobantes._shared.btn_create_with_almacen', [
                    'routeCreate' => 'boleta_manual.create',
                    'useAlmacen' => false,
                    'method' => 'GET',
                    'asLink' => true,
                ])
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up text-muted"></i>
                    </a>
                    <a href="{{ route('comprobantes.index_boleta_manual') }}" title="Cerrar">
                        <i class="fa fa-times text-muted"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="padding-right: 3.1%; padding-left: 3.1%; padding-bottom: 10px;">
                <div class="row align-items-center" style="position: relative; min-height: 56px;">

                    {{-- Código y RUC --}}
                    <div class="col-12 col-md-2">
                        <h3 style="margin: 0;">{{ $boleta->codigo_boleta }}</h3>
                        <strong style="margin: 0;">R.U.C :</strong>{{ $empresa->ruc }}
                    </div>

                    {{-- Título ABSOLUTAMENTE centrado en el row --}}
                    <div style="position: absolute; left: 0; right: 0; text-align: center; pointer-events: none;">
                        <h2 class="mb-0 text-nowrap">BOLETA ELECTRÓNICA</h2>
                    </div>

                    {{-- Botones alineados a la derecha --}}
                    <div class="col-12 col-md-4 ml-auto d-flex flex-wrap align-items-center justify-content-end mt-2 mt-md-0" style="gap: 4px;">
                        <?php use Carbon\Carbon;
                        use App\Boleta_m; ?>

                        @if ($boleta->nota_credito != 0)
                            <div class="d-flex align-items-center" style="overflow: hidden;">
                                <div id="nc-slider" style="width: 0; overflow: hidden; transition: width 0.3s ease;">
                                    <a class="btn btn-primary" data-toggle="tooltip" data-placement="bottom"
                                        data-original-title="Motivo: {{ Boleta_m::search_motivo_nc($boleta->id) }}"
                                        href="{{ route('nota-credito.show', Boleta_m::nota_credito_id($boleta->id)) }}"
                                        style="white-space: nowrap; margin-right: 4px;">
                                        <i class="fa fa-file-text fa-lg"></i>
                                    </a>
                                </div>
                                <button id="nc-toggle" onclick="toggleNC()" class="btn btn-default"
                                    style="border: 1px solid #ccc; padding: 5px 8px; transition: transform 0.3s;">
                                    <i class="fa fa-chevron-left" id="nc-arrow"></i>
                                </button>
                            </div>
                            <div style="width: 1px; height: 30px; background-color: #ccc; margin: 0 2px;"></div>
                        @endif

                        <form class="m-0 p-0" action="{{ route('boleta_manual.pdf', $boleta->id) }}">
                            <input type="text" name="name" maxlength="50" hidden value="{{ $boleta->codigo_boleta }}">
                            <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom"
                                data-original-title="Descargar PDF">
                                <i class="fa fa-file-pdf-o fa-lg"></i>
                            </button>
                        </form>

                        <a href="{{ route('boleta_manual.ticket', $boleta->id) }}" class="btn btn-info" target="_blank">
                            <i class="fa fa-ticket fa-lg"></i>
                        </a>

                        <a class="btn btn-success" href="{{ route('boleta_manual.print', $boleta->id) }}" target="_blank"
                            data-toggle="tooltip" data-placement="bottom" data-original-title="Imprimir">
                            <i class="fa fa-print fa-lg"></i>
                        </a>

                        @if (Auth::user()->email_creado == 1)
                            <form action="{{ route('email.boleta_manual', $boleta->id) }}" method="post" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="btn btn-secondary" data-toggle="tooltip"
                                    data-placement="bottom" data-original-title="Enviar por correo" formtarget="_blank">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </button>
                            </form>
                        @endif

                        <div id="auto" onclick="divAuto()">
                            <a class="btn btn-success" style="background: green; border-color: green;">
                                <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                            </a>
                        </div>

                        @if ($boleta->estado == 0)
                            <button class="btn btn-warning btn-editar" id="edit" onclick="click_editar()">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn-no-editar no_mostrar btn btn-warning" onclick="click_cancelar_editar()">
                                <i class="fa fa-times"></i>
                            </button>
                        @endif

                        <div id="div-mostrar" style="height: 0px; overflow: hidden; width: 100%; transition: height .4s;">
                            <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="m-0 p-0">
                                @csrf
                                <input type="tel" name="numero" value="{{ $boleta->cliente->celular }}" />
                                <input type="text" name="mensaje" id="texto_orden" hidden />
                                <input type="text" hidden name="url"
                                    value="{{ route('boleta_manual.pdf', $boleta->id) }}?archivo=">
                                <input type="text" name="name_sin_cambio" hidden
                                    value="BoletaM_{{ $boleta->codigo_boleta }}" />
                                <button type="submit" class="btn btn-success"
                                    style="background: green; border-color: green;" formtarget="_blank"
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
        <div class="mostrar" id="show_boleta">
            <div class="row">
                <div class="col-lg-12" style="margin-top: -26px;">
                    @if ($boleta->b_electronica == 2)
                        <div id="watermark">
                            <p>Anulado</p>
                        </div>
                    @endif
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">

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

                                        @foreach ($boleta_registro as $boletas_registros)
                                            <tr>
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
                                                    <td style="text-align:center">
                                                        {{ $boletas_registros->servicio->codigo_servicio }}</td>
                                                    <td>
                                                        {{ $boletas_registros->servicio->nombre }}
                                                        {{ $boletas_registros->descripcion_item }}
                                                        @if (isset($boletas_registros->numero_serie))
                                                            <br><strong>N/S:</strong> {{ $boletas_registros->numero_serie }}
                                                        @endif
                                                    </td>
                                                @endif
                                                <td style="text-align:center">{{ $boletas_registros->cantidad }}</td>
                                                <td style="text-align:center">
                                                    {{ round($boletas_registros->precio, 8) }}</td>

                                                <td style="text-align:center">
                                                    {{ round($boletas_registros->precio * $boletas_registros->cantidad,8) }}
                                                </td>
                                                <span hidden="hidden">{{ $i++ }}</span>
                                            </tr>
                                        @endforeach


                                        <td style="display: none">
                                            {{ $sub_total = $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada }}
                                            {{ $igv_p = $boleta->op_gravada * ($igv->igv_total / 100) }}
                                            {{ $end = $sub_total + $igv_p }}
                                            {{ $end2 = number_format( round($end, 2), 2) }}
                                        </td>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 align="left">
                                    <?php use Luecano\NumeroALetras\NumeroALetras;
                                    $v = new NumeroALetras();
                                    $letra = $v->toInvoice($end, 2);
                                    // $letra_final = ucfirst(strstr($letra, 'soles', true));
                                    // $end_final_point = strstr($end2, '.', false);
                                    // $end_final = str_replace('.', '', $end_final_point);
                                    ?>
                                    Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $boleta->moneda->nombre }}
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
                            <div class="col-sm-12 form-control" style="height:  120px">
                                <strong>Observaciones:</strong><br>
                                {{ $boleta->observacion }}
                            </div>
                        </div>
                        <br>
                        @include('layout_bancos')
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="no_mostrar" id="edicion_boleta">
            @if ($boleta->estado == '0')
                @include('transaccion.venta.boleta.boleta_manual.edit')
            @endif
        </div>
    </div>
    <style>
        .input-group>.select2-container--bootstrap {
            width: auto;
            flex: 1 1 auto;
        }

        .input-group>.select2-container--bootstrap .select2-selection--single {
            height: 100%;
            line-height: inherit;
            padding: 0.5rem 1rem;
            border: 1px solid #e5e6e7;
        }

        .row_form {
            align-items: center;
            margin-bottom: 0px;
        }

        .edit_form {
            margin: 0px !important;
            padding-bottom: 0px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 12px;
        }

        .select2-container--default .select2-selection--single {
            border: none;
        }

        span.select2.select2-container.select2-container--default {
            width: 100% !important;
            background-color: #FFFFFF;
            background-image: none;
            border-radius: 1px;
            display: block;
            padding: 3px 12px;
            border: 1px solid #e5e6e7;
        }

        @media only screen and (max-width: 1497px) {
            .td_selected>span.select2.select2-container.select2-container--default {
                min-width: 376px !important;
            }
        }

        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1200px;
            }
        }

        .item_guia {
            font-size: 11px;
            margin: 0px 7px;
            cursor: hand;
        }

        a.item_guia::after {
            content: "x";
            font-size: 9px;
            color: red;
            vertical-align: top;
        }

        .detracc_campo_required {
            display: none;
            /* font-size: 9px; */
            color: red;
        }

        .td_selected>span.select2.select2-container.select2-container--default {
            max-width: 700px !important;
            width: 30vw !important;
        }

        .input-cantidad,
        .total_s_igv,
        .total_c_igv {
            max-width: 100px;
        }

        .mostrar {
            display: ;
        }

        .no_mostrar {
            display: none;
        }

        .select2-results__option.select2-results__option--highlighted {
            background-color: #1c84c6 !important;
            color: white !important;
        }

        .ruc {
            border-radius: 10px;
            height: 150px;
        }

        /* .form-control {
                        border-radius: 10px;
                    } */
        .a {
            height: 30px;
            margin: 0;
            border-radius: 0px;
            text-align: center;
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

        /* .form-control {
                        margin-top: 5px;
                        border-radius: 5px
                    } */

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
            color: rgba(120, 120, 120, 0.31);
            font-weight: bolder;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 95px;
            pointer-events: none;
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            top: 45%;
            right: 40%;
            z-index: 0;
        }

        /* .form-control {
                        background-color: transparent !important;
                    } */
    </style>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
    <!-- Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

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
            $('#edicion_boleta').removeClass('no_mostrar');
            $('#edicion_boleta').addClass('mostrar');
            // OCULTAR TABLA
            $('#show_boleta').addClass('no_mostrar');
            // BOTONES
            $('.btn-no-editar').removeClass('no_mostrar');
            $('.btn-editar').addClass('no_mostrar');
        }

        function click_cancelar_editar() {
            // OCULTAR INPUTS
            $('#edicion_boleta').removeClass('mostrar');
            $('#edicion_boleta').addClass('no_mostrar');
            // MOSTRAR TABLA
            $('#show_boleta').removeClass('no_mostrar');
            $('#show_boleta').addClass('mostrar');

            $('.btn-editar').removeClass('no_mostrar');
            $('.btn-no-editar').addClass('no_mostrar');
        }
    </script>
    @include('transaccion.venta.boleta.boleta_manual._shared._edit_script')
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
@endsection
