<div class="nav nav-custom" style="min-width: 1450px;overflow-y: hidden;overflow-x: auto;">
    @can('guia_remision.listar_por_emitir')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('guias_electronicas.index_guia_remision') }}" id="tab_remision">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span> </span>
                Guías de Remisión
                {{-- link del tab 1 --}}
            </a>
        </li>
    @endcan
    @can('guia_remision.listar_emitidas')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('guias_electronicas.remision_enviadas') }}" id="tab_remision_env">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span></span> Enviados
                {{-- link del tab 2 --}}
            </a>
        </li>
    @endcan
    @can('guia_remision_m.listar_por_emitir')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('guias_electronicas.index_guia_remision_manual') }}"
                id="tab_remision_m"><span class="badge badge-success" style="background-color:  var(--primary);">0 </span>
                Guia de Remision Manual
                {{-- link del tab 3 --}}
            </a>
        </li>
    @endcan
    @can('guia_remision_m.listar_emitidas')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('guias_electronicas.remision_m_envidas') }}" id="tab_remision_m_env">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span></span> Enviados
                {{-- link del tab 4 --}}
            </a>
        </li>
    @endcan
</div>
