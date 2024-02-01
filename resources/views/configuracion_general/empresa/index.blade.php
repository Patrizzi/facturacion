@extends('layout')
@section('title', 'Mi Empresa')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Editar')
@section('atributo_actu', 'hidden')
@section('config',route('Configuracion'))

@section('content')

  <!-- Modal Create  -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-left: 25%">
      <div class="modal-content" style="width: 702.22222px;">
        <div style="padding-left: 15px;padding-right: 15px;">
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
                            <img src="{{asset('img/logos/'.$mi_empresa->foto)}}" style="width: 350px;;margin-bottom: 15px;">
                          </center>
                        </div>
                        <input type="text" value="{{$mi_empresa->foto}}" style="width: 350px;margin-bottom: 15px;" class="form-control" name="ori_foto" hidden="hidden" >
                      </div>
                      <label class="col-sm-2 col-form-label">Descripción:</label>
                      <div class="col-sm-10" style="padding-bottom: 10px">
                        <textarea name="descripcion" required class="form-control">{{$mi_empresa->descripcion}}</textarea>
                      </div>
                      <label class="col-sm-2 col-form-label">Movil:</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" required name="movil" value="{{$mi_empresa->movil}}">
                      </div>
                      <label class="col-sm-2 col-form-label">Teléfono:</label>
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
                      <label class="col-sm-2 col-form-label">País:</label>
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
                      <label class="col-sm-2 col-form-label">Código Ubigeo:</label>
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
              <button class="btn btn-primary" type="submit">Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- / Modal Create  -->

  <div class="wrapper wrapper-content animated fadeInRight">
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
  </div>

  <div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
      <div class="">
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
                <h3>Datos de Ubicación:</h3>
                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> País :</b> {{$mi_empresa->pais}}</span></p>
                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Region Provincia :</b> {{$mi_empresa->region_provincia}}</span></p>
                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Ciudad :</b> {{$mi_empresa->ciudad}}</span></p>
                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Dirección :</b> {{$mi_empresa->calle}}</span></p>
                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Código Ubigeo :</b> {{$mi_empresa->codigo_postal}}</span></p>
              </div>
            </div>
          </div>
          {{-- MONEDAS --}}
          <div class="col-lg-5">
            <div class="ibox-content">
              <span style="font-size: 15px;"><b>Moneda Principal</b> <i style="color:#0f0ff7ad;" class="fa fa-check-circle "></i></span>
              <div class="row">
                @foreach($moneda as $monedas)
                  <div class="col-lg-6"  @if($monedas->principal == 0) id="demo{{$monedas->id}}" @else id="demo_principal{{$monedas->id}}" @endif>
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
          {{-- FIN MONEDAS --}}
          <div class="col-lg-4 m-b-lg">
            <div id="vertical-timeline" class="vertical-container light-timeline no-margins">
              @foreach($banco as $bancos)
                <div class="vertical-timeline-block">
                  <div class="vertical-timeline-icon blue-bg">
                    <i class="fa fa-bank"></i>
                  </div>
                  <div class="vertical-timeline-content" align="center">
                    @if($bancos->estado==0)
                    {{-- TIPO DE CUENTA = NOMBRE DE BANCO --}}
                      <strong><span>{{$bancos->nombre_banco}}</span></strong>
                      <br>
                      <i class="fa fa-circle" style="color: #5fa8f3;"></i>
                    @else
                      <i class="fa fa-circle"></i>
                    @endif
                    <img data-toggle="modal" data-target="#exampleModal{{$bancos->id}}" src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 150px;cursor: pointer;"><br>
                  </div>
                </div>
                {{-- MODAL BANCOS --}}
                <div class="modal fade" id="exampleModal{{$bancos->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div style="padding-left: 15px;padding-right: 15px;">
                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                          <form action="{{ route('banco.update',$bancos->id) }}"  enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PATCH')
                            <fieldset >
                              <div>
                                <div class="panel-body" >
                                  <div class="row" style="align-items: center !important">
                                    {{-- Foto --}}
                                    <div class="col-sm-6">
                                      <strong>Nombre</strong>
                                      <input type="text" class="form-control" name="nombre_banco" id="" value="{{$bancos->nombre_banco}}" autocomplete="off">
                                      <strong>Titular</strong>
                                      <input type="text" class="form-control" name="titular" id="" value="{{$bancos->titular }}"  autocomplete="off">
                                    </div>
                                    <div class="col-sm-6">
                                      <strong>Imagen</strong><br>
                                      <div class="form-control" style="margin: 0px">
                                        <input type="file" id="archivoInput{{$bancos->id}}" name="foto" onchange="return validarExt{{$bancos->id}}()"  />
                                        <div id="visorArchivo{{$bancos->id}}">
                                          <!--Aqui se desplegará el fichero-->
                                          <center >
                                            <img src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 200px;margin: 13px 0px;border-radius: 10px">
                                          </center>
                                        </div>
                                      </div>
                                      <input type="text" value="{{$bancos->foto}}" class="form-control" name="ori_foto" hidden="hidden">
                                    </div>
                                    
                                  </div>
                                  <hr>
                                  {{--/ foto --}}
                                  {{-- Registros --}}
                                  <div class="row" style="align-items: center !important">
                                    <div class="col-lg-3" style="padding-bottom: 0px;">
                                      <strong>Tipo de Cuenta</strong>
                                    </div>
                                    <div class="col-lg-3">
                                      <strong>Moneda</strong>
                                    </div>
                                    <div class="col-lg-3" style="padding-bottom: 0px;">
                                      <strong>N° de Cuenta</strong>
                                    </div>
                                    <div class="col-lg-2" style="padding-bottom: 0px;">
                                      <strong>¿Detracción?</strong>
                                    </div>
                                    <div class="col-lg-1" style="padding-bottom: 0px;" align="right" id="div_boton{{$bancos->id}}">
                                      <button type="button" class="btn btn-info" id="btn_add_{{$bancos->id}}"> <i class="fa fa-plus-square"></i></button>
                                    </div>
                                  </div>
                                  
                                  {{-- @if (count($banco_registro->where('banco_id', $bancos->id)) == 0)
                                    <div class="row delete_modal_edit_0"  style="padding-top: 10px;padding-bottom: 10px;align-items: center !important">
                                      <div class="col-lg-3">
                                        <input type="text" name="creadas_id[]" hidden value="" readonly>
                                        <select name="descripcion1_creadas[]" class="form-control" id="">
                                          <option value="Cta C.">Cuenta Corriente</option>
                                          <option value="Cta Ah.">Cuenta Ahorro</option>
                                          <option value="Cta Det.">Cuenta Detracciones</option>
                                          <option value="CCI">Cod. C. Interbancario</option>
                                        </select>
                                      </div>
                                      <div class="col-lg-3">
                                        <select name="moneda_creada[]" class="form-control" id="">
                                          @foreach ($moneda as $monedas)
                                            <option value="{{$monedas->id}}">{{$monedas->nombre}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class="col-lg-3">
                                        <input type="text" name="descripcion2_creadas[]" class="form-control descripcion2_creadas" value=""  autocomplete="off">
                                      </div>
                                      <div class="col-lg-2" align="right">
                                        <input type="checkbox" class="form-control change_status" name="estado_detraccion" id="" value="on" >
                                        <input type="hidden" class="ipt_hidden" id="input_check_0" name="det_creada[]">
                                      </div>
                                      <div class="col-lg-1" align="right">
                                        <button type="button" class="btn btn-secondary" onclick="eliminar_edit(0)"><i class="fa fa-trash-o"></i></button>
                                        <input type="hidden" name="value_eliminar[]" id="eliminar_0" value="0">
                                      </div>
                                    </div>
                                    <input type="" id="count_reg_0" value="0">
                                  @else --}}
                                    @foreach($banco_registro->where('banco_id', $bancos->id) as $banco_registros)
                                        <div class="row delete_modal_edit_{{$banco_registros->id}}"  style="padding-top: 10px;padding-bottom: 10px;align-items: center !important">
                                          <div class="col-lg-3">
                                            <input type="text" name="creadas_id[]" hidden value=" {{$banco_registros->id}}" readonly>
                                            {{-- <input type="t ext" name="descripcion1_creadas[]" class="form-control" value=" {{$banco_registros->tipo_cuenta}}"> --}}
                                            <select name="descripcion1_creadas[]" class="form-control" id="">
                                              <option value="Cta C." @if($banco_registros->tipo_cuenta == 'Cta C.') selected @endif>Cuenta Corriente</option>
                                              <option value="Cta Ah." @if($banco_registros->tipo_cuenta == 'Cta Ah.') selected @endif>Cuenta Ahorro</option>
                                              <option value="Cta Det." @if($banco_registros->tipo_cuenta == 'Cta Det.') selected @endif>Cuenta Detracciones</option>
                                              <option value="CCI." @if($banco_registros->tipo_cuenta == 'CCI') selected @endif>Cod. C. Interbancario</option>
                                            </select>
                                          </div>
                                          <div class="col-lg-3">
                                            <select name="moneda_creada[]" class="form-control" id="">
                                              @foreach ($moneda as $monedas)
                                                <option value="{{$monedas->id}}" @if($monedas->id == $banco_registros->moneda_id) selected @endif>{{$monedas->nombre}}</option>
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="col-lg-3">
                                            <input type="text" name="descripcion2_creadas[]" class="form-control descripcion2_creadas{{$bancos->id}}" value=" {{$banco_registros->nombre_cuenta}}"  autocomplete="off">
                                          </div>
                                          <div class="col-lg-2" align="right">
                                            <input type="checkbox" class="form-control change_status" name="estado_detraccion" id="" @if($banco_registros->estado_detraccion == 1) checked  @endif value="on" >
                                            <input name="det_creada[]" class="ipt_hidden" type="hidden" id="input_check_{{$banco_registros->id}}" @if($banco_registros->estado_detraccion == 1) value="on" @else value="off"  @endif>
                                          </div>
                                          <div class="col-lg-1" align="right">
                                            <button type="button" class="btn btn-secondary" onclick="eliminar_edit({{$banco_registros->id}})"><i class="fa fa-trash-o"></i></button>
                                            <input type="hidden" name="value_eliminar[]" id="eliminar_{{$banco_registros->id}}" value="0">
                                          </div>
                                        </div>   
                                      @endforeach
                                      <input type="hidden" id="count_reg_{{$bancos->id}}" value="{{$banco_registro->where('banco_id', $bancos->id)->count()}}">
                                      
                                  {{-- @endif --}}
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
                                    <div class="col-sm-6">
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
                {{-- FIN  MODAL BANCOS --}}
              @endforeach
              <input type="hidden" id="count_check_detr" value="{{$banco_registro->where('estado_detraccion', 1)->count()}}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style type="text/css" media="screen">
    .col-lg-2{
      padding-right: 10px !important;
      padding-left: 10px !important;
    }
    .col-lg-3{
      padding-right: 10px !important;
      padding-left: 10px !important;
    }
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
    }
    .modal-dialog{
      max-width: 900px;
    }
  </style>

  @foreach($banco as $bancos)
    <style>
      input#archivoInput{{$bancos->id}}{
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
    <script type="text/javascript">
      // {{-- Fotooos --}}
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
  <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
  <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
  <!-- Custom and plugin javascript -->
  <script src="{{ asset('js/inspinia.js') }}"></script>
  <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

  @foreach($moneda as $monedas)
    <script>
      $('#demo_principal{{$monedas->id}}').click(function(){
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
              var data = `  <input type="hidden" hidden name="id_moneda" randoly value="{{$monedas->id}}" >`;
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
  

  <script type="text/javascript">
  
    $( document ).ready(function() {
      var count_d = $('#count_check_detr').val();
      if(count_d > 0){
        all_ch = document.querySelectorAll('.change_status');
        all_ch.forEach(function(checkbox) {
          if (!checkbox.checked) { // Verificar si el checkbox no está marcado
            checkbox.disabled = true; // Agregar el atributo disabled
          }
        });
      }
      
    });
    // {{-- Fotooos --}}
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

    function eliminar_edit(y){
      $(`.delete_modal_edit_${y}`).css('display', 'none');
      $(`#eliminar_${y}`).val(y);
    };

    
  </script>

  @foreach($banco as $bancos)
    <script>
      
      $("#btn_add_{{$bancos->id}}").on('click', function () {
        var x = $(`#count_reg_`+{{$bancos->id}}).val();
        var suma{{$bancos->id}} = document.getElementsByClassName('descripcion2').length;
        var otra_suma{{$bancos->id}} = document.getElementsByClassName('descripcion2_creadas{{$bancos->id}}').length;
        var inp_mont{{$bancos->id}} = suma{{$bancos->id}} + otra_suma{{$bancos->id}} ;
        console.log(x);
        var data = `
          <div class="delete_modal${x} row" style="padding-top: 5px;padding-bottom: 5px;align-items: center !important;">
            <div class="col-lg-3">
              <select name="descripcion1[]" class="form-control" id="">
                <option value="Cta C.">Cuenta Corriente</option>
                <option value="Cta Ah.">Cuenta Ahorro</option>
                <option value="Cta Det.">Cuenta Detracciones</option>
                <option value="CCI">Cod. C. Interbancario</option>
              </select>
            </div>
            <div class="col-lg-3">
              <select name="moneda[]" id="" class="form-control">
                @foreach ($moneda as $monedas)
                  <option value="{{$monedas->id}}">{{$monedas->nombre}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-3">
              <input type="text" name="descripcion2[]" class="form-control descripcion2"  autocomplete="off">
            </div>
            <div class="col-lg-2" align="right">
              <input type="checkbox" class="form-control change_status" name="estado_detraccion[]" id="" value="off" >
              <input type="hidden" class="ipt_hidden" id="input_check_${x}" name="detrac[]" value="off" >
            </div>
            <div class="col-lg-1" align="right">
              <button type="button" class="btn btn-secondary" onclick="eliminar(${x})"><i class="fa fa-trash-o"></i></button>
            </div>
          </div>`;
        if(x <= 3){
          $('#conteiner_add_{{$bancos->id}}').append(data);
        }
        x++;
        var x = $(`#count_reg_`+{{$bancos->id}}).val(x);

        f_checked();
        
      });
      function eliminar(x){
        $(`.delete_modal${x}`).remove();
      };
    </script>
  @endforeach
  <script>
    $(".change_status").on("change", function(){
      // console.log($(this).is(':checked'));
      let optionSelected = $(this).val();
      if ($(this).is(':checked') == true) {
        $(this).parent().children("input.ipt_hidden").val('on');
        var all_ch = document.querySelectorAll('.change_status');
        all_ch.forEach(function(checkbox) {
          if (!checkbox.checked) { // Verificar si el checkbox no está marcado
            checkbox.disabled = true; // Agregar el atributo disabled

          }
        });
      }else{
        var all_ch = document.querySelectorAll('.change_status');
        all_ch.forEach(function(checkbox) {
          // if (checkbox.checked) { // Verificar si el checkbox no está marcado
            checkbox.disabled = false; // Agregar el atributo disabled
          // }
        });
        $(this).parent().children("input.ipt_hidden").val('off');
      }

    });
    function f_checked(){
      var count_d = $('#count_check_detr').val();
      if(count_d > 0){
        all_ch = document.querySelectorAll('.change_status');
        all_ch.forEach(function(checkbox) {
          if (!checkbox.checked) { // Verificar si el checkbox no está marcado
            checkbox.disabled = true; // Agregar el atributo disabled
          }
        });
      }
    }
  </script>
@endsection