@extends('layout')
@section('title', 'Productos')
@section('atributo_actu', 'hidden')
@section('value_accion', 'Agregar')
@section('href_accion', route('productos.create'))

@section('content')


{{--
@section('styles')
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


--}}

{{--
@section('scripts')
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


--}}

@if(session('success') || session('error') || session('warning'))
    <div id="toast" class="toast
        {{ session('success') ? 'success' : '' }}
        {{ session('error') ? 'error' : '' }}
        {{ session('warning') ? 'warning' : '' }}">

        <span class="toast-icon">
            @if(session('success')) ✔️ @endif
            @if(session('error')) ❌ @endif
            @if(session('warning')) ⚠️ @endif
        </span>

        <p style="margin: 0; flex: 1;">
            {{ session('success') ?? session('error') ?? session('warning') }}
        </p>

        <button class="toast-close" onclick="document.getElementById('toast').classList.remove('show')">&times;</button>
    </div>
@endif

<div class="wrapper wrapper-content animated fadeInRight">








<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox">
    <div class="ibox-content">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap mb-3">
            <div class="nav nav-tabs border-0">
                <a href="#" class="btn btn-link text-dark font-weight-bold">Productos</a>
                <a href="#" class="btn btn-link text-muted">Paquetes</a>
                <a href="#" class="btn btn-link text-muted">Familia</a>
                <a href="#" class="btn btn-link text-muted">Subfamilia</a>
            </div>
            <button class="btn btn-primary" data-toggle="modal" data-target="#NuevoProducto">Nuevo Producto</button>
            <i class="fa fa-plus text-secondary mx-2" style="cursor: pointer;"></i>
            <!-- Ícono para abrir el modal -->
            <i class="fa fa-upload text-secondary mx-2" style="cursor: pointer;" id="openUploadModal"></i>

            <i class="fa fa-download text-secondary mx-2" style="cursor: pointer;"></i>
            <i class="fa fa-user text-secondary mx-2" style="cursor: pointer;"></i>
        </div>

      <div class="table-responsive" >
        <table class="table table-striped table-hover bg-white align-middle dataTables-productoNuevo" id="table_prod">
            <thead class="table-light">
            <tr>
              <th>
                 <!-- Josue Pilco -->
                <label class="cb-codigo">
                    <input type="checkbox" id="cb-codigo" hidden>
                    <div></div>
                </label>
                 <!-- Josue Pilco -->
              </th>
              <th>Código <i class="fa fa-search"></i></th>
              <th>Nombre <i class="fa fa-search"></i></th>
              <th>Marca <i class="fa fa-search"></i></th>
              <th>Unidad <i class="fa fa-filter"></i></th>
              <th>Estado<i class="fa fa-search"></i></th>
              <th>Precio Nacional<i class="fa fa-search"></i></th>
              <th>Precio Extranjero<i class="fa fa-search"></i></th>
              <th>Stock <i class="fa fa-search"></i></th>
              <th><i class="fa fa-sliders"></i></th>
            </tr>
            </thead>
          <tbody>
            @foreach ($productos as $producto)
            <tr>
                {{-- contenido estático --}}
                {{-- <td><input type="radio" name="product"></td>
                <td>LN-000001</td>
                <td>Laptop Asus TUF Gaming</td>
                <td>ASUS</td>
                <td>UNIDAD</td>
                <td>S/. 2800.00</td>
                <td>10</td>
                <td class="position-relative">
                    <i class="fa fa-book text-secondary me-3" style="cursor:pointer;"></i>
                    <div class="dropdown d-inline">
                    <i class="fa fa-ellipsis-h text-secondary" style="cursor:pointer;" id="dropdownMenuIcon1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuIcon1">
                        <a class="dropdown-item" data-toggle="modal" href="#EditProducto">Editar</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ajusteStockModal">Ajustar Stock</a>
                        <a class="dropdown-item" href="#">Historial de Ventas</a>
                        <a class="dropdown-item" href="#">Historial de Compras</a>
                        <a class="dropdown-item text-danger" href="#">Eliminar</a>
                    </div>
                    </div>
                </td> --}}

                    <td>
                        <!-- Josue Pilco -->
                        <label class="cb-product">
                            <input type="checkbox" name="product" hidden>
                            <div></div>
                        </label>
                         <!-- Josue Pilco -->
                    </td>
                    <td>{{ $producto->codigo_producto }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->marca }}</td>
                    <td>{{ $producto->unidad_medida }}</td>
                     <td>{{ $producto->estado_anular == 1 ? 'Activo' : 'Anulado'}}</td>
                    {{-- Aproximado --}}
                    {{-- <td>S/ {{ number_format((float) $producto->precio_nacional, 2, '.', '') }}</td> --}}
                    {{-- <td>$ {{ number_format((float) $producto->precio_extranjero, 2, '.', '') }}</td> --}}
                    <td>
                        @if (is_numeric($producto->precio_nacional))
                            S/ {{ explode('.', $producto->precio_nacional)[0] . '.' . substr(explode('.', $producto->precio_nacional)[1] ?? '00', 0, 2) }}
                        @else
                            {{ $producto->precio_nacional }}
                        @endif
                    </td>

                    <td>
                        @if (is_numeric($producto->precio_extranjero))
                            $ {{ explode('.', $producto->precio_extranjero)[0] . '.' . substr(explode('.', $producto->precio_extranjero)[1] ?? '00', 0, 2) }}
                        @else
                            {{ $producto->precio_extranjero }}
                        @endif
                    </td>

                    <td>{{ $producto->stock }}</td>
                    <td class="position-relative">
                        <i class="fa fa-book text-secondary me-3" style="cursor:pointer;"></i>
                        <div class="dropdown d-inline">
                        <i class="fa fa-ellipsis-h text-secondary" style="cursor:pointer;" id="dropdownMenuIcon1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuIcon1">
                            <a class="dropdown-item" data-toggle="modal" href="#EditProducto">Editar</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ajusteStockModal">Ajustar Stock</a>
                            <a class="dropdown-item" href="#">Historial de Ventas</a>
                            <a class="dropdown-item" href="#">Historial de Compras</a>
                            <a class="dropdown-item text-danger" href="#">Eliminar</a>
                        </div>
                        </div>
                    </td>

            </tr>
            @endforeach
            {{-- <tr>
              <td><input type="radio" name="product"></td>
              <td>LN-000002</td>
              <td>TECLADO INALÁMBRICO</td>
              <td>LENOVO</td>
              <td>BOLSA</td>
              <td>S/. 140.50</td>
              <td>20</td>
              <td><i class="fa fa-ellipsis-h"></i></td>
            </tr> --}}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
 <!-- Josue Pilco -->
