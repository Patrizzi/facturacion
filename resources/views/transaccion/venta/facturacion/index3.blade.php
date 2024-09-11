@extends('layout')

@section('title', 'Cotización')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <!-- Acá iria el titulo -->
                    <h4>Resumen de Febrero 2024</h4>
                </div>
                <div class="ibox-content">
                    <div class="row d-flex justify-content-between px-4 text-center">
                        <div class="col-auto">
                            <div class="border border-danger rounded-circle">
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                            <h4>Boleta Manual</h4>
                            <p>4 documentos</p>
                            <p class="text-danger"><b>S/***.**</b></p>
                        </div>

                        <div class="col-auto">
                            <div class="border border-warning rounded-circle">
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                            <h4>Factura Manual</h4>
                            <p>4 documentos</p>
                            <p class="text-warning"><b>S/***.**</b></p>
                        </div>

                        <div class="col-auto">
                            <div class="border border-primary rounded-circle">
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                            <h4>Nota de crédito</h4>
                            <p>4 documentos</p>
                            <p class="text-primary"><b>S/***.**</b></p>
                        </div>
                        <div class="col-auto">
                            <div class="border border-success rounded-circle">
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                            <h4>Nota de débito</h4>
                            <p>4 documentos</p>
                            <p class="text-success"><b>S/***.**</b></p>
                        </div>
                        <div class="col-auto">
                            <div class="border border-dark rounded-circle">
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                            <h4>Guía de remisión manual</h4>
                            <p>4 documentos</p>
                            <p class="text-dark"><b>S/***.**</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Base para agregar el tab para el los contenidos-->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-1">
                                    Boleta manual
                                </a>
                            </li>
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-2">
                                    Factura manual
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-3">
                                    Nota de crèdito
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-4">
                                    Nota dèdito
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-5">
                                    Guìa de remisiòn manual
                                </a>
                            </li>
                            <li class="ml-auto">
                                <button class="btn btn-primary btn-lg" type="button"><i class="fa fa-plus"></i>
                                </button>
                            </li>
                            <li>
                                <button class="btn btn-primary btn-lg mx-3" type="button"><i class="fa fa-cloud-download"></i>
                                </button>
                            </li>
                        </ul>

                        <!-- Input seleccionar fecha inicio y fin, y Botón agregar y Descargar -->
                        <div class="d-flex justify-content-md-start row mx-3 mt-4">
                            <div class="input-group col-md-4 mx-5">
                                <input class="form-control col-md-auto" type="text" name="daterange" value="01/01/2015 - 01/31/2015">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-secondary px-3"><i class="fa fa-history"></i></button>
                                </span>
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary px-3"><i class="fa fa-eraser"></i></button>
                                </span>
                            </div>

                            <div class="row g-3 col-md-5">
                                <div class="col-auto">
                                    <label for="inputPassword6" class="col-form-label">Buscar:</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="password" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
                                </div>
                            </div>
                        </div>

                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                                                <th >ID</th>
                                                <th >Còdigo</th>
                                                <th >RUC/DNI</th>
                                                <th >Cliente</th>
                                                <th>Fecha</th>
                                                <th>Condiciòn</th>
                                                <th>Importe total</th>
                                                <th>Sunat</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                            <td>1</td>
                                            <td>FA00-00000001</td>
                                            <td>203837834</td>
                                            <td>Fact1</td>
                                            <td>Jul 14, 2013</td>
                                            <td>Contado</td>
                                            <td>S/ 1,800.00</td>
                                            <td>
                                                <a href="#"><i class="fa fa-check-circle"></i></a>
                                            </td>
                                            <td>
                                                <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                            <td>2</td>
                                            <td>FA00-00000002</td>
                                            <td>23908223</td>
                                            <td>Dexter</td>
                                            <td>Jul 16, 2013</td>
                                            <td>Contado</td>
                                            <td>s/ 2,456.50</td>
                                            <td>
                                                <a href="#"><i class="fa fa-check-circle"></i></a>
                                            </td>
                                            <td>
                                                <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                            <td>3</td>
                                            <td>FA00-00000003</td>
                                            <td>23908223</td>
                                            <td>Dexter</td>
                                            <td>Jul 18, 2013</td>
                                            <td>Contado</td>
                                            <td>s/ 2,456.50</td>
                                            <td>
                                                <a href="#"><i class="fa fa-check-circle"></i></a>
                                            </td>
                                            <td>
                                                <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                            <td>4</td>
                                            <td>FA00-00000004</td>
                                            <td>23908223</td>
                                            <td>Dexter</td>
                                            <td>Jul 22, 2013</td>
                                            <td>Contado</td>
                                            <td>s/ 2,456.50</td>
                                            <td>
                                                <a href="#"><i class="fa fa-check-circle"></i></a>
                                            </td>
                                            <td>
                                                <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>


                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane active show">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                                                <th >ID</th>
                                                <th >Código</th>
                                                <th >RUC/DNI</th>
                                                <th >Cliente</th>
                                                <th>Fecha</th>
                                                <th>Condiciòn</th>
                                                <th>Importe total</th>
                                                <th>Sunat</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>1</td>
                                                <td>FM00-00000001</td>
                                                <td>203837834</td>
                                                <td>Fact2</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Contado</td>
                                                <td>S/ 1,800.00</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>2</td>
                                                <td>FM00-00000002</td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 16, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>3</td>
                                                <td>FM00-00000003</td>
                                                <td>23908223</td>
                                                <td>Jacinto</td>
                                                <td>Jul 18, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>4</td>
                                                <td>FM00-00000004</td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 22, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                                                <th >ID</th>
                                                <th >Código</th>
                                                <th >RUC/DNI</th>
                                                <th >Cliente</th>
                                                <th>Fecha</th>
                                                <th>Condiciòn</th>
                                                <th>Importe total</th>
                                                <th>Sunat</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>1</td>
                                                <td>8944444</td>
                                                <td>203837834</td>
                                                <td>Fact3</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Contado</td>
                                                <td>S/ 1,800.00</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>2</td>
                                                <td><span class="pie" style="display: none;">6,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 12.702282018339785 14.47213595499958 Z" fill="#1ab394"></path><path d="M 8 8 L 12.702282018339785 14.47213595499958 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 16, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>3</td>
                                                <td><span class="pie" style="display: none;">3,1</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 1 1 0 8.000000000000002 Z" fill="#1ab394"></path><path d="M 8 8 L 0 8.000000000000002 A 8 8 0 0 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Jacinto</td>
                                                <td>Jul 18, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>4</td>
                                                <td><span class="pie" style="display: none;">4,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 15.48012994148332 10.836839096340286 Z" fill="#1ab394"></path><path d="M 8 8 L 15.48012994148332 10.836839096340286 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 22, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  4 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                                                <th >ID</th>
                                                <th >Código</th>
                                                <th >RUC/DNI</th>
                                                <th >Cliente</th>
                                                <th>Fecha</th>
                                                <th>Condiciòn</th>
                                                <th>Importe total</th>
                                                <th>Sunat</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>1</td>
                                                <td>8944444</td>
                                                <td>203837834</td>
                                                <td>Fact4</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Contado</td>
                                                <td>S/ 1,800.00</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>2</td>
                                                <td><span class="pie" style="display: none;">6,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 12.702282018339785 14.47213595499958 Z" fill="#1ab394"></path><path d="M 8 8 L 12.702282018339785 14.47213595499958 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 16, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>3</td>
                                                <td><span class="pie" style="display: none;">3,1</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 1 1 0 8.000000000000002 Z" fill="#1ab394"></path><path d="M 8 8 L 0 8.000000000000002 A 8 8 0 0 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Jacinto</td>
                                                <td>Jul 18, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>4</td>
                                                <td><span class="pie" style="display: none;">4,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 15.48012994148332 10.836839096340286 Z" fill="#1ab394"></path><path d="M 8 8 L 15.48012994148332 10.836839096340286 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 22, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-5" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  5 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                                                <th>ID</th>
                                                <th>Código</th>
                                                <th>RUC/DNI</th>
                                                <th>Cliente</th>
                                                <th>Fecha</th>
                                                <th>Condiciòn</th>
                                                <th>Importe total</th>
                                                <th>Sunat</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>1</td>
                                                <td>8944444</td>
                                                <td>203837834</td>
                                                <td>Fact5</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Contado</td>
                                                <td>S/ 1,800.00</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>2</td>
                                                <td><span class="pie" style="display: none;">6,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 12.702282018339785 14.47213595499958 Z" fill="#1ab394"></path><path d="M 8 8 L 12.702282018339785 14.47213595499958 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 16, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>3</td>
                                                <td><span class="pie" style="display: none;">3,1</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 1 1 0 8.000000000000002 Z" fill="#1ab394"></path><path d="M 8 8 L 0 8.000000000000002 A 8 8 0 0 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Jacinto</td>
                                                <td>Jul 18, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>4</td>
                                                <td><span class="pie" style="display: none;">4,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 15.48012994148332 10.836839096340286 Z" fill="#1ab394"></path><path d="M 8 8 L 15.48012994148332 10.836839096340286 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 22, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <!-- Botones de navegación en la tabla -->
                        <div class="btn-group mt-4">
                            <button type="button" class="btn btn-white"><!--<i class="fa fa-chevron-left"></i>-->Anterior</button>
                            <button class="btn btn-white">1</button>
                            <button class="btn btn-white active">2</button>
                            <button class="btn btn-white">3</button>
                            <button class="btn btn-white">4</button>
                            <button type="button" class="btn btn-white"><!--<i class="fa fa-chevron-right"></i>-->Siguiente</button>
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
    <script>
    $(document).ready(function(){
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
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
