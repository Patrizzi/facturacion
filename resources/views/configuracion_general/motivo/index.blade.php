@extends('layout')

@section('title', 'Motivos')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('button2', 'Atras')
@section('config',route('Configuracion'))

@section('content')
<div class="wrapper wrapper-content animated fadeInRight align-content-center">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
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


                        <!-- Buscar, Botón agregar y Descargar -->
                        <div class="py-2 d-flex align-items-center row-cols-12 pt-4 border-left border-right border-secondary-subtle" style="margin-left: 0.1px; margin-right: 0.1px;">
                            <div class="col-md-7 d-flex justify-content-md-start row-cols-12 py-2">
                                <div class="col-md-auto">
                                    <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                                </div>
                            </div>

                            <div class="col-md-5 d-flex justify-content-end">
                                <div class="col-md-2 d-flex justify-content-end align-content-center align-items-md-center ms-5">
                                    <div class="btn-group">
                                        <!--<button data-toggle="dropdown" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>-->
                                        <a data-toggle="modal" class="btn btn-primary btn-sm" href="#modal-form4"><i class="fa fa-plus"></i></a>
                                        <div id="modal-form4" class="modal fade" style="display: none;" aria-modal="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <!--Contenido de modal-->
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="ibox collapsed border-bottom">
                                                                    <div class="ibox-title">
                                                                        <h3><i class="fa fa-th-large fs-4"></i> AGREGAR MOTIVO</h3>

                                                                    </div>
                                                                    <!--Contenido-->
                                                                    <div class="ibox-content" style="display: block;">
                                                                        <div class="form-group row px-2">
                                                                            <div class="col-md-12">
                                                                                <input type="text" placeholder="Nombre:" class="form-control m-b">
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <select class="form-control m-b" name="tipo">
                                                                                    <option>Tipo</option>
                                                                                    <option value="">option 2</option>
                                                                                    <option value="">option 3</option>
                                                                                    <option value="">option 4</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mt-4 px-2">
                                                                            <div class="col-md-12">
                                                                                <button type="button" class="btn btn-block btn-lg btn-success fs-6"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Guardar</button>
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
                                </div>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" type="button" class="btn btn-primary btn-sm mx-3"><i class="fa fa-cloud-download"></i></button>
                                    <ul class="dropdown-menu p-1">
                                        <li><a class="dropdown-item" href="#">PDF</a></li>
                                        <li><a class="dropdown-item" href="#">Excel</a></li>
                                        <li><a class="dropdown-item" href="#">Word</a></li>
                                        <li><a class="dropdown-item" href="#">CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Tablas y su contenido -->
                        <div class="tab-content">

                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB - Boleta manual -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" checked class="i-checks" name="input[]"></th>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Fecha de Modificación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>1</td>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <!--<a href="" class="fs-5"><i class="fa fa-edit"></i></a>-->
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>2</td>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>3</td>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>4</td>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>5</td>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>6</td>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>7</td>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>8</td>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>9</td>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>10</td>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>11</td>
                                                <td>BOL</td>
                                                <td>Abril 25, 1987</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
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
                                                <th><input type="checkbox" checked class="i-checks" name="input[]"></th>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Fecha de Modificación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>1</td>
                                                <td>Tab2</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>2</td>
                                                <td>Tab2</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>3</td>
                                                <td>Tab2</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>4</td>
                                                <td>Tab2</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" class="fs-5" href="#modal-form3"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <!--Modal editar-->
                        <div id="modal-form3" class="modal fade" style="display: none;" aria-modal="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <!--Contenido de modal-->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="ibox collapsed border-bottom">
                                                    <div class="ibox-title">
                                                        <h3><i class="fa fa-th-large fs-4"></i> EDITAR MOTIVO</h3>

                                                    </div>
                                                    <!--Contenido-->
                                                    <div class="ibox-content" style="display: block;">
                                                        <div class="form-group row px-2">
                                                            <div class="col-md-12">
                                                                <input type="text" placeholder="Nombre:" class="form-control m-b">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row px-2">
                                                            <div class="col-md-6">
                                                                <select class="form-control m-b" name="estado">
                                                                    <option>Estado</option>
                                                                    <option value="">option 2</option>
                                                                    <option value="">option 3</option>
                                                                    <option value="">option 4</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select class="form-control m-b" name="tipo">
                                                                    <option>Tipo</option>
                                                                    <option value="">option 2</option>
                                                                    <option value="">option 3</option>
                                                                    <option value="">option 4</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mt-2 px-2">
                                                            <div class="col-md-12">
                                                                <button type="button" class="btn btn-block btn-lg btn-success fs-6"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Guardar</button>
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
                        <!--/ Modal-->

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





