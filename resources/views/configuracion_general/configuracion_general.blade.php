 @extends('layout')

 @section('title', 'Configuración Sistema')
 @section('atributo_actu', 'hidden')
 @section('atributo_1', 'hidden')

 @section('content')

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
                                <a href="{{route('categoria.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/categoria.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">CATEGORÍAS</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('familia.index')}}">
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
                                <a href="{{route('marca.index')}}">
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
                                <a href="{{route('validez.index')}}">
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
    <div class="modal-dialog modal-dialog-centered">
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
                                <option>option 3</option>
                                <option>option 4</option>
                            </select>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button"><i class="fa fa-pencil"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button"><i class="fa fa-upload"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <input type="text" disabled="" placeholder="Venta: 3.74" class="form-control m-b">
                        <input type="text" disabled="" placeholder="Compra: 3.75" class="form-control">
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Paralelo Compra: 3.69" class="form-control m-b">
                        <input type="text" placeholder="Paralelo Venta: 3.75" class="form-control">
                    </div>
                </div>
                <hr>
                <!--Buscar y tabla-->
                <div class="row mb-3">
                    <div class="col-12 input-group row">
                        <label class="col-sm-2 col-form-label">Buscar:</label>
                        <input class="form-control col-sm-auto" type="text" name="daterange" value="01/01/2015 - 01/31/2015">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-secondary px-3"><i class="fa fa-history"></i></button>
                        </span>
                        <span class="input-group-append">
                            <button type="button" class="btn btn-primary px-3"><i class="fa fa-eraser"></i></button>
                        </span>
                    </div>
                </div>
                <div class="row p-2 bg-light m-1 table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center">
                        <thead>
                            <tr>
                                <th>Compra</th>
                                <th>Venta</th>
                                <th>Paralelo C.</th>
                                <th>Paralelo V.</th>
                                <th>Fecha Actualización</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3.74</td>
                                <td>3.75</td>
                                <td>3.69</td>
                                <td>3.75</td>
                                <td>Jul 14, 2013</td>
                            </tr>
                            <tr>
                                <td>3.74</td>
                                <td>3.75</td>
                                <td>3.69</td>
                                <td>3.75</td>
                                <td>Jul 14, 2013</td>
                            </tr>
                            <tr>
                                <td>3.74</td>
                                <td>3.75</td>
                                <td>3.69</td>
                                <td>3.75</td>
                                <td>Jul 14, 2013</td>
                            </tr>
                            <tr>
                                <td>3.74</td>
                                <td>3.75</td>
                                <td>3.69</td>
                                <td>3.75</td>
                                <td>Jul 14, 2013</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="btn-group btn-group-toggle mt-1" data-toggle="buttons">
                        <label class="btn btn-sm btn-white ">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Anterior
                        </label>
                        <label class="btn btn-sm btn-white active">
                            <input type="radio" name="options" id="option2" autocomplete="off"> 1
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option3" autocomplete="off"> 2
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option4" autocomplete="off"> 3
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option5" autocomplete="off"> 4
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option6" autocomplete="off"> Siguiente
                        </label>
                    </div>
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
                            <button class="btn btn-success btn-sm" type="button"><i class="fa fa-upload"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button"><i class="fa fa-pencil"></i></button>
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
                        <input class="form-control col-sm-10" type="text" name="daterange" value="01/01/2015 - 01/31/2015">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-secondary px-3"><i class="fa fa-history"></i></button>
                        </span>
                        <span class="input-group-append">
                            <button type="button" class="btn btn-primary px-3"><i class="fa fa-eraser"></i></button>
                        </span>
                    </div>
                    <div class="input-group col-6">
                        <label class="col-sm-3 col-form-label">Buscar:</label>
                        <input class="form-control col-sm-9" type="text" name="">
                    </div>
                </div>
                <div class="row px-2 py-3 bg-light m-1 table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center">
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
                            <tr>
                                <td>BOL</td>
                                <td>Bolsa</td>
                                <td>12</td>
                                <td>03-06-2010</td>
                                <td>29-12-2023</td>
                            </tr>
                            <tr>
                                <td>BOL</td>
                                <td>Bolsa</td>
                                <td>12</td>
                                <td>03-06-2010</td>
                                <td>29-12-2023</td>
                            </tr>
                            <tr>
                                <td>BOL</td>
                                <td>Bolsa</td>
                                <td>12</td>
                                <td>03-06-2010</td>
                                <td>29-12-2023</td>
                            </tr>
                            <tr>
                                <td>BOL</td>
                                <td>Bolsa</td>
                                <td>12</td>
                                <td>03-06-2010</td>
                                <td>29-12-2023</td>
                            </tr>
                            <tr>
                                <td>BOL</td>
                                <td>Bolsa</td>
                                <td>12</td>
                                <td>03-06-2010</td>
                                <td>29-12-2023</td>
                            </tr>
                            <tr>
                                <td>BOL</td>
                                <td>Bolsa</td>
                                <td>12</td>
                                <td>03-06-2010</td>
                                <td>29-12-2023</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="btn-group btn-group-toggle mt-1" data-toggle="buttons">
                        <label class="btn btn-sm btn-white ">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Anterior
                        </label>
                        <label class="btn btn-sm btn-white active">
                            <input type="radio" name="options" id="option2" autocomplete="off"> 1
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option3" autocomplete="off"> 2
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option4" autocomplete="off"> 3
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option5" autocomplete="off"> 4
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option6" autocomplete="off"> Siguiente
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal - Motivos -->
<div id="modal-forms3" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3">
    <div class="modal-dialog modal-dialog-centered">
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
                            <button class="btn btn-success btn-sm" type="button"><i class="fa fa-upload"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Nombre: Compras locales" class="form-control m-b">
                    </div>
                    <div class="col-6">
                        <select class="form-control m-b" name="account">
                            <option>Compras</option>
                            <option>Ventas</option>
                            <option>option 3</option>
                            <option>option 4</option>
                        </select>
                    </div>
                </div>
                <hr>
                <!--Buscar y tabla-->
                <div class="row mb-3">
                    <div class="col-12 input-group row">
                        <label class="col-sm-2 col-form-label">Buscar:</label>
                        <input class="form-control col-sm-10" type="text" name="daterange" value="01/01/2015 - 01/31/2015">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-secondary px-3"><i class="fa fa-history"></i></button>
                        </span>
                        <span class="input-group-append">
                            <button type="button" class="btn btn-primary px-3"><i class="fa fa-eraser"></i></button>
                        </span>
                    </div>
                </div>
                <div class="row bg-light p-3 m-1">
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
                        <div class="tab-content" style="width: 147%;">
                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body table-responsive">
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Fecha de Modificación</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                            </tr>
                                            <tr>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                            </tr>
                                            <tr>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                            </tr>
                                            <tr>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body table-responsive">
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Fecha de Modificación</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Tab2</td>
                                                <td>Jul 14, 2013</td>
                                            </tr>
                                            <tr>
                                                <td>Tab2</td>
                                                <td>Jul 14, 2013</td>
                                            </tr>
                                            <tr>
                                                <td>Tab2</td>
                                                <td>Jul 14, 2013</td>
                                            </tr>
                                            <tr>
                                                <td>Tab2</td>
                                                <td>Jul 14, 2013</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="btn-group btn-group-toggle mt-4" data-toggle="buttons">
                            <label class="btn btn-sm btn-white ">
                                <input type="radio" name="options" id="option1" autocomplete="off" checked> Anterior
                            </label>
                            <label class="btn btn-sm btn-white active">
                                <input type="radio" name="options" id="option2" autocomplete="off"> 1
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option3" autocomplete="off"> 2
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option4" autocomplete="off"> 3
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option5" autocomplete="off"> 4
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option6" autocomplete="off"> Siguiente
                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal - Garantía-->
