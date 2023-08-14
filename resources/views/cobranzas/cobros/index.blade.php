@extends('layout')

@section('title', 'Cobros')
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <h1>Facturas a credito</h1>
                            <div class="row">
                                <div class="col-sm-2">
                                    <span>Filtro:</span>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <select class="select2_demo_client" name="cliente" id="cliente"
                                            required=""></select>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-primary" onclick="limpiar_select()">
                                                <i class="fa fa-eraser"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 align-right">
                                    <button type="button" id="button_all_pago" class="btn btn-primary" onclick="data_all_pass()" data-toggle="modal" data-target="#todo_pago" disabled>
                                        Pagar Todos</button>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">
                                            <input type="checkbox" class="form-control" name="" id="check_all">
                                        </th>
                                        <th>Id</th>
                                        <th>Cod Factura</th>
                                        <th>Cliente</th>
                                        <th>Cuotas</th>
                                        <th>Moneda</th>
                                        <th>Total a Pagar</th>
                                        <th>Pagar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($facturas as $factura)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="form-control check_only"
                                                    name="" id="check_{{ $factura->id }}" value="{{$factura->codigo_fac}}" onc>
                                            </td>
                                            <td>{{ $factura->id }}</td>
                                            <td>
                                                <a href="{{ route('facturacion.show', $factura->id) }}">{{ $factura->codigo_fac }}</a>
                                            </td>
                                            <td>{{ $factura->cliente->nombre }}</td>
                                            <td>{{ $cuotas->where('facturacion_id', $factura->id)->count() }}</td>
                                            <td>{{ $factura->moneda->nombre }}</td>
                                            <td>{{ $factura->moneda->simbolo }}
                                                {{ number_format($cuotas->where('facturacion_id', $factura->id)->sum('monto'), 2) }}
                                            </td>
                                            <td><button class="btn btn-primary pagar_individual">Pagar</button></td>
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
    {{$fecha_hoy}}
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="todo_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('pagados.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                                        <select id="sel" class="select_2_multipl select2-selection--multiple" name="states[]" multiple="multiple">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="" id="total_cuotas">
                                    </div>
                                </div>
                            </div>
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
                                <div class="col-sm-4">
                                    <label class="col-form-label text-center">Total:</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group select-group">
                                        <select class="form-control " style="max-width: 30%;height: 36px" id="select_money">
                                            @foreach ($monedas as $money)
                                                <option value="{{$money->id}}">{{$money->simbolo}}</option>
                                            @endforeach
                                        </select>
                                        <label class="form-control disabled" id="tota_totas"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <input type="hidden" value="{{$fecha_hoy}}" name="" id="fecha_value_php">
                        <div class="metodo_pago">
                            <input type="hidden" name="input_pago" id="input_pago" value="1">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3 class="text-center">Metodos de Pago</h3>
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-block btn-primary btn_pago_selec active" id="bm_pago_1" onclick="select_pago(1)">Cheque</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_2" onclick="select_pago(2)">Tarjeta</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_3" onclick="select_pago(3)">Efectivo</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_4" onclick="select_pago(4)">Transferencia</button>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row pago_m m_pago_1"> {{-- Metodo de Pago 1 - CHEQUE --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Numero de Cheque</label>
                                                <input type="text" id="" name="cheque_name" value="" placeholder="Numero de Cheque" class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Fecha de Cobro</label>
                                                <input type="date" id="" name="cheque_fecha_cobro" value="{{$fecha_hoy}}" placeholder="Fecha de Cobro" class="form-control pago_class_1 class_pago fecha_hoy" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Banco Emisor</label>
                                                {{-- <input type="text" id="" name="cheque_banco_emisor" value="" placeholder="Banco Emisor" class="form-control pago_class_1 class_pago" required> --}}
                                                <select class="form-control pago_class_1 class_pago" name="cheque_banco_emisor" id="" required>
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
                                                <label class="col-form-label" for="">Beneficiario</label>
                                                <input type="text" id="" name="cheque_beneficiario" value="" placeholder="Beneficiario" class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Monto</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago_vuelto">S/</span>
                                                    </div>
                                                    <input type="number" id="cheque_monto" name="cheque_monto" value="" placeholder="Monto" class="form-control pago_class_1 class_pago" required step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">N° de Cuenta</label>
                                                <input type="text" value="" name="" name="cheque_n_cuenta" placeholder="N° de Cuenta" class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Fecha de Emision</label>
                                                <input type="date" value="{{$fecha_hoy}}" name="" name="cheque_fecha_emision" placeholder="Fecha de Emision" class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Comprobante <small>(opcional)</small></label>
                                                <input type="file" class="form-control" name="cheque_file" id="" class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                    </div>
                                    {{$fecha_hoy}}
                                    <div class="row pago_m m_pago_2"> {{-- Metodo de Pago 2 - TARJETA --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Titular de la Tajeta</label>
                                                <input type="text" id="" name="tarjeta_titular" value="" placeholder="Titular de la Tajeta" class="form-control pago_class_2 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Banco</label>
                                                <select class="form-control pago_class_2 class_pago" name="tarjeta_banco" id="">
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
                                                <label class="col-form-label" for="">Fecha</label>
                                                <input type="date" value="{{$fecha_hoy}}" class="form-control pago_class_2 class_pago fecha_hoy" name="tarjeta_fecha" id="" >
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Comprobante</label>
                                                <input type="file" class="form-control pago_class_2 class_pago" name="tarjeta_file" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pago_m m_pago_3"> {{-- Metodo de Pago 3 - EFECTIVO--}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Persona que Cancela</label>
                                                <input type="text" id="" name="efectivo_persona" value="" placeholder="Titular" class="form-control pago_class_3 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Fecha</label>
                                                <input type="date" class="form-control pago_class_3 class_pago fecha_hoy" name="" id="" value="{{$fecha_hoy}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Monto de Pago</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago">S/</span>
                                                    </div>
                                                    <input type="number" id="efectivo_pago" class="form-control pago_class_3 class_pago" placeholder="" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Vuelto</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago_vuelto">S/</span>
                                                    </div>
                                                    <input type="text" id="efectivo_vuelto" class="form-control pago_class_3 class_pago" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pago_m m_pago_4"> {{-- Metodo de Pago 4 - TRANSFERENCIA --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Titular</label>
                                                <input type="text" id="" name="" value="" placeholder="Titular" class="form-control pago_class_4 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Fecha</label>
                                                <input type="date" class="form-control pago_class_4 class_pago fecha_hoy" name="" id="" value="{{$fecha_hoy}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Comprobante</label>
                                                <input type="file" class="form-control pago_class_4 class_pago" name="" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">Notas Adicionales</label>
                                                <textarea class="form-control" name="" id="" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-primary">Enviar</button>
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
        .form-group{
            margin-bottom: 0px;
        }
        .select2.select2-container.select2-container--default {
            width: calc(100% - 46px) !important;
        }

        .select2-selection.select2-selection--single {
            height: 100%;
        }
        .select2-container.select2-container--default.select2-container--open{
            z-index: 3200;
        }
        .div_select >  .select2.select2-container.select2-container--default {
            width: 100% !important;
        }
        .pago_m{
            display: none;
        }
        .pago_m.m_pago_1{
            display: flex;   
        }
        label.col-form-label{
            font-weight: bold;
        }
        .input-group.col-sm-4{
            height: fit-content;
        }
        .input-group-text{
            width: 40px;
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] { -moz-appearance:textfield; }
    </style>

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


    <!-- Page-Level Scripts -->
    <script>
        var tipo_coti = 3;
        $(".select2_demo_client").select2({
            placeholder: "Seleccionar Cliente",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.clients') }}",
                dataType: 'json',
                type: "POST",
                delay: 10,
                data: function(params) {
                    var tipo_coti = $('[name="tipo_coti"]:checked').val();
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term, // search term
                        tipo_coti: tipo_coti
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.nombre,
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
        $(".select_2_multipl").select2();
    </script>
    <script>
        $(document).ready(function() {
            table = $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $(document).on('change', '#cliente', function(event) {
                var nombre = $("#cliente option:selected").val();
                table.column(3).search(nombre).draw();
            });
        });

        function limpiar_select() {
            // console.log('a');
            var table2 = $('.dataTables-example').DataTable();
            table2.column(3).search('').draw();
            $('#cliente').val(null).trigger('change');

        }

        $('#check_all').click(function() {
            if ($(this).is(':checked')) {
                var dataTable = $('.dataTables-example').DataTable();
                var ids = dataTable.rows({
                    filter: 'applied'
                }).data().toArray();
                var firstColumnInputIDs = [];
                ids.forEach(function(row) {
                    var firstColumnInput = $(row[0]);
                    $('#' + firstColumnInput[0].id + '').prop('checked', true);
                });
                $('#button_all_pago').attr('disabled',false);
            } else {
                var dataTable = $('.dataTables-example').DataTable();
                var ids = dataTable.rows({
                    filter: 'applied'
                }).data().toArray();
                var firstColumnInputIDs = [];
                ids.forEach(function(row) {
                    var firstColumnInput = $(row[0]);
                    $('#' + firstColumnInput[0].id + '').prop('checked', false);
                });
                $('#button_all_pago').attr('disabled',true);
            }
        });
        $('.check_only').click(function() {
            // console.log($("input[type=checkbox]:checked").length);
            if ($("input[type=checkbox]:checked").length > 0) {
                $('#button_all_pago').attr('disabled',false);
                $('.pagar_individual').attr('disabled',true);
                
            }else{
                $('#button_all_pago').attr('disabled',true);
                $('.pagar_individual').attr('disabled',false);
            }
            
        });
        function data_all_pass(){
            $('#div_facturas').empty();
            var ids_array =  [];
            $("input[type=checkbox]:checked").each(function(index, check ){
                var ids = check.id;
                var id_fact = ids.split('_');
                var val_fact = check.value;
                ids_array.push(id_fact[1]);
            });
            var tipo_cambio = {{$tipo_cambio->paralelo}} ;
            $.ajax({
                type: "post",
                url: "{{ route('pagos.lista_ajax') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'ids_facturas': ids_array
                },
                success: function (msg) {
                    
                    msg.forEach(function(row,index) {
                        // console.log(row.cuotas_array); 
                        // var options;
                        var data = `
                            <div class="row">
                                <label></label>
                                <div class="col-sm-4">
                                    <label class="form-control">`+row.factura_cod+`</label>
                                    <input class="form-control" type="hidden" name="numero_factura[]" id="numero_fac_`+index+`" value="`+row.factura_cod+`">
                                </div>
                                <div class="col-sm-4 div_select">
                                    <select placeholder="Seleccionar Cuotas" id="sel_`+index+`" class="select_2_multipl_`+index+` select2-selection--multiple" name="cuotas_precio_`+row.factura_cod+`[]" multiple="multiple" onchangue="select_2_(`+index+`)" required>
                                        `+ row.cuotas_array.map(function(bar){
                                            return '<option value="'+bar.monto+'">'+bar.monto+'</option>'
                                        }) +`
                                    </select>
                                </div>
                                <div class="input-group col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">`+row.factura_simbolo+`</span>
                                    </div>
                                    <label class="form-control" id="lbl_tot_`+index+`">0</label>
                                    <input class="form-control" type="hidden" name="tot_cuotas[]" id="total_cuotas_`+index+`">
                                </div>
                            </div>
                        `;
                        $('#div_facturas').append(data);
                        $(`.select_2_multipl_`+index+``).select2({
                            placeholder: "Seleccionar Cuotas"
                        });
                        $(`.select_2_multipl_`+index+``).on('select2:select', function (e) {
                            var data = e.params.data;
                            var ant = $(`#total_cuotas_`+index+``).val();
                            if(ant == ""){  
                                ant = 0;
                            }
                            var math_total = Math.round((parseFloat(data.text) + parseFloat(ant)  ) * 100 ) / 100;
                            $(`#total_cuotas_`+index+``).val(math_total);
                            $(`#lbl_tot_`+index+``).html(math_total);
                            // TOTAL DE TOTALES
                            var tota_tot = $('#tota_totas').html();
                            if(tota_tot == ""){  
                                tota_tot = 0;
                            }
                            //TODO O NADA
                            var igual =   $("#select_money option:selected").text();
                            if(igual == row.factura_simbolo){
                                var tot_math = Math.round((parseFloat(tota_tot) + parseFloat(data.text)) * 100) / 100;
                            }else{
                                if(row.factura_moneda == "soles" && igual == '$'){  //DE DOLAR A SOL
                                    var new_val = parseFloat(data.text) / tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) + parseFloat(new_val)) * 100) / 100;
                                    console.log('a');
                                }else{  // DE SOL A DOLAR
                                    var new_val = parseFloat(data.text) * tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) + parseFloat(new_val)) * 100) / 100;
                                    console.log('b');
                                }
                            }
                            // console.log(tot_math);
                            $('#tota_totas').html(tot_math); 
                            $('#cheque_monto').attr('max',tot_math);
                            $('#efectivo_pago').attr('min',tot_math);
                            $('#cheque_monto').val(tot_math);
                            
                        });
                        $(`.select_2_multipl_`+index+``).on('select2:unselect', function (e) {
                            var data = e.params.data;
                            var ant = $(`#total_cuotas_`+index+``).val();
                            if(ant == ""){  
                                ant = 0;
                            }
                            var math_total = Math.round((parseFloat(ant) - parseFloat(data.text)) * 100 ) / 100;
                            $(`#total_cuotas_`+index+``).val(math_total);
                            $(`#lbl_tot_`+index+``).html(math_total);
                            var tota_tot = $('#tota_totas').html();

                            // console.log(tota_tot);
                            if(tota_tot == ""){  
                                tota_tot = 0;
                            }
                            var igual =   $("#select_money option:selected").text();
                            if(igual == row.factura_simbolo){
                                var tot_math = Math.round((parseFloat(tota_tot) - parseFloat(data.text)) * 100) / 100;
                            }else{
                                if(row.factura_moneda == "soles" && igual == '$'){  //DE DOLAR A SOL
                                    var new_val = parseFloat(data.text) / tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) - parseFloat(new_val)) * 100) / 100;
                                    console.log('a');
                                }else{  // DE SOL A DOLAR
                                    var new_val = parseFloat(data.text) * tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) - parseFloat(new_val)) * 100) / 100;
                                    console.log('b');
                                }
                            }
                            // console.log(tot_math);
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max',tot_math);
                            $('#efectivo_pago').attr('min',tot_math);
                            $('#cheque_monto').val(tot_math);
                        });
                    });
                    
                },
                error: function(eject) {
                    if(eject.status===400){
                        console.log(eject.responseJSON.error);
                    }
                },
                cache:true
            });
        }
        $(".select2-selection--multiple").on("change", function () { 
            debugger; 
        });
        function select_pago(item){
            $('.pago_m').css('display','none');
            $(`.m_pago_`+item).css('display','flex');
            
            $('.class_pago').attr('required', false);
            // $('.class_pago').val('');
            $(`.pago_class_`+item).attr('required', true);
            

            $('.btn_pago_selec').removeClass("active"); 
            $(`#bm_pago_`+item).addClass("active");
            $('#input_pago').val(item);
            
            var fecha = $('#fecha_value_php').val();
            console.log(fecha);
            $('.fecha_hoy').val(fecha);
           
        }

        $('#select_money').on('change', function() {
            var tipo_cambio = {{$tipo_cambio->paralelo}} ;
            var total = $('#tota_totas').html();
            if(this.value == "1"){
                var conv = parseFloat(total) * tipo_cambio;
                var conv_two = Math.round(conv * 100) / 100;
                $('#tota_totas').html(conv_two);
                //CAMBIO EN METODO DE PAGO = EFECTIVO
                $('#simbolo_pago').html('S/');
                $('#simbolo_pago_vuelto').html('S/');
            }else{ //Dolares
                var conv = parseFloat(total) / tipo_cambio;
                var conv_two = Math.round(conv * 100) / 100;
                $('#tota_totas').html(conv_two);
                //CAMBIO EN METODO DE PAGO = EFECTIVO
                $('#simbolo_pago').html('$');
                $('#simbolo_pago_vuelto').html('$');
            }
            $('#cheque_monto').attr('max',conv_two);
            $('#efectivo_pago').attr('min',conv_two);
            $('#cheque_monto').val(conv_two);
        });
        $('#efectivo_pago').on('keyup', function(){
            var pago = this.value;
            var total = $('#tota_totas').text();
            var vuelto  = parseFloat( this.value) - parseFloat(total);
            $('#efectivo_vuelto').val(Math.round(vuelto * 100) / 100);
        })
    </script>

@endsection
