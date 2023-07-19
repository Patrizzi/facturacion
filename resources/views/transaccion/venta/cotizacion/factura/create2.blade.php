@extends('layout')
@section('title', 'Cotización M.Principal')
@section('href_accion', route('cotizacion.index') )
@section('atributo_actu', 'hidden')
@section('value_accion', 'Atrás')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@section('content')

@if (session('repite'))
<div class="alert alert-success">
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
@include('layout_agregado_rapido')

{{-- Boton para modal de Clientes --}}
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>
{{--Fin Boton para modal de Clientes --}}

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content" style="padding-bottom: 0px;" >
                <div class="row" >
                   <div class="col-sm-3 ">
                       <p class="form-control " align="center" >Cotizado por: {{auth()->user()->nombre}}</p>
                   </div>
                   <div class="col-sm-3">
                       <p class="form-control "  align="center" style="margin-left: 10px;">Fecha de Emision: {{date("d-m-Y")}}</p>
                   </div>
                   <div class="col-sm-6" align="right">
                      <div class="dropdown" style="float:right;">
                        <button class="btn btn-info" type="button" > <i class="fa fa-sliders"></i></button>
                        <div class="dropdown-content" align="left">
                            @foreach($config_create as $index => $lista)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" onclick="ConfiguracionSelector(this)"  id="{{$lista['id_input']}}" 
                                @foreach($config as $confi_create_blade) 
                                    @if($confi_create_blade->nombre== $lista["nombre"] && $confi_create_blade->estado=='1') 
                                        checked 
                                    @endif 
                                @endforeach>
                                <label class="form-check-label" for="{{$lista['id_input']}}">  {{$lista["input_value"]}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox">
            <div class="ibox-content">
                <form action="{{route('cotizacion.store_factura',$moneda->id)}}"  enctype="multipart/form-data" method="post" id="coti_store_Fac">
                    @csrf
                    @method('put')
                    {{-- Cabecera --}}
                    <div class="row">
                        <div class="col-sm-4 text-left" align="left">
                            <address class="col-sm-4" align="left">
                                <img src="{{asset('img/logos/'.$empresa->foto)}}" alt="" width="300px">
                            </address>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <div class="form-control" align="center" style="height: auto;">
                                <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                <h2 style="font-size: 19px">COTIZACIÓN ELECTRÓNICA</h2>
                                <h5 id="n_factura">{{$cotizacion_numero}}</h5>
                                <h5 id="n_boleta" style="display: none;">{{$cotizacion_numero_boleta}}</h5>
                                <h5 id="n_nota_v" style="display: none;">{{$cotizacion_numero_n_venta}}</h5>
                                {{-- <input type="text" name="fecha_emision" class="form-control" value="{{date("d-m-Y")}}" readonly="readonly"> --}}
                            </div>
                        </div>
                    </div>
                    {{-- Cabecera new --}}
                    <div class="form-group row">
                        {{-- Clientes --}}
                        <label class="col-sm-1 col-form-label">Cliente:</label>
                        <div class="col-sm-5">
                            <select class="select2_demo_client" name="cliente" id="cliente" required=""></select>
                        </div>
                        {{-- Tipo de Cotizacion --}}
                        <label  class="col-sm-1 col-form-label">T.Cotización:</label>
                        <div class="col-sm-5 col-form-label" style="padding-bottom: 0px !important" >
                            <div class="radio">
                                <input type="radio" name="tipo_coti" id="radio1" value="1" checked="" class="radio_factura" onchange="click_radio_factura()">
                                <label style="padding-right: 5px;" for="radio1">
                                    Factura &nbsp;
                                </label>
                                <input type="radio" name="tipo_coti" id="radio2" value="3" class="radio_boleta" onchange="click_radio_boleta()">
                                <label for="radio2">
                                    Boleta &nbsp;&nbsp;
                                </label>
                                <input type="radio" name="tipo_coti" id="radio3" value="4" class="radio_nota_v" onchange="click_radio_nota_v()">
                                <label for="radio3">
                                    Nota de V.
                                </label>
                            </div>
                        </div>
                        {{-- Validez --}}
                        <label id="validez_1" class="col-sm-1 col-form-label"  
                            @foreach($config as $confi_create_blade)  
                                @if($confi_create_blade->nombre=='validez_create' && $confi_create_blade->estado=='0')  
                                    hidden="hidden" 
                                @endif  
                            @endforeach>
                            Validez:
                        </label>
                        <div id="validez_2" class="col-sm-5" 
                            @foreach($config as $confi_create_blade)  
                                @if($confi_create_blade->nombre=='validez_create' && $confi_create_blade->estado=='0') 
                                    hidden="hidden" 
                                @endif  
                            @endforeach>
                            <select  class="form-control" name="validez" required="required">
                                @foreach($validez as $validezz) <option value="{{$validezz->descripcion}}">{{$validezz->descripcion}}</option> @endforeach
                            </select>
                        </div>
                        {{-- Garantía --}}
                        <label id="garantia_1" class="col-sm-1 col-form-label" 
                            @foreach($config as $confi_create_blade)  
                                @if($confi_create_blade->nombre=='garantia_create' && $confi_create_blade->estado=='0')  
                                    hidden="hidden" 
                                @endif  
                            @endforeach>
                            Garantía:
                        </label>
                        <div id="garantia_2" class="col-sm-5"  
                            @foreach($config as $confi_create_blade)  
                                @if($confi_create_blade->nombre=='garantia_create' && $confi_create_blade->estado=='0')  
                                    hidden="hidden" 
                                @endif  
                            @endforeach>
                            <select class="form-control" name="garantia">
                                @foreach($garantia as $garantias) 
                                    <option value="{{$garantias->descripcion}}">{{$garantias->descripcion}}</option> 
                                @endforeach
                            </select>
                        </div>
                        {{-- Comision --}}
                        <label id="personalcomision_1"  class="col-sm-1 col-form-label"
                            @foreach($config as $confi_create_blade)  
                                @if($confi_create_blade->nombre=='personalcomision_create' && $confi_create_blade->estado=='0')  
                                    hidden="hidden" 
                                @endif  
                            @endforeach>
                            Comisionista:
                        </label>
                        <div class="col-sm-5" id="personalcomision_2"  
                            @foreach($config as $confi_create_blade) 
                                @if($confi_create_blade->nombre=='personalcomision_create' && $confi_create_blade->estado=='0') 
                                    hidden 
                                @endif 
                            @endforeach>
                            <input list="browsersc2" class="form-control" id="comisionista" name="comisionista" required value="Sin comision - 0" onkeyup="comision()" autocomplete="off">
                            <datalist id="browsersc2" >
                                <option id="">Sin comision - 0 </option>
                                @foreach($p_venta as $p_ventas)
                                    <option id="{{$p_ventas->id}}">{{$p_ventas->cod_vendedor}} - {{$p_ventas->personal->personal_l->nombres}} - <span style="color: red">{{$p_ventas->comision}}</span></option>
                                @endforeach
                            </datalist>
                        </div>
                        {{-- Forma de pago --}}
                        <label  id="forma_pago_1" class="col-sm-1 col-form-label"
                            @foreach($config as $confi_create_blade) 
                                @if($confi_create_blade->nombre=='forma_pago_create' && $confi_create_blade->estado=='0') 
                                    hidden 
                                @endif 
                            @endforeach>
                            F. Pago:
                        </label>
                        <div class="col-sm-5" id="forma_pago_2" 
                            @foreach($config as $confi_create_blade) 
                                @if($confi_create_blade->nombre=='forma_pago_create' && $confi_create_blade->estado=='0') 
                                    hidden 
                                @endif 
                            @endforeach>
                            <select class="form-control" name="forma_pago" required="required">
                                @foreach($forma_pagos as $forma_pago) 
                                    <option value="{{$forma_pago->id}}">{{$forma_pago->nombre}} </option> 
                                @endforeach
                            </select>
                        </div>
                        {{-- Moneda --}}
                        <label id="moneda_1" class="col-sm-1 col-form-label"
                            @foreach($config as $confi_create_blade) 
                                @if($confi_create_blade->nombre=='moneda_create' && $confi_create_blade->estado=='0') 
                                    hidden 
                                @endif 
                            @endforeach>
                            Moneda:
                        </label>
                        <div class="col-sm-5" id="moneda_2" 
                            @foreach($config as $confi_create_blade) 
                                @if($confi_create_blade->nombre=='moneda_create' && $confi_create_blade->estado=='0') 
                                    hidden 
                                @endif 
                            @endforeach >
                            <div class="row" >
                                <input type="hidden" name="almacen" id="almacen_id" class="form-control " value="{{$sucursal->id}}" readonly="readonly">
                                <input type="hidden" id="moneda_id" class="form-control " value="{{$moneda->id}}" readonly="readonly">
                                <div class="col-sm-5" style="margin-top: 0px !important" >
                                    <input type="text" name="moneda" id="moneda_nam" class="form-control " value="{{$moneda->nombre}}" readonly="readonly">
                                </div>

                                <div class="col-sm-5 button_money" style="margin-top: 0px !important">
                                    <button style="height: 35px;width: auto" type="button" class='money_change btn btn-info' id="button_changeMoney" onclick="changeMoney()">
                                        @if($moneda->tipo=='nacional')Dolares
                                        @elseif($moneda->tipo=='extranjera')Soles
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- Tipo de Operacion --}}
                        <label id="tipo_operacion_1" class="col-sm-1 col-form-label"
                            @foreach($config as $confi_create_blade) 
                                @if($confi_create_blade->nombre=='tipo_operacion_create' && $confi_create_blade->estado=='0') 
                                    hidden 
                                @endif 
                            @endforeach >
                            T.Operación:
                        </label>
                        <div class="col-sm-5" id="tipo_operacion_2" 
                            @foreach($config as $confi_create_blade) 
                                @if($confi_create_blade->nombre=='tipo_operacion_create' && $confi_create_blade->estado=='0') 
                                    hidden 
                                @endif 
                            @endforeach>
                            <select class="form-control" name="tipo_operacion" >
                                @foreach($tipo_operacion as $t_op)
                                <option id="{{$t_op->id}}">{{$t_op->codigo}} - {{$t_op->informacion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Observacion --}}
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label">Observación:</label>
                        <div class="col-sm-11">
                            <textarea class="form-control" name="observacion" id="observacion" rows="2">Emitimos la siguiente Factura a vuestra solicitud</textarea>
                        </div>
                    </div>
            {{-- Cabecera new --}}



            <div id="resultado_moneda"></div>

            <div class="table-responsive">
                <table cellspacing="0" class="table tables" id="inp_s">
                    <thead>
                        <tr>
                            <th style="min-width: 10px"></th>
                            <th style="width: 500px">Artículo</th>
                            <th style="min-width: 80px">Stock</th>
                            <th style="min-width: 80px">Cantidad</th>
                            <th>Precio</th>
                            <th>Dcto</th>
                            <th>PU. Dcto.</th>
                            <th>PU. Com.</th>
                            <th>Total</th>
                            <th>Total IGV</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <button type="button" class='delete borrar e btn btn-danger'> <i class="fa fa-trash" aria-hidden="true"></i> </button>
                            </td>
                            <td class="td_selected">
                                <select class="monto0 select2_demo_3 select_change" required="" id="articulo" onchange="ajax(0)" autocomplete="off"></select>
                                <textarea type='text' id='descripcion0' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" autocomplete="off" style="margin-top: 5px;" ></textarea>
                                <input style="width: 76px" hidden="" type='text' id='tipo_afec0' name='tipo_afec[]' readonly="readonly" class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off"  />
                                <input hidden="hidden" class="celda" name="articulo[]" id="input_prod1" >
                            </td>
                            <td>
                                <input style="min-width: 80px;margin: 0px" type='text' id='stock0' readonly="readonly" name='stock[]' class="form-control" required autocomplete="off"/>
                            </td>
                            <td>
                                <input style="min-width: 80px" type='number' id='cantidad0' name='cantidad[]' max="" min="1" class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off" />
                            </td>
                            <td>
                                <input style="min-width: 85px" type='text' id='precio0' name='precio[]' readonly="readonly" class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off" />
                            </td>
                            <td>
                                <div style="position: relative;">
                                    <input class="text_des" type='text' id='descuento0' name='descuento[]' readonly="readonly" class="" required autocomplete="off"/>
                                </div>
                                <div  class="div_check">
                                    <input class="check" type='checkbox' id='check0' name='check[]' onclick="multi(0)" style="" autocomplete="off"/>
                                </div>
                                <input type='hidden' id='check_descuento0' name='check_descuento[]' class="form-control"  required >
                                <input type='hidden' id='promedio_original0' name='promedio_original[]' class="form-control" required >
                            </td>
                            <td>
                                <input style="min-width: 85px" type='text' id='precio_unitario_descuento0' name='precio_unitario_descuento[]' readonly="readonly" class="precio_unitario_descuento0 form-control"  required  autocomplete="off" />
                            </td>
                            <input type='hidden' name="comision[]" id='comision0'  readonly="readonly" class="form-control"  required  autocomplete="off" />
                            <td>
                                <input style="min-width: 85px" type='text' id='precio_unitario_comision0' name='precio_unitario_comision[]' readonly="readonly" class="form-control"  required autocomplete="off" />
                            </td>
                            <td>
                                <input style="min-width: 85px" type='text' id='total0' name='total' disabled="disabled" class="total form-control" required  autocomplete="off" />
                                <input type='text' id='afectacion0' name='afectacion' disabled="disabled" class="afectacion form-control" hidden="" required  autocomplete="off"/>
                            </td>
                            <td>
                                <input style="min-width: 85px" type='text' id='precio_unitario_igv0' name='precio_unitario_igv[]' readonly="readonly" class="form-control" required  autocomplete="off" />
                            </td>
                            <span id="spTotal"></span>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr style="background-color: #f5f5f500;" align="center">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Subtotal :</td>
                            <td colspan="3">
                                <input id='sub_total' disabled="disabled" class="form-control" required />
                                <input id='subtotal_gravado'  disabled="disabled"  hidden="" class="form-control" required />
                            </td>
                        </tr>
                        <tr style="background-color: #f5f5f500;" align="center">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>IGV :</td>
                            <td colspan="3"><input id='igv' disabled="disabled" class="form-control" required /></td>
                        </tr>
                        <tr align="center">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total :</td>
                            <td colspan="3"><input id='total_final' disabled="disabled" class="form-control" required /></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            &nbsp;
            <div class="row">
                <div class="col-sm-6" align="left">
                    <button type="button" class='addmore btn btn-success' disabled > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;
                </div>
                <div align="right" class="col-sm-6">
                    <button  data-style="zoom-out" class="guardar ladda-button btn btn-info " type="submit" >Guardar</button>
                    <button class="btn btn-warning  demo3 float-right" style="margin-left: 10px;" type="button"  >Guardar y Finalizar</button>
                    <button class="btn btn-secondary ladda-button finalizar " id="finalizar" hidden="" data-style="zoom-out" ></button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