<div id="modal-forms4" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel4">
    <div class="modal-dialog modal-dialog-centered">
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
                    <div class="col-6">
                        <select class="form-control" name="account">
                            <option>Extendida</option>
                            <option>Anual</option>
                            <option>option 3</option>
                            <option>option 4</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="text" placeholder="Duración: 3 meses" class="form-control m-b">
                    </div>
                    <div class="col-12 row">
                        <div class="col-10">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button"><i class="fa fa-upload"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button"><i class="fa fa-pencil"></i></button>
                        </div>
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
                <div class="row bg-light p-3 m-1 table-responsive">
                    <table class="col-12 table table-striped text-md-center">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Duración</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Extendida anual</td>
                                <td>5 años</td>
                            </tr>
                            <tr>
                                <td>semestre</td>
                                <td>6 meses</td>
                            </tr>
                            <tr>
                                <td>eds</td>
                                <td>70 días</td>
                            </tr>
                            <tr>
                                <td>bimestral</td>
                                <td>2 meses</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="btn-group btn-group-toggle mt-4" data-toggle="buttons">
                        <label class="btn btn-sm btn-white ">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Anterior
                        </label>
                        <label class="btn btn-sm btn-white active">
                            <input type="radio" name="options" id="option2" autocomplete="off"> 1
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option3" autocomplete="off"> 2
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option4" autocomplete="off"> 3
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option5" autocomplete="off"> 4
                        </label>
                        <label class="btn btn-sm btn-white">
                            <input type="radio" name="options" id="option6" autocomplete="off"> Siguiente
                        </label>
                    </div>
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

<style>
    /*Para el tamaño de los botones*/
    .tam{
        min-width: 150px;
        min-height: 150px;
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
<!-- Chosen -->
<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>

<!-- JSKnob -->
<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>

<!-- Input Mask-->
<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>

<!-- Data picker -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- NouSlider -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- Switchery -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- IonRangeSlider -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- iCheck -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- Clock picker -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- Image cropper -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- Date range use moment.js same as full calendar plugin -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- Date range picker -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- TouchSpin -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- Tags Input -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- Dual Listbox -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

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
