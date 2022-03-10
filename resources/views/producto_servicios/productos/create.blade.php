@extends('layout')
@section('title', 'Productos')
@section('href_accion', route('productos.index') )
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
 <form action="{{ route('productos.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
   @csrf
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

                     <img src="{{asset('img/logos/producto.svg')}}" style="width:100%;padding: 30px;">
                   </div>
                 </div>
               </div>

             </div>

           </div>
           <div class="col-md-7">
            <div class="tooltip-demo">

              <div class="row" style="padding-bottom:10px">
                <div class="col-sm-4" align="center">
                  <input placeholder="PRO-0X33X345XX" data-toggle="tooltip" data-placement="top"  title="Código Alternativo:" type="text" class="form-control" name="codigo_original" autocomplete="off">
                </div>

                <div class="col-sm-4" align="center">
                 <select data-toggle="tooltip" data-placement="top" title="Familia"  class="form-control" name="familia_id" required="required">
                   {{-- <option>Seleccione una Familia</option> --}}
                   @foreach($familias as $familia)
                   <option value="{{ $familia->id }}">{{ $familia->descripcion}}</option>
                   @endforeach
                 </select></div>

                 <div class="col-sm-4" align="center">
                  <select  data-toggle="tooltip" data-placement="top" title="Marca"class="form-control " name="marca_id" required="required">
                   @foreach($marcas as $marca)
                   <option value="{{ $marca->id }}">{{ $marca->nombre}}</option>
                   @endforeach
                 </select>
               </div>
             </div>

             <input type="text" placeholder="Nombre del Producto" class="form-control" required="required" data-toggle="tooltip" name="nombre" data-placement="top" title="Nombre del Producto"  autocomplete="off" >
             <textarea style="margin-top:10px" data-toggle="tooltip" data-placement="top" title="Descripción del Producto"  type="text" class="form-control" placeholder="Descripción del Producto" name="descripcion" rows="2" ></textarea >
         </div>

         <hr style="border:1px solid #8080803d;">

         <div class="tooltip-demo row" >
          <label class="col-sm-2 col-form-label">Desct.1:</label>
          <div class="col-sm-4">
           <div class="input-group m-b">
            <div class="input-group-prepend">
              <span class="input-group-addon">%</span>
            </div>
            <input type="text"  data-toggle="tooltip" data-placement="top" title="Descuenta internamente, de forma automática" class="form-control" name="descuento1" value="0" autocomplete="off" required="required" >
          </div>
        </div>

        <label class="col-sm-2 col-form-label">Desct.2:</label>
        <div class="col-sm-4">
         <div class="input-group m-b">
           <div class="input-group-prepend">
             <span class="input-group-addon">%</span>
           </div>
           <input type="text" class="form-control" data-toggle="tooltip" data-placement="top" title="Descuenta de forma Manual (Cotizaciones, Facturas)" name="descuento2"  required="required" value="0" autocomplete="off" >
         </div>
       </div>
     </div>

     <div class="row">
       <label class="col-sm-2 col-form-label">Desct.Máximo:</label>
       <div class="col-sm-4">
        <div class="input-group m-b">
          <div class="input-group-prepend"> <span class="input-group-addon">%</span></div>
          <input type="text" class="form-control" name="descuento_maximo" required="required" value="0" autocomplete="off">
        </div>
      </div>
      <label class="col-sm-2 col-form-label">Utilidad:</label>
      <style>.fa-question-circle:hover{color: blue;}</style>
      <div class="col-sm-4">
        <div class="input-group m-b">
          <div class="input-group-prepend"><span class="input-group-addon">%</span></div>
          <input type="text" id="sumando" class="form-control" name="utilidad" required="required" value="0" autocomplete="off">
        </div>
      </div>
    </div>


    <div class="row">
     <label class="col-sm-2 col-form-label">Ud.Medida:</label>
     <div class="col-sm-4">
       <div class="input-group m-b">
         <select class="form-control m-b" name="unidad_medida_id" required="required">
      @foreach($unidad_medidas as $unidad_medida)
      <option value="{{ $unidad_medida->id }}">{{ $unidad_medida->medida}}</option>
      @endforeach
    </select>
     </div>
   </div>
   <label class="col-sm-2 col-form-label">Peso:</label>
   <div class="col-sm-2">
    <div class="input-group m-b">
     <input type="number" class="form-control" name="peso" required="required" value="0" autocomplete="off">
   </div>
 </div>
 <div class="col-sm-2">
  <div class="input-group m-b">
   <select name="simbolo" class="form-control">
      <option value="Gramos">Gramos</option>
      <option value="Kilos">Kilos</option>
      <option value="Toneladas">Toneladas</option>
    </select>
  </div>
</div>
</div>


<div class="row">
 <label class="col-sm-2 col-form-label">garantía:</label>
 <div class="col-sm-4">
   <input type="text" class="form-control" name="garantia" value="12 meses" required="required">
 </div>
 <label class="col-sm-2 col-form-label">Stock Mínimo:</label>
 <div class="col-sm-4" style="padding-bottom: 15px">
  <input type="text" class="form-control" name="stock_minimo"    required="" value="0" autocomplete="off"  >
</div>
<label class="col-sm-2 col-form-label">Stock Máximo:</label>
<div class="col-sm-4">
  <input type="text" class="form-control" name="stock_maximo"  required="" value="0" autocomplete="off"  >
</div>
<label class="col-sm-2 col-form-label">Tipo de Afectación:</label>
<div class="col-sm-4">
 <div class="input-group m-b">
    <select class="form-control m-b" name="tipo_afectacion" required="required">
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