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
    <div class="ibox-title" style="padding-right: 3.1%;padding-left: 3.1%">
        <div class="row tooltip-demo">
             <div class="col-sm-6" align="left" style="padding: 0 15px;padding: 0 15px; margin: auto">
                @if ($cotizacion->tipo =='factura' &&  $cotizacion->estado == 0)
                    <a class="btn btn-success" href="{{route('cotizacion_manual.facturar',$cotizacion->id)}}">Facturar</a>
                    <input type="hidden" name="tipo_coti" id="tipo_coti" value="1">
                @endif
                @if ($cotizacion->tipo =='factura' &&  $cotizacion->estado == 1)
                    <a class="btn btn-default procesado" style="color: inherit !important; transition: 1s"  href="{{route('facturacion_manual.show',$factura->id)}}" >Ver Factura</a>
                @endif
                @if($cotizacion->tipo =='boleta' &&  $cotizacion->estado == 0)
                    <a class="btn btn-success" href="{{route('cotizacion_manual.boletear',$cotizacion->id)}}" target="_blank">Boletear</a>
                    <input type="hidden" name="tipo_coti" id="tipo_coti" value="0">
                @endif
                @if($cotizacion->tipo =='boleta' &&  $cotizacion->estado == 1)
                    <a class="btn btn-default procesado" style="color: inherit !important; transition: 1s"  href="{{route('boleta_manual.show',$boleta->id)}}" >Ver Boleta</a>
                @endif
                @if($cotizacion->tipo =='nota_venta' &&  $cotizacion->estado == 0)
                    <a class="btn btn-success" href="{{route('cotizacion_manual.gen_nota_venta',$cotizacion->id)}}" target="_blank">Generar Nota de V.</a>
                    <input type="hidden" name="tipo_coti" id="tipo_coti" value="3">
                @endif
                @if($cotizacion->tipo =='nota_venta' &&  $cotizacion->estado == 1)
                    <a class="btn btn-default procesado" style="color: inherit !important; transition: 1s"  href="{{route('nota_venta.show',$nota_venta->id)}}" >Ver Nota de V.</a>
                @endif


            </div>
            <div class="col-sm-6" align="right">
                <a href="{{route('cotizacion_manual.free_print', $cotizacion->id)}}" class="btn btn-secondary" target="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Impresion Libre"><i class="fa fa-share-alt"></i></a>
                <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('cotizacion_manual_pdf' ,$cotizacion->id)}}">@csrf
                    <input type="text" name="name" maxlength="50" hidden="" value="CotizacionManual_{{$cotizacion->tipo}}"  >
                    <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button>
                </form>
                <a class="btn btn-success" href="{{route('cotizacion_manual.print',$cotizacion->id)}}" target="_blank"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
                @if(Auth::user()->email_creado == 1)
                    <form action="{{ route('email.cotizacion_manual', $cotizacion->id )}}" method="post" style="text-align: none;padding: 0;" class="btn"  >
                        @csrf
                        <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=""  formtarget="_blank"  data-original-title="Enviar por correo">
                            <i class="fa fa-envelope fa-lg" ></i>
                        </button>
                    </form>
                @endif
                <div id="auto" onclick="divAuto()">
                    <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-whatsapp fa-lg" style="color: white"></i>  </a>
                </div>
                @if($cotizacion->estado_vigente == 0 && $cotizacion->estado == 0)
                    <button class="btn btn-warning btn-editar" id="edit" onclick="click_editar()"><i class="fa fa-pencil"></i></button>
                    <button class="btn-no-editar no_mostrar btn btn-warning" onclick="click_cancelar_editar()"><i class="fa fa-times"></i></button>
                @else

                @endif
                <div id="div-mostrar">
                    <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                         @csrf
                         <input type="tel" name="numero"  value="{{$cotizacion->cliente->celular}}"   />
                         <input type="text" name="mensaje" id="texto_orden" hidden="" />
                         <input type="text" hidden="" name="url" value="{{route('cotizacion_manual_pdf' ,$cotizacion->id)}}?archivo=">
                         <input type="text" name="name_sin_cambio" hidden="" value="Cotizacion_{{$cotizacion->tipo}}" />
                         <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
                     </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl" style="margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row" style="align-items: center; justify-content: center">
                    @include('layout_cabecera_ventas')
                    <div class="col-sm-4">
                        <div class="form-control" align="center" style="height: auto;">
                            <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">COTIZACIÓN ELECTRÓNICA</h2>
                            <h5>{{$cotizacion->cod_cotizacion}} </h5>
                        </div>
                    </div>
                </div><br>
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
                                    <strong>observaciones:</strong> &nbsp;{{$cotizacion->observacion }}<br>
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
                            <th>ITEM </th>
                            <th>Código </th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>P.Unitario</th>
                            <th>Total <span hidden="hidden">{{$simbologia=$cotizacion->moneda->simbolo}}</span></th>
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
                            <td>{{$cotizacion_m_regs->cantidad}}</td>
                            <td>{{number_format(round($cotizacion_m_regs->precio,2),2)}}</td>
                            <td>{{number_format(round($cotizacion_m_regs->cantidad*$cotizacion_m_regs->precio,2),2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                        <span style="display: block;float: right;"> {{$simbologia=$cotizacion->moneda->simbolo}} {{number_format($sub_total, 2)}}</span>
                        <br>
                        <span style="display: block;float: left"> Op. Gravada: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion->op_gravada,2)}}</span><br>
                        <span style="display: block;float: left"> Op. Inafecta: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{ number_format($cotizacion->op_inafecta,2)}}</span><br>
                        <span style="display: block;float: left"> Op. Exonerada: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion->op_exonerada,2)}} </span><br>
                        <span style="display: block;float: left"> I.G.V.: </span>
                        <span style="display: block;float: right">{{$cotizacion->moneda->simbolo}} {{number_format(round($igv, 2),2)}}</span><br>
                        <span style="display: block;float: left"> Importe Total: </span>
                        <span style="display: block;float: right">{{$cotizacion->moneda->simbolo}} {{number_format($end,2)}}</span>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
        <span hidden>{{$h = 0 }} {{$igv_1 =  1 + ($igv_t->igv_total/100)}}</span>
        <div class="div-editar no_mostrar">
            <form action="{{route('cotizacion_manual.update', $cotizacion->id)}}" method="post" id="coti_man_update">
                @csrf
                <div class="row">
                    <div class="col-sm-6" align="center">
                        <div class="form-control ">
                            <div class="row input_small">
                                <div class="col-sm-4">
                                    <strong>Señor(es)</strong>
                                </div>
                                <div class="col-sm-8">
                                <input type="hidden" name="" id="cliente_id" value="{{$cotizacion->cliente->id}}">
                                    <select class="select2_demo_client" name="cliente" id="cliente" required="" >
                                        <option selected value="{{$cotizacion->cliente->id}}">{{$cotizacion->cliente->nombre}} - {{$cotizacion->cliente->numero_documento}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <strong>Forma de Pago:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control" name="forma_pago" required="required">
                                        @foreach($forma_pagos as $forma_pago)
                                            <option value="{{$forma_pago->id}}" @if($cotizacion->forma_pago_id == $forma_pago->id) selected @endif>{{$forma_pago->nombre}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <strong>Garantía:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control" name="garantia">
                                        @foreach($garantia as $garantias)
                                            <option value="{{$garantias->descripcion}}" @if($cotizacion->garantia == $garantias->descripcion) selected @endif>{{$garantias->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center" style="padding-bottom: 15px">
                        <div class="form-control ">
                            <div class="row input_small">
                                <div class="col-sm-4">
                                    <strong>Validez:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <select  class="form-control" name="validez" required="required">
                                        @foreach($validez as $validezz)
                                            <option value="{{$validezz->descripcion}}" @if($cotizacion->validez == $validezz->descripcion) selected @endif>{{$validezz->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <strong>Tipo de Moneda:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <input class="form-control" readonly type="text" name="" id="" value="{{$cotizacion->moneda->nombre }}">
                                </div>
                                <div class="col-sm-4">
                                    <strong>Comisionista:</strong>
                                </div>
                                <div class="col-sm-8">
                                    @if(isset($cotizacion->comisionista->cod_vendedor))
                                        <input class="form-control" readonly type="text" id="" value="{{$cotizacion->comisionista->cod_vendedor}} - {{$cotizacion->comisionista->personal->personal_l->nombres}} - {{$cotizacion->comisionista->comision}}%">
                                    @else
                                        <input class="form-control" readonly type="text" id="" value="Sin Comisionista - 0">
                                    @endif
                                </div>

                                <!-- Sección de Renovación -->
                                <div class="col-sm-4" style="margin-top: 15px; display: flex; align-items: center; justify-content: flex-start; padding-right: 15px; padding-left: 55px;">
                                    <div class="switch-container">
                                        <strong>Renovación:</strong>
                                        <label class="switch">
                                            <input type="checkbox" id="estado_renovacion" name="estado_renovacion" value="1"
                                                {{ $cotizacion->estado_renovacion == 1 ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-8" style="margin-top: 15px;">
                                    <div id="renovacion_container" style="display: {{ $cotizacion->estado_renovacion == 1 ? 'block' : 'none' }};">
                                        <div class="row" style="margin: 0;">
                                            <div class="col-sm-6" style="padding-right: 5px; padding-left: 0;">
                                                <select class="form-control form-control-sm" name="select_fecha" id="select_fecha" autocomplete="off">
                                                    <option value="">Frecuencia</option>
                                                    <option value="Mensual" {{ $cotizacion->frecuencia_renovacion == 'Mensual' ? 'selected' : '' }}>Mensual</option>
                                                    <option value="Anual" {{ $cotizacion->frecuencia_renovacion == 'Anual' ? 'selected' : '' }}>Anual</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6" style="padding-left: 5px; padding-right: 0;" id="extra_selects"></div>
                                        </div>
                                        <!-- Inputs ocultos para guardar los valores -->
                                        <input type="hidden" name="dia_mensual" id="dia_mensual_hidden" value="{{ $cotizacion->dia_mensual ?? '' }}">
                                        <input type="hidden" name="dia_anual" id="dia_anual_hidden" value="{{ $cotizacion->dia_anual ?? '' }}">
                                        <input type="hidden" name="mes_anual" id="mes_anual_hidden" value="{{ $cotizacion->mes_anual ?? '' }}">
                                        <input type="hidden" name="anio_anual" id="anio_anual_hidden" value="{{ $cotizacion->anio_anual ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br style="padding-bottom: 5px">
                    <div class="col-sm-12">
                        <div class="form-control">
                            <strong>Observaciones</strong>
                            <textarea class="form-control" name="observacion" id="">{{$cotizacion->observacion }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table tables" id="inp_s" >
                        <thead>
                            <tr>
                                <th><button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;</th>
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>P. Sugerido</th>
                                <th>P. s/Igv</th>
                                <th>P. c/Igv</th>
                                <th>Total IGV</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cotizacion_m_reg as $cotizacion_m_regs)
                                <tr>
                                    <td>
                                        <button class="btn btn-danger delete borrar e"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td>
                                        <input type="hidden" name="elem_delete[]" value="{{$cotizacion_m_regs->id}}">
                                        <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="existente">
                                        <select class="select2_demo_3 select_change" required="" id="articulo{{$h}}" onchange="inputs_campos({{$h}}),ajax({{$h}})" autocomplete="off">
                                            @if(isset($cotizacion_m_regs->producto->id))
                                                <option value="{{$cotizacion_m_regs->producto->id}} | {{$cotizacion_m_regs->producto->codigo_producto}} | {{$cotizacion_m_regs->producto->codigo_original}} | {{$cotizacion_m_regs->producto->nombre}}">{{$cotizacion_m_regs->producto->id}} | {{$cotizacion_m_regs->producto->codigo_producto}} | {{$cotizacion_m_regs->producto->codigo_original}} | {{$cotizacion_m_regs->producto->nombre}}</option>
                                            @else
                                                <option value="{{$cotizacion_m_regs->servicio->id}} | {{$cotizacion_m_regs->servicio->codigo_servicio}} | {{$cotizacion_m_regs->servicio->codigo_original}} | {{$cotizacion_m_regs->servicio->nombre}}">{{$cotizacion_m_regs->servicio->id}} | {{$cotizacion_m_regs->servicio->codigo_servicio}} | {{$cotizacion_m_regs->servicio->codigo_original}} | {{$cotizacion_m_regs->servicio->nombre}}</option>
                                            @endif
                                        </select>
                                        <textarea type='text' id='descripcion0' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control txt-limp" autocomplete="off" style="margin-top: 5px;" >{{$cotizacion_m_regs->descripcion_item}}</textarea>
                                        <input hidden="hidden" class="celda" name="articulo[]" id="input_prod{{$h}}" >
                                    </td>
                                    <td>
                                        <input style="width: 76px" type='number' min="1" id='cantidad{{$h}}' name='cantidad[]' max="" class="cantidad monto0 form-control"  onkeyup="multi({{$h}})"  required  autocomplete="off" value="{{$cotizacion_m_regs->cantidad}}" />
                                    </td>
                                    <td>
                                        <input style="width: 76px" type='text' id='precio_oficial{{$h}}' name='precio_oficial[]' ondblclick="copy({{$h}})"  class="precio_oficial{{$h}} p_inp form-control inp" required readonly  data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)" />
                                    </td>
                                    <td>
                                        <input style="width: 76px" type='text' id='precio_s_igv{{$h}}' name='precio_s_igv[]'  class="precio_s_igv form-control" onkeyup="multi_s_igv({{$h}}),multi({{$h}})" required  autocomplete="off" value="{{$cotizacion_m_regs->precio}}" maxlength="15"/>
                                        <input hidden type='text' id='precio_s_igv_float{{$h}}' name='precio_s_igv_float'  class=" form-control precio_s_igv_float" onkeyup="multi_s_igv({{$h}}),multi({{$h}})" required  autocomplete="off" value="{{$cotizacion_m_regs->precio * $cotizacion_m_regs->cantidad}}" />
                                    </td>
                                    <td>

                                        <input style="width: 76px" type='text' id='precio_c_igv{{$h}}' name='precio_c_igv[]'  class="precio_c_igv monto0 form-control" onkeyup="multi_c_igv({{$h}}),multi({{$h}})" required  autocomplete="off" value="{{round($cotizacion_m_regs->precio * $igv_1 ,2)}}" maxlength="15" />
                                        <span hidden {{$p_igv = $cotizacion_m_regs->precio * $igv_1}}></span>
                                    </td>
                                    <td>
                                        <input style="width: 76px"  type='text' id='total{{$h}}' name='total' disabled="disabled" class="total form-control " required  autocomplete="off" value="{{round($cotizacion_m_regs->cantidad * $p_igv,2)}}"  />
                                    </td>

                                </tr>
                                <span hidden>{{$h++}}</span>
                            @endforeach
                        </tbody>
                        <tbody id="left_h3">
                            <input id='sub_total' hidden/></td>
                            <input id='total' hidden/></td>
                            <tr>
                                <td colspan="4"></td>
                                <td>Subtotal: </td>
                                <td colspan="2">
                                    <input type="text" id='subtotal' name="subtotal"  readonly="readonly" class="subtotal form-control" required value="{{round($sub_total,2)}}" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>Igv:</td>
                                <td colspan="2">
                                    <input type="text" id='igv' name="igv"  readonly="readonly" class="igv form-control" required value="{{round($igv, 2)}}" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>Total :</td>
                                <td colspan="2">
                                    <input type="text" id='total_final' name="total_final"  readonly="readonly" class="total_final form-control" required value="{{round($end,2)}}" />
                               </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="col-sm-12" align="right">
                    <button  data-style="zoom-out" class="guardar ladda-button btn btn-primary btn-outline" type="submit" >Guardar</button>
                    <button class="btn btn-primary  demo3 float-right" style="margin-left: 10px;" type="button"  >Guardar y Finalizar</button>
                    <button class="btn btn-secondary ladda-button finalizar " id="finalizar" hidden="" data-style="zoom-out" >
                    </button>
                </div>
            </form>
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
    .form-control{margin-top: 5px; border-radius: 5px}
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
    .form-control{border-radius: 10px; padding: 10px }
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

    .calendar-container {
        background: #fff;
        border-radius: 4px;
        padding: 8px;
        border: 1px solid #e5e6e7;
        margin-top: 6px;
        max-width: 260px;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        padding-bottom: 6px;
        border-bottom: 1px solid #e5e6e7;
    }

    .calendar-header h6 {
        font-size: 12px;
        font-weight: 600;
        color: #333;
        margin: 0;
        flex: 1;
        text-align: center;
    }

    .calendar-nav-btn {
        background: #fff;
        border: 1px solid #e5e6e7;
        border-radius: 3px;
        width: 26px;
        height: 26px;
        padding: 0;
        color: #676a6c;
        transition: all 0.2s;
        cursor: pointer;
    }

    .calendar-nav-btn:hover:not(:disabled) {
        background: #1ab394;
        color: white;
        border-color: #1ab394;
    }

    .calendar-nav-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .calendar-nav-btn i {
        font-size: 11px;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
    }

    .calendar-day-header {
        text-align: center;
        font-weight: 600;
        font-size: 10px;
        padding: 5px 0;
        color: #676a6c;
        background: #f8f9fa;
        border-radius: 2px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 2px;
        cursor: pointer;
        font-size: 10px;
        border: 1px solid transparent;
        transition: all 0.2s;
        color: #333;
        min-height: 24px;
        max-height: 26px;
    }

    .calendar-day.selectable {
        cursor: pointer;
        background: #fff;
    }

    .calendar-day.selectable:hover {
        background: #e8f4f8;
        border-color: #1c84c6;
    }

    .calendar-day.disabled {
        color: #ccc;
        cursor: not-allowed;
        background: #f9f9f9;
    }

    .calendar-day.selected {
        background: #1c84c6 !important;
        color: white !important;
        font-weight: 600;
        border-color: #1c84c6;
    }

    .calendar-day.fecha-emision {
        background: #1ab394 !important;
        color: white !important;
        font-weight: 600;
        border-color: #1ab394 !important;
    }

    .calendar-day.fecha-emision:hover {
        background: #18a689 !important;
        border-color: #18a689 !important;
    }

    .calendar-day.fecha-emision.selected {
        background: #1c84c6 !important;
        color: white !important;
        box-shadow: 0 0 0 2px #1ab394;
        border-color: #1c84c6 !important;
    }

    .renovacion .row {
        margin-bottom: 6px;
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
<script>
    //*Condicional para el tipo de factura
    var tipo_coti = $('#tipo_coti').val();
    var cliente_default = $('#cliente_id').val();
    $(".select2_demo_client").select2({
        placeholder: "Seleccionar Cliente",
        ajax: {
            minimumInputLength: 1,
            url: "{{ route('pa.clients') }}",
            dataType: 'json',
            type: "POST",
            delay: 10,
            data: function (params) {
                return {
                    _token: "{{ csrf_token() }}",
                    search: params.term, // search term
                    tipo_coti: tipo_coti,
                    select_default: cliente_default
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.nombre + ' | ' +  item.numero_documento,
                        };

                    })
                };
            },
            cache: true
        }

    });
    function divAuto(){
        var clic = 1;
       if(clic==1){
            document.getElementById("div-mostrar").style.height = "50px";
            clic = clic + 1;
       } else{
            document.getElementById("div-mostrar").style.height = "0px";
            clic = 1;
       }
    }
        //Llama predeterminada para el select articles (productos- servicios), se ejecuta al cargar la pagina
        var e = {{$h}};
        $(document).ready(function() {
            console.log("variable h: "+e);
            // var a
            for ( var a = 0; a < e ; a++) {
                prueba_ajax(a);
            }
            articlesSelect2();
        });
    function prueba_ajax(a){
        var articulo = document.getElementById(`articulo${a}`).value;
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
                success: function (msg2) {
                    $(`#precio_oficial${a}`).val(msg2.price);
                },
                error: function(eject) {
                    if(eject.status===400){
                        console.log(eject.responseJSON.error);
                    }
                },
                cache:true
            });
    }

    var i = {{$h}};
    $(".addmore").on('click', function () {
        console.log(i)
        var data = `[
        <tr>
            <td>
                <button type="button" class='delete borrar e btn btn-danger'>
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </td>";
            <td>
                <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="nuevo">
                <select class="select2_demo_3 select_change" id='articulo${i}' onchange="inputs_campos(${i}),ajax(${i})"  autocomplete="off" required></select>
                <textarea type='text' id='descripcion${i}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" autocomplete="off" style="margin-top: 5px;"></textarea>
                <input hidden="hidden"  class="celda"  name="articulo[]" id="input_prod${i}" >
            </td>
            <td>
                <input type='number' min='1' style="width: 76px"  id='cantidad${i}' name='cantidad[]' class="cantidad monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
            </td>
            <td class="full-height-scroll tooltip-demo">
                <input type='text' style="width: 76px"  id='precio_oficial${i}' name='precio_oficial[]' ondblclick="copy(${i})" class="precio_oficial${i} form-control inp" required  autocomplete="off" readonly data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)" />
            </td>
            <td>
                <input style="width: 76px" type='text' id='precio_s_igv${i}' name='precio_s_igv[]'  class="precio_s_igv monto${i} form-control" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off" />
                <input hidden type='text' id='precio_s_igv_float${i}' name='precio_s_igv_float'  class="form-control precio_s_igv_float" onkeyup="multi_s_igv(${i}),multi(${i})"   autocomplete="off" />
            </td>
            <td>
                <input style="width: 76px" type='text' id='precio_c_igv${i}' name='precio_c_igv[]'  class="precio_c_igv p_inp monto${i} form-control" onkeyup="multi_c_igv(${i}),multi(${i})" required  autocomplete="off" />
            </td>
            <td>
                <input type='text' id='total${i}'  style="width: 76px"  name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
            </td>
        </tr>
        `;
        $('.tables').append(data);
        i++;
        //Llamada para la ejecucion de articlesSelect (funcionamiento de los select nuevos creados)
        articlesSelect2();
        toggle();
        const section = document.getElementById("left_h3");
        console.log(section);
        section.scrollIntoView({block: "end", behavior: "smooth"});
    });

    //Funcion para el select articles "AJAX" (productos- servicios), ejecutandose cada vez realizada una llamada
    function articlesSelect2() {
        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Articulo",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.articles') }}",
                dataType: 'json',
                type: "POST",
                // delay: 1500,
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term, // search term
                        tipo_doc: 'manual'
                    };
                },
                processResults: function (data) {
                    //validador de articulos multiples
                    let data_length = data.length;
                    let articles_selected_ajax = document.getElementsByClassName("select2_demo_3");
                    let articles_selected_count_ajax = articles_selected_ajax.length;
                    // for(var z=0;z<articles_selected_count_ajax;z++){
                    //     var selected_ajax=document.getElementsByClassName("select2_demo_3 select_change")[z].value;
                    //     for(var y=0;y<data_length;y++){
                    //         if(selected_ajax == data[y].id+ " | " + data[y].codigo + " | " + data[y].codigo_original + " | " + data[y].nombre){
                    //             if(data[y].tipo == 'producto'){
                    //                 data[y].disabled=true;
                    //             }else{
                    //                 data[y].disabled=false;
                    //             }
                    //         }
                    //     }
                    // }
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id:  item.id + " | " + item.codigo + " | " + item.codigo_original + " | " + item.nombre,
                                text: item.id + " | " + item.codigo + " | " + item.codigo_original + " | " + item.nombre,
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
    function copy(a){
        if(a==0){
            var copy = document.getElementById(`precio_oficial0`).value;
            document.getElementById(`precio_s_igv0`).value = copy;
            multi_s_igv(0);
        }else{
            var copy = document.getElementById(`precio_oficial${a}`).value;
            document.getElementById(`precio_s_igv${a}`).value = copy;
            multi_s_igv(a);
        }
        multi(a);

    }
    function mostrarPassword(){
        var cambio = document.getElementById("txtPassword");
        if(cambio.type == "password"){
            cambio.type = "text";
            $('#ojo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }else{
            cambio.type = "password";
            $('#ojo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
    }
    function ajax(a){

        var articulo = document.getElementById(`articulo${a}`).value;
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
            success: function (msg) {
                if(msg.price == 0 && msg.amount == 0){
                    // $(`#precio${a}`).val(0);
                    $(`#cantidad${a}`).val(1);
                    // $(`#cantidad${a}`).attr('max', msg.amount );
                    // $(`#cantidad`).attr('max', msg.amount );
                    $(`#precio_oficial${a}`).val(msg.price)
                }else{
                    // $(`#precio${a}`).val(1);
                    $(`#precio_oficial${a}`).val(msg.price)
                    $(`#cantidad${a}`).val(1);
                    // $(`#cantidad${a}`).attr('max', msg.amount );
                    // $(`#cantidad`).attr('max', msg.amount );
                }
                multi(a);
                $(`.addmore`).prop("disabled", false);
            },
            error: function(eject) {
                if(eject.status===400){
                    console.log(eject.responseJSON.error);
                }
            },
            cache:true
        });
    }
    function multi(a){
        var total = 1;
        var totales=0;
        var change= false; //
        var multiplier = 100;
        $(`.monto${a}`).each(function(){
            if (!isNaN(parseFloat($(this).val()))) {
                change= true;
                total *= parseFloat($(this).val());
            }
        });
        total = (change)? total:0;
        var cantidad = document.querySelector(`#cantidad${a}`).value;
        //CALCULAR PRECIO SIN IGV
        var precio_sin = document.querySelector(`#precio_s_igv${a}`).value;
        var final_sin =precio_sin*cantidad;
        var final_decimal_sin = Math.round(final_sin * multiplier) / multiplier;


        document.getElementById(`precio_s_igv_float${a}`).value = final_decimal_sin;
        //CALCULAR PRECIO CON IGV
        var precio = document.querySelector(`#precio_c_igv${a}`).value;
        var final=precio*cantidad;
        // var final_decimal = Math.round(final * multiplier) / multiplier;
        //igv calculo
        var only_igv = final_sin + (parseFloat(final_sin) * (igv/multiplier))
        var igv_decimal = Math.round(only_igv * multiplier ) / multiplier;

        document.getElementById(`total${a}`).value = igv_decimal;



        // Operacion para subtotal sin igv
        var sub_igv = $('[name="precio_s_igv_float"]');
        var sub_igv_t = 0;
        sub_igv.each(function(){
            sub_igv_t += parseFloat($(this).val());
        });
        var sub_igv_tt = Math.round(sub_igv_t * multiplier) / multiplier;
        $('#sub_total').val(sub_igv_tt);
        document.getElementById("subtotal").value = sub_igv_tt;

        //OPERACION PARA CALULCAR EL IGV
        var only_igv = (parseFloat(sub_igv_tt) * (igv/multiplier))
        var igv_decimal = Math.round(only_igv * multiplier ) / multiplier;
        document.getElementById("igv").value = igv_decimal;

        // Operacion para total
        var totalInp = $('[name="total"]');
        var total_t = 0;
        totalInp.each(function(){
            total_t += parseFloat($(this).val());
        });
        console.log(total_t);
        var multiplier2 = 100;
        var total_tt = Math.round(total_t * multiplier2) / multiplier2;

        $('#total').val(total_tt);

        var subtotal = document.querySelector(`#total`).value;
        document.getElementById("total_final").value = subtotal;

    }
    function inputs_campos(a){
        var articulo = document.getElementById(`articulo${a}`).value;
        document.getElementById(`input_prod${a}`).value = articulo;
    }

    var igv = {{$igv_t->renta}}
    var multiplier = 100;
    function multi_s_igv(a){
        var pr_s_igv = $(`#precio_s_igv${a}`).val();
        $(`#precio_s_igv_float${a}`).val(pr_s_igv);
        var c_igv_s_redondeo = parseFloat(pr_s_igv)+(parseFloat(pr_s_igv)*igv/multiplier);
        var c_igv_redondeo = Math.round(c_igv_s_redondeo * multiplier)/multiplier;
        $(`#precio_c_igv${a}`).val(c_igv_redondeo);
    }

    function multi_c_igv(a){
        var pr_c_igv = $(`#precio_c_igv${a}`).val();
        var igv_dec = igv / multiplier ;
        var s_igv_s_base = parseFloat(pr_c_igv) / ( 1 + parseFloat(igv_dec));
        var s_igv_redondeo = Math.round(s_igv_s_base * multiplier) / multiplier;
        $(`#precio_s_igv${a}`).val(s_igv_redondeo);
        $(`#precio_s_igv_float${a}`).val(s_igv_redondeo);


    }
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        var input_text_opt = fila.find('input[class="celda"]').val();
        $('option[value="'+input_text_opt+'"]').prop("disabled", false);
        $(".addmore").prop("disabled", false);

        // ELIMINAR TR
        if (e>1) {
            fila.closest('tr').remove();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
            //RECALCULO PARA LOS SUBTOTAL IGV Y TOTAL
            // Operacion para subtotal sin igv
            var sub_igv = $('[name="precio_s_igv_float"]');
            var sub_igv_t = 0;
            sub_igv.each(function(){
                sub_igv_t += parseFloat($(this).val());
            });
            var sub_igv_tt = Math.round(sub_igv_t * multiplier) / multiplier;
            $('#sub_total').val(sub_igv_tt);
            document.getElementById("subtotal").value = sub_igv_tt;

            //OPERACION PARA CALULCAR EL IGV
            var only_igv = (parseFloat(sub_igv_tt) * (igv/multiplier))
            var igv_decimal = Math.round(only_igv * multiplier ) / multiplier;
            document.getElementById("igv").value = igv_decimal;

            // Operacion para total
            var totalInp = $('[name="total"]');
            var total_t = 0;
            totalInp.each(function(){
                total_t += parseFloat($(this).val());
            });

            var multiplier2 = 100;
            var total_tt = Math.round(total_t * multiplier2) / multiplier2;

            console.log(total_tt);
            $('#total').val(total_tt);

            var subtotal = document.querySelector(`#total`).value;
            document.getElementById("total_final").value = subtotal;
        }else{
            limpiar_inputs();
            $(".select2_demo_3").val(null).trigger("change");
            $(".addmore").prop("disabled", false);
            limpiar_inputs();

        }
        articlesSelect2();
    });
    function limpiar_inputs(){
        $(`.precio_s_igv`).val("");
        $(`.precio_c_igv`).val("");
        $(`.cantidad`).val("");
        $(`.total`).val("");
        $(`.subtotal`).val("");
        $(`.igv`).val("");
        $(`.total_final`).val("");
        $(`.p_inp`).val("");
        $(`.txt-limp`).val("");

    }
</script>

{{-- script para manejar las renovaciones --}}
<script>
// ==================== VARIABLES GLOBALES ====================
let calendarioMesActual = new Date();
let calendarioAnualMesActual = new Date();
let fechaEmisionGlobal = new Date();
let diaSeleccionadoAnual = null;
let mesSeleccionadoAnual = null;

// ==================== CALENDARIO MENSUAL CORREGIDO ====================
function generarCalendarioMensual(mesOffset = 0) {
    const extraSelects = document.getElementById("extra_selects");

    @if($renovacion && $fecha_vencimiento)
        const fechaVencimientoText = "{{ $fecha_vencimiento->format('d-m-Y') }}";
        let fechaReferencia;

        if (fechaVencimientoText) {
            const separador = fechaVencimientoText.includes('/') ? '/' : '-';
            const partes = fechaVencimientoText.split(separador);

            if (partes.length === 3) {
                const dia = parseInt(partes[0]);
                const mes = parseInt(partes[1]) - 1;
                const anio = parseInt(partes[2]);
                fechaReferencia = new Date(anio, mes, dia);
            } else {
                fechaReferencia = new Date();
            }
        } else {
            fechaReferencia = new Date();
        }
    @else
        // Si no hay vencimiento, usar fecha de emisión
        const fechaEmisionText = "{{ $cotizacion->fecha_emision }}";
        let fechaReferencia;

        if (fechaEmisionText) {
            const separador = fechaEmisionText.includes('/') ? '/' : '-';
            const partes = fechaEmisionText.split(separador);

            if (partes.length === 3) {
                const dia = parseInt(partes[0]);
                const mes = parseInt(partes[1]) - 1;
                const anio = parseInt(partes[2]);
                fechaReferencia = new Date(anio, mes, dia);
            } else {
                fechaReferencia = new Date();
            }
        } else {
            fechaReferencia = new Date();
        }
    @endif

    if (isNaN(fechaReferencia.getTime())) {
        fechaReferencia = new Date();
    }

    fechaEmisionGlobal = fechaReferencia;

    if (mesOffset === 0) {
        // Iniciar el calendario en el mes de la fecha de referencia (vencimiento)
        calendarioMesActual = new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), 1);
    }

    const mesVista = calendarioMesActual.getMonth();
    const anioVista = calendarioMesActual.getFullYear();

    // Fecha máxima: 30 días después de la fecha de referencia (vencimiento)
    const fechaMaxima = new Date(fechaReferencia);
    fechaMaxima.setDate(fechaMaxima.getDate() + 30);

    const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    // Calcular si se puede retroceder (solo meses que contengan la fecha de referencia o posteriores)
    const primerDiaMesAnterior = new Date(anioVista, mesVista - 1, 1);
    const puedeRetroceder = primerDiaMesAnterior >= new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), 1);

    // Calcular si se puede avanzar (hasta 30 días después de la fecha de referencia)
    const puedeAvanzar = new Date(anioVista, mesVista + 1, 1) <= fechaMaxima;

    let html = `
        <div class="calendar-container">
            <div class="calendar-header">
                <button type="button" class="btn btn-xs calendar-nav-btn" id="prevMonth" ${!puedeRetroceder ? 'disabled' : ''}>
                    <i class="fa fa-chevron-left"></i>
                </button>
                <h6>${meses[mesVista]} ${anioVista}</h6>
                <button type="button" class="btn btn-xs calendar-nav-btn" id="nextMonth" ${!puedeAvanzar ? 'disabled' : ''}>
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
            <div class="calendar-grid">
                <div class="calendar-day-header">Lu</div>
                <div class="calendar-day-header">Ma</div>
                <div class="calendar-day-header">Mi</div>
                <div class="calendar-day-header">Ju</div>
                <div class="calendar-day-header">Vi</div>
                <div class="calendar-day-header">Sa</div>
                <div class="calendar-day-header">Do</div>
    `;

    const ultimoDia = new Date(anioVista, mesVista + 1, 0);
    const diasEnMes = ultimoDia.getDate();
    const primerDiaSemana = new Date(anioVista, mesVista, 1).getDay();

    const ajusteDia = primerDiaSemana === 0 ? 6 : primerDiaSemana - 1;

    const ultimoDiaMesAnterior = new Date(anioVista, mesVista, 0);
    const diasMesAnterior = ultimoDiaMesAnterior.getDate();

    // Días del mes anterior (SIEMPRE deshabilitados en el show)
    for (let i = ajusteDia - 1; i >= 0; i--) {
        const dia = diasMesAnterior - i;
        html += `<div class="calendar-day disabled" style="color: #d1dade;">${dia}</div>`;
    }

    const diaReferencia = fechaReferencia.getDate();
    const mesReferencia = fechaReferencia.getMonth();
    const anioReferencia = fechaReferencia.getFullYear();

    // Días del mes actual
    for (let dia = 1; dia <= diasEnMes; dia++) {
        const fechaDia = new Date(anioVista, mesVista, dia);

        // Normalizar fechas a medianoche para comparación correcta
        const fechaDiaNormalizada = new Date(fechaDia.getFullYear(), fechaDia.getMonth(), fechaDia.getDate());
        const fechaReferenciaNormalizada = new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), fechaReferencia.getDate());

        const esFechaReferencia = dia === diaReferencia && mesVista === mesReferencia && anioVista === anioReferencia;
        const esAnteriorReferencia = fechaDiaNormalizada < fechaReferenciaNormalizada;
        const esPosteriorMaximo = fechaDia > fechaMaxima;
        const esDeshabilitado = esAnteriorReferencia || esPosteriorMaximo;

        let clases = 'calendar-day';
        if (esDeshabilitado) {
            clases += ' disabled';
        } else {
            clases += ' selectable';
            if (esFechaReferencia) clases += ' fecha-emision';
        }

        html += `<div class="${clases}"
                    data-dia="${dia}"
                    data-mes="${mesVista + 1}"
                    data-anio="${anioVista}">${dia}</div>`;
    }

    // Días vacíos al final
    const celdasUsadas = ajusteDia + diasEnMes;
    const filasNecesarias = Math.ceil(celdasUsadas / 7);
    const totalCeldas = filasNecesarias * 7;
    const diasVaciosFinal = totalCeldas - celdasUsadas;

    for (let i = 1; i <= diasVaciosFinal; i++) {
        html += `<div class="calendar-day disabled" style="color: #d1dade;">${i}</div>`;
    }

    html += `</div></div>`;
    extraSelects.innerHTML = html;

    // Eventos de navegación
    const prevBtn = document.getElementById('prevMonth');
    const nextBtn = document.getElementById('nextMonth');

    if (prevBtn && !prevBtn.disabled) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            calendarioMesActual.setMonth(calendarioMesActual.getMonth() - 1);
            generarCalendarioMensual(-1);
        });
    }

    if (nextBtn && !nextBtn.disabled) {
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            calendarioMesActual.setMonth(calendarioMesActual.getMonth() + 1);
            generarCalendarioMensual(1);
        });
    }

    // Eventos de selección de día
    document.querySelectorAll('.calendar-day.selectable').forEach(function(elemento) {
        elemento.addEventListener('click', function() {
            document.querySelectorAll('.calendar-day').forEach(el => {
                el.classList.remove('selected');
            });

            this.classList.add('selected');

            // ✅ ÚNICO CAMBIO: Guardar día del mes (1-31) directamente
            const diaSeleccionado = parseInt(this.getAttribute('data-dia'));
            document.getElementById('dia_mensual_hidden').value = diaSeleccionado;
        });
    });

    // Restaurar selección guardada
    const diaGuardado = document.getElementById('dia_mensual_hidden').value;
    if (diaGuardado && diaGuardado !== "") {
        const fechaSeleccionada = new Date(fechaEmisionGlobal);
        fechaSeleccionada.setDate(fechaSeleccionada.getDate() + parseInt(diaGuardado));

        const diaSelec = fechaSeleccionada.getDate();
        const mesSelec = fechaSeleccionada.getMonth();
        const anioSelec = fechaSeleccionada.getFullYear();

        if (mesSelec === mesVista && anioSelec === anioVista) {
            document.querySelectorAll('.calendar-day.selectable').forEach(el => {
                if (parseInt(el.getAttribute('data-dia')) === diaSelec) {
                    el.classList.add('selected');
                }
            });
        }
    }
}

