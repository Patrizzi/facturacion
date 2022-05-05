@extends('layout')
@section('title', 'Cotizacion Manual')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@extends('layout_agregado_rapido')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@section('content')
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
@section('ruta_retorno', 'otros')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form action="{{route('manual.store')}}"  enctype="multipart/form-data" method="post" id="form_sto" onsubmit="return valida(this)">
                        @csrf
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
                                    <h2 style="font-size: 19px">COTIZACION ELECTRONICA</h2>
                                    <h5 id="codigo_cot_manual">{{$cotizacion_numero_fac}}</h5>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Cliente</td>
                                    <td>:</td>
                                    <td>
                                        <select class="select2_demo_client" name="cliente" required="" value="{{old('nombre')}}">
                                        </select>
                                    </td>
                                    <td>Almacen</td>
                                    <td>:</td>
                                    <td>
                                        <select class="select2_demo_almacen" name="almacen_form" required="" value=""  onchange="codigo_numero()">
                                            @foreach($almacen as $almacenes)
                                                <option value="{{$almacenes->id}}">{{$almacenes->nombre}} - {{$almacenes->abreviatura}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>   
                                    <td>Forma de pago</td>
                                    <td>:</td>
                                    <td>
                                        <select class="form-control" name="forma_pago" required="required">
                                            @foreach($forma_pagos as $forma_pago)
                                                <option value="{{$forma_pago->nombre}}">{{$forma_pago->nombre}}</option>
                                            @endforeach
                                        <select>
                                    </td>`
                                    <td>Tipo de Cotizacion</td>
                                    <td>:</td>
                                    <td>
                                        <div class="radio">
                                            <input type="radio" name="tipo_coti" id="radio1" value="1" checked=""  onchange="click_radio_factura(),codigo_numero()">
                                            <label style="padding-right: 5px;" for="radio1">
                                                Factura
                                            </label>
                                            <input type="radio" name="tipo_coti" id="radio2" value="0" onchange="click_radio_boleta(),codigo_numero()">
                                            <label for="radio2">
                                                Boleta
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Validez</td>
                                    <td>:</td>
                                    <td>
                                        <select  class="form-control" name="validez" required="required">
                                            @foreach($validez as $validezz)
                                                <option value="{{$validezz->descripcion}}">{{$validezz->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>Garantia</td>
                                    <td>:</td>
                                    <td>
                                        <select class="form-control" name="garantia">
                                            @foreach($garantia as $garantias)
                                                <option value="{{$garantias->descripcion}}">{{$garantias->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Moneda</td>
                                    <td>:</td>
                                    <td>
                                        <div class="row">
                                            <input type="hidden" name="almacen" id="almacen_id" class="form-control " value="{{$sucursal}}" readonly="readonly">
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
                                    <td>Fecha de cotizacion</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="fecha_emision" class="form-control" value="{{date("d-m-Y")}}" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Observacion</td>
                                    <td>:</td>
                                    <td>
                                        <textarea class="form-control" name="observacion" id="observacion"  rows="2" >Emitimos la siguiente Cotizacion a vuestra solicitud</textarea>
                                    </td>
                                    <td>Tipo de Operacion</td>
                                    <td>:</td>
                                    <td>
                                        <select class="form-control" name="tipo_operacion" >
                                            @foreach($tipo_operacion as $t_op)
                                                <option id="{{$t_op->id}}">{{$t_op->codigo}} - {{$t_op->informacion}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>    
                        <div id="resultado_moneda"></div>
                        <div class="table-responsive">
                            <table cellspacing="0" class="table_form tables" id="inp_s" >
                                <thead>
                                    <tr>
                                        <th style="width: 10px">
                                            
                                        </th>
                                        <th >Articulo</th>
                                        <th style="width:100px">Cantidad</th>
                                        <th style="width:100px">P. Sugerido</th>
                                        <th style="width:100px">Precio s/Igv </th>
                                        <th style="width:100px">Precio c/Igv</th>
                                        <th style="width:100px">Total Igv</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <button type="button" class='delete borrar e btn btn-danger'>
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <select class="select2_demo_3 select_change"  required="" id="articulo" onchange="inputs_campos(0),ajax(0)" name="select_articulo"></select>
                                            <textarea type='text' id='descripcion0' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" autocomplete="off" style="margin-top: 5px;" ></textarea>
                                            <input hidden="hidden" class="celda" name="articulo[]" id="input_prod1" >
                                        </td>
                                        
                                        <td>
                                            <input style="width: 76px" type='number' min="1" id='cantidad0' name='cantidad[]' max="" class="cantidad monto0 form-control"  onkeyup="multi(0)"  required  autocomplete="off" />
                                        </td>
                                        <td>
                                            <input style="width: 76px" type='text' id='precio_oficial0' name='precio_oficial[]' ondblclick="copy(0)"  class="precio_oficial0 p_inp form-control inp" required readonly  data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)"/>
                                        </td>
                                        <td>
                                            <input style="width: 76px" type='number' step="0.0000001" id='precio_s_igv0' name='precio_s_igv[]'  class="precio_s_igv form-control" onkeyup="multi_s_igv(0),multi(0)" required  autocomplete="off" />
                                            <input hidden type='text' id='precio_s_igv_float0' name='precio_s_igv_float'  class="precio_s_igv_float form-control" onkeyup="multi_s_igv(0),multi(0)"   autocomplete="off" />
                                        </td>
                                        <td>
                                            <input style="width: 76px" type='number' step="0.0000001" id='precio_c_igv0' name='precio_c_igv[]'  class="precio_c_igv monto0 form-control" onkeyup="multi_c_igv(0),multi(0)" required  autocomplete="off" />
                                        </td> 
                                        <td>
                                            <input style="width: 76px"  type='number' id='total0' name='total' disabled="disabled" class="total form-control " required  autocomplete="off" />
                                        </td>
                                        <span id="spTotal"></span>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <input id='sub_total' hidden /></td>
                                    <input id='total' hidden   /></td>  
                                    <tr>
                                        <td colspan="4"></td>
                                        <td>Subtotal: </td>
                                        <td colspan="2">
                                            <input type="text" id='subtotal' name="subtotal"  readonly="readonly" class="subtotal form-control" required />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td>Igv:</td>
                                        <td colspan="2">
                                            <input type="text" id='igv' name="igv"  readonly="readonly" class="igv form-control" required />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td>Total :</td>
                                        <td colspan="2">
                                            <input type="text" id='total_final' name="total_final"  readonly="readonly" class="total_final form-control" required />
                                       </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;
                            </div>
                            <div class="col-sm-6 " align="right">
                                <button  class="guardar ladda-button btn btn-info " type="submit" >Guardar</button>
                                <button class="btn btn-warning demo3 float-right"  id="finalizar_button"  style="margin-left: 10px;" type="button">Guardar y Finalizar</button>
                                <button class="btn btn-secondary ladda-button finalizar " id="finalizar" hidden="" data-style="zoom-out" >
                                </button>
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
    .a{color: red}
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
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] { -moz-appearance:textfield; }
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
    .table_form{
        width: 100%;
        max-width: 100%;
    }
    .table_form td, .table_form th {
       padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid rgb(222 226 230);
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
<!-- Sweet alert -->
<link href="{{ asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>


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


<script type="text/javascript">
    // $(document).ready(function () {
    $('.demo3').click(function (e) {
        if(  document.forms['form_sto'].reportValidity()){
            swal({
            title: "¿Estas seguro que deseas Finalizar?",
            text: "Una vez Finalizado, no podras modificar la Cotizacion Manual",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3686ff",
            confirmButtonText: "Si, Finalizar",
            cancelButtonText: "Cancelar!",
            closeOnConfirm: false,
            closeOnCancel: false },
            function (isConfirm) {
                if (isConfirm) {
                    swal("Edicion de Cotizacion Manual Finalizada", "Ya no podrás editar", "success");
                    $(".finalizar").click();
                    $(".guardar").attr('disabled', true);
                } else {
                    swal("Cancelado", "Cancelado la Finalizar", "error");
                }
            });    
        }else{
            console.log("campos incompletos");
        }
    });
    $(document).ready(function (){
        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 8000 });
    });

    // $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    
    function mostrarMensaje(mensaje){
       $("#divmsg").empty(); //limpiar div
       $("#divmsg").append(mensaje);
       $("#divmsg").show(200);
    }
    /* {{-- Darle valor a cada Boton si es Finalizar o solo Guardar --}} */
    $(".guardar").on('submit', function (e) {
        $(".demo3").attr('disabled', true);
        var data = `<input value="1" type='hidden' name='submit' class="form-control" required/>  <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
        $('#inp_s').append(data);
        
    });
    $(".finalizar").on('click', function (e) {
        var data = `<input value="2" type='hidden' name='submit' class="form-control" required/>   <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
        $('#inp_s').append(data);
        //  $(".guardar").dis();
    });
    $(".select2_demo_almacen").select2({
        placeholder: "Seleccionar Almacen",
    });

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
 
    var i = 2;
    $(".addmore").on('click', function () {
        var data = `[
        <tr>
            <td>
                <button type="button" class='delete borrar e btn btn-danger'>
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </td>";
            <td>
                <select class="select2_demo_3 select_change" id='articulo${i}' onchange="inputs_campos(${i}),ajax(${i})"  autocomplete="off" required></select>
                <textarea type='text' id='descripcion${i}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" autocomplete="off" style="margin-top: 5px;"></textarea>
                <input hidden="hidden"  class="celda"  name="articulo[]" id="input_prod${i}" >
            </td>
            <td>
                <input type='number' min='1' style="width: 76px"  id='cantidad${i}' name='cantidad[]' class="cantidad monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
            </td>
            <td class="full-height-scroll tooltip-demo">
                <input type='number' style="width: 76px"  id='precio_oficial${i}' name='precio_oficial[]' ondblclick="copy(${i})" class="precio_oficial${i} form-control inp" required  autocomplete="off" readonly data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)" />
            </td>
            <td>
                <input style="width: 76px" type='number' step="0.0000001" id='precio_s_igv${i}' name='precio_s_igv[]'  class="precio_s_igv monto${i} form-control" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off" />
                <input hidden type='text' id='precio_s_igv_float${i}' name='precio_s_igv_float'  class="precio_s_igv_float form-control" onkeyup="multi_s_igv(${i}),multi(${i})"   autocomplete="off" />
            </td>
            <td>
                <input style="width: 76px" type='number' id='precio_c_igv${i}' name='precio_c_igv[]' step="0.0000001" class="precio_c_igv p_inp monto${i} form-control" onkeyup="multi_c_igv(${i}),multi(${i})" required  autocomplete="off" />
            </td> 
            <td>
                <input type='number' id='total${i}'  style="width: 76px"  name='total' disabled="disabled" class="total form-gitcontrol "  required  autocomplete="off"/>
            </td>
        </tr>
        `;
        $('.tables').append(data);
        i++;
        //Llamada para la ejecucion de articlesSelect (funcionamiento de los select nuevos creados)
        articlesSelect2();
        toggle();
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
                    // for(var z=0;z<ar ticles_selected_count_ajax;z++){
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
            document.getElementById(`precio_s_igv0`).value = copy;
            multi_s_igv(0);
        }else{
            var copy = document.getElementById(`precio_oficial${a}`).value;
            document.getElementById(`precio_s_igv${a}`).value = copy;
            multi_s_igv(a);
        }
        multi(a);   
        
    }
     // TODO funcion ajax para obtener los parametros requeridos de articulo (PRODUCTOS - SERVICIOS)
     function ajax(a){
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

    function inputs_campos(a){
        
        if(a==0){
            var articulo = document.getElementById(`articulo`).value;
            document.getElementById(`input_prod1`).value = articulo;
            
        }else{
            var articulo = document.getElementById(`articulo${a}`).value;
            document.getElementById(`input_prod${a}`).value = articulo;
        }
    }
    var igv = {{$igv->renta}}

    function multi(a){
        var total = 1;
        var totales=0;
        var change= false; //
        var multiplier = 100;
        $(`.monto${a}`).each(function(){
            if (!isNaN(parseFloat($(this).val()))) {
                change= true;
                total *= parseFloat($(this).val());
            }
        });
        total = (change)? total:0;
        var cantidad = document.querySelector(`#cantidad${a}`).value;
        //CALCULAR PRECIO SIN IGV
        var precio_sin = document.querySelector(`#precio_s_igv${a}`).value;
        var final_sin =precio_sin*cantidad; 
        var final_decimal_sin = Math.round(final_sin * multiplier) / multiplier;
        
        
        document.getElementById(`precio_s_igv_float${a}`).value = final_decimal_sin;
        //CALCULAR PRECIO CON IGV
        // var precio = document.querySelector(`#precio_c_igv${a}`).value;
        // var final=precio*cantidad; 
        // var final_decimal = Math.round(final * multiplier) / multiplier;
        //igv calculo
        var only_igv = final_sin + (parseFloat(final_sin) * (igv/multiplier)) ;
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
        document.getElementById("subtotal").value = sub_igv_tt;

        //OPERACION PARA CALULCAR EL IGV
        var only_igv = (parseFloat(sub_igv_tt) * (igv/multiplier)) 
        var igv_decimal = Math.round(only_igv * multiplier ) / multiplier;
        document.getElementById("igv").value = igv_decimal;

        // Operacion para total
        var totalInp = $('[name="total"]');
        var total_t = 0;
        totalInp.each(function(){
            total_t += parseFloat($(this).val());
        });
        console.log(total_t);
        var multiplier2 = 100;
        var total_tt = Math.round(total_t * multiplier2) / multiplier2;
        
        $('#total').val(total_tt);

        var subtotal = document.querySelector(`#total`).value;
        document.getElementById("total_final").value = subtotal;

    }
     
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        var input_text_opt = fila.find('input[class="celda"]').val();
        $('option[value="'+input_text_opt+'"]').prop("disabled", false);
        $(".addmore").prop("disabled", false);

        // ELIMINAR TR
        if (e>1) {
            fila.closest('tr').remove();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
            //RECALCULO PARA LOS SUBTOTAL IGV Y TOTAL
            // Operacion para subtotal sin igv
            var sub_igv = $('[name="precio_s_igv_float"]');
            var sub_igv_t = 0;
            sub_igv.each(function(){
                sub_igv_t += parseFloat($(this).val());
            });        
            var sub_igv_tt = Math.round(sub_igv_t * multiplier) / multiplier;
            $('#sub_total').val(sub_igv_tt);
            document.getElementById("subtotal").value = sub_igv_tt;

            //OPERACION PARA CALULCAR EL IGV
            var only_igv = (parseFloat(sub_igv_tt) * (igv/multiplier)) 
            var igv_decimal = Math.round(only_igv * multiplier ) / multiplier;
            document.getElementById("igv").value = igv_decimal;

            // Operacion para total
            var totalInp = $('[name="total"]');
            var total_t = 0;
            totalInp.each(function(){
                total_t += parseFloat($(this).val());
            });

            var multiplier2 = 100;
            var total_tt = Math.round(total_t * multiplier2) / multiplier2;

            console.log(total_tt);
            $('#total').val(total_tt);

            var subtotal = document.querySelector(`#total`).value;
        document.getElementById("total_final").value = subtotal;
        }else{
            limpiar_inputs();
            $(".select2_demo_3").val(null).trigger("change");
            $(".addmore").prop("disabled", false);
            limpiar_inputs();

        }
        articlesSelect2();
    });

    var igv = {{$igv->renta}}
    var multiplier = 100;
    function multi_s_igv(a){
        var pr_s_igv = $(`#precio_s_igv${a}`).val();
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
        $(`#precio_s_igv${a}`).val(s_igv_redondeo);
        $(`#precio_s_igv_float${a}`).val(s_igv_redondeo);
        

    }
    function click_radio_boleta(){
        if ($('input[class=n_boleta]:radio:checked').length == 0) {
            $(".select2_demo_client").select2("val", "");
        }
        
    }
    function click_radio_factura(){
        if ($('input[class=n_factura]:radio:checked').length == 0) {
            $(".select2_demo_client").select2("val", "");
        }
    }
    function limpiar_inputs(){
        $(`.precio_s_igv`).val("");
        $(`.precio_c_igv`).val("");
        $(`.cantidad`).val("");
        $(`.total`).val("");
        $(`.subtotal`).val("");
        $(`.igv`).val("");
        $(`.total_final`).val("");
        $(`.p_inp`).val("");
    }
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
        var tipo = $('[name="tipo_coti"]:checked').val();
        $.ajax({
            type: "post",
            url: "{{route('cotizacion_manual.change_almacen_tipo')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'tipo': tipo,
                'almacen': almacen,
            },
            success: function(msg){
                $('#codigo_cot_manual').html(msg)
            }
        })
    }
</script>
@stop
