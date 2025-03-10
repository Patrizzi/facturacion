<!-- modal - Tipo de Cambio-->
<div id="modal-forms" class="modal fade" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Tipo de Cambio</h3>
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
                                <option>Dolar</option>
                                <option>Sol</option>
                            </select>
                        </div>
                        <div class="col-5">
                            <input type="text" placeholder="Paralelo Compra: 3.69" class="form-control m-b" autocomplete="off">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <input type="text" disabled="" placeholder="Venta: 3.74" class="form-control" autocomplete="off">
                    </div>
                    <div class="col-6">
                        <input type="text" disabled="" placeholder="Compra: 3.75" class="form-control" autocomplete="off">
                    </div>
                </div>
                <hr>
                <!--Buscar y tabla-->
                <div class="col-12 mb-3">
                    <div class=" input-group row">
                        <input class="form-control" type="text" name="daterangecambio" value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" autocomplete="off"/>
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
                </div>
                <div class="table-responsive p-2">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center dataTables-cambio12">
                        <thead>
                            <tr>
                                <th>Compra</th>
                                <th>Venta</th>
                                <th>Paralelo C.</th>
                                <th>Fecha Actualización</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tipo_cambio as $tipo_cambios)
                            <tr>
                                <td>{{$tipo_cambios->compra}}</td>
                                <td>{{$tipo_cambios->venta}}</td>
                                <td>{{$tipo_cambios->paralelo}}</td>
                                <td>{{$tipo_cambios->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
