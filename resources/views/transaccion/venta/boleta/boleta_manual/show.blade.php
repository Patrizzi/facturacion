@extends('layout')
@section('title', 'Boleta Manual')
@section('atributo_actu', 'hidden')
@section('href_accion', route('boleta_manual.create'))
@section('value_accion', 'Agregar')
@section('content')

{{-- obtener errores --}}
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

{{-- obtener errores --}}
@if (Session::has('successMsg'))
<div style="padding-top: 20px;">
    <div class="alert alert-warning">
        <a class="alert-link" href="#">
            <li style="color: black">{{ Session::get('successMsg') }}</li>
        </a>
    </div>
</div>
@endif

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title" style="padding-right: 3.1%">
            <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a href="{{ route('comprobantes.index_boleta_manual') }}" title="Cerrar">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content" style="padding-right: 3.1%;padding-left: 3.1%; padding-bottom: 10px;">
            <div class="row tooltip-demo">
                <div class="col-sm-6">
                    <?php use Carbon\Carbon; use App\Boleta_m; ?>
                    @if($boleta->nota_credito != 0)
                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Motivo: {{ Boleta_m::search_motivo_nc($boleta->id)}}">
                            <a class="btn btn-primary" href="{{route('nota-credito.show',Boleta_m::nota_credito_id($boleta->id))}}">Ver nota de Credito</a>
                        </span>
                    @endif
                </div>
                <div class="col-sm-6" align="right">
                    <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{ route('boleta_manual.pdf', $boleta->id) }}">
                        <input type="text" name="name" maxlength="50" hidden="" value="{{ $boleta->codigo_boleta }}">
                        <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF"><i class="fa fa-file-pdf-o fa-lg"></i> </button>
                    </form>
                    <a href="{{route('boleta_manual.ticket', $boleta->id)}}" class="btn btn-info" target="_blank"><i class="fa fa-ticket fa-lg"></i></a>
                    <a class="btn btn-success" href="{{ route('boleta_manual.print', $boleta->id) }}" target="_blank"
                        class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title=""
                        data-original-title="Imprimir"><i class="fa fa-print fa-lg"></i>
                    </a>
                    @if(Auth::user()->email_creado == 1)
                        <form action="{{ route('email.boleta_manual', $boleta->id )}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn"  >
                            @csrf
                            <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=""  formtarget="_blank"  data-original-title="Enviar por correo">
                                <i class="fa fa-envelope fa-lg" ></i>
                            </button>
                        </form>
                    @endif
                    <div id="auto" onclick="divAuto()">
                        <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a">
                            <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                        </a>
                    </div>
                    <div id="div-mostrar" style="height: 0px; overflow: hidden;">
                        <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="btn"
                            style="text-align: none;padding-right: 0;padding-left: 0;">
                            @csrf
                            <input type="tel" name="numero" value="{{ $boleta->cliente->celular }}" />
                            <input type="text" name="mensaje" id="texto_orden" hidden="" />
                            <input type="text" hidden="" name="url"
                                value="{{ route('boleta_manual.pdf', $boleta->id) }}?archivo=">
                            <input type="text" name="name_sin_cambio" hidden=""
                                value="BoletaM_{{ $boleta->codigo_boleta }}" />
                            <button type="submit" class="btn  btn-success" style="background: green;border-color: green;"
                                formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title=""
                                data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i> </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: -26px;">
            @if($boleta->b_electronica == 2)
                    <div id="watermark">
                        <p>Anulado</p>
                    </div>
                @endif
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row" style="align-items: center; justify-content: center">
                    @include('layout_cabecera_ventas')
                    <div class="col-sm-4 ">
                        <div class="form-control ruc" style="height: 125px">
                            <center>
                                <h3 style="padding-top:10px ">R.U.C : {{ $empresa->ruc }}</h3>
                                <h2>BOLETA ELECTRÓNICA</h2>
                                <h5> {{ $boleta->codigo_boleta }}</h5>
                            </center>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <div align="left">
                                <strong>Cliente:</strong>
                                    @if (isset($boleta->cliente_id))
                                        {{ $boleta->cliente->nombre }}
                                    @else
                                        {{ $boleta->cotizacion->cliente->nombre }}
                                    @endif
                                <br>
                                <strong>N° de Documento:</strong>
                                    @if (isset($boleta->cliente_id))
                                        {{ $boleta->cliente->numero_documento }}
                                        @else
                                        {{ $boleta->cotizacion->cliente->numero_documento }}
                                    @endif
                                <br>
                                <strong>Dirección:</strong>
                                    @if (isset($boleta->cliente_id))
                                        {{ $boleta->cliente->direccion }}
                                    @else
                                        {{ $boleta->cotizacion->cliente->direccion }}
                                    @endif
                                <br>
                                <strong>Condiciones de Pago:</strong>
                                    @if (isset($boleta->cliente_id))
                                        {{ $boleta->forma_pago->nombre }}
                                    @else
                                        {{ $boleta->cotizacion->forma_pago->nombre }}
                                    @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Tipo de Moneda:</strong>
                                    @if (isset($boleta->cliente_id))
                                        {{ $boleta->moneda->nombre }}
                                    @else
                                        {{ $boleta->cotizacion->moneda->nombre }}
                                    @endif
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-control">
                            <div align="left">
                                <strong>Orden de Compra:</strong>
                                {{ $boleta->orden_compra }}
                                <br>
                                <strong>Guia de Remisión:</strong>
                                {{ $boleta->guia_remision }}
                                <br>
                                <strong>Fecha Emisión:</strong>
                                {{ $boleta->fecha_emision }}
                                <br>
                                <strong>Fecha de Vencimiento:</strong>
                                {{ $boleta->fecha_vencimiento }}
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center">Item</th>
                                <th style="text-align:center">Código Producto</th>
                                <th>Descripción</th>
                                <th style="text-align:center">Cantidad</th>
                                <th style="text-align:center">Valor Unitario</th>

                                <th style="text-align:center">Valor Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <span hidden="hidden">{{ $i = 1 }} </span>
                            <tr>
                                @foreach ($boleta_registro as $boletas_registros)
                                    <td style="text-align:center">{{ $i }} </td>
                                    @if (isset($boletas_registros->producto_id))
                                        <td style="text-align:center">
                                            {{ $boletas_registros->producto->codigo_producto }}
                                        </td>
                                        <td>
                                            {{ $boletas_registros->producto->nombre }}
                                            {{ $boletas_registros->descripcion_item }}
                                            @if (isset($boletas_registros->numero_serie))
                                                <br><strong>N/S:</strong> {{ $boletas_registros->numero_serie }}
                                            @endif
                                        </td>
                                    @else
                                        <td style="text-align:center">{{ $boletas_registros->servicio->codigo_servicio }}</td>
                                        <td>
                                            {{ $boletas_registros->servicio->nombre }}
                                            {{ $boletas_registros->descripcion_item }}
                                            @if (isset($boletas_registros->numero_serie))
                                                <br><strong>N/S:</strong> {{ $boletas_registros->numero_serie }}
                                            @endif
                                        </td>
                                    @endif
                                    <td style="text-align:center">{{ $boletas_registros->cantidad }}</td>
                                    <td style="text-align:center">{{number_format($boletas_registros->precio,2)}}</td>

                                    <td style="text-align:center">{{number_format( $boletas_registros->precio * $boletas_registros->cantidad - ($boletas_registros->precio * $boletas_registros->cantidad * $boletas_registros->descuento/100),2) }}</td>

                                <td style="display: none">
                                    {{ $sub_total =$boletas_registros->boleta_i->op_gravada + $boletas_registros->boleta_i->op_inafecta +$boletas_registros->boleta_i->op_exonerada }}
                                    {{ $sub_total_gravado = $boletas_registros->boleta_i->op_gravada }}
                                    {{ $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100 }}
                                    {{ $end = round($sub_total, 2) + round($igv_p, 2) }}
                                    {{ $end2 = number_format(round($sub_total, 2) + round($igv_p, 2), 2) }}
                                </td>
                            </tr>
                            <span hidden="hidden">{{ $i++ }}</span>
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-8">
                        <h3 align="left">
                            <?php  use Luecano\NumeroALetras\NumeroALetras;
                                $v=new NumeroALetras() ;
                                $letra=($v->toInvoice($end, 2));
                            // $letra_final = ucfirst(strstr($letra, 'soles', true));
                            // $end_final_point = strstr($end2, '.', false);
                            // $end_final = str_replace('.', '', $end_final_point);
                            ?>
                            Son : {{ucfirst(mb_strtolower($letra,'UTF-8'))}} {{ $boleta->moneda->nombre }}
                            {{-- {{$end2}} --}}
                        </h3>
                    </div>
                    <div class="col-sm-4 form-control">
                        {{-- <div class="col-sm-4 form-control" > --}}
                        <span style="display: block;float: left"> Sub Total:</span>
                        <span style="display: block;float: right;"> {{ $simbologia = $boleta->moneda->simbolo }}
                            {{ number_format($sub_total, 2) }}</span>
                        <br>
                        <span style="display: block;float: left"> Op. Agravada: </span>
                        <span style="display: block;float: right">{{ $simbologia }}
                            {{ number_format($boleta->op_gravada, 2) }}</span><br>
                        <span style="display: block;float: left"> Op. Inafecta: </span>
                        <span style="display: block;float: right">{{ $simbologia }}
                            {{ number_format($boleta->op_inafecta, 2) }}</span><br>
                        <span style="display: block;float: left"> Op. Exonerada: </span>
                        <span style="display: block;float: right">{{ $simbologia }}
                            {{ number_format($boleta->op_exonerada, 2) }} </span><br>
                        <span style="display: block;float: left"> I.G.V.: </span>
                        <span style="display: block;float: right">{{ $boleta->moneda->simbolo }}
                            {{ number_format(round($igv_p, 2), 2) }}</span><br>
                        <span style="display: block;float: left"> Importe Total: </span>
                        <span style="display: block;float: right">{{ $boleta->moneda->simbolo }}
                            {{ number_format(round($end, 2), 2) }}</span>

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 form-control" style="height:  120px">
                        <strong>Observaciones:</strong><br>
                        {{ $boleta->observacion }}
                    </div>
                </div>
                <br>
                @include('layout_bancos')
                <br>
            </div>
        </div>
    </div>

