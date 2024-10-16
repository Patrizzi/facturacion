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
                                          <option value="Cta A.">Cuenta Ahorro</option>
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
                                              <option value="Cta A." @if($banco_registros->tipo_cuenta == 'Cta A.') selected @endif>Cuenta Ahorro</option>
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



{{-- INICIO FLAVIA --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        font-family: 'Montserrat', sans-serif;
    }
</style>
<body>

  <div class="container mt-4">
      <div class="row">
          <div class="col-12">
              <div class="card text-center" style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);">
                  <div class="d-flex flex-column flex-md-row align-items-center" style="padding: 20px; border-radius: 5px;">
                      <!-- Contenido de la tarjeta -->
                      <div class="mb-3 mb-md-0" style="flex: 0 0 auto; margin-right: 0px;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCrz_XKzKwCeiR3Te3FDc-zTIDtxgLMVE5CA&s" alt="Imagen de la empresa" style="max-width: 100%; height: auto; width: 100px;"></div>
                      <div class="text-center" style="flex: 1;">
                          <h5>J&P Perifericos S.A.C</h5>
                          <p>RUC: 20545122520</p>
                          <p>Empresa de mantenimiento informático, venta de computadoras, hardware, software ERP, elaboración de páginas web, redes y comunicaciones, utilizando la tecnología actual para servirlos mejor.</p>
                      </div>
                      <div style="flex: 0 0 auto;">
                      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#infoModal">Editar</button>
                  </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="infoModalLabel" style="color: blue;">Información de la Empresa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <!-- Formulario dentro del modal -->
              <form>
                  <div class="row">
                      <!-- Imagen -->
                      <div class="col-md-12 mb-3 text-center">
                          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCrz_XKzKwCeiR3Te3FDc-zTIDtxgLMVE5CA&s" alt="Imagen de la Empresa" style="width: 300px; height: 150px; object-fit: cover;">
                      </div>
                      <!-- Descripción -->
                      <div class="col-md-12 mb-3">
                          <label for="descripcion" class="form-label">Descripción:</label>
                          <textarea class="form-control" id="descripcion" rows="3">Empresa de mantenimiento informático, venta de computadoras, hardware, software Erp, elaboración de páginas web, redes y más.</textarea>
                      </div>

                      <!-- Movil y Teléfono -->
                      <div class="col-md-6 mb-3">
                          <label for="movil" class="form-label">Movil:</label>
                          <input type="text" class="form-control" id="movil" value="+51946201443">
                      </div>
                      <div class="col-md-6 mb-3">
                          <label for="telefono" class="form-label">Teléfono:</label>
                          <input type="text" class="form-control" id="telefono" value="013308292">
                      </div>

                      <!-- Correo y País -->
                      <div class="col-md-6 mb-3">
                          <label for="correo" class="form-label">Correo:</label>
                          <input type="email" class="form-control" id="correo" value="julioflores@jypsac.com">
                      </div>
                      <div class="col-md-6 mb-3">
                          <label for="pais" class="form-label">País:</label>
                          <input type="text" class="form-control" id="pais" value="Peru">
                      </div>

                      <!-- Calle y Rubro -->
                      <div class="col-md-6 mb-3">
                          <label for="calle" class="form-label">Calle:</label>
                          <textarea class="form-control" id="calle" rows="2">Av. Bolivia 148 Of. 2218 Pta 4 - Galería</textarea>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label for="rubro" class="form-label">Rubro:</label>
                          <input type="text" class="form-control" id="rubro" value="Hardware y Software">
                      </div>

                      <!-- Región y Ciudad -->
                      <div class="col-md-6 mb-3">
                          <label for="region" class="form-label">Región/Provincia:</label>
                          <input type="text" class="form-control" id="region" value="Lima">
                      </div>
                      <div class="col-md-6 mb-3">
                          <label for="ciudad" class="form-label">Ciudad:</label>
                          <input type="text" class="form-control" id="ciudad" value="Lima">
                      </div>

                      <!-- Código Ubigeo y Página Web -->
                      <div class="col-md-6 mb-3">
                          <label for="codigo" class="form-label">Código Ubigeo:</label>
                          <input type="text" class="form-control" id="codigo" value="150101">
                      </div>
                      <div class="col-md-6 mb-3">
                          <label for="paginaWeb" class="form-label">Página Web:</label>
                          <input type="text" class="form-control" id="paginaWeb" value="www.jypsac.com">
                      </div>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary">Guardar</button>
          </div>
      </div>
  </div>
