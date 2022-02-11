@extends('layout')
@section('title', 'Mi Empresa')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Editar')
@section('atributo_actu', 'hidden')
@section('config',route('Configuracion'))

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
  <!-- Modal Create  -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-left: 25%">
      <div class="modal-content" style="width: 702.22222px;">

        <div style="padding-left: 15px;padding-right: 15px;">
          {{-- ccccccccccccccccc --}}
          <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px" align="center">

            <form action="{{route('empresa.update',$mi_empresa->id) }}"  enctype="multipart/form-data" method="post">
              @csrf
              @method('PATCH')
              <fieldset >
                <div>
                  <div class="panel-body" >
                    <div class="row">
                      <div class="col-sm-12">
                       <input type="file" id="archivoInputs" name="fotos" onchange="return validarExtImg()" align="right" style="cursor: pointer;text-align: center;" />
                       <div id="visorArchivos">
                         <!--Aqui se desplegará el fichero-->
                         <center >
                          <img src="{{asset('img/logos/'.$mi_empresa->foto)}}" style="width: 350px;;margin-bottom: 15px;"></center>
                        </div>
                        <input type="text" value="{{$mi_empresa->foto}}" style="width: 350px;margin-bottom: 15px;" class="form-control" name="ori_foto" hidden="hidden" >
                      </div>


                      <label class="col-sm-2 col-form-label">Descripcion:</label>
                      <div class="col-sm-10" style="padding-bottom: 10px">
                        <textarea name="descripcion" required class="form-control">{{$mi_empresa->descripcion}}</textarea>
                      </div>
                      <label class="col-sm-2 col-form-label">Movil:</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" required name="movil" value="{{$mi_empresa->movil}}">
                      </div>
                      <label class="col-sm-2 col-form-label">Telefono:</label>
                      <div class="col-sm-4" style="padding-bottom: 15px; ">
                        <input type="text" class="form-control" required name="telefono" value="{{$mi_empresa->telefono}}">
                      </div>

                      <label class="col-sm-2 col-form-label">Correo:</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" required name="correo" value="{{$mi_empresa->correo}}">
                      </div>
                      <label class="col-sm-2 col-form-label">Region Provincia:</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" required name="region_provincia" value="{{$mi_empresa->region_provincia}}">
                      </div>
                      <label class="col-sm-2 col-form-label">Pais:</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" required name="pais" value="{{$mi_empresa->pais}}">
                      </div>
                      <label class="col-sm-2 col-form-label">Ciudad:</label>
                      <div class="col-sm-4" style="padding-bottom: 15px">
                        <input type="text" class="form-control" required name="ciudad" value="{{$mi_empresa->ciudad}}">
                      </div>
                      <label class="col-sm-2 col-form-label">Calle:</label>
                      <div class="col-sm-4" style="padding-bottom: 15px">
                        <textarea name="calle" class="form-control" required>{{$mi_empresa->calle}}</textarea>
                      </div>
                      <label class="col-sm-2 col-form-label">Codigo Postal:</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" required name="codigo_postal" value="{{$mi_empresa->codigo_postal}}">
                      </div>
                      <label class="col-sm-2 col-form-label">Rubro:</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" required name="rubro" value="{{$mi_empresa->rubro}}">
                      </div>
                      <label class="col-sm-2 col-form-label">Pagina Web:</label>
                      <div class="col-sm-4" style="    padding-bottom: 10px;">
                        <input  type="text" class="form-control" required name="pagina_web" value="{{$mi_empresa->pagina_web}}">
                      </div>
                    </div>
                  </div>
                </div>

              </fieldset>
              <button class="btn btn-primary" type="submit">Grabar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- / Modal Create  -->


  <div class="ibox">
    <div class="ibox-content">
      <div class="row ">

        <div class="col-md-2">
          <img  src="{{asset('img/logos/'.$mi_empresa->foto)}}" alt="profile" width="300px">
        </div>

        <div class="col-md-8">
          <div class="profile-info">
            <div class="">
              <div>
                <h2 class="no-margins">{{$mi_empresa->nombre}}</h2>
                <h4>{{$mi_empresa->ruc}}</h4>
                <p>{{$mi_empresa->descripcion}}</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row">

    <div class="col-lg-3">

      <div class="ibox">
        <div class="ibox-content">
          <h3>Número en Contactos:</h3>
          <p class="font-bold"> <span><i class="fa fa-circle text-navy"></i> <b>Teléfono :</b> {{$mi_empresa->telefono}}</span></p>
          <p class="font-bold"> <span><i class="fa fa-circle text-navy"></i> <b>Celular :</b> {{$mi_empresa->movil}}</span> </p>
          <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Pagina Web :</b> {{$mi_empresa->pagina_web}}</span></p>
          <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Correo :</b> {{$mi_empresa->correo}}</span></p>
        </div>
      </div>

      <div class="ibox">
        <div class="ibox-content">
          <h3>Datos de Ubicacion:</h3>
          <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> País :</b> {{$mi_empresa->pais}}</span></p>
          <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Region Provincia :</b> {{$mi_empresa->region_provincia}}</span></p>
          <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Ciudad :</b> {{$mi_empresa->ciudad}}</span></p>
          <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Dirección :</b> {{$mi_empresa->calle}}</span></p>
          <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Código Postal :</b> {{$mi_empresa->codigo_postal}}</span></p>
        </div>
      </div>
    </div>

    {{-- MONEDAS --}}
    <div class="col-lg-5">
      <div class="ibox-content">
        <span style="font-size: 15px;"><b>Moneda Principal</b> <i style="color:#0f0ff7ad;" class="fa fa-check-circle "></i></span>
        <div class="row">

          @foreach($moneda as $monedas)
          <div class="col-lg-6"  @if($monedas->principal == 0) id="demo{{$monedas->id}}" @else id="demo_principal" @endif>
           <div class="widget p-lg text-center " style="">
            <div class="m-b-md">
              <i class="fa fa-4x">{{$monedas->simbolo}}</i>
              <h1 class="m-xs">{{$monedas->codigo}}</h1>
              <h3 class="font-bold no-margins"> {{$monedas->nombre}}
               @if($monedas->principal == 1)<i class="fa fa-check-circle"></i> @endif
             </h3>
             <small>Moneda {{$monedas->tipo}}</small>
           </div>
         </div>
       </div>
       @endforeach
     </div>
   </div>

   <div class="ibox" style="padding-top:15px">
    <div class="ibox-content">
      <h3>Impuesto:</h3>
      <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> IGV :</b> 18%</span></p>
      <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Impuesto Renta :</b> 18%</span></p>
    </div>
  </div>
