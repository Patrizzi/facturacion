@extends('layout')

@section('title', 'Boleta')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('content')
@section('button2', 'Atrás')
@section('config',route('Configuracion'))

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h3><strong> Datos del cliente</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row ">
                                    <div class="col-sm-12">
                                            <div style="margin: auto 50px">
                                                <div class="form-group row">
                                                <label class="col-sm-4 col-form-label"><strong>Cliente:</strong></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control">
                                                        <option value="">Seleccione un cliente</option>
                                                        <option value="">ARTHRO MEDS SPORT S.A.C | 20603185197</option>
                                                        <option value="">BOX PARTS SOCIEDAD ANONIMA CERRADA | 20605675523</option>
                                                        <option value="">CELESTE DEL CARMEN UGARTE HUACCHILLO | 72875303</option>
                                                        <option value="">RAUL EDUARDO RODRIGUEZ SALAZAR | 09892148</option>
                                                        <option value="">ABRAHAN JOSUE GONZALES FERNANDEZ | 76652408</option>
                                                        <!-- Agrega más opciones según sea necesario -->
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-4 col-form-label"><strong>RUC:</strong></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" placeholder="Ingrese el RUC">
                                                        </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h3><strong> Datos del Vendedor</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row ">
                                    <div class="col-sm-12">
                                            <div style="margin: auto 50px">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><strong>Vendedor:</strong></label>
                                                    <div class="col-sm-8">
                                                        <p class="form-control">Administrador</p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-4 col-form-label"><strong>Contacto:</strong></label>
                                                    <div class="col-sm-8">
                                                        <p class="form-control">987654320</p>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h3><strong>Datos de la Venta</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row col-lg-12">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Orden de Compra:</strong></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Guía de Remisión:</strong></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Comisionista:</strong></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control"placeholder="Ingrese la comision">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Forma de pago:</strong></label>
                                            <div class="col-sm-7">
                                                <select class="form-control">
                                                    <option>Seleccione</option>
                                                    <option>Contado</option>
                                                    <option>Crédito</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Observación:</strong></label>
                                            <div class="col-sm-7">
                                                <textarea id="Observación" name="Observación" class="form-control" autocomplete="off" placeholder="Observación" style="margin-top: 5px;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Fecha de Inicio:</strong></label>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control" value="2024-11-06" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Fecha de Vencimiento:</strong></label>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control" value="2024-11-06" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Moneda:</strong></label>
                                            <div class="col-sm-7">
                                                <select class="form-control">
                                                    <option>Seleccione</option>
                                                    <option>Soles</option>
                                                    <option>Dolares</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Tipo de Operación:</strong></label>
                                            <div class="col-sm-7">
                                                    <select class="form-control" name="tipo_operacion">
                                                        <option id="1">0101 - Venta Interna</option>
                                                        <option id="2">0200 - Exportación</option>
                                                        <option id="3">0103 - No Domiciliados</option>
                                                        <option id="4">0104 - Venta Interna - Anticipos</option>
                                                        <option id="5">0105 - Venta Itinerante</option>
                                                        <option id="6">0106 - Factura Guía</option>
                                                        <option id="7">0107 - Venta Arroz Pilado</option>
                                                        <option id="8">0108 - Factura - Comprobante de Percepción</option>
                                                        <option id="9">0110 - Factura - Guía Remitente</option>
                                                        <option id="10">0111 - Factura - Guía de Transportista</option>
                                                        <option id="11">0201 - Exportación de Servicios - Prestación servicios realizados</option>
                                                        <option id="12">1001 - Operacion Sujeta a Detracción</option>
                                                        <option id="13">1002 - Operacion sujeta a detracción - Recursos Hidrobiológicos</option>
                                                        <option id="14">1003 - Operacion sujeta a detracción - Servicios de transporte pasajeros</option>
                                                        <option id="15">1004 - Operacion sujeta a detracción - Servicios de transporte de carga</option>
                                                        <option id="16">2001 - Operación Sujeta a Percepción</option>
                                                        <option id="17">2002 - Operación Sujeta a Retención de Renta de segunda categoría</option>
                                                        <option id="18">2100 - Créditos a empresas</option>
                                                    </select>

                                            </div>
                                        </div>
                                    </div>
                                    <!--TABLA DE AGREGAR-->
                                    <div class="table-responsive">
                                        <table cellspacing="0" class="table tables">
                                            <thead>
                                                <tr style="background-color: #3366cc; color: white; text-align: center;">
                                                    <th>Acción</th>
                                                    <th style="width: 300px;">Artículo</th>
                                                    <th>Stock</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Dcto</th>
                                                    <th>PU. Dcto.</th>
                                                    <th>PU. Com.</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="addmore btn btn-success">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                            <select id="Nombre" name="Nombre" class="form-control" autocomplete="off"  style="margin-top: 5px;">
                                                                <option>Seleccione Articulo</option>
                                                                <option value="">443 | EP-000292 | 2192584 | WIRELESS LAN USB MODULE EPSON</option>
                                                                <option value="">19 | SERV-00000019 | SERV-00000019 | 729790 WIRE  22-Aug-24 LP005947</option>
                                                                <option value="">18 | SERV-00000018 | SERV-00000018 | 729790 WIRE  22-Aug-24 LP005979</option>
                                                                <option value="">20 | SERV-00000020 | SERV-00000020 | 729790 WIRE  24-Jun-24 LP005704</option>
                                                                <option value="">22 | SERV-00000022 | SERV-00000022 | 729790 WIRE 23 - Oct - 2023 LP004720</option>
                                                                <option value="">21 | SERV-00000021 | SERV-00000021 | 729790 WIRE 25- Sep -2023 LP004623</option>
                                                            </select>
                                                        <textarea id="Descripcion" name="Descripcion" class="form-control" autocomplete="off" placeholder="Descripción de Item" style="margin-top: 5px;"></textarea>
                                                        <textarea id="Serie" name="Serie" class="form-control" autocomplete="off" placeholder="Número de Serie" style="margin-top: 5px;"></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="stock0" disabled name="stock[]" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="number" id="cantidad0" name="cantidad[]" min="1" class="monto0 form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio0" name="precio[]" disabled class="monto0 form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="descuento" name="descuento" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio_unitario_descuento0" name="precio_unitario_descuento[]" disabled class="precio_unitario_descuento0 form-control" required autocomplete="off" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio_unitario_comision0" disabled class="form-control" required autocomplete="off" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="total0" name="total" disabled class="total form-control" required autocomplete="off" />
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!--TABLA DE ELIMINAR-->
                                    <div class="table-responsive">
                                        <table cellspacing="0" class="table tables">
                                            <thead>
                                                <tr style="background-color: #3366cc; color: white; text-align: center;">
                                                    <th>Acción</th>
                                                    <th style="width: 300px;">Artículo</th>
                                                    <th>Stock</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Dcto</th>
                                                    <th>PU. Dcto.</th>
                                                    <th>PU. Com.</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-danger">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <select id="Nombre" name="Nombre" class="form-control" autocomplete="off"  style="margin-top: 5px;">
                                                            <option>Seleccione Articulo</option>
                                                            <option value="">443 | EP-000292 | 2192584 | WIRELESS LAN USB MODULE EPSON</option>
                                                            <option value="">19 | SERV-00000019 | SERV-00000019 | 729790 WIRE  22-Aug-24 LP005947</option>
                                                            <option value="">18 | SERV-00000018 | SERV-00000018 | 729790 WIRE  22-Aug-24 LP005979</option>
                                                            <option value="">20 | SERV-00000020 | SERV-00000020 | 729790 WIRE  24-Jun-24 LP005704</option>
                                                            <option value="">22 | SERV-00000022 | SERV-00000022 | 729790 WIRE 23 - Oct - 2023 LP004720</option>
                                                            <option value="">21 | SERV-00000021 | SERV-00000021 | 729790 WIRE 25- Sep -2023 LP004623</option>
                                                        </select>
                                                        <textarea id="Descripcion" name="Descripcion" class="form-control" autocomplete="off" placeholder="Descripción de Item" style="margin-top: 5px;"></textarea>
                                                        <textarea id="Serie" name="Serie" class="form-control" autocomplete="off" placeholder="Número de Serie" style="margin-top: 5px;"></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="stock0" disabled name="stock[]" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="number" id="cantidad0" name="cantidad[]" min="1" class="monto0 form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio0" name="precio[]" disabled class="monto0 form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="descuento" name="descuento" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio_unitario_descuento0" name="precio_unitario_descuento[]" disabled class="precio_unitario_descuento0 form-control" required autocomplete="off" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio_unitario_comision0" disabled class="form-control" required autocomplete="off" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="total0" name="total" disabled class="total form-control" required autocomplete="off" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr >
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><strong>Subtotal:</strong></td>
                                                    <td colspan="2">
                                                    <input  id="subtotal"  type="text" disabled class="form-control" required="">
                                                    </td>
                                                </tr>
                                                <tr >
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><strong>IGV:</strong></td>
                                                    <td colspan="2">
                                                        <input  id="igv"  type="text" disabled class="form-control" required=""></td>
                                                </tr>
                                                <tr >
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><strong>Total:</strong></td>
                                                    <td colspan="2">
                                                    <input  id="total_final"  type="text" disabled class="form-control" required=""></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <button class="btn btn-success" type="submit">
                                                <i class="fa fa-cloud-upload" aria-hidden="true"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






    <!-- INICIO DE BOLETA MANUAL -->
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-success">
                        <div class="panel-heading text-center">
                            <h3><strong> Datos del cliente</strong></h3>
                        </div>
                        <div class="panel-body">
                            <div class="row ">
                                <div class="col-sm-12">
                                        <div style="margin: auto 50px">
                                            <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><strong>Cliente:</strong></label>
                                            <div class="col-sm-8">
                                                <select class="form-control">
                                                    <option value="">Seleccione un cliente</option>
                                                    <option value="">ARTHRO MEDS SPORT S.A.C | 20603185197</option>
                                                    <option value="">BOX PARTS SOCIEDAD ANONIMA CERRADA | 20605675523</option>
                                                    <option value="">CELESTE DEL CARMEN UGARTE HUACCHILLO | 72875303</option>
                                                    <option value="">RAUL EDUARDO RODRIGUEZ SALAZAR | 09892148</option>
                                                    <option value="">ABRAHAN JOSUE GONZALES FERNANDEZ | 76652408</option>
                                                    <!-- Agrega más opciones según sea necesario -->
                                                </select>
                                            </div>
                                        </div>
                                            <div class="form-group row">
                                                <label
                                                    class="col-sm-4 col-form-label"><strong>RUC o DNI:</strong></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" placeholder="Ingrese el RUC o DNI">
                                                    </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-success">
                        <div class="panel-heading text-center">
                            <h3><strong> Datos del Vendedor</strong></h3>
                        </div>
                        <div class="panel-body">
                            <div class="row ">
                                <div class="col-sm-12">
                                        <div style="margin: auto 50px">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label"><strong>Vendedor:</strong></label>
                                                <div class="col-sm-8">
                                                    <p class="form-control">Administrador</p>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label
                                                    class="col-sm-4 col-form-label"><strong>Contacto:</strong></label>
                                                <div class="col-sm-8">
                                                    <p class="form-control">000000000</p>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading text-center">
                            <h3><strong>Datos de la Venta</strong></h3>
                        </div>
                        <div class="panel-body">
                            <div class="row col-lg-12">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Orden de Compra:</strong></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Guía de Remisión:</strong></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Comisionista:</strong></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control"placeholder="Ingrese la comision">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Forma de pago:</strong></label>
                                        <div class="col-sm-7">
                                            <select class="form-control">
                                                <option>Seleccione</option>
                                                <option>Contado</option>
                                                <option>Crédito</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Observación:</strong></label>
                                        <div class="col-sm-7">
                                            <textarea id="Observación" name="Observación" class="form-control" autocomplete="off" placeholder="Observación" style="margin-top: 5px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Fecha de Inicio:</strong></label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control" value="2024-11-06" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Fecha de Vencimiento:</strong></label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control" value="2024-11-06" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Moneda:</strong></label>
                                        <div class="col-sm-7">
                                            <select class="form-control">
                                                <option>Seleccione</option>
                                                <option>Soles</option>
                                                <option>Dolares</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label"><strong>Tipo de Operación:</strong></label>
                                        <div class="col-sm-7">
                                                <select class="form-control" name="tipo_operacion">
                                                    <option id="1">0101 - Venta Interna</option>
                                                    <option id="2">0200 - Exportación</option>
                                                    <option id="3">0103 - No Domiciliados</option>
                                                    <option id="4">0104 - Venta Interna - Anticipos</option>
                                                    <option id="5">0105 - Venta Itinerante</option>
                                                    <option id="6">0106 - Factura Guía</option>
                                                    <option id="7">0107 - Venta Arroz Pilado</option>
                                                    <option id="8">0108 - Factura - Comprobante de Percepción</option>
                                                    <option id="9">0110 - Factura - Guía Remitente</option>
                                                    <option id="10">0111 - Factura - Guía de Transportista</option>
                                                    <option id="11">0201 - Exportación de Servicios - Prestación servicios realizados</option>
                                                    <option id="12">1001 - Operacion Sujeta a Detracción</option>
                                                    <option id="13">1002 - Operacion sujeta a detracción - Recursos Hidrobiológicos</option>
                                                    <option id="14">1003 - Operacion sujeta a detracción - Servicios de transporte pasajeros</option>
                                                    <option id="15">1004 - Operacion sujeta a detracción - Servicios de transporte de carga</option>
                                                    <option id="16">2001 - Operación Sujeta a Percepción</option>
                                                    <option id="17">2002 - Operación Sujeta a Retención de Renta de segunda categoría</option>
                                                    <option id="18">2100 - Créditos a empresas</option>
                                                </select>
        
                                        </div>
                                    </div>
                                </div>
                                <!--TABLA DE AGREGAR-->
                                <div class="table-responsive">
                                    <table cellspacing="0" class="table tables">
                                        <thead>
                                            <tr style="background-color: #3366cc; color: white; text-align: center;">
                                                <th>Acción</th>
                                                <th style="width: 300px;">Artículo</th>
                                                <th>Cantidad</th>
                                                <th>P.Sugerido</th>
                                                <th>Precio s/ Igv</th>
                                                <th>Precio c/ Igv</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <button type="button" class="addmore btn btn-success">
                                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                        <select id="Nombre" name="Nombre" class="form-control" autocomplete="off"  style="margin-top: 5px;">
                                                            <option>Seleccione Articulo</option>
                                                            <option value="">443 | EP-000292 | 2192584 | WIRELESS LAN USB MODULE EPSON</option>
                                                            <option value="">19 | SERV-00000019 | SERV-00000019 | 729790 WIRE  22-Aug-24 LP005947</option>
                                                            <option value="">18 | SERV-00000018 | SERV-00000018 | 729790 WIRE  22-Aug-24 LP005979</option>
                                                            <option value="">20 | SERV-00000020 | SERV-00000020 | 729790 WIRE  24-Jun-24 LP005704</option>
                                                            <option value="">22 | SERV-00000022 | SERV-00000022 | 729790 WIRE 23 - Oct - 2023 LP004720</option>
                                                            <option value="">21 | SERV-00000021 | SERV-00000021 | 729790 WIRE 25- Sep -2023 LP004623</option>
                                                        </select>
                                                    <textarea id="Descripcion" name="Descripcion" class="form-control" autocomplete="off" placeholder="Descripción de Item" style="margin-top: 5px;"></textarea>
                                                    <textarea id="Serie" name="Serie" class="form-control" autocomplete="off" placeholder="Número de Serie" style="margin-top: 5px;"></textarea>
                                                </td>
                                                <td>
                                                    <input type="number" id="cantidad0" name="cantidad[]" min="1" class="monto0 form-control" />
                                                </td>
                                                <td>
                                                    <input type="text" id="P.suge" name="precio[]" disabled class="monto0 form-control" />
                                                </td>
                                                <td>
                                                    <input type="text" id="precio_s_igv" name="precio_unitario_descuento[]" disabled class="precio_unitario_descuento0 form-control" required autocomplete="off" />
                                                </td>
                                                <td>
                                                    <input type="text" id="precio_c_igv" disabled class="form-control" required autocomplete="off" />
                                                </td>
                                                <td>
                                                    <input type="text" id="total0" name="total" disabled class="total form-control" required autocomplete="off" />
                                                </td>
                                            </tr>
        
                                        </tbody>
                                    </table>
                                </div>
                                <!--TABLA DE ELIMINAR-->
                                <div class="table-responsive">
                                    <table cellspacing="0" class="table tables">
                                        <thead>
                                            <tr style="background-color: #3366cc; color: white; text-align: center;">
                                                <th>Acción</th>
                                                <th style="width: 300px;">Artículo</th>
                                                <th>Cantidad</th>
                                                <th>P.Sugerido</th>
                                                <th>Precio s/ Igv</th>
                                                <th>Precio c/ Igv</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-danger">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <select id="Nombre" name="Nombre" class="form-control" autocomplete="off"  style="margin-top: 5px;">
                                                        <option>Seleccione Articulo</option>
                                                        <option value="">443 | EP-000292 | 2192584 | WIRELESS LAN USB MODULE EPSON</option>
                                                        <option value="">19 | SERV-00000019 | SERV-00000019 | 729790 WIRE  22-Aug-24 LP005947</option>
                                                        <option value="">18 | SERV-00000018 | SERV-00000018 | 729790 WIRE  22-Aug-24 LP005979</option>
                                                        <option value="">20 | SERV-00000020 | SERV-00000020 | 729790 WIRE  24-Jun-24 LP005704</option>
                                                        <option value="">22 | SERV-00000022 | SERV-00000022 | 729790 WIRE 23 - Oct - 2023 LP004720</option>
                                                        <option value="">21 | SERV-00000021 | SERV-00000021 | 729790 WIRE 25- Sep -2023 LP004623</option>
                                                    </select>
                                                    <textarea id="Descripcion" name="Descripcion" class="form-control" autocomplete="off" placeholder="Descripción de Item" style="margin-top: 5px;"></textarea>
                                                    <textarea id="Serie" name="Serie" class="form-control" autocomplete="off" placeholder="Número de Serie" style="margin-top: 5px;"></textarea>
                                                </td>
                                                <td>
                                                    <input type="number" id="cantidad0" name="cantidad[]" min="1" class="monto0 form-control" />
                                                </td>
                                                <td>
                                                    <input type="text" id="P.suge" name="precio[]" disabled class="monto0 form-control" />
                                                </td>
                                                <td>
                                                    <input type="text" id="precio_s_igv" name="precio_unitario_descuento[]" disabled class="precio_unitario_descuento0 form-control" required autocomplete="off" />
                                                </td>
                                                <td>
                                                    <input type="text" id="precio_c_igv" disabled class="form-control" required autocomplete="off" />
                                                </td>
                                                <td>
                                                    <input type="text" id="total0" name="total" disabled class="total form-control" required autocomplete="off" />
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr >
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong>Subtotal:</strong></td>
                                                <td colspan="2">
                                                <input  id="subtotal"  type="text" disabled class="form-control" required="">
                                                </td>
                                            </tr>
                                            <tr >
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong>IGV:</strong></td>
                                                <td colspan="2">
                                                    <input  id="igv"  type="text" disabled class="form-control" required=""></td>
                                            </tr>
                                            <tr >
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong>Total:</strong></td>
                                                <td colspan="2">
                                                <input  id="total_final"  type="text" disabled class="form-control" required=""></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
        
                                <div class="d-flex justify-content-between mt-3">
                                    <div>
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa fa-cloud-upload" aria-hidden="true"></i> Guardar
                                        </button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <!-- FIN DE BOLETA MANUAL -->



    <!-- Mainly scripts -->
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

    <!-- Switchery -->
    <link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
    <script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>
    @endsection
