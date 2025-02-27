<!-- modal - Motivos -->
<div id="modal-forms3" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel3">Motivos</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row mb-3">
                        <div class="col-10">
                            <select class="form-control" name="account">
                                <option>Compras</option>
                                <option>Ventas</option>
                            </select>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="text" placeholder="Nombre: Compras locales" class="form-control">
                    </div>
                </div>
                <hr>
                <div class="">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs active show" role="tablist">
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1"> Entradas

                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-2"> Salidas

                                </a>
                            </li>
                        </ul>

                        <!-- Tablas y su contenido -->
                        <div class="tab-content" >
                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body table-responsive">

                                    <div class="col-12 input-group row">
                                        <input class="col-lg-12 form-control" type="text" name="daterangemotivos1" value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
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
                                    <br>

                                    <table class="table table-striped text-md-center dataTables-motivos1">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Fecha de Modificación</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($motivos_compra as $m_compras)
                                            <tr>
                                            <td>{{$m_compras->nombre}}</td>
                                            <td>{{ \Carbon\Carbon::parse($m_compras->updated_at)->format('d/m/Y H:i:s')}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body table-responsive ">
                                    <div class="col-12 input-group row">
                                        <input class="col-lg-12 form-control" type="text" name="daterangemotivos2" value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
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
                                    <br>

                                    <table class="table table-striped text-md-center dataTables-motivos2">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Fecha de Modificación</th>
                                            </tr>
                                        </thead>
                                        @foreach ($motivos_dev as $m_devol)
                                        <tbody>
                                            <tr>
                                            <td>{{$m_devol->nombre}}</td>
                                            <td>{{ \Carbon\Carbon::parse($m_devol->updated_at)->format('d/m/Y H:i:s')}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
