@extends('layout')

@section('title', 'Registros de Pago')
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">

                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-control">
                                    <h3>Datos del Cliente</h3>
                                    <div class="text-left">
                                        <strong>Señor(es):</strong> {{$factura_m->cliente->nombre}}<br>
                                        <strong>Señor(es):</strong> {{$factura_m->cliente->nombre}}<br>
                                        <strong>Señor(es):</strong> {{$factura_m->cliente->nombre}}<br>
                                        <strong>Señor(es):</strong> {{$factura_m->cliente->nombre}}<br>
                                        <strong>Señor(es):</strong> {{$factura_m->cliente->nombre}}<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-control">

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

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>

    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <!-- Switchery -->
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    {{-- @include('cobranzas.pago_contado')
    @include('cobranzas.adelanto_view')
    @include('cobranzas.adelanto') --}}

    <script>
        var elem_2 = document.querySelector('.js-switch-pago');
        var switchery_2 = new Switchery(elem_2, {
            color: '#ED5565'
        });

        $(document).ready(function() {
            table = $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $('.dataTables-examaple').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $('.footable').footable();

            $('#select_banco_pagos').select2({
                placeholder: "Seleccionar",
            });
            $('#select_cuenta_pago').select2({
                placeholder: "Seleccionar",
            });

            $('#select_banco_transf_pag').select2({
                placeholder: "Seleccionar",
            });
            $('#select_cuenta_adl_pag').select2({
                placeholder: "Seleccionar",
            });

            $('#id_factura').attr('name', 'id_factura_m[]');
            $('#cod_factura').attr('name', 'numero_factura_m[]');
        });

        function changue_bancos_pagos() {
            // $("#select_banco_adl").attr('disabled', false);
            console.log('a');
            var id_banc = $("#select_banco_pagos").val();
            $('#select_cuenta_pago').select2({
                placeholder: "Seleccionar",
                ajax: {
                    minimumInputLength: 1,
                    url: "{{ route('bancos.registros_search') }}",
                    dataType: 'json',
                    type: "POST",
                    data: function(params) {
                        return {
                            '_token': $('input[name=_token]').val(),
                            'id_bancos': id_banc
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.tipo_cuenta + ' - ' + item.nombre_cuenta,
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        }

        function changue_bancos_pago_tr() {
            // $("#select_banco_adl").attr('disabled', false);
            console.log('a');
            var id_banc = $("#select_banco_transf_pag").val();
            $('#select_cuenta_adl_pag').select2({
                placeholder: "Seleccionar",
                ajax: {
                    minimumInputLength: 1,
                    url: "{{ route('bancos.registros_search') }}",
                    dataType: 'json',
                    type: "POST",
                    data: function(params) {
                        return {
                            '_token': $('input[name=_token]').val(),
                            'id_bancos': id_banc
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.tipo_cuenta + ' - ' + item.nombre_cuenta,
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        }
    </script>
    <script>
        function detalle_cuota(item) {
            $('#detalle_pago').modal('show');
            $('#id_cuota').html(item);

            var data = item;
            $.ajax({
                type: "post",
                url: "{{ route('pagos.show_cuota') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'data': item,
                },
                success: function(msg) {
                    var numero = $(`#numero_` + item).val();
                    var monto = $(`#monto_` + item).val();
                    // var vencimiento = $(`#fecha_ven_` + item).val();
                    var estado = $(`#estado_` + item).val();
                    $('#n_cuota_header').html(`Cuota N° ` + numero);
                    $('#monto_cuota_header').html(monto);
                    $('#estado_cuota_header').html(estado);
                    $('#body_pago_detail').append(msg['html_end']);
                }
            });
        }
        $('#detalle_pago').on('hidden.bs.modal', function(e) {
            $('#body_pago_detail').empty();
        });

        function check_lote(num) {
            var count_check = document.querySelectorAll('.check_only');
            let checkboxesDesactivados = 0;

            // Recorrer los checkboxes y contar los desactivados
            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkboxesDesactivados++;
                }
            });
            // console.log(checkboxesDesactivados);
            if (checkboxesDesactivados > 0) {
                $('#pago_lote').attr('disabled', false);
            } else {
                $('#pago_lote').attr('disabled', true);
            }
        }

        
        $('#pago_lote').on('click', function() {
            $('.lote_pago_sect').remove();
            $('.input_check').remove();
            $('.cuota_prec_fact').remove();
            var total_c = 0;
            var count_check = document.querySelectorAll('.check_only');
            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    var id_cuot = checkbox.id;
                    let id_one = id_cuot.match(/\d+/g);
                    modal_pagos_lote(id_one[0]);
                    total_c += parseFloat($(`#total_` + id_one[0]).val());
                    // $(`#cuota_precio`+id_one[0]+``).val(id_one[0] + '_' + total_c);
                }
            });
            $('#efectivo_pago').attr('min', total_c);
            $('#total_cuota').val(total_c);

        });
    </script>
@endsection
