<!--Modal Crear correo-->
<div class="modal fade bd-example-modal-lg" id="crear" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelCrear" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="min-width:70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabelCrear">Crear Correo</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">
                        CORREO
                    </div>
                    <div class="panel-body">
                        <p class="d-flex justify-content-end"><strong>De: </strong>desarrollo@jypsac.com</p>

                        <div class="row mt-3">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Para:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="info@jypsac.com">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Cc:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="Cc">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">Asunto:</label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control" placeholder="25">
                            </div>
                        </div>
                        <div class="summernote">
                            <h3>Lorem Ipsum is simply</h3>
                            dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
                            when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
                            typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                            <br/>
                            <br/>
                            <ul>
                                <li>Remaining essentially unchanged</li>
                                <li>Make a type specimen book</li>
                                <li>Unknown printer</li>
                            </ul>
                        </div>
                        <div class="row mt-4">
                            <div class="col-9">
                                <div class="custom-file">
                                    <input id="logo" type="file" class="custom-file-input">
                                    <label for="logo" class="custom-file-label"><i class="fa fa-cloud-upload"></i> Adjuntar</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group row">
                                    <label class="col-sm-7 col-form-label">Insertar Firma:</label>
                                    <div class="col-sm-5">
                                        <input type="checkbox" class="js-switch" checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-10">
                                <button type="button" class="btn btn-warning">Guardar</button>
                                <button type="button" class="btn btn-danger">Eliminar</button>
                                <button type="button" class="btn btn-secondary">Cancelar</button>
                            </div>
                            <div clas="col-2">
                                <button type="button" class="btn btn-primary"><i class="fa fa-cloud-upload"></i> Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
