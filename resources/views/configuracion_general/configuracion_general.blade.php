 @extends('layout')

 @section('title', 'Configuración Sistema')
 @section('atributo_actu', 'hidden')
 @section('atributo_1', 'hidden')

 @section('content')

 @php
use App\Categoria;
$categorias = Categoria::get();

use App\Familia;
$familias = Familia::get();

use App\Garantia;
$garantia = Garantia::get();

use App\Marca;
$marcas=Marca::get();

use App\Motivo;
$motivos_compra=Motivo::get();
$motivos_dev=Motivo::get();

use App\TipoCambio;
$tipo_cambio=TipoCambio::get();

use App\Unidad_medida;
$unidad_de_medida=Unidad_medida::get();

use App\Validez;
$validez=Validez::get();
@endphp

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content d-flex justify-content-center">
                    <div class="row d-flex justify-content-between p-4">
                        <!-- Elementos de la fila -->
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button" >
                                <a href="{{ route('almacen.index') }}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/almacen.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">ALMACÉN</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('apariencia.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/apariencia.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">APARIENCIA</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <!--
                                <a href="{{route('categoria.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/categoria.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">CATEGORÍAS</p>
                                </a>-->
                                <a data-toggle="modal" href="#modal-forms5">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/categoria.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">CATEGORÍAS</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <!--
                                <a href="{{route('familia.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/familia.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">FAMILIAS</p>
                                </a>-->
                                <a data-toggle="modal" href="#modal-forms6">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/familia.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">FAMILIAS</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <!--
                                <a href="{{route('garantia.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/garantia.png')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">GARANTÍA</p>
                                </a>-->
                                <a data-toggle="modal" href="#modal-forms4">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/garantia.png')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">GARANTÍA</p>
                                </a>
                            </button>
                        </div>

                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <!--
                                <a href="{{route('marca.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/marca.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">MARCAS</p>
                                </a>-->
                                <a data-toggle="modal" href="#modal-forms7">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/marca.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">MARCAS</p>
                                </a>
                            </button>
                        </div>

                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <!--
                                <a href="{{route('motivo.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/motivo.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">MOTIVO</p>
                                </a>-->
                                <a data-toggle="modal" href="#modal-forms3">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/motivo.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">MOTIVOS</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <!--
                                <a href="{{route('tipo_cambio.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/tipo-cambio.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">TIPO CAMBIO</p>
                                </a>-->
                                <a data-toggle="modal" href="#modal-forms">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/tipo-cambio.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">TIPO CAMBIO</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <!--
                                <a href="{{route('unidad-medida.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/unidad_medida.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">U. DE MEDIDA</p>
                                </a>-->
                                <a data-toggle="modal" href="#modal-forms2">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/unidad_medida.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">U.DE MEDIDA</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('usuarios.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/usuarios.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">USUARIOS</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                               <!-- <a href="{{route('validez.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/validez.png')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">VALIDEZ</p>
                                </a>-->
                                <a data-toggle="modal" href="#modal-forms8">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/validez.png')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">VALIDEZ</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <!-- ELEMENTO FANTASMA - RELLENO -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal - Tipo de Cambio-->
<div id="modal-forms" class="modal fade" style="display: none;" aria-hidden="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Tipo de Cambio</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row">
                        <div class="col-10">
                            <select class="form-control m-b" name="account">
                                <option>Dolar</option>
                                <option>Sol</option>
                            </select>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <input type="text" disabled="" placeholder="Venta: 3.74" class="form-control m-b">
                        <input type="text" disabled="" placeholder="Compra: 3.75" class="form-control">
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Paralelo Compra: 3.69" class="form-control m-b">
                    </div>
                </div>
                <hr>
                <!--Buscar y tabla-->
                <div class="col-12 mb-3">
                    <div class=" input-group row">
                        <input class="form-control" type="text" name="daterangecambio" value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                        <span class="input-group-append">
                            <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                <i class="fa fa-history"></i>
                            </button>
                        </span>
                        <span class="input-group-append">
                            <button type="button" class="btn btn-primary" style="background-color:blue; border-color:blue;" onclick="limpiar_select()">
                                <i class="fa fa-eraser"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="table-responsive p-2">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center dataTables-cambio12">
                        <thead>
                            <tr>
                                <th>Compra</th>
                                <th>Venta</th>
                                <th>Paralelo C.</th>
                                <th>Fecha Actualización</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tipo_cambio as $tipo_cambios)
                            <tr>
                                <td>{{$tipo_cambios->compra}}</td>
                                <td>{{$tipo_cambios->venta}}</td>
                                <td>{{$tipo_cambios->paralelo}}</td>
                                <td>{{$tipo_cambios->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal - Unidad de medida -->
<div id="modal-forms2" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel2">Unidad de Medida</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row">
                        <div class="col-5">
                            <select class="form-control m-b" name="account">
                                <option>Bolsa</option>
                                <option>Kilogramos</option>
                                <option>Litros</option>
                                <option>option 4</option>
                            </select>
                        </div>
                        <div class="col-5">
                            <input type="text" placeholder="Símbolo: BOL" class="form-control m-b">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Unidad: 12" class="form-control">
                    </div>
                    <div class="col-6">
                        <input type="text" disabled="" placeholder="Fecha Actualización: 12-03-1997" class="form-control">
                    </div>
                </div>
                <hr>
                <!--Fecha, Buscar y tabla-->
                <div class="row mb-3">
                    <div class="input-group col-6">
                        <input class="form-control col-sm-10" type="text" name="daterangecambio" value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                        <span class="input-group-append">
                            <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                <i class="fa fa-history"></i>
                            </button>
                        </span>
                        <span class="input-group-append">
                            <button type="button" class="btn btn-primary" style="background-color:blue; border-color:blue;" onclick="limpiar_select()">
                                <i class="fa fa-eraser"></i>
                            </button>
                        </span>
                    </div>
                    <div class="input-group col-6">
                        <div class="col-4">
                            <label for="inputBuscar" class="col-form-label">Buscar:</label>
                         </div>
                        <div class="col-md-8">
                            <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                </div>
                <div class="row px-2 py-3 bg-light m-1 table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center dataTables-medida">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Símbolo</th>
                                <th style="width: 20%;">Medida</th>
                                <th style="width: 20%;">Unidad</th>
                                <th style="width: 30%;">Fecha Creación</th>
                                <th style="width: 30%;">Fecha Actualización</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unidad_de_medida as $u_medida)
                            <tr>
                                <td>{{$u_medida->simbolo}}</td>
                                <td>{{$u_medida->medida}}</td>
                                <td>{{$u_medida->unidad}}</td>
                                <td>{{$u_medida->created_at}}</td>
                                <td>{{$u_medida->updated_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal - Motivos -->
<div id="modal-forms3" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel3">Motivos</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row mb-3">
                        <div class="col-10">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Nombre: Compras locales" class="form-control m-b">
                    </div>
                    <div class="col-6">
                        <select class="form-control m-b" name="account">
                            <option>Compras</option>
                            <option>Ventas</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs active show" role="tablist">
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1"> Entradas

                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-2"> Salidas

                                </a>
                            </li>
                        </ul>

                        <!-- Tablas y su contenido -->
                        <div class="tab-content" >
                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body table-responsive">

                                    <div class="col-12 input-group row">
                                        <input class="col-lg-12 form-control" type="text" name="daterangemotivos1" value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                                <i class="fa fa-history"></i>
                                            </button>
                                        </span>
                                        <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" style="background-color:blue; border-color:blue;" onclick="limpiar_select()">
                                            <i class="fa fa-eraser"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <br>

                                    <table class="table table-striped text-md-center dataTables-motivos1">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Fecha de Modificación</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach ($motivos_compra as $m_compras)
                                            <tr>
                                            <td>{{$m_compras->nombre}}</td>
                                            <td>{{ \Carbon\Carbon::parse($m_compras->updated_at)->format('d/m/Y H:i:s')}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body table-responsive ">
                                    <div class="col-12 input-group row">
                                        <input class="col-lg-12 form-control" type="text" name="daterangemotivos2" value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                                <i class="fa fa-history"></i>
                                            </button>
                                        </span>
                                        <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" style="background-color:blue; border-color:blue;" onclick="limpiar_select()">
                                            <i class="fa fa-eraser"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <br>

                                    <table class="table table-striped text-md-center dataTables-motivos2">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Fecha de Modificación</th>
                                            </tr>
                                        </thead>
                                        @foreach ($motivos_dev as $m_devol)
                                        <tbody>
                                            <tr>
                                            <td>{{$m_devol->nombre}}</td>
                                            <td>{{ \Carbon\Carbon::parse($m_devol->updated_at)->format('d/m/Y H:i:s')}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal - Garantía-->
<div id="modal-forms4" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel4">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel4">Garantía</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row mb-3">
                        <div class="col-10">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <select class="form-control" name="account">
                            <option>Extendida</option>
                            <option>Anual</option>
                            <option>option 3</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Duración: 3 meses" class="form-control m-b">
                    </div>
                </div>
                <hr>
                <!--Buscar y tabla-->
                <div class="row mb-3">
                    <div class="col-12 input-group row">
                        <label class="col-md-2 col-sm-3 col-form-label">Buscar:</label>
                        <input type="text" class="form-control col-md-9 col-sm-8">
                    </div>
                </div>
                <div class="row bg-light table-responsive pt-3">
                    <table class="col-12 table table-striped text-md-center dataTables-garantia">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Duración</th>
                            </tr>
                        </thead>
                            <span hidden="hidden">{{$i=1}}</span>
                            @foreach($garantia as $garantias)
                        <tbody>
                            <tr>
                            <td>{{$garantias->descripcion}}</td>
                            <td style="color: red;">5 años</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal - Categorías -->
<div id="modal-forms5" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel5">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel5">Categorías</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-6">
                        <select class="form-control" name="account">
                            <option>Servicios</option>
                            <option>Productos</option>
                            <option>Ventas</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Código: 0001" class="form-control m-b">
                    </div>
                    <div class="col-12 row">
                        <div class="col-10">
                            <input type="text" placeholder="Descripción:" class="form-control">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                </div>
                <hr>
                <!--Buscar y tabla-->
                <div class="row mb-3">
                    <div class="col-12 input-group">
                        <label class="col-md-2 col-sm-3 col-form-label">Buscar:</label>
                        <input type="text" class="form-control col-md-9 col-sm-8">
                    </div>
                </div>
                <div class="row bg-light p-3 m-1 table-responsive">
                    <table class="table table-striped text-md-center dataTables-categorias">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorias as $categoria)
                            <tr>
                                <td>{{$categoria->codigo}}</td>
                                <td>{{$categoria->descripcion}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal - Familias -->
<div id="modal-forms6" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel6">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel6">Familias</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row">
                        <div class="col-4">
                            <input type="text" disabled placeholder="Código: 003" class="form-control m-b">
                        </div>
                        <div class="col-6">
                            <input type="text" placeholder="Padre: Utencilios" class="form-control m-b">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <div class="col-4">
                        <input type="text" placeholder="Ubicación: A12" class="form-control">
                    </div>
                    <div class="col-8">
                        <input type="text" placeholder="Descripción: Sartén Antiaderente" class="form-control">
                    </div>
                </div>
                <hr>
                <!--Fecha, Buscar y tabla-->
                <div class="row mb-3">
                    <div class="col-12 input-group">
                        <label class="col-md-2 col-sm-3 col-form-label">Buscar:</label>
                        <input type="text" class="form-control col-md-8 col-sm-8">
                    </div>
                </div><!--
                <div class="row">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Buscar:</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="" class="form-control m-b">
                        </div>
                    </div>
                </div>-->
                <div class="row px-2 py-3 bg-light m-1 table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center dataTables-familias">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Código</th>
                                <th style="width: 35%;">Descripción</th>
                                <th style="width: 15%;">Ubicación</th>
                                <th style="width: 20%;">Cantidad de SubFamilias</th>
                                <th style="width: 10%;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            use App\Subfamilia;
                            @endphp
                            <span hidden="hidden">{{$i=1}}</span>
                            @foreach($familias as $familia)
                            <tr>
                            <td>{{$familia->codigo}}</td>
                            <td>{{$familia->descripcion}}</td>
                            <td>@if($familia->ubicacion != null)
                                    {{$familia->ubicacion}}
                                @else
                                    Sin Ubicacion
                                @endif
                            </td>
                            <td>{{ $count_sub = Subfamilia::where('id_familia', $familia->id)->count()}}</td>
                            <td>
                            <a href="{{route('familia.show',$familia->id)}}">
                                <button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button>
                            </a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal - Marcas -->
<div id="modal-forms7" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel7">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel7">Marcas</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row">
                        <!--
                        <div class="col-5">
                            <select class="form-control m-b" name="account">
                                <option>Bolsa</option>
                                <option>Kilogramos</option>
                                <option>Litros</option>
                                <option>option 4</option>
                            </select>
                        </div>-->
                        <div class="col-10">
                            <input type="text" placeholder="Descripción: Empresa especializada en la creación de..." class="form-control m-b">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Nombre: Epson" class="form-control m-b">
                        <input type="text" placeholder="Teléfono: 981273890" class="form-control">
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Empresa: Epson Perú" class="form-control m-b">
                        <div class="row">
                            <div class="col-sm-7">
                                <input type="text" placeholder="Abreviatura: EP" class="form-control">
                            </div>
                            <div class="col-sm-5">
                                <!--<input type="text" placeholder="Foto" class="form-control">
                                <form action="#" class="dropzone" id="dropzoneForm">
                                    <div class="fallback">
                                        <input name="file" placeholder="Foto" type="file" multiple />
                                    </div>
                                </form>-->
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input id="inputGroupFile01" type="file" class="custom-file-input">
                                        <label class="custom-file-label" for="inputGroupFile01">Foto</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <!--Fecha, Buscar y tabla-->
                <div class="row mb-3 mx-1">
                    <div class="col-12 input-group row">
                        <label class="col-sm-2 col-form-label">Buscar:</label>
                        <input class="form-control col-sm-8" type="text" name="">
                    </div>
                </div>
                <div class="row px-2 py-3 bg-light m-1 table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center dataTables-marcas">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Nombre</th>
                                <th style="width: 5%;">Abreviatura</th>
                                <th style="width: 20%;">Teléfono</th>
                                <th style="width: 40%;">Descripción</th>
                                <th style="width: 20%;">Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($marcas as $marca)
                            <tr>
                                <td>{{$marca->nombre}}</td>
                                <td>{{$marca->abreviatura}}</td>
                                <td>@if($marca->telefono != null)
                                    {{$marca->telefono}}
                                @else
                                    Sin número
                                @endif
                                </td>
                                <td>{{$marca->descripcion}}</td>
                                <td>
                                @if(isset($marca->imagen))
                                <img name="imagen" src="{{asset('archivos/imagenes/marcas/'.$marca->imagen)}}" width="80px" height="80px"   />
                                @else
                                <img src="{{asset('img/logos/marca_ejemplo.svg')}}" width="80px">
                                @endif </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal - Validez -->
<div id="modal-forms8" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel7">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel7">Validez</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row">
                        <div class="col-10">
                            <input type="text" placeholder="Descripción: Tiempo ..." class="form-control m-b">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button" style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                </div>
                <hr>
                <!--Fecha, Buscar y tabla-->
                <div class="row mb-3">
                    <div class="col-12 input-group">
                        <label class="col-sm-2 col-form-label">Buscar:</label>
                        <input class="form-control col-sm-8" type="text" name="">
                    </div>
                </div>
                <div class="table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center dataTables-validez">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                        <span hidden="hidden">{{$i=1}}</span>
                        @foreach($validez as $validezz)
                            <tr>
                            <td>{{$validezz->id}}</td>
                            <td>{{$validezz->descripcion}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- fin código Gaby-->


<!--
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>Tema</th>
                                    <th>Tipo de configuración</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/almacen.svg')}}" width="20px" alt=""></td>
                                    <td>Almacén</td>
                                    <td><a class="btn btn-primary" href="{{ route('almacen.index') }}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/apariencia.svg')}}" width="20px" alt=""></td>
                                    <td>Apariencia</td>
                                    <td><a class="btn btn-primary" href="{{route('apariencia.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/categoria.svg')}}" width="20px" alt=""></td>
                                    <td>Categorías</td>
                                    <td><a class="btn btn-primary" href="{{route('categoria.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/familia.svg')}}" width="20px" alt=""></td>
                                    <td>Familias</td>
                                    <td><a class="btn btn-primary" href="{{route('familia.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                 <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/garantia.png')}}" width="20px" alt=""></td>
                                    <td>Garantia</td>
                                    <td><a class="btn btn-primary" href="{{route('garantia.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/marca.svg')}}" width="20px" alt=""></td>
                                    <td>Marcas</td>
                                    <td><a class="btn btn-primary" href="{{route('marca.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/motivo.svg')}}" width="20px" alt=""></td>
                                    <td>Motivo</td>
                                    <td><a class="btn btn-primary" href="{{route('motivo.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/tipo-cambio.svg')}}" width="20px" alt=""></td>
                                    <td>Tipo de Cambio</td>
                                    <td><a class="btn btn-primary" href="{{route('tipo_cambio.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/unidad_medida.svg')}}" width="20px" alt=""></td>
                                    <td>Unidades de Medidas</td>
                                    <td><a class="btn btn-primary" href="{{route('unidad-medida.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/usuarios.svg')}}" width="20px" alt=""></td>
                                    <td>Usuarios</td>
                                    <td><a class="btn btn-primary" href="{{route('usuarios.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                 <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/validez.png')}}" width="20px" alt=""></td>
                                    <td>Validez</td>
                                    <td><a class="btn btn-primary" href="{{route('validez.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                {{-- <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/backup_mail.svg')}}" width="20px" alt=""></td>
                                    <td>Backup de Email</td>
                                    <td><a class="btn btn-primary" href="{{route('email_backup')}}"><i class="fa fa-gear"></i></a></td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ asset('js/plugins/jqueryMask/jquery.mask.min.js') }}"></script>
<script src="{{asset('js/plugins/jsKnob/jquery.knob.js')}}"></script>
<script src="{{asset('js/plugins/nouslider/jquery.nouislider.min.js')}}"></script>
<script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>
<script src="{{asset('js/plugins/ionRangeSlider/ion.rangeSlider.min.js')}}"></script>
<script src="{{asset('js/plugins/colorpicker/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{asset('js/plugins/clockpicker/clockpicker.js')}}"></script>
<script src="{{asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<script src="{{asset('js/plugins/dualListbox/jquery.bootstrap-duallistbox.js')}}"></script>
<script src="{{asset('js/plugins/cropper/cropper.min.js')}}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<!-- Chosen -->
<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>

<!-- Data picker -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<style>
    /* OCULTANDO LO DE ORGANIZAR*/
        /* Ver (números) */
        div.dataTables_length {
            display: none;
        }

        /* El Buscar */
        div.dataTables_filter {
            display: none;
        }

        /* CSV, Excel, PDF, Print */
        div.dt-buttons {
            display: none;
        }
        /* Tamaño de los botones del index */
        .tam{
        min-width: 150px;
        min-height: 150px;*/
        }
</style>

<script>
    $(document).ready(function(){
        $('.dataTables-categorias').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.dataTables-marcas').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.dataTables-familias').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.dataTables-garantia').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [  ]
    });
    });
</script>

<script>
    $(document).ready(function(){
        table1 = $('.dataTables-motivos1').DataTable({
            pageLength: 12,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

            ]

        });
        $('input[name="daterangemotivos1"]').daterangepicker({

                    "locale": {
                        "separator": " | ",
                        "applyLabel": "Guardar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Custom",
                        "daysOfWeek": [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    }
                },
                function(start, end, label) {
                    var dates = [];
                    var currentDate = new Date(start);
                    while (currentDate <= end) {
                        var day = ('0' + currentDate.getDate()).slice(-2);
                        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                        var year = currentDate.getFullYear();

                        var formattedDate = day + '-' + month + '-' + year;
                        dates.push(formattedDate);

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    var dateRangeString = dates.join('|');
                    console.log(dateRangeString);
                    table1.column(2).search(dateRangeString, true, false).draw();
                }
            );
        });
        function limpiar_select(){
            table1.column(2).search("").draw();
        }
        function revert_select() {
            table1.column(2).search(`{{ date('m-Y') }}`).draw();
        }
    </script>

<script>
    $(document).ready(function(){
        table2 = $('.dataTables-motivos2').DataTable({
            pageLength: 12,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                 customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
                }
            ]

        });
        $('input[name="daterangemotivos2"]').daterangepicker({

                    "locale": {
                        "separator": " | ",
                        "applyLabel": "Guardar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Custom",
                        "daysOfWeek": [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    }
                },
                function(start, end, label) {
                    var dates = [];
                    var currentDate = new Date(start);
                    while (currentDate <= end) {
                        var day = ('0' + currentDate.getDate()).slice(-2);
                        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                        var year = currentDate.getFullYear();

                        var formattedDate = day + '-' + month + '-' + year;
                        dates.push(formattedDate);

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    var dateRangeString = dates.join('|');
                    console.log(dateRangeString);
                    table2.column(2).search(dateRangeString, true, false).draw();
                }
            );
        });
        function limpiar_select(){
            table2.column(2).search("").draw();
        }
        function revert_select() {
            table2.column(2).search(`{{ date('m-Y') }}`).draw();
        }
    </script>

<script>
    $(document).ready(function(){
        table3 = $('.dataTables-cambio12').DataTable({
            pageLength: 12,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                 customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
                }
            ]

        });
        $('input[name="daterangecambio"]').daterangepicker({

                    "locale": {
                        "separator": " | ",
                        "applyLabel": "Guardar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Custom",
                        "daysOfWeek": [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    }
                },
                function(start, end, label) {
                    var dates = [];
                    var currentDate = new Date(start);
                    while (currentDate <= end) {
                        var day = ('0' + currentDate.getDate()).slice(-2);
                        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                        var year = currentDate.getFullYear();

                        var formattedDate = day + '-' + month + '-' + year;
                        dates.push(formattedDate);

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    var dateRangeString = dates.join('|');
                    console.log(dateRangeString);
                    table3.column(5).search(dateRangeString, true, false).draw();
                }
            );
    });

        function limpiar_select(){
            table3.column(5).search("").draw();
        }
        function revert_select() {
            table3.column(5).search(`{{ date('m-Y') }}`).draw();
        }
    </script>

<script>
    $(document).ready(function(){
        table4 = $('.dataTables-medida').DataTable({
            pageLength: 12,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                 customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
                }
            ]

        });
        $('input[name="daterangemedida"]').daterangepicker({

                    "locale": {
                        "separator": " | ",
                        "applyLabel": "Guardar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Custom",
                        "daysOfWeek": [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    }
                },
                function(start, end, label) {
                    var dates = [];
                    var currentDate = new Date(start);
                    while (currentDate <= end) {
                        var day = ('0' + currentDate.getDate()).slice(-2);
                        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                        var year = currentDate.getFullYear();

                        var formattedDate = day + '-' + month + '-' + year;
                        dates.push(formattedDate);

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    var dateRangeString = dates.join('|');
                    console.log(dateRangeString);
                    table4.column(5).search(dateRangeString, true, false).draw();
                }
            );
        });
        function limpiar_select(){
            table4.column(5).search("").draw();
        }
        function revert_select() {
            table4.column(5).search(`{{ date('m-Y') }}`).draw();
        }
</script>

<script>
    $(document).ready(function(){
        $('.dataTables-validez').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>

<style>
    .dropdown-menu {
        left: 70px;
        padding: 20px 0;
    }

    #DataTables_Table_0_wrapper {
        padding-right: 0px;
    }

    .table {
        width: 100% !important;
    }

    .ibox-content>.row {
        margin: auto;
    }
</style>

<script>
    $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

        });
</script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function() {
        table = $('.dataTables-example-facturacion').DataTable({
            pageLength: 10,
            order: [
                [0, "desc"]
            ],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            footerCallback: function(tr, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total filtered rows on the selected column (code part added)
                var sumCol4Filtered = display.map(el => data[el][5]).reduce((a, b) => intVal(a) +
                    intVal(b), 0);

                // Update footer
                $(api.column(5).footer()).html(
                    'S/ ' + Math.round(sumCol4Filtered * 100) / 100
                );
            },
            buttons: []
        });

        revert_select();

        $(document).on('change', '#select_tipo_coti', function(event) {
            var nombre = $("#select_tipo_coti option:selected").val();
            // console.log(nombre);
            table.column(11).search(nombre).draw();
        });
        $('input[name="daterange"]').daterangepicker({
                "locale": {
                    "separator": " | ",
                    "applyLabel": "Guardar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                }
            },
            function(start, end, label) {
                var dates = [];
                var currentDate = new Date(start);
                while (currentDate <= end) {
                    var day = ('0' + currentDate.getDate()).slice(-2);
                    var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                    var year = currentDate.getFullYear();

                    var formattedDate = day + '-' + month + '-' + year;
                    dates.push(formattedDate);

                    currentDate.setDate(currentDate.getDate() + 1);
                }
                var dateRangeString = dates.join('|');
                console.log(dateRangeString);
                table.column(4).search(dateRangeString, true, false).draw();
            }
        );
    });

    $(".select2_demo_1").select2();
    $(".select2_demo_2").select2();
    $(".select2_demo_3").select2({
        placeholder: "Tipo",
        allowClear: true
    });

    function limpiar_select() {
        table.column(4).search("").draw();
    }

    function revert_select() {
        table.column(4).search(`{{ date('m-Y') }}`).draw();
    }


</script>
@stop
