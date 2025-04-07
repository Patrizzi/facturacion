@extends('layout')
@section('atributo_actu', 'hidden')
@section('title', 'Servicios')
@section('value_accion', 'Agregar')
@section('href_accion', route('servicios.create'))

@section('content')


    <!--Inicio del código actual (14/11/2024)-->
    @include('producto_servicios.shared.stadistics')


    <div class="modal fade" id="servicio_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
            <div class="modal-content">
                <div class="modal-body" style="padding: 0px;">
                    <div class="ibox-content float-e-margins">
                        <h3 class="font-bold col-lg-12" align="center">
                            ¿Esta Seguro que Deseas Anular el Servicio:<br><span id="serv_nombre"> </span>? <br>
                            <h4 align="center"> <strong>Nota: Una vez Anulado no hay opción de devolver la acción </strong>
                            </h4>
                        </h3>
                        <p align="center">
                        <form action="{{ route('servicios.destroy') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_servicio" id="serv_id_form" value="">
                            <center>
                                <button type="submit" class="btn btn-w-m btn-primary" id="button_anular">Anular</button>
                            </center>
                        </form>
                        </p>
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
                                @include('producto_servicios.servicios.shared.tabs')
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
                                                <button class="btn btn-primary btn-block" id="servicio_buscar"
                                                    type="button">Buscar</button>
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table table-striped dataTables-servicios">
                                            <thead class=" text-md-center">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Código</th>
                                                    <th>Código original</th>
                                                    <th>Nombre</th>
                                                    <th>Familia</th>
                                                    <th>Acciones</th>
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
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- d3 and c3 charts -->
    <script src="{{ asset('js/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('js/plugins/c3/c3.min.js') }}"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('#tab-1').addClass('active show');
            $('.dataTables-servicios').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_servicios') }}",
                    method: "get",
                    data: function(d) {
                        d.estado_anular = 0;
                        d.value = $('#inputBuscar').val();
                        console.log(d.value);
                    },
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                "pageLength": 15,
                "order": [
                    [0, "desc"]
                ],
                "columnDefs": [{
                    'targets': [0]
                }, {
                    'targets': [1]
                }, {
                    'targets': [2]
                }, {
                    'targets': [3],
                    'render': function(data, type, full, meta) {
                        return "<input type='hidden' id='servicio_nombre_"+full[0]+"' value='"+ full[3] +"' >"+ full[3] +"";
                    }
                }, {
                    'targets': [4]
                }, {
                    'targets': [5],
                    'render': function(data, type, full, meta) {

                        return "<a href='{{ route('servicios.show', '') }}/" + full[0] +
                            "'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i></button></a> <button type='button' class='btn btn-danger btn-sm' onclick='abrir_modal(" +
                            full[0] +
                            ")'> <i class='fa fa-trash-o' aria-hidden='true'></i></button> ";
                    }
                }]
            });
            // En caso es input este vacio se limpia automaticamente la tabla
            $('#inputBuscar').on('keyup change', function() {
                var valor = $(this).val().trim();

                if (valor === '') {
                    $('.dataTables-servicios').DataTable().ajax.reload();
                }
            });
        });
        $('#servicio_buscar').on('click', function() {
            $('.dataTables-servicios').DataTable().ajax.reload();
        });

        function abrir_modal(a) {
            var nombre = document.getElementById(`servicio_nombre_${a}`).value;
            document.getElementById(`serv_nombre`).innerHTML = nombre;
            document.getElementById(`serv_id_form`).value = a;
            $('#servicio_modal').modal('show');

        }
    </script>
    @include('producto_servicios.shared.pie')
@endsection
