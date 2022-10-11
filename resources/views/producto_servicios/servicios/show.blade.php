  @extends('layout')

  @section('title', 'Servicios/Ver')
  @section('breadcrumb', 'Servicios/Ver')
  @section('breadcrumb2', 'Servicios/Ver')
  @section('href_accion', route('servicios.create'))
  @section('value_accion', 'Servicio Nuevo')

  @section('content')
  <form action="{{ route('servicios.update',$servicios->id) }}"  enctype="multipart/form-data" method="post">
   @csrf
   @method('PATCH')
   <div class="wrapper wrapper-content animated fadeInRight">
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

    <div class="row">
      <div class="col-lg-12">

        <div class="ibox product-detail">
          <div class="ibox-content">

            <div class="row">
              <div class="col-md-5">

                <div class="product-images">

                  <div>
                    <div class="image-imitation" style="padding:0px">
                     <input type="file" id="archivoInput" name="foto" onchange="return validarExt()"   />
                     <div id="visorArchivo">
                       <img @if($servicios->foto == "defecto.png" || $servicios->foto == "servicio.png" ) src="{{ asset('/archivos/imagenes/servicios/servicio.png')}}" @else src="{{ asset('/archivos/imagenes/servicios/')}}/{{$servicios->foto}}" @endif style="width:100%;padding: 30px;">
                       <input type="text" hidden="hidden" name="foto_original" value="{{$servicios->foto}}">
                     </div>
                   </div>
                 </div>

               </div>

             </div>
             <div class="col-md-7">
              <div class="tooltip-demo">

                <div class="row" style="padding-bottom: 15px">
                  <div class="col-sm-4" align="center"><b>Cod.Generado:</b> {{$servicios->codigo_servicio}} </div>
                  <div class="col-sm-4" align="center"><b>Categoría:</b> Servicio</div>
                  <div class="col-sm-4" align="center"><b>Marca:</b> {{$servicios->marca->nombre}}</div>
                </div>
                <div class="row" style="padding-bottom:10px">

                  <div class="col-sm-6" align="center">
                    <input placeholder="SERV-0X33X345XX" data-toggle="tooltip" data-placement="top"  title="Código Alternativo:" type="text" class="form-control" name="codigo_original" autocomplete="off" value="{{$servicios->codigo_original}}">
                  </div>

                  <div class="col-sm-6" align="center">
                   <select class="form-control m-b" name="familia_id" required="required" data-toggle="tooltip" data-placement="top"  title="Familia" >
                     @foreach($familias as $familia)
                     <option value="{{ $familia->id }}"  @if( $servicios->familia->id == $familia->id) selected @endif>{{ $familia->descripcion}}</option>
                     @endforeach
                   </select>
                 </div>
               </div>

               <input type="text" placeholder="Nombre del Servicio" class="form-control" required="required" data-toggle="tooltip" name="nombre" data-placement="top" title="Nombre del Servicio"  autocomplete="off" value="{{$servicios->nombre}}"  >
               <textarea style="margin-top:10px" data-toggle="tooltip" data-placement="top" title="Description del Servicio"  type="text" class="form-control" placeholder="Descripcion del Servicio" name="descripcion" rows="2" >{{$servicios->descripcion}}</textarea >
             </div>

             <hr style="border:1px solid #8080803d;">

             <div class="tooltip-demo " >
               <div class="row">
                 <label class="col-sm-2 col-form-label">Descuento:</label>
                 <div class="col-sm-4">
                   <div class="input-group m-b">
                    <div class="input-group-prepend">
                      <span class="input-group-addon">%</span>
                    </div>
                    <input type="text" class="form-control" name="descuento" required="required" value="{{$servicios->descuento}}" >
                  </div>
                </div>
                <label class="col-sm-2 col-form-label">Utilidad:</label>
                <div class="col-sm-4"><div class="input-group m-b">
                  <div class="input-group-prepend">
                    <span class="input-group-addon">%</span>
                  </div>
                  <input type="text" class="form-control" name="utilidad" required="required" value="{{$servicios->utilidad}}" >
                </div>
              </div>

            </div>


            <div class="row">

              <label class="col-sm-2 col-form-label">Precio s/igv:</label>
              <div class="col-sm-4"><div class="input-group m-b">
                <div class="input-group-prepend">
                  <select class="input-group-addon"  name="moneda">
                    @foreach($monedas as $moneda)
                    <option value="{{$moneda->id}}" @if($servicios->moneda->id==$moneda->id)selected @endif>{{$moneda->simbolo}}</option>
                    @endforeach
                  </select>
                </div>
                @if($servicios->moneda->id==2)
                <input type="number" min="0" step="0.01" class="form-control" name="precio" required="required" value="{{$servicios->precio_extranjero}}" >
                @else
                <input type="number" min="0" step="0.01" class="form-control" name="precio" required="required" value="{{$servicios->precio_nacional}}" >
                @endif
              </div>
            </div>
            <label class="col-sm-2 col-form-label">Afectación:</label>
            <div class="col-sm-4">
              <select class="form-control"  name="afectacion">
                @foreach($afectacion as $afecta)
                <option value="{{$afecta->id}}">{{$afecta->informacion}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-12">
              <button type="submit" class="ladda-button btn btn-success btn-block" >Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="ibox-footer">
    <span style="text-align:right;">
      Fecha de Creación <i class="fa fa-clock-o"></i> {{date('d:m:Y')}}
    </span>
  </div>
</div>

</div>
</div>
</div>
</form>

<style>  input#archivoInput{
  position:absolute;
  top:0px;
  left:0px;
  right:0px;
  bottom:0px;
  width:100%;
  /*height:100%;*/
  opacity: 0  ;
  padding: 30px;
}
</style>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
{{-- foto --}}
<script type="text/javascript">
  function validarExt()
  {
    var archivoInput = document.getElementById('archivoInput');
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.jpg|.png|.jfif)$/i;
    if(!extPermitidas.exec(archivoRuta)){
      alert('Asegúrese de haber seleccionado una Imagen');
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
            '<img name="foto" src="'+e.target.result+'" style="width:100%;padding: 30px;"/>';
          };
          visor.readAsDataURL(archivoInput.files[0]);
        }
      }
    }
  </script>
  @endsection