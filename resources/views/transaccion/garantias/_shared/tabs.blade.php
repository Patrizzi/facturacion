<div class="nav nav-custom">
    @can('guia_ingreso.listar')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('garantia_guia_ingreso.index') }}" id="tab-1">
                <span style="color: green;">&#9632; </span> Guía de Ingreso
            </a>
        </li>
    @endcan
    @can('guia_egreso.listar')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('garantia_guia_egreso.index') }}" id="tab-2">
                <span style="color: orange;">&#9632;</span> Guía de Egreso
            </a>

        </li>
    @endcan
    @can('informe_tecnico.listar')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('garantia_informe_tecnico.index') }}" id="tab-3">
                <span style="color: red;">&#9632;</span> Guía de Informe Técnico
            </a>
        </li>
    @endcan
</div>
