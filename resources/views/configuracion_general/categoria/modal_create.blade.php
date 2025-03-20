<!-- modal - Categorías -->
<div id="modal-categorias" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel5">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel5">Categorías</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="form_categoria">
                    @csrf
                    <input type="hidden" value="" name="categoria_edit_id" id="id_categoria_edit">

                    <div class="row">
                        <div class="col-sm-4">
                            <input type="text" placeholder="Codigo" class="form-control m-b" name="codigo_categoria"
                                id="codigo_categoria_edit" autocomplete="off">
                        </div>
                        <div class="col-sm-8">
                            <input type="text" placeholder="Descripción" class="form-control m-b"
                                    name="descripcion_categoria" id="descripcion_categoria" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" style="text-align: center">
                            <button class="btn  btn-success " type="button" id="add_new_categoria" style="width: 49%"><i
                                    class="fa fa-plus"></i> Guardar</button>
                            <button class="btn  btn-success " type="button" id="update_categoria"
                                style="display: none;margin-top: 0px;width: 49%"><i class="fa fa-pencil"></i>
                                Actualizar</button>
                            <button class="btn  btn-danger " type="button" id="cancel_categoria" style="width: 49%"><i
                                    class="fa fa-pencil"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="input-group row">
                    <label class="col-sm-2 col-form-label text-center">Buscar:</label>
                    <input class="form-control col-sm-10" type="text" name="" id="search_categoria">
                </div>
                <br>
                <div class="table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped table-bordered dataTables-categorias">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Codigo</th>
                                <th style="width: 65%;">Descripción</th>
                                <th style="width: 10%;">Estado</th>
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



                <!--Contenido de modal
                <div class="row">
                    <div class="col-6">
                        <select class="form-control" name="account">
                            <option>Servicios</option>
                            <option>Productos</option>
                            <option>Ventas</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Código: 0001" class="form-control m-b" autocomplete="off">
                    </div>
                    <div class="col-12 row">
                        <div class="col-10">
                            <input type="text" placeholder="Descripción:" class="form-control" autocomplete="off">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                </div>
                <hr>-->
                <!--Buscar y tabla-->
                {{-- <div class="row mb-3">
                    <div class="col-12 input-group">
                        <label class="col-md-2 col-sm-3 col-form-label">Buscar:</label>
                        <input type="text" class="form-control col-md-9 col-sm-8" autocomplete="off">
                    </div>
                </div>
                <div class="row bg-light p-3 m-1 table-responsive">
                    <table class="table table-striped text-md-center dataTables-categorias">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorias as $categoria)
                            <tr>
                                <td>{{$categoria->codigo}}</td>
                                <td>{{$categoria->descripcion}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}

