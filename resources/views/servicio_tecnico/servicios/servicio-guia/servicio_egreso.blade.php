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
                                style="cursor: default;"
                            >
                                <i class="fa fa-clock-o"></i>
                            </button>
                        </td>
                    </tr>
                @endif
                {{-- modal store egreso equipo --}}
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
                                        <label>Observación:</label>
                                        <textarea
                                            class="form-control"
                                            readonly
                                        >{{ $ingresoEquipo->observacion }}</textarea>
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
                    @if($egresoEquipo->estado == 2)
                        <td>Rechazado</td>
                    @else
                        <td>{{ $egresoEquipo->fecha_fin_reparacion ?? 'Pendiente' }}</td>
                    @endif
                    <td>
                        {{-- servicio guia estado falta diagnosticar(0) o diganosticado(1) --}}
                        @if($servicioGuia->estado == 0 || $servicioGuia->estado == 1)
                            {{-- btn en espera --}}
                            <button
                                class="btn btn-warning"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="En espera"
                                style="cursor: default;"
                            >
                                <i class="fa fa-clock-o"></i>
                            </button>

                        {{-- servicio guia estado cotizado(2) --}}
                        @elseif($servicioGuia->estado == 2)
                            @if($egresoEquipo->estado == 2)
                                {{-- btn en rechazado --}}
                                <button
                                    class="btn btn-danger btn-circle"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Rechazado"
                                    style="cursor: not-allowed;"
                                >
                                    <i class="fa fa-times"></i>
                                </button>
                            @else
                                {{-- btn en espera --}}
                                <button
                                    class="btn btn-warning"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="En espera"
                                    style="cursor: default;"
                                >
                                    <i class="fa fa-clock-o"></i>
                                </button>
                            @endif

                        {{-- servicio guia estado orden servicio creada(3) o si ya fueron todos reparados(4) para poder actualizar --}}
                        @elseif($servicioGuia->estado == 3)
                            {{-- equipos estado cotizado(0) --}}
                            @if($egresoEquipo->estado == 0)
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
                                {{-- btn en espera --}}
                                <button
                                    class="btn btn-warning"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="En espera"
                                    style="cursor: default;"
                                >
                                    <i class="fa fa-clock-o"></i>
                                </button>

                            {{-- equipo reparado --}}
                            @elseif($egresoEquipo->estado == 1)
                                <button
                                    class="btn btn-success btn-circle"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Reparado"
                                    style="cursor: default;"
                                >
                                    <i class="fa fa-check"></i>
                                </button>

                            {{-- equipos no cotizados pasaron a estado rechazado(2) --}}
                            @elseif($egresoEquipo->estado == 2)
                                {{-- btn en rechazado --}}
                                <button
                                    class="btn btn-danger btn-circle"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Rechazado"
                                    style="cursor: not-allowed;"
                                >
                                    <i class="fa fa-times"></i>
                                </button>
                            @endif

                        {{-- servicio guia estado reparado todos(4) --}}
                        @elseif($servicioGuia->estado == 4 || $servicioGuia->estado == 5)
                            {{-- si el equipo no fue cotizado, que se siga mostrando en rechazado --}}
                            @if($egresoEquipo->estado == 2)
                                 {{-- btn en rechazado --}}
                                <button
                                    class="btn btn-danger btn-circle"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Rechazado"
                                    style="cursor: not-allowed;"
                                >
                                    <i class="fa fa-times"></i>
                                </button>

                            {{-- si el producto fue cotizado y reparado, que se muestre en btn reparado --}}
                            @elseif($egresoEquipo->estado == 1)
                                {{-- btn reparado --}}
                                <button
                                    class="btn btn-success btn-circle"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Reparado"
                                    style="cursor: default;"
                                >
                                    <i class="fa fa-check"></i>
                            </button>
                            @endif
                        @endif
                    </td>
                </tr>

                {{-- modal update reparar equipo --}}
                <div class="modal fade" id="modal-reparar-{{ $egresoEquipo->id }}" tabindex="-1" aria-labelledby="modalRepararLabel-{{ $egresoEquipo->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('servicio-guias.reparar-equipo') }}" method="POST">
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
<<<<<<< HEAD
=======
                                    <div class="form-group">
                                        <label>Descripción:</label>
                                        <textarea
                                            name="descripcion_os"
                                            class="form-control"
                                        >{{ $egresoEquipo->descripcion_os ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Fecha fin reparación</label>
                                        <input type="date" class="form-control" name="fecha_fin_reparacion" value="{{ $egresoEquipo->fecha_fin_reparacion ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Estado:</label>
                                        <select name="estado" class="form-control">
                                            <option value="0" {{ $egresoEquipo->estado == 0 ? 'selected' : '' }}>En revisión</option>
                                            <option value="1" {{ $egresoEquipo->estado == 1 ? 'selected' : '' }}>Revisado</option>
                                        </select>
                                    </div>
>>>>>>> DevMarlo
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