</div>

  <div class="container mt-4">
      <div class="row row-cols-1 row-cols-md-2 g-4">
  <div class="col mb-4"> <!-- Tarjeta de "Mi empresa" -->
      <div class="card text-center" style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); height: 255px">
          <div style="display: flex; justify-content: center;">
              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCrz_XKzKwCeiR3Te3FDc-zTIDtxgLMVE5CA&s" class="card-img-top" alt="..." style="width: 355px; height: auto;">
          </div>
          <div class="card-body">
          <h5 class="card-title" style="color: blue; font-weight: bold; font-size: 2rem;">MI EMPRESA</h5>
      </div>
      </div>
  </div>

  <div class="col mb-4"> <!-- Tarjeta de "Número de contactos" -->
      <div class="card text-center" style="background-color: blue; color: white; box-shadow: 0 4px 15px rgba(0, 0, 255, 0.5);">
          <div class="card-body" style="min-height: 250px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
              <h5 class="card-title" style="text-align: center; width: 100%;font-weight: bold; font-size: 1rem">NÚMERO DE CONTACTOS</h5>
              <p class="card-text" style="margin: 5px 0; text-align: center;"><i class="bi bi-telephone"></i> Teléfono: 013308292</p>
              <p class="card-text" style="margin: 5px 0; text-align: center;"><i class="bi bi-phone"></i> Celular: +51946201443</p>
              <p class="card-text" style="margin: 5px 0; text-align: center;"><i class="bi bi-globe"></i> Sitio Web: www.jypsac.com/<a href="..." style="color: white; text-decoration: underline;"></a></p>
              <p class="card-text" style="margin: 5px 0; text-align: center;">
              <i class="bi bi-envelope"></i> Correo:
              <a href="mailto:julioflores@jypsac.com" style="color: white; text-decoration: none;">
                  julioflores@jypsac.com
              </a>
          </p>            </div>
      </div>
  </div>
</div>

<!-- Segunda fila de tarjetas -->
<div class="row row-cols-1 row-cols-md-2 g-4">
<div class="col mb-4"> <!-- Agregado mb-4 -->
  <div class="card text-center" style="background-color: blue; color: white; box-shadow: 0 4px 15px rgba(0, 0, 255, 0.5);">
      <div class="card-body d-flex flex-column justify-content-center" style="min-height: 260px; align-items: center;">
          <h5 class="card-title" style="text-align: center;font-weight: bold; font-size: 1rem"> DATOS DE UBICACIÓN</h5>
          <p class="card-text" style="margin: 5px 0; text-align: center;"><i class="bi bi-flag"></i> País: Perú</p>
          <p class="card-text" style="margin: 5px 0; text-align: center;"><i class="bi bi-geo"></i> Provincia: Lima</p>
          <p class="card-text" style="margin: 5px 0; text-align: center;"><i class="bi bi-geo"></i> Ciudad: Lima</p>
          <p class="card-text" style="margin: 5px 0; text-align: center;"><i class="bi bi-geo-alt"></i> Dirección: Av. Bolivia 148 Of. 2218 Pta 4 - Galería Centro de Lima</p>
          <p class="card-text" style="margin: 5px 0 20px 0; text-align: center;"><i class="bi bi-file-earmark-binary"></i> Código Ubigeo: 150101</p>
          <!-- Mapa incrustado -->
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.5608069684718!2d-77.04077347304688!3d-12.07371039999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c8ed9bc09107%3A0x65cd03781324adb2!2sJ%26P%20Perif%C3%A9ricos%20SAC%20-%20en%20LIMA%7C%20Venta%2C%20Computadoras%2C%20Laptop%20%7C%20Reparaci%C3%B3n%20y%20Mantenimiento%20de%20port%C3%A1tiles!5e0!3m2!1ses-419!2spe!4v1727195701956!5m2!1ses-419!2spe"
          width="100%" height="280" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
  </div>
</div>

<div class="container mt-4">
<div class="row">
  <div class="col mb-4"> <!-- Columna para la tarjeta -->
      <div class="card text-center" style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); height: 200px;box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);">
          <div class="card-body d-flex flex-column justify-content-center align-items-center">
              <h5 class="card-title mb-3" style="text-align: center; font-weight: bold; font-size: 1rem; color: blue;">MONEDA PRINCIPAL</h5>
              <div class="d-flex flex-column align-items-start mb-3">
                  <!-- Sección de Círculo y Texto -->
                      <div class="d-flex align-items-center mb-3">
                      <button type="button" class="rounded-circle bg-warning text-dark d-flex justify-content-center align-items-center"
                          style="width: 50px; height: 50px; margin-right: 30px; background-color: gold; border: none;"
                          data-bs-toggle="modal" data-bs-target="#monedaModal">
                          <span style="color: white; font-size: 24px;">S/</span>
                          </button>
