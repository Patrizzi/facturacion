@extends('layout')

@section('title', 'Créditos')

@section('content')
                                                            <div class="row mb-3"> 
                                                                <div class="col-sm-6">
                                                                    <div class="form-group row mb-3"> <!-- Agregar margen inferior a cada fila -->
                                                                        <label class="col-sm-4 col-form-label"><strong>Código:</strong></label>
                                                                        <div class="col-sm-8">
                                                                            <p class="form-control">NV 001-00000015</p> <!-- Agregar el código como en la imagen -->
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
                                                                            <button class="btn btn-danger btn-block" disabled><i class="fa fa-times"></i>&nbsp;&nbsp;Sin Pagar</button> <!-- Botón de estado -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-sm-6">
                                                                    <div class="form-group row mb-3">
                                                                        <label class="col-sm-4 col-form-label"><strong>Fecha de Pago:</strong></label>
                                                                        <div class="col-sm-8">
                                                                            <p class="form-control">71104520</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-3">
                                                                        <label class="col-sm-4 col-form-label"><strong>Total:</strong></label>
                                                                        <div class="col-sm-8">
                                                                            <p class="form-control">S/ 1,200.00</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-3">
                                                                        <label class="col-sm-4 col-form-label"><strong>Pagado:</strong></label>
                                                                        <div class="col-sm-8">
                                                                            <p class="form-control">S/ 0.00</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-3">
                                                                        <label class="col-sm-4 col-form-label"><strong>Faltante:</strong></label>
                                                                        <div class="col-sm-8">
                                                                            <p class="form-control">S/ 1,200.00</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <div class="row mb-3">
                                                                <div class="col-sm-12 d-flex justify-content-center"> 
                                                                    <a class="btn btn-primary mx-2" href="" target="_blank">Descargar</a> 
                                                                    <a class="btn btn-primary mx-2" href="" target="_blank">Nota de Venta</a> 
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


