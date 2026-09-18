<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia Informe Tecnico</title>{{--
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
                <center><img align="center" src="{{asset('img/logos/'.$mi_empresa->foto)}}" style="margin-top: 0px;" width="80%" /></center>
            </td>
            <td style="width: 6%;border-color: transparent"></td>
            <td style="width: 29%; ;border: 1px #3D3D3D solid;border-radius: 8px;margin: 2px 0px;vertical-align: middle" align="right">
                <center><img align="" src="{{asset('archivos/imagenes/marcas/'.$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->imagen)}}" style="height: 50px;width: 150px;margin-top: 5px" /></center>
            </td>
            <td style="width: 6%;border-color: transparent"></td>
            <td style="width: 29%;border: 1px #3D3D3D solid;border-radius: 8px;margin: 2px 0px;align-items: center" align="right">
                <center>
                    <h3 style="margin: 8px;"> R.U.C {{$mi_empresa->ruc}}</h3>
                    <h2 style="margin: 6px;" >GUÍA DE INGRESO</h2>
                    <h4 style="margin: 7px" >{{$garantias_informe_tecnico->orden_servicio}}</h4>
                </center>
            </td>
        </tr>
    </table>
    <table style="width: 100%;border-collapse:separate">
        <tr >
            <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 4px;width: 47%" >
                <center><h3 style="margin: 2px 0px 6px 0px">CONTACTO CLIENTE</h3></center>
                <strong>@if($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion == "RUC") Empresa: @else Nombre: @endif</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}<br>
                <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion}}:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha:</strong>&nbsp;{{date("d/m/Y", strtotime($garantias_informe_tecnico->fecha))}}<br>
                <strong>Teléfono:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>Correo:</strong>&nbsp; {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email}}<br>
                <strong>Dirección:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->direccion}}<br>
                <strong>Contacto:</strong>&nbsp;
                @if($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contacto_cliente_id == null)
                <em>Sin Registro</em>
                @else
                {{$contacto->where('id','=',$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contacto_cliente_id)->pluck('nombre')->first()}} &nbsp;
                @endif<br>
            </td>
            <th style="width: 5%;border-color: white"></th>
            <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 4px;width: auto" >
                <center><h3 style="margin: 2px 0px 6px 0px">CONDICIONES GENERALES</h3></center>
                <strong>Técnico. Asignado:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->apellidos}}<br>
                <strong>Motivo:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo}}<br>
                <strong>Marca:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre}}<br>
                <strong>Asunto:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto}}<br>
            </td>
        </tr>


    </table>
    <br>
    <table style="width: 100%;border-collapse:separate">
        <tr>
            <td style="border: 1px #3D3D3D solid;border-radius: 4px;width: 100%;">
                <table style="border-color: white;">
                    <tr>
                        <td colspan="3" style="border-color: white;padding: 0px">
                            <center><h3 style="margin: 1px 0px 5px 0px">DATOS DEL EQUIPO</h3></center>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-color: white;padding: 0px;width: 47%;"><strong>Modelo:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->nombre_equipo}}</td>
                        <td style="border-color: white;padding: 0px;width: 5%;"></td>
                        <td style="border-color: white;padding: 0px;width: auto"><strong>Código Interno:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->codigo_interno}}</td>
                    </tr>
                    <tr>
                        <td style="border-color: white;padding: 0px;width: 47%;"><strong>Número de Serie:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->numero_serie}}</td>
                        <td style="border-color: white;padding: 0px;width: 5%;"></td>
                        <td style="border-color: white;padding: 0px;width: auto"><strong>Fecha de Compra:</strong>&nbsp;<span>{{date("d/m/Y", strtotime($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha_compra))}}</span></td>

                    </tr>
                    <tr>
                        <td style="border-color: white;padding: 0px;width: 47%;"><strong>Descripción del Problema:</strong>&nbsp;{!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->descripcion_problema)!!}</td>
                        <td style="border-color: white;padding: 0px;width: 5%;"></td>
                        <td style="border-color: white;padding: 0px;width: auto"><strong>Revisión y Diagnóstico:</strong>&nbsp;<span>{!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->revision_diagnostico)!!} </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