</div>
{{-- MONEDAS --}}


<div class="col-lg-4 m-b-lg">
  <div id="vertical-timeline" class="vertical-container light-timeline no-margins">

    @foreach($banco as $bancos)
    <div class="vertical-timeline-block">
      <div class="vertical-timeline-icon blue-bg">
        <i class="fa fa-bank"></i>
      </div>

      <div class="vertical-timeline-content" align="center">
       @if($bancos->estado==0)
       <i class="fa fa-circle" style="color: #5fa8f3;"></i>
       @else
       <i class="fa fa-circle"></i>
       @endif
       <img data-toggle="modal" data-target="#exampleModal{{$bancos->id}}" src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 150px;cursor: pointer;"><br>
     </div>
   </div>

   <div class="modal fade" id="exampleModal{{$bancos->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div style="padding-left: 15px;padding-right: 15px;">
          {{-- ccccccccccccccccc --}}
          <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

            <form action="{{ route('banco.update',$bancos->id) }}"  enctype="multipart/form-data" method="post">
              @csrf
              @method('PATCH')
              <fieldset >
                <div>
                  <div class="panel-body" >
                    <div class="row">
                      {{-- Foto --}}
                      <div class="col-sm-12">
                       <input type="file" id="archivoInput{{$bancos->id}}" name="foto" onchange="return validarExt{{$bancos->id}}()"  />
                       <div id="visorArchivo{{$bancos->id}}">
                         <!--Aqui se desplegará el fichero-->
                         <center >
                          <img src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 200px;margin-bottom: 15px;border-radius: 10px"></center>
                        </div>
                        <input type="text" value="{{$bancos->foto}}" class="form-control" name="ori_foto" hidden="hidden">
                      </div>
                    </div>
                    {{--/ foto --}}
                    {{-- Registros --}}
                    <div class="row">
                      <div class="col-lg-12" style="padding-bottom: 10px;" align="right" id="div_boton{{$bancos->id}}">
                        <button type="button" class="btn btn-info" id="btn_add_{{$bancos->id}}"> <i class="fa fa-plus-square"></i></button>
                      </div>
                    </div>
                    @foreach($banco_registro as $banco_registros)
                    @if($banco_registros->banco_id==$bancos->id)
                    <div class="row"  style="padding-top: 10px;padding-bottom: 10px;">
                      <div class="col-lg-6">
                        <input type="text" name="creadas_id[]" hidden value=" {{$banco_registros->id}}" readonly>
                        <input type="text" name="descripcion1_creadas[]" class="form-control" value=" {{$banco_registros->descripcion1}}">
                      </div>
                      <div class="col-lg-6">
                        <input type="text" name="descripcion2_creadas[]" class="form-control descripcion2_creadas{{$bancos->id}}" value=" {{$banco_registros->descripcion2}}">
                      </div>
                      <div class="col-lg-2" align="right">
                      </div>
                    </div>
                    @endif
                    @endforeach
                    <div id="conteiner_add_{{$bancos->id}}" >
                    </div>
                    {{-- Registros --}}

                    <div class="row"  style="padding-top: 10px;padding-bottom: 10px;">

                     <label class="col-sm-3 col-form-label">Activo/Desactivo:</label>
                     <div class="col-sm-3">
                      @if($bancos->estado == 0)
                      <div class="switch-button">
                        <input type="checkbox" name="estado" id="switch-label{{$bancos->id}}" class="switch-button__checkbox" checked="">
                        <label for="switch-label{{$bancos->id}}" class="switch-button__label"></label>
                      </div>
                      @else
                      <div class="switch-button">
                        <input type="checkbox" name="estado" id="aswitch-label{{$bancos->id}}" class="switch-button__checkbox" >
                        <label for="aswitch-label{{$bancos->id}}" class="switch-button__label"></label>
                      </div>
                      @endif
                    </div>
                    <div class="col-sm-2">
                      <button class="ladda-button btn btn-primary" type="submit" data-style="zoom-out">Guardar</button>
                    </div>
                  </div>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
