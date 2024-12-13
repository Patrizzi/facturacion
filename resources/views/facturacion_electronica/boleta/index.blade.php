@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Boleta Electronica')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                @if(Session::has('successMsg'))
                <div class="alert alert-success">
                    <a class="alert-link" href="#">{{ session('successMsg') }}</a>.
                </div>
                @endif
                {{-- MENSAJE DEL AJAX PARA LAS FACTURAS INDIVIDUALES --}}
                <div id="msg_individual" class="">

                </div>
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active show" data-toggle="tab" href="#tab-1">Boletas</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Enviados</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">Boleta Manual</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-4">Enviados</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active show">
                            <div class="panel-body">
                                <div class="table-responsive" id="ibox1">
                                    <div class="ibox-content">
                                        <div class="sk-spinner sk-spinner-double-bounce">
                                            <div class="sk-double-bounce1"></div>
                                            <div class="sk-double-bounce2"></div>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th><input class='check_all_boleta' type='checkbox' onclick="select_all_boleta()" /></th>
                                                    <th>Item</th>
                                                    <th>Codigo de Boleta</th>
                                                    <th>Cliente</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Fecha Vencimiento</th>
                                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                </tr>
                                            </thead>
                                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                            <tbody>
                                                <span hidden>{{$i=1}}</span>
                                                @foreach($boletas as $boleta)
                                                <tr class="gradeX">
                                                    <td><input type='checkbox' class='case' value="{{$boleta->codigo_boleta}}" /></td>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$boleta->codigo_boleta}}</td>
                                                    @if(isset($boleta->cliente_id)) <!-- Nombre del cliente -->
                                                    <td>{{$boleta->cliente->nombre}}</td>
                                                    <td>{{$boleta->cliente->numero_documento}}</td>
                                                    @else
                                                    <td>{{$boleta->cotizacion->cliente->nombre}}</td>
                                                    <td>{{$boleta->cotizacion->cliente->numero_documento}}</td>
                                                    @endif
                                                    <td>{{$boleta->fecha_vencimiento }}</td>
                                                    <td>
                                                        <center>
                                                            {{-- <form action="{{route('facturacion_electronica.boleta_sunat')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="boleta_id" value="{{$boleta->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form> --}}
                                                            <button type="button" class="btn btn-success btn-circle btn-ls boleta_ind" id="boleta_ind" value="{{$boleta->codigo_boleta}}" onclick="envio_boleta(this)"><i class="fa fa-cloud-upload" ></i></button>
                                                        </center>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfooter >
                                                <td colspan="6" align="right" style="padding-right: 2em"></td>
                                                <td align="center"><button type="button" class="btn btn-primary" id="boleta_elec_all">Enviar</button></td>
                                            </tfooter>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Codigo de Factura</th>
                                                <th>Cliente</th>
                                                <th>Ruc/DNI</th>
                                                <th>Fecha Vencimiento</th>
                                                <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                <th>XML</th>
                                                <th>ZIP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span hidden>{{$i=1}}</span>
                                            @foreach($boletas_enviadas as $boleta_env)
                                            <tr class="gradeX">
                                                <td>{{$i++}}</td>
                                                <td>{{$boleta_env->codigo_boleta}}</td>
                                                @if(isset($boleta_env->cliente_id)) <!-- Nombre del cliente -->
                                                <td>{{$boleta_env->cliente->nombre}}</td>
                                                <td>{{$boleta_env->cliente->numero_documento}}</td>
                                                @else
                                                <td>{{$boleta_env->cotizacion->cliente->nombre}}</td>
                                                <td>{{$boleta_env->cotizacion->cliente->numero_documento}}</td>
                                                @endif
                                                <td>{{$boleta_env->fecha_vencimiento }}</td>
                                                <td>
                                                    <center>
                                                        <button type="button" class="btn btn-info btn-circle btn-ls" ><i class="fa fa-check-circle"></i></button>
                                                    </center>
                                                </td>
                                                <td align="center">
                                                    <a href="{{ asset('facturas_electronicas/')}}/{{$empresa->ruc}}-03-{{$boleta_env->codigo_boleta}}.xml" download><img src="{{asset('xml.png')}}" width="25px"></a>
                                                </td>
                                                <td align="center">
                                                    <a href="{{ asset('facturas_electronicas/')}}/R-{{$empresa->ruc}}-03-{{$boleta_env->codigo_boleta}}.zip" download><img src="{{asset('zip.png')}}" width="25px"></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-3" class="tab-pane show">
                            <div class="panel-body">
                                <div class="table-responsive" id="ibox2">
                                    <div class="ibox-content">
                                        <div class="sk-spinner sk-spinner-double-bounce">
                                            <div class="sk-double-bounce1"></div>
                                            <div class="sk-double-bounce2"></div>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th><input class='check_all_boleta_m' type='checkbox' onclick="select_all_boleta_m()" /></th>
                                                    <th>Item</th>
                                                    <th>Codigo de Boleta</th>
                                                    <th>Cliente</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Fecha Vencimiento</th>
                                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                </tr>
                                            </thead>
                                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                            <tbody>
                                                <span hidden>{{$i=1}}</span>
                                                @foreach($boletas_m as $boleta_m)
                                                <tr class="gradeX">
                                                    <td><input type='checkbox' class='case2' value="{{$boleta_m->codigo_boleta}}" /></td>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$boleta_m->codigo_boleta}}</td>
                                                    <td>{{$boleta_m->cliente->nombre}}</td>
                                                    <td>{{$boleta_m->cliente->numero_documento}}</td>
                                                    <td>{{$boleta_m->fecha_vencimiento }}</td>
                                                    <td>
                                                        <center>
                                                            {{-- <form action="{{route('facturacion_electronica.boleta_m_e')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="boleta_id" value="{{$boleta_m->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form> --}}
                                                            <button type="button" class="btn btn-success btn-circle btn-ls boleta_ind" id="boleta_ind" value="{{$boleta_m->codigo_boleta}}" onclick="envio_boleta_m(this)"><i class="fa fa-cloud-upload" ></i></button>

                                                        </center>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfooter >
                                                <td colspan="6" align="right" style="padding-right: 2em"></td>
                                                <td align="center"><button type="button" class="btn btn-primary" id="boleta_elec_all_m">Enviar</button></td>
                                            </tfooter>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-4" class="tab-pane">
                            <div class="panel-body">
                                <div class="table-responisve">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Codigo de Factura</th>
                                                <th>Cliente</th>
                                                <th>Ruc/DNI</th>
                                                <th>Fecha Vencimiento</th>
                                                <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                <th>XML</th>
                                                <th>ZIP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span hidden>{{$i=1}}</span>
                                            @foreach($boletas_enviadas_m as $boleta_env_m)
                                            <tr class="gradeX">
                                                <td>{{$i++}}</td>
                                                <td>{{$boleta_env_m->codigo_boleta}}</td>
                                                <td>{{$boleta_env_m->cliente->nombre}}</td>
                                                <td>{{$boleta_env_m->cliente->numero_documento}}</td>
                                                <td>{{$boleta_env_m->fecha_vencimiento }}</td>
                                                <td>
                                                    <center>
                                                        <button type="button" class="btn btn-info btn-circle btn-ls" ><i class="fa fa-check-circle"></i></button>
                                                    </center>
                                                </td>
                                                <td align="center">
                                                    <a href="{{ asset('facturas_electronicas/')}}/{{$empresa->ruc}}-03-{{$boleta_env_m->codigo_boleta}}.xml" download><img src="{{asset('xml.png')}}" width="25px"></a>
                                                </td>
                                                <td align="center">
                                                    <a href="{{ asset('facturas_electronicas/')}}/R-{{$empresa->ruc}}-03-{{$boleta_env_m->codigo_boleta}}.zip" download><img src="{{asset('zip.png')}}" width="25px"></a>
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
            </div>
        </div>
    </div>
</div>
<!-- Modal para BOLETA  -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviando Boletas a Sunat</h5>
            </div>
            <div class="modal-body">
                <div id="msg_bole_el">
                    {{-- Contenido del ajax --}}
                </div>
            </div>
            <div class="modal-footer" style="display: none;">
                <div class="row">
                    <div class="col-sm-6" >
                        *En caso de algún error al enviar la Factura, por favor comunicarse de manera inmediata.
                    </div>
                    <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                        <button type="button" class="btn btn-primary" id="cerrar_modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para BOLETA MANUAL  -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="exampleModal2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviando Boletas a Sunat</h5>
            </div>
            <div class="modal-body">
                <div id="msg_bole_el_man">
                    {{-- Contenido del ajax --}}
                </div>
            </div>
            <div class="modal-footer" style="display: none;">
                <div class="row">
                    <div class="col-sm-6" >
                        *En caso de algún error al enviar la Factura, por favor comunicarse de manera inmediata.
                    </div>
                    <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                        <button type="button" class="btn btn-primary" id="cerrar_modal2">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ESTILOS --}}
