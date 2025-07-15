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
    <div>
      <div>
        <div>
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
                    <div class="col-sm-3">
                      <input type="text" placeholder="Código del Producto" class="form-control"  name="codigo_original" data-toggle="tooltip" data-placement="top" title="Código del Producto"  value="{{$producto->codigo_original}}" >
                    </div>
                    <div class="col-sm-3">
                      <select class="form-control m-b" name="origen"  data-toggle="tooltip" data-placement="top" title="Origen del Producto" >
                        <option value="Producto Nacional"  @if($producto->origen=="Producto Nacional")selected @endif>Producto Nacional</option>
                        <option value="Producto Importado" @if($producto->origen=="Producto Importado")selected @endif>Producto Importado</option>
                      </select>
                    </div>
                    <div class="col-sm-3">
                      <div  data-toggle="tooltip" data-placement="top" title="Familia">
                        <select class="familia_select2 form-control m-b" name="familia_id" id="familia_id_sl" required="required" onchange="list_subfamilia()">
                          <option value=""></option>
                          @foreach($familias as $familia)
                            <option value="{{ $familia->id }}"  @if($producto->familia_i_producto->id==$familia->id)selected @endif>{{ $familia->descripcion}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3" data-toggle="tooltip" data-placement="top" title="Subfamilia">
                      <div>
                        <select class="subfamilia_select2 form-control" name="sub_familia_id" >
                          @if(isset($producto->subfamilia_id))
                              <option value="{{$producto->subfamilia_i_producto->id}}">{{$producto->subfamilia_i_producto->descripcion}}</option>
                            @endif
                        </select>
                      </div>
                    </div>
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
                      <input type="text"  data-toggle="tooltip" data-placement="top" title="Descuenta internamente, de forma automática" class="form-control input_valor_numerico" name="descuento1" value="{{$producto->descuento1}}" required="required">
                    </div>
                  </div>
                  <label class="col-sm-2 col-form-label">Desct.2:</label>
                  <div class="col-sm-4">
                    <div class="input-group m-b">
                      <div class="input-group-prepend">
                        <span class="input-group-addon">%</span>
                      </div>
                      <input type="text" class="form-control input_valor_numerico" data-toggle="tooltip" data-placement="top" title="Descuenta de forma Manual (Cotizaciones, Facturas)" name="descuento2" value="{{$producto->descuento2}}"required="required" >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Desct.Máximo:</label>
                  <div class="col-sm-4">
                    <div class="input-group m-b">
                      <div class="input-group-prepend"> <span class="input-group-addon">%</span></div>
                      <input type="text" class="form-control input_valor_numerico" name="descuento_maximo" required="required" value="{{$producto->descuento_maximo}}" >
                    </div>
                  </div>
                  <label class="col-sm-2 col-form-label">Utilidad:
                    @if(isset($precio_promedio->precio_nacional))
                      <i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;" data-toggle="modal" data-target="#utilidad_con_inventario"></i>
                    @else
                      <i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;" data-toggle="modal" data-target="#utilidad_sin_existencia"></i>
                    @endif
                  </label>
                  <style>.fa-question-circle:hover{color: blue;}</style>
                  <div class="col-sm-4">
                    <div class="input-group m-b">
                      <div class="input-group-prepend"><span class="input-group-addon">%</span></div>
                      <input type="text" id="sumando" class="form-control input_valor_numerico" name="utilidad" required="required" value="{{$producto->utilidad}}">
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
                <label class="col-sm-2 col-form-label">Fecha de creación:</label>
                <div class="col-sm-4">
                  <div class="input-group m-b">
                    <input type="text" class="form-control" readonly value="{{$producto->created_at}}" name="" id="">
                  </div>
                </div>
                <label class="col-sm-2 col-form-label">Ficha del Producto:</label>
                <div class="col-sm-4">
                  <div class="input-group m-b">
                    @if(isset($producto->archivo))
                      <div class="row" style="width: 100%;margin: auto">
                        <div class="col-sm-10" style="padding: 0">
                          <div class="custom-file">
                            <input id="logo" type="file" class="custom-file-input" value="{{$producto->archivo}}" name="archivo_producto" />
                            <label for="logo" class="custom-file-label" >{{$producto->archivo}}</label>
                          </div>
                        </div>
                        <a class=" btn btn-secondary col-sm-2 "  style="padding: auto;vertical-align: middle" href="{{ asset('/archivos/productos/fichas/'.$producto->archivo)}}" download="{{$producto->archivo}}">
                          <i class="fa fa-download" style="vertical-align:middle;"></i>
                        </a>
                      </div>
                    @else
                      <div class="col-sm-12" style="padding: 0">
                        <input id="logo" type="file" class="custom-file-input" name="archivo_producto">
                        <label for="logo" class="custom-file-label">Seleccionar archivo...</label>
                      </div>
                    @endif
                  </div>
                </div>
                <div class="col-sm-12">
                  <button type="submit" class="ladda-button btn btn-success btn-block button_guardar" >Guardar</button>
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
<!-- Modal  -->
@if(isset($precio_promedio->precio_nacional))
  <div class="modal fade" id="utilidad_con_inventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
@else
  {{-- Modal Utilidad --}}
  <div class="modal fade" id="utilidad_sin_existencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">¿En duda con su porcentaje de utilidad? Puede colocar su precio venta y el sistema calculará por ud.</h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <label class="col-sm-4 col-form-label">Precio de Compra:</label>
            <div class="col-sm-8">
              <div class="input-group m-b">
                <div class="input-group-prepend">
                  <span class="input-group-addon">{{$moneda_principal->simbolo}}</span>
                </div>
                <input type="text" onkeypress="return ( event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57 )" class="form-control" id="precio_compra" name="precio_compra" value="" >
              </div>
            </div>
            <label class="col-sm-4 col-form-label">Precio Venta al Publico + Igv:</label>
            <div class="col-sm-8">
              <div class="input-group m-b">
                <div class="input-group-prepend">
                  <span class="input-group-addon">{{$moneda_principal->simbolo}}</span>
                </div>
                <input type="text" onkeypress="return ( event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57 )" class="form-control" id="precio_venta" name="precio_venta" value="" >
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="calcular_utilidad()">Calcular</button>
        </div>
      </div>
    </div>
  </div>
@endif
<!-- Modal -->
</form>


<style>
  input#archivoInput{
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
  .select2.select2-container.select2-container--default{
    width: 100% !important;
    /* height: 100% !important; */
  }
  .select2-container--default .select2-selection--single{
    height: 2.5em;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height: 32px !important;
  }
  .custom-file-label{
    word-break: break-all;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }
  .custom-file-label::after{
    content: "Sel."
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
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script>
  // Switchery button
  var elem= document.querySelector('.js-switch');
  var switchery = new Switchery(elem, { color: '#4cc0f7' });
  // input file button
  $('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
  });
  // select2 inputs
  $(document).ready(function(){
    $('.familia_select2').select2({
      placeholder: "Seleccionar",

    });
    $('.subfamilia_select2').select2({
      placeholder: "Seleccionar",
    });
  });

  function list_subfamilia(){
    var family = $('.familia_select2').val();
    $('.subfamilia_select2').val(null).trigger('change');

    // console.log(family);
    $('.subfamilia_select2').select2({
      placeholder: "Seleccionar",
      ajax: {
        minimumInputLength: 1,
        url: "{{ route('subfamilia.search_ajax') }}",
        dataType: 'json',
        type: "POST",
        data: function (params) {
            return {
                _token: "{{ csrf_token() }}",
                familia_id: family
            };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
                return {
                    id: item.id,
                    text: item.descripcion,
                };
            })
          };
        },
        cache: true
      }
    });
  }
