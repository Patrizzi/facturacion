@extends('layout')

@section('title', 'Inventario Inicial')
@section('breadcrumb', 'Inventario Inicial')
@section('breadcrumb2', 'Inventario Inicial')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Nuevo</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
				</div>
				<div class="ibox-content">
					<form action="{{ route('inventario-inicial.store') }}"  enctype="multipart/form-data" method="post">
					 	@csrf
					 	<div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Motivos :</label>
		                    <div class="col-sm-10">
                                <input type="text" class="form-control"  value="Inventario Inicial" disabled>
                            </div>
						</div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Almacen :</label>
		                    <div class="col-sm-10">
                                <select class="form-control" name='almacen' required>
									@foreach($almacenes as $almacen)
									<option value="{{$almacen->id}}">{{$almacen->nombre}}</option>
									@endforeach
								</select>
                            </div>
						</div>


                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Provedor:</label>
		                    <div class="col-sm-10">
                                <select class="form-control" name='provedor' required>
									@foreach($provedores as $provedor)
									<option value="{{$provedor->id}}">{{$provedor->empresa}}</option>
									@endforeach
								</select>
                            </div>
						</div>

						<div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Moneda:</label>
		                    <div class="col-sm-10">
                                <select class="form-control" name='moneda' required>
									@foreach($monedas as $moneda)
									<option value="{{$moneda->id}}">{{$moneda->nombre}}</option>
									@endforeach
								</select>
                            </div>
						</div>

		                <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Informaciones:</label>
		                    <div class="col-sm-10">
                                <input type="text" class="form-control" name="informacion">
                            </div>
						</div>
						<table 	 cellspacing="0" class="table table-striped ">
							<thead>
							<tr>
								<th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()" /></th>
								<th style="width: 600px">---- Codigo ------ articulo</th>

								<th style="width: 100px">Cantidad</th>
								<th style="width: 100px">Precio</th>
								<th style="width: 100px">Total</th>
							</tr>
						</thead>
								<tbody>
							<tr>
								<td><input type='checkbox' class="case"></td>
								<td>
								<select class="form-control" id='articulo' name='articulo[]' required>
									@foreach($productos as $producto)
									<option value="{{$producto->id}}">{{$producto->codigo_producto}} -> {{$producto->nombre}}</option>
									@endforeach
								</select>
								</td>

								<td><input type='text' id='cantidad' name='cantidad[]' class="monto0 form-control"   onkeyup="multi(0);"  required/></td>
								<td><input type='text' id='precio' name='precio[]' class="monto0 form-control" onkeyup="multi(0);" required/></td>
								<td><input type='text' id='total0' name='total[]' class="form-control" required/></td>
								<span id="spTotal"></span>
							</tr>
						</tbody>
						</table>



						<button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
						<button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
						<button class="btn btn-primary float-right" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>


					</form>

					<style type="text/css">
					.form-control{
							border-radius: 5px;
					}
					</style>

				</div>
			</div>
		</div>
	</div>
</div>