<!-- Modal Create
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 3">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                    <form action="{{ route('motivo.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                        @csrf
                        <div>
                            <div class="panel-body" >
                                <div class="row">
                                    <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/motivo.svg')}}" width="100px"></div>
                                    <label class="col-sm-2 col-form-label">Tipo:</label>
                                    <div class="col-sm-10" style="margin-bottom: 5px">
                                        <select name="tipo" class="form-control " >
                                            <option value="Compras">Compras</option>
                                            <option value="Salidas">Salidas</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Nombre:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nombre">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" id="boton">Grabar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Modal Create

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Ver</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        {{-- <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Fecha de creacion</th>
                                    <th>Fecha de Modificacion</th>
                                    <th>EDITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($motivos as $motivo)
                                <tr class="gradeX">
                                    <td>{{$motivo->id}}</td>
                                    <td>{{$motivo->nombre}}</td>
                                    <td>{{$motivo->created_at}}</td>
                                    <td>{{$motivo->updated_at}}</td>
                                    <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$motivo->id}}">Editar</button>
                                        <div class="modal fade" id="exampleModal{{$motivo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> Edit Motivo</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                                                            <form action="{{ route('motivo.update',$motivo->id) }}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <fieldset >
                                                                    <div>
                                                                        <div class="panel-body" >
                                                                            <div class="row">
                                                                                <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/motivo.svg')}}" width="100px"></div>
                                                                                <label class="col-sm-2 col-form-label">Nombre:</label>
                                                                                <div class="col-sm-10">
                                                                                    @if($motivo->created_at==$motivo->updated_at)
                                                                                        <input type="text" class="form-control" value="{{$motivo->nombre}}" name="nombre">
                                                                                    @else
                                                                                        <input type="text" class="form-control" value="{{$motivo->nombre}}" name="nombre" readonly="readonly">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                                <button class="btn btn-primary" type="submit">Grabar</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- / Modal Create
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Entradas</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2">Salidas</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Nombre</th>
                                                        <th>Fecha de Modificacion</th>
                                                        <th>Estado</th>
                                                        <th>Editar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($motivos_compra as $m_compras)
                                                    <tr>
                                                        <td>{{$id_compras++}}</td>
                                                        <td>{{$m_compras->nombre}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($m_compras->updated_at)->format('d/m/Y H:i:s')}}</td>
                                                        <td>
                                                            @if ($m_compras->estado == 0)
                                                                <i class="fa fa-circle" style="color: green;"></i>&nbsp;Activo
                                                            @else
                                                                <i class="fa fa-circle"></i>&nbsp;Desactivo
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_{{$m_compras->id}}">
                                                                Editar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal Create
                                                    <div class="modal fade" id="edit_{{$m_compras->id}}" role="dialog" aria-labelledby="edit_{{$m_compras->id}}" aria-hidden="true"  >
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div style="padding-left: 15px;padding-right: 15px;">
                                                                    {{-- ccccccccccccccccc --}}
                                                                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;margin-bottom: 12px" align="center">
                                                                        <form action="{{ route('motivo.update',$m_compras->id) }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                                                                            @csrf
                                                                            @method('PUT')
                                                                                <div style="padding-bottom: 12px">
                                                                                    <div class="panel-body" >
                                                                                        <div class="row">
                                                                                        <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/motivo.svg')}}" width="100px"></div>
                                                                                        <label class="col-sm-2 col-form-label">Tipo:</label>
                                                                                        <div class="col-sm-10" style="padding-bottom: 15px">
                                                                                            @if($m_compras->tipo == "Sin Asignar")
                                                                                                <select name="tipo" id="" value="" class="form-control">
                                                                                                    <option selected="true" value="Compras">Compras</option>
                                                                                                    <option value="Salidas">Ventas</option>
                                                                                                </select>
                                                                                            @else
                                                                                                <select name="tipo" id="" class="form-control">
                                                                                                    <option selected value="{{$m_compras->tipo}}">{{$m_compras->tipo}}</option>
                                                                                                    <option value="Compras">Compras</option>
                                                                                                    <option value="Salidas">Ventas</option>
                                                                                                </select>
                                                                                            @endif
                                                                                        </div>
                                                                                        <label class="col-sm-2 col-form-label">Nombre:</label>
                                                                                        <div class="col-sm-10" style="padding-bottom: 15px">
                                                                                            <input type="text" class="form-control" name="nombre" value="{{$m_compras->nombre}}">
                                                                                        </div>
                                                                                        <label class="col-sm-2 col-form-label">Estado</label>
                                                                                            <div class="col-sm-10">
                                                                                                <center><input type="checkbox" class="switch_compras{{$m_compras->id}} check_edit " name="estado"  @if($m_compras->estado==0) checked="" @endif /></center>
                                                                                            </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div align="right">
                                                                                <button class="btn btn-primary" type="submit" id="boton">Grabar</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- / Modal Create
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Nombre</th>
                                                        <th>Fecha de Modificacion</th>
                                                        <th>Estado</th>
                                                        <th>Editar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($motivos_dev as $m_devol)
                                                    <tr>
                                                        <td>{{$id_salida++}}</td>
                                                        <td>{{$m_devol->nombre}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($m_devol->updated_at)->format('d/m/Y H:i:s')}}</td>
                                                        <td>
                                                            @if ($m_devol->estado == 0)
                                                                <i class="fa fa-circle" style="color: green;"></i>&nbsp;Activo
                                                            @else
                                                                <i class="fa fa-circle"></i>&nbsp;Desactivo
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_{{$m_devol->id}}">
                                                                Editar
                                                            </button>
                                                        </td>
                                                        <!-- Modal Create
                                                        <div class="modal fade" id="edit_{{$m_devol->id}}" role="dialog" aria-labelledby="edit_{{$m_devol->id}}" aria-hidden="true"  >
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                                        {{-- ccccccccccccccccc --}}
                                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                                                                            <form action="{{ route('motivo.update',$m_devol->id) }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                    <div style="padding-bottom: 15px">
                                                                                        <div class="panel-body" >
                                                                                            <div class="row">
                                                                                            <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/motivo.svg')}}" width="100px"></div>
                                                                                            <label class="col-sm-2 col-form-label">Tipo:</label>
                                                                                            <div class="col-sm-10" style="padding-bottom: 15px">
                                                                                                @if($m_devol->tipo == "Sin Asignar")
                                                                                                    <select name="tipo" id="" class="form-control" required>
                                                                                                        <option selected value="Salidas">Ventas</option>
                                                                                                        <option  value="Compras">Compras</option>
                                                                                                    </select>
                                                                                                @else
                                                                                                    <select name="tipo" id="" class="form-control">
                                                                                                        <option selected value="{{$m_devol->tipo}}">{{$m_devol->tipo}}</option>
                                                                                                        <option value="Compras">Compras</option>
                                                                                                        <option value="Salidas">Ventas</option>
                                                                                                    </select>
                                                                                                @endif
                                                                                            </div>
                                                                                            <label class="col-sm-2 col-form-label">Nombre:</label>
                                                                                            <div class="col-sm-10" style="padding-bottom: 15px">
                                                                                                <input type="text" class="form-control" name="nombre" value="{{$m_devol->nombre}}">
                                                                                            </div>
                                                                                            <label class="col-sm-2 col-form-label">Estado</label>
                                                                                            <div class="col-sm-10" style="padding-bottom: 15px">
                                                                                                <input type="checkbox" class="switch_dev{{$m_devol->id}} check_edit " name="estado"  @if($m_devol->estado==0) checked="" @endif />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div align="right">
                                                                                    <button class="btn btn-primary" type="submit" id="boton">Grabar</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- / Modal Create
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
    </div>
</div>
<style>
    .form-control{
        border-radius: 8px;
    }
    .select2-selection.select2-selection--single{
        height: 100%;
    }
    span.select2-container {
        z-index:10050;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
    }
</style>-->

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
<script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- iCheck -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

<script>
    $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
</script>


<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
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

    });