<table style="width: 100%;border-collapse:separate">
    <tr >
         <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 4px;width: auto" >
            <center><strong style="align-content: center;margin: 5px">ESTÉTICA:</strong></center><br>
            <span>  {!! nl2br($garantias_informe_tecnico->estetica)!!} </span>
            <br>
        </td>
        <th style="width: 5%;border-color: white"></th>
         <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 4px;width: auto" >
            <center><strong style="align-content: center;margin: 5px">REVISIÓN Y DIAGNÓSTICO:</strong></center><br>
            <span> {!! nl2br($garantias_informe_tecnico->revision_diagnostico)!!} </span>
            <br>
        </td>
        {{-- &nbsp;&nbsp;&nbsp; --}}
    </tr>
    <tr style="border-color: white">
        <td style="border-color: white"> </td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 4px;width: auto">
            <center><strong style="align-content: center;margin: 5px">CAUSAS DEL PROBLEMA:</strong></center><br>
            <span>  {!! nl2br($garantias_informe_tecnico->causas_del_problema)!!}</span>
            <br>
        </td>
         <th style="width: 5%;border-color: white"></th>
        <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 4px;width: auto">
            <center><strong style="align-content: center;margin: 5px">SOLUCIÓN:</strong></center><br>
            <span> {!! nl2br($garantias_informe_tecnico->solucion)!!}  </span>
            <br>
        </td>
    </tr>
</table >
</div>
<br>
<footer style="position: absolute;bottom:0;width:100%;height:180px;"> {{-- 250 --}}
    <div style="">
        <table class=" white-bg ">
            <tbody>
                <tr>
                    <td class="blanco"></td>
                    <td class="blanco" style="width: 70px;border-top: none;" ><hr style="width:200px;border-top-width:0.1px"  /> </td>
                    <td class="blanco" style="border-top: none;"></td>
                    <td class="blanco" style="width: 70px; border-top: none;"><hr style="width:200px;border-top-width:0.1px"  /> </td>
                </tr>
                <tr>
                    <td class="blanco"></td>
                    <th class="blanco" style="width: 200px;border-top: none;"><center>    Departamento de Servicio Técnico <br>Ing. {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->apellidos}} {{-- {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->apellidos}} --}}</center></th>
                    <th class="blanco" style="border-top: none;"></th>
                    <th class="blanco" style="width: 200px; border-top: none;"><center>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}<br> ({{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion}}: {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento}})  </center></th>
                </tr>
                <tr>
                    <td colspan="6" class="blanco">{{-- <p><b>IMPORTANTE:</b> El plazo para el recojo del equipo es de 15 días calendario. en caso de no recoger el equipo dentro de los plazos, este será trasladado al almacén. debiendo pagar S/.20.00 por cada semana que transcurra por gastos administrativos, seguros y almacenaje. Así mismo pasado los 90 días el cliente pierde el derecho total sobre el equipo. </p> --}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
</footer>

<div style="page-break-after:auto; width: 100%;height: 80%" >
    <div class="table">
         <table style="width: 100%;border-collapse:separate">
          <tr>
              <td colspan="4" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 100%;">
                <center><strong>Imágenes:</strong> <br></center>
                <div style="padding-top: 50px;padding-left: 25px">

                  @foreach($archivo_informe_tecnico as $archivo)
                    <img  src="{{asset('archivos/imagenes/informe_tecnico')}}/{{$archivo->archivos}}" style="width:200px;height: 200px;border-radius: 10px;padding: 5px">
                @endforeach
                </div>
              </td>
          </tr>
      </table>
  </div>
</div>

<style>
        *{
            color: #3D3D3D;
            font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        }
        .cero{
            margin-bottom: 0px;

        }
        .table-bordered .blanco {
            border: none;
        }
        .blanco{
            border: none;
            border-color: #3D3D3D ;
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

