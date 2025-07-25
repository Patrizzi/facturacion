@extends('layout')
@section('title', 'kardex Entrada')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'Atras')

@section('content')
<!-- <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet"> -->
<link rel="stylesheet" href="{{ asset('css/kardex/entrada/create.css') }}">
@if (session('repite'))
<div class="alert alert-danger">
	{{ session('repite') }}
</div>
@endif
@if (session('campo'))
<div class="alert alert-success">
	{{ session('campo') }}
</div>
@endif
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
{{-- <div class="social-bar">
	<a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target=".bd-example-modal-lg1">
		<i class="fa fa-user-o" aria-hidden="true"></i>
		<span> Provedor</span>
	</a>
</div> --}}
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
				<div class="ibox-title" style="padding: 15px 15px 8px 15px">
					<div class="row">
						<div class="col-sm-6" align="left">
							<span><strong>{{Carbon\Carbon::now()->format('d/m/Y')}}</strong></span>
						</div>
						<div class="col-sm-6" align="left">
							@foreach($almacenes as $almacen)
								<span><strong>{{$almacen->abreviatura}} - {{$almacen->nombre}}</strong></span>
								<input class="form-control" name="almacen" type="text" hidden="" value="1">
							@endforeach
						</div>
					</div>
				</div>
				<div class="ibox-content">
					<form action="{{ route('kardex-entrada.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)" id="kardex_submit" >
						@csrf
						<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Motivos:</label>
							<div class="col-sm-4">
								<select class="form-control" name="motivo" id="motivo" required="required">
									<option value="">Seleccionar Motivo</option>
									@foreach($motivos as $motivo)
									<option value="{{$motivo->nombre}}" >{{$motivo->nombre}}</option>
									@endforeach
								</select>
							</div>

							<label class="col-sm-2 col-form-label">G Remision:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="guia_remision" id="guia_remision"  value="0">
							</div>
						</div>
						<input class="form-control" name="almacen" type="text" hidden="" value="1">
						<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Factura:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control " name="factura" id="factura"  value="0" >
							</div>

							<label class="col-sm-2 col-form-label"> Provedor:</label>
							<div class="col-sm-4">
								<select class="form-control " name="provedor" required="required">
									@foreach($provedores as $provedor)
									<option value="{{$provedor->empresa}}" >{{$provedor->empresa}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row ">
							{{-- <label class="col-sm-2 col-form-label" >Almacen:</label>
							<div class="col-sm-4">
								@foreach($almacenes as $almacen)
								<input class="form-control" type="text" readonly="" value="{{$almacen->abreviatura}} - {{$almacen->descripcion}}">
								<input class="form-control" name="almacen" type="text" hidden="" value="1">
								@endforeach
							</select> --}}
							<label class="col-sm-2 col-form-label" >Tipo de Transporte:</label>
							<div class="col-sm-4">
								<select name="transporte" required	 id="" class="form-control">
									<option value="">Escoge el tipo de Transporte</option>
									<option value="Transporte Privado">Transporte Privado</option>
									<option value="Transporte Publico">Transporte Publico</option>
								</select>
							</div>
						{{-- </div> --}}

						<label class="col-sm-2 col-form-label"> Informaciones:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="informacion" value="Ingreso de productos al almacen">
						</div>
					</div>


					<div class="form-group row ">
						<label class="col-sm-2 col-form-label" >Categoria:</label>
						<div class="col-sm-4">
							<input class="form-control" name="clasificacion" disabled="direccion" value="PRODUCTOS">
						</div>
						<label class="col-sm-2 col-form-label" >Moneda:</label>
						<div class="col-sm-4">
							<select class="form-control" name="moneda" required="">
								<option value="" >Seleccionar Moneda</option>
								@foreach($moneda as $monedas)
								<option value="{{$monedas->nombre}}">{{$monedas->nombre}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Fecha de compra:</label>
						<div class="col-sm-4">
							<input type="date" name="fecha_compra" id="" required="" class="form-control">
						</div>
						<label class="col-sm-2 col-form-label">Archivo:</label>
						<div class="col-sm-4">
							<input type="file" class="form-control" name="archivo" id="archivo">
						</div>
					</div>

					<table cellspacing="0" class="table table-striped " width="100%">
						<thead>
							<tr>
								<th style="width: 10px"></th>
								<th style="width: 600px">Producto  <a href="{{route('productos.create')}}" class="btn btn-warning" target="blanck" style="padding-top: 0px;padding-bottom: 0px; padding-left: 4px;padding-right: 4px;" ><i class="fa fa-plus-square" aria-hidden="true" ></a></th>
									<th style="width: 100px">Unidad</th>
									<th style="width: 100px">Cantidad</th>
									<th style="width: 100px">Precio</th>
									<th style="width: 100px">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<button type="button" class='delete borrar e btn btn-danger' > <i class="fa fa-trash" aria-hidden="true"></i> </button>
									</td>
									<td>
										<select class="select2_demo_3 asf" name="articulo[]" required="" id="articulo1" onchange="select_opt(1)">
											<option></option>
											@foreach($productos as $producto)
											<option value="{{$producto->id}}"> {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}</option>
											@endforeach
										</select>
										<input type="hidden" value="" id="registro_opt1" name="registro_opt[]" class="registro_opt">
									</td>

									<td><input type='text' id='unidad' name='unidad[]' class="monto0 unidad0 form-control clean"  onkeyup="multi(0);" value="1"  required/></td>
									<td><input type='text' id='cantidad' name='cantidad[]' class="monto0 form-control clean"  onkeyup="multi(0);"  required/></td>
									<td><input type='text' id='precio' name='precio[]' class="monto0 precio0 form-control clean" onkeyup="multi(0);" required/></td>
									<td><input type='text' id='total0' name='total[]' class="form-control clean" required/></td>
									<span id="spTotal"></span>
								</tr>
							</tbody>
							<tbody style="background-color: white !important">
								<tr>
									<td colspan="4">
										<button type="button" class='addmore btn btn-success' disabled="" > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
									</td>
									<td colspan="2">
										<button class="ladda-button btn btn-primary float-right" type="submit" id="boton"  ><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
					<tr>
						<style type="text/css">
						.form-control{border-radius: 5px;}
					</style>
				</tr>
			</div>
		</div>
	</div>
</div>
</div>
<style type="text/css">
	.select2-container--default .select2-selection--single .select2-selection__rendered {font-size: 12px;text-align: left;}
	.select2-container--default .select2-selection--single { border: none;}
	.select2-container--default .select2-selection--single .select2-selection__rendered {font-size: 0.9rem;padding-left: 0px;color: inherit;}
	span.select2.select2-container.select2-container--default{
		width: 100% !important;
		background-color: #FFFFFF;
		background-image: none;
		border-radius: 1px;
		display: block;
		padding: 3px 12px;
		border: 1px solid #e5e6e7;
	}
	.input_red{
		border-color: red;
	}
	.input_red::before{
		content: "El Numero de Factura ya esta en uso";
		font-size: 11px;
	}
</style>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
    .word-style select,
    .word-style input,
    .word-style span{
        font-family: 'Outfit', sans-serif;
        font-size: 11px;
    }
    .required {
    color: red;
    margin-left: 2px;
  }
  .form-control {
        border-radius: 20px !important;
        background: #f3f3f4;
        font-size: 11px;
    }
</style>
<!-- KARDEX ENTRADA NUEVO-->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-content" style="font-family: 'Outfit', sans-serif;">
            <!-- Título -->
            <div style="border-bottom: 1px solid #e7eaec; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center;">
                    <a href="#" style="text-decoration: none; margin-right: 20px;">
                        <i class="fa fa-arrow-left" style="font-size: 24px; color: black;"></i>
                    </a>
                    <h2 style="font-family: 'Outfit', sans-serif; font-weight: bold; margin: 0; color: #000;"><strong>Kardex Entrada</strong></h2>
                </div>
                <i class="fa fa-user-circle" style="font-size: 28px; color: #222;"></i>
            </div>
            <div style="color: #6e6e6e; font-size: 1rem; margin-bottom: 18px; font-weight: 600;"><strong>15/05/2025</strong></div>
            <form>
                <div class="row mb-2">
                    <div class="col-md-6 d-flex align-items-center mb-2">
                        <label for="motivo" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>Motivo</strong><span style="color:red;">*</span></label>
                        <select id="motivo" class="form-control" required>
                            <option selected disabled>Seleccionar motivo</option>
                            <option>Compra</option>
                            <option>Devolución</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-center mb-2">
                        <label for="proveedor" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>Proveedor</strong><span style="color:red;">*</span></label>
                        <input type="text" id="proveedor" class="form-control" value="J &amp; P PERIFERICOS S.A.C." readonly style="color:#000; font-weight:600;">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6 d-flex align-items-center mb-2">
                        <label for="comprobante" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>Tipo de Comprobante</strong><span style="color:red;">*</span></label>
                        <select id="comprobante" class="form-control me-2" style="width: 35%;">
                            <option>Sin Comprobante</option>
                            <option>Factura</option>
                            <option>Boleta</option>
                        </select>
                        <input type="text" class="form-control me-2" placeholder="Número" style="width: 25%;">
                        <input type="date" class="form-control" style="width: 25%;">
                    </div>
                    <div class="col-md-6 d-flex align-items-center mb-2">
                        <label for="moneda" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>Moneda</strong><span style="color:red;">*</span></label>
                        <select id="moneda" class="form-control" required>
                            <option selected disabled>Seleccionar Moneda</option>
                            <option>PEN</option>
                            <option>USD</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6 d-flex align-items-center mb-2">
                        <label for="transporte" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>Tipo de transporte</strong><span style="color:red;">*</span></label>
                        <select id="transporte" class="form-control" required>
                            <option selected disabled>Seleccionar Tipo de Transporte</option>
                            <option>Terrestre</option>
                            <option>Aéreo</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-center mb-2">
                        <label for="info" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>Información</strong><span style="color:red;">*</span></label>
                        <input type="text" id="info" class="form-control" placeholder="Información">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6 d-flex align-items-center mb-2">
                        <label for="categoria" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>Categoría</strong><span style="color:red;">*</span></label>
                        <input type="text" id="categoria" class="form-control" value="Producto" readonly style="color:#000; font-weight:600;">
                    </div>
                    <div class="col-md-6 d-flex align-items-center mb-2">
                        <label for="guia" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>G. Remisión</strong><span style="color:red;">*</span></label>
                        <input type="text" id="guia" class="form-control" placeholder="Abrir Guía">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6 d-flex align-items-center mb-2">
                        <label for="fecha" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>Fecha de compra</strong><span style="color:red;">*</span></label>
                        <input type="date" id="fecha" class="form-control" value="2025-05-26" style="color:#000; font-weight:600;">
                    </div>
                    <div class="col-md-6 d-flex align-items-center mb-2">
                        <label for="archivo" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>Archivo</strong><span style="color:red;">*</span></label>
                        <input type="file" id="archivo" class="form-control">
                    </div>
                </div>
                <hr>
                <div class="row mb-2 align-items-end">
                    <div class="col-auto" style="display:flex; flex-direction:column; align-items:center; gap:10px;">
                        <button type="button" class="btn" style="background:#D32F2F; color:white; width:38px; height:38px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; margin-bottom:8px;">
                            <i class="fa fa-trash"></i>
                        </button>
					</div>
                    <div class="col-5">
                        <label class="form-label" style="font-weight:600; color:#000; margin-bottom:2px; display:block;"><strong>Producto</strong> <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" placeholder="Producto" style="width:100%; min-width:220px;">
                    </div>
                    <div class="col">
                        <label class="form-label" style="font-weight:600; color:#000; margin-bottom:2px; display:block;"><strong>Unidad</strong> <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" placeholder="Unidad">
                    </div>
                    <div class="col">
                        <label class="form-label" style="font-weight:600; color:#000; margin-bottom:2px; display:block;"><strong>Cantidad</strong> <span style="color:red;">*</span></label>
                        <input type="number" class="form-control" placeholder="Cantidad">
                    </div>
                    <div class="col">
                        <label class="form-label" style="font-weight:600; color:#000; margin-bottom:2px; display:block;"><strong>Precio</strong> <span style="color:red;">*</span></label>
                        <input type="number" class="form-control" step="0.01" placeholder="Precio">
                    </div>
                    <div class="col">
                        <label class="form-label" style="font-weight:600; color:#000; margin-bottom:2px; display:block;"><strong>Total</strong> <span style="color:red;">*</span></label>
                        <input type="number" class="form-control" step="0.01" readonly placeholder="Total">
                    </div>
                </div>
                <button type="button" class="btn" style="background:#2563eb; color:white; width:38px; height:38px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:22px;">
                    <i class="fa fa-plus"></i>
                </button>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" style="background:#5c2d91; border:none; border-radius:8px; font-weight:500; font-size:1rem; padding:10px 36px;">
                            <strong>Guardar</strong>
                        </button>
                    </div>
                </div>
            </form>
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
		<button type="button" class='delete e borrar btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
		</td>
		<td>
		<select class="select2_demo_3 asf" name="articulo[]" required="" id="articulo${i}" onchange="select_opt(${i})" >
		<option></option>
		@foreach($productos as $producto)
		<option value="{{$producto->id}}"> {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}</option>
		@endforeach
		</select>
		<input type="hidden"  name='registro_opt[]' id="registro_opt${i}" readonly="readonly" value="" required  class="registro_opt" />
		</td>
		<td>
		<input type='text' id='unidad${i}' name='unidad[]' class="monto${i} unidad${i} form-control" onkeyup="multi(${i});" required value="1"/>
		</td>
		<td>
		<input type='text' id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i});" required/>
		</td>
		<td>
		<input type='text' id='precio${i}' name='precio[]' class="monto${i} precio${i} form-control"  onkeyup="multi(${i});" required/>
		</td>
		<td>
		<input type='text' id='total${i}' name='total[]' class="form-control" required/>
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
	function valid_factura(){
		// e.preventDefault();
		var n_factura = $('[id="factura"]').val();
		$.ajax({
			type: "post",
			url: "{{ route('pa.nfactura') }}",
			data: {
				'_token': $('input[name=_token]').val(),
				'n_factura': n_factura
			},
			success: function(msg){
				if(msg == 1){
					toastr.error("Error en el Registro",
                            'N de Factura ya en uso', {
                                timeOut: 3000
                            });
					$('[id="factura"]').addClass('input_red');
					// $('[id="boton"]').prop("disabled", true);
				}else{
					$('[id="factura"]').removeClass('input_red');
					$('[id="boton"]').prop("disabled", false);
				}
			}
		});
	}
	var  timeout;
	$("#factura").on('keydown', () => {
		$('[id="boton"]').prop("disabled", true);
		clearTimeout(timeout)
		timeout = setTimeout(() => {
			valid_factura();
			clearTimeout(timeout)
		},400)
	})

</script>
<script>
	function multi(a){
		console.log(a);
		var total = 1;
		var precio = $(`.precio${a}`).val();
		var change= false; //
		$(`.monto${a}`).each(function(){
			if (!isNaN(parseFloat($(this).val()))) {
				change= true;
				if(precio.length == 0){
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
	<script>
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
</script>
<script >
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

@endsection
