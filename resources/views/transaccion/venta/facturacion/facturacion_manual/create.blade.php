@extends('layout')
@section('title', 'Facturación Manual')
@section('href_accion', route('facturacion.index'))
@section('value_accion', 'Atrás')
@extends('layout_agregado_rapido')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<head>
    <script type="text/javascript">
        $(document).ready(function() {

            $("form").keypress(function(e) {
                if (e.which == 13) {
                    setTimeout(function() {
                        e.target.value += ' | ';
                    }, 4);
                    e.preventDefault();
                }
            });
        });
    </script>
</head>
@section('content')
{{-- errors --}}
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

@section('form_action_modal_cliente',  route('agregado_rapido.cliente_cotizado'))
@section('ruta_retorno', 'facturacion')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>Cliente</a>
</div>

<!-- Inicio-->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form action="{{route('facturacion_manual.store')}}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)" id="form_store">
                        @csrf
                       
                        <!--CABECERA-->
                        <!--//-->
                        <!--//-->
                        <!-- Foto del Logo y Detalle del Correlativo-->
                        <div class="row">
                            <div class="col-sm-4 text-left" align="left">
                                <address class="col-sm-4" align="left">
                                    <img src="{{asset('img/logos/')}}//{{$empresa->foto}}" alt="" width="300px">
                                </address>
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <div class="form-control ruc" style="height:125px">
                                    <center>
                                        <h3 style="padding-top:10px">{{$empresa->ruc}}</h3>
                                        <h2>FACTURA ELECTRONICA</h2>
                                        
                                    </center>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- Foto del Logo y Detalle del Correlativo-->

                        <!--Tabla de Datos Cabecera Factura-->
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Cliente</td><td>:</td>
                                    <td>
                                        <select class="select2_demo_client" name="cliente" required="" value="{{old('nombre')}}">
                                            <option></option>
                                            @foreach($clientes as $cliente)
                                            <option id="{{$cliente->id}}">{{$cliente->numero_documento}} - {{$cliente->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>Almacen</td><td>:</td>
                                    <td>
                                        <select class="select2_demo_almacen" name="almacen" required="" value="{{old('almacen')}}">
                                            <option></option>
                                            @foreach($almacenes as $almacen)
                                            <option value="{{$almacen->id}}">{{$almacen->nombre}} - {{$almacen->abreviatura}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Orden de compra</td><td>:</td>
                                    <td><input type="text" class="form-control m-b" name="orden_compra" required  autocomplete="off" value="0"></td>
                                    <td>Guía remisión</td><td>:</td>
                                    <td><input type="text" class="form-control" value="0" name="guia_r"></td>
                                    
                                </tr>
                                <tr>
                                    <td>Vendedor</td><td>:</td>
                                    <td><input type="text" class="form-control" name="personal" disabled required="required" value="{{auth()->user()->name}}"></td>
                                    <td>Forma de pago</td><td>:</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <select class="form-control" name="forma_pago"  id ="forma_pago" onchange="seleccionado_fp()">
                                                    @foreach($forma_pagos as $forma_pago) <option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option> @endforeach
                                                <select>
                                            </div>
                                            <div class="col-sm-6" id="credito_pago" style="visibility: hidden;">
                                                <button  type="button" class='cuota_modal btn btn-info' id="cuota_modal"  data-toggle="modal" data-target="#cuotas_modal">Cuotas</button>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Modal de Cuotas -->
                                    <div class="modal fade bd-example-modal-lg" id="cuotas_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Registrar cuotas</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert"   id="alert_campos" style="display: none">
                                                        <strong style="font-size:11px">Rellenar todos los campos</strong>
                                                            <button type="button" class="close_model_rc close" onclick="cerrar_but_rc()" style="padding: 6;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                    </div>
                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert"  id="suma_campos" style="display: none" >
                                                        <strong style="font-size:11px">La suma de las cuotas exceden el monto total</strong>
                                                        <button type="button" class="close_model_mt close" onclick="cerrar_but_mt()" style="padding: 6;">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="row_number">
                                                        <div class="pago_modal row">
                                                            <div class="col-sm-1">
                                                                <label>Fecha:</label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <input type="date" name="fecha_pago[]" id="fecha_pago0"  class="fecha_pago form-control" >
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <label>Monto:</label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="input-group mb-3" style="padding-right:15px">
                                                                    <div class="input-group-prepend">

                                                                    </div>
                                                                    <input type="text" name="monto_pago[]" id="monto_pago0" class="monto_pago form-control"   >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label ><button type="button"  aria-hidden="true" id="add_pago" class="add_pago btn btn-success"><i class="fa fa-plus-square-o fa-lg" > </i></button></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal de Cuotas -->
                                </tr>
                                <tr>
                                    <td>Moneda</td>
                                    <td>:</td>
                                    <td>
                                        <select name="moneda" class="form-control" >
                                            @foreach($moneda as $monedas)
                                            <option value="{{$monedas->id}}">{{$monedas->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>Fecha</td><td>:</td>
                                    <td><input type="text" name="fecha_emision" class="form-control" value="{{date("d-m-Y")}}" readonly="readonly"></td>
                                </tr>
                                <tr>
                                    <td>Tipo de Operación</td><td>:</td>
                                    <td>
                                        <select class="form-control" name="tipo_operacion" >
                                            @foreach($tipo_operacion as $t_op)
                                            <option id="{{$t_op->id}}">{{$t_op->codigo}} - {{$t_op->informacion}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td id="ven_1p" style="visibility: initial;">Fecha de Vencimiento</td><td id="ven_2p" style="visibility: initial;">:</td>
                                    <td id="ven_3p" style="visibility: initial;"><input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{date("Y-m-d")}}"></td>
                                </tr>
                                <tr>
                                    <td>Observación</td><td>:</td>
                                    <td colspan="4"><textarea class="form-control" name="observacion" id="observacion" >Emitimos la siguiente Factura a vuestra solicitud</textarea></td>
                                </tr>
                            </tbody>
                        </table>
                        <!--Tabla de Datos Cabecera Factura-->

                        <!--CABECERA-->


                        <!--REGISTROS DE PRODUCTOS Y SERVICIO-->
                        <div class="table-responsive">
                            <table cellspacing="0" class="table tables  " >
                                <thead>
                                    <tr>
                                        <th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()" /></th>
                                        <th >Articulo</th>
                                        <th style="width:100px">Cantidad</th>
                                        <th style="width:100px">Precio</th>
                                        <th style="width:100px">Total</th>
                                    </tr>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type='checkbox' class="case">
                                    </td>
                                    <td>
                                        <select class="monto0 select2_demo_3 select_change"  required="" id="articulo"  onchange="multi(0);selet_one()"  autocomplete="off">
                                            <option></option>
            
                                            @foreach($productos as $index => $producto)
                                            <option value="{{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}} }}">
                                                {{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}}
                                            </option>
                                            @endforeach
                                            @foreach($servicios as $index2 => $servicio)
                                            <option value="{{$servicio->id}} | {{$servicio->codigo_servicio}} | {{$servicio->codigo_original}} | {{$servicio->nombre}}">
                                                {{$servicio->id}} | {{$servicio->codigo_servicio}} | {{$servicio->codigo_original}} | {{$servicio->nombre}}
                                            </option>
                                            @endforeach
                                        </select>
            
                                        <textarea  type='text' {{-- id='descripcion0' --}}  name='descripcion_item[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                                        <textarea type='text' id='numero_serie0'  name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px;" placeholder="N° de Serie"></textarea>
                                        <input style="width: 76px" hidden="" type='text' id='tipo_afec0' name='tipo_afec[]' readonly="readonly" class="monto0 form-control" onkeyup="multi(0)"   autocomplete="off"  />
                                        <input type="hidden" class="celda"  name="articulo[]" id="input_prod1" >
            
                                    </td>
                                        <td>
                                            <input style="width: 76px" type='text' id='cantidad0' name='cantidad[]' max="" class="monto0 form-control"  onkeyup="multi(0)"  required  autocomplete="off" />
                                        </td>
                                        <td>
                                            <input style="width: 76px" type='text' id='precio0' name='precio[]'  class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off" />
                                        </td>
                                        <td>
                                            <input style="width: 76px"  type='text' id='total0' name='total' disabled="disabled" class="total form-control " required  autocomplete="off" />
                                        </td>
                                        <span id="spTotal"></span>
                                    </tr>
    
                                </tbody>
                                <tbody>

                                    {{-- subtotal e igv --}}
                                    <tr style="background-color: #f5f5f500;" align="center">
                                        <td></td>
                                        <td></td>
                                        <td>Subtotal :</td>
                                        <td colspan="2">
                                            <input id='sub_total' type="text" name="sub_total_sin_igv" readonly class="form-control" required />
                                            <input id='subtotal_gravado' type="text" name="subtotal_gravado" readonly class="form-control" required hidden="" />
                                        </td>
                                    </tr>
                                    <tr style="background-color: #f5f5f500;" align="center">
                                        <td></td>
                                        <td></td>
                                        <td>IGV :</td>
                                        <td colspan="2">
                                            <input id='igv' type="text" disabled="disabled" class="form-control" required />
                                        </td>
                                    </tr>

                                  <tr align="center">
                                    <td></td>
                                    <td></td>
                                    <td>Total :</td>
                                    <td colspan="2"><input id='total_final' name="costo_total"  readonly="readonly" class="form-control" required /></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>&nbsp;
                                <button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;
                            </div>
                            <div class="col-sm-6 ">
                                <button type="submit" name="name" value="pdf" class="ladda-button btn btn-info float-right"  style="margin-right: 5px">Enviar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control{border-radius: 10px}
    .text_des{border-radius: 10px;border: 1px solid #e5e6e7;width: 80px;padding: 6px 12px;}
    .check{-webkit-appearance: none;height: 34px;background-color: #ffffff00;-moz-appearance: none;border: none;appearance: none;width: 80px;border-radius: 10px;}
    .div_check{position: relative;top: -33px;left: 0px;background-color: #ffffff00;  top: -35;}
    .check:checked {background: #0375bd6b;}
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] { -moz-appearance:textfield; }
    label.col-form-label::marker{
        list-style:none;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 12px;
    }
    .select2-container--default .select2-selection--single {
        border: none;
    }
    span.select2.select2-container.select2-container--default{
        width: 100%!important;
        background-color: #FFFFFF;
        background-image: none;
        border-radius: 1px;
        display: block;
        padding: 3px 12px;
        border: 1px solid #e5e6e7;
    }
</style>


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
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>


<script type="text/javascript">
    $(".select2_demo_3").select2({
        placeholder: "Seleccionar Producto",
    });
</script>

<script type="text/javascript">
    $(".select2_demo_client").select2({
        placeholder: "Seleccionar Cliente",
    });
</script>

<script type="text/javascript">
    $(".select2_demo_almacen").select2({
        placeholder: "Seleccionar Almacen",
    });
</script>

{{-- Validar Formulario / No doble insercion de datos(Gente desesperado) --}}
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
{{-- FIN Validar Formulario / No doble insercion de datos(Gente desesperado) --}}

{{-- @if($categoria=='producto') --}}
<script>
    var i = 2;
    $(".addmore").on('click', function () {
        var data = `[
            <tr>
        <td>
            <input type='checkbox' class='case'/>
        </td>";
        
        <td>
            <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="multi(${i});seleccion_options(${i})"  autocomplete="off">
                    <option></option>
                @foreach($productos as $index => $producto)
                    <option value="{{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}}">
                        {{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}}</option>
                    @endforeach
                @foreach($servicios as $index2 => $servicio)
                    <option value="{{$servicio->id}} | {{$servicio->codigo_servicio}} | {{$servicio->codigo_original}} | {{$servicio->nombre}}">
                        {{$servicio->id}} | {{$servicio->codigo_servicio}} | {{$servicio->codigo_original}} | {{$servicio->nombre}}
                    </option>
                @endforeach
            </select>
            <textarea type='text' {{-- id='descripcion${i}'--}}   name='descripcion_item[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
            <textarea type='text' id='numero_serie0' placeholder="N° de Serie" name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
            <input type="hidden" class="celda"  name="articulo[]" id="input_prod${i}" >
        </td>

        <td>
            <input type='text' style="width: 76px"  id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
        </td>
        <td>
            <input type='text' style="width: 76px"  id='precio${i}' name='precio[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
        </td>
        <td>
            <input type='text' id='total${i}'  style="width: 76px"  name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
        </td>

        </tr>
        `;
        $('.tables').append(data);
        i++;

        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Producto",
        });
       
    });
</script>

<script>
    function multi(a){
        var total = 1;
        var totales=0;
        var change= false; //
        $(`.monto${a}`).each(function(){
        if (!isNaN(parseFloat($(this).val()))) {
        change= true;

        total *= parseFloat($(this).val());
        }
        });
        total = (change)? total:0;

        var cantidad = document.querySelector(`#cantidad${a}`).value;
        var precio = document.querySelector(`#precio${a}`).value;
        
        var multiplier = 100;
        var final=(precio*cantidad);
        var final_decimal = Math.round(final * multiplier) / multiplier;
        console.log(final_decimal);
        document.getElementById(`total${a}`).value = final_decimal;

        var totalInp = $('[name="total"]');
        var total_t = 0;

        totalInp.each(function(){
        total_t += parseFloat($(this).val());
        });

        var multiplier2 = 100;
        var total_tt = Math.round(total_t * multiplier2) / multiplier2;

        $('#sub_total').val(total_tt);

        var igv_valor={{$igv->renta}}; 
        var subtotal = document.querySelector(`#sub_total`).value;
        var igv=subtotal*igv_valor/100;

        var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
        var end=igv_decimal+parseFloat(subtotal);

        var end2 = Math.round(end * multiplier2) / multiplier2;

        document.getElementById("igv").value = igv_decimal;
        document.getElementById("sub_total").value = subtotal;

        var end=parseFloat(igv_decimal)+parseFloat(subtotal);
        var end3 = Math.round(end * multiplier2) / multiplier2;
        document.getElementById("total_final").value = end3;

        var monto_c = document.getElementsByClassName('monto_pago');

            var inp_mont = document.getElementsByClassName('monto_pago').length;
            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                // var input_text = document.getElementById(`${monto}`).value;
                var fin = (end2/inp_mont)
                document.getElementById("monto_pago0").value = Math.round(end2 * multiplier2)/ multiplier2;
                // document.getElementById(`${monto}`).value = end2;
            }
    }
    </script>

    <script>
        $(".delete").on('click', function () {
            $('.case:checkbox:checked').parents("tr").remove();
                var totalInp = $('[name="total"]');
                var total_t = 0;

                totalInp.each(function(){
                total_t += parseFloat($(this).val());
            });
            $('#sub_total').val(total_t);

            var igv_valor={{$igv->renta}};
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv=parseFloat(subtotal)*igv_valor/100;
            var end=parseFloat(igv)+parseFloat(subtotal);

            document.getElementById("igv").value = igv;
            document.getElementById("total_final").value = end;

            var monto_c = document.getElementsByClassName('monto_pago');

            var inp_mont = document.getElementsByClassName('monto_pago').length;
            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                // var input_text = document.getElementById(`${monto}`).value;
                var fin = (end2/inp_mont)
                document.getElementById("monto_pago0").value = Math.round(end * multiplier2)/ multiplier2;
                // document.getElementById(`${monto}`).value = end2;
            }

        });
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






    <script type="text/javascript">
        function seleccionado_fp(){
            var opt = $('#forma_pago').val();
            if(opt=="1"){
                    document.getElementById('credito_pago').style.visibility = "hidden";
                    document.getElementById('ven_1p').style.visibility = "initial";
                    document.getElementById('ven_2p').style.visibility = "initial";
                    document.getElementById('ven_3p').style.visibility = "initial";
                    document.getElementById('fecha_vencimiento').removeAttribute('disabled');
                    // $('#consulta_s').hide();
                }else{
                    // $('#consulta_p_input').prop('disabled', 'disabled');
                    document.getElementById('credito_pago').style.visibility = "initial";
                    document.getElementById('ven_1p').style.visibility = "hidden";
                    document.getElementById('ven_2p').style.visibility = "hidden";
                    document.getElementById('ven_3p').style.visibility = "hidden";
                    document.getElementById('fecha_vencimiento').setAttribute('disabled', 'true');
                    // $('#consulta_s').show();
                }
            }
        </script>
        <script>
            var total = document.getElementById('total_final').value;
            var x = 1;
            $(".add_pago").on('click', function () {
                var total = document.getElementById('total_final').value;
                var data = `
                <div class="delete_modal${x} row">
                <div class="col-sm-1"><label>Fecha:</label></div>
                <div class="col-sm-4">
                <input type="date" name="fecha_pago[]" id="fecha_pago${x}" class="fecha_pago form-control" >
                </div>
                <div class="col-sm-1"><label>Monto:</label></div>
                <div class="col-sm-4">
                <div class="input-group mb-3" style="padding-right:15px">
                <div class="input-group-prepend">
                
                </div>
                <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}"    >
                </div>
                </div>
                <div class="col-sm-2">
                <label ><button type="button"  class="xd btn btn-danger" onclick="eliminar(${x})"><i class="fa fa-trash-o fa-lg" > </i></button></label>
                </div>
                </div>`;
                $('.row_number').append(data);

                var inp_mont = document.getElementsByClassName('monto_pago').length;

       // document.getElementById(`monto_pago${x}`).value = (total/inp_mont);

       x++;
       if(inp_mont>6){
        $('.add_pago').attr('disabled');
    }
    var multiplier2 = 100;
    var monto_c = document.getElementsByClassName('monto_pago');
    var inp_mont = document.getElementsByClassName('monto_pago').length;
    for (var i = 0; i < inp_mont; i++) {
        var monto = monto_c[i].id;
        var fin = (total/inp_mont)
        document.getElementById("monto_pago0").value = '';
                // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
    }
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        if(inp_mont>5){
            document.getElementById('add_pago').setAttribute('disabled', "true");
        }else{
            document.getElementById('add_pago').removeAttribute('disabled');
        }
    });

    </script>























    <style type="text/css">
        .a{color: red}
    </style>
    <script type="text/javascript">
        // $(".delete_pago").on('click', function () {
            function eliminar(x){
                $(`.delete_modal${x}`).remove();
                var monto_c = document.getElementsByClassName('monto_pago');
                var inp_mont = document.getElementsByClassName('monto_pago').length;
                var total = document.getElementById('total_final').value;
                var multiplier2 = 100;
                for (var i = 0; i < inp_mont; i++) {
                    var monto = monto_c[i].id;

                    var fin = (total/inp_mont)
                    document.getElementById("monto_pago0").value = '';
                // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
            }
            if(inp_mont>5){
                document.getElementById('add_pago').setAttribute('disabled', "true");
            }else if(inp_mont == 1){
                document.getElementById("monto_pago0").value = total;
            }else{
                document.getElementById('add_pago').removeAttribute('disabled');
            }
        };
    </script>
    <script>
        $("#boton").on("click",function(buton){
            // var cliente = document.getElementById("cliente").value;
            // console.log(cliente);
           // if(cliente.length != 0){
            var f_p = $('#forma_pago').val();
            var total = document.getElementById('total_final').value;
            // console.log(total);
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var monto_c = document.getElementsByClassName('monto_pago');
            var monto_fc = document.getElementsByClassName('fecha_pago');
            if(f_p == "2" ){
                var sum2 = 0.00;
                for(g = 0; g<inp_mont;g++){
                    var monto1 = monto_c[g].id;
                    var input_text_2 = document.getElementById(`${monto1}`).value;
                    console.log("text2 = "+input_text_2);
                    var sum2 = ( Number.parseFloat(sum2) + Number.parseFloat(input_text_2));
                    console.log("sum-b-for = "+sum2);

                }
                var sum = Math.round(sum2 * 100) / 100;
                if(sum != total){
                    document.getElementById('cuota_modal').click();
                    document.getElementById('suma_campos').style.display = "flex";
                    buton.preventDefault();
                }
                for (var i = 0; i < inp_mont; i++) {
                    var fecha = monto_fc[i].id;
                    var monto = monto_c[i].id;
                    var input_text = document.getElementById(`${monto}`).value;
                    var date_text = document.getElementById(`${fecha}`).value;
                    if( input_text.length  == 0 || date_text.length  == 0 ){
                        document.getElementById('cuota_modal').click();
                        document.getElementById('alert_campos').style.display = "flex";
                        buton.preventDefault();
                    }else{
                        document.getElementById('boton').click();
                            // buton.preventDefault();
                        }
                    }
                }else{
                    document.getElementById('boton').click();
                     // buton.preventDefault();
                 }
            // buton.preventDefault();
        });

    </script>
    <script >
        function cerrar_but_rc(){
            document.getElementById('alert_campos').style.display = "none";
        }
        function cerrar_but_mt(){
            document.getElementById('suma_campos').style.display = "none";
        }
    </script>
    {{-- FUNCION PARA DESACTIVAR LOS SELECT  --}}
    <script>

        function seleccion_options(b){
            var cant_opt = document.getElementById(`articulo${b}`).length;
            var count_input = document.getElementsByClassName('celda').length;
            var option = document.getElementById(`articulo${b}`);
            var valor_select = option.value;
            var ant_val = document.getElementById(`input_prod${b}`).value;
            $('option[value="'+ant_val+'"]').prop( "disabled", false);

            if(valor_select.indexOf("SERV-") == 4){
                $(".addmore").prop("disabled", false);
                document.getElementById(`input_prod${b}`).value = valor_select;
                $('option[value="'+valor_select+'"]').prop( "disabled", false);

            }else{
                if(valor_select == ""){
                    document.getElementById(`input_prod${b}`).value = valor_select;
                    $('option[value="'+valor_select+'"]').prop( "disabled", true);
                }else{
                    $('option[value="'+valor_select+'"]').prop( "disabled", true);
                    document.getElementById(`input_prod${b}`).value = valor_select;

                    $(".addmore").prop("disabled", false);
                }
            }
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Producto",
            });
        }
    </script>

    {{-- @endif --}}

    <script  >
        function selet_one(){
            var cant_opt = document.getElementById(`articulo`).length;
            var count_input = document.getElementsByClassName('celda').length;
            var option = document.getElementById(`articulo`);
            var valor_select = option.value;
            var ant_val = document.getElementById(`input_prod1`).value;
            $('option[value="'+ant_val+'"]').prop( "disabled", false);
            if(valor_select.indexOf("SERV-") == 4){
                $(".addmore").prop("disabled", false);
                document.getElementById(`input_prod1`).value = valor_select;
                $('option[value="'+valor_select+'"]').prop( "disabled", false);
            }else{
                if(valor_select == ""){
                    document.getElementById(`input_prod1`).value = valor_select;
                    $('option[value="'+valor_select+'"]').prop( "disabled", true);
                }else{                    
                    $('option[value="'+valor_select+'"]').prop( "disabled", true);
                    document.getElementById(`input_prod1`).value = valor_select;
                    $(".addmore").prop("disabled", false);
                }
            }
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Producto",
            });
        }

    </script>
    @stop
