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
                                                    <div role="tabpanel" id="contenido-tab-1" class="tab-pane active show">
                                                        <!-- Título centrado -->
                                                        <h2 style="text-align: center; margin-bottom: 20px;">Almacen Principal - Oficina Arequipa</h2>
                                                        <div class="panel-body">
                                                            <!-- Contenido de Nested Tab 1 -->
                                                            <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <!-- Barra de búsqueda y botón Buscar -->
                                                                <div style="flex-grow: 1;">
                                                                    <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                                    <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                                                </div>

                                                                <!-- Botones Agregar, Actualizar y Descarga -->
                                                                <div>
                                                                    <button class="btn btn-success" style="margin-right: 10px;"><i class="fa fa-plus"></i></button>

                                                                    <!-- Botón de Descarga con menú desplegable -->
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="fa fa-cloud-download"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="#">Copy</a>
                                                                            <a class="dropdown-item" href="#">CSV</a>
                                                                            <a class="dropdown-item" href="#">Excel</a>
                                                                            <a class="dropdown-item" href="#">PDF</a>
                                                                            <a class="dropdown-item" href="#">Print</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-hover text-center datatables-entrada">
                                                                    <thead>
                                                                        <tr>
                                                                            <th></th>
                                                                            <th>ID </th>
                                                                            <th>Código</th>
                                                                            <th>Motivo</th>
                                                                            <th>Proveedor</th>
                                                                            <th>F.Ingreso</th>
                                                                            <th>N° Guía de Remisión</th>
                                                                            <th>N° Factura</th>
                                                                            <th>Acciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><input type="checkbox"  checked class="i-checks" name="input[]"></td>
                                                                            <td>01</td>
                                                                            <td>GE001-00000001</td>
                                                                            <td>COMPRAS LOCALES</td>
                                                                            <td>GRUPO INFOZONAL S.A.C.</td>
                                                                            <td>10/01/2022</td>
                                                                            <td>0001</td>
                                                                            <td>0001</td>
                                                                            <td>
                                                                                <p>
                                                                                    <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                                    <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
                                                                                </p>
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div role="tabpanel" id="contenido-tab-2" class="tab-pane">
                                                        <div class="panel-body">
                                                            <!-- Contenido de Nested Tab 2 -->
                                                            <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <!-- Barra de búsqueda y botón Buscar -->
                                                                <div style="flex-grow: 1;">
                                                                    <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                                    <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                                                </div>

                                                                <!-- Botones Agregar, Actualizar y Descarga -->
                                                                <div>
                                                                    <button class="btn btn-success" style="margin-right: 10px;"><i class="fa fa-plus"></i></button>

                                                                    <!-- Botón de Descarga con menú desplegable -->
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="fa fa-cloud-download"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="#">Copy</a>
                                                                            <a class="dropdown-item" href="#">CSV</a>
                                                                            <a class="dropdown-item" href="#">Excel</a>
                                                                            <a class="dropdown-item" href="#">PDF</a>
                                                                            <a class="dropdown-item" href="#">Print</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
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
                                                                    <tr>
                                                                        <td><input type="checkbox"  checked class="i-checks" name="input[]"></td>
                                                                        <td>01</td>
                                                                        <td>GE001-00000001</td>
                                                                        <td>10/01/2022</td>
                                                                        <td>1000</td>
                                                                        <td>250</td>
                                                                        <td>ALMACEN</td>
                                                                        <td>0001</td>
                                                                        <td>
                                                                            <p>
                                                                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                                        <td>01</td>
                                                                        <td>GE001-00000001</td>
                                                                        <td>15/05/2022</td>
                                                                        <td>1500</td>
                                                                        <td>530</td>
                                                                        <td>ALMACEN</td>
                                                                        <td>0002</td>
                                                                        <td>
                                                                            <p>
                                                                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                                        <td>01</td>
                                                                        <td>GE001-00000001</td>
                                                                        <td>21/10/2023</td>
                                                                        <td>2300</td>
                                                                        <td>700</td>
                                                                        <td>ALMACEN</td>
                                                                        <td>0003</td>
                                                                        <td>
                                                                            <p>
                                                                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>




                                                            <br>
                                                            <!--
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
                                                                <button class="btn btn-white">1</button>
                                                                <button class="btn btn-white  active">2</button>
                                                                <button class="btn btn-white">3</button>
                                                                <button class="btn btn-white">4</button>
                                                                <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i> </button>
                                                            </div>
                                                            -->

                                                        </div>
                                                    </div>
                                                    <div role="tabpanel" id="contenido-tab-3" class="tab-pane">
                                                        <div class="panel-body">
                                                            <!-- Contenido de Nested Tab 3 -->
                                                            <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <!-- Barra de búsqueda y botón Buscar -->
                                                                <div style="flex-grow: 1;">
                                                                    <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                                    <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                                                </div>

                                                                <!-- Botones Agregar, Actualizar y Descarga -->
                                                                <div>
                                                                    <button class="btn btn-success" style="margin-right: 10px;"><i class="fa fa-plus"></i></button>

                                                                    <!-- Botón de Descarga con menú desplegable -->
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="fa fa-cloud-download"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="#">Copy</a>
                                                                            <a class="dropdown-item" href="#">CSV</a>
                                                                            <a class="dropdown-item" href="#">Excel</a>
                                                                            <a class="dropdown-item" href="#">PDF</a>
                                                                            <a class="dropdown-item" href="#">Print</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-hover text-center datatables-traslado">
                                                                    <thead>
                                                                    <tr>

                                                                        <th></th>
                                                                        <th>ID </th>
                                                                        <th>Código</th>
                                                                        <th>Almacén - Emisor</th>
                                                                        <th>Almacén - Receptor</th>
                                                                        <th>Acciones</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td><input type="checkbox"  checked class="i-checks" name="input[]"></td>
                                                                        <td>01</td>
                                                                        <td>GE001-00000001</td>
                                                                        <td>CENTRAL</td>
                                                                        <td>MIRAFLORES</td>
                                                                        <td>
                                                                            <p>
                                                                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                                <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                                        <td>02</td>
                                                                        <td>GE001-00000001</td>
                                                                        <td>MIRAFLORE</td>
                                                                        <td>WILSON</td>
                                                                        <td>
                                                                            <p>
                                                                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                                <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                                        <td>03</td>
                                                                        <td>GE001-00000001</td>
                                                                        <td>WILSON</td>
                                                                        <td>CENTRAL</td>
                                                                        <td>
                                                                            <p>
                                                                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                                <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div role="tabpanel" id="contenido-tab-4" class="tab-pane">
                                                        <!-- Título centrado -->
                                                        <h2 style="text-align: center; margin-bottom: 20px;">Creacion de Almacen</h2>
                                                        <div class="panel-body">
                                                            <!-- Contenido de Nested Tab 4 -->
                                                            <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                                <!-- Barra de búsqueda y botón Buscar -->
                                                                <div style="flex-grow: 1;">
                                                                    <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                                    <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                                                </div>

                                                                <!-- Botones Agregar, Actualizar y Descarga -->
                                                                <div>
                                                                    <button class="btn btn-success" style="margin-right: 10px;"><i class="fa fa-plus"></i></button>

                                                                    <!-- Botón de Descarga con menú desplegable -->
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="fa fa-cloud-download"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="#">Copy</a>
                                                                            <a class="dropdown-item" href="#">CSV</a>
                                                                            <a class="dropdown-item" href="#">Excel</a>
                                                                            <a class="dropdown-item" href="#">PDF</a>
                                                                            <a class="dropdown-item" href="#">Print</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-hover text-center datatables-salida">
                                                                    <thead>
                                                                    <tr>

                                                                        <th></th>
                                                                        <th>ID </th>
                                                                        <th>Motivo</th>
                                                                        <th>Información</th>
                                                                        <th>Ver</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td><input type="checkbox"  checked class="i-checks" name="input[]"></td>
                                                                        <td>01</td>
                                                                        <td>DEVOLUCION CLIENTE</td>
                                                                        <td>SALIDA</td>
                                                                        <td>
                                                                            <p>
                                                                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                                        <td>02</td>
                                                                        <td>DEVOLUCION CLIENTE</td>
                                                                        <td>SALIDA</td>
                                                                        <td>
                                                                            <p>
                                                                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                                        <td>03</td>
                                                                        <td>DEVOLUCION CLIENTE</td>
                                                                        <td>SALIDA</td>
                                                                        <td>
                                                                            <p>
                                                                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <br>
                                                        </div>
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
        $('#tab-1').addClass('active show');

        $('.datatables-entrada').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
        $('.datatables-distribucion').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
        $('.datatables-traslado').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
        $('.datatables-salida').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
        $('.datatables-compra-producto').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
        $('.datatables-facturas').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
        $('.datatables-boletas').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
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


<!-- scrip para los calendarios -->
<script>
    $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#reportrange').daterangepicker({
        format: 'MM/DD/YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: { days: 60 },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });
</script>
<script>
    $('#reportrange1 span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#reportrange1').daterangepicker({
        format: 'MM/DD/YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: { days: 60 },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange1 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });
</script>
<script>
    $('#reportrange2 span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#reportrange2').daterangepicker({
        format: 'MM/DD/YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: { days: 60 },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });
</script>

@endsection
