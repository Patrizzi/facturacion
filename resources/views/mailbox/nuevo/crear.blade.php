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
                                <div class="form-group row mb-0">
                                    <label class="col-sm-2 col-form-label">Para:</label>
                                    <div class="col-sm-10">
                                        <select data-placeholder="Destinatario" class="chosen-select" multiple style="width:350px;" tabindex="4">
                                            <option value="">Select</option>
                                            <option value="info@jypsac.com">info@jypsac.com</option>
                                            <option value="mica@gmail.com">mica@gmail.com</option>
                                            <option value="Afghanistan">Afghanistan</option>
                                            <option value="Aland Islands">Aland Islands</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="American Samoa">American Samoa</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Anguilla">Anguilla</option>
                                            <option value="Antarctica">Antarctica</option>
                                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Aruba">Aruba</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaijan">Azerbaijan</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-2 col-form-label">Cc:</label>
                                    <div class="col-sm-10">
                                        <select data-placeholder=" " class="chosen-select" multiple style="width:350px;" tabindex="4">
                                            <option value="">Select</option>
                                            <option value="info@jypsac.com">info@jypsac.com</option>
                                            <option value="mica@gmail.com">mica@gmail.com</option>
                                            <option value="Afghanistan">Afghanistan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mt-3">
                            <label class="col-sm-1 col-form-label">Asunto:</label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control">
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
                        <div class="row mx-0 mt-4">
                            <div class="col-9 align-content-center pl-0">
                                <div class="custom-file">
                                    <input id="logo" type="file" class="custom-file-input">
                                    <label for="logo" class="custom-file-label"><i class="fa fa-cloud-upload"></i> Adjuntar</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <label class="col-sm-7 col-form-label">Insertar Firma:</label>
                                    <div class="col-sm-5">
                                        <input type="checkbox" class="js-switch" checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mx-0 d-flex justify-content-between">
                            <div class="col-auto px-0">
                                <button type="button" class="btn btn-warning"><i class="fa fa-cloud-upload"></i> Guardar</button>
                                <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                                <button type="button" class="btn btn-secondary"><i class="fa fa-times-circle"></i> Cancelar</button>
                            </div>
                            <div clas="col-auto">
                                <button type="button" class="btn btn-primary"><i class="fa fa-send"></i> Enviar</button> <!--<i class="fa fa-reply"></i><i class="fa fa-share"></i>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
