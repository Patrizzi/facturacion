
<div class="nav nav-custom">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('facturacion_electronica.index') }}" id="tab_factura"><span style="color: green;">&#9632; </span>
            Facturas
            {{-- link del tab 1 --}}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('facturacion_electronica.facturas_enviadas_list') }}" id="tab_fact_env"><span
                style="color: orange;">&#9632;</span> Enviados
            {{-- link del tab 2 --}}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('facturacion_electronica.index_facturas_manual') }}" id="tab_fact_m" ><span style="color: rgb(0, 255, 72);">&#9632;</span>
            Factura Manual
            {{-- link del tab 2 --}}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('facturacion_electronica.facturas_manual_enviadas') }}" id="tab_fact_m_env"><span style="color: red;">&#9632;</span> Enviados
            {{-- link del tab 2 --}} 
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('facturacion_electronica.facturas_detracciones')}}" id="tab_factura_detraccion" ><span style="color: rgb(14, 14, 194);">&#9632;</span>
            Detracciones
            {{-- link del tab 2 --}}
        </a>
    </li>
</div>
