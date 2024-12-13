@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Nota de credito Electronica')
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

                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active show" data-toggle="tab" href="#tab-1">Por Enviar</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Enviados</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active show">
                            <div class="panel-body">

                               <div class="table-responsive">
                                    <div class="ibox-content">
                                        <div class="sk-spinner sk-spinner-double-bounce">
                                            <div class="sk-double-bounce1"></div>
                                            <div class="sk-double-bounce2"></div>
                                        </div>
                                       <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th><input class='check_all_boleta' type='checkbox' onclick="select_all_nota_credito()" /></th>
                                                <th>Item</th>
                                                <th>Codigo de NC</th>
                                                <th>N° de Doc.</th>
                                                <th>Cliente</th>
                                                <th>Ruc/DNI</th>
                                                <th>Tipo</th>
                                                <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                            </tr>
                                        </thead>
                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                        <tbody>
                                            <span hidden>{{$i=1}}</span>
                                            @foreach($n_creditos as $n_credito)
                                            <tr class="gradeX">
                                                <td><input type='checkbox' class='case' value="{{$n_credito->codigo_n_c}}" /></td>
                                                <td>{{$i++}}</td>
                                                @if($n_credito->facturacion_id !=NULL)
                                                    <td>{{$n_credito->codigo_n_c}}</td>
                                                    <td><a class="link_tds" target="_blank" href="{{route('facturacion.show',$n_credito->nota_i_facturacion->id)}}">{{$n_credito->nota_i_facturacion->codigo_fac}}</a></td>
                                                    <td>{{$n_credito->nota_i_facturacion->cliente->nombre}}</td>
                                                    <td>{{$n_credito->nota_i_facturacion->cliente->numero_documento}}</td>
                                                    <td>Factura</td>
                                                    <td>
                                                        <center>
                                                            <form action="{{route('facturacion_electronica.nota_credito')}}" method="POST">
                                                            @csrf
                                                                <input type="hidden" name="id" value="{{$n_credito->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </center>
                                                    </td>
                                                @elseif($n_credito->boleta_id !=NULL)
                                                    <td>{{$n_credito->codigo_n_c}}</td>
                                                    <td><a class="link_tds" target="_blank" href="{{route('boleta.show',$n_credito->nota_i_boleta->id)}}">{{$n_credito->nota_i_boleta->codigo_boleta}}</a></td>
                                                    <td>{{$n_credito->nota_i_boleta->cliente->nombre}}</td>
                                                    <td>{{$n_credito->nota_i_boleta->cliente->numero_documento}}</td>
                                                    <td>Boleta</td>
                                                    <td>
                                                        <center>
                                                            <form action="{{route('facturacion_electronica.nota_credito_bol')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$n_credito->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </center>
                                                    </td>
                                                @elseif($n_credito->boleta_m_id !=NULL)
                                                    <td>{{$n_credito->codigo_n_c}}</td>
                                                    <td><a class="link_tds" target="_blank" href="{{route('boleta_manual.show',$n_credito->nota_i_boleta_manual->id)}}">{{$n_credito->nota_i_boleta_manual->codigo_boleta}}</td>
                                                    <td>{{$n_credito->nota_i_boleta_manual->cliente->nombre}}</td>
                                                    <td>{{$n_credito->nota_i_boleta_manual->cliente->numero_documento}}</td>
                                                    <td>Boleta Manual</td>
                                                    <td>
                                                        <center>
                                                            <form action="{{route('facturacion_electronica.nota_credito_bol')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$n_credito->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </center>
                                                    </td>
                                                @else
                                                    <td>{{$n_credito->codigo_n_c}}</td>
                                                    <td><a class="link_tds" target="_blank" href="{{route('facturacion_manual.show',$n_credito->nota_i_fac_manual->id)}}">{{$n_credito->nota_i_fac_manual->codigo_fac}}</td>
                                                    <td>{{$n_credito->nota_i_fac_manual->cliente->nombre}}</td>
                                                    <td>{{$n_credito->nota_i_fac_manual->cliente->numero_documento}}</td>
                                                    <td>Factura Manual</td>
                                                    <td>
                                                        <center>
                                                            <form action="{{route('facturacion_electronica.nota_credito')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$n_credito->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </center>
                                                    </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfooter >
                                            <td colspan="7" align="right" style="padding-right: 2em"></td>
                                            <td align="center"><button type="button" class="btn btn-primary" id="nota_credito_elec_all">Enviar</button></td>
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
                                        <th>Codigo de NC</th>
                                        <th>N° de Doc.</th>
                                        <th>Cliente</th>
                                        <th>Ruc/DNI</th>
                                        <th>Tipo</th>
                                        <th>XML</th>
                                        <th>ZIP</th>
                                        <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <span hidden>{{$q=1}}</span>
                                    @foreach($n_creditos_enviados as $n_credito_enviado)
                                    <tr class="gradeX">
                                        <td>{{$q++}}</td>
                                        @if($n_credito_enviado->facturacion_id !=NULL)
                                            <td>{{$n_credito_enviado->codigo_n_c}}</td>
                                            <td><a class="link_tds" target="_blank" href="{{route('facturacion.show',$n_credito_enviado->nota_i_facturacion->id)}}">{{$n_credito_enviado->nota_i_facturacion->codigo_fac}}</a></td>
                                            <td>{{$n_credito_enviado->nota_i_facturacion->cliente->nombre}}</td>
                                            <td>{{$n_credito_enviado->nota_i_facturacion->cliente->numero_documento}}</td>
                                            <td>Factura</td>
                                        @elseif($n_credito_enviado->boleta_id !=NULL)
                                            <td>{{$n_credito_enviado->codigo_n_c}}</td>
                                            <td><a class="link_tds" target="_blank" href="{{route('boleta.show',$n_credito_enviado->nota_i_boleta->id)}}">{{$n_credito_enviado->nota_i_boleta->codigo_boleta}}</a></td>
                                            <td>{{$n_credito_enviado->nota_i_boleta->cliente->nombre}}</td>
                                            <td>{{$n_credito_enviado->nota_i_boleta->cliente->numero_documento}}</td>
                                            <td>Boleta</td>
                                        @elseif($n_credito_enviado->boleta_m_id !=NULL)
                                            <td>{{$n_credito_enviado->codigo_n_c}}</td>
                                            <td><a class="link_tds" target="_blank" href="{{route('boleta_manual.show',$n_credito_enviado->nota_i_boleta_manual->id)}}">{{$n_credito_enviado->nota_i_boleta_manual->codigo_boleta}}</td>
                                            <td>{{$n_credito_enviado->nota_i_boleta_manual->cliente->nombre}}</td>
                                            <td>{{$n_credito_enviado->nota_i_boleta_manual->cliente->numero_documento}}</td>
                                            <td>Boleta Manual</td>
                                        @else
                                            <td>{{$n_credito_enviado->codigo_n_c}}</td>
                                            <td><a class="link_tds" target="_blank" href="{{route('facturacion_manual.show',$n_credito_enviado->nota_i_fac_manual->id)}}">{{$n_credito_enviado->nota_i_fac_manual->codigo_fac}}</td>
                                            <td>{{$n_credito_enviado->nota_i_fac_manual->cliente->nombre}}</td>
                                            <td>{{$n_credito_enviado->nota_i_fac_manual->cliente->numero_documento}}</td>
                                            <td>Factura Manual</td>
                                        @endif
                                        <td>
                                            <a href="{{ asset('facturas_electronicas/')}}/{{$empresa->ruc}}-07-{{$n_credito_enviado->codigo_n_c}}.xml" download><img src="{{asset('xml.png')}}" width="25px"></a>
                                        </td>
                                        <td>
                                            <a href="{{ asset('facturas_electronicas/')}}/R-{{$empresa->ruc}}-07-{{$n_credito_enviado->codigo_n_c}}.zip" download><img src="{{asset('zip.png')}}" width="25px"></a>
                                        </td>
                                        <td>
                                            <center>
                                                <button type="button" class="btn btn-info btn-circle btn-ls" ><i class="fa fa-check-circle"></i></button>
                                            </center>
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
<!-- Modal para Guia de Remision  -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviando Boletas a Sunat</h5>
            </div>
            <div class="modal-body">
                <div id="msg_nota_credito_el">
                    {{-- Contenido del ajax --}}
                </div>
            </div>
            <div class="modal-footer" style="display: none;">
                <div class="row">
                    <div class="col-sm-6" >
                        *En caso de algún error al enviar la Nota de Credito, por favor comunicarse de manera inmediata.
                    </div>
                    <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                        <button type="button" class="btn btn-primary" id="cerrar_modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ESTILOS --}}
