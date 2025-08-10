<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ 'css/productos/create.css' }}">

{{--
@extends('layout')
@section('title', 'Productos')
@section('href_accion', route('productos.index') )
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')--}}

<!--
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

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox product-detail">
        <div class="ibox-content">
          <div class="row">
            <form action="{{ route('productos.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)" style="display: flex;">
              @csrf
              <div class="col-sm-5">
                <div class="product-images">
                  <div class="image-imitation" style="padding:0px">
                    <input type="file" id="archivoInput" name="foto" onchange="return validarExt()"   />
                    <div id="visorArchivo">
                      <img src="{{asset('img/logos/producto.svg')}}" style="width: 100%" >
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7" style="vertical-align: middle;padding: auto">
                <div class="tooltip-demo">
                  <div class="row">
                    <div class="col-sm-3">
                      <input placeholder="PRO-0X33X345XX" data-toggle="tooltip" data-placement="top"  title="Código Alternativo:" type="text" class="form-control" name="codigo_original" autocomplete="off">
                    </div>
                    <div class="col-sm-3">
                        <div data-toggle="tooltip" data-placement="top" title="Familia">
                          <select   class="familia_select2 form-control" name="familia_id" id="familia_id_sl" required="required" onchange="list_subfamilia()">
                            <option value=""></option>
                              @foreach($familias as $familia)
                                <option value="{{ $familia->id }}">{{ $familia->descripcion}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3" >
                        <div data-toggle="tooltip" data-placement="top" title="Subfamilia">
                          <select   class="subfamilia_select2 form-control" name="sub_familia_id" >
                            {{-- <option value="" aria-readonly="">Seleccionar</option> --}}
                          </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                      <div  data-toggle="tooltip" data-placement="top" title="Marca">
                        <select  class="marca_select2 " name="marca_id" required="required">
                          @foreach($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nombre}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-12">
                      <input type="text" placeholder="Nombre del Producto" class="form-control" required="required" data-toggle="tooltip" name="nombre" data-placement="top" title="Nombre del Producto"  autocomplete="off" >
                      <textarea style="margin-top:10px" data-toggle="tooltip" data-placement="top" title="Descripción del Producto"  type="text" class="form-control" placeholder="Descripción del Producto" name="descripcion" rows="2" ></textarea >
                    </div>
                  </div>
                  <hr style="border:1px solid #8080803d;">
                  <div class="tooltip-demo row">
                    <label class="col-sm-2 col-form-label">Desct.1:</label>
                    <div class="col-sm-4">
                      <div class="input-group m-b">
                        <div class="input-group-prepend">
                          <span class="input-group-addon">%</span>
                        </div>
                        <input type="text"  data-toggle="tooltip" data-placement="top" title="Descuenta internamente, de forma automática" class="form-control input_valor_numerico" name="descuento1" value="0" autocomplete="off" required="required" >
                      </div>
                    </div>
                    <label class="col-sm-2 col-form-label">Desct.2:</label>
                    <div class="col-sm-4">
                      <div class="input-group m-b">
                        <div class="input-group-prepend">
                          <span class="input-group-addon">%</span>
                        </div>
                        <input type="text" class="form-control input_valor_numerico" data-toggle="tooltip" data-placement="top" title="Descuenta de forma Manual (Cotizaciones, Facturas)" name="descuento2"  required="required" value="0" autocomplete="off" >
                      </div>
                    </div>
                    <label class="col-sm-2 col-form-label">Desct.Máximo:</label>
                    <div class="col-sm-4">
                      <div class="input-group m-b">
                        <div class="input-group-prepend">
                          <span class="input-group-addon">%</span>
                        </div>
                        <input type="text" class="form-control input_valor_numerico" name="descuento_maximo" required="required" value="0" autocomplete="off">
                      </div>
                    </div>
                    <label class="col-sm-2 col-form-label">Utilidad: <i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;" data-toggle="modal" data-target="#exampleModalCenter"></i></label>
                    <div class="col-sm-4">
                      <div class="input-group m-b">
                        <div class="input-group-prepend">
                          <span class="input-group-addon">%</span>
                        </div>
                        <input type="text" id="sumando" class="form-control input_valor_numerico" name="utilidad" required="required" value="0" autocomplete="off">
                      </div>
                    </div>
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
                      <div class="input-group m-">
                        <select name="simbolo" class="form-control">
                          <option value="Gramos">Gramos</option>
                          <option value="Kilos">Kilos</option>
                          <option value="Toneladas">Toneladas</option>
                        </select>
                      </div>
                    </div>
                    <label class="col-sm-2 col-form-label">Garantía:</label>
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
                    <label class="col-sm-2">Fecha de Creacion:</label>
                    <div class="col-sm-4">
                      <input type="text" readonly value="{{date('d/m/Y')}}" class="form-control">
                    </div>
                    <label class="col-sm-2">Ficha:</label>
                    <div class="col-sm-4">
                      {{-- <input type="file" class="form-control" name="archivo_producto" style="margin: 1px auto 1px auto;padding: 1%"> --}}
                      <div class="custom-file">
                        <input id="logo" type="file" class="custom-file-input" name="archivo_producto">
                        <label for="logo" class="custom-file-label">Seleccionar archivo...</label>
                      </div>
                    </div>

                    <div class="col-sm-12" style="align-items: center;padding:  2% 22% 2% 22% ">
                      <button type="submit" class="ladda-button btn btn-success btn-block button_guardar" >Guardar</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- Modal Utilidad --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
-->


{{--
<!--Código actual 14/11/2024-->
<form action="">
    <div class="row bg-white p-3 m-5 align-content-center" >
        <!--Primera columna-->
        <div class="col-md-7 col-lg-6 col-xl-6 p-5 border border-primary border-left-0 border-bottom-0 border-top-0">
            <div class="row d-flex justify-content-between">
                <input type="text" placeholder="PRO-0X33X345XX" class="form-control m-b col-lg-5">

                <select class="form-control m-b col-lg-5" name="account">
                    <option>Servidores</option>
                    <option>Perifericos</option>
                    <option>Tablets</option>
                    <option>Computadoras de escritorio</option>
                    <option value="">Impresoras</option>
                    <option value="">Escaner</option>
                </select>
            </div>
            <div class="row d-flex justify-content-between">
                <select class="form-control m-b col-lg-5" name="account">
                    <option>Sub familia</option>
                    <option>Sub familia</option>
                    <option>Sub familia</option>
                    <option>Sub familia</option>
                    <option value="">Sub familia</option>
                    <option value="">Sub familia</option>
                </select>
                <select class="form-control m-b col-lg-5" name="account">
                    <option>HP</option>
                    <option>Samsung</option>
                    <option>Lenovo</option>
                    <option>LG</option>
                    <option value="">sonic</option>
                    <option value="">Dell</option>
                </select>
            </div>
            <div class="row pb-5 border border-primary border-left-0 border-right-0 border-top-0">
                <input type="text" placeholder="Nombre del Producto" class="form-control mt-2">
                <textarea name="" id="" placeholder="Descripción del Producto" class="form-control mt-2" style="height: 100px;"></textarea>
            </div>

            <!--Segunda parte de la primera columna-->
            <div class="row d-flex justify-content-between pt-5">
                <!-- Descuento 1-->
                <div class="form-group col-xl-4 col-md-6">
                    <div class="input-group m-b">
                        <div class="input-group-prepend">
                            <span class="input-group-addon">%</span>
                        </div>
                        <input type="text" placeholder="Desct.1" class="form-control">
                    </div>
                </div>
                <!-- Descuento 2-->
                <div class="form-group col-xl-4 col-md-6">
                    <div class="input-group m-b">
                        <div class="input-group-prepend">
                            <span class="input-group-addon">%</span>
                        </div>
                        <input type="text" placeholder="Desct.2:" class="form-control">
                    </div>
                </div>
                <!-- Descuento Máximo-->
                <div class="form-group col-xl-4">
                    <div class="input-group m-b">
                        <div class="input-group-prepend">
                            <span class="input-group-addon">%</span>
                        </div>
                        <input type="text" placeholder="Desct.Máx:" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-between">
                <!-- Utilidad-->
                <div class="form-group col-xl-5">
                    <div class="input-group m-b">
                        <div class="input-group-prepend">
                            <span class="input-group-addon">%</span>
                        </div>
                        <input type="text" placeholder="Utilidad:" class="form-control">
                    </div>
                </div>
                <!-- Unidad de  medida-->
                <div class="form-group col-xl-7 row">
                    <label class="col-xl-5 col-form-label">Un.de Medida:</label>
                    <div class="input-group m-b col-xl-7">
                        <select class="form-control m-b" name="account">
                            <option>Bolsa</option>
                            <option>Gravado - Retiro</option>
                            <option>Gravado - IVAP</option>
                            <option>Inafecto - Retiro</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-between">
                <!-- Peso-->
                <div class="form-group col-xl-6 row">
                    <label class="col-xl-3 col-form-label">Peso:</label>
                    <div class="input-group m-b col-xl-9">
                        <div class="input-group-prepend">
                            <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button" aria-expanded="false">Action </button>
                            <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 35px; left: 0px; will-change: top, left;">
                                <li><a href="#">Gramo</a></li>
                                <li><a href="#">Kg</a></li>
                                <li><a href="#">Pixeles</a></li>
                            </ul>
                        </div>
                        <input type="number" class="form-control">
                    </div>
                </div>
                <!-- Garantía-->
                <div class="form-group col-xl-6 row">
                    <label class="col-xl-4 col-form-label">Garantía: </label>
                    <div class="input-group m-b col-xl-8">
                        <input type="text" placeholder="" class="form-control">
                    </div>
                </div>
            </div>

        </div>

        <!--Segunda columna-->
        <div class="col-md-5 col-lg-6 col-xl-6 align-content-center align-items-center px-4">
            <div class="row">
                <div class="col-xl-8">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Stock Mínimo: </label>
                        <div class="input-group m-b col-sm-9">
                            <input type="text" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Stock Máximo: </label>
                        <div class="input-group m-b col-sm-9">
                            <input type="text" placeholder="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Afectación:</label>
                        <div class="input-group m-b col-sm-9">
                            <select class="form-control m-b" name="account">
                                <option>Gravado - Operación Onerosa</option>
                                <option>Gravado - Retiro</option>
                                <option>Gravado - IVAP</option>
                                <option>Inafecto - Retiro</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Fecha de creación:</label>
                        <div class="input-group m-b col-sm-9">
                            <input type="text" placeholder="20/08/2024" class="form-control bg-primary-subtle" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Ficha:</label>
                        <div class="input-group m-b col-sm-9">
                            <div class="custom-file">
                                <input id="inputGroupFile01" type="file" class="custom-file-input">
                                <label class="custom-file-label" for="inputGroupFile01"></label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-4 d-flex justify-content-center align-items-center">
                    <p>
                        <a href=""><img src="{{ asset('img/logos/producto.svg') }}" alt="" class="img-size"></a>
                    </p>
                </div>
                <button type="submit" class="btn btn-block btn-success mx-3">Guardar</button>

                <a data-toggle="modal" href="#NuevoProducto">agregar</a>
            </div>
        </div>
    </div>
</form>

<!-- modal - Agregar Producto 11/02/2025-->
<div id="create" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width:1300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Agregar Producto</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <form action="">
                    <div class="row align-content-center">
                        <!--Primera columna-->
                        <div class="col-md-7 col-lg-6 col-xl-6 p-5 border border-primary border-left-0 border-bottom-0 border-top-0">
                            <div class="row d-flex justify-content-between">
                                <input type="text" placeholder="PRO-0X33X345XX" class="form-control m-b col-lg-5">

                                <select class="form-control m-b col-lg-5" name="account">
                                    <option>Servidores</option>
                                    <option>Perifericos</option>
                                    <option>Tablets</option>
                                    <option>Computadoras de escritorio</option>
                                    <option value="">Impresoras</option>
                                    <option value="">Escaner</option>
                                </select>
                            </div>
                            <div class="row d-flex justify-content-between">
                                <select class="form-control m-b col-lg-5" name="account">
                                    <option>Sub familia</option>
                                    <option>Sub familia</option>
                                    <option>Sub familia</option>
                                    <option>Sub familia</option>
                                    <option value="">Sub familia</option>
                                    <option value="">Sub familia</option>
                                </select>
                                <select class="form-control m-b col-lg-5" name="account">
                                    <option>HP</option>
                                    <option>Samsung</option>
                                    <option>Lenovo</option>
                                    <option>LG</option>
                                    <option value="">sonic</option>
                                    <option value="">Dell</option>
                                </select>
                            </div>
                            <div class="row pb-5 border border-primary border-left-0 border-right-0 border-top-0">
                                <input type="text" placeholder="Nombre del Producto" class="form-control mt-2">
                                <textarea name="" id="" placeholder="Descripción del Producto" class="form-control mt-2" style="height: 100px;"></textarea>
                            </div>

                            <!--Segunda parte de la primera columna-->
                            <div class="row d-flex justify-content-between pt-5">
                                <!-- Descuento 1 -->
                                <div class="form-group col-xl-4 col-md-6">
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                        <input type="text" placeholder="Desct.1" class="form-control">
                                    </div>
                                </div>
                                <!-- Descuento 2 -->
                                <div class="form-group col-xl-4 col-md-6">
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                        <input type="text" placeholder="Desct.2:" class="form-control">
                                    </div>
                                </div>
                                <!-- Descuento Máximo -->
                                <div class="form-group col-xl-4">
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                        <input type="text" placeholder="Desct.Máx:" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-between">
                                <!-- Utilidad -->
                                <div class="form-group col-xl-5">
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                        <input type="text" placeholder="Utilidad:" class="form-control">
                                    </div>
                                </div>
                                <!-- Unidad de  medida -->
                                <div class="form-group col-xl-7 row">
                                    <label class="col-xl-5 col-form-label">Un.de Medida:</label>
                                    <div class="input-group m-b col-xl-7">
                                        <select class="form-control m-b" name="account">
                                            <option>Bolsa</option>
                                            <option>Gravado - Retiro</option>
                                            <option>Gravado - IVAP</option>
                                            <option>Inafecto - Retiro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-between">
                                <!-- Peso -->
                                <div class="form-group col-xl-6 row">
                                    <label class="col-xl-3 col-form-label">Peso:</label>
                                    <div class="input-group m-b col-xl-9">
                                        <div class="input-group-prepend">
                                            <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button" aria-expanded="false">Action </button>
                                            <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; top: 35px; left: 0px; will-change: top, left;">
                                                <li><a href="#">Gramo</a></li>
                                                <li><a href="#">Kg</a></li>
                                                <li><a href="#">Pixeles</a></li>
                                            </ul>
                                        </div>
                                        <input type="number" class="form-control">
                                    </div>
                                </div>
                                <!-- Garantía -->
                                <div class="form-group col-xl-6 row">
                                    <label class="col-xl-4 col-form-label">Garantía: </label>
                                    <div class="input-group m-b col-xl-8">
                                        <input type="text" placeholder="" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!--Segunda columna-->
                        <div class="col-md-5 col-lg-6 col-xl-6 align-content-center align-items-center px-5">
                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Stock Mínimo: </label>
                                        <div class="input-group m-b col-sm-9">
                                            <input type="text" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Stock Máximo: </label>
                                        <div class="input-group m-b col-sm-9">
                                            <input type="text" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Afectación:</label>
                                        <div class="input-group m-b col-sm-9">
                                            <select class="form-control m-b" name="account">
                                                <option>Gravado - Operación Onerosa</option>
                                                <option>Gravado - Retiro</option>
                                                <option>Gravado - IVAP</option>
                                                <option>Inafecto - Retiro</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Fecha de creación:</label>
                                        <div class="input-group m-b col-sm-9">
                                            <input type="text" placeholder="20/08/2024" class="form-control bg-primary-subtle" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Ficha:</label>
                                        <div class="input-group m-b col-sm-9">
                                            <div class="custom-file">
                                                <input id="inputGroupFile01" type="file" class="custom-file-input">
                                                <label class="custom-file-label" for="inputGroupFile01"></label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xl-4 d-flex justify-content-center align-items-center">
                                    <p>
                                        <a href=""><img src="{{ asset('img/logos/producto.svg') }}" alt="" class="img-size"></a>
                                    </p>
                                </div>
                                <button type="submit" class="btn btn-block btn-success mx-3">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>--}}

<!-- Modal EditarProducto - 29/05/2025 -->
<div id="EditProducto" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="TituloProducto">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
             <form action="">
            <div class="modal-header d-flex align-items-center">
                <h2 class="model-title" id="TituloProducto"><b>Editar Producto</b></h2>
                <input type="checkbox" class="js-switch" id="edit_estado_id" name="edit_estado_id" {{ $producto->estado_id == 1 ? 'checked' : '' }}>
            </div>
            <div class="modal-body p-3">
                <div class="scroll_content p-4">

                        <div class="form-group row">
                            <label for="" class="col-form-label col-sm-2 col-lg-1">Nombre<span class="text-danger">*</span></label>
                            <div class="col-sm-10  col-lg-11">
                                <input type="text" class="form-control" id="edit_nombre" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Código<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="edit_codigo" value="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-3">Cod. Original<span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="edit_codigo_original" value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Marca<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        {{--<select class="form-control" id="edit_marca">
                                            <option value="Lenovo">Lenovo</option>
                                            <option value="LG">LG</option>
                                            <option value="Samsung">Samsung</option>
                                        </select>--}}
                                        <select class="form-control" id="edit_marca" required>
                                            @foreach($marcas as $marca)
                                                <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-sm-2 col-md-12 col-lg-3">Peso<span class="text-danger">*</span></label>
                                    <div class="col-sm-10 col-md-12 col-lg-9">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" id="edit_peso_cantidad" step="0.01" min="0" value="" required>
                                            </div>
                                            <div class="col-sm-6">
                                                 <select class="form-control" name="peso_unidad" id="edit_peso_unidad">
                                                    <option value="Kilos">Kilos</option>
                                                    <option value="Litros">Litros</option>
                                                    <option value="Gramos">Gramos</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-sm-2 col-md-3">Origen<span class="text-danger">*</span></label>
                                    <div class="col-sm-10 col-md-9">
                                        {{--  <select name="" class="form-control" id="edit_origen" >
                                            <option value="">Producto Importado</option>
                                            <option value="">Producto Importado</option>
                                        </select>--}}
                                        <input type="text" class="form-control" id="edit_origen" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-sm-2 col-md-3">Stock<span class="text-danger">*</span></label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="number" class="form-control" id="edit_stock" min="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- stock min y max --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Stock Mínimo<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id ="edit_stock_minimo" min="1" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Stock Máximo<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id="edit_stock_maximo" min="1" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- descuento 1 y 2 --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Descuento 1<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id ="edit_descuento_1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Descuento 2<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id="edit_descuento_2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- descuento max y utilidad--}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Descuento Max.<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id ="edit_descuento_max">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Utilidad<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id ="edit_utilidad">
                                    </div>

                                    <style>.fa-question-circle:hover{color: blue;}</style>
                                    <div class="col-lg-8">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" id="sumando" class="form-control input_valor_numerico" name="utilidad" required="required" value="{{$producto->utilidad}}">
                                        </div>
                                    </div>

                                </div>
                            </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-3 col-lg-2">Unidad<span class="text-danger">*</span></label>
                                    <div class="col-md-9 col-lg-10">
                                        {{--<select name="" id="edit_unidad" class="form-control">
                                            <option value="NIU">(NIU) Unidad</option>
                                            <option value="Unidad">Unidad</option>
                                        </select>--}}
                                        <select name="" id="edit_unidad_medida" class="form-control" required>
                                            @foreach($unidad_medidas as $unidad)
                                                <option value="{{ $unidad->id }}">{{ $unidad->medida }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-3">Garantía<span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="edit_garantia" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Familia<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        {{--  <select name="" id="" class="form-control">
                                            <option value="">Familia</option>
                                            <option value="">Familia</option>
                                        </select>--}}
                                        <select name="" id="edit_familia" class="form-control" required>
                                            @foreach($familias as $familia)
                                                <option value="{{ $familia->id }}">{{ $familia->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-3">SubFamilia<span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        {{--<select name="" id="" class="form-control">
                                            <option value="">SubFamilia</option>
                                            <option value="">SubFamilia</option>
                                        </select>--}}
                                        <select name="" id="edit_subfamilia" class="form-control" required>
                                            @foreach($subfamilias as $subfamilia)
                                                <option value="{{ $subfamilia->id }}">{{ $subfamilia->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-2">
                                <label for="" class="col-form-label">Precio de Venta<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-12 col-lg-10">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="input-group m-b">
                                            <div class="input-group-prepend">
                                                <select name="" id="" class="btn btn-white">
                                                    <option value="">S/.</option>
                                                    <option value="">$</option>
                                                </select>
                                            </div>
                                            <input type="number" class="form-control" id="edit_precio_venta" min="0.01" step="0.01" oninput="calcular_utilidad()">
                                        </div>
                                    </div>
                                    <div class="col-md-2"><i class="fa fa-question-circle"></i></div>
                                </div>
                                <div class="row m-1 bg-light d-flex align-items-center rounded-top rounded-bottom">
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Precio de compra<span class="text-danger">*</span></b></label>
                                            <input type="text" class="border-0 form-control input-s-lg"  placeholder="S/." id="precio_compra" oninput="calcular_utilidad()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            {{-- <label for="" class="col-form-label"><b>Utilidad %</b></label>
                                            <input type="text" class="form-control input-s-lg" data-mask="99.99 %" placeholder="%" id="edit_utilidad"> --}}
                                            <label for="" class="col-form-label"><b>Utilidad %</b></label>
                                            <input type="text" class="form-control input-s-lg" placeholder="%" id="edit_utilidad">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Utilidad S/.</b></label>
                                            <input type="text" class="form-control input-s-lg" data-mask=" S/. 999,999,999.99" placeholder="S/.">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group row mt-3">
                            <label for="" class="col-form-label col-md-2">Impuesto</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" value="IGV (18.00%)" min="0.01" step="0.01">
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label for="" class="col-form-label col-md-2">Ficha</label>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input id="logo" type="file" class="custom-file-input">
                                    <label for="logo" class="custom-file-label">Selecciona</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row d-flex align-items-center">
                            <label for="" class="col-form-label col-md-2">Imagen</label>
                            <div class="col-md-9 bg-light align-items-right">
                                <input type="file" id="archivoInput" name="avatar" onchange="return validarExt()">
                                <input name="avatar_respaldo" value="defecto_avatar.jpg" hidden>
                                <div id="visorArchivo" class="d-flex justify-content-center">
                                        <img id="fotoPrevia" name="foto"
                                        src="{{ asset('img/logos/imagen-subir1.svg') }}"
                                        class="img-fluid hover-zoom"
                                        style="padding: 10px; width: 30%;">
                                </div>
                            </div>
                        </div>
<!--
                                <div id="visorArchivo">
                                    <img style="padding: 20px; width: 50%;" class="img-fluid" src="{{ asset('img/logos/categoria.svg') }}">
                                </div>
                                -->
                            <!--
                            <div class="col-md-4">
                                <h2>Subir Imagen</h2>
                            </div>
                            -->
                        <div class="form-group row">
                            <label for="" class="col-form-label col-md-3 col-lg-2">Descripción</label>
                            <div class="col-md-9 col-lg-10">
                                <input type="text" class="form-control" id="edit_descripcion">
                            </div>
                        </div>


                        {{-- <div class="form-group row">
                            <label for="" class="col-form-label col-md-3">Ùltimo precio de compra</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" value="S/.100.00">
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary ml-3" value="Guardar">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal EditarProducto - 29/05/2025 -->

<!--NuevoProducto - 29/05/2025-->
<div id="NuevoProducto" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="TituloProducto">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="form-producto" action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            <div class="modal-header d-flex align-items-center">
                <h2 class="model-title" id="TituloProducto"><b style="font-weight: bold;">Nuevo Producto</b></h2>
                <input type="checkbox" class="js-switch-1" checked>
            </div>
            <div class="modal-body">

                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-form-label col-sm-2 col-lg-1">Nombre<span class="text-danger">*</span></label>
                        <div class="col-sm-10  col-lg-11">
                            <input type="text" class="form-control" placeholder="Nombre del Producto" required="required" data-toggle="tooltip" name="nombre" data-placement="top" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Código autogenerado -->
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Código<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input
                                    type="text"
                                    id=""
                                    class="form-control"
                                    readonly
                                    placeholder="Código generado automáticamente"
                                    >
                                    <input
                                    type="hidden"
                                    id="codigo_producto_display"
                                    class="form-control"
                                    readonly
                                    value="{{ old('codigo_producto', $codigoProdGenerado) }}"
                                    >
                                    <input
                                    type="hidden"
                                    name="codigo_producto"
                                    id="codigo_producto"
                                    value="{{ old('codigo_producto', $codigoProdGenerado) }}"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Código Original manual -->
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3">Cod. Original<span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input
                                        type="text"
                                        name="codigo_original"
                                        id="codigo_original"
                                        class="form-control @error('codigo_original') is-invalid @enderror"
                                        value="{{ old('codigo_original') }}"
                                        placeholder="Ingresa el código original"
                                        autocomplete="off"
                                    >
                                    @error('codigo_original')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                        {{-- <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-2">Código</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                        </div> --}}
                        {{-- <!-- Código editable -->
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Código</label>
                                <div class="col-lg-10">
                                    <input
                                    type="text"
                                    name="codigo_producto"
                                    id="codigo_producto"
                                    class="form-control"
                                    value="{{ old('codigo_producto') }}"
                                    >
                                </div>
                            </div>
                        </div> --}}
                    {{-- <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-2">Código</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-3">Cod. Original</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="" name="codigo_original" autocomplete="off">
                                </div>
                            </div>
                        </div> --}}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-2">Marca<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select id="marca_id" class="form-control marca_select2" name="marca_id" required>
                                        @foreach ( $marcas as $marca )
                                            <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-sm-2 col-md-12 col-lg-3">Peso<span class="text-danger">*</span></label>
                                <div class="col-sm-10 col-md-12 col-lg-9">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" name="peso" required="required" step="0.01" min="0" value="2.5" autocomplete="off">
                                        </div>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="simbolo" id="">
                                                <option value="Kilos">Kilos</option>
                                                <option value="Litros">Litros</option>
                                                <option value="Gramos">Gramos</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="origen" class="col-form-label col-sm-2 col-md-3">Origen<span class="text-danger">*</span></label>
                                <div class="col-sm-10 col-md-9">
                                    <select name="origen" id="origen" class="form-control" required>
                                        <option value="Producto Importado">Producto Importado</option>
                                        <option value="Producto Nacional">Producto Nacional</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-sm-2 col-md-3">Stock</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="number" class="form-control" min="1">
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-4">Stock Mínimo<span class="text-danger">*</span></label>
                                <div class="col-lg-8">
                                    <input type="number" class="form-control" name="stock_minimo" min="1" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-4">Stock Máximo<span class="text-danger">*</span></label>
                                <div class="col-lg-8">
                                    <input type="number" class="form-control" name="stock_maximo" min="1" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-md-3 col-lg-2">Unidad<span class="text-danger">*</span></label>
                                <div class="col-md-9 col-lg-10">
                                    <select name="unidad_medida_id" required class="form-control">
                                        @foreach ($unidad_medidas as $unidad_medida)
                                            <option value="{{ $unidad_medida->id }}">{{ $unidad_medida->medida }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-md-3">Garantía<span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="garantia" value="12 meses" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-2">Familia<span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select name="familia_id" id="familia_id_sl" required="required" class="form-control familia_select2" onchange="list_subfamilia()">
                                        <option value=""></option>
                                        @foreach ($familias as $familia)
                                            <option value="{{ $familia->id }}">{{ $familia->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-lg-3">SubFamilia<span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select class="form-control subfamilia_select2" name="sub_familia_id">
                                        @foreach ( $subfamilias as $subfamilia )
                                            <option value="{{ $subfamilia->id }}">{{ $subfamilia->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal NuevoProducto - 29/05/2025 -->

{{--
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
            min-height: 90px;
            min-width: 90px;
            max-height: 90px;
            max-width: 90px;
        }
    }
    @media(min-width:740px){
        .img-size{
            min-height: 130px;
            min-width: 130px;
            max-height: 130px;
            max-width: 130px;
        }
    }
    @media(min-width:1440px){
        .img-size{
            min-height: 200px;
            min-width: 200px;
            max-height: 200px;
            max-width: 200px;
        }
    }
</style>
--}}

<style>
  .form-control{
    border-radius: 5px;
  }
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
  .fa-question-circle:hover{color: blue;}
  .select2.select2-container.select2-container--default{
    width: 100% !important;
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

#visorArchivo {
  width: 100%;
  height: auto;
  min-height: 250px;
  padding: 10px;
  background-color: #f8f9fa;
  border: 2px solid #ced4da;
  border-radius: 6px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;

}

#visorArchivo img[name="foto"] {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
  transition: transform 0.3s ease-in-out;
}

.hover-zoom {
  transition: transform 0.3s ease-in-out;
  cursor: pointer;
}

.hover-zoom:hover {
  transform: scale(1.2, 1.4); /
}
</style>



{{-- <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script> --}}

{{-- <!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script> --}}

<!-- Switchery -->
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

 <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

 <style>
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
    content: "Sel.";
  }
  .select2-selection.select2-selection--single{
    text-align: justify !important;
  }

  .select2-container .select2-dropdown {
  z-index: 20000 !important;
}

 </style>

{{-- <!-- Jasny -->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">

<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
<!-- Input Mask -->
<script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>

<!-- DROPZONE -->
<script src="{{ asset('js/plugins/dropzone/dropzone.js') }}"></script>

<!-- CodeMirror -->
<script src="{{ asset('js/plugins/codemirror/codemirror.js') }}"></script>
<script src="{{ asset('js/plugins/codemirror/mode/xml/xml.js') }}"></script> --}}


<script>
    $(document).ready(function() {
        var elem = document.querySelector('#edit_estado_id');
        if (elem) {
            var switchery = new Switchery(elem, { color: '#2776ea' });
            $('<input>').attr({
                type: 'hidden',
                name: 'estado_id',
                value: elem.checked ? '1' : '2'
            }).insertAfter(elem);

            elem.addEventListener('change', function() {
                $('input[name="estado_id"]').val(this.checked ? '1' : '2');
            });
        }

        var elem1 = document.querySelector('.js-switch-1');
        if (elem1) {
            var switchery1 = new Switchery(elem1, { color: '#2776ea' });
            $('<input>').attr({
                type: 'hidden',
                name: 'estado_producto_store',
                value: elem1.checked ? '1' : '2'
            }).insertAfter(elem1);
            elem1.addEventListener('change', function() {
                $('input[name="estado_producto_store"]').val(this.checked ? '1' : '2');
            });
        }

        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>

<script>
function calcular_utilidad(){
    var precio_venta = document.getElementById("edit_precio_venta").value;
    var precio_compra = document.getElementById("precio_compra").value;

    if (!isNaN(precio_venta) && !isNaN(precio_compra) && precio_venta !== "" && precio_compra !== "") {
        var a1 = parseFloat(precio_venta) * 100;
        var a2 = parseFloat(a1) / parseFloat(precio_compra);
        var utilidad = parseFloat(a2) - 100;
        // document.getElementById("edit_utilidad").value = utilidad.toFixed(2);
        document.getElementById("edit_utilidad").value = utilidad;
    } else {
        document.getElementById("edit_utilidad").value = "";
    }
}
</script>
{{-- foto --}}
<script type="text/javascript">
  $('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
  });

 $(document).ready(function(){
  $('.familia_select2').select2({ placeholder: "Seleccionar" });
  $('.subfamilia_select2').select2({ placeholder: "Seleccionar" });
  $('.marca_select2').select2();
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

//  agrandar la imagen

function validarExt() {
  var archivoInput = document.getElementById('archivoInput');
  var archivoRuta = archivoInput.value;
  var extPermitidas = /(.jpg|.png|.jfif)$/i;

  if (!extPermitidas.exec(archivoRuta)) {
    alert('Asegúrese de haber seleccionado una imagen válida (.jpg, .png, .jfif)');
    archivoInput.value = '';
    return false;
  }

  if (archivoInput.files && archivoInput.files[0]) {
    var visor = new FileReader();
    visor.onload = function(e) {
      var img = document.getElementById('fotoPrevia');
      img.onload = function () {
        const esHorizontal = img.naturalWidth > img.naturalHeight;

        if (esHorizontal) {
          // Si es horizontal, se ajusta a mayor ancho
          img.style.width = "70%";
          img.style.height = "auto";
        } else {
          // Si es vertical, se prioriza altura
          img.style.height = "250px";
          img.style.width = "auto";
        }
      };
      img.src = e.target.result;
    };
    visor.readAsDataURL(archivoInput.files[0]);
  }
}

//   function calcular_utilidad(){
//     var precio_venta = document.getElementById("precio_venta").value;
//     var precio_compra = document.getElementById("precio_compra").value;

//     if (!isNaN(precio_venta) || !isNaN(precio_compra) ) {
//       // var utilidad = (parseFloat(precio_compra)/100) * parseFloat(precio_venta);
//       var a1 =  parseFloat(precio_venta) * 100;
//       var a2 = parseFloat(a1) / parseFloat(precio_compra);
//       var utilidad = parseFloat(a2) - 100;
//       document.getElementById("sumando").value = utilidad;
//     }
//   }

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
<script>
    $(function(){
        $('.marca_select2').select2({ placeholder: 'Selecciona una marca' });

        function actualizarCodigo(marcaId) {
            if (!marcaId) {
            $('#codigo_producto_display, #codigo_producto').val('');
            return;
            }
            $.post(
            '{{ route("productos.generateCodigoProducto") }}',
            {
                _token: '{{ csrf_token() }}',
                marca_id: marcaId
            }
            ).done(function(res){
            $('#codigo_producto_display').val(res.codigo_producto);
            $('#codigo_producto').val(res.codigo_producto);
            }).fail(function(err){
            console.error('no pudo generar el código', err);
            });
        }

        $('#marca_id')
            .on('change select2:select', function(){
            actualizarCodigo($(this).val());
            })
            .trigger('change');
    });




</script>






{{--
@endsection--}}
