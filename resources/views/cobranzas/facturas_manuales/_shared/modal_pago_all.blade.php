 <div class="modal fade bd-example-modal-lg" id="todo_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document" style="max-width: 900px;">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="{{ route('pagados.store') }}" method="POST" enctype="multipart/form-data">
                 @csrf

                 <input type="hidden" name="tipo_comprobante" value="factura_manual">
                 <div class="display: none" id="ids_divs_factura">

                 </div>
                 <input type="hidden" value="{{ $fecha_hoy }}" name="" id="fecha_value_php">
                 <div class="modal-body">
                     {{-- Lista de Facturas M --}}
                     <div id="accordion-collapse">
                         <div class="panel panel-default">
                             <div class="panel-heading" id="collapse-head-three">
                                 <h4 class="panel-title text-center">
                                     <a data-toggle="collapse" data-parent="#accordion-collapse" href="#collapseThree"
                                         aria-expanded="true" class="text-center">Facturas a Pagar</a>
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
                                                 <input class="form-control form-control-sm" type="hidden"
                                                     name="gran_total" id="tota_totas2">
                                                 <input class="form-control form-control-sm" type="hidden"
                                                     name="gran_total" id="gran_total_input">

                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="panel panel-default">
                             <div class="panel-heading" id="collapse-head-four">
                                 <h4 class="panel-title text-center">
                                     <a data-toggle="collapse" data-parent="#accordion-collapse" href="#collapseFour"
                                         aria-expanded="true" class="text-center">Metodo de Pago</a>
                                 </h4>
                             </div>
                             <div id="collapseFour" class="panel-collapse collapse">
                                 <div class="panel-body">
                                     {{-- * Encabezado Metodo de pago --}}
                                     {{-- <h4 class="text-center">Escoge el metodo de Pago</h4> --}}
                                     <div class="row text-center" style="justify-content: space-around;">
                                         <div class="col-sm-3">
                                             <button type="button" value="btn_pago_1"
                                                 class="btn btn-outline btn-block btn-primary btn_pago_selec"
                                                 id="bm_pago_1" onclick="select_pago(1)">Cheque</button>
                                             {{-- <button class="btn btn-primary btn-outline btn-block">Cheque</button> --}}
                                         </div>
                                         <div class="col-sm-3">
                                             {{-- <button class="btn btn-primary btn-outline btn-block">Tarjeta</button> --}}
                                             <button type="button" value="btn_pago_2"
                                                 class="btn btn-outline btn-block btn-primary btn_pago_selec"
                                                 id="bm_pago_2" onclick="select_pago(2)">Tarjeta</button>
                                         </div>
                                         <div class="col-sm-3">
                                             {{-- <button class="btn btn-primary btn-outline btn-block">Efectivo / QR</button> --}}
                                             <button type="button" value="btn_pago_3"
                                                 class="btn btn-outline btn-block btn-primary btn_pago_selec"
                                                 id="bm_pago_3" onclick="select_pago(3)">Efectivo / QR</button>
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
                                                             name="moneda_pago">
                                                             @foreach ($monedas as $moneda)
                                                                 <option value="{{ $moneda->id }}"
                                                                     @if ($moneda->principal == 1) selected @endif>
                                                                     {{ $moneda->simbolo }}</option>
                                                             @endforeach
                                                         </select>
                                                         <input type="number" id="cheque_monto" name="cheque_monto"
                                                             value="" placeholder="Monto"
                                                             class="form-control pago_class_1 class_pago" required
                                                             step="0.01">
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
                                                         name="tipo_cambio" id="tipo_cambio" readonly
                                                         value="{{ $tipo_cambio->paralelo }}">
                                                 </div>
                                             </div>
                                             <div class="col-md-3">
                                                 <div class="form-group">
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
                                                     <label class=""><strong>Fecha</strong></label>
                                                     <input type="date" value="{{ $fecha_hoy }}"
                                                         class="form-control pago_class_2 class_pago fecha_hoy"
                                                         name="tarjeta_fecha" id="">
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
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <!--
                    <div class="modal-body">
                        <input type="hidden" name="tipo_comprobante" value="factura_manual">
                        <div class="display: none" id="ids_divs_factura">

                        </div>
                        <input type="hidden" value="{{ $fecha_hoy }}" name="" id="fecha_value_php">
                        <div class="cabeza_facturas">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h3 class="text-center">N° de Factura</h3>

                                </div>
                                <div class="col-sm-4">
                                    <h3 class="text-center">Cuotas por Factura</h3>
                                </div>
                                <div class="col-sm-4">
                                    <h3 class="text-center">Total x Cuotas</h3>
                                </div>
                            </div>
                            <div id="div_facturas">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="" id="numero_fac">
                                    </div>
                                    <div class="col-sm-4 div_select">
                                        <select id="sel" class="select_2_multipl select2-selection--multiple"
                                            name="select_cuotas[]" multiple="multiple">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="" id="total_cuotas">
                                    </div>
                                </div>
                            </div>
                            <hr style="margin: 0px 5px">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <label class="col-form-label text-right">Total:</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group select-group" id="tot_simbolo">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="metodo_pago">
                            <input type="hidden" name="input_pago" id="input_pago" value="1">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3 class="text-center">Metodos de Pago</h3>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_1"
                                            class="btn btn-block btn-primary btn_pago_selec active" id="bm_pago_1"
                                            onclick="select_pago(1)">Cheque</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_2"
                                            class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_2"
                                            onclick="select_pago(2)">Tarjeta</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_3"
                                            class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_3"
                                            onclick="select_pago(3)">Efectivo</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_4"
                                            class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_4"
                                            onclick="select_pago(4)">Transferencia</button>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row pago_m m_pago_1"> {{-- Metodo de Pago 1 - CHEQUE --}}`
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">¿Es cheque diferido? </label>
                                                <div class="">
                                                    <span>No&nbsp;</span><input type="checkbox" class="js-switch-pago"
                                                        name="cheque_diferido" /><span>&nbsp;Si</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Numero de Cheque</label>
                                                <input type="text" id="" name="cheque_name" value=""
                                                    placeholder="Numero de Cheque"
                                                    class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha de Cobro</label>
                                                <input type="date" id="" name="cheque_fecha_cobro"
                                                    value="{{ $fecha_hoy }}" placeholder="Fecha de Cobro"
                                                    class="form-control pago_class_1 class_pago fecha_hoy" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Banco Emisor</label>
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
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Beneficiario</label>
                                                <input type="text" id="" name="cheque_beneficiario"
                                                    value="" placeholder="Beneficiario"
                                                    class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Monto</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago_vuelto">S/</span>
                                                    </div>
                                                    <input type="number" id="cheque_monto" name="cheque_monto"
                                                        value="" placeholder="Monto"
                                                        class="form-control pago_class_1 class_pago" required
                                                        step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form_adelanto">
                                                <label class="col-form-label">Banco de la Empresa</label>
                                                <select name="banco_cuenta" id="select_banco_pagos"
                                                    class="select2_banco pago_class_1 class_pago"
                                                    onchange="changue_bancos_pagos()">
                                                    <option value="">Seleccionar</option>
                                                    @foreach ($bancos as $banco)
