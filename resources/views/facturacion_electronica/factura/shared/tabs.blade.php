<div class="nav nav-custom" style="min-width: 1450px;overflow-y: hidden;overflow-x: auto;">
    @can('factura.listar_por_emitir')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('facturacion_electronica.index') }}" id="tab_factura">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span>
                Facturas
                {{-- link del tab 1 --}}
            </a>
        </li>
    @endcan
    @can('factura.listar_emitidas')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('facturacion_electronica.facturas_enviadas_list') }}" id="tab_fact_env">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span> 
                Enviados
                {{-- link del tab 2 --}}
            </a>
        </li>
        @can('factura_m.listar_por_emitir')
        @endcan
        <li class="nav-item">
            <a class="nav-link" href="{{ route('facturacion_electronica.index_facturas_manual') }}" id="tab_fact_m">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span>
                Factura Manual
                {{-- link del tab 2 --}}
            </a>
        </li>
    @endcan
    @can('factura_m.listar_emitidas')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('facturacion_electronica.facturas_manual_enviadas') }}" id="tab_fact_m_env">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span> 
                Enviados
                {{-- link del tab 2 --}}
            </a>
        </li>
        @can('detraccion_factura.listar')
        @endcan
        <li class="nav-item">
            <a class="nav-link" href="{{ route('facturacion_electronica.facturas_detracciones') }}"
                id="tab_factura_detraccion">
                <span class="badge badge-success" style="background-color:  var(--primary);">0 </span>
                Detracciones
                {{-- link del tab 2 --}}
            </a>
        </li>
    @endcan
</div>