<p class="card-text mb-0" style="color: gold; font-weight: bold;">Soles / Moneda Nacional</p>
</div>
<!-- Modal pequeño de soles -->
<div class="modal fade" id="monedaModal" tabindex="-1" aria-labelledby="monedaModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title text-center" id="monedaModalLabel" style="color: gold; width: 100%; text-align: center;">S/ SOLES</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          Moneda "soles" actualmente registrada como Moneda Principal.
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
      </div>
  </div>
</div>
</div>
<!-- Sección de Círculo y Texto para Dólares -->
<div class="d-flex align-items-center mb-3">
<button type="button" class="rounded-circle bg-success d-flex justify-content-center align-items-center"
      style="width: 50px; height: 50px; margin-right: 30px; background-color: darkgreen; border: none;"
      data-bs-toggle="modal" data-bs-target="#dolaresModal">
  <span style="color: white; font-size: 24px;">$</span>
</button>

<p class="card-text mb-0" style="color: darkgreen; font-weight: bold;">Dólares / Moneda Extranjera</p>
</div>

<!-- Modal pequeño para Dólares -->
<div class="modal fade" id="dolaresModal" tabindex="-1" aria-labelledby="dolaresModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-sm">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title text-center d-flex justify-content-center align-items-center" id="dolaresModalLabel" style="color: darkgreen; width: 100%; text-align: center;">
          <i class="bi bi-exclamation-circle-fill" style="color: red; font-size: 2rem; margin-right: 5px;"></i>
      </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          ¿Deseas cambiar '$ Dólares' como moneda principal?
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="cambiarButton">Sí, Cambiar</button>
      </div>
  </div>
</div>
</div>
</div>
</div>

<!-- Tercera fila de tarjetas -->
<div class="row row-cols-1 row-cols-md-2 g-4">
<div class="col mb-4"> <!-- Tarjeta Datos de Ubicación -->
  <div class="card text-center"  style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); height: 330px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);">
      <div class="card-body d-flex flex-column align-items-center justify-content-center">
          <h5 class="card-title" style="text-align: center; font-weight: bold; font-size: 0.80rem; color: blue;">Cuenta Ahorro</h5>
          <img src="IMG/bcp.png" class="card-img-top" alt="BCP" style="width: 80px; height: auto; margin-bottom: 0px;" data-bs-toggle="modal" data-bs-target="#cuentaModal">

          <h5 class="card-title" style="text-align: center; font-weight: bold; font-size: 0.80rem; color: blue;">Cuenta Corriente</h5>
          <img src="IMG/scotiabank.png" class="card-img-top" alt="Scotiabank" style="width: 100px; height: auto; margin-bottom: 0px;" data-bs-toggle="modal" data-bs-target="#scotiabankModal">

          <h5 class="card-title" style="text-align: center; font-weight: bold; font-size: 0.80rem; color: blue;">Cuenta Corriente</h5>
          <img src="IMG/interbank.jpeg" class="card-img-top" alt="Interbank" style="width: 100px; height: auto; margin-bottom: 0px;" data-bs-toggle="modal" data-bs-target="#interbankModal">


          <h5 class="card-title" style="text-align: center; font-weight: bold; font-size: 0.80rem; color: blue;">Cuenta Corriente</h5>
          <img src="IMG/bbva.png" class="card-img-top" alt="BBVA" style="width: 80px; height: auto;" data-bs-toggle="modal" data-bs-target="#bbvaModal">
      </div>

<!-- Modal para la imagen de BCP -->
<div class="modal fade" id="cuentaModal" tabindex="-1" aria-labelledby="cuentaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="cuentaModalLabel">Cuenta Bancaria</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <!-- Formulario de cuenta bancaria -->
              <form>
    <div class="row mb-3">
      <div class="col-md-6">
          <label for="nombreCuenta" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombreCuenta" value="Cuenta Ahorros">

          <label for="titularCuenta" class="form-label">Titular</label>
          <input type="text" class="form-control" id="titularCuenta" value="19130895186056">
          </div>
<!-- Imagen de la cuenta -->
<div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
  <label for="imagenCuenta" class="form-label"></label>
  <img src="IMG/bcp.png" alt="BCP" class="img-fluid" style="max-width: 150px;">
