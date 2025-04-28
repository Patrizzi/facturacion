@extends('layout')
@section('title', 'Tipo de cambio')

@if ($consulta)
    @section('atributo_1', 'hidden')
    @section('atributo_actu', 'hidden')
@else
    @section('atributo_actu', 'hidden')
    @section('href_accion', route('tipo_cambio.create'))
    @section('value_accion', 'Agregar')
@endif

@section('content')
    {{--
<div class="wrapper wrapper-content animated fadeInRight">
    @if (isset($error))
    <div>
      <div class="alert alert-danger">
        <div class="alert-link" href="#">
          <li style="color: red;">{{ $error }}</li>
      </div>
  </div>
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Compra</th>
                                <th>Venta</th>
                                <th>Paralelo</th>
                                <th>Fecha de creacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <span hidden>{{$i=1}}</span>
                            @foreach ($tipo_cambio as $tipo_cambios)
                            <tr class="gradeX">
                                <td>{{$i++}}</td>
                                <td>{{$tipo_cambios->compra}}</td>
                                <td>{{$tipo_cambios->venta}}</td>
                                <td>{{$tipo_cambios->paralelo}}</td>
                                <td>{{$tipo_cambios->created_at}}</td>
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
--}}
    <div class="wrapper wrapper-content animated fadeInRight pb-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h4>Tipo de Cambio del mes</h4>
                    </div>
                    <div class="ibox-content align-content-center">
                        <div class="row" style="align-items: center">
                            <div class="col-sm-3 text-center px-4">
                                <div class="border border-primary rounded-circle circle-size" style="margin: auto">
                                    <p class="m-0 p-4" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4>Mínimo de valor general</h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <p> {{$estadisticas['day_compra_max']}}</p>
                                        <p class="text-primary" style="margin-bottom: 0px;"> <b>S/ {{$estadisticas['max_compra']}}</b></p>
                                    </div>
                                </div>
                                <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4>Maximo de valor general</h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <p> {{$estadisticas['day_venta_max']}}</p>
                                        <p class="text-primary"><b>S/ {{$estadisticas['max_venta']}}</b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div id="morris-one-line-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Base para agregar el tab para el los contenidos-->
    <div class="wrapper wrapper-content animated fadeInRight pt-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li>
                                    <a class="nav-link active" data-toggle="tab" href="#tab-1" >
                                        {{-- <span style="color: white; background-color: blue;" class="px-1">4</span>  --}}
                                        Tipo de Cambio
                                    </a>
                                </li>
                            </ul>
                            <!-- Tablas y su contenido -->
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                    <div class="panel-body table-responsive">
                                        <div class="row">
                                            <div class="col-md-5">
                                                {{-- ACA PUEDE IR OTRO FILTRO DE BUSQUEDA --}}
                                                
                                            </div>
                                            <div class="col-md-5 ">
                                                <div class="input-group">
                                                    <label for="inputBuscar"
                                                        class="col-lg-2 col-form-label "><strong>Buscar:</strong></label>
                                                    <input type="text" id="inputBuscar" class="form-control"
                                                        aria-describedby="passwordHelpInline">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-primary btn-block" id="cambio_buscar"
                                                    type="button">Buscar</button>
                                            </div>
                                        </div>
                                        <br>
                                        <!-- CONTENIDO DENTRO DEL TAB - Boleta manual -->
                                        <table class="table table-striped text-md-center dataTables-tipo">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Compra</th>
                                                    <th>Venta</th>
                                                    <th>Paralelo</th>
                                                    <th>Fecha Actualización</th>
                                                    <th>Accion</th>
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
    <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="editar" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="editar">Editar</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="form_tipo_cambio">
                        @csrf
                        <input type="hidden" class="form-control" id="editar-id" autocomplete="off" readonly>
                        <div class="row mb-3">
                            <strong for="Fecha" class="col-sm-2 col-form-label fw-bold">Fecha:</strong>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="editar-fecha" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong for="Compra" class="col-sm-2 col-form-label fw-bold">Compra:</strong>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editar-compra" name="compra"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong for="Venta" class="col-sm-2 col-form-label fw-bold">Venta:</strong>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editar-venta" name="venta"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong for="Paralelo" class="col-sm-2 col-form-label fw-bold">Paralelo:</strong>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editar-paralelo" name="paralelo"
                                    autocomplete="off">
                            </div>
                        </div>

                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="update-tipo_cambio">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .circle-size {
            min-height: 105px;
            min-width: 105px;
        }

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
    <!-- Morris -->
    <script src="{{ asset('js/plugins/morris/raphael-2.1.0.min.js') }}"></script>
    <script src="{{ asset('js/plugins/morris/morris.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    {{-- <script src="{{ asset('js/demo/morris-demo.js') }}"></script> --}}

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {

            let table = $('.dataTables-tipo').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_tipo_cambio') }}",
                    method: "get",
                    data: function(d) {
                        d.value = $('#inputBuscar').val();
                    },
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                "pageLength": 15,
                "columnDefs": [{
                    sortable: false,
                    'targets': "_all"
                }, {
                    'targets': [5],
                    'className': 'button_estado_motivos',
                    'render': function(data, type, full, meta) {
                        return `<button class="btn btn-primary" id="btn-editar" data-id="` +
                            full[
                                '0'] + `" data-fecha="` + full['4'] + `" data-compra="` + full[
                                '1'] +
                            `" data-venta="` + full['2'] + `" data-paralelo="` + full['3'] + `">
                            <i class="fa fa-edit text-primary"></i>
                        </button>`;
                    }
                }]
            });
            $('.dataTables-tipo').on('click', '#btn-editar', function() {
                const btn = $(this);
                $('#editar-id').val(btn.data('id'));
                $('#editar-fecha').val(btn.data('fecha'));
                $('#editar-compra').val(btn.data('compra'));
                $('#editar-venta').val(btn.data('venta'));
                $('#editar-paralelo').val(btn.data('paralelo'));
                $('#editar').modal('show');
            });
        });
        const updateUrlBase = "{{ route('tipo_cambio.update', ':id') }}";
        $('#update-tipo_cambio').on('click', function() {
            let id = $('#editar-id').val();
            let compra = $('#editar-compra').val();
            let venta = $('#editar-venta').val();
            let paralelo = $('#editar-paralelo').val();

            const updateUrl = updateUrlBase.replace(':id', id);
            console.log(updateUrl);
            $.ajax({
                url: updateUrl,
                type: 'POST',
                data: $('#form_tipo_cambio').serialize() + '&_method=PUT',
                success: function() {
                    $('#editar').modal('hide');
                    $('.dataTables-tipo').DataTable().ajax.reload(null, false);
                    // toast
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 5000
                        };
                        toastr.success(
                            'Tipo de Cambio actualizado correctamente',
                        );

                    }, 500);
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON);
                }
            });
        });
        $('#cambio_buscar').on('click', function() {
            $('.dataTables-tipo').DataTable().ajax.reload();
        });
        $(function() {
            const datos = @json($estadisticas['data']);
            const minY = {{ $estadisticas['minY'] }};
            const maxY = {{ $estadisticas['maxY'] }};
            Morris.Line({
                element: 'morris-one-line-chart',
                data: datos,
                xkey: 'dia_str',
                ykeys: ['Monto'],
                resize: true,
                lineWidth: 4,
                labels: ['Valor'],
                lineColors: ['#1ab394'],
                pointSize: 5,
                ymin: minY,
                ymax: maxY,
                yLabelFormat: function (y) {
                    return y.toFixed(2); // Mostrar 2 decimales en el eje Y
                },
            });
            console.log(minY);
            console.log(minY);

        });
    </script>
@endsection
