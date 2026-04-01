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
                    'method' => 'POST'
                ])
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up text-muted"></i>
                    </a>
                    <a href="{{ route('comprobantes.index_boleta') }}" title="Cerrar">
                        <i class="fa fa-times text-muted"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="padding-right: 3.1%;padding-left: 3.1%; padding-bottom: 10px;">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3">
                        <h3 style="margin: 0;">{{ $boleta->codigo_boleta }}</h5>
                        <strong style="margin: 0;">R.U.C : </strong>{{ $empresa->ruc }}
                    </div>
                    <div class="col-12 col-md-4 text-center">
                        <h2 class="mb-0 text-nowrap" style="margin-left: 200px;">
                            BOLETA ELECTRÓNICA
                        </h2>
                    </div>
                    <div class="col-12 col-md-5 d-flex flex-wrap justify-content-end align-items-center" style="gap: 4px;">
                        @php use Carbon\Carbon;
                        use App\Boleta; @endphp
                        @if ($boleta->nota_credito != 0)
                            <div class="d-flex align-items-center" style="overflow: hidden;">
                                {{-- Botón NC (oculto por defecto) --}}
                                <div id="nc-slider" style="width: 0; overflow: hidden; transition: width 0.3s ease;">
                                    <a class="btn btn-primary" data-toggle="tooltip" data-placement="bottom"
                                        data-original-title="Motivo: {{ Boleta::search_motivo_nc($boleta->id) }}"
                                        href="{{ route('nota-credito.show', Boleta::nota_credito_id($boleta->id)) }}"
                                        style="white-space: nowrap; margin-right: 4px;">
                                        <i class="fa fa-file-text fa-lg"></i>
                                    </a>
                                </div>
                                {{-- Flecha toggle --}}
                                <button id="nc-toggle" onclick="toggleNC()" class="btn btn-default"
                                    style="border: 1px solid #ccc; padding: 5px 8px; transition: transform 0.3s;">
                                    <i class="fa fa-chevron-right" id="nc-arrow"></i>
                                </button>
                            </div>
                            {{-- Divisor --}}
                            <div style="width: 1px; height: 30px; background-color: #ccc; margin: 0 6px;"></div>
                        @endif
                        <form class="btn" style="padding: 0;" action="{{ route('boleta_manual.pdf', $boleta->id) }}">
                            <input type="text" name="name" maxlength="50" hidden value="{{ $boleta->codigo_boleta }}">
                            <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom"
                                data-original-title="Descargar PDF"><i class="fa fa-file-pdf-o fa-lg"></i></button>
                        </form>

                        <a href="{{ route('boleta.ticket', $boleta->id) }}" class="btn btn-info" target="_blank">
                            <i class="fa fa-ticket fa-lg"></i>
                        </a>

                        <a class="btn btn-success" href="{{ route('boleta_manual.print', $boleta->id) }}" target="_blank"
                            data-toggle="tooltip" data-placement="bottom" data-original-title="Imprimir">
                            <i class="fa fa-print fa-lg"></i>
                        </a>

                        @if (Auth::user()->email_creado == 1)
                            <form action="{{ route('email.boleta_manual', $boleta->id) }}" method="post"
                                style="padding: 0;" class="btn">
                                @csrf
                                <button type="submit" class="btn btn-secondary" data-toggle="tooltip"
                                    data-placement="bottom" data-original-title="Enviar por correo" formtarget="_blank">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </button>
                            </form>
                        @endif

                        <div style="position: relative; display: inline-block;">
                            <div id="auto" onclick="divAuto()">
                                <a class="btn btn-success" style="background: green; border-color: green;">
                                    <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                </a>
                            </div>
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
                            <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="btn"
                                style="text-align: none;padding-right: 0;padding-left: 0;">
                                @csrf
                                <input type="tel" name="numero" value="{{ $boleta->cliente->celular }}" />
                                <input type="text" name="mensaje" id="texto_orden" hidden />
                                <input type="text" hidden name="url"
                                    value="{{ route('boleta_manual.pdf', $boleta->id) }}?archivo=">
                                <input type="text" name="name_sin_cambio" hidden
                                    value="BoletaM_{{ $boleta->codigo_boleta }}" />
                                <button type="submit" class="btn btn-success"
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
        <div class="mostrar" id="show_boleta">
            <div class="row">
                <div class="col-lg-12" style="margin-top: -26px;">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
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

                        <div class="table-responsive">
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
                                        <td>{{ number_format(round($boleta_registros->precio,2),2) }}</td>
                                        <td>{{ $boleta_registros->descuento }}%</td>
                                        <td>{{ number_format(round($boleta_registros->precio_unitario_desc,2),2) }}</td>
                                        <td>{{ $boleta_registros->comision }}%</td>
                                        <td>{{ number_format(round($boleta_registros->precio_unitario_comi,2), 2) }}</td>
                                        <td>{{ number_format(round($boleta_registros->precio_unitario_comi * $boleta_registros->cantidad,2), 2) }}
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
                        </div><br><br><br><br>

                        <div class="row">
                            <div class="col-sm-8">
                                <h3 align="left">
                                    <?php
                                    use Luecano\NumeroALetras\NumeroALetras;
                                    $v = new NumeroALetras();
                                    $letra = $v->toInvoice($end, 2);
                                    //     $letra_final = ucfirst(strstr($letra, 'soles',true));
                                    //     $end_final_point=strstr($end2, '.',false);
                                    //     $end_final=str_replace('.', '',$end_final_point);
                                    ?>
                                    Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $boleta->moneda->nombre }}
                                    {{-- {{$end2}} --}}
                                </h3>
                            </div>
                            <div class="col-sm-4 form-control">
                                <span style="display: block;float: left"> Subtotal:</span>
                                <span style="display: block;float: right;"> {{ $simbologia = $boleta->moneda->simbolo }}
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
                                    {{ number_format(round($end, 2), 2) }}</span>

                            </div>
                            <div class="col-sm-12 form-control" align="center" style="margin-top: 8px">
                                <div align="left">
                                    <strong>Observación :</strong>
                                    <p> {{ $boleta->observacion }} </p>
                                </div>
                            </div>
                        </div><br>
                        @include('layout_bancos')
                        <br>
                    </div>
                </div>

            </div>
        </div>
        <div class="no_mostrar" id="edicion_boleta">
            @if ($boleta->estado == 0)
                <div class="">
                    @include('transaccion.venta.boleta.edit')
                </div>
            @endif
        </div>
    </div>

    <style type="text/css">
        .ruc {
            border-radius: 10px;
            height: 125px;
        }

        .a {
            height: 30px;
            margin: 0;
            border-radius: 0px;
            text-align: center;
        }

        #auto {
            cursor: pointer;
            box-shadow: 0px 0px 1px #000;
            display: inline-block;
        }

        #auto:hover {
            opacity: .8;
        }

        #div-mostrar {
            margin: auto;
            height: 0px;
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
    </style>
    <style>
        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1200px;
            }
        }

        /* PARA EL EDITAR */
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
                arrow.classList.remove('fa-chevron-left');
                arrow.classList.add('fa-chevron-right');
            } else {
                slider.style.width = '42px';
                arrow.classList.remove('fa-chevron-right');
                arrow.classList.add('fa-chevron-left');
            }

            ncAbierto = !ncAbierto;
        }
    </script>
@endsection