// ==================== CALENDARIO ANUAL CORREGIDO ====================
function generarCalendarioAnual(mesOffset = 0) {
    const extraSelects = document.getElementById("extra_selects");

    // EN EL SHOW, USAR LA FECHA DE VENCIMIENTO COMO REFERENCIA
    @if($renovacion && $fecha_vencimiento)
        const fechaVencimientoText = "{{ $fecha_vencimiento->format('d-m-Y') }}";
        let fechaReferencia;

        if (fechaVencimientoText) {
            const separador = fechaVencimientoText.includes('/') ? '/' : '-';
            const partes = fechaVencimientoText.split(separador);

            if (partes.length === 3) {
                const dia = parseInt(partes[0]);
                const mes = parseInt(partes[1]) - 1;
                const anio = parseInt(partes[2]);
                fechaReferencia = new Date(anio, mes, dia);
            } else {
                fechaReferencia = new Date();
            }
        } else {
            fechaReferencia = new Date();
        }
    @else
        // Si no hay vencimiento, usar fecha de emisión
        const fechaEmisionText = "{{ $cotizacion->fecha_emision }}";
        let fechaReferencia;

        if (fechaEmisionText) {
            const separador = fechaEmisionText.includes('/') ? '/' : '-';
            const partes = fechaEmisionText.split(separador);

            if (partes.length === 3) {
                const dia = parseInt(partes[0]);
                const mes = parseInt(partes[1]) - 1;
                const anio = parseInt(partes[2]);
                fechaReferencia = new Date(anio, mes, dia);
            } else {
                fechaReferencia = new Date();
            }
        } else {
            fechaReferencia = new Date();
        }
    @endif

    if (isNaN(fechaReferencia.getTime())) {
        fechaReferencia = new Date();
    }

    if (mesOffset === 0) {
        calendarioAnualMesActual = new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), 1);
    }

    const mesVista = calendarioAnualMesActual.getMonth();
    const anioVista = calendarioAnualMesActual.getFullYear();

    const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    // Calcular si se puede retroceder (solo meses que contengan la fecha de referencia o posteriores)
    const primerDiaMesAnterior = new Date(anioVista, mesVista - 1, 1);
    const puedeRetroceder = primerDiaMesAnterior >= new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), 1);

    let html = `
        <div class="calendar-container">
            <div class="calendar-header">
                <button type="button" class="btn btn-xs calendar-nav-btn" id="prevMonthAnual" ${!puedeRetroceder ? 'disabled' : ''}>
                    <i class="fa fa-chevron-left"></i>
                </button>
                <h6>${meses[mesVista]} ${anioVista}</h6>
                <button type="button" class="btn btn-xs calendar-nav-btn" id="nextMonthAnual">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
            <div class="calendar-grid">
                <div class="calendar-day-header">Lu</div>
                <div class="calendar-day-header">Ma</div>
                <div class="calendar-day-header">Mi</div>
                <div class="calendar-day-header">Ju</div>
                <div class="calendar-day-header">Vi</div>
                <div class="calendar-day-header">Sa</div>
                <div class="calendar-day-header">Do</div>
    `;

    const ultimoDia = new Date(anioVista, mesVista + 1, 0);
    const diasEnMes = ultimoDia.getDate();
    const primerDiaSemana = new Date(anioVista, mesVista, 1).getDay();

    const ajusteDia = primerDiaSemana === 0 ? 6 : primerDiaSemana - 1;

    const ultimoDiaMesAnterior = new Date(anioVista, mesVista, 0);
    const diasMesAnterior = ultimoDiaMesAnterior.getDate();

    // Días del mes anterior (SIEMPRE deshabilitados)
    for (let i = ajusteDia - 1; i >= 0; i--) {
        const dia = diasMesAnterior - i;
        html += `<div class="calendar-day disabled" style="color: #d1dade;">${dia}</div>`;
    }

    const diaReferencia = fechaReferencia.getDate();
    const mesReferencia = fechaReferencia.getMonth();
    const anioReferencia = fechaReferencia.getFullYear();

    // Días del mes actual
    for (let dia = 1; dia <= diasEnMes; dia++) {
        const fechaDia = new Date(anioVista, mesVista, dia);

        // Normalizar fechas a medianoche para comparación correcta
        const fechaDiaNormalizada = new Date(fechaDia.getFullYear(), fechaDia.getMonth(), fechaDia.getDate());
        const fechaReferenciaNormalizada = new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), fechaReferencia.getDate());

        const esFechaReferencia = dia === diaReferencia && mesVista === mesReferencia && anioVista === anioReferencia;
        const esAnteriorReferencia = fechaDiaNormalizada < fechaReferenciaNormalizada;

        let clases = 'calendar-day';
        if (esAnteriorReferencia) {
            clases += ' disabled';
        } else {
            clases += ' selectable';
            if (esFechaReferencia) clases += ' fecha-emision';
        }

        html += `<div class="${clases}"
                    data-dia="${dia}"
                    data-mes="${mesVista + 1}"
                    data-anio="${anioVista}">${dia}</div>`;
    }

    // Días vacíos al final
    const celdasUsadas = ajusteDia + diasEnMes;
    const filasNecesarias = Math.ceil(celdasUsadas / 7);
    const totalCeldas = filasNecesarias * 7;
    const diasVaciosFinal = totalCeldas - celdasUsadas;

    for (let i = 1; i <= diasVaciosFinal; i++) {
        html += `<div class="calendar-day disabled" style="color: #d1dade;">${i}</div>`;
    }

    html += `</div></div>`;

    extraSelects.innerHTML = html;

    // Navegación
    const prevBtn = document.getElementById('prevMonthAnual');
    const nextBtn = document.getElementById('nextMonthAnual');

    if (prevBtn && !prevBtn.disabled) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            calendarioAnualMesActual.setMonth(calendarioAnualMesActual.getMonth() - 1);
            generarCalendarioAnual(-1);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            calendarioAnualMesActual.setMonth(calendarioAnualMesActual.getMonth() + 1);
            generarCalendarioAnual(1);
        });
    }

    // Eventos de selección
    document.querySelectorAll('.calendar-day.selectable').forEach(function(elemento) {
        elemento.addEventListener('click', function() {
            document.querySelectorAll('.calendar-day').forEach(el => {
                el.classList.remove('selected');
            });

            this.classList.add('selected');

            // ✅ ÚNICO CAMBIO: Guardar día, mes y año directamente
            diaSeleccionadoAnual = parseInt(this.getAttribute('data-dia'));
            mesSeleccionadoAnual = parseInt(this.getAttribute('data-mes'));
            const anioSeleccionado = parseInt(this.getAttribute('data-anio'));

            document.getElementById('dia_anual_hidden').value = diaSeleccionadoAnual;
            document.getElementById('mes_anual_hidden').value = mesSeleccionadoAnual;
            document.getElementById('anio_anual_hidden').value = anioSeleccionado;
        });
    });

    // Restaurar selección guardada
    const diaGuardado = document.getElementById('dia_anual_hidden').value;
    const mesGuardado = document.getElementById('mes_anual_hidden').value;

    if (diaGuardado && diaGuardado !== "" && mesGuardado && mesGuardado !== "") {
        const diasAcumulados = parseInt(diaGuardado);

        // Calcular la fecha real sumando días acumulados a la fecha de referencia
        @if($renovacion && $fecha_vencimiento)
            const fechaVencimientoBase = "{{ $fecha_vencimiento->format('d-m-Y') }}";
            let fechaBase;

            if (fechaVencimientoBase) {
                const separador = fechaVencimientoBase.includes('/') ? '/' : '-';
                const partes = fechaVencimientoBase.split(separador);

                if (partes.length === 3) {
                    const dia = parseInt(partes[0]);
                    const mes = parseInt(partes[1]) - 1;
                    const anio = parseInt(partes[2]);
                    fechaBase = new Date(anio, mes, dia);
                } else {
                    fechaBase = new Date();
                }
            } else {
                fechaBase = new Date();
            }
        @else
            const fechaEmisionBase = "{{ $cotizacion->fecha_emision }}";
            let fechaBase;

            if (fechaEmisionBase) {
                const separador = fechaEmisionBase.includes('/') ? '/' : '-';
                const partes = fechaEmisionBase.split(separador);

                if (partes.length === 3) {
                    const dia = parseInt(partes[0]);
                    const mes = parseInt(partes[1]) - 1;
                    const anio = parseInt(partes[2]);
                    fechaBase = new Date(anio, mes, dia);
                } else {
                    fechaBase = new Date();
                }
            } else {
                fechaBase = new Date();
            }
        @endif

        const fechaSeleccionada = new Date(fechaBase);
        fechaSeleccionada.setDate(fechaSeleccionada.getDate() + diasAcumulados);

        diaSeleccionadoAnual = fechaSeleccionada.getDate();
        mesSeleccionadoAnual = fechaSeleccionada.getMonth() + 1;

        if (mesSeleccionadoAnual === mesVista + 1) {
            document.querySelectorAll('.calendar-day.selectable').forEach(el => {
                if (parseInt(el.getAttribute('data-dia')) === diaSeleccionadoAnual) {
                    el.classList.add('selected');
                }
            });
        }
    }
}

