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
                                    <button type="button" class="btn btn-primary" onclick="data_all_pass()" data-toggle="modal" data-target="#todo_pago" >
                                        Pagar Todos</button>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">
                                            <input type="checkbox" class="form-control" name="" id="check_all"
                                                onclick="">
                                        </th>
                                        <th>Id</th>
                                        <th>Cod Factura</th>
                                        <th>Cliente</th>
                                        <th>Cuotas</th>
                                        <th>Total a Pagar</th>
                                        {{-- <th>Descripción</th> --}}
                                        {{-- <th>Activo/Desactivo</th> --}}
                                        <th>Pagar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($facturas as $factura)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="form-control check_only"
                                                    name=""id="check_{{ $factura->id }}">
                                            </td>
                                            <td>{{ $factura->id }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('facturacion.show', $factura->id) }}">{{ $factura->codigo_fac }}</a>
                                            </td>
                                            <td>{{ $factura->cliente->nombre }}</td>
                                            <td>{{ $cuotas->where('facturacion_id', $factura->id)->count() }}</td>
                                            <td>{{ $factura->moneda->simbolo }}
                                                {{ number_format($cuotas->where('facturacion_id', $factura->id)->sum('monto'), 2) }}
                                            </td>
                                            <td><button class="btn btn-primary">Pagar</button></td>
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

    <!-- Modal -->
    <div class="modal fade" id="todo_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .select2.select2-container.select2-container--default {
            width: calc(100% - 46px) !important;
        }

        .select2-selection.select2-selection--single {
            height: 100%;
        }
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
            console.log('a');
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
                    console.log(firstColumnInput[0].id)
                    $('#' + firstColumnInput[0].id + '').prop('checked', true);
                });
                
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
            }
        });
        function data_all_pass(){
            console.log('a');
            $("input[type=checkbox]:checked").each(function(index, check ){
                console.log(check);
            });
        }
    </script>

@endsection
