<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia Egreso</title>{{--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
</head>
<style type="text/css">
    .form-control, .single-line {
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
                <td style="border: 1px #3D3D3D solid;border-radius: 8px;width: 29%;padding-top: 5px;vertical-align: middle" align="center">
                    <center><img align="center" src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" style="margin-top: 0px;" width="80%" /></center>
                </td>
                <td style="width: 6%;border-color: transparent"></td>
                <td style="width: 29%; ;border: 1px #3D3D3D solid;border-radius: 8px;margin: 2px 0px;vertical-align: middle" align="right">
                    <center><img align="" src="{{asset('archivos/imagenes/marcas/'.$garantias_guias_egreso->garantia_ingreso_i->marcas_i->imagen)}}" style="height: 50px;width: 150px;margin-top: 5px" /></center>
                </td>
                <td style="width: 6%;border-color: transparent"></td>
                <td style="width: 29%; ;border: 1px #3D3D3D solid;border-radius: 8px;margin: 2px 0px;align-items: center" align="right">
                    <center>
                        <h3 style="margin: 8px;"> R.U.C {{$mi_empresa->ruc}}</h3>
                        <h2 style="margin: 6px;" >GUÍA DE EGRESO</h2>
                        <h4 style="margin: 7px" >{{$garantias_guias_egreso->garantia_ingreso_i->orden_servicio}}</h4>
                    </center>
                </td>
            </tr>
        </table>
        <table style="width: 100%;border-collapse:separate">
            <tr >
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 4px;width: 47%" >
                    <center><h3 style="margin: 2px 0px 6px 0px">CONTACTO CLIENTE</h3></center>
                    <strong>@if($garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion == "RUC") Empresa: @else Nombre: @endif</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}<br>
                    <strong>{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion}}:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha:</strong>&nbsp;{{date("d/m/Y", strtotime($garantias_guias_egreso->garantia_ingreso_i->fecha_compra))}}<br>
                    <strong>Telefono:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Correo:</strong>&nbsp; {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->email}}<br>
                    <strong>Direccion:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->direccion}}<br>
                    <strong>Contacto:</strong>&nbsp;
                    @if($garantias_guias_egreso->garantia_ingreso_i->contacto_cliente_id == null)
                    <em>Sin Registro</em>
                    @else
                    {{$contacto->where('id','=',$garantias_guias_egreso->garantia_ingreso_i->contacto_cliente_id)->pluck('nombre')->first()}} &nbsp;
                    @endif<br>
                </td>
                <td style="width: 5%;border-color: transparent"></td>
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 4px;width: 47%">
                    <center><h3 style="margin: 2px 0px 6px 0px">CONDICIONES GENERALES</h3></center>
                    <strong>Técnico Asignado:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->apellidos}}<br>
                    <strong>Motivo:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->motivo}}<br>
                    <strong>Marca:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre}}<br>
                    <strong>Asunto:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->asunto}}<br>
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
                                <center><h3 style="margin: 1px 0px 5px 0px">DATOS DEL EQUIPO</h3></center>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-color: white;padding: 0px;width: 50%;"><strong>Modelo:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->nombre_equipo}}</td>
                            <td style="border-color: white;padding: 0px;width: 50%"><strong>Codigo Interno:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->codigo_interno}}</td>
                        </tr>
                        <tr>
                            <td style="border-color: white;padding: 0px;width: 50%"><strong>Número de Serie:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->numero_serie}}</td>
                            <td style="border-color: white;padding: 0px;width: 50%"><strong>Fecha de Compra:</strong>&nbsp;<span>{{date("d/m/Y", strtotime($garantias_guias_egreso->garantia_ingreso_i->fecha_compra))}}</span></td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
        <table style="width: 100%;border-collapse:separate">
            <tr>
                <td style="border: 1px #3D3D3D solid;border-radius: 4px;width: 33%;">
                    <center><strong style="align-content: center;margin: 5px">DESCRIPCION DEL PROBLEMA</strong></center><br>
                    <span style="font-size: 90%"> {!! nl2br($garantias_guias_egreso->descripcion_problema)!!}</span>
                </td>
                <td style="border: 1px #3D3D3D solid;border-radius: 4px;width: 33%">
                    <center><strong style="align-content: center;margin: 5px">REVISION Y DIAGNOSTICO</strong></center><br>
                    <span style="font-size: 90%"> {!! nl2br($garantias_guias_egreso->diagnostico_solucion)!!}</span>
                </td>
                <td style="border: 1px #3D3D3D solid;border-radius: 4px;width: 33%">
                    <center><strong style="align-content: center;margin: 5px">ESTÉTICA</strong></center><br>
                    <span style="font-size: 90%"> {!! nl2br($garantias_guias_egreso->recomendaciones)!!}</span>
                </td>
            </tr>
        </table >
<br>

<br>
<br>
<footer style="position:fixed;bottom:0;width:100%;height:180px;"> {{-- 250 --}}
    <div class="">
        <table class=" white-bg ">
            <tbody>
                <tr>
                    <td style="width: 15%;border: none"></td>
                    <td style="width: 27%;margin-right: 10%;margin-left: 10%;border-color: #3D3D3D">
                        <span style="width: 50%">
                            <center>
                                Departamento de Servicio Tecnico <br>Ing. {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->apellidos}}
                            </center>
                        </span>
                    </td>
                    <td style="width: 15%;border: none"></td>
                    <td style="width: 27%;margin-right: 10%;margin-left: 10%;border-color: #3D3D3D">
                        <span style="width: 50%">
                            <center>
                                {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}<br> ({{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion}}: {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento}})
                            </center>
                        </span>
                    </td>
                    <td style="width: 15%;border: none"></td>
                </tr>
            </tbody>
        </table>
    </div>
</footer>

<style>

    *{
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        color: #3D3D3D;
    }
    .cero{
    margin-bottom: 0px;

    }
     .table-bordered .blanco {
        border: none;
    }
    .blanco{border: none;
        border: medium transparent;
        }
    .border {
        border-color: #3D3D3D;
        border-width: 1px;
        border-style: solid;
    }

</style>

