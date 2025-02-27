<!-- modal - Categorías -->
<div id="modal-forms5" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel5">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel5">Categorías</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-6">
                        <select class="form-control" name="account">
                            <option>Servicios</option>
                            <option>Productos</option>
                            <option>Ventas</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Código: 0001" class="form-control m-b">
                    </div>
                    <div class="col-12 row">
                        <div class="col-10">
                            <input type="text" placeholder="Descripción:" class="form-control">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                </div>
                <hr>
                <!--Buscar y tabla-->
                <div class="row mb-3">
                    <div class="col-12 input-group">
                        <label class="col-md-2 col-sm-3 col-form-label">Buscar:</label>
                        <input type="text" class="form-control col-md-9 col-sm-8">
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
                </div>
            </div>
        </div>
    </div>
</div>
