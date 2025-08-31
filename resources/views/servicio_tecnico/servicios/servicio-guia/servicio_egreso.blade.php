<br>
<div class="table-responsive">
    <table id="servicio-guias-egresos" class="table table-striped table-bordered table-hover">
        <thead class="bg-white">
            <tr>
                <th>Equipo</th>
                <th>Serie</th>
                <th>Fecha inicio reparación</th>
                <th>Diagnóstico</th>
                <th>Técnico encargado</th>
                <th>Fecha fin reparacion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- total equipos egresos --}}
            <input type="hidden" name="total_serv_egresos" value={{ $servEgresosEquipos->count() }}>

            @php
                $equiposConEgreso = $servEgresosEquipos->pluck('servicio_g_ingreso_id')->toArray();
            @endphp

            @foreach($servIngresoEquipos as $ingresoEquipo)
                @if(!in_array($ingresoEquipo->id, $equiposConEgreso))
                    <tr class="gradeX">
                        <td>{{ $ingresoEquipo->nombre_equipo }}</td>
                        <td>{{ $ingresoEquipo->nro_serie }}</td>
                        <td>No iniciada</td>
                        <td>No diagnosticado</td>
                        <td>Sin técnico</td>
                        <td>No Iniciada</td>
                        <td>
                            {{-- btn modal store para diagnosticar --}}
                            <button
                                type="button"
                                class="btn btn-primary btn-diagnosticar"
                                id="btn-diagnosticar-equipo-{{ $ingresoEquipo->id }}"
                                data-toggle="modal"
                                data-target="#modal-diagnosticar-{{ $ingresoEquipo->id }}"
                            >
                                <i class="fa fa-thermometer-full" aria-hidden="true"></i>
                            </button>

                            {{-- btn en espera --}}
                            <button
                                class="btn btn-warning"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="En espera"
                            >
                                <i class="fa fa-clock-o"></i>
                            </button>
                        </td>
                    </tr>
                @endif
                {{-- modal store egreso --}}
                <div class="modal fade" id="modal-diagnosticar-{{ $ingresoEquipo->id }}" tabindex="-1" aria-labelledby="modalDiagnosticarLabel-{{ $ingresoEquipo->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('servicio-guias.store-diagnostico') }}" method="POST">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="servicio_g_id" value="{{ $servicioGuia->id }}">
                                <input type="hidden" name="servicio_g_ingreso_id" value="{{ $ingresoEquipo->id }}">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalDiagnosticarLabel-{{ $ingresoEquipo->id }}">
                                        Diagnosticar Equipo
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label>Equipo:</label>
                                            <input type="text" class="form-control" value="{{ $ingresoEquipo->nombre_equipo }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Serie:</label>
                                            <input type="text" class="form-control" value="{{ $ingresoEquipo->nro_serie }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Técnico encargado:</label>
                                        <input type="text" class="form-control" value="{{ Auth()->user()->name }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Diagnóstico:</label>
                                        <textarea
                                            name="diagnostico"
                                            class="form-control"
                                            placeholder="Describa el problema encontrado y las acciones a realizar..."
                                        ></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-dismiss="modal"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Diagnosticar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            @foreach($servEgresosEquipos as $egresoEquipo)
                <tr class="gradeX">
                    <td>{{ $egresoEquipo->equipo }}</td>
                    <td>{{ $egresoEquipo->serie }}</td>
                    <td>{{ $egresoEquipo->fecha_inicio_reparacion }}</td>
                    <td>{{ $egresoEquipo->diagnostico }}</td>
                    <td>{{ $egresoEquipo->tecnico }}</td>
                    <td>{{ $egresoEquipo->fecha_fin_reparacion ?? 'Pendiente' }}</td>
                    <td>
                        @if($servicioGuia->estado == 2)
                            {{-- btn reparar modal --}}
                            <button
                                class="btn btn-primary"
                                type="button"
                                id="btn-reparar-equipo-{{ $egresoEquipo->id }}"
                                data-toggle="modal"
                                data-target="#modal-reparar-{{ $egresoEquipo->id }}"
                            >
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                            </button>
                        @endif

                        {{-- btn en espera --}}
                        <button
                            class="btn btn-warning"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="En espera"
                        >
                            <i class="fa fa-clock-o"></i>
                        </button>
                    </td>
                </tr>

                {{-- modal update reparar equipo --}}
                <div class="modal fade" id="modal-reparar-{{ $egresoEquipo->id }}" tabindex="-1" aria-labelledby="modalRepararLabel-{{ $egresoEquipo->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="#" method="PATCH">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="servicio_g_id" value="{{ $servicioGuia->id }}">
                                <input type="hidden" name="servicio_g_egreso_id" value="{{ $egresoEquipo->id }}">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalRepararLabel-{{ $egresoEquipo->id }}">
                                        Reparar Equipo
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label>Equipo:</label>
                                            <input type="text" class="form-control" value="{{ $egresoEquipo->equipo }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Serie:</label>
                                            <input type="text" class="form-control" value="{{ $egresoEquipo->serie }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Técnico encargado:</label>
                                        <input type="text" class="form-control" value="{{ $egresoEquipo->tecnico }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Diagnóstico:</label>
                                        <textarea
                                            name="diagnostico"
                                            class="form-control"
                                            disabled
                                        >{{ $egresoEquipo->diagnostico }}</textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-dismiss="modal"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Guardar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