// ==================== EVENT LISTENERS ====================
document.addEventListener("DOMContentLoaded", function () {
    const checkRenovacion = document.getElementById("estado_renovacion");
    const contenedorRenovacion = document.getElementById("renovacion_container");
    const selectFecha = document.getElementById("select_fecha");
    const extraSelects = document.getElementById("extra_selects");

    // Al cargar, si hay frecuencia seleccionada, generar el calendario correspondiente
    if (selectFecha.value === "Mensual") {
        generarCalendarioMensual(0);
    } else if (selectFecha.value === "Anual") {
        generarCalendarioAnual(0);
    }

    checkRenovacion.addEventListener("change", function () {
        contenedorRenovacion.style.display = this.checked ? "block" : "none";
        if (!this.checked) {
            selectFecha.value = "";
            extraSelects.innerHTML = "";
            document.getElementById('dia_mensual_hidden').value = "";
            document.getElementById('dia_anual_hidden').value = "";
            document.getElementById('mes_anual_hidden').value = "";
            document.getElementById('anio_anual_hidden').value = "";
            diaSeleccionadoAnual = null;
            mesSeleccionadoAnual = null;
        }
    });

    selectFecha.addEventListener("change", function () {
        const selected = this.value;
        extraSelects.innerHTML = "";
        document.getElementById('dia_mensual_hidden').value = "";
        document.getElementById('dia_anual_hidden').value = "";
        document.getElementById('mes_anual_hidden').value = "";
        document.getElementById('anio_anual_hidden').value = "";
        diaSeleccionadoAnual = null;
        mesSeleccionadoAnual = null;

        if (selected === "Mensual") {
            generarCalendarioMensual(0);
        } else if (selected === "Anual") {
            generarCalendarioAnual(0);
        }
    });
});
</script>

@endsection
