<div class="nav nav-custom" style="min-width: 1450px;overflow-y: hidden;overflow-x: auto;">
    @can('nota_credito.listar_por_emitir')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('facturacion_electronica.index_nota_credito') }}" id="tab_credito">
            <span class="badge badge-success" style="background-color:  var(--primary);">0 </span>
            Nota de Crédito
            {{-- link del tab 1 --}}
        </a>
    </li>
    @endcan
    @can('nota_credito.lista_emitidas')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('facturacion_electronica.nota_credito_env') }}" id="tab_credito_env">
           <span class="badge badge-success" style="background-color:  var(--primary);">0 </span> Enviados
            {{-- link del tab 2 --}}
        </a>
    </li>
    @endcan
    @can('nota_debito.listar_por_emitir')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('facturacion_electronica.index_nota_debito') }}" id="tab_debito">
            <span class="badge badge-success" style="background-color:  var(--primary);">0 </span>
            Nota de Débito
            {{-- link del tab 1 --}}
        </a>
    </li>
    @endcan
    @can('nota_debito.lista_emitidas')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('facturacion_electronica.nota_debito_env') }}" id="tab_debito_env">
           <span class="badge badge-success" style="background-color:  var(--primary);">0 </span> Enviados
            {{-- link del tab 2 --}}
        </a>
    </li>
    @endcan
</div>
