@extends('layout')
@section('title', 'Productos')
@section('href_accion', route('productos.index'))
@section('value_accion', 'Inicio')
@section('button2', 'Nuevo Producto')
@section('config',route('productos.create'))
@section('content')
<form action="{{ route('productos.update',$producto->id) }}"  enctype="multipart/form-data" method="post">
 @csrf
 @method('PATCH')
 <div style="padding-top:10px">
  <div >
    <div >
      <div >
        <div class="ibox-content">
          <div class="row">
            <div class="col-sm-12" align="right" style="padding-bottom:5px">
              @if($producto->estado_id==1)
              <input type="checkbox" checked name="estado_id" class="js-switch" />
              @else
              <input type="checkbox"  name="estado_id" class="js-switch" />
              @endif
            </div>

            <div class="col-md-5">
              <div class="product-images">

                <div>
                  <div class="image-imitation" style="padding:0px">
                   <input type="file" id="archivoInput" name="foto" onchange="return validarExt()"   />
                   <div id="visorArchivo">
                     <!--Aqui se desplegará el fichero-->
                     @if(isset($producto->foto))
                     <img src="{{ asset('/archivos/imagenes/productos/')}}/{{$producto->foto}}" style="width:100%;padding: 30px;">
                     @else
                     <img src="{{asset('img/logos/producto.svg')}}" style="width:100%;padding: 30px;">
                     @endif
                   </div>
                 </div>
               </div>

             </div>
           </div>

           <div class="col-md-7">
            <div class="tooltip-demo">

              <div class="row" style="padding-bottom: 15px">
                <div class="col-sm-4" align="center"><b>Código:</b> {{$producto->codigo_producto}}</div>
                <div class="col-sm-4" align="center"><b>Categoría:</b> {{$producto->categoria_i_producto->descripcion}}</div>
                <div class="col-sm-4" align="center"><b>Marca:</b> {{$producto->marcas_i_producto->nombre}}</div>
              </div>

              <input type="text" placeholder="Nombre del Producto" class="form-control"  data-toggle="tooltip" name="nombre" data-placement="top" title="Nombre del Producto"  value="{{$producto->nombre}}" >
              <textarea style="margin-top:10px" data-toggle="tooltip" data-placement="top" title="Description del Producto"  type="text" class="form-control" placeholder="Descripción del Producto" name="descripcion" rows="2" >{{$producto->descripcion}}</textarea >


              <div class="m-t-md row">

               <div class="col-sm-4"><input type="text" placeholder="Código del Producto" class="form-control"  name="codigo_original" data-toggle="tooltip" data-placement="top" title="Código del Producto"  value="{{$producto->codigo_original}}" ></div>

               <div class="col-sm-4">  <select class="form-control m-b" name="origen"  data-toggle="tooltip" data-placement="top" title="Origen del Producto" >
                <option value="Producto Nacional"  @if($producto->origen=="Producto Nacional")selected @endif>Producto Nacional</option>
                <option value="Producto Importado" @if($producto->origen=="Producto Importado")selected @endif>Producto Importado</option>
              </select></div>

              <div class="col-sm-4"><select  data-toggle="tooltip" data-placement="top" title="Familia"  class="form-control m-b" name="familia_id" required="required">
               @foreach($familias as $familia)
               <option value="{{ $familia->id }}"  @if($producto->familia_i_producto->id==$familia->id)selected @endif>{{ $familia->descripcion}}</option>
               @endforeach
             </select></div>

           </div>
         </div>

         <hr style="border:1px solid #8080803d;">

         <div class="tooltip-demo row" >
          <label class="col-sm-2 col-form-label">Desct.1:</label>
          <div class="col-sm-4">
           <div class="input-group m-b">
            <div class="input-group-prepend">
              <span class="input-group-addon">%</span>
            </div>
            <input type="text"  data-toggle="tooltip" data-placement="top" title="Descuenta internamente, de forma automática" class="form-control" name="descuento1" value="{{$producto->descuento1}}" required="required">
          </div>
        </div>

        <label class="col-sm-2 col-form-label">Desct.2:</label>
        <div class="col-sm-4">
         <div class="input-group m-b">
           <div class="input-group-prepend">
             <span class="input-group-addon">%</span>
           </div>
           <input type="text" class="form-control" data-toggle="tooltip" data-placement="top" title="Descuenta de forma Manual (Cotizaciones, Facturas)" name="descuento2" value="{{$producto->descuento2}}"required="required" >
         </div>
       </div>
     </div>

     <div class="row">
       <label class="col-sm-2 col-form-label">Desct.Máximo:</label>
       <div class="col-sm-4">
        <div class="input-group m-b">
          <div class="input-group-prepend"> <span class="input-group-addon">%</span></div>
          <input type="text" class="form-control" name="descuento_maximo" required="required" value="{{$producto->descuento_maximo}}" >
        </div>
      </div>
      <label class="col-sm-2 col-form-label">Utilidad: @if(isset($precio_promedio->precio_nacional)) <i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;" data-toggle="modal" data-target="#exampleModalCenter"></i>@endif</label>
      <style>.fa-question-circle:hover{color: blue;}</style>
      <div class="col-sm-4">
        <div class="input-group m-b">
          <div class="input-group-prepend"><span class="input-group-addon">%</span></div>
          <input type="text" id="sumando" class="form-control" name="utilidad" required="required" value="{{$producto->utilidad}}">
        </div>
      </div>
    </div>


    <div class="row">
     <label class="col-sm-2 col-form-label">Ud.Medida:</label>
     <div class="col-sm-4">
       <div class="input-group m-b">
        <select class="form-control m-b" required="required" name="unidad_medida_id">
         <option value="{{$producto->unidad_i_producto->id}}" style="font-weight:bold">{{$producto->unidad_i_producto->medida}}</option>
         @foreach($unidad_medidas as $unidad_medida)
         <option value="{{ $unidad_medida->id }}">{{ $unidad_medida->medida}}</option>
         @endforeach
       </select>
     </div>
   </div>
   <label class="col-sm-2 col-form-label">Peso:</label>
   <div class="col-sm-2">
    <div class="input-group m-b">
     <input type="number" class="form-control" required="required" name="peso" value="{{$peso}}">
   </div>
 </div>
 <div class="col-sm-2">
  <div class="input-group m-b">
    <select name="simbolo" required="required" class="form-control">
      <option value="{{$simbolo}}">{{$simbolo}}</option>
      <option value="Kilos">Kilos</option>
      <option value="Gramos">Gramos</option>
      <option value="Toneladas">Toneladas</option>
    </select>
  </div>
