<!-- modal - Tipo de Cambio-->
<div id="modal-tipo_cambio" class="modal fade" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Tipo de Cambio</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                            <input class="form-control" type="text" name="daterange" id="search_tipo_cambio"
                                value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />   
                            <span class="input-group-append">
                                <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                    <i class="fa fa-history"></i>
                                </button>
                            </span>
                            <span class="input-group-append">
                                <button type="button" class="btn btn-primary" onclick="limpiar_select()">
                                    <i class="fa fa-eraser"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                    <br>
                    <div class="table-responsive">
                        <!--Tabla-->
                        <table class="table table-striped table-bordered dataTables-tipo_cambio">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Compra</th>
                                    <th style="width: 25%;">Venta</th>
                                    <th style="width: 25%;">Paralelo</th>
                                    <th style="width: 25%;">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>
