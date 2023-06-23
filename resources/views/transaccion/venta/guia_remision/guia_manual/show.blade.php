@extends('layout')

@section('title', 'Ver Guia de Remision Manual')
@section('breadcrumb', 'Ver Guia de Remision Manual')
@section('breadcrumb2', 'Ver Guia de Remision Manual')

@section('content')



<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title" style="padding-right: 3.1%">
        <div class="row tooltip-demo">
            <div class="col-sm-6"></div>
            <div class="col-sm-6" align="right">
                <a href="{{route('remision_m.pdf' ,$guia_remision_m->id)}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  
                </a>
                @if(Auth::user()->email_creado == 1)
                    <form action="{{ route('email.guia_remision_m', $guia_remision_m->id )}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn"  >
                        @csrf
                        <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=""  formtarget="_blank"  data-original-title="Enviar por correo">
                            <i class="fa fa-envelope fa-lg" ></i> 
                        </button>
                    </form>
                @endif
                <a class="btn btn-success" href="{{route('remision_m.print' , $guia_remision_m->id)}}"target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
                <div id="auto" onclick="divAuto()">
                    <a class="btn  btn-success" style= "background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-whatsapp fa-lg" style="color: white"></i>  </a>
                </div>
                <div id="div-mostrar">
                    <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                        @csrf
                        <input type="tel" name="numero"  value="{{$guia_remision_m->cliente->celular}}"   />
                        <input type="text" name="mensaje" id="texto_orden" hidden="" />
                        <input type="text" hidden="" name="url" value="{{route('remision_m.pdf' ,$guia_remision_m->id)}}?archivo=">
                        <input type="text" name="name_sin_cambio" hidden="" value="{{$guia_remision_m->cod_guia}}" />
                        <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
                    </form>
                </div>
            </div>  
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: -2px">
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
                        <div class="form-control" align="center" style="height: auto;">
                            <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">GUIA REMISION ELECTRONICA</h2>
                            <h5>{{$guia_remision_m->cod_guia}} </h5>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control"><h3>Domicilio De Partida</h3>
                            <div align="left" style="font-size: 13px">
                            <p>{{$guia_remision_m->almacen->direccion}} -  {{$guia_remision_m->almacen->cod_postal}}</p>
                                {{-- <p>{{$guia_remision_m->almacen->direccion}}</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" ><h3>Domicilio De Llegada</h3>
                            <div align="left" style="font-size: 13px">
                                @if(isset($guia_remision->sucursal_cliente))
                                    <p>{{$guia_remision_m->sucursal_cliente}} - {{$guia_remision_m->cod_postal_cliente}}</p>
                                @else
                                    <p>{{$guia_remision_m->cliente->direccion}} - {{$guia_remision_m->cliente->cod_postal}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" align="center">
                    <div class="col-sm-6" align="center">
                        <div class="form-control"><h3>Destinario</h3>
                            <div align="left" style="font-size: 13px">
                                <p><b>Señor(es) :</b> {{$guia_remision_m->cliente->nombre}} <br>
                                   <b>R.U.C / DNI : </b> {{$guia_remision_m->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;<b>Fecha Emision :</b> {{$guia_remision_m->fecha_emision}} <br><b>Fecha Traslado :</b> {{$guia_remision_m->fecha_entrega}} </p>
                               </div>
                           </div>
                       </div>
                       <div class="col-sm-6" align="center">
                        <div class="form-control" ><h3>Unidad de Transporte/Conductor</h3>
                            <div align="left" style="font-size: 13px">
                                @if(isset($guia_remision_m->vehiculo_id))
                                    <p>
                                        <b>Placa del Vehiculo : </b>{{$guia_remision_m->vehiculo->placa}}<br>
                                        <b>Marca del Vehiculo : </b>{{$guia_remision_m->vehiculo->marca}}<br>
                                        <b>Conductor : </b>{{$guia_remision_m->personal->nombres}}
                                    </p>
                                @elseif(isset($guia_remision_m->vehiculo_publico))
                                    <p>
                                        <b>Empresa:</b> {{$guia_remision_m->vehiculo_publicos->nombre}}<br>
                                        <b>Ruc: </b> {{$guia_remision_m->vehiculo_publicos->ruc}}<br>
                                        <b>Nota:</b>Esta Empresa es Publica
    
                                    </p>
                                @else
                                    <p>
                                        <b>Placa del Vehiculo : </b>No Hay Vehiculo<br>
                                        <b>Marca del Vehiculo : </b>No Hay Vehiculo<br>
                                        @if(isset($guia_remision_m->conductor_id))
                                        <b>Conductor : </b>{{$guia_remision_m->personal->nombres}}
                                        @else
                                        <b>Conductor : </b> No Hay Conductor
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table " >
                        <thead>
                            <tr >
                                <th>ITEM</th>
                                <th>Codigo Producto </th>
                                <th>Marca / Producto / Descripcion</th>
                                <th>Unid.Medida</th>
                                <th>Cantidad</th>
                                <th>Peso</th>
                            </thead>
                            <tbody>
                                <span hidden>{{$i=1}}</span>
                             @foreach($guia_remision_m_reg as $guia_registros)
                             <tr>
                                <td>{{$i++}}</td>
                                <td>{{$guia_registros->producto->codigo_producto}}</td>
                                <td>{{$guia_registros->producto->marcas_i_producto->nombre}} / {{$guia_registros->producto->nombre}} / {{$guia_registros->descripcion}} <br><strong>N/S: </strong>{{$guia_registros->numero_serie}}
                                 </td>
                                <td>{{$guia_registros->producto->unidad_i_producto->medida}}</td>
                                <td>{{$guia_registros->cantidad}}</td>
                                <td>{{$guia_registros->peso}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tbody>
                            <tr>
                                <td colspan="5" align="right">Peso Total:</td>
                                <td>{{$guia_remision_m_reg->sum('peso')}} KGM </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <footer style="padding-top: 120px">
                    <div class="row" align="center" style="padding-bottom: 5px">
                        <div class="col-sm-6" align="center">
                            <div class="form-control"><h3>Observacion:</h3>
                                <div align="left" style="font-size: 13px">
                                    <p>{{$guia_remision_m->observacion}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" align="center">
                            <div class="form-control" ><h3>Motivo de Traslado</h3>
                                <div align="left" style="font-size: 13px">
                                    <p>{{$guia_remision_m->motivo_traslado}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <br>
                {{-- @include('layout_bancos') --}}
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <p><u>centro de Atencion : </u></p>
                        Telefono : {{$guia_remision_m->user_personal->personal->telefono }}<br>
                        Celular : {{$guia_remision_m->user_personal->personal->celular }}<br>
                        Email : {{$guia_remision_m->user_personal->personal->email }}<br>
                        Web : {{$empresa->pagina_web}}<br>
                    </div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3"><br><br>
                        <hr>
                        <center>{{$guia_remision_m->user_personal->personal->nombres }}</center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .form-control{border-radius: 10px; height: auto;}
    .form-control{margin-top: 5px; border-radius: 5px}
    .ibox-tools a{color: white !important}
    .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}
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
@endsection