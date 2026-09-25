@extends('layout')

@section('title', 'Comprobantes | Factura Manual')

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
                        <div class="row" style="justify-content: center">
                            @include('transaccion.comprobantes._shared.statistics')
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
                            <div class="tabs-scroll-top-comprobantes"></div>
                            <div class="tabs-scroll-bottom">
                                <ul class="nav nav-tabs" role="tablist" style="align-items: center;border-bottom: 0px !important;">
                                    <div class="nav nav-custom" style="min-width: 1450px;overflow-y: hidden;overflow-x: auto;">
                                        @include('transaccion.comprobantes._shared.tabs')
                                        {{-- Almacen --}}
                                        <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                            {{-- ALMACEN --}}
                                            @can('factura_m.crear')
                                                <a class="btn btn-primary" href="{{ route('facturacion_manual.create') }}"><i
                                                    class="fa fa-plus"></i></a>
                                            @endcan
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-download"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <button type="button" id="btn-imprimir" class="dropdown-item">
                                                        <i class="fa fa-print"></i> Imprimir
                                                    </button>
                                                    <button type="button" id="btn-exportar-filtrado" class="dropdown-item">
                                                        <i class="fa fa-file-excel-o"></i> Excel
                                                    </button>

                                                    <button type="button" id="btn-descargar-filtrado" class="dropdown-item">
                                                        <i class="fa fa-file-pdf-o"></i> PDF
                                                    </button>

                                                    <button type="button" id="btn-correo-filtrado" class="dropdown-item">
                                                        <i class="fa fa-envelope"></i> Correo
                                                    </button>

                                                    <button type="button" id="btn-whatsapp-filtrado" class="dropdown-item">
                                                        <i class="fa fa-whatsapp"></i> Whatsapp
                                                    </button>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                </ul>
                            </div>
                            <div class="tab-content" style="margin-top: -2px">
                                <!-- Factura-->
                                <div role="tabpanel" id="tab-4" class="tab-pane active show"  style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter"
                                                        value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}"
                                                        readonly="readonly" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <select class="form-control" name="estado_pago[]" id="select_estado_pago"  multiple="multiple" placeholder="Estado de Pago">
                                                    {{-- <option value="" selected>Estado de Pago</option> --}}
                                                    <option value="0">Sin Pagar</option>
                                                    <option value="1">P. Parcial</option>
                                                    <option value="2">P. Total</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <select class="form-control" name="" id="select_estado_sunat">
                                                    <option value="" selected>Todos los estados</option>
                                                    <option value="0">Sin Enviar</option>
                                                    <option value="1">Enviado</option>
                                                    <option value="2">Anulado</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                            </div>
                                            <div class="col-lg-1 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>{{--  Tabla de Cotizacion Manual   --}}
                                    <div class="scrooll-table-responsive">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-example-factura">
                                            <thead> 
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>N°</th>
                                                    <th>RUC/DNI</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Forma</th>
                                                    <th>Importe T.</th>
                                                    <th>@can('factura_m.ver') Ver @endcan</th>
                                                    <th style="width: 0.5vmax !important">Información</th>
                                                    <th>Pago</th>
                                                    <th>Compartir R.</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" id="">
                                                        <div style="display: flex;justify-content: space-between">
                                                            @foreach ($monedas as $coin)
                                                                <div>
                                                                    {{$coin->simbolo}} <span @if($coin->principal == 1) id="total-seleccion-prin" @else id="total-seleccion-sec" @endif >0.00</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </th>
                                                    <th colspan="5"></th>
                                                    <th class="total-columna">Total: 0</th>
                                                    <th colspan="2" class="total-total">Total G: 0</th>
                                                </tr>
                                            </tfoot>
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

    <!-- Estilos personalizados para iconos -->
    <style>
        /* botón sin fondo ni borde para que solo el icono sea visible */
        .info-icon {
            background-color: transparent;
            border: none;
            padding: 0;
            transition: none;
            color: inherit;
            /* hereda color del contexto (texto cercano) */
        }

        /* transiciones aplicadas al svg interior */
        .info-icon svg {
            transition: fill 0.3s, transform 0.2s;
            fill: currentColor;
            /* mismo color que el texto */
        }

        /* hover: cambia el tono (azul oscuro) y aumenta un poco */
        .info-icon:hover svg {
            color: #0056b3;
            /* tono diferente para indicar hover */
            transform: scale(1.1);
        }

        /* eliminar outline/box-shadow al enfocar el botón */
        .info-icon:focus {
            outline: none;
            box-shadow: none;
        }

        /* Estilos personalizados para el Popover */
        .popover-header {
            background-color: #2641f8; /* Azul solicitado */
            color: white;
            font-weight: normal !important;
        }

        .popover-body {
            background-color: white; /* Blanco solicitado */
            color: black;
            font-weight: normal !important;
        }
    </style>
    <input type="hidden" name="" id="tipo_comprobante_view" value="factura_manual">
    @include('transaccion.comprobantes._shared.js_shared')

    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#modal_pago_tipo_comprobante').val('factura_manual');
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-4-tab').addClass('active');
            var $bottom = $('.tabs-scroll-bottom');
            var $nav = $bottom.find('.nav-custom');
            var $tab = $nav.find('li').eq(3);

            if ($tab.length) {
                var target = $tab[0].offsetLeft - ($bottom.innerWidth() / 2) + ($tab.outerWidth(true) / 2);

                $bottom.animate({ scrollLeft: target }, 600);
            }

            $('#select_estado_pago').select2({
                placeholder: "Estado de Pago"
            });
        });

        //  {{-- SCRIPTS PARA DATATABLE --}}
        let permiso_ver = false;
        let permiso_pagar = false;
        var coti_table = $('.dataTables-example-factura').DataTable({
            "pageLength": 15,
            "serverSide": true,
            "ajax": {
                url: "{{ route('comprobantes.facturaM_registers') }}",
                method: "get",
                data: function(d) {
                    d.daterange = $('#data_range_filter').val();
                    d.estado_s = $('#select_estado_sunat').val();
                    d.estado_pago = $('#select_estado_pago').val();
                    d.value = $('#search_all_column').val();
                },
                dataSrc: function(json) {
                    var total_columna = json.total_columna;
                    var total_table = json.total_table;
                    $('.dataTables-example-factura tfoot th.total-columna').html('Total: ' + total_columna);
                    $('.dataTables-example-factura tfoot th.total-total').html('Total  G.: ' + total_table);
                    permiso_ver = json.permiso_ver;
                    permiso_pagar = json.permiso_pagar;
                    return json.data;
                }
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" name="select_row" value="' + full[0] +
                            '" class="i-checks-factura" data-total="'+full[19]+'" data-moneda="'+full[20]+'">';
                    }
                },
                {
                    'width': '11%',
                    'targets': [2],
                    'orderable': false,
                    'render': function(data, type, full, meta) {

                        const facturacionId = full[0];
                        const codigoFacturacion = full[2];
                        const notaInformativa = full[17];

                        let tieneNota = notaInformativa !== null && notaInformativa !== '';
                        let contenidoBoton = '';

                        if(tieneNota){
                            let escapedNota = notaInformativa.replace(/'/g, '&#39;').replace(/"/g, '&quot;');
                            let jsEscapedNota = notaInformativa.replace(/'/g, "\\'").replace(/"/g, '&quot;').replace(/\n/g, '\\n');

                            contenidoBoton = `
                                <button type="button" class="btn btn-sm info-icon"
                                        data-trigger="hover"
                                        data-placement="top"
                                        data-toggle="popover"
                                        title="Nota Informativa"
                                        data-content="${escapedNota}"
                                        onclick="gestionarNota(${facturacionId}, '${jsEscapedNota}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-square-fill" viewBox="0 0 16 16">
                                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm8.93 4.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                    </svg>
                                </button>
                            `;
                        } else {
                            contenidoBoton = `
                                <button type="button" class="btn btn-sm info-icon text-muted"
                                        title="Añadir Nota"
                                        onclick="gestionarNota(${facturacionId}, '')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-dotted" viewBox="0 0 16 16">
                                        <path d="M2.5 0c-.166 0-.33.016-.487.048l.194.98A1.51 1.51 0 0 1 2.5 1h.458V0zm2.292 0h-.917v1h.917zm1.833 0h-.917v1h.917zm1.833 0h-.916v1h.916zm1.834 0h-.917v1h.917zm1.833 0h-.917v1h.917zM13.5 0h-.458v1h.458c.1 0 .199.01.293.029l.194-.981A2.51 2.51 0 0 0 13.5 0m2.079 1.11a2.5 2.5 0 0 0-.69-.689l-.556.831c.164.11.305.251.415.415l.83-.556zM1 2.292V3.21h-1v-.917h1zm14 0v.917h1v-.917zM1 4.125v.917h-1v-.917h1zm14 0v.917h1v-.917zM1 5.958v.917h-1v-.917zm14 0v.917h1v-.917zM1 7.792v.916h-1v-.916zm14 0v.916h1v-.916zM1 9.625v.917h-1v-.917zm14 0v.917h1v-.917zM1 11.458v.917h-1v-.917zm14 0v.917h1v-.917zM1 13.292v.917h-1v-.917zm14 0v.917h1v-.917zM1.531 15.348a2.5 2.5 0 0 0 .69.689l.556-.831a1.5 1.5 0 0 1-.415-.415l-.83.556zM2.5 16h.458v-1h-.458a1.5 1.5 0 0 1-.293-.029l-.194.981c.157.032.321.048.487.048m2.292 0h.917v-1h-.917zm1.833 0h.917v-1h-.917zm1.833 0h.916v-1h-.916zm1.834 0h.917v-1h-.917zm1.833 0h.917v-1h-.917zM13.5 16c.166 0 .33-.016.487-.048l-.194-.98A1.51 1.51 0 0 1 13.5 15h-.458v1zM8 4.5a.5.5 0 0 1 .5.5v2.5H11a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V8.5H5a.5.5 0 0 1 0-1h2.5V5a.5.5 0 0 1 .5-.5"/>
                                    </svg>
                                </button>
                            `;
                        }

                        return `
                            <div class="d-flex align-items-center">
                                <span class="mr-2 text-secondary-emphasis">
                                    ${codigoFacturacion}
                                </span>
                                ${contenidoBoton}
                            </div>
                        `;
                    }
                },
                {
                    'width': '30%',
                    'targets': [4],
                    'orderable': false
                },
                {
                    'targets': [7],
                    'render': function(data, type, full, meta){
                        if(full[18] != ""){
                            return `<s>`+full[7] + `</s>`;
                        }else{
                            return ``+full[7]+``;
                        }
                    }
                },
                {
                    'width': '0.5vmax',
                    'targets': [8],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url = '{{ route('facturacion_manual.show', ':id') }}';
                        url = url.replace(':id', full[0]);
                        let button_show = ``;
                        if(permiso_ver){
                            button_show = `<a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a> `;
                        }
                        return button_show;
                    }
                },
                {
                    'targets': [9], // Configuración para otra columna (como la de acciones)
                    'orderable': false,
                    'render': function(data, type, full, meta) {

                        const estados = {
                            0: {
                                texto: "Sin Enviar",
                                clase: "btn-warning",
                                icono: "fa fa-clock-o"
                            },
                            1: {
                                texto: "Enviado",
                                clase: "btn-info",
                                icono: "fa fa-check-circle"
                            },
                            2: {
                                texto: "Anulado",
                                clase: "btn-danger",
                                icono: "fa fa-check-circle"
                            }
                            // No incluimos 99 porque no queremos que aparezca
                        };

                        let end = "";

                        const estadoSunat = parseInt(full[9]);
                        const estadoCredito = parseInt(full[10]);
                        const estadoDebito = parseInt(full[11]);
                        const estadoProcesado = parseInt(full[14]);

                        if(estadoProcesado == 0){
                            end += `<button class="btn btn-warning btn-circle btn-ls" title="Sin Finalizar"><i class="fa fa-clock-o"></i></button> `;
                            estados[0].clase = estados[0].clase + " disabled";
                            estados[0].texto = "No se puede enviar hasta Finalizar la Factura"
                        }else{
                            end += `<button class="btn btn-info btn-circle btn-ls" title="Finalizado"><i class="fa fa-check-circle"></i></button> `;
                        }

                        const e0 = estados[estadoSunat];
                        end += `<button class="btn ${e0.clase} btn-circle btn-ls" title=" ${e0.texto}" style="display: inline-flex;align-items: center;justify-content: center;">
                                    <img src="{{asset('sunat_blanco.png')}}" style="width:16px; height:16px;" />
                                </button> `;
                        // Solo muestra botón si el estado es válido y diferente de 99
                        if (estadoCredito != 99) {
                            const e1 = estados[estadoCredito];
                            end += `<button class="btn ${e1.clase} btn-circle btn-ls" title="Nota de crédito: ${e1.texto}">
                                        <i style="font-weight: 700" >NC</i>
                                    </button> `;
                        }

                        if (estadoDebito != 99) {
                            const e2 = estados[estadoDebito];
                            end += `<button class="btn ${e2.clase} btn-circle btn-ls" title="Nota de débito: ${e2.texto}">
                                        <i style="font-weight: 700" >ND</i>
                                    </button> `;
                        }

                        return end;

                    }
                },
                {
                    'targets': [10], // Configuración para otra columna (como la de acciones)
                    'orderable': false,
                    'className': 'column-actions',
                    'width': '1%',
                    'render': function(data, type, full, meta) {
                        // if(full[6] == "Contado"){
                        const estado_pago = {
                            0: { texto: "Sin Pago", clase: "btn-danger" },
                            1: { texto: "Pago Parcial", clase: "btn-warning" },
                            2: { texto: "Pago Completo", clase: "btn-info" }
                        };
                        const estadoPago = parseInt(full[15]);
                        const e3 = estado_pago[estadoPago];

                        let pago = full[16];
                        let class_pago = ``;
                        if(permiso_pagar){
                            class_pago = `button_hover_pago`;
                        }
                        switch (full[15]) {
                            case 0:
                                var end = `
                                    <div class="wrapper-hover">
                                        <button class="btn ${e3.clase} btn-circle btn-ls `+class_pago+`"
                                            data-id="${full[0]}"
                                            data-estado="${full[14]}"
                                            title="Pago: ${e3.texto}">  
                                        <i style="font-weight:700" class="fa fa-dollar"></i>
                                        </button>
                                    </div>
                                `;
                                break;
                            case 1:
                                var end = `
                                    <div class="wrapper-hover">
                                        <button class="btn ${e3.clase} btn-circle btn-ls `+class_pago+`"
                                            data-id="${full[0]}"
                                            data-estado="${full[14]}"
                                            title="Pago: ${e3.texto}" 
                                            title="Pago: ${e3.texto}">
                                            <i style="font-weight:700" class="fa fa-dollar"></i>
                                        </button>
                                        <div class="contenedor">
                                            <div class="mini-overlay">
                                                <span class="info_overlay">Info. Ult. Pago</span><br>
                                                <b>Monto: </b>${pago.monto_pagado}<br>
                                                <b>Fecha: </b>${pago.fecha_pago}<br>
                                                <b>Tipo: </b>${pago.tipo_pago}<br>
                                                <b>Dato: </b>${pago.detalle_pago}
                                            </div>
                                        </div>
                                    </div>
                                `;    
                                break;
                            case 2:
                                var end = `
                                    <div class="wrapper-hover">
                                        <button class="btn ${e3.clase} btn-circle btn-ls"
                                            title="Pago: ${e3.texto}">
                                            <i style="font-weight:700" class="fa fa-dollar"></i>
                                        </button>
                                        <div class="contenedor">
                                            <div class="mini-overlay">
                                                <span class="info_overlay">Info. Ult. Pago</span><br>
                                                <b>Monto: </b>${pago.monto_pagado}<br>
                                                <b>Fecha: </b>${pago.fecha_pago}<br>
                                                <b>Tipo: </b>${pago.tipo_pago}<br>
                                                <b>Dato: </b>${pago.detalle_pago}
                                            </div>
                                        </div>
                                    </div>
                                `; 
                            break;
                        }
                        if(full[18] != "01"){
                            return end;
                        }else{
                            return "";
                        }
                    }
                },
                {
                    'targets': [11], // Columna de Compartir (Boton de correo sin funcionamiento por ahora)
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        const facturaId = full[0];
                        const codigoFactura = full[2];
                        const celularCliente = full[12] || '';
                        const emailCliente = full[13] || '';

                        return `
                            <div style="display: inline-block; white-space: nowrap;">
                                <!-- Contenedor Correo -->
                                <div class="email-container" data-id="${facturaId}"
                                    style="display: inline-block; position: relative; vertical-align: top; margin-right: 5px;">
                                    <button type="button" class="btn btn-secondary" style="cursor: pointer;">
                                        <i class="fa fa-envelope fa-lg"></i>
                                    </button>
                                    <div class="email-form" data-id="${facturaId}"
                                        style="position: absolute; top: 100%; right: 0; margin-top: 5px; height: 0px;
                                        overflow: hidden; transition: height .4s; background: white;
                                        box-shadow: 0px 0px 5px rgba(0,0,0,0.3); border-radius: 4px;
                                        z-index: 9999; white-space: nowrap; min-width: 250px;">
                                        <form class="form-enviar-email" data-factura-id="${facturaId}" style="padding: 10px;">
                                            @csrf
                                            <div style="margin-bottom: 5px;">
                                                <input type="email" name="emails[]" placeholder="correo@ejemplo.com"
                                                    value="${emailCliente}"
                                                    style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" required />
                                            </div>
                                            <div class="emails-adicionales-${facturaId}"></div>
                                            <button type="button" class="btn-agregar-email btn btn-info btn-xs" data-id="${facturaId}"
                                                    style="padding: 3px 8px; margin-bottom: 5px; font-size: 11px;">
                                                <i class="fa fa-plus"></i> Agregar correo
                                            </button>
                                            <button type="submit" class="btn btn-secondary" style="padding: 5px 10px; float: right;">
                                                <i class="fa fa-send fa-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <!-- Contenedor WhatsApp -->
                                <div class="wsp-container" data-id="${facturaId}"
                                    style="display: inline-block; position: relative; vertical-align: top;">
                                    <a class="btn btn-success" style="background: green; border-color: green; cursor: pointer;">
                                        <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                    </a>
                                    <div class="wsp-form" data-id="${facturaId}"
                                        style="position: absolute; top: 100%; right: 0; margin-top: 5px; height: 0px;
                                        overflow: hidden; transition: height .4s; background: white;
                                        box-shadow: 0px 0px 5px rgba(0,0,0,0.3); border-radius: 4px;
                                        z-index: 9999; white-space: nowrap;">
                                        <form action="{{ route('agregado.whatsapp_send') }}" method="post" target="_blank" style="padding: 10px;">
                                            @csrf
                                            <input type="tel" name="numero" placeholder="999999999" value="${celularCliente}"
                                                style="width: 130px; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" required />
                                            <input type="text" name="mensaje" hidden />
                                            <input type="hidden" name="url" value="{{ route('pdf_fac_m', '') }}/${facturaId}?archivo=" />
                                            <input type="hidden" name="name_sin_cambio" value="Factura_${codigoFactura}" />
                                            <button type="submit" class="btn btn-success"
                                                style="background: green; border-color: green; padding: 5px 10px; margin-left: 5px;">
                                                <i class="fa fa-send fa-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                }
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('.i-checks-factura').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });

                $('[data-toggle="popover"]').popover({
                    trigger: 'hover',
                    container: 'body'
                });
            }
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
            coti_table.ajax.reload();
        });
    </script>
    @include('cobranzas._shared.facturas.modal_pago_all')
    <script>
        $(".select_2_multipl").select2();
        $('.select_2_estado').select2();
        $('.select_2_tipo_pago').select2();
        $(document).on('click', '.button_hover_pago', function () {
            if (parseInt($(this).data('estado')) != 0) {
                console.log($(this).data('id'));
                pago_rapido_factura($(this).data('id'));
            }
        });

        function pago_rapido_factura(n_factura) {
            // console.log('a');
            $('#div_facturas').empty();
            $('#tota_totas').html("0.00");
            $('#ids_divs_factura').empty();
            $('#todo_pago').modal('show');

            var only_id_fact = `
                <input type="hidden" name="id_factura_m[]" class="" id="id_factura_` + n_factura + `" value="` +
                n_factura + `">
            `;
            $('#ids_divs_factura').append(only_id_fact);
            var ids_array = [n_factura];
            $.ajax({
                type: "post",
                url: "{{ route('pagos.lista_ajax_fact_m') }}",
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
                                    <div class="col-sm-12">
                                        <div class="d-flex align-items-center my-2">
                                            <span class=" fw-bold"><strong>` + row.factura_cod + `</strong></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 div_select">
                                        <select id="sel_` + index + `" class="select_2_multipl_` + index +
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
                                    <div class="input-group  input-group-sm col-sm-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm"
                                                style="justify-content: center">` + row.factura_simbolo + `</span>
                                        </div>
                                        <label class="form-control form-control" id="lbl_tot_` + index + `"
                                            aria-describedby="inputGroup-sizing-sm">0</label>

                                        <input class="form-control form-control-sm" type="hidden"
                                            name="tot_cuotas[]" id="total_cuotas_` +
                            index + `">
                                    </div>
                                </div>
                            `;
                        $('#div_facturas').append(data);
                        $(`.select_2_multipl_` + index + ``).select2({
                            placeholder: "Seleccionar 1 o más cuotas"
                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:select', function(e) {
                            var data = e.params.data;

                            var ant = $(`#total_cuotas_` + index + ``).val();
                            if (ant == "") {
                                ant = 0;
                            }
                            console.log("total_cuotas_" + ant)

                            var data_cuota = data.text.replace(/N°-\d+: /g, '');
                            console.log(data_cuota);

                            var math_total = Math.round((parseFloat(data_cuota) + parseFloat(
                                ant)) * 100) / 100;
                            console.log("math_total" + math_total);
                            $(`#total_cuotas_` + index + ``).val(math_total);
                            $(`#lbl_tot_` + index + ``).html(math_total);
                            // TOTAL DE TOTALES
                            var tota_tot = $('#tota_totas').html();
                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            //TODO O NADA
                            var igual = $("#simbolor_label").html();
                            console.log("igual" + igual);
                            console.log("row.factura_simbolo" + row.factura_simbolo);

                            if (igual === row.factura_simbolo) {
                                var tot_math = Math.round((parseFloat(tota_tot) + parseFloat(
                                    data_cuota)) * 100) / 100;
                            } else {
                                var tipo_cambio = row.tipo_cambio;
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
                            console.log("aaa" + tot_math);
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max', tot_math);
                            $('#efectivo_pago').attr('min', tot_math);
                            $('#cheque_monto').val(tot_math);

                            $('#tarjeta_monto').val(tot_math);
                            $('#efectivo_monto').val(tot_math);
                            $('#transferencia_monto').val(tot_math);

                            console.log(data.id);
                            var ids_cuotas = data.id;
                            var ids_arry = ids_cuotas.split('_');

                            var cuota_array = `
                                <input class="input_check" type="hidden" name="id_cuota[]" value="` + ids_arry[0] +
                                `" id='cuota_` + ids_arry[0] + `'>
                            `;
                            $('#ids_divs_factura').append(cuota_array);

                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:unselect', function(e) {
                            var data = e.params.data;
                            var ids_cuotas = data.id;
                            var ids_arry = ids_cuotas.split('_');
                            console.log(ids_arry);
                            $(`#cuota_` + ids_arry[0] + ``).remove();

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

                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            var tot_math = Math.round((parseFloat(tota_tot) - parseFloat(
                                data_cuota)) * 100) / 100;
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
    </script>

    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>

    <script>
    $(document).ready(function() {
        // Variables globales
        var allSelectedIds = [];
        var masterChecked = false;
        var isUpdatingCheckboxes = false; // Flag para evitar loops infinitos

        // Inicializar iCheck
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        function hasAnySelection() {
            return Array.isArray(allSelectedIds) && allSelectedIds.length > 0;
        }

        function closeWhatsappPanels() {
            $('.wsp-form').removeClass('wsp-fixed').css('height', '0px');
        }

        function closeEmailPanels() {
            $('.email-form').removeClass('email-fixed').css('height', '0px');
        }

        // Función para obtener TODOS los IDs mediante AJAX (para serverSide DataTables)
        function getAllIds(callback) {
            $.ajax({
                url: "{{ route('comprobantes.facturaM_registers') }}",
                method: "GET",
                data: {
                    daterange: $('#data_range_filter').val(),
                    tipo_comprobante: $('#select_tipo_coti').val(),
                    estado_s: $('#select_estado_sunat').val(),
                    estado_pago: $('#select_estado_pago').val(),
                    value: $('#search_all_column').val(),
                    length: -1,
                    start: 0,
                    get_all_ids: true
                },
                success: function(response) {
                    var ids = [];
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(row) {
                            if (row[0]) {
                                ids.push(row[0].toString());
                            }
                        });
                    }
                    console.log('getAllIds() encontró estos IDs:', ids);
                    console.log('Total de IDs encontrados:', ids.length);
                    callback(ids);
                },
                error: function(xhr, status, error) {
                    console.error('Error obteniendo todos los IDs:', error);
                    callback([]);
                }
            });
        }

        // Función para actualizar el estado del master checkbox automáticamente
        function updateMasterCheckbox() {
            if (isUpdatingCheckboxes) return;

            getAllIds(function(allIds) {
                // Si hay IDs disponibles y todos están seleccionados, marcar master
                var allSelected = allIds.length > 0 && allIds.every(function(id) {
                    return allSelectedIds.includes(id);
                });

                isUpdatingCheckboxes = true;
                if (allSelected && !masterChecked) {
                    masterChecked = true;
                    $('thead input[type="checkbox"]').iCheck('check');
                    console.log('Master checkbox marcado automáticamente - todos los registros están seleccionados');
                } else if (!allSelected && masterChecked) {
                    masterChecked = false;
                    $('thead input[type="checkbox"]').iCheck('uncheck');
                    console.log('Master checkbox desmarcado automáticamente - no todos los registros están seleccionados');
                }
                isUpdatingCheckboxes = false;
            });
        }

        // Checkbox del header - seleccionar/deseleccionar todos
        $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
            if (isUpdatingCheckboxes) return; // Evitar loops infinitos

            closeWhatsappPanels();
            closeEmailPanels();

            if (event.type === 'ifChecked') {
                masterChecked = true;
                console.log('Master checkbox marcado manualmente - obteniendo todos los IDs...');

                getAllIds(function(ids) {
                    allSelectedIds = [...ids]; // Crear una copia del array
                    // console.log('allSelectedIds después del master:', allSelectedIds);
                    // console.log('Cantidad de IDs en allSelectedIds:', allSelectedIds.length);
                    totalSeleccionPrin = 0;
                    totalSeleccionSec = 0;

                    coti_table.rows().every(function() {
                        var rowNode = this.node();
                        var chk = $(rowNode).find('.i-checks-factura');
                        
                        var total = parseFloat(chk.data('total')) || 0;
                        var moneda = chk.data('moneda');

                        if (String(moneda_p_id) === String(moneda)) {
                            totalSeleccionPrin += total;
                        } else {
                            totalSeleccionSec += total;
                        }
                    });
                    $('#total-seleccion-prin').html(totalSeleccionPrin.toFixed(2));
                    $('#total-seleccion-sec').html(totalSeleccionSec.toFixed(2));
                    // Marcar todos los checkboxes visibles en la página actual
                    isUpdatingCheckboxes = true;
                    $('.dataTables-example-factura tbody input[type="checkbox"]').iCheck('check');
                    isUpdatingCheckboxes = false;
                });
            } else {
                masterChecked = false;
                allSelectedIds = [];
                // console.log('Master checkbox desmarcado manualmente - allSelectedIds limpio');
                totalSeleccionPrin = 0;
                totalSeleccionSec = 0;

                // 2. Actualizar el DOM
                $('#total-seleccion-prin').html(totalSeleccionPrin.toFixed(2));
                $('#total-seleccion-sec').html(totalSeleccionSec.toFixed(2));
                isUpdatingCheckboxes = true;
                $('.dataTables-example-factura tbody input[type="checkbox"]').iCheck('uncheck');
                isUpdatingCheckboxes = false;
            }
        });

        // Checkboxes individuales
        var totalSeleccionPrin = 0;
        var totalSeleccionSec = 0;
        var moneda_p_id  = `{{$monedas->where('principal', 1)->pluck('id')->first()}}`;
        var moneda_p_simbolo  = `{{$monedas->where('principal', 1)->pluck('simbolo')->first()}}`;
        $(document).on('ifChecked ifUnchecked', '.dataTables-example-factura tbody input[type="checkbox"]', function(event) {
            if (isUpdatingCheckboxes) return; // Evitar que se ejecute cuando estamos actualizando programáticamente

            closeWhatsappPanels();
            closeEmailPanels();

            var row = $(this).closest('tr');
            var rowData = coti_table.row(row).data();
            var moneda_comprobante = $(this).data('moneda');
            var total_select = parseFloat($(this).data('total')) || 0;

            if (rowData && rowData[0]) {
                var id = rowData[0].toString();

                if (event.type === 'ifChecked') {
                    // Agregar ID si no está ya seleccionado
                    if (!allSelectedIds.includes(id)) {
                        allSelectedIds.push(id);
                        if(moneda_p_id == moneda_comprobante){
                            totalSeleccionPrin += total_select;
                        }else{
                            totalSeleccionSec += total_select;
                        }
                    }
                    // console.log('Registro seleccionado:', id);
                } else {
                    // Remover ID de la selección
                    allSelectedIds = allSelectedIds.filter(function(selectedId) {
                        return selectedId !== id;
                    });
                    if(moneda_p_id == moneda_comprobante){
                        totalSeleccionPrin -= total_select;
                    }else{
                        totalSeleccionSec -= total_select;
                    }
                    // console.log('Registro deseleccionado:', id);

                    // Cuando se desmarca individualmente, salir del modo master
                    if (masterChecked) {
                        masterChecked = false;
                        isUpdatingCheckboxes = true;
                        $('thead input[type="checkbox"]').iCheck('uncheck');
                        isUpdatingCheckboxes = false;
                        console.log('Master checkbox desmarcado por deselección individual');
                    }
                }

                // console.log('allSelectedIds después de checkbox individual:', allSelectedIds);
                $('#total-seleccion-prin').html(totalSeleccionPrin.toFixed(2));
                $('#total-seleccion-sec').html(totalSeleccionSec.toFixed(2));
                // AQUÍ ESTÁ LA MAGIA: Verificar automáticamente si todos están seleccionados
                setTimeout(updateMasterCheckbox, 50);
            }
        });

        // Cuando se redibuje la tabla (cambio de página, etc.)
        coti_table.on('draw', function() {
            closeWhatsappPanels();
            closeEmailPanels();
            console.log('Tabla redibujada. allSelectedIds actual:', allSelectedIds);
            console.log('masterChecked actual:', masterChecked);

            // Reinicializar checkboxes
            $('.dataTables-example-factura tbody input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Usar setTimeout para asegurar que iCheck esté completamente inicializado
            setTimeout(function() {
                isUpdatingCheckboxes = true;

                // Procesar cada checkbox en la página actual
                $('.dataTables-example-factura tbody input[type="checkbox"]').each(function() {
                    var row = $(this).closest('tr');
                    var rowData = coti_table.row(row).data();

                    if (rowData && rowData[0]) {
                        var id = rowData[0].toString();

                        // Si este ID está en nuestra lista de seleccionados, marcarlo
                        if (allSelectedIds.includes(id)) {
                            $(this).iCheck('check');
                        } else {
                            $(this).iCheck('uncheck');
                        }
                    }
                });

                // Actualizar el estado del master checkbox
                if (masterChecked) {
                    $('thead input[type="checkbox"]').iCheck('check');
                } else {
                    $('thead input[type="checkbox"]').iCheck('uncheck');
                }

                isUpdatingCheckboxes = false;

                // Verificar si necesitamos actualizar el master checkbox automáticamente
                setTimeout(updateMasterCheckbox, 100);
            }, 150);
        });

        // ============CORREO ============
        // Fijar cuando se hace clic en el botón de correo
        $(document).on('click', '.email-container .btn-secondary', function(e) {
            if (hasAnySelection()) {
                e.preventDefault();
                e.stopPropagation();
                closeEmailPanels();
                return;
            }

            e.stopPropagation();
            const form = $(this).siblings('.email-form');
            form.addClass('email-fixed').css('height', (form.find('form').outerHeight() + 20) + 'px');
        });

        // Fijar también cuando se hace clic en el formulario o inputs
        $(document).on('click', '.email-form', function(e) {
            if (hasAnySelection()) {
                e.preventDefault();
                e.stopPropagation();
                closeEmailPanels();
                return;
            }

            e.stopPropagation();
            $(this).addClass('email-fixed').css('height', ($(this).find('form').outerHeight() + 20) + 'px');
        });

        $(document).on('click', '.btn-agregar-email', function() {
            const facturaId = $(this).data('id');
            const container = $(`.emails-adicionales-${facturaId}`);

            container.append(`
                <div style="margin-bottom: 5px; position: relative;">
                    <input type="email" name="emails[]" placeholder="correo@ejemplo.com"
                        style="width: calc(100% - 30px); padding: 5px; border: 1px solid #ccc; border-radius: 3px;" />
                    <button type="button" class="btn-eliminar-email btn btn-danger btn-xs"
                        style="padding: 3px 6px; position: absolute; right: 0; top: 0; height: 100%;">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            `);

            const form = $(`.email-form[data-id="${facturaId}"]`);
            form.css('height', (form.find('form').outerHeight() + 20) + 'px');
        });

        $(document).on('click', '.btn-eliminar-email', function() {
            const form = $(this).closest('.email-form');
            $(this).closest('div').remove();
            form.css('height', (form.find('form').outerHeight() + 20) + 'px');
        });

        // ============ ENVÍO DE CORREO AJAX ============
        $(document).on('submit', '.form-enviar-email', function(e) {
            e.preventDefault();

            const form = $(this);
            const facturaId = form.data('factura-id');
            const button = form.find('button[type="submit"]');
            const originalHtml = button.html();
            const emailFormContainer = $(`.email-form[data-id="${facturaId}"]`);

            // Validar que haya al menos un email
            const emails = form.find('input[type="email"]').map(function() {
                return $(this).val();
            }).get().filter(email => email.trim() !== '');

            if (emails.length === 0) {
                toastr.warning('Debes ingresar al menos un correo electrónico', 'Atención');
                return;
            }

            // Deshabilitar botón y mostrar loading
            button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

            // Mostrar toast de carga
            toastr.info('<i class="fa fa-spinner fa-spin"></i> Enviando correo, no cierre esta pestaña...', 'Procesando', {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: false,
                tapToDismiss: false
            });

            // Preparar datos
            const formData = new FormData(form[0]);

            $.ajax({
                url: "{{ route('facturaM.enviar-correo-directo', '') }}/" + facturaId,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Limpiar todos los toasts
                    toastr.clear();

                    if (response.success) {
                        // Cerrar formulario
                        emailFormContainer.removeClass('email-fixed').css('height', '0px');

                        // Resetear formulario
                        form[0].reset();
                        $(`.emails-adicionales-${facturaId}`).empty();

                        // Mostrar mensaje de éxito con Toast
                        toastr.success(response.message, '¡Enviado!');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function(xhr) {
                    // Limpiar todos los toasts
                    toastr.clear();

                    let errorMsg = 'Error al enviar el correo';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    toastr.error(errorMsg, 'Error');
                },
                complete: function() {
                    // Rehabilitar botón
                    button.prop('disabled', false).html(originalHtml);
                }
            });
        });

        // Cerrar al hacer clic fuera
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.email-container, .email-form').length) {
                $('.email-form').removeClass('email-fixed').css('height', '0px');
            }
        });

        // ============ WHATSAPP ============
        $(document).on('click', '.wsp-container .btn-success', function(e) {
            if (hasAnySelection()) {
                e.preventDefault();
                e.stopPropagation();
                closeWhatsappPanels();
                return;
            }

            e.stopPropagation();
            $(this).siblings('.wsp-form').addClass('wsp-fixed').css('height', '50px');
        });

        // Fijar también cuando se hace clic en el input o en cualquier parte del formulario
        $(document).on('click', '.wsp-form', function(e) {
            if (hasAnySelection()) {
                e.preventDefault();
                e.stopPropagation();
                closeWhatsappPanels();
                return;
            }

            e.stopPropagation();
            $(this).addClass('wsp-fixed').css('height', '50px');
        });

        $(document).on('submit', '.wsp-form form', function() {
            const form = $(this).closest('.wsp-form');
            form.removeClass('wsp-fixed').css('height', '0px');
        });

        // Cerrar al hacer clic fuera
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.wsp-container, .wsp-form').length) {
                $('.wsp-form').removeClass('wsp-fixed').css('height', '0px');
            }
        });

        // Función de impresión múltiple
        $('#btn-imprimir').on('click', function(e) {
            e.preventDefault();

            console.log('IDs seleccionados para imprimir:', allSelectedIds);

            if (allSelectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una factura manual para imprimir.",
                    type: "warning",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#1a3bb3"
                });
                return;
            }

            swal({
                title: "Confirmar impresión",
                text: `¿Deseas imprimir ${allSelectedIds.length} factura(s) manual(es) seleccionada(s)?`,
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sí, imprimir",
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#1a3bb3"
            }, function(isConfirm) {
                if (isConfirm) {
                    var url = '{{ route("facturaM.print.multiple") }}';
                    var params = new URLSearchParams();

                    allSelectedIds.forEach(function(id) {
                        params.append('facturaM_ids[]', id);
                    });

                    console.log('URL completa:', url + '?' + params.toString());

                    var printWindow = window.open(
                        url + '?' + params.toString(),
                        '_blank'
                    );

                    if (printWindow) {
                        printWindow.focus();
                    } else {
                        alert('Por favor, permite ventanas emergentes para imprimir');
                    }

                    swal({
                        title: "Procesando",
                        text: "Las facturas manuales se están imprimiendo...",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Manejar click del botón de exportar
        $('#btn-exportar-filtrado').on('click', function(e) {
            e.preventDefault();

            if (allSelectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una factura para exportar.",
                    type: "warning",
                    confirmButtonColor: "#1a3bb3"
                });
                return;
            }

            swal({
                title: "Confirmar exportación",
                text: `¿Deseas exportar ${allSelectedIds.length} factura(s) seleccionada(s) a Excel?`,
                type: "info",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#1a3bb3"
            }, function(isConfirm) {
                if (!isConfirm) return;

                $('#btn-exportar-filtrado').prop('disabled', true);

                $.ajax({
                    url: "{{ route('facturasM.exportar') }}",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ factura_ids: allSelectedIds }),
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    xhrFields: { responseType: 'blob' },
                    complete: () => $('#btn-exportar-filtrado').prop('disabled', false),
                    success: function(blob) {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `Facturas_${new Date().toISOString().slice(0,10)}.xlsx`;
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                    }
                });
            });
        // });
        });

        // Funciones helper para debugging (opcional)
        window.clearAllSelections = function() {
            allSelectedIds = [];
            masterChecked = false;
            isUpdatingCheckboxes = true;
            $('thead input[type="checkbox"]').iCheck('uncheck');
            $('.dataTables-example-factura tbody input[type="checkbox"]').iCheck('uncheck');
            isUpdatingCheckboxes = false;
            console.log('Todas las selecciones limpiadas');
        };

        window.getSelectedIds = function() {
            console.log('IDs actualmente seleccionados:', allSelectedIds);
            return allSelectedIds;
        };
        // Función para descargar boletas seleccionadas en PDF/ZIP
        $('#btn-descargar-filtrado').on('click', function(e) {
            e.preventDefault();

            console.log('IDs seleccionados para descargar:', allSelectedIds);

            if (allSelectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una factura manual para descargar.",
                    type: "warning",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#1a3bb3"
                });
                return;
            }

            var mensaje = allSelectedIds.length === 1
                ? "¿Deseas descargar la factura manual seleccionada en PDF?"
                : `¿Deseas descargar ${allSelectedIds.length} facturas manuales en un archivo ZIP?`;

            swal({
                title: "Confirmar descarga",
                text: mensaje,
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sí, descargar",
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#1a3bb3"
            }, function(isConfirm) {
                if (isConfirm) {
                    var url = '{{ route("facturaM.download.multiple") }}';
                    var params = new URLSearchParams();

                    allSelectedIds.forEach(function(id) {
                        params.append('facturaM_ids[]', id);
                    });

                    console.log('URL de descarga:', url + '?' + params.toString());

                    window.location.href = url + '?' + params.toString();

                    swal({
                        title: "Procesando",
                        text: allSelectedIds.length === 1
                            ? "La factura manual se está descargando..."
                            : "Las facturas manuales se están comprimiendo y descargando...",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Función para enviar boletas por Correo múltiple
        $('#btn-correo-filtrado').on('click', function(e) {
            e.preventDefault();

            if (allSelectedIds.length === 0) {
                return swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una factura manual para enviar por correo.",
                    type: "warning",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#1a3bb3"
                });
            }

            swal({
                title: "Enviar por Correo",
                text: `Ingresa el correo electrónico para enviar ${allSelectedIds.length} factura(s):`,
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "Enviar",
                cancelButtonText: "Cancelar",
                inputPlaceholder: "ejemplo@correo.com",
                confirmButtonColor: "#1a3bb3"
            }, function(inputValue) {
                if (inputValue === false) return false;
                if (!inputValue) return swal.showInputError("Por favor ingresa un correo electrónico");

                // Validar formato de email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(inputValue)) {
                    return swal.showInputError("Por favor ingresa un correo electrónico válido");
                }

                // Mostrar mensaje de procesando
                swal({
                    title: "Enviando...",
                    text: `Procesando ${allSelectedIds.length} factura(s). Por favor espera...`,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });

                // Enviar por AJAX
                $.ajax({
                    url: '{{ route('envioCorreo.facturaM.multiple') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: inputValue,
                        factura_ids: allSelectedIds
                    },
                    success: function(response) {
                        if (response.success) {
                            swal({
                                title: "¡Enviado!",
                                text: response.message || `Se han enviado ${allSelectedIds.length} factura(s) por correo`,
                                type: "success",
                                timer: 3000,
                                showConfirmButton: true,
                                confirmButtonColor: "#1a3bb3"
                            });
                        } else {
                            swal({
                                title: "Error",
                                text: response.message || "Hubo un error al enviar los correos",
                                type: "error",
                                confirmButtonText: "Entendido",
                                confirmButtonColor: "#1a3bb3"
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Error al enviar los correos';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        swal({
                            title: "Error",
                            text: errorMsg,
                            type: "error",
                            confirmButtonText: "Entendido",
                            confirmButtonColor: "#1a3bb3"
                        });
                    }
                });
            });
        });

        // Función para enviar boletas por WhatsApp multiple
        $('#btn-whatsapp-filtrado').on('click', function(e) {
            e.preventDefault();

            if (allSelectedIds.length === 0) {
                return swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una factura para enviar por WhatsApp.",
                    type: "warning",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#1a3bb3"
                });
            }

            swal({
                title: "Enviar por WhatsApp",
                text: `Ingresa el número de WhatsApp para enviar ${allSelectedIds.length} factura(s):`,
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "Enviar",
                cancelButtonText: "Cancelar",
                inputPlaceholder: "Ejemplo: 999999999",
                confirmButtonColor: "#1a3bb3"
            }, function(inputValue) {
                if (inputValue === false) return false;
                if (!inputValue) return swal.showInputError("Por favor ingresa un número de WhatsApp válido");
                if (!/^\d+$/.test(inputValue)) return swal.showInputError("Por favor ingresa solo números");

                swal.close();
                swal({
                    title: "Procesando...",
                    text: "Enviando facturas por WhatsApp",
                    type: "info",
                    showConfirmButton: false,
                    allowOutsideClick: false
                });

                const form = $('<form>', {
                    action: '{{ route('envioWhatsapp.facturaM.multiple') }}',
                    method: 'POST',
                    target: '_blank',
                    style: 'display:none;'
                });

                form.append($('<input>', {type: 'hidden', name: '_token', value: '{{ csrf_token() }}'}));
                form.append($('<input>', {type: 'hidden', name: 'numero', value: inputValue}));

                allSelectedIds.forEach(id => {
                    form.append($('<input>', {type: 'hidden', name: 'factura_ids[]', value: id}));
                });

                $('body').append(form);
                form.submit();
                setTimeout(() => form.remove(), 1000);
                setTimeout(() => {
                    swal({
                        title: "¡Enviado!",
                        text: `Se han enviado ${allSelectedIds.length} factura(s) por WhatsApp`,
                        type: "success",
                        timer: 3000,
                        showConfirmButton: true
                    });
                }, 500);
            });
        });
    });
    </script>
    <script>
        $(document).ready(function() {
            @if (session('success'))
                toastr.success("{{ session('success') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}", '', {
                    timeOut: 3000
                });
            @endif
        });
    </script>

    {{-- Script para la nota informativa --}}
    <script>
        // Función para gestionar nota usando un Modal Bootstrap estilizado e Inspinia-like
        function gestionarNota(id, notaActual) {
            // Cerrar popovers primero para que no estorben
            $('[data-toggle="popover"]').popover('hide');

            // Eliminar modal anterior si existe en el DOM
            $('#modalGestionarNota').remove();

            let title = notaActual ? 'Editar Nota Informativa' : 'Agregar Nota Informativa';
            let deleteBtn = notaActual ? `<button type="button" class="btn btn-danger" style="border-radius: 4px;" onclick="confirmarEliminarNota(${id})"><i class="fa fa-trash"></i> Eliminar</button>` : '';
            let saveBtnText = notaActual ? 'Actualizar' : 'Guardar';
            let iconHeader = notaActual ? 'fa-pencil-square-o' : 'fa-plus-circle';

            let modalHTML = `
            <div class="modal fade" id="modalGestionarNota" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content border-0 shadow" style="border-radius: 6px; overflow: hidden;">
                        <div class="modal-header d-flex justify-content-between align-items-center" style="background-color: #1a3bb3; color: white; border-bottom: none; padding: 15px 20px;">
                            <h5 class="modal-title" style="margin: 0; font-weight: 500; font-size: 16px;"><i class="fa ${iconHeader} mr-2"></i>${title}</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8; padding: 10px; margin: -10px -10px -10px auto; outline: none; text-shadow: none;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body bg-light" style="padding: 20px;">
                            <label class="font-weight-bold text-muted mb-2">Contenido de la nota:</label>
                            <textarea id="input-modal-nota" class="form-control" rows="4" placeholder="Escriba aquí..." style="border-radius: 4px; resize: none;"></textarea>
                        </div>
                        <div class="modal-footer bg-white d-flex justify-content-between align-items-center" style="border-top: 1px solid #e7eaec; padding: 12px 20px;">
                            <div>
                                ${deleteBtn}
                            </div>
                            <div>
                                <button type="button" class="btn btn-white" data-dismiss="modal" style="border-radius: 4px; margin-right: 5px;">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="guardarDesdeModal(${id})" style="background-color: #1a3bb3; border-color: #1a3bb3; border-radius: 4px;">${saveBtnText}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

            $('body').append(modalHTML);
            $('#input-modal-nota').val(notaActual);

            // Enfocar automáticamente el textarea cuando el modal se abre
            $('#modalGestionarNota').on('shown.bs.modal', function () {
                $('#input-modal-nota').focus();
            });

            $('#modalGestionarNota').modal('show');
        }

        function guardarDesdeModal(id) {
            let nota = $('#input-modal-nota').val().trim();
            if (!nota) {
                toastr.warning('La nota no puede estar vacía al guardar. Si desea borrarla, use el botón rojo de "Eliminar".');
                $('#input-modal-nota').focus();
                return;
            }
            enviarNotaAjax(id, nota, false);
        }

        function confirmarEliminarNota(id) {
            // Ocultamos el modal principal mientras mostramos SweetAlert sobre el borrado
            $('#modalGestionarNota').modal('hide');

            setTimeout(function() {
                swal({
                    title: "¿Eliminar nota?",
                    text: "Esta acción no se puede deshacer.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#1a3bb3",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true
                }, function(isConfirm){
                    if(isConfirm){
                        enviarNotaAjax(id, '', true);
                    } else {
                        // Si cancela, reabrimos el modal de edición
                        $('#modalGestionarNota').modal('show');
                    }
                });
            }, 300);
        }

        function enviarNotaAjax(id, nota, isDelete = false) {
            // Bloqueamos los botones para evitar doble submit
            $('#modalGestionarNota').find('.btn').prop('disabled', true);

            $.ajax({
                url: "{{ route('facturacionM.guardar_nota', ':id') }}".replace(':id', id),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    nota_informativa: nota
                },
                success: function(response) {
                    if(response.success){
                        $('#modalGestionarNota').modal('hide');
                        if (isDelete) {
                            toastr.success('Nota eliminada correctamente', 'Éxito');
                        } else {
                            toastr.success(response.message, 'Éxito');
                        }
                        // Recargar tabla
                        $('.dataTables-example-factura').DataTable().ajax.reload(function() {
                            $('[data-toggle="popover"]').popover({
                                trigger: 'hover',
                                container: 'body'
                            });
                        }, false);
                    }else{
                        toastr.error(response.message, "Error");
                        $('#modalGestionarNota').find('.btn').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    toastr.error("Error al procesar la nota.", "Error");
                    $('#modalGestionarNota').find('.btn').prop('disabled', false);
                }
            });
        }
    </script>
    @include('cobranzas._shared.js')
@endsection