</script>
{{-- foto --}}
<script type="text/javascript">
  function validarExt(){
    var archivoInput = document.getElementById('archivoInput');
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.jpg|.png|.jfif)$/i;
    if(!extPermitidas.exec(archivoRuta)){
      alert('Asegúrese de haber seleccionado una Imagen');
      archivoInput.value = '';
      return false;
    }else{
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
  //VALIDACION DE UTILIDAD PARA QUE NO ACEPTA LETRAS
  $('.input_valor_numerico').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
  });
  $('.button_guardar').on('mouseenter', function () {
    var lol = document.querySelectorAll('.input_valor_numerico');
      lol.forEach(element => {
        if (element.val == "" || isNaN(Number(element.value)) == true) {
          element.value = 0;
        }
      });
  });
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
@else
  <script>
    function calcular_utilidad(){
      var precio_venta = document.getElementById("precio_venta").value;
      var precio_compra = document.getElementById("precio_compra").value;

      if (!isNaN(precio_venta) || !isNaN(precio_compra) ) {
        // var utilidad = (parseFloat(precio_compra)/100) * parseFloat(precio_venta);
        var a1 =  parseFloat(precio_venta) * 100;
        var a2 = parseFloat(a1) / parseFloat(precio_compra);
        var utilidad = parseFloat(a2) - 100;
        document.getElementById("sumando").value = utilidad;
      }
    }
  </script>
@endif

@endsection
