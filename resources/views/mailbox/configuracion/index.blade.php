@extends('layout')
@section('title', 'Configuracion Correo')
@section('breadcrumb', 'Configuracion Correo')
@section('breadcrumb2', 'Configuracion Correo')

@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')
<!-- Modal Create  -->
@if($errors->any())
<div style="padding-top: 10px">
      <div class="alert alert-danger">
            <a class="alert-link" href="#">
	          @foreach ($errors->all() as $error)
	          <li style="color: red">{{ $error }}</li>
	          @endforeach
        	</a>
      </div>
 </div>
@endif
@if(session()->has('success'))
<div style="padding-top: 10px" id="success_alert">
	<div class="alert alert-success">
		  <a class="alert-link" href="#">
			<li style="color: green">{{ session()->get('success') }}</li>
		  </a>
	</div>
</div>
@endif
@if (session('error_email'))
<div style="padding-top: 10px">
    <div class="alert alert-danger">
        <a class="alert-link" href="#">
            <li style="color: red">{{ session('error_email') }}</li>
        </a>
    </div>
</div>
@endif
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="">
					{{-- 2 Columnas --}}
					<div class="row">
						@include('layout_mail')
						
						@if($validacion == "DISMAIL")  {{--Configuracion para los Agregar registros  --}}
							<div class="col-lg-9">
								<div class="ibox-content" style="padding: 1em 4em">
									<center><h2 style="font-weight: 700">Agregar Correo</h2></center>
									<div class="alert_display" style="display: none;" >
										<div class="alert alert-danger alert-dismissible " role="alert" >
											<strong>Credenciales para correo no validas</strong>
										</div>
									</div>
									<form action="{{route('configuracion_email.store')}}"  enctype="multipart/form-data" method="post">
										@csrf
										<div class="row">
											<label class="col-sm-2 col-form-label">Email:</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="email" required id="email" >
											</div>
											<label class="col-sm-2 col-form-label">Contraseña:</label>
											<div class="col-sm-10">
												<div class="input-group m-b">
													<input type="password" class="form-control" name="password" id="txtPassword" required="" id="password" >
													<div class="input-group-prepend">
														<span class="input-group-addon" style="height: 35.22222px;margin-top: 5px;">
															<i class="fa fa-eye-slash " id="ojo" onclick="mostrarPassword()"></i>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-2 col-form-label">SMPT:</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="smtp" placeholder="mail.domain.com" required="" id="smtp">
											</div>

											<label class="col-sm-2 col-form-label">PORT:</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="port" value="110" >
											</div>
										</div>
										<div class="row">
											<label class="col-sm-2 col-form-label">Encryption:</label>
											<div class="col-sm-4">
												<select class="form-control" name="encryp" required="">
													<option value="">Ninguno</option>
													<option value="SSL">SSL</option>
													<option value="TLS">TLS</option>
												</select>
											</div>
										</div>
										<br>
										<div class="row tooltip-demo">
											<label class="col-sm-2 col-form-label">
												CC: <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="Se enviara 1 copia de cada correo"></i>
											</label>
											<div class="col-sm-4">
												<input type="email" class="form-control" name="backup_mail" id="" value="">
											</div>
										</div>
										<br>
										<div class="row">
											<label class="col-sm-12 col-form-label">Firma Correo:</label><br>
											<div class="col-sm-5">
												<input type="file" class="input_file" id="firma_correo_add_id" name="firma_correo_add" onchange="return f_firma_correo_add()" />
												<span id="visor_span_firma_correo">
													<!--Aqui se desplegará el fichero-->
													<img name="firma_correo" src="{{asset('/archivos/imagenes/firma_correo/defecto.png')}}" width="300px" height="120px" />
													<input type="text" name="firma_correo_nombre" hidden="hidden" value="">
												</span>
											</div>
											{{-- <label class="col-sm-2 col-form-label">Firma (opcional):</label>
											<div class="col-sm-4">
												<input type="file" id="archivoInput" name="firma" onchange="return validarExt()"  />
												<span id="visorArchivo">
													<!--Aqui se desplegará el fichero-->
													<img name="firma"  src="" width="390px" height="200px" />
												</span>
											</div>
											<label class="col-sm-2 col-form-label">Firma (opcional):</label>
											<div class="col-sm-4">
												<input type="file" id="archivoInput" name="firma" onchange="return validarExt()"  />
												<span id="visorArchivo">
													<!--Aqui se desplegará el fichero-->
													<img name="firma"  src="" width="390px" height="200px" />
												</span>
											</div> --}}
										</div>
										<br>
										<button class="btn btn-primary" id="submit_button" type="submit" style="display:none">Grabar</button>
										<button class="btn btn-primary ladda-button" id="grabar_button" type="button">Grabar</button>
										<br>
									</form>
								</div>
							</div>
						@else {{--Configuracion para los Editar registros  --}}
							<div class="col-lg-9">
								<div class="ibox-content" style="padding: 1em 4em ">
									<center><h2 style="font-weight: 700">Actualizar Correo</h2></center>
									<hr>
									<div class="alert_display" style="display: none;" >
										<div class="alert alert-danger alert-dismissible " role="alert" >
											<strong>Credenciales para correo no validas</strong>
										</div>
									</div>
									<form action="{{route('configuracion_email.update', $config_email->id)}}"  enctype="multipart/form-data" method="post">
										@csrf
										<div class="row">
											<label class="col-sm-2 col-form-label">Email:</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="email" value="{{$config_email->email}}" id="email" required>
											</div>
											<label class="col-sm-2 col-form-label">Contraseña:</label>
											<div class="col-sm-10">
												<div class="input-group m-b">
													<input type="password" class="form-control password" name="password" id="txtPassword" required="" value="{{$config_email->password}}">
													<div class="input-group-prepend">
														<span class="input-group-addon" style="height: 35.22222px;margin-top: 5px;">
															<i class="fa fa-eye-slash " id="ojo" onclick="mostrarPassword()"></i>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-2 col-form-label">SMPT:</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="smtp" placeholder="mail.domain.com" required="" value="{{$config_email->smtp}}" id="smtp">
											</div>
											<label class="col-sm-2 col-form-label">PORT:</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="port" value="{{$config_email->port}}"  id="port" required>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-2 col-form-label">Encryption:</label>
											<div class="col-sm-4">
												<select class="form-control" name="encryp" required="" id="encryption">
													<option value="{{$config_email->encryption}}">{{$config_email->encryption}}</option>
													<option value="">Ninguno</option>
													<option value="SSL">SSL</option>
													<option value="TLS">TLS</option>
												</select>
											</div>
										</div>
										<br>
										<div class="row tooltip-demo">
											<label class="col-sm-2 col-form-label">
												CC: <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="Se enviara 1 copia de cada correo"></i>
											</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="backup_mail" id="" value="{{$config_email->email_backup}}">
											</div>
										</div>
										<br>
										<div class="row">
											<label class="col-sm-12 col-form-label">Firma Correo:</label><br>
											<div class="col-sm-5">
												<input type="file" class="input_file" id="firma_correo_upd_id" name="firma_correo" onchange="return firma_correo_upd()"  />
												<span id="visor_span_firma_correo">
													<!--Aqui se desplegará el fichero-->
													<img name="firma_correo" src="{{asset('/archivos/imagenes/firma_correo/')}}/{{$config_email->firma_correo}}" width="300px" height="120px" />
													<input type="text" name="firma_correo_nombre" hidden="hidden" value="{{$config_email->firma_correo}}">
												</span>
											</div>
											{{-- <label class="col-sm-2 col-form-label">Firma (opcional):</label>
											<div class="col-sm-4">
												<input type="file" id="archivoInput" name="firma" onchange="return validarExt()"  />
												<span id="visorArchivo">
													<!--Aqui se desplegará el fichero-->
													<img name="firma"  src="" width="390px" height="200px" />
												</span>
											</div>
											<label class="col-sm-2 col-form-label">Firma (opcional):</label>
											<div class="col-sm-4">
												<input type="file" id="archivoInput" name="firma" onchange="return validarExt()"  />
												<span id="visorArchivo">
													<!--Aqui se desplegará el fichero-->
													<img name="firma"  src="" width="390px" height="200px" />
												</span>
											</div> --}}
										</div>
										<br>
										<button class="btn btn-primary" id="submit_button" type="submit" style="display:none">Grabar</button>
										<button class="btn btn-primary ladda-button" id="grabar_button" type="button">Grabar</button>
										<br>
									</form>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	
	.form-control{margin-top: 5px; border-radius: 5px}
	p#texto{
		text-align: center;
		color:black;
	}

	input#archivoInput{
		position:absolute;
		top:0px;
		left:0px;
		right:0px;
		bottom:0px;
		width:100%;
		height:100%;
		opacity: 0;
		border: 1px black solid;
	}
	.input_file{
		position:absolute;
		margin-left: 15px;
		top:0px;
		left:0px;
		right:0px;
		bottom:0px;
		width:300px;
		height:120px;
		opacity: 0;
		border: 1px black solid;
	}
	
