@extends('layout')

@section('title', 'Cotización')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h4>Resumen de Febrero 2024</h4>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <!-- Primer Círculo -->
                        <div class="col-md-3">
                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                <div style="border: 2px solid green; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                    <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
                                </div>
                                <h4 style="font-weight: bold; margin-top: 15px;">Cotización</h4>
                                <p style="margin: 5px 0;">4 Documentos</p>
                                <p style="color: green; font-weight: bold;">S/. 771.55</p>
                            </div>
                        </div>
                        <!-- Segundo Círculo -->
                        <div class="col-md-3">
                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                <div style="border: 2px solid orange; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                    <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
                                </div>
                                <h4 style="font-weight: bold; margin-top: 15px;">Cotización Manual</h4>
                                <p style="margin: 5px 0;">4 Documentos</p>
                                <p style="color: orange; font-weight: bold;">S/. 658.00</p>
                            </div>
                        </div>
                        <!-- Tercer Círculo -->
                        <div class="col-md-3">
                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                <div style="border: 2px solid red; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                    <i class="fa fa-file-o" style="font-size: 50px; color: black;"></i>
                                </div>
                                <h4 style="font-weight: bold; margin-top: 15px;">Nota de Venta</h4>
                                <p style="margin: 5px 0;">3 Documentos</p>
                                <p style="color: red; font-weight: bold;">S/. 320.00</p>
                            </div>
                        </div>
                        <!-- Cuarto Círculo -->
                        <div class="col-md-3">
                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                <div style="border: 2px solid blue; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                    <i class="fa fa-user-o" style="font-size: 50px; color: black;"></i>
                                </div>
                                <h4 style="font-weight: bold; margin-top: 15px;">Clientes</h4>
                                <p style="margin: 5px 0;">5 Clientes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                <li class="nav-item">
                                    <a class="nav-link active show" data-toggle="tab" href="#tab-1">
                                        <span class="badge badge-success" style="background-color :green;">4</span> Cotización 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-2">
                                        <span class="badge badge-success" style="background-color: orange;">4</span> Cotización Manual
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-3">
                                        <span class="badge badge-success" style="background-color: red;">3</span> Nota de Venta
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-4">
                                        <span class="badge badge-success" style="background-color: blue;">5</span> Clientes
                                    </a>
                                </li>
                                <div class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <div class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-plus"></i> 
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#" id="oficina-arequipa">Oficina Arequipa</a></li>
                                            <li><a class="dropdown-item" href="#" id="galeria-centro-lima">Galería Centro Lima</a></li>
                                        </ul>
                                    </div>
                                    <button class="btn btn-success" type="button">
                                        <i class="fa fa-upload"></i> 
                                    </button>
                                </div>
                            </ul>
                        <div class="tab-content">
                         <!-- COTIZACION-->   
                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
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
                                            <!----><div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"><strong>Buscar:</strong></label>
                                                    <input type="search" class="form-control col-lg-8">
                                                </div>
                                            </div> 
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr><th>
                                                    <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Código</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Forma</th>
                                                    <th>Importe T.</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                    <input type="checkbox" class="i-checks" name="input[]">
                                                    </td>
                                                    <td>1</td>
                                                    <td>COTV 001-00000003</td>
                                                    <td>031465121</td>
                                                    <td>Marco Estrada</td>
                                                    <td>07-10-2024</td>
                                                    <td>Contado</td>
                                                    <td>S/. 200.00</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                                        <button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    <input type="checkbox" class="i-checks" name="input[]"></td>
                                                    <td>2</td>
                                                    <td>COTV 001-00000002</td>
                                                    <td>031492021</td>
                                                    <td>Marlo Calderon</td>
                                                    <td>08-02-2024</td>
                                                    <td>Contado</td>
                                                    <td>S/. 320.00</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                                        <button type="button" class="btn btn-warning"><i class="fa fa-clock-o"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    <input type="checkbox" class="i-checks" name="input[]">
                                                    </td>
                                                    <td>3</td>
                                                    <td>COTV 001-00000001</td>
                                                    <td>14865121</td>
                                                    <td>Fabricio Yupanqui</td>
                                                    <td>03-08-2024</td>
                                                    <td>Contado</td>
                                                    <td>S/. 190.00</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                                        <button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    <input type="checkbox" class="i-checks" name="input[]"></td>
                                                    <td>4</td>
                                                    <td>COTV 001-00000004</td>
                                                    <td>12982021</td>
                                                    <td>EM PLAST PERU E.I.R.L</td>
                                                    <td>12-09-2024</td>
                                                    <td>Contado</td>
                                                    <td>S/. 480.55</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                                        <button type="button" class="btn btn-warning"><i class="fa fa-clock-o"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                        <td>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                        </td>
                                                        <td>5</td>
                                                        <td>COTPF 001-00000001</td>
                                                        <td>20101088881</td>
                                                        <td>DROGUERIA REYES S.A.C.</td>
                                                        <td>18-06-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 179.00</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>

                                                            <button type="button" class="btn btn-info">
                                                                <i class="fa fa-check-circle"></i></button>
                                                        </td>
                                                </tr>
                                                    <tr>
                                                        <td>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                        </td>
                                                        <td>6</td>
                                                        <td>COTB 001-00000006</td>
                                                        <td>20474595081</td>
                                                        <td> CORADIC S.A.C.	</td>
                                                        <td>08-05-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 319.00</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>

                                                            <button type="button" class="btn btn-info">
                                                                <i class="fa fa-check-circle"></i></button>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="7" class="text-right">Total General</th>
                                                    <th colspan="7">S/. ****</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
    
                                 <!-- COTIZACION MANUAL--> 
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        {{-- CONTENIDO DENTRO DEL TAB  2 --}}
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
                                        <div class="table-responsive" id="tab-2">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                    <tr><th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                        <th>ID</th>
                                                        <th>Código</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Cliente</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>Forma</th>
                                                        <th>Importe T.</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                              
                                                    <tr>
                                                        <td>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                        </td>
                                                        <td>1</td>
                                                        <td>CMF 001-00000001</td>
                                                        <td>70871200</td>
                                                        <td>Daniel Roman Castillo</td>
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
                                                    <tr>
                                                        <td>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                        </td>
                                                        <td>2</td>
                                                        <td>CMF 001-00000002</td>
                                                        <td>20612050300</td>
                                                        <td>COBRANZA INTELIGENTE S.A.C.</td>
                                                        <td>17-09-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 195.01</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>

                                                            <button type="button" class="btn btn-warning"><i
                                                                    class="fa fa-clock-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                        </td>
                                                        <td>3</td>
                                                        <td>CMF 001-00000003</td>
                                                        <td>20604690685</td>
                                                        <td>LUOXO S.A.C.</td>
                                                        <td>02-04-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 305.11</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>

                                                            <button type="button" class="btn btn-info">
                                                                <i class="fa fa-check-circle"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                        </td>
                                                        <td>4</td>
                                                        <td>CMF 001-00000004</td>
                                                        <td>20550971861</td>
                                                        <td>DYM SOLUCIONES E.I.R.L.</td>
                                                        <td>03-04-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 155.00</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>

                                                            <button type="button" class="btn btn-info">
                                                                <i class="fa fa-check-circle"></i></button>
                                                        </td>     
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                        </td>
                                                        <td>5</td>
                                                        <td>CMF 001-00000005</td>
                                                        <td>20550977861</td>
                                                        <td>TEXTILES TBM S.A.C.</td>
                                                        <td>03-04-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 285.00</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>

                                                            <button type="button" class="btn btn-info">
                                                                <i class="fa fa-check-circle"></i></button>
                                                        </td>     
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="7" class="text-right">Total General</th>
                                                        <th colspan="7">S/. ****</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                 <!-- NOTA DE VENTA--> 
                                <div role="tabpanel" id="tab-3" class="tab-pane">
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
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr><th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                        <th>ID</th>
                                                        <th>Código</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Cliente</th>
                                                        <th>Fecha Emisión</th>
                                                        <th>Forma</th>
                                                        <th>Importe T.</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                        </td>
                                                        <td>1</td>
                                                        <td>NV001-00000291</td>
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
                                                    <tr><td>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                        </td>
                                                        <td>2</td>
                                                        <td>NV001-00000292</td>
                                                        <td>76652408</td>
                                                        <td>Raul Pancorbo Salazar</td>
                                                        <td>12-02-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 240.00</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>

                                                            <button type="button" class="btn btn-danger"><i
                                                                    class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr><td>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                        </td>
                                                        <td>3</td>
                                                        <td>NV001-00000293</td>
                                                        <td>79841402</td>
                                                        <td>Cindy Rosa Rosales Torres</td>
                                                        <td>11-03-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 180.00</td>
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
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Código</th>
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
                                                    <tr>
                                                        <td>3</td>
                                                        <td>*******</td>
                                                        <td>20546717683</td>
                                                        <td>XIOS PROYECTOS & SERVICIOS E.I.R.L.</td>
                                                        <td>sincorreo@gmail.com</td>
                                                        <td>90781623</td>
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
        /* OCULTANDO LO DE ORGANIZAR*/
        /* Ver (números) */
        div.dataTables_length {
            display: none;
        }

        /* El Buscar */
        div.dataTables_filter {
            display: none;
        }

        /* CSV, Excel, PDF, Print */
        div.dt-buttons {
            display: none;
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

    <!-- Seleccionar todos los check -->
    <script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // Controlar el checkbox del thead 
        $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event){
            var table = $(this).closest('table'); // Limita el control de checkboxes a la tabla actual
            if (event.type === 'ifChecked') {
                // Selecciona 
                table.find('tbody input[type="checkbox"]').iCheck('check');
            } else {
                // Deselecciona 
                table.find('tbody input[type="checkbox"]').iCheck('uncheck');
            }
        });

        // Si todos los checkboxes de tbody de la tabla visible están seleccionados, selecciona el checkbox del thead, y si no, deselecciónalo
        $('tbody input[type="checkbox"]').on('ifChanged', function(event){
            var table = $(this).closest('table'); // Limita el control a la tabla visible
            if (table.find('tbody input[type="checkbox"]').filter(':checked').length === table.find('tbody input[type="checkbox"]').length) {
                table.find('thead input[type="checkbox"]').iCheck('check');
            } else {
                table.find('thead input[type="checkbox"]').iCheck('uncheck');
            }
        });

        // Detectar cuando se cambia de tab y restaurar el estado de los checkboxes SOLO de la tabla visible
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // Restablecer el estado de los checkboxes SOLO de la tabla activa
            var activeTab = $(e.target).attr('href'); // ID del tab activo
            $(activeTab).find('.i-checks').iCheck('update');
        });
    });
