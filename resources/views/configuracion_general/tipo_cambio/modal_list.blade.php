<!-- modal - Tipo de Cambio-->
<div id="modal-tipo_cambio" class="modal fade modal-xl-manual" style="display: none;" aria-hidden="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl-manual">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Tipo de Cambio</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- {{ date('m/t/Y') }} --}}
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-8">
                        <div id="morris-one-line-chart" style="margin-top: -80px;"></div>
                    </div>
                    <div class="col-sm-4" style="margin: auto">
                        <div class="">
                            {{-- <div class="border border-primary rounded-circle circle-size" style="margin: auto">
                            </div>
                            <br>
                            <br> --}}
                            <p class="m-0 p-4 text-center" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                            <p>
                                <h4>Mínimo de valor general</h4>
                            </p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p> {{ $tipo_cambio_estaditica['day_compra_max'] }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-primary" style="margin-bottom: 0px;"> <b>S/
                                            {{ $tipo_cambio_estaditica['max_compra'] }}</b></p>
                                </div>
                            </div>
                            <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                            <p>
                                <h4>Maximo de valor general</h4>
                            </p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p> {{ $tipo_cambio_estaditica['day_venta_max'] }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-primary"><b>S/ {{ $tipo_cambio_estaditica['max_venta'] }}</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                            <input class="form-control" type="text" name="daterange_tipo_cambio"
                                id="search_tipo_cambio" value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}" />
                            <span class="input-group-append">
                                <button type="button" class="btn btn-primary" onclick="limpiar_select_tc()">
                                    <i class="fa fa-eraser"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped table-bordered dataTables-tipo_cambio">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Fecha</th>
                                <th style="width: 25%;">Compra</th>
                                <th style="width: 25%;">Venta</th>
                                <th style="width: 25%;">Paralelo</th>
                                <th>Acciones</th>
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


@include('configuracion_general.tipo_cambio.modal_edit')