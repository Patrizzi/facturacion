@extends('layout')
@section('title', 'Nota de Venta')
@section('href_accion', route('nota_venta.index') )
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@section('content')


@include('layout_agregado_rapido')

{{-- Boton para modal de Clientes --}}
@section('ruta_retorno', 'cotizacion')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>
{{--Fin Boton para modal de Clientes --}}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form action="{{route('nota_venta.store')}}"  enctype="multipart/form-data" method="post" id="nota_venta_store">
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
                                <div class="form-control tooltip-demo" align="center" style="height: auto;">
                                    <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                    <h2 style="font-size: 19px">NOTA DE VENTA</h2>
                                    <h4>{{$cod_nota_venta}} <span class="small" data-toggle="tooltip" data-placement="bottom" title="N° Referencial"><i class="fa fa-question-circle"></i></span></h4>
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
                                        <select class="select2_demo_client" name="cliente" id="cliente" required></select>
                                    </td>
                                    <td>Forma de pago</td>
                                    <td>:</td>
                                    <td>
                                        <select class="form-control" name="forma_pago" required="required">
                                            @foreach($forma_pagos as $forma_pago)
                                                <option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option>
                                            @endforeach
                                        <select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Almacen</td>
                                    <td>:<input type="text" class="form-control" value="{{$almacen->id}}" name="almacen" hidden></td>
                                    <td>
                                        <input type="text" class="form-control" value="{{$almacen->nombre}}" disabled>
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
                                    <select name="moneda" class="form-control" required id="moneda_id" >
                                        @foreach($moneda as $monedas)
                                            <option value="{{$monedas->id}}">{{$monedas->nombre}}</option>
                                        @endforeach
                                    </select>
                                    </td>
                                    <td>Fecha de Emision</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="fecha_emision" class="form-control" value="{{date("d-m-Y")}}" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Observacion</td>
                                    <td>:</td>
                                    <td colspan="4">
                                        <textarea class="form-control" name="observacion" id="observacion"  rows="2"  >Emitimos la siguiente Nota de Venta a vuestra solicitud</textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="resultado_moneda"></div>
                        <div class="table-responsive">
                            <table cellspacing="0" class="table tables  " id="inp_s" >
                                <thead>
                                    <tr>
                                        <th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()" /></th>
                                        <th >Articulo</th>
                                        <th style="width:120px">Cantidad</th>
                                        <th style="width:120px">P. Sugerido (c/igv)</th>
                                        <th style="width:120px">Precio</th>
                                        <th style="width:120px">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type='checkbox' class="case"></td>
                                        <td>
                                            <select class="monto0 select2_demo_3 select_change" required="" id="articulo" onchange="ajax(0)" autocomplete="off"></select>
                                            <textarea  type='text' {{-- id='descripcion0' --}}  name='descripcion_item[]' class="form-control"   autocomplete="off" style="margin-top: 5px;" placeholder="Descripcion del artículo"></textarea>
                                            <input type="hidden" class="celda"  name="articulo[]" id="input_prod1" >
                                        </td>
                                        <td>
                                            <input style="min-width: 96px" type='text' id='cantidad0' name='cantidad[]' max="" class="monto0 form-control"  onkeyup="multi(0)"  required  autocomplete="off" value="1"  />
                                        </td>
                                        <td>
                                            <input type="text" style="min-width: 96px" class="form-control" readonly id="precio_sugerido0" ondblclick="copy(0)">
                                        </td>
                                        <td>
                                            <input style="min-width: 96px" type='text' id='precio0' name='precio[]'  class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off" />
                                        </td>

                                        <td>
                                            <input style="min-width: 96px"  type='text' id='total0' name='total' disabled="disabled" class="total form-control " required  autocomplete="off" />
                                        </td>
                                        <span id="spTotal"></span>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr  align="center">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total :</td>
                                        <td colspan="2">
                                            <input id='sub_total' hidden name="costo_sub_total"  readonly="readonly" class="form-control" required />
                                            <input id='total_final' name="costo_total"  readonly="readonly" class="form-control" required />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>&nbsp;
                                <button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;
                            </div>
                            <div class="col-sm-6" align="right">
                                <div class="tooltip-demo" align="right">
                                    <button class="guardar ladda-button btn btn-info" type="submit" >Guardar</button>
                                    <button class="btn btn-warning  demo3 float-right" style="margin-left: 10px;" type="button" >Guardar y Finalizar</button>
                                    <button class="btn btn-secondary ladda-button finalizar " id="finalizar" hidden="" data-style="zoom-out" >
                                    </button>
                                </div>
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
    .select2-hidden-accessible{
        width: 0px;
        margin: 0px;
        width: auto;
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
<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js')}}"></script>
<!-- Sweet alert -->
<link href="{{ asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
 
<script type="text/javascript">
  
    $('.demo3').click(function (e) {
        if(document.forms['nota_venta_store'].reportValidity()){
            swal({
                title: "¿Estas seguro que deseas Finalizar?",
                text: "Una vez Finalizado, No se podrá editar la Nota de Venta",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3686ff",
                confirmButtonText: "Si, Finalizar",
                cancelButtonText: "Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        swal("Nota de Venta Finalizada", "", "success");
                        $('.finalizar').click();
                        $('.gurdar').attr('disabled', true);
                    } else {
                        swal("Cancelado", "Cancelado la Finalizar", "error");
                    }
            });
        }else{
            console.log("campos incompletos ");
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
    $(".select2_demo_client").select2({
        placeholder: "Seleccionar Cliente",
        ajax: {
            minimumInputLength: 1,
            url: "{{ route('pa.clients') }}",
            dataType: 'json',
            type: "POST",
            delay: 10,
            data: function (params) {
                var tipo_coti = 2;
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
</script>

<script >
    var i = 2;

    $(".addmore").on('click', function () {
        var data = `[
        <tr>
        <td>
            <input type='checkbox' class='case'/>
        </td>";
        <td>
            <select class="monto${i} select2_demo_3 select_change" required="" id="articulo${i}" onchange="ajax(${i})" autocomplete="off"></select>
            <textarea  type='text' {{-- id='descripcion0' --}}  name='descripcion_item[]' class="form-control"   autocomplete="off" style="margin-top: 5px;" placeholder="Descripcion del artículo"></textarea>
            <input type="hidden" class="celda"  name="articulo[]" id="input_prod${i}" >

        </td>
        <td>
            <input type='text' style="min-width: 96px" value="1" id='cantidad${i}' name='cantidad[]'  class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
        </td>
        <td>
            <input type="text" style="min-width: 96px" class="form-control" readonly id="precio_sugerido${i}" ondblclick="copy(${i})">
        </td>
        <td>
            <input type='text' style="min-width: 96px"  id='precio${i}' name='precio[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
        </td>
        <td>
            <input type='text' id='total${i}'  style="min-width: 96px"  name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
        </td>

        </tr>
        `;
                        // $(`.monto${a}`).each(function(){

        $('.tables').append(data);
        i++;
        articlesSelect2();
    });
</script>
<script>
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
                    $(`#precio_sugerido${a}`).val(msg.price)
                }else{
                    $(`#precio_sugerido${a}`).val(msg.price)
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
        var final=precio*cantidad;
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

        var igv_valor=0;
        var subtotal = document.querySelector(`#sub_total`).value;
        var igv=subtotal*igv_valor/100;

        var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
        var end=igv_decimal+parseFloat(subtotal);

        var end2 = Math.round(end * multiplier2) / multiplier2;

        // document.getElementById("igv").value = igv_decimal;
        document.getElementById("total_final").value = end2;

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

        var igv_valor=18;
        var subtotal = document.querySelector(`#sub_total`).value;
        var igv=parseFloat(subtotal)*igv_valor/100;
        // var end=parseFloat(igv)+parseFloat(subtotal);

        // console.log(typeof igv);
        // console.log(typeof end);
        // document.getElementById("igv").value = igv;
        document.getElementById("total_final").value = end;
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
    function ajax_p_sugerido(item,elemt){
        var item = item;
        var moneda = $("#moneda_id").val();
        $.ajax({
            type: "post",
            url: "{{ route('nota_venta.precio_sugerido') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'item': item,		
                'moneda': moneda,		
            },
            success: function (msg) {
                console.log(msg);
                $(`#precio_sugerido${elemt}`).val(msg);
                $(`#value${elemt}`).val(msg);

            },
            error: function(eject) {
                if(eject.status===400){
                    console.log(eject.responseJSON.error);
                }
            },
            cache:true
        });
    }
    function change_list(valor,elem){
        var options = document.getElementById(`browsers${elem}`).getElementsByTagName('option');
        var optionVals = [];
        var i = 0;

        for (i; i < options.length; i += 1) {
            optionVals.push(options[i].value);
        }

        if (optionVals.indexOf(valor.value) > -1) {
            console.log(valor.value);
            ajax_p_sugerido(valor.value,elem);
        }
    }
    function copy(a){
        if(a==0){
            var copy = document.getElementById(`precio_sugerido0`).value;
            document.getElementById(`precio0`).value = copy;
        }else{
            var copy = document.getElementById(`precio_sugerido${a}`).value;
            document.getElementById(`precio${a}`).value = copy;
        }
        multi(a);
    }
</script>
@stop
