<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia Ingreso</title>{{--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
</head>
<style type="text/css">
    .form-control,
    .single-line {
        background-color: #FFFFFF;
        background-image: none;
        border: 1px solid #e5e6e7;
        border-radius: 1px;
        color: inherit;
        display: block;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        width: 100%;
    }

    @page {
        size: A4;
        font-size: 60% !important;
    }
</style>

<body class="white-bg">
    <div class="wrapper wrapper-content animated fadeIn">
        <table style="width: 100%;border-collapse:separate">
            <tr>
                <td style="border: 1px #3D3D3D solid;border-radius: 8px;width: 29%;padding-top: 5px;vertical-align: middle"
                    align="center">
                    <center><img align="center" src="{{ asset('img/logos/') }}/{{ $empresa->foto }}"
                            style="margin-top: 0px;" width="80%" /></center>
                </td>
                <td style="width: 6%;border-color: transparent"></td>
                <td style="width: 29%; ;border: 1px #3D3D3D solid;border-radius: 8px;margin: 2px 0px;vertical-align: middle"
                    align="right">
                    <center><img align=""
                            src="{{ asset('archivos/imagenes/marcas/' . $garantia_guia_ingreso->marcas_i->imagen) }}"
                            style="height: 50px;width: 150px;margin-top: 5px" /></center>
                </td>
                <td style="width: 6%;border-color: transparent"></td>
                <td style="width: 29%; ;border: 1px #3D3D3D solid;border-radius: 8px;margin: 2px 0px;align-items: center"
                    align="right">
                    <center>
                        <h3 style="margin: 8px;"> R.U.C {{ $mi_empresa->ruc }}</h3>
                        <h2 style="margin: 6px;">GUÍA DE INGRESO</h2>
                        <h4 style="margin: 7px">{{ $garantia_guia_ingreso->orden_servicio }}</h4>
                    </center>
                </td>
            </tr>
        </table>
        <table style="width: 100%;border-collapse:separate">
            <tr>
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 4px;width: 47%">
                    <center>
                        <h3 style="margin: 2px 0px 6px 0px">CONTACTO CLIENTE</h3>
                    </center>
                    <strong>
                        @if ($garantia_guia_ingreso->clientes_i->documento_identificacion == 'RUC')
                            Empresa:
                        @else
                            Nombre:
                        @endif
                    </strong>&nbsp;{{ $garantia_guia_ingreso->clientes_i->nombre }}<br>
                    <strong>{{ $garantia_guia_ingreso->clientes_i->documento_identificacion }}:</strong>&nbsp;{{ $garantia_guia_ingreso->clientes_i->numero_documento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <strong>Teléfono:</strong>&nbsp;{{ $garantia_guia_ingreso->clientes_i->telefono }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Correo:</strong>&nbsp; {{ $garantia_guia_ingreso->clientes_i->email }}<br>
                    <strong>Dirección:</strong>&nbsp;{{ $garantia_guia_ingreso->clientes_i->direccion }}<br>
                    <strong>Contacto:</strong>&nbsp;
                    @if ($garantia_guia_ingreso->contacto_cliente_id == null)
                        <em>Sin Registro</em>
                    @else
                        {{ $contacto->where('id', '=', $garantia_guia_ingreso->contacto_cliente_id)->pluck('nombre')->first() }}
                        &nbsp;
                    @endif
                    <br>
                </td>
                <td style="width: 5%;border-color: transparent"></td>
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 4px;width: 47%">
                    <center>
                        <h3 style="margin: 2px 0px 6px 0px">CONDICIONES GENERALES</h3>
                    </center>
                    <strong>Técnico Asignado:</strong>&nbsp;{{ $garantia_guia_ingreso->personal_laborales->nombres }}
                    {{ $garantia_guia_ingreso->personal_laborales->apellidos }}<br>
                    <strong>Motivo:</strong>&nbsp;{{ $garantia_guia_ingreso->motivo }}<br>
                    <strong>Marca:</strong>&nbsp;{{ $garantia_guia_ingreso->marcas_i->nombre }}<br>
                    <strong>Asunto:</strong>&nbsp;{{ $garantia_guia_ingreso->asunto }}<br>
                    <strong>Fecha:</strong>&nbsp;{{ date('d/m/Y', strtotime($garantia_guia_ingreso->fecha)) }}
                </td>
            </tr>
        </table>
        <br>
        <table style="width: 100%;border-collapse:separate">
            <tr>
                <td style="border: 1px #3D3D3D solid;border-radius: 4px;width: 100%;">
                    <table style="border-color: white;">
                        <tr>
                            <td colspan="2" style="border-color: white;padding: 0px">
                                <center>
                                    <h3 style="margin: 1px 0px 5px 0px">DATOS DEL EQUIPO</h3>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-color: white;padding: 0px;width: 50%;">
                                <strong>Modelo:</strong>&nbsp;{{ $garantia_guia_ingreso->nombre_equipo }}
                            </td>
                            <td style="border-color: white;padding: 0px;width: 50%"><strong>Codigo
                                    Interno:</strong>&nbsp;{{ $garantia_guia_ingreso->codigo_interno }}</td>
                        </tr>
                        <tr>
                            <td style="border-color: white;padding: 0px;width: 50%"><strong>Número de
                                    Serie:</strong>&nbsp;{{ $garantia_guia_ingreso->numero_serie }}</td>
                            <td style="border-color: white;padding: 0px;width: 50%"><strong>Fecha de
                                    Compra:</strong>&nbsp;<span>{{ date('d/m/Y', strtotime($garantia_guia_ingreso->fecha_compra)) }}</span>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        <table style="width: 100%;border-collapse:separate">
            <tr>
                <td style="border: 1px #3D3D3D solid;border-radius: 4px;width: 33%;">
                    <center><strong style="align-content: center;margin: 5px">DESCRIPCIÓN DEL PROBLEMA</strong></center>
                    <br>
                    <span style="font-size: 90%"> {!! nl2br($garantia_guia_ingreso->descripcion_problema) !!}</span>
                </td>
                <td style="border: 1px #3D3D3D solid;border-radius: 4px;width: 33%">
                    <center><strong style="align-content: center;margin: 5px">REVISIÓN Y DIAGNÓSTICO</strong></center>
                    <br>
                    <span style="font-size: 90%"> {!! nl2br($garantia_guia_ingreso->revision_diagnostico) !!}</span>
                </td>
                <td style="border: 1px #3D3D3D solid;border-radius: 4px;width: 33%">
                    <center><strong style="align-content: center;margin: 5px">ESTÉTICA</strong></center><br>
                    <span style="font-size: 90%"> {!! nl2br($garantia_guia_ingreso->estetica) !!}</span>
                </td>
            </tr>
        </table>
        <br><br>
        <footer style="position:fixed;bottom:0;width:100%;height:250px;">
            <div class="">
                <table class=" white-bg ">
                    <tbody>
                        <tr>
                            <td class="blanco"></td>
                            <td class="blanco" style="width: 70px;border-top: none;">
                                <hr style="width:200px;border-top-width:0.1px" />
                            </td>
                            <td class="blanco" style="border-top: none;"></td>
                            <td class="blanco" style="width: 70px; border-top: none;">
                                <hr style="width:200px;border-top-width:0.1px" />
                            </td>
                        </tr>
                        <tr>
                            <td class="blanco"></td>
                            <th class="blanco" style="width: 200px;border-top: none;">
                                <center> Departamento de Servicio Técnico <br>Ing.
                                    {{ $garantia_guia_ingreso->personal_laborales->nombres }}
                                    {{ $garantia_guia_ingreso->personal_laborales->apellidos }}</center>
                            </th>
                            <th class="blanco" style="border-top: none;"></th>
                            <th class="blanco" style="width: 200px; border-top: none;">
                                <center>{{ $garantia_guia_ingreso->clientes_i->nombre }}<br>
                                    ({{ $garantia_guia_ingreso->clientes_i->documento_identificacion }}:
                                    {{ $garantia_guia_ingreso->clientes_i->numero_documento }}) </center>
                            </th>
                        </tr>
                        <tr>
                            <td colspan="6" class="blanco">
                                <p><b>IMPORTANTE:</b> Toda revisión por garantía consta de 48 horas. El plazo para el
                                    recojo del equipo es de 15 días calendario. en caso de no recoger el equipo dentro
                                    de los plazos, este será trasladado al almacén. debiendo pagar S/.20.00 por cada
                                    semana que transcurra por gastos administrativos, seguros y almacenaje. Así mismo
                                    pasado los 90 días el cliente pierde el derecho total sobre el equipo. </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="border: 1px solid #EBEBEB;">
                    <tbody>
                        <tr align="center" style="box-sizing: border-box;border: 1px solid #EBEBEB;font-size: 90%">
                            <th style="width:21.3%;border: 1px solid #EBEBEB;">{{ $garantia_guia_ingreso->clientes_i->nombre }}</th>
                            <th style="width: 12%;border: 1px solid #EBEBEB;">{{ $garantia_guia_ingreso->orden_servicio }}</th>
                            <th style="width:21.3%;border: 1px solid #EBEBEB;">{{ $garantia_guia_ingreso->clientes_i->nombre }}</th>
                            <th style="width: 12%;border: 1px solid #EBEBEB;">{{ $garantia_guia_ingreso->orden_servicio }}</th>
                            <th style="width:21.3%;border: 1px solid #EBEBEB;">{{ $garantia_guia_ingreso->clientes_i->nombre }}</th>
                            <th style="width: 12%">{{ $garantia_guia_ingreso->orden_servicio }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </footer>
    </div>
    <style>
        * {
            color: #3D3D3D;
            font-family: apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        .cero {
            margin-bottom: 0px;

        }

        .table-bordered .blanco {
            border: none;
        }

        .blanco {
            border: none;
            border-color: #3D3D3D;
        }

        .border {
            border-color: #3D3D3D;
            border-width: 1px;
            border-style: solid;
        }

        .table {
            margin-bottom: 1rem;
            background-color: transparent;
            border-top-width: 0px;
        }
    </style>
</body>

</html>
