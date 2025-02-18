<div class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('garantia_guia_ingreso.index') }}" id="tab-1">
        <span style="color: green;">&#9632; </span> Guía de Ingreso
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('garantia_guia_egreso.index') }}" id="tab-2">
        <span style="color: orange;">&#9632;</span> Guía de Egreso
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('garantia_informe_tecnico.index') }}" id="tab-3">
            <span style="color: red;">&#9632;</span> Guía de Informe Técnico
        </a>
    </li>
</div>
<!-- Botón de descarga -->
<div class="btn-group">
    <button data-toggle="dropdown" type="button" class="btn btn-success dropdown-toggle ">
        <i class="fa fa-cloud-download"></i>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">PDF</a></li>
        <li><a class="dropdown-item" href="#">WORD</a></li>
        <li><a class="dropdown-item" href="#">CSV</a></li>
        <li><a class="dropdown-item" href="#">EXCEL</a></li>
    </ul>
</div>
