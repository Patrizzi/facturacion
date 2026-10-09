<div class="form-group col-lg-4">
    {{ html()->label('Nombre') }}
    {{ html()->text('nombre')->placeholder('Ingrese el Nombre')->class('form-control')->value(old('nombre', $project_manager->nombre ?? '')) }}
</div>
<div class="form-group col-lg-3">
    {{ html()->label('Centro de Costo') }}
    {{ html()->text('centro_costo')->placeholder('Ingrese el Centro de Costo')->class('form-control')->value(old('centro_costo', $project_manager->centro_costo ?? '')) }}
</div>
<div class="form-group col-lg-3">
    {{ html()->label('Servicio') }}
    {{ html()->select('service_id', $servicios)->placeholder('Ingrese el Servicio')->class('select')->value(old('service_id', $project_manager->service_id ?? '')) }}
</div>
<div class="form-group col-lg-2">
    {{ html()->label('Prioridad') }}
    {{ html()->select('prioridad', $priorities)->placeholder('Ingrese la Prioridad')->class('select')->value(old('prioridad', $project_manager->prioridad ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Cliente') }}
    {{ html()->select('cliente_id', $clients)->placeholder('Ingrese al Cliente')->class('select client')->value(old('cliente_id', $project_manager->cliente_id ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Administrador') }}
    {{ html()->select('administrador_id', $administradores)->placeholder('Ingrese al Administrador')->class('select')->value(old('administrador_id', $project_manager->administrador_id ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Ruc') }}
    {{ html()->text('ruc')->placeholder('Ingrese el ruc')->class('form-control ruc')->readonly()->value(old('ruc', $project_manager->ruc ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Responsable') }}
    {{ html()->select('responsable_id', $responsables)->placeholder('Ingrese al Responsable')->class('select')->value(old('responsable_id', $project_manager->responsable_id ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Fecha de Inicio') }}
    {{ html()->datetime('fecha_inicio')->placeholder('Ingrese la Fecha de Inicio')->class('form-control datetime')->value(old('fecha_inicio', $project_manager->fecha_inicio ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Fecha de Cierre') }}
    {{ html()->datetime('fecha_cierre')->placeholder('Ingrese la Fecha de Cierre')->class('form-control datetime')->value(old('fecha_cierre', $project_manager->fecha_cierre ?? '')) }}
</div>
{{-- @push('js')
@once

@endonce
@endpush --}}
