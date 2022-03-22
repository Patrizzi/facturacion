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
@section('form_action_modal_cliente',  route('agregado_rapido.cliente_cotizado'))
@section('ruta_retorno', 'otros')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form action="{{route('manual.store')}}"  enctype="multipart/form-data" method="post">
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
                                    <h5><br></h5>
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
                                        <select class="select2_demo_almacen" name="almacen" required="" value="">
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
                                            <input type="radio" name="tipo_coti" id="radio1" value="1" checked="">
                                            <label style="padding-right: 5px;" for="radio1" onchange="click_radio_factura()">
                                                Factura
                                            </label>
                                            <input type="radio" name="tipo_coti" id="radio2" value="0" onchange="click_radio_boleta()">
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
                                    <select name="moneda" class="form-control" >
                                        @foreach($moneda as $monedas)
                                            <option value="{{$monedas->id}}">{{$monedas->nombre}}</option>
                                        @endforeach
                                    </select>
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
                            <table cellspacing="0" class="table tables  " >
                                <thead>
                                    <tr>
                                        <th style="width: 10px">
                                            
                                        </th>
                                        <th >Articulo</th>
                                        <th style="width:100px">Cantidad</th>
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
                                            <select class="select2_demo_3 select_change" required="" id="articulo" onchange="inputs_campos(0)" autocomplete="off"></select>
                                            <textarea type='text' id='descripcion0' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" autocomplete="off" style="margin-top: 5px;" ></textarea>
                                            <input hidden="hidden" class="celda" name="articulo[]" id="input_prod1" >
                                        </td>
                                        <td>
                                            <input style="width: 76px" type='number' min="1" id='cantidad0' name='cantidad[]' max="" class="cantidad monto0 form-control"  onkeyup="multi(0)"  required  autocomplete="off" />
                                        </td>
                                        <td>
                                            <input style="width: 76px" type='text' id='precio_s_igv0' name='precio_s_igv[]'  class="precio_s_igv form-control" onkeyup="multi_s_igv(0),multi(0)" required  autocomplete="off" />
                                            <input hidden type='text' id='precio_s_igv_float0' name='precio_s_igv_float'  class="precio_s_igv_float form-control" onkeyup="multi_s_igv(0),multi(0)" required  autocomplete="off" />
                                        </td>
                                        <td>
                                            <input style="width: 76px" type='text' id='precio_c_igv0' name='precio_c_igv[]'  class="precio_c_igv monto0 form-control" onkeyup="multi_c_igv(0),multi(0)" required  autocomplete="off" />
                                        </td> 
                                        <td>
                                            <input style="width: 76px"  type='text' id='total0' name='total' disabled="disabled" class="total form-control " required  autocomplete="off" />
                                        </td>
                                        <span id="spTotal"></span>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <input id='sub_total' hidden /></td>
                                    <input id='total' hidden   /></td>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>Subtotal: </td>
                                        <td colspan="2">
                                            <input type="text" id='subtotal' name="subtotal"  readonly="readonly" class="subtotal form-control" required />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>Igv:</td>
                                        <td colspan="2">
                                            <input type="text" id='igv' name="igv"  readonly="readonly" class="igv form-control" required />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
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
                            <div class="col-sm-6 ">
                                {{-- <button class="btn btn-primary float-right" name="name" value="print" formtarget="_blank" type="submit" style="margin-right: 5px"><i class="fa fa-print fa-lg" > </i></button> --}}
                                {{-- <button type="submit" name="name" value="pdf" class="btn btn-info float-right"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF"  style="margin-right: 5px"><i class="fa fa-file-pdf-o fa-lg"></i></button> --}}
                                <button type="submit" name="guardar" class="btn btn-success ladda-button float-right" style="margin-right: 5px">Guardar</button>
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
</style>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script type="text/javascript">

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
                <select class="select2_demo_3 select_change" id='articulo${i}' onchange="inputs_campos(${i})"  autocomplete="off" required></select>
                <textarea type='text' id='descripcion${i}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" autocomplete="off" style="margin-top: 5px;"></textarea>
                <input hidden="hidden"  class="celda"  name="articulo[]" id="input_prod${i}" >
            </td>
            <td>
                <input type='number' min='1' style="width: 76px"  id='cantidad${i}' name='cantidad[]' class="cantidad monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
            </td>
            <td>
                <input style="width: 76px" type='text' id='precio_s_igv${i}' name='precio_s_igv[]'  class="precio_s_igv monto${i} form-control" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off" />
                <input hidden type='text' id='precio_s_igv_float${i}' name='precio_s_igv_float'  class="precio_s_igv_float form-control" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off" />
            </td>
            <td>
                <input style="width: 76px" type='text' id='precio_c_igv${i}' name='precio_c_igv[]'  class="precio_c_igv monto${i} form-control" onkeyup="multi_c_igv(${i}),multi(${i})" required  autocomplete="off" />
            </td> 
            <td>
                <input type='text' id='total${i}'  style="width: 76px"  name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
            </td>
        </tr>
        `;
        $('.tables').append(data);
        i++;
        //Llamada para la ejecucion de articlesSelect (funcionamiento de los select nuevos creados)
        articlesSelect2();
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
                                data[y].disabled=true;
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
        var precio = document.querySelector(`#precio_c_igv${a}`).value;
        var final=precio*cantidad; 
        // var final_decimal = Math.round(final * multiplier) / multiplier;
        //igv calculo
        var only_igv = final_sin + (parseFloat(final_sin) * (igv/multiplier)) 
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
    }
</script>
@stop
