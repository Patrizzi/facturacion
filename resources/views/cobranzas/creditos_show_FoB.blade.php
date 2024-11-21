@extends('layout')

@section('title', 'Registros FA00-00000767')
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
                                                                <h2><strong>Datos Generales</strong></h2>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row ">
                                                                    <div class="col-sm-12">
                                                                            <div style="margin: auto 50px">
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label"><strong>Nombre Completo:</strong></label>
                                                                                    <div class="col-sm-8">
                                                                                        <p class="form-control">Paolo Guerrero Gonzales</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label
                                                                                        class="col-sm-4 col-form-label"><strong>DNI:</strong></label>
                                                                                    <div class="col-sm-8">
                                                                                        <p class="form-control">80561230</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label"><strong>Telefono:</strong></label>
                                                                                    <div class="col-sm-8">
                                                                                        <p class="form-control">912345678</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-4 col-form-label"><strong>Correo:</strong></label>
                                                                                    <div class="col-sm-8">
                                                                                        <p class="form-control">Pguerrero9@gmail.com</p>
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
                                                                <h2><strong>Datos Generales</strong></h2>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Código:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                <p class="form-control">FA00-00000767</p>
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
                                                                            <label class="col-sm-4 col-form-label"><strong>N° Cuotas:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                <p class="form-control">3</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Estado:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                    <button class="btn btn-warning btn-block" disabled><i class="fa fa-warning"></i>&nbsp;&nbsp;Adelantado</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Fecha de Pago:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                <p class="form-control">22-10-2024</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Monto Total:</strong></label>
                                                                            <div class="col-sm-8"> 
                                                                                <p class="form-control">S/ 1,000.02</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Monto Pagado:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                <p class="form-control">S/.400.01</p>                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row mb-3">
                                                                            <label class="col-sm-4 col-form-label"><strong>Monto Faltante:</strong></label>
                                                                            <div class="col-sm-8">
                                                                                <p class="form-control">S/ 600.01</p>
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
                                        <!--TABLAS-->
                                        <div role="tabpanel" id="tab-3" class="tab-pane ">
                                            <div class="panel-body">
                                            <div class="col-lg-12">
                                                        <div class="panel panel-success">
                                                            <div class="panel-heading text-center">
                                                                <h2><strong>Informacion General</strong></h2>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="row col-lg-12">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-4 col-form-label"><strong>Buscar:</strong></label>
                                                                            <input type="search" class="form-control col-lg-8">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-7 col-form-label"><strong>Pagar por Lote:</strong></label>
                                                                            <button type="submit" class="form-control col-lg-5 btn btn-primary">Pagar todo</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <div class="table-responsive">
                                                                <table class="footable3 table table-stripped toggle-arrow-tiny table-bordered table-hover dataTables-example">
                                                                        <thead>
                                                                            <tr>
                                                                                <th data-toggle="true">Ver</th>    
                                                                                <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                                                <th>Cuotas</th>
                                                                                <th>Monto Total</th>
                                                                                <th>Fecha Cancelada</th>
                                                                                <th>Fecha de Inicio</th>
                                                                                <th>Fecha de Vencimiento</th>
                                                                                <th>Pagos</th>
                                                                                <th>Adelanto</th>
                                                                                <th>Acciones</th>
                                                                                <th data-hide="all"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Ver más</td>     
                                                                                <td><input type="checkbox" class="i-checks" name="input[]"></td> 
                                                                                <td>Cuota N° 1</td>
                                                                                <td>S/ 350.01</td>
                                                                                <td>S/ 350.01</td>
                                                                                <td>24-10-2024</td>
                                                                                <td>25-10-2024</td>
                                                                                <td><strong>24-10-2024</strong></td>
                                                                                <td><button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button></td>
                                                                                <td>
                                                                                <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                                                                <button type="button" class="btn" style="background-color: green"><i class="fa fa-check"></i></button>  
                                                                                <div class="btn-group">
                                                                                        <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">Pago</button>
                                                                                    </div>
                                                                                </td>
                                                                                <td>Se pagó a tiempo</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Ver más</td>
                                                                                <td><input type="checkbox" class="i-checks" name="input[]"></td> 
                                                                                <td>Cuota N° 2</td>
                                                                                <td>S/. 200.00</td>
                                                                                <td>S/. 50.00</td>
                                                                                <td>25-10-2024</td>
                                                                                <td>26-10-2024</td>
                                                                                <td><strong>PENDIENTE </strong></td>
                                                                                <td><button type="button" class="btn" style="background-color: green"><i class="fa fa-check"></i></button></td>  
                                                                                <td>
                                                                                <button type="button" class="btn btn-info"> <i class="fa fa-eye"></i></button>
                                                                                <button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>  
                                                                                <div class="btn-group">
                                                                                        <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Pago</button>
                                                                                        <ul class="dropdown-menu">
                                                                                        <li><a class="dropdown-item" class="btn btn-primary" >Pagar</a></li>
                                                                                        <li><a class="dropdown-item" class="btn btn-primary" >Adelantar</a></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                <td>eewe</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Ver más</td>
                                                                                <td><input type="checkbox" class="i-checks" name="input[]"></td> 
                                                                                <td>Cuota N° 3</td>
                                                                                <td>S/. 400.01</td>
                                                                                <td>S/. 0.00</td>
                                                                                <td>26-10-2024</td>
                                                                                <td>27-10-2024</td>
                                                                                <td><strong>PENDIENTE</strong></td>
                                                                                <td><button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button></td>
                                                                                <td>
                                                                                <button type="button" class="btn btn-info"> <i class="fa fa-eye"></i></button>
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
                                                                            <td>
                                                                                <div  class="table-responsive text-center">
                                                                                    <h3 class="mb-4">Detalle de Pagos</h3>
                                                                                    <table class="table-striped table-bordered table-hover" >
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Id</th>
                                                                                                <th>Codigo</th>
                                                                                                <th>Monto</th>
                                                                                                <th>Fecha</th>
                                                                                                <th>Detalle</th>
                                                                                                <th>Comprobante</th>
                                                                                            </tr>
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td>1</td>
                                                                                                    <td>Hola</td>
                                                                                                    <td>S/. 400.01</td>
                                                                                                    <td>26-10-2024</td>
                                                                                                    <td><button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button></td>
                                                                                                    <td><button type="button" class="btn btn-primary"><i class="fa fa-file-text"></i></button></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </thead>
                                                                                    </table>
                                                                                </div>
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
        .footable{
            width: 100%;
        }.footable-row-detail-name {
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

    <!-- FooTable -->
    <script src="{{ asset ('js/plugins/footable/footable.all.min.js') }}"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {

            $('.footable3').footable();
  $('#tab-3').on('click', function() {
            $('.footable3').footable();
        });
        });
      
    </script>
    
@endsection