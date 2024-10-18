<div class="modal-header">
    <h5 class="modal-title" id="dynamicModalLabel">{{ $formMethod == 'POST' ? 'Crear Tarea' : 'Editar Tarea' }}</h5>
</div>
@if ($errors->any())
        <h3 class="alert alert-danger">{{ $errors->first() }}</h3>
@endif
<div class="modal-body">
    {{ html()->modelForm($model, $formMethod, $formRoute)->open() }}
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group d-flex align-items-center"> 
                    {{ html()->label('Usuario')->class('label-custom me-2') }}
                    {{ html()->select('user_id', $modalData['users']->pluck('name', 'id'))->class('form-control')->value(old('user_id', $model->user_id ?? '')) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group d-flex align-items-center"> 
                    {{ html()->label('Contenido')->class('label-custom me-2') }}
                    {{ html()->text('contenido')->placeholder('Ingrese el Contenido')->class('form-control')->value(old('contenido',$model->contenido ?? ''))}}
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
                    {{ html()->select('estado', $modalData['estados'])->class('form-control')->value(old('estado', $model->estado ?? ''))}}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
            {{html()->button('Guardar')->class('btn btn-primary')}}
        </div>
    {{ html()->closeModelForm() }}
</div>