<div id="loaderGif"></div>

<style>
    .col-form-label{margin-top: 15px!important;}
    .col-sm-5{margin-top: 15px!important;}
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
    .a{
        color: red
    }
    #loaderGif{
        background:url({{ asset('img/loading.gif') }}) 50% 50% no-repeat #000000a3;
        background-size: 250px;
        display: none;
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100vh;
        z-index: 20;
    }
    .not-active {
        pointer-events: none;
        cursor: default;
    }

    .dropdown {position: relative;display: inline-block;}
    .dropdown-content {display: none;position: absolute; right: 0; background-color: #f9f9f9; min-width: 200px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1;}
    .dropdown-content a {color: black; padding: 12px 16px; text-decoration: none; display: block;}
    .dropdown-content a:hover {background-color: #f1f1f1;}
    .dropdown:hover .dropdown-content {display: block;}
    .form-check{margin: 20px 12px;}
    .select2-hidden-accessible{
        width: 0px;
        margin: 0px;
        width: auto;
    }
    @media only screen and (max-width: 1497px){
        .td_selected > span.select2.select2-container.select2-container--default{
            width: 376px !important;
            min-width: 376px !important;
        }
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
<!-- Jquery Validate -->
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js')}}"></script>
<!-- Steps -->
<script src="{{ asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<!-- Sweet alert -->
<link href="{{ asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>

<script>
    function ajax_confi(parameters){
        var configuracion_seleccionado = parameters.id;
        $.ajax({
        type: "post",
        url: "{{ route('envio_confi_ingresos') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'tipo_configuracion': configuracion_seleccionado
            },
            success: function (msg) {
                // alert(msg);
            }
        });
    }

    function ConfiguracionSelector(parameters) {
        console.log(parameters.id);
        var configuracion_seleccionado = parameters.id;

        var data1 = document.getElementById(configuracion_seleccionado+"_1");
        var data2 = document.getElementById(configuracion_seleccionado+"_2");

        if( data1.hasAttribute("hidden") ){
            data1.removeAttribute("hidden", "");
            data2.removeAttribute("hidden", "");
            ajax_confi(parameters);
        }
        else{
            data1.setAttribute("hidden", "");
            data2.setAttribute("hidden", "");
            ajax_confi(parameters);
        }
    }
    $('.demo3').click(function () {
        if(document.forms['coti_store_Fac'].reportValidity()){
            swal({
                title: "¿Estas seguro que deseas Finalizar?",
                text: "Una vez Finalizado, No se podrá editar la Cotizacion",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3686ff",
                confirmButtonText: "Si, Finalizar",
                cancelButtonText: "Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        document.getElementById("finalizar").click();
                        swal("Cotizacion Finalizada", "", "success");
                    } else {
                        swal("Cancelado", "Cancelado la Finalizar", "error");
                    }
            });
        }else{

        }
    });
    $(document).ready(function (){
        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 8000 });
    });

    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    
    function mostrarMensaje(mensaje){
       $("#divmsg").empty(); //limpiar div
       $("#divmsg").append(mensaje);
       $("#divmsg").show(200);
    }
    $(".guardar").on('submit', function () {
        $(".demo3").attr('disabled', true);
        var data = `<input value="1" type='hidden' name='submit' class="form-control" required/>  <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
        $('#inp_s').append(data);
        
    });
    $(".finalizar").on('click', function () {
        var data = `<input value="2" type='hidden' name='submit' class="form-control" required/>   <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
        $('#inp_s').append(data);
        // $(".guardar").remove();
    });