</div>
</div>
</div>
@foreach($banco as $bancos)
<script type="text/javascript">
  {{-- Fotooos --}}
  function validarExt{{$bancos->id}}(){
    var archivoInput = document.getElementById('archivoInput{{$bancos->id}}');
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
            document.getElementById('visorArchivo{{$bancos->id}}').innerHTML =
            '<img name="firma" src="'+e.target.result+'" style="width: 300px;height: 120px;margin-bottom: 15px;border-radius: 10px" />';
          };
          visor.readAsDataURL(archivoInput.files[0]);
        }
      }
    }
  </script>
  <style>input#archivoInput{{$bancos->id}}{
    position:absolute;
    top:0px;
    left:0px;
    right:0px;
    bottom:0px;
    width:100%;
    height:100%;
    opacity: 0  ;
  }</style>
  @endforeach
  <div id="form">

  </div>
  <form action="{{ route('moneda.update',1) }}"  enctype="multipart/form-data" method="post"  id="myForm">
    @csrf
    @method('PATCH')
  </form>
  <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>
  <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
  <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

  @foreach($moneda as $monedas)
  <!-- Sweet alert -->
  <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
  <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">

  <script>

    $('#demo_principal').click(function(){
      swal({
        title: "{{$monedas->simbolo}} {{$monedas->nombre}}",
        text: "Moneda '{{$monedas->nombre}}' actualmente registrada como Moneda Principal."
      });
    });


    $(document).ready(function () {
      $('#demo{{$monedas->id}}').click(function () {
        swal({
          title: "¿Deseas Cambiar '{{$monedas->simbolo}} {{$monedas->nombre}}'' como moneda Principal ?",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3686ff",
          confirmButtonText: "Si, Cambiar",
          cancelButtonText: "Cancelar!",
          closeOnConfirm: false,
          closeOnCancel: false },
          function (isConfirm) {
            if (isConfirm) {
             var data = `  <input type="hidden" hidden name="id_moneda" randoly value="{{$monedas->id}}" >
             `;
             $('#myForm').append(data);
             document.getElementById("myForm").submit();
             swal("Moneda Cambiada", "Ahora debes Registrar el Tipo de Cambio", "success");
           } else {
            swal("Cancelado", "", "error");
          }
        });
      })
    });
  </script>
  @endforeach
  <!-- Custom and plugin javascript -->
  <script src="{{ asset('js/inspinia.js') }}"></script>
  <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
  <style type="text/css" media="screen">
    #vertical-timeline.light-timeline:before {
      background: #0d9eff;
    }
    .widget{ border-radius: 50%;border: 8px solid #7e7e7eab;transition: 0.8s;cursor: pointer;}
    .widget:hover{ background: #bdbcbc94; color: white;}
    :root {
      --color-button: #fdffff;
    }
    .switch-button {
      display: inline-block;
      padding-top: 9px;
      padding-right: 30px;
    }
    .switch-button .switch-button__checkbox {
      display: none;
    }
    .switch-button .switch-button__label {
      background-color:#1f1f1f66;
      width: 2rem;
      height: 1rem;
      border-radius: 3rem;
      display: inline-block;
      position: relative;
    }
    .switch-button .switch-button__label:before {
      transition: .6s;
      display: block;
      position: absolute;
      width: 1rem;
      height: 1rem;
      background-color: var(--color-button);
      content: '';
      border-radius: 50%;
      box-shadow: inset 0px 0px 0px 1px black;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label {
      background-color: #1c84c6;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
      transform: translateX(1rem);
    }
    .banco{border-radius: 5px;border: 1px solid black }

    input#archivoInputs{
      position:absolute;
      right:130px;
      width:350px;
      height:100%;
      opacity: 0  ;
    }</style>
    <script type="text/javascript">
      {{-- Fotooos --}}
      function validarExtImg(){
        var archivoInput = document.getElementById('archivoInputs');
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
            document.getElementById('visorArchivos').innerHTML =
            '<img name="fotos" src="'+e.target.result+'" style="width: 350px;margin-bottom: 15px;border-radius: 10px"/>';
          };
          visor.readAsDataURL(archivoInput.files[0]);
        }
      }
    }
  </script>
  @foreach($banco as $bancos)
  <script>
    var x = 1;
    $("#btn_add_{{$bancos->id}}").on('click', function () {
      var suma{{$bancos->id}} = document.getElementsByClassName('descripcion2').length;
      var otra_suma{{$bancos->id}} = document.getElementsByClassName('descripcion2_creadas{{$bancos->id}}').length;
      var inp_mont{{$bancos->id}} = suma{{$bancos->id}} + otra_suma{{$bancos->id}} ;
// alert(inp_mont{{$bancos->id}});
      if(inp_mont{{$bancos->id}}>3){
      }
        else{
      var data = `
      <div class="delete_modal${x} row" style="padding-top: 5px;padding-bottom: 5px;">
      <div class="col-lg-5">
      <input type="text" name="descripcion1[]" class="form-control" >
      </div>
      <div class="col-lg-5">
      <input type="text" name="descripcion2[]" class="form-control descripcion2" >
      </div>
      <div class="col-lg-2" align="right">
      <button type="button" class="btn btn-secondary" onclick="eliminar(${x})"><i class="fa fa-trash-o"></i></button>
      </div>
      </div>`;
      $('#conteiner_add_{{$bancos->id}}').append(data);

      x++;
      }

    });

    function eliminar(x){
      $(`.delete_modal${x}`).remove();
    };
  </script>
  @endforeach
  @endsection