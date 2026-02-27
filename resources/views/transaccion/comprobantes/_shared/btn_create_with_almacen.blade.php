@php
    $hideDropdownIfSingle = $hideDropdownIfSingle ?? true;

    $isAdmin = auth()->check() && auth()->user()->name === 'Administrador';
    $hasManyAlmacenes = isset($almacen) && $almacen->count() > 1;
    $showDropdown = $isAdmin && (!$hideDropdownIfSingle || $hasManyAlmacenes);
@endphp

{{-- CONTENEDOR ESTILO IBOX-TITLE (DERECHA) --}}
<div class="d-flex justify-content-end" style="padding-right: 3.1%;">
    <div style="margin-top: 5px; margin-bottom: 8px; margin-left: 10px;">

        @if ($showDropdown)
            <span class="dropdown">
                <a type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-arrow-left text-muted"></i>
                </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    <span style="margin-left:12px;"><b>Almacenes:</b></span>

                    @foreach ($almacen as $almacens)
                        <li>
                            <form action="{{ route($routeCreate) }}" method="post">
                                @csrf
                                <input type="hidden" name="almacen" value="{{ $almacens->id }}">
                                <button class="btn btn-w-m btn-link" type="submit">
                                    {{ $almacens->nombre }}
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </span>
        @else
            <form action="{{ route($routeCreate) }}" method="post" class="tooltip-demo" style="display:inline;">
                @csrf
                <input type="hidden" name="almacen" value="{{ auth()->user()->almacen_id }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-plus"></i>
                </button>
            </form>
        @endif

    </div>
</div>
