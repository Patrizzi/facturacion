<link rel="stylesheet" href="{{ asset('/css/project_managers/formDinamico.css') }}">

<div class="form-group">
    <x-form-dinamico name="nombre" label="Nombre:" type="text" placeholder="Ingrese el Nombre" value="{{old('nombre',$data->nombre ?? '')}}"/>

    <x-form-dinamico name="centro_costo" label="Centro de Costo:" type="text" placeholder="Ingrese el Centro de Costo" value="{{old('centro_costo',$data->centro_costo ?? '')}}"/>
    
    <x-form-dinamico name="ruc" label="Ruc:" type="text" placeholder="Ingrese el Ruc" value="{{old('ruc',$data->ruc ?? '')}}"/>
    
    <x-form-dinamico name="administrador_id" label="Administrador:" type="number" placeholder="Ingrese al Administrador" value="{{old('administrador_id',$data->administrador_id ?? '')}}"/>
    
    <x-form-dinamico name="responsable_id" label="Responsable:" type="number" placeholder="Ingrese al Responsable" value="{{old('responsable_id',$data->responsable_id ?? '')}}"/>
    
    <x-form-dinamico name="project_service_id" label="Servicio:" type="number" placeholder="Ingrese el Servicio" value="{{old('project_service_id',$data->project_service_id ?? '')}}"/>
    
    <x-form-dinamico name="cliente_id" label="Cliente:" type="number" placeholder="Ingrese al Cliente" value="{{old('cliente_id',$data->cliente_id ?? '')}}"/>
    
    <x-form-dinamico name="fecha_inicio" label="Fecha de Inicio:" type="datetime-local" placeholder="Ingrese la Fecha de Inicio" value="{{old('fecha_inicio',$data->fecha_inicio ?? '')}}"/>
    
    <x-form-dinamico name="fecha_cierre" label="Fecha de Cierre:" type="datetime-local" placeholder="Ingrese la Fecha de Cierre" value="{{old('fecha_cierre',$data->fecha_cierre ?? '')}}"/>
    
    <x-form-dinamico name="prioridad" label="Prioridad:" type="number" placeholder="Ingrese la Prioridad" value="{{old('prioridad',$data->prioridad ?? '')}}"/>
</div>