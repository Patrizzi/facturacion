@extends('layout')

@section('title', ' Guias Egreso')
@section('breadcrumb', 'Guias de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.guias'))
@section('value_accion', 'Agregar')


@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="wrapper wrapper-content animated fadeInRight pb-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title" style="display: flex; align-items: center;">
                    <span>RESUMEN DE SEPTIEMBRE DEL 2024</span>
                </div>

                <div class="ibox-content">
                    {{-- Acá iria el tema del contenido --}}
                    <div class="card-group">
                        <div class="card p-3" style="border: none;">
                            <div class="d-flex justify-content-center align-items-center card-img-top">
                                <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 3rem;">
                                    <i class="bi bi-cloud-arrow-down-fill text-white"></i>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title" style="font-size: 18px">Guia de Ingreso</h5>
                                <p class="card-text" style="font-size: 14px">5 Documentos</p>
                                <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                        <div class="card p-3" style="border: none;">
                            <div class="d-flex justify-content-center align-items-center card-img-top">
                                <div class="bg-success rounded-circle d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 3rem;">
                                    <i class="bi bi-cloud-check-fill text-white"></i>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title" style="font-size: 18px">Guia de Egreso</h5>
                                <p class="card-text" style="font-size: 14px">3 Documentos</p>
                                <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                        <div class="card p-3" style="border: none;">
                            <div class="d-flex justify-content-center align-items-center card-img-top">
                                <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 3rem;">
                                    <i class="bi bi-clipboard2-data-fill text-white"></i>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title" style="font-size: 18px">Guia de Informe Tecnico</h5>
                                <p class="card-text" style="font-size: 14px">8 Documentos</p>
                                <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight pt-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs d-flex justify-content-between align-items-center" role="tablist">
                            @include('transaccion\garantias\tabs')
                        </ul>

                        <div class="tab-content">
                            <div class="d-flex justify-content-md-start row mx-3 mt-4">
                                <div class="input-group col-md-4 mx-5">
                                    <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                    <input class="form-control" type="text" name="daterange3"
                                        value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                            <i class="fa fa-history"></i>
                                        </button>
                                    </span>
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="limpiar_select()">
                                            <i class="fa fa-eraser"></i>
                                        </button>
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
                            <div role="tabpanel" id="tab-1" class="tab-pane">
                                <div class="panel-body">
                                    {{-- CONTENIDO DENTRO DEL TAB  1 --}}
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane active show">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <div class="table-responsive">
                                        <table class="table table-striped dataTables-example3">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                    <th >ID</th>
                                                    <th >Orden Servicio</th>
                                                    <th >Marca</th>
                                                    <th>Fecha</th>
                                                    <th>Motivo</th>
                                                    <th >Asuntos</th>
                                                    <th >Cliente</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($garantias_guias_egresos as $garantias_guias_egreso)
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                    <td>{{$garantias_guias_egreso->id}}</td>
                                                    <td>{{$garantias_guias_egreso->orden_servicio}}
                                                    <td>{{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre}}
                                                    <td>{{$garantias_guias_egreso->garantia_ingreso_i->fecha}}</td>
                                                    <td>{{$garantias_guias_egreso->garantia_ingreso_i->motivo}}</td>
                                                    <td>{{$garantias_guias_egreso->garantia_ingreso_i->asunto}}</td>
                                                    <td>{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}</td>
                                                    <td>
                                                        <a href="{{ route('garantia_guia_egreso.show', $garantias_guias_egreso->id) }}">
                                                        <button type="button" class="btn btn-primary"><i class="fa fa-eye" style="color:white;"></i></button></a>

                                                            @if($garantias_guias_egreso->estado==1)
                                                            <button class="btn btn-info" style="border-color: #28a745; background-color:#28a745;">
                                                            <i class="fa fa-check" style="color:white;"></i></button>
                                                            @else
                                                            <button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>
                                                            @endif

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    {{-- CONTENIDO DENTRO DEL TAB  3 --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="table_egreso" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Orden servicio</th>
                                    <th>Marca</th>
                                    <th>fecha</th>
                                    <th>Motivo</th>
                                    <th>Asunto</th>
                                    <th>Cliente</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->
</div>

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
</style>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- check -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>

<!-- Seleccionar todos los check -->
<script>
    $(document).ready(function() {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // Controlar el checkbox del thead
        $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
            var table = $(this).closest('table'); // Limita el control de checkboxes a la tabla actual
            if (event.type === 'ifChecked') {
                // Selecciona
                table.find('tbody input[type="checkbox"]').iCheck('check');
            } else {
                // Deselecciona
                table.find('tbody input[type="checkbox"]').iCheck('uncheck');
            }
        });

        // Si todos los checkboxes de tbody de la tabla visible están seleccionados, selecciona el checkbox del thead, y si no, deselecciónalo
        $('tbody input[type="checkbox"]').on('ifChanged', function(event) {
            var table = $(this).closest('table'); // Limita el control a la tabla visible
            if (table.find('tbody input[type="checkbox"]').filter(':checked').length === table.find(
                    'tbody input[type="checkbox"]').length) {
                table.find('thead input[type="checkbox"]').iCheck('check');
            } else {
                table.find('thead input[type="checkbox"]').iCheck('uncheck');
            }
        });

        // Detectar cuando se cambia de tab
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            // Restablecer el estado de los checkboxes
            var activeTab = $(e.target).attr('href'); // ID del tab activo
            $(activeTab).find('.i-checks').iCheck('update');
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('#table_egreso').DataTable({
            // "order": [[ 1, "desc" ]],
            "serverSide":true,
            "ajax":"{{url('api/garantia_egreso')}}",
            "columns":[
                {data : 'egreso_id'},
                {data : 'orden_servicio'},
                {data : 'nombre_marca'},
                {data : 'fecha'},
                {data : 'motivo'},
                {data : 'asunto'},
                {data : 'cliente_nom'},
                {
                    name: '',
                    data: null,
                    sortable: false,
                    searchable: false,
                    render: function (data) {
                        var actions = '';
                        actions += '<center><a href="{{ route('garantia_guia_egreso.show', ':id') }}"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a></center>';
                        return actions.replace(/:id/g, data.egreso_id);
                    }
                }
            ]
        });
    });

</script>

<script>
    $(document).ready(function(){
        $('#tab-2').addClass('active show');

        table = $('.dataTables-example3').DataTable({
            pageLength: 8,
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
        $('input[name="daterange3"]').daterangepicker({

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
                    table3.column(4).search(dateRangeString, true, false).draw();
                }
            );
        });
        function limpiar_select(){
            table3.column(4).search("").draw();
        }
        function revert_select() {
            table3.column(4).search(`{{ date('m-Y') }}`).draw();
        }
</script>


@endsection
