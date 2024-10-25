<div class="modal-content" id="modal-form-card-{{ isset($activity) ? $activity->id : 'new' }}">
    <div class="modal-header">
        <h5 class="modal-title" id="formModalLabel">{{ $formMethod == 'POST' ? 'Crear Tarjeta' : 'Editar Tarjeta' }}</h5>
    </div>
    <div class="modal-body">
        {{ html()->modelForm($model, $formMethod, $formRoute)->acceptsFiles()->open() }}
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group d-flex align-items-center"> 
                        {{ html()->label('Responsable')->class('label-custom me-2') }}
                        {{ html()->select('responsable_id', $modalData['users']->pluck('name', 'id'))->class('form-control')->value(old('responsable_id', $model->responsable_id ?? '')) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group d-flex align-items-center"> 
                        {{ html()->label('Nombre')->class('label-custom me-2') }}
                        {{ html()->text('nombre')->placeholder('Ingrese el Nombre')->class('form-control')->value(old('nombre',$model->nombre ?? ''))}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group d-flex"> 
                        {{ html()->label('Contenido')->class('fs-5')}}
                        {{ html()->text('contenido')->placeholder('Ingrese el contenido')->class('form-control')->value(old('contenido',$model->contenido ?? ''))}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group d-flex"> 
                        {{ html()->label('Fecha de Inicio')->class('col-form-label')}}
                        {{ html()->datetime('fecha_inicio')->class('form-control')->value(old('fecha_inicio',$model->fecha_inicio ?? ''))}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group d-flex"> 
                        {{ html()->label('Fecha de Cierre')->class('col-form-label')}}
                        {{ html()->datetime('fecha_cierre')->class('form-control')->value(old('fecha_cierre',$model->fecha_cierre ?? ''))}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group d-flex"> 
                        {{ html()->label('Estado')->class('col-form-label')}}
                        {{ html()->select('estado', $modalData['estados'])->class('form-control')->value(old('estado', $model->estado ?? '')) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group d-flex"> 
                        {{ html()->label('Color')->class('col-form-label') }}
                        {{ html()->input('color')
                            ->name('color')
                            ->class('form-control color-picker-input')
                            ->value(old('color', $model->color ?? '#ffffff'))
                        }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group d-flex"> 
                        {{ html()->label('Foto')->class('col-form-label') }}
                        {{ html()->file('foto')->class('form-control') }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                {{ html()->button('Guardar')->class('btn btn-primary')->type('submit') }}
            </div>
        {{ html()->closeModelForm() }}
    </div>
</div>