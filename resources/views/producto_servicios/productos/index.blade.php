@extends('layout')
@section('title', 'Productos')
@section('atributo_actu', 'hidden')
@section('value_accion', 'Agregar')
@section('href_accion', route('productos.create'))


@section('content')
    <link rel="stylesheet" href="{{ asset('css/productos/index.css') }}">

    <!-- toast que mostrará los mensajes de creacion, actualizacion, etc -->
    @if (session('success') || session('error') || session('warning') || session('info'))
        <div id="toast"
            class="toast
        {{ session('success') ? 'success' : '' }}
        {{ session('error') ? 'error' : '' }}
        {{ session('warning') ? 'warning' : '' }}
        {{ session('info') ? 'info' : '' }}">
            <span class="toast-icon">
                @if (session('success'))
                    ✔️
                @endif
                @if (session('error'))
                    ❌
                @endif
                @if (session('warning'))
                    ⚠️
                @endif
                @if (session('info'))
                    ℹ️
                @endif
            </span>
            <p style="margin: 0; flex: 1;">
                {{ session('success') ?? (session('error') ?? (session('warning') ?? session('info'))) }}
            </p>
        </div>
    @endif

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                    </div>
                    <div class="ibox-content">
                        <div class="row d-flex justify-content-center">
                            @include('producto_servicios.shared.stadistics')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    {{-- <div class="ibox-title">
                        <h5>Lista de Productos</h5>
                    </div> --}}
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                <div class="nav nav-custom">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('productos.index') }}" id="tab-1-tab">
                                            <span class="badge badge-success"
                                                style="background-color : var(--primary);">0</span>
                                            Producto
                                        </a>
                                    </li>
                                </div>
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <button class="btn btn-sm btn-primary" id="openUploadModal">
                                        <i class="fa fa-upload text-secondary"
                                            style="cursor: pointer;color: white !important"></i>
                                    </button>
                                    <div class="btn btn-sm btn-primary dropdown" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-download text-secondary"
                                            style="cursor: pointer;color: white !important"></i>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button class="dropdown-item" onclick="exportarTodo(event)"
                                                style="width: 100%;">
                                                <i class="fa fa-file-excel mr-2"></i>
                                                Exportar Todo
                                            </button>
                                            <button class="dropdown-item" id="exportSelected" style="width: 100%;">
                                                <i class="fa fa-file-pdf mr-2"></i>
                                                Exportar Selecionados
                                            </button>
                                        </div>
                                    </div>

                                    {{-- forms ocultos exportar productos --}}
                                    <form id="formExportProdAll" action="{{ route('export.excel') }}" method="GET"
                                        style="display: none;"></form>

                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#NuevoProducto">
                                        <i class="fa fa-plus"></i></button>
                                </ul>
                            </ul>
                            <div class="tabs-content">
                                <div class="tab-pane active show" id="tab-1">
                                    <br>
                                    <div class="search-responsive">

                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover bg-white align-middle"
                                            id="table_prod">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>
                                                        <label class="cb-codigo">
                                                            <input type="checkbox" id="cb-codigo" hidden>
                                                            <div></div>
                                                        </label>
                                                    </th>
                                                    <th>Código <i class="fa fa-search"></i></th>
                                                    <th id="th-nombre" class="no-sort">

                                                        <span id="nombre-label" style="cursor: pointer;">Nombre <i
                                                                class="fa fa-search"></i></span>
                                                        <input type="text" id="filtrarNombre"
                                                            class="form-control form-control-sm d-none mt-1"
                                                            placeholder="Buscar nombre">
                                                    </th>

                                                    <th>Marca <i class="fa fa-search"></i></th>
                                                    <th>Unidad <i class="fa fa-filter"></i></th>
                                                    <th>Estado<i class="fa fa-search"></i></th>
                                                    {{-- <th>Precio Nacional<i class="fa fa-search"></i></th>
                                                    <th>Precio Nacional IGV<i class="fa fa-search"></i></th>
                                                    <th>Precio Extranjero<i class="fa fa-search"></i></th>
                                                    <th>Precio Extranjero IGV<i class="fa fa-search"></i></th> --}}

                                                    {{-- PRECIO NACIONAL, N. IGV, EXTRANJERO, E. IGV UNIFICADO => EVENTO CLICK --}}
                                                    <th id="precio-header" class="precio-header no-sort" style="cursor: pointer; user-select: none;">
                                                        <span id="precio-title">Precio Nacional</span>
                                                        <i class="fa fa-exchange-alt"></i>
                                                        <span class="precio-indicator" id="precio-indicator" style="font-size: 0.8em; color: #6c757d; margin-left: 5px;">(1/4)</span>
                                                    </th>
                                                    <th>Stock <i class="fa fa-search"></i></th>
                                                    <th>

                                                        <div class="dropdown">
                                                            <i class="fa fa-sliders" style="cursor: pointer;"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                            </i>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('productos.index') }}">
                                                                    Todos
                                                                </a>

                                                                <a class="dropdown-item {{ request('stock') == 'alto' ? 'active' : '' }}"
                                                                    href="{{ route('productos.index', ['stock' => 'alto']) }}">
                                                                    <i class="fa fa-caret-up mr-1"></i>
                                                                    Stock Alto
                                                                </a>

                                                                <a class="dropdown-item {{ request('stock') == 'bajo' ? 'active' : '' }}"
                                                                    href="{{ route('productos.index', ['stock' => 'bajo']) }}">
                                                                    <i class="fa fa-caret-down mr-1"></i>
                                                                    Stock Bajo
                                                                </a>

                                                            </div>
                                                        </div>

                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- PRODUCTOS FILTRADOS CAMBIAR NOMBRRE --}}
                                                @foreach ($productosFiltrados as $producto)
                                                @php
                                                    $precios = $producto->calcularPrecios();
                                                @endphp
                                                    <tr data-estado="{{ $producto->estado_id }}">
                                                        <td>
                                                            <label class="cb-product">
                                                                <input type="checkbox" name="product"
                                                                    data-id="{{ $producto->id }}" hidden>
                                                                <div></div>
                                                            </label>
                                                        </td>
                                                        <td>{{ $producto->codigo_producto }}</td>
                                                        <td>{{ $producto->nombre }}</td>
                                                        <td>{{ $producto->marca }}</td>
                                                        <td>{{ $producto->unidad_medida }}</td>
                                                        @if ($producto->estado_id == 1 || $producto->estado_id == 3)
                                                            <td>Activo</td>
                                                        @else
                                                            <td>Desactivo</td>
                                                        @endif
                                                        {{-- Aproximado --}}
                                                        {{-- <td>S/ {{ number_format((float) $producto->precio_nacional, 2, '.', '') }}</td> --}}
                                                        {{-- <td>$ {{ number_format((float) $producto->precio_extranjero, 2, '.', '') }}</td> --}}
                                                        {{-- <td>
                                                            @if (is_numeric($producto->precio_nacional))
                                                                S/
                                                                {{ explode('.', $producto->precio_nacional)[0] . '.' . substr(explode('.', $producto->precio_nacional)[1] ?? '00', 0, 2) }}
                                                            @else
                                                                {{ $producto->precio_nacional }}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if (is_numeric($producto->precio_extranjero))
                                                                $
                                                                {{ explode('.', $producto->precio_extranjero)[0] . '.' . substr(explode('.', $producto->precio_extranjero)[1] ?? '00', 0, 2) }}
                                                            @else
                                                                {{ $producto->precio_extranjero }}
                                                            @endif
                                                        </td> --}}

                                                        <td class="precio-cell"
                                                            data-precio-nacional="{{ $precios['precio_nacional'] }}"
                                                            data-precio-nacional-igv="{{ $precios['precio_nacional_igv'] }}"
                                                            data-precio-extranjero="{{ $precios['precio_extranjero'] }}"
                                                            data-precio-extranjero-igv="{{ $precios['precio_extranjero_igv'] }}">
                                                            {{ $precios['precio_nacional'] }}
                                                        </td>

                                                        <td>{{ $producto->stock }}</td>
                                                        <td class="position-relative">
                                                            {{-- ??? --}}
                                                            {{-- <i class="fa fa-book text-secondary me-3"
                                                                style="cursor:pointer;"></i> --}}
                                                            <div class="dropdown d-inline">
                                                                <i class="fa fa-ellipsis-h text-secondary"
                                                                    style="cursor:pointer;" id="dropdownMenuIcon1"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"></i>
                                                                <div class="dropdown-menu dropdown-menu-right"
                                                                    aria-labelledby="dropdownMenuIcon1">
                                                                    @php
                                                                        $peso_completo = $producto->peso ?? '0 gramos';
                                                                        $peso_parts = explode(' ', $peso_completo);
                                                                        $peso_cantidad = $peso_parts[0] ?? '0';
                                                                        $peso_unidad = $peso_parts[1] ?? 'gramos';
                                                                    @endphp
                                                                    <a class="dropdown-item edit-producto"
                                                                        data-toggle="modal" href="#EditProducto"
                                                                        data-id="{{ $producto->id }}"
                                                                        data-nombre="{{ $producto->nombre }}"
                                                                        data-codigo="{{ $producto->codigo_producto }}"
                                                                        data-codigo_original="{{ $producto->codigo_original }}"
                                                                        data-marca="{{ $producto->marca }}"
                                                                        data-marca_id="{{ $producto->marca_id }}"
                                                                        data-origen="{{ $producto->origen }}"
                                                                        data-peso_cantidad="{{ $peso_cantidad }}"
                                                                        data-peso_unidad="{{ $peso_unidad }}"
                                                                        data-stock="{{ $producto->stock_producto->stock ?? 0 }}"
                                                                        data-stock_minimo="{{ $producto->stock_minimo }}"
                                                                        data-stock_maximo="{{ $producto->stock_maximo }}"
                                                                        data-descuento_1="{{ $producto->descuento1 }}"
                                                                        data-descuento_2="{{ $producto->descuento2 }}"
                                                                        data-descuento_max="{{ $producto->descuento_maximo }}"
                                                                        data-precio_venta="{{ $producto->precio_venta }}"
                                                                        data-precio_compra="{{ $producto->precio_impuesto }}"
                                                                        data-afectacion="{{ $producto->tipo_afectacion_id }}"
                                                                        data-fecha="{{ $producto->fecha_creacion }}"
                                                                        data-utilidad="{{ $producto->utilidad }}"
                                                                        data-unidad_medida="{{ $producto->unidad_medida }}"
                                                                        data-unidad_medida_id="{{ $producto->unidad_medida_id }}"
                                                                        data-garantia="{{ $producto->garantia }}"
                                                                        data-familia="{{ $producto->familia_i_producto->descripcion ?? '' }}"
                                                                        data-familia_id="{{ $producto->familia_id }}"
                                                                        data-subfamilia="{{ $producto->subfamilia_i_producto->descripcion ?? '' }}"
                                                                        data-subfamilia_id="{{ $producto->subfamilia_id }}"
                                                                        data-descripcion="{{ $producto->descripcion }}"
                                                                        data-detalle="{{ $producto->detalle }}"
                                                                        data-archivo="{{ $producto->archivo }}"
                                                                        data-foto="{{ $producto->foto }}"
                                                                        data-estado_id="{{ $producto->estado_id }}">
                                                                        Editar
                                                                    </a>
                                                                    {{-- <a class="dropdown-item" href="#"
                                                                        data-toggle="modal"
                                                                        data-target="#ajusteStockModal">Ajustar Stock</a> --}}
                                                                    {{-- <a class="dropdown-item" href="#">Historial de
                                                                        Ventas</a> --}}
                                                                    {{-- <a class="dropdown-item" href="#">Historial de
                                                                        Compras</a> --}}
                                                                    <button class="dropdown-item text-danger"
                                                                        onclick="desactivarProducto({{ $producto->id }}, event)"
                                                                        style="width: 100%; cursor: pointer;">
                                                                        Desactivar
                                                                    </button>

                                                                    {{-- form oculto para desactivar producto --}}
                                                                    <form id="formDesactivarProduc{{ $producto->id }}"
                                                                        action="{{ route('productos.desactivar', $producto->id) }}"
                                                                        method="POST" style="display: none;">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--
