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
        <div class="col-sm-12 tooltip-demo "align="right"  > 
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
                <td>{{$simbologia}} {{$nota_venta_reg->precio_nacional}}</td>
                <td>{{$simbologia}} {{$nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional}}</td>
                <span hidden>{{$sume=$nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional+$sume}}</span>
            </tr>
            @endforeach
        </tbody>
    </table>
</div><!-- /table-responsive -->
<br><br><br><br>
<h3 align="left">
    <?php $v=new CifrasEnLetras() ;
    $letra=($v->convertirEurosEnLetras($sume));
    $letra_final = strstr($letra, 'soles',true);
    $end_final=strstr($sume, '.');
?>
Son : {{$letra_final}} {{$end_final}}/100 {{$nota_venta->moneda->nombre }}
</h3>

<div class="row">
    <div class="col-lg-12" align="right">
        <div style="width:20%">
         <p class="form-control a"> Importe Total</p>
         <p class="form-control a"> {{$nota_venta->moneda->simbolo}}{{$sume}}</p>
     </div>

 </div>
</div>

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
    </style>
    <style>
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
    <style type="text/css">
        .form-control{border-radius: 10px; padding: 10px }
        .ibox-tools a{color: white !important}
        .a{height: 37px; margin:0;border-radius: 0px;text-align: center;}
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}

    </style>
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
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>



@endsection