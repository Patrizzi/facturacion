
@extends('layout')

@section('title', 'Facturación Ver')

@section('href_accion', route('facturacion.index'))
@section('value_accion', 'Inicio')

@section('button2', 'Nueva Facturación')
@section('onclick', "event.preventDefault();document.getElementById('nueva_cots').submit();")

@section('content')

    <form action="{{ route('facturacion.create') }}"enctype="multipart/form-data" method="post" id="nueva_cots">
        @csrf
        <input type="text" hidden="hidden" name="almacen" value="{{ $facturacion->almacen_id }}">
        <input hidden="hidden" type="submit" />
    </form>
    <style type="text/css">
        .procesado:before {
            content: "Procesado";
        }

        .procesado:hover:before {
            content: "Ver";
        }
    </style>
    <div class="wrapper wrapper-content animated fadeInRight">
        {{-- <h1>{{ $facturacion->estado }}</h1> --}}
        <div class="ibox">
            <div class="ibox-title d-flex justify-content-between">
                @include('transaccion.comprobantes._shared.btn_create_with_almacen', [
                    'routeCreate' => 'facturacion.create',
                    'almacen' => $almacen,
                    'useAlmacen' => true,
                    'method' => 'POST'
                ])
                <div class="ibox-tools" style="margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up text-muted"></i>
                    </a>
                    <a href="{{ route('comprobantes.index_factura') }}" title="Cerrar">
                        <i class="fa fa-times text-muted"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="padding-bottom: 10px;">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4">
                        <h3 style="margin: 0;">{{ $facturacion->codigo_fac }}</h5>
                        <strong style="margin: 0;">R.U.C : </strong>{{ $empresa->ruc }}
                    </div>
                    <div class="col-12 col-md-4 text-center">
                        <h2 class="mb-0 text-nowrap">
                            FACTURA ELECTRÓNICA
                        </h2>
                    </div>
                    <div class="col-12 col-md-4 d-flex flex-wrap justify-content-end align-items-center" style="gap: 4px;">
                        @php
                            use Carbon\Carbon;
                            use App\Facturacion;

                            $showAnular = $facturacion->f_electronica == 0 && $facturacion->created_at->diffInDays(Carbon::now()) > 7;
                            $showNC = $facturacion->nota_credito != 0;
                        @endphp

                        @if ($showAnular || $showNC)
                            <div class="d-flex align-items-center" style="overflow: hidden;">

                                {{-- Slider con los botones --}}
                                <div id="btn-slider" style="width: 0; overflow: hidden; transition: width 0.3s ease; display: flex; align-items: center;">

                                    {{-- Botón Anular --}}
                                    @if ($showAnular)
                                        @can('factura.anular')
                                            <span data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Anular La Factura"
                                                style="display: inline-flex; animation: circleScale 3s infinite; margin-right: 4px;">
                                                <button class="btn btn-danger btn-sm btn-circle" data-toggle="modal" data-target="#modal_anular">
                                                    <i class="fa fa-ban fa-xl"></i>
                                                </button>
                                            </span>
                                        @endcan
                                    @endif

                                    {{-- Botón Nota de Crédito --}}
                                    @if ($showNC)
                                        <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom"
                                            data-original-title="Motivo: {{ Facturacion::search_motivo_nc($facturacion->id) }}"
                                            href="{{ route('nota-credito.show', Facturacion::nota_credito_id($facturacion->id)) }}"
                                            style="white-space: nowrap; margin-right: 4px;">
                                            <i class="fa fa-file-text fa-lg"></i>
                                        </a>
                                    @endif

                                </div>

                                {{-- Flecha toggle --}}
                                <button id="btn-toggle" onclick="toggleBtns()" class="btn btn-default btn-sm"
                                    style="border: 1px solid #ccc; padding: 5px 8px; transition: transform 0.3s;">
                                    <i class="fa fa-chevron-left" id="btn-arrow"></i>
                                </button>

                            </div>

                            {{-- Divisor --}}
                            <div style="width: 1px; height: 30px; background-color: #ccc; margin: 0 6px;"></div>
                        @endif
                        <!-- PDF -->
                        <form class="btn" style="padding: 0;" action="{{ route('pdf_fac', $facturacion->id) }}">
                            <input type="text" name="name" maxlength="50" hidden value="{{ $facturacion->codigo_fac }}">
                            <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom"
                                data-original-title="Descargar PDF"><i class="fa fa-file-pdf-o fa-lg"></i></button>
                        </form>

                        <a href="{{ route('facturacion.ticket', $facturacion->id) }}" class="btn btn-info btn-sm" target="_blank">
                            <i class="fa fa-ticket fa-lg"></i>
                        </a>

                        <input type="text" value="{{ $facturacion->id }}" name="id" id="id" hidden>

                        <a class="btn btn-success btn-sm" href="{{ route('facturacion.print', $facturacion->id) }}" target="_blank"
                            data-toggle="tooltip" data-placement="bottom" data-original-title="Imprimir">
                            <i class="fa fa-print fa-lg"></i>
                        </a>

                        @if (Auth::user()->email_creado == 1)
                            <form action="{{ route('email.factura', $facturacion->id) }}" method="post" style="padding: 0;" class="btn">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="bottom"
                                    data-original-title="Enviar por correo" formtarget="_blank">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </button>
                            </form>
                        @endif
                        <div style="position: relative; display: inline-block;">
                            <div id="auto" onclick="divAuto()">
                                <a class="btn btn-success btn-sm" style="background: green; border-color: green;" ...>
                                    <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                </a>
                            </div>
                        </div>

                        @if ($facturacion->estado == 0)
                            @can('factura.editar')
                                <button class="btn btn-warning btn-sm btn-editar" id="edit" onclick="click_editar()">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn-no-editar no_mostrar btn btn-warning btn-sm" onclick="click_cancelar_editar()">
                                    <i class="fa fa-times"></i>
                                </button>
                            @endcan
                        @endif
                        <div  id="div-mostrar" style="height: 0px; overflow: hidden; width: 100%; transition: height .4s; margin-right: 14px;">
                            <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="btn"
                                style="text-align: none;padding-right: 0;padding-left: 0;">
                                @csrf
                                <input type="tel" name="numero" value="{{ $facturacion->cliente->celular }}" />
                                <input type="text" name="mensaje" id="texto_orden" hidden="" />
                                <input type="text" hidden="" name="url"
                                    value="{{ route('pdf_fac', $facturacion->id) }}?archivo=">
                                <input type="text" name="name_sin_cambio" hidden=""
                                    value="Facturacion_{{ $facturacion->codigo_fac }}" />
                                <button type="submit" class="btn btn-success btn-sm"
                                    style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip"
                                    data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i
                                        class="fa fa-send fa-lg"></i> </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-top: -26px;">
                <div class="ibox-content" style=" margin-bottom: 20px;padding-bottom: 50px;">
                    @if ($facturacion->f_electronica == 2 || ($facturacion->nota_credito == 1 && $facturacion->motivo == "01"))
                        <div id="watermark">
                            <p>Anulado</p>
                        </div>
                    @endif
                    <div class="table-no mostrar">
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
                                        <strong>Guía de Remisión:</strong>
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
                    </div>
                    <div class="table-no mostrar">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th style="width: 10%">Código de Item</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Valor Unitario</th>
                                    <th>Dscto. %</th>
                                    <th>P. Unitario Desc</th>
                                    <th>Comisión %</th>
                                    <th>P. Unitario Com.</th>
                                    <th>Valor Venta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <span hidden="hidden">{{ $i = 1 }} </span>
                                    @foreach ($facturacion_registro as $facturacion_registros)
                                <tr>
                                    <td>{{ $i }} </td>
                                    @if (isset($facturacion_registros->producto))
                                        <td>{{ $facturacion_registros->producto->codigo_producto }}</td>
                                        <td>{{ $facturacion_registros->producto->nombre }}
                                            {{ $facturacion_registros->descripcion_item }} @if (isset($facturacion_registros->numero_serie))
                                                <br><strong>N/S:</strong> {{ $facturacion_registros->numero_serie }}
                                            @endif
                                        </td>
                                    @else
                                        <td>{{ $facturacion_registros->servicio->codigo_servicio }}</td>
                                        <td>{{ $facturacion_registros->servicio->nombre }}
                                            {{ $facturacion_registros->descripcion_item }} @if (isset($facturacion_registros->numero_serie))
                                                <br><strong>N/S:</strong> {{ $facturacion_registros->numero_serie }}
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ $facturacion_registros->cantidad }}</td>
                                    <td>{{ number_format(round($facturacion_registros->precio,2),2) }}</td>
                                    <td>{{ $facturacion_registros->descuento }}%</td>
                                    <td>{{ number_format(round($facturacion_registros->precio_unitario_desc), 2) }}</td>
                                    <td>{{ $facturacion_registros->comision }}%</td>
                                    <td>{{ number_format(round($facturacion_registros->precio_unitario_comi ,2),2 )}}</td>
                                    <td>{{ number_format(round($facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad,2),2  ) }}
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
                        <footer style="padding-top: 120px">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3 align="left">
                                        <?php use Luecano\NumeroALetras\NumeroALetras;
                                        $v = new NumeroALetras();
                                        $letra = $v->toInvoice($end, 2);
                                        // $letra_final = ucfirst(strstr($letra, 'soles',true));
                                        // $end_final_point=strstr($end2, '.',false);
                                        // $end_final=str_replace('.', '',$end_final_point);
                                        ?>
                                        Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $facturacion->moneda->nombre }}
                                        {{-- {{$end2}} --}}

                                    </h3>
                                </div>
                                <div class="col-sm-4 ">
                                    <div class="form-control">
                                        <span style="display: block;float: left"> Subtotal:</span>
                                        <span style="display: block;float: right;">
                                            {{ $simbologia = $facturacion->moneda->simbolo }}
                                            {{ number_format($sub_total, 2) }}</span>
                                        <br>
                                        <span style="display: block;float: left"> Op. Gravada: </span>
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
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </footer>
                        <br>
                    </div>
                    <div class="table-no mostrar">
                        <div class="row">
                            @if($facturacion->detracciones || $facturacion->retencion == 1)
                                <div class="col-sm-6 ">
                                    <div class="form-control" style="height: 100% !important">
                                        <strong>Observaciones:</strong><br>
                                        {{ $facturacion->observacion }}
                                    </div>
                                </div>
                                @if($facturacion->detracciones)
                                    <div class="col-sm-6 ">
                                        <div class="form-control" style="height: 100% !important">
                                            <strong>Informacion de Detraccion:</strong><br>
                                            <strong>Tipo de Detraccion:</strong>
                                            {{ $facturacion->detracciones->tipo_detraccion->descripcion }} -
                                            {{ $facturacion->detracciones->porcentaje_detraccion }} %<br>
                                            <strong>Medio de Pago:</strong>
                                            {{ $facturacion->detracciones->medio_pago->descripcion }} <br>
                                            <strong>Monto de Detraccion:</strong>
                                            S/. {{ number_format($facturacion->detracciones->monto_detraccion, 2) }} <br>
                                        </div>
                                    </div>
                                @else
                                    @php
                                        $total_fact = $facturacion->total_precio_sin_forma; 
                                    @endphp
                                    <div class="col-sm-6 ">
                                        <div class="form-control" style="height: 100% !important">
                                            <strong>Informacion de Retención:</strong><br>
                                            <strong>Importe Total Facturado:</strong>
                                            {{ $simbologia }} {{ number_format(round($end, 2), 2) }}<br>
                                            <strong>Monto Retenido ({{ $facturacion->porcentaje_retencion}} %):</strong>
                                            {{ $simbologia }} {{ number_format(round($facturacion->monto_retencion,2),2)}} <br>
                                            <strong>Monto Neto a Pagar:</strong>
                                            {{ $simbologia }}  {{ number_format(round($facturacion->monto_retencion_pagar,2),2)}} <br>
                                        </div>
                                    </div>
                                @endif
                                
                            @else
                                <div class="col-sm-12 form-control" style="height:  100px">
                                    <strong>Observaciones:</strong><br>
                                    {{ $facturacion->observacion }}
                                </div>
                            @endif
                        </div>
                        <br>
                    </div>
                    <div class="div-editar no_mostrar">
                        @if($facturacion->estado == 0)
                            <div class="" >
                                @include('transaccion.venta.facturacion.edit')
                            </div>
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
        .detracc_campo_required, .retenc_campo_required {
            display: none;
            /* font-size: 9px; */
            color: red;
        }
    </style>
    {{-- Modal Configuracion --}}
    <div class="modal fade" id="config" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                </div>
                <div style="padding-left: 15px;padding-right: 15px;">
                    {{-- ccccccccccccccccc --}}
                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                        <form action="{{ route('email.config') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">
                                <fieldset>
                                    <legend> Agregar Configuración </legend>
                                    <div class="panel-body" align="left">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Email:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control"
                                                    name="email" style="height: 75%;border-radius: 2px ">
                                            </div>

                                            <label class="col-sm-2 col-form-label">Contraseña:</label>
                                            <div class="col-sm-10">
                                                <div class="input-group m-b">
                                                    <input type="password" class="form-control" name="password"
                                                        id="txtPassword" required=""
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
                                                <input type="text" class="form-control" name="port" value="110 "
                                                    style="border-radius: 2px">
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
                                                    onchange="return validarExt()" style="border-radius: 2px" />
                                                <span id="visorArchivo">
                                                    <!--Aqui se desplegará el fichero-->
                                                    <img name="firma" src="" width="390px" height="200px" />
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Ancho(px)</label>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" name="ancho_firma">
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
                            <button class="ladda-button btn btn-primary" type="submit">Grabar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL ANULAR A LOS 7 DIAS --}}

    <div class="modal fade" id="modal_anular" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">Anular Factura</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>
                        <center>La Factura ya tiene más de <strong>7 días</strong> desde su creación, si la envía a Sunat
                            procederá como <strong>RECHAZADA por SUNAT</strong></center>
                    </h4>
                    <br>
                    <div class="row">
                        <div class="col-sm-8">
                            <p><strong>¿Desea Anular La Factura {{ $facturacion->codigo_fac }}?</strong></p>
                        </div>
                        <div class="col-sm-4">
                            <form action="{{ route('facturacion.anulacion') }}" method="POST">
                                {{-- <form action="" method="POST"> --}}
                                @csrf
                                <input type="hidden" name="id_fact" value="{{ $facturacion->id }}">
                                <center><button class="btn btn-danger">Anular</i></button></center>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding:  1rem 1rem;justify-content: center">
                    <div class="row" style="width: 100%">
                        <div class="col-sm-6" style="padding: 0px" align="left">
                            *Esto no Anula la Factura en Sunat,
                        </div>
                        <div class="col-sm-6" style="padding: 0px" align="right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Fin de modal configuracion --}}
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
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    <!-- TouchSpin -->
    <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

    <script type="text/javascript">
        function mostrarPassword() {
            var cambio = document.getElementById("txtPassword");
            if (cambio.type == "password") {
                cambio.type = "text";
                $('#ojo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('#ojo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        }
    </script>
    <script type="text/javascript">
        // {{-- Fotooos --}}

        function validarExt() {
            var archivoInput = document.getElementById('archivoInput');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.png|.jfif)$/i;
            if (!extPermitidas.exec(archivoRuta)) {
                alert('Asegurese de haber seleccionado una Imagen');
                archivoInput.value = '';
                return false;
            } else {
                //PRevio del PDF
                if (archivoInput.files && archivoInput.files[0]) {
                    var visor = new FileReader();
                    visor.onload = function(e) {
                        document.getElementById('visorArchivo').innerHTML =
                            '<img name="firma" src="' + e.target.result + '"width="390px" height="200px" />';
                    };
                    visor.readAsDataURL(archivoInput.files[0]);
                }
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

    <script>
        function toggleBtns() {
            const slider = document.getElementById('btn-slider');
            const arrow = document.getElementById('btn-arrow');
            const isOpen = slider.style.width !== '0px' && slider.style.width !== '0';

            if (isOpen) {
                slider.style.width = '0';
                arrow.classList.remove('fa-chevron-right');
                arrow.classList.add('fa-chevron-left');
            } else {
                slider.style.width = slider.scrollWidth + 'px';
                arrow.classList.remove('fa-chevron-left');
                arrow.classList.add('fa-chevron-right');
            }
        }
    </script>
    {{-- -
    <div class="row tooltip-demo align-items-center">

    <!-- IZQUIERDA -->
    <div class="col-md-auto">
        <h5 class="mb-0">{{ $facturacion->codigo_fac }}</h5>
        <span><strong>R.U.C :</strong> {{ $empresa->ruc }}</span>
    </div>

    <!-- CENTRO -->
    <div class="col text-center">
        <h4 class="mb-0 font-weight-bold">
            FACTURA ELECTRÓNICA
        </h4>
    </div>

    <!-- DERECHA (BOTONES) -->
    <div class="col-md-auto d-flex align-items-center flex-wrap" style="gap:5px;">

        <!-- PDF -->
        <form action="{{ route('pdf_fac', $facturacion->id) }}" class="m-0">
            <input type="text" name="name" hidden value="{{ $facturacion->codigo_fac }}">
            <button type="submit" class="btn btn-success"
                data-toggle="tooltip" title="Descargar PDF">
                <i class="fa fa-file-pdf-o"></i>
            </button>
        </form>

        <!-- Ticket -->
        <a href="{{ route('facturacion.ticket', $facturacion->id) }}"
           class="btn btn-info" target="_blank">
           <i class="fa fa-ticket"></i>
        </a>

        <!-- Print -->
        <a href="{{ route('facturacion.print', $facturacion->id) }}"
           class="btn btn-success" target="_blank"
           data-toggle="tooltip" title="Imprimir">
            <i class="fa fa-print"></i>
        </a>

        <!-- Email -->
        @if (Auth::user()->email_creado == 1)
        <form action="{{ route('email.factura', $facturacion->id) }}" method="post" class="m-0">
            @csrf
            <button type="submit" class="btn btn-secondary"
                data-toggle="tooltip" title="Enviar por correo"
                formtarget="_blank">
                <i class="fa fa-envelope"></i>
            </button>
        </form>
        @endif

        <!-- WhatsApp -->
        <button class="btn btn-success"
            style="background:green;border-color:green"
            onclick="divAuto()">
            <i class="fa fa-whatsapp"></i>
        </button>

        @if ($facturacion->estado == 0)

        <button class="btn btn-warning btn-editar"
            onclick="click_editar()">
            <i class="fa fa-pencil"></i>
        </button>

        <button class="btn btn-warning btn-no-editar no_mostrar"
            onclick="click_cancelar_editar()">
            <i class="fa fa-times"></i>
        </button>

        @endif

    </div>

</div>

<!-- FORM WHATSAPP -->
<div id="div-mostrar" class="w-100 mt-2"
     style="height:0; overflow:hidden; transition:height .4s;">

    <form action="{{ route('agregado.whatsapp_send') }}"
          method="post" class="d-flex align-items-center">

        @csrf

        <input type="tel" name="numero"
               class="form-control mr-2"
               value="{{ $facturacion->cliente->celular }}">

        <input type="text" name="mensaje" id="texto_orden" hidden>

        <input type="text" hidden name="url"
               value="{{ route('pdf_fac', $facturacion->id) }}?archivo=">

        <input type="text" hidden name="name_sin_cambio"
               value="Facturacion_{{ $facturacion->codigo_fac }}">

        <button type="submit"
            class="btn btn-success"
            style="background:green;border-color:green"
            formtarget="_blank"
            data-toggle="tooltip"
            title="Enviar por Whatsapp">

            <i class="fa fa-send"></i>

        </button>

    </form>

</div>--}}
    {{-- Para Editar Factura Sin Finalizar --}}
    @include('transaccion.venta.facturacion._shared._edit_script')
@endsection
