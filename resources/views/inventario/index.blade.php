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
                                    <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                        <div class="panel-body">
                                            <div class="tabs-container">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    @include('inventario\tabs2')
                                                </ul>
                                                <div class="tab-content">
                                                    <div role="tabpanel" id="contenido-tab-1" class="tab-pane active show">
                                                        <h2 class="text-center mb-4">Almacén Principal - Oficina Arequipa</h2>
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
                                                            <!-- Tabla de datos -->
                                                            <div class="table-responsive ">
                                                                <table class="table table-striped table-hover text-center datatables-entrada">
                                                                <thead>
                                                                    <tr>
                                                                    <th></th>
                                                                    <th>ID</th>
                                                                    <th>Código</th>
                                                                    <th>Motivo</th>
                                                                    <th>Proveedor</th>
                                                                    <th>F.Ingreso</th>
                                                                    <th>N° Guía de Remisión</th>
                                                                    <th>N° Factura</th>
                                                                    <th>Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody><span hidden="hidden">{{$i=0}}</span>
                                                                    @if(isset($primer_registro))
                                                                    <tr>
                                                                    <td><input type="checkbox" checked class="i-checks" name="input[]"></td>
                                                                    <td>{{$i=1}}</td>
                                                                    <td>{{$primer_registro->codigo_guia}}</td>
                                                                    <td>{{$primer_registro->codigo_guia}}</td>
                                                                    <td>{{$primer_registro->codigo_guia}}</td>
                                                                    <td>{{$primer_registro->created_at->format('d/m/Y')}}</td>
                                                                    <td>{{$primer_registro->codigo_guia}}</td>
                                                                    <td>{{$primer_registro->codigo_guia}}</td>
                                                                    <td><a href="{{ route('kardex-entrada.show', $primer_registro->id) }}"><button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button></a></td>
                                                                    </tr>
                                                                    @endif

                                                                    @foreach($kardex_entradas as $value => $kardex_entrada)
                                                                    <tr>
                                                                    <td><input type="checkbox" checked class="i-checks" name="input[]"></td>
                                                                    <td> {{$i=$i+1}}</td>
                                                                    <td>{{$kardex_entrada->codigo_guia}}</td>
                                                                    <td>{{$kardex_entrada->motivo->nombre}}</td>
                                                                    <td>{{$kardex_entrada->provedor->empresa}}</td>
                                                                    <td>{{$kardex_entrada->created_at->format('d/m/Y')}}</td>
                                                                    <td>{{$kardex_entrada->guia_remision}}</td>
                                                                    <td>{{$kardex_entrada->factura}}</td>
                                                                    <td><a href="{{ route('kardex-entrada.show', $primer_registro->id) }}">
                                                                        <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button></a>

                                                                        @if($array_final[$value]==1)
                                                                            @if($kardex_entrada->estado==1)
                                                                            <input type="hidden" name="kardex_nombre_{{$kardex_entrada->id}}" id="kardex_nombre_{{$kardex_entrada->id}}" value="{{$kardex_entrada->codigo_guia}}"/>
                                                                            <button type="button" class="btn btn-s-m btn-danger" onclick="abrir_modal( {{$kardex_entrada->id}} )">
                                                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                            </button>
                                                                            @else
                                                                                <button class="btn btn-s-m btn-secondary"></button>
                                                                            @endif
                                                                            @else
                                                                            <button class="btn btn-s-m btn-info"></button>
                                                                        @endif
                                                                    </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <form action="{{ route('kardex-entrada.destroy', $kardex_entrada->id)}}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-s-m btn-info"></button>
                                                    </form> --}}
                                                    <!-- Modal Universal Para Anulacion de Kardexs -->
                                                    <div class="modal fade" id="servicio_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
                                                            <div class="modal-content" >
                                                                <div class="modal-body" style="padding: 0px;">
                                                                    <div class="ibox-content float-e-margins">
                                                                            <h3 class="font-bold col-lg-12" align="center">
                                                                                ¿Está seguro que deseas anular el Kardex Entrada con guía N°:<br><span id="kardex_nombre"> </span>? <br>
                                                                                <h4 align="center"> <strong>Nota: Una vez Anulado no hay opción de devolver la acción </strong></h4>
                                                                            </h3>
                                                                        <p align="center">
                                                                            <form action="{{ route('kardex-entrada.destroy')}}" method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="id_kardex" id="kardex_id_form" value="">
                                                                                <center>
                                                                                    <button type="submit" class="btn btn-w-m btn-primary">Anular</button>
                                                                                </center>
                                                                            </form>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div role="tabpanel" id="contenido-tab-2" class="tab-pane">
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
    $(document).ready(function () {
        $('#indextab').addClass('active show');

        $('.datatables-entrada').DataTable({
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



<script>
    document.getElementById("btn-agregar-EP").onclick = function() {
        document.getElementById("formulario-agregar-producto").style.display = "block";
    };

    function cerrarFormulario() {
        document.getElementById("formulario-agregar-producto").style.display = "none";
    }
</script>

@endsection

