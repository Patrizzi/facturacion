<link rel="stylesheet" href="css/project_managers/form.css">

<div class="btnVolver">
    <a href="{{route('project_managers.index')}}">Volver</a>
</div>
<div class="formShow">
    @include('project_manager.formDinamico',compact('data'),['esDisabled'=>True])
</div>