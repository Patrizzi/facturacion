@extends('layout')

@section('title', 'Servicios')
@section('href_accion', route('servicios.index') )
@section('atributo_actu', 'hidden')
@section('value_accion', 'Atrás')

@section('content')
<!--
    <form action="{{ route('servicios.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
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
                        <img src="{{ asset('/archivos/imagenes/servicios/servicio.png')}}" style="width:100%;padding: 30px;">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="tooltip-demo">
                  <div class="row" style="padding-bottom:10px">
                    <div class="col-sm-3" align="center">
                      <input placeholder="SERV-0X33X345XX" data-toggle="tooltip" data-placement="top"  title="Código Alternativo:" type="text" class="form-control" name="codigo_original" autocomplete="off">
                    </div>
                    <div class="col-sm-3" align="center">
                      <div data-toggle="tooltip" data-placement="top" title="Familia">
                        <select   class="familia_select2 form-control" name="familia_id" id="familia_id_sl" required="required" onchange="list_subfamilia()">
                          <option value=""></option>
                            @foreach($familias as $familia)
                              <option value="{{ $familia->id }}">{{ $familia->descripcion}}</option>
                            @endforeach
                          </select>
                      </div>
                      {{-- <select data-toggle="tooltip" data-placement="top" title="Familia"  class="form-control" name="familia_id" required="required">
                      @foreach($familias as $familia)
                          <option value="{{ $familia->id }}">{{ $familia->descripcion}}</option>
                      @endforeach
                      </select> --}}
                    </div>
                    <div class="col-sm-3" align="center">
                      <div data-toggle="tooltip" data-placement="top" title="Subfamilia">
                        <select  class="subfamilia_select2 form-control" name="sub_familia_id" >
                          {{-- <option value="" aria-readonly="">Seleccionar</option> --}}
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3" align="center">
                      <select  data-toggle="tooltip" data-placement="top" title="Marca"class="marca_select2 " name="marca_id" required="required">
                      @foreach($marcas as $marca)
                        <option value="{{ $marca->id }}">{{ $marca->nombre}}</option>
                      @endforeach
                      </select>
                    </div>
                  </div>
                  <input type="text" placeholder="Nombre del Servicio" class="form-control" required="required" data-toggle="tooltip" name="nombre" data-placement="top" title="Nombre del Servicio"  autocomplete="off" >
                  <textarea style="margin-top:10px" data-toggle="tooltip" data-placement="top" title="Description del Servicio"  type="text" class="form-control" placeholder="Descripción del Servicio" name="descripcion" rows="2" ></textarea >
                </div>
                <hr style="border:1px solid #8080803d;">
                <div class="tooltip-demo" >
                  <div class="row">
                    <label class="col-sm-2 col-form-label">Descuento:</label>
                    <div class="col-sm-4">
                      <div class="input-group m-b">
                        <div class="input-group-prepend">
                          <span class="input-group-addon">%</span>
                        </div>
                        <input type="text" class="form-control input_valor_numerico" name="descuento" required="required" value="0">
                      </div>
                    </div>
                    <label class="col-sm-2 col-form-label">Utilidad: <i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;" data-toggle="modal" data-target="#utilidad_modal"></i></label>
                    <div class="col-sm-4">
                      <div class="input-group m-b">
                        <div class="input-group-prepend">
                          <span class="input-group-addon">%</span>
                        </div>
                        <input type="text" class="form-control input_valor_numerico" name="utilidad" required="required" value="0" id="utilidad_calc">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 col-form-label">Precio s/igv:</label>
                    <div class="col-sm-4">
                      <div class="input-group m-b">
                        <div class="input-group-prepend">
                          <select class="input-group-addon"  name="moneda" id="moneda_id" >
                          @foreach($monedas as $moneda)
                            <option value="{{$moneda->id}}">{{$moneda->simbolo}}</option>
                          @endforeach
                          </select>
                        </div>
                        <input type="number" min="0" step="0.01" class="form-control" name="precio" required="required" value="1" id="precio_sin_igv" onchange="input_key()">
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
                      <button type="submit" class="ladda-button btn btn-success btn-block button_guardar" >Guardar</button>
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
</form>-->
<!-- Modal
<div class="modal fade" id="utilidad_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">¿En duda con su porcentaje de utilidad? Puede colocar su precio venta y el sistema calculará por ud.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-4">
            <p>Precio s/igv: </p>
          </div>
          <div class="col-sm-8">
            <div class="input-group m-b">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="sin_key"></span>
              </div>
              <input type="number" min="0" step="0.01" class="form-control" value="1" name="" id="key_sin_igv" onchange="modal_key()">
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-sm-4">
            <p>Precio de Venta: </p>
          </div>
          <div class="col-sm-8">
            <div class="input-group m-b">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="venta_key"></span>
              </div>
              <input type="number" min="0" step="0.01" class="form-control" name="" id="precio_venta">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        {{-- <button type="button" class="btn btn-secondary" >Close</button> --}}
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="calc_utilidad()">Calcular</button>
      </div>
    </div>
  </div>
