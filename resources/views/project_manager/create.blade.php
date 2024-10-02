<form action="{{route('project_managers.store')}}" class="formEnvio" method="POST">
    @csrf
    @include('project_manager.formDinamico')

    <div class="btnEnvioForm">
        <button type="submit">Crear</button>
    </div>
    <div class="btnCancelar">
        <a href="{{route('project_managers.index')}}">Cancelar</a>
    </div>
</form>