</style>
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

<!-- iCheck -->
<script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

<!-- SUMMERNOTE -->
<script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>
<!-- Jasny -->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>

<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
<script>
    function doAction(ele, param1, param2) {
      var a = document.getElementById(param1).innerHTML;
      var b = document.getElementById(param2).innerHTML;
      ele.innerHTML = a + " " + b;
  }</script>
  <script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200,
       
    });

  });
</script>

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function(){
		$('.dataTables-example').DataTable({
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
	
	setTimeout(function() {
		$("#success_alert").css({'display':'none'});
	},5000);

	

	});

</script>
<script type="text/javascript">
	function firma_correo_upd()
	{
		var archivoInput = document.getElementById('firma_correo_upd_id');
		var archivoRuta = archivoInput.value;
		var extPermitidas = /(.jpg|.png|.jfif)$/i;
		if(!extPermitidas.exec(archivoRuta)){
			alert('Asegurese de haber seleccionado una Imagen');
			archivoInput.value = '';
			return false;
		}else{
			//PRevio del PDF
			if (archivoInput.files && archivoInput.files[0])
			{
				var visor = new FileReader();
				visor.onload = function(e)
				{
					document.getElementById('visor_span_firma_correo').innerHTML =
					'<img name="firma_correo" src="'+e.target.result+'"width="300px" height="120px" />';
				};
				visor.readAsDataURL(archivoInput.files[0]);
			} 
		}
	}
	function f_firma_correo_add()
	{
		var archivoInput = document.getElementById('firma_correo_add_id');
		var archivoRuta = archivoInput.value;
		var extPermitidas = /(.jpg|.png|.jfif)$/i;
		if(!extPermitidas.exec(archivoRuta)){
			alert('Asegurese de haber seleccionado una Imagen');
			archivoInput.value = '';
			return false;
		}else{
			//PRevio del PDF
			if (archivoInput.files && archivoInput.files[0])
			{
				var visor = new FileReader();
				visor.onload = function(e)
				{
					document.getElementById('visor_span_firma_correo').innerHTML =
					'<img name="firma_correo" src="'+e.target.result+'"width="300px" height="120px" />';
				};
				visor.readAsDataURL(archivoInput.files[0]);
			} 
		}
	}
</script>
	{{-- ANTIGUO --}}
<script type="text/javascript">
	function mostrarPassword(){
		var cambio = document.getElementById("txtPassword");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('#ojo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('#ojo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	}

</script>
<script type="text/javascript">
	// {{-- Fotooos --}}
	function validarExt()
	{
		var archivoInput = document.getElementById('archivoInput');
		var archivoRuta = archivoInput.value;
		var extPermitidas = /(.jpg|.png|.jfif)$/i;
		if(!extPermitidas.exec(archivoRuta)){
			alert('Asegurese de haber seleccionado una Imagen');
			archivoInput.value = '';
			return false;
		}else{
        //PRevio del PDF
        	if (archivoInput.files && archivoInput.files[0]){
        	var visor = new FileReader();
        	visor.onload = function(e){
        		document.getElementById('visorArchivo').innerHTML =
        		'<img name="firma" src="'+e.target.result+'"width="390px" height="200px" />';
        	};
        	visor.readAsDataURL(archivoInput.files[0]);
        	}
    	}
	}
	
</script>
<script>
	//funcion para validar las credenciales del usuario
	$("#grabar_button").on("click" ,function(e){
		e.preventDefault();
		var l = Ladda.create(this);
    	l.start();
		if($('[id="smtp"]').val() == "" || $('[id="port"]').val() == "" || $('.password').val() == "" || $('[id="email"]').val() == "" || $('[id="encryption"]').val() == "" ){
			// console.log('vacio');
			$("#submit_button").click();
			l.stop();
		}else{
			// console.log('lleno');
			checkEmail(function(resp) {
				if(resp){
					// $('.alert_display').show();
					$(".alert_display").css({'display':''});
					setTimeout(function() {
						$(".alert_display").css({'display':'none'});
					},6000);
					
				}else{
					// alert("las credenciales son correctas");
					$("#submit_button").click();
				}
			});
		}
		
	});
	//* FUNCION AJAX PARA VERIFICAR EMAIL EN AJAX -> ParametersControls
	function checkEmail(my_callback){
		var global_editar=false;

		var smtpAddress = $('[id="smtp"]').val();
		var port = $('[id="port"]').val();
		var encryption = $('[id="encryption"]').val();
		var yourEmail = $('[id="email"]').val();
		var yourPassword = $('.password').val();
		$(document).ready(function() {
			$.ajax({
				type: "post",
				url: "{{ route('pa.check_email') }}",
				processData: true,
				data: {
					'_token': $('input[name=_token]').val(),
					'smtpAddress': smtpAddress,
					'port': port,
					'encryption': encryption,
					'yourEmail': yourEmail,
					'yourPassword': yourPassword,
				},
				beforeSend: function(){
					$('#loaderGif').show(); 							
				},
				complete:function(data){
					/*
					* Se ejecuta al termino de la petición
					* */
				},
				success: function (msg) {
					console.log(msg);
					// global_editar=msg;
					if(msg == 0){
						global_editar = false;
					}
					if(msg == 1){
						global_editar = true;
					}
					my_callback(global_editar); //AQUI
				},
			});
			return global_editar;
		})
	}
</script>
@endsection