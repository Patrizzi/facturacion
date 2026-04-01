@extends('layout')
@section('title', 'Cotizacion Manual')
@section('breadcrumb', 'Cotizacion Manual')
@section('breadcrumb2', 'Cotizacion Manual')
@section('href_accion', route('cotizacion_manual.index'))
@section('value_accion', 'Inicio')

@section('button2', 'Nueva Cotización')
@section('config', route('cotizacion_manual.create'))

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title d-flex justify-content-between" style="padding-right: 3.1%">
            <div style="margin-top: 5px;margin-bottom: 8px; margin-left: 10px">
                <a href="{{ route('cotizacion_manual.create') }}">
                    <i class="fa fa-arrow-left text-muted"></i>
                </a>
            </div>
            <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px; margin-right: 10px">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up text-muted"></i>
                </a>
                <a class="" href="{{ route('ventas.cotizacion_manual') }}">
                    <i class="fa fa-times text-muted"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content" style="padding-right: 3.1%; padding-left: 3.1%; padding-bottom: 10px;">
            <div class="row align-items-center tooltip-demo">
                <div class="col-12 col-md-3">
                    <h3 style="margin: 0;">{{ $cotizacion->cod_cotizacion }}</h3>
                    <strong style="margin: 0;">R.U.C : </strong>{{ $empresa->ruc }}
                </div>

                <div class="col-12 col-md-4 text-center">
                    <h2 class="mb-0 text-nowrap" style="margin-left: 200px;">
                        COTIZACIÓN
                    </h2>
                </div>

                <div class="col-12 col-md-5 d-flex flex-wrap justify-content-end align-items-center" style="gap: 4px;">
                    <div class="d-flex align-items-center" style="overflow: hidden;">
                        <div id="btn-slider-cotizacion-manual"
                            style="width: 0; overflow: hidden; transition: width 0.3s ease; display: flex; align-items: center;">
                            @if ($cotizacion->tipo == 'factura' && $cotizacion->estado == 0)
                                <a class="btn btn-success"
                                href="{{ route('cotizacion_manual.facturar', $cotizacion->id) }}"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                data-original-title="Facturar"
                                style="white-space: nowrap; margin-right: 4px;">
                                    <i class="fa fa-file-text-o fa-lg"></i>
                                </a>
                                <input type="hidden" name="tipo_coti" id="tipo_coti" value="1">
                            @endif

                            @if ($cotizacion->tipo == 'factura' && $cotizacion->estado == 1)
                                <a class="btn btn-default procesado"
                                style="color: inherit !important; transition: 1s; white-space: nowrap; margin-right: 4px;"
                                href="{{ route('facturacion_manual.show', $factura->id) }}"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                data-original-title="Ver Factura">
                                    <i class="fa fa-file-text-o fa-lg"></i>
                                </a>
                            @endif

                            @if($cotizacion->tipo == 'boleta' && $cotizacion->estado == 0)
                                <a class="btn btn-success"
                                href="{{ route('cotizacion_manual.boletear', $cotizacion->id) }}"
                                target="_blank"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                data-original-title="Boletear"
                                style="white-space: nowrap; margin-right: 4px;">
                                    <i class="fa fa-file-text-o fa-lg"></i>
                                </a>
                                <input type="hidden" name="tipo_coti" id="tipo_coti" value="0">
                            @endif

                            @if($cotizacion->tipo == 'boleta' && $cotizacion->estado == 1)
                                <a class="btn btn-default procesado"
                                style="color: inherit !important; transition: 1s; white-space: nowrap; margin-right: 4px;"
                                href="{{ route('boleta_manual.show', $boleta->id) }}"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                data-original-title="Ver Boleta">
                                    <i class="fa fa-file-text-o fa-lg"></i>
                                </a>
                            @endif

                            @if($cotizacion->tipo == 'nota_venta' && $cotizacion->estado == 0)
                                <a class="btn btn-success"
                                href="{{ route('cotizacion_manual.gen_nota_venta', $cotizacion->id) }}"
                                target="_blank"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                data-original-title="Generar Nota de Venta"
                                style="white-space: nowrap; margin-right: 4px;">
                                    <i class="fa fa-file-text-o fa-lg"></i>
                                </a>
                                <input type="hidden" name="tipo_coti" id="tipo_coti" value="3">
                            @endif

                            @if($cotizacion->tipo == 'nota_venta' && $cotizacion->estado == 1)
                                <a class="btn btn-default procesado"
                                style="color: inherit !important; transition: 1s; white-space: nowrap; margin-right: 4px;"
                                href="{{ route('nota_venta.show', $nota_venta->id) }}"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                data-original-title="Ver Nota de Venta">
                                    <i class="fa fa-file-text-o fa-lg"></i>
                                </a>
                            @endif
                        </div>

                        <button type="button"
                                id="btn-toggle-cotizacion-manual"
                                onclick="toggleBtnsCotizacionManual()"
                                class="btn btn-default"
                                style="background: #fff; border: 1px solid #ccc; padding: 5px 8px; transition: transform 0.3s;">
                            <i class="fa fa-chevron-left" id="btn-arrow-cotizacion-manual"></i>
                        </button>
                    </div>

                    <div style="width: 1px; height: 30px; background-color: #ccc; margin: 0 6px;"></div>

                    <a href="{{ route('cotizacion_manual.free_print', $cotizacion->id) }}"
                    class="btn btn-secondary"
                    target="_blank"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    data-original-title="Impresión Libre">
                        <i class="fa fa-share-alt"></i>
                    </a>

                    <form class="btn" style="padding: 0;" action="{{ route('cotizacion_manual_pdf', $cotizacion->id) }}">
                        @csrf
                        <input type="text" name="name" maxlength="50" hidden value="CotizacionManual_{{ $cotizacion->tipo }}">
                        <button type="submit"
                                class="btn btn-success"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                data-original-title="Descargar PDF">
                            <i class="fa fa-file-pdf-o fa-lg"></i>
                        </button>
                    </form>

                    <a class="btn btn-success"
                    href="{{ route('cotizacion_manual.print', $cotizacion->id) }}"
                    target="_blank"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    data-original-title="Imprimir">
                        <i class="fa fa-print fa-lg"></i>
                    </a>

                    @if(Auth::user()->email_creado == 1)
                        <form action="{{ route('email.cotizacion_manual', $cotizacion->id) }}" method="post" style="padding: 0;" class="btn">
                            @csrf
                            <button type="submit"
                                    class="btn btn-secondary"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    formtarget="_blank"
                                    data-original-title="Enviar por correo">
                                <i class="fa fa-envelope fa-lg"></i>
                            </button>
                        </form>
                    @endif

                    <div style="position: relative; display: inline-block;">
                        <div id="auto" onclick="divAuto()">
                            <a class="btn btn-success"
                            style="background: green; border-color: green;"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            data-original-title="Enviar a">
                                <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                            </a>
                        </div>
                    </div>
                    @if($cotizacion->estado_vigente == 0 && $cotizacion->estado == 0)
                        <button type="button"
                                class="btn btn-warning btn-editar"
                                id="edit"
                                onclick="click_editar()"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                data-original-title="Editar cotización manual"
                                style="white-space: nowrap; margin-right: 4px;">
                            <i class="fa fa-pencil"></i>
                        </button>

                        <button type="button"
                                class="btn-no-editar no_mostrar btn btn-warning"
                                onclick="click_cancelar_editar()"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                data-original-title="Cancelar edición"
                                style="white-space: nowrap; margin-right: 4px;">
                            <i class="fa fa-times"></i>
                        </button>
                    @endif
                </div>

                <div id="div-mostrar" style="height: 0px; overflow: hidden; width: 100%; transition: height .4s; margin-right: 17px;">
                    <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="btn" style="text-align: none; padding-right: 0; padding-left: 0;">
                        @csrf
                        <input type="tel" name="numero" value="{{ $cotizacion->cliente->celular }}" />
                        <input type="text" name="mensaje" id="texto_orden" hidden />
                        <input type="text" hidden name="url" value="{{ route('cotizacion_manual_pdf', $cotizacion->id) }}?archivo=">
                        <input type="text" name="name_sin_cambio" hidden value="Cotizacion_{{ $cotizacion->tipo }}" />
                        <button type="submit"
                                class="btn btn-success"
                                style="background: green; border-color: green;"
                                formtarget="_blank"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                data-original-title="Enviar por Whatsapp">
                            <i class="fa fa-send fa-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: -26px;">
            <div class="ibox-content p-xl" style="margin-bottom: 20px;padding-bottom: 50px;">
                <br>
                <div class="table-no mostrar">
                    <div class="row" align="center" style="padding-bottom: 5px">
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <h3>Contacto Cliente</h3>
                                <div align="left">
                                    <strong>Señor(es):</strong> &nbsp;{{$cotizacion->cliente->nombre}}<br>
                                    <strong>{{$cotizacion->cliente->documento_identificacion}} :</strong> &nbsp;{{$cotizacion->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Fecha:</strong> &nbsp;{{$cotizacion->updated_at}}<br>
                                    <strong>Dirección:</strong>&nbsp; {{$cotizacion->cliente->direccion}}<br>
                                    <strong>Teléfono:</strong>&nbsp; {{$cotizacion->cliente->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Celular:</strong>&nbsp; {{$cotizacion->cliente->celular}}<br>
                                    {{-- DATOS DE RENOVACIÓN --}}
                                    @if($renovacion && $fecha_vencimiento)
                                        <strong>F. Vencimiento:</strong>&nbsp;{{ $fecha_vencimiento->format('d-m-Y') }}&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Días restantes:</strong>&nbsp;{{ $dias_restantes_texto }}<br>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" align="center">
                        <div class="form-control" >
                                <h3>Condiciones Generales</h3>
                                <div align="left">
                                    <strong>Forma De Pago:</strong> &nbsp;{{$cotizacion->forma_pago->nombre }}<br>
                                    <strong>Validez :</strong> &nbsp;{{$cotizacion->validez}}<br>
                                    <strong>Garantía:</strong> &nbsp;{{$cotizacion->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <strong>Tipo de Moneda:</strong> &nbsp;{{$cotizacion->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="almacen" id="almacen_id" class="form-control " value="{{$cotizacion->almacen_id}}" readonly="readonly">
                        <input type="hidden" id="moneda_id" class="form-control " value="{{$cotizacion->moneda_id}}" readonly="readonly">
                        <div class="col-sm-12" align="center">
                            <div class="form-control" style="border: none;height: auto" >
                                <div align="left">
                                    <strong>Observaciones:</strong> &nbsp;{{$cotizacion->observacion }}<br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <br>
        <div class="mostrar table-no">
            <div class="table-responsive">
                <table class="table " >
                    <thead>
                        <tr >
                            <th style="width: 5% !important">ITEM </th>
                            <th style="width: 10">Código</th>
                            <th style="width: 51%;text-align: left">Descripción</th>
                            <th tyle="width: 10%; text-align: center">Cantidad</th>
                            <th style="width: 12%; text-align: right">P. Unitario</th>
                            <th style="width: 12%;text-align: right">P. Total </span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cotizacion_m_reg as $cotizacion_m_regs)
                        <tr>
                            <td>{{$j++}} </td>
                            @if(isset($cotizacion_m_regs->producto->codigo_producto))
                                <td>
                                    {{$cotizacion_m_regs->producto->codigo_producto}}
                                </td>
                                <td>
                                    {{$cotizacion_m_regs->producto->nombre}} @if(isset($cotizacion_m_regs->descripcion_item)) | {{$cotizacion_m_regs->descripcion_item}} @else @endif </span>
                                </td>
                            @else
                                <td>
                                    {{$cotizacion_m_regs->servicio->codigo_servicio}}
                                </td>
                                <td>
                                    {{$cotizacion_m_regs->servicio->nombre}} @if(isset($cotizacion_m_regs->descripcion_item)) | {{$cotizacion_m_regs->descripcion_item}} @else @endif </span>
                                </td>
                            @endif
                            <td >{{$cotizacion_m_regs->cantidad}}</td>
                            <td style="text-align: right">{{round($cotizacion_m_regs->precio ,8) }}</td>
                            <td style="text-align: right">{{round($cotizacion_m_regs->cantidad*$cotizacion_m_regs->precio ,8)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <?php
                $simbologia = $cotizacion->moneda->simbolo;
                $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
                $igv = $cotizacion->op_gravada *($igv_t->igv_total / 100);
                $end = $sub_total + $igv;
            ?>
            <div class="row" style="padding-top: 120px">
                <div class="col-sm-8">
                    <h3 align="left">
                        <?php use Luecano\NumeroALetras\NumeroALetras;
                            $v=new NumeroALetras() ;
                            $letra=($v->toInvoice($end, 2));
                        // $end_final_point=strstr($end2, '.', false);
                        // $end_final=str_replace('.', '',$end_final_point);
                        ?>
                        Son : {{ucfirst( mb_strtolower($letra,'UTF-8') )}} {{$cotizacion->moneda->nombre }}
                    </h3>
                </div>
                <div class="col-sm-4 form-control ">
                        <span style="display: block;float: left"> Subtotal:</span>
                        <span style="display: block;float: right;"> {{$simbologia}} {{number_format(round($sub_total,2),2)}}</span><br>
                        <span style="display: block;float: left"> Op. Gravada: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{number_format(round($cotizacion->op_gravada,2), 2)}}</span><br>
                        <span style="display: block;float: left"> Op. Inafecta: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{ number_format(round($cotizacion->op_inafecta,2), 2)}}</span><br>
                        <span style="display: block;float: left"> Op. Exonerada: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{number_format(round($cotizacion->op_exonerada,2), 2)}} </span><br>
                        <span style="display: block;float: left"> I.G.V.: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{number_format(round($igv,2) ,2)}}</span><br>
                        <span style="display: block;float: left"> Importe Total: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{number_format(round($end,2),2)}}</span>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
        <span hidden>{{$h = 0 }} {{$igv_1 =  1 + ($igv_t->igv_total/100)}}</span>
        <div class="div-editar no_mostrar">
        @if($cotizacion->estado == 0)
                @include('transaccion.venta.cotizacion.manual.edit')
        @endif
        </div>

        <!-- /table-responsive -->

<br>
<!-- Fin Totales de Productos -->
@include('layout_bancos')
        <br>
        @include('layout_firma_pie_hoja')
    </div>
</div>
</div>
</div>
{{--  --}}
{{-- Modal Configuracion --}}
{{-- <div class="modal fade" id="config" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{route('email.config')}}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <fieldset >
                                <legend> Agregar Configuracion </legend>
                                    <div class="panel-body" align="left">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Email:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" name="email" style="height: 75%;border-radius: 2px ">
                                            </div>

                                            <label class="col-sm-2 col-form-label">Contraseña:</label>
                                            <div class="col-sm-10">
                                                <div class="input-group m-b">
                                                    <input type="password" class="form-control" name="password" id="txtPassword" required="" style="height: 35.2px;border-radius: 2px ">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon" style="height: 35.22222px;margin-top: 5px;">
                                                            <i class="fa fa-eye-slash " id="ojo" onclick="mostrarPassword()"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">SMPT:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="smtp" placeholder="smtp.gmail.com" required="" style="border-radius: 2px">
                                            </div>

                                            <label class="col-sm-2 col-form-label">PORT:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="port" value="110 " style="border-radius: 2px">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Encryption:</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="encryp" required="" style="height: 85%;border-radius: 2px;padding-top: 4px">
                                                    <option value="">Ninguno</option>
                                                    <option value="SSL">SSL</option>
                                                    <option value="TLS">TLS</option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Firma (opcional):</label>
                                            <div class="col-sm-10">
                                                <input type="file" id="archivoInput" name="firma" onchange="return validarExt()" style="border-radius: 2px" />
                                                <span id="visorArchivo">
                                                    <!--Aqui se desplegará el fichero-->
                                                    <img name="firma"  src="" width="390px" height="200px" />
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Ancho(px)</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="ancho_firma">
                                                </div>
                                            <label class="col-sm-2 col-form-label" >Alto(px)</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="alto_firma">
                                                </div>
                                        </div>
                                        <br>
                                    </div>
                                </fieldset>
                            </div>
                            <button class="btn btn-primary" type="submit">Grabar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
{{-- Fin de modal configuracion --}}

<style>
    .input_small > div {
        margin-top: 2px ;
        margin-bottom: 2px ;
    }
    .input_small > div > input {
        padding: 5px 10px;
    }
    .input_small > div > select{
        padding: 5px 10px;
    }
    #auto{
        cursor: pointer;
        box-shadow: 0px 0px 1px #000;
        display: inline-block;
    }
    #auto:hover{
        opacity: .8;
    }
    #div-mostrar{
        margin: auto;
        height: 0px;
        transition: height .4s;
        color:white;
        text-align: right;
    }
    #auto:hover{
        opacity: .8;
    }
    #auto:hover + #div-mostrar{
        height: 50px;
    }
    /* .form-control{margin-top: 5px; border-radius: 5px} */
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
    /* .form-control{border-radius: 10px; padding: 10px } */
    .ibox-tools a{color: white !important}
    .a{height: 37px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 12px;
    }
    .select2-container--default .select2-selection--single {
        border: none;
    }
    span.select2.select2-container.select2-container--default{
        width: 100%!important;
        background-color: #FFFFFF;
        background-image: none;
        border-radius: 1px;
        display: block;
        padding: 3px 12px;
        border: 1px solid #e5e6e7;
    }
    .limp{
        width: 90px;
    }
    .limp_txt{
        width: 100%;
    }
    .mostrar{
        display: initial;
    }
    .no_mostrar{
        display: none;
    }
    .select2-hidden-accessible{
        width: 0px;
        margin: 0px;
        width: auto;
    }
    .table-responsive{
        /* display: inline-table; */
    }

    //Estilos nuevos para la seccion de renovacion
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
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    input:checked + .slider {
        background-color: #1ab394;
    }

    input:focus + .slider {
        box-shadow: 0 0 2px #1ab394;
    }

    input:checked + .slider:before {
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

    .form-control-sm {
        height: 34px;
        padding: 0.375rem 0.75rem;
        font-size: 13px;
        line-height: 1.5;
        border-radius: 1px;
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
    .row_articulo{
        width: 45% !important;
        max-width: 45% !important;
    }
    </style>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<!-- Sweet alert -->
<link href="{{ asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>

<script>

    $('.demo3').click(function (e) {
        if(document.forms['coti_man_update'].reportValidity()){
            swal({
                title: "¿Estas seguro que deseas Finalizar?",
                text: "Una vez Finalizado, no podras modificar Cotizacion Manual",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3686ff",
                confirmButtonText: "Si, Finalizar",
                cancelButtonText: "Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        swal("Edicion de Cotizacion Manual Finalizada", "Ya no podrás editar", "success");
                        $('.finalizar').click();
                        $('.guardar').attr('disabled', true);
                    } else {
                        swal("Cancelado", "Cancelado la Finalizar", "error");
                    }
            });
        }else{
            console.log("campos incompletos")
        }
    });

    $(document).ready(function (){
        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 8000 });
    });

    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    function mostrarMensaje(mensaje){
       $("#divmsg").empty(); //limpiar div
       $("#divmsg").append(mensaje);
       $("#divmsg").show(200);
    }
    // {{-- Darle valor a cada Boton si es Finalizar o solo Guardar --}}
    $(".guardar").on('submit', function (e) {
        $(".demo3").attr('disabled', true);
        var data = `<input value="1" type='hidden' name='submit' class="form-control" required/>  <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
        $('#inp_s').append(data);

    });
    $(".finalizar").on('click', function (e ) {
        var data = `<input value="2" type='hidden' name='submit' class="form-control" required/>   <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
        $('#inp_s').append(data);
        // $(".guardar").remove();
    });
    function click_editar(){
        // MOSTRAR LOS INPUTS
        $('.div-editar').removeClass('no_mostrar');
        $('.div-editar').addClass('mostrar');
        // OCULTAR TABLA
        $('.table-no').addClass('no_mostrar');
        // BOTONES
        $('.btn-no-editar').removeClass('no_mostrar');
        $('.btn-editar').addClass('no_mostrar');
    }
    function click_cancelar_editar(){
        // OCULTAR INPUTS
        $('.div-editar').removeClass('mostrar');
        $('.div-editar').addClass('no_mostrar');
        // MOSTRAR TABLA
        $('.table-no').removeClass('no_mostrar');
        $('.table-no').addClass('mostrar');

        $('.btn-editar').removeClass('no_mostrar');
        $('.btn-no-editar').addClass('no_mostrar');
    }
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function toggle(){
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    }
</script>

