@extends('layout')
@section('title', 'Kardex Entrada')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'Atras')

@section('content')
{{-- <!-- <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet"> --> --}}
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
{{-- <div class="wrapper wrapper-content animated fadeInRight">
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
    <form action="{{ route('kardex-entrada.store') }}" enctype="multipart/form-data" method="post" onsubmit="return valida(this)" id="kardex_submit">
        @csrf
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Motivos:</label>
            <div class="col-sm-4">
                <select class="form-control" name="motivo" id="motivo" required="required">
                    <option value="">Seleccionar Motivo</option>
                    @foreach($motivos as $motivo)
                    <option value="{{$motivo->nombre}}">{{$motivo->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <label class="col-sm-2 col-form-label">G Remision:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="guia_remision" id="guia_remision" value="0">
            </div>
        </div>
        <input class="form-control" name="almacen" type="text" hidden="" value="1">
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Factura:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control " name="factura" id="factura" value="0">
            </div>

            <label class="col-sm-2 col-form-label"> Provedor:</label>
            <div class="col-sm-4">
                <select class="form-control " name="provedor" required="required">
                    @foreach($provedores as $provedor)
                    <option value="{{$provedor->empresa}}">{{$provedor->empresa}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Almacen:</label>
            <div class="col-sm-4">
                @foreach($almacenes as $almacen)
                <input class="form-control" type="text" readonly="" value="{{$almacen->abreviatura}} - {{$almacen->descripcion}}">
                <input class="form-control" name="almacen" type="text" hidden="" value="1">
                @endforeach
                </select>
                <label class="col-sm-2 col-form-label">Tipo de Transporte:</label>
                <div class="col-sm-4">
                    <select name="transporte" required id="" class="form-control">
                        <option value="">Escoge el tipo de Transporte</option>
                        <option value="Transporte Privado">Transporte Privado</option>
                        <option value="Transporte Publico">Transporte Publico</option>
                    </select>
                </div>
            </div>

            <label class="col-sm-2 col-form-label"> Informaciones:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="informacion" value="Ingreso de productos al almacen">
            </div>
        </div>


        <div class="form-group row ">
            <label class="col-sm-2 col-form-label">Categoria:</label>
            <div class="col-sm-4">
                <input class="form-control" name="clasificacion" disabled="direccion" value="PRODUCTOS">
            </div>
            <label class="col-sm-2 col-form-label">Moneda:</label>
            <div class="col-sm-4">
                <select class="form-control" name="moneda" required="">
                    <option value="">Seleccionar Moneda</option>
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
                    <th style="width: 600px">Producto <a href="{{route('productos.create')}}" class="btn btn-warning" target="blanck" style="padding-top: 0px;padding-bottom: 0px; padding-left: 4px;padding-right: 4px;"><i class="fa fa-plus-square" aria-hidden="true"></a></th>
                    <th style="width: 100px">Unidad</th>
                    <th style="width: 100px">Cantidad</th>
                    <th style="width: 100px">Precio</th>
                    <th style="width: 100px">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <button type="button" class='delete borrar e btn btn-danger'> <i class="fa fa-trash" aria-hidden="true"></i> </button>
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

                    <td><input type='text' id='unidad' name='unidad[]' class="monto0 unidad0 form-control clean" onkeyup="multi(0);" value="1" required /></td>
                    <td><input type='text' id='cantidad' name='cantidad[]' class="monto0 form-control clean" onkeyup="multi(0);" required /></td>
                    <td><input type='text' id='precio' name='precio[]' class="monto0 precio0 form-control clean" onkeyup="multi(0);" required /></td>
                    <td><input type='text' id='total0' name='total[]' class="form-control clean" required /></td>
                    <span id="spTotal"></span>
                </tr>
            </tbody>
            <tbody style="background-color: white !important">
                <tr>
                    <td colspan="4">
                        <button type="button" class='addmore btn btn-success' disabled=""> <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
                    </td>
                    <td colspan="2">
                        <button class="ladda-button btn btn-primary float-right" type="submit" id="boton"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <tr>
        <style type="text/css">
            .form-control {
                border-radius: 5px;
            }

        </style>
    </tr>
</div>
</div>
</div>
</div>
</div> --}}
<!-- Título -->
{{-- <div style="border-bottom:none solid #e7eaec; margin-bottom: 35px; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center;">
                    <a href="{{ route('kardex-entrada.index') }}" style="text-decoration: none; margin-right: 20px;">
<i class="fa fa-arrow-left" style="font-size: 24px; color: black;"></i>
</a>
</div>
<i class="fa fa-user-circle" style="font-size: 28px; color: #222;"></i>
</div> --}}

<!-- KARDEX ENTRADA NUEVO CON BACKEND DEL ANTIGUO -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h4><strong>Kardex de Entrada</strong></h4>
            <div class="ibox-tools" style="margin-top:5px;margin-bottom:8px;margin-right:10px">
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                <a class="" href="{{ route('kardex-entrada.index') }}"><i class="fa fa-times"></i></a>
            </div>
        </div>

        <div class="ibox-content">


            {{-- Fecha izquierda / Almacén derecha--}}
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-6">
                    <span><strong>{{ Carbon\Carbon::now()->format('d/m/Y') }}</strong></span>
                </div>
                <div class="col-md-6 text-right">
                    @foreach($almacenes as $almacen)
                    <span><strong>{{ $almacen->abreviatura }} - {{ $almacen->nombre }}</strong></span>
                    @endforeach
                </div>
            </div>

            {{-- Mensajes/errores (déjalos tal cual aquí) --}}
            @if (session('repite')) <div class="alert alert-danger">{{ session('repite') }}</div> @endif
            @if (session('campo')) <div class="alert alert-success">{{ session('campo') }}</div> @endif
            @if($errors->any())
            <div style="padding-top: 20px;">
                <div class="alert alert-danger">
                    <a class="alert-link" href="#">
                        @foreach ($errors->all() as $error) <li style="color: red">{{ $error }}</li> @endforeach
                    </a>
                </div>
            </div>
            @endif


            <!-- Formulario con action y método del código antiguo -->
            <form action="{{ route('kardex-entrada.store') }}" enctype="multipart/form-data" method="post" onsubmit="return valida(this)" id="kardex_submit">
                @csrf

                <!-- Campos ocultos-->
                <input class="form-control" name="almacen" type="text" hidden="" value="1">
                <div class="row form-label word-style">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Motivo:</strong></label>
                            <div class="col-md-10">
                                <select class="select2_demo_3b asf2" name="motivo" id="motivo" required>
                                    <option value="Sin motivo">Seleccionar Motivo</option>
                                    @foreach($motivos as $motivo)
                                    <option value="{{ $motivo->nombre }}">{{ $motivo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tipo de Comprobante -->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">
                                        <strong>Tipo de Comprobante:</strong>
                                    </label>
                                    <div class="col-md-8">
                                        <select id="comprobante" class="select2_demo_3b asf2" required>
                                            <option value="Sin Comprobante">Sin Comprobante</option>
                                            <option value="Factura">Factura</option>
                                            <option value="Boleta">Boleta</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- N° y Fecha (fusionados en el control) -->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">
                                        <strong>N° y Fecha:</strong>
                                    </label>
                                    <div class="col-md-8">
                                        <div class="d-flex w-100">
                                            <div class="d-flex w-100 border rounded bg-white px-2 py-1">
                                                <input type="date" class="form-control border-0 rounded-0 bg-transparent shadow-none" id="fecha_comprobante">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 d-flex align-items-center mb-2">
                            <label for="comprobante" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>Tipo de Comprobante</strong><span style="color:red;">*</span></label>
                            <select id="comprobante" class="form-control me-2" style="width: 35%;">
                                <option>Sin Comprobante</option>
                                <option>Factura</option>
                                <option>Boleta</option>
                            </select>
                            <!-- Campo factura del código antiguo -->
                            <input type="text" class="form-control me-2" name="factura" id="factura" value="0" placeholder="Número" style="width: 25%;">
                            <input type="date" class="form-control" style="width: 25%;">
                        </div> --}}
                        <div class="form-group row">
                            <label for="transporte" class="col-form-label col-md-2"><strong>Tipo de transporte</strong></label>
                            <div class="col-md-10">
                                <select name="transporte" required id="" class="select2_demo_3b asf2">
                                    <option value="Sin transporte">Escoge el tipo de Transporte</option>
                                    <option value="Transporte Privado">Transporte Privado</option>
                                    <option value="Transporte Publico">Transporte Publico</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 d-flex align-items-center mb-2">
                            <label for="transporte" class="form-label mb-0 me-2" style="min-width:120px; font-weight:600; color:#000;"><strong>Tipo de transporte</strong><span style="color:red;">*</span></label>
                            <!-- Select de transporte del código antiguo -->
                            <select name="transporte" required id="" class="form-control">
                                <option value="">Escoge el tipo de Transporte</option>
                                <option value="Transporte Privado">Transporte Privado</option>
                                <option value="Transporte Publico">Transporte Publico</option>
                            </select>
                        </div> --}}
                        <div class="form-group row">
                            <label for="categoria" class="col-form-label col-md-2"><strong>Categoría</strong></label>
                            <div class="col-md-10">
                                <div class="d-flex w-100 border rounded bg-white px-2 py-1">
                                    <input class="form-control border-0 rounded-0 bg-transparent shadow-none w-100" name="clasificacion" disabled="direccion" value="PRODUCTOS">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fecha" class="col-form-label col-md-2"><strong>Fecha de compra</strong></label>
                            <div class="col-md-10">
                                <div class="d-flex w-100 border rounded bg-white px-2 py-1">
                                    <input type="date" name="fecha_compra" id="" required="" class="form-control border-0 rounded-0 bg-transparent shadow-none w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="proveedor" class="col-form-label col-md-2"><strong>Proveedor</strong></label>
                            <div class="col-md-10">
                                <select class="select2_demo_3b asf2" name="provedor" required="required">
                                    @foreach($provedores as $provedor)
                                    <option value="{{$provedor->empresa}}">{{$provedor->empresa}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="moneda" class="col-form-label col-md-2"><strong>Moneda</strong></label>
                            <div class="col-md-10">
                                <select class="select2_demo_3b asf2" name="moneda" required="">
                                    <option value="Sin moneda">Seleccionar Moneda</option>
                                    @foreach($moneda as $monedas)
                                    <option value="{{$monedas->nombre}}">{{$monedas->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="info" class="col-form-label col-md-2"><strong>Información</strong></label>
                            <div class="col-md-10">
                                <div class="d-flex w-100 border rounded bg-white px-2 py-1">
                                    <input type="text" class="form-control border-0 rounded-0 bg-transparent shadow-none w-100" name="informacion" value="Ingreso de productos al almacen">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="guia" class="col-form-label col-md-2"><strong>G. Remisión</strong></label>
                            <div class="col-md-10">
                                <div class="d-flex w-100 border rounded bg-white px-2 py-1">
                                    <input type="text" class="form-control border-0 rounded-0 bg-transparent shadow-none w-100" name="guia_remision" id="guia_remision" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="archivo" class="col-form-label col-md-2"><strong>Archivo</strong>{{--<span class="text-danger">*</span>--}}</label>
                            <div class="col-md-10">
                                <div class="d-flex w-100 border rounded bg-white px-2 py-1">
                                    <input type="file" class="form-control border-0 rounded-0 bg-transparent shadow-none w-100" name="archivo" id="archivo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Tabla con tu lógica de cálculo funcionando -->
                <table cellspacing="0" class="table table-striped" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 10px">
                                <button type="button" class="btn btn-sm btn-primary btn-outline btn-agregar" title="Agregar">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </th>
                            <th style="width: 600px">Producto</th>
                            <th style="width: 100px">Unidad</th>
                            <th style="width: 100px">Cantidad</th>
                            <th style="width: 100px">Precio</th>
                            <th style="width: 100px">Total</th>
                        </tr>
                    </thead>
                    <tbody id="productos_tbody2">
                        <tr>
                            <td>
                                <button type="button" class="delete borrar2 btn-borrar btn btn-sm btn-primary" title="Eliminar">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td>
                                <select class="select2_demo_3b asf2" name="articulo[]" required id="articulo2_1" onchange="select_opt2(1)">
                                    <option value="">Seleccionar Producto</option>
                                    @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}"> {{ $producto->nombre }} | {{ $producto->codigo_original }} | {{ $producto->codigo_producto }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="registro_opt[]" id="registro_opt2_1" value="" class="registro_opt2" />
                            </td>
                            <td><input type='text' name='unidad[]' class="form-control monto2_1" onkeyup="multi2(1);" value="1" required /></td>
                            <td><input type='text' name='cantidad[]' class="form-control monto2_1" onkeyup="multi2(1);" required /></td>
                            <td><input type='text' name='precio[]' class="form-control monto2_1" onkeyup="multi2(1);" required /></td>
                            <td><input type='text' name='total[]' id='total2_1' class="form-control" readonly /></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <button class="ladda-button btn btn-primary float-right" type="submit" id="boton2">
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
        placeholder: "Seleccionar Producto"
    , });

</script>
<script>
    $(function() {
        $('.select2_demo_motivo').select2({
            theme: 'bootstrap'
            , placeholder: 'Seleccionar Motivo'
            , width: '100%'
        });
    });

</script>

{{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<script>
    function valida(f) {
        var boton = document.getElementById("boton2");
        var completo = true;
        var incompleto = false;
        if (f.elements[0].value == "") {
            alert(incompleto);
        } else {
            boton.type = 'button';
        }
    }

</script>
{{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}

<!-- Typehead -->
<script src="{{ asset('js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>
<script>
    $(function() {
        $('.btn-agregar, .btn-borrar').css('cursor', 'pointer');
    });

</script>


<script>
    var i = 2;
    $(".addmore").on('click', function() {
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
        for (j = 0; j < number_tot; j++) {
            input_ds[j] = document.getElementsByName('articulo[]')[j].value;
            $('option[value="' + input_ds[j] + '"]').prop("disabled", true);
        };
        $(".addmore").prop("disabled", true);
        $(".borrar").prop("disabled", false);

        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Producto"
        , });
    });

</script>

<script>
    function valid_factura() {
        // e.preventDefault();
        var n_factura = $('[id="factura"]').val();
        $.ajax({
            type: "post"
            , url: "{{ route('pa.nfactura') }}"
            , data: {
                '_token': $('input[name=_token]').val()
                , 'n_factura': n_factura
            }
            , success: function(msg) {
                if (msg == 1) {
                    toastr.error("Error en el Registro"
                        , 'N de Factura ya en uso', {
                            timeOut: 3000
                        });
                    $('[id="factura"]').addClass('input_red');
                    // $('[id="boton"]').prop("disabled", true);
                } else {
                    $('[id="factura"]').removeClass('input_red');
                    $('[id="boton"]').prop("disabled", false);
                }
            }
        });
    }
    var timeout;
    $("#factura").on('keydown', () => {
        $('[id="boton"]').prop("disabled", true);
        clearTimeout(timeout)
        timeout = setTimeout(() => {
            valid_factura();
            clearTimeout(timeout)
        }, 400)
    })

</script>

<script>
    function multi(a) {
        console.log(a);
        var total = 1;
        var precio = $(`.precio${a}`).val();
        var change = false; //
        $(`.monto${a}`).each(function() {
            if (!isNaN(parseFloat($(this).val()))) {
                change = true;
                if (precio.length == 0) {
                    total = 0;
                } else {
                    total *= parseFloat($(this).val());
                }

            }
        });
        total = (change) ? total : 0;
        document.getElementById(`total${a}`).value = Math.round(total * 100) / 100;
    }

</script>

<script>
    $(document).on('click', '.borrar', function(event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        // alert(e);
        var fila = $(this).parents("tr");
        var input_text_opt = fila.find('input[class="registro_opt"]').val();
        $('option[value="' + input_text_opt + '"]').prop("disabled", false);
        if (e > 1) {
            fila.closest('tr').remove();
            $(".addmore").prop("disabled", false);
        } else {
            $('.clean').val("");
            $(".select2_demo_3").val(null).trigger("change");
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
        }
    });

</script>

<script>
    function select_opt(b) {
        var cant_opt = document.getElementById(`articulo${b}`).length;
        var count_input = document.getElementsByClassName('registro_opt').length;

        var option = document.getElementById(`articulo${b}`);

        var valor_select = option.value;
        console.log(valor_select);
        if (valor_select == "") {
            document.getElementById(`registro_opt${b}`).value = valor_select;
            $('option[value="' + valor_select + '"]').prop("disabled", true);
        } else {
            var ant_val = document.getElementById(`registro_opt${b}`).value;
            $('option[value="' + ant_val + '"]').prop("disabled", false);
            $('option[value="' + valor_select + '"]').prop("disabled", true);
            document.getElementById(`registro_opt${b}`).value = valor_select;
            if (cant_opt - 1 == count_input) {
                $(".addmore").prop("disabled", true);
            } else {
                $(".addmore").prop("disabled", false);
            }
        }
        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Producto"
        , });

    }

</script>

{{-- SCRIPTS CORREGIDOS PARA LA TABLA NUEVA --}}
<script>
    let contador = 2;

    // Inicializar Select2 y deshabilitar botón de agregar al cargar
    $(document).ready(function() {
        $(".select2_demo_3b").select2({
            placeholder: "Seleccionar Producto"
        });

        // Deshabilitar botón de agregar al inicio
        $(".btn-agregar").prop("disabled", true);

        // Verificar estado inicial del primer select
        verificarEstadoBotonAgregar();

        // Deshabilitar productos ya seleccionados al inicio
        actualizarProductosDisponibles();
    });

    // Función para verificar si se debe habilitar el botón agregar
    function verificarEstadoBotonAgregar() {
        let todasLasFilasTienenProducto = true;

        // Verificar que TODAS las filas tengan un producto seleccionado
        $('select[name="articulo[]"]').each(function() {
            if (!$(this).val() || $(this).val() === '') {
                todasLasFilasTienenProducto = false;
                return false; // break del each
            }
        });

        if (todasLasFilasTienenProducto) {
            $(".btn-agregar").prop("disabled", false);
        } else {
            $(".btn-agregar").prop("disabled", true);
        }
    }

    // Función para deshabilitar productos ya seleccionados
    function actualizarProductosDisponibles() {
        // Primero habilitar todas las opciones
        $('select[name="articulo[]"] option').prop('disabled', false);

        // Obtener todos los productos seleccionados
        let productosSeleccionados = [];
        $('select[name="articulo[]"]').each(function() {
            let valor = $(this).val();
            if (valor && valor !== '') {
                productosSeleccionados.push(valor);
            }
        });

        // Para cada select, deshabilitar productos ya seleccionados en otros
        $('select[name="articulo[]"]').each(function() {
            let selectActual = $(this);
            let valorActual = selectActual.val();

            selectActual.find('option').each(function() {
                let opcion = $(this);
                let valorOpcion = opcion.val();

                if (valorOpcion && valorOpcion !== '' && valorOpcion !== valorActual) {
                    // Si está seleccionado en otro select, deshabilitar
                    if (productosSeleccionados.includes(valorOpcion)) {
                        opcion.prop('disabled', true);
                    }
                }
            });
        });

        // Actualizar Select2 para reflejar los cambios
        $('select[name="articulo[]"]').trigger('change.select2');
    }

    // Función corregida para manejar selección de productos
    function select_opt2(index) {
        let select = document.getElementById(`articulo2_${index}`);
        let val = select.value;
        let oldVal = document.getElementById(`registro_opt2_${index}`).value;

        // Actualizar valor en campo oculto
        document.getElementById(`registro_opt2_${index}`).value = val;

        // Actualizar productos disponibles
        setTimeout(function() {
            actualizarProductosDisponibles();
            verificarEstadoBotonAgregar();
        }, 100);
    }

    // Agregar nueva fila
    $(".btn-agregar").on("click", function() {
        let fila = `
        <tr>
            <td>
                <button type="button" class="delete borrar2 btn-borrar btn-sm btn-primary">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </td>
            <td>
                <select class="select2_demo_3b asf2" name="articulo[]" required id="articulo2_${contador}" onchange="select_opt2(${contador})">
                    <option value="">Seleccionar Producto</option>
                    @foreach($productos as $producto)
                    <option value="{{ $producto->id }}"> {{ $producto->nombre }} | {{ $producto->codigo_original }} | {{ $producto->codigo_producto }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="registro_opt[]" id="registro_opt2_${contador}" value="" class="registro_opt2" />
            </td>
            <td><input type='text' name='unidad[]' class="form-control monto2_${contador}" onkeyup="multi2(${contador});" value="1" required/></td>
            <td><input type='text' name='cantidad[]' class="form-control monto2_${contador}" onkeyup="multi2(${contador});" required/></td>
            <td><input type='text' name='precio[]' class="form-control monto2_${contador}" onkeyup="multi2(${contador});" required/></td>
            <td><input type='text' name='total[]' id='total2_${contador}' class="form-control" readonly/></td>
        </tr>
        `;
        $("#productos_tbody2").append(fila);

        // Inicializar Select2 en el nuevo select
        $(`#articulo2_${contador}`).select2({
            placeholder: "Seleccionar Producto"
        });

        contador++;

        // Actualizar productos disponibles pero mantener botón deshabilitado
        // hasta que se seleccione producto en la nueva fila
        setTimeout(function() {
            actualizarProductosDisponibles();
            verificarEstadoBotonAgregar(); // Esto verificará que todas las filas tengan producto
        }, 200);
    });

    // Eliminar fila
    $(document).on("click", ".borrar2", function() {
        let fila = $(this).closest("tr");
        let filas = $(".borrar2").length;

        if (filas > 1) {
            fila.remove();
        } else {
            // Si es la última fila, limpiar campos
            fila.find("input[type='text']").val("");
            fila.find("input[name='unidad[]']").val("1");
            fila.find("select").val("").trigger("change");
        }

        // Actualizar estado después de eliminar
        setTimeout(function() {
            actualizarProductosDisponibles();
            verificarEstadoBotonAgregar();
        }, 100);
    });

    // Event listener para el primer select (que ya existe en el HTML)
    $(document).on('change', 'select[name="articulo[]"]', function() {
        setTimeout(function() {
            actualizarProductosDisponibles();
            verificarEstadoBotonAgregar();
        }, 100);
    });

    // Calcular total: unidad * cantidad * precio
    function multi2(index) {
        let total = 1;
        let valid = false;

        $(`.monto2_${index}`).each(function() {
            let val = parseFloat($(this).val());
            if (!isNaN(val) && val > 0) {
                total *= val;
                valid = true;
            }
        });

        total = valid ? total : 0;
        document.getElementById(`total2_${index}`).value = Math.round(total * 100) / 100;
    }

</script>
{{--Agregar funcion para calcular total de cada fila--}}
@endsection
