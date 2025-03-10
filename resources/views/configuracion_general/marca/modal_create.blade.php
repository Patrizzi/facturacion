<!-- modal - Marcas -->
<div id="modal-marcas" class="modal fade modal-xl-manual" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel7">
    <div class="modal-dialog modal-dialog-centered modal-xl-manual">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel7">Marcas</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">

                    {{-- <div class="col-6">
                        <input type="text" placeholder="Nombre" class="form-control m-b" name="nombre">
                        <input type="text" placeholder="Teléfono" class="form-control" name="telefono">
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Empresa" class="form-control m-b" name="nombre_empresa">
                        <div class="row">
                            <div class="col-sm-7">
                                <input type="text" placeholder="Abreviatura" class="form-control" name="abreviatura">
                            </div>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input id="logo" type="file" class="custom-file-input">
                                        <label for="logo" class="custom-file-label">Foto</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-12 row">
                        <div class="col-lg-10">
                            <input type="text" placeholder="Descripción" class="form-control m-b" name="descripcion">
                        </div>
                        <div class="col-lg-1">
                            <button class="btn  btn-success btn-sm" type="button"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-lg-1">
                            <button class="btn  btn-success btn-sm" type="button"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div> --}}
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" placeholder="Nombre" class="form-control m-b" name="nombre">
                    </div>
                    <div class="col-sm-6">
                        <input type="text" placeholder="Teléfono" class="form-control" name="telefono">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" placeholder="Empresa" class="form-control m-b" name="nombre_empresa">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Abreviatura" class="form-control" name="abreviatura">
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <div class="custom-file">
                                <input id="logo" type="file" class="custom-file-input">
                                <label for="logo" class="custom-file-label">Foto</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <input type="text" placeholder="Descripción" class="form-control m-b" name="descripcion">
                    </div>
                    <div class="col-sm-2">
                        <button class="btn  btn-success btn-sm" type="button"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn  btn-success btn-sm" type="button"><i class="fa fa-pencil"></i></button>
                    </div>
                </div>
                <hr>
                <!--Fecha, Buscar y tabla-->
                <div class="input-group row">
                    <label class="col-sm-2 col-form-label text-center">Buscar:</label>
                    <input class="form-control col-sm-10" type="text" name="" id="search_marca">
                </div>
                <br>
                <div class="table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped table-bordered dataTables-marcas">
                        <thead>
                            <tr>
                                <th style="width: 15%;">Nombre</th>
                                <th style="width: 10%;">Abreviatura</th>
                                <th style="width: 15%;">Teléfono</th>
                                <th style="width: 45%;">Descripción</th>
                                <th style="width: 15%;">Foto</th>
                                <th style="width: 5%;">Estado</th>
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
