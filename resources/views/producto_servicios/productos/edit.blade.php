@extends('layout')
@section('title', 'Productos')
@section('href_accion', route('productos.index') )
@section('value_accion', 'Atras')
@section('content')

@if($producto->estado_anular == '1')
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
<div class="ibox-content" style="margin-top: 5px;margin-bottom:50px" align="center">

  <form action="{{ route('productos.update',$producto->id) }}"  enctype="multipart/form-data" method="post">
   @csrf
   @method('PATCH')
   <div class="row">

    <fieldset class="col-sm-6">
     <legend>Clasificacion del <br>Producto</legend>

     <div class="panel panel-default">
       <div class="panel-body" align="left">
        <div class="row">
         <label class="col-sm-2 col-form-label">Codigo:</label>
         <div class="col-sm-4"><input type="text" class="form-control" name="codigo" value="{{$producto->codigo_producto}}" readonly="readonly">
         </div>

         <label class="col-sm-2 col-form-label">Codigo Alernativo:</label>
         <div class="col-sm-4"><input type="text" class="form-control" name="codigo_original" value="{{$producto->codigo_original}}" ></div>
       </div>

       <div class="row">
         <label class="col-sm-2 col-form-label">Categoria:</label>
         <div class="col-sm-4">
          <input type="text" class="form-control" value="{{$producto->categoria_i_producto->descripcion}}" disabled="disabled">
        </div>

        <label class="col-sm-2 col-form-label">Marca:</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" value="{{$producto->marcas_i_producto->nombre}}" disabled="disabled">
        </div>
      </div>
      <div class="row">

       <label class="col-sm-2 col-form-label">Familia:</label>
       <div class="col-sm-10">
        {{-- <input type="text" class="form-control" value="{{$producto->familia_i_producto->descripcion}}" disabled="disabled"> --}}
        <select class="form-control m-b" name="familia_id" required="required">
         <option value="{{ $producto->familia_i_producto->id }}">{{ $producto->familia_i_producto->descripcion}}</option>
         <option disabled="">---------------------</option>
         @foreach($familias as $familia)
         <option value="{{ $familia->id }}">{{ $familia->descripcion}}</option>
         @endforeach
       </select>
     </div>

   </div>
   <br>
 </div>

</fieldset>

<fieldset class="col-sm-6">
 <legend>Datos del <br>Producto </legend>

 <div class="panel panel-default">
  <div class="panel-body" align="left">
   <div class="row">
    <label class="col-sm-2 col-form-label">Nombre:</label>
    <div class="col-sm-10"><input type="text" class="form-control" name="nombre" value="{{$producto->nombre}}"></div>

    <label class="col-sm-2 col-form-label">Descripcion:</label>
    <div class="col-sm-10"><textarea type="text" class="form-control" name="descripcion" rows="2" required="required">{{$producto->descripcion}}</textarea ></div>
  </div>
  <div class="row">
    <label class="col-sm-2 col-form-label">Estado:</label>
    <div class="col-sm-4">
      <select class="form-control m-b" name="estado_id">
        <option value="{{$producto->estado_i_producto->id}}"style="font-weight:bold">{{$producto->estado_i_producto->nombre}}</option>			          					@foreach($estados as $estado)
        <option value="{{ $estado->id }}">{{ $estado->nombre}}</option>
        @endforeach
      </select>
    </div>

    <label class="col-sm-2 col-form-label">Origen:</label>
    <div class="col-sm-4">
     <select class="form-control m-b" name="origen">
      <option value="{{$producto->origen}}" style="font-weight:bold">{{$producto->origen}}</option>
      <option value="Producto Nacional" >Producto Nacional</option>
      <option value="Producto Importado">Producto Importado</option>
    </select>
  </div>

</div>

</div>
</div>

</fieldset>

<fieldset class="col-sm-6">
 <legend>Precio del <br>Producto</legend>

 <div class="panel panel-default">
  <div class="panel-body" align="left">
   <div class="row">
     <label class="col-sm-2 col-form-label">Descuento1:</label>
     <div class="col-sm-4">
       <div class="input-group m-b">
        <div class="input-group-prepend">
          <span class="input-group-addon">%</span>
        </div>
        <input type="text" class="form-control" name="descuento1" value="{{$producto->descuento1}}" >
      </div>
    </div>

    <label class="col-sm-2 col-form-label">Descuento2:</label>
    <div class="col-sm-4">
     <div class="input-group m-b">
       <div class="input-group-prepend">
         <span class="input-group-addon">%</span>
       </div>
       <input type="text" class="form-control" name="descuento2" value="{{$producto->descuento2}}" >
     </div>
   </div>

 </div>
 <div class="row">
   <label class="col-sm-2 col-form-label">Descuento Maximo:</label>
   <div class="col-sm-4"><div class="input-group m-b">
    <div class="input-group-prepend">
      <span class="input-group-addon">%</span>
    </div>
    <input type="text" class="form-control" name="descuento_maximo" value="{{$producto->descuento_maximo}}" >
  </div>
</div>

<label class="col-sm-2 col-form-label">Utilidad: <i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;" data-toggle="modal" data-target="#exampleModalCenter"></i></label>
<style>
  .fa-question-circle:hover{color: blue;}
