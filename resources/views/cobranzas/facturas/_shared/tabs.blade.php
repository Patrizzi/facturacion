<div class="nav nav-custom" style="min-width: 720px;overflow-y: hidden;overflow-x: auto;">
    @can('factura.listar_por_pagar')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cobranzas.index_factura') }}" id="tab-1-tab">
                <span class="badge badge-success" style="background-color :green;"> 0 </span>
                Sin pagos
            </a>
        </li>
    @endcan

    @can('factura.listar_pagadas')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cobranzas.index_factura_pagados') }}" id="tab-2-tab">
                <span class="badge badge-success" style="background-color: orange;"> 0 </span>
                Pagados
            </a>
        </li>
    @endcan
</div>