</div>
</div>


<div class="row">
 <label class="col-sm-2 col-form-label">garantía:</label>
 <div class="col-sm-4">
   <input type="text" class="form-control" required="required" name="garantia" value="{{$producto->garantia}}">
 </div>
 <label class="col-sm-2 col-form-label">Stock Mínimo:</label>
 <div class="col-sm-4" style="padding-bottom: 15px">
  <input type="text" class="form-control" required="required" name="stock_minimo" value="{{$producto->stock_minimo}}"   >
</div>
<label class="col-sm-2 col-form-label">Stock Máximo:</label>
<div class="col-sm-4">
  <input type="text" class="form-control" required="required" name="stock_maximo"  value="{{$producto->stock_maximo}}"  >
</div>
<label class="col-sm-2 col-form-label">Tipo de Afectación:</label>
<div class="col-sm-4">
 <div class="input-group m-b">
  <select class="form-control m-b" name="tipo_afectacion" required="required">
   <option value="{{$producto->tipo_afec_i_producto->id}}" style="font-weight:bold">{{$producto->tipo_afec_i_producto->informacion}}</option>
   @foreach($tipo_afectacion as $tipo_afec)
   <option value="{{ $tipo_afec->id }}">{{ $tipo_afec->informacion}}</option>
   @endforeach
 </select>
</div>
</div>
<div class="col-sm-12">
  <button type="submit" class="ladda-button btn btn-success btn-block" >Guardar</button>
</div>
</div>

</div>
</div>

</div>


<div class="ibox-footer">
  <span style="text-align:right;">
    Fecha de Creación <i class="fa fa-clock-o"></i> {{$producto->created_at}}
  </span>
</div>
</div>

</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">¿En duda con su porcentaje de utilidad? Puede colocar su precio venta y el sistema calculará por ud.</h5>
      </div>
      <div class="modal-body">
        <div class="row">

          <label class="col-sm-4 col-form-label">Precio Venta al Publico:</label>
          <div class="col-sm-8"><div class="input-group m-b">
            <div class="input-group-prepend">
              <span class="input-group-addon">{{$moneda_principal->simbolo}}</span>
            </div>
            <input type="text" onkeypress="return ( event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57 )" class="form-control" id="precio_venta" name="precio_venta" value="{{$producto->precio_venta}}" >
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="myFunction()">Calcular</button>
      </div>

    </div>
  </div>
</div>
</form>
<!-- Modal -->

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
<!-- Switchery -->
<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
<script>
  var elem= document.querySelector('.js-switch');
  var switchery = new Switchery(elem, { color: '#4cc0f7' });
</script>
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
  @if(isset($precio_promedio->precio_nacional))
  <script>
   function myFunction() {
     var x,suma,text;
     x = document.getElementById("precio_venta").value;
     if (isNaN(x) ) {
      alert('ss');
    } else {
     suma=parseFloat(x)/1.18;//Sacar IGV
     suma2=parseFloat(suma)*100;//Porcentaje
     @if($moneda_principal->tipo=='nacional')
     suma3=parseFloat(suma2)/{{$precio_promedio->precio_nacional}};//precio Promedio
     @else
     suma3=parseFloat(suma2)/{{$precio_promedio->precio_extranjero}};//precio Promedio
     @endif
     text= parseFloat(suma3)-100;
     document.getElementById("sumando").value = text;
   }
 }
</script>
@endif
@endsection