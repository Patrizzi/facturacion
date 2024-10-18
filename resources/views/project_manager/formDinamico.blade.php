
<div class="col-md-6">
    <div class="form-group d-flex align-items-center"> 
        {{ html()->label('Nombre')->class('label-custom me-2') }}
        {{ html()->text('nombre')->placeholder('Ingrese el Nombre')->class('form-control')->value(old('nombre',$project_manager->nombre ?? ''))}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Centro de Costo')->class('fs-5')}}
        {{html()->text('centro_costo')->placeholder('Ingrese el Centro de Costo')->class('form-control')->value(old('centro_costo',$project_manager->centro_costo ?? ''))}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Ruc')->class('col-form-label')}}
        {{html()->text('ruc')->placeholder('Ingrese el ruc')->class('form-control')->value(old('ruc',$project_manager->ruc ?? ''))}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex">
        {{html()->label('Administrador')->class('col-form-label')}}
        {{html()->select('administrador_id',$actividades)->placeholder('Ingrese al Administrador')->class('form-control')->value(old('administrador_id',$project_manager->administrador_id ?? ''))}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Responsable')->class('col-form-label')}}
        {{html()->select('responsable_id',$responsables)->placeholder('Ingrese al Responsable')->class('form-control')->value(old('responsable_id',$project_manager->responsable_id ?? ''))}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Servicio')->class('col-form-label')}}
        {{html()->select('project_service_id',$projectServices)->placeholder('Ingrese el Servicio')->class('form-control')->value(old('project_service_id',$project_manager->project_service_id ?? ''))}}
    </div>
</div>

<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Cliente')->class('col-form-label')}}
        {{html()->number('cliente_id')->placeholder('Ingrese al Cliente')->class('form-control')->value(old('cliente_id',$project_manager->cliente_id ?? ''))}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Prioridad')->class('col-form-label')}}
        {{html()->number('prioridad')->placeholder('Ingrese la Prioridad')->class('form-control')->value(old('prioridad',$project_manager->prioridad ?? ''))}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Fecha de Inicio')->class('col-form-label')}}
        {{html()->datetime('fecha_inicio')->placeholder('Ingrese la Fecha de Inicio')->class('form-control')->value(old('fecha_inicio',$project_manager->fecha_inicio ?? ''))}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Fecha de Cierre')->class('col-form-label')}}
        {{html()->datetime('fecha_cierre')->placeholder('Ingrese la Fecha de Cierre')->class('form-control')->value(old('fecha_cierre',$project_manager->fecha_cierre ?? ''))}}
    </div>
</div>
