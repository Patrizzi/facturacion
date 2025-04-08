<!-- modal - alarma -->
<div id="modal-alarma" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel5">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel8">Alarma</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="form_alarma">
                    @csrf
                    <input type="hidden" value="" name="alarma_edit_id" id="id_alarma_edit">

                    <div class="row">
                        <div class="col-sm-2">
                            <input type="text" placeholder="Tipo" class="form-control m-b" name="tipo_alarma"
                                id="tipo_alarma" autocomplete="off">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Descripción" class="form-control m-b"
                                    name="descripcion_alarma" id="descripcion_alarma_edit" autocomplete="off" required>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Alarma" class="form-control m-b" name="alarma_alarma"
                                id="alarma_alarma" autocomplete="off">
                        </div>
                        <div class="col-sm-4" style="text-align: center">
                            <button class="btn  btn-success " type="button" id="add_new_alarma" style="width: 49%"><i
                                    class="fa fa-plus"></i> Guardar</button>
                            <button class="btn  btn-success " type="button" id="update_alarma"
                                style="display: none;margin-top: 0px;width: 49%"><i class="fa fa-pencil"></i>
                                Actualizar</button>
                            <button class="btn  btn-danger " type="button" id="cancel_alarma" style="width: 49%"><i
                                    class="fa fa-pencil"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="input-group row">
                    <label class="col-sm-2 col-form-label text-center">Buscar:</label>
                    <input class="form-control col-sm-10" type="text" name="" id="search_alarma">
                </div>
                <br>
                <div class="table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped table-bordered dataTables-alarma">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Codigo / Descripción</th>
                                <th style="width: 20%;">Tipo</th>
                                <th style="width: 20%;">Alarma</th>
                                <th style="width: 20%;">Estado</th>
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