</script>
@foreach($motivos_compra as $mc)
<script>
    var swObjs{{$mc->id}} = {};
    $(document).ready(function(){
        var elem_sub{{$mc->id}} = document.querySelector('.switch_compras{{$mc->id}}');
        var switch_sub{{$mc->id}} = new Switchery(elem_sub{{$mc->id}}, { color: 'skyblue' });
        swObjs{{$mc->id}}[elem_sub{{$mc->id}}.id] = switch_sub{{$mc->id}};
    });


</script>
@endforeach
@foreach($motivos_dev as $md)
<script>
    var swObjs{{$md->id}} = {};
    $(document).ready(function(){
        var elem_sub{{$md->id}} = document.querySelector('.switch_dev{{$md->id}}');
        var switch_sub{{$md->id}} = new Switchery(elem_sub{{$md->id}}, { color: 'skyblue' });
        swObjs{{$md->id}}[elem_sub{{$md->id}}.id] = switch_sub{{$md->id}};
    });


</script>
@endforeach
{{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<script>
    function valida(f) {
        var boton=document.getElementById("boton");
        var completo = true;
        var incompleto = false;
        if( f.elements[0].value == "" )
         { alert(incompleto); }
     else{boton.type = 'button';}
    }

    $('#mySelect2').select2({
		placeholder: "Seleccionar",
    });


</script>
{{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
@endsection
