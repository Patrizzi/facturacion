@extends('layout')
@section('title', 'Kardex Distribucion')
@section('href_accion', route('kardex-entrada-Distribucion.index'))
@section('value_accion', 'Atras')
@section('button2', 'Nueva Distribucion')
@section('config',route('kardex-entrada-Distribucion.create'))
@section('content')

<link rel="stylesheet" href="{{ asset('css/kardex/distribucion/create.css') }}">

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
{{--  <div class="wrapper wrapper-content animated fadeInRight">
	@if (session('repite'))
        <div class="alert alert-danger">
            {{ session('repite') }}
        </div>
    @endif
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
				<form action="{{ route('kardex-entrada-Distribucion.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
				@csrf
					<div class="ibox-title">
						<div class="row">
							<div class="col-sm-12 text-right" >
								<div class="switch-button">
									Generar Guia de Remision &nbsp;&nbsp;
									<input type="text" name="estado" value="on" hidden="hidden">
									<input type="checkbox" name="estado_check" class="js-switch1"   @if($check_config->estado == 1) checked  @endif/>
								</div>
							</div>
						</div>
					</div>
					<div class="ibox-content">
							<input type="hidden" name="past1" id="" value="view_create">
							<div class="form-group row ">
								<label class="col-sm-2 col-form-label" >Motivos:</label>
								<div class="col-sm-4">
									<input type="text" value="Distribucion a Sucursales" readonly="" class="form-control" name="motivo" required="required">
								</div>
								<label class="col-sm-2 col-form-label" >Almacen:</label>
								<div class="col-sm-4">
									<select class="form-control" name="almacen" id="almacen" onchange="changue_almc()" required>
										<option value="">Seleccionar Almacen</option>
										@foreach($almacenes as $almacen)
										<option value="{{$almacen->id}} \ {{$almacen->nombre}}">{{$almacen->abreviatura}} / {{$almacen->descripcion}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="row ">
								<label class="col-sm-2 col-form-label" >Punto de Partida:</label>
								<div class="col-sm-4">
									<input class="form-control" name="punto_partida" value="{{$alm_principal->direccion}} - {{$alm_principal->cod_postal}}" readonly>
								</div>
								<label class="col-sm-2 col-form-label" >Punto de Llegada:</label>
								<div class="col-sm-4">
									<input class="form-control" name="llegada" id="llegada" readonly>
								</div>
							</div>
							<div class="form-group row ">

								comentado<label class="col-sm-2 col-form-label" >Punto de Partida:</label>
								<div class="col-sm-4">
									<input class="form-control" name="punto_partida" value="{{$alm_principal->direccion}} - {{$alm_principal->cod_postal}}" readonly>
								</div>comentado
							</div>
							<div class="form-group row ">
								<label class="col-sm-2 col-form-label" >Categoria:</label>
								<div class="col-sm-4">
									<input class="form-control" name="clasificacion" disabled="direccion" value="PRODUCTOS">
								</div>
								<label class="col-sm-2 col-form-label">Observaciones:</label>
								<div class="col-sm-4" style="margin-bottom: 15px">
									<textarea name="observacion" class="form-control" id="" placeholder="..." ></textarea>
								</div>
							</div>
                            <table cellspacing="0" class="table table-striped " width="100%">
								<thead>
									<tr>
										<th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()"  /></th>
										<th style="width: auto">Producto</th>
										<th style="width: auto">Stock</th>
										<th style="width: 100px">Unidades</th>
										<th style="width: 150px">Cantidad</th>
										<th style="width: 150px">Total</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><input type='checkbox' class="case" id="form_distribucion"></td>
										<td>
											<select class="select2_demo_3 asf" name="articulo[]" required="" id="articulo0"  onchange="ajax(0);select_opt(0)" >
												<option></option>
												@foreach($productos as $producto)
												<option value="{{$producto->id}}"> {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}</option>
												@endforeach
											</select>
											<input type="hidden" value="" id="registro_opt0" name="registro_opt[]" class="registro_opt">
										</td>
										<td>
											<input type='text' id='stock0' disabled="" name='stock[]' class="stock0 form-control" required/>
										</td>
										<td><input type="text" class="monto0 form-control" id="unidades0" name="unidades[]" value="1" onkeyup="multi(0);"></td>
										<td><input type='text' id='cantidad0' name='cantidad[]' class="monto0 form-control" onkeyup="multi(0);" required/></td>
										<td><input type='text' id='total0' name='total[]' class="total0 form-control"  readonly /></td>
										<span id="spTotal"></span>
									</tr>
								</tbody>
							</table>
							<button type="button" class='delete btn btn-danger' id="boton" > <i class="fa fa-trash" aria-hidden="true"></i> </button>
							<button type="button" class='addmore btn btn-success' id="boton"> <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
							<button class="btn btn-primary float-right" type="submit" id="boton">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>--}}

<!-- Vista 29/05/2025-->
<div class="wrapper wrapper-content animated fadeInRight">
    @if (session('repite'))
        <div class="alert alert-danger">
            {{ session('repite') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <form action="{{ route('kardex-entrada-Distribucion.store') }}" method="POST" id="form_distribucion">
                    @csrf
                    <input type="hidden" name="past1" id="past1" value="">

                    <div class="ibox-title d-flex align-items-center justify-content-between">
                        <h3 class="">{{ date('d/m/Y') }}</h3>
                        <div class="switch-button">
                            Generar Guia de Remision &nbsp;&nbsp;
                            <input type="hidden" name="estado" value="on">
                            <input type="checkbox" class="js-switch1" name="estado_check" id="estado_check" checked>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Motivo<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select name="motivo" class="form-control">
                                            <option value="" disabled selected>Selecciona motivo</option>
                                            @foreach($motivos as $motivo)
                                                <option value="{{ $motivo->id }}">{{ $motivo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Punto partida<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input type="text" name="punto_partida" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Categorìa<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <select name="categoria" class="form-control">
                                            <option value="" disabled selected>Selecciona categoria</option>
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Almacen<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                       <select name="almacen" class="form-control" onchange="ajax_direccion_almacen()">
                                            <option value="" disabled selected>Selecciona almacen</option>
                                            @foreach($almacenes as $almacen)
                                                <option value="{{ $almacen->id }} \ {{ $almacen->nombre}}">{{ $almacen->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Punto llegada<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="llegada" id="llegada">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Observaciones<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <textarea name="observacion" class="form-control" id="" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-4">
                            <table cellspacing="0" class="table table-striped " width="100%" id="tabla_productos">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()"  /></th>
                                            <th style="width: auto; font-weight: bold; color: black;">Producto<span class="text-danger">*</span></th>
                                            <th style="width: auto; font-weight: bold; color: black;">Stock<span class="text-danger">*</span></th>
                                            <th style="width: 100px; font-weight: bold; color: black;">Unidades<span class="text-danger">*</span></th>
                                            <th style="width: 150px; font-weight: bold; color: black;">Cantidad<span class="text-danger">*</span></th>
                                            <th style="width: 150px; font-weight: bold; color: black;">Total<span class="text-danger">*</span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_productos">
                                        <tr id="fila_0">
                                            <td><input type='checkbox' class="case" id="form_distribucion"></td>
                                            <td>
                                                <select class="select2_demo_3 asf" name="articulo[]" required="" id="articulo0"  onchange="ajax(0);select_opt(0)" >
                                                    <option></option>
                                                    @foreach($productos as $producto)
                                                    <option value="{{$producto->id}} {{$producto->peso}}"> {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" value="" id="registro_opt0" name="registro_opt[]" class="registro_opt">
                                            </td>
                                            <td>
                                                <input type='text' id='stock0' disabled="" name='stock[]' class="stock0 form-control" required/>
                                            </td>
                                            <td><input type="text" class="monto0 form-control" id="unidades0" name="unidades[]" value="1" onkeyup="multi(0);"></td>
                                            <td><input type='text' id='cantidad0' name='cantidad[]' class="monto0 form-control" onkeyup="multi(0);" required/></td>
                                            <td>
                                                <input type='text' id='total0' name='total[]' class="total0 form-control"  readonly />
                                                <input type='hidden' id='peso_tot0' name='peso_tot[]' />
                                                <input type='hidden' id='n_series0' name='n_series[]' value="N/A" />
                                            </td>
                                            <span id="spTotal"></span>
                                        </tr>
                                    </tbody>
                            </table>
                            <button type="button" class='delete btn btn-danger' id="btn_borrar" onclick="delete_row()"> <i class="fa fa-trash" aria-hidden="true"></i> </button>
                            <button type="button" class='addmore btn btn-success' id="btn_agregar" onclick="add_row()"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                            <button class="btn btn-primary float-right" type="submit" id="btn_guardar">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight word-s">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title d-flex align-items-center">
                    <a href="#" style="text-decoration: none; margin-right: 35px;"><i class="fa fa-arrow-left" style="font-size: 24px; color: black;"></i></a>
                    <h2 style=".word-style input; font-weight: bold; margin: 0;">  Kardex Entrada</h2>
                </div>
                <div class="ibox-content">
                    <form>
                        <div class="mb-5" style="font-weigh; font-size: 1.3rem; font-weight: bold; padding-top: 10px; padding-bottom: 15px;">15/05/2025</div>
                        <form>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label for="motivo" class="form-label me-3" style="word-style; font-weight: 600; font-size: 14px; white-space: nowrap; margin-right: 180px;">Motivo<span class="text-danger">*</span></label>
                                        <select id="motivo" class="form-control" style=".word-style input,: #eeeeee; border-radius: 20px; width: 100%; height: 38px;" required>
                                            <option selected disabled>Seleccionar motivo</option>
                                            <option>Compra</option>
                                            <option>Devolución</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label for="proveedor" class="form-label me-3" style="word-style; font-weight: 600; font-size: 14px; white-space: nowrap; margin-right: 180px;">Proveedor<span class="text-danger">*</span></label>
                                        <input type="text" id="proveedor" class="form-control" style="word-style: #eeeeee; border-radius: 20px; width: 100%; height: 38px;" value="J &amp; P PERIFERICOS S.A.C." readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div class="d-flex align-items-start">
                                        <label for="comprobante" class="form-label me-3" style="word-style; font-weight: 600; font-size: 14px; white-space: nowrap; margin-right: 20px; padding-top: 8px;">Tipo de Comprobante<span class="text-danger">*</span></label>
                                        <div class="d-flex gap-2 w-100">
                                        <select id="comprobante" class="form-control word-style" style="background-color: #eeeeee; border-radius: 20px; height: 32px; width: 27%;">
                                            <option>Sin Comprobante</option>
                                            <option>Factura</option>
                                            <option>Boleta</option>
                                        </select>
                                        <input type="text" class="form-control word-style" placeholder="Número" style="background-color: #eeeeee; border-radius: 20px; height: 32px; width: 20%;">
                                        <input type="date" class="form-control word-style" style="background-color: #eeeeee; border-radius: 20px; height: 32px; width: 25%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="d-flex align-items-center">
                                        <label for="moneda" class="form-label me-3" style="word-style; font-weight: 600; font-size: 14px; white-space: nowrap; margin-right: 190px;">Moneda<span class="text-danger">*</span></label>
                                        <select id="moneda" class="form-control" style="word-style: #eeeeee; border-radius: 20px; width: 100%; height: 38px;" required>
                                        <option selected disabled>Seleccionar Moneda</option>
                                        <option>PEN</option>
                                        <option>USD</option>
                                        </select>
                                    </div>
                                </div>
                        </form>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<!-- Switchery -->
<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

<script>
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });
</script>

<script>
    var elem1 = document.querySelector('.js-switch1');
    var switchery = new Switchery(elem1, { color: '#4cc0f7' });
    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#2776ea' });
</script>
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
<!-- Typehead -->
<script src="{{ asset('js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>

<script>
	var i = 2;
	$(".addmore").on('click', function () {
		var data = `[
		<tr>
			<td>
				<input type='checkbox' class='case'/>
			</td>";
			<td>
				<select class="select2_demo_3 asf" name="articulo[]" required="" id="articulo${i}" onchange="ajax(${i});select_opt(${i})">
					<option></option>
					@foreach($productos as $producto)
					<option value="{{$producto->id}}"> {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}</option>
					@endforeach
				</select>
			<input type="hidden"  name='registro_opt[]' id="registro_opt${i}" readonly="readonly" value="" required  class="registro_opt" />
			</td>
			<td>
				<input type='text' id='stock${i}' disabled="" name='stock[]' class="stock${i} form-control"  required/>
			</td>
			<td>
				<input type='number' id='unidad${i}' name='unidades[]' class="monto${i} form-control" value="1"  onkeyup="multi(${i});"  required/>
			</td>
			<td>
				<input type='number' id='cantidad${i}' name='cantidad[]' class="monto${i} form-control"  onkeyup="multi(${i});"  required/>
			</td>
			<td>
				<input type='number' id='total${i}' name='total[]' class="total${i} form-control"  readonly/>
			</td>
		</tr>`;
		$('table').append(data);
		i++;
		var input_ds = [];
		var number_tot = document.getElementsByName('articulo[]').length;
		for( j = 0; j < number_tot; j++){
			input_ds[j]  = document.getElementsByName('articulo[]')[j].value;
			$('option[value="'+input_ds[j]+'"]').prop("disabled", true);
		};
		$(".addmore").prop("disabled", true);
		$(".borrar").prop("disabled", false);

		$(".select2_demo_3").select2({
			placeholder: "Seleccionar Producto",
		});
	});
</script>

<script>
	function multi(a){
		var total = 1;
		var change= false; //
		$(`.monto${a}`).each(function(){
			if (!isNaN(parseFloat($(this).val()))) {
				change= true;
				if($(this).length == 0){
					total = 0;
				}else{
					total *= parseFloat($(this).val());
				}

			}
		});
		total = (change)? total:0;
		document.getElementById(`total${a}`).value = Math.round(total * 100)/100;
	}
</script>

/*<script>
	$(document).on('click', '.borrar', function (event) {
		event.preventDefault();
		var e = document.getElementsByClassName("e").length;
		// alert(e);
		var fila = $(this).parents("tr");
		var input_text_opt = fila.find('input[class="registro_opt"]').val();
		$('option[value="'+input_text_opt+'"]').prop("disabled", false);
		if (e>1) {
			fila.closest('tr').remove();
			$(".addmore").prop("disabled", false);
		}else{
			$('.clean').val("");
			$(".select2_demo_3").val(null).trigger("change");
			$(".borrar").prop("disabled", false);
			$(".addmore").prop("disabled", false);
		}
	});
</script>*/
    <script>
    $(document).on('click', '#btn_borrar', function (event) {
        event.preventDefault();

        // Obtener todas las filas seleccionadas
        var filasSeleccionadas = $('.case:checked');

        if (filasSeleccionadas.length === 0) {
            return;
        }

        // Iterar sobre cada fila seleccionada
        filasSeleccionadas.each(function() {
            var fila = $(this).closest('tr');

            // Rehabilitar la opción del select antes de borrar
            var input_text_opt = fila.find('input[class="registro_opt"]').val();
            if (input_text_opt) {
                $('option[value="'+input_text_opt+'"]').prop("disabled", false);
            }

            // Remover la fila
            fila.remove();
        });

        // Desmarcar el checkbox "seleccionar todo" si existe
        $('.check_all').prop('checked', false);

        // Habilitar el botón de agregar
        $(".addmore").prop("disabled", false);
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
		changue_almc();
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
	});
	$(document).ready(function(){

		$('.typeahead_1').typeahead({
			source: ["item 1","item 2","item 3"]
		});
	});
	function Clear(elem)
	{
		elem.value='';
	}
	function select_opt(b){
		var cant_opt = document.getElementById(`articulo${b}`).length;
		var count_input = document.getElementsByClassName('registro_opt').length;

		var option = document.getElementById(`articulo${b}`);

		var valor_select = option.value;
		console.log(valor_select);
		if(valor_select == ""){
			document.getElementById(`registro_opt${b}`).value = valor_select;
			$('option[value="'+valor_select+'"]').prop( "disabled", true);
		}else{
			var ant_val = document.getElementById(`registro_opt${b}`).value;
			$('option[value="'+ant_val+'"]').prop( "disabled", false);
			$('option[value="'+valor_select+'"]').prop( "disabled", true);
			document.getElementById(`registro_opt${b}`).value = valor_select;
			if(cant_opt-1 == count_input ){
				$(".addmore").prop("disabled", true);
			}
			else{
				$(".addmore").prop("disabled", false);
			}
		}
		$(".select2_demo_3").select2({
			placeholder: "Seleccionar Producto",
		});

	}
</script>

    //Script agregado para que se desabilite por defecto el boton de agregar producto
    <script>
        $(document).ready(function(){
        // Deshabilitar el botón al inicio
        $(".addmore").prop("disabled", true);

        // Habilitar/deshabilitar cuando se seleccione el primer producto
        $('#articulo0').on('change', function(){
            if($(this).val() != ""){
                $(".addmore").prop("disabled", false);
            } else {
                $(".addmore").prop("disabled", true);
            }
        });
    });
    </script>

<script>
	function ajax(a){
		var articulo2 = $(`[id='articulo${a}']`).val();
		console.log(articulo2);
		$.ajax({
			type: "post",
			url: "{{ route('stock_ajax_distribucion') }}",
			data: {
				'_token': $('input[name=_token]').val(),
				'articulo': articulo2
				// 'almacen' : almacen
				},
			success: function (msg) {
				// console.log(msg);

				$(`#stock${a}`).val(msg);
				var msg2 = parseInt(msg) ;
				$(`#cantidad${a}`).attr('max', msg2 );
			}
		});
	}
	function changue_almc(){
		var almacen = $('[id="almacen"]').val();
		$.ajax({
			type: "post",
			url: "{{route('ajax_direccion_almacen')}}",
			data: {
				'_token': $('input[name=_token]').val(),
				'almacen': almacen
				},
			success: function(end){
				$(`#llegada`).val(end);
			}
		});
	}

</script>

@endsection
