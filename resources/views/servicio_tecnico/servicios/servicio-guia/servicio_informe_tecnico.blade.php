<br>
<div class="search-responsive" style="padding-right: 15px;padding-left: 15px;">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="input-group">
                <input class="form-control" type="text" name="daterange"
                            id="data_range_filter" value="" readonly="readonly" />
                <span class="input-group-append">
                    <button type="button" class="btn btn-secondary" id="revert_select">
                                <i class="fa fa-history"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <input type="search" class="form-control" placeholder="Buscar:"
                        id="search_all_column">
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12">
            <button type="button" class="btn btn-block btn-primary"
                        id="filter_buttons">Buscar
            </button>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table id="servicio-informes" class="table table-striped table-bordered table-hover">
        <thead class="bg-white">
            <tr>
                <th>Cliente</th>
                <th>Servicio Tec.</th>
                <th>Orden Servicio</th>
                <th>Fecha Registrada</th>
                <th>Ver</th>
            </tr>
        </thead>
            <tbody>
                @if($informeTecnico)
                <tr class="gradeX">
                    <td>{{ $informeTecnico->servicioGuia->cliente->nombre }}</td>
                    <td>{{ $informeTecnico->servicioGuia->nro_servicio_guia }}</td>
                    <td>{{ $informeTecnico->servicioGuia->orden_servicio }}</td>
                    <td>{{ $informeTecnico->servicioGuia->fecha_creacion }}</td>
                    <td>
                        {{-- <a href="{{ route('servicio_tecnico.servicios.servicio-guia.servicio_informe_tecnico_show', ['id' => $informeTecnico->id]) }}">
                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver">
                                <i class="fa fa-eye"></i>
                            </button>
                        </a> --}}
                        <a href="{{ route('servicio_tecnico.servicios.informe-tecnico.show-cambios', ['id' => $informeTecnico->id]) }}">
                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver">
                                <i class="fa fa-eye"></i>
                            </button>
                        </a>
                    </td>

                </tr>
                @endif
            </tbody>
    </table>
</div>
