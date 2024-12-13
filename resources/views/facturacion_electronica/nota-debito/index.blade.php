@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Nota de credito Electronica')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                @if(Session::has('successMsg'))
                <div class="alert alert-success">
                    <a class="alert-link" href="#">{{ session('successMsg') }}.</a>
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
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    {{-- <th><input class='check_all_boleta' type='checkbox' onclick="select_all_nota_credito()" /></th> --}}
                                                    <th>Item</th>
                                                    <th>Codigo de NC</th>
                                                    <th>Cliente</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Tipo</th>
                                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                </tr>
                                            </thead>
                                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                            <tbody>
                                                <span hidden>{{$i=1}}</span>
                                                @foreach ($n_debitos as $nota_d)
                                                <tr>
                                                    {{-- <td><input type='checkbox' class='case' value="{{$nota_d->codigo_n_d}}" /></td> --}}
                                                    <td>{{$i++}}</td>
                                                    <td>{{$nota_d->codigo_n_d}}</td>
                                                    @if($nota_d->facturacion_id !=NULL)
                                                        <td>{{$nota_d->nota_i_facturacion->cliente->nombre}}</td>
                                                        <td>{{$nota_d->nota_i_facturacion->cliente->numero_documento}}</td>
                                                        <td>Factura</td>
                                                        <td style="text-align: center">
                                                            <form action="{{route('facturacion_electronica.nota_debito')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$nota_d->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </td>
                                                    @elseif($nota_d->boleta_id !=NULL)
                                                        <td>{{$nota_d->nota_i_boleta->cliente->nombre}}</td>
                                                        <td>{{$nota_d->nota_i_boleta->cliente->numero_documento}}</td>
                                                        <td>Boleta</td>
                                                        <td style="text-align: center">
                                                            <form action="{{route('facturacion_electronica.nota_debito_bol')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$nota_d->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </td>
                                                    @elseif($nota_d->boleta_m_id !=NULL)
                                                        <td>{{$nota_d->nota_i_boleta_manual->cliente->nombre}}</td>
                                                        <td>{{$nota_d->nota_i_boleta_manual->cliente->numero_documento}}</td>
                                                        <td>Boleta Manual</td>
                                                        <td style="text-align: center">
                                                            <form action="{{route('facturacion_electronica.nota_debito_bol')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$nota_d->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </td>
                                                    @else
                                                        <td>{{$nota_d->nota_i_fac_manual->cliente->nombre}}</td>
                                                        <td>{{$nota_d->nota_i_fac_manual->cliente->numero_documento}}</td>
                                                        <td>Factura Manual</td>
                                                        <td style="text-align: center">
                                                            <form action="{{route('facturacion_electronica.nota_debito')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$nota_d->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <div class="ibox-content">
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Codigo de NC</th>
                                                    <th>Cliente</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Tipo</th>
                                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <span hidden>{{$h=1}}</span>
                                                @foreach ($n_debitos_enviados as $n_d_env)
                                                    <tr>
                                                        <td>{{$h}}</td>
                                                        <td>{{$n_d_env->codigo_n_d}}</td>
                                                    
                                                        @if(isset($n_d_env->facturacion_id))
                                                            <td>{{$n_d_env->nota_i_facturacion->cliente->nombre}}</td>
                                                            <td>{{$n_d_env->nota_i_facturacion->cliente->numero_documento}}</td>
                                                            <td>Factura</td>
                                                        @elseif(isset($n_d_env->boleta_id))
                                                            <td>{{$n_d_env->nota_i_boleta->cliente->nombre}}</td>
                                                            <td>{{$n_d_env->nota_i_boleta->cliente->numero_documento}}</td>
                                                            <td>Boleta</td>
                                                        @elseif(isset($n_d_env->boleta_m_id))
                                                            <td>{{$n_d_env->nota_i_boleta_manual->cliente->nombre}}</td>
                                                            <td>{{$n_d_env->nota_i_boleta_manual->cliente->numero_documento}}</td>
                                                            <td>Boleta Manual</td>
                                                        @else
                                                            <td>{{$n_d_env->nota_i_fac_manual->cliente->nombre}}</td>
                                                            <td>{{$n_d_env->nota_i_fac_manual->cliente->numero_documento}}</td>
                                                            <td>Facturacion Manual</td>
                                                        @endif
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
</div>
<style type="text/css">
    .a{width: 200px}
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
                            <h5 class="card-title" style="font-size: 18px">NOTA DE DEBITO ELECTRONICA</h5>
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
                                <a class="nav-link active show" data-toggle="tab" href="#tab-6"><span style="color: green;">&#9632; </span> NOTA DE DEBITO ELECTRONICA
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
                                            <td>FITOBONOS S.A.C</td>
                                            <td>20600184866</td>
                                            <td>Factura</td>
                                            <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                        </tr>
                                    </tbody>
                                    <tr><td colspan="6" align="right" style="padding-right: 2em"></td>
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
                                                <td>FM00-00000001</td>
                                                <td>NETKA S.A.Ctd</td>
                                                <td>20603807104</td>
                                                <td>Factura</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);">
                                                </td>
                                                <td>2</td>
                                                <td>FM00-00000002</td>
                                                <td>NETKA S.A.Ctd</td>
                                                <td>20603807104</td>
                                                <td>Factura</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);">
                                                </td>
                                                <td>3</td>
                                                <td>FM00-00000003</td>
                                                <td>NETKA S.A.Ctd</td>
                                                <td>20603807104</td>
                                                <td>Factura</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);">
                                                </td>
                                                <td>4</td>
                                                <td>FM00-00000002</td>
                                                <td>NETKA S.A.Ctd</td>
                                                <td>20603807104</td>
                                                <td>Factura</td>
                                                <td><button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></td>
                                            </tr>
                                        </tbody>
                                        <tr><td colspan="6" align="right" style="padding-right: 2em"></td>
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
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 20,
            responsive: true,
            order: [[0, "desc"]],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [ ]
        });
    });
</script>
@endsection