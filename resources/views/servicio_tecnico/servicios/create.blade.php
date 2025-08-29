@extends('layout')
@section('title', 'Cotizacion Manual')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/servicios/create.css') }}">

    @if ($errors->any())
        <div style="padding-top: 20px;">
            <div class="alert alert-danger">
                <a class="alert-link" href="#">
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </a>
            </div>
        </div>
    @endif

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h4><strong>Generar Servicio Técnico</strong></h4>
            </div>
            <div class="ibox-content">
                <form action="{{ route('servicio-guias.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row form-label word-style">
                        <div class="col-md-6">
                            <!-- Cliente -->
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <select class="select2_demo_client" name="cliente_id" id="cliente" required>
                                        </select>
                                        <div class="input-group-append">
                                            <a href="#" class="btn btn-secondary btn-rounded" id="add_cliente"><i
                                                    class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Fecha:</strong></label>
                                        <div class="col-md-8">
                                            <input
                                                type="text"
                                                class="form-control"
                                                value="{{ date('d-m-Y') }}"
                                                readonly
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-md-3"><strong>Recepcionista:</strong>
                                </label>
                                <div class="col-md-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        value="{{ $currentUser }}"
                                        readonly
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3"><strong>Código Servicio Guía:</strong></label>
                                <div class="col-md-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        value="{{ $newNroGuia }}"
                                        readonly
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table cellspacing="0" class="table tables">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-info"
                                                    id="agregar-equipo"
                                                >
                                                    <i class="fa fa-plus-square"></i>
                                                </button>
                                            </th>
                                            <th style="width: 80%">Equipos</th>
                                            <th style="width:20%">Nro. Serie</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-equipos">
                                        <tr>
                                            <td>
                                                <button
                                                    type="button"
                                                    class='btn btn-sm btn-danger borrar-equipo'
                                                >
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                            <td class="td_selected">
                                                <input
                                                    type="text"
                                                    placeholder="Nombre Equipo"
                                                    class="form-control"
                                                    name="nombre_equipo[]">
                                                <textarea
                                                    name='observacion[]'
                                                    placeholder="Observación"
                                                    class="form-control"
                                                    autocomplete="off"
                                                    style="margin-top: 5px;"></textarea>
                                            </td>
                                            <td>
                                                <input
                                                    style="width: 520px"
                                                    type='text'
                                                    name='nro_serie[]'
                                                    class="form-control"
                                                    placeholder="Número Serie"
                                                />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary btn-outline" type="submit">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>

    </style>

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

    <!-- Jquery Validate -->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>

    <!-- Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Sweet alert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script type="text/javascript">
        $(".select2_tipo_coti").select2();

        $(".select2_demo_client").select2({
            theme: "bootstrap",
            placeholder: "Seleccionar Cliente",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.clients') }}",
                dataType: 'json',
                type: "POST",
                delay: 10,
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.nombre + ' | ' + item.numero_documento,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    </script>


    <script>
        document.getElementById('agregar-equipo').addEventListener('click', function() {
            var tr = document.createElement('tr');

            var tdBoton = document.createElement('td');
            var btnEliminar = document.createElement('button');
            btnEliminar.type = 'button';
            btnEliminar.className = 'btn btn-sm btn-danger borrar-equipo';
            btnEliminar.innerHTML = '<i class="fa fa-trash" aria-hidden="true"></i>';
            tdBoton.appendChild(btnEliminar);

            var tdEquipos = document.createElement('td');
            tdEquipos.className = 'td_selected';

            var inputNombre = document.createElement('input');
            inputNombre.type = 'text';
            inputNombre.placeholder = 'Nombre Equipo';
            inputNombre.className = 'form-control';
            inputNombre.name = 'nombre_equipo[]';

            var textareaObs = document.createElement('textarea');
            textareaObs.name = 'observacion[]';
            textareaObs.placeholder = 'Observación';
            textareaObs.className = 'form-control';
            textareaObs.autocomplete = 'off';
            textareaObs.style.marginTop = '5px';

            tdEquipos.appendChild(inputNombre);
            tdEquipos.appendChild(textareaObs);

            var tdSerie = document.createElement('td');
            var inputSerie = document.createElement('input');
            inputSerie.type = 'text';
            inputSerie.name = 'nro_serie[]';
            inputSerie.placeholder = 'Número Serie';
            inputSerie.className = 'form-control';
            inputSerie.style.width = '520px';
            tdSerie.appendChild(inputSerie);

            tr.appendChild(tdBoton);
            tr.appendChild(tdEquipos);
            tr.appendChild(tdSerie);

            document.querySelector('#tabla-equipos').appendChild(tr);

            btnEliminar.onclick = function() {
                this.closest('tr').remove();
            }
        });

        function eliminarFila() {
            var btnDelete = document.querySelectorAll('.borrar-equipo');
            btnDelete.forEach(function(btn) {
                btn.onclick = function() {
                    this.closest('tr').remove();
                }
            });
        }

        eliminarFila();
    </script>

    @include('transaccion.venta.clientes.modal_create')
@stop
