@if ($menu->hasAccess())
    <li>
        <a href="{{ $url }}">
            @if ($icon)
                <img src="{{ $icon }}" class="iconos">
            @endif
            <span class="nav-label">{!! $text !!}</span>
            @if ($menu->hasAlerts())
                &nbsp;
                <span class="label label-warning">
                    {{ $menu->alertsFormat() }}
                </span>
            @endif
        </a>
        @if ($submenus)
            <ul {!! $getClass !!}>
                @foreach ($submenus as $menu)
                    <x-menu-item :menu="$menu" :next-level="$nextLevel + 1" />
                @endforeach
            </ul>
        @endif
    </li>
@endif
