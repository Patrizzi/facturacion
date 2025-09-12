@extends('layout')

@section('title', 'Guía de Ingreso')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden="hidden"')
{{-- @extends('layout_agregado_rapido') --}}

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@section('content')
<link rel="stylesheet" href="{{ asset('css/garantias/guia_ingreso/create.css') }}">
<script type="text/javascript">
	$(document).ready(function() {
		$("form").keypress(function(e) {
			if (e.which == 13) {
				setTimeout(function() {
					e.target.value += '';
				}, 4);
				e.preventDefault();
			}
		});
	});
</script>
{{--
@section('form_action_modal_cliente',  route('agregado_rapido.cliente_cotizado')) --}}
@section('ruta_retorno', 'garantia_guia_ingreso')
{{-- <div class="social-bar">
	<a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div> --}}

<div class="wrapper wrapper-content animated fadeInRight">
	@if($errors->any())
	<div class="alert alert-danger">
		<a class="alert-link" href="#">
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</a>
	</div>
	@endif
	<div class="ibox">
        <div class="ibox-title">
            <strong class="col-auto" style="font-size: 16px;">GUÍA DE INGRESO </strong>
            <strong class="col-auto" style="font-size: 16px;">{{$orden_servicio}}</strong>
            <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                <a class="" href="{{ route('garantia_guia_ingreso.index') }}">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
		<div class="ibox-content" style=" margin-bottom: 2px;padding-bottom: 50px;padding: 30px;">
			{{-- <div class="row" style="height: 120px">
				<div class="col-sm-4 text-left" align="left">
					<div class="form-control for" align="center" style="height: 79%;" align="left">
						<img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="height: 70px;width: 90%;margin-top: 5px">
					</div>
				</div>
				<div class="col-sm-4" align="center">
					<div class="form-control for" align="center" style="height: 79%;" align="center"  >
						<img align="center" src="{{asset('archivos/imagenes/marcas/'.$marca_t->imagen)}}" style="height: 70px;width: 90%;margin-top: 5px">
					</div>
				</div>
				<div class="col-sm-4" align="right" >
					<div class="form-control for" align="center" style="height: 79%;"align="right">
						<h3 style="">R.U.C {{$empresa->ruc}}</h3>
						<h2 style="font-size: 19px">GUÍA DE INGRESO</h2>
						<h5>{{$orden_servicio}}</h5>
					</div>
				</div>
			</div> --}}
			<br>
			<form action="{{route('garantia_guia_ingreso.store')}}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
				@csrf
				<input type="hidden" name="marca_id" value="{{$marca_id}}">
				<div class="row" >
					<div class="col-sm-6" align="center" >
						<div class="form-control for">
							<h3>Datos Generales </h3>
							<br>
							<div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
								{{-- <label class="col-sm-2 col-form-label">Asunto:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control for" name="asunto" value="Ingreso de Equipo" required/>
								</div> --}}
								<label class="col-sm-2 col-form-label">Tecnico. Asignado:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control for m-b" value="{{Auth::user()->personal->nombres}}" id="" readonly="">
								</div>
								{{-- <label class="col-sm-2 col-form-label">Motivo:</label>
								<div class="col-sm-4">
									<select class="form-control for m-b" name="motivo" id="motivo" onchange="change_motivo()">
										<option value="Garantía">Garantía</option>
										<option value="Servicio">Servicio</option>
										<option value="Informativo">Informativo</option>
										<option value="Reingreso">Reingreso</option>
									</select>
								</div> --}}
								<label class="col-sm-2 col-form-label">Fecha:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control for" value="{{$tiempo_actual}}" readonly>
								</div>

							    <label class="col-sm-2 col-form-label">Cliente:</label>
                                <div class="col-sm-10" style="display: flex; align-items: center;">
                                    <select class="select2_demo_3 form-control" onchange="buscador_contac();" name="cliente_id" id="cliente_id" required style="flex: 1; margin-right: 0;">
                                        {{-- <option></option>
                                        @foreach($clientes as $cliente)
                                        <option value="{{$cliente->id}}">{{$cliente->numero_documento}}- {{$cliente->nombre}}</option>
                                        @endforeach --}}
                                    </select>
                                    <a href="#" class="btn btn-secondary btn-rounded" id="add_cliente" style="margin-left: -1px; border-radius: 0 0.25rem 0.25rem 0;">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>

								<label class="col-sm-2 col-form-label">Contacto:</label>
								<div class="col-sm-10">
									<select name="contacto_cliente" id="contacto_cliente" class="form-control">
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6" align="center">
						<div class="form-control for">
							<h3>Datos del Equipo</h3>
							<br>
							<div align="left" class="row" style="padding-right:10px; padding-left: 10px;">

								{{-- <label class="col-sm-2 col-form-label">Modelo:</label>
								<div class="col-sm-10" id=father_producto >
									<select class="select2_demo_2 form-control"  name="nombre_equipos" required id="producto"  >
										@foreach($productos as $producto)
										<option  value="{{$producto->nombre}}">{{$producto->nombre}}</option>
										@endforeach
									</select>
								</div> --}}
                                <label class="col-sm-2 col-form-label">Modelo:</label>
                                <div class="col-sm-10" id="father_producto" style="display: flex; align-items: center;">
                                    <select class="select2_demo_2 form-control" name="nombre_equipos" required id="producto" style="flex: 1; margin-right: 0;">
                                        @foreach($productos as $producto)
                                            <option value="{{$producto->nombre}}">{{$producto->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <a
                                        href="javascript:void(0);"
                                        class="btn btn-secondary btn-rounded"
                                        style="margin-left: -1px; border-radius: 0 0.25rem 0.25rem 0;"
                                        data-toggle="modal"
                                        data-target="#NuevoProducto"
                                    >
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
								<div class="col-sm-10" id="father_servicio"  style="display: none">
									<select class="select2_demo_2 form-control"  name="invalido"    id="servicio_t">
										@foreach($servicios as $servicio)
										<option  value="{{$servicio->nombre}}">{{$servicio->nombre}}</option>
										@endforeach
									</select>
								</div>
								<label class="col-sm-2 col-form-label">Nr Serie:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control for" name="numero_serie"  value="0" required>
								</div>
								<label class="col-sm-2 col-form-label">Código Interno:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control for" name="codigo_interno" value="000000" required>
								</div>
								<label class="col-sm-2 col-form-label">Fecha de Compra:</label>
								<div class="col-sm-10">
									<input type="date" class="form-control for" name="fecha_compra" max="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12" align="center" style="margin-top: 10px">
						<div class="form-control for">
							<center><h3>Informe del Problema</h3></center>
							<br>
							{{-- Vista --}}
							<div class="wrapper wrapper-content animated fadeIn">
								<div class="row">
									<div class="col-lg-12">
										<div class="tabs-container">
											<ul class="nav nav-tabs" role="tablist">
												<li><a class="nav-link active" data-toggle="tab" href="#tab-1">Descripción del Problema</a></li>
												<li><a class="nav-link" data-toggle="tab" href="#tab-2">Revisión y diagnostico</a></li>
												<li><a class="nav-link" data-toggle="tab" href="#tab-3">Estética</a></li>
											</ul>
											<div class="tab-content">
												<div role="tabpanel" id="tab-1" class="tab-pane active">
													<div class="panel-body">
														<textarea class="form-control" rows="10" placeholder="Escribir aquí Descripción Del Problema" name="descripcion_problema" maxlength="1230" required ></textarea>
													</div>
												</div>
												<div role="tabpanel" id="tab-2" class="tab-pane">
													<div class="panel-body">
														<textarea class="form-control" rows="10" placeholder="Escribir aquí Revisión y diagnostico" name="revision_diagnostico" maxlength="1230" required ></textarea>
													</div>
												</div>
												<div role="tabpanel" id="tab-3" class="tab-pane">
													<div class="panel-body">
														<textarea class="form-control" rows="10" placeholder="Escribir aquí Estética" name="estetica" maxlength="1230" required></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						{{-- Vista --}}
						{{-- <div align="ibox" align="right"> --}}
							<button style="align: left" class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit" ><strong>Grabar</strong></button>
						{{-- </div> --}}
					</div>
				</div>
			</form>
		</div>
	</div>

</div>
<style>
	.form-control{ margin-top: 5px;}
</style>


<style>
	span.select2-selection.select2-selection--single{border: 1px solid #5f232326;height: 36px; color: gray}
	span .select2-selection__rendered{color:#000000c7;}
</style>
@include('producto_servicios.productos.create')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"><9/script> --}}
	<script>
		function buscador_contac()
		{
			$value=$('#cliente_id').val();
			$.ajax({
				type: 'get',
				url: '{{URL::to('contacto_cliente')}}',
				data: {'cliente_id':$value},
				success:function(data){
					$('#contacto_cliente').html(data);
				}
			})
		}

	</script>

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
	<!-- Jquery Validate -->
	<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

	<!-- Steps -->
	<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>

	<!-- Select2 -->
	<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
	<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

	<script>
        $(document).ready(function() {
            $('.scroll_content').slimscroll({
                height: '450px'
            })
        });
        $('.select2_demo_2').select2({
            placeholder: 'Selecciona un modelo...',
            allowClear: true
        });
	$(".select2_demo_3").select2({
			width: 'resolve',
			placeholder: "Seleccionar Cliente",
			ajax: {
				minimumInputLength: 1,
				url: "{{ route('pa.clients') }}",
				dataType: 'json',
				type: "POST",
				delay: 10,
				data: function (params) {
					var tipo_coti = 3;
					return {
						_token: "{{ csrf_token() }}",
						search: params.term, // search term
						tipo_coti: tipo_coti
					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								id: item.id,
								text: item.nombre + ' | ' +  item.numero_documento,
							};
						})
					};
				},
				cache: true
			}
		});

		// $(".select2_demo_2").select2();
		// $(".select2_demo_3").select2({
		// 	placeholder: "Seleccionar Cliente",
		// 	allowClear: false
		// });
	</script>
    @include('transaccion.venta.clientes.modal_create')
	<script type="text/javascript">
		function change_motivo() {
			var tipo = document.getElementById("motivo");
			// console.log(tipo);
			if(tipo.value == "Servicio"){
				//cambio de estados para productos
				var prod = document.getElementById("producto");
				prod.setAttribute('name' , 'invalido');
				prod.required = false;
				var father = prod.closest("div");
				father.style.display = 'none';

				//cambio de estado parqa servicios
				var ser = document.getElementById("servicio_t");
				ser.setAttribute('name' , 'nombre_equipos');
				ser.required = true;
				var father_serv = ser.closest("div");
				father_serv.style.display = 'block';
				$(".select2_demo_2").select2();
			}else{
				//cambio de estado parqa servicio
				var ser = document.getElementById("servicio_t");
				ser.setAttribute('name' , 'invalido');
				ser.required = false;
				var father_serv = ser.closest("div");
				father_serv.style.display = 'none';

				//cambio de estados para productos
				var prod = document.getElementById("producto");
				prod.setAttribute('name' , 'nombre_equipos');
				prod.required = true;
				var father = prod.closest("div");
				father.style.display = 'block';
				$(".select2_demo_2").select2();
			}
		}
	</script>
	@stop