@include('transaccion.venta.cotizacion.manual._shared._edit_script')

{{-- script para manejar las renovaciones --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkRenovacion      = document.getElementById("estado_renovacion");
        const contenedorRenovacion = document.getElementById("renovacion_container");
        const inputVencimiento     = document.getElementById("fecha_vencimiento");
        const diasPreview          = document.getElementById("dias_restantes_preview");

        // ── Preview días restantes ────────────────────────────────
        function mostrarDiasRestantes() {
            if (!inputVencimiento.value) {
                diasPreview.textContent = "";
                return;
            }

            const hoy         = new Date();
            hoy.setHours(0, 0, 0, 0);
            const vencimiento = new Date(inputVencimiento.value + 'T00:00:00');
            const diff        = Math.round((vencimiento - hoy) / (1000 * 60 * 60 * 24));

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

        checkRenovacion.addEventListener("change", function () {
            contenedorRenovacion.style.display = this.checked ? "block" : "none";
            if (!this.checked) {
                inputVencimiento.value  = "";
                diasPreview.textContent = "";
            }
            // Al activar, NO tocar el min — ya viene seteado desde Blade
        });

        inputVencimiento.addEventListener("change", function () {
            // Quitar la línea que pisaba el min con hoy
            mostrarDiasRestantes();
        });
    });
</script>
<script>
    function toggleBtnsCotizacionManual() {
        const slider = document.getElementById('btn-slider-cotizacion-manual');
        const arrow = document.getElementById('btn-arrow-cotizacion-manual');
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