<!-- Modal EditarProducto - 29/05/2025 -->
<div id="EditProducto" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="TituloProducto">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h2 class="model-title" id="TituloProducto"><b>Editar Producto</b></h2>
                <input type="checkbox" class="js-switch" checked>
            </div>
            <div class="modal-body p-3">
                <div class="scroll_content p-4">
                    <form action="">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-sm-2 col-lg-1">Nombre</label>
                            <div class="col-sm-10  col-lg-11">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Código</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-3">Cod. Original</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Marca</label>
                                    <div class="col-lg-10">
                                        <select class="form-control">
                                            <option value="Lenovo">Lenovo</option>
                                            <option value="LG">LG</option>
                                            <option value="Samsung">Samsung</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-sm-2 col-md-12 col-lg-3">Peso</label>
                                    <div class="col-sm-10 col-md-12 col-lg-9">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" step="0.01" min="0" value="2.5">
                                            </div>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="" id="">
                                                    <option value="Kilos">Kilos</option>
                                                    <option value="Litros">Litros</option>
                                                    <option value="Gramos">Gramos</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-sm-2 col-md-3">Origen</label>
                                    <div class="col-sm-10 col-md-9">
                                        <select name="" id="" class="form-control">
                                            <option value="">Producto Importado</option>
                                            <option value="">Producto Importado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-sm-2 col-md-3">Stock</label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="number" class="form-control" min="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Stock Mínimo</label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" min="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Stock Máximo</label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" min="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-3 col-lg-2">Unidad</label>
                                    <div class="col-md-9 col-lg-10">
                                        <select name="" id="" class="form-control">
                                            <option value="">(NIU) Unidad</option>
                                            <option value="">Unidad</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-3">Garantía</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Familia</label>
                                    <div class="col-lg-10">
                                        <select name="" id="" class="form-control">
                                            <option value="">Familia</option>
                                            <option value="">Familia</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-3">SubFamilia</label>
                                    <div class="col-lg-9">
                                        <select name="" id="" class="form-control">
                                            <option value="">SubFamilia</option>
                                            <option value="">SubFamilia</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-2">
                                <label for="" class="col-form-label">Precio de Venta</label>
                            </div>
                            <div class="col-md-12 col-lg-10">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="input-group m-b">
                                            <div class="input-group-prepend">
                                                <select name="" id="" class="btn btn-white">
                                                    <option value="">S/.</option>
                                                    <option value="">$</option>
                                                </select>
                                            </div>
                                            <input type="number" class="form-control" min="0.01" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-2"><i class="fa fa-question-circle"></i></div>
                                </div>
                                <div class="row m-1 bg-light d-flex align-items-center rounded-top rounded-bottom">
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Precio de Venta</b></label>
                                            <input type="text" class="border-0 form-control input-s-lg" data-mask=" S/. 999,999,999.99" placeholder="S/.">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Utilidad %</b></label>
                                            <input type="text" class="form-control input-s-lg" data-mask="99.99 %" placeholder="%">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Utilidad S/.</b></label>
                                            <input type="text" class="form-control input-s-lg" data-mask=" S/. 999,999,999.99" placeholder="S/.">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="" class="col-form-label col-md-2">Impuesto</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" value="IGV (18.00%)" min="0.01" step="0.01">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-form-label col-md-2">Ficha</label>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input id="logo" type="file" class="custom-file-input">
                                    <label for="logo" class="custom-file-label">Selecciona</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row d-flex align-items-center">
                            <label for="" class="col-form-label col-md-2">Imagen</label>
                            <div class="col-md-6">
                                <input type="file" id="archivoInput" name="avatar" onchange="return validarExt()">
                                <input name="avatar_respaldo" value="defecto_avatar.jpg" hidden>
                                <div id="visorArchivo">
                                    <img style="padding: 20px; width: 50%;" class="img-fluid" src="{{ asset('img/logos/categoria.svg') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h2>Subir Imagen</h2>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-form-label col-md-3 col-lg-2">Descripción</label>
                            <div class="col-md-9 col-lg-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-form-label col-md-3">Ùltimo precio de compra</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" value="S/.100.00">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary ml-3" value="Guardar">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal EditarProducto - 29/05/2025 -->

