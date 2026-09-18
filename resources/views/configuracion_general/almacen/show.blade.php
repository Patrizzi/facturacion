<div class="row">
    <div class="col-sm-3">
        <div style="display: flex;flex-direction: column;justify-content: space-between;height: 100%;">
            <div>
                <center>
                    <h2>Editar Almacen</h2>
                    <img src="{{ asset('img/icons/almacen.svg') }}" width="100px" style="margin-right: 10px;">
                    <h3 ><strong id="titulo_almacen_show">Almacen</strong></h3>
                </center>
            </div>
            <button type="button" class="btn btn-block btn-default" id="cancel_button_show">Cancelar</button>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="tabs-container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab6-tab" data-toggle="tab" href="#tab_show_general" role="tab"
                        aria-controls="tab3" aria-selected="true">Información General</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab7-tab" data-toggle="tab" href="#tab_show_sunat" role="tab"
                        aria-controls="tab4" aria-selected="false">Información de la Sunat</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" id="tab_show_general" class="tab-pane active show"
                    style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                    <input type="hidden" id="almacen_id_show">
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class=""><strong>Nombre:</strong></label>
                                <input type="text" class="form-control" readonly id="almacen_nombre_show">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class=""><strong>Responsable:</strong></label>
                                {{-- <select required
                                        class="form-control select2-responsable_show" id="almacen_responsable_show"
                                        autocomplete="off" readonly="" required="required" style="margin-bottom: 0px;">
                                        <option value=""></option>
                                        @foreach ($personal as $personals)
                                            <option value="{{ $personals->id }}"> {{ $personals->nombres }}
                                                {{ $personals->apellidos }}</option>
                                        @endforeach
                                    </select> --}}
                                <input type="text" class="form-control" readonly id="almacen_responsable_show">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class=""><strong>Direccion</strong></label>
                                <input type="text" class="form-control" readonly id="almacen_direccion_show">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class=""><strong>Abreviatura</strong></label>
                                <input type="text" class="form-control" readonly id="almacen_abreviatura_show">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class=""><strong>Codigo Ubigeo</strong></label>
                                <input type="text" class="form-control" readonly id="almacen_ubigeo_show">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class=""><strong>Codigo Sunat:</strong></label>
                                <input type="text" class="form-control" readonly id="almacen_sunat_show">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class=""><strong>Descripcion:</strong></label>
                                <input type="text" class="form-control" readonly id="almacen_descripcion_show">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_show_sunat" role="tabpanel">
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class=""><strong>Factura</strong></label>
                                <div class="row">
                                    <div class="col-sm-6 col-left-c">
                                        <input type="text" class="form-control" readonly id="sunat_factura_show"
                                            placeholder="Serie F-">
                                    </div>
                                    <div class="col-sm-6 col-right-c">
                                        <input type="text" class="form-control" readonly
                                            id="correlativo_factura_show" placeholder="Correlativo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class=""><strong>Boleta</strong></label>
                                <div class="row">
                                    <div class="col-sm-6 col-left-c">
                                        <input type="text" class="form-control" readonly id="sunat_boleta_show"
                                            placeholder="Serie B-">
                                    </div>
                                    <div class="col-sm-6 col-right-c">
                                        <input type="text" class="form-control" readonly
                                            id="correlativo_boleta_show" placeholder="Correlativo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class=""><strong>Guia Remision</strong></label>
                                <div class="row">
                                    <div class="col-sm-6 col-left-c">
                                        <input type="text" class="form-control" readonly id="sunat_remision_show"
                                            placeholder="Serie T-">
                                    </div>
                                    <div class="col-sm-6 col-right-c">
                                        <input type="text" class="form-control" readonly
                                            id="correlativo_remision_show" placeholder="Correlativo">
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
                                        <input type="text" class="form-control" readonly id="sunat_factura_m_show"
                                            placeholder="Serie FA-">
                                    </div>
                                    <div class="col-sm-6 col-right-c">
                                        <input type="text" class="form-control" readonly
                                            id="correlativo_factura_m_show" placeholder="Correlativo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class=""><strong>Boleta Manual</strong></label>
                                <div class="row">
                                    <div class="col-sm-6 col-left-c">
                                        <input type="text" class="form-control" readonly id="sunat_boleta_m_show"
                                            placeholder="Serie BA-">
                                    </div>
                                    <div class="col-sm-6 col-right-c">
                                        <input type="text" class="form-control" readonly
                                            id="correlativo_boleta_m_show" placeholder="Correlativo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class=""><strong>Guia Remision Manual</strong></label>
                                <div class="row">
                                    <div class="col-sm-6 col-left-c">
                                        <input type="text" class="form-control" readonly
                                            id="sunat_remision_m_show" placeholder="Serie TA-">
                                    </div>
                                    <div class="col-sm-6 col-right-c">
                                        <input type="text" class="form-control" readonly
                                            id="correlativo_remision_m_show" placeholder="Correlativo">
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
                                        <input type="text" class="form-control" readonly
                                            id="sunat_credit_fact_show" placeholder="Serie FF-">
                                    </div>
                                    <div class="col-sm-6 col-right-c">
                                        <input type="text" class="form-control" readonly
                                            id="correlativo_credit_fact_show" placeholder="Correlativo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class=""><strong>Nota de Crédito Boleta</strong></label>
                                <div class="row">
                                    <div class="col-sm-6 col-left-c">
                                        <input type="text" class="form-control" readonly
                                            id="sunat_credit_bol_show" placeholder="Serie BB-">
                                    </div>
                                    <div class="col-sm-6 col-right-c">
                                        <input type="text" class="form-control" readonly
                                            id="correlativo_credit_bol_show" placeholder="Correlativo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class=""><strong>Nota de Débito</strong></label>
                                <div class="row">
                                    <div class="col-sm-6 col-left-c">
                                        <input type="text" class="form-control" readonly id="sunat_debito_show"
                                            placeholder="Serie FF-">
                                    </div>
                                    <div class="col-sm-6 col-right-c">
                                        <input type="text" class="form-control" readonly
                                            id="correlativo_debito_show" placeholder="Correlativo">
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
