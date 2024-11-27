@extends('layout')

@section('title', 'Nota Debito Boleta - lista')
@section('breadcrumb', 'Nota Debito Boleta - lista')
@section('breadcrumb2', 'Nota Debito Boleta - lista')
@section('href_accion', route('nota-debito.index'))
@section('value_accion', 'Atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a href="#tab-1" class="nav-link active" data-toggle="tab">Boletas</a></li>
                            <li><a href="#tab-2" class="nav-link" data-toggle="tab">Boleta Manual</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1" role="tab-panel">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Codigo de Guia</th>
                                                    <th>Cliente</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Fecha emision</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($boletas as $boleta)
                                                <tr class="gradeX">
                                                    <td>{{$boleta->id}}</td>
                                                    <td>{{$boleta->codigo_boleta}}</td>
                                                    <td>{{$boleta->cliente->nombre}}</td>
                                                    <td>{{$boleta->cliente->numero_documento}}</td>
                                                    <td>{{$boleta->fecha_emision}}</td>
                                                    <td>
                                                        <form method="POST" action="{{route('nota-debito.create_nota_debito_boleta')}}">
                                                          @csrf
                                                          <input type="hidden" name="tipo" value="normal">
                                                          <input type="hidden" name="boleta_id" value="{{$boleta->id}}">
                                                          <button type="submit" class="btn btn-sm btn-primary">Aplicar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-2" role="tab-pane"l">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Codigo de Guia</th>
                                                    <th>Cliente</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Fecha emision</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($boleta_manual as $boleta)
                                                <tr class="gradeX">
                                                    <td>{{$boleta->id}}</td>
                                                    <td>{{$boleta->codigo_boleta}}</td>
                                                    <td>{{$boleta->cliente->nombre}}</td>
                                                    <td>{{$boleta->cliente->numero_documento}}</td>
                                                    <td>{{$boleta->fecha_emision}}</td>
                                                    <td>
                                                        <form method="POST" action="{{route('nota-debito.create_nota_debito_boleta')}}">
                                                          @csrf
                                                          <input type="hidden" name="tipo" value="manual">
                                                          <input type="hidden" name="boleta_id" value="{{$boleta->id}}">
                                                          <button type="submit" class="btn btn-sm btn-primary">Aplicar</button>
                                                        </form>
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



<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="container col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h2><strong>Listado de Nota de Débito</strong></h2>
                            </div>
                            <div class="panel-body">
                                <div class="tabs-container">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#tab-3">Boleta</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tab-4">Boleta Manual</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tab-3" class="tab-pane active">
                                            <div class="panel-body">
                                                <!-- Filtros -->
                                                <div class="search-responsive mb-4">
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6 col-sm-12">
                                                            <div class="input-group">
                                                                <input class="form-control" type="text" name="daterange"
                                                                    id="data_range_filter"
                                                                    value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}" readonly="readonly" />
                                                                <span class="input-group-append">
                                                                    <button type="button" class="btn btn-secondary" id="revert_select">
                                                                        <i class="fa fa-history"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-6 col-sm-12">
                                                            <input type="search" class="form-control" placeholder="Buscar:"
                                                                id="search_all_column">
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-12">
                                                            <button type="button" class="btn btn-block btn-primary"
                                                                id="filter_buttons">Buscar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered dataTables-example-boleta">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Código</th>
                                                                <th>RUC/DNI</th>
                                                                <th>Fecha</th>
                                                                <th>Cliente</th>
                                                                <th>Importe Total</th>
                                                                <th>Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                @foreach($boletas as $boleta)
                                                                <tr class="gradeX">
                                                                    <td>{{$boleta->id}}</td>
                                                                    <td>{{$boleta->codigo_boleta}}</td>
                                                                    <td>{{$boleta->cliente->numero_documento}}</td>
                                                                    <td>{{$boleta->fecha_emision}}</td> 
                                                                    <td>{{$boleta->cliente->nombre}}</td>
                                                                    <span hidden>{{$subtotal = $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada }} </span>
                                                                    <td>{{$boleta->moneda->simbolo}} {{number_format(round(($subtotal+($boleta->op_gravada*$igv->renta/100)),2),2)}}</td>
                                                                    <td>
                                                                        <form method="POST" action="{{route('nota-debito.create_nota_debito_boleta')}}">
                                                                          @csrf
                                                                          <input type="hidden" name="tipo" value="normal">
                                                                          <input type="hidden" name="boleta_id" value="{{$boleta->id}}">
                                                                          <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @endforeach 
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Tab 2 -->
                                        <div id="tab-4" class="tab-pane">
                                            <div class="panel-body">
                                                <div class="search-responsive mb-4">
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6 col-sm-12">
                                                            <div class="input-group">
                                                                <input class="form-control" type="text" name="daterange"
                                                                    id="data_range_filter"
                                                                    value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}" readonly="readonly" />
                                                                <span class="input-group-append">
                                                                    <button type="button" class="btn btn-secondary" id="revert_select">
                                                                        <i class="fa fa-history"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-6 col-sm-12">
                                                            <input type="search" class="form-control" placeholder="Buscar:"
                                                                id="search_all_column">
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-12">
                                                            <button type="button" class="btn btn-block btn-primary"
                                                                id="filter_buttons">Buscar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered dataTables-example-boletam">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Código</th>
                                                                <th>RUC/DNI</th>
                                                                <th>Fecha</th>
                                                                <th>Cliente</th>
                                                                <th>Importe Total</th>
                                                                <th>Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($boleta_manual as $boletam)
                                                            <tr class="gradeX">
                                                                <td>{{$boletam->id}}</td>
                                                                <td>{{$boletam->codigo_boleta}}</td>
                                                                <td>{{$boletam->cliente->numero_documento}}</td>
                                                                <td>{{$boletam->fecha_emision}}</td>
                                                                <td>{{$boletam->cliente->nombre}}</td>
                                                                <span hidden>{{$subtotal = $boletam->op_gravada + $boletam->op_inafecta + $boletam->op_exonerada }} </span>
                                                                <td>{{$boletam->moneda->simbolo}} {{number_format(round(($subtotal+($boletam->op_gravada*$igv->renta/100)),2),2)}}</td>
                                                                <td>
                                                                    <form method="POST" action="{{route('nota-debito.create_nota_debito_boleta')}}">
                                                                        @csrf
                                                                        <input type="hidden" name="tipo" value="manual">
                                                                        <input type="hidden" name="boleta_id" value="{{$boletam->id}}">
                                                                    <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @endforeach 
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
            </div>
        </div>
    </div>
</div>

        <style>
            select.form-control:not([size]):not([multiple]) {
                height: 100%;
            }
    
            .dropdown-menu {
                left: 70px;
                padding: 20px 0;
            }
    
            #DataTables_Table_0_wrapper {
                /* padding-right: 0px; */
            }
    
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
    
            /* PANTALLA TABLET */
            @media (min-width: 768px) and (max-width: 991.98px) {
                .row>.col-md-6 {
                    margin-bottom: 12px;
                }
            }
        </style>


<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []

        });

        $('.dataTables-example-boleta').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []

        });

        $('.dataTables-example-boletam').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []

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
        });
    });

</script>
@endsection
