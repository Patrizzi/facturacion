<div class="nav nav-custom" style="min-width: 720px;overflow-y: hidden;overflow-x: auto;">
    <li class="nav-item">
        <a class="nav-link" href="{{route('cobranzas.index_boletas')}}" id="tab-1-tab">
            <span class="badge badge-success" style="background-color :green;"> 0 </span>
            Sin pagos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  href="{{route('cobranzas.index_boleta_pagados')}}" id="tab-2-tab">
            <span class="badge badge-success" style="background-color: orange;"> 0 </span>
            Pagados
        </a>
    </li>
    <li class="nav-item">
        {{-- <a class="nav-link"href="{{route('cobranzas.lista_facturas_manual_clientes_index')}}" id="tab-3-tab">
            <span class="badge badge-success" style="background-color: red;"> 0 </span>Clientes
        </a> --}}
        {{-- <a class="nav-link"href="#" id="tab-3-tab">
            <span class="badge badge-success" style="background-color: red;"> 0 </span>Clientes
        </a> --}}
    </li>
</div>
