
{{--!! Si usas un formateador de codigo para ordernar, el option de $moneda->simbolo se rompe, se debe dejar {{$moneda->simbolo}}, pegado todo, no dejar espacios --}}
<div class="modal fade bd-example-modal-lg" id="todo_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document" style="max-width: 900px;">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Pago de Cuotas</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="{{ route('pagados.store') }}" method="POST" enctype="multipart/form-data">
                 @csrf

                 <input type="hidden" id="modal_pago_tipo_comprobante" name="tipo_comprobante" value="">
                 <div style="display: none" id="ids_divs_factura">

                 </div>
                 <input type="hidden" value="{{ $fecha_hoy }}" name="" id="fecha_value_php">
                 <div class="modal-body">
                     {{-- Lista de Facturas M --}}
                     <div id="accordion-collapse">
                         <div class="panel panel-default">
                             <div class="panel-heading" id="collapse-head-three">
                                 <h4 class="panel-title text-center">
                                     <a data-toggle="collapse" data-parent="#accordion-collapse" href="#collapseThree"
                                         aria-expanded="true" class="text-center"><span id="comprobante_titulo">Facturas</span> a Pagar</a>
                                 </h4>
                             </div>
                             <div id="collapseThree" class="panel-collapse collapse">
                                 <div class="panel-body">
                                     <div class="facturas_list" id="div_facturas">
                                         <div class="row">
                                             <div class="col-sm-12">
                                                 <div class="d-flex align-items-center my-2">
                                                     <span class=" fw-bold"><strong>F001-00000001</strong></span>
                                                 </div>
                                             </div>
                                             <div class="col-sm-8 div_select">
                                                 <select data-placeholder="Seleccionar 1 o más cuotas"
                                                     class="chosen-select" multiple style="width: 100% !important;"
                                                     tabindex="4">
                                                     <option value="100.00">Cuota 1 - 100.00</option>
                                                     <option value="150.00">Cuota 2 - 150.00</option>
                                                 </select>
                                             </div>
                                             <div class="input-group  input-group-sm col-sm-4">
                                                 <div class="input-group-prepend">
                                                     <span class="input-group-text" id="inputGroup-sizing-sm"
                                                         style="justify-content: center">S/</span>
                                                 </div>
                                                 <label class="form-control form-control" id="lbl_tot_0"
                                                     aria-describedby="inputGroup-sizing-sm">>0.00</label>

                                                 <input class="form-control form-control-sm" type="hidden"
                                                     name="tot_cuotas[]" id="total_cuotas_0">
                                             </div>
                                         </div>
                                     </div>
                                     <hr>
                                     <div class="row">
                                         <div class="col-sm-7">
                                             <h4 class="text-right">Total a Pagar:</h4>
                                         </div>
                                         <div class="col-sm-5">
                                             <div class="input-group  input-group-sm" id="tot_simbolo">
                                                 <div class="input-group-prepend">
                                                     <span class="input-group-text" id="simbolor_label"
                                                         style="justify-content: center">{{ $monedas->where('principal', 1)->pluck('simbolo')->first() }}</span>
                                                 </div>
                                                 <label class="form-control form-control" id="tota_totas"
                                                     aria-describedby="inputGroup-sizing-sm">0.00</label>
                                                 <input class="form-control form-control-sm" type="hidden" id="tota_totas2">
                                                 <input class="form-control form-control-sm" type="hidden" id="gran_total_input">

                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="panel panel-default" style="margin-bottom: 0px">
                             <div class="panel-heading" id="collapse-head-four">
                                 <h4 class="panel-title text-center">
                                     <a data-toggle="collapse" data-parent="#accordion-collapse" href="#collapseFour"
                                         aria-expanded="true" class="text-center">Metodo de Pago</a>
                                 </h4>
                             </div>
                             <input type="hidden" name="input_pago" id="input_pago" value="1">
                             <div id="collapseFour" class="panel-collapse collapse">
                                 <div class="panel-body">
                                     {{-- * Encabezado Metodo de pago --}}
                                     {{-- <h4 class="text-center">Escoge el metodo de Pago</h4> --}}
                                     <div class="row text-center" style="justify-content: space-around;">
                                         <div class="col-sm-3">
                                             <button type="button" value="btn_pago_1"
                                                 class="btn  btn-block btn-primary btn_pago_selec" id="bm_pago_1"
                                                 onclick="select_pago(1)">Cheque</button>
                                             {{-- <button class="btn btn-primary btn-outline btn-block">Cheque</button> --}}
                                         </div>
                                         <div class="col-sm-3">
                                             {{-- <button class="btn btn-primary btn-outline btn-block">Tarjeta</button> --}}
                                             <button type="button" value="btn_pago_2"
                                                 class="btn btn-outline btn-block btn-primary btn_pago_selec"
                                                 id="bm_pago_2" onclick="select_pago(2)">Tarjeta</button>
                                         </div>
                                         <div class="col-sm-3">
                                             {{-- <button class="btn btn-primary btn-outline btn-block">Efectivo</button> --}}
                                             <button type="button" value="btn_pago_3"
                                                 class="btn btn-outline btn-block btn-primary btn_pago_selec"
                                                 id="bm_pago_3" onclick="select_pago(3)">Efectivo</button>
                                         </div>
                                         <div class="col-sm-3">
                                             {{-- <button class="btn btn-primary btn-outline btn-block">Transferencia</button> --}}
                                             <button type="button" value="btn_pago_4"
                                                 class="btn btn-outline btn-block btn-primary btn_pago_selec"
                                                 id="bm_pago_4" onclick="select_pago(4)">Transferencia</button>
                                         </div>
                                     </div>
                                     <hr>
                                     {{-- * Cheque --}}
                                     <div class="pago_m m_pago_1">
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>N° de
                                                             Cheque</strong></label>
                                                     <input type="text" id="" name="cheque_name"
                                                         value="" placeholder="Numero de Cheque"
                                                         class="form-control pago_class_1 class_pago" required>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Fecha de
                                                             Cobro</strong></label>
                                                     <input type="date" id="" name="cheque_fecha_cobro"
                                                         value="{{ $fecha_hoy }}" placeholder="Fecha de Cobro"
                                                         class="form-control pago_class_1 class_pago fecha_hoy"
                                                         required>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Banco
                                                             Emisor</strong></label>
                                                     <select class="form-control pago_class_1 class_pago"
                                                         name="cheque_banco_emisor" id="" required>
                                                         <option value="">Seleccionar Banco</option>
                                                         <option value="BCP">BCP</option>
                                                         <option value="INTERBANK">INTERBANK</option>
                                                         <option value="BBVA">BBVA</option>
                                                         <option value="SCOTIABANK">SCOTIABANK</option>
                                                     </select>
                                                 </div>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Beneficiario</strong></label>
                                                     <input type="text" id="" name="cheque_beneficiario"
                                                         value="" placeholder="Beneficiario"
                                                         class="form-control pago_class_1 class_pago" required>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Moneda de Pago y
                                                             monto</strong></label>
                                                     <div class="input-group">
                                                         <select class="form-control" id="moneda_pago_cheque"
                                                             style="height: 2.25rem;max-width: 100px"
                                                             name="moneda_pago_cheque">
                                                             @foreach ($monedas as $moneda)
                                                                 <option
                                                                     value="{{ $moneda->id }}"@if ($moneda->principal == 1) selected @endif>{{$moneda->simbolo}}</option>
                                                             @endforeach
                                                         </select>
                                                         <input type="number" id="cheque_monto" name="cheque_monto"
                                                             value="" placeholder="Monto"
                                                             class="form-control pago_class_1 class_pago" required
                                                             step="0.01" readonly>
                                                     </div>
                                                     <small id="emailHelp" class="form-text text-muted">En base al
                                                         tipo de cambio del dia de pago</small>
                                                 </div>
                                             </div>
                                             <div class="col-md-3">
                                                 <div class="form-group">
                                                     <label for=""><strong>Tipo
                                                             cambio</strong></label>
                                                     <input type="number" step="0.01" class="form-control"
                                                         name="tipo_cambio_cheque" id="tipo_cambio_cheque" readonly
                                                         value="{{ $tipo_cambio->paralelo }}">
                                                 </div>
                                             </div>
                                             <div class="col-md-3">
                                                 <div class="form-group" style="text-align: center">
                                                     <label for=""><strong>¿Es
                                                             Diferido?</strong></label>
                                                     <div class="">
                                                         <span>No&nbsp;</span><input type="checkbox"
                                                             class="js-switch-pago"
                                                             name="cheque_diferido" /><span>&nbsp;Si</span>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Fecha de Emision de
                                                             Cheque</strong></label>
                                                     <input type="date" value="{{ $fecha_hoy }}"
                                                         name="cheque_fecha_emision" placeholder="Fecha de Emision"
                                                         class="form-control pago_class_1 class_pago"
                                                         id="cheque_fecha_emision" required>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Banco de la
                                                             Empresa</strong></label>
                                                     <select name="banco_cuenta" id="select_banco_pagos"
                                                         class="select2_banco pago_class_1 class_pago"
                                                         onchange="changue_bancos_pagos(this)">
                                                         <option value="">Seleccionar</option>
                                                         @foreach ($bancos as $banco)
                                                             <option value="{{ $banco->id }}">
                                                                 {{ $banco->nombre_banco }}
                                                             </option>
                                                         @endforeach
                                                     </select>
                                                 </div>
                                             </div>

                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>N° de
                                                             Cuenta</strong></label>
                                                     <select name="cheque_n_cuenta"
                                                         class="form-control pago_class_1 class_pago"
                                                         id="select_cuenta_pago">
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Comprobantes
                                                             <small>(opcional)</small></strong></label>
                                                     <input type="file" name="cheque_file" id=""
                                                         class="form-control pago_class_1 class_pago file_input">
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-12">
                                                 <div class="form-group">
                                                     <label for=""><strong>Notas Adicionales</strong></label>
                                                     <textarea class="form-control" name="cheque_notas_adicionales" id="" rows="3"></textarea>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     {{-- * Tarjeta --}}
                                     <div class="pago_m m_pago_2">
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Titular de la
                                                             tarjeta</strong></label>
                                                     <input type="text" id="" name="tarjeta_titular"
                                                         value="" placeholder="Titular de la Tajeta"
                                                         class="form-control pago_class_2 class_pago">
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Banco</strong></label>
                                                     <select class="form-control pago_class_2 class_pago"
                                                         name="tarjeta_banco" id="">
                                                         <option value="">Seleccionar Banco</option>
                                                         <option value="BCP">BCP</option>
                                                         <option value="INTERBANK">INTERBANK</option>
                                                         <option value="BBVA">BBVA</option>
                                                         <option value="SCOTIABANK">SCOTIABANK</option>
                                                     </select>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Moneda de Pago y
                                                             monto</strong></label>
                                                     <div class="input-group">
                                                         <select class="form-control" id="moneda_pago_tarjeta"
                                                             style="height: 2.25rem;max-width: 100px"
                                                             name="moneda_pago_tarjeta">
                                                             @foreach ($monedas as $moneda)
                                                                 <option value="{{ $moneda->id }}"
                                                                     @if ($moneda->principal == 1) selected @endif>{{$moneda->simbolo}}</option>
                                                             @endforeach
                                                         </select>
                                                         <input type="number" id="tarjeta_monto"
                                                             name="tarjeta_monto" value="" placeholder="Monto"
                                                             class="form-control pago_class_1 class_pago"
                                                             step="0.01" readonly>
                                                     </div>
                                                     <small id="emailHelp" class="form-text text-muted">En base al
                                                         tipo de cambio del dia de pago</small>
                                                 </div>
                                             </div>
                                             <div class="col-md-3">
                                                 <div class="form-group">
                                                     <label for=""><strong>Tipo
                                                             cambio</strong></label>
                                                     <input type="number" step="0.01" class="form-control"
                                                         name="tipo_cambio_tarjeta" id="tipo_cambio_tarjeta" readonly
                                                         value="{{ $tipo_cambio->paralelo }}">
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class=""><strong>Fecha de Pago</strong></label>
                                                     <input type="date" value="{{ $fecha_hoy }}"
                                                         class="form-control pago_class_2 class_pago fecha_hoy"
                                                         name="tarjeta_fecha" id="tarjeta_fecha_pago">
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Comprobante
                                                             <small>(opcional)</small></strong></label>
                                                     <input type="file"
                                                         class="form-control pago_class_2 class_pago file_input"
                                                         name="tarjeta_file" id="">
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-12">
                                                 <div class="form-group">
                                                     <label for=""><strong>Notas Adicionales</strong></label>
                                                     <textarea class="form-control" name="tarjeta_notas_adicionales" id="" rows="3"></textarea>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     {{-- * Efectivo --}}
                                     <div class="pago_m m_pago_3">
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Persona que Cancela</strong></label>
                                                     <input type="text" id="" name="efectivo_persona"
                                                         value="" placeholder="Titular"
                                                         class="form-control pago_class_3 class_pago">
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Fecha de Pago</strong></label>
                                                     <input type="date"
                                                         class="form-control pago_class_3 class_pago fecha_hoy"
                                                         name="fecha_efectivo" id="efectivo_fecha_pago"
                                                         value="{{ $fecha_hoy }}">
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Moneda de Pago y
                                                             monto</strong></label>
                                                     <div class="input-group">
                                                         <select class="form-control" id="moneda_pago_efectivo"
                                                             style="height: 2.25rem;max-width: 100px"
                                                             name="moneda_pago_efectivo">
                                                             @foreach ($monedas as $moneda)
                                                                 <option
                                                                     value="{{ $moneda->id }}"@if ($moneda->principal == 1) selected @endif>{{$moneda->simbolo}}</option>
                                                             @endforeach
                                                         </select>
                                                         <input type="number" id="efectivo_monto"
                                                             name="monto_pago_efectivo" value=""
                                                             placeholder="Monto"
                                                             class="form-control pago_class_3 class_pago"
                                                             step="0.01" readonly>
                                                     </div>
                                                     <small id="emailHelp" class="form-text text-muted">En base al
                                                         tipo de cambio del dia de pago</small>
                                                 </div>
                                             </div>
                                             <div class="col-md-3">
                                                 <div class="form-group">
                                                     <label for=""><strong>Tipo
                                                             cambio</strong></label>
                                                     <input type="number" step="0.01" class="form-control"
                                                         name="tipo_cambio_efectivo" id="tipo_cambio_efectivo"
                                                         readonly value="{{ $tipo_cambio->paralelo }}">
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-12">
                                                 <div class="form-group">
                                                     <label for=""><strong>Notas Adicionales</strong></label>
                                                     <textarea class="form-control" name="efectivo_notas_adicionales" id="" rows="3"></textarea>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>

                                     {{-- * Transferencia --}}
                                     <div class="pago_m m_pago_4">
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Titular</strong></label>
                                                     <input type="text" id=""
                                                         name="transferencia_titular" value=""
                                                         placeholder="Titular"
                                                         class="form-control pago_class_4 class_pago">
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Fecha</strong></label>
                                                     <input type="date"
                                                         class="form-control pago_class_4 class_pago fecha_hoy"
                                                         name="transferencia_fecha" id="transferencia_fecha_pago"
                                                         value="{{ $fecha_hoy }}">
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Moneda de Pago y
                                                             monto</strong></label>
                                                     <div class="input-group">
                                                         <select class="form-control" id="moneda_pago_transferencia"
                                                             style="height: 2.25rem;max-width: 100px"
                                                             name="moneda_pago_transferencia">
                                                             @foreach ($monedas as $moneda)
                                                                 <option
                                                                     value="{{ $moneda->id }}"@if ($moneda->principal == 1) selected @endif>{{$moneda->simbolo}}</option>
                                                             @endforeach
                                                         </select>
                                                         <input type="number" id="transferencia_monto"
                                                             name="monto_pago_transferencia" value=""
                                                             placeholder="Monto"
                                                             class="form-control pago_class_3 class_pago"
                                                             step="0.01" readonly>
                                                     </div>
                                                     <small id="emailHelp" class="form-text text-muted">En base al
                                                         tipo de cambio del dia de pago</small>
                                                 </div>
                                             </div>
                                             <div class="col-md-3">
                                                 <div class="form-group">
                                                     <label for=""><strong>Tipo
                                                             cambio</strong></label>
                                                     <input type="number" step="0.01" class="form-control"
                                                         name="tipo_cambio_transferencia" id="tipo_cambio_transferencia"
                                                         readonly value="{{ $tipo_cambio->paralelo }}">
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Banco de la Empresa</strong></label>
                                                     <select name="banco_cuenta_transf_pag"
                                                         id="select_banco_transf_pag" class="pago_class_4 class_pago"
                                                         onchange="changue_bancos_pago_tr()">
                                                         <option value="">Seleccionar</option>
                                                         @foreach ($bancos as $banco)
                                                             <option value="{{ $banco->id }}">
                                                                 {{ $banco->nombre_banco }}
                                                             </option>
                                                         @endforeach
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>N° de Cuenta
                                                             Bancaria</strong></label>
                                                     <select name="transferencia_n_cuenta"
                                                         class="form-control pago_class_4 class_pago"
                                                         id="select_cuenta_adl_pag">
                                                     </select>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>N° de Operación</strong></label>
                                                     <input type="text"
                                                         class="form-control pago_class_4 class_pago"
                                                         name="transferencia_operacion_pag"
                                                         id="transferencia_oper_pag">
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for=""><strong>Comprobante</strong></label>
                                                     <input type="file"
                                                         class="form-control pago_class_4 class_pago file_input"
                                                         name="transferencia_comprobante" id="">
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-12">
                                                 <div class="form-group">
                                                     <label for=""><strong>Notas Adicionales</strong></label>
                                                     <textarea class="form-control" name="transferencia_notas_adicionales" id="" rows="3"></textarea>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                     <button type="submit" class="btn btn-primary">Guardar</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <style>
     .search-choice {
         margin-top: 6px !important;
     }

     li.search-field>input {
         width: 100% !important;
     }
     .select2-search__field {
        width: 100% !important;
     }

     .select2.select2-container.select2-container--default {
        width: 100% !important;
     }

     .select2-selection.select2-selection--single {
        height: 100%;
     }

     .select2-container.select2-container--default.select2-container--open {
        z-index: 3200;
     }
     .col-sm-9>.select2.select2-container.select2-container--default {
        width: 100% !important;
     }
     .div_select>.select2.select2-container.select2-container--default {
        width: 100% !important;
    }
</style>
