<div class="nav nav-custom" style="min-width: 1450px;overflow-y: hidden;overflow-x: auto;">
    @can('boleta.listar_por_emitir')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('boletas_electronicas.index_boleta') }}" id="tab_boleta">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span>
                    Boletas
                {{-- link del tab 1 --}}
            </a>
        </li>
    @endcan
    @can('boleta.listar_emitidas')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('boletas_electronicas.boletas_enviadas_list') }}" id="boleta_enviado">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span>
                Enviados
                {{-- link del tab 2 --}}
            </a>
        </li>
    @endcan
    @can('boleta_m.listar_por_emitir')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('boletas_electronicas.index_boleta_manual') }}" id="index_boleta_m">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span>
                Boleta Manual
                {{-- link del tab 2 --}}
            </a>
        </li>
    @endcan
    @can('boleta_m.listar_emitidas')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('boletas_electronicas.boletas_enviadas_m') }}" id="boeltas_m_enviados">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span>
                Enviados
                {{-- link del tab 2 --}}
            </a>
        </li>
    @endcan
</div>
