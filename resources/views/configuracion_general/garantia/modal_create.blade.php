<!-- modal - Garantía-->
<div id="modal-garantia" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel4">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel4">Garantía</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="form_garantia">
                    @csrf
                    <input type="hidden" value="" name="garantia_edit_id" id="id_garantia_edit">

                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" placeholder="Descripción" class="form-control m-b" name="descripcion_garantia"
                                id="descripcion_garantia" autocomplete="off">
                        </div>
                        <div class="col-sm-6" style="text-align: center">
                            <button class="btn  btn-success " type="button" id="add_new_garantia" style="width: 49%"><i
                                    class="fa fa-plus"></i> Guardar</button>
                            <button class="btn  btn-success " type="button" id="update_garantia"
                                style="display: none;margin-top: 0px;width: 49%"><i class="fa fa-pencil"></i>
                                Actualizar</button>
                            <button class="btn  btn-danger " type="button" id="cancel_garantia" style="width: 49%"><i
                                    class="fa fa-pencil"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="input-group row">
                    <label class="col-sm-2 col-form-label text-center">Buscar:</label>
                    <input class="form-control col-sm-10" type="text" name="" id="search_garantia">
                </div>
                <br>
                <div class="table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped table-bordered dataTables-garantia">
                        <thead>
                            <tr>
                                <th style="width: 35%;">Descripción</th>
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
