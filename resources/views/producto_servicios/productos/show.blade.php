@extends('layout')
@section('title', 'Productos')
@section('href_accion', route('productos.index'))
@section('value_accion', 'Inicio')
@section('button2', 'Nuevo Producto')
@section('config',route('productos.create'))
@section('content')
<form action="{{ route('productos.update', $producto->id) }}"
      enctype="multipart/form-data"
      method="post">
  @csrf
  @method('PATCH')

  <div style="padding-top:10px">
    <div>
      <div>
        <div>
          <div class="ibox-content">
            <div class="row">
              {{-- Toggle de estado --}}
              <div class="col-sm-12 text-right pb-1">
                <input type="checkbox"
                       name="estado_id"
                       class="js-switch"
                       {{ $producto->estado_id == 1 ? 'checked' : '' }} />
              </div>

              {{-- Imagen --}}
              <div class="col-md-5">
                <div class="product-images">
                  <div class="image-imitation p-0">
                    <input type="file"
                           id="archivoInput"
                           name="foto"
                           onchange="return validarExt()" />
                    <div id="visorArchivo">
                      @if($producto->foto)
                        <img src="{{ asset('archivos/imagenes/productos/'.$producto->foto) }}"
                             style="width:100%;padding:30px">
                      @else
                        <img src="{{ asset('img/logos/producto.svg') }}"
                             style="width:100%;padding:30px">
                      @endif
                    </div>
                  </div>
                </div>
              </div>

              {{-- Datos básicos --}}
              <div class="col-md-7">
                <div class="tooltip-demo">
                  {{-- Código, categoría y marca --}}
                  <div class="row pb-3">
                    <div class="col-sm-4 text-center"><b>Código:</b> {{ $producto->codigo_producto }}</div>
                    <div class="col-sm-4 text-center"><b>Categoría:</b> {{ optional($producto->categoria_i_producto)->descripcion }}</div>
                    <div class="col-sm-4 text-center"><b>Marca:</b> {{ optional($producto->marcas_i_producto)->nombre }}</div>
                  </div>

                  {{-- Nombre y descripción --}}
                  <input type="text"
                         name="nombre"
                         class="form-control mb-2"
                         placeholder="Nombre del Producto"
                         value="{{ $producto->nombre }}"
                  >
                  <textarea name="descripcion"
                            class="form-control mb-3"
                            rows="2"
                            placeholder="Descripción del Producto">{{ $producto->descripcion }}</textarea>

                  {{-- Código original, origen, familia y subfamilia --}}
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <input type="text"
                             name="codigo_original"
                             class="form-control"
                             placeholder="Código Alternativo"
                             value="{{ $producto->codigo_original }}">
                    </div>
                    <div class="col-sm-3">
                      <select name="origen"
                              class="form-control"
                              data-toggle="tooltip"
                              title="Origen del Producto">
                        <option value="Producto Nacional"
                                {{ $producto->origen=='Producto Nacional' ? 'selected' : '' }}>
                          Producto Nacional
                        </option>
                        <option value="Producto Importado"
                                {{ $producto->origen=='Producto Importado' ? 'selected' : '' }}>
                          Producto Importado
                        </option>
                      </select>
                    </div>
                    <div class="col-sm-3">
                      <select name="familia_id"
                              id="familia_id_sl"
                              class="form-control familia_select2"
                              required
                              onchange="list_subfamilia()">
                        <option value="">Seleccionar familia</option>
                        @foreach($familias as $familia)
                          <option value="{{ $familia->id }}"
                                  {{ optional($producto->familia_i_producto)->id == $familia->id ? 'selected' : '' }}>
                            {{ $familia->descripcion }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-3">
                      <select name="sub_familia_id"
                              class="form-control subfamilia_select2">
                        @if($producto->subfamilia_id)
                          <option value="{{ optional($producto->subfamilia_i_producto)->id }}">
                            {{ optional($producto->subfamilia_i_producto)->descripcion }}
                          </option>
                        @endif
                      </select>
                    </div>
                  </div>
                </div>

                <hr style="border:1px solid #ddd;">

                {{-- Descuentos y utilidad --}}
                <div class="row mb-2 align-items-center">
                  <label class="col-sm-2 col-form-label">Desct.1:</label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-addon">%</span></div>
                      <input type="text"
                             name="descuento1"
                             class="form-control input_valor_numerico"
                             value="{{ $producto->descuento1 }}"
                             required>
                    </div>
                  </div>
                  <label class="col-sm-2 col-form-label">Desct.2:</label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-addon">%</span></div>
                      <input type="text"
                             name="descuento2"
                             class="form-control input_valor_numerico"
                             value="{{ $producto->descuento2 }}"
                             required>
                    </div>
                  </div>
                </div>

                <div class="row mb-3 align-items-center">
                  <label class="col-sm-2 col-form-label">Desct.Máximo:</label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-addon">%</span></div>
                      <input type="text"
                             name="descuento_maximo"
                             class="form-control input_valor_numerico"
                             value="{{ $producto->descuento_maximo }}"
                             required>
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
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-addon">%</span></div>
                      <input type="text"
                             id="sumando"
                             name="utilidad"
                             class="form-control input_valor_numerico"
                             value="{{ $producto->utilidad }}"
                             required>
                    </div>
                  </div>
                </div>

                {{-- Unidad, peso y garantía --}}
                <div class="row mb-3 align-items-center">
                  <label class="col-sm-2 col-form-label">Ud.Medida:</label>
                  <div class="col-sm-4">
                    <select name="unidad_medida_id"
                            class="form-control"
                            required>
                      <option value="{{ optional($producto->unidad_i_producto)->id }}"
                              style="font-weight:bold">
                        {{ optional($producto->unidad_i_producto)->medida }}
                      </option>
                      @foreach($unidad_medidas as $um)
                        <option value="{{ $um->id }}">{{ $um->medida }}</option>
                      @endforeach
                    </select>
                  </div>
                  <label class="col-sm-2 col-form-label">Peso:</label>
                  <div class="col-sm-2">
                    <input type="number"
                           name="peso"
                           class="form-control"
                           value="{{ $peso }}"
                           required>
                  </div>
                  <div class="col-sm-2">
                    <select name="simbolo"
                            class="form-control"
                            required>
                      <option value="{{ $simbolo }}">{{ $simbolo }}</option>
                      <option value="Kilos">Kilos</option>
                      <option value="Gramos">Gramos</option>
                      <option value="Toneladas">Toneladas</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-4 align-items-center">
                  <label class="col-sm-2 col-form-label">Garantía:</label>
                  <div class="col-sm-4">
                    <input type="text"
                           name="garantia"
                           class="form-control"
                           value="{{ $producto->garantia }}"
                           required>
                  </div>
                  <label class="col-sm-2 col-form-label">Stock Mínimo:</label>
                  <div class="col-sm-4">
                    <input type="text"
                           name="stock_minimo"
                           class="form-control"
                           value="{{ $producto->stock_minimo }}"
                           required>
                  </div>
                  <label class="col-sm-2 col-form-label">Stock Máximo:</label>
                  <div class="col-sm-4">
                    <input type="text"
                           name="stock_maximo"
                           class="form-control"
                           value="{{ $producto->stock_maximo }}"
                           required>
                  </div>
                </div>

                {{-- Tipo de Afectación corregido con optional() --}}
                <div class="row mb-4 align-items-center">
                  <label class="col-sm-2 col-form-label">Tipo de Afectación:</label>
                  <div class="col-sm-4">
                    <select name="tipo_afectacion"
                            class="form-control"
                            required>
                      {{-- opción ya guardada --}}
                      <option value="{{ $producto->tipo_afectacion_id }}"
                              style="font-weight:bold">
                        {{ optional($producto->tipoAfectacion)->informacion }}
                      </option>
                      {{-- resto de opciones --}}
                      @foreach($tipo_afectacion as $tipo_afec)
                        <option value="{{ $tipo_afec->id }}">
                          {{ $tipo_afec->informacion }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <label class="col-sm-2 col-form-label">Fecha creación:</label>
                  <div class="col-sm-4">
                    <input type="text"
                           class="form-control"
                           readonly
                           value="{{ $producto->created_at->format('d/m/Y H:i') }}">
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
                        <a href="{{ asset('archivos/productos/fichas/'.$producto->archivo) }}"
                           download
                           class="btn btn-secondary ml-2">
                          <i class="fa fa-download"></i>
                        </a>
                      </div>
                    @else
                      <div class="custom-file">
                        <input type="file"
                               name="archivo_producto"
                               class="custom-file-input"
                               id="logo">
                        <label class="custom-file-label"
                               for="logo">Seleccionar archivo...</label>
                      </div>
                    @endif
                  </div>
                </div>

                {{-- Botón de guardar --}}
                <div class="row">
                  <div class="col-sm-12">
                    <button type="submit"
                            class="btn btn-success btn-block">
                      Guardar
                    </button>
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- Footer opcional --}}
          <div class="ibox-footer text-right">
            <small>Creado: {{ $producto->created_at->diffForHumans() }}</small>
          </div>

        </div>
      </div>
    </div>
  </div>
</form>

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
