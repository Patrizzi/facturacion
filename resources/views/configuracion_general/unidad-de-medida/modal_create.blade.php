<!-- modal - Unidad de medida -->
<div id="modal-forms2" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel2">Unidad de Medida</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row">
                        <div class="col-5">
                            <select class="form-control m-b" name="account">
                                <option>Bolsa</option>
                                <option>Kilogramos</option>
                                <option>Litros</option>
                                <option>option 4</option>
                            </select>
                        </div>
                        <div class="col-5">
                            <input type="text" placeholder="Símbolo: BOL" class="form-control m-b">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Unidad: 12" class="form-control">
                    </div>
                    <div class="col-6">
                        <input type="text" disabled="" placeholder="Fecha Actualización: 12-03-1997" class="form-control">
                    </div>
                </div>
                <hr>
                <!--Fecha, Buscar y tabla-->
                <div class="row mb-3">
                    <div class="input-group col-6">
                        <input class="form-control col-sm-10" type="text" name="daterangecambio" value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                        <span class="input-group-append">
                            <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                <i class="fa fa-history"></i>
                            </button>
                        </span>
                        <span class="input-group-append">
                            <button type="button" class="btn btn-primary" style="background-color:blue; border-color:blue;" onclick="limpiar_select()">
                                <i class="fa fa-eraser"></i>
                            </button>
                        </span>
                    </div>
                    <div class="input-group col-6">
                        <div class="col-4">
                            <label for="inputBuscar" class="col-form-label">Buscar:</label>
                         </div>
                        <div class="col-md-8">
                            <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                </div>
                <div class="row px-2 py-3 bg-light m-1 table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center dataTables-medida">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Símbolo</th>
                                <th style="width: 20%;">Medida</th>
                                <th style="width: 20%;">Unidad</th>
                                <th style="width: 30%;">Fecha Creación</th>
                                <th style="width: 30%;">Fecha Actualización</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unidad_de_medida as $u_medida)
                            <tr>
                                <td>{{$u_medida->simbolo}}</td>
                                <td>{{$u_medida->medida}}</td>
                                <td>{{$u_medida->unidad}}</td>
                                <td>{{$u_medida->created_at}}</td>
                                <td>{{$u_medida->updated_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
