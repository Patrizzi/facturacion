@extends('layout')

@section('title', 'Cobros')
@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active show" data-toggle="tab" href="#tab-1">Sin procesar</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Moras</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">Cliente</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active show">
                            <div class="panel-body">
                                <div class="row">
                                    {{-- <div class="col-sm-6">
                                        logo.png
                                    </div>
                                    <div class="col-sm-6">

                                    </div> --}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Pago Lote</th>
                                                <th style="width: 150px">Estado</th>
                                                <th>N° Factura</th>
                                                <th>Cliente</th>
                                                <th>Debe | Cuotas</th>
                                                <th>Pagó | Cuotas</th>
                                                <th>Ultima Fecha de Pago</th>
                                                <th>Detalles</th>
                                                <th>Pagar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($facturas_sp as $index => $f_sp)
                                                <tr>
                                                    <td>{{ $f_sp->id }}</td>
                                                    <td><input type="checkbox" name="" id=""></td>
                                                    <td>
                                                        @if ($cuotas_all->where('facturacion_id', $f_sp->id)->where('estado', 0)->count() == 0)
                                                            <button id="pendiente" class="btn btn-primary"
                                                                disabled><strong>PAGADO</strong></button>
                                                        @elseif($cuotas_all->where('facturacion_id', $f_sp->id)->where('estado', 0)->count() < $cuotas_all->where('facturacion_id', $f_sp->id)->count())
                                                            <button id="pagado" class="btn btn-primary"
                                                                disabled><strong>PAGADO PARCIAL</strong></button>
                                                        @else
                                                            <button id="retrasado" class="btn btn-primary"
                                                                disabled><strong>SIN PAGO</strong></button>
                                                        @endif
                                                    </td>
                                                    <td>{{ $f_sp->codigo_fac }}</td>
                                                    <td>{{ $f_sp->cliente->nombre }}</td>
                                                    <td>{{ $f_sp->moneda->simbolo }}
                                                        {{ number_format($cuotas_all->where('facturacion_id', $f_sp->id)->where('estado', 0)->sum('monto'),2) }}
                                                        <strong>|</strong>
                                                        {{ $cuotas_all->where('facturacion_id', $f_sp->id)->where('estado', 0)->count() }}
                                                    </td>
                                                    <td>{{ $f_sp->moneda->simbolo }}
                                                        {{ number_format($cuotas_all->where('facturacion_id', $f_sp->id)->where('estado', 1)->sum('monto'),2) }}
                                                        <strong>|</strong>
                                                        {{ $cuotas_all->where('facturacion_id', $f_sp->id)->where('estado', 1)->count() }}
                                                    </td>
                                                    <td>
                                                        @if ($cuotas_all)
                                                            {{ date('d-m-Y',strtotime($cuotas_all->where('facturacion_id', $f_sp->id)->where('estado', 1)->pluck('fecha_pago')->first())) }}
                                                        @else
                                                            <strong>Pendiente</strong>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary"
                                                            href="{{ route('pagos.edit_mora', $f_sp->codigo_fac) }}">Detalles</a>
                                                    </td>
                                                    <td>
                                                        @if ($cuotas_all->where('facturacion_id', $f_sp->id)->where('estado', 0)->count() > 0)
                                                            <button class="btn btn-primary"
                                                                onclick="pago_factura( {{ $f_sp->id }} )">Pagar</button>
                                                        @else
                                                            <button class="btn btn-primary" disabled>Pagar</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <strong>Donec quam felis</strong>
                                <p>Thousand unknown plants are noticed by me: when I hear the buzz of the little world among
                                    the stalks, and grow familiar with the countless indescribable forms of the insects
                                    and flies, then I feel the presence of the Almighty, who formed us in his own image, and
                                    the breath </p>
                                <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss
                                    of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite
                                    sense of mere tranquil existence, that I neglect my talents. I should be incapable of
                                    drawing a single stroke at the present moment; and yet.</p>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-3" class="tab-pane">
                            <div class="panel-body">
                                <strong>Donec quam felis</strong>
                                <p>Thousand unknown plants are noticed by me: when I hear the buzz of the little world among
                                    the stalks, and grow familiar with the countless indescribable forms of the insects
                                    and flies, then I feel the presence of the Almighty, who formed us in his own image, and
                                    the breath </p>
                                <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss
                                    of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite
                                    sense of mere tranquil existence, that I neglect my talents. I should be incapable of
                                    drawing a single stroke at the present moment; and yet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-lg" id="todo_pago" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pagados.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" name="id_factura[]" id="id_factura" value=""> --}}
                        <div class="display: none" id="ids_divs_factura">

                        </div>
                        {{-- <input type="hidden" name="numero_factura[]" id="cod_factura" value=""> --}}
                        {{-- <input type="hidden" name="tot_cuotas[]" id="total_cuota" value=""> --}}
                        {{-- <input type="hidden" name="cuotas_precio_{{ $cod_fact }}[]" id="cuota_precio"value=""> --}}

                        <input type="hidden" value="{{ $fecha_hoy }}" name="" id="fecha_value_php">
                        {{-- <input class="form-control" type="hidden" name="numero_factura[]" id="numero_fac_`+index+`" value="`+row.factura_cod+`"> --}}
                        <div class="cabeza_facturas">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h3 class="text-center">N° de Factura</h3>
                                </div>
                                <div class="col-sm-4">
                                    <h3 class="text-center">Cuotas por Factura</h3>
                                </div>
                                <div class="col-sm-4">
                                    <h3 class="text-center">Total x Cuotas</h3>
                                </div>
                            </div>
                            <div id="div_facturas">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="" id="numero_fac">
                                    </div>
                                    <div class="col-sm-4 div_select">
                                        <select id="sel" class="select_2_multipl select2-selection--multiple"
                                            name="select_cuotas[]" multiple="multiple">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="" id="total_cuotas">
                                    </div>
                                </div>
                            </div>
                            <hr style="margin: 0px 5px">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {{-- <label class="col-form-label" for="">Monto Total de Pago</label>
                                        <div class="input-group select-group">
                                            <select class="form-control " style="max-width: 30%;height: 100%;">
                                                @foreach ($monedas as $money)
                                                    <option value="{{$money->id}}">{{$money->simbolo}}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control select_input_group"/>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right" >
                                    <label class="col-form-label text-right">Total:</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group select-group" id="tot_simbolo">
                                        {{-- <select class="form-control " style="max-width: 30%;height: 36px"
                                            id="select_money">
                                            @foreach ($monedas as $money)
                                                <option value="{{ $money->id }}">{{ $money->simbolo }}</option>
                                            @endforeach
                                        </select> --}}
                                        {{-- <label class="form-control disabled" id="tota_totas"></label> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="metodo_pago">
                            <input type="hidden" name="input_pago" id="input_pago" value="1">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3 class="text-center">Metodos de Pago</h3>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_1"
                                            class="btn btn-block btn-primary btn_pago_selec active" id="bm_pago_1"
                                            onclick="select_pago(1)">Cheque</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_2"
                                            class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_2"
                                            onclick="select_pago(2)">Tarjeta</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_3"
                                            class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_3"
                                            onclick="select_pago(3)">Efectivo</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_4"
                                            class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_4"
                                            onclick="select_pago(4)">Transferencia</button>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row pago_m m_pago_1"> {{-- Metodo de Pago 1 - CHEQUE --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Numero de Cheque</label>
                                                <input type="text" id="" name="cheque_name" value=""
                                                    placeholder="Numero de Cheque"
                                                    class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha de Cobro</label>
                                                <input type="date" id="" name="cheque_fecha_cobro"
                                                    value="{{ $fecha_hoy }}" placeholder="Fecha de Cobro"
                                                    class="form-control pago_class_1 class_pago fecha_hoy" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Banco Emisor</label>
                                                {{-- <input type="text" id="" name="cheque_banco_emisor" value="" placeholder="Banco Emisor" class="form-control pago_class_1 class_pago" required> --}}
                                                <select class="form-control pago_class_1 class_pago"
                                                    name="cheque_banco_emisor" id="" required>
                                                    <option value="">Seleccionar Banco</option>
                                                    <option value="BCP">BCP</option>
                                                    <option value="INTERBANK">INTERBANK</option>
                                                    <option value="BBVA">BBVA</option>
                                                    <option value="SCOTIABANK">SCOTIABANK</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Beneficiario</label>
                                                <input type="text" id="" name="cheque_beneficiario"
                                                    value="" placeholder="Beneficiario"
                                                    class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Monto</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago_vuelto">S/</span>
                                                    </div>
                                                    <input type="number" id="cheque_monto" name="cheque_monto"
                                                        value="" placeholder="Monto"
                                                        class="form-control pago_class_1 class_pago" required
                                                        step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">N° de Cuenta</label>
                                                <input type="text" value="" name="cheque_n_cuenta"
                                                    placeholder="N° de Cuenta"
                                                    class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha de Emision</label>
                                                <input type="date" value="{{ $fecha_hoy }}"
                                                    name="cheque_fecha_emision" placeholder="Fecha de Emision"
                                                    class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Comprobante
                                                    <small>(opcional)</small></label>
                                                <input type="file" name="cheque_file" id=""
                                                    class="form-control pago_class_1 class_pago file_input">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- {{$fecha_hoy}} --}}
                                    <div class="row pago_m m_pago_2"> {{-- Metodo de Pago 2 - TARJETA --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Titular de la Tajeta</label>
                                                <input type="text" id="" name="tarjeta_titular"
                                                    value="" placeholder="Titular de la Tajeta"
                                                    class="form-control pago_class_2 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Banco</label>
                                                <select class="form-control pago_class_2 class_pago" name="tarjeta_banco"
                                                    id="">
                                                    <option value="">Seleccionar Banco</option>
                                                    <option value="BCP">BCP</option>
                                                    <option value="INTERBANK">INTERBANK</option>
                                                    <option value="BBVA">BBVA</option>
                                                    <option value="SCOTIABANK">SCOTIABANK</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha</label>
                                                <input type="date" value="{{ $fecha_hoy }}"
                                                    class="form-control pago_class_2 class_pago fecha_hoy"
                                                    name="tarjeta_fecha" id="">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Comprobante</label>
                                                <input type="file"
                                                    class="form-control pago_class_2 class_pago file_input"
                                                    name="tarjeta_file" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pago_m m_pago_3"> {{-- Metodo de Pago 3 - EFECTIVO --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Persona que Cancela</label>
                                                <input type="text" id="" name="efectivo_persona"
                                                    value="" placeholder="Titular"
                                                    class="form-control pago_class_3 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha</label>
                                                <input type="date" name="fecha_efectivo"
                                                    class="form-control pago_class_3 class_pago fecha_hoy" id=""
                                                    value="{{ $fecha_hoy }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Monto de Pago</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago">S/</span>
                                                    </div>
                                                    <input type="number" name="monto_pago_efectivo" id="efectivo_pago"
                                                        class="form-control pago_class_3 class_pago" placeholder=""
                                                        step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Vuelto</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago_vuelto">S/</span>
                                                    </div>
                                                    <input type="text" name="monto_vuelto" id="efectivo_vuelto"
                                                        class="form-control pago_class_3 class_pago" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pago_m m_pago_4"> {{-- Metodo de Pago 4 - TRANSFERENCIA --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Titular</label>
                                                <input type="text" id="" name="transferencia_titular"
                                                    value="" placeholder="Titular"
                                                    class="form-control pago_class_4 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha</label>
                                                <input type="date"
                                                    class="form-control pago_class_4 class_pago fecha_hoy"
                                                    name="transferencia_fecha" id=""
                                                    value="{{ $fecha_hoy }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Comprobante</label>
                                                <input type="file"
                                                    class="form-control pago_class_4 class_pago file_input"
                                                    name="transferencia_comprobante" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> {{--  NOTAS PARA TODOS --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Notas Adicionales</label>
                                                <textarea class="form-control" name="notas_adicionales" id="" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .pago_m {
            display: none;
        }

        .pago_m.m_pago_1 {
            display: flex;
        }

        .nav.nav-tabs {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            flex-wrap: nowrap;
        }

        #view_all {
            display: none;
        }

        .view_pagos {
            display: none;
        }

        .form-group {
            margin-bottom: 0px;
        }

        .select2.select2-container.select2-container--default {
            width: calc(100% - 46px) !important;
        }

        .select2-selection.select2-selection--single {
            height: 100%;
        }

        .select2-container.select2-container--default.select2-container--open {
            z-index: 3200;
        }

        .div_select>.select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        label.col-form-label {
            font-weight: bold;
        }

        .input-group.col-sm-4 {
            height: fit-content;
        }

        .input-group-text {
            width: 40px;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script>
        $(".select_2_multipl").select2();

        $(document).ready(function() {
            table = $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
        });

        function pago_factura(n_factura) {
            // console.log('a');
            $('#div_facturas').empty();
            $('#tot_simbolo').empty();
            $('#todo_pago').modal('show');

            var only_id_fact = `
                <input type="hidden" name="id_factura[]" id="id_factura_`+n_factura+`" value="`+n_factura+`">
            `;
            $('#ids_divs_factura').append(only_id_fact);
            var ids_array = [n_factura];
            $.ajax({
                type: "post",
                url: "{{ route('pagos.lista_ajax') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'ids_facturas': ids_array
                },
                success: function(msg) {
                    // console.log(msg)
                    msg.forEach(function(row, index) {
                        // console.log(row.cuotas_array); 
                        // cod_factura
                        var data = `
                            <div class="row">
                                <label></label>
                                <div class="col-sm-4">
                                    <label class="form-control">` + row.factura_cod +
                            `</label>
                                    <input class="form-control" type="hidden" name="numero_factura[]" id="numero_fac_` +
                            index + `" value="` + row.factura_cod + `">
                                </div>
                                <div class="col-sm-4 div_select">
                                    <select placeholder="Seleccionar Cuotas" id="sel_` + index +
                            `" class="select_2_multipl_` + index +
                            ` select2-selection--multiple" name="cuotas_precio_` + row.factura_cod +
                            `[]" multiple="multiple" onchangue="select_2_(` + index + `)" required>
                                        ` + row.cuotas_array.map(function(bar) {
                                if (bar.estado == 0) {
                                    return '<option value="' + bar.id_cuota + '_' + bar.monto +
                                        '">' +
                                        'N°-' + bar.cuota_n + ': ' + bar.monto + '</option>'
                                }
                            }) + `
                                    </select>
                                </div>
                                <div class="input-group col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">` + row.factura_simbolo + `</span>
                                    </div>
                                    <label class="form-control" id="lbl_tot_` + index + `">0</label>
                                    <input class="form-control" type="hidden" name="tot_cuotas[]" id="total_cuotas_` +
                            index + `">
                                </div>
                            </div>
                        `;
                        $('#div_facturas').append(data);

                        var data_2 = `<hr><div class="input-group-prepend"><label class="form-control disabled" id="simbolor_label" style="margin: 0px">`+ row.factura_simbolo+`</label></div><label class='form-control disabled' id='tota_totas'></label>`;
                        $('#tot_simbolo').append(data_2);
                        
                        $(`.select_2_multipl_` + index + ``).select2({
                            placeholder: "Seleccionar Cuotas"
                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:select', function(e) {
                            var data = e.params.data;
                            // console.log(data)
                            var ant = $(`#total_cuotas_` + index + ``).val();
                            if (ant == "") {
                                ant = 0;
                            }
                            var data_cuota = data.text.replace(/N°-\d+: /g, '');
                            console.log(data_cuota);
                            
                            var math_total = Math.round((parseFloat(data_cuota) + parseFloat(
                                ant)) * 100) / 100;
                            $(`#total_cuotas_` + index + ``).val(math_total);
                            $(`#lbl_tot_` + index + ``).html(math_total);
                            // TOTAL DE TOTALES
                            var tota_tot = $('#tota_totas').html();
                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            //TODO O NADA
                            var igual = $("#simbolor_label").html();

                            if (igual == row.factura_simbolo) {
                                var tot_math = Math.round((parseFloat(tota_tot) + parseFloat(
                                    data_cuota)) * 100) / 100;
                            } else {
                                if (row.factura_moneda == "soles" && igual ==
                                    '$') { //DE DOLAR A SOL
                                    var new_val = parseFloat(data_cuota) / tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) +
                                        parseFloat(new_val)) * 100) / 100;
                                    // console.log('a');
                                } else { // DE SOL A DOLAR
                                    var new_val = parseFloat(data_cuota) * tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) +
                                        parseFloat(new_val)) * 100) / 100;
                                    // console.log('b');
                                }
                            }
                            // console.log(tot_math);
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max', tot_math);
                            $('#efectivo_pago').attr('min', tot_math);
                            $('#cheque_monto').val(tot_math);
                            
                            console.log(data.id);
                            var ids_cuotas =  data.id;
                            var ids_arry = ids_cuotas.split('_');
                            
                            var cuota_array = `
                                <input class="input_check" type="hidden" name="id_cuota[]" value="`+ids_arry[0]+`" id='cuota_`+ids_arry[0]+`'>
                            `;
                            $('#ids_divs_factura').append(cuota_array);

                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:unselect', function(e) {
                            var data = e.params.data;
                            var ids_cuotas =  data.id;
                            var ids_arry = ids_cuotas.split('_');
                            console.log(ids_arry);
                            $(`#cuota_`+ids_arry[0]+``).remove();
                            
                            var ant = $(`#total_cuotas_` + index + ``).val();
                            if (ant == "") {
                                ant = 0;
                            }
                            var data_cuota = data.text.replace(/N°-\d+: /g, '');
                            var math_total = Math.round((parseFloat(ant) - parseFloat(
                                data_cuota)) * 100) / 100;
                            $(`#total_cuotas_` + index + ``).val(math_total);
                            $(`#lbl_tot_` + index + ``).html(math_total);
                            var tota_tot = $('#tota_totas').html();

                            // console.log(tota_tot);
                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            // var igual = $("#select_money option:selected").text();
                            // if (igual == row.factura_simbolo) {
                            var tot_math = Math.round((parseFloat(tota_tot) - parseFloat(
                                data_cuota)) * 100) / 100;
                            // } else {
                            //     if (row.factura_moneda == "soles" && igual ==
                            //         '$') { //DE DOLAR A SOL
                            //         var new_val = parseFloat(data_cuota) / tipo_cambio;
                            //         var tot_math = Math.round((parseFloat(tota_tot) -
                            //             parseFloat(new_val)) * 100) / 100;
                            //         console.log('a');
                            //     } else { // DE SOL A DOLAR
                            //         var new_val = parseFloat(data_cuota) * tipo_cambio;
                            //         var tot_math = Math.round((parseFloat(tota_tot) -
                            //             parseFloat(new_val)) * 100) / 100;
                            //         console.log('b');
                            //     }
                            // }
                            // console.log(tot_math);

                            

                            
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max', tot_math);
                            $('#efectivo_pago').attr('min', tot_math);
                            $('#cheque_monto').val(tot_math);
                        });
                    });

                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }

        $('#sel_0').on('select2:select', function (e) {
            console.log('a');
        });
        function select_pago(item) {
            $('.pago_m').css('display', 'none');
            $(`.m_pago_` + item).css('display', 'flex');

            $('.class_pago').attr('required', false);
            // $('.class_pago').val('');
            $(`.pago_class_` + item).attr('required', true);
            $(`.file_input`).attr('required', false);



            $('.btn_pago_selec').removeClass("active");
            $(`#bm_pago_` + item).addClass("active");
            $('#input_pago').val(item);

            var fecha = $('#fecha_value_php').val();
            // console.log(fecha);
            $('.fecha_hoy').val(fecha);  
        }
        $('#efectivo_pago').on('keyup', function(){
            var pago = this.value;
            var total = $('#tota_totas').text();
            var vuelto  = parseFloat( this.value) - parseFloat(total);
            $('#efectivo_vuelto').val(Math.round(vuelto * 100) / 100);
        })
    </script>
@endsection
