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
                <form action="" method="post" enctype="multipart/form-data" id="form_marca">
                    @csrf
                    <input type="hidden" value="" name="marca_edit_id" id="id_marca_edit">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" placeholder="Nombre" class="form-control m-b" name="nombre_marca"
                                id="nombre_marca" required autocomplete="off">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Teléfono" class="form-control" name="telefono_marca"
                                id="telefono_marca" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" placeholder="Empresa" class="form-control m-b" name="nombre_empresa"
                                id="empresa_marca" required autocomplete="off">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" placeholder="Abreviatura" class="form-control"
                                name="abreviatura_marca" autocomplete="off" id="abreviatura_marca" autocomplete="off">
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input id="logo" type="file" class="custom-file-input" id="file_marca"
                                        name="file_marca">
                                    <label for="logo" class="custom-file-label">Agregar Foto</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <input type="text" placeholder="Descripción" class="form-control m-b"
                                name="descripcion_marca" id="descripcion_marca" autocomplete="off">
                        </div>
                        <div class="col-sm-3" style="text-align: center">
                            <button class="btn  btn-success " type="button" id="add_new_marca" style="width: 49%"><i
                                    class="fa fa-plus"></i> Guardar</button>
                            <button class="btn  btn-success " type="button" id="update_marca"
                                style="display: none;margin-top: 0px;width: 49%"><i class="fa fa-pencil"></i>
                                Actualizar</button>
                            <button class="btn  btn-danger " type="button" id="cancel_marca" style="width: 49%"><i
                                    class="fa fa-pencil"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
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