<!--TODO SOBRE LA VISTA -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                        <a class="nav-link active" href="" id="tab-1">Kardex/Producto</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-panel active">
                            <div class="panel-body">
                    <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h3><strong>Inventario</strong></h3>
                            </div>
                            <div class="panel-body">
                            <div class="row col-lg-12">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Motivos</strong></label>
                                        <div class="col-sm-7">
                                        <input type="text" class="form-control" value="Inventario Inicial" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Informaciones:</strong></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="informacion">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Provedor</strong></label>
                                        <div class="col-sm-7">
                                            <select class="form-control">
                                                    <option value="1">Saar HK Electronic&nbsp;Limited</option>
                                                    <option value="2">DYNDNS</option>
                                                    <option value="3">GRUPO DELTRON S.A.</option>
                                                    <option value="4">L &amp; T TECHNOLOGYA SOCIEDAD ANONIMA CERRADA - L &amp; T TECHNOLOGYA S.A.C.</option>
                                                    <option value="5">BITDEFENDER</option>
                                                    <option value="6">ANONIMO</option>
                                                    <option value="7">GRUPO INFOZONAL S.A.C.</option>
                                                    <option value="8">BOX PARTS SOCIEDAD ANONIMA CERRADA</option>
                                                    <option value="9">BIOS 3000 EIRL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Moneda:</strong></label>
                                        <div class="col-sm-7">
                                            <select class="form-control">
                                                <option>Seleccione</option>
                                                <option>Soles</option>
                                                <option>Dolares</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--TABLA DE AGREGAR-->
                                <div class="table-responsive">
                                    <table cellspacing="0" class="table tables">
                                        <thead>
                                            <tr style="background-color: #3366cc; color: white; text-align: center;">
                                                <th>Acción</th>
                                                <th style="width: 300px;">Artículo</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <button type="button" class="addmore btn btn-success">
                                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="articulo" name="articulo[]" required="">
                                                        <option value="1">BIT-000001 -&gt; ANTIVIRUS BITDEFENDER TOTAL SECURITY 1PC</option>
                                                        <option value="2">DN-000001 -&gt; DYNDNS BASICO</option>
                                                        <option value="3">DN-000002 -&gt; DYNDNS CORPORATIVO</option>
                                                        <option value="4">TE-000001 -&gt; TENDA AC10 ROUTER AC1200GB</option>
                                                        <option value="5">CP-000001 -&gt; CAMARA WEBCAM 720 - COMPATIBLE</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" id="cantidad0" name="cantidad[]" min="1" class="monto0 form-control" />
                                                </td>
                                                <td>
                                                    <input type="text" id="descuento" name="descuento" class="form-control" />
                                                </td>
                                                <td>
                                                    <input type="text" id="total0" name="total" disabled class="total form-control" required autocomplete="off" />
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <!--TABLA DE ELIMINAR-->
                                <div class="table-responsive">
                                    <table cellspacing="0" class="table tables">
                                        <thead>
                                            <tr style="background-color: #3366cc; color: white; text-align: center;">
                                                <th>Acción</th>
                                                <th style="width: 300px;">Artículo</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-danger">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="articulo" name="articulo[]" required="">
                                                        <option value="1">BIT-000001 -&gt; ANTIVIRUS BITDEFENDER TOTAL SECURITY 1PC</option>
                                                        <option value="2">DN-000001 -&gt; DYNDNS BASICO</option>
                                                        <option value="3">DN-000002 -&gt; DYNDNS CORPORATIVO</option>
                                                        <option value="4">TE-000001 -&gt; TENDA AC10 ROUTER AC1200GB</option>
                                                        <option value="5">CP-000001 -&gt; CAMARA WEBCAM 720 - COMPATIBLE</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" id="cantidad0" name="cantidad[]" min="1" class="monto0 form-control" />
                                                </td>
                                                <td>
                                                    <input type="text" id="descuento" name="descuento" class="form-control" />
                                                </td>
                                                <td>
                                                    <input type="text" id="total0" name="total" disabled class="total form-control" required autocomplete="off" />
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <div>
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa fa-cloud-upload" aria-hidden="true"></i> Guardar
                                        </button>
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa fa-cloud-upload" aria-hidden="true"></i> Guardar y Finalizar
                                        </button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        <!-- Contenido de Tab 4 -->
        </div>
        </div>
        </div>
        </div>
        </div>

<!-- Mainly scripts -->














	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<script>
// function multi(){
//     var total = 1;
//     var change= false; //
//     $(".monto").each(function(){
//         if (!isNaN(parseFloat($(this).val()))) {
//             change= true;
//             total *= parseFloat($(this).val());
//         }
//     });
//     total = (change)? total:0;
//     document.getElementById('Costo').innerHTML = total;
// }
</script>

    <script>
        var i = 2;
        $(".addmore").on('click', function () {
            var data = `[
			<tr>
				<td>
					<input type='checkbox' class='case'/>
				</td>";
             	<td>
					<select class="form-control" id='articulo' name='articulo[]' required>
						@foreach($productos as $producto)
						<option value="{{$producto->id}}">{{$producto->codigo_producto}} --- {{$producto->nombre}}</option>
						@endforeach
					</select>
				</td>
				<td>
					<input type='text' id='cantidad" + i + "' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i});" required/>
				</td>
				<td>
					<input type='text' id='precio" + i + "' name='precio[]' class="monto${i} form-control"  onkeyup="multi(${i});" required/>
				</td>
				<td>
					<input type='text' id='total${i}' name='total[]' class="form-control" required/>
				</td>
			</tr>`;
            $('table').append(data);
            i++;
        });
	</script>

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

    <script>
        $(".delete").on('click', function () {
            $('.case:checkbox:checked').parents("tr").remove();

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
			$('.i-checks').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});
		});
	</script>

@endsection
