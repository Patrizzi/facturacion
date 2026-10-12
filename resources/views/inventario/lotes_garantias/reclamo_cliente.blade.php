@extends('layout')

@section('title', 'Registrar Reclamo de Garantía')
@section('breadcrumb', 'Inventario')
@section('breadcrumb2', 'Reclamo de Garantía')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    @include('inventario.lotes_garantias.navbar_tabs')

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="ibox border-left border-primary shadow-sm">
                <div class="ibox-title text-white py-3" style="background-color: #2641f8;">
                    <h5 class="mb-0 text-white font-weight-bold">
                        <i class="fa fa-wrench mr-2"></i>Registrar reclamo de garantía
                    </h5>
                </div>
                <div class="ibox-content p-4">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <strong>No se pudo registrar el reclamo.</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p class="text-muted mb-4">
                        El cliente se identificará a partir del comprobante de venta asociado a la serie.
                        Ingrese el número de serie del producto y describa la falla.
                    </p>

                    <form method="POST" action="{{ route('lotes-garantias.reclamo-cliente.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="codigo_producto" class="font-weight-bold">Código de producto</label>
                            <input
                                id="codigo_producto"
                                type="text"
                                class="form-control"
                                value="{{ old('codigo_producto', $codigoProducto) }}"
                                placeholder="Código del producto asociado"
                                readonly
                            >
                            <small class="form-text text-muted">Este dato es una referencia; el reclamo se vincula usando el número de serie.</small>
                        </div>

                        <div class="form-group">
                            <label for="numero_serie" class="font-weight-bold">Número de serie <span class="text-danger">*</span></label>
                            <input
                                id="numero_serie"
                                name="numero_serie"
                                type="text"
                                value="{{ old('numero_serie') }}"
                                class="form-control @error('numero_serie') is-invalid @enderror"
                                required
                                maxlength="100"
                                autocomplete="off"
                            >
                            @error('numero_serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipo_falla" class="font-weight-bold">Tipo de falla <span class="text-danger">*</span></label>
                            <select id="tipo_falla" name="tipo_falla" class="form-control @error('tipo_falla') is-invalid @enderror" required>
                                <option value="">Seleccione el tipo de falla</option>
                                @foreach ([
                                    'defecto de fabrica' => 'Defecto de fábrica',
                                    'daño físico' => 'Daño físico',
                                    'derrame de líquidos' => 'Derrame de líquidos',
                                    'manipulación no autorizada' => 'Manipulación no autorizada',
                                    'falla eléctrica' => 'Falla eléctrica',
                                    'desgaste' => 'Desgaste',
                                ] as $value => $label)
                                    <option value="{{ $value }}" {{ old('tipo_falla') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('tipo_falla')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion" class="font-weight-bold">Descripción detallada <span class="text-danger">*</span></label>
                            <textarea
                                id="descripcion"
                                name="descripcion"
                                rows="5"
                                minlength="20"
                                maxlength="2000"
                                class="form-control @error('descripcion') is-invalid @enderror"
                                required
                            >{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <fieldset class="form-group">
                            <legend class="col-form-label font-weight-bold">Condiciones observadas (opcional)</legend>
                            @foreach ([
                                'sello_roto' => 'El sello de garantía está roto',
                                'desmontaje_incorrecto' => 'El equipo presenta señales de desmontaje',
                                'derrame_liquido' => 'Hay indicios de derrame de líquidos',
                                'manipulacion_no_autorizada' => 'Hay indicios de manipulación no autorizada',
                                'falta_evidencia' => 'No cuento con evidencia suficiente',
                            ] as $value => $label)
                                <div class="custom-control custom-checkbox mb-2">
                                    <input
                                        id="condicion_{{ $value }}"
                                        type="checkbox"
                                        name="condiciones_uso[{{ $value }}]"
                                        value="1"
                                        class="custom-control-input"
                                        {{ old('condiciones_uso.' . $value) ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="condicion_{{ $value }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @error('condiciones_uso')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </fieldset>

                        <div class="form-group">
                            <label for="evidencias" class="font-weight-bold">Evidencias (opcional, hasta 5 archivos)</label>
                            <input
                                id="evidencias"
                                name="evidencias[]"
                                type="file"
                                multiple
                                accept="image/*,video/mp4,video/quicktime"
                                class="form-control-file @if ($errors->has('evidencias') || count($errors->get('evidencias.*')) > 0) is-invalid @endif"
                            >
                            <small class="form-text text-muted">Formatos permitidos: JPG, PNG, WEBP, MP4 y MOV. Máximo 10 MB por archivo.</small>
                            @error('evidencias')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            @foreach ($errors->get('evidencias.*') as $messages)
                                @foreach ($messages as $message)
                                    <div class="text-danger small">{{ $message }}</div>
                                @endforeach
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('lotes-garantias.garantia-cliente', ['codigo_producto' => $codigoProducto]) }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left mr-1"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary font-weight-bold" style="background-color: #2641f8; border-color: #2641f8;">
                                <i class="fa fa-paper-plane mr-1"></i> Registrar reclamo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
