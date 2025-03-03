<div class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('facturacion_electronica.index_nota_credito') }}" id="tab_credito"><span
                style="color: green;">&#9632; </span>
            Nota de Crédito
            {{-- link del tab 1 --}}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('facturacion_electronica.nota_credito_env') }}" id="tab_credito_env"><span
                style="color: orange;">&#9632;</span> Enviados
            {{-- link del tab 2 --}}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('facturacion_electronica.index_nota_debito') }}" id="tab_debito"><span
                style="color: green;">&#9632; </span>
            Nota de Dédito
            {{-- link del tab 1 --}}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('guias_electronicas.remision_enviadas') }}" id="tab_debito_env"><span
                style="color: orange;">&#9632;</span> Enviados
            {{-- link del tab 2 --}}
        </a>
    </li>
</div>
