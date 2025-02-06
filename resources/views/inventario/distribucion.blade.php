@extends('layout')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
    <!-- Sección de Inventario -->
    <div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    @include('inventario\tabs1')
                                </ul>
                                <div class="tab-content">
                                    <!-- Contenido de Tab 1 -->
                                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                                        <div class="panel-body">
                                            <!-- ANIDAMOS MÁS TABS AQUÍ -->
                                            <div class="tabs-container">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    @include('inventario\tabs2')
                                                </ul>

                                                <div class="tab-content">
                                                    <div role="tabpanel" id="contenido-tab-1" class="tab-pane ">
                                                    </div>

                                                    <div role="tabpanel" id="contenido-tab-2" class="tab-pane active show">
                                                        <div class="panel-body">
                                                        <div class="row align-items-center">
                                                                <div class="col-md-5 mb-2">
                                                                <div class="input-group">
                                                                    <input type="search" id="search" class="form-control" placeholder="Buscar...">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary" type="button" style="background-color: blue; border-color:blue;">Buscar</button>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                                <div class="col-md-5 mb-2">
                                                                    <div class="input-group">
                                                                    <input type="text" id="daterange" name="daterange" class="form-control"value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}">
                                                                        <div class="input-group-append">
                                                                            <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                                                                <i class="fa fa-history"></i>
                                                                            </button>
                                                                            <button type="button" class="btn btn-primary" style="background-color: blue; border-color:blue;"   onclick="limpiar_select()">
                                                                                <i class="fa fa-eraser"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 mb-2 d-flex justify-content-end">
                                                                    <button class="btn btn-success mr-2" style="background-color: blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cloud-download"></i></button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item" href="#">Copy</a>
                                                                            <a class="dropdown-item" href="#">CSV</a>
                                                                            <a class="dropdown-item" href="#">Excel</a>
                                                                            <a class="dropdown-item" href="#">PDF</a>
                                                                            <a class="dropdown-item" href="#">Print</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-hover text-center datatables-distribucion">
                                                                    <thead>
                                                                    <tr>

                                                                        <th></th>
                                                                        <th>ID </th>
                                                                        <th>Código</th>
                                                                        <th>F. Distribución</th>
                                                                        <th>Cant.Productos</th>
                                                                        <th>Cant.Total</th>
                                                                        <th>Almacén</th>
                                                                        <th>Guía de Remisión</th>
                                                                        <th>Ver</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <span hidden="hidden">{{$i=1}}</span>
                                                                    @foreach($kardex_distribucion as $index => $kardex_distribuciones)
                                                                    <tr>
                                                                        <td><input type="checkbox"  checked class="i-checks" name="input[]"></td>
                                                                        <td> {{$i++}}</td>
                                                                        <td>{{$kardex_distribuciones->codigo_guia}}</td>
                                                                        <td>{{$kardex_distribuciones->created_at->format('d/m/Y')}}</td>
                                                                        <td>{{$cantidad_prod[$index]}} @if($cantidad_prod[$index] > 1 ) productos @else producto @endif</td>
                                                                        <td>{{$cantidad_tot[$index]}} items </td>
                                                                        <td>{{$kardex_distribuciones->almacen->nombre}}</td>
                                                                        <td>{{$kardex_distribuciones->cod_guia_remisio}}</td>
                                                                        <td>
                                                                            <a href="{{ route('kardex-entrada-Distribucion.show', $kardex_distribuciones->id) }}">
                                                                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div role="tabpanel" id="contenido-tab-3" class="tab-pane">
                                                    </div>

                                                    <div role="tabpanel" id="contenido-tab-4" class="tab-pane">                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- FIN DE LOS TABS ANIDADOS -->
                                        </div>
                                    </div>

                                    <!-- Contenido de Tab 2 -->
                                    <div role="tabpanel" id="tab-2" class="tab-pane"> 
                                    </div>
                                    <!-- Contenido de Tab 3 -->
                                    <div role="tabpanel" id="tab-3" class="tab-pane">
                                    </div>
                                    <!-- Contenido de Tab 4 -->
                                    <div role="tabpanel" id="tab-4" class="tab-pane">
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
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
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
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- check -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

    });

</script>

<style>
    #DataTables_Table_0_length{
        display:none;
    }
    #DataTables_Table_0_filter{
        display: none;
    }
    div.dt-buttons{
        display: none;
    }
</style>

<script>
    //dataTables-example
    $(document).ready(function () {
        // Asegúrate de que el tab esté activo
        $('#contenido-tab-2').addClass('active show');

        $('.datatables-distribucion').DataTable({
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

        function limpiar_select() {
            table.column(4).search("").draw();
        }
        function revert_select() {
            table.column(4).search(`{{ date('m-Y') }}`).draw();
        }

</script>

<!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<script>
    document.getElementById("btn-agregar-EP").onclick = function() {
        document.getElementById("formulario-agregar-producto").style.display = "block";
    };

    function cerrarFormulario() {
        document.getElementById("formulario-agregar-producto").style.display = "none";
    }
</script>

@endsection
