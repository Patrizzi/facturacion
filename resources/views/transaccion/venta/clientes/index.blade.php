@extends('layout')

@section('title', 'Ventas | Clientes')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                        <div class="ibox-tools custom">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            @include('transaccion.venta._shared.statistics')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <div class="tabs-scroll-top"></div>
                            <div class="tabs-scroll-bottom">
                                <ul class="nav nav-tabs" role="tablist" style="align-items: center;border-bottom: 0px !important;">
                                    @include('transaccion.venta._shared.tabs')
                                    {{-- Almacen --}}
                                    <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;z-index: 20;position: absolute;right: 0px">
                                        {{-- ALMACEN --}}
                                        <a href="#" class="btn btn-primary" id="add_cliente"><i
                                                class="fa fa-plus"></i></a>
                                        <button type="button" id="btn-exportar-filtrado" class="btn btn-primary"
                                            title="Exportar a Excel">
                                            <i class="fa fa-upload"></i>
                                        </button>
                                    </ul>
                                </ul>
                            </div>
                            <div class="tab-content" style="margin-top: -1px">
                                <!-- COTIZACION-->
                                <div role="tabpanel" id="tab-1" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row" style="row-gap: 10px;">
                                            {{-- Rango de fechas --}}
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter" readonly="readonly" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <select class="form-control" id="tipo_doc">
                                                    <option value="">Todos los Documentos</option>
                                                    <option value="DNI">DNI</option>
                                                    <option value="RUC">RUC</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>{{--  Tabla de   --}}
                                    <div class="scrooll-table-responsive">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table_clientes"
                                            id="table_cliente" style="min-width: 982px">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Tipo Doc.</th>
                                                    <th>N° Doc.</th>
                                                    <th>Correo</th>
                                                    <th>Celular</th>
                                                    <th>Fecha de Registro</th>
                                                    <th>Ver</th>
                                                </tr>
                                            </thead>
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

    @include('transaccion.venta._shared.js_shared')

    {{-- JS CORE --}}
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    {{-- DataTables --}}
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    {{-- Moment + DateRangePicker --}}
    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    {{-- Theme --}}
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    {{-- iCheck (solo una vez; eliminar el duplicado para evitar conflictos) --}}
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    @include('transaccion.venta._shared.js_shared')

    <script>
    $(function () {
        // Activar tab "Clientes"
        $('#tab-4-tab').addClass('active');

        // DateRangePicker
        $('input[name="daterange"]').daterangepicker({
            locale: {
                separator: " | ",
                applyLabel: "Guardar",
                cancelLabel: "Cancelar",
                fromLabel: "Desde",
                toLabel: "Hasta",
                customRangeLabel: "Custom",
                daysOfWeek: ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
                monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
                firstDay: 1
            }
        });

        // DataTable
        var table_cliente = $('#table_cliente').DataTable({
            pageLength: 15,
            lengthChange: false,
            responsive: true,
            searching: false,
            serverSide: true,
            ajax: {
                url: "{{ route('ventas.clientes_registers') }}",
                method: "get",
                data: function(d){
                    d.daterange = $('#data_range_filter').val();
                    d.tipo_doc  = $('#tipo_doc').val();
                    d.value     = $('#search_all_column').val();
                }
            },
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    width: '40px',
                    render: function(data, type, full){
                        // BODY iCheck
                        return '<input type="checkbox" class="i-checks-row" name="select_row" value="'+ full[0] +'">';
                    }
                },
                { targets: 2, width: '20vmax' },
                { targets: 4, width: '10vmax' },
                {
                    targets: 8,
                    orderable: false,
                    render: function(data, type, full){
                        var url = '{{ route("cliente.show", ":id") }}'.replace(':id', full[0]);
                        return `
                            <div class="tooltip-demo">
                                <a href="${url}">
                                    <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Ver">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a>
                            </div>`;
                    }
                }
            ]
        })

        // Seleccionar / deseleccionar todos (afecta página actual)
        $('#table_cliente thead .i-checks').on('ifChecked ifUnchecked', function(e){
            if (e.type === 'ifChecked'){
                $('#table_cliente tbody .i-checks-row').iCheck('check');
            } else {
                $('#table_cliente tbody .i-checks-row').iCheck('uncheck');
            }
        });

        // Sincronizar header según selección de la página visible
        $(document).on('ifChanged', '#table_cliente tbody .i-checks-row', function(){
            var $rows = $('#table_cliente tbody .i-checks-row');
            var total = $rows.length;
            var checked = $rows.filter(':checked').length;
            if (total && total === checked){
                $('#table_cliente thead .i-checks').iCheck('check');
            } else {
                $('#table_cliente thead .i-checks').iCheck('uncheck');
            }
        });

        // Filtros
        let mostrarToast = false;
        $('#filter_buttons').on('click', function(){
            mostrarToast = true;
            table_cliente.ajax.reload();
        });
        table_cliente.on('xhr.dt', function(){
            if (mostrarToast){
                toastr.success('Se han aplicado los filtros correctamente', ' ', { timeOut: 3000 });
                mostrarToast = false;
            }
        });
        $('#revert_select').on('click', function(){
            $('input[name="daterange"]').val('').trigger('change');
            mostrarToast = true;
            table_cliente.ajax.reload();
        });


                // INIT iCheck header
        $('#table_cliente thead .i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        // INIT iCheck en filas en cada draw
        table_cliente.on('draw.dt', function(){
            $('#table_cliente tbody .i-checks-row').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
        }).trigger('draw'); // forzar primera vez
        
        // Scroll a la pestaña Clientes
        var $bottom = $('.tabs-scroll-bottom');
        var $nav = $bottom.find('.nav-custom');
        var $tab = $nav.find('li').eq(3);
        if ($tab.length){
            var target = $tab[0].offsetLeft - ($bottom.innerWidth()/2) + ($tab.outerWidth(true)/2);
            $bottom.animate({ scrollLeft: target }, 600);
        }
    });

    // Exportar
    $(document).on('click', '#btn-exportar-filtrado', function(e){
        e.preventDefault();
        var exportUrl = "{{ route('cliente.exportar2') }}";
        var params = new URLSearchParams();
        var daterange = $('#data_range_filter').val();
        var value     = $('#search_all_column').val();
        var tipo_coti = $('#select_tipo_coti').val();

        if (daterange) params.append('daterange', daterange);
        if (value)     params.append('value', value);
        if (tipo_coti) params.append('tipo_coti', tipo_coti);

        window.location.href = exportUrl + '?' + params.toString();
    });
    </script>

    @include('transaccion.venta.clientes.modal_create')

@endsection
