@extends('layout')
@section('title', 'Cotizacion Manual')
@section('breadcrumb', 'Cotizacion Manual')
@section('breadcrumb2', 'Cotizacion Manual')
@section('href_accion', route('manual.index'))
@section('value_accion', 'Atras')

@section('button2', 'Nueva Cotización')
@section('config', route('manual.create'))

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title" style="padding-right: 3.1%">
        <div class="row tooltip-demo">
             <div class="col-sm-6">
                {{-- @if ($regla=='factura')
                    <a class="btn btn-success" href="{{route('cotizacion.facturar',$cotizacion->id)}}" target="_blank">Facturar</a>
                @elseif(($regla=='boleta'))
                    <a class="btn btn-success" href="{{route('cotizacion.boletear',$cotizacion->id)}}" target="_blank">Boletear</a>
                @endif --}}
            </div>
             <div class="col-sm-6" align="right">
                <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('cotizacion_manual_pdf' ,$cotizacion_m->id)}}">
                    <input type="text" name="name" maxlength="50" hidden="" value="CotizacionManual_{{$cotizacion_m->tipo}}"  >
                    <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button>
                </form>
                <a class="btn btn-success" href="{{route('cotizacion_manual.print',$cotizacion_m->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
                <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                    @csrf
                     <input type="tel" name="numero"  value="{{$cotizacion_m->cliente->celular}}" hidden="" />
                     <input type="text" name="mensaje"  hidden="" value="" />
                     <input type="text" hidden="" name="url" value="{{route('pdf_cotizacion' ,$cotizacion_m->id)}}?archivo=">
                     <input type="text" name="name_sin_cambio" hidden="" value="Cotizacion_{{$cotizacion_m->tipo}}" />
                    <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-whatsapp fa-lg"></i>  </button>
                </form>
                         {{-- </a> --}}
                {{-- @if(Auth::user()->email_creado == 0)
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#config" ><i class="fa fa-envelope fa-lg " ></i>  </button>
                @else
                    <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn" >
                        @csrf
                        <input type="text" hidden="hidden"  name="tipo" value="App\Cotizacion"/>
                        <input type="text" hidden="hidden"  name="id" value="{{$cotizacion_m->id}}"/>
                        <input type="text" hidden="hidden"  name="redict" value="cotizacion_factura"/>
                        <input type="text" hidden="hidden"  name="cliente" value=" {{$cotizacion_m->cliente->email}}"/>
                       <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=""  formtarget="_blank"  data-original-title="Enviar por correo"><i class="fa fa-envelope fa-lg"  ></i> </button>
                    </form>
                @endif --}}
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    @include('layout_cabecera_ventas')
                    <div class="col-sm-4">
                        <div class="form-control" align="center" style="height: auto;">
                            <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">COTIZACION ELECTRONICA</h2>
                            <h5>{{$cotizacion_m->cod_cotizacion}} </h5>
                        </div>
                    </div>
                </div><br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3>Contacto Cliente</h3>
                            <div align="left">
                                <strong>Señor(es):</strong> &nbsp;{{$cotizacion_m->cliente->nombre}}<br>
                                <strong>{{$cotizacion_m->cliente->documento_identificacion}} :</strong> &nbsp;{{$cotizacion_m->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Fecha:</strong> &nbsp;{{$cotizacion_m->created_at}}<br>
                                <strong>Direccion:</strong>&nbsp; {{$cotizacion_m->cliente->direccion}}<br>
                                <strong>Telefono:</strong>&nbsp; {{$cotizacion_m->cliente->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Celular:</strong>&nbsp; {{$cotizacion_m->cliente->celular}}<br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                     <div class="form-control" >
                         <h3>Condiciones Generales</h3>
                         <div align="left">
                            <strong>Forma De Pago:</strong> &nbsp;{{$cotizacion_m->forma_pago->nombre }}<br>
                            <strong>Validez :</strong> &nbsp;{{$cotizacion_m->validez}}<br>
                            <strong>Garantia:</strong> &nbsp;{{$cotizacion_m->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            <strong>Tipo de Moneda:</strong> &nbsp;{{$cotizacion_m->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" align="center">
                 <div class="form-control" style="border: none;height: auto" >
                     <div align="left">
                        <strong>observaciones:</strong> &nbsp;{{$cotizacion_m->observacion }}<br>
                    </div>
                </div>
            </div>

        </div><br>
        <div class="table-responsive">
            <table class="table " >
                <thead>
                    <tr >
                        <th>ITEM </th>
                        <th>Codigo </th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>P.Unitario</th>
                        <th>Total <span hidden="hidden">{{$simbologia=$cotizacion_m->moneda->simbolo}}</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cotizacion_m_reg as $cotizacion_registros)
                    <tr>
                        <td>{{$j++}} </td>
                        @if(isset($cotizacion_registros->producto->codigo_producto))
                            <td>
                                {{$cotizacion_registros->producto->codigo_producto}}
                            </td>
                            <td>
                                {{$cotizacion_registros->producto->nombre}}  <br>{{$cotizacion_registros->descripcion_item}} </span>
                            </td>
                        @else
                            <td>
                                {{$cotizacion_registros->servicio->codigo_servicio}}
                            </td>
                            <td>
                                {{$cotizacion_registros->servicio->nombre}}  <br> {{$cotizacion_registros->descripcion_item}} </span>
                            </td>
                        @endif                        
                        <td>{{$cotizacion_registros->cantidad}}</td>
                        <td>{{number_format($cotizacion_registros->precio,2)}}</td>
                        <td>{{number_format($cotizacion_registros->cantidad*$cotizacion_registros->precio,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /table-responsive -->

<footer style="padding-top: 120px">
    <div class="row">
        <div class="col-sm-8">
            <h3 align="left">
                <?php $v=new CifrasEnLetras() ;
                $letra=($v->convertirEurosEnLetras($end));
                $letra_final = ucfirst(strstr($letra, 'soles',true));
                $end_final_point=strstr($end2, '.', false);
                $end_final=str_replace('.', '',$end_final_point);
                ?>
                Son : {{$letra_final}} con {{$end_final}}/100 {{$cotizacion_m->moneda->nombre }}
            </h3>         
        </div>
        <div class="col-sm-4 form-control ">
                <span style="display: block;float: left"> Subtotal:</span>
                <span style="display: block;float: right;"> {{$simbologia=$cotizacion_m->moneda->simbolo}} {{number_format($sub_total, 2)}}</span>
                <br>
                <span style="display: block;float: left"> Op. Gravada: </span>
                <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion_m->op_gravada,2)}}</span><br>
                <span style="display: block;float: left"> Op. Inafecta: </span>
                <span style="display: block;float: right">{{$simbologia}} {{ number_format($cotizacion_m->op_inafecta,2)}}</span><br>
                <span style="display: block;float: left"> Op. Exonerada: </span>
                <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion_m->op_exonerada,2)}} </span><br>
                <span style="display: block;float: left"> I.G.V.: </span>
                <span style="display: block;float: right">{{$cotizacion_m->moneda->simbolo}} {{number_format(round($igv, 2),2)}}</span><br>
                <span style="display: block;float: left"> Importe Total: </span>
                <span style="display: block;float: right">{{$cotizacion_m->moneda->simbolo}} {{number_format($end,2)}}</span>
            {{-- @endif --}}
        </div>
    </div>
</footer>

<br>
<!-- Fin Totales de Productos -->
<div class="row">
    @foreach($banco as $bancos)

    @if($banco_count==3)
    <div class="col-sm-4 " align="center">
    <p class="form-control" >

    @elseif($banco_count==2)
    <div class="col-sm-6" align="center">
    <p class="form-control">

    @elseif($banco_count==1)
    <div class="col-sm-12" align="center" style="width: 100px">
    <p class="form-control" style="width: 426px;">

    @else
    <div class="col-sm-3 " align="center">
    <p class="form-control" >
    @endif

      <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="height: 30px;"><br>
      <span style="font-size: 11px"><strong> {{$bancos->tipo_cuenta}}</strong></span>
      <br>
      <span style="font-size: 12px">
      S/: {{$bancos->numero_soles}}
      <br>
      $: {{$bancos->numero_dolares}}<br>
      </span>
     </p>
     </div>
      @endforeach
</div>
          <br>
          <div class="row">
            <div class="col-sm-3">
                <p><u>centro de Atencion : </u></p>
                Telefono : {{$cotizacion_m->user_personal->personal->telefono }}<br>
                Celular : {{$cotizacion_m->user_personal->personal->celular }}<br>
                Email : {{$cotizacion_m->user_personal->personal->email }}<br>
                Web : {{$empresa->pagina_web}} <br>
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"><br><br>
                <hr>
                <center>{{$cotizacion_m->user_personal->personal->nombres }}</center>
            </div>
        </div>
    </div>
</div>
</div>
</div>
{{--  --}}
{{-- Modal Configuracion --}}
<div class="modal fade" id="config" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{route('email.config')}}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <fieldset >
                                <legend> Agregar Configuracion </legend>
                                {{-- <div> --}}
                                    <div class="panel-body" align="left">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Email:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" name="email" style="height: 75%;border-radius: 2px ">
                                            </div>

                                            <label class="col-sm-2 col-form-label">Contraseña:</label>
                                            <div class="col-sm-10">
                                                <div class="input-group m-b">
                                                    <input type="password" class="form-control" name="password" id="txtPassword" required="" style="height: 35.2px;border-radius: 2px ">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon" style="height: 35.22222px;margin-top: 5px;">
                                                            <i class="fa fa-eye-slash " id="ojo" onclick="mostrarPassword()"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">SMPT:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="smtp" placeholder="smtp.gmail.com" required="" style="border-radius: 2px">
                                            </div>

                                            <label class="col-sm-2 col-form-label">PORT:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="port" value="110 " style="border-radius: 2px">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Encryption:</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="encryp" required="" style="height: 85%;border-radius: 2px;padding-top: 4px">
                                                    <option value="">Ninguno</option>
                                                    <option value="SSL">SSL</option>
                                                    <option value="TLS">TLS</option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Firma (opcional):</label>
                                            <div class="col-sm-10">
                                                <input type="file" id="archivoInput" name="firma" onchange="return validarExt()" style="border-radius: 2px" />
                                                <span id="visorArchivo">
                                                    <!--Aqui se desplegará el fichero-->
                                                    <img name="firma"  src="" width="390px" height="200px" />
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Ancho(px)</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="ancho_firma">
                                                </div>
                                            <label class="col-sm-2 col-form-label" >Alto(px)</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="alto_firma">
                                                </div>
                                        </div>
                                        <br>
                                    </div>
                                </fieldset>
                            </div>
                            <button class="btn btn-primary" type="submit">Grabar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- Fin de modal configuracion --}}
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
</style>
<style type="text/css">
    .form-control{border-radius: 10px; padding: 10px }
    .ibox-tools a{color: white !important}
    .a{height: 37px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}

</style>
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
<script type="text/javascript">
    {{-- Fotooos --}}
    function validarExt()
    {
        var archivoInput = document.getElementById('archivoInput');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpg|.png|.jfif)$/i;
        if(!extPermitidas.exec(archivoRuta)){
            alert('Asegurese de haber seleccionado una Imagen');
            archivoInput.value = '';
            return false;
        }

        else
                                        {
        //PRevio del PDF
        if (archivoInput.files && archivoInput.files[0])
        {
            var visor = new FileReader();
            visor.onload = function(e)
            {
                document.getElementById('visorArchivo').innerHTML =
                '<img name="firma" src="'+e.target.result+'"width="390px" height="200px" />';
            };
            visor.readAsDataURL(archivoInput.files[0]);
        }
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


@endsection