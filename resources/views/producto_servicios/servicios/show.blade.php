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

                  <div class="col-sm-4" align="center">
                    <input placeholder="SERV-0X33X345XX" data-toggle="tooltip" data-placement="top"  title="Código Alternativo:" type="text" class="form-control" name="codigo_original" autocomplete="off" value="{{$servicios->codigo_original}}">
                  </div>
                  <div class="col-sm-4" align="center">
                    <div data-toggle="tooltip" data-placement="top"  title="Familia" >
                      <select class="familia_select2" name="familia_id" required="required" onchange="list_subfamilia()" >
                        @foreach($familias as $familia)
                        <option value="{{ $familia->id }}"  @if( $servicios->familia->id == $familia->id) selected @endif>{{ $familia->descripcion}}</option>
                        @endforeach
                      </select>
                    </div>
                 </div>
                <div class="col-sm-4" align="center">
                  <div data-toggle="tooltip" data-placement="top" title="Sub Familia">
                    <select class="subfamilia_select2 form-control" name="sub_familia_id">
                      @foreach($subfamilias as $subfamilia)
                        <option value="{{ $subfamilia->id }}"  @if( $servicios->subfamilia_id == $subfamilia->id) selected @endif>{{ $subfamilia->descripcion}}</option>
                      @endforeach
                    </select>
                  </div>
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
                    <input type="text" class="form-control input_valor_numerico" name="descuento" required="required" value="{{$servicios->descuento}}" >
                  </div>
                </div>
                <label class="col-sm-2 col-form-label">Utilidad: <i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;" data-toggle="modal" data-target="#utilidad_modal"></i></label>
                <div class="col-sm-4"><div class="input-group m-b">
                  <div class="input-group-prepend">
                    <span class="input-group-addon">%</span>
                  </div>
                  <input type="text" class="form-control input_valor_numerico" name="utilidad" required="required" value="{{$servicios->utilidad}}" id="utilidad_inpt">
                </div>
              </div>

            </div>


            <div class="row">

              <label class="col-sm-2 col-form-label">Precio s/igv:</label>
              <div class="col-sm-4"><div class="input-group m-b">
                <div class="input-group-prepend">
                  <select class="input-group-addon"  name="moneda" id="moneda_id">
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
</form>
<!-- Modal -->
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
              @if($servicios->moneda->id==2)
                {{-- <input type="number" min="0" step="0.01" class="form-control" name="precio" required="required"  > --}}
                <input type="number" min="0" step="0.01" class="form-control" value="{{$servicios->precio_extranjero}}" name="" id="key_sin_igv" onchange="modal_key()">
              @else
              <input type="number" min="0" step="0.01" class="form-control" value="{{$servicios->precio_nacional}}" name="" id="key_sin_igv" onchange="modal_key()">
                {{-- <input type="number" min="0" step="0.01" class="form-control" name="precio" required="required" value="{{$servicios->precio_nacional}}" > --}}
              @endif
              
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
  .select2-selection.select2-selection--single{
    text-align: justify !important;
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
      placeholder: "Seleccionar",
    
    });
    $('.subfamilia_select2').select2({
      placeholder: "Seleccionar",
    });
  });
  // $('.subfamilia_select2').val({{$servicios->subfamilia_id}});
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
    function calc_utilidad(){
     var precio_sin_igv = $('#key_sin_igv').val();
     var precio_venta = $('#precio_venta').val();

     if (!isNaN(precio_venta) || !isNaN(precio_sin_igv) ) {
      // var utilidad = (parseFloat(precio_compra)/100) * parseFloat(precio_venta);
      var a1 =  parseFloat(precio_venta) * 100;
      var a2 = parseFloat(a1) / parseFloat(precio_sin_igv);
      console.log(precio_sin_igv)
      var utilidad = parseFloat(a2) - 100;
      document.getElementById("utilidad_inpt").value = utilidad;
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
    var precio_sin_igv = $('#key_sin_igv').val();
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