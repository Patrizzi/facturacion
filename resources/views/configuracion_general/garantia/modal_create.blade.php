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
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row mb-3">
                        <div class="col-10">
                            <input type="text" placeholder="Descripción:" class="form-control" autocomplete="off">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button"
                                style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button"
                                style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <select class="form-control" name="account">
                            <option>Extendida</option>
                            <option>Anual</option>
                            <option>option 3</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Duración: 3 meses" class="form-control" autocomplete="off">
                    </div>
                </div>
                <hr>
                <!--Buscar y tabla-->
                <div class="row mb-3">
                    <div class="col-12 input-group row">
                        <label class="col-md-2 col-sm-3 col-form-label">Buscar:</label>
                        <input type="text" class="form-control col-md-9 col-sm-8" autocomplete="off">
                    </div>
                </div>
                <div class="row bg-light table-responsive pt-3">
                    <table class="col-12 table table-striped text-md-center dataTables-garantia">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Duración</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <span hidden="hidden">{{ $i = 1 }}</span>
                        <tbody>
                            {{-- @foreach ($garantia as $garantias)
                                <tr>
                                    <td>{{ $garantias->descripcion }}</td>
                                    <td style="color: red;">5 años</td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