</style>
<div class="col-sm-4"><div class="input-group m-b">
  <div class="input-group-prepend">
    <span class="input-group-addon">%</span>
  </div>
  <input type="text" id="sumando" class="form-control" name="utilidad" value="{{$producto->utilidad}}">
  <p ></p>
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
              <span class="input-group-addon">S/.</span>
            </div>
            <input type="text" class="form-control" id="precio_venta" name="precio_venta"  >
          </div>
        </div>
      </div>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="myFunction()">Calcular</button>
    </div>

    <script>
     function myFunction() {
       var x,suma,text;
       x = document.getElementById("precio_venta").value;
       if (isNaN(x) ) {
        alert('ss');
       } else {
     suma=parseFloat(x)/1.18;//Sacar IGV
     suma2=parseFloat(suma)*100;//Porcentaje
     suma3=parseFloat(suma2)/{{$precio_promedio->precio_nacional}};//precio Promedio
     text= parseFloat(suma3)-100;
   document.getElementById("sumando").value = text;
   }
 }
</script>
</div>
</div>
</div>
<!-- Modal -->

</div>
<div class="row">
 <label class="col-sm-2 col-form-label">Unida de medida:</label>
 <div class="col-sm-4">
   <div class="input-group m-b">
    <select class="form-control m-b" name="unidad_medida_id">
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
   <input type="number" class="form-control" name="peso" value="{{$peso}}">
 </div>
</div>
<div class="col-sm-2">
  <div class="input-group m-b">
    <select name="simbolo" class="form-control">
      <option value="{{$simbolo}}">{{$simbolo}}</option>
      <option value="Kilos">Kilos</option>
      <option value="Gramos">Gramos</option>
      <option value="Toneladas">Toneladas</option>
    </select>
  </div>
</div>



</div>
<div class="row">
 <label class="col-sm-2 col-form-label">garantia:</label>
 <div class="col-sm-4">
   <select class="form-control" name="garantia"  >
    <option value="{{$producto->garantia}}">{{$producto->garantia}}</option>
    <option disabled="">----------------------</option>
    <option value="4 meses">4 meses</option>
    <option value="6 meses">6 meses</option>
    <option value="12 meses">12 meses</option>
    <option value="18 meses">18 meses</option>
    <option value="24 meses">24 meses</option>
    <option value="30 meses">30 meses</option>
    <option value="36 meses">36 meses</option>
  </select>
</div>

<label class="col-sm-2 col-form-label">Stok Minimo:</label>
<div class="col-sm-4"><input type="text" class="form-control" name="stock_minimo" value="{{$producto->stock_minimo}}"   >
</div>
<label class="col-sm-2 col-form-label">Stock Maximo:</label>
<div class="col-sm-4"><input type="text" class="form-control" name="stock_maximo"  value="{{$producto->stock_maximo}}"  >
</div>
<label class="col-sm-2 col-form-label">Tipo de Afectacion:</label>
<div class="col-sm-4">
 <div class="input-group m-b">
  <select class="form-control m-b" name="tipo_afectacion">
   <option value="{{$producto->tipo_afec_i_producto->id}}" style="font-weight:bold">{{$producto->tipo_afec_i_producto->informacion}}</option>
   @foreach($tipo_afectacion as $tipo_afec)
   <option value="{{ $tipo_afec->id }}">{{ $tipo_afec->informacion}}</option>
   @endforeach
 </select>
</div>
</div>
</div>



</div>



</fieldset>
<fieldset class="col-sm-6">
 <legend>Foto del <br>Producto </legend>

 <div class="panel panel-default">
  <div class="panel-body">
    <div class="col-sm-12">
     <input type="file" id="archivoInput" name="foto" onchange="return validarExt()"  />
     <div id="visorArchivo">
       <!--Aqui se desplegará el fichero-->
       <center >
        @if(isset($producto->foto))
        <img src="
        {{ asset('/archivos/imagenes/productos/')}}/{{$producto->foto}}" style="width:250px; height: 250px;border-radius: 5px"></center>
        @else
        <img src="{{asset('img/logos/producto.svg')}}" style="width:250px; height: 250px;border-radius: 5px"></center>
        @endif
      </center>

    </div><input type="text" value="{{$producto->foto}}" class="form-control" name="ori_foto" hidden="hidden">
  </div>
  <input type="text" value="{{$producto->foto}}" hidden="hidden" name="foto_original">
</div>

</fieldset>


</div>

<button class="btn btn-primary" type="submit">Grabar</button>
</form>
</div>


@elseif($producto->estado_anular == '0')
@include("maestro.catalogo.productos.show");
@endif

<style>
	.form-control{    margin-bottom: 15px;
  }
  fieldset
  {
    /*border: 1px solid #ddd !important;*/
    padding: 10px;
    /*border-radius:4px ;*/
    background-color:#f5f5f5;
    padding-left:10px!important;
    padding-right:10px!important;
    margin-bottom: 10px;
    border-left: 1px solid #ddd !important;

  }

  legend
  {
    font-size:14px;
    font-weight:bold;
    margin-bottom: 0px;
    width: 35%;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px 5px 5px 10px;
    background-color: #ffffff;
  }
  /*img{border-radius: 40px}*/
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
            '<center><img name="foto" src="'+e.target.result+'"width="250px" height="250px" /></center>';
          };
          visor.readAsDataURL(archivoInput.files[0]);
        }
      }
    }
  </script>
  @endsection