<style type="text/css">
    .a{width: 200px}
    .ibox-content{
        padding: 0px;
        border: none;
    }
    .model-footer{
        > :not(:last-child) { margin-right: .0rem; }
    }
</style>



<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
            <div class="ibox-title" style="display: flex; align-items: center;">
    <span>RESUMEN DE DICIEMBRE DEL 2024</span>
</div>
            <div class="ibox-content">
                <div class="card-group">
                    <div class="card p-3" style="border: none;">
                        <div class="d-flex justify-content-center align-items-center card-img-top">
                            <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2.5rem;">
                                <i class="fa fa-envelope-open text-white"></i>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 18px">BOLETAS</h5>
                            <p class="card-text" style="font-size: 14px">5 Documentos</p>
                            <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                    <div class="card p-3" style="border: none;">
                        <div class="d-flex justify-content-center align-items-center card-img-top">
                            <div class="bg-success rounded-circle d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2.5rem;">
                                <i class="fa fa-file-archive-o text-white"></i>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 18px">BOLETA MANUAL</h5>
                            <p class="card-text" style="font-size: 14px">3 Documentos</p>
                            <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--Base para agregar el tab para el los contenidos--}}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-5"><span style="color: green;">&#9632; </span> BOLETAS
                                    {{-- link del tab 1 --}}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-6"><span style="color: orange;">&#9632;</span> ENVIADOS
                                    {{-- link del tab 2 --}}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-7"><span style="color: rgb(0, 255, 72);">&#9632;</span> BOLETA MANUAL
                                    {{-- link del tab 2 --}}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-8"><span style="color: red;">&#9632;</span> ENVIADOS
                                    {{-- link del tab 2 --}}
                                </a>
                            </li>
                                <li class="ml-auto">
                                <div class="btn-group mx-2">
                                    <button data-toggle="dropdown" type="button" class="btn btn-default btn-sm dropdown-toggle bg-primary"><i class="fa fa-plus"></i></button>
                                    <ul class=" dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Oficia 1</a></li>
                                        <li><a class="dropdown-item" href="#">Oficina 2</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="btn-group mx-3">
                                    <button data-toggle="dropdown" type="button" class="btn btn-default btn-sm dropdown-toggle bg-primary"><i class="fa fa-cloud-download"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">PDF</a></li>
                                        <li><a class="dropdown-item" href="#">WORD</a></li>
                                        <li><a class="dropdown-item" href="#">CSV</a></li>
                                        <li><a class="dropdown-item" href="#">EXCEL</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <!-- Input seleccionar fecha inicio y fin, y Botón agregar y Descargar -->
                        <div class="d-flex justify-content-md-start row mx-3 mt-4">
                            <div class="input-group col-md-4 mx-5">
                                <input class="form-control col-md-auto" type="text" name="daterange" value="01/01/2015 - 01/31/2015">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-secondary px-3"><i class="fa fa-history"></i></button>
                                </span>
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary px-3"><i class="fa fa-eraser"></i></button>
                                </span>
                            </div>
                            <div class="row g-3 col-md-5">
                                <div class="col-auto">
                                    <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                                </div>
                            </div>
                        </div>
                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-5" class="tab-pane active show">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <th >Item</th>
                                                <th >Código de Boleta</th>
                                                <th >Cliente</th>
                                                <th>RUC / DNI</th>
                                                <th>Fecha de vencimiento</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;" class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="SUNAT: activate to sort column ascending"><img src="http://127.0.0.1:8000/sunat.png" width="15px">SUNAT</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                            
                                            <td>1</td>
                                            <td>BA00-00000001</td>
                                            <td>EM PLAST PERU E.I.R.L</td>
                                            <td>20600184866</td>
                                            <td>2020-03-22 16:45:32</td>
                                            <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                        </tr>
                                        <tr>
                                            <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                            
                                            <td>2</td>
                                            <td>BA00-00000002</td>
                                            <td>COPACO S.A.C</td>
                                            <td>20600184811</td>
                                            <td>2022-06-24 11:41:48</td>
                                            <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                        </tr>
                                        <tr>
                                            <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                            
                                            <td>3</td>
                                            <td>BA00-00000001</td>
                                            <td>FITOBONOS S.A.C</td>
                                            <td>2060018483</td>
                                            <td>2022-04-24 11:41:48</td>
                                            <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                        </tr>
                                        <tr>
                                            <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                            
                                            <td>4</td>
                                            <td>BA00-00000001</td>
                                            <td>COPACO S.A.C</td>
                                            <td>206001844</td>
                                            <td>2022-04-16 11:41:48</td>
                                            <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                        </tr>
                                        <tr><td colspan="6" align="right" style="padding-right: 2em"></td>
                                            <td align="center"><button type="button" class="btn btn-primary" id="fac_elec_all">Enviar</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-6" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <th >Item</th>
                                                <th >Código de Boleta</th>
                                                <th >Cliente</th>
                                                <th>RUC /DNI</th>
                                                <th>Fecha de emisión</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;" class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="SUNAT: activate to sort column ascending"><img src="http://127.0.0.1:8000/sunat.png" width="15px">SUNAT</th>
                                                <th >XML</th>
                                                <th>ZIP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>2</td>
                                                <td>BM00-00000002</td>
                                                <td>NETKA S.A.C</td>
                                                <td>20603807104</td>
                                                <td>2022-02-24 23:18:04</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>2</td>
                                                <td>BM00-00000002</td>
                                                <td>ESCUELA SUPERIOR DE SALUD COMPLEJO HOSPITALARIO SAN PABLO SOCIEDAD ANONIMA CERRADA</td>
                                                <td>20390910461</td>
                                                <td>2022-03-08 12:01:27</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>3</td>
                                                <td>BM00-00000002</td>
                                                <td>MACHEN PERU S.A.C.</td>
                                                <td>20508630345	</td>
                                                <td>2022-03-09 14:20:33</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>2</td>
                                                <td>BM00-00000002</td>
                                                <td>SM CONSULTORES LEGALES SOCIEDAD ANONIMA CERRADA</td>
                                                <td>20608262271</td>
                                                <td>2022-03-14 15:58:14</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-7" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                        <tr>
                                            <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                            <th >Item</th>
                                                <th >Código de Boleta</th>
                                                <th >Cliente</th>
                                                <th>RUC / DNI</th>
                                                <th>Fecha de vencimiento</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;" class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="SUNAT: activate to sort column ascending"><img src="http://127.0.0.1:8000/sunat.png" width="15px">SUNAT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>3</td>
                                                <td>BM00-00000003</td>
                                                <td>203837834</td>
                                                <td>Fact2</td>
                                                <td>Jul 14, 2013</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>2</td>
                                                <td>BM00-00000003</td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 16, 2013</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>3</td>
                                                <td>BM00-00000003</td>
                                                <td>23908223</td>
                                                <td>Jacinto</td>
                                                <td>Jul 18, 2013</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>4</td>
                                                <td>BM00-00000003</td>
                                                <td>23908223</td>
                                                <td>aronou</td>
                                                <td>Jul 22, 2013</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                            <tr><td colspan="6" align="right" style="padding-right: 2em"></td>
                                                <td align="center"><button type="button" class="btn btn-primary" id="fac_elec_all">Enviar</button></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-8" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                        <tr>
                                            <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                            <th >Item</th>
                                                <th >Código de Boleta</th>
                                                <th >Cliente</th>
                                                <th>RUC /DNI</th>
                                                <th>Fecha de emisión</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;" class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="SUNAT: activate to sort column ascending"><img src="http://127.0.0.1:8000/sunat.png" width="15px">SUNAT</th>
                                                <th >XML</th>
                                                <th>ZIP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>4</td>
                                                <td>BM00-00000003</td>
                                                <td>203837834</td>
                                                <td>Fact2</td>
                                                <td>Jul 14, 2013</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>4</td>
                                                <td>BM00-00000003</td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 16, 2013</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>4</td>
                                                <td>BM00-00000003</td>
                                                <td>23908223</td>
                                                <td>Jacinto</td>
                                                <td>Jul 18, 2013</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>4</td>
                                                <td>BM00-00000003</td>
                                                <td>23908223</td>
                                                <td>aronou</td>
                                                <td>Jul 22, 2013</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                            </tr>
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

