@extends('layout')
@section('title', 'Mi Empresa')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Editar')
@section('atributo_actu', 'hidden')
{{-- @section('config', route('Configuracion')) --}}

@section('content')

    {{-- <!-- Modal Create  -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="margin-left: 25%">
            <div class="modal-content" style="width: 702.22222px;">
                <div style="padding-left: 15px;padding-right: 15px;">
                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px" align="center">
                        <form action="{{ route('empresa.update', $mi_empresa->id) }}" enctype="multipart/form-data"
                            method="post">
                            @csrf
                            @method('PATCH')
                            <fieldset>
                                <div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="file" id="archivoInputs" name="fotos"
                                                    onchange="return validarExtImg()" align="right"
                                                    style="cursor: pointer;text-align: center;" />
                                                <div id="visorArchivos">
                                                    <!--Aqui se desplegará el fichero-->
                                                    <center>
                                                        <img src="{{ asset('img/logos/' . $mi_empresa->foto) }}"
                                                            style="width: 350px;;margin-bottom: 15px;">
                                                    </center>
                                                </div>
                                                <input type="text" value="{{ $mi_empresa->foto }}"
                                                    style="width: 350px;margin-bottom: 15px;" class="form-control"
                                                    name="ori_foto" hidden="hidden" autocomplete="off">
                                            </div>
                                            <label class="col-sm-2 col-form-label">Descripción:</label>
                                            <div class="col-sm-10" style="padding-bottom: 10px">
                                                <textarea name="descripcion" required class="form-control">{{ $mi_empresa->descripcion }}</textarea>
                                            </div>
                                            <label class="col-sm-2 col-form-label">Movil:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" required name="movil"
                                                    value="{{ $mi_empresa->movil }}" autocomplete="off">
                                            </div>
                                            <label class="col-sm-2 col-form-label">Teléfono:</label>
                                            <div class="col-sm-4" style="padding-bottom: 15px; ">
                                                <input type="text" class="form-control" required name="telefono"
                                                    value="{{ $mi_empresa->telefono }}" autocomplete="off">
                                            </div>

                                            <label class="col-sm-2 col-form-label">Correo:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" required name="correo"
                                                    value="{{ $mi_empresa->correo }}" autocomplete="off">
                                            </div>
                                            <label class="col-sm-2 col-form-label">Region Provincia:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" required name="region_provincia"
                                                    value="{{ $mi_empresa->region_provincia }}" autocomplete="off">
                                            </div>
                                            <label class="col-sm-2 col-form-label">País:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" required name="pais"
                                                    value="{{ $mi_empresa->pais }}" autocomplete="off">
                                            </div>
                                            <label class="col-sm-2 col-form-label">Ciudad:</label>
                                            <div class="col-sm-4" style="padding-bottom: 15px">
                                                <input type="text" class="form-control" required name="ciudad"
                                                    value="{{ $mi_empresa->ciudad }}" autocomplete="off">
                                            </div>
                                            <label class="col-sm-2 col-form-label">Calle:</label>
                                            <div class="col-sm-4" style="padding-bottom: 15px">
                                                <textarea name="calle" class="form-control" required>{{ $mi_empresa->calle }}</textarea>
                                            </div>
                                            <label class="col-sm-2 col-form-label">Código Ubigeo:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" required name="codigo_postal"
                                                    value="{{ $mi_empresa->codigo_postal }}" autocomplete="off">
                                            </div>
                                            <label class="col-sm-2 col-form-label">Rubro:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" required name="rubro"
                                                    value="{{ $mi_empresa->rubro }}" autocomplete="off">
                                            </div>
                                            <label class="col-sm-2 col-form-label">Pagina Web:</label>
                                            <div class="col-sm-4" style="    padding-bottom: 10px;">
                                                <input type="text" class="form-control" required name="pagina_web"
                                                    value="{{ $mi_empresa->pagina_web }}" autocomplete="off">
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
                        <img src="{{ asset('img/logos/' . $mi_empresa->foto) }}" alt="profile" width="300px">
                    </div>
                    <div class="col-md-8">
                        <div class="profile-info">
                            <div class="">
                                <div>
                                    <h2 class="no-margins">{{ $mi_empresa->nombre }}</h2>
                                    <h4>{{ $mi_empresa->ruc }}</h4>
                                    <p>{{ $mi_empresa->descripcion }}</p>
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
                                <p class="font-bold"> <span><i class="fa fa-circle text-navy"></i> <b>Teléfono :</b>
                                        {{ $mi_empresa->telefono }}</span></p>
                                <p class="font-bold"> <span><i class="fa fa-circle text-navy"></i> <b>Celular :</b>
                                        {{ $mi_empresa->movil }}</span> </p>
                                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Pagina Web :</b>
                                        {{ $mi_empresa->pagina_web }}</span></p>
                                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Correo :</b>
                                        {{ $mi_empresa->correo }}</span></p>
                            </div>
                        </div>
                        <div class="ibox">
                            <div class="ibox-content">
                                <h3>Datos de Ubicación:</h3>
                                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> País :</b>
                                        {{ $mi_empresa->pais }}</span></p>
                                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Region Provincia
                                            :</b> {{ $mi_empresa->region_provincia }}</span></p>
                                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Ciudad :</b>
                                        {{ $mi_empresa->ciudad }}</span></p>
                                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Dirección :</b>
                                        {{ $mi_empresa->calle }}</span></p>
                                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Código Ubigeo :</b>
                                        {{ $mi_empresa->codigo_postal }}</span></p>
                            </div>
                        </div>
                    </div>
                    <!-- MONEDAS -->
                    <div class="col-lg-5">
                        <div class="ibox-content">
                            <span style="font-size: 15px;"><b>Moneda Principal</b> <i style="color:#0f0ff7ad;"
                                    class="fa fa-check-circle "></i></span>
                            <div class="row">
                                @foreach ($moneda as $monedas)
                                    <div class="col-lg-6"
                                        @if ($monedas->principal == 0) id="demo{{ $monedas->id }}" @else id="demo_principal{{ $monedas->id }}" @endif>
                                        <div class="widget p-lg text-center " style="">
                                            <div class="m-b-md">
                                                <i class="fa fa-4x">{{ $monedas->simbolo }}</i>
                                                <h1 class="m-xs">{{ $monedas->codigo }}</h1>
                                                <h3 class="font-bold no-margins"> {{ $monedas->nombre }}
                                                    @if ($monedas->principal == 1)
                                                        <i class="fa fa-check-circle"></i>
                                                    @endif
                                                </h3>
                                                <small>Moneda {{ $monedas->tipo }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="ibox" style="padding-top:15px">
                            <div class="ibox-content">
                                <h3>Impuesto:</h3>
                                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> IGV :</b> 18%</span>
                                </p>
                                <p class="font-bold"><span><i class="fa fa-circle text-navy"></i> <b> Impuesto Renta :</b>
                                        18%</span></p>
                            </div>
                        </div>
                    </div>
                    <!-- FIN MONEDAS -->
                    <div class="col-lg-4 m-b-lg">
                        <div id="vertical-timeline" class="vertical-container light-timeline no-margins">
                            @foreach ($banco as $bancos)
                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon blue-bg">
                                        <i class="fa fa-bank"></i>
                                    </div>
                                    <div class="vertical-timeline-content" align="center">
                                        @if ($bancos->estado == 0)
                                            <!-- TIPO DE CUENTA = NOMBRE DE BANCO  -->
                                            <strong><span>{{ $bancos->nombre_banco }}</span></strong>
                                            <br>
                                            <i class="fa fa-circle" style="color: #5fa8f3;"></i>
                                        @else
                                            <i class="fa fa-circle"></i>
                                        @endif
                                        <img data-toggle="modal" data-target="#exampleModal{{ $bancos->id }}"
                                            src="{{ asset('img/logos/' . $bancos->foto) }}"
                                            style="width: 150px;cursor: pointer;"><br>
                                    </div>
                                </div>
                                <!-- MODAL BANCOS  -->
                                <div class="modal fade" id="exampleModal{{ $bancos->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div style="padding-left: 15px;padding-right: 15px;">
                                                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;"
                                                    align="center">
                                                    <form action="{{ route('banco.update', $bancos->id) }}"
                                                        enctype="multipart/form-data" method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <fieldset>
                                                            <div>
                                                                <div class="panel-body">
                                                                    <div class="row"
                                                                        style="align-items: center !important">
                                                                        <!-- Foto -->
                                                                        <div class="col-sm-6">
                                                                            <strong>Nombre</strong>
                                                                            <input type="text" class="form-control"
                                                                                name="nombre_banco" id=""
                                                                                value="{{ $bancos->nombre_banco }}"
                                                                                autocomplete="off">
                                                                            <strong>Titular</strong>
                                                                            <input type="text" class="form-control"
                                                                                name="titular" id=""
                                                                                value="{{ $bancos->titular }}"
                                                                                autocomplete="off">
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <strong>Imagen</strong><br>
                                                                            <div class="form-control" style="margin: 0px">
                                                                                <input type="file"
                                                                                    id="archivoInput{{ $bancos->id }}"
                                                                                    name="foto"
                                                                                    onchange="return validarExt{{ $bancos->id }}()" />
                                                                                <div id="visorArchivo{{ $bancos->id }}">
                                                                                    <!--Aqui se desplegará el fichero-->
                                                                                    <center>
                                                                                        <img src="{{ asset('img/logos/' . $bancos->foto) }}"
                                                                                            style="width: 200px;margin: 13px 0px;border-radius: 10px">
                                                                                    </center>
                                                                                </div>
                                                                            </div>
                                                                            <input type="text"
                                                                                value="{{ $bancos->foto }}"
                                                                                class="form-control" name="ori_foto"
                                                                                hidden="hidden">
                                                                        </div>

                                                                    </div>
                                                                    <hr>
                                                                     <!-- / foto -->
                                                                     <!-- Registros -->
                                                                    <div class="row"
                                                                        style="align-items: center !important">
                                                                        <div class="col-lg-3"
                                                                            style="padding-bottom: 0px;">
                                                                            <strong>Tipo de Cuenta</strong>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <strong>Moneda</strong>
                                                                        </div>
                                                                        <div class="col-lg-3"
                                                                            style="padding-bottom: 0px;">
                                                                            <strong>N° de Cuenta</strong>
                                                                        </div>
                                                                        <div class="col-lg-2"
                                                                            style="padding-bottom: 0px;">
                                                                            <strong>¿Detracción?</strong>
                                                                        </div>
                                                                        <div class="col-lg-1" style="padding-bottom: 0px;"
                                                                            align="right"
                                                                            id="div_boton{{ $bancos->id }}">
                                                                            <button type="button" class="btn btn-info"
                                                                                id="btn_add_{{ $bancos->id }}"> <i
                                                                                    class="fa fa-plus-square"></i></button>
                                                                        </div>
                                                                    </div>

                                                                    @foreach ($banco_registro->where('banco_id', $bancos->id) as $banco_registros)
                                                                        <div class="row delete_modal_edit_{{ $banco_registros->id }}"
                                                                            style="padding-top: 10px;padding-bottom: 10px;align-items: center !important">
                                                                            <div class="col-lg-3">
                                                                                <input type="text" name="creadas_id[]"
                                                                                    hidden
                                                                                    value=" {{ $banco_registros->id }}"
                                                                                    readonly>
                                                                                <!-- <input type="t ext" name="descripcion1_creadas[]" class="form-control" value=" {{$banco_registros->tipo_cuenta}}"> -->
                                                                                <select name="descripcion1_creadas[]"
                                                                                    class="form-control" id="">
                                                                                    <option value="Cta C."
                                                                                        @if ($banco_registros->tipo_cuenta == 'Cta C.') selected @endif>
                                                                                        Cuenta Corriente</option>
                                                                                    <option value="Cta A."
                                                                                        @if ($banco_registros->tipo_cuenta == 'Cta A.') selected @endif>
                                                                                        Cuenta Ahorro</option>
                                                                                    <option value="Cta Det."
                                                                                        @if ($banco_registros->tipo_cuenta == 'Cta Det.') selected @endif>
                                                                                        Cuenta Detracciones</option>
                                                                                    <option value="CCI."
                                                                                        @if ($banco_registros->tipo_cuenta == 'CCI') selected @endif>
                                                                                        Cod. C. Interbancario</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-3">
                                                                                <select name="moneda_creada[]"
                                                                                    class="form-control" id="">
                                                                                    @foreach ($moneda as $monedas)
                                                                                        <option
                                                                                            value="{{ $monedas->id }}"
                                                                                            @if ($monedas->id == $banco_registros->moneda_id) selected @endif>
                                                                                            {{ $monedas->nombre }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-3">
                                                                                <input type="text"
                                                                                    name="descripcion2_creadas[]"
                                                                                    class="form-control descripcion2_creadas{{ $bancos->id }}"
                                                                                    value=" {{ $banco_registros->nombre_cuenta }}"
                                                                                    autocomplete="off">
                                                                            </div>
                                                                            <div class="col-lg-2" align="right">
                                                                                <input type="checkbox"
                                                                                    class="form-control change_status"
                                                                                    name="estado_detraccion"
                                                                                    id=""
                                                                                    @if ($banco_registros->estado_detraccion == 1) checked @endif
                                                                                    value="on">
                                                                                <input name="det_creada[]"
                                                                                    class="ipt_hidden" type="hidden"
                                                                                    id="input_check_{{ $banco_registros->id }}"
                                                                                    @if ($banco_registros->estado_detraccion == 1) value="on" @else value="off" @endif>
                                                                            </div>
                                                                            <div class="col-lg-1" align="right">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    onclick="eliminar_edit({{ $banco_registros->id }})"><i
                                                                                        class="fa fa-trash-o"></i></button>
                                                                                <input type="hidden"
                                                                                    name="value_eliminar[]"
                                                                                    id="eliminar_{{ $banco_registros->id }}"
                                                                                    value="0">
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                    <input type="hidden"
                                                                        id="count_reg_{{ $bancos->id }}"
                                                                        value="{{ $banco_registro->where('banco_id', $bancos->id)->count() }}">

                                                                     <!-- @endif -->
                                                                    <div id="conteiner_add_{{ $bancos->id }}">
                                                                    </div>
                                                                     <!-- Registros -->
                                                                    <div class="row"
                                                                        style="padding-top: 10px;padding-bottom: 10px;">
                                                                        <label
                                                                            class="col-sm-3 col-form-label">Activo/Desactivo:</label>
                                                                        <div class="col-sm-3">
                                                                            @if ($bancos->estado == 0)
                                                                                <div class="switch-button">
                                                                                    <input type="checkbox" name="estado"
                                                                                        id="switch-label{{ $bancos->id }}"
                                                                                        class="switch-button__checkbox"
                                                                                        checked="">
                                                                                    <label
                                                                                        for="switch-label{{ $bancos->id }}"
                                                                                        class="switch-button__label"></label>
                                                                                </div>
                                                                            @else
                                                                                <div class="switch-button">
                                                                                    <input type="checkbox" name="estado"
                                                                                        id="aswitch-label{{ $bancos->id }}"
                                                                                        class="switch-button__checkbox">
                                                                                    <label
                                                                                        for="aswitch-label{{ $bancos->id }}"
                                                                                        class="switch-button__label"></label>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <button class="ladda-button btn btn-primary"
                                                                                type="submit"
                                                                                data-style="zoom-out">Guardar</button>
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
                                <!-- FIN  MODAL BANCOS -->
                            @endforeach
                            <input type="hidden" id="count_check_detr"
                                value="{{ $banco_registro->where('estado_detraccion', 1)->count() }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
--}}

    {{-- INICIO FLAVIA --}}
        <div class="mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="card"
                        style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);">
                        <div class="row align-items-center"
                            style="padding: 20px; border-radius: 5px;">
                            <!-- Contenido de la tarjeta -->
                            <div class="col-sm-3" style="text-align: center">
                                <img src="{{ asset('img/logos/' . $mi_empresa->foto) }}"
                                    alt="Imagen de la empresa" style="max-height: 200px; height: 100%; max-width: 100%;">
                            </div>
                            <div class="col-sm-8">
                                <h3><strong>{{ $mi_empresa->razon_social}}</strong></h3>
                                <h4>{{ $mi_empresa->ruc}}</h4>
                                <p>{{ $mi_empresa->descripcion}}</p>
                            </div>
                            @can('empresa.editar')
                                <div class="col-sm-1">
                                    <button class="btn btn-primary" type="button" data-toggle="modal"
                                        data-target="#infoModal">Editar</button>
                                </div>
                            @endcan
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
                        <h3 class="modal-title" id="infoModalLabel">
                            Información de la Empresa
                        </h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                    </div>
                    <form action="{{ route('empresa.update', $mi_empresa->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="row">
                                <!-- Imagen -->
                                <div class="col-md-12 mb-3 text-center">
                                    <div class="image-container">
                                        <img class="preview_img" id="preview" src="{{ asset('img/logos/' . $mi_empresa->foto) }}" alt="Clic para cambiar imagen">
                                    </div>
                                    <input type="file" id="fileInput" accept="image/*" style="display: none;" name="ori_foto">
                                    <small>(Click para cambiar la imagen)</small>
                                </div>
                                <!-- Descripción -->
                                <div class="col-md-12 mb-3">
                                    <label for="descripcion" class="form-label"><strong>Descripción:</strong></label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{$mi_empresa->descripcion}}</textarea>
                                </div>

                                <!-- Movil y Teléfono -->
                                <div class="col-md-6 mb-3">
                                    <label for="movil" class="form-label"><strong>Movil:</strong></label>
                                    <input type="text" class="form-control" id="movil" name="movil" value="{{$mi_empresa->movil}}" autocomplete="off">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label"><strong>Teléfono:</strong></label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" value="{{$mi_empresa->telefono}}" autocomplete="off">
                                </div>

                                <!-- Correo y País -->
                                <div class="col-md-6 mb-3">
                                    <label for="correo" class="form-label"><strong>Correo:</strong></label>
                                    <input type="email" class="form-control" name="correo" id="correo"
                                        value="{{$mi_empresa->correo}}" autocomplete="off">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pais" class="form-label"><strong>País:</strong></label>
                                    <select class="select2_pais form-control" name="pais" id="pais">
                                        @php
                                            $pais_encontrado = false;
                                        @endphp

                                        @foreach ($paises as $pais)
                                            <option value="{{ $pais->nombre }}" @if ($mi_empresa->pais == $pais->nombre) selected @php $pais_encontrado = true; @endphp @endif>
                                                {{ $pais->nombre }}
                                            </option>
                                        @endforeach

                                        @if (!$pais_encontrado)
                                            <option value="{{ $mi_empresa->pais }}" selected>{{ $mi_empresa->pais }}</option>
                                        @endif
                                    </select>
                                </div>

                                <!-- Calle y Rubro -->
                                <div class="col-md-6 mb-3">
                                    <label for="calle" class="form-label"><strong>Calle:</strong></label>
                                    <textarea class="form-control" id="calle" name="calle" rows="2">{{$mi_empresa->calle}}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="rubro" class="form-label"><strong>Rubro:</strong></label>
                                    <input type="text" class="form-control" id="rubro" name="rubro"
                                        value="{{$mi_empresa->rubro}}" autocomplete="off">
                                </div>

                                <!-- Región y Ciudad -->
                                <div class="col-md-6 mb-3">
                                    <label for="region_provincia" class="form-label"><strong>Región/Provincia:</strong></label>
                                    <input type="text" class="form-control" id="region_provincia" name="region_provincia" value="{{$mi_empresa->region_provincia}}" autocomplete="off">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ciudad" class="form-label"><strong>Ciudad:</strong></label>
                                    <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{$mi_empresa->ciudad}}" autocomplete="off">
                                </div>

                                <!-- Código Ubigeo y Página Web -->
                                <div class="col-md-6 mb-3">
                                    <label for="codigo_postal" class="form-label"><strong>Código Ubigeo: </strong><a href="https://account.geodir.co/recursos/ubigeo-inei-peru.html"  target="_blank" style="margin: auto" ><i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999" ></i></a></label>
                                    <input type="text" class="form-control" id="ubigeo" name="codigo_postal" value="{{$mi_empresa->codigo_postal}}" autocomplete="off">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pagina_web" class="form-label"><strong>Página Web:</strong></label>
                                    <input type="text" class="form-control" id="pagina_web" name="pagina_web" value="{{$mi_empresa->pagina_web}}" autocomplete="off">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class=" mt-4" style="padding-bottom: 1rem;margin-bottom: 1rem">
            <div class="row row-cols-1 row-cols-md-2 g-4 ">
                <div class="col mb-4"> <!-- Tarjeta de "Mi empresa" -->
                    <div class="card text-center"
                        style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);height: 100%;">
                        <div style="margin: auto;text-align: center">
                            <h5 class="card-title"
                            style="text-align: center !important; width: 100%;font-weight: bold; font-size: 1rem">LOGO DE LA EMPRESA</h5>
                            <img src="{{ asset('img/logos/' . $mi_empresa->foto) }}"
                            alt="Imagen de la empresa" style="max-height: 200px; height: 100%;">
                        </div>
                        {{-- <div class="card-body">
                            <h5 class="card-title" style="color: blue; font-weight: bold; font-size: 2rem;"> {{ $mi_empresa->razon_social }}</h5>
                        </div> --}}
                    </div>
                </div>

                <div class="col mb-4"> <!-- Tarjeta de "Número de contactos" -->
                    <div class="card text-center"
                        style="background-color: blue; color: white; box-shadow: 0 4px 15px rgba(0, 0, 255, 0.5);">
                        <div class="card-body"
                            style="min-height: 270px; display: flex; flex-direction: column; justify-content: center;align-items: center">
                            <h5 class="card-title"
                                style="text-align: center !important; width: 100%;font-weight: bold; font-size: 1rem">INFORMACION DE LA EMPRESA</h5>
                            <div style="text-align: left">
                                <p class="card-text" style="margin: 5px 0;"><i
                                    class="fa fa-phone"></i>&nbsp; <strong>Teléfono:</strong> {{ $mi_empresa->telefono }}</p>
                                <p class="card-text" style="margin: 5px 0;"><i class="fa fa-phone"></i>
                                    &nbsp;<strong>Celular:</strong> {{ $mi_empresa->movil }}</p>
                                <p class="card-text" style="margin: 5px 0;"><i class="fa fa-globe"></i>
                                    &nbsp;<strong>Sitio Web:</strong> {{ $mi_empresa->pagina_web }}<a h1ref="{{ $mi_empresa->pagina_web }}"
                                        style="color: white; text-decoration: underline;"></a></p>
                                <p class="card-text" style="margin: 5px 0;">
                                    <i class="fa fa-envelope"></i> &nbsp;<strong>Correo:</strong>
                                    <a href="mailto:{{ $mi_empresa->correo }}" style="color: white; text-decoration: none;">
                                        {{ $mi_empresa->correo }}
                                    </a>
                                </p>
                                <p class="card-text" style="margin: 5px 0;"><i
                                    class="fa fa-phone"></i>&nbsp; <strong>Rubro:</strong> {{ $mi_empresa->rubro }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segunda fila de tarjetas -->
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col mb-4"> <!-- Agregado mb-4 -->
                    <div class="card text-center"
                        style="background-color: blue; color: white; box-shadow: 0 4px 15px rgba(0, 0, 255, 0.5);height: 100%;">
                        <div class="card-body" style=" display: flex; flex-direction: column; justify-content: center;align-items: center">
                            <h5 class="card-title" style="text-align: center;font-weight: bold; font-size: 1rem"> DATOS DE
                                UBICACIÓN</h5>
                                <div style="text-align: left">
                                    <p class="card-text" style="margin: 5px 0;"><i class="fa fa-flag"></i>
                                        &nbsp; <strong>País:</strong> {{ $mi_empresa->pais }}</p>
                                    <p class="card-text" style="margin: 5px 0;"><i class="fa fa-map"></i>
                                        &nbsp; <strong>Provincia:</strong> {{ $mi_empresa->region_provincia }}</p>
                                    <p class="card-text" style="margin: 5px 0;"><i class="fa fa-map"></i>
                                        &nbsp; <strong>Ciudad:</strong> {{ $mi_empresa->ciudad }}</p>
                                    <p class="card-text" style="margin: 5px 0;"><i class="fa fa-map"></i>
                                        &nbsp; <strong>Dirección:</strong> {{ $mi_empresa->calle }}</p>
                                    <p class="card-text" style="margin: 5px 0 20px 0;"><i
                                            class="fa fa-file"></i>&nbsp;<strong> Código Ubigeo:</strong> {{ $mi_empresa->codigo_postal }}</p>
                                </div>
                            <!-- Mapa incrustado -->
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.5608069684718!2d-77.04077347304688!3d-12.07371039999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c8ed9bc09107%3A0x65cd03781324adb2!2sJ%26P%20Perif%C3%A9ricos%20SAC%20-%20en%20LIMA%7C%20Venta%2C%20Computadoras%2C%20Laptop%20%7C%20Reparaci%C3%B3n%20y%20Mantenimiento%20de%20port%C3%A1tiles!5e0!3m2!1ses-419!2spe!4v1727195701956!5m2!1ses-419!2spe"
                                width="100%" height="280" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                                <br>
                        </div>
                    </div>
                </div>

                <div class="col mb-4">
                    <div class="row">
                        <div class="col-sm-12"> <!-- Columna para la tarjeta -->
                            <div class="card text-center"
                                style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <h5 class="card-title mb-3"
                                        style="text-align: center; font-weight: bold; font-size: 1rem; color: blue;">MONEDA
                                        PRINCIPAL</h5>
                                    <div class="">
                                        @foreach ($moneda as $index2 => $monedas)
                                            <div class="d-flex align-items-center mb-3 tooltip-demo" style="justify-content: space-between">
                                                <span data-toggle="tooltip" data-placement="bottom" @if ($monedas->principal == 1) title="Moneda Principal" @else title="Moneda Secundaria" @endif >
                                                    <span  @if ($monedas->principal == 0) id="demo{{ $monedas->id }}" @else id="demo_principal{{ $monedas->id }}" @endif style="display: flex; align-items: center; justify-content: center; align-content: center;cursor: pointer;">
                                                        <button type="button"
                                                            class="rounded-circle bg-warning text-dark d-flex justify-content-center align-items-center"
                                                            style="width: 50px; height: 50px; margin-right: 30px; border: none;cursor: pointer; @if ($monedas->principal == 0) background-color: grey !important @endif "   >
                                                            <span style="color: white;"><i class="fa fa-2x">{{ $monedas->simbolo }}</i></span>
                                                        </button>
                                                        <p class="card-text mb-0" style="font-weight: bold;">{{ ucfirst($monedas->nombre) }} /
                                                            Moneda {{ $monedas->tipo }}</p>
                                                    </span>
                                                </span>
                                            </div>
                                            @if($index2%2 == 0) <hr> @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="height: 3px !important; margin: 10px !important">
                            <br>
                        </div>
                        <div class="col-sm-12">
                            <!-- Tercera fila de tarjetas -->
                            <div class="">
                                <div class=""> <!-- Tarjeta Datos de Ubicación -->
                                    <div class="card text-center" style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); min-height: 240px;">
                                        <!-- Título de la tarjeta -->
                                        <div class="card-header" style="background-color: transparent; border: none;">
                                            <h5 class="card-title mb-3" style="text-align: center; font-weight: bold; font-size: 1rem; color: blue;">CUENTAS BANCARIAS</h5>
                                            <div class="card-body d-flex flex-row align-items-center justify-content-around">
                                                <!-- Columna derecha con Scotiabank y BBVA -->
                                                <div class="row" style="align-items: center;justify-content: center;">
                                                    @foreach ($banco as $index  => $bancos)
                                                        <div class="col-lg-5">
                                                            <div class="tooltip-demo">
                                                                <span data-toggle="tooltip" data-placement="bottom" @if ($bancos->estado == 0) title="Activado" @else title="Desactivado" @endif >
                                                                    @if ($bancos->estado == 0)
                                                                        <strong><span>{{ $bancos->nombre_banco }}</span></strong>
                                                                        <br>
                                                                        <i class="fa fa-circle" style="color: #5fa8f3;"></i>
                                                                    @else
                                                                        <i class="fa fa-circle"></i>
                                                                    @endif
                                                                    <img src="{{ asset('img/logos/' . $bancos->foto) }}" class="card-img-top" alt="Scotiabank" style="width: 150px; height: auto;margin: 20px 0px;cursor: pointer;" data-toggle="modal" data-target="#modal_banco_{{ $bancos->id }}">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        @if( $index%2 == 0)
                                                            <div class="col-lg-2">
                                                                <i class="fa fa-bank" style="color: blue; font-size: 30px; margin-bottom: 10px;"></i>
                                                            </div>
                                                        @endif
                                                        {{-- MODAL BANCOS --}}
                                                            <div class="modal fade" id="modal_banco_{{ $bancos->id }}" tabindex="-1"
                                                                role="dialog" aria-labelledby="modal_banco_label" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div style="padding-left: 15px;padding-right: 15px;">
                                                                            <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;"
                                                                                align="center">
                                                                                <form action="{{ route('banco.update', $bancos->id) }}"
                                                                                    enctype="multipart/form-data" method="post">
                                                                                    @csrf
                                                                                    @method('PATCH')
                                                                                    <fieldset>
                                                                                        <div>
                                                                                            <div class="panel-body">
                                                                                                <div class="row"
                                                                                                    style="align-items: center !important">
                                                                                                    {{-- Foto --}}
                                                                                                    <div class="col-sm-6">
                                                                                                        <strong>Nombre</strong>
                                                                                                        <input type="text" class="form-control" name="nombre_banco" id="" value="{{ $bancos->nombre_banco }}"
                                                                                                            autocomplete="off">
                                                                                                        <strong>Titular</strong>
                                                                                                        <input type="text" class="form-control" name="titular" id="" value="{{ $bancos->titular }}"
                                                                                                            autocomplete="off">
                                                                                                    </div>
                                                                                                    <div class="col-sm-6">
                                                                                                        <strong>Imagen</strong><br>
                                                                                                        <div class="form-control" style="margin: 0px">
                                                                                                            <input type="file"
                                                                                                                id="archivoInput{{ $bancos->id }}" name="foto"
                                                                                                                onchange="return validarExt{{ $bancos->id }}()" />
                                                                                                            <div id="visorArchivo{{ $bancos->id }}" style="text-align: center">
                                                                                                                <!--Aqui se desplegará el fichero-->
                                                                                                                <img src="{{ asset('img/logos/' . $bancos->foto) }}"
                                                                                                                        style="width: 200px;margin: 13px 0px;border-radius: 10px">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <input type="text"
                                                                                                            value="{{ $bancos->foto }}" class="form-control" name="ori_foto"
                                                                                                            hidden="hidden" autocomplete="off">
                                                                                                        <small>(Click para cambiar la imagen)</small>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <hr>
                                                                                                {{-- / foto --}}
                                                                                                {{-- Registros --}}
                                                                                                <div class="row" style="align-items: center !important">
                                                                                                    <div class="col-lg-3"
                                                                                                        style="padding-bottom: 0px;">
                                                                                                        <strong>Tipo de Cuenta</strong>
                                                                                                    </div>
                                                                                                    <div class="col-lg-3">
                                                                                                        <strong>Moneda</strong>
                                                                                                    </div>
                                                                                                    <div class="col-lg-3"
                                                                                                        style="padding-bottom: 0px;">
                                                                                                        <strong>N° de Cuenta</strong>
                                                                                                    </div>
                                                                                                    <div class="col-lg-2"
                                                                                                        style="padding-bottom: 0px;">
                                                                                                        <strong>¿Detracción?</strong>
                                                                                                    </div>
                                                                                                    <div class="col-lg-1" style="padding-bottom: 0px;" align="right" id="div_boton{{ $bancos->id }}">
                                                                                                        <button type="button" class="btn btn-info"
                                                                                                            id="btn_add_{{ $bancos->id }}"> <i
                                                                                                                class="fa fa-plus-square"></i></button>
                                                                                                    </div>
                                                                                                </div>
                                                                                                @foreach ($banco_registro->where('banco_id', $bancos->id) as $banco_registros)
                                                                                                    <div class="row delete_modal_edit_{{ $banco_registros->id }}"
                                                                                                        style="padding-top: 10px;padding-bottom: 10px;align-items: center !important">
                                                                                                        <div class="col-lg-3">
                                                                                                            <input type="text" name="creadas_id[]" hidden value=" {{ $banco_registros->id }}" readonly >
                                                                                                            <select name="descripcion1_creadas[]"
                                                                                                                class="form-control" id="">
                                                                                                                <option value="Cta C."
                                                                                                                    @if ($banco_registros->tipo_cuenta == 'Cta C.') selected @endif>
                                                                                                                    Cuenta Corriente</option>
                                                                                                                <option value="Cta A."
                                                                                                                    @if ($banco_registros->tipo_cuenta == 'Cta A.') selected @endif>
                                                                                                                    Cuenta Ahorro</option>
                                                                                                                <option value="Cta Det."
                                                                                                                    @if ($banco_registros->tipo_cuenta == 'Cta Det.') selected @endif>
                                                                                                                    Cuenta Detracciones</option>
                                                                                                                <option value="CCI."
                                                                                                                    @if ($banco_registros->tipo_cuenta == 'CCI') selected @endif>
                                                                                                                    Cod. C. Interbancario</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                        <div class="col-lg-3">
                                                                                                            <select name="moneda_creada[]"
                                                                                                                class="form-control" id="">
                                                                                                                @foreach ($moneda as $monedas)
                                                                                                                    <option
                                                                                                                        value="{{ $monedas->id }}"
                                                                                                                        @if ($monedas->id == $banco_registros->moneda_id) selected @endif>
                                                                                                                        {{ $monedas->nombre }}</option>
                                                                                                                @endforeach
                                                                                                            </select>
                                                                                                        </div>
                                                                                                        <div class="col-lg-3">
                                                                                                            <input type="text"
                                                                                                                name="descripcion2_creadas[]"
                                                                                                                class="form-control descripcion2_creadas{{ $bancos->id }}"
                                                                                                                value=" {{ $banco_registros->nombre_cuenta }}"
                                                                                                                autocomplete="off">
                                                                                                        </div>
                                                                                                        <div class="col-lg-2" align="right">
                                                                                                            <input type="checkbox"
                                                                                                                class="form-control change_status"
                                                                                                                name="estado_detraccion"
                                                                                                                id=""
                                                                                                                @if ($banco_registros->estado_detraccion == 1) checked @endif
                                                                                                                value="on">
                                                                                                            <input name="det_creada[]"
                                                                                                                class="ipt_hidden" type="hidden"
                                                                                                                id="input_check_{{ $banco_registros->id }}"
                                                                                                                @if ($banco_registros->estado_detraccion == 1) value="on" @else value="off" @endif>
                                                                                                        </div>
                                                                                                        <div class="col-lg-1" align="right">
                                                                                                            <button type="button"
                                                                                                                class="btn btn-secondary"
                                                                                                                onclick="eliminar_edit({{ $banco_registros->id }})"><i
                                                                                                                    class="fa fa-trash-o"></i></button>
                                                                                                            <input type="hidden"
                                                                                                                name="value_eliminar[]"
                                                                                                                id="eliminar_{{ $banco_registros->id }}"
                                                                                                                value="0">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endforeach
                                                                                                <input type="hidden"
                                                                                                    id="count_reg_{{ $bancos->id }}"
                                                                                                    value="{{ $banco_registro->where('banco_id', $bancos->id)->count() }}">
                                                                                                <div id="conteiner_add_{{ $bancos->id }}">
                                                                                                </div>
                                                                                                {{-- Registros --}}
                                                                                                <div class="row"
                                                                                                    style="padding-top: 10px;padding-bottom: 10px;">
                                                                                                    <label
                                                                                                        class="col-sm-3 col-form-label">Activo/Desactivo:</label>
                                                                                                    <div class="col-sm-3">
                                                                                                        @if ($bancos->estado == 0)
                                                                                                            <div class="switch-button">
                                                                                                                <input type="checkbox" name="estado"
                                                                                                                    id="switch-label{{ $bancos->id }}"
                                                                                                                    class="switch-button__checkbox"
                                                                                                                    checked="">
                                                                                                                <label
                                                                                                                    for="switch-label{{ $bancos->id }}"
                                                                                                                    class="switch-button__label"></label>
                                                                                                            </div>
                                                                                                        @else
                                                                                                            <div class="switch-button">
                                                                                                                <input type="checkbox" name="estado"
                                                                                                                    id="aswitch-label{{ $bancos->id }}"
                                                                                                                    class="switch-button__checkbox">
                                                                                                                <label
                                                                                                                    for="aswitch-label{{ $bancos->id }}"
                                                                                                                    class="switch-button__label"></label>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                    <div class="col-sm-6">
                                                                                                        @can('bancos.editar')
                                                                                                            <button class="ladda-button btn btn-primary"
                                                                                                                type="submit"
                                                                                                                data-style="zoom-out">Guardar</button>
                                                                                                        @endcan
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
                                                    <input type="hidden" id="count_check_detr" value="{{ $banco_registro->where('estado_detraccion', 1)->count() }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- FIN FLAVIA --}}

    <style type="text/css" media="screen">
        #vertical-timeline.light-timeline:before {
            background: #0d9eff;
        }

        .widget {
            border-radius: 50%;
            border: 8px solid #7e7e7eab;
            transition: 0.8s;
            cursor: pointer;
        }

        .widget:hover {
            background: #bdbcbc94;
            color: white;
        }

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
            background-color: #1f1f1f66;
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

        .switch-button .switch-button__checkbox:checked+.switch-button__label {
            background-color: #1c84c6;
        }

        .switch-button .switch-button__checkbox:checked+.switch-button__label:before {
            transform: translateX(1rem);
        }

        .banco {
            border-radius: 5px;
            border: 1px solid black
        }

        .image-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        .preview_img {
            width: 100%;
            height: auto;
            cursor: pointer;
            display: block;
        }

        .modal-dialog {
            max-width: 900px;
        }
        .select2-container{
            z-index: 99999999;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {font-size: 12px;text-align: left;}
        .select2-container--default .select2-selection--single { border: none;}
        .select2-container--default .select2-selection--single .select2-selection__rendered {font-size: 0.9rem;padding-left: 0px;color: inherit;}
        span.select2.select2-container.select2-container--default{
            width: 100% !important;
            background-color: #FFFFFF;
            background-image: none;
            border-radius: 1px;
            display: block;
            padding: 3px 12px;
            border: 1px solid #e5e6e7;
        }
        input#archivoInputs {
            position: absolute;
            right: 130px;
            width: 350px;
            height: 100%;
            opacity: 0;
        }
    </style>

    @foreach ($banco as $bancos)
        <style>
            input#archivoInput{{ $bancos->id }} {
                position: absolute;
                top: 0px;
                left: 0px;
                right: 0px;
                bottom: 0px;
                width: 100%;
                height: 100%;
                opacity: 0;
            }
        </style>
        <script type="text/javascript">
            // {{-- Fotooos --}}
            function validarExt{{ $bancos->id }}() {
                var archivoInput = document.getElementById('archivoInput{{ $bancos->id }}');
                var archivoRuta = archivoInput.value;
                var extPermitidas = /(.jpg|.png|.jfif)$/i;
                if (!extPermitidas.exec(archivoRuta)) {
                    alert('Asegúrese de haber seleccionado una Imagen');
                    archivoInput.value = '';
                    return false;
                } else {
                    //PRevio del PDF
                    if (archivoInput.files && archivoInput.files[0]) {
                        var visor = new FileReader();
                        visor.onload = function(e) {
                            document.getElementById('visorArchivo{{ $bancos->id }}').innerHTML =
                                '<img name="firma" src="' + e.target.result +
                                '" style="width: 300px;height: 120px;margin-bottom: 15px;border-radius: 10px" />';
                        };
                        visor.readAsDataURL(archivoInput.files[0]);
                    }
                }
            }
        </script>
    @endforeach

    <div id="form">

    </div>
    <form action="{{ route('moneda.update', 1) }}" enctype="multipart/form-data" method="post" id="myForm">
        @csrf
        @method('PATCH')
    </form>

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}"rel="stylesheet">
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    @foreach ($moneda as $monedas)
       @can('moneda.editar')
            <script>
                $('#demo_principal{{ $monedas->id }}').click(function() {
                    swal({
                        title: "{{ $monedas->simbolo }} {{ $monedas->nombre }}",
                        text: "Moneda '{{ $monedas->nombre }}' actualmente registrada como Moneda Principal."
                    });
                });
                $(document).ready(function() {
                    $('#demo{{ $monedas->id }}').click(function() {
                        swal({
                                title: "¿Deseas Cambiar '{{ $monedas->simbolo }} {{ $monedas->nombre }}'' como moneda Principal ?",
                                text: "",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3686ff",
                                confirmButtonText: "Si, Cambiar",
                                cancelButtonText: "Cancelar!",
                                closeOnConfirm: false,
                                closeOnCancel: false
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    var data =
                                        `  <input type="hidden" hidden name="id_moneda" randoly value="{{ $monedas->id }}" >`;
                                    $('#myForm').append(data);
                                    document.getElementById("myForm").submit();
                                    swal("Moneda Cambiada", "Ahora debes Registrar el Tipo de Cambio",
                                        "success");
                                } else {
                                    swal("Cancelado", "", "error");
                                }
                            });
                    })
                });
            </script>
       @endcan
    @endforeach
    @cannot('bancos.editar')
        <script>
            $(document).ready(function() {
                $('#modal_banco_{{ $bancos->id }}')
                    .find('input, select, textarea, button[type="submit"]')
                    .prop('disabled', true);

                // Mantener visible el botón cerrar del modal
                $('#modal_banco_{{ $bancos->id }} .close').prop('disabled', false);
            });
        </script>
    @endcannot

    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2_pais").select2({
                placeholder: "Seleccionar Producto",
            });

            var count_d = $('#count_check_detr').val();
            if (count_d > 0) {
                all_ch = document.querySelectorAll('.change_status');
                all_ch.forEach(function(checkbox) {
                    if (!checkbox.checked) { // Verificar si el checkbox no está marcado
                        checkbox.disabled = true; // Agregar el atributo disabled
                    }
                });
            }

        });
        // {{-- Imagen de Logo --}}
        const previewImage = document.getElementById('preview');
        const fileInput = document.getElementById('fileInput');

        previewImage.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        function eliminar_edit(y) {
            $(`.delete_modal_edit_${y}`).css('display', 'none');
            $(`#eliminar_${y}`).val(y);
        };
    </script>

    @foreach ($banco as $bancos)
        <script>
            $("#btn_add_{{ $bancos->id }}").on('click', function() {
                var x = $(`#count_reg_` + {{ $bancos->id }}).val();
                var suma{{ $bancos->id }} = document.getElementsByClassName('descripcion2').length;
                var otra_suma{{ $bancos->id }} = document.getElementsByClassName(
                    'descripcion2_creadas{{ $bancos->id }}').length;
                var inp_mont{{ $bancos->id }} = suma{{ $bancos->id }} + otra_suma{{ $bancos->id }};
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
                            <option value="{{ $monedas->id }}">{{ $monedas->nombre }}</option>
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
                if (x <= 3) {
                    $('#conteiner_add_{{ $bancos->id }}').append(data);
                }
                x++;
                var x = $(`#count_reg_` + {{ $bancos->id }}).val(x);

                f_checked();

            });

            function eliminar(x) {
                $(`.delete_modal${x}`).remove();
            };
        </script>
    @endforeach
    <script>
        $(".change_status").on("change", function() {
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
            } else {
                var all_ch = document.querySelectorAll('.change_status');
                all_ch.forEach(function(checkbox) {
                    // if (checkbox.checked) { // Verificar si el checkbox no está marcado
                    checkbox.disabled = false; // Agregar el atributo disabled
                    // }
                });
                $(this).parent().children("input.ipt_hidden").val('off');
            }

        });

        function f_checked() {
            var count_d = $('#count_check_detr').val();
            if (count_d > 0) {
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
