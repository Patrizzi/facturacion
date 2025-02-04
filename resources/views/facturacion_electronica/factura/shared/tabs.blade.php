<ul class="nav nav-tabs" role="tablist">
    <li>
        <a class="nav-link" href="{{ route('facturacion_electronica.facturas_enviadas_list') }}" id="tab_factura"><span style="color: green;">&#9632; </span>
            Facturas
            {{-- link del tab 1 --}}
        </a>
    </li>
    <li>
        <a class="nav-link" href="{{ route('facturacion_electronica.facturas_enviadas_list') }}" id="tab_fact_env"><span
                style="color: orange;">&#9632;</span> Enviados
            {{-- link del tab 2 --}}
        </a>
    </li>
    <li>
        <a class="nav-link" href="#tab-7"><span style="color: rgb(0, 255, 72);">&#9632;</span>
            Factura Manual
            {{-- link del tab 2 --}}
        </a>
    </li>
    <li>
        <a class="nav-link" href="#tab-8"><span style="color: red;">&#9632;</span> Enviados
            {{-- link del tab 2 --}}
        </a>
    </li>
    <li>
        <a class="nav-link" href="#tab-9"><span style="color: rgb(14, 14, 194);">&#9632;</span>
            Detracciones
            {{-- link del tab 2 --}}
        </a>
    </li>
</ul>
<ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
    <span class="dropdown">
        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
            <i class="fa fa-plus"></i>
        </button>
    </span>
    <button class="btn btn-success" type="button">
        <i class="fa fa-upload"></i>
    </button>
</ul>
