@extends('layout')

@section('title', 'Nota debito')
@section('breadcrumb', 'Nota debito')
@section('breadcrumb2', 'Nota debito')
@section('href_accion', route('nota-debito.index'))
@section('value_accion', 'atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title d-flex justify-content-between" style="padding-right: 3.1%">
            <span class="dropdown" style="margin-top: 5px;margin-bottom: 8px;margin-left: 10px">
                <a id="dropdownTipoNotaDebito" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                style="cursor:pointer;">
                    <i class="fa fa-arrow-left text-muted"></i>
                </a>

                <ul class="dropdown-menu animated fadeInRight m-t-xs" aria-labelledby="dropdownTipoNotaDebito">
                    <li style="padding: 3px 12px;"><b>Seleccionar tipo:</b></li>
                    <li>
                        <a class="btn btn-w-m btn-link" href="{{ route('nota-debito.create') }}">Factura</a>
                    </li>
                    <li>
                        <a class="btn btn-w-m btn-link" href="{{ route('nota-debito.create_boleta') }}">Boleta</a>
                    </li>
                </ul>
            </span>
            <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up text-muted"></i>
                </a>
                <a class="" href="{{ route('comprobantes.index_nota_debito') }}">
                    <i class="fa fa-times text-muted"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content" style="padding-right: 3.1%;padding-left: 3.1%; padding-bottom: 10px;">
            <div class="row tooltip-demo">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6" align="right">
                    <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('nota_debito.pdf' ,$notas_debito->id)}}">
                        <input type="text" name="name" maxlength="50" hidden="" value="{{$notas_debito->codigo_n_d}}"  >
                        <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button>
                    </form>
                    <a class="btn btn-success" href="{{route('nota_debito.print',$notas_debito->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
                    {{-- @if(Auth::user()->email_creado == 1)
                        <form action="{{ route('email.nota_credito', $notas_debito->id )}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn"  >
                            @csrf
                            <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=""  formtarget="_blank"  data-original-title="Enviar por correo">
                                <i class="fa fa-envelope fa-lg" ></i>
                            </button>
                        </form>
                    @endif --}}
                    <div id="auto" onclick="divAuto()">
                        <a class="btn btn-success" style="background: green;border-color: green;" data-toggle="tooltip"
                            data-placement="bottom" title="" data-original-title="Enviar a">
                            <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                        </a>
                    </div>
                    <div id="div-mostrar" style="height: 0px; overflow: hidden;">
                        <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="btn"
                            style="text-align: none;padding-right: 0;padding-left: 0;">
                            @csrf
                            <input type="tel" name="numero" value="{{ $notas_debito->cliente_obj->celular ?? '' }}" />
                            <input type="text" name="mensaje" id="texto_orden" hidden="" />
                            <input type="text" hidden="" name="url"
                                value="{{ route('nota_debito.pdf', $notas_debito->id) }}?archivo=">
                            <input type="text" name="name_sin_cambio" hidden=""
                                value="Nota de Débito_{{ $notas_debito->codigo_n_d }}" />
                            <button type="submit" class="btn btn-success" style="background: green;border-color: green;"
                                formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title=""
                                data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" style="margin-top: -26px;">
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
                                <h5>{{$notas_debito->codigo_n_d}}</h5>
                            </center>
                        </div>
                    </div>
                </div><br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3> Datos Generales</h3>
                            <div align="left">
                                {{-- @if (isset($notas_debito->facturacion_id) || $notas_debito->facturacion_m_id) --}}
                                    <strong>Cliente:</strong>
                                    @if(isset($document->cliente_id))
                                        {{$document->cliente->nombre}}
                                    @else
                                        {{$document->cotizacion->cliente->nombre}}
                                    @endif <br>
                                    <strong>R.U.C:</strong>
                                    @if(isset($document->cliente_id))
                                        {{$document->cliente->numero_documento}}
                                    @else
                                        {{$document->cotizacion->cliente->numero_documento}}
                                    @endif<br>
                                    <strong>Direccion:</strong>
                                    @if(isset($document->cliente_id))
                                        {{$document->cliente->direccion}}
                                    @else
                                        {{$document->cotizacion->cliente->direccion}}
                                    @endif <br>
                                    <strong>Condiciones de Pago:</strong>
                                    @if(isset($document->cliente_id))
                                        {{$document->forma_pago->nombre }}
                                    @else
                                        {{$document->cotizacion->forma_pago->nombre }}
                                    @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($document->cliente_id))
                                        {{$document->moneda->nombre }}
                                    @else
                                        {{$document->cotizacion->moneda->nombre }}
                                    @endif<br>
                                {{-- @else
                                    HOlaas
                                @endif --}}
                                {{-- @if(isset($notas_debito->facturacion_id))
                                    <strong>Cliente:</strong>
                                    @if(isset($notas_debito->nota_i_facturacion->cliente_id)){{$notas_debito->nota_i_facturacion->cliente->nombre}}
                                    @else{{$notas_debito->nota_i_facturacion->cotizacion->cliente->nombre}}
                                    @endif <br>
                                    <strong>R.U.C:</strong>
                                    @if(isset($notas_debito->nota_i_facturacion->cliente_id)){{$notas_debito->nota_i_facturacion->cliente->numero_documento}}
                                    @else{{$notas_debito->nota_i_facturacion->cotizacion->cliente->numero_documento}}
                                    @endif <br>
                                    <strong>Direccion:</strong>
                                    @if(isset($notas_debito->nota_i_facturacion->cliente_id)){{$notas_debito->nota_i_facturacion->cliente->direccion}}
                                    @else{{$notas_debito->nota_i_facturacion->cotizacion->cliente->direccion}}
                                    @endif <br>
                                    <strong>Condiciones de Pago:</strong>
                                    @if(isset($notas_debito->nota_i_facturacion->cliente_id)){{$notas_debito->nota_i_facturacion->forma_pago->nombre }}
                                    @else{{$notas_debito->nota_i_facturacion->cotizacion->forma_pago->nombre }}
                                    @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($notas_debito->nota_i_facturacion->cliente_id)){{$notas_debito->nota_i_facturacion->moneda->nombre }}
                                    @else{{$notas_debito->nota_i_facturacion->cotizacion->moneda->nombre }}
                                    @endif<br>
                                @else
                                    <strong>Cliente:</strong>
                                    @if(isset($notas_debito->nota_i_boleta->cliente_id)){{$notas_debito->nota_i_boleta->cliente->nombre}}
                                    @else{{$notas_debito->nota_i_boleta->cotizacion->cliente->nombre}}
                                    @endif <br>
                                    <strong>R.U.C:</strong>
                                    @if(isset($notas_debito->nota_i_boleta->cliente_id)){{$notas_debito->nota_i_boleta->cliente->numero_documento}}
                                    @else{{$notas_debito->nota_i_boleta->cotizacion->cliente->numero_documento}}
                                    @endif <br>
                                    <strong>Direccion:</strong>
                                    @if(isset($notas_debito->nota_i_boleta->cliente_id)){{$notas_debito->nota_i_boleta->cliente->direccion}}
                                    @else{{$notas_debito->nota_i_boleta->cotizacion->cliente->direccion}}
                                    @endif <br>
                                    <strong>Condiciones de Pago:</strong>
                                    @if(isset($notas_debito->nota_i_boleta->cliente_id)){{$notas_debito->nota_i_boleta->forma_pago->nombre }}
                                    @else{{$notas_debito->nota_i_boleta->cotizacion->forma_pago->nombre }}
                                    @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($notas_debito->nota_i_boleta->cliente_id)){{$notas_debito->nota_i_boleta->moneda->nombre }}
                                    @else{{$notas_debito->nota_i_boleta->cotizacion->moneda->nombre }}
                                    @endif<br>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" >
                            <h3>Condiciones Generales</h3>
                            <div align="left">
                                {{-- @if($notas_debito->facturacion_id || $notas_debito->facturacion_m_id) --}}
                                    <strong>Documento: </strong>
                                    @if ($notas_debito->facturacion_id  != NULL)
                                        {{ $notas_debito->nota_i_facturacion->codigo_fac }}<br>
                                    @elseif($notas_debito->boleta_id  != NULL)
                                        {{ $notas_debito->nota_i_boleta->codigo_boleta }}<br>
                                    @elseif($notas_debito->boleta_m_id  != NULL)
                                        {{ $notas_debito->nota_i_boleta_manual->codigo_boleta }}<br>
                                    @else
                                        {{ $notas_debito->nota_i_fac_manual->codigo_fac }}<br>
                                    @endif
                                    <strong>Orden de Compra:</strong>
                                    {{$document->orden_compra}}<br>
                                    <strong>Guia de Remision:</strong>
                                    {{$document->guia_remision}}<br>
                                    <strong>Fecha Emision:</strong>
                                    {{$document->fecha_emision}}<br>
                                    {{-- <strong>Fecha de Vencimiento:</strong>
                                    {{$document->fecha_vencimiento}}<br> --}}
                                {{-- @else
                                    <strong>Orden de Compra:</strong>
                                    {{$document->orden_compra}}<br>
                                    <strong>Guia de Remision:</strong>
                                    {{$document->guia_remision}}<br>
                                    <strong>Fecha Emision:</strong>
                                    {{$document->fecha_emision}}<br>
                                    <strong>Fecha de Vencimiento:</strong>
                                    {{$document->fecha_vencimiento}}<br>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-12" style="padding-top: 15px">
                        <div class="form-control">
                            <h3>Tipo</h3>
                            <div align="left" class="row">
                                <div class="col-sm-6">
                                    <strong>Tipo:</strong>
                                    @if ($notas_debito->tipo == 01)
                                        Interes por mora
                                    @elseif($notas_debito->tipo == 02)
                                        Aumentos en el valor
                                    @else
                                        Penalidades
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <strong>Motivo:</strong>
                                    {{$notas_debito->motivo}}
                                </div>
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
                                    <th style="width: 5%;">ITEM</th>
                                    <th style="width: 15%;">Codigo Producto</th>
                                    <th style="width: 45%;">Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Precio unitario</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <span hidden="hidden">{{$u=1}} </span>
                                <tr>
                                    @foreach($notas_debito_registros as $e => $notas_debito_registro)
                                        <tr>
                                            <td>{{$u++}}</td>
                                            @if (isset($notas_debito_registro->producto_id))
                                                <td>{{$notas_debito_registro->producto->codigo_producto}}</td>
                                                <td>{{$notas_debito_registro->producto->nombre}} <br><strong>N/S:</strong>{{$notas_debito_registro->numero_serie}}</td>
                                            @else
                                                <td>{{$notas_debito_registro->servicio->codigo_servicio}}</td>
                                                <td>{{$notas_debito_registro->servicio->nombre}} <br><strong>N/S:</strong>{{$notas_debito_registro->numero_serie}}</td>
                                            @endif
                                            <td>{{$notas_debito_registro->cantidad}}</td>
                                            <td>{{$notas_debito_registro->precio}}</td>
                                            <td>{{$notas_debito_registro->precio* $notas_debito_registro->cantidad }}</td>
                                            <td style="display: none">
                                                {{$sub_total=($notas_debito_registro->nota_id->op_gravada)+($notas_debito_registro->nota_id->op_inafecta)+($notas_debito_registro->nota_id->op_exonerada)}}
                                                {{$sub_total_gravado=($notas_debito_registro->nota_id->op_gravada)}}
                                                {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                                {{$end= round($sub_total, 2)+round($igv_p, 2)}}
                                                {{$end2=number_format(round($sub_total, 2)+round($igv_p, 2),2)}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                            {{$document->moneda->nombre}}
                        </h3>
                    </div>
                    <div class="col-sm-4 form-control">
                        {{-- <div class="col-sm-4 form-control" > --}}
                            <span style="display: block;float: left"> Subtotal:</span>
                            <span style="display: block;float: right;">
                                    {{$simbologia=$document->moneda->simbolo}}.
                                    {{number_format($sub_total, 2)}}</span>
                            <br>
                            <span style="display: block;float: left"> Op. Gravada: </span>
                            <span style="display: block;float: right">{{$simbologia}} {{number_format($notas_debito->op_gravada,2)}}</span><br>
                            <span style="display: block;float: left"> Op. Inafecta: </span>
                            <span style="display: block;float: right">{{$simbologia}} {{ number_format($notas_debito->op_inafecta,2)}}</span><br>
                            <span style="display: block;float: left"> Op. Exonerada: </span>
                            <span style="display: block;float: right">{{$simbologia}} {{number_format($notas_debito->op_exonerada,2)}} </span><br>
                            <span style="display: block;float: left"> I.G.V.: </span>
                            <span style="display: block;float: right">{{$simbologia}} {{number_format(round($igv_p, 2),2)}}</span><br>
                            <span style="display: block;float: left"> Importe Total: </span>
                            <span style="display: block;float: right">{{$simbologia}} {{number_format(round($end, 2),2)}}</span>

                        </div>
                    </div>
                <br><br><br><br>
            </div>
        </div>
    </div>
</div>

<style>
    #auto {
        display: inline-block;
    }

    #div-mostrar {
        margin: auto;
        height: 0px;
        transition: height .4s;
        text-align: right;
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


<script>
    var estado = 1;
    function check(i){
        if(document.getElementById(`inlineCheckbox_${i}`).value == "false"){
            document.getElementById(`input_disabled_${i}`).disabled = true;
            document.getElementById(`inlineCheckbox_${i}`).value = "true"
        }else{
            document.getElementById(`input_disabled_${i}`).disabled = false;
            document.getElementById(`inlineCheckbox_${i}`).value = "false"
        }
    }

    var clic = 1;
    function divAuto() {
        if (clic == 1) {
            document.getElementById("div-mostrar").style.height = "50px";
            clic = clic + 1;
        } else {
            document.getElementById("div-mostrar").style.height = "0px";
            clic = 1;
        }
    }
</script>
@endsection
