<div class="row">
    <div class="col-sm-3">
        <div style="display: flex;flex-direction: column;justify-content: space-between;height: 100%;">
            <div>
                <center>
                    <h2>Crear Almacen</h2>
                    <img src="{{ asset('img/icons/almacen.svg') }}" width="100px" style="margin-right: 10px;">
                    <h3 id="titulo_almacen">Almacen N°</h3>
                </center>
            </div>
            <button type="button" class="btn btn-block btn-default" id="cancel_button_create">Cancelar</button>
        </div>
    </div>
    <div class="col-sm-9">
        <form action="" id="form_create">
            @csrf
            <div class="tabs-container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab5-tab" data-toggle="tab" href="#tab_0_create" role="tab"
                            aria-controls="tab3" aria-selected="true">Información General</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab6-tab" data-toggle="tab" href="#tab_1_sunat_create" role="tab"
                            aria-controls="tab4" aria-selected="false">Información de la Sunat</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab_0_create" class="tab-pane active show"
                        style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                        <input type="hidden" name="almacen_id_create" id="almacen_id_create">
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class=""><strong>Nombre:</strong></label>
                                    <input type="text" class="form-control" name="almacen_nombre_create"
                                        id="almacen_nombre_create">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class=""><strong>Responsable:</strong></label>
                                    <select name="almacen_responsable_create" required
                                        class="form-control select2-responsable_create" id="almacen_responsable_create"
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
                                    <input type="text" class="form-control" name="almacen_direccion_create"
                                        id="almacen_direccion_create">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class=""><strong>Abreviatura</strong></label>
                                    <input type="text" class="form-control" name="almacen_abreviatura_create"
                                        id="almacen_abreviatura_create">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class=""><strong>Codigo Ubigeo</strong></label>
                                    <input type="text" class="form-control" name="almacen_ubigeo_create"
                                        id="almacen_ubigeo_create">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class=""><strong>Codigo Sunat:</strong></label>
                                    <input type="text" class="form-control" name="almacen_sunat_create"
                                        id="almacen_sunat_create">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class=""><strong>Descripcion:</strong></label>
                                    <input type="text" class="form-control" name="almacen_descripcion_create"
                                        id="almacen_descripcion_create">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="display: flex;justify-content: center">
                                <button type="button" class="btn btn-block btn-primary save_create"
                                    style="max-width: 200px">Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_1_sunat_create" role="tabpanel">
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Factura</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_factura_create"
                                                id="sunat_factura_create" placeholder="Serie F-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_factura_create" id="correlativo_factura_create"
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
                                            <input type="text" class="form-control" name="sunat_boleta_create"
                                                id="sunat_boleta_create" placeholder="Serie B-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control" name="correlativo_boleta_create"
                                                id="correlativo_boleta_create" placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Guia Remision</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_remision_create"
                                                id="sunat_remision_create" placeholder="Serie T-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_remision_create" id="correlativo_remision_create"
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
                                            <input type="text" class="form-control" name="sunat_factura_m_create"
                                                id="sunat_factura_m_create" placeholder="Serie FA-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_factura_m_create" id="correlativo_factura_m_create"
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
                                            <input type="text" class="form-control" name="sunat_boleta_m_create"
                                                id="sunat_boleta_m_create" placeholder="Serie BA-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_boleta_m_create" id="correlativo_boleta_m_create"
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
                                            <input type="text" class="form-control" name="sunat_remision_m_create"
                                                id="sunat_remision_m_create" placeholder="Serie TA-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_remision_m_create" id="correlativo_remision_m_create"
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
                                            <input type="text" class="form-control" name="sunat_credit_fact_create"
                                                id="sunat_credit_fact_create" placeholder="Serie FF-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_credit_fact_create" id="correlativo_credit_fact_create"
                                                placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class=""><strong>Nota de Crédito Boleta</strong></label>
                                    <div class="row">
                                        <div class="col-sm-6 col-left-c">
                                            <input type="text" class="form-control" name="sunat_credit_bol_create"
                                                id="sunat_credit_bol_create" placeholder="Serie BB-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control"
                                                name="correlativo_credit_bol_create" id="correlativo_credit_bol_create"
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
                                            <input type="text" class="form-control" name="sunat_debito_create"
                                                id="sunat_debito_create" placeholder="Serie FF-">
                                        </div>
                                        <div class="col-sm-6 col-right-c">
                                            <input type="text" class="form-control" name="correlativo_debito_create"
                                                id="correlativo_debito_create" placeholder="Correlativo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="display: flex;justify-content: center">
                                <button type="button" class="btn btn-block btn-primary save_create"
                                    style="max-width: 200px">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
