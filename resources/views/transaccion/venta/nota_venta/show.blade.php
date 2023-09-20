@extends('layout')
@section('title', 'Nota de Venta')
@section('href_accion', route('nota_venta.index'))
@section('value_accion', 'Inicio')
@section('nombre', 'nueva cotizacion')

@section('button2', 'Nueva Nota de Venta')
@section('onclick',"event.preventDefault();document.getElementById('nueva_nota').submit();")

@section('content')
<?php use Luecano\NumeroALetras\NumeroALetras; ?>
<form action="{{ route('nota_venta.create')}}"enctype="multipart/form-data" method="post" id="nueva_nota">
    @csrf
    <input type="text"  hidden="hidden" name="almacen"  value="{{$nota_venta->almacen_id}}">
    <input  hidden="hidden" type="submit"  >
</form> 

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row ibox-title" style="padding-right: 3.1%;margin: 0; padding-bottom: 1px" >
        <div class="col-sm-6">
            @if($nota_venta->estado == 0 && $nota_venta->estado_vigente == 0 )
                <button class="btn-editar btn btn-warning" onclick="click_editar()"><i class="fa fa-pencil"></i></button>
                <button class="btn-no-editar no_mostrar btn btn-warning" onclick="click_cancelar_editar()"><i class="fa fa-times"></i></button>
            @else

            @endif
            {{-- <a href="" id="btn-editar" class="btn-editar btn btn-warning">Editar</a> --}}
        </div>
        <div class="col-sm-6 tooltip-demo "align="right"  > 
            <!-- PDF -->
            <a href="{{route('nota_venta_pdf' ,$nota_venta->id)}}"class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i></a>
            <!-- Ticket -->
            <a href="{{route('nota_venta.ticket', $nota_venta->id)}}" class="btn btn-info" target="_blank"><i class="fa fa-ticket fa-lg"></i></a>
            <!-- Impresion -->
            <a class="btn btn-success" href="{{route('nota_venta.print',$nota_venta->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
            <!-- Email -->
            @if(Auth::user()->email_creado == 1)
                <form action="{{ route('email.nota_venta', $nota_venta->id )}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn"  >
                    @csrf
                    <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=""  formtarget="_blank"  data-original-title="Enviar por correo">
                        <i class="fa fa-envelope fa-lg" ></i> 
                    </button>
                </form>
            @endif
            
            <!-- Whatsapp -->
            <div id="auto" onclick="divAuto()">
                <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-whatsapp fa-lg" style="color: white"></i>  </a>
            </div>
            <div id="div-mostrar">
                <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                    @csrf
                    <input type="tel" name="numero"  value="{{$nota_venta->cliente->celular}}"  />
                    <input type="text" name="mensaje"  hidden="" value="" />
                    <input type="text" hidden="" name="url" value="{{route('nota_venta_pdf' ,$nota_venta->id)}}">
                    <input type="text" name="name_sin_cambio" hidden="" value="PDF-DOC-{{$nota_venta->cod_nota_venta}}-{{$empresa->ruc}}" />
                    <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    <div class="col-sm-4 text-left" align="left">

                        <address class="col-sm-4" align="left">
                            <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                        </address>
                    </div>
                    <div class="col-sm-4 text-center" style="font-size: 13px"><br>
                        <strong>{{$empresa->razon_social}}</strong>
                        <br>
                        Tel.: {{$empresa->telefono}} / Móvil: {{$empresa->movil}}
                        <br>
                        {{$empresa->correo}}
                        <br>
                        {{$empresa->calle}} - {{$empresa->ciudad}} - {{$empresa->region_provincia}} - {{$empresa->pais}}
                    </div>
                    <div class="col-sm-4">
                        <div class="form-control" align="center" style="height: auto;">
                            <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">NOTA DE VENTA</h2>
                            <h5>{{$nota_venta->cod_nota_venta}} </h5>
                        </div>
                    </div>
                </div><br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3>Contacto Cliente</h3>
                            <div align="left">
                                <strong>Señor(es):</strong> &nbsp;{{$nota_venta->cliente->nombre}}<br>
                                <strong>{{$nota_venta->cliente->documento_identificacion}} :</strong> &nbsp;{{$nota_venta->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Fecha:</strong> &nbsp;{{$nota_venta->updated_at}}<br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                       <div class="form-control" >
                           <h3>Condiciones Generales</h3>
                           <div align="left">
                            <strong>Garantia:</strong> &nbsp;@if(isset($nota_venta->id_cotizacion)) {{$nota_venta->garantia}}  @else {{$nota_venta->garantia}} @if( preg_match('/\d+/', $nota_venta->garantia)) Mes(es) @endif @endif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            <strong>Tipo de Moneda:</strong> &nbsp;{{$nota_venta->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            <input type="hidden" name="moneda" id="moneda" value="{{$nota_venta->moneda->nombre}}">
                            <input type="hidden"  id="moneda_id" value="{{$nota_venta->moneda->id}}">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" align="center">
                   <div class="form-control" style="border: none;height: auto" >
                       <div align="left">
                        <strong>observaciones:</strong> &nbsp;{{$nota_venta->observacion }}<br>
                    </div>
                </div>
            </div>

        </div><br>
        <div class="table-responsive">
            <div class="table-no">
                <table class="table " >
                    <thead>
                       <tr >
                            <th>ITEM </th>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>P.Unitario</th>
                            <th>Total <span hidden="hidden">{{$simbologia=$nota_venta->moneda->simbolo}}</span></th>
                        </tr>
                    </thead>
                    <span hidden>{{$i=1}}{{$sume=0}}</span>
                    <tbody>
                    @foreach($nota_venta_re as $nota_venta_reg)
                    <tr>
                            <td>{{$i++}} </td>
                            <td>{{$nota_venta_reg->producto}}<br>{{$nota_venta_reg->descripcion}}</td>
                            <td>{{$nota_venta_reg->cantidad}}</td>
                            <td>{{$simbologia}} {{round($nota_venta_reg->precio_nacional,2)}}</td>
                            <td>{{$simbologia}} {{round($nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional,2)}}</td>
                            <span hidden>{{$sume=round($nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional+$sume,2)}}</span>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row" style="width: 100%">
                    <div class="col-sm-8">
                        <h3 align="left" class="">
                            <?php 
                                    $end=round($sume, 2);
                                    $v=new NumeroALetras() ;
                                    $letra=($v->toInvoice($end, 2));
                                ?>
                                Son : {{ucfirst(strtolower($letra))}} {{$nota_venta->moneda->nombre }}
                        </h3>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-control" align="center">
                            <p class=" a"> <strong>Importe Total</strong></p>
                            <span>{{$nota_venta->moneda->simbolo}}</span>
                            <span class="">{{number_format($end,2)}}</span>
                            {{-- <input type="text" name="impor_t" id="impor_t" value="" readonly class="form-control-plaintext" style="width: 60%"> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- //SOLO EDITAR  --}}
            <span hidden>{{$h=0}}</span>
            @if($nota_venta->estado == 0 && $nota_venta->estado_vigente == 0)
                <div class="div-editar no_mostrar">
                    <form action="{{route('nota_venta.update',$nota_venta->id)}}" method="post" id="nota_vent_update">
                        @csrf
                        <table   class="table tables" id="inp_s">
                            <thead>
                                <tr >
                                    <th><button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;</th>
                                    <th style="width: 51%">Descripcion</th>
                                    <th style="width: 8%;">Cantidad</th>
                                    <th>P. Sugerido</th>
                                    <th>P.Unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nota_venta_re as $nota_venta_reg)
                                
                                <tr>
                                    <td>
                                        <button type="button" class='delete borrar e btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                    </td>
                                    <td>
                                        <input maxlength="190" class="form-control limp" list="browsers{{$h}}" name="articulo[]"  required autocomplete="off" value="{{$nota_venta_reg->producto}}" id="article_text{{$h}}">
                                            <datalist id="browsers{{$h}}" >
                                                @foreach($productos as $index)
                                                <option>{{$index->nombre}} \\ {{$index->descripcion}}</option>
                                                @endforeach
                                                @foreach($servicios as $servicio)
                                                <option>{{$servicio->nombre}} \\ {{$servicio->descripcion}}</option>
                                                @endforeach
                                            </datalist>
                                        </input>
                                        <textarea name="article_descripcion[]" id="" class="form-control" placeholder="Descripcion del artículo">{{$nota_venta_reg->descripcion}}</textarea>
                                    </td>
                                    <input type="hidden" name="elem_delete[]" value="{{$nota_venta_reg->id}}">
                                    <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="existente">
                                    <td><input type="text" value="{{$nota_venta_reg->cantidad}}" class="cantidad{{$h}} form-control limp" id="cantidad{{$h}}" name="cantidad[]" onkeyup="multi({{$h}})"></td>
                                    <td><input type="text" style="width: 96px" class="form-control" readonly id="precio_sugerido{{$h}}" ondblclick="copy({{$h}})"></td>
                                    <td><input type="text" value="{{$nota_venta_reg->precio_nacional}}" class="precio{{$h}} form-control limp" id="precio{{$h}}" name="precio[]" onkeyup="multi({{$h}})"></td>
                                    <td><input type="text" value="{{$nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional}}" class="form-control limp" name="total" id="total{{$h}}" readonly></td>
                                </tr>
                                <span hidden>{{$h++}}</span>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-sm-12" align="right">
                            <button  data-style="zoom-out" class="guardar ladda-button btn btn-info" type="submit" >Guardar</button>
                            <button class="btn btn-warning  demo3 float-right" style="margin-left: 10px;" type="button"  >Guardar y Finalizar</button>
                            <button class="btn btn-secondary ladda-button finalizar " id="finalizar" hidden="" data-style="zoom-out" >
                            </button>
                        </div>
                        <br>
                    </form>
                    <div class="row" style="width: 100%">
                        <div class="col-sm-8">
                            <h3 align="left" class="h3-total">
                                <?php 
                                    $end=round($sume, 2);
                                    $v=new NumeroALetras() ;
                                    $letra=($v->toInvoice($end, 2));
                                ?>
                                Son : {{ucfirst(strtolower($letra))}} {{$nota_venta->moneda->nombre }}
                            </h3>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-control" align="center">
                                <p class=" a"> Importe Total</p>
                                <span>{{$nota_venta->moneda->simbolo}}</span>
                                <span class="impor_t">{{$sume}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            
            @else
            @endif
        </div><!-- /table-responsive -->
<br><br><br><br>


<br>
@include('layout_bancos')
<!-- Fin Totales de Productos -->

    <br>
    <div class="row">
        <div class="col-sm-3">
            <p><u>Atendido Por: </u></p>
            Teléfono :  {{$empresa->telefono}}<br>
            Celular : {{$nota_venta->user->celular }}<br>
            Email : {{$nota_venta->user->email_user}}<br>
            Web : {{$empresa->pagina_web}} <br>
        </div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3"><br><br>

    </div>
</div>
</div>
</div>
</div>
</div>

    {{--  --}}
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
        opacity: 0  ;
    }
   
    #auto{
        /*padding: -100px;*/
        /*background: orange;*/
        /*width: 95px;*/
        cursor: pointer;
        /*margin-top: 10px;*/
        /*margin-bottom: 10px;*/
        box-shadow: 0px 0px 1px #000;
        display: inline-block;
    }

    #auto:hover{
        opacity: .8;
    }

    #div-mostrar{
        /*width: 50%;*/
        margin: auto;
        height: 0px;
        /*margin-top: -5px*/
        /*background: #000;*/
        /*box-shadow: 10px 10px 3px #D8D8D8;*/
        transition: height .4s;
        color:white;
        text-align: right;
    }
    #auto:hover{
        opacity: .8;
    }
    #auto:hover + #div-mostrar{
        height: 50px;
    }
    .form-control-plaintext{
        display: table-column !important;
    }
    .form-control{border-radius: 10px; padding: 10px }
    .ibox-tools a{color: white !important}
    .a{height: 37px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}
    .mostrar{
        display: revert;
    }
    .no_mostrar{
        display: none;
    }
    .table-responsive{
        overflow-x: revert;
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
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- Jquery Validate -->
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js')}}"></script>
<!-- Sweet alert -->
<link href="{{ asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>

<script>
    $('.demo3').click(function () {
        if(document.forms['nota_vent_update'].reportValidity()){
            swal({
            title: "¿Estas seguro que deseas Finalizar?",
            text: "Una vez Finalizado, no podras modificar la Nota de Venta",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3686ff",
            confirmButtonText: "Si, Finalizar",
            cancelButtonText: "Cancelar!",
            closeOnConfirm: false,
            closeOnCancel: false },
            function (isConfirm) {
                if (isConfirm) {
                    $(".finalizar").click();
                    swal("Edicion de Nota de Venta Finalizada", "Ya no podrás editar", "success");
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

    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    
    function mostrarMensaje(mensaje){
       $("#divmsg").empty(); //limpiar div
       $("#divmsg").append(mensaje);
       $("#divmsg").show(200);
    }
    {{-- Darle valor a cada Boton si es Finalizar o solo Guardar --}}
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
    function click_editar(){
        // MOSTRAR LOS INPUTS
        $('.div-editar').removeClass('no_mostrar');
        $('.div-editar').addClass('mostrar');
        // OCULTAR TABLA
        $('.table-no').addClass('no_mostrar');
        // BOTONES
        $('.btn-no-editar').removeClass('no_mostrar');
        $('.btn-editar').addClass('no_mostrar');
    }
    function click_cancelar_editar(){
        // OCULTAR INPUTS
        $('.div-editar').removeClass('mostrar');
        $('.div-editar').addClass('no_mostrar');
        // MOSTRAR TABLA
        $('.table-no').removeClass('no_mostrar');
        $('.table-no').addClass('mostrar');

        $('.btn-editar').removeClass('no_mostrar');
        $('.btn-no-editar').addClass('no_mostrar');
    }
</script>
<script>
    
    var i = {{$h}};
    $(".addmore").on('click', function () {
        var data = `[
        <tr>
            <td>
                <button type="button" class='delete borrar e btn btn-danger'><i class="fa fa-trash" aria-hidden="true"></i></button>
            </td>";
            <td>
                <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="nuevo">
                <input  class="form-control " list="browsers${i}" name="articulo[]" class="monto0 form-control" required autocomplete="off" maxlength="191" onchange="change_list(this,${i});">
                    <datalist id="browsers${i}" >
                        @foreach($productos as $index)
                        <option>{{$index->nombre}} \\ {{$index->descripcion}}</option>
                        @endforeach
                        @foreach($servicios as $servicio)
                        <option>{{$servicio->nombre}} \\ {{$servicio->descripcion}}</option>
                        @endforeach
                    </datalist>
                </input>
                <textarea name="article_descripcion[]" id="" class="form-control" placeholder="Descripcion del artículo"></textarea>
            </td>
            <td>
                <input type='text'  id='cantidad${i}' name='cantidad[]' class="cantidad${i} form-control" onkeyup="multi(${i})" required  autocomplete="off" value="1"/>
            </td>
            <td>
                <input type="text" style="width: 96px" class="form-control" readonly id="precio_sugerido${i}" ondblclick="copy(${i})">
            </td>
            <td>
                <input type='text'  id='precio${i}' name='precio[]' class="precio${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
            </td>
            <td>
                <input type='text' id='total${i}'    name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
            </td>   
        </tr>`;
        $('.tables').append(data);
        i++;
        $(".addmore").prop("disabled", false);
        $(".borrar").prop("disabled", false);
    });
    
    function multi(a){
        var cantidad = document.querySelector(`#cantidad${a}`).value;
        var precio = document.querySelector(`#precio${a}`).value;
        var total = cantidad*precio;
        var round_tota = parseFloat(Math.round((total) * 100 ) / 100).toFixed(2);
        document.querySelector(`#total${a}`).value = round_tota;
        // console.log(total);
        var totalInp = $('[name="total"]');
        var total_t = 0;

        totalInp.each(function(){
            total_t += parseFloat($(this).val());
        });
        var red = parseFloat(Math.round((total_t) * 100 ) / 100).toFixed(2);
        // document.querySelector(`#impor_t`).value = total_t;
        $('.impor_t').html(red);
        ajax_l();
    }
    function ajax_l(){
        var numeros = $('.impor_t').html();

        console.log("antes_ajax"+numeros);
        var moneda = document.querySelector(`#moneda`).value;
        $.ajax({
            type: "post",
            url: "{{route('pa.numberletters')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'numeros': numeros,
                'moneda': moneda
            },
            success: function(msg){
                console.log(msg);  
                $('.h3-total').html(msg);
            }
        });
    }
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        $(".addmore").prop("disabled", false);
        // ELIMINAR TR
        if (e>1) {
            fila.closest('tr').remove();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
        }else{
            $(".borrar").prop("disabled", true);
            $(".addmore").prop("disabled", false);
            $(".limp").val("");
        }
        var totalInp = $('[name="total"]');
        var total_t = 0;

        totalInp.each(function(){
            total_t += parseFloat($(this).val());
        });
        $('.impor_t').html(total_t);
        ajax_l();
    });
</script>
<script>
    var clic = 1;
    function divAuto(){
        if(clic==1){
            document.getElementById("div-mostrar").style.height = "50px";
            clic = clic + 1;
        } else{
        document.getElementById("div-mostrar").style.height = "0px";
        clic = 1;
        }
    }
</script>

<script >
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
    $(document).ready(function (){ 
        var contador = `{{$count_reg}}`;
        for (var index = 0; index < contador; index++) {
            var options = document.getElementById(`article_text${index}`).value;
            console.log(options);
            ajax_p_sugerido(options,index);
            
        }
    });
</script>

@endsection