</div>
</div>
                  <div class="row mb-3">
                      <!-- Tipo de cuenta y Moneda -->
                      <div class="col-md-6">
                          <label for="tipoCuenta" class="form-label">Tipo de Cuenta</label>
                          <select class="form-select" id="tipoCuenta">
                              <option selected>Cuenta Corriente</option>
                              <option>Cuenta de Ahorros</option>
                              <option selected>Cuenta Detracciones</option>
                              <option>Cod. C. Interbancacio </option>

                          </select>
                      </div>
                      <div class="col-md-6">
                          <label for="monedaCuenta" class="form-label">Moneda</label>
                          <select class="form-select" id="monedaCuenta">
                              <option selected>soles</option>
                              <option>dólares</option>
                          </select>
                      </div>
                  </div>

                  <div class="row mb-3">
                      <!-- N° de cuenta y Código Interbancario -->
                      <div class="col-md-6">
                          <label for="numeroCuenta" class="form-label">N° de Cuenta</label>
                          <select class="form-select" id="numeroCuenta">
                              <option value="19130895186056" selected>19130895186056</option>
                              <option value="00219113089518605654">00219113089518605654</option>
                          </select>
                      </div>
                      <div class="col-md-6">
                          <label for="codigoInterbancario" class="form-label">Cod. C. Interbancario</label>
                          <input type="text" class="form-control" id="codigoInterbancario" value="00219113089518605654">
                      </div>
                  </div>

                  <div class="row mb-3 align-items-center">
                    <!-- Detracción -->
                    <div class='col-md-4'>
                        <label class='form-label'>¿Detracción?</label>
                        <input class='form-check-input ms-2' type='checkbox' id='detraccionCheck'>
                    </div>
                    <div class='col-md-4 d-flex justify-content-center align-items-center'>
                        <button type='button' class='btn btn-danger me-2'><i class='bi bi-trash'></i></button>
                        <button type='button' class='btn btn-primary'><i class='bi bi-plus'></i></button>
                    </div>
                    <div class='col-md-4'>
                        <label class='form-label' for='activoCheck'>Activo/Desactivo:</label>
                        <input class='form-check-input ms-2' type='checkbox' id='activoCheck' checked>
                    </div>
                </div>
              </form>
          </div>
          <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
              <button type='button' class='btn btn-primary'>Guardar</button>
          </div>
      </div>
  </div>
</div>
<!-- Modal para la imagen de Scotiabank -->
<div class="modal fade" id="scotiabankModal" tabindex="-1" aria-labelledby="scotiabankModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="scotiabankModalLabel">Cuenta Corriente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <!-- Formulario de cuenta bancaria -->
              <form>
                  <div class="row mb-3">
                      <!-- Nombre -->
                      <div class="col-md-6">
                          <label for="nombreCuenta" class="form-label">Nombre</label>
                          <input type="text" class="form-control" id="nombreCuenta" value="Cuenta Corriente">
                          <!-- Titular colocado directamente aquí -->
                          <label for="titularCuenta" class="form-label">Titular</label>
                          <input type="text" class="form-control" id="titularCuenta" value="0873003385919">
                      </div>

                      <!-- Imagen de la cuenta -->
                      <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                          <label for="imagenCuenta" class="form-label"></label>
                          <img src="IMG/scotiabank.png" alt="BCP" class="img-fluid" style="max-width: 150px;">
                      </div>
                  </div>

                  <div class="row mb-3">
                      <!-- Tipo de cuenta y Moneda -->
                      <div class="col-md-6">
                          <label for="tipoCuenta" class="form-label">Tipo de Cuenta</label>
                          <select class="form-select" id="tipoCuenta">
                              <option selected>Cuenta Corriente</option>
                              <option>Cod. C. Interbancario</option>
                              <option selected>Cuenta Corriente</option>
                              <option>Cod. C. Interbancario</option>
                          </select>
                      </div>
                      <div class="col-md-6">
                          <label for="monedaCuenta" class="form-label">Moneda</label>
                          <select class="form-select" id="monedaCuenta">
                              <option selected>soles</option>
                              <option>soles</option>
                              <option>dólares</option>
                              <option>dólares</option>
                          </select>
                      </div>
                  </div>

                  <div class="row mb-3">
                      <!-- N° de cuenta y Código Interbancario -->
                      <div class="col-md-6">
                          <label for="numeroCuenta" class="form-label">N° de Cuenta</label>
                          <select class="form-select" id="numeroCuenta">
                              <option value="0873003385919" selected>0873003385919</option>
                              <option value="00308700300338591">00308700300338591</option>
                              <option value="2003002187954">2003002187954</option>
                          </select>
                      </div>
                      <div class="col-md-6">
                          <label for="codigoInterbancario" class="form-label">Cod. C. Interbancario</label>
                          <input type="text" class="form-control" id="codigoInterbancario" value="00320000300218795">
                      </div>
                  </div>

                  <div class="row mb-3 align-items-center">
                    <!-- Detracción -->
                    <div class='col-md-4'>
                        <label class='form-label'>¿Detracción?</label>
                        <input class='form-check-input ms-2' type='checkbox' id='detraccionCheck'>
                    </div>
                    <div class='col-md-4 d-flex justify-content-center align-items-center'>
                        <button type='button' class='btn btn-danger me-2'><i class='bi bi-trash'></i></button>
                        <button type='button' class='btn btn-primary'><i class='bi bi-plus'></i></button>
                    </div>
                    <div class='col-md-4'>
                        <label class='form-label' for='activoCheck'>Activo/Desactivo:</label>
                        <input class='form-check-input ms-2' type='checkbox' id='activoCheck' checked>
                    </div>
                </div>
              </form>
          </div>
          <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
              <button type='button' class='btn btn-primary'>Guardar</button>
          </div>
      </div>
  </div>
