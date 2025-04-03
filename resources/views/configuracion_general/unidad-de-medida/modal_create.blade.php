<!-- modal - Unidad de medida -->
<div id="modal-medida" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel2">Unidad de Medida</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">
                <form action="" method="post" enctype="" id="form_medida">
                    @csrf
                    <input type="hidden" value="" name="medida_edit_id" id="id_medida_edit">
                    <div class="row">
                        <div class="col-sm-8">
                            <input type="text" placeholder="Nombre U.Medida: " class="form-control m-b" name="nombre_medida" id="nombre_medida" required>
                        </div>
                        <div class="col-sm-4" style="text-align: center;">
                            <button class="btn btn-success " type="button" id="add_new_medida"
                                style="background-color:blue; border-color:blue; width: 49%"><i class="fa fa-plus"></i> Guardar</button>
                            <button class="btn btn-success " type="button" id="update_medida"
                                style="background-color:blue; border-color:blue; display: none; margin-top: 0px; width: 49%"><i class="fa fa-pencil"></i> Actualizar</button>
                            <button class="btn btn-danger " type="button" id="cancel_medida" style="width: 49%">
                                <i class="fa fa-pencil"></i> Cancelar</button>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" placeholder="Símbolo: BOL" class="form-control" name="simbolo_medida" id="simbolo_medida" required  autocomplete="off">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Unidad: 12" class="form-control" name="unidad_medida" id="unidad_medida" autocomplete="off" required>
                        </div>
                    </div>
                    <hr>
                    <!--Fecha, Buscar y tabla
                    <div class="row mb-3">
                        <div class="input-group col-6">
                            <input class="form-control col-sm-10" type="text" name="daterangecambio" value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" autocomplete="off"/>
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
                        <div class="input-group col-6 row">
                            <label class="col-sm-2 col-form-label text-center">Buscar:</label>
                            <input type="text" class="form-control col-sm-10" name="" id="search_medida">
                        </div>
                    </div>-->
                    <div class="input-group row">
                        <label class="col-sm-2 col-form-label text-center">Buscar:</label>
                        <input type="text" class="form-control col-sm-10" name="" id="search_medida">
                    </div>
                    <br>
                    <div class="table-responsive">
                        <!--Tabla-->
                        <table class="table table-striped text-md-center table-bordered dataTables-medidas"><!-- dataTables-medida -->
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Símbolo</th>
                                    <th style="width: 20%;">Medida</th>
                                    <th style="width: 20%;">Unidad</th>
                                    <!--<th style="width: 30%;">Fecha Creación</th>
                                    <th style="width: 30%;">Fecha Actualización</th>-->
                                </tr>
                            </thead>
                            <tbody>
                               {{--
                                 @foreach($unidad_de_medida as $u_medida)
                                <tr>
                                    <td>{{$u_medida->simbolo}}</td>
                                    <td>{{$u_medida->medida}}</td>
                                    <td>{{$u_medida->unidad}}</td>
                                    <td>{{$u_medida->created_at}}</td>
                                    <td>{{$u_medida->updated_at}}</td>
                                </tr>
                                @endforeach
                               --}}
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
