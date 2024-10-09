
<div class="col-md-6">
    <div class="form-group d-flex align-items-center"> 
        {{html()->label('Nombre')->class('label-custom me-2')}}
        {{html()->text('name')->placeholder('Ingrese el Nombre')->class('form-control')->value(old('nombre',$data->nombre ?? ''))->required()}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Centro de Costo')->class('fs-5')}}
        {{html()->text('centro_costo')->placeholder('Ingrese el Centro de Costo')->class('form-control')->value(old('centro_costo',$data->centro_costo ?? ''))->required()}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Ruc')->class('col-form-label')}}
        {{html()->text('ruc')->placeholder('Ingrese el ruc')->class('form-control')->value(old('ruc',$data->ruc ?? ''))->required()}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Administrador')->class('col-form-label')}}
        {{html()->number('administrador_id')->placeholder('Ingrese al Administrador')->class('form-control')->value(old('administrador_id',$data->administrador_id ?? ''))->required()}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Responsable')->class('col-form-label')}}
        {{html()->number('responsable_id')->placeholder('Ingrese al Responsable')->class('form-control')->value(old('responsable_id',$data->responsable_id ?? ''))->required()}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Servicio')->class('col-form-label')}}
        {{html()->number('project_service_id')->placeholder('Ingrese el Servicio')->class('form-control')->value(old('project_service_id',$data->project_service_id ?? ''))->required()}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Cliente')->class('col-form-label')}}
        {{html()->number('cliente_id')->placeholder('Ingrese al Cliente')->class('form-control')->value(old('cliente_id',$data->cliente_id ?? ''))->required()}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Fecha de Inicio')->class('col-form-label')}}
        {{html()->datetime('fecha_inicio')->placeholder('Ingrese la Fecha de Inicio')->class('form-control')->value(old('fecha_inicio',$data->fecha_inicio ?? ''))->required()}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Fecha de Cierre')->class('col-form-label')}}
        {{html()->datetime('fecha_cierre')->placeholder('Ingrese la Fecha de Cierre')->class('form-control')->value(old('fecha_cierre',$data->fecha_cierre ?? ''))->required()}}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group d-flex"> 
        {{html()->label('Prioridad')->class('col-form-label')}}
        {{html()->number('prioridad')->placeholder('Ingrese la Prioridad')->class('form-control')->value(old('prioridad',$data->prioridad ?? ''))->required()}}
    </div>
</div>