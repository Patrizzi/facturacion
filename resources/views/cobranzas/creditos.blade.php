@extends('layout')

@section('title', 'Créditos')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <!-- Contenedor de pestañas -->
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <!-- Pestaña 1: Pagados -->
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1G">
                                    Pagados
                                </a>
                            </li>
                            <!-- Pestaña 2: Sin Pagar -->
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-2G">
                                    Sin Pagar
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- Contenido de la pestaña Pagados -->
                            <div role="tabpanel" id="tab-1G" class="tab-pane active show">
                            <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox">
                                                <div class="ibox-title" style="border: 2px solid #ddd; padding: 10px; background-color: #f8f9fa; border-radius: 5px 5px 0 0;">
                                                    <h4>Resumen de agos de Septiembre 2024</h4>
                                                </div>
                                                <div class="ibox-content" style="border: 2px solid #ddd; border-radius: 0 0 5px 5px;">
                                                    <div class="row" style="display: flex; justify-content: space-between;">
                                                        <!-- Primer Círculo -->
                                                        <div class="col-md-2">
                                                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                                <div style="border: 3px solid green; border-radius: 50%; width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                                                    <span style="color: green; font-size: 25px;"><i class="fa fa-file-text"></i></span>
                                                                </div>
                                                                <h4 style="font-weight: bold; margin-top: 10px;">Boleta</h4>
                                                                <p style="margin: 0;">Monto Pagado</p>
                                                                <p style="color: green; font-weight: bold;">S/. ***.**</p>
                                                            </div>
                                                        </div>
                                                        <!-- Segundo Círculo -->
                                                        <div class="col-md-2">
                                                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                                <div style="border: 3px solid orange; border-radius: 50%; width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                                                    <span style="color: orange; font-size: 25px;"><i class="fa fa-file-text-o"></i></span>
                                                                </div>
                                                                <h4 style="font-weight: bold; margin-top: 10px;">Boleta Manual</h4>
                                                                <p style="margin: 0;">Monto Pagado</p>
                                                                <p style="color: orange; font-weight: bold;">S/. ***.**</p>
                                                            </div>
                                                        </div>
                                                        <!-- Tercer Círculo -->
                                                        <div class="col-md-2">
                                                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                                <div style="border: 3px solid red; border-radius: 50%; width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                                                    <span style="color: red; font-size: 25px;"><i class="fa fa-file"></i></span>
                                                                </div>
                                                                <h4 style="font-weight: bold; margin-top: 10px;">Factura</h4>
                                                                <p style="margin: 0;">Monto Pagado</p>
                                                                <p style="color: red; font-weight: bold;">S/. ***.**</p>
                                                            </div>
                                                        </div>
                                                        <!-- Cuarto Círculo -->
                                                        <div class="col-md-2">
                                                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                                <div style="border: 3px solid blue; border-radius: 50%; width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                                                    <span style="color: blue; font-size: 25px;"><i class="fa fa-file-o"></i></span>
                                                                </div>
                                                                <h4 style="font-weight: bold; margin-top: 10px;">Factura Manual</h4>
                                                                <p style="margin: 0;">Monto Pagado</p>
                                                                <p style="color: blue; font-weight: bold;">S/. ***.**</p>
                                                            </div>
                                                        </div>
                                                        <!-- Quinto Círculo -->
                                                        <div class="col-md-2">
                                                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                                <div style="border: 3px solid purple; border-radius: 50%; width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                                                    <span style="color: purple; font-size: 25px;"><i class="fa fa-file-text"></i></span>
                                                                </div>
                                                                <h4 style="font-weight: bold; margin-top: 10px;">Nota de Venta</h4>
                                                                <p style="margin: 0;">Monto Pagado</p>
                                                                <p style="color: purple; font-weight: bold;">S/. ***.**</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            
                                        <!-- Filtros de búsqueda -->
                                        <div class="col-lg-12">
                                            <form>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="dateRange">Fecha:</label>
                                                        <input type="text" class="form-control" id="dateRange" placeholder="07/07/2024 - 07/08/2024">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="clientSelect">Cliente:</label>
                                                        <select class="form-control" id="clientSelect">
                                                            <option value="">Seleccionar cliente</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="paymentOption">Pago:</label>
                                                        <select class="form-control" id="paymentOption">
                                                            <option value="">Seleccionar opción</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Buscar</button>
                                            </form>
                                        </div>

                                        <!-- Tabla de ventas -->
                                        <div class="col-lg-12">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Código</th>
                                                        <th>Cliente</th>
                                                        <th>Fecha</th>
                                                        <th>Forma</th>
                                                        <th>Importe Total</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>B001-00000004</td>
                                                        <td>HIDROMAX S.A.C.</td>
                                                        <td>27-08-2022</td>
                                                        <td>Contado</td>
                                                        <td>S/ 85.00</td>
                                                        <td>
                                                            <button class="btn btn-success"><i class="fa fa-check"></i></button>
                                                            <button class="btn btn-info"><i class="fa fa-eye"></i></button>
                                                        </td>
                                                    </tr>
                                                    <!-- Repite para más filas -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenido de Sin Pagar -->
                            <div role="tabpanel" id="tab-2G" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox">
                                                <div class="ibox-title" style="border: 2px solid #ddd; padding: 10px; background-color: #f8f9fa; border-radius: 5px 5px 0 0;">
                                                    <h4>Resumen de pagos de Septiembre 2024</h4>
                                                </div>
                                                <div class="ibox-content" style="border: 2px solid #ddd; border-radius: 0 0 5px 5px;">
                                                    <div class="row" style="display: flex; justify-content: space-between;">
                                                        <!-- Primer Círculo -->
                                                        <div class="col-md-2">
                                                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                                <div style="border: 3px solid green; border-radius: 50%; width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                                                    <span style="color: green; font-size: 25px;"><i class="fa fa-file-text"></i></span>
                                                                </div>
                                                                <h4 style="font-weight: bold; margin-top: 10px;">Boleta</h4>
                                                                <p style="margin: 0;">Monto Sin Pagar</p>
                                                                <p style="color: green; font-weight: bold;">S/. ***.**</p>
                                                            </div>
                                                        </div>
                                                        <!-- Segundo Círculo -->
                                                        <div class="col-md-2">
                                                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                                <div style="border: 3px solid orange; border-radius: 50%; width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                                                    <span style="color: orange; font-size: 25px;"><i class="fa fa-file-text-o"></i></span>
                                                                </div>
                                                                <h4 style="font-weight: bold; margin-top: 10px;">Boleta Manual</h4>
                                                                <p style="margin: 0;">Monto Sin Pagar</p>
                                                                <p style="color: orange; font-weight: bold;">S/. ***.**</p>
                                                            </div>
                                                        </div>
                                                        <!-- Tercer Círculo -->
                                                        <div class="col-md-2">
                                                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                                <div style="border: 3px solid red; border-radius: 50%; width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                                                    <span style="color: red; font-size: 25px;"><i class="fa fa-file"></i></span>
                                                                </div>
                                                                <h4 style="font-weight: bold; margin-top: 10px;">Factura</h4>
                                                                <p style="margin: 0;">Monto Sin Pagar</p>
                                                                <p style="color: red; font-weight: bold;">S/. ***.**</p>
                                                            </div>
                                                        </div>
                                                        <!-- Cuarto Círculo -->
                                                        <div class="col-md-2">
                                                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                                <div style="border: 3px solid blue; border-radius: 50%; width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                                                    <span style="color: blue; font-size: 25px;"><i class="fa fa-file-o"></i></span>
                                                                </div>
                                                                <h4 style="font-weight: bold; margin-top: 10px;">Factura Manual</h4>
                                                                <p style="margin: 0;">Monto Sin Pagar</p>
                                                                <p style="color: blue; font-weight: bold;">S/. ***.**</p>
                                                            </div>
                                                        </div>
                                                        <!-- Quinto Círculo -->
                                                        <div class="col-md-2">
                                                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                                                <div style="border: 3px solid purple; border-radius: 50%; width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                                                    <span style="color: purple; font-size: 25px;"><i class="fa fa-file-text"></i></span>
                                                                </div>
                                                                <h4 style="font-weight: bold; margin-top: 10px;">Nota de Venta</h4>
                                                                <p style="margin: 0;">Monto Sin Pagar</p>
                                                                <p style="color: purple; font-weight: bold;">S/. ***.**</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox">
                                                <div class="ibox-content">
                                                    <div class="tabs-container">
                                                        <!-- Pestañas (Nav Tabs) -->
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active show" data-toggle="tab" href="#tab-1-Sin">
                                                                    <span class="badge badge-success" style="background-color: green;">4</span> Boleta 
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-toggle="tab" href="#tab-2-Sin">
                                                                    <span class="badge badge-success" style="background-color: orange;">4</span> Boleta Manual
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-toggle="tab" href="#tab-3-Sin">
                                                                    <span class="badge badge-success" style="background-color: red;">3</span> Factura
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-toggle="tab" href="#tab-4-Sin">
                                                                    <span class="badge badge-success" style="background-color: blue;">3</span> Factura Manual
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-toggle="tab" href="#tab-5-Sin">
                                                                    <span class="badge badge-success" style="background-color: purple;">5</span> Nota de Venta
                                                                </a>
                                                            </li>
                                                        </ul>
                        <div class="tab-content">
                         <!-- COTIZACION-->   
                            <div role="tabpanel" id="tab-1-Sin" class="tab-pane active show">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="daterange"
                                                    value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                                        <i class="fa fa-history"></i>
                                                    </button>
                                                </span>
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary" onclick="limpiar_select()">
                                                        <i class="fa fa-eraser"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label"><strong>Cliente:</strong></label>
                                                <select class="form-control col-lg-6" id="select_tipo_coti">
                                                    <option value="">Seleccionar</option>
                                                    <option value="factura">Factura</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label"><strong>Pagar por Lote:</strong></label>
                                                <button type="submit" class="form-control col-lg-6 btn btn-primary">Pagar todo</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label"><strong>Pago:</strong></label>
                                                <select class="form-control col-lg-6" id="select_tipo_coti">
                                                    <option value="">Seleccionar</option>
                                                    <option value="factura">Contado</option>
                                                    <option value="factura">Credito</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label"><strong>Estado:</strong></label>
                                                <select class="form-control col-lg-6" id="select_tipo_coti">
                                                    <option value="">Seleccionar</option>
                                                    <option value="factura">Pagado</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label"><strong>Buscar:</strong></label>
                                                <input type="search" class="form-control col-lg-6">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr><th></th>
                                                    <th>ID</th>
                                                    <th>Código</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha</th>
                                                    <th>Forma</th>
                                                    <th>Monto y Cuotas</th>
                                                    <th>Pago o Adelantado</th>
                                                    <th>Ultima Fecha</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                    <div class="icheckbox_square-green checked" style="position: relative;">
                                                        <input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;">
                                                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    </td>
                                                    <td>1</td>
                                                    <td>B001-00000001</td>
                                                    <td>Marco Estrada</td>
                                                    <td>07-10-2024</td>
                                                    <td>Contado</td>
                                                    <td>S/. 74.34 | 1</td>
                                                    <td>S/. 10.00</td>
                                                    <td>07-10-2024</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                                        <button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>  
                                                       <!--<button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>--> 
                                                       <div class="btn-group">
                                                            <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Pago</button>
                                                            <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" class="btn btn-primary" >Pagar</a></li>
                                                            <li><a class="dropdown-item" class="btn btn-primary" >Adelantar</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>         
                                            </tbody>          
                                        </table>
                                    </div>
                                </div>
                            </div>
                                 <!-- COTIZACION MANUAL--> 
                                <div role="tabpanel" id="tab-2-Sin" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary" onclick="limpiar_select()">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <select class="form-control col-lg-12" id="select_tipo_coti">
                                                        <option value="">Todos los Comprobantes</option>
                                                        <option value="factura">Factura</option>
                                                        <option value="boleta">Boleta</option>
                                                        <option value="nota_venta">Nota de Venta</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"><strong>Buscar:</strong></label>
                                                    <input type="search" class="form-control col-lg-8">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                            <thead>
                                                    <tr><th></th>
                                                        <th>ID</th>
                                                        <th>N° Cotizacion</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Cliente</th>
                                                        <th>Fecha Emision</th>
                                                        <th>Forma</th>
                                                        <th>Importe T.</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                              
                                                    <tr>
                                                        <td>
                                                            <div class="icheckbox_square-green checked" style="position:relative;">
                                                                <input type="checkbox" checked class="i-checks" name="input[]" style="position:absolute; opacity:0;">
                                                                <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                            </div>
                                                        </td>
                                                        <td>1</td>
                                                        <td>******</td>
                                                        <td>70871200</td>
                                                        <td>Daniel Roman</td>
                                                        <td>07-10-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 200.00</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>

                                                            <button type="button" class="btn btn-warning"><i
                                                                    class="fa fa-clock-o"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="6" class="text-right">Total General</th>
                                                        <th colspan="6">S/. ****</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                 <!-- NOTA DE VENTA--> 
                                <div role="tabpanel" id="tab-3-Sin" class="tab-pane">
                                    <div class="panel-body">
                                    <div class="row">
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary"
                                                            onclick="revert_select()">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="limpiar_select()">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label"
                                                        for=""><strong>Buscar:</strong></label>
                                                    <input type="search" class="form-control col-lg-6">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr><th></th>
                                                        <th>ID</th>
                                                        <th>N° Nota de Venta</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Cliente</th>
                                                        <th>Fecha Emision</th>
                                                        <th>Forma</th>
                                                        <th>Importe T.</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td>
                                                            <div class="icheckbox_square-green checked" style="position:relative;">
                                                                <input type="checkbox" checked class="i-checks" name="input[]" style="position:absolute; opacity:0;">
                                                                <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                            </div>
                                                        </td>
                                                        <td>1</td>
                                                        <td>****</td>
                                                        <td>08123245</td>
                                                        <td>Julio Flores</td>
                                                        <td>02-01-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 200.00</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>

                                                            <button type="button" class="btn btn-danger"><i
                                                                    class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                 <!-- CLIENTES--> 
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                    <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"
                                                        for=""><strong>Buscar:</strong></label>
                                                    <input type="search" class="form-control col-lg-6">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Codigo</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Cliente</th>
                                                        <th>Correo</th>
                                                        <th>Celular</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>*******</td>
                                                        <td>72531212</td>
                                                        <td>Marlo Samaniego Calderon</td>
                                                        <td>sincorreo@gmail.com</td>
                                                        <td>920123456</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>
                                                            <button type="button" class="btn btn-info"><i
                                                                    class="fa fa-check-circle"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>*******</td>
                                                        <td>77893000</td>
                                                        <td>Carlos Antoñez Gomez</td>
                                                        <td>sincorreo@gmail.com</td>
                                                        <td>970841600</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>
                                                            <button type="button" class="btn btn-info"><i
                                                                    class="fa fa-check-circle"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
<style>
        .dropdown-menu {
            left: 70px;
            padding: 20px 0;
        }

        #DataTables_Table_0_wrapper {
            padding-right: 0px;
        }

        .table {
            width: 100% !important;
        }

        .ibox-content>.row {
            margin: auto;
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
 @endsection