</div>
-->

<!--Código 14/11/2024-->
    <form action="{{ route('servicios.store') }}" method="POST">
        @csrf
        
        <div class="row bg-white p-3 m-5 align-content-center">
            <!--Primera columna-->
            <div class="col-xl-5 col-lg-4 col-md-6 p-xl-5 p-md-4">
                <div class="row d-flex justify-content-between">
                    <input type="text" placeholder="SERV-0X33X345XX" class="form-control m-b col-xl-5">

                    <select class="form-control m-b col-xl-5 familia_select2" name="familia_id" id="familia_id_sl" required="required" onchange="list_subfamilia()">
                        {{-- <option>Servidores</option>
                        <option>Perifericos</option>
                        <option>Tablets</option>
                        <option>Computadoras de escritorio</option>
                        <option value="">Impresoras</option>
                        <option value="">Escaner</option> --}}
                        <option value=""></option>
                        @foreach($familias as $familia)
                            <option value="{{ $familia->id }}">{{ $familia->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row my-3 d-flex justify-content-between">
                    <select class="form-control m-b col-xl-5 subfamilia_select2" name="sub_familia_id">
                        {{-- <option>Sub familia</option>
                        <option>Sub familia</option>
                        <option>Sub familia</option>
                        <option>Sub familia</option>
                        <option value="">Sub familia</option>
                        <option value="">Sub familia</option> --}}
                    </select>
                    <select class="form-control m-b col-xl-5 marca_select2" name="marca_id" required="required">
                        {{-- <option>HP</option>
                        <option>Samsung</option>
                        <option>Lenovo</option>
                        <option>LG</option>
                        <option value="">sonic</option>
                        <option value="">Dell</option> --}}
                        <option value=""></option>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row mt-5">
                    <input type="text" placeholder="Nombre del Servicio" class="form-control" name="nombre">
                </div>
                <div class="row mt-3">
                    <!-- <input type="text" placeholder="Descripción del Servicio" class="form-control">-->
                        <textarea name="descripcion" id="" placeholder="Descripción del Servicio" class="form-control" style="height: 100px;"></textarea>
                </div>
            </div>

            <!--Segunda columna-->
            <div class="col-xl-7 col-lg-8 col-md-6 align-content-center align-items-center py-xl-4 py-md-3 ps-xl-4 border border-primary border-right-0 border-bottom-0 border-top-0">
                <div class="row">
                    <div class="col-xl-8 col-lg-9">
                        <div class="form-group row">
                            <label class="col-xl-2 col-md-3 col-form-label">Descuento:</label>
                            <div class="input-group m-b col-xl-10 col-md-9">
                                <div class="input-group-prepend">
                                    <span class="input-group-addon">%</span>
                                </div>
                                <input type="text" placeholder="Descuento" class="form-control" name="descuento">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-2 col-md-3 col-form-label">Utilidad:</label>
                            <div class="input-group m-b col-xl-10 col-md-9">
                                <div class="input-group-prepend">
                                    <span class="input-group-addon">%</span>
                                </div>
                                <input type="text" placeholder="Utilidad" class="form-control" name="utilidad">
                            </div>
                        </div>
                        <div class="form-group row" style="width: 100% !important;">
                            <label class="col-xl-2 col-md-3 col-form-label">Afectación:</label>
                            <div class="m-b col-xl-10 col-md-9 content-afect-select">
                                <select class="form-control m-b afec_select2" name="afectacion">
                                    {{-- <option>Gravado - Operación Onerosa</option>
                                    <option>Gravado - Retiro</option>
                                    <option>Gravado - IVAP</option>
                                    <option>Inafecto - Retiro</option> --}}
                                    @foreach($afectacion as $afect)
                                        <option value="{{ $afect->id }}">{{ $afect->informacion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-2 col-md-3 col-form-label">Precio S/IGV:</label>
                            <div class="input-group m-b col-xl-10 col-md-9">
                                <div class="input-group-prepend">
                                    {{-- <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button" aria-expanded="false">Action </button>
                                    <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 35px; left: 0px; will-change: top, left;">
                                        <li><a href="#">S/</a></li>
                                        <li><a href="#">$</a></li>
                                        <li><a href="#">E</a></li>
                                    </ul> --}}
                                    <select class="col-xl-2 col-md3"  name="moneda" id="moneda_id" >
                                    @foreach($monedas as $moneda)
                                        <option value="{{$moneda->id}}">{{$moneda->simbolo}}</option>
                                    @endforeach
                                </div>
                                <input type="number" min="0" step="0.01" class="form-control" name="precio" required="required" value="1" id="precio_sin_igv" onchange="input_key()">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-3 d-flex justify-content-center align-items-center">
                        <p>
                            <a href=""><img src="{{ asset('/archivos/imagenes/servicios/servicio.png')}}" alt="" class="img-size"></a>
                        </p>
                        <!--
                        <form action="#" class="dropzone dz-clickable" id="dropzoneForm">
                            <div class="dz-default dz-message">
                                <span>
                                    <strong>Drop files here or click to upload. </strong><br> (This is just a demo dropzone. Selected files are not actually uploaded.)
                                </span>

                            </div>
                        </form>
                        -->
                    </div>
                    <button type="submit" class="btn  btn-block btn-primary mx-3">Guardar</button>
                </div>
            </div>
        </div>
    </form>

<style>
    @media(min-width:300px){
        .img-size{
            min-height: 90px;
            min-width: 90px;
            max-height: 90px;
            max-width: 90px;
        }
    }
    @media(min-width:500px){
        .img-size{
            min-height: 100px;
            min-width: 100px;
            max-height: 100px;
            max-width: 100px;
        }
    }
    @media(min-width:740px){
        .img-size{
            min-height: 120px;
            min-width: 120px;
            max-height: 120px;
            max-width: 120px;
        }
    }
    @media(min-width:1440px){
        .img-size{
            min-height: 180px;
            min-width: 180px;
            max-height: 180px;
            max-width: 180px;
        }
    }
</style>

<!-- Fin del código actual :) -->


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
  .select2-selection.select2-selection--single{
    text-align: justify !important;
  }
  .select2.select2-container.select2-container--default{
    width: 42% !important;
    height: 100% !important;
  }
  .select2-container--default .select2-selection--single{
    height: 100% !important;
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
  .content-afect-select .select2.select2-container.select2-container--default {
        width: 100% !important;
        height: 100% !important;
    }

</style>



<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
{{-- foto --}}
<script type="text/javascript">
    $(document).ready(function(){
        $('.familia_select2').select2({
            placeholder: "Seleccionar Familia",
        });
        $('.subfamilia_select2').select2({
            placeholder: "Seleccionar Subfamilia",
        });
        $('.marca_select2').select2({
            placeholder: "Seleccionar Marca",
        });
        $('.afec_select2').select2({
            placeholder: "Seleccionar Afectación",
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
      if (archivoInput.files && archivoInput.files[0]){
        var visor = new FileReader();
        visor.onload = function(e){
          document.getElementById('visorArchivo').innerHTML =
          '<img name="foto" src="'+e.target.result+'" style="width:100%;padding: 30px;"/>';
        };
        visor.readAsDataURL(archivoInput.files[0]);
      }
    }
  }
  function calc_utilidad(){
     var precio_sin_igv = $('#precio_sin_igv').val();
     var precio_venta = $('#precio_venta').val();

     if (!isNaN(precio_venta) || !isNaN(precio_sin_igv) ) {
      // var utilidad = (parseFloat(precio_compra)/100) * parseFloat(precio_venta);
      var a1 =  parseFloat(precio_venta) * 100;
      var a2 = parseFloat(a1) / parseFloat(precio_sin_igv);
      var utilidad = parseFloat(a2) - 100;
      document.getElementById("utilidad_calc").value = utilidad;
      // console.log(utilidad)
    }

    //  var precio = (precio_sin_igv/precio_venta) * 100;
    //  console.log(precio);
  }
  function modal_key(){
    // moneda
    var precio_sin_igv = $('#key_sin_igv').val();

    $('#precio_sin_igv').val(precio_sin_igv) ;
  }
  function input_key(){
    var precio_venta = $('#precio_venta').val();
    var precio_sin_igv = $('#precio_sin_igv').val();
    $('#key_sin_igv').val(precio_sin_igv) ;
    if(precio_venta != ""){
      calc_utilidad();
    }
  }
  // document{
    // function changue_moneda(){
      var select = document.getElementById('moneda_id');
      select.addEventListener('change',
      function(){
        var selectedOption = this.options[select.selectedIndex];
        // console.log(selectedOption.text);
        $('#sin_key').html(selectedOption.text)
        $('#venta_key').html(selectedOption.text)
      });
    // }
  // }
  $(document).ready(function() {
    var select = document.getElementById('moneda_id');
      // select.addEventListener('change',function(){
        var selectedOption = select.options[select.selectedIndex];
        // console.log(selectedOption.text);
        $('#sin_key').html(selectedOption.text)
        $('#venta_key').html(selectedOption.text)
      // });
  });
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
@endsection
