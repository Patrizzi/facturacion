@if ($menuItem->hasAccess())
<li>
    <a href="{{ $menuItem->url }}">
        @if ($menuItem->icon)
            <img src="{{ $menuItem->icon }}" class="iconos">
        @endif
        <span class="nav-label">{!! $menuItem->text !!}</span>
        @if ($hasNotifications())
            &nbsp;
            <span class="label label-warning">
                {{ $notificationCount() }}
            </span>
        @endif
    </a>
    @if ($menuItem->subMenus)
        <ul class="nav nav-{{ $getNextLevelMenu() }}-level collapse">
            @foreach ($menuItem->subMenus as $secondLevelMenu)
                <x-menu-item :menuItem="$secondLevelMenu" :level="$level+1" />
            @endforeach
        </ul>
    @endif
</li>
@endif
