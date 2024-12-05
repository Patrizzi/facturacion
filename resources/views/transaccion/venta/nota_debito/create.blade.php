@extends('layout')

@section('title', 'Nota Debito')
@section('breadcrumb', 'Nota Debito')
@section('breadcrumb2', 'Nota Debito')
@section('href_accion', route('nota-debito.index'))
@section('value_accion', 'atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" style="margin-top: -5px;">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    <div class="col-sm-4 text-left" align="left">
                        <address class="col-sm-4" align="left">
                            <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                        </address>
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-control ruc" style="height: 125px">
                            <center>
                                <h3 style="padding-top:10px ">R.U.C : {{$empresa->ruc}}</h3>
                                <h2>NOTA DE DEBITO</h2>
                                <h5> {{$nota_debito_numero}}</h5>
                            </center>
                        </div>
                    </div>
                </div><br>
                <form action="{{route('nota-debito.nota_debito_store_factura',$facturacion->id)}}"  enctype="multipart/form-data" method="post" id="post_form" >
                    @csrf
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">

                        <div class="form-control">
                            <h3> Datos Generales</h3>
                            <div align="left">
                                <strong>Cliente:</strong>
                                @if(isset($facturacion->cliente_id)){{$facturacion->cliente->nombre}}
                                @else{{$facturacion->cotizacion->cliente->nombre}}
                                @endif <br>
                                <strong>R.U.C:</strong>
                                @if(isset($facturacion->cliente_id)){{$facturacion->cliente->numero_documento}}
                                @else{{$facturacion->cotizacion->cliente->numero_documento}}
                                @endif <br>
                                <strong>Direccion:</strong>
                                @if(isset($facturacion->cliente_id)){{$facturacion->cliente->direccion}}
                                @else{{$facturacion->cotizacion->cliente->direccion}}
                                @endif <br>
                                <strong>Condiciones de Pago:</strong>
                                @if(isset($facturacion->cliente_id)){{$facturacion->forma_pago->nombre }}
                                @else{{$facturacion->cotizacion->forma_pago->nombre }}
                                @endif 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Tipo de Moneda:</strong>
                                @if(isset($facturacion->cliente_id)){{$facturacion->moneda->nombre }}
                                @else{{$facturacion->cotizacion->moneda->nombre }}
                                @endif <br>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center" >
                        <div class="form-control" >
                            <h3>Condiciones Generales</h3>
                            <div align="left">
                                <strong>Orden de Compra:</strong>
                                {{$facturacion->orden_compra}} <br>
                                <strong>Guia de Remision:</strong>
                                {{$facturacion->guia_remision}} <br>
                                <strong>Fecha Emision:</strong>
                                {{$facturacion->fecha_emision}} <br>
                                <strong>Fecha de Vencimiento:</strong>
                                {{$facturacion->fecha_vencimiento }} <br>
                            </div>                                
                        </div>
                    </div>
                    <div class="col-sm-12" style="padding-top: 10px">
                        <div class="form-control">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-2"><strong>Tipo:</strong></div>
                                        <div class="col-sm-10">
                                            
                                            <select class="form-control" name="tipo">
                                                <option value="01" >Interes por mora</option>
                                                <option value="02">Aumentos en el valor</option>
                                                <option value="03">Penalidades</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-2"><strong>Motivo:</strong></div>
                                        <div class="col-sm-10">
                                            <input type="text" name="motivo" id="mot" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </div> --}}
                    <br>
                    
                    {{-- <div class="row" align="" style="padding-top: 10px;">
                        <div  class="form-control " align="left">
                            <div class="col-sm-6 " >
                                <div class="col-sm-4" >
                                    <strong>Motivo:</strong>
                                </div>
                                <div class="col-sm-8" >
                                    <select class="form-control" name="motivo">
                                        <option >Interes por mora</option>
                                        <option >Aumentos en el valor</option>
                                        <option >Penalidades</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">

                            </div>
                        </div>
                    </div> --}}
                </div>
                <br>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ITEM</th>
                                    <th>Codigo Item</th>
                                    <th style="width: 40%;">Descripción</th>
                                    <th >Cantidad</th>
                                    <th>Precio unitario</th>
                                    <th style="width: 12%;">Precio unitario Nuevo</th>
                                    <th style="width: 12%;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <span hidden="hidden">{{$u=1}} </span>
                                <span hidden="hidden"><input type="hidden" name="tipo_nota" value="{{$tipo}}"></span>
                                <tr>
                                    @foreach($facturacion_registro as $e => $facturacion_registros)
                                    <tr>
                                        <td><input class="form-check-input check_2" type="checkbox" id="inlineCheckbox_{{$e}}" name="inlineCheckbox_{{$e}}"  onclick="check('{{$e}}')" ></td>
                                        <td >{{$u++}}</td>
                                        @if(isset($facturacion_registros->producto_id))
                                            <td>{{$facturacion_registros->producto->codigo_producto}}</td>    
                                            <td>{{$facturacion_registros->producto->nombre}} <br><strong>N/S:</strong> {{$facturacion_registros->numero_serie}}</td>
                                        @else
                                            <td>{{$facturacion_registros->servicio->codigo_servicio}}</td>    
                                            <td>{{$facturacion_registros->servicio->nombre}} <br><strong>N/S:</strong> {{$facturacion_registros->numero_serie}}</td>
                                        @endif
                                        <td>{{$facturacion_registros->cantidad}}</td>
                                        
                                        <td>{{$facturacion_registros->precio}}</td>
                                        <td><input required="required" class="form-control" type="number" id="input_disabled_precio_{{$e}}" name="input_disabled_precio_{{$e}}" value="0" step="0.01" min="0.01" disabled></td>
                                        <td>{{$facturacion_registros->precio_unitario_comi* $facturacion_registros->cantidad }}</td>
                                        <td style="display: none">
                                            {{$sub_total=($facturacion_registros->factura_ids->op_gravada)+($facturacion_registros->factura_ids->op_inafecta)+($facturacion_registros->factura_ids->op_exonerada)}}
                                            {{$sub_total_gravado=($facturacion_registros->factura_ids->op_gravada)}}
                                            {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                            {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                        </td>
                                    </tr>
                                   {{--  <span hidden="hidden">{{$i=1}}</span>
                                   <span hidden="hidden">{{$i++}}</span> --}}
                                   @endforeach
                               </tr>

                               <tr>
                                <td colspan="13" align="right">
                                    <button type="button" id="enviar_pt"  class="btn btn-w-m btn-primary">Enviar</button>
                                    <button type="submit" id="submit_pt" style="display: none">enviar </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br><br><br><br>
            </form>
        </div>
    </div>
</div>
</div>

    <div class="wrapper wrapper-content">
        <div class="row animated fadeInDown">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h2><strong>Nota de Débito de {{$facturacion->codigo_fac}}</strong></h2>
                            </div>
                                <div class="col-lg-12">
                                    <div class="ibox">
                                        <div class="ibox-content">
                                                <!--Datos Generales -->
                                                <div class="panel panel-success">
                                                    <div class="panel-heading" >
                                                        <form action="{{route('nota-debito.nota_debito_store_factura',$facturacion->id)}}"  enctype="multipart/form-data" method="post" id="post_form" >
                                                        @csrf
                                                        <h3 class="text-center"><strong>Datos Generales</strong></h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label"><strong>Cliente:</strong></label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="@if(isset($facturacion->cliente_id)){{$facturacion->cliente->nombre}}
                                                                        @else{{$facturacion->cotizacion->cliente->nombre}}
                                                                        @endif" readonly/>
                                                                    </div>
                                                                </div>                                                  
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label"><strong>Condiciones:</strong></label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="@if(isset($facturacion->cliente_id)){{$facturacion->forma_pago->nombre }}
                                                                        @else{{$facturacion->cotizacion->forma_pago->nombre }}
                                                                        @endif " readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label"><strong>RUC o DNI:</strong></label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="@if(isset($facturacion->cliente_id)){{$facturacion->cliente->numero_documento}}
                                                                        @else{{$facturacion->cotizacion->cliente->numero_documento}}
                                                                        @endif" readonly/>
                                                                    </div>
                                                                </div>                                           
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label"><strong>Tipo:</strong></label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="@if(isset($facturacion->cliente_id)){{$facturacion->moneda->nombre }}
                                                                        @else{{$facturacion->cotizacion->moneda->nombre }}
                                                                        @endif" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-2 col-form-label"><strong>Dirección:</strong></label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control" value="@if(isset($facturacion->cliente_id)){{$facturacion->cliente->direccion}}
                                                                        @else{{$facturacion->cotizacion->cliente->direccion}}
                                                                        @endif" readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <!-- Condiciones Generales -->
                                                    <div class="panel panel-success">
                                                        <div class="panel-heading" >
                                                            <h3 class="text-center"><strong>Condiciones Generales</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label"><strong>Orden de Compra:</strong></label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" value="{{$facturacion->orden_compra}}" readonly />
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label"><strong>Guía de Remisión:</strong></label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control" value="{{$facturacion->guia_remision}}" readonly/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label"><strong>Tipo:</strong></label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control" name="tipo">
                                                                                <option value="01" >Interes por mora</option>
                                                                                <option value="02">Aumentos en el valor</option>
                                                                                <option value="03">Penalidades</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label"><strong>F. de Inicio:</strong></label>
                                                                        <div class="col-sm-8">
                                                                            <input class="form-control" value="{{$facturacion->fecha_emision}}" readonly/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label"><strong>F. de Vencimiento:</strong></label>
                                                                        <div class="col-sm-8">
                                                                            <input class="form-control" value="{{$facturacion->fecha_vencimiento}}" readonly/>
                                                                        </div>
                                                                    </div>
                                                                   <div class="form-group row">
                                                                        <label class="col-sm-4 col-form-label"><strong>Motivo:</strong></label>
                                                                        <div class="col-sm-8">
                                                                            <textarea type="textarea" name="motivo" id="mot" class="form-control" placeholder="Descripción" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Tabla-->
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr style="background-color: #3366cc; color: white; text-align: center;">
                                                                    <th>Acción</th>
                                                                    <th>N°</th>
                                                                    <th>Código</th>
                                                                    <th style="width: 40%;">Descripción</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Precio Unitario</th>
                                                                    <th style="width: 12%;">Nuevo Precio</th>
                                                                    <th style="width: 12%;">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <span hidden="hidden">{{$u=1}} </span>
                                                                <span hidden="hidden"><input type="hidden" name="tipo_nota" value="{{$tipo}}"></span>
                                                                @foreach($facturacion_registro as $e => $facturacion_registros)
                                                                    <tr>
                                                                    <td><input class="form-check-input i-checks check_2" type="checkbox" id="inlineCheckbox_{{$e}}" name="inlineCheckbox_{{$e}}"  onclick="check('{{$e}}')"></td>
                                                                    <td >{{$u++}}</td>
                                                                    @if(isset($facturacion_registros->producto_id))
                                                                        <td>{{$facturacion_registros->producto->codigo_producto}}</td>    
                                                                        <td>{{$facturacion_registros->producto->nombre}} <br><strong>N/S:</strong> {{$facturacion_registros->numero_serie}}</td>
                                                                    @else
                                                                        <td>{{$facturacion_registros->servicio->codigo_servicio}}</td>    
                                                                        <td>{{$facturacion_registros->servicio->nombre}} <br><strong>N/S:</strong> {{$facturacion_registros->numero_serie}}</td>
                                                                    @endif
                                                                    <td>{{$facturacion_registros->cantidad}}</td>
                                                                    <td>{{$facturacion_registros->precio}}</td>
                                                                    <td><input required="required" class="form-control" type="number" id="input_disabled_precio_{{$e}}" name="input_disabled_precio_{{$e}}" value="0" step="0.01" min="0.01" disabled></td>
                                                                    <td>{{$facturacion_registros->precio_unitario_comi* $facturacion_registros->cantidad }}</td>
                                                                    <td style="display: none">
                                                                        {{$sub_total=($facturacion_registros->factura_ids->op_gravada)+($facturacion_registros->factura_ids->op_inafecta)+($facturacion_registros->factura_ids->op_exonerada)}}
                                                                        {{$sub_total_gravado=($facturacion_registros->factura_ids->op_gravada)}}
                                                                        {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                                                        {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="text-center" style="margin-top: 20px;">
                                                        <button type="button" id="enviar_pt"   class="btn btn-success">Enviar</button>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>


<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] { -moz-appearance:textfield; }
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
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>

<script>
   $(document).ready(function(){
       $('.i-checks').iCheck({
           checkboxClass: 'icheckbox_square-green',
           radioClass: 'iradio_square-green',
       });
   });
</script>

<script>
    var estado=1;
    function check(i){
        if(document.getElementById(`inlineCheckbox_${i}`).value == "false"){
            
            document.getElementById(`input_disabled_precio_${i}`).disabled = true;
            document.getElementById(`inlineCheckbox_${i}`).value = "true"
        }else{
            
            document.getElementById(`input_disabled_precio_${i}`).disabled = false;
            document.getElementById(`inlineCheckbox_${i}`).value = "false"
        }
    }
    // function grabar(){
        $("#enviar_pt").click(function(e){
            var hola =  $('#mot').val();
            console.log(hola);
            e.preventDefault();
            if ($('.check_2:checked').length == 0 && $('#mot').val() ==  "") {
                $('#submit_pt').click();
            }else if($('.check_2:checked').length == 0 && $('#mot').val() != ""){
                toastr.warning("Seleccionar al menos 1 producto para la Nota de Debito",
                'Verifique si ha seleccionado al menos 1 producto', {
                    timeOut: 3000
                });
            }else{
                $('#submit_pt').click();
            }
        });
    // }
</script>
@endsection
