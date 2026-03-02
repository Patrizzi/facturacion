@php
    $hideDropdownIfSingle = $hideDropdownIfSingle ?? true;
    $method = strtoupper($method ?? 'GET');
    $isPost = $method === 'POST';
    $useAlmacen = $useAlmacen ?? true;
    $asLink = $asLink ?? false;
    $label = $label ?? 'Almacenes:';
    $isAdmin = auth()->check() && auth()->user()->name === 'Administrador';
    $almacenCount = (isset($almacen) && is_countable($almacen)) ? count($almacen) : 0;
    $hasManyAlmacenes = $almacenCount > 1;
    $showDropdown = $useAlmacen && $isAdmin && (!$hideDropdownIfSingle || $hasManyAlmacenes);
    $dropdownId = 'dropdownMenuButton_' . uniqid();
@endphp
<div style="margin-top: 5px; margin-bottom: 8px; margin-left: 10px;">
    {{-- 1) Dropdown de ALMACENES (solo si useAlmacen=true y admin corresponde) --}}
    @if ($showDropdown)
        <span class="dropdown">
            <a id="{{ $dropdownId }}" class="no-hover-icon" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false" style="cursor: pointer;">
                <i class="fa fa-arrow-left text-muted"></i>
            </a>
            <ul class="dropdown-menu animated fadeInRight m-t-xs" aria-labelledby="{{ $dropdownId }}">
                <li style="padding: 3px 12px;"><b>{{ $label }}</b></li>
                @foreach ((isset($almacen) && is_iterable($almacen) ? $almacen : []) as $almacens)
                    <li>
                        <form action="{{ route($routeCreate) }}" method="{{ strtolower($method) }}">
                            @if ($isPost)
                                @csrf
                            @endif
                            <input type="hidden" name="almacen" value="{{ $almacens->id }}">
                            <button class="btn btn-w-m btn-link" type="submit">
                                {{ $almacens->nombre }}
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </span>
        {{-- 2) SIN dropdown: puede ser con almacén (no admin) o sin almacén (useAlmacen=false) --}}
    @else
        @if (!$isPost && $asLink && !$useAlmacen)
            <a class="no-hover-icon" href="{{ route($routeCreate) }}" style="cursor: pointer;">
                <i class="fa fa-arrow-left text-muted"></i>
            </a>
        @else
            <form action="{{ route($routeCreate) }}" method="{{ strtolower($method) }}" style="display:inline;">
                @if ($isPost)
                    @csrf
                @endif
                @if ($useAlmacen)
                    <input type="hidden" name="almacen" value="{{ auth()->user()->almacen_id }}">
                @endif
                <button class="btn btn-link no-hover-icon" type="submit" style="cursor: pointer;">
                    <i class="fa fa-arrow-left text-muted"></i>
                </button>
            </form>
        @endif
    @endif
</div>





