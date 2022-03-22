@extends('layout')

@section('title', 'Nota Credito')
@section('breadcrumb', 'Nota Credito')
@section('breadcrumb2', 'Nota Credito')
@section('href_accion', route('nota-credito.index'))
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
                                <h2>NOTA DE CREDITsssO</h2>
                                {{$notas_credito->codigo_n_c}}
                            </center>
                        </div>
                    </div>
                </div><br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3> Datos Generales</h3>
                            <div align="left">
                                @if($estado==0)
                                    <strong>Cliente:</strong>
                                    @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->cliente->nombre}}
                                    @else{{$notas_credito->nota_i_facturacion->cotizacion->cliente->nombre}}
                                    @endif <br>
                                    <strong>R.U.C:</strong>
                                    @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->cliente->numero_documento}}
                                    @else{{$notas_credito->nota_i_facturacion->cotizacion->cliente->numero_documento}}
                                    @endif <br>
                                    <strong>Direccion:</strong>
                                    @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->cliente->direccion}}
                                    @else{{$notas_credito->nota_i_facturacion->cotizacion->cliente->direccion}}
                                    @endif <br>
                                    <strong>Condiciones de Pago:</strong>
                                    @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->forma_pago->nombre }}
                                    @else{{$notas_credito->nota_i_facturacion->cotizacion->forma_pago->nombre }}
                                    @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($notas_credito->nota_i_facturacion->cliente_id)){{$notas_credito->nota_i_facturacion->moneda->nombre }}
                                    @else{{$notas_credito->nota_i_facturacion->cotizacion->moneda->nombre }}
                                    @endif<br>
                                @else
                                    <strong>Cliente:</strong>
                                    @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->cliente->nombre}}
                                    @else{{$notas_credito->nota_i_boleta->cotizacion->cliente->nombre}}
                                    @endif <br>
                                    <strong>R.U.C:</strong>
                                    @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->cliente->numero_documento}}
                                    @else{{$notas_credito->nota_i_boleta->cotizacion->cliente->numero_documento}}
                                    @endif <br>
                                    <strong>Direccion:</strong>
                                    @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->cliente->direccion}}
                                    @else{{$notas_credito->nota_i_boleta->cotizacion->cliente->direccion}}
                                    @endif <br>
                                    <strong>Condiciones de Pago:</strong>
                                    @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->forma_pago->nombre }}
                                    @else{{$notas_credito->nota_i_boleta->cotizacion->forma_pago->nombre }}
                                    @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($notas_credito->nota_i_boleta->cliente_id)){{$notas_credito->nota_i_boleta->moneda->nombre }}
                                    @else{{$notas_credito->nota_i_boleta->cotizacion->moneda->nombre }}
                                    @endif<br>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" >
                            <h3>Condiciones Generales</h3>
                            <div align="left">
                                @if($estado==0)
                                    <strong>Documento:</strong>
                                    {{$notas_credito->nota_i_facturacion->codigo_fac}}<br>
                                    <strong>Tipo de operacion:</strong>
                                    @switch($notas_credito->motivo)
                                        @case(01)
                                        Anulacion de la operacion<br>
                                        @break
                                        @case(02)
                                        Anulacion por error en el ruc<br>
                                        @break
                                        @case(03)
                                        Correcion por error en la descripcion<br>
                                        @break
                                        @case(04)
                                        Devolucion total<br>
                                        @break
                                    @endswitch
                                    <strong>Tipo de sustento:</strong>
                                    {{$notas_credito->tipo}}<br>
                                    <strong>Fecha Emision:</strong>c
                                    {{$notas_credito->created_at}}<br>
                                @else
                                    <strong>Documento:</strong>
                                    {{$notas_credito->nota_i_boleta->codigo_boleta}}<br>
                                    <strong>Tipo de operacion:</strong>
                                    @switch($notas_credito->motivo)
                                        @case(01)
                                        Anulacion de la operacion<br>
                                        @break
                                        @case(02)
                                        Anulacion por error en el ruc<br>
                                        @break
                                        @case(03)
                                        Correcion por error en la descripcion<br>
                                        @break
                                        @case(04)
                                        Devolucion total<br>
                                        @break
                                    @endswitch
                                    <strong>Tipo de sustento:</strong>
                                    {{$notas_credito->tipo}}<br>
                                    <strong>Fecha Emision:</strong>
                                    {{$notas_credito->created_at}}<br><br>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12" align="center">
                        <div class="form-control" style="border: none;height: auto" >
                            <div align="left">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>ITEM</th>
                                    <th>Codigo Producto</th>
                                    <th>Cantidad</th>
                                    <th>Descripción</th>
                                    <th>Precio unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <span hidden="hidden">{{$u=1}} </span>
                                <tr>
                                    @foreach($notas_credito_registros as $e => $notas_credito_registro)
                                        <tr>
                                            <td>{{$u++}}</td>
                                            @if(isset($notas_credito_registro->producto_id))
                                                <td>{{$notas_credito_registro->producto->codigo_producto}}</td>
                                            @else
                                                <td>{{$notas_credito_registro->servicio->codigo_servicio}}</td>
                                            @endif
                                            <td>{{$notas_credito_registro->cantidad}}</td>

                                            <td>
                                                @if(isset($notas_credito_registro->producto_id))
                                                    {{$notas_credito_registro->producto->nombre}} 
                                                @else
                                                    {{$notas_credito_registro->servicio->nombre}} 
                                                @endif
                                                <br><strong>N/S:</strong>
                                                {{$notas_credito_registro->numero_serie}}
                                            </td>

                                            <td>{{$notas_credito_registro->precio}}</td>
                                            <td>{{$notas_credito_registro->precio* $notas_credito_registro->cantidad }}</td>
                                            <td style="display: none">
                                                
                                                {{$sub_total=($notas_credito_registro->nota_credito_ids->op_gravada)+($notas_credito_registro->nota_credito_ids->op_inafecta)+($notas_credito_registro->nota_credito_ids->op_exonerada)}}
                                                {{$sub_total_gravado=($notas_credito_registro->nota_credito_ids->op_gravada)}}
                                                {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                                {{$end=round($sub_total, 2)+round($igv_p, 2)}} 
                                                {{$end2=number_format(round($sub_total, 2)+round($igv_p, 2),2)}}
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tr>

                               <tr>
                                
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br><br><br><br>
                <div class="row">
                    <div class="col-sm-8">
                        <h3 align="left">
                            <?php $v=new CifrasEnLetras() ;
                            $letra=($v->convertirEurosEnLetras($end));
                            $letra_final = ucfirst(strstr($letra, 'soles',true));
                            $end_final_point=strstr($end2, '.',false);
                            $end_final=str_replace('.', '',$end_final_point);
                        ?>
                        Son: {{$letra_final}} con {{$end_final}}/100
                        @if(isset($notas_credito->facturacion_id))
                            {{$notas_credito->nota_i_facturacion->moneda->nombre}}
                        @else
                            {{$notas_credito->nota_i_boleta->moneda->nombre}}
                        @endif
                        {{-- {{$end2}} --}}
                    </h3>
                </div>
                <div class="col-sm-4 form-control">
                    {{-- <div class="col-sm-4 form-control" > --}}
                        <span style="display: block;float: left"> Subtotal:</span>
                        <span style="display: block;float: right;"> 
                            @if(isset($notas_credito->facturacion_id))
                                {{$simbologia=$notas_credito->nota_i_facturacion->moneda->simbolo}} 
                            @else
                                {{$simbologia=$notas_credito->nota_i_boleta->moneda->simbolo}} 
                            @endif 
                                {{number_format($sub_total, 2)}}</span>
                        <br>
                        <span style="display: block;float: left"> Op. Gravada: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{number_format($notas_credito->op_gravada,2)}}</span><br>
                        <span style="display: block;float: left"> Op. Inafecta: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{ number_format($notas_credito->op_inafecta,2)}}</span><br>
                        <span style="display: block;float: left"> Op. Exonerada: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{number_format($notas_credito->op_exonerada,2)}} </span><br>
                        <span style="display: block;float: left"> I.G.V.: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{number_format(round($igv_p, 2),2)}}</span><br>
                        <span style="display: block;float: left"> Importe Total: </span>
                        <span style="display: block;float: right">{{$simbologia}} {{number_format(round($end, 2),2)}}</span>
    
                    </div>
                </div>
                <br>
                {{-- <div class="row">
                    <div class="col-sm-12 form-control" style="height:  120px">
                        <strong>Observaciones:</strong><br>
                        {{$notas_credito->observacion}}
                    </div>
                </div> --}}
                <br>
              <br>
            </div>
        </div>
    </div>
</div>

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


<script>
    var estado=1;
    function check(i){
        if(document.getElementById(`inlineCheckbox_${i}`).value == "false"){
            document.getElementById(`input_disabled_${i}`).disabled = true;
            document.getElementById(`inlineCheckbox_${i}`).value = "true"
        }else{
            document.getElementById(`input_disabled_${i}`).disabled = false;
            document.getElementById(`inlineCheckbox_${i}`).value = "false"
        }
    }
</script>
@endsection
