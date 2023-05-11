@extends('layout')
@section('title', 'Factura Manual')
@section('atributo_actu', 'hidden')
@section('href_accion', route('facturacion_manual.index'))
@section('value_accion', 'Inicio')
@extends('layout_agregado_rapido')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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

{{-- @section('form_action_modal_cliente',  route('agregado_rapido.cliente_cotizado')) --}}
{{-- @section('ruta_retorno', 'facturacion') --}}
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
                                        <h3 id="codigo_fac_manual">{{$factura_numero}}</h3>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Cliente</td><td>:</td>
                                    <td>
                                        <select class="select2_demo_client" name="cliente" id="cliente" required=""></select>
                                    </td>
                                    <td>Almacen</td><td>:</td>
                                    <td>
                                        <select class="select2_demo_almacen" name="almacen_id_selec" required=""  onchange="codigo_numero()">
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
                                                        <strong style="font-size:11px">La suma de las cuotas es diferente del monto total</strong>
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
                                                                <input type="date" name="fecha_pago[]" id="fecha_pago0"  class="fecha_pago form-control" min="{{$fecha_1}}" >
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <label>Monto:</label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="input-group mb-3" style="padding-right:15px">
                                                                    <div class="input-group-prepend">

                                                                    </div>
                                                                    <input type="text" name="monto_pago[]" id="monto_pago0" class="monto_pago form-control"  onkeypress="return filterFloat(event,this);" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label ><button type="button"  aria-hidden="true" id="add_pago" class="add_pago btn btn-success"><i class="fa fa-plus-square-o fa-lg" > </i></button></label>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="display: block">
                                                    <div class="row">
                                                        <div class="col-sm-6" style="">
                                                            <label for=""><strong>Precio Total: &nbsp;</strong>{{$moneda->simbolo}}&nbsp;</label><label id="cuotas_footer"></label>
                                                        </div>
                                                        <div class="col-sm-6" align="right">
                                                            <button type="button" id="button_cuotas_save" class="btn btn-primary">Guardar</button>
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
                                        <div class="row">
                                            <input type="hidden" name="almacen" id="_selec" class="form-control " value="{{$sucursal->id}}" readonly="readonly">
                                            <input type="hidden" id="moneda_id" class="form-control " value="{{$moneda->id}}" readonly="readonly">
                                            <div class="col-sm-5">
                                                <input type="text" name="moneda" id="moneda" class="form-control " value="{{$moneda->nombre}}" readonly="readonly">
                                            </div>

                                            <a class="col-sm-5 button_money" onclick="changeMoney()">
                                                <button style="height: 35px;width: auto" type="button" class='money_change btn btn-info' id="button_changeMoney">
                                                    @if($moneda->tipo=='nacional')
                                                        Dolares 
                                                    @elseif($moneda->tipo=='extranjera') 
                                                        Soles 
                                                    @endif
                                                </button>
                                            </a>
                                        </div>
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
                        <div class="table-responsive">
                            {{-- <div  > --}}
                                <table cellspacing="0" class="table tables  " >
                                    <thead>
                                        <tr>
                                            <th style="width: 10px"></th>
                                            <th >Articulo</th>
                                            <th style="width:100px">Cantidad</th>
                                            <th style="width:100px">P.Sugerido</th>
                                            <th style="width:100px">Precio s/Igv</th>
                                            <th style="width:100px">Precio c/Igv</th>
                                            <th style="width:100px">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <button type="button" class='delete borrar e btn btn-danger'> <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                            </td>
                                            <td class="td_selected">
                                                <select class="monto0 select2_demo_3 select_change" required="" id="articulo" onchange="ajax(0)" autocomplete="off"></select>
                                                <textarea  type='text' {{-- id='descripcion0' --}}  name='descripcion_item[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                                                <textarea type='text' id='numero_serie0'  name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px;" placeholder="N° de Serie"></textarea>
                                                <input style="min-width: 100px" hidden="" type='text' id='tipo_afec0' name='tipo_afec[]' readonly="readonly" class="monto0 form-control" onkeyup="multi(0)" autocomplete="off"  />
                                                <input type="hidden" class="celda"  name="articulo[]" id="input_prod1" >
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='text' id='cantidad0' name='cantidad[]' max="" class="monto0 form-control inp"  onkeyup="multi(0)"  required  autocomplete="off"/>
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='text' id='precio_oficial0' name='precio_oficial[]' ondblclick="copy(0)"  class="precio_oficial0 form-control inp" required readonly  data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)"/>
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='number' step="0.0000001" id='precio0' name='precio[]'  class="monto0 form-control inp" onkeyup="multi_s_igv(0),multi(0)" required  autocomplete="off" />
                                                <input hidden type='text' id='precio_s_igv_float0' name='precio_s_igv_float'  class="precio_s_igv_float form-control" onkeyup="multi_s_igv(0),multi(0)" required  autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='number' step="0.0000001" id='precio_c_igv0' name='precio_c_igv[]'  class="precio_c_igv monto0 form-control inp" onkeyup="multi_c_igv(0),multi(0)" required  autocomplete="off" />
                                            </td> 
                                            <td>
                                                <input style="min-width: 100px"  type='number' id='total0' name='total' disabled="disabled" class="total form-control inp" required  autocomplete="off" />
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
                                            <td>Subtotal :</td>
                                            <td colspan="2">
                                                <input id='sub_total' type="number" name="sub_total_sin_igv" readonly class="form-control inp" required />
                                                <input id='subtotal_gravado' type="text" name="subtotal_gravado" readonly class="form-control inp" required hidden="" />
                                            </td>
                                        </tr>
                                        <tr style="background-color: #f5f5f500;" align="center">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>IGV :</td>
                                            <td colspan="2">
                                                <input id='igv' type="number" disabled="disabled" class="form-control inp" required />
                                            </td>
                                        </tr>
                                        <tr align="center">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total :</td>
                                            <td colspan="2"><input id='total_final' type="number" name="costo_total"  readonly="readonly" class="form-control inp" required /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            {{-- </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                
                                <button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;
                            </div>
                            <div class="col-sm-6 ">
                                <button type="button" name="name" value="pdf" class="ladda-button btn btn-info float-right" id="boton"  style="margin-right: 5px">Enviar</button>
                                <button id="button_submit" hidden type="submit">Button DB</button>
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
    .slimScrollBar{
        display: none !important;
    }
    #loaderGif{
        /* background:url({{ asset('img/loading.gif') }}) 50% 50% no-repeat #000000a3; */
        background-size: 250px;
        display: none;
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100vh;
        z-index: 20;
    }
    @media only screen and (max-width: 1497px){
        .td_selected > span.select2.select2-container.select2-container--default{
            min-width: 376px !important;
        }
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

<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

<script type="text/javascript">
    $(".select2_demo_3").select2({
        placeholder: "Seleccionar Producto",
    });
</script>


<script type="text/javascript">
    $(".select2_demo_almacen").select2({
        placeholder: "Seleccionar Almacen",
    });
</script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function toggle(){
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    }
</script>



{{-- Validar Formulario / No doble insercion de datos(Gente desesperado) --}}
<script>
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
                var tipo_coti = 1;
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
                    <button type="button" class='delete borrar e btn btn-danger'><i class="fa fa-trash" aria-hidden="true"></i></button>
                </td>
                <td class="td_selected">
                    <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="ajax(${i})" autocomplete="off" required></select>
                    <textarea type='text' {{-- id='descripcion${i}'--}}   name='descripcion_item[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                    <textarea type='text' id='numero_serie${i}' placeholder="N° de Serie" name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                    <input type="hidden" class="celda"  name="articulo[]" id="input_prod${i}" >
                </td>
                <td>
                    <input type='text' style="min-width: 100px"  id='cantidad${i}' name='cantidad[]' class="monto${i} form-control inp" onkeyup="multi(${i})" required  autocomplete="off"/>
                </td>
                <td class="full-height-scroll tooltip-demo">
                    <input type='text' style="min-width: 100px"  id='precio_oficial${i}' name='precio_oficial[]' ondblclick="copy(${i})" class="precio_oficial${i} form-control inp" required  autocomplete="off" readonly data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)" />
                </td>
                <td>
                    <input type='number' style="min-width: 100px"step="0.0000001"  id='precio${i}' onchange="change(${i})" name='precio[]' class="monto${i} form-control inp" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off"/>
                    <input hidden type='text' id='precio_s_igv_float${i}' name='precio_s_igv_float'  class="precio_s_igv_float form-control" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off" />
                </td>
                <td>
                    <input style="min-width: 100px" type='number' step="0.0000001"id='precio_c_igv${i}' name='precio_c_igv[]'  class="precio_c_igv p_inp monto${i} form-control inp" onkeyup="multi_c_igv(${i}),multi(${i})" required  autocomplete="off" />
                </td>
                <td>
                    <input type='number' id='total${i}'  style="min-width: 100px"  name='total' disabled="disabled" class="total form-control inp"  required  autocomplete="off"/>
                </td>
            </tr>
        `;
        $('.tables').append(data);
        i++;

        //Llamada para la ejecucion de articlesSelect (funcionamiento de los select nuevos creados)
        articlesSelect2();
        toggle();

        $(".addmore").prop("disabled", true);
        // $(".borrar").prop("disabled", false);
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
                        search: params.term, // search term 
                        almacen: 0,
                        tipo_doc: 'manual' 
                    };
                },
                processResults: function (data) {
                    //validador de articulos multiples
                    let data_length = data.length;
                    let articles_selected_ajax = document.getElementsByClassName("select2_demo_3");
                    let articles_selected_count_ajax = articles_selected_ajax.length; 
                    // for(var z=0;z<articles_selected_count_ajax;z++){
                    //     var selected_ajax=document.getElementsByClassName("select2_demo_3 select_change")[z].value;
                    //     for(var y=0;y<data_length;y++){
                    //         if(selected_ajax == data[y].id+ " | " + data[y].codigo + " | " + data[y].codigo_original + " | " + data[y].nombre){
                    //             if(data[y].tipo == 'producto'){
                    //                 data[y].disabled=true;
                    //             }else{
                    //                 data[y].disabled=false;
                    //             }
                    //         }
                    //     }
                    // }
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

    //Funcion Copiar
    function copy(a){
        if(a==0){
            var copy = document.getElementById(`precio_oficial0`).value;
            document.getElementById(`precio0`).value = copy;
            multi_s_igv(0);
        }else{
            var copy = document.getElementById(`precio_oficial${a}`).value;
            document.getElementById(`precio${a}`).value = copy;
            multi_s_igv(a);
        }
        multi(a);
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
                if(msg.price == 0 && msg.amount == 0){
                    // $(`#precio${a}`).val(0);
                    $(`#cantidad${a}`).val(0);
                    $(`#cantidad${a}`).attr('max', msg.amount );
                    $(`#cantidad`).attr('max', msg.amount );
                    $(`#precio_oficial${a}`).val(msg.price)
                }else{
                    // $(`#precio${a}`).val(1);
                    $(`#precio_oficial${a}`).val(msg.price)
                    $(`#cantidad${a}`).val(1);
                    // $(`#cantidad${a}`).attr('max', msg.amount );
                    // $(`#cantidad`).attr('max', msg.amount );
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

    
    function multi(a){
        var igv = 18.00;
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
        var final= precio * cantidad;
        var final_decimal = Math.round(final * multiplier) / multiplier;

        document.getElementById(`precio_s_igv_float${a}`).value = final_decimal;
        var only_igv = final + ( parseFloat(final) * ( igv / multiplier) );
        var igv_decimal = Math.round(only_igv * multiplier ) / multiplier;
        document.getElementById(`total${a}`).value = igv_decimal;

         // Operacion para subtotal sin igv
         var sub_igv = $('[name="precio_s_igv_float"]');
        var sub_igv_t = 0;
        sub_igv.each(function(){
            sub_igv_t += parseFloat($(this).val());
        });        
        var sub_igv_tt = Math.round(sub_igv_t * multiplier) / multiplier;
        $('#sub_total').val(sub_igv_tt);
        document.getElementById("sub_total").value = sub_igv_tt;

        //OPERACION PARA CALULCAR EL IGV
        var only_igv = (parseFloat(sub_igv_tt) * (igv/multiplier)) 
        var igv_decimal = Math.round(only_igv * multiplier ) / multiplier;
        document.getElementById("igv").value = igv_decimal;

        var end = igv_decimal+parseFloat(sub_igv_tt);
        var end2 = Math.round(end * multiplier) / multiplier;
       // Operacion para total
        // var totalInp = $('[name="total"]');
        // var total_t = 0;
        // totalInp.each(function(){
        //     total_t += parseFloat($(this).val());
        // });
        // console.log(total_t);
        // var multiplier2 = 100;
        var total_tt = sub_igv_tt+ end2;
        
        $('#total').val(total_tt);

        // var subtotal = document.querySelector(`#total`).value;
        document.getElementById("total_final").value = end2;


        var monto_c = document.getElementsByClassName('monto_pago');

        var inp_mont = document.getElementsByClassName('monto_pago').length;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (end2/inp_mont)
            document.getElementById("monto_pago0").value = Math.round(end2 * multiplier)/ multiplier;
            
        }
        $("#cuotas_footer").html(end2);
    }
    $(document).on('click','#button_cuotas_save', function(event){
            
        var monto_c = document.getElementsByClassName('monto_pago');
        var monto_fc = document.getElementsByClassName('fecha_pago');
        console.log(monto_c)
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        var total =  $("#cuotas_footer").html();
        var fin = 0.00;
        var comp = 0;
        for (var i = 0; i < inp_mont; i++) {
            fin = parseFloat(fin) + parseFloat(monto_c[i].value);
        }
        var fin_r = Math.round(fin * 100) / 100;
        console.log(total);
        for (var i = 0; i < inp_mont; i++) {
            var fecha = monto_fc[i].id;
            var monto = monto_c[i].id;

            var input_text = document.getElementById(`${monto}`).value;
            var date_text = document.getElementById(`${fecha}`).value;
            if( input_text.length  == 0 || date_text.length  == 0){
                console.log("a");
                document.getElementById('alert_campos').style.display = "flex";                    
                mostrarMensaje();
                return;
            }
        }
        if(fin_r != total){
            document.getElementById('suma_campos').style.display = "flex";
        }else{
            console.log('e')
            $('#cuotas_modal').modal('hide')
        }
        mostrarMensaje();
        
    });
    function mostrarMensaje(){
            // $("#alert_campos").show(200);
            $("#alert_campos").hide(3000);
            $("#suma_campos").hide(3000);
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
            // $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
        }else{
            // $(".borrar").prop("disabled", true);
            $(".addmore").prop("disabled", false);
            $(".select2_demo_3").val(null).trigger("change");
            $(".inp").val(null);

        }
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
            var fin = (end2/inp_mont)
            document.getElementById("monto_pago0").value = Math.round(end2 * multiplier2)/ multiplier2;
        }
        articlesSelect2();
    });
  
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });

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
        
            var total = document.getElementById('total_final').value;
            var x = 1;
            $(".add_pago").on('click', function () {
                var total = document.getElementById('total_final').value;
                var data = `
                <div class="delete_modal${x} row">
                <div class="col-sm-1"><label>Fecha:</label></div>
                <div class="col-sm-4">
                <input type="date" name="fecha_pago[]" id="fecha_pago${x}" class="fecha_pago form-control" min="{{$fecha_1}}">
                </div>
                <div class="col-sm-1"><label>Monto:</label></div>
                <div class="col-sm-4">
                <div class="input-group mb-3" style="padding-right:15px">
                <div class="input-group-prepend">
                
                </div>
                <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}"    onkeypress="return filterFloat(event,this);" >
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
    
        $("#boton").on("click",function(buton){
            var forma_pago = $("#forma_pago option:selected").val();
            if(forma_pago == 2){
                var monto_c = document.getElementsByClassName('monto_pago');
                var monto_fc = document.getElementsByClassName('fecha_pago');
                var inp_mont = document.getElementsByClassName('monto_pago').length;
                var total =  $("#cuotas_footer").html();
                var fin = 0.00;
                var comp = 0;
                for (var i = 0; i < inp_mont; i++) {
                    fin = parseFloat(fin) + parseFloat(monto_c[i].value);
                }
                var fin_r = Math.round(fin * 100) / 100;
                // console.log(total);
                for (var i = 0; i < inp_mont; i++) {
                    var fecha = monto_fc[i].id;
                    var monto = monto_c[i].id;
        
                    var input_text = document.getElementById(`${monto}`).value;
                    var date_text = document.getElementById(`${fecha}`).value;
                    if( input_text.length  == 0 || date_text.length  == 0){
                        $('#cuotas_modal').modal('show');
                        document.getElementById('alert_campos').style.display = "flex";                    
                        setTimeout(mostrarMensaje, 3000);
                        return;
                    }
                }
                if(fin_r != total){
                    $('#cuotas_modal').modal('show');
                    document.getElementById('suma_campos').style.display = "flex";
                    setTimeout(mostrarMensaje, 3000);
                }else{
                    // console.log('e')
                    
                    document.getElementById('button_submit').click();
                }
            // buton.preventDefault();
            }else{
                document.getElementById('button_submit').click();
            }
        });

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
                $(`#moneda_id`).val(msg.id);
                $(`#moneda`).val(msg.nombre);
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
        function cerrar_but_rc(){
            document.getElementById('alert_campos').style.display = "none";
        }
        function cerrar_but_mt(){
            document.getElementById('suma_campos').style.display = "none";
        }

    var igv = {{$igv->renta}}
    var multiplier = 100;
    function multi_s_igv(a){
        var pr_s_igv = $(`#precio${a}`).val();
        $(`#precio_s_igv_float${a}`).val(pr_s_igv);
        var c_igv_s_redondeo = parseFloat(pr_s_igv)+(parseFloat(pr_s_igv)*igv/multiplier);
        var c_igv_redondeo = Math.round(c_igv_s_redondeo * multiplier)/multiplier;
        $(`#precio_c_igv${a}`).val(c_igv_redondeo);
    }

    function multi_c_igv(a){
        var pr_c_igv = $(`#precio_c_igv${a}`).val();
        var igv_dec = igv / multiplier ;
        var s_igv_s_base = parseFloat(pr_c_igv) / ( 1 + parseFloat(igv_dec));
        var s_igv_redondeo = Math.round(s_igv_s_base * multiplier) / multiplier;
        $(`#precio${a}`).val(s_igv_redondeo);
        $(`#precio_s_igv_float${a}`).val(s_igv_redondeo);
    }
    function disabled_money(){
        $(`.money_change`).prop('disabled', true);
        $(`.button_money`).addClass('not-active');

        setTimeout(function(){
            $(`.money_change`).prop('disabled', false);
            $(`.button_money`).removeClass('not-active');
        }, 10000);
    }
    
    function codigo_numero(){
        var almacen = $('.select2_demo_almacen').val();
        console.log(almacen);
        $.ajax({
            type: "post",
            url: "{{route('facturacion_manual.change_almacen_tipo')}}",
            data: {
                '_token': "{{ csrf_token() }}",
                'almacen': almacen,
            },
            success: function(msg){
                $('#codigo_fac_manual').html(msg)
            }
        })
    }
    function filterFloat(evt,input){
            var key = window.Event ? evt.which : evt.keyCode;    
            var chark = String.fromCharCode(key);
            var tempValue = input.value+chark;

            if(key >= 48 && key <= 57){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
            }else{
                if(key == 8 || key == 13 || key == 0) {     
                    return true;              
                }else if(key == 46){
                    if(filter(tempValue)=== false){
                        return false;
                    }else{       
                        return true;
                    }
                }else{
                    return false;
                }
            }
        }
        function filter(__val__){
            var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
            if(preg.test(__val__) === true){
                return true;
            }else{
            return false;
            }   
        }
        function mostrarMensaje(){
            // $("#alert_campos").show(200);
            $("#alert_campos").hide(3000);
            $("#suma_campos").hide(3000);
        }
    </script>
    @stop