</script>


    <!--Organizar--> 
    <script>
            $(document).ready(function(){
                $('.dataTables-example').DataTable({
                    pageLength: 25,
                    responsive: true,
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [
                        {extend: 'csv'},
                        {extend: 'excel', title: 'ExampleFile'},
                        {extend: 'pdf', title: 'ExampleFile'},

                        {extend: 'print',
                        customize: function (win){
                                $(win.document.body).addClass('white-bg');
                                $(win.document.body).css('font-size', '10px');

                                $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                        }
                        }
                    ]
                });
            });

        </script>  

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            table = $('.dataTables-example-facturacion').DataTable({
                pageLength: 10,
                order: [
                    [0, "desc"]
                ],
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                footerCallback: function(tr, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(5)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total filtered rows on the selected column (code part added)
                    var sumCol4Filtered = display.map(el => data[el][5]).reduce((a, b) => intVal(a) +
                        intVal(b), 0);

                    // Update footer
                    $(api.column(5).footer()).html(
                        'S/ ' + Math.round(sumCol4Filtered * 100) / 100
                    );
                },
                buttons: []
            });

            revert_select();

            $(document).on('change', '#select_tipo_coti', function(event) {
                var nombre = $("#select_tipo_coti option:selected").val();
                // console.log(nombre);
                table.column(11).search(nombre).draw();
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
                },
                function(start, end, label) {
                    var dates = [];
                    var currentDate = new Date(start);
                    while (currentDate <= end) {
                        var day = ('0' + currentDate.getDate()).slice(-2);
                        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                        var year = currentDate.getFullYear();

                        var formattedDate = day + '-' + month + '-' + year;
                        dates.push(formattedDate);

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    var dateRangeString = dates.join('|');
                    console.log(dateRangeString);
                    table.column(4).search(dateRangeString, true, false).draw();
                }
            );
        });

        function limpiar_select() {
            table.column(4).search("").draw();
        }

        function revert_select() {
            table.column(4).search(`{{ date('m-Y') }}`).draw();
        }

    
    </script>
@endsection
