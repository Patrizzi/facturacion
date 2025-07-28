@extends('layout')

@section('title', 'Kardex_salida')
@section('breadcrumb', 'kardex_salida-Agregar')
@section('breadcrumb2', 'kardex_salida-Agregar')
@section('href_accion', route('kardex-salida.index') )
@section('value_accion', 'Atras')

@section('content')
<link rel="stylesheet" href="{{ asset('css/kardex/salida/create.css') }}">

@if (session('repite'))
    <div class="alert alert-success">
        {{ session('repite') }}
    </div>
@endif

@if (session('cantidad'))
    <div class="alert alert-success">
        {{ session('cantidad') }}
    </div>
@endif

@if (session('campo'))
    <div class="alert alert-success">
        {{ session('campo') }}
    </div>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Nueva Salida</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a></li>
                            <li><a href="#" class="dropdown-item">Config option 2</a></li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
				</div>
				<div class="ibox-content">
					<form action="{{ route('kardex-salida.store') }}" enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
					 	@csrf

					 	<div class="form-group row">
							<label class="col-sm-2 col-form-label">Motivos<span class="text-danger">*</span></label>
							<div class="col-sm-4">
								<select class="form-control" name="motivo" id="seleccion_motivo" onchange="seleccionado()">
									@foreach($motivos as $motivo)
									<option value="{{$motivo->id}}">{{$motivo->nombre}}</option>
									@endforeach
								</select>
							</div>

							<label class="col-sm-2 col-form-label">Almacen<span class="text-danger">*</span></label>
							<div class="col-sm-4">
							    <input type="text" class="form-control" name="almacen" value="{{$almacen_nombre}}" id="almacen" readonly>
							</div>
						</div>

						<div class="form-group row" id="almacen_trasladar" style="display:none;">
							<label class="col-sm-2 col-form-label">Almacen a trasladar<span class="text-danger">*</span></label>
							<div class="col-sm-10">
								<select class="form-control" name="almacen_trasladar">
									@foreach($almacenes as $almacen)
									<option value="{{$almacen->id}}">{{$almacen->nombre}}</option>
									@endforeach
								</select>
							</div>
						</div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Información<span class="text-danger">*</span></label>
							<div class="col-sm-4">
								<input type="text" required class="form-control" name="informacion">
							</div>
						</div>

						<table cellspacing="0" class="table table-striped">
							<thead>
								<tr>
									<th><input class='check_all' type='checkbox' onclick="select_all()"></th>
									<th style="width: auto; font-weight: bold; color: black;">Producto<span class="text-danger">*</span></th>
                                    <th style="width: 600px; font-weight: bold; color: black;">Stock<span class="text-danger">*</span></th>
                                    <th style="width: 400px; font-weight: bold; color: black;">Cantidad<span class="text-danger">*</span></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<input type='checkbox' class='case'>
									</td>
									<td>
										<select class="select2_demo_3 asf" name="articulo[]" required="" id="articulo0"  onchange="ajax(0);select_opt(0)" >
                                            <option></option>
                                            @foreach($productos as $producto)
                                            <option value="{{$producto->id}} {{$producto->peso}}"> {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}</option>
                                            @endforeach
                                        </select>
									</td>
									<td>
										<input type='text' id='stock0' name='stock[]' class="stock0 form-control" required readonly>
									</td>
									<td>
										<input type='text' id='cantidad' name='cantidad[]' class="monto0 form-control" required>
									</td>
								</tr>
							</tbody>
						</table>

						<button type="button" class='delete btn btn-danger' id="btn_borrar"><i class="fa fa-trash" aria-hidden="true"></i></button>
						<button type="button" class='addmore btn btn-success' id="btn_agregar"><i class="fa fa-plus" aria-hidden="true"></i></button>
						<button class="btn btn-primary float-right" type="submit" id="btn_guardar">Guardar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script type="text/javascript">
        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Producto",
        });
    </script>
	{{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
    <script>
        function valida(f) {
            var boton=document.getElementById("boton");
            var completo = true;
            var incompleto = false;
            if( f.elements[0].value == "" )
            { alert(incompleto); }
        else{boton.type = 'button';}
    }
    </script>
    {{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}

    <script>
        var i = 1; // Cambiado a 1 porque el primer select es articulo0

        $(".addmore").on('click', function () {
            var data = `<tr><td><input type='checkbox' class='case'/></td>
            <td>
                <select class="select2_demo_3 asf" name="articulo[]" required id='articulo${i}' onchange="ajax(${i});select_opt(${i})">
                    <option></option>
                    @foreach($productos as $producto)
                    <option value="{{$producto->id}} {{$producto->peso}}">
                        {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}
                    </option>
                    @endforeach
                </select>
            </td>
            <td><input type='text' id='stock${i}' name='stock[]' class="stock${i} form-control" required readonly/></td>
            <td><input type='text' id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" required/></td>
            </tr>`;

            $('table').append(data);

            // Inicializar Select2 en el nuevo select
            $(`#articulo${i}`).select2({
                placeholder: "Seleccionar Producto",
            });

            // Actualizar las opciones después de agregar la nueva fila
            updateProductOptions();

            // Deshabilitar el botón después de agregar una nueva fila
            $("#btn_agregar").prop('disabled', true);

            i++;
        });
    </script>

    <script>
        $(".delete").on('click', function () {
            // Destruir Select2 antes de eliminar las filas
            $('.case:checkbox:checked').each(function() {
                var row = $(this).parents("tr");
                var select = row.find('.select2_demo_3');
                if (select.length > 0) {
                    select.select2('destroy');
                }
            });

            $('.case:checkbox:checked').parents("tr").remove();

            // Actualizar las opciones después de eliminar filas
            updateProductOptions();
            // Verificar si se puede agregar más después de eliminar
            checkCanAddMore();
        });
    </script>

    <script>
        function select_all() {
            $('input[class=case]:checkbox').each(function () {
                if ($('input[class=check_all]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }
    </script>

    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Inicializar Select2 en el select inicial
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Producto",
            });

            // Deshabilitar el botón agregar al inicio
            $("#btn_agregar").prop('disabled', true);

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Event listener para Select2 change en el select inicial
            $('#articulo0').on('select2:select', function (e) {
                checkCanAddMore();
                updateProductOptions();
            });

            $('#articulo0').on('select2:unselect select2:clear', function (e) {
                checkCanAddMore();
                updateProductOptions();
            });
        });

        function checkCanAddMore() {
            var canAdd = true;

            // Verificar todos los selects de productos
            $('select[name="articulo[]"]').each(function() {
                var value = $(this).val();
                if (value === "" || value === null || value === undefined) {
                    canAdd = false;
                    return false; // Salir del each
                }
            });

            // Habilitar o deshabilitar el botón según el resultado
            $("#btn_agregar").prop('disabled', !canAdd);
        }

        // Función para actualizar las opciones disponibles en todos los selects
        function updateProductOptions() {
            var selectedValues = [];

            // Recopilar todos los valores seleccionados
            $('select[name="articulo[]"]').each(function() {
                var value = $(this).val();
                if (value && value !== "") {
                    selectedValues.push(value);
                }
            });

            // Actualizar cada select
            $('select[name="articulo[]"]').each(function() {
                var currentSelect = $(this);
                var currentValue = currentSelect.val();

                // Habilitar todas las opciones primero
                currentSelect.find('option').each(function() {
                    $(this).prop('disabled', false);
                });

                // Deshabilitar las opciones que ya están seleccionadas en otros selects
                selectedValues.forEach(function(selectedValue) {
                    if (selectedValue !== currentValue) {
                        currentSelect.find('option[value="' + selectedValue + '"]').prop('disabled', true);
                    }
                });

                // Refrescar Select2 para que muestre los cambios
                currentSelect.trigger('change.select2');
            });
        }

        // Función select_opt para manejar los eventos de Select2
        function select_opt(index) {
            // Agregar event listeners para Select2 en selects dinámicos
            $(`#articulo${index}`).on('select2:select', function (e) {
                checkCanAddMore();
                updateProductOptions();
            });

            $(`#articulo${index}`).on('select2:unselect select2:clear', function (e) {
                checkCanAddMore();
                updateProductOptions();
            });
        }

        // Modificar la función de cambio del select inicial para Select2
        $('#articulo0').on('select2:select', function(e){
            var articulo = $(this).val();
            var almacen = $(`[id='almacen']`).val();

            $.ajax({
                type: "post",
                url: "{{ route('stock_ajax') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'articulo': articulo,
                    'almacen': almacen
                },
                success: function (msg) {
                    $('#stock0').val(msg);
                    // Verificar si se puede agregar más después de seleccionar
                    checkCanAddMore();
                }
            });
        });

        function ajax(a) {
            var articulo2 = $(`[id='articulo${a}']`).val();
            var almacen = $(`[id='almacen']`).val();

            $.ajax({
                type: "post",
                url: "{{ route('stock_ajax') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'articulo': articulo2,
                    'almacen': almacen
                },
                success: function (msg) {
                    $(`#stock${a}`).val(msg);
                }
            });
        }

        function seleccionado(){
            var opt = $('#seleccion_motivo').val();
            if(opt=="6"){
                $('#almacen_trasladar').show();
            }else{
                $('#almacen_trasladar').hide();
            }
        }
    </script>

@endsection
