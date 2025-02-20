<div class="nav">
    <li class="nav-item">
        <a class="nav-link"  href="{{ route('boletas_electronicas.index_boleta') }}" id="tab_boleta"><span style="color: green;">&#9632; </span> Boletas
            {{-- link del tab 1 --}}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"   href="{{ route('boletas_electronicas.boletas_enviadas_list')}}" id="boleta_enviado"><span style="color: orange;">&#9632;</span> Enviados
        {{-- link del tab 2 --}}
        </a>
    </li>
    <li  class="nav-item">
        <a class="nav-link" href="{{ route('boletas_electronicas.index_boleta_manual') }}" id="index_boleta_manual"><span style="color: rgb(0, 255, 72);">&#9632;</span> Boleta Manual
        {{-- link del tab 2 --}}
        </a>
    </li>
    <li  class="nav-item">
        <a class="nav-link" href="" id="boleta_manual_enviado"><span style="color: red;">&#9632;</span> Enviados
            {{-- link del tab 2 --}}
        </a>
    </li>
</div>