<!-- scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


<!-- Page Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 20,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [ ]
        });
    });
    function select_all_boleta() {
        $('input[class=case]:checkbox').each(function () {
            if ($('input[class=check_all_boleta]:checkbox:checked').length == 0) {
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        });
    }
    function select_all_boleta_m() {
        $('input[class=case2]:checkbox').each(function () {
            if ($('input[class=check_all_boleta_m]:checkbox:checked').length == 0) {
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        });
    }
    // BOlETA ENVIO
    function envio_boleta(codigo){
        $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
        $('.nav-link').addClass('disabled');
        var value_check =  codigo.value;
        $.ajax({
            type: "post",
            url: "{{ route('facturacion_electronica.boleta_elec_all') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'codigo_bol': value_check,
            },
            success: function (response) {
                var salt = response.replace(/(\r\n|\n|\r)/gm, "")
                var result = salt.substr(0,13);
                // console.log(result);
                if(result  == "Codigo Error:"){
                    var data = `
                        <div id="myAlert" class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert"  data-toggle="popover" data-placement="left" data-content="Haga click para cerrar esta notificación">&times;</a>
                            <span class="alert-link" id="`+value_check+`">Error N°  `+value_check+' <br> '+response+`</span>
                        </div>
                    `;
                }else{
                    var data = `
                        <div id="myAlert" class=" alert alert-success" >
                            <a id="cerrar_popup" class="close"  data-container="body" data-trigger="click" data-toggle="popover"  data-placement="bottom" data-content="Haga click para cerrar esta notificación." style="color:#d4edda;width: 0">&times;</a>
                            <a class="close" data-dismiss="alert">&times;</a>
                            <span class="alert-link" id="`+value_check+`">`+response+`</span>
                        </div>
                    `;
                }
                revision(value_check, response, 'boleta');
                inv_close();
                $('#msg_individual').append( data );
                $("#success-alert").show();
            }
        });
    }
    $('#boleta_elec_all').on('click', function(){
        var cant_checks =  $('input[class=case]:checkbox:checked').length;
        if(cant_checks == 0){
            console.log("ninguno marcado");
        }else{
            $('#exampleModal').modal({backdrop: 'static', keyboard: false});
            $("#exampleModal").modal("show");
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            submit_boleta_click(0,cant_checks);
        }

    });
    function submit_boleta_click(repetir,maximo)
    {
        if ( repetir < maximo ){
            var value_check =  $('input[class=case]:checkbox:checked')[repetir].value;
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.boleta_elec_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_bol': value_check,
                },
                success: function (response) {
                    var salt = response. replace(/(\r\n|\n|\r)/gm, "")
                    var result = salt.substr(0,13);
                    // console.log(result);
                    if(result  == "Codigo Error:"){
                        var data = `
                            <div class="alert alert-danger">
                                <a class="alert-link" href="#" id="`+value_check+`">Error N°  `+value_check+' <br> '+response+`</a>
                            </div>
                        `;
                    }else{
                        var data = `
                            <div class="alert alert-success">
                                <a class="alert-link" href="#" id="`+value_check+`">`+response+`</a>
                            </div>
                        `;
                    }
                    console.log('b');
                    revision(value_check, response, 'boleta');
                    $('#msg_bole_el').append( data );
                    repetir++;
                    submit_boleta_click(repetir, maximo);
                }
            });
        }else{
            $('.modal-footer').removeAttr( 'style' );
        }
    }
    function revision(codigo, msg, tipo){
        console.log('a');
        $.ajax({
            type: "post",
            url: "{{ route('facturacion_electronica.validacion_sunat_boleta') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'tipo': tipo,
                'codigo_bol': codigo,
                'msg': msg,
            },
            success: function (response) {
                var data2 = `<p style="margin-bottom: 0px">`+response+`</p>`
                $(`#`+codigo+``).append( data2 );
            }
        });
    }
    function inv_close(){
        $(document).ready(function(){
            $("#myAlert").bind('closed.bs.alert', function(){
                location.reload();
            })
        });
        $('[data-toggle="popover"]').popover();
        const myTimeout = setTimeout(click, 5000);
    }
    function click(){
        console.log("click");
        $('[data-toggle="popover"]').popover();
        $('#cerrar_popup').trigger('click');
    }

    //BOLETA MANUAL
    function envio_boleta_m(codigo){
        $('#ibox2').children('.ibox-content').toggleClass('sk-loading');
        $('.nav-link').addClass('disabled');
        var value_check =  codigo.value;
        $.ajax({
            type: "post",
            url: "{{ route('facturacion_electronica.boleta_m_e_all') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'codigo_bol': value_check,
            },
            success: function (response) {
                var salt = response.replace(/(\r\n|\n|\r)/gm, "")
                var result = salt.substr(0,13);
                // console.log(result);
                if(result  == "Codigo Error:"){
                    var data = `
                        <div id="myAlert" class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert"  data-toggle="popover" data-placement="left" data-content="Haga click para cerrar esta notificación">&times;</a>
                            <span class="alert-link" id="`+value_check+`">Error N°  `+value_check+' <br> '+response+`</span>
                        </div>
                    `;
                }else{
                    var data = `
                        <div id="myAlert" class=" alert alert-success" >
                            <a id="cerrar_popup" class="close"  data-container="body" data-trigger="click" data-toggle="popover"  data-placement="bottom" data-content="Haga click para cerrar esta notificación." style="color:#d4edda;width: 0">&times;</a>
                            <a class="close" data-dismiss="alert">&times;</a>
                            <span class="alert-link" id="`+value_check+`">`+response+`</span>
                        </div>
                    `;
                }
                revision(value_check, response, 'boleta_manual');
                inv_close();
                $('#msg_individual').append( data );
                $("#success-alert").show();
            }
        });
    }
    function submit_boleta_click_manual(repetir,maximo)
    {
        if ( repetir < maximo ){
            var value_check =  $('input[class=case2]:checkbox:checked')[repetir].value;
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.boleta_m_e_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_bol': value_check,
                },
                success: function (response) {
                    var salt = response. replace(/(\r\n|\n|\r)/gm, "")
                    var result = salt.substr(0,13);
                    // console.log(result);
                    if(result  == "Codigo Error:"){
                        var data = `
                            <div class="alert alert-danger">
                                <a class="alert-link" href="#" id="`+value_check+`">Error N°  `+value_check+' <br> '+response+`</a>
                            </div>
                        `;
                    }else{
                        var data = `
                            <div class="alert alert-success">
                                <a class="alert-link" href="#" id="`+value_check+`">`+response+`</a>
                            </div>
                        `;
                    }
                    console.log('b');
                    revision(value_check, response, 'boleta_manual');
                    $('#msg_bole_el_man').append( data );
                    repetir++;
                    submit_boleta_click_manual(repetir, maximo);
                }
            });
        }else{
            $('.modal-footer').removeAttr( 'style' );
        }
    }
    $('#boleta_elec_all_m').on('click', function(){
        var cant_checks =  $('input[class=case2]:checkbox:checked').length;
        if(cant_checks == 0){
            console.log("ninguno marcado");
        }else{
            $('#exampleModal2').modal({backdrop: 'static', keyboard: false});
            $("#exampleModal2").modal("show");
            $('#ibox2').children('.ibox-content').toggleClass('sk-loading');
            submit_boleta_click_manual(0,cant_checks);
        }

    });
    function click(){
        console.log("click");
        $('[data-toggle="popover"]').popover();
        $('#cerrar_popup').trigger('click');
    }
    $('#cerrar_modal').on('click', function(){
        location.reload();
    });
    $('#cerrar_modal2').on('click', function(){
        location.reload();
    });

</script>
@endsection
