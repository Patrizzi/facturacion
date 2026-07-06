<!-- modal - Tipo de Cambio-->
<div id="modal-almacen" class="modal fade modal-xl-manual" style="display: none;" aria-hidden="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl-manual">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Almacenes</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- {{ date('m/t/Y') }} --}}
            <div class="modal-body">
                {{-- <div id="almacen_list"> --}}
                <div id="almacen_list">
                    <div class="row">
                        <div class="col-sm-5">
                            {{-- <div class="form-group">
                                <label class="col-form-label"><strong>Fecha:</strong></label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="daterange_almacen"
                                        id="datarenger_almacen" value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}" />
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="limpiar_select_tc()">
                                            <i class="fa fa-eraser"></i>
                                        </button>
                                    </span>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-sm-5">
                            {{-- <div class="form-group">
                                <label class="col-form-label"><strong>Buscar:</strong></label>
                                <input class="form-control" type="text" name=""
                                    id="serach_almacen" value="" />
                            </div> --}}
                        </div>
                        <div class="col-sm-2 text-right">
                            @can('almacen.crear')
                                <button class="btn btn-primary" id="almacen_create"><i class="fa fa-plus"></i></button>
                            @endcan
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <!--Tabla-->
                        <table class="table table-striped table-bordered dataTables-almacen">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Abreviatura</th>
                                    <th>Direccion</th>
                                    <th>Responsable</th>
                                    <th>Acciones</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="almacen_edit_div" style="display: none">
                    @include('configuracion_general.almacen.edit')
                </div>
                <div id="almacen_create_div" style="display: none">
                    @include('configuracion_general.almacen.create')
                </div>
                <div id="almacen_show_div" style="display: none">
                    @include('configuracion_general.almacen.show')
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .col-left-c {
        padding-right: 8px !important;
    }

    .col-right-c {
        padding-left: 8px !important;
    }

    .tab-pane.active.show {
        border-right: 1px solid #e7eaec;
        border-left: 1px solid #e7eaec;
        border-bottom: 1px solid #e7eaec;
    }
    .tab-pane{
        padding-right: 15px;
        padding-left: 15px;
        padding-bottom: 10px;
    }
    .select2.select2-container.select2-container--default{
        width: 100% !important;
    }
    span.select2-container.select2-container--default.select2-container--open{
        z-index: 999999 !important;
    }
    .buttons_acciones{
        /* display: flex; */
    }
</style>
