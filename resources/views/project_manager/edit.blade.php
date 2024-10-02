<form action="{{route('project_managers.update',$data->id)}}" class="formEnvio" method="POST">
    @csrf
    @method('PUT')
    @include('project_manager.formDinamico',compact('data'))
    <div class="btnEnvioForm">
        <button type="submit">Editar Proyecto</button>
    </div>
    <div class="btnCancelar">
        <a href="{{route('project_managers.index')}}">Cancelar</a>
    </div>
</form>