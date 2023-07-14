@extends('layout')

@section('title', 'De Cotizacion a Nota de Venta')
@section('breadcrumb', 'Nota de Venta')
@section('breadcrumb2', 'Nota de Venta')
@section('href_accion', route('cotizacion.show',$cotizacion->id))
@section('value_accion', 'Atrás')

@section('content')
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
<div class="wrapper wrapper-content animated fadeInRight">
    <form action="{{route('cotizacion.nota_venta_store')}}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                    <div class="row">
                        <div class="col-sm-4 text-left" align="left">
                            <address class="col-sm-4" align="left">
                                <img src="{{asset('img/logos')}}/{{$empresa->foto}}" alt="" width="300px">
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
                        <div class="col-sm-4 ">
                            <div class="form-control ruc" style="height: 125px">
                                <center>
                                    <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                    <h2>NOTA DE VENTA</h2>
                                    <input type="text" value="{{$cotizacion->id}}" name="id_cotizador" hidden="hidden">
                                    <p>{{$cod_nota_venta}}</p>
                                    <input type="text" value="{{$cotizacion->comisionista_id}}" name="id_comisionista" hidden="hidden">
                                </center>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <div align="left">
                                    <div class="row">
                                        <div class="col-sm-2"><strong>Cliente:</strong></div>
                                        <div class="col-sm-10"><input type="text" class="form-control" name="" value="{{$cotizacion->cliente->nombre}}" readonly=""></div>
                                        <br>
                                        <div class="col-sm-2"><strong>R.U.C:</strong></div>
                                        <div class="col-sm-10"><input type="text" class="form-control" name="" value="{{$cotizacion->cliente->numero_documento}}" readonly=""></div>
                                        <br>
                                        <div class="col-sm-2"><strong>Condiciones de Pago:</strong></div>
                                        <div class="col-sm-4" id="colum-col">
                                            <select class="form-control" name="forma_pago"  id ="forma_pago" >
                                                <option value="{{$cotizacion->forma_pago->id}}">{{$cotizacion->forma_pago->nombre}}</option>
                                                <option disabled>--------------------</option>
                                                @foreach($forma_pagos as $forma_pago)
                                                    <option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <strong>Tipo de Moneda:</strong>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="{{$cotizacion->moneda->nombre}}" name="" readonly>
                                            <input type="text" name="tipo_moneda" value="{{$cotizacion->moneda->id }}" hidden="hidden">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" align="center">
                            <div class="form-control" >
                                <div align="left">
                                    <div class="row">
                                        <div class="col-sm-2"><strong>Almacen:</strong></div>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{$cotizacion->almacen->nombre}}" name="almacen" readonly>
                                            <input type="hidden" value="{{$cotizacion->almacen_id}}" name="almacen_id" id="">
                                        </div>
                                        <br>
                                        <div class="col-sm-2"><strong>Garantia:</strong></div>
                                        <div class="col-sm-10"><input type="text" class="form-control" value="{{$cotizacion->garantia}}" name="garantia" readonly></div>
                                        <br>
                                        <div class="col-sm-2"><strong>Fecha de Emisión:</strong></div>
                                        <div class="col-sm-10"><input type="date" class="form-control" value="{{date("Y-m-d")}}"  readonly="readonly" name=fecha_emision></div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 " style="height:  120px">
                            <div class="form-control">
                                <strong>Observaciones:</strong><br>
                                <textarea class="form-control" name="observacion">{{$cotizacion->observacion}}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th style="width:10%">Código Item</th>
                                    <th style="width:10%">Cantidad</th>
                                    <th>Descripción</th>
                                    {{-- <th>Stock</th> --}}
                                    <th style="width:10%">Valor Unitario</th>
                                    <th style="width:10%">Valor Venta </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotizacion_registros as $index => $cotizacion_registro)
                                {{-- @if($validor[$index]==1) --}}
                                <tr>
                                    @if(isset($cotizacion_registro->producto_id))
                                        <td>{{$cotizacion_registro->producto->codigo_producto}}</td>
                                        <td>{{$cotizacion_registro->cantidad}} <input type="hidden" value="{{$cotizacion_registro->cantidad}}" name="cantidad_art[]" id=""></td>
                                        <td>
                                           <p >{{$cotizacion_registro->producto->nombre}}</p>
                                           <textarea class="form-control" name="descripcion_item[]" placeholder="Descripción del item" rows="2" cols="2">{{$cotizacion_registro->descripcion_item}}</textarea>
                                        </td>
                                        <div style="display: none">
                                            @if(strpos($cotizacion_registro->producto->tipo_afec_i_producto->informacion,'Gravado') !== false)
                                                {{ $tot_igv_unit = $cotizacion_registro->precio_unitario_comi + ( $cotizacion_registro->precio_unitario_comi  * ($igv->igv_total/100)) }}
                                            @else
                                                {{ $tot_igv_unit = $cotizacion_registro->precio_unitario_comi}}
                                            @endif
                                            
                                        </div>
                                        <td>
                                            {{number_format(round($tot_igv_unit ,2),2)}}
                                        </td>
                                        <td>
                                            {{number_format(round($tot_igv_unit * $cotizacion_registro->cantidad ,2),2)}}
                                        </td>
                                    @else
                                       <td>{{$cotizacion_registro->servicio->codigo_servicio}}</td>
                                       <td>{{$cotizacion_registro->cantidad}}<input type="hidden" value="{{$cotizacion_registro->cantidad}}" name="cantidad_art[]" id=""></td>
                                        <td>
                                            <p>{{$cotizacion_registro->servicio->nombre}} / {{$cotizacion_registro->servicio->descripcion}}</p>
                                            <textarea class="form-control" name="descripcion_item[]" placeholder="Descripción del item" rows="2" cols="2">{{$cotizacion_registro->descripcion_item}}</textarea>
                                        </td>
                                        <div style="display: none">
                                            @if(strpos($cotizacion_registro->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false)
                                                {{ $tot_igv_unit = $cotizacion_registro->precio_unitario_comi + ( $cotizacion_registro->precio_unitario_comi  * ($igv->igv_total/100)) }}
                                            @else
                                                   
                                            @endif
                                        </div>
                                        <td>
                                            {{number_format(round($tot_igv_unit ,2),2)}}
                                        </td>
                                        <td>
                                            {{number_format(round($tot_igv_unit * $cotizacion_registro->cantidad ,2),2)}}
                                        </td>
                                    @endif
                                   <td style="display: none">
                                       {{$sub_total=($cotizacion->op_gravada)+($cotizacion->op_exonerada)+($cotizacion->op_inafecta)}}
                                       {{$sub_total_gravado=($cotizacion->op_gravada)}}
                                       S/.{{$igv_p=round($sub_total_gravado, 2)*($igv->igv_total/100)}}
                                       {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                       {{$end2=number_format(round($sub_total, 2)+round($igv_p, 2),2)}}
                                        
                                   </td>
                                </tr>
                                {{-- @endif --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <h3 >
                                <?php 
                                    use Luecano\NumeroALetras\NumeroALetras;
                                    $v=new NumeroALetras() ;
                                    $letra=($v->toInvoice($end, 2));
                                    $end_final_point=strstr($end2, '.',false);
                                    $end_final=str_replace('.', '',$end_final_point);
                                ?>
                                Son : {{ucfirst(strtolower($letra))}} {{$cotizacion->moneda->nombre}}
                            </h3>
                        </div>
                        <div class="col-sm-4 form-control" align="center">
                            <p class=" a"> Importe Total</p>
                            <span>{{$cotizacion->moneda->simbolo}}</span>
                            <span class="impor_t">{{number_format(round($end,2),2)}}</span>
                        </div>
                    </div>
                    <div class="row" align="center" >
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4" align="center" >
                            <button class="btn btn-primary " style="margin-top: 5px" type="button"  id="boton"><i class="fa fa-cloud-upload" aria-hidden="true" >Guardar</i></button>&nbsp;
                            <button type="submit" hidden id="button_submit">Guardar Hidden</button>
                        </div>
                    </div>
                    <br>
                    @include('layout_bancos')
                </div>
            </div>
        </div>
    </form>
</div>

<style type="text/css">
    .ruc{border-radius: 10px; height: 150px;}
    .form-control{border-radius: 10px;margin-bottom: 1em;}
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


{{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
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
{{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<script>
    $("#boton").on(" click",function(buton){
        document.getElementById('button_submit').click();
    });

</script>
<script>
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
</script>
@endsection