<script>
    const cb_codigo = document.getElementById('cb-codigo');

    cb_codigo.addEventListener('change', function(event) {
        const table = $('#table_prod').DataTable();

        table.rows().nodes().to$().each(function() {
            const estado = $(this).find('td').eq(5).text().trim();

            if (estado === 'Activo') {
                $(this).find('input[name="product"]').prop('checked', cb_codigo.checked);
            } else {
                $(this).find('input[name="product"]').prop('checked', false);
            }
        });
    });
</script>
<!-- Josue Pilco -->

@include('producto_servicios.productos.create')
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
<div class="modal fade" id="ajusteStockModal" tabindex="-1" role="dialog" aria-labelledby="ajusteStockModalLabel" aria-hidden="true">
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

<!-- Modal para importar archivo Excel o CSV  Pilco-->

<div class="modal fade" id="miNuevoModal" tabindex="-1" role="dialog" aria-labelledby="miNuevoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="importForm" action="{{ route('productos.importar') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow rounded">
      @csrf

      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title font-weight-bold" id="miNuevoModalLabel">Importar archivo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" id="cancelButtonTop">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label for="excel">Selecciona un archivo (.xlsx, .xls, .csv):</label>
          <input type="file" name="excel" id="excel" class="form-control" accept=".xlsx,.xls,.csv" required>
        </div>
      </div>

      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-light" data-dismiss="modal" id="cancelButton">Cancelar</button>
        <button type="button" class="btn btn-primary" id="saveButton">Guardar</button>
      </div>
    </form>
  </div>
</div>






<script>
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
</script>
<script>
  document.getElementById('openUploadModal').addEventListener('click', function () {
    $('#miNuevoModal').modal('show');
  });
</script>








    <!--Código actual 14/11/2024-->
    @include('producto_servicios.shared.stadistics')

    <!--Modal para anular producto-->
    @include('producto_servicios.productos.shared.modal_anular')

    <!--Base para agregar el tab para el los contenidos-->

    <div class="wrapper wrapper-content animated fadeInRight pt-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                @include('producto_servicios.productos.shared.tabs2')
                            </ul>


                            <!-- Tablas y su contenido -->
                            <div class="tab-content">

                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                    <div class="panel-body table-responsive">
                                        <div class="row">
                                            <div class="col-md-5">
                                                {{-- ACA PUEDE IR OTRO FILTRO DE BUSQUEDA --}}
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
                                        <!-- CONTENIDO DENTRO DEL TAB -->
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
    </div>
    <!--/ Fin del Código Gaby-->
    <style>
        .pie-md {
            max-width: 17%;
            max-height: 50%;
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
    </style>
    <style>
        input#archivoInput{
            position:absolute;
            top:0px;
            left:0px;
            right:0px;
            bottom:0px;
            width:100%;
            /*height:100%;*/
            opacity: 0  ;
            padding: 30px;
        }
        input#archivoInput:hover{
            cursor: pointer;
        }
        .custom-file-label{
            word-break: break-all;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }
        .custom-file-label::after{
            content: "Select"
        }
        .custom-file-input:hover{
            cursor: pointer;
        }
        .form-control{
            border-radius: 5px;
        }
        .fa-question-circle:hover{color: blue;}
    </style>

    <style>
        .select2.select2-container.select2-container--default{
            width: 100% !important;
            height: 100% !important;
        }
        .select2-container--default .select2-selection--single{
            height: 100% !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 32px !important;
        }
    </style>

    <!-- Josue Pilco -->
    <style>
        .cb-codigo, .cb-product {
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

        .cb-codigo input:checked ~ div,
        .cb-product input:checked ~ div {
            background-color: #1e3a8a;
        }
    </style>

    <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- d3 and c3 charts -->
    <script src="{{ asset('js/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('js/plugins/c3/c3.min.js') }}"></script>

    <!-- Switchery -->
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Jasny -->
    <script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
    <link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
    <!-- Input Mask -->
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>

    <!-- DROPZONE -->
    <script src="{{ asset('js/plugins/dropzone/dropzone.js') }}"></script>

    <!-- CodeMirror -->
    <script src="{{ asset('js/plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('js/plugins/codemirror/mode/xml/xml.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, { color: '#2776ea' });
            var elem1 = document.querySelector('.js-switch-1');
            var switchery = new Switchery(elem1, { color: '#2776ea' });

            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
        $(document).ready(function () {
            // Add slimscroll to element
            $('.scroll_content').slimscroll({
                height: '450px'
            })
        });
        function validarExt()
        {
            var archivoInput = document.getElementById('archivoInput');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.png|.jfif)$/i;
            if(!extPermitidas.exec(archivoRuta)){
            alert('Asegúrese de haber seleccionado una Imagen');
            archivoInput.value = '';
            return false;
            }else{
                //PRevio del PDF
            if (archivoInput.files && archivoInput.files[0]){
                var visor = new FileReader();
                visor.onload = function(e){
                document.getElementById('visorArchivo').innerHTML =
                '<img name="foto" src="'+e.target.result+'" style="width:55%;padding: 30px;"/>';
                };
                visor.readAsDataURL(archivoInput.files[0]);
            }
            }
        }
    </script>


    <script>
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
    </script>
    <script>
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Abrir modal cuando se da clic al ícono
            document.getElementById('openUploadModal').addEventListener('click', function() {
                $('#miNuevoModal').modal('show');
            });

            // Evento para botón Cancelar (footer)
            document.getElementById('cancelButton').addEventListener('click', function() {
                swal("Cancelado", "La operación fue cancelada.", "info");
                $('#miNuevoModal').modal('hide');
            });

            // Evento para botón Cancelar (ícono cerrar)
            document.getElementById('cancelButtonTop').addEventListener('click', function() {
                swal("Cancelado", "La operación fue cancelada.", "info");
                // El modal se cierra automáticamente por data-dismiss="modal"
            });

            // Evento para botón Guardar - CORREGIDO
            document.getElementById('saveButton').addEventListener('click', function() {
                let inputFile = document.getElementById('excel');

                // Validar que se haya seleccionado un archivo
                if (!inputFile.files.length) {
                    swal("Error", "Por favor selecciona un archivo para importar.", "error");
                    return;
                }

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
                        console.log('Enviando formulario...');
                        document.getElementById('importForm').submit();
                    } else {
                        swal("Cancelado", "La importación fue cancelada.", "info");
                    }
                });
            });

            // Limpiar formulario al cerrar modal
            $('#miNuevoModal').on('hidden.bs.modal', function () {
                document.getElementById('importForm').reset();
            });

            // Mostrar nombre del archivo seleccionado (opcional)
            document.getElementById('excel').addEventListener('change', function() {
                let fileName = this.files[0] ? this.files[0].name : '';
                if (fileName) {
                    console.log('Archivo seleccionado:', fileName);
                }
            });
        });
    </script>




    @include('producto_servicios.shared.pie')
@endsection
