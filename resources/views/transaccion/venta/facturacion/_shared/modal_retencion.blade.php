<div class="modal fade bd-example-modal-lg" id="modal_retencion" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Calculo de Retención</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="detraccion_valores">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-center text-bold">El monto enviado a Sunat depende de la moneda seleccionada
                            </h3>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for=""><strong>Porcentaje de
                                            Retención</strong></label>
                                    <input type="text" class="form-control ipt_reten" name="porcentaje_retencion"
                                        id="porcentaje_ret">
                                    <div class="retenc_campo_required">
                                        <small>Rellena este campo</small>
                                    </div>
                                </div>
                            </div>
                            <hr style="margin-top: 5px; margin-bottom: 5px">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for=""><strong>Total de
                                            Retencion</strong></label>
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon"
                                                id="simbolo_retencion">{{ $moneda->simbolo }}</span>
                                        </div>
                                        <input type="text" class="form-control ipt_ret" name="total_retencion"
                                            id="tota_reten" placeholder="0.00" readonly>
                                    </div>

                                    <div class="retenc_campo_required">
                                        <small>Rellena este campo</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
