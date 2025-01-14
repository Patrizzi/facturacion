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
                    <div class="d-flex justify-content-between align-items-center">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-6"><span style="color: green;">&#9632; </span> Nota de Débito
                                    {{-- link del tab 1 --}}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-7"><span style="color: orange;">&#9632;</span> Enviados
                                    {{-- link del tab 2 --}}
                                </a>
                            </li>
                             </ul>   
                        </div>                             
                        <div>  <!-- Botón de descarga -->
                            <div class="btn-group">
                                <button data-toggle="dropdown" type="button" class="btn btn-success dropdown-toggle ">
                                    <i class="fa fa-cloud-download"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">PDF</a></li>
                                    <li><a class="dropdown-item" href="#">WORD</a></li>
                                    <li><a class="dropdown-item" href="#">CSV</a></li>
                                    <li><a class="dropdown-item" href="#">EXCEL</a></li>
                                </ul>
                            </div>
                        </div>
                 </div>
                       
                        <!-- Input seleccionar fecha inicio y fin, y Botón agregar y Descargar -->
                        <div class="d-flex justify-content-md-start row mx-3 mt-4">
                            <div class="input-group col-md-4 mx-5">
                                <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                <input class="form-control" type="text" name="daterange"
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
                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-6" class="tab-pane active show">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  -->
                                    <table class="table table-striped dataTables-example2">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                <th>Item</th>
                                                <th>Código de NC</th>
                                                <th>Tipo</th>
                                                <th>Cliente</th>
                                                <th>Ruc/DNI</th>
                                                <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                </tr>
                                        </thead>
                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                        <tbody>
                                            <span hidden>{{$i=1}}</span>
                                            @foreach ($n_debitos as $nota_d)
                                        <tr>
                                            <td><input type="checkbox" class="i-checks" name="input[]"></td>                                            
                                            <td>{{$i++}}</td>
                                            <td>{{$nota_d->codigo_n_d}}</td>
                                        @if($nota_d->facturacion_id !=NULL)
                                            <td>Factura</td>
                                            <td>{{$nota_d->nota_i_facturacion->cliente->nombre}}</td>
                                            <td>{{$nota_d->nota_i_facturacion->cliente->numero_documento}}</td>
                                            <td style="text-align: center">
                                                <form action="{{route('facturacion_electronica.nota_debito')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$nota_d->id}}">
                                                    <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                </form>
                                            </td>

                                        @elseif($nota_d->boleta_id !=NULL)
                                            <td>Boleta</td>
                                            <td>{{$nota_d->nota_i_boleta->cliente->nombre}}</td>
                                            <td>{{$nota_d->nota_i_boleta->cliente->numero_documento}}</td>
                                            <td style="text-align: center">
                                                <form action="{{route('facturacion_electronica.nota_debito_bol')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$nota_d->id}}">
                                                    <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                </form>
                                            </td>

                                        @elseif($nota_d->boleta_m_id !=NULL)
                                            <td>Boleta Manual</td>
                                            <td>{{$nota_d->nota_i_boleta_manual->cliente->nombre}}</td>
                                            <td>{{$nota_d->nota_i_boleta_manual->cliente->numero_documento}}</td>
                                            <td style="text-align: center">
                                                <form action="{{route('facturacion_electronica.nota_debito_bol')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$nota_d->id}}">
                                                    <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                </form>
                                            </td>
                                        
                                        @else
                                            <td>Factura Manual</td>
                                            <td>{{$nota_d->nota_i_fac_manual->cliente->nombre}}</td>
                                            <td>{{$nota_d->nota_i_fac_manual->cliente->numero_documento}}</td>
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
                                    <tfooter>
                                        <td colspan="6" align="right" style="padding-right: 2em"></td>
                                        <td align="center"><button type="button" class="btn btn-primary" id="nota_debito_elec_all">Enviar</button></td>
                                    </tfooter>
                                </table>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-7" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <table class="table table-striped dataTables-example2">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                <th>Item</th>
                                                <th>Código de NC</th>
                                                <th>Tipo</th>
                                                <th>Cliente</th>
                                                <th>Ruc/DNI</th>
                                                <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span hidden>{{$h=1}}</span>
                                            @foreach ($n_debitos_enviados as $n_d_env)
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>                                                
                                                <td>{{$h}}</td>
                                                <td>{{$n_d_env->codigo_n_d}}</td>

                                            @if(isset($n_d_env->facturacion_id))
                                                <td>Factura</td>
                                                <td>{{$n_d_env->nota_i_facturacion->cliente->nombre}}</td>
                                                <td>{{$n_d_env->nota_i_facturacion->cliente->numero_documento}}</td>
                                            
                                            @elseif(isset($n_d_env->boleta_id))
                                                <td>Boleta</td>
                                                <td>{{$n_d_env->nota_i_boleta->cliente->nombre}}</td>
                                                <td>{{$n_d_env->nota_i_boleta->cliente->numero_documento}}</td>

                                            @elseif(isset($n_d_env->boleta_m_id))
                                                <td>Boleta Manual</td>
                                                <td>{{$n_d_env->nota_i_boleta_manual->cliente->nombre}}</td>
                                                <td>{{$n_d_env->nota_i_boleta_manual->cliente->numero_documento}}</td>

                                            @else
                                                <td>Facturacion Manual</td>
                                                <td>{{$n_d_env->nota_i_fac_manual->cliente->nombre}}</td>
                                                <td>{{$n_d_env->nota_i_fac_manual->cliente->numero_documento}}</td>
                                            @endif    
                                            
                                            <td><button type="button" class="btn btn-info btn-circle btn-ls" ><i class="fa fa-check-circle"></i></button></td>
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
<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example2').DataTable({
            pageLength: 12,
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

        })
            ;$('input[name="daterange"]').daterangepicker({
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
        function limpiar_select(){
            table.column(4).search("").draw();
        }
        function revert_select() {
            table.column(4).search(`{{ date('m-Y') }}`).draw();
        }
    </script>

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