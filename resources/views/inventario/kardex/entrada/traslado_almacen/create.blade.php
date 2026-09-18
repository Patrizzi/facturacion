@extends('layout')
@section('title', 'Kardex Traslado Almacen')
@section('href_accion', route('kardex-entrada-Traslado-almacen.index'))
@section('value_accion', 'Atras')
@section('button2', 'Nuevo Traslado')
@section('config',route('kardex-entrada-Traslado-almacen.create'))
@section('content')

<link rel="stylesheet" href="{{ asset('css/kardex/traslado/create.css') }}">

@if($errors->any())
<div style="padding-top: 20px;">
	<div class="alert alert-danger">
		<a class="alert-link" href="#">
			@foreach ($errors->all() as $error)
			<li style="color: red">{{ $error }}</li>
			@endforeach
		</a>
	</div>
</div>
@endif
<div class="wrapper wrapper-content animated fadeInRight">
	@if (session('repite'))
        <div class="alert alert-danger">
            {{ session('repite') }}
        </div>
    @endif
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
                <div class="ibox-title">
                    <h4><strong>Kardex Traslado</strong></h4>
                    <div class="ibox-tools" style="margin-top:5px;margin-bottom:8px;margin-right:10px">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="" href="{{ route('kardex-entrada-Traslado-almacen.index') }}"><i class="fa fa-times"></i></a>
                    </div>
                </div>
				<div class="ibox-content">
                    {{--  <!-- Título -->
                    <div style="border-bottom:none solid #e7eaec; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center;">
                            <a href="{{ route('kardex-entrada-Traslado-almacen.index') }}" style="text-decoration: none; margin-right: 20px;">
                                <i class="fa fa-arrow-left" style="font-size: 24px; color: black;"></i>
                            </a>
                        </div>
                        <i class="fa fa-user-circle" style="font-size: 28px; color: #222;"></i>
                    </div>--}}
                    <form action="{{ route('kardex-entrada-Traslado-almacen.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                        @csrf
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="" style="font-size:13px;">{{ date('d/m/Y') }}</h3>
                        <div class="switch-button">
                            Generar Guía de Remisión &nbsp;&nbsp;
                            <input type="hidden" name="estado" value="on">
                            <input type="checkbox" class="js-switch1" name="estado_check" id="estado_check" checked>
                        </div>
                    </div>
						<div class="form-group row" style="margin-top:20px;">
							<label class="col-sm-2 col-form-label" ><strong>Almacén Emisor:</strong></label>
							<div class="col-sm-4">
								<input type="text" value="{{$almacen_emison->nombre}}" readonly="" class="form-control" required="required" name="almacen_emisor" id="almacen_emisor">
							</div>
							<label class="col-sm-2 col-form-label"><strong>Almacén:</strong></label>
							<div class="col-sm-4">
								<select class="select2_demo_3 asf" name="almacen">
                                    <option value="Sin almacen" >Seleccionar Almacén</option>
									@foreach($almacenes as $almacen)
									<option value="{{$almacen->id}}">{{$almacen->abreviatura}} / {{$almacen->descripcion}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label"><strong>Categoría:</strong></label>
							<div class="col-sm-4">
								<input class="form-control" name="clasificacion" disabled="direccion" value="PRODUCTOS">
							</div>
							<label class="col-sm-2 col-form-label"><strong>Motivo:</strong></label>
							<div class="col-sm-4">
								<input type="text" value="Traslado de almacen" readonly="" class="form-control" name="motivo" required="required">
							</div>
						</div>
						<table cellspacing="0" class="table table-striped " width="100%">
							<thead>
								<tr>
                                    <th style="width: 10px">
                                        <button type="button" class='addmore btn btn-sm btn-primary btn-outline'>
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </th>
									<th style="width: auto;">Producto</th>
                                    <th style="width: 600px;">Stock</th>
                                    <th style="width: 400px;">Cantidad</th>
								</tr>
							</thead>
							<tbody>
								<tr>
                                    <td>
                                        <button type="button" class="delete borrar2 btn-borrar btn btn-sm btn-primary" >
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
									<td>
										{{-- <input list="browsers2" class="form-control " name="articulo[]" required id='articulo' onclick="Clear(this);" autocomplete="off">
										<datalist id="browsers2" >
											@foreach($productos as $producto)
										<option value="{{$producto->id}} | {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}">
												@endforeach
											</datalist> --}}
                                        <select class="select2_demo_3 asf" name="articulo[]" required="" id="articulo0"  onchange="ajax(0);select_opt(0)" >
                                            <option></option>
                                            @foreach($productos as $producto)
                                            <option value="{{$producto->id}} {{$producto->peso}}"> {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}</option>
                                            @endforeach
                                        </select>
									</td>
									<td>
										<input type='text' id='stock0' name='stock[]' class="stock0 form-control" readonly="" required />
									</td>
									<td>
                                        <input type='number' id='cantidad' name='cantidad[]' class="monto0 form-control"  onkeyup="multi(0);"  required/>
									</td>
								</tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <button class="btn btn-primary float-right" type="submit" id="btn_guardar">
                                            Guardar
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
	<style type="text/css">
		input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
		}
	</style>
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.js') }}"></script>
	<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
	<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

	<script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <!-- Switchery -->
    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script>
        var elem1 = document.querySelector('.js-switch1');
        var switchery = new Switchery(elem1, { color: '#2776ea' });
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#4cc0f7' });
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
	<!-- Typehead -->
	<script src="{{ asset('js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>

	{{-- <script>
		var i = 2;
		$(".addmore").on('click', function () {
			var data = `[
			<tr>
			<td>
			<input type='checkbox' class='case'/>
			</td>";
			<td>
			<input list="browsers" class="form-control " name="articulo[]" required id='articulo${i}' onclick="Clear(this);" autocomplete="off" onkeyup="ajax(${i})">
			<datalist id="browsers" >
			@foreach($productos as $producto)
			<option value="{{$producto->id}} | {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}">
			@endforeach
			</datalist>
			</td>
			<td><input type='text' id='stock${i}' name='stock[]' class="stock${i} form-control" readonly=""  required/></td>
			<td>
			<input type='number' id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i});" required/>
			</td>
			</tr>`;
			$('table').append(data);
			i++;
		});
	</script> --}}

	<script>
		function multi(a){
			console.log(a);
			var total = 1;
			var change= false; //
			$(`.monto${a}`).each(function(){
				if (!isNaN(parseFloat($(this).val()))) {
					change= true;
					total *= parseFloat($(this).val());
				}
			});
			total = (change)? total:0;
			document.getElementById(`total${a}`).value = total;
		}
	</script>

	<script src="{{ asset('js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>

	<script>
		$(document).ready(function(){

			$('.typeahead_1').typeahead({
				source: ["item 1","item 2","item 3"]
			});
		});
		function Clear(elem)
		{
			elem.value='';
		}


		$('#articulo').change(function(e){
			e.preventDefault();

			var articulo = $('[id="articulo"]').val();

			var almacen_emisor = $('[id="almacen_emisor"]').val();
				$.ajax({
					type: "post",
					url: "{{ route('stock_ajax_traslado') }}",
					data: {
						'_token': $('input[name=_token]').val(),
						'articulo': articulo,
					'almacen_emisor':almacen_emisor
						},
					success: function (msg) {
						$('#stock0').val(msg);
						var msg2 = parseInt(msg) ;
						$('#cantidad').attr('max', msg2 );
					}
				});
			});


		function ajax (a){
			var articulo2 = $(`[id='articulo${a}']`).val();
			var almacen_emisor = $('[id="almacen_emisor"]').val();
			$.ajax({
				type: "post",
				url: "{{ route('stock_ajax_traslado') }}",
				data: {
					'_token': $('input[name=_token]').val(),
					'articulo': articulo2,
					'almacen_emisor':almacen_emisor
					},
				success: function (msg) {
					$(`#stock${a}`).val(msg);
					var msg2 = parseInt(msg) ;
					$(`#cantidad${a}`).attr('max', msg2 );
				}
			});
		}

	</script>

    <script>
        var i = 1;

        $(".addmore").on('click', function () {
            var data = `<tr>
            <td>
                <button type="button" class='delete borrar2 btn-borrar btn btn-sm btn-primary'  id="btn_borrar">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </td>
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
            $(".addmore").prop('disabled', true);

            i++;
        });

        // Eliminar fila - fuera del addmore
        $(document).on("click", ".borrar2", function() {
            let fila = $(this).closest("tr");
            let filas = $(".borrar2").length;

            if (filas > 1) {
                fila.remove();
            } else {
                // Si es la última fila, limpiar campos
                fila.find("input[type='text']").val("");
                fila.find("select").val("").trigger("change");
            }

            // Actualizar estado después de eliminar
            setTimeout(function() {
                updateProductOptions();
                checkCanAddMore();
            }, 100);
        });
    </script>

    <script>
        $(document).ready(function () {
            // Inicializar Select2 en el select inicial
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Producto",
            });

            // Deshabilitar el botón agregar al inicio
            $(".addmore").prop('disabled', true);

            // Event listener para Select2 change en el select inicial
            $('#articulo0').on('select2:select', function (e) {
                checkCanAddMore();
                updateProductOptions();

                // Llamar a la función ajax para obtener stock (igual que los selects dinámicos)
                ajax(0);
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
            $(".addmore").prop('disabled', !canAdd);
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

        function ajax(a) {
            var articulo2 = $(`[id='articulo${a}']`).val();
            var almacen_emisor = $('[id="almacen_emisor"]').val();

            $.ajax({
                type: "post",
                url: "{{ route('stock_ajax_traslado') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'articulo': articulo2,
                    'almacen_emisor': almacen_emisor
                },
                success: function (msg) {
                    $(`#stock${a}`).val(msg);
                    var msg2 = parseInt(msg);
                    // Para el primer select, el input de cantidad tiene ID 'cantidad', para los demás 'cantidad${a}'
                    if (a === 0) {
                        $('#cantidad').attr('max', msg2);
                    } else {
                        $(`#cantidad${a}`).attr('max', msg2);
                    }
                }
            });
        }
    </script>


	@endsection
