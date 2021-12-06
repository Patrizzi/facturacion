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
                    <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('pdf_cotizacion' ,$nota_venta->id)}}">
                        <input type="text" name="name" maxlength="50" hidden="" value="Cotizacion_{{$nota_venta->tipo}}"  >
                        <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button>
                    </form>
                    <a class="btn btn-success" href="{{route('cotizacion.print',$nota_venta->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
                    <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                        @csrf
                        <input type="tel" name="numero"  value="{{$nota_venta->cliente->celular}}" hidden="" />
                        <input type="text" name="mensaje"  hidden="" value="" />
                        <input type="text" hidden="" name="url" value="{{route('pdf_cotizacion' ,$nota_venta->id)}}?archivo=">
                        <input type="text" name="name_sin_cambio" hidden="" value="Cotizacion_{{$nota_venta->tipo}}" />
                        <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-whatsapp fa-lg"></i>  </button>
                    </form>
                {{-- </a> --}}
                @if(Auth::user()->email_creado == 0)
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#config" ><i class="fa fa-envelope fa-lg " ></i>  </button>
                @else
                <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn" >
                    @csrf
                    <input type="text" hidden="hidden"  name="tipo" value="App\Cotizacion"/>
                    <input type="text" hidden="hidden"  name="id" value="{{$nota_venta->id}}"/>
                    <input type="text" hidden="hidden"  name="redict" value="cotizacion_factura"/>
                    <input type="text" hidden="hidden"  name="cliente" value=" {{$nota_venta->cliente->email}}"/>
                    <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=""  formtarget="_blank"  data-original-title="Enviar por correo"><i class="fa fa-envelope fa-lg"  ></i> </button>
                </form>
                @endif
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
                    <div class="col-sm-4">
                    </div>

                    <div class="col-sm-4">
                        <div class="form-control" align="center" style="height: auto;">
                            <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">COTIZACION ELECTRONICA</h2>
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
                                {{-- <strong>Direccion:</strong>&nbsp; {{$nota_venta->cliente->direccion}}<br> --}}
                                {{-- <strong>Telefono:</strong>&nbsp; {{$nota_venta->cliente->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --}}
                                {{-- <strong>Celular:</strong>&nbsp; {{$nota_venta->cliente->celular}}<br> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                       <div class="form-control" >
                           <h3>Condiciones Generales</h3>
                           <div align="left">
                            {{-- <strong>Forma De Pago:</strong> &nbsp;{{$nota_venta->forma_pago->nombre }}<br> --}}
                            {{-- <strong>Validez :</strong> &nbsp;{{$nota_venta->validez}}<br> --}}
                            <strong>Garantia:</strong> &nbsp;{{$nota_venta->garantia }} Mes(es)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            <strong>Tipo de Moneda:</strong> &nbsp;{{$nota_venta->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
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
                <td>{{$simbologia}}{{$nota_venta_reg->precio_nacional}}</td>
                <td>{{$simbologia}}{{$nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional}}</td>
                <span hidden>{{$sume=$nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional+$sume}}</span>
            </tr>
            @endforeach
        </tbody>
    </table>
</div><!-- /table-responsive -->

<div class="row"style="padding-top: 120px">
<div class="col-lg-12" align="right">
<div style="width:20%">
 <p class="form-control a"> Importe Total</p>
        <p class="form-control a"> {{$nota_venta->moneda->simbolo}}{{$sume}}</p>
</div>

</div>
</div>

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
                            Telefono : {{$nota_venta->user->personal->telefono }}<br>
                            Celular : {{$nota_venta->user->personal->celular }}<br>
                            Email : {{$nota_venta->user->personal->email }}<br>
                            Web : {{$empresa->pagina_web}} <br>
                        </div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3"></div>º
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