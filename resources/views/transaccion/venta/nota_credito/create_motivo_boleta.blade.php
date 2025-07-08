@extends('layout')

@section('title', 'Nota Credito Boleta Motivo')
@section('breadcrumb', 'Nota Credito Boleta Motivo')
@section('breadcrumb2', 'Nota Credito Boleta Motivo')
@section('href_accion', route('nota-credito.index'))
@section('value_accion', 'atras')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row animated fadeInDown">
            <div class="col-lg-12">
                <div class="ibox">
                    {{-- <div class="ibox-content"> --}}
                    @if (isset($boleta->codigo_boleta))
                        <form method="POST" action="{{ route('nota-credito.create_nota_credito_boleta') }}" class="row">
                            @csrf
                            <input type="hidden" name="tipo" id="" value="boleta_origi">
                            <div class="container col-lg-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading text-center">
                                        <h2><strong>Motivo de Nota de {{ $boleta->codigo_boleta }}</strong></h2>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Número de
                                                            BE:</strong></label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="boleta_id"
                                                            id="boleta_id" required value="{{ $boleta->codigo_boleta }}"
                                                            readonly />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Tipo:</strong></label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control" name="tipo_nota_credito"
                                                            id="tipo_nota_credito" onchange="seleccion_motivo()" required>
                                                            <option value=""></option>
                                                            <option value="01">Anulacion de la operacion</option>
                                                            <option value="02">Anulacion por error en el RUC</option>
                                                            <option value="03">Correcion por error en la descripcion
                                                            </option>
                                                            <option value="06">Devolucion Total</option>
                                                            <option value="07">Devolucion por Item</option>
                                                            {{-- <option value="8">Otros conceptos</option>
                                            <option value="9">Ajustes - montos y/o fechas de pago</option> --}}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="div2">
                                                    <div class="form-group row">
                                                        <label class="col-sm-5 col-form-label"><strong>Número
                                                                Nuevo:</strong></label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" name="nueva_boleta"
                                                                id="nueva_boleta">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Fecha de
                                                            Emisión:</strong></label>
                                                    <div class="col-sm-7">
                                                        <input type="date" placeholder="Ingrese Fecha"
                                                            class="form-control" name="fecha_emision" id="fecha_emision">
                                                    </div>
                                                </div>
                                                <div class="div1">
                                                    <div class="form-group row">
                                                        <label class="col-sm-5 col-form-label"><strong>Motivo o
                                                                sustento:</strong></label>
                                                        <div class="col-sm-7">
                                                            <input type="text" name="sustento" id="sustento"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Observación" style="margin-top: 5px;"></input>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="div3">
                                                    <div class="form-group row">
                                                        <label>Descuento Global </label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control"
                                                                name="descuento_global" id="descuento_global">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-success">Enviar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <form method="POST" action="{{ route('nota-credito.create_nota_credito_boleta') }}" class="row">
                            @csrf
                            <input type="hidden" name="tipo" id="" value="boleta_manual">
                            <div class="container col-lg-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading text-center">
                                        <h2><strong>Motivo de Nota de {{ $boleta_m->codigo_boleta }}</strong></h2>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Número de
                                                            BE:</strong></label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="boleta_id"
                                                            id="boleta_id" required value="{{ $boleta_m->codigo_boleta }}"
                                                            readonly />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Tipo:</strong></label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control" name="tipo_nota_credito"
                                                            id="tipo_nota_credito" onchange="seleccion_motivo()" required>
                                                            <option value=""></option>
                                                            <option value="01">Anulacion de la operacion</option>
                                                            <option value="02">Anulacion por error en el RUC</option>
                                                            <option value="03">Correcion por error en la descripcion
                                                            </option>
                                                            <option value="06">Devolucion Total</option>
                                                            <option value="07">Devolucion por Item</option>
                                                            {{-- <option value="8">Otros conceptos</option>
                                            <option value="9">Ajustes - montos y/o fechas de pago</option> --}}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="div2">
                                                    <div class="form-group row">
                                                        <label class="col-sm-5 col-form-label"><strong>Número
                                                                Nuevo:</strong></label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control"
                                                                name="nueva_boleta" id="nueva_boleta">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Fecha de
                                                            Emisión:</strong></label>
                                                    <div class="col-sm-7">
                                                        <input type="date" placeholder="Ingrese Fecha"
                                                            class="form-control" name="fecha_emision" id="fecha_emision">
                                                    </div>
                                                </div>
                                                <div class="div1">
                                                    <div class="form-group row">
                                                        <label class="col-sm-5 col-form-label"><strong>Motivo o
                                                                sustento:</strong></label>
                                                        <div class="col-sm-7">
                                                            <input type="text" name="sustento" id="sustento"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Observación"
                                                                style="margin-top: 5px;"></input>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="div3">
                                                    <div class="form-group row">
                                                        <label>Descuento Global </label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control"
                                                                name="descuento_global" id="descuento_global">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-success">Enviar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
    <style>
        h2 {
            margin-top: 5px;
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

    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>

    <script>
        seleccion_motivo();

        function seleccion_motivo() {
            var motivo = $('#tipo_nota_credito').val();
            $('#nueva_boleta').attr('required', false);
            if (motivo == "") {
                $('.div1').hide();
                $('.div2').hide();
                $('.div3').hide();
            } else if (motivo == "01" || motivo == "04" || motivo == "05" || motivo == "06" || motivo == "07" || motivo ==
                "08" || motivo == "03") {
                $('.div1').show();
                $('.div2').hide();
                $('.div3').hide();
            } else if (motivo == "02") {
                $('.div1').show();
                $('.div2').show();
                $('.div3').hide();
                $('#sustento').attr('required', true);
                $('#nueva_boleta').attr('required', true);
            }
        }
        $(document).ready(function() {
            document.getElementById('fecha_emision').max = new Date(new Date().getTime() - new Date()
                .getTimezoneOffset() * 60000).toISOString().split("T")[0];
            // var f = new Date().toISOString().split("T")[0];
            var today = new Date();
            var dd = today.getDate() - 2;
            var mm = today.getMonth(); //January is 0 so need to add 1 to make it 1!
            var new_m = parseInt(mm) + 1;
            var n_m = '0' + new_m;
            var yyyy = today.getFullYear();
            var min = yyyy + '-' + n_m + '-' + dd;

            document.getElementById('fecha_emision').min = min;
        });
        // $('.fecha_emision').max = new Date().toISOString().split("T")[0];
        window.onload = function() {
            var today = new Date();
            var dd = today.getDate();
            if (dd < 10) {
                var dd = '0' + dd;
            } else {
                var dd = dd;
            }
            var mm = today.getMonth(); //January is 0 so need to add 1 to make it 1!
            var new_m = parseInt(mm) + 1;
            if (new_m < 10) {
                var n_m = '0' + new_m;
            } else {
                var n_m = new_m;
            }
            var yyyy = today.getFullYear();
            var hoy = yyyy + '-' + n_m + '-' + dd;
            document.getElementById('fecha_emision').value = hoy;
        }
    </script>

@endsection
