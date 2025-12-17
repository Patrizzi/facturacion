<div class="modal fade bd-example-modal-lg" id="modal_detalle_pago" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Detalle Pago de la cuota</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                <div class="pago_cheque" style="displey: flex">
                    <h3></h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>N° de Cheque</strong></label>
                                <p class="form-control" id="numero_cheque"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Fecha de Cobro</strong></label>
                                <p class="form-control" id="fecha_cheque"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Banco Emisor</strong></label>
                                <p class="form-control" id="banco_emisor_cheque"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Beneficiario</strong></label>
                                <p class="form-control" id="beneficiario_cheque"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Moneda y Monto de Pago</strong></label>
                                <p class="form-control" id="moneda_monto_cheque"></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for=""><strong>Tipo de Cambio</strong></label>
                                <p class="form-control" id="tipo_cambio_cheque"></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for=""><strong>¿Es Diferido?</strong></label>
                                <p class="form-control" id="diferido_cheque"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Fecha de Emision del Cheque</strong></label>
                                <p class="form-control" id="emision_cheque"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Banco de la Empresa</strong></label>
                                <p class="form-control" id="banco_empresa_cheque"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>N° de Cheque</strong></label>
                                <p class="form-control" id="emision_cheque"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Comprobante</strong></label>
                                    {{-- <p class="form-control" id="banco_empresa_cheque"></p> --}}
                                    {{-- Imagen o pdf vista previa? --}}
                                    <br>
                                    <button class="btn btn-primary btn-sm">Ver Comprobante</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for=""><strong>Observaciones</strong></label>
                                <p class="form-control" id="observaciones_cheque"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pago_tarjeta" style="display: none">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Titular de la Tarjeta</strong></label>
                                <p class="form-control" id="titular_tarjeta"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Banco</strong></label>
                                <p class="form-control" id="banco_tarjeta"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Moneda y Monto de Pago</strong></label>
                                <p class="form-control" id="moneda_monto_tarjeta"></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for=""><strong>Tipo de Cambio</strong></label>
                                <p class="form-control" id="tipo_cambio_tarjeta"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Fecha de Pago</strong></label>
                                <p class="form-control" id="fecha_tarjeta"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Comprobante</strong></label>
                                    {{-- <p class="form-control" id="banco_empresa_cheque"></p> --}}
                                    {{-- Imagen o pdf vista previa? --}}
                                    <br>
                                    <button class="btn btn-primary btn-sm">Ver Comprobante</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for=""><strong>Observaciones</strong></label>
                                <p class="form-control" id="observaciones_tarjeta"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pago_efectivo" style="display: none">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Persona que Cancela</strong></label>
                                <p class="form-control" id="persona_efectivo"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Fecha de Pago</strong></label>
                                <p class="form-control" id="feha_efectivo"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Moneda y monto de Pago</strong></label>
                                <p class="form-control" id="moneda_monto_efectivo"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Tipo de Cambio</strong></label>
                                <p class="form-control" id="feha_efectivo"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for=""><strong>Observaciones</strong></label>
                                <p class="form-control" id="observaciones_efectivo"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pago_transferencia" style="display: none">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Titular</strong></label>
                                <p class="form-control" id="titular_transferencia"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Fecha</strong></label>
                                <p class="form-control" id="fecha_transferencia"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Moneda y Monto de Pago</strong></label>
                                <p class="form-control" id="moneda_monto_transferencia"></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for=""><strong>Tipo Cambio</strong></label>
                                <p class="form-control" id="tipo_cambio_transferencia"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>N° de Operacion</strong></label>
                                <p class="form-control" id="numero_operacion_transferencia"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""><strong>Comprobante</strong></label>
                                {{-- <p class="form-control" id="banco_empresa_cheque"></p> --}}
                                {{-- Imagen o pdf vista previa? --}}
                                <br>
                                <button class="btn btn-primary btn-sm">Ver Comprobante</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for=""><strong>Observaciones</strong></label>
                                <p class="form-control" id="observaciones_transferencia"></p>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
             </div>
        </div>
    </div>
  </div>
</div>