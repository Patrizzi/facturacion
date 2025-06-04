<div class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('comprobantes.index_boleta') }}" id="tab-1-tab">
            <span class="badge badge-success"
                style="background-color : var(--primary);">{{ $count_all_comprobantes['boleta_day_count'] }}</span>
            Boleta
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('comprobantes.index_boleta_manual') }}" id="tab-2-tab">
            <span class="badge badge-success"
                style="background-color:  var(--primary);">{{ $count_all_comprobantes['boleta_m_day_count'] }}</span>
            Boleta Manual
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('comprobantes.index_factura') }}" id="tab-3-tab">
            <span class="badge badge-success"
                style="background-color:  var(--primary);">{{ $count_all_comprobantes['factura_day_count'] }}</span> Factura
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('comprobantes.index_factura_manual') }}" id="tab-4-tab">
            <span class="badge badge-success"
                style="background-color:  var(--primary);">{{ $count_all_comprobantes['factura_m_day_count'] ?? 0 }}</span> Factura
            Manual
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('ventas.nota_venta') }}" id="tab-5-tab">
            <span class="badge badge-success"
                style="background-color:  var(--primary);">{{ $count_all_comprobantes['n_credito_day_count'] }}</span> Nota de
            Credito
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('ventas.nota_venta') }}" id="tab-6-tab">
            <span class="badge badge-success"
                style="background-color:  var(--primary);">{{ $count_all_comprobantes['n_debito_day_count'] }}</span> Nota de
            Debito
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('ventas.nota_venta') }}" id="tab-7-tab">
            <span class="badge badge-success"
                style="background-color:  var(--primary);">{{ $count_all_comprobantes['remision_day_count'] }}</span> Guia Remision
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('ventas.nota_venta') }}" id="tab-8-tab">
            <span class="badge badge-success"
                style="background-color:  var(--primary);">{{ $count_all_comprobantes['remision_m_day_count'] }}</span> Guia
            Remision Manual
        </a>
    </li>
</div>
