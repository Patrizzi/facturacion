<div class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{route('ventas.cotizacion')}}" id="tab-1-tab">
            <span class="badge badge-success" style="background-color :green;">{{$count_all_comprobantes['boleta_day_count']}}</span>
            Boleta
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  href="{{route('ventas.cotizacion_manual')}}" id="tab-2-tab">
            <span class="badge badge-success" style="background-color: orange;">{{$count_all_comprobantes['boleta_m_day_count']}}</span>
            Boleta Manual
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"href="{{route('ventas.nota_venta')}}" href="#tab-3" id="tab-3-tab">
            <span class="badge badge-success" style="background-color: red;">{{$count_all_comprobantes['factura_day_count']}}</span> Factura
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"href="{{route('ventas.nota_venta')}}" href="#tab-`4" id="tab-`4-tab">
            <span class="badge badge-success" style="background-color: red;">{{$count_all_comprobantes['factura_m_day_count']}}</span> Factura Manual
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"href="{{route('ventas.nota_venta')}}" href="#tab-5" id="tab-5-tab">
            <span class="badge badge-success" style="background-color: red;">{{$count_all_comprobantes['n_credito_day_count']}}</span> Nota de Credito
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"href="{{route('ventas.nota_venta')}}" href="#tab-6" id="tab-6-tab">
            <span class="badge badge-success" style="background-color: red;">{{$count_all_comprobantes['n_debito_day_count']}}</span> Nota de Debito
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"href="{{route('ventas.nota_venta')}}" href="#tab-7" id="tab-7-tab">
            <span class="badge badge-success" style="background-color: red;">{{$count_all_comprobantes['remision_day_count']}}</span> Guia Remision
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"href="{{route('ventas.nota_venta')}}" href="#tab-8" id="tab-8-tab">
            <span class="badge badge-success" style="background-color: red;">{{$count_all_comprobantes['remision_m_day_count']}}</span> Guia Remision Manual
        </a>
    </li>
</div>
