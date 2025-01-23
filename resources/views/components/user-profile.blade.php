<li class="nav-header">
    <div class="dropdown profile-element">
        <a href="{{ route('usuario.index') }}">
            <img alt="image" class="rounded-circle" 
                 src="{{ asset('/profile/images/' . $foto) }}" 
                 style="width: 150px; height: 150px" />
            <span class="block m-t-xs font-bold spans">{{ $nombre }}</span>
            <span class="block m-t-xs spans">{{ $area }}</span>
        </a>
    </div>
    <div class="logo-element">
        <!-- Aquí puedes agregar contenido adicional si es necesario -->
    </div>
</li>
