<!-- modal - Tipo de Cambio-->
<div id="modal-almacen" class="modal fade modal-xl-manual" style="display: none;" aria-hidden="true"
    data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl-manual">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Almacenes</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- {{ date('m/t/Y') }} --}}
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                            <input class="form-control" type="text" name="daterange_tipo_cambio"
                                id="search_tipo_cambio" value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}" />
                            <span class="input-group-append">
                                <button type="button" class="btn btn-primary" onclick="limpiar_select_tc()">
                                    <i class="fa fa-eraser"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped table-bordered dataTables-almacen">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Abreviatura</th>
                                <th>Direccion</th>
                                <th>Responsable</th>
                                <th>Acciones</th>
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
