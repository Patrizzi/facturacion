<div class="nav nav-custom">
    <li class="nav-item">
        <a class="nav-link" href="{{route('guias_electronicas.index_guia_remision')}}" id="tab_remision"><span style="color: green;">&#9632; </span>
            Guías de Remisión
            {{-- link del tab 1 --}}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('guias_electronicas.remision_enviadas')}}" id="tab_remision_env"><span
                style="color: orange;">&#9632;</span> Enviados
            {{-- link del tab 2 --}}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('guias_electronicas.index_guia_remision_manual')}}" id="tab_remision_m" ><span style="color: rgb(0, 255, 72);">&#9632;</span>
            Guia de Remision Manual
            {{-- link del tab 3 --}}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('guias_electronicas.remision_m_envidas')}}" id="tab_remision_m_env"><span style="color: red;">&#9632;</span> Enviados
            {{-- link del tab 4 --}} 
        </a>
    </li>
</div>
