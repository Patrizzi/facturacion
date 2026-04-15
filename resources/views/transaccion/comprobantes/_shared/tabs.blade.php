<div class="nav nav-custom" style="min-width: 1450px;overflow-y: hidden;overflow-x: auto;">
    @can()
        <li class="nav-item">
            <a class="nav-link" href="{{ route('comprobantes.index_boleta') }}" id="tab-1-tab">
                <span class="badge badge-success"
                    style="background-color : var(--primary);">{{ $count_all_comprobantes['boleta_day_count'] }}</span>
                Boleta
            </a>
        </li>
    @endcan
    @can()
        <li class="nav-item">
            <a class="nav-link" href="{{ route('comprobantes.index_boleta_manual') }}" id="tab-2-tab">
                <span class="badge badge-success"
                    style="background-color:  var(--primary);">{{ $count_all_comprobantes['boleta_m_day_count'] }}</span>
                Boleta Man.
            </a>
        </li>
    @endcan
    @can()
        <li class="nav-item">
            <a class="nav-link" href="{{ route('comprobantes.index_factura') }}" id="tab-3-tab">
                <span class="badge badge-success"
                    style="background-color:  var(--primary);">{{ $count_all_comprobantes['factura_day_count'] }}</span>
                Factura
            </a>
        </li>
    @endcan
    @can()
        <li class="nav-item">
            <a class="nav-link" href="{{ route('comprobantes.index_factura_manual') }}" id="tab-4-tab">
                <span class="badge badge-success"
                    style="background-color:  var(--primary);">{{ $count_all_comprobantes['factura_m_day_count'] ?? 0 }}</span>
                Factura
                Man.
            </a>
        </li>
    @endcan
    @can()
        <li class="nav-item">
            <a class="nav-link" href="{{ route('comprobantes.index_nota_credito') }}" id="tab-5-tab">
                <span class="badge badge-success"
                    style="background-color:  var(--primary);">{{ $count_all_comprobantes['n_credito_day_count'] }}</span>
                Nota de
                Crédito
            </a>
        </li>
    @endcan
    @can()
        <li class="nav-item">
            <a class="nav-link" href="{{ route('comprobantes.index_nota_debito') }}" id="tab-6-tab">
                <span class="badge badge-success"
                    style="background-color:  var(--primary);">{{ $count_all_comprobantes['n_debito_day_count'] }}</span>
                Nota de
                Débito
            </a>
        </li>
    @endcan
    @can()
        <li class="nav-item">
            <a class="nav-link" href="{{ route('comprobantes.index_guia_remision') }}" id="tab-7-tab">
                <span class="badge badge-success"
                    style="background-color:  var(--primary);">{{ $count_all_comprobantes['remision_day_count'] }}</span>
                Guía Remisión
            </a>
        </li>
    @endcan
    @can()
        <li class="nav-item">
            <a class="nav-link" href="{{ route('comprobantes.index_guia_remision_manual') }}" id="tab-8-tab">
                <span class="badge badge-success"
                    style="background-color:  var(--primary);">{{ $count_all_comprobantes['remision_m_day_count'] }}</span>
                Guía
                Remisión Man.
            </a>
        </li>
    </div>
