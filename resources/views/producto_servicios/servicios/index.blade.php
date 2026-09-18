@extends('layout')
@section('atributo_actu', 'hidden')
@section('title', 'Servicios')
@section('value_accion', 'Agregar')
@section('href_accion', route('servicios.create'))

@section('content')
    <!--Inicio del código actual (14/11/2024)-->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">  
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                    </div>
                    <div class="ibox-content">
                        <div class="row d-flex justify-content-center">
                            @include('producto_servicios.servicios.shared.stadistics')
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
                            <ul class="nav nav-tabs" role="tablist"
                                style="align-items: center;border-bottom: 0px !important;">
                                @include('producto_servicios.servicios.shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <button class="btn btn-primary" id="openUploadModal" title="Importar">
                                        <i class="fa fa-upload text-secondary"
                                            style="cursor: pointer;color: white !important"></i>
                                    </button>                    
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" title="Exportar">
                                            <i class="fa fa-download"></i></button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="exportarTodo(event)">Exportar Todo</a></li>
                                            <li><a class="dropdown-item" href="#"  id="exportSelected">Exportar seleccionados</a></li>
                                        </ul>
                                    </div>
                                    {{-- forms ocultos exportar productos --}}
                                    <form id="formExportProdAll" action="{{ route('export.excel') }}" method="GET"
                                        style="display: none;"></form>
                                    @can('servicios.crear')
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#NuevoServicio"
                                            id="nuevo_servicio" title="Nuevo Servicio">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    @endcan
                                </ul>
                            </ul>
                            <div class="tabs-content"  style="margin-top: -2px">
                                <div class="tab-pane active show" id="tab-1" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br>
                                    <div class="search-responsive" style="padding-right: 15px;padding-left: 15px;">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter" value="" readonly="readonly" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <select class="form-control" name="" id="estado_anular">
                                                    <option value="" selected>Todos los servicios</option>
                                                    <option value="0">Activos</option>
                                                    <option value="1">Anulados</option>
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
                                    <br>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Código Servicio</th>
                                                    <th>Código Original</th>
                                                    <th>Nombre</th>
                                                    <th>Familia</th>
                                                    <th>P. Venta  (
                                                        <strong>{{ $moneda->where('tipo', 'nacional')->pluck('simbolo')->first() }}</strong>
                                                        ) <small>S/igv</small>
                                                    </th>
                                                    <th>P. Venta (
                                                        <strong>{{ $moneda->where('tipo', 'extranjera')->pluck('simbolo')->first() }}</strong>
                                                        ) <small>S/igv</small> 
                                                    </th>
                                                    <th>Ficha Técnica</th>
                                                    <th class="icon-estado">Estado</th>
                                                    <th><i class="fa fa-sliders"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>

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
    <style>
        .table {
            width: 100% !important;
        }

        .nav-link.active,
        .nav.nav-tabs>.nav-custom {
            /* border-bottom: none; */
        }

        .tab-pane.active.show {
            border-right: 1px solid #e7eaec;
            border-left: 1px solid #e7eaec;
            border-bottom: 1px solid #e7eaec;
        }

        .pie-md {
            max-width: 17%; //270
            max-height: 50%; //400
        }

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

        /* Tamaño de los botones del index */
        .tam {
            min-width: 150px;
            min-height: 150px;
            */
        }

        input#fotoIntupEdit,
        input#archivoInputCreate {
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
            width: 100%;
            /*height:100%;*/
            opacity: 0;
            padding: 30px;
        }

        #visorArchivoEdit,
        #visorArchivoCreate {
            width: 100%;
            height: auto;
            min-height: 250px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 2px solid #ced4da;
            border-radius: 6px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        #visorArchivoEdit img[name="foto"],
        #visorArchivoCreate img[name="foto"] {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease-in-out;
        }
        .drop-actions > li > a{
            margin-right: 10px !important;
            margin-left: 0px !important;
        }
    </style>


    <!--Fin del código actual-->


    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <!-- d3 and c3 charts -->
    <script src="{{ asset('js/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('js/plugins/c3/c3.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('#tab-1').addClass('active');
            $('.scroll_content').slimscroll({
                height: '450px'
            })
        });
        // const destroyBaseUrl = "{{ url('servicios_destroy') }}";
        // $('#tab-1').addClass('active')
        var permiso_editar = false;
        var permiso_ver = false;
        var permiso_estado = false;
        var servicios_table = $('.dataTables-example').DataTable({
            pageLength: 15,
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_servicios') }}",
                method: "get",
                data: function(d) {
                    d.daterange = $('#data_range_filter').val();
                    d.estado_anular = $('#estado_anular').val();
                    d.value = $('#search_all_column').val();
                },
                dataSrc: function(json) {
                    permiso_editar = json.permiso_editar;
                    permiso_ver = json.permiso_ver;
                    permiso_estado = json.permiso_estado;
                    return json.data;
                }
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" name="select_row" value="' + full[
                                2] +
                            '" class="i-checks-boleta">';
                    }
                },{
                    'width': '350px',
                    'targets': [3],
                },
                {
                    'targets': [7],
                    'orderable': false,
                    'searchable': false,
                    'render': function(data, type, full, meta) {
                        const servicio = full[9];
                        return `
                        <button type="button"
                                class="btn btn-sm btn-danger btn-ft"
                                data-id="${servicio.id}"
                                data-nombre="${servicio.nombre}">
                            <i class="fa fa-file-pdf-o"></i>
                        </button>
                        `;
                    }
                },
                {
                    'targets': [8],
                    'orderable': false,
                    'className': "icon-estado",
                    'render': function(data, type, full, meta) {
                        if(full[7] == 0){
                            return `<button class="btn btn-info btn-circle btn-ls" title="Activo">
                                        <i class="fa fa-check" ></i>
                                    </button> `
                        }else{
                            return `<button class="btn btn-danger btn-circle btn-ls" title="Anulado">
                                    <i class="fa fa-times" ></i>
                                </button> `
                        }
                    }
                },
                {
                    'targets': [9],
                    'width': '3%',
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var servicio = full[9];
                        let text_button = ``;
                        let ver_button = ``;
                        let estado_button = ``;
                        let button_ver_editar = ``;
                        function ServicioDataAttr(servicio){
                            return  `
                                data-id="${servicio.id}"
                                data-codigo_servicio="${servicio.codigo_servicio}"
                                data-codigo_original="${servicio.codigo_original}"  
                                data-familia_id="${servicio.familia_id}"
                                data-subfamilia_id="${servicio.subfamilia_id}"
                                data-marca_id="${servicio.marca_id}"
                                data-moneda_id="${servicio.moneda_id}"
                                data-nombre="${servicio.nombre}"
                                data-precio_nacional="${servicio.precio_nacional_float}"
                                data-precio_extranjero="${servicio.precio_extranjero_float}"
                                data-utilidad="${servicio.utilidad}"
                                data-descuento="${servicio.descuento}"
                                data-descripcion="${servicio.descripcion}"
                                data-foto="${servicio.foto}"
                                data-tipo_afectacion_id="${servicio.tipo_afectacion_id}"
                                data-estado_anular="${servicio.estado_anular}"
                                data-fecha_creacion="${servicio.fecha_creacion}"
                                data-familia="${servicio.familia.nombre}"
                            `;
                        }
                        if (permiso_ver) {
                            button_ver_editar += `
                                <li><a class="dropdown-item ver-servicio"
                                    data-toggle="modal"
                                    href="#ModalFormVerServicio"
                                    ${ServicioDataAttr(servicio)}
                                    data-familia_name="${servicio.familia.descripcion}"
                                    data-subfamilia_name="${servicio.subfamilia_name}"
                                    data-marca_name="${servicio.marca_name}"
                                    data-tipo_afectacion="${servicio.tipo_afectacion}"
                                    >
                                    Ver
                                </a></li>
                            `;
                        }

                        if (permiso_editar) {
                            button_ver_editar += `
                                <li><a class="dropdown-item edit-servicio "
                                    data-toggle="modal"
                                    href="#EditServicio"
                                    ${ServicioDataAttr(servicio)}>
                                    Editar
                                </a></li>
                            `;
                        }
                        if(permiso_estado && full[7] == 0){
                            estado_button = `
                                <li><a class="dropdown-item" onclick="desactivarserivicio(${servicio.id}, event)" style="color: red;font-weight: bold" href="#">Desactivar</a></li>
                                `;
                        }
                        let html =`
                            <button data-toggle="dropdown" aria-expanded="false" class="btn btn-primary" id="dropdownMenuIcon${servicio.id}"><i class="fa fa-ellipsis-h"></i></button>
                            <ul class="dropdown-menu drop-actions" x-placement="bottom-start">
                                `+ button_ver_editar +`
                                <li>`+ estado_button +`</li>
                            </u>
                        `;
                        return html;
                    }
                }
            ]
        });

        // ficha tecnica modal
        $(document).on('click', '.btn-ft', function() {
            $('#pdf_ficha_tecnica').attr('src', "");

            var servicioId = $(this).data('id');
            var servicioNombre = $(this).data('nombre');

            $('#exampleModalLabel').text('Ficha Técnica - ' + servicioNombre);

            const url = `/servicios/${servicioId}/ft-pdf?ts=` + Date.now();
            $('#pdf_ficha_tecnica').attr('src', url);

            $('#ftservicio_modal').modal('show');
        });

        $('#ftservicio_modal').on('hidden.bs.modal', function() {
            $('#pdf_ficha_tecnica').attr('src', '');
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
        $(`#filter_buttons`).on('click', function() {
            servicios_table.ajax.reload();
        });

        function abrir_modal(a) {
            // var nomb_id = 'servicio_nombre_'+id;
            var nombre = document.getElementById(`servicio_nombre_${a}`).value;
            document.getElementById(`serv_nombre`).innerHTML = nombre;
            document.getElementById(`serv_id_form`).value = a;
            // console.log(nombre);

            $('#servicio_modal').modal('show');

        }

        $('#nuevo_servicio').on('click', function(e) {
            $.ajax({
                url: "{{ route('servicio.generar_codigo') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    $('#codigo_servicio').val(response);
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseJSON);
                }
            });
        });

        function desactivarserivicio(id, e) {
            e.preventDefault()
            // const form = document.getElementById('formDesactivarServ' + id)
            // if (form) {
            //     // form.submit()
            // }
            var formData = new FormData();
            formData.append('id', id);
            const serviciosAnulacion = "{{ route('servicios.destroy', ':id') }}";
            $.ajax({
                url: serviciosAnulacion.replace(':id', id),
                method: 'PATCH',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(
                        'Se Anuló el Servicio correctamente'
                    );
                    $('.dataTables-example').DataTable().ajax.reload();

                }
            });

        }
    </script>

    @include('producto_servicios.servicios.create2')
    @include('producto_servicios.servicios.edit')
    @include('producto_servicios.servicios.show')
    @include('producto_servicios.servicios.shared.pie')
    @include('producto_servicios.servicios.shared.ficha_tecnica')
@endsection
