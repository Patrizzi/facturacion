<div class="modal fade bd-example-modal-lg" id="modal_detalle_pago" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <div id="header-cuota-detalle">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group" style="margin-bottom: 0px">
                                    <label for=""><strong>Tipo de Pago</strong></label>
                                    <span class="input-group-prepend">
                                        <button class="btn btn-primary btn-block" readonly="true">Pago
                                            con <span id="tipo_pago"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" style="margin-bottom: 0px">
                                    <label for=""><strong>Moneda y Monto Total de la
                                            Cuota</strong></label>
                                    <p class="form-control" id="monto_total_cuota" style="margin-bottom: 0px"></p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" style="margin-bottom: 0px">
                                    <label for=""><strong>Estado de la Cuota</strong></label>
                                    <p class="form-control" id="estado_cuota" style="margin-bottom: 0px"></p>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist" style="justify-content: space-around">
                            <li style="width: 50%"><a class="nav-link active text-center" data-toggle="tab" href="#tab-detalles">Detalle del Pago</a></li>
                            <li style="width: 50%"><a class="nav-link text-center"  data-toggle="tab" href="#tab-otros">Otros Detalles <span id="count_otros"></span></a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-detalles" class="tab-pane active">
                                <div class="panel-body">
                                    <div id="body-header-detalle">
                                        <div id="pago_cheque" style="display: none">
                                            <div>
                                                @include('cobranzas.facturas_manuales._shared.modal_detalle.cheque')
                                            </div>
                                        </div>

                                        <div id="pago_tarjeta" style="display: none">
                                            <div>
                                                @include('cobranzas.facturas_manuales._shared.modal_detalle.tarjeta')
                                            </div>
                                        </div>

                                        <div id="pago_efectivo" style="display: none">
                                            <div>
                                                @include('cobranzas.facturas_manuales._shared.modal_detalle.efectivo')
                                            </div>
                                        </div>

                                        <div id="pago_transferencia" style="display: none">
                                            <div>
                                                @include('cobranzas.facturas_manuales._shared.modal_detalle.transferencia')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-otros" class="tab-pane">
                                <div class="panel-body">
                                    <div id="otros-nulos">
                                        <p class="text-center">Sin otros detalles</p>
                                    </div>
                                    <div class="detalle-otros-pago" style="display: none">

                                    </div>
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