</div>
<!-- Modal para la imagen de Interbank 3 -->
<div class="modal fade" id="interbankModal" tabindex="-1" aria-labelledby="interbankModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="interbankModalLabel">Cuenta Corriente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <!-- Formulario de cuenta bancaria -->
              <form>
                  <div class="row mb-3">
                      <!-- Nombre -->
                      <div class="col-md-6">
                          <label for="nombreCuentaInterbank" class="form-label">Nombre</label>
                          <input type="text" class="form-control" id="nombreCuentaInterbank" value="Cuenta Corriente">
                          <!-- Titular colocado directamente aquí -->
                          <label for="titularCuentaInterbank" class="form-label">Titular</label>
                          <input type="text" class="form-control" id="titularCuentaInterbank" value="001101750100068128 76">
                      </div>

                      <!-- Imagen de la cuenta -->
                      <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                          <label for="imagenCuentaInterbank" class="form-label"></label>
                          <img src="IMG/interbank.jpeg" alt="Interbank" class="img-fluid" style="max-width: 150px;">
                      </div>
                  </div>

                  <div class="row mb-3">
                      <!-- Tipo de cuenta y Moneda -->
                      <div class="col-md-6">
                          <label for="tipoCuentaInterbank" class="form-label">Tipo de Cuenta</label>
                          <select class="form-select" id="tipoCuentaInterbank">
                              <option selected>Cuenta Corriente</option>
                              <option>Cod. C. Interbancario</option>
                              <option>Cuenta Corriente</option>
                              <option>Cod. C. Interbancario</option>
                          </select>
                      </div>
                      <div class="col-md-6">
                          <label for="monedaCuentaInterbank" class="form-label">Moneda</label>
                          <select class="form-select" id="monedaCuentaInterbank">
                              <option selected>soles</option>
                              <option selected>soles</option>
                              <option selected>soles</option>
                              <option selected>soles</option>
                          </select>
                      </div>
                  </div>

                  <div class="row mb-3">
                    <!-- N° de cuenta y Código Interbancario -->
                    <div class="col-md-6">
                      <label for="numeroCuentaInterbank" class="form-label">N° de Cuenta</label>
                      <select class="form-select" id="numeroCuentaBBVA">
                          <option value="00110175010006812876" selected>00110175010006812876</option>
                          <option value="01117500010006812876">01117500010006812876</option>
                          <option value="001101470200665686">001101470200665686</option>
                      </select>
                  </div>
                    <div class="col-md-6">
                        <label for="codigoInterbancarioInterbank" class="form-label">Cod. C. Interbancario</label>
                        <input type="text" class="form-control" id="codigoInterbancarioInterbank" value="01114700020066568668">
                    </div>
                </div>

                  <div class="row mb-3 align-items-center">
                    <!-- Detracción -->
                    <div class='col-md-4'>
                        <label class='form-label'>¿Detracción?</label>
                        <input class='form-check-input ms-2' type='checkbox' id='detraccionCheck'>
                    </div>
                    <div class='col-md-4 d-flex justify-content-center align-items-center'>
                        <button type='button' class='btn btn-danger me-2'><i class='bi bi-trash'></i></button>
                        <button type='button' class='btn btn-primary'><i class='bi bi-plus'></i></button>
                    </div>
                    <div class='col-md-4'>
                        <label class='form-label' for='activoCheck'>Activo/Desactivo:</label>
                        <input class='form-check-input ms-2' type='checkbox' id='activoCheck' checked>
                    </div>
                </div>
              </form>
          </div>
          <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
              <button type='button' class='btn btn-primary'>Guardar</button>
          </div>
      </div>
  </div>