<!--NuevoProducto - 29/05/2025-->
<div id="NuevoProducto" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="TituloProducto">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h2 class="model-title" id="TituloProducto"><b>Nuevo Producto</b></h2>
                <input type="checkbox" class="js-switch-1" checked>
            </div>
            <div class="modal-body">
                <form action="{{ route('productos.store') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-form-label col-sm-2 col-lg-1">Nombre</label>
                        <div class="col-sm-10  col-lg-11">
                            <input type="text" class="form-control" placeholder="Nombre del Producto" required="required" data-toggle="tooltip" name="nombre" data-placement="top" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-2">Código</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-3">Cod. Original</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="" name="codigo_original" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-2">Marca</label>
                                <div class="col-lg-10">
                                    <select class="form-control marca_select2" name="marca_id" required="required">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-sm-2 col-md-12 col-lg-3">Peso</label>
                                <div class="col-sm-10 col-md-12 col-lg-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" name="peso" required="required" step="0.01" min="0" value="2.5" autocomplete="off">
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="simbolo" id="">
                                                <option value="Kilos">Kilos</option>
                                                <option value="Litros">Litros</option>
                                                <option value="Gramos">Gramos</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-sm-2 col-md-3">Origen</label>
                                <div class="col-sm-10 col-md-9">
                                    <select name="" id="" class="form-control">
                                        <option value="">Producto Importado</option>
                                        <option value="">Producto Importado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-sm-2 col-md-3">Stock</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="number" class="form-control" min="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-4">Stock Mínimo</label>
                                <div class="col-lg-8">
                                    <input type="number" class="form-control" name="stock_minimo" min="1" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-4">Stock Máximo</label>
                                <div class="col-lg-8">
                                    <input type="number" class="form-control" name="stock_maximo" min="1" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-md-3 col-lg-2">Unidad</label>
                                <div class="col-md-9 col-lg-10">
                                    <select name="unidad_medida_id" required class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-md-3">Garantía</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="garantia" value="12 meses" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-2">Familia</label>
                                <div class="col-lg-10">
                                    <select name="familia_id" id="familia_id_sl" required="required" class="form-control familia_select2" onchange="list_subfamilia()">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-3">SubFamilia</label>
                                <div class="col-lg-9">
                                    <select class="form-control subfamilia_select2" name="sub_familia_id">
                                        //
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary ml-3" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal NuevoProducto - 29/05/2025 -->
--}}
    <!-- Modal -->
    <div class="modal fade" id="ajusteStockModal" tabindex="-1" role="dialog" aria-labelledby="ajusteStockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow rounded">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">Ajuste de Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="font-weight-semibold">Nombre del Producto</span>
                        <span class="text-muted">x <strong>99 NIU</strong></span>
                    </div>

                    <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                        <label class="btn btn-outline-primary active">
                            <input type="radio" name="stockOption" value="incrementar" checked> Incrementar
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="stockOption" value="igualar"> Igualar a
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="stockOption" value="disminuir"> Disminuir
                        </label>
                    </div>

                    <div class="input-group mb-3" style="max-width: 200px;">
                        <input type="number" class="form-control border-primary" value="30" min="0">
                        <div class="input-group-append">
                            <span class="input-group-text border-primary">NIU</span>
                        </div>
                    </div>

                    <p class="font-weight-semibold">Cantidad final: <strong>129 NIU</strong></p>

                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Ajustar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para importar archivo Excel o CSV -->

    <div class="modal fade" id="miNuevoModal" tabindex="-1" role="dialog" aria-labelledby="miNuevoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="importForm" action="{{ route('productos.importar') }}" method="POST"
                enctype="multipart/form-data" class="modal-content border-0 shadow rounded">
                @csrf

                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold" id="miNuevoModalLabel">Importar archivo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"
                        id="cancelButtonTop">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="excel">Selecciona un archivo (.xlsx, .xls, .csv):</label>
                        <input type="file" name="excel" id="excel" class="form-control"
                            accept=".xlsx,.xls,.csv" required>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal"
                        id="cancelButton">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveButton">Guardar</button>
                </div>
            </form>
        </div>
    </div>


    <!--Código actual 14/11/2024-->
    {{-- @include('producto_servicios.shared.stadistics') --}}

    <!--Modal para anular producto-->
    @include('producto_servicios.productos.shared.modal_anular')

    <!--Base para agregar el tab para el los contenidos-->

    {{-- <div class="wrapper wrapper-content animated fadeInRight pt-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                @include('producto_servicios.productos.shared.tabs2')
                            </ul>


                            <div class="tab-content">

                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                    <div class="panel-body table-responsive">
                                        <div class="row">
                                            <div class="col-md-5">
                                            </div>
                                            <div class="col-md-5 ">
                                                <div class="input-group">
                                                    <label for="inputBuscar"
                                                        class="col-lg-2 col-form-label "><strong>Buscar:</strong></label>
                                                    <input type="text" id="inputBuscar" class="form-control"
                                                        aria-describedby="passwordHelpInline">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-primary btn-block" id="producto_buscar"
                                                    type="button">Buscar</button>
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table table-striped" id="table_prodac">
                                            <thead class="text-md-center">


                                                <tr>
                                                    <!--<th><input type="checkbox" checked class="i-checks" name="input[]"></th>-->
                                                    <th>Item</th>
                                                    <th>Nombre</th>
                                                    <th>Código producto</th>
                                                    <th>Código original</th>
                                                    <th>Familia</th>
                                                    <th>Marca</th>
                                                    <th>Afectación</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!--/ Fin del Código Gaby-->
    <style>
        .tab-pane.active.show {
            border-right: 1px solid #e7eaec;
            border-left: 1px solid #e7eaec;
            border-bottom: 1px solid #e7eaec;
        }

        .pie-md {
            /* max-width: 17%; */
            /* max-height: 50%; */
        }

        div.dataTables_length {
            display: none;
        }

        /* El Buscar */
        div.dataTables_filter {
            display: none;
        }

        /* CSV, Excel, PDF, Print */
        div.dt-buttons {
            display: none;
        }

        /* Tamaño de los botones del index */
        .tam {
            min-width: 150px;
            min-height: 150px;
        }

        input#archivoInput {
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
            width: 100%;
            /*height:100%;*/
            opacity: 0;
            padding: 30px;
        }

        input#archivoInput:hover {
            cursor: pointer;
        }

        .custom-file-label {
            word-break: break-all;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .custom-file-label::after {
            content: "Select"
        }

        .custom-file-input:hover {
            cursor: pointer;
        }

        .form-control {
            border-radius: 5px;
        }

        .fa-question-circle:hover {
            color: blue;
        }
    </style>

    <style>
        .select2.select2-container.select2-container--default {
            width: 100% !important;
            height: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            height: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 32px !important;
        }
    </style>

    <style>
        .cb-codigo,
        .cb-product {
            width: 14px;
            height: 14px;
            padding: 2px;
            border: 1.5px solid #1e3a8a;
            border-radius: 50%;
        }

        .cb-codigo div,
        .cb-product div {
            width: 100%;
            height: 100%;
            background-color: transparent;
            border-radius: 50%;
        }

        .cb-codigo input:checked~div,
        .cb-product input:checked~div {
            background-color: #1e3a8a;
        }
    </style>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- d3 and c3 charts -->
    <script src="{{ asset('js/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('js/plugins/c3/c3.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>

    {{-- <!-- Switchery -->
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script> --}}

    <!-- Jasny -->
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <link href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/codemirror/codemirror.css') }}" rel="stylesheet">

    <!-- Input Mask -->
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>

    <!-- DROPZONE -->
    <script src="{{ asset('js/plugins/dropzone/dropzone.js') }}"></script>

    <!-- CodeMirror -->
    <script src="{{ asset('js/plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('js/plugins/codemirror/mode/xml/xml.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> --}}
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    {{-- alertas SWEET --}}
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>



    <script>
        $(document).ready(function() {
            // var elem = document.querySelector('.js-switch');
            // var switchery = new Switchery(elem, { color: '#2776ea' });
            // var elem1 = document.querySelector('.js-switch-1');
            // var switchery = new Switchery(elem1, { color: '#2776ea' });

            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
        $(document).ready(function() {
            $('.scroll_content').slimscroll({
                height: '450px'
            })
        });

        // function validarExt() {
        //     var archivoInput = document.getElementById('foto_id');
        //     var archivoRuta = archivoInput.value;
        //     var extPermitidas = /(.jpg|.png|.jfif)$/i;
        //     if (!extPermitidas.exec(archivoRuta)) {
        //         archivoInput.value = '';
        //         return false;
        //     } else {
        //         if (archivoInput.files && archivoInput.files[0]) {
        //             var visor = new FileReader();
        //             visor.onload = function(e) {
        //                 document.getElementById('visorArchivo').innerHTML =
        //                     '<img name="foto" src="' + e.target.result + '" style="width:55%;padding: 30px;"/>';
        //             };
        //             visor.readAsDataURL(archivoInput.files[0]);
        //         }
        //     }
        // }
    </script>


    {{-- <script>
        $(document).ready(function() {
            $('#tab-1-tab').addClass('active show');
            $('#table_prodac').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_productos') }}",
                    method: "get",
                    data: function(d) {
                        d.estado = 1;
                        d.value = $('#inputBuscar').val();
                    },
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                "pageLength": 15,
                "order": [
                    [0, "desc"]
                ],
                "columnDefs": [{
                    'targets': [0]
                }, {
                    'targets': [1]
                }, {
                    'targets': [2]
                }, {
                    'targets': [3],
                    'render': function(data, type, full, meta) {
                        return "<input type='hidden' id='producto_nombre_" + full[0] +
                            "' value='" + full[1] + "' >" + full[3] + "";
                    }
                }, {
                    'targets': [4]
                }, {
                    'targets': [7],
                    'render': function(data, type, full, meta) {

                        return "<a href='{{ route('productos.show', '') }}/" + full[0] +
                            "'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i></button></a> <button type='button' class='btn btn-danger btn-sm' onclick='abrir_modal(" +
                            full[0] +
                            ")'> <i class='fa fa-trash-o' aria-hidden='true'></i></button> ";
                    }
                }]
            });
        });
        $('#producto_buscar').on('click', function() {
            $('#table_prodac').DataTable().ajax.reload();
        });

        function abrir_modal(a) {
            var nombre = document.getElementById(`producto_nombre_${a}`).value;
            document.getElementById(`prod_nombre`).innerHTML = nombre;
            document.getElementById(`prod_id_form`).value = a;
            $('#producto_modal').modal('show');
        }
    </script> --}}
    {{-- <script>
  $(document).ready(function () {
    $('#table_prod').DataTable({
      "serverSide": true,
      "processing": true,
      "ajax": "{{ url('api/productos') }}",
      "columns": [
        {
          data: 'prod_id',
          render: function (data) {
            return '<input type="radio" name="product" value="' + data + '">';
          },
          orderable: false,
          searchable: false
        },
        { data: 'codigo_producto' },
        { data: 'prod_nombre' },
        { data: 'nombre_marca' },
        { data: 'unidad_medida' },
        {
          data: 'precio',
          render: function (data) {
            return 'S/. ' + parseFloat(data).toFixed(2);
          }
        },
        { data: 'stock' },
        {
          data: null,
          orderable: false,
          searchable: false,
          render: function (data) {
            return `
              <i class="fa fa-book text-secondary me-3" style="cursor:pointer;"></i>
              <div class="dropdown d-inline">
                <i class="fa fa-ellipsis-h text-secondary" style="cursor:pointer;" id="dropdownMenu${data.prod_id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu${data.prod_id}">
                  <a class="dropdown-item" data-toggle="modal" href="#EditProducto" data-id="${data.prod_id}">Editar</a>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ajusteStockModal" data-id="${data.prod_id}">Ajustar Stock</a>
                  <a class="dropdown-item" href="#">Historial de Ventas</a>
                  <a class="dropdown-item" href="#">Historial de Compras</a>
                  <a class="dropdown-item text-danger" href="#">Eliminar</a>
                </div>
              </div>`;
          }
        }
      ],
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
      }
    });
  });
</script> --}}

    <script>
        $(document).ready(function() {
            // ÚNICA inicialización de DataTable con todas las configuraciones
            const table = $('#table_prod').DataTable({
                ordering: false, // Desactiva el ordenamiento en toda la tabla
        // Mantener todas las demás funcionalidades de DataTables
        searching: true,
        paging: true,
        info: true,
        lengthChange: true
            });

            // Funcionalidad de filtro personalizado
            $('#th-nombre').off('click.DT');
            $('#th-nombre').on('click', function() {
                $('#nombre-label').addClass('d-none');
                $('#filtrarNombre').removeClass('d-none').focus();
            });

            $('#filtrarNombre').on('blur', function() {
                if ($(this).val().trim() === '') {
                    $(this).addClass('d-none');
                    $('#nombre-label').removeClass('d-none');
                }
            });

            $('#filtrarNombre').on('keyup change', function() {
                table.search(this.value).draw();
            });

            // Funcionalidad de checkboxes
            const cb_codigo = document.getElementById('cb-codigo');
            let selectedProducts = new Set();

            if (cb_codigo) {
                cb_codigo.addEventListener('change', function(event) {
                    selectedProducts.clear();

                    if (cb_codigo.checked) {
                        table.rows().every(function() {
                            const rowData = this.data();
                            const rowNode = this.node();
                            const estadoId = $(rowNode).attr('data-estado');

                            if (estadoId == '1') {
                                const checkbox = $(rowNode).find('input[name="product"]')[0];
                                if (checkbox) {
                                    const productId = checkbox.dataset.id;
                                    checkbox.checked = true;
                                    selectedProducts.add(productId);
                                }
                            }
                        });
                    } else {
                        table.rows().every(function() {
                            const rowNode = this.node();
                            const checkbox = $(rowNode).find('input[name="product"]')[0];
                            if (checkbox) {
                                checkbox.checked = false;
                            }
                        });
                    }

                    updateVisibleCheckboxes();
                });

                function updateVisibleCheckboxes() {
                    $('#table_prod tbody tr').each(function() {
                        const checkbox = $(this).find('input[name="product"]')[0];
                        if (checkbox) {
                            const productId = checkbox.dataset.id;
                            checkbox.checked = selectedProducts.has(productId);
                        }
                    });
                }

                table.on('draw', function() {
                    updateVisibleCheckboxes();
                });

                $(document).on('change', 'input[name="product"]', function() {
                    const productId = this.dataset.id;

                    if (this.checked) {
                        selectedProducts.add(productId);
                    } else {
                        selectedProducts.delete(productId);
                        cb_codigo.checked = false;
                    }
                });

                // Verificar si existe el botón antes de agregar el event listener
                const exportButton = document.getElementById('exportSelected');
                if (exportButton) {
                    exportButton.addEventListener('click', function(e) {
                        e.preventDefault();

                        const selectedIds = Array.from(selectedProducts);

                        if (selectedIds.length === 0) {
                            alert('Selecciona al menos un producto');
                            return;
                        }

                        const baseUrl = "{{ route('export.selected.products') }}";
                        const url = baseUrl + '?ids=' + selectedIds.join(',');

                        window.location.href = url;
                    });
                }
            }
        });
    </script>

    {{-- <script>
        $(document).ready(function(){
            $('.dataTables-productoNuevo').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>

     <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cb_codigo = document.getElementById('cb-codigo');
            const table = $('#table_prod').DataTable();

            let selectedProducts = new Set();

            cb_codigo.addEventListener('change', function(event) {
                selectedProducts.clear();

                if (cb_codigo.checked) {

                    table.rows().every(function() {
                        const rowData = this.data();
                        const rowNode = this.node();
                        const estadoId = $(rowNode).attr('data-estado');

                        if (estadoId == '1') {
                            const checkbox = $(rowNode).find('input[name="product"]')[0];
                            const productId = checkbox.dataset.id;

                            checkbox.checked = true;

                            selectedProducts.add(productId);
                        }
                    });
                } else {

                    table.rows().every(function() {
                        const rowNode = this.node();
                        const checkbox = $(rowNode).find('input[name="product"]')[0];
                        checkbox.checked = false;
                    });
                }

                updateVisibleCheckboxes();
            });

            function updateVisibleCheckboxes() {
                $('#table_prod tbody tr').each(function() {
                    const checkbox = $(this).find('input[name="product"]')[0];
                    if (checkbox) {
                        const productId = checkbox.dataset.id;
                        checkbox.checked = selectedProducts.has(productId);
                    }
                });
            }

            table.on('draw', function() {
                updateVisibleCheckboxes();
            });

            $(document).on('change', 'input[name="product"]', function() {
                const productId = this.dataset.id;

                if (this.checked) {
                    selectedProducts.add(productId);
                } else {
                    selectedProducts.delete(productId);
                    cb_codigo.checked = false;
                }
            });

            document.getElementById('exportSelected').addEventListener('click', function(e) {
                e.preventDefault();

                const selectedIds = Array.from(selectedProducts);

                if (selectedIds.length === 0) {
                    alert('Selecciona al menos un producto');
                    return;
                }

                const baseUrl = "{{ route('export.selected.products') }}";
                const url = baseUrl + '?ids=' + selectedIds.join(',');

                window.location.href = url;
            });
        });
    </script> --}}

    {{-- <script>
        $(document).ready(function(){
            $('.familia_select2').select2({
            placeholder: "Seleccionar",

            });
            $('.subfamilia_select2').select2({
            placeholder: "Seleccionar",
            });
            $('.marca_select2').select2();
        });
        function list_subfamilia(){
            var family = $('.familia_select2').val();
            $('.subfamilia_select2').val(null).trigger('change');

            // console.log(family);
            $('.subfamilia_select2').select2({
            placeholder: "Seleccionar",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('subfamilia.search_ajax') }}",
                dataType: 'json',
                type: "POST",
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        familia_id: family
                    };
                },
                processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.descripcion,
                        };
                    })
                };
                },
                cache: true
            }
            });
        }
        function calcular_utilidad(){
            var precio_venta = document.getElementById("precio_venta").value;
            var precio_compra = document.getElementById("precio_compra").value;

            if (!isNaN(precio_venta) || !isNaN(precio_compra) ) {
            // var utilidad = (parseFloat(precio_compra)/100) * parseFloat(precio_venta);
            var a1 =  parseFloat(precio_venta) * 100;
            var a2 = parseFloat(a1) / parseFloat(precio_compra);
            var utilidad = parseFloat(a2) - 100;
            document.getElementById("sumando").value = utilidad;
            }
        }
        //VALIDACION DE UTILIDAD PARA QUE NO ACEPTA LETRAS
        $('.input_valor_numerico').on('input', function () {
            this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
        });
        $('.button_guardar').on('mouseenter', function () {
            var lol = document.querySelectorAll('.input_valor_numerico');
            lol.forEach(element => {
                if (element.val == "" || isNaN(Number(element.value)) == true) {
                element.value = 0;
                }
            });
        });

    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Abrir modal cuando se da clic al ícono
            document.getElementById('openUploadModal').addEventListener('click', function() {
                $('#miNuevoModal').modal('show');
            });



            // // Evento para botón Cancelar (ícono cerrar)
            // document.getElementById('cancelButtonTop').addEventListener('click', function() {
            //     swal("Cancelado", "La operación fue cancelada.", "info");
            //     // El modal se cierra automáticamente por data-dismiss="modal"
            // });

            // Evento para botón Guardar - CORREGIDO
            document.getElementById('saveButton').addEventListener('click', function() {
                let inputFile = document.getElementById('excel');

                /*// Validar que se haya seleccionado un archivo
                if (!inputFile.files.length) {
                    swal("Error", "Por favor selecciona un archivo para importar.", "error");
                    return;
                }*/

                // Validar tipo de archivo
                let fileName = inputFile.files[0].name;
                let fileExtension = fileName.split('.').pop().toLowerCase();
                let allowedExtensions = ['xlsx', 'xls', 'csv'];

                if (!allowedExtensions.includes(fileExtension)) {
                    swal("Error", "El archivo debe ser de tipo Excel (.xlsx, .xls) o CSV (.csv).", "error");
                    return;
                }

                // Confirmación con SweetAlert v1 - SINTAXIS CORREGIDA
                swal({
                    title: "¿Seguro que deseas importar?",
                    text: "Se procesará el archivo: " + fileName,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, importar",
                    cancelButtonText: "Cancelar"
                }, function(isConfirm) {
                    if (isConfirm) {
                        // Mostrar loading
                        swal({
                            title: "Procesando...",
                            text: "Por favor espera mientras se importa el archivo.",
                            type: "info",
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });

                        // Enviar formulario
                        // console.log('Enviando formulario...');
                        document.getElementById('importForm').submit();
                    }


                });
            });

            // Limpiar formulario al cerrar modal
            $('#miNuevoModal').on('hidden.bs.modal', function() {
                document.getElementById('importForm').reset();
            });

            // Mostrar nombre del archivo seleccionado (opcional)
            document.getElementById('excel').addEventListener('change', function() {
                let fileName = this.files[0] ? this.files[0].name : '';

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let currentProductId = null;

            let todasLasSubfamilias = @json($subfamilias);

            $('#edit_familia').on('change', function() {
                var Idfamilia = $(this).val();
                var subfamiliaSelect = $('#edit_subfamilia');

                subfamiliaSelect.empty();

                if (Idfamilia) {
                    var subfamiliasFiltradas = todasLasSubfamilias.filter(function(subfamilia) {
                        return subfamilia.id_familia == Idfamilia;
                    });

                    subfamiliasFiltradas.forEach(function(subfamilia) {
                        subfamiliaSelect.append('<option value="' + subfamilia.id + '">' +
                            subfamilia.descripcion + '</option>');
                    });
                }
            });

            $('#familia_id_sl').on('change', function() {
                var Idfamilia = $(this).val();
                var subfamiliaSelect = $('.subfamilia_select2');

                subfamiliaSelect.empty();

                if (Idfamilia) {
                    var subfamiliasFiltradas = todasLasSubfamilias.filter(function(subfamilia) {
                        return subfamilia.id_familia == Idfamilia;
                    });

                    subfamiliasFiltradas.forEach(function(subfamilia) {
                        subfamiliaSelect.append('<option value="' + subfamilia.id + '">' +
                            subfamilia.descripcion + '</option>');
                    });
                }
            });

            $('#NuevoProducto').on('shown.bs.modal', function() {
                $('#familia_id_sl').trigger('change');
            });

            $(document).on('click', '.edit-producto', function() {
                currentProductId = $(this).data('id');

                var nombre = $(this).data('nombre');
                var codigo = $(this).data('codigo');
                var codigo_original = $(this).data('codigo_original');
                var marca = $(this).data('marca');
                var marca_id = $(this).data('marca_id');
                var origen = $(this).data('origen');
                var peso_cantidad = $(this).data('peso_cantidad');
                var peso_unidad = $(this).data('peso_unidad');
                // var stock = $(this).data('stock');
                var stock_minimo = $(this).data('stock_minimo');
                var stock_maximo = $(this).data('stock_maximo');
                var descuento_1 = $(this).data('descuento_1');
                var descuento_2 = $(this).data('descuento_2');
                var descuento_max = $(this).data('descuento_max');
                var utilidad = $(this).data('utilidad');
                var unidad_medida = $(this).data('unidad_medida');
                var unidad_medida_id = $(this).data('unidad_medida_id');
                var precio_venta = $(this).data('precio_venta');
                var precio_compra = $(this).data('precio_compra');
                var afectacion = $(this).data('afectacion');
                var garantia = $(this).data('garantia');
                var familia = $(this).data('familia');
                var familia_id = $(this).data('familia_id');
                var subfamilia = $(this).data('subfamilia');
                var subfamilia_id = $(this).data('subfamilia_id');
                var descripcion = $(this).data('descripcion');
                var fecha = $(this).data('fecha');
                var estado_id = $(this).data('estado_id');
                var archivo = $(this).data('archivo');
                var foto = $(this).data('foto');

                $('#edit_nombre').val(nombre);
                $('#edit_codigo').val(codigo);
                $('#edit_codigo_original').val(codigo_original);
                $('#edit_origen').val(origen);
                $('#edit_peso_cantidad').val(peso_cantidad);
                $('#edit_peso_unidad').val(peso_unidad);
                // $('#edit_stock').val(stock);
                $('#edit_stock_minimo').val(stock_minimo);
                $('#edit_stock_maximo').val(stock_maximo);
                $('#edit_descuento_1').val(descuento_1);
                $('#edit_descuento_2').val(descuento_2);
                $('#edit_descuento_max').val(descuento_max);
                $('#edit_utilidad').val(utilidad);
                $('#edit_precio_compra').val(precio_compra);
                $('#edit_afectacion').val(afectacion);
                $('#edit_precio_venta').val(precio_venta);
                $('#edit_garantia').val(garantia);
                $('#edit_descripcion').val(descripcion);
                $('#edit_fecha').val(fecha);
                $('#edit_estado_id').val(estado_id);
                // $('#ficha_tecnica_edit').val(archivo);
                $('.value-input-file').html(archivo);
                $('#link_archivo').attr('href', "{{ asset('archivos/productos/fichas') }}/" + archivo);
                $('#link_archivo').attr('download', archivo);
                // $('#fotoPreviaEdit').html(foto);
                // $("#foo").attr("src", foto);
                $('#fotoPreviaEdit').attr('src', "{{ asset('archivos/imagenes/productos')}}/" + foto);
                // $('#link_archivo').attr('download', archivo);


                if (marca_id) {
                    $('#edit_marca').val(marca_id).trigger('change');
                } else {
                    $('#edit_marca').val(marca);
                }

                if (unidad_medida_id) {
                    $('#edit_unidad_medida').val(unidad_medida_id).trigger('change');
                } else {
                    $('#edit_unidad_medida').val(unidad_medida);
                }

                if (familia_id) {
                    $('#edit_familia').val(familia_id).trigger('change');

                    var subfamiliaSelect = $('#edit_subfamilia');
                    // subfamiliaSelect.empty();
                    edit_list_subfamilia();
                    // var subfamiliasFiltradas = todasLasSubfamilias.filter(function(subfamilia) {
                    //     return subfamilia.id_familia == familia_id;
                    // });

                    // subfamiliasFiltradas.forEach(function(subfamilia) {
                    //     subfamiliaSelect.append('<option value="' + subfamilia.id + '">' +
                    //         subfamilia.descripcion + '</option>');
                    // });

                    if (subfamilia_id) {
                        $('#edit_subfamilia').val(subfamilia_id).trigger('change');
                    }
                } else {
                    $('#edit_familia').val(familia);
                }

                if (afectacion) {
                    $('#edit_tipo_afectacion').val(afectacion).trigger('change');
                }

                if (archivo) {
                    $('#col-dw-ficha').css('display', 'flex');
                    $('#col-dw-ficha').addClass('col-md-1 justify-content-center');
                    $('#col-ficha').removeClass('col-md-10');
                    $('#col-ficha').addClass('col-md-9');
                } else {
                    $('#col-ficha').removeClass('col-md-9');
                    $('#col-ficha').addClass('col-md-10');
                    $('#col-dw-ficha').css('display', 'none');
                }
            });

            $('#EditProducto').on('click', 'input[type="submit"]', function(e) {
                e.preventDefault();

                if (!currentProductId) {
                    return;
                }
                var estadoValue = $('input[name="estado_id"]').val()
                var formData = new FormData();
                formData.append('nombre', $('#edit_nombre').val());
                formData.append('codigo_producto', $('#edit_codigo').val());
                formData.append('codigo_original', $('#edit_codigo_original').val());
                formData.append('marca_id', $('#edit_marca').val());
                formData.append('origen', $('#edit_origen').val());
                formData.append('peso_cantidad', $('#edit_peso_cantidad').val());
                formData.append('peso_unidad', $('#edit_peso_unidad').val());
                // formData.append('stock', $('#edit_stock').val());
                formData.append('stock_minimo', $('#edit_stock_minimo').val());
                formData.append('stock_maximo', $('#edit_stock_maximo').val());
                formData.append('descuento_1', $('#edit_descuento_1').val());
                formData.append('descuento_2', $('#edit_descuento_2').val());
                formData.append('descuento_max', $('#edit_descuento_max').val());
                formData.append('utilidad', $('#edit_utilidad').val());
                formData.append('precio_venta', $('#edit_precio_venta').val());
                formData.append('unidad_medida_id', $('#edit_unidad_medida').val());
                formData.append('garantia', $('#edit_garantia').val());
                formData.append('familia_id', $('#edit_familia').val());
                formData.append('subfamilia_id', $('#edit_subfamilia').val());
                formData.append('precio_nacional', $('#edit_precio_compra').val());
                formData.append('estado_id', estadoValue);
                formData.append('descripcion', $('#edit_descripcion').val());
                formData.append('detalle', $('#edit_detalle').val());
                formData.append('_method', 'PUT'); // Para Laravel si no usas directamente PUT
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                if ($('#ficha_tecnica_edit')[0].files.length > 0) {
                    formData.append('archivo', $('#ficha_tecnica_edit')[0].files[0]);
                }
                if ($('#fotoIntupEdit')[0].files.length > 0) {
                    formData.append('foto', $('#fotoIntupEdit')[0].files[0]);
                }

                var submitBtn = $(this);
                submitBtn.prop('disabled', true).val('Guardando...');

                // Genera la URL usando el helper route() de Laravel
                const updateProductUrl = "{{ route('productos.update', ':id') }}";

                // Tu función Ajax corregida
                $.ajax({
                    url: updateProductUrl.replace(':id', currentProductId),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#EditProducto').modal('hide');
                            // location.reload();
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'Error al actualizar el producto';

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            var errorList = [];

                            for (var field in errors) {
                                errorList.push(errors[field][0]);
                            }

                            errorMessage += ':\n' + errorList.join('\n');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage += ': ' + xhr.responseJSON.message;
                        }

                        // Mostrar el error al usuario
                        alert(errorMessage);
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).val('Guardar');
                    }
                });
            });

            $('#EditProducto').on('hidden.bs.modal', function() {
                currentProductId = null;
                $('#EditProducto form')[0].reset();
            });

        });
    </script>

    <script>
        window.onload = function() {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 4000);
            }
        };
    </script>
    <script>
        document.getElementById('openUploadModal').addEventListener('click', function() {
            $('#miNuevoModal').modal('show');
        });
    </script>

    {{-- exportar productos --}}
    <script>
        const exportProducAll = document.getElementById('formExportProdAll');

        function exportarTodo(e) {
            e.preventDefault()
            exportProducAll.submit()
        }
    </script>

    {{-- script submit para desactivar producto --}}
    <script>
        function desactivarProducto(id, e) {
            e.preventDefault()
            const form = document.getElementById('formDesactivarProduc' + id)
            if (form) {
                form.submit()
            }
        }
    </script>

    <script>
        $(document).ready(function() {

            let estadoPrecioActual = 0;
            const estadoPrecio = [
                { title: 'Precio Nacional', attribute: 'data-precio-nacional' },
                { title: 'Precio Nacional IGV', attribute: 'data-precio-nacional-igv' },
                { title: 'Precio Extranjero', attribute: 'data-precio-extranjero' },
                { title: 'Precio Extranjero IGV', attribute: 'data-precio-extranjero-igv' }
            ];

            function actualizarVistaPrecio() {
                const estadoActual = estadoPrecio[estadoPrecioActual];
                $('#precio-title').text(estadoActual.title);
                $('#precio-indicator').text(`(${estadoPrecioActual + 1}/4)`);

                $('.precio-cell').each(function() {
                    const newPrice = $(this).attr(estadoActual.attribute);
                    $(this).text(newPrice);
                });
            }

            $('#precio-header').on('click', function(e) {
                e.stopPropagation();
                e.preventDefault();

                estadoPrecioActual = (estadoPrecioActual + 1) % 4;
                actualizarVistaPrecio();
            });

            $('#precio-header').hover(
                function() { $(this).css('background-color', '#e9ecef'); },
                function() { $(this).css('background-color', ''); }
            );
        });
    </script>
    @include('producto_servicios.productos.create')

    @include('producto_servicios.shared.pie')

@endsection