</div>
<style>
    #auto {
        /*padding: -100px;*/
        /*background: orange;*/
        /*width: 95px;*/
        cursor: pointer;
        /*margin-top: 10px;*/
        /*margin-bottom: 10px;*/
        box-shadow: 0px 0px 1px #000;
        display: inline-block;
    }

    #auto:hover {
        opacity: .8;
    }

    #div-mostrar {
        /*width: 50%;*/
        margin: auto;
        height: 0px;
        /*margin-top: -5px*/
        /*background: #000;*/
        /*box-shadow: 10px 10px 3px #D8D8D8;*/
        transition: height .4s;
        color: white;
        text-align: right;
    }

    #auto:hover {
        opacity: .8;
    }

    #auto:hover+#div-mostrar {
        height: 50px;
    }
    #watermark {
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 0;
    }
    #watermark p {
        position: absolute;
        color:   rgba(120, 120, 120, 0.31);
        font-weight: bolder;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        font-size: 95px;
        pointer-events: none;
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        top: 45%;
        right: 40%;
        z-index: 10;
    }
</style>

<style>
    .form-control {
        margin-top: 5px;
        border-radius: 5px
    }

    p#texto {
        text-align: center;
        color: black;
    }

    input#archivoInput {
        position: absolute;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        width: 100%;
        height: 100%;
        opacity: 0;
    }

</style>
<script>
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
@stop
