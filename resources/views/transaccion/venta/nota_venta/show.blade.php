@extends('layout')
@section('title', 'Nota de Venta')
@section('href_accion', route('nota_venta.index'))
@section('value_accion', 'Atras')
@section('nombre', 'nueva cotizacion')
{{-- @section('onclick',"event.preventDefault();document.getElementById('nueva_cot').submit();") --}}

@section('content')
{{--
<form action="{{ route($nueva_cot)}}"enctype="multipart/form-data" method="post" id="nueva_cot">
    @csrf
    <input type="text"  hidden="hidden" name="almacen"  value="{{$almacen}}">
    <input  hidden="hidden" type="submit"  >
</form> --}}

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row ibox-title" style="padding-right: 3.1%;margin: 0; padding-bottom: 1px" >
        <div class="col-sm-6">
            <button class="btn-editar btn btn-warning" onclick="click_editar()">Editar</button>
            <button class="btn-no-editar no_mostrar btn btn-warning" onclick="click_cancelar_editar()">Cancelar</button>
            {{-- <a href="" id="btn-editar" class="btn-editar btn btn-warning">Editar</a> --}}
        </div>
        <div class="col-sm-6 tooltip-demo "align="right"  > 
            <!-- PDF -->
            <a href="{{route('nota_venta_pdf' ,$nota_venta->id)}}"class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i></a>
            <!-- Impresion -->
            <a class="btn btn-success" href="{{route('nota_venta.print',$nota_venta->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
            <!-- Email -->
            @if(Auth::user()->email_creado == 0)
                
            @else
                <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn" >
                    @csrf
                    <input type="text" hidden="hidden"  name="tipo" value="App\NotaVenta"/>
                    <input type="text" hidden="hidden"  name="id" value="{{$nota_venta->id}}"/>
                    <input type="text" hidden="hidden"  name="redict" value="nota_venta"/>
                    <input type="text" hidden="hidden"  name="cliente" value=" {{$nota_venta->cliente->email}}"/>
                    <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=""  formtarget="_blank"  data-original-title="Enviar por correo"><i class="fa fa-envelope fa-lg"  ></i> </button>
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
                                <strong>Fecha:</strong> &nbsp;{{$nota_venta->created_at}}<br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                       <div class="form-control" >
                           <h3>Condiciones Generales</h3>
                           <div align="left">
                            <strong>Garantia:</strong> &nbsp;{{$nota_venta->garantia }} Mes(es)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            <strong>Tipo de Moneda:</strong> &nbsp;{{$nota_venta->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            <input type="hidden" name="moneda" id="moneda" value="{{$nota_venta->moneda->nombre}}">
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
                            <td>{{$nota_venta_reg->producto}}</td>
                            <td>{{$nota_venta_reg->cantidad}}</td>
                            <td>{{$simbologia}} {{$nota_venta_reg->precio_nacional}}</td>
                            <td>{{$simbologia}} {{$nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional}}</td>
                            <span hidden>{{$sume=$nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional+$sume}}</span>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row" style="width: 100%">
                    <div class="col-sm-8">
                        <h3 align="left" class="">
                            <?php 
                                $v=new CifrasEnLetras() ;
                                $end2=number_format(round($sume, 2),2);
                                $end=round($sume, 2);
    
                                $v=new CifrasEnLetras() ;
                                $letra=($v->convertirEurosEnLetras($end));
                                $letra_final = ucfirst(strstr($letra, 'soles',true));
                                $end_final_point=strstr($end2, '.', false);
                                $end_final=str_replace('.', ' ',$end_final_point);
                                ?>
                                Son : {{$letra_final}} {{$end_final}}/100 {{$nota_venta->moneda->nombre }}
                        </h3>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-control" align="center">
                            <p class=" a"> Importe Total</p>
                            <span>{{$nota_venta->moneda->simbolo}}</span>
                            <span class="">{{$sume}}</span>
                            {{-- <input type="text" name="impor_t" id="impor_t" value="" readonly class="form-control-plaintext" style="width: 60%"> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- //SOLO EDITAR  --}}
            <div class="div-editar no_mostrar">
                <form action="{{route('nota_venta.update',$nota_venta->id)}}" method="post">
                    @csrf
                    <table   class="table tables">
                        <thead>
                            <tr >
                                <th><button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;</th>
                                <th style="width: 65%">Descripcion</th>
                                <th>Cantidad</th>
                                <th>P.Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <span hidden>{{$h=1}}</span>
                        <tbody>
                            @foreach($nota_venta_re as $nota_venta_reg)
                            
                            <tr>
                                <td>
                                    <button type="button" class='delete borrar e btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                </td>
                                <td>
                                    <input maxlength="190" class="form-control limp" list="browsers2" name="articulo[]"  required autocomplete="off" value="{{$nota_venta_reg->producto}}">
                                        <datalist id="browsers2" >
                                            @foreach($productos as $index)
                                            <option>{{$index->nombre}} / {{$index->descripcion}}</option>
                                            @endforeach
                                            @foreach($servicios as $servicio)
                                            <option>{{$servicio->nombre}} / {{$servicio->descripcion}}</option>
                                            @endforeach
                                        </datalist>
                                    </input>
                                </td>
                                <input type="hidden" name="elem_delete[]" value="{{$nota_venta_reg->id}}">
                                <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="existente">
                                <td><input type="text" value="{{$nota_venta_reg->cantidad}}" class="cantidad{{$h}} form-control limp" id="cantidad{{$h}}" name="cantidad[]" onkeyup="multi({{$h}})"></td>
                                <td><input type="text" value="{{$nota_venta_reg->precio_nacional}}" class="precio{{$h}} form-control limp" id="precio{{$h}}" name="precio[]" onkeyup="multi({{$h}})"></td>
                                <td><input type="text" value="{{$nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional}}" class="form-control limp" name="total" id="total{{$h}}" readonly></td>
                            </tr>
                            <span hidden>{{$h++}}</span>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="ladda-button btn btn-primary float-right" id="boton" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>
                    <br>
                </form>
                <div class="row" style="width: 100%">
                    <div class="col-sm-8">
                        <h3 align="left" class="h3-total">
                            <?php 
                                $v=new CifrasEnLetras() ;
                                $end2=number_format(round($sume, 2),2);
                                $end=round($sume, 2);

                                $v=new CifrasEnLetras() ;
                                $letra=($v->convertirEurosEnLetras($end));
                                $letra_final = ucfirst(strstr($letra, 'soles',true));
                                $end_final_point=strstr($end2, '.', false);
                                $end_final=str_replace('.', ' ',$end_final_point);
                                ?>
                                Son : {{$letra_final}} {{$end_final}}/100 {{$nota_venta->moneda->nombre }}
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
        </div><!-- /table-responsive -->
<br><br><br><br>


<br>
@include('layout_bancos')
<!-- Fin Totales de Productos -->

    <br>
    <div class="row">
        <div class="col-sm-3">
            <p><u>Centro de Atencion : </u></p>
            Telefono : {{$nota_venta->user->personal->telefono }}<br>
            Celular : {{$nota_venta->user->personal->celular }}<br>
            Email : {{$nota_venta->user->personal->email }}<br>
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

<script>
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
                <input  class="form-control " list="browsers2" name="articulo[]" class="monto0 form-control" required autocomplete="off">
                    <datalist id="browsers2" >
                        @foreach($productos as $index)
                        <option>{{$index->nombre}} / {{$index->descripcion}}</option>
                        @endforeach
                        @foreach($servicios as $servicio)
                        <option>{{$servicio->nombre}} / {{$servicio->descripcion}}</option>
                        @endforeach
                    </datalist>
                </input>
            </td>
            <td>
                <input type='text'  id='cantidad${i}' name='cantidad[]' class="cantidad${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
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
        document.querySelector(`#total${a}`).value = total;
        // console.log(total);
        var totalInp = $('[name="total"]');
        var total_t = 0;

        totalInp.each(function(){
            total_t += parseFloat($(this).val());
        });
        // document.querySelector(`#impor_t`).value = total_t;
        $('.impor_t').html(total_t);
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

@endsection