<style type="text/css">
    .a{
        width: 200px;
    }
    .link_tds{
        color: black !important;
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
                            <h5 class="card-title" style="font-size: 18px">NOTA DE CREDITO ELECTRONICA</h5>
                            <p class="card-text" style="font-size: 14px">5 Documentos</p>
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
                                <a class="nav-link active show" data-toggle="tab" href="#tab-6"><span style="color: green;">&#9632; </span> NOTA DE CREDITO
                                    {{-- link del tab 1 --}}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-7"><span style="color: orange;">&#9632;</span> ENVIADOS
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
                            <div role="tabpanel" id="tab-6" class="tab-pane active show">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>
                                                <th >Item</th>
                                                <th >Código de NC</th>
                                                <th >Nª de Doc.</th>
                                                <th>Cliente</th>
                                                <th>Ruc/DNI</th>
                                                <th>Tipo</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;" class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="SUNAT: activate to sort column ascending"><img src="http://127.0.0.1:8000/sunat.png" width="15px">SUNAT</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);">
                                            </td>                                            
                                            <td>1</td>
                                            <td>FA00-00000001</td>
                                            <td>FF01-00000001</td>
                                            <td>FITOBONOS S.A.C</td>
                                            <td>20600184866</td>
                                            <td>Factura</td>
                                            <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);">
                                            </td>                                            
                                            <td>2</td>
                                            <td>FA00-00000001</td>
                                            <td>FF01-00000001</td>
                                            <td>FITOBONOS S.A.C</td>
                                            <td>20600184866</td>
                                            <td>Factura</td>
                                            <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);">
                                            </td>
                                            <td>3</td>
                                            <td>FA00-00000001</td>
                                            <td>FF01-00000001</td>
                                            <td>FITOBONOS S.A.C</td>
                                            <td>20600184866</td>
                                            <td>Factura</td>
                                            <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);">
                                            </td>                                            
                                            <td>4</td>
                                            <td>FA00-00000001</td>
                                            <td>FF01-00000001</td>
                                            <td>FITOBONOS S.A.C</td>
                                            <td>20600184866</td>
                                            <td>Factura</td>
                                            <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                        </tr>
                                    </tbody>
                                    <tr><td colspan="7" align="right" style="padding-right: 2em"></td>
                                        <td align="center"><button type="button" class="btn btn-primary" id="fac_elec_all">Enviar</button></td>
                                </tr>
                                </table>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-7" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <th >Item</th>
                                                <th >Código de NC</th>
                                                <th >Nª de Doc.</th>
                                                <th>Cliente</th>
                                                <th>Ruc/DNI</th>
                                                <th>Tipo</th>
                                                <th >XML</th>
                                                <th>ZIP</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;" class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="SUNAT: activate to sort column ascending"><img src="http://127.0.0.1:8000/sunat.png" width="15px">SUNAT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);">
                                                </td>                                                
                                                <td>1</td>
                                                <td>FM00-00000002</td>
                                                <td>FM00-00000002</td>
                                                <td>NETKA S.A.Ctd</td>
                                                <td>20603807104</td>
                                                <td>Factura</td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);">
                                                </td>
                                                <td>2</td>
                                                <td>FM00-00000002</td>
                                                <td>FM00-00000002</td>
                                                <td>NETKA S.A.Ctd</td>
                                                <td>20603807104</td>
                                                <td>Factura</td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);">
                                                </td>
                                                <td>3</td>
                                                <td>FM00-00000003</td>
                                                <td>FM00-00000003</td>
                                                <td>NETKA S.A.Ctd</td>
                                                <td>20603807104</td>
                                                <td>Factura</td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);">
                                                </td>
                                                <td>4</td>
                                                <td>FM00-00000004</td>
                                                <td>FM00-00000004</td>
                                                <td>NETKA S.A.Ctd</td>
                                                <td>20603807104</td>
                                                <td>Factura</td>
                                                <td><img src="http://127.0.0.1:8000/xml.png" width="25px"></td>
                                                <td>
                                                    <img src="http://127.0.0.1:8000/zip.png" width="25px">
                                                </td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                        </tbody>
                                        <tr><td colspan="9" align="right" style="padding-right: 2em"></td>
                                            <td align="center"><button type="button" class="btn btn-primary" id="fac_elec_all">Enviar</button></td>
                                    </tr>
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
            order: [[0, "asc"]],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [ ]
        });
    });
    function select_all_nota_credito() {
        $('input[class=case]:checkbox').each(function () {
            // console.log($('input[class=check_all]:checkbox:checked'));
            if ($('input[class=check_all_boleta]:checkbox:checked').length == 0) {
                // console.log("a");
                $(this).prop("checked", false);
            } else {
                // console.log("b");
                $(this).prop("checked", true);
            }
        });
    }
    function submit_nota_credito_click(repetir,maximo)
    {
        if ( repetir < maximo ){
            var value_check =  $('input[class=case]:checkbox:checked')[repetir].value;
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.nota_credito_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_nota_credito': value_check,
                },
                success: function (response) {
                    var salt = response. replace(/(\r\n|\n|\r)/gm, "") 
                    var result = salt.substr(0,13);
                    console.log(result);
                    if(result  == "Codigo Error:"){
                        var data = `
                            <div class="alert alert-danger">
                                <a class="alert-link" href="#">Error N°  `+value_check+' <br> '+response+`</a>
                            </div>
                        `;
                    }else{
                        var data = `
                            <div class="alert alert-success">
                                <a class="alert-link" href="#">`+response+`</a>
                            </div>
                        `;
                    }
                    $('#msg_nota_credito_el').append( data );
                    repetir++;
                    submit_nota_credito_click(repetir, maximo);
                }    
            });
        }else{
            $('.modal-footer').removeAttr( 'style' );
        }
    }
    $('#nota_credito_elec_all').on('click', function(){
        var cant_checks =  $('input[class=case]:checkbox:checked').length;
        console.log(cant_checks)
        // var max_menos = cant_checks -1;
        if(cant_checks == 0){
            console.log("ninguno marcado");
        }else{
            $('#exampleModal').modal({backdrop: 'static', keyboard: false});
            $("#exampleModal").modal("show");
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            submit_nota_credito_click(0,cant_checks);
        }
        
    });
    $('#cerrar_modal').on('click', function(){
        location.reload();
    });
</script>
@endsection
