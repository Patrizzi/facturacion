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
                                    </div>

                                    <!-- Contenido de Tab 2 -->
                                    <div role="tabpanel" id="tab-2" class="tab-pane">
                                    </div>
                                    <!-- Contenido de Tab 3 -->
                                    <div role="tabpanel" id="tab-3" class="tab-pane">

                                    </div>
                                    <!-- Contenido de Tab 4 -->
                                    <div role="tabpanel" id="tab-4" class="tab-pane">
                                        <div class="panel-body">
                                            <!-- CONTENIDO DENTRO DEL TAB 4 -->
                                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                                                <!-- Calendario -->
                                                <div id="reportrange1" class="form-control">
                                                    <i class="fa fa-calendar"></i>
                                                    <span>October 22, 2024 - November 20, 2024</span> <b class="caret"></b>
                                                </div>

                                                <!-- Botones -->
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <div style="display: flex; gap: 10px;">
                                                        <div style="position: relative;">
                                                            <button class="btn btn-success" style="margin-right: 10px;"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>

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
                                                <h3 class="text-center">COMPRAS PRODUCTOS</h3> <!-- Título más prominente -->
                                                <br>
                                                <table class="table table-striped table-hover text-center datatables-compra-producto">
                                                    <thead>
                                                    <tr>

                                                        <th></th>
                                                        <th>Fecha</th>
                                                        <th>N° Ruc</th>
                                                        <th>Proveedor</th>
                                                        <th>Ruc</th>
                                                        <th>N° Doc. Proveedor</th>
                                                        <th>Sub total</th>
                                                        <th>IGV</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><input type="checkbox"  checked class="i-checks" name="input[]"></td>
                                                        <td>23/10/2024</td>
                                                        <td>20601381461</td>
                                                        <td>IMPACTO</td>
                                                        <td>26958463245</td>
                                                        <td>72846344</td>
                                                        <td>S/ 1200</td>
                                                        <td>S/ 216</td>
                                                        <td>S/ 1416</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
                                                <h3 class="text-center">FACTURAS</h3> <!-- Título más prominente -->
                                                <br>
                                                <table class="table table-striped table-hover text-center datatables-facturas">
                                                    <thead>
                                                    <tr>

                                                        <th></th>
                                                        <th>Fecha</th>
                                                        <th>N° Ruc</th>
                                                        <th>Proveedor</th>
                                                        <th>Ruc</th>
                                                        <th>N° Doc</th>
                                                        <th>Moneda</th>
                                                        <th>Sub total</th>
                                                        <th>IGV</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><input type="checkbox"  checked class="i-checks" name="input[]"></td>
                                                        <td>23/10/2024</td>
                                                        <td>20956328574</td>
                                                        <td>LOGISTICA FERRE</td>
                                                        <td>20635894521</td>
                                                        <td>84526955</td>
                                                        <td>PEN</td>
                                                        <td>s/ 1200</td>
                                                        <td>S/ 216</td>
                                                        <td>S/ 1416</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
                                                <h3 class="text-center">BOLETAS</h3> <!-- Título más prominente -->
                                                <br>
                                                <table class="table table-striped table-hover text-center datatables-boletas">
                                                    <thead>
                                                    <tr>

                                                        <th></th>
                                                        <th>Fecha</th>
                                                        <th>N° Doc</th>
                                                        <th>Cliente</th>
                                                        <th>Ruc</th>
                                                        <th>N° Doc</th>
                                                        <th>Moneda</th>
                                                        <th>Sub total</th>
                                                        <th>IGV</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><input type="checkbox"  checked class="i-checks" name="input[]"></td>
                                                        <td>23/10/2024</td>
                                                        <td>20956328574</td>
                                                        <td>LOGISTICA FERRE</td>
                                                        <td>20635894521</td>
                                                        <td>84526955</td>
                                                        <td>PEN</td>
                                                        <td>s/ 1200</td>
                                                        <td>S/ 216</td>
                                                        <td>S/ 1416</td>
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
    div.datatables_length{
        display:none;
    }
    div.datatables_filter{
        display: none;
    }
    div.dt-buttons{
        display: none;
    }
</style>

<script>
    //dataTables-example
    $(document).ready(function(){
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
        
        $('.datatables-cierre').DataTable({
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
