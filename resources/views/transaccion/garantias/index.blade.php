@extends('layout')
@section('title', 'Guias Ingreso')
@section('breadcrumb', 'Guia de ingreso')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

{{-- Base para Agregar recuadro blanco donde deberia ir el contenido general de lo nuevo que se agrega--}}

<div class="wrapper wrapper-content animated fadeInRight">
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

{{--Base para agregar el tab para el los contenidos--}}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1"><span style="color: green;">&#9632; </span> GUIA DE INGRESO
                                    {{-- link del tab 1 --}}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-2"><span style="color: orange;">&#9632;</span> GUIA DE EGRESO
                                    {{-- link del tab 2 --}}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-3"><span style="color: red;">&#9632;</span> GUIA DE INFORME TECNICO
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
                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
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
                                        <tr>
                                            <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                            
                                            <td>1</td>
                                            <td>FA00-00000001</td>
                                            <td>203837834</td>
                                            <td>Fact1</td>
                                            <td>Jul 14, 2013</td>
                                            <td>Contado</td>
                                            <td>S/ 1,800.00</td>
                                            <td>
                                                <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                    <i class="fa fa-check" style="color:white;"></i>
                                                </a>
                                                <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                    <i class="bi bi-eye-fill" style="color:white;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                            
                                            <td>2</td>
                                            <td>FA00-00000001</td>
                                            <td>23908223</td>
                                            <td>Dexter</td>
                                            <td>Jul 16, 2013</td>
                                            <td>Contado</td>
                                            <td>s/ 2,456.50</td>
                                            <td>
                                                <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                    <i class="fa fa-check" style="color:white;"></i>
                                                </a>
                                                <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                    <i class="bi bi-eye-fill" style="color:white;"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                            
                                            <td>3</td>
                                            <td>FA00-00000001</td>
                                            <td>23908223</td>
                                            <td>Dexter</td>
                                            <td>Jul 18, 2013</td>
                                            <td>Contado</td>
                                            <td>s/ 2,456.50</td>
                                            <td>
                                                <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                    <i class="fa fa-check" style="color:white;"></i>
                                                </a>
                                                <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                    <i class="bi bi-eye-fill" style="color:white;"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                            
                                            <td>4</td>
                                            <td>FA00-00000001</td>
                                            <td>23908223</td>
                                            <td>Dexter</td>
                                            <td>Jul 22, 2013</td>
                                            <td>Contado</td>
                                            <td>s/ 2,456.50</td>
                                            <td>
                                                <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                    <i class="fa fa-check" style="color:white;"></i>
                                                </a>
                                                <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                    <i class="bi bi-eye-fill" style="color:white;"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
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
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>1</td>
                                                <td>FM00-00000002</td>
                                                <td>203837834</td>
                                                <td>Fact2</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Contado</td>
                                                <td>S/ 1,800.00</td>
                                                <td>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                        <i class="fa fa-check" style="color:white;"></i>
                                                    </a>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                        <i class="bi bi-eye-fill" style="color:white;"></i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>2</td>
                                                <td>FM00-00000002</td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 16, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                        <i class="fa fa-check" style="color:white;"></i>
                                                    </a>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                        <i class="bi bi-eye-fill" style="color:white;"></i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>3</td>
                                                <td>FM00-00000002</td>
                                                <td>23908223</td>
                                                <td>Jacinto</td>
                                                <td>Jul 18, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                        <i class="fa fa-check" style="color:white;"></i>
                                                    </a>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                        <i class="bi bi-eye-fill" style="color:white;"></i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>4</td>
                                                <td>FM00-00000002</td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 22, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                        <i class="fa fa-check" style="color:white;"></i>
                                                    </a>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                        <i class="bi bi-eye-fill" style="color:white;"></i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                        <tr>
                                            <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
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
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>1</td>
                                                <td>FM00-00000003</td>
                                                <td>203837834</td>
                                                <td>Fact2</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Contado</td>
                                                <td>S/ 1,800.00</td>
                                                <td>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                        <i class="fa fa-check" style="color:white;"></i>
                                                    </a>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                        <i class="bi bi-eye-fill" style="color:white;"></i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>2</td>
                                                <td>FM00-00000003</td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 16, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                        <i class="fa fa-check" style="color:white;"></i>
                                                    </a>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                        <i class="bi bi-eye-fill" style="color:white;"></i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>3</td>
                                                <td>FM00-00000003</td>
                                                <td>23908223</td>
                                                <td>Jacinto</td>
                                                <td>Jul 18, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                        <i class="fa fa-check" style="color:white;"></i>
                                                    </a>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                        <i class="bi bi-eye-fill" style="color:white;"></i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>                                                
                                                <td>4</td>
                                                <td>FM00-00000003</td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 22, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#007bff; border-radius:5px; margin-right:2px;">
                                                        <i class="fa fa-check" style="color:white;"></i>
                                                    </a>
                                                    <a href="#" style="display:inline-block; padding:5px; background-color:#28a745; border-radius:5px;">
                                                        <i class="bi bi-eye-fill" style="color:white;"></i>
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

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function() {
        table = $('.dataTables-example-facturacion').DataTable({
            pageLength: 10,
            order: [
                [0, "desc"]
            ],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            footerCallback: function(tr, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total filtered rows on the selected column (code part added)
                var sumCol4Filtered = display.map(el => data[el][5]).reduce((a, b) => intVal(a) +
                    intVal(b), 0);

                // Update footer
                $(api.column(5).footer()).html(
                    'S/ ' + Math.round(sumCol4Filtered * 100) / 100
                );
            },
            buttons: []
        });

        revert_select();

        $(document).on('change', '#select_tipo_coti', function(event) {
            var nombre = $("#select_tipo_coti option:selected").val();
            // console.log(nombre);
            table.column(11).search(nombre).draw();
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
        table.column(4).search({{ date('m-Y') }}).draw();
    }


</script>


    @endsection











