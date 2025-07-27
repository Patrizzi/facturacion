<!-- modal - Motivos -->
<div id="modal-motivos" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel3">Motivos</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="form_motivos">
                @csrf
                <input type="hidden" value="" name="motivos_edit_id" id="id_motivos_edit">
                <div class="row">
                    <div class="col-sm-4">
                            <input type="text" placeholder="Nombre" class="form-control m-b" name="nombre_motivos"
                                id="nombre_motivos_edit" autocomplete="off" required>
                    </div>
                        <div class="col-sm-4">
                            <select class="form-control" class="form-control m-b" name="select_motivos"
                            id="select_motivos" autocomplete="off" required>
                                <option value="Compras">Compras</option>
                                <option value="Ventas">Ventas</option>
                                <option value="Salidas">Salidas</option>
                                <!--<option value="Sin Asignar">Sin Asignar</option>-->
                            </select>
                        </div>

                        <div class="col-sm-4" style="text-align: center">
                            <button class="btn  btn-success " type="button" id="add_new_motivos" style="width: 49%"><i
                                    class="fa fa-plus"></i> Guardar</button>
                            <button class="btn  btn-success " type="button" id="update_motivos"
                                style="display: none;margin-top: 0px;width: 49%"><i class="fa fa-pencil"></i>
                                Actualizar</button>
                            <button class="btn  btn-danger " type="button" id="cancel_motivos" style="width: 49%"><i
                                    class="fa fa-pencil"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="input-group row">
                    <label class="col-sm-2 col-form-label text-center">Buscar:</label>
                    <input class="form-control col-sm-10" type="text" name="" id="search_motivos">
                </div>
                <br>
                <div class="table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped table-bordered dataTables-motivos">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Nombre</th>
                                <th style="width: 30%;">Tipo</th>
                                <th style="width: 25%;">Estado</th>
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
