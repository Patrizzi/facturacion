<!-- modal - Marcas -->
<div id="modal-forms7" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel7">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                    <div class="col-12 row">
                        <!--
                        <div class="col-5">
                            <select class="form-control m-b" name="account">
                                <option>Bolsa</option>
                                <option>Kilogramos</option>
                                <option>Litros</option>
                                <option>option 4</option>
                            </select>
                        </div>-->
                        <div class="col-10">
                            <input type="text" placeholder="Descripción: Empresa especializada en la creación de..." class="form-control m-b">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Nombre: Epson" class="form-control m-b">
                        <input type="text" placeholder="Teléfono: 981273890" class="form-control">
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Empresa: Epson Perú" class="form-control m-b">
                        <div class="row">
                            <div class="col-sm-7">
                                <input type="text" placeholder="Abreviatura: EP" class="form-control">
                            </div>
                            <div class="col-sm-5">
                                <!--<input type="text" placeholder="Foto" class="form-control">
                                <form action="#" class="dropzone" id="dropzoneForm">
                                    <div class="fallback">
                                        <input name="file" placeholder="Foto" type="file" multiple />
                                    </div>
                                </form>-->
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input id="inputGroupFile01" type="file" class="custom-file-input">
                                        <label class="custom-file-label" for="inputGroupFile01">Foto</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <!--Fecha, Buscar y tabla-->
                <div class="row mb-3 mx-1">
                    <div class="col-12 input-group row">
                        <label class="col-sm-2 col-form-label">Buscar:</label>
                        <input class="form-control col-sm-8" type="text" name="">
                    </div>
                </div>
                <div class="row px-2 py-3 bg-light m-1 table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center dataTables-marcas">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Nombre</th>
                                <th style="width: 5%;">Abreviatura</th>
                                <th style="width: 20%;">Teléfono</th>
                                <th style="width: 40%;">Descripción</th>
                                <th style="width: 20%;">Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($marcas as $marca)
                            <tr>
                                <td>{{$marca->nombre}}</td>
                                <td>{{$marca->abreviatura}}</td>
                                <td>@if($marca->telefono != null)
                                    {{$marca->telefono}}
                                @else
                                    Sin número
                                @endif
                                </td>
                                <td>{{$marca->descripcion}}</td>
                                <td>
                                @if(isset($marca->imagen))
                                <img name="imagen" src="{{asset('archivos/imagenes/marcas/'.$marca->imagen)}}" width="80px" height="80px"   />
                                @else
                                <img src="{{asset('img/logos/marca_ejemplo.svg')}}" width="80px">
                                @endif </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
