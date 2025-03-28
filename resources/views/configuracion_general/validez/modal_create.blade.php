<!-- modal - Validez -->
<div id="modal-validez" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel7">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel7">Validez</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="form_validez">
                    @csrf
                    <input type="hidden" value="" name="validez_edit_id" id="id_validez_edit">

                    <div class="row">
                        <div class="col-sm-7">
                            <input type="text" placeholder="Descripción" class="form-control m-b"
                                    name="descripcion_validez" id="descripcion_validez" autocomplete="off" required>
                        </div>

                        <div class="col-sm-5" style="text-align: center">
                            <button class="btn  btn-success " type="button" id="add_new_validez" style="width: 49%"><i
                                    class="fa fa-plus"></i> Guardar</button>
                            <button class="btn  btn-success " type="button" id="update_validez"
                                style="display: none;margin-top: 0px;width: 49%"><i class="fa fa-pencil"></i>
                                Actualizar</button>
                            <button class="btn  btn-danger " type="button" id="cancel_validez" style="width: 49%"><i
                                    class="fa fa-pencil"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="input-group row">
                    <label class="col-sm-2 col-form-label text-center">Buscar:</label>
                    <input class="form-control col-sm-10" type="text" name="" id="search_validez">
                </div>
                <br>
                <div class="table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped table-bordered dataTables-validez">
                        <thead>
                            <tr>
                                <th style="width: 70%;">Descripción</th>
                                <th style="width: 30%;">Estado</th>
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
