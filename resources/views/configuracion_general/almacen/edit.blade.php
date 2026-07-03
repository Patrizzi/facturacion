<div class="row">
    <div class="col-sm-3">
        <div style="display: flex;flex-direction: column;justify-content: space-between;height: 100%;">
            <div>
                <center>
                    <h2>Editar Almacen</h2>
                    <img src="{{ asset('img/icons/almacen.svg') }}" width="100px" style="margin-right: 10px;">
                    <h3 id="titulo_almacen">Almacen N°</h3>
                </center>
            </div>
            <button type="button" class="btn btn-block btn-default" id="cancel_button_edit">Cancelar</button>
        </div>
    </div>
    <div class="col-sm-9">
        <form action="" id="form_edit">
            @csrf
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab3-tab" data-toggle="tab" href="#tab_0_general" role="tab"
                            aria-controls="tab3" aria-selected="true">Información General</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab_1_sunat" role="tab"
                            aria-controls="tab4" aria-selected="false">Información de la Sunat</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab_0_general" class="tab-pane active show"
                        style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                        <input type="hidden" name="almacen_id_edit" id="almacen_id_edit">
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class=""><strong>Nombre:</strong></label>
                                    <input type="text" class="form-control" name="almacen_nombre_edit"
                                        id="almacen_nombre_edit">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class=""><strong>Responsable:</strong></label>
                                    <select name="almacen_responsable_edit" required
                                        class="form-control select2-responsable_edit" id="almacen_responsable_edit"
                                        autocomplete="off" required="required" style="margin-bottom: 0px;">
                                        <option value=""></option>
                                        @foreach ($personal as $personals)
                                            <option value="{{ $personals->id }}"> {{ $personals->nombres }}
                                                {{ $personals->apellidos }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class=""><strong>Direccion</strong></label>
                                    <input type="text" class="form-control" name="almacen_direccion_edit"
                                        id="almacen_direccion_edit">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class=""><strong>Abreviatura</strong></label>
                                    <input type="text" class="form-control" name="almacen_abreviatura_edit"
                                        id="almacen_abreviatura_edit">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class=""><strong>Codigo Ubigeo</strong></label>
                                    <input type="text" class="form-control" name="almacen_ubigeo_edit"
                                        id="almacen_ubigeo_edit">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class=""><strong>Codigo Sunat:</strong></label>
                                    <input type="text" class="form-control" name="almacen_sunat_edit"
                                        id="almacen_sunat_edit">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class=""><strong>Descripcion:</strong></label>
                                    <input type="text" class="form-control" name="almacen_descripcion_edit"
                                        id="almacen_descripcion_edit">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="display: flex;justify-content: center">
                                <button type="button" class="btn btn-block btn-primary save_edit"
                                    style="max-width: 200px">Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_1_sunat" role="tabpanel">
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Factura</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_factura_edit"
                                                id="sunat_factura_edit" placeholder="Serie F-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_factura_edit" id="correlativo_factura_edit"
                                                placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Boleta</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_boleta_edit"
                                                id="sunat_boleta_edit" placeholder="Serie B-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control" name="correlativo_boleta_edit"
                                                id="correlativo_boleta_edit" placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Guia Remision</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_remision_edit"
                                                id="sunat_remision_edit" placeholder="Serie T-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_remision_edit" id="correlativo_remision_edit"
                                                placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Factura Manual</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_factura_m_edit"
                                                id="sunat_factura_m_edit" placeholder="Serie FA-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_factura_m_edit" id="correlativo_factura_m_edit"
                                                placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Boleta Manual</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_boleta_m_edit"
                                                id="sunat_boleta_m_edit" placeholder="Serie BA-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_boleta_m_edit" id="correlativo_boleta_m_edit"
                                                placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Guia Remision Manual</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_remision_m_edit"
                                                id="sunat_remision_m_edit" placeholder="Serie TA-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_remision_m_edit" id="correlativo_remision_m_edit"
                                                placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Nota Crédito Factura</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_credit_fact_edit"
                                                id="sunat_credit_fact_edit" placeholder="Serie FF-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control" name="correlativo_credit_fact_edit"
                                                id="correlativo_credit_fact_edit" placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Nota de Crédito Boleta</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_credit_bol_edit"
                                                id="sunat_credit_bol_edit" placeholder="Serie BB-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_credit_bol_edit" id="correlativo_credit_bol_edit"
                                                placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Nota de Débito</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_debito_edit"
                                                id="sunat_debito_edit" placeholder="Serie FF-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control" name="correlativo_debito_edit"
                                                id="correlativo_debito_edit" placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="display: flex;justify-content: center">
                                <button type="button" class="btn btn-block btn-primary save_edit"
                                    style="max-width: 200px">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
