@extends('layout')

@section('title', 'Registros NV 001-00000001')
@section('content')
    <div class="wrapper wrapper-content animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="col-lg-12">
                            <div class="tabs-container">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Cliente</a></li>
                                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Comprobante</a></li>
                                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">Cuotas y Adelanto </a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <!--CLIENTE-->
                                        <div role="tabpanel" id="tab-1" class="tab-pane active">
                                            <div class="panel-body">
                                                    <div class="col-lg-12">
                                                        <div class="panel panel-success">
                                                            <div class="panel-heading text-center">
                                                                Datos Generales
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row ">
                                                                    <div class="col-sm-12">
                                                                            <div style="margin: auto 50px">
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label"><strong>Nombre Completo:</strong></label>
                                                                                    <div class="col-sm-8">
                                                                                        <p class="form-control">Marlo Samaniego Calderon</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label
                                                                                        class="col-sm-4 col-form-label"><strong>DNI:</strong></label>
                                                                                    <div class="col-sm-8">
                                                                                        <p class="form-control">72808518</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label"><strong>Telefono:</strong></label>
                                                                                    <div class="col-sm-8">
                                                                                        <p class="form-control">987654321</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label"><strong>Correo:</strong></label>
                                                                                    <div class="col-sm-8">
                                                                                        <p class="form-control">mnose@gmail.com</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!--COMPROBANTE-->
                                        <div role="tabpanel" id="tab-2" class="tab-pane">
                                            <div class="panel-body">
                                                    <div class="col-lg-12">
                                                        <div class="panel panel-success">
                                                            <div class="panel-heading text-center">
                                                                Datos Generales
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Código:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                <p class="form-control">NV 001-00000015</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Moneda:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                <p class="form-control">SOLES</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Forma:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                <p class="form-control">Crédito</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Estado:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                    <button class="btn btn-danger btn-block" disabled><i class="fa fa-times"></i>&nbsp;&nbsp;Sin Pagar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Fecha de Pago:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                <p class="form-control">10-10-2024</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Total:</strong></label>
                                                                            <div class="col-sm-8"> 
                                                                                <p class="form-control">S/. 100.00</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Pagado:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                <p class="form-control">S/. 0.00</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Faltante:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                <p class="form-control">S/. 100.00</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="col-sm-12">
                                                                        <div class="form-group row justify-content-center">
                                                                            <a class="btn btn-primary mx-2" href="" target="_blank">Descargar </a>
                                                                        
                                                                            <a class="btn btn-primary mx-2" href="" target="_blank">Ver Factura</a>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div role="tabpanel" id="tab-3" class="tab-pane">
                                            <div class="panel-body">
                                            <div class="col-lg-12">
                                                        <div class="panel panel-success">
                                                            <div class="panel-heading text-center">
                                                                Informacion General
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-6 col-form-label"><strong>Buscar:</strong></label>
                                                                            <input type="search" class="form-control col-lg-6">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                        <thead>
                                                                            <tr>
                                                                                <th data-toggle="true" >Ver</th>
                                                                                <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                                                <th>Cuota</th>
                                                                                <th>Total</th>
                                                                                <th>Cancelado</th>
                                                                                <th>Inicio</th>
                                                                                <th>Vencimiento</th>
                                                                                <th>Pago</th>
                                                                                <th>Acciones</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>></td>
                                                                                <td><input type="checkbox" class="i-checks" name="input[]"></td> 
                                                                                <td>Cuota N° 1</td>
                                                                                <td>S/. 100.00</td>
                                                                                <td>S/. 0.00</td>
                                                                                <td>17-04-2024</td>
                                                                                <td>17-04-2024</td>
                                                                                <td>PENDIENTE</td>
                                                                                <td>
                                                                                <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                                                                <button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>  
                                                                                <div class="btn-group">
                                                                                        <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Pago</button>
                                                                                        <ul class="dropdown-menu">
                                                                                        <li><a class="dropdown-item" class="btn btn-primary" >Pagar</a></li>
                                                                                        <li><a class="dropdown-item" class="btn btn-primary" >Adelantar</a></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </td>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>></td>
                                                                                <td><input type="checkbox" class="i-checks" name="input[]"></td> 
                                                                                <td>Cuota N° 2</td>
                                                                                <td>S/. 100.00</td>
                                                                                <td>S/. 0.00</td>
                                                                                <td>17-04-2024</td>
                                                                                <td>17-04-2024</td>
                                                                                <td>PENDIENTE</td>
                                                                                <td>
                                                                                <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                                                                <button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>  
                                                                                <div class="btn-group">
                                                                                        <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Pago</button>
                                                                                        <ul class="dropdown-menu">
                                                                                        <li><a class="dropdown-item" class="btn btn-primary" >Pagar</a></li>
                                                                                        <li><a class="dropdown-item" class="btn btn-primary" >Adelantar</a></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </td>
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