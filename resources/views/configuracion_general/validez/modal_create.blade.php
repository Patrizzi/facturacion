<!-- modal - Validez -->
<div id="modal-forms8" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel7">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel7">Validez</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row">
                        <div class="col-10">
                            <input type="text" placeholder="Descripción: Tiempo ..." class="form-control m-b" autocomplete="off">
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
                <!--Fecha, Buscar y tabla-->
                <div class="row mb-3">
                    <div class="col-12 input-group">
                        <label class="col-sm-2 col-form-label">Buscar:</label>
                        <input class="form-control col-sm-8" type="text" name="" autocomplete="off">
                    </div>
                </div>
                <div class="table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center dataTables-validez">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                        <span hidden="hidden">{{$i=1}}</span>
                        @foreach($validez as $validezz)
                            <tr>
                            <td>{{$validezz->id}}</td>
                            <td>{{$validezz->descripcion}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
