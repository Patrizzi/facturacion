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
                                    <div role="tabpanel" id="tab-1" class="tab-pane">
                                    </div>

                                    <!-- Contenido de Tab 2 -->
                                    <div role="tabpanel" id="tab-2" class="tab-pane">
                                    </div>
                                    <!-- Contenido de Tab 3 -->
                                    <div role="tabpanel" id="tab-3" class="tab-pane">

                                    </div>
                                    <!-- Contenido de Tab 4 -->
                                    <div role="tabpanel" id="tab-4" class="tab-pane active show">
                                        <div class="panel-body">
                                            <!-- CONTENIDO DENTRO DEL TAB 4 -->
                                            <div class="row align-items-center">
                                                                <div class="col-md-6 mb-2">
                                                                <div class="input-group">
                                                                    <input type="search" id="botonBuscar" name="botonBuscar" class="form-control" placeholder="Buscar...">
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
                                                                <div class="col-md-1 mb-1 d-flex justify-content-end">
                                                                    
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

                                            <div class="ibox-title" style="text-align: center;">
                                            <h5>Compras Productos</h5>
                                            <div class="table-responsive">
                                                <table id="tablacompra" class="table table-striped table-hover text-center datatables-compra">
                                                    <thead>
                                                    <tr>
                                                        <th><input type="checkbox"  checked class="i-checks" name="input[]"></th>
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
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                            <div class="ibox-title" style="text-align: center;">
                                                <h5>Facturas</h5>
                                            <div class="table-responsive">
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
                                            </div>

                                            <div class="ibox-title" style="text-align: center;">
                                                <h5>Boletas</h5>
                                            <div class="table-responsive">
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
    #DataTables_Table_1_length{
        display:none;
    }
    #DataTables_Table_1_filter{
        display: none;
    }
    #DataTables_Table_2_length{
        display:none;
    }
    #DataTables_Table_2_filter{
        display: none;
    }
    div.dt-buttons{
        display: none;
    }
</style>

<script>
    $(document).ready(function(e) {
        $('#tab-4').addClass('active show');
        
        $('#botonBuscar').on('click', function() {
                    $.ajax({
                    method: "POST",
                    url: "{{ route('ajax_movimiento') }}",
                    data:$("#formulario").serialize()
                }).done(function(res){
                    $('#tablacompra').dataTable().fnDestroy();
                    var data=JSON.parse(res);
                    $('#tablacompra').dataTable({
                            pageLength: 25,
                            responsive: true,
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [],
                        "aaData": data,
                        "columns": [
                            { "data": "fecha_compra" },
                            { "data": "codigo_guia" },
                            { "data": "provedor.empresa" , "defaultContent": ""},
                            { "data": "provedor.ruc" , "defaultContent": ""},
                            { "data": "factura" },
                            { "data": "subtotal"},
                            { "data": "igv" },
                            { "data": "precio_nacional_total" }
                        ]
                    });

                });



                $('#tbody_venta tr').slice(1).remove();
                $.ajax({
                    method: "POST",
                    url: "{{ route('ajax_movimiento_ventas') }}",
                    data:$("#formulario").serialize()
                }).done(function(res){
                    $('#tablaid_venta').dataTable().fnDestroy();
                    var data=JSON.parse(res);
                    $('#tablaid_venta').dataTable({
                            pageLength: 25,
                            responsive: true,
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                {extend: 'copy'},
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
                            ],
                        "aaData": data,
                        "columns": [
                            { "data": "fecha_emision" , "defaultContent": "" },
                            { "data": "codigo_fac" },
                            { "data": "cliente.nombre" , "defaultContent": ""},
                            { "data": "cliente.numero_documento" , "defaultContent": ""},
                            { "data": "codigo_fac" },
                            { "data": "moneda.nombre","defaultContent": "" },
                            { "data": "subtotal"},
                            { "data": "igv" },
                            { "data": "precio" }
                        ]
                    })
                });

                $('#tbody_venta_b tr').slice(1).remove();
                $.ajax({
                    method: "POST",
                    url: "{{ route('ajax_movimiento_ventas_b') }}",
                    data:$("#formulario").serialize()
                }).done(function(res){
                    $('#tablaid_venta_b').dataTable().fnDestroy();
                    var data=JSON.parse(res);
                    $('#tablaid_venta_b').dataTable({
                            pageLength: 25,
                            responsive: true,
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                {extend: 'copy'},
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
                            ],
                        "aaData": data,
                        "columns": [
                            { "data": "fecha_emision" , "defaultContent": "" },
                            { "data": "codigo_boleta" },
                            { "data": "cliente.nombre" , "defaultContent": ""},
                            { "data": "cliente.numero_documento" , "defaultContent": ""},
                            { "data": "codigo_boleta" },
                            { "data": "moneda.nombre","defaultContent": "" },
                            { "data": "subtotal"},
                            { "data": "igv" },
                            { "data": "precio" }
                        ]
                    })
                });
		});
    });
</script>

<script>
        function valida(f) {
            var botonBuscar=document.getElementById("botonBuscar");
            var completo = true;
            var incompleto = false;
            if( f.elements[0].value == "" )
               { alert(incompleto); }
           else{botonBuscar.type = 'button';}
       }
</script>




@endsection
