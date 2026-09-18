<!-- Modal DETRACCIONES DENTRO DEL FORM, EN EL CONTROLLER CONDICIONAL PARA TOMAR O NO DETRACCION-->
<div class="modal fade" id="modal_detraccion" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Configuración de
                    Detracciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="detraccion_valores">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-center text-bold">Por indicaciones de Sunat la
                                detracción se envía en Soles.</h3>
                            <div class="row">
                                <div class="col-sm-8">
                                    <label for=""><strong>Tipo de
                                            Detracción</strong></label>
                                    <select class="select2_tipodetrac ipt_detrac" name="tipo_detraccion"
                                        id="select_tipo_pago">
                                        <option value="">Seleccionar Tipo</option>
                                        @foreach ($detraccion as $detra)
                                            <option value="{{ $detra->id }}">
                                                {{ $detra->codigo }} -
                                                {{ $detra->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div class="detracc_campo_required">
                                        <small>Selecciona un campo</small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for=""><strong>Porcentaje de
                                            Detraccion</strong></label>
                                    <input type="text" class="form-control ipt_detrac" name="porcentaje_detraccion"
                                        id="porcentaje_detc">
                                    <div class="detracc_campo_required">
                                        <small>Rellena este campo</small>
                                    </div>
                                </div>
                            </div>
                            <hr style="margin-top: 5px; margin-bottom: 5px">
                            <div class="row">
                                <div class="col-sm-8">
                                    <label for=""><strong>Medio de
                                            Pago</strong></label>
                                    <select class="select2_mediopago ipt_detrac" name="medio_pago_detraccion"
                                        id="">
                                        <option value="">Seleccionar Medio de Pago
                                        </option>
                                        @foreach ($medio_pago as $m_pago)
                                            <option value="{{ $m_pago->id }}">
                                                {{ $m_pago->codigo }} -
                                                {{ $m_pago->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div class="detracc_campo_required">
                                        <small>Selecciona un campo</small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for=""><strong>Total de
                                            Detracción</strong></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">S/.</span>
                                        </div>
                                        <input type="text" class="form-control ipt_detrac" name="total_detraccion"
                                            id="tota_detra" placeholder="0.00" readonly>
                                    </div>

                                    <div class="detracc_campo_required">
                                        <small>Rellena este campo</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-sm-6">

                                                </div> --}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="save_detraccion()">Verificar</button>
            </div>
        </div>
    </div>
</div>
