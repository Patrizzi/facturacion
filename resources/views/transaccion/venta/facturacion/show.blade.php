
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
            <div class="ibox-title" style="padding-right: 3.1%"">
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a href="{{ route('comprobantes.index_factura') }}" title="Cerrar">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="padding-right: 3.1%;padding-left: 3.1%; padding-bottom: 10px;">
                <div class="row tooltip-demo">
                    <div class="col-sm-6 col_btn" style="text-align: left ">
                        <?php use Carbon\Carbon;
                        use App\Facturacion; ?>
                        @if ($facturacion->f_electronica == 0 && $facturacion->created_at->diffInDays(Carbon::now()) > 7)
                            <span data-toggle="tooltip" data-placement="bottom" title=""
                                data-original-title="Anular La Factura"
                                style="display: inline-flex;animation: circleScale 3s infinite;">
                                <button class="btn btn-danger btn-circle" data-toggle="modal" data-target="#modal_anular"><i
                                        class="fa fa-ban fa-xl"></i></button>
                            </span>
                        @endif
                        @if ($facturacion->nota_credito != 0)
                            <span data-toggle="tooltip" data-placement="bottom" title=""
                                data-original-title="Motivo: {{ Facturacion::search_motivo_nc($facturacion->id) }}">
                                <a class="btn btn-primary"
                                    href="{{ route('nota-credito.show', Facturacion::nota_credito_id($facturacion->id)) }}">Ver
                                    nota de Crédito</a>
                            </span>
                        @endif
                    </div>
                    <div class="col-sm-6" align="right">
                        <form class="btn" style="text-align: none;padding: 0 0 0 0"
                            action="{{ route('pdf_fac', $facturacion->id) }}">
                            <input type="text" name="name" maxlength="50" hidden=""
                                value="{{ $facturacion->codigo_fac }}">
                            <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom"
                                title="" data-original-title="Descargar PDF"><i class="fa fa-file-pdf-o fa-lg"></i>
                            </button>
                        </form>
                        {{-- <button id="btn_ticket" class="btn btn-info"><i class="fa fa-ticket fa-lg"></i></button> --}}
                        <a href="{{ route('facturacion.ticket', $facturacion->id) }}" class="btn btn-info" target="_blank"><i
                                class="fa fa-ticket fa-lg"></i></a>
                        <input type="text" value="{{ $facturacion->id }}" name="id" id="id" hidden="">
                        <a class="btn btn-success" href="{{ route('facturacion.print', $facturacion->id) }}" target="_blank"
                            class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title=""
                            data-original-title="Imprimir"><i class="fa fa-print fa-lg"></i></a>
                        @if (Auth::user()->email_creado == 1)
                            <form action="{{ route('email.factura', $facturacion->id) }}" method="post"
                                style="text-align: none;padding-right: 0;padding-left: 0;" class="btn">
                                @csrf
                                <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom"
                                    title="" formtarget="_blank" data-original-title="Enviar por correo">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </button>
                            </form>
                        @endif
                        <div id="auto" onclick="divAuto()">
                            <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip"
                                data-placement="bottom" title="" data-original-title="Enviar a"><i
                                    class="fa fa-whatsapp fa-lg" style="color: white"></i> </a>
                        </div>
                        @if ($facturacion->estado == 0)
                            <button class="btn btn-warning btn-editar" id="edit" onclick="click_editar()"><i
                                    class="fa fa-pencil"></i></button>
                            <button class="btn-no-editar no_mostrar btn btn-warning" onclick="click_cancelar_editar()"><i
                                    class="fa fa-times"></i></button>
                        @endif
                        <div id="div-mostrar" style="height: 0px; overflow: hidden;">
                            <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="btn"
                                style="text-align: none;padding-right: 0;padding-left: 0;">
                                @csrf
                                <input type="tel" name="numero" value="{{ $facturacion->cliente->celular }}" />
                                <input type="text" name="mensaje" id="texto_orden" hidden="" />
                                <input type="text" hidden="" name="url"
                                    value="{{ route('pdf_fac', $facturacion->id) }}?archivo=">
                                <input type="text" name="name_sin_cambio" hidden=""
                                    value="Facturacion_{{ $facturacion->codigo_fac }}" />
                                <button type="submit" class="btn  btn-success"
                                    style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip"
                                    data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i
                                        class="fa fa-send fa-lg"></i> </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="mostrar" id="show_factura">
            <div class="row">
                <div class="col-lg-12" style="margin-top: -26px;">
                    @if ($facturacion->f_electronica == 2 || $facturacion->nota_credito == 1)
                        <div id="watermark">
                            <p>Anulado</p>
                        </div>
                    @endif
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                        <div class="row" style="align-items: center; justify-content: center">
                            @include('layout_cabecera_ventas')
                            <div class="col-sm-4 ">
                                <div class="form-control ruc" style="height: 125px">
                                    <center>
                                        <h3 style="padding-top:10px ">R.U.C : {{ $empresa->ruc }}</h3>
                                        <h2>FACTURA ELECTRÓNICA</h2>
                                        <h5> {{ $facturacion->codigo_fac }}</h5>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <br>
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
                        <div class="table-responsive">
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
                                        <td>{{ $facturacion_registros->precio }}</td>
                                        <td>{{ $facturacion_registros->descuento }}%</td>
                                        <td>{{ $facturacion_registros->precio_unitario_desc }}</td>
                                        <td>{{ $facturacion_registros->comision }}%</td>
                                        <td>{{ $facturacion_registros->precio_unitario_comi }}</td>
                                        <td>{{ $facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad }}
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
                            <div class="col-sm-4 form-control">
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
                            </div>
                        </div>
                        <br>
                        {{-- {{$detraccion}} --}}
                        <div class="row">
                            @if ($detraccion == 'not')
                                <div class="col-sm-12 form-control" style="height:  100px">
                                    <strong>Observaciones:</strong><br>
                                    {{ $facturacion->observacion }}
                                </div>
                            @else
                                <div class="col-sm-6">
                                    <div class=" form-control" style="height: 100% !important">
                                        <strong>Información de Detracción:</strong><br>
                                        <strong>Tipo de Detracción:</strong>
                                        {{ $detraccion->tipo_detraccion->descripcion }} -
                                        {{ $detraccion->porcentaje_detraccion }} %<br>
                                        <strong>Medio de Pago:</strong>
                                        {{ $detraccion->medio_pago->descripcion }} <br>
                                        <strong>Monto de Detracción:</strong>
                                        S/. {{ number_format($detraccion->monto_detraccion, 2) }} <br>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-control" style="height: 100% !important">
                                        <strong>Observaciones:</strong><br>
                                        {{ $facturacion->observacion }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <br>
                        <!-- EXTENSION PARA LLAMAR AL LAYOUT DE BANCOS -->
                        @include('layout_bancos')
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="no_mostrar" id="edicion_factura">
            @if($facturacion->estado == 0)
                <div class="" >
                    @include('transaccion.venta.facturacion.edit')
                </div>
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
    <style type="text/css">
        .ruc {
            border-radius: 10px;
            height: 150px;
        }

        /* .form-control {
                            border-radius: 10px;
                        } */

        /* .a{height: 30px; margin:0;border-radius: 0px;text-align: center;} */
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

        .form-control {
            /* background-color: transparent !important; */
        }

        .col_btn {
            display: inline-block;
            font-weight: 400;
            white-space: nowrap;
            vertical-align: middle;
            padding: 0.375rem 0.75rem;
        }

        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1200px;
            }
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

        @keyframes circleScale {
            0% {
                transform: scale(0.8)
            }

            50% {
                transform: scale(1.25)
            }

            100% {
                transform: scale(0.8)
            }
        }

        .mostrar {
            display: ;
        }

        .no_mostrar {
            display: none;
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
            $('#edicion_factura').removeClass('no_mostrar');
            $('#edicion_factura').addClass('mostrar');
            // OCULTAR TABLA
            $('#show_factura').addClass('no_mostrar');
            // BOTONES
            $('.btn-no-editar').removeClass('no_mostrar');
            $('.btn-editar').addClass('no_mostrar');
        }

        function click_cancelar_editar() {
            // OCULTAR INPUTS
            $('#edicion_factura').removeClass('mostrar');
            $('#edicion_factura').addClass('no_mostrar');
            // MOSTRAR TABLA
            $('#show_factura').removeClass('no_mostrar');
            $('#show_factura').addClass('mostrar');

            $('.btn-editar').removeClass('no_mostrar');
            $('.btn-no-editar').addClass('no_mostrar');
        }
    </script>
    {{-- Para Editar Factura Sin Finalizar --}}
    @include('transaccion.venta.facturacion._shared._edit_script')
@endsection