</div>

<!-- Modal para la imagen de BBVA -->
<div class="modal fade" id="bbvaModal" tabindex="-1" aria-labelledby="bbvaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="bbvaModalLabel">Cuenta Corriente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <!-- Formulario de cuenta bancaria -->
              <form>
                  <div class="row mb-3">
                      <!-- Nombre -->
                      <div class="col-md-6">
                          <label for="nombreCuentaBBVA" class="form-label">Nombre</label>
                          <input type="text" class="form-control" id="nombreCuentaBBVA" value="Cuenta Ahorros">
                          <!-- Titular colocado directamente aquí -->
                          <label for="titularCuentaBBVA" class="form-label">Titular</label>
                          <input type="text" class="form-control" id="titularCuentaBBVA" value="19130895186056">
                      </div>

                      <!-- Imagen de la cuenta -->
                      <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                          <label for="imagenCuentaBBVA" class="form-label"></label>
                          <img src="IMG/bbva.png" alt="BBVA" class="img-fluid" style="max-width: 150px;">
                      </div>
                  </div>

                  <div class="row mb-3">
                      <!-- Tipo de cuenta y Moneda -->
                      <div class="col-md-6">
                          <label for="tipoCuentaBBVA" class="form-label">Tipo de Cuenta</label>
                          <select class="form-select" id="tipoCuentaBBVA">
                              <option selected>Cuenta Corriente</option>
                          </select>
                      </div>
                      <div class="col-md-6">
                          <label for="monedaCuentaBBVA" class="form-label">Moneda</label>
                          <select class="form-select" id="monedaCuentaBBVA">
                              <option selected>soles</option>
                          </select>
                      </div>
                  </div>

                  <div class="row mb-3">
                      <!-- N° de cuenta y Código Interbancario -->
                      <div class="col-md-6">
                          <label for="numeroCuentaBBVA" class="form-label">N° de Cuenta</label>
                          <select class="form-select" id="numeroCuentaBBVA">
                              <option value="" selected>00-060-035172</option>
                          </select>
                      </div>
                      <div class="col-md-6">
                          <label for="codigoInterbancarioBBVA" class="form-label">Cod. C. Interbancario</label>
                          <input type="text" class="form-control" id="codigoInterbancarioBBVA" value="00219113089518605654">
                      </div>
                  </div>

                  <div class="row mb-3 align-items-center">
                    <!-- Detracción -->
                    <div class='col-md-4'>
                        <label class='form-label'>¿Detracción?</label>
                        <input class='form-check-input ms-2' type='checkbox' id='detraccionCheck'>
                    </div>
                    <div class='col-md-4 d-flex justify-content-center align-items-center'>
                        <button type='button' class='btn btn-danger me-2'><i class='bi bi-trash'></i></button>
                        <button type='button' class='btn btn-primary'><i class='bi bi-plus'></i></button>
                    </div>
                    <div class='col-md-4'>
                        <label class='form-label' for='activoCheck'>Activo/Desactivo:</label>
                        <input class='form-check-input ms-2' type='checkbox' id='activoCheck' checked>
                    </div>
                </div>
              </form>
          </div>
          <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
              <button type='button' class='btn btn-primary'>Guardar</button>
          </div>
      </div>
  </div>
</div>
</div>
</div>
<div class='col mb-4'>
  <div class='card text-center' style="background-color: blue; color: white; box-shadow: 0 4px 15px rgba(0, 0, 255, 0.5); height: 330px">
      <div class='card-body d-flex flex-column justify-content-center align-items-center'>
          <h5 class='card-title'style="text-align: center;font-weight: bold; font-size: 1rem">IMPUESTOS</h5>
          <p class='card-text'>IGV: 18 %</p>
          <p class='card-text'>Impuesto Renta: 18 %</p>
      </div>
  </div>
</div>
</div>
</div>
</div>
</div>

<!-- Incluye las librerías de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
{{-- FIN FLAVIA --}}












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
                <option value="Cta A.">Cuenta Ahorro</option>
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