</script>

{{-- Scripts realizados por el desarrollador --}}
<script type="text/javascript">

    // TODO Selección de cliente por medio de ajax para mostrar los datos del cliente en el formularios
    // $('').val();
    $(".select2_demo_client").select2({
        placeholder: "Seleccionar Cliente",
        ajax: {
            minimumInputLength: 1,
            url: "{{ route('pa.clients') }}",
            dataType: 'json',
            type: "POST",
            delay: 10,
            data: function (params) {
                var tipo_coti = $('[name="tipo_coti"]:checked').val();
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

    // TODO Validacion de formulario el no doble incerción
    function valida(f) {
        var boton=document.getElementById("boton");
        var completo = true;
        var incompleto = false;
        if( f.elements[0].value == "" )
            { alert(incompleto); }
        else{
            boton.type = 'button';
        }
    }

    //Creador para la agregacion de articulos (Productos-Servicios) en vista
    var i = 2;
    $(".addmore").on('click', function () {
        var data = `[
        <tr>
        <td>
        <button type="button" class='delete borrar e btn btn-danger'><i class="fa fa-trash" aria-hidden="true"></i></button>
        </td>";
        <td class="td_selected">
        <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="ajax(${i})"  autocomplete="off" required></select>
        <textarea type='text' id='descripcion${i}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" autocomplete="off" style="margin-top: 5px;"></textarea>
        <input type='text' style="min-width: 85px" id='tipo_afec${i}' name='tipo_afec[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" required hidden  autocomplete="off" />
        <input hidden="hidden"  class="celda"  name="articulo[]" id="input_prod${i}">
        </td>
        <td>
        <input type="" style="min-width: 85px"  id='stock${i}' name='stock[]' readonly="readonly" class="form-control" required autocomplete="off"/>
        </td>
        <td>
        <input type='number' style="min-width: 80px" max="" min="1" id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
        </td>
        <td>
        <input type='text' style="min-width: 85px"  id='precio${i}' name='precio[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
        </td>
        <td>
        <div style="position: relative;" >
        <input class="text_des"type='text' id='descuento${i}' name='descuento[]' readonly="readonly" class="" required onkeyup="multi(${i})"  autocomplete="off"/>
        </div>
        <div  class="div_check">
        <input class="check"  type='checkbox' id='check${i}' name='check[]' onclick="multi(${i})" style="" autocomplete="off"/>
        </div>
        <input style="min-width: 85px" type='hidden'id='check_descuento${i}' name='check_descuento[]'  class="form-control"  required >
        <input type='hidden' id='promedio_original${i}' name='promedio_original[]'  class="form-control"  required >
        </td>
        <td>
        <input type='text' id='precio_unitario_descuento${i}' style="min-width: 85px"  name='precio_unitario_descuento[]' readonly="readonly" class=" form-control"  required  autocomplete="off" />
        </td>
        <input type='hidden' name="comision[]" id='comision${i}' style="min-width: 85px"  readonly="readonly" class="form-control" required autocomplete="off" />
        <td>
        <input type='text' id='precio_unitario_comision${i}' style="min-width: 85px"  name='precio_unitario_comision[]' readonly="readonly" class="form-control" required autocomplete="off" />
        </td>
        <td>
        <input type='text' id='total${i}' style="min-width: 85px"  name='total' disabled="disabled" class="total form-control" required autocomplete="off"/>
        <input type='text' id='afectacion${i}' style="min-width: 85px" hidden  name='afectacion' disabled="disabled" class="afectacion form-control" required autocomplete="off"/>
        </td>
        <td>
        <input style="min-width: 85px" type='text' id='precio_unitario_igv${i}' name='precio_unitario_igv[]' readonly="readonly" class="form-control" required autocomplete="off" />
        <td>
        </tr>`;
        
        $('.tables').append(data);
        i++;
        //Llamada para la ejecucion de articlesSelect (funcionamiento de los select nuevos creados)
        articlesSelect2();

        var input_ds = [];
        var number_tot = document.getElementsByName('articulo[]').length;
        for( j = 0; j < number_tot; j++){
            input_ds[j]  = document.getElementsByName('articulo[]')[j].value;
            if(input_ds[j].indexOf("SERV-") == 4){
                $('option[value="'+input_ds[j]+'"]').prop("disabled", false);
            }else{
                $('option[value="'+input_ds[j]+'"]').prop("disabled", true);
            }
        };
        $(".addmore").prop("disabled", true);
        $(".borrar").prop("disabled", false);
        
    });

    //Llama predeterminada para el select articles (productos- servicios), se ejecuta al cargar la pagina
    $(document).ready(function() {
        articlesSelect2();
    });
    
    //Funcion para el select articles "AJAX" (productos- servicios), ejecutandose cada vez realizada una llamada
    function articlesSelect2() {
        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Articulo",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.articles') }}",
                dataType: 'json',
                type: "POST",
                // delay: 1500,
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term // search term 
                    };
                },
                processResults: function (data) {
                    //validador de articulos multiples
                    let data_length = data.length;
                    let articles_selected_ajax = document.getElementsByClassName("select2_demo_3");
                    let articles_selected_count_ajax = articles_selected_ajax.length; 
                    for(var z=0;z<articles_selected_count_ajax;z++){
                        var selected_ajax=document.getElementsByClassName("select2_demo_3 select_change")[z].value;
                        for(var y=0;y<data_length;y++){
                            if(selected_ajax == data[y].id+ " | " + data[y].codigo + " | " + data[y].codigo_original + " | " + data[y].nombre){
                                if(data[y].tipo == 'producto'){
                                    data[y].disabled=true;
                                }else{
                                    data[y].disabled=false;
                                }
                            }
                        }
                    }
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id:  item.id + " | " + item.codigo + " | " + item.codigo_original + " | " + item.nombre,
                                text: item.id + " | " + item.codigo + " | " + item.codigo_original + " | " + item.nombre,
                                disabled: item.disabled
                            };
                        })
                    };
                },
                cache: true,
                passive: true
            }
        });
    }

    // TODO funcion ajax para obtener los parametros requeridos de articulo (PRODUCTOS - SERVICIOS)
    function ajax (a){
        if(a==0){
            var articulo = document.getElementById(`articulo`).value;
            document.getElementById(`input_prod1`).value = articulo;
        }else{
            var articulo = document.getElementById(`articulo${a}`).value;
            document.getElementById(`input_prod${a}`).value = articulo;
        }

        var almacen = $('[id="almacen_id"]').val();
        var moneda = $('[id="moneda_id"]').val();
        $.ajax({
            type: "post",
            url: "{{ route('pa.description') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'articulo': articulo,
                'almacen': almacen,
                'moneda': moneda	
            },
            success: function (msg) {
                $(`#descripcion${a}`).val(msg.description);
                $(`#tipo_afec${a}`).val(msg.afectacion);
                $(`#precio${a}`).val(msg.price);
                $(`#cantidad${a}`).val(1);
                $(`#precio_unitario_descuento${a}`).val(msg.price);
                $(`#promedio_original${a}`).val(msg.average);
                $(`#stock${a}`).val(msg.amount);
                $(`#descuento${a}`).val(msg.discount);
                $(`#check_descuento${a}`).val(0);
                $(`#cantidad${a}`).attr('max', msg.amount );
                $(`#cantidad`).attr('max', msg.amount );
                var separador=" ";
                var comision=document.querySelector(`#comisionista`).value;
                //revirtiendo la cadena
                var reverse9=reverseString(comision);//devuelve toda la cadena articulo al reves
                //para comision
                var comision_v_r=reverse9.split(separador,1); //devuelve el precio en objeto al revez
                var comision_r=comision_v_r[0];//obtiene el precio del objeto [0] al revez
                var comision_v =reverseString(comision_v_r[0]);//convierte el precio al revez a la normalidad
                if(comision){
                    document.getElementById(`comision${a}`).value = comision_v;
                }else{
                    document.getElementById(`comision${a}`).value = 0;
                }
                multi(a);
                $(`.addmore`).prop("disabled", false);
            },
            error: function(eject) {
                if(eject.status===400){
                    console.log(eject.responseJSON.error);
                }
            },
            cache:true
        });
    }
    //Funcion de comision 
    function comision(){
        var comision=document.querySelector(`#comisionista`).value;
        var separador=" ";
        //revirtiendo la cadena
        var reverse9=reverseString(comision);//devuelve toda la cadena articulo al reves
        //para comision
        var comision_v_r=reverse9.split(separador,1); //devuelve el precio en objeto al revez
        var comision_r=comision_v_r[0];//obtiene el precio del objeto [0] al revez
        var comision_v =reverseString(comision_v_r[0]);//convierte el precio al revez a la normalidad
        var campos_num = document.getElementsByClassName("total").length;

        document.getElementById(`comision0`).value = comision_v;

        if(campos_num!=1){
            for(var i=2;i<=campos_num;i++){
                document.getElementById(`comision${i}`).value = comision_v;
            }
        }
        multi(0);
        if(campos_num!=1){
            for(var i=2;i<=campos_num;i++){
                multi(i);
            }
        }
    }

    //Función para el calculo de los totales de cada articulo y para los totales de la factura
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

        // Get the checkbox
        var checkBox = document.getElementById(`check${a}`);
        var cantidad = document.querySelector(`#cantidad${a}`).value;
        var promedio_origina_descuento1=document.querySelector(`#precio_unitario_descuento${a}`).value;
        var promedio_original2=document.querySelector(`#promedio_original${a}`).value;
        var cantidad_desc = document.getElementById(`check_descuento0${a}`)
        var descuento = document.querySelector(`#descuento${a}`).value;
        var afec = document.querySelector(`#tipo_afec${a}`).value;
        var precio = document.querySelector(`#precio${a}`).value;
        var comision_porcentaje=document.querySelector(`#comision${a}`).value;
        var multiplier = 100;
        var igv_valor={{$igv->renta}};
        // Con DESCUENTO
        if (checkBox.checked == true && descuento > 0 ){
            // SACADA DE DESCUENTO PRIMERO
            var precio_uni = precio - (promedio_original2*(descuento/100));
            var precio_uni_dec=Math.round(precio_uni * multiplier) / multiplier;
            document.getElementById(`check_descuento${a}`).value = descuento;
            document.getElementById(`precio_unitario_descuento${a}`).value = precio_uni_dec;
            //SACADA DE COMISION
            var comisiones_base_uni = parseFloat(precio_uni_dec)+ parseFloat(precio_uni_dec)*(comision_porcentaje/100);
            var comisiones_red = Math.round(parseFloat(comisiones_base_uni)*multiplier)/multiplier;
            document.getElementById(`precio_unitario_comision${a}`).value = comisiones_red;
            var total_sin_igv = parseFloat(comisiones_red)*cantidad;
            document.getElementById(`total${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
            // IGV POR GRAVADO O EXONERADO
            if(afec.toString() == "Gravado"){
                //SACA IGV
                var igv = (parseFloat(comisiones_red)*(igv_valor/100));
                var igv_decimal = Math.round(igv * multiplier) / multiplier;  
                var final_igv_round = parseFloat(comisiones_red) + parseFloat(igv_decimal);
                var tot_tot =  final_igv_round * cantidad;
                // TOTAL PRECIO UNITARIO
                document.getElementById(`afectacion${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
                // TOTAL PRECIO ALL
                document.getElementById(`precio_unitario_igv${a}`).value = Math.round(tot_tot * multiplier) / multiplier;
            }else{
                // TOTAL PRECIO UNITARIO
                document.getElementById(`afectacion${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
                // TOTAL PRECIO ALL
                document.getElementById(`precio_unitario_igv${a}`).value = total_sin_igv;
            }
        }else{
            document.getElementById(`check_descuento${a}`).value = 0;
            document.getElementById(`precio_unitario_descuento${a}`).value = precio;
            //SACADA DE COMISION
            var comisiones_base_uni = parseFloat(precio) + parseFloat(precio)*(comision_porcentaje/100);
            var comisiones_red = Math.round(parseFloat(comisiones_base_uni) * multiplier)/multiplier;
            document.getElementById(`precio_unitario_comision${a}`).value = comisiones_red;
            var total_sin_igv = parseFloat(comisiones_red)*cantidad;
            document.getElementById(`total${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
            // IGV POR GRAVADO O EXONERADO
            if(afec.toString() == "Gravado"){
                //SACA IGV

                var igv = total_sin_igv*(igv_valor/100); 
                var igv_decimal = Math.round(igv * multiplier) / multiplier;
                var end=parseFloat(total_sin_igv) + igv_decimal;
                var final_igv_round = Math.round(end * multiplier) / multiplier;

                // TOTAL PRECIO UNITARIO
                document.getElementById(`afectacion${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
                // TOTAL PRECIO ALL
                document.getElementById(`precio_unitario_igv${a}`).value = Math.round(final_igv_round * multiplier) / multiplier;
            }else{
                // TOTAL PRECIO UNITARIO
                document.getElementById(`afectacion${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
                // TOTAL PRECIO ALL
                document.getElementById(`precio_unitario_igv${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
            }
        }
        var totalInp = $('[name="total"]');
        var total_t = 0;

        totalInp.each(function(){
            total_t += parseFloat($(this).val());
        });

        var multiplier2 = 100;
        var total_tt = Math.round(total_t * multiplier2) / multiplier2;

        $('#sub_total').val(total_tt);

        //SOLO GRAVADO
        var totalInpG = $('[name="afectacion"]');
        var total_tg = 0;

        totalInpG.each(function(){
            total_tg += parseFloat($(this).val());
        });

        var multiplier3 = 100;
        var total_ttg = Math.round(total_tg * multiplier3) / multiplier3;

        $('#subtotal_gravado').val(total_ttg);

        var subtotal = document.querySelector(`#sub_total`).value;
        var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;
        
        var igv_valor={{$igv->renta}};
        
        var igv=subtotal_gravado*igv_valor/100; 
        var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
        var end=parseFloat(subtotal) + igv_decimal;
        var end2 = Math.round(end * multiplier2) / multiplier2;

        document.getElementById("igv").value = igv_decimal;
        document.getElementById("total_final").value = end2;
    }

    //Funcion para revertir un string dado
    function reverseString(str) {
        return str.split("").reverse().join("");;
    }

    //Función de borrado de fila de articulos (Producto-Servicio)
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        var input_text_opt = fila.find('input[class="celda"]').val();
        $('option[value="'+input_text_opt+'"]').prop("disabled", false);
        $(".addmore").prop("disabled", false);
        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Item",
        });
        // ELIMINAR TR
        if (e>1) {
            fila.closest('tr').remove();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
        }else{
            $(".borrar").prop("disabled", true);
            $(".addmore").prop("disabled", false);
        }
        var multiplier = 100;
        var totalInp = $('[name="afectacion"]');
        var total_t = 0;

        totalInp.each(function(){
            total_t += parseFloat($(this).val());
        });

        $('#subtotal_gravado').val(total_t);
        //GRAVADO
        var totalInpG = $('[name="total"]');
        var total_tt = 0;

        totalInpG.each(function(){
            total_tt += parseFloat($(this).val());
        });
        $('#sub_total').val(total_tt);

        var igv_valor=({{$igv->renta}});
        var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;
        var subtotal = document.querySelector(`#sub_total`).value;
        var igv_val=parseFloat(subtotal_gravado)*igv_valor/100;
        var igv = Math.round(igv_val * multiplier) / multiplier;
        var end_2=parseFloat(igv)+parseFloat(subtotal);
        var end = Math.round(end_2 * multiplier) / multiplier;

        document.getElementById("igv").value = igv;
        document.getElementById("total_final").value = end;
        articlesSelect2();
    });

    function click_radio_nota_v(){
        if ($('input[class=n_nota_v]:radio:checked').length == 0) {
            document.getElementById("n_nota_v").style.display = "block";
            document.getElementById("n_boleta").style.display = "none";
            document.getElementById("n_factura").style.display = "none";
            $(".a").select2("val", "");
        }
        
    }
    function click_radio_boleta(){
        if ($('input[class=n_boleta]:radio:checked').length == 0) {
            document.getElementById("n_factura").style.display = "none";
            document.getElementById("n_nota_v").style.display = "none";
            document.getElementById("n_boleta").style.display = "block";
            $(".select2_demo_client").select2("val", "");
        }
        
    }
    function click_radio_factura(){
        if ($('input[class=n_factura]:radio:checked').length == 0) {
            document.getElementById("n_boleta").style.display = "none";
            document.getElementById("n_nota_v").style.display = "none";
            document.getElementById("n_factura").style.display = "block";
            $(".select2_demo_client").select2("val", "");
        } 
    }   

    // TODO Script para cambiar por moneda
    let status=0;
    function changeMoney() {
        $.ajax({
            type: "post",
            url: "{{ route('pa.money') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'status': status,
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
                //Cambio de moneda
                console.log('a');
                // document.getElementById("moneda_id").value = msg.id;
                // document.getElementById("moneda").value = msg.nombre;
                $('[id="moneda_id"]').val(msg.id);
                $('[id="moneda_nam"]').val(msg.nombre);
                $(`#button_changeMoney`).html(msg.other);
                if(status==1){
                    status=0;
                }else{
                    status=1;
                }
                $('#loaderGif').hide(); 
                let articles_selected = document.getElementsByClassName("select2_demo_3");
                let articles_selected_count = articles_selected.length;
                for(let z=0;z<articles_selected_count;z++){
                    let selected=document.getElementsByClassName("select2_demo_3 select_change")[z].getAttribute('id');
                    if(selected=='articulo'){
                        ajax(0); 
                    }else{
                        ajax(selected.substring(8)); 
                    }
                }    
                disabled_money();
            },
        });
    }

    $(document).on({
        ajaxStart: function(){
            $("body").addClass("loading"); 
        },
        ajaxStop: function(){ 
            $("body").removeClass("loading"); 
        }    
    });

    jQuery.event.special.touchstart = {
        setup: function( _, ns, handle ) {
            this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
        }
    };
    jQuery.event.special.touchmove = {
        setup: function( _, ns, handle ) {
            this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
        }
    };
    jQuery.event.special.wheel = {
        setup: function( _, ns, handle ){
            this.addEventListener("wheel", handle, { passive: true });
        }
    };
    jQuery.event.special.mousewheel = {
        setup: function( _, ns, handle ){
            this.addEventListener("mousewheel", handle, { passive: true });
        }
    };

    function disabled_money(){
        $(`.money_change`).prop('disabled', true);
        $(`.button_money`).addClass('not-active');

        setTimeout(function(){
            $(`.money_change`).prop('disabled', false);
            $(`.button_money`).removeClass('not-active');
        }, 10000);
    }

</script>        
@stop