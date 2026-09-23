@extends('layout')
@section('title', 'Cotización')
@section('breadcrumb', 'Cotización')
@section('breadcrumb2', 'Cotización')
@section('href_accion', route('cotizacion.index'))
@section('value_accion', 'Inicio')

@section('button2', 'Nueva Cotización')
@section('onclick', "event.preventDefault();document.getElementById('nueva_cot').submit();")
@section('content')

    <form action="{{ route($nueva_cot) }}"enctype="multipart/form-data" method="post" id="nueva_cot">
        @csrf
        <input type="text" hidden="hidden" name="almacen" value="{{ $cotizacion->almacen_id }}">
        <input hidden="hidden" type="submit">
    </form>
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
            <a class="alert-link" href="#">
                @foreach ($errors->all() as $error)
                    <li class="error" style="color: red">{{ $error }}</li>
                @endforeach
            </a>
        </div>
    @endif
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title d-flex justify-content-between" style="padding-right: 3.1%">
                <div style="margin-top: 5px; margin-bottom: 8px; margin-left: 10px;">
                    @if (auth()->user()->almacen_id == null)
                        <span class="dropdown">
                            <a id="" class="no-hover-icon" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="cursor: pointer;">
                                <i class="fa fa-arrow-left text-muted"></i>
                            </a>

                            <ul class="dropdown-menu animated fadeInRight" aria-labelledby="" style="margin: 5px 3px">
                                <li style="padding: 12px 12px 5px 15px;"><b>Almacenes:</b></li>
                                @foreach (isset($almacenes_list) && is_iterable($almacenes_list) ? $almacenes_list : [] as $almacens)
                                    <li>
                                        <form action="{{ route('cotizacion.create_factura') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="almacen" value="{{ $almacens->id }}">
                                            <button class="btn btn-block btn-link" type="submit"
                                                style="box-shadow: none;text-align: left">
                                                {{ $almacens->nombre }}
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </span>
                    @else
                        <form action="{{ route('cotizacion.create_factura') }}" method="post" style="display:inline;">
                            @csrf
                            {{-- Usa el ID del almacén de la cotización (tu $almacen actual es int) --}}
                            <input type="hidden" name="almacen" value="{{ $almacen }}">
                            <button type="submit" class="btn btn-link btn-sm" style="box-shadow: none;transform: none">
                                <i class="fa fa-arrow-left text-muted"></i>
                            </button>
                        </form>
                    @endif
                </div>
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up text-muted"></i>
                    </a>
                    <a class="" href="{{ route('ventas.cotizacion') }}">
                        <i class="fa fa-times text-muted"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="padding-bottom: 10px;">
                <div class="row align-items-center tooltip-demo">
                    <div class="col-12 col-md-5">
                        <h3 style="margin: 0;">{{ $cotizacion->cod_cotizacion }}</h3>
                        <strong style="margin: 0;">R.U.C : </strong>{{ $empresa->ruc }}
                    </div>

                    <div class="col-12 col-md-2 text-center">
                        <h2 class="mb-0 text-nowrap" style="text-align: center">
                            COTIZACIÓN
                        </h2>
                    </div>

                    <div class="col-12 col-md-5 d-flex flex-wrap justify-content-end align-items-center" style="gap: 4px;">
                        {{-- @if ($cotizacion->estado_vigente == 0 && $cotizacion->estado == 0) --}}
                        <div class="d-flex align-items-center" style="overflow: hidden;">
                            <div id="btn-slider-cotizacion"
                                style="width: 0; overflow: hidden; transition: width 0.3s ease; display: flex; align-items: center;">
                                @if ($cotizacion->estado == '1')
                                    @if ($cotizacion->tipo == 'factura')
                                        <a class="btn btn-default btn-sm procesado"
                                            style="color: inherit !important; transition: 1s"
                                            href="{{ route('facturacion.show', $factura->id) }}" data-toggle="tooltip"
                                            data-placement="bottom" data-original-title="Ver Factura">
                                            <i class="fa fa-file-text-o fa-lg"></i>
                                        </a>
                                    @elseif($cotizacion->tipo == 'boleta')
                                        <a class="btn btn-default btn-sm procesado"
                                            style="color: inherit !important; transition: 1s"
                                            href="{{ route('boleta.show', $boleta->id) }}" data-toggle="tooltip"
                                            data-placement="bottom" data-original-title="Ver Boleta">
                                            <i class="fa fa-file-text-o fa-lg"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-default btn-sm procesado"
                                            style="color: inherit !important; transition: 1s"
                                            href="{{ route('nota_venta.show', $nota_venta->id) }}" data-toggle="tooltip"
                                            data-placement="bottom" data-original-title="Ver Nota de Venta">
                                            <i class="fa fa-file-text-o fa-lg"></i>
                                        </a>
                                    @endif
                                @else
                                    @can('cotizacion.procesar')
                                        @if ($cotizacion->tipo == 'factura')
                                            <form action="{{ route('cotizacion.facturar', $cotizacion->id) }}" method="post"
                                                enctype="multipart/form-data" style="padding: 0;" class="btn">
                                                @csrf
                                                <input type="hidden" name="almacen" value="{{ $almacen }}" />
                                                <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" data-original-title="Facturar">
                                                    <i class="fa fa-file-text-o fa-lg"></i>
                                                </button>
                                            </form>
                                            <input type="hidden" name="tipo_coti" id="tipo_coti" value="1">
                                        @elseif($cotizacion->tipo == 'boleta')
                                            <form action="{{ route('cotizacion.boletear', $cotizacion->id) }}" method="post"
                                                enctype="multipart/form-data" style="padding: 0;" class="btn">
                                                @csrf
                                                <input type="hidden" name="almacen" value="{{ $almacen }}" />
                                                <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" data-original-title="Boletear">
                                                    <i class="fa fa-file-text-o fa-lg"></i>
                                                </button>
                                            </form>
                                            <input type="hidden" name="tipo_coti" id="tipo_coti" value="0">
                                        @else
                                            <form action="{{ route('cotizacion.nota_venta', $cotizacion->id) }}"
                                                method="post" enctype="multipart/form-data" style="padding: 0;"
                                                class="btn">
                                                @csrf
                                                <input type="hidden" name="almacen" value="{{ $almacen }}" />
                                                <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" data-original-title="Generar Nota de Venta">
                                                    <i class="fa fa-file-text-o fa-lg"></i>
                                                </button>
                                            </form>
                                            <input type="hidden" name="tipo_coti" id="tipo_coti" value="3">
                                        @endif
                                    @endcan
                                @endif
                            </div>
                            @can('cotizacion.procesar')
                                <button type="button" id="btn-toggle-cotizacion" onclick="toggleBtnsCotizacion()"
                                    class="btn btn-default btn-sm"
                                    style="background: #fff; border: 1px solid #ccc; padding: 5px 8px; transition: transform 0.3s;margin-left: 3px">
                                    <i class="fa fa-chevron-left" id="btn-arrow-cotizacion"></i>
                                </button>
                            @endcan
                        </div>
                        <div style="width: 1px; height: 30px; background-color: #ccc; margin: 0 6px;"></div>
                        {{-- @endif --}}

                        <a href="{{ route('cotizacion.free_print', $cotizacion->id) }}" class="btn btn-secondary btn-sm"
                            target="_blank" data-toggle="tooltip" data-placement="bottom"
                            data-original-title="Impresión Libre">
                            <i class="fa fa-share-alt"></i>
                        </a>

                        <form class="btn" style="padding: 0;"
                            action="{{ route('pdf_cotizacion', $cotizacion->id) }}">
                            <input type="text" name="name" maxlength="50" hidden
                                value="Cotizacion_{{ $cotizacion->tipo }}">
                            <input type="text" hidden name="firma" value="0">
                            <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip"
                                data-placement="bottom" data-original-title="Descargar PDF">
                                <i class="fa fa-file-pdf-o fa-lg"></i>
                            </button>
                        </form>

                        <input type="text" value="{{ $cotizacion->id }}" name="id" id="id" hidden>

                        <a class="btn btn-success btn-sm" href="{{ route('cotizacion.print', $cotizacion->id) }}"
                            target="_blank" data-toggle="tooltip" data-placement="bottom"
                            data-original-title="Imprimir">
                            <i class="fa fa-print fa-lg"></i>
                        </a>

                        @if (Auth::user()->email_creado == 1)
                            <form action="{{ route('email.cotizacion', $cotizacion->id) }}" method="post"
                                style="padding: 0;" class="btn">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm" data-toggle="tooltip"
                                    data-placement="bottom" formtarget="_blank" data-original-title="Enviar por correo">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </button>
                            </form>
                        @endif

                        <div style="position: relative; display: inline-block;">
                            <div id="auto" onclick="divAuto()">
                                <a class="btn btn-success btn-sm" style="background: green; border-color: green;"
                                    data-toggle="tooltip" data-placement="bottom" data-original-title="Enviar a">
                                    <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                </a>
                            </div>
                        </div>
                        @if (is_null($factura))
                            @can('cotizacion.editar')
                                <button type="button" class="btn btn-warning btn-editar btn-sm" id="edit"
                                    onclick="click_editar()" data-toggle="tooltip" data-placement="bottom"
                                    data-original-title="Editar cotización" style="white-space: nowrap;">
                                    <i class="fa fa-pencil"></i>
                                </button>

                                <button type="button" class="btn-no-editar no_mostrar btn btn-warning btn-sm"
                                    onclick="click_cancelar_editar()" data-toggle="tooltip" data-placement="bottom"
                                    data-original-title="Cancelar edición" style="white-space: nowrap; margin-right: 4px;">
                                    <i class="fa fa-times"></i>
                                </button>
                            @endcan
                        @endif
                    </div>
                    <div id="div-mostrar"
                        style="">
                        <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="">
                            @csrf
                            <input type="tel" name="numero" value="{{ $cotizacion->cliente->celular }}" />
                            <input type="text" name="mensaje" id="texto_orden" hidden />
                            <input type="text" hidden name="url"
                                value="{{ route('pdf_cotizacion', $cotizacion->id) }}?archivo=">
                            <input type="text" name="name_sin_cambio" hidden
                                value="Cotizacion_{{ $cotizacion->tipo }}" />
                            <button type="submit" class="btn btn-success btn-xs"
                                style="background: green; border-color: green;" formtarget="_blank" data-toggle="tooltip"
                                data-placement="bottom" data-original-title="Enviar por Whatsapp">
                                <i class="fa fa-send fa-lg"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-top: -26px;">
                <div class="ibox-content " style=" margin-bottom: 20px;padding-bottom: 50px;">
                    <br>
                    <div class="table-no mostrar">
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>Señor(es):</strong> &nbsp;<span>{{ $cotizacion->cliente->nombre }}</span><br>
                                        <strong><span>{{ $cotizacion->cliente->documento_identificacion }}</span> :</strong>
                                        &nbsp;<span>{{ $cotizacion->cliente->numero_documento }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <strong>Dirección:</strong>&nbsp; <span>{{ $cotizacion->cliente->direccion }}</span><br>
                                        <strong>N° Contacto:</strong>&nbsp;
                                        <span>
                                            {{ $cotizacion->cliente->celular }}
                                            @if (isset($cotizacion->cliente->telefono))
                                                / {{ $cotizacion->cliente->telefono }}<br>
                                            @endif
                                        </span>
                                        {{-- DATOS DE RENOVACIÓN --}}
                                        @if ($renovacion)
                                            <strong>F.
                                                Vencimiento:</strong>&nbsp;{{ $renovacion->fecha_vencimiento->format('d-m-Y') }}&nbsp;&nbsp;&nbsp;
                                            <strong>Días restantes:</strong>&nbsp;{{ $dias_restantes_texto }}<br>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Condiciones Generales</h3>
                                    <div align="left">
                                        <strong>Forma De Pago:</strong>
                                        &nbsp;<span>{{ $cotizacion->forma_pago->nombre }}</span>&nbsp;&nbsp;&#09;&nbsp;&nbsp;&#09;&Tab;&Tab;&#8287;<strong>Fecha:</strong>
                                        &nbsp;<span>{{ \Carbon\Carbon::parse($cotizacion->updated_at)->format('d-m-Y H:i:s') }}</span><br>
                                        <strong>Validez :</strong>
                                        &nbsp;<span>{{ $cotizacion->validez }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#09;&Tab;&Tab;&#8287;
                                        <strong>Garantía:</strong>
                                        &nbsp;<span>{{ $cotizacion->garantia }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <strong>Tipo de Moneda:</strong>
                                        &nbsp;<span>{{ $cotizacion->moneda->nombre }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <strong>Comisionista:</strong> &nbsp;

                                        @if (isset($cotizacion->comisionista->cod_vendedor))
                                            <span>{{ $cotizacion->comisionista->cod_vendedor }} -
                                            {{ $cotizacion->comisionista->personal->personal_l->nombres }} -
                                            {{ $cotizacion->comisionista->comision }}%</span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                            <input type="hidden" name="" id="comisionista"
                                                value="{{ $cotizacion->comisionista->comision }}">
                                        @else
                                            <span>Sin Comisionista - 0</span>
                                            <input type="hidden" name="" id="comisionista" value="0">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-12" align="center">
                                <div class="form-control" style="border: none;height: auto">
                                    <div align="left">
                                        <strong>Observaciones:</strong> &nbsp;{{ $cotizacion->observacion }}<br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <input type="hidden" name="almacen" id="almacen_id" class="form-control "
                        value="{{ $cotizacion->almacen_id }}" readonly="readonly">
                    <input type="hidden" id="moneda" class="form-control "
                        value="{{ $cotizacion->moneda->nombre }}" readonly="readonly">
                    <input type="hidden" id="moneda_id" class="form-control " value="{{ $cotizacion->moneda_id }}"
                        readonly="readonly">
                    <div class="table-no mostrar ">
                        <table class="table" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ITEM</th>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Dscto.</th>
                                    <th>P.Unitario Desc.</th>
                                    <th>Comisión</th>
                                    <th>P.Unitario Com.</th>
                                    <th>Total<span hidden="hidden">{{ $simbologia = $cotizacion->moneda->simbolo }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cotizacion_registro as $cotizacion_registros)
                                    <tr>
                                        <td>{{ $i++ }} </td>
                                        @if (isset($cotizacion_registros->producto_id))
                                            <td>{{ $cotizacion_registros->producto->codigo_producto }}</td>
                                            <td>{{ $cotizacion_registros->producto->nombre }}
                                                <br><small>{{ $cotizacion_registros->descripcion_item }}</small></td>
                                        @else
                                            <td>{{ $cotizacion_registros->servicio->codigo_servicio }}</td>
                                            <td>{{ $cotizacion_registros->servicio->nombre }}
                                                <br><small>{{ $cotizacion_registros->descripcion_item }}</small></td>
                                        @endif

                                        <td>{{ $cotizacion_registros->cantidad }}</td>
                                        <td>{{ $cotizacion_registros->descuento }}%</td>
                                        <td>{{ number_format($cotizacion_registros->precio_unitario_desc, 2) }}</td>
                                        <td>{{ $cotizacion_registros->comision }}%</td>
                                        <td>{{ number_format($cotizacion_registros->precio_unitario_comi, 2) }}</td>
                                        <td style="text-align: right">
                                            {{ number_format($cotizacion_registros->cantidad * $cotizacion_registros->precio_unitario_comi, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
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
                                        Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }}
                                        {{ $cotizacion->moneda->nombre }}
                                    </h3>
                                </div>
                                <div class="col-sm-4 ">
                                    <div class="form-control">
                                        <span style="display: inline-block;float: left"> Subtotal:</span>
                                        <span style="display: inline-block;float: right;">
                                            {{ $simbologia = $cotizacion->moneda->simbolo }}
                                            {{ number_format($sub_total, 2) }}</span>
                                        <br>
                                        <span style="display: inline-block;float: left"> Op. Gravada: </span>
                                        <span style="display: inline-block;float: right">{{ $simbologia }}
                                            {{ number_format($cotizacion->op_gravada, 2) }}</span><br>
                                        <span style="display: inline-block;float: left"> Op. Inafecta: </span>
                                        <span style="display: inline-block;float: right">{{ $simbologia }}
                                            {{ number_format($cotizacion->op_inafecta, 2) }}</span><br>
                                        <span style="display: inline-block;float: left"> Op. Exonerada: </span>
                                        <span style="display: inline-block;float: right">{{ $simbologia }}
                                            {{ number_format($cotizacion->op_exonerada, 2) }} </span><br>
                                        <span style="display: inline-block;float: left"> I.G.V.: </span>
                                        <span style="display: inline-block;float: right">{{ $cotizacion->moneda->simbolo }}
                                            {{ number_format(round($igv_p, 2), 2) }}</span><br>
                                        <span style="display: inline-block;float: left"> Importe Total: </span>
                                        <span style="display: inline-block;float: right">{{ $cotizacion->moneda->simbolo }}
                                            {{ number_format($end, 2) }}</span>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </div>
                    <span hidden> {{ $h = 1 }} {{ $sume = 0 }}</span>
                    <div class="div-editar no_mostrar">
                        @if ($cotizacion->estado_vigente == 0 && $cotizacion->estado == 0)
                            @include('transaccion.venta.cotizacion.factura.edit')
                        @endif
                    </div>
                    <!-- Fin Totales de Productos -->
                    <br>
                    @include('layout_bancos')
                    <br>
                    @include('layout_firma_pie_hoja')
                </div>
            </div>
        </div>
    </div>
    <style>
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
        #div-mostrar{
            margin: auto;
            margin-right: 15px;
            height: 0px;
            transition: height .4s;
            color:white;
            text-align: right;
            width: 100%;
        }
        #div-mostrar > form{
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

        #DataTables_Table_0_wrapper{
            display: flex;
            flex-direction: column !important;
            justify-content: space-between !important;
            height: 100% !important;
        }
        #DataTables_Table_0_wrapper > .top{
            display: none;
        }
        #DataTables_Table_0_wrapper > .row > .col-sm-12 {
            padding: 0px !important;
        }
        .data_table_multiple{
            border: 1px solid #e7eaec;
            margin-bottom: 0px !important;
        }
        #DataTables_Table_0_info{
            margin-bottom: 5px !important;
        }
        span.select2.select2-container.select2-container--default.select2-container--below{
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
        .limp{
            min-width: 85px !important;
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
    {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
    <!-- TouchSpin -->
    <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

    <script>
        $('.demo3').click(function() {
            if (document.forms['coti_update'].reportValidity()) {
                swal({
                        title: "¿Estas seguro que deseas Finalizar?",
                        text: "Una vez Finalizado, no podras editar esta Cotizacion",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3686ff",
                        confirmButtonText: "Si, Finalizar",
                        cancelButtonText: "Cancelar!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            swal("Edicion de Cotizacion Cerrado", "No se va a poder editar de nuevo",
                            "success");
                            $(".finalizar").click();
                            $(".guardar").attr('disabled', true);
                        } else {
                            swal("Cancelado", "Cancelando el Finalizar", "error");
                        }
                    });
            } else {
                console.log('campos incompletos')
            }
        });
        $(document).ready(function() {});
        $(document).ready(function() {
            // Bind normal buttons
            Ladda.bind('.ladda-button', {
                timeout: 8000
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function mostrarMensaje(mensaje) {
            $("#divmsg").empty(); //limpiar div
            $("#divmsg").append(mensaje);
            $("#divmsg").show(200);
        }
        // {{-- Darle valor a cada Boton si es Finalizar o solo Guardar --}}
        $(".guardar").on('submit ', function() {
            $(".demo3").attr('disabled', true);
            var data =
                `<input value="1" type='hidden' name='submit' class="form-control" required/>  <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
            $('#inp_s').append(data);

        });
        $(".finalizar").on('click', function() {
            var data =
                `<input value="2" type='hidden' name='submit' class="form-control" required/>   <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
            $('#inp_s').append(data);
            // $(".guardar").remove();
        });

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

        $(document).ready(function() {
            $('#btn_ticket').click(function() {
                var id_fac = $(`[id='id']`).val();
                $.ajax({
                    type: "post",
                    url: "{{ route('ticket_ajax_coti') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': id_fac
                    },
                    success: function(response) {
                        if (response == 1) {
                            // alert('Imprimiendo Ticket');
                        } else {
                            alert('Error');
                        }
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        // var input_text_opt = $('input[class="celda"]').find();
        let articulosAgregados = new Set();
        $('.celda').each(function() {
            var valor = $(this).val();
            var partes = valor.split('|').map(p => p.trim());
            var id = partes[0];
            articulosAgregados.add(String(id));
        });

        
        //*Condicional para el tipo de factura
        var tipo_coti = $('#tipo_coti').val();
        var cliente_default = $('#cliente_id').val();
        $(".select2_demo_client").select2({
            placeholder: "Seleccionar Cliente",
            width: '100%',
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.clients') }}",
                dataType: 'json',
                type: "POST",
                delay: 10,
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term, // search term
                        tipo_coti: tipo_coti,
                        select_default: cliente_default
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.nombre + ' | ' + item.numero_documento,
                            };

                        })
                    };
                },
                cache: true
            }

        });

        var clic = 1;

        function divAuto() {
            if (clic == 1) {
                document.getElementById("div-mostrar").style.height = "40px";
                clic = clic + 1;
            } else {
                document.getElementById("div-mostrar").style.height = "0px";
                clic = 1;
            }
        }

        // function ajax_l() {
        //     var numeros = $('[id="total_final"]').val();
        //     var moneda = $('[id="moneda"]').val();
        //     $.ajax({
        //         type: "post",
        //         url: "{{ route('pa.numberletters') }}",
        //         data: {
        //             '_token': $('input[name=_token]').val(),
        //             'numeros': numeros,
        //             'moneda': moneda
        //         },
        //         success: function(msg) {
        //             console.log(msg);
        //             $('.h3-total').html(msg);
        //         }
        //     });
        // }

        //AUMENTO DE INPUTS
        var i = $('#count_articles').val();
        $(".addmore").on('click', function() {
            var data = `[
                <tr>
                    <td>
                        <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="nuevo">
                        <button class="btn btn-primary btn-sm e  borrar"><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <select class="monto0 select2_demo_3 select_change limp_select" id='articulo${i}' onchange="ajax(${i})"  autocomplete="off" required></select>
                        </select>
                        <textarea type='text' id='descripcion${i}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control limp_txt" autocomplete="off" style="margin-top: 5px;" ></textarea>
                        <input style="width: 76px" hidden="" type='text' id='tipo_afec${i}' name='tipo_afec[]' readonly="readonly" class="monto0 form-control" onkeyup="multi(${i})" required  autocomplete="off"  />
                        <input class="celda" name="articulo[]" id="input_prod${i}" hidden >
                    </td>
                    <td>
                        <input type="text" class="form-control limp" name="stock" id="stock${i}" readonly>
                    </td>
                    <td>
                        <input type="text"  name="cantidad[]" id="cantidad${i}" class="form-control limp" onkeyup="multi(${i})" >
                    </td>
                    <td>
                        <input type="text"  name="precio[]" id="precio${i}" class="form-control limp" readonly>
                    </td>
                    <td>
                        <div style="position: relative;">
                            <input class="text_des limp" type='text' id='descuento${i}' name='descuento[]' readonly="readonly" required autocomplete="off"/>
                        </div>
                        <div  class="div_check">
                            <input class="check" type='checkbox' id='check${i}' name='check[]' onclick="multi(${i})" style="" autocomplete="off"/>
                        </div>
                        <input type='hidden' id='check_descuento${i}' name='check_descuento[]' class="form-control limp"  required>
                        <input type='hidden' id='promedio_original${i}' name='promedio_original[]' class="form-control limp" required >
                    </td>
                    <td>
                        <input type="text" readonly name="precio_unitario_descuento[]" id="precio_unitario_descuento${i}" class="form-control limp">
                    </td>
                    <td>
                        <input style="width: 76px" type='hidden' name="comision[]" id='comision${i}'  readonly="readonly" class="form-control limp"  required  autocomplete="off" />
                        <input type="text" readonly name="precio_unitario_comision[]" id="precio_unitario_comision${i}" class="form-control limp" >
                    </td>
                    <td>
                        <input type="text" name="total_inp" id="total${i}" readonly class="form-control limp" >
                        <input type='text' id='afectacion${i}'    name='afectacion' disabled="disabled" class="afectacion form-control" hidden="" required  autocomplete="off"/>
                    </td>
                </tr>
            `;
            $('.tables').append(data);
            $('#count_articles').val(i);
            i++;
            articlesSelect2();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);

            const section = document.getElementById("left_h3");
            section.scrollIntoView({
                block: "end",
                behavior: "smooth"
            });

        });
        $(document).ready(function() {
            articlesSelect2();
        });

        function articlesSelect2() {
            $(".select2_demo_3").select2({
                width: "400px",
                placeholder: "Seleccionar Articulo",
                ajax: {
                    minimumInputLength: 1,
                    url: "{{ route('pa.articles') }}",
                    dataType: 'json',
                    type: "POST",
                    // delay: 1500,
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term // search term
                        };
                    },
                    processResults: function(data) {
                        //validador de articulos multiples
                        let data_length = data.length;
                        let articles_selected_ajax = document.getElementsByClassName("select2_demo_3");
                        let articles_selected_count_ajax = articles_selected_ajax.length;
                        for (var z = 0; z < articles_selected_count_ajax; z++) {
                            var selected_ajax = document.getElementsByClassName("select2_demo_3 select_change")[
                                z].value;
                            for (var y = 0; y < data_length; y++) {
                                if (selected_ajax == data[y].id + " | " + data[y].codigo + " | " + data[y]
                                    .codigo_original + " | " + data[y].nombre) {
                                    if (data[y].tipo == 'producto') {
                                        data[y].disabled = true;
                                    } else {
                                        data[y].disabled = false;
                                    }
                                }
                            }
                        }
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id + " | " + item.codigo + " | " + item.codigo_original +
                                        " | " + item.nombre,
                                    text: item.id + " | " + item.codigo + " | " + item.codigo_original +
                                        " | " + item.nombre,
                                    disabled: item.disabled
                                };
                            })
                        };
                    },
                    cache: true,
                    passive: true
                }
            });
        }

        function ajax(a) {
            console.log(a);
            var articulo = document.getElementById(`articulo${a}`).value;
            console.log(articulo);
            document.getElementById(`input_prod${a}`).value = articulo;

            var almacen = $('[id="almacen_id"]').val();
            var moneda = $('[id="moneda_id"]').val();
            $.ajax({
                type: "post",
                url: "{{ route('pa.description') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'articulo': articulo,
                    'almacen': almacen,
                    'moneda': moneda
                },
                success: function(msg) {
                    $(`#descripcion${a}`).val(msg.description);
                    $(`#tipo_afec${a}`).val(msg.afectacion);
                    $(`#precio${a}`).val(msg.price);
                    $(`#cantidad${a}`).val(1);
                    $(`#precio_unitario_descuento${a}`).val(msg.price);
                    $(`#promedio_original${a}`).val(msg.average);
                    $(`#stock${a}`).val(msg.amount);
                    $(`#descuento${a}`).val(msg.discount);
                    $(`#check_descuento${a}`).val(0);
                    $(`#cantidad${a}`).attr('max', msg.amount);
                    // $(`#cantidad`).attr('max', msg.amount );
                    var separador = " ";
                    var comision = document.querySelector(`#comisionista`).value;
                    document.getElementById(`comision${a}`).value = comision;
                    multi(a);
                    $(`.addmore`).prop("disabled", false);
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }
        //Funcion de comision
        function comision() {
            var comision = document.getElementById(`comisionista`).value;
            if (comision != 0) {

                var campos_num = document.getElementsByClassName("total").length;

                document.getElementById(`comision0`).value = comision_v;

                if (campos_num != 1) {
                    for (var i = 2; i <= campos_num; i++) {
                        document.getElementById(`comision${i}`).value = comision_v;
                    }
                }
                multi(0);
                if (campos_num != 1) {
                    for (var i = 2; i <= campos_num; i++) {
                        multi(i);
                    }
                }
            }
        }

        function multi(a) {
            console.log(a);
            // var totales = 0;
            // $(`.monto${a}`).each(function(){
            //     if (!isNaN(parseFloat($(this).val()))) {
            //         change= true;
            //         total *= parseFloat($(this).val());
            //     }
            // });
            // total = (change)? total:0;
            // variables
            var checkBox = document.getElementById(`check${a}`);
            var cantidad = document.querySelector(`#cantidad${a}`).value;
            var promedio_original = document.querySelector(`#promedio_original${a}`).value;
            var descuento = document.querySelector(`#descuento${a}`).value;
            var afec = document.querySelector(`#tipo_afec${a}`).value;
            var precio = document.querySelector(`#precio${a}`).value
            var comision = document.getElementById(`comisionista`).value;
            var multiplier = 100;
            var igv = {{ $igv->renta }};
            if (checkBox.checked == true && descuento > 0) {
                var precio_uni = precio - (promedio_original * (descuento / multiplier));
                var precio_uni_dec = Math.round(precio_uni * multiplier) / multiplier;
                document.getElementById(`check_descuento${a}`).value = descuento;
                document.getElementById(`precio_unitario_descuento${a}`).value = precio_uni_dec;
                var comision_mul = precio_uni_dec + (precio_uni_dec * (comision / 100));
                var comision_final = Math.round(comision_mul * multiplier) / multiplier;
                document.getElementById(`precio_unitario_comision${a}`).value = comision_final;

                var final = comision_final * cantidad;
                var final_decimal = Math.round(final * multiplier) / multiplier;
                var igv_final = final_decimal * (igv / multiplier);
                var igv_dec = Math.round(igv_final * multiplier) / multiplier;
                var final_igv_round = parseFloat(final) + parseFloat(igv_dec);
                if (afec.toString() == "Gravado") {
                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = final_decimal;
                    // document.getElementById(`precio_unitario_igv${a}`).value = Math.round(final_igv_round * multiplier) / multiplier;
                } else {
                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = 0;
                    // document.getElementById(`precio_unitario_igv${a}`).value = final_decimal;
                }
            } else {
                document.getElementById(`check_descuento${a}`).value = 0;
                var precio_comi = parseFloat(precio) + (parseFloat(precio) * parseFloat(comision) / multiplier);
                var end = Math.round(precio_comi * multiplier) / multiplier;
                var final2 = cantidad * end;
                var final_decimal = Math.round(final2 * multiplier) / multiplier;
                document.getElementById(`precio_unitario_descuento${a}`).value = precio;
                document.getElementById(`precio_unitario_comision${a}`).value = end;
                var igv_prc = final_decimal * (igv / multiplier);
                var igv_decimal = Math.round(igv_prc * multiplier) / multiplier;
                var final_igv_round = parseFloat(final_decimal) + parseFloat(igv_decimal);
                if (afec.toString() == "Gravado") {
                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = final_decimal;
                    // document.getElementById(`precio_unitario_igv${a}`).value = Math.round(final_igv_round * multiplier) / multiplier;
                } else {
                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = 0;
                    // document.getElementById(`precio_unitario_igv${a}`).value = final_decimal;
                }
            }
            var for_tot = $('[name="total_inp"]');
            var tot = 0;
            for_tot.each(function() {
                tot += parseFloat($(this).val());
            });
            var total_ipt = Math.round(tot * multiplier) / multiplier;
            $('#sub_total').val(total_ipt);
            //solo gravado
            var to_grava = $('[name="afectacion"]');
            var t_grava = 0;
            to_grava.each(function() {
                t_grava += parseFloat($(this).val());
            });
            var tot_gra_dec = Math.round(t_grava * multiplier) / multiplier;
            // console.log(t_grava);
            $('#subtotal_gravado').val(tot_gra_dec);
            var igv = {{ $igv->renta }};
            var igv_val = tot_gra_dec * (igv / multiplier);

            var igv_dec_val = Math.round(igv_val * multiplier) / multiplier;
            var end = igv_dec_val + parseFloat(total_ipt);
            var end2 = Math.round(end * multiplier) / multiplier;
            document.getElementById("igv_input").value = igv_dec_val;
            document.getElementById("total_final").value = end2;
            // console.log(tot);
            // ajax_l();
        }
        $(document).on('click', '.borrar', function(event) {
            event.preventDefault();
            var e = document.getElementsByClassName("e").length;
            var fila = $(this).parents("tr");
            var input_text_opt = fila.find('input[class="celda"]').val();
            if (input_text_opt) {
                var partes = input_text_opt.split('|').map(p => p.trim());
                var id = partes[0];
                articulosAgregados.delete(String(id));
                reactivarBotonModal(id);
                // console.log(articulosAgregados);
            }
            $('option[value="' + input_text_opt + '"]').prop("disabled", false);
            $(".addmore").prop("disabled", false);
            if (e > 1) {
                fila.closest('tr').remove();
                $(".borrar").prop("disabled", false);
                $(".addmore").prop("disabled", false);
                // $(".guardar").prop("disabled", false);
                // $(".finalizad").prop("disabled", false);

                var multiplier = 100;
                var igv = {{ $igv->renta }};
                var for_tot = $('[name="total_inp"]');
                var tot = 0;
                for_tot.each(function() {
                    tot += parseFloat($(this).val());
                });
                var total_ipt = Math.round(tot * multiplier) / multiplier;
                $('#sub_total').val(total_ipt);
                //solo gravado
                var to_grava = $('[name="afectacion"]');
                var t_grava = 0;
                to_grava.each(function() {
                    t_grava += parseFloat($(this).val());
                });
                var tot_gra_dec = Math.round(t_grava * multiplier) / multiplier;
                // console.log(t_grava);
                $('#subtotal_gravado').val(tot_gra_dec);
                var igv = {{ $igv->renta }};
                var igv_val = tot_gra_dec * (igv / multiplier);

                var igv_dec_val = Math.round(igv_val * multiplier) / multiplier;
                var end = igv_dec_val + parseFloat(total_ipt);
                var end2 = Math.round(end * multiplier) / multiplier;
                document.getElementById("igv_input").value = igv_dec_val;
                document.getElementById("total_final").value = end2;
                // console.log(tot);
                // ajax_l();
            } else {
                // $(".borrar").prop("disabled", true);
                if(input_text_opt == ""){
                    return;
                }
                $(".addmore").prop("disabled", false);
                $(".select2_demo_3").val(null).trigger("change");
                limpiar_inputs();
            }
            
        });
        function limpiar_inputs(){             
            $(".select_change").select2("val", "");
            $('.check').prop('checked', false)
            $(".limp").val("");
            $(".celda").val("");
            $(".limp_txt").val("");
            $(".limp_select").val("");
            $("#igv_input").val("");
            $("#total_final").val("");
            $("#sub_total").val("");
        }
     
        document.addEventListener("DOMContentLoaded", function() {
            const checkRenovacion = document.getElementById("estado_renovacion");
            const contenedorRenovacion = document.getElementById("renovacion_container");
            const inputVencimiento = document.getElementById("fecha_vencimiento");
            const diasPreview = document.getElementById("dias_restantes_preview");

            // ── Preview días restantes ────────────────────────────────
            function mostrarDiasRestantes() {
                if (!inputVencimiento.value) {
                    diasPreview.textContent = "";
                    return;
                }

                const hoy = new Date();
                hoy.setHours(0, 0, 0, 0);
                const vencimiento = new Date(inputVencimiento.value + 'T00:00:00');
                const diff = Math.round((vencimiento - hoy) / (1000 * 60 * 60 * 24));

                if (diff > 0) {
                    diasPreview.style.color = diff <= 7 ? '#f8ac59' : '#1ab394';
                    diasPreview.textContent = `Vence en ${diff} día${diff !== 1 ? 's' : ''}`;
                } else if (diff === 0) {
                    diasPreview.style.color = '#ed5565';
                    diasPreview.textContent = 'Vence hoy';
                } else {
                    diasPreview.style.color = '#ed5565';
                    diasPreview.textContent = `Venció hace ${Math.abs(diff)} día${Math.abs(diff) !== 1 ? 's' : ''}`;
                }
            }

            // Mostrar preview al cargar si ya hay fecha
            mostrarDiasRestantes();

            // ── Al cambiar la fecha ───────────────────────────────────
            inputVencimiento.addEventListener("change", function() {
                // El min se actualiza: no puede elegir una fecha menor a la actual
                // (en renovación, la nueva fecha siempre debe ser futura)
                const hoy = new Date();
                hoy.setHours(0, 0, 0, 0);
                inputVencimiento.min = hoy.toISOString().split('T')[0];
                mostrarDiasRestantes();
            });

            // ── Toggle check renovación ───────────────────────────────
            checkRenovacion.addEventListener("change", function() {
                contenedorRenovacion.style.display = this.checked ? "block" : "none";
                if (!this.checked) {
                    inputVencimiento.value = "";
                    diasPreview.textContent = "";
                }
            });
        });
               // MODAL BUSQUEDA DE PRODUCTO
        let debounceTimer;
        $('#search_product').on('input', function(e) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                var busqueda = $(this).val();
                search_multiple(busqueda);
            }, 500); // Espera 300 ms antes de ejecutar la acción
        });
        $('#add_new_product').on('click', function(){
            search_multiple("");
            $('#search_product').val('');
        });
        
        let filtrarConStock = false;
        function search_multiple(busqueda) {
            // Limpiar DataTable previo
            if ($.fn.DataTable.isDataTable('.data_table_multiple')) {
                $('.data_table_multiple').DataTable().clear().destroy();
            }
            $('.data_table_multiple tbody').empty();

            $.ajax({
                type: "post",
                url: "{{ route('pa.search_multiple') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'articulo': busqueda,
                    'stock': filtrarConStock ? 1 : 0,
                    'almacen': $('[id="almacen_id"]').val(),
                    'moneda': $('[id="moneda_id"]').val()
                },
                success: function(msg) {
                    // Intentar parsear si el backend no manda las cabeceras application/json correctas
                    let data = typeof msg === 'string' ? JSON.parse(msg) : msg;
                    // Validación unificada: Si no hay data o está vacío, mostrar alerta y salir
                    if (!data || data.length === 0) {
                        toastr.warning("No se encontraron resultados", '', { timeOut: 3000 });
                        return;
                    }

                    // Inicializar DataTable
                    $('.data_table_multiple').DataTable({
                        "bLengthChange": false,
                        "searching": false,
                        "autoWidth": false,
                        pageLength: 7,
                        responsive: true,
                        "aaData": data,
                        drawCallback: function (settings) {
                            $(".touchspin1").each(function () {
                                const $input = $(this);
                                // Evitar doble inicialización si el plugin ya envolvió este input
                                if (!$input.hasClass('js-touchspin-init')) {
                                    $input.addClass('js-touchspin-init').TouchSpin({
                                        buttondown_class: 'btn btn-link btn-sm',
                                        buttonup_class: 'btn btn-link btn-sm',
                                        min: 1,
                                        max: parseFloat($input.attr('max')) || 0,
                                    });
                                }
                            });
                            activarSliderSiDesborda();
                        },
                        dom: '<"top"f>rt<"dt-left-info"ip>', // i = info ("Mostrando X-Y de Z"), p = paginación
                        language: {
                            info: "Mostrando _START_-_END_ de _TOTAL_ artículos",
                            infoEmpty: "No hay artículos",
                            paginate: {
                                previous: '<i class="fa fa-chevron-left"></i>',
                                next: '<i class="fa fa-chevron-right"></i>'
                            }
                        },
                        pagingType: "simple_numbers",
                        "columns": [
                            // { "data": "id" },
                            { 
                                "data": "codigo",
                                "width": "130px",
                                render: function(data, type, row) {
                                     return `
                                        <span class="codigo-toggle" 
                                            data-producto="${row.codigo_producto}" 
                                            data-original="${row.codigo_original ?? ''}" 
                                            data-showing="producto"
                                            style="cursor:pointer; display:inline-block; min-width:80px;">
                                            <span class="badge badge-info">${row.codigo_producto}</span>
                                        </span>
                                    `;
                                }
                            },
                            { 
                                "data": "nombre", 
                                "defaultContent": "",
                                render: function(data, type, row) {
                                    return `
                                        <div class="articulo-nombre"><span class=""><strong>${row.nombre}</strong></span></div>
                                        <div class="small-description"><small>${row.description}</small></div>
                                    `;
                                } 
                            },
                            { 
                                "data": "stock", 
                                "className": "precio_search precio_cantidad",  
                                "defaultContent": "",
                                render: function(data, type, row) {
                                    let claseCss;
                                    if (`${row.stock}` == 0) {
                                        claseCss = "badge badge-danger"; // ver nota abajo sobre badge-error
                                    } else {
                                        claseCss = "badge badge-success";
                                    }
                                    return `<span class="${claseCss}">${row.stock}</span>`;
                                } 
                            },
                            {
                                data: null,
                                title: 'CANTIDAD',
                                "className": "precio_cantidad",
                                "width": "100px",
                                render: function(data, type, row) {
                                    return `
                                        <input class="touchspin1 form-control-sm input-cantidad" type="text" value="1" name="demo1" min="1" max="${row.stock}" data-simbolo="${row.moneda.simbolo}" value="1" data-price="${row.price}" data-id="${row.id}">
                                    `;
                                }
                            },
                            {
                                data: 'price',
                                title: 'P. UNITARIO',
                                "width": "100px",
                                "className": "precio_dt",
                                render: function(data, type, row) {
                                    const formattedPrice = $.fn.dataTable.render.number(',', '.', 2).display(data);
                                    return `${row.moneda.simbolo} ${formattedPrice}`;
                                }
                            },
                            {
                                data: null,
                                title: 'TOTAL',
                                "width": "100px",
                                "className": "precio_dt",
                                render: function(data, type, row) {
                                    return `<span class="total" data-id="${row.id}" data-simbolo="${row.moneda.simbolo}">${row.moneda.simbolo} ${row.price.toFixed(2)}</span>`;
                                }
                            },
                            {
                                "width": "100px",
                                "className": "precio_search precio_cantidad",
                                render: function(data, type, row) {
                                    const yaAgregado = articulosAgregados.has(String(row.id));
                                    console.log(yaAgregado);
                                    if (`${row.stock}` != 0) {
                                        return `<button class="btn btn-primary btn-xs btn-agregar-articulo" data-id="${row.id}" data-cod_producto="${row.codigo_producto}" data-cod_original="${row.codigo_original}" data-nombre="${row.nombre}" ${yaAgregado ? 'disabled' : ''}> <i class="fa fa-plus"></i> Agregar</button>`;
                                    }else{ 
                                        return `<button class="btn btn-danger btn-xs btn-agregar-articulo" disabled><i class="fa fa-times"></i> Sin stock</button>`;
                                    }
                                }
                            }
                        ]
                    });
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.error('Error en la petición: ', eject.responseJSON);
                    }
                }
            });
        }
        $('.data_table_multiple').on('input change', '.input-cantidad', function() {
            const cantidad = parseFloat($(this).val()) || 0;
            const price = parseFloat($(this).data('price'));
            const simbolo = $(this).data('simbolo');
            const total = cantidad * price;
            const id = $(this).data('id');
            $(`.total[data-id="${id}"]`).text(`${simbolo} ` + `${total.toFixed(2)}`);
        });

        $('.data_table_multiple').on('click', '.btn-agregar-articulo', function(e) {
            var $btn = $(this);
            var $row = $(this).closest('tr');

            var stock = $row.find("td:eq(3)").text();
            var cantidad = $row.find('input').val();

            if (parseFloat(cantidad) > parseFloat(stock)) {
                toastr.warning("Cantidad mayor al stock", '', { timeOut: 3000 });
                return;
            }

            var id =  $(this).data('id');
            var cod_prod = $(this).data('cod_producto');
            var cod_origi = $(this).data('cod_original');
            var nombres =$(this).data('nombre');

            articulosAgregados.add(String(id));

            var concat_data = id + " | " + cod_prod + " | " + cod_origi + " | " + nombres;
            const newOption = new Option(concat_data, concat_data, true, true);

            var $primerSelect = $('#articulo');
            var existePrimerSelect = $primerSelect.length > 0;
            var valorPrimerSelect = existePrimerSelect ? $primerSelect.val() : null;

            if (!existePrimerSelect || valorPrimerSelect == null || valorPrimerSelect == "") {
                // Busca todos los selects existentes (incluyendo #articulo si existe)
                var $selectsExistentes = $('select[id^="articulo"]');

                if ($selectsExistentes.length === 0) {
                    // No queda NINGÚN select en el formulario: crear uno desde cero
                    $('.addmore').prop('disabled', false).click();
                    $selectsExistentes = $('select[id^="articulo"]');
                }

                var $selectDestino = $selectsExistentes.last();
                var idAttr = $selectDestino.attr('id');
                var count_artc = idAttr === 'articulo' ? 0 : parseInt(idAttr.replace('articulo', ''));
                var valorDestino = $selectDestino.val();

                if (valorDestino != null && valorDestino != "") {
                    // El último select ya tiene algo: crea uno nuevo
                    $('.addmore').prop('disabled', false).click();
                    $selectsExistentes = $('select[id^="articulo"]');
                    $selectDestino = $selectsExistentes.last();
                    idAttr = $selectDestino.attr('id');
                    count_artc = idAttr === 'articulo' ? 0 : parseInt(idAttr.replace('articulo', ''));
                }

                $selectDestino.append(newOption).trigger('change');

                let debounceTimer;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    $(`#cantidad${count_artc}`).val(cantidad);
                    multi(count_artc);
                }, 1000);

            } else {
                var $selectsNumerados = $('select[id^="articulo"]').not('#articulo');
                var count_artc = $selectsNumerados.length > 0
                    ? Math.max(...$selectsNumerados.map(function () {
                        return parseInt($(this).attr('id').replace('articulo', ''));
                    }).get())
                    : null;
                var $ultimoSelect = count_artc === null ? $('#articulo') : $(`#articulo${count_artc}`);
                var valorActual = $ultimoSelect.val();
                if (valorActual != null && valorActual != "") {
                    $('.addmore').prop('disabled', false).click();
                    // Recalcular tras crear la fila
                    $selectsNumerados = $('select[id^="articulo"]').not('#articulo');
                    count_artc = Math.max(...$selectsNumerados.map(function () {
                        return parseInt($(this).attr('id').replace('articulo', ''));
                    }).get());
                    $ultimoSelect = $(`#articulo${count_artc}`);
                }

                $ultimoSelect.append(newOption).trigger('change');

                let debounceTimer;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    $(`#cantidad${count_artc}`).val(cantidad);
                    multi(count_artc);
                }, 1000);
            }
            $btn.prop('disabled', true);

            toastr.info("Se agregó el Articulo correctamente", '', { timeOut: 3000 });
        });

        $('#total_final').on('input change', function(){
            var total = $(this).val();
            $('#subtotal-monto').html(total);
        });
        
        setInterval(function () {
            $('.codigo-toggle').each(function () {
                const $el = $(this);
                const showing = $el.data('showing');

                if (showing === 'producto') {
                    $el.fadeOut(150, function () {
                        $el.html(`<span class="badge badge-info">${$el.data('original')}</span>`).fadeIn(150);
                    });
                    $el.data('showing', 'original');
                } else {
                    $el.fadeOut(150, function () {
                        $el.html(`<span class="badge badge-info">${$el.data('producto')}</span>`).fadeIn(150);
                    });
                    $el.data('showing', 'producto');
                }
            });
        }, 5000); // cambia cada 2 segundos

        function activarSliderSiDesborda() {
            setTimeout(function () {
                $('.articulo-nombre').each(function () {
                    const el = this; // elemento DOM nativo, no jQuery

                    if (el.scrollWidth > el.clientWidth) {
                        $(el).addClass('is-overflowing');
                    } else {
                        $(el).removeClass('is-overflowing');
                    }
                });
            }, 50);
            setTimeout(function () {
                $('.small-description').each(function () {
                    const el = this; // elemento DOM nativo, no jQuery
                    if (el.scrollWidth > el.clientWidth) {
                        $(el).addClass('is-overflowing');
                    } else {
                        $(el).removeClass('is-overflowing');
                    }
                });
            }, 30);
        }
        $('#add_product_data').on('shown.bs.modal', function () {
            activarSliderSiDesborda();
        });

        $('#button_filter_stock').on('click', function(){
            const $btn = $(this);
            filtrarConStock = !$btn.hasClass('active');
            search_multiple($('#buscador_articulo').val());
        });
        function reactivarBotonModal(id) {
            var $btn = $(`.btn-agregar-articulo[data-id="${id}"]`);
            console.log($btn);
            if ($btn.length) {
                $btn.prop('disabled', false);
            }
        }
        function validarJson(data) {
            try {
                JSON.parse(data);
                return true; // es JSON válido
            } catch (e) {
                return false; // no es JSON
            }
        }
    </script>
    <script>
        function toggleBtnsCotizacion() {
            const slider = document.getElementById('btn-slider-cotizacion');
            const arrow = document.getElementById('btn-arrow-cotizacion');
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
@endsection