<option value="{{ $banco->id }}">{{ $banco->nombre_banco }}
                                                        </option>
@endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form_adelanto">
                                                <label class="col-form-label">N° de Cuenta</label>
                                                <select name="cheque_n_cuenta"
                                                    class="form-control pago_class_1 class_pago" id="select_cuenta_pago">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha de Emision</label>
                                                <input type="date" value="{{ $fecha_hoy }}"
                                                    name="cheque_fecha_emision" placeholder="Fecha de Emision"
                                                    class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Comprobante
                                                    <small>(opcional)</small></label>
                                                <input type="file" name="cheque_file" id=""
                                                    class="form-control pago_class_1 class_pago file_input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pago_m m_pago_2"> {{-- Metodo de Pago 2 - TARJETA --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Titular de la Tajeta</label>
                                                <input type="text" id="" name="tarjeta_titular"
                                                    value="" placeholder="Titular de la Tajeta"
                                                    class="form-control pago_class_2 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Banco</label>
                                                <select class="form-control pago_class_2 class_pago" name="tarjeta_banco"
                                                    id="">
                                                    <option value="">Seleccionar Banco</option>
                                                    <option value="BCP">BCP</option>
                                                    <option value="INTERBANK">INTERBANK</option>
                                                    <option value="BBVA">BBVA</option>
                                                    <option value="SCOTIABANK">SCOTIABANK</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha</label>
                                                <input type="date" value="{{ $fecha_hoy }}"
                                                    class="form-control pago_class_2 class_pago fecha_hoy"
                                                    name="tarjeta_fecha" id="">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Comprobante</label>
                                                <input type="file"
                                                    class="form-control pago_class_2 class_pago file_input"
                                                    name="tarjeta_file" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pago_m m_pago_3"> {{-- Metodo de Pago 3 - EFECTIVO --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Persona que Cancela</label>
                                                <input type="text" id="" name="efectivo_persona"
                                                    value="" placeholder="Titular"
                                                    class="form-control pago_class_3 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha</label>
                                                <input type="date" name="fecha_efectivo"
                                                    class="form-control pago_class_3 class_pago fecha_hoy" id=""
                                                    value="{{ $fecha_hoy }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Monto de Pago</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago">S/</span>
                                                    </div>
                                                    <input type="number" name="monto_pago_efectivo" id="efectivo_pago"
                                                        class="form-control pago_class_3 class_pago" placeholder=""
                                                        step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Vuelto</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago_vuelto">S/</span>
                                                    </div>
                                                    <input type="text" name="monto_vuelto" id="efectivo_vuelto"
                                                        class="form-control pago_class_3 class_pago" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pago_m m_pago_4"> {{-- Metodo de Pago 4 - TRANSFERENCIA --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Titular</label>
                                                <input type="text" id="" name="transferencia_titular"
                                                    value="" placeholder="Titular"
                                                    class="form-control pago_class_4 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha</label>
                                                <input type="date"
                                                    class="form-control pago_class_4 class_pago fecha_hoy"
                                                    name="transferencia_fecha" id=""
                                                    value="{{ $fecha_hoy }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form_adelanto">
                                                <label class="col-form-label">Banco de la Empresa</label>
                                                <select name="banco_cuenta_transf_pag" id="select_banco_transf_pag"
                                                    class="pago_class_4 class_pago" onchange="changue_bancos_pago_tr()">
                                                    <option value="">Seleccionar</option>
                                                    @foreach ($bancos as $banco)
<option value="{{ $banco->id }}">{{ $banco->nombre_banco }}
                                                        </option>
@endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form_adelanto">
                                                <label class="col-form-label">N° de Cuenta Bancaria</label>
                                                <select name="transferencia_n_cuenta"
                                                    class="form-control pago_class_4 class_pago"
                                                    id="select_cuenta_adl_pag">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">N° de Operación</label>
                                                <input type="text" class="form-control pago_class_4 class_pago"
                                                    name="transferencia_operacion_pag" id="transferencia_oper_pag">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Comprobante</label>
                                                <input type="file"
                                                    class="form-control pago_class_4 class_pago file_input"
                                                    name="transferencia_comprobante" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> {{--  NOTAS PARA TODOS --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Notas Adicionales</label>
                                                <textarea class="form-control" name="notas_adicionales" id="" rows="4"></textarea>
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
                     -->
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
 </style>
