@extends('layout')

@section('title', 'Nota Credito Motivo')
@section('breadcrumb', 'Nota Credito Motivo')
@section('breadcrumb2', 'Nota Credito Motivo')
@section('href_accion', route('nota-credito.index'))
@section('value_accion', 'atras')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Formulario de motivo</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Emisión de Nota de credito</h3>
                            <form role="form">
                                <div class="form-group"><label>Fecha de emisión</label> <input type="date" placeholder="Ingrese Fecha" class="form-control"></div>
                                <div class="form-group"><label>Tipo de nota de credito</label> 
                                    <select placeholder="Password" class="form-control" name="motivo" id="motivo" onchange="seleccion_motivo()">
                                        <option value="0"></option>
                                        <option value="1">Anulacion de la operacion</option>
                                        <option value="2">Anulacion por error en el RUC</option>
                                        <option value="3">Descuento Global</option>
                                        <option value="4">Devolucion Total</option>
                                        <option value="5">Correcion por error en la descripcion</option>
                                        <option value="6">Devolucion por Item</option>
                                        <option value="7">Descuento por Item</option>
                                        <option value="8">Otros conceptos</option>
                                        <option value="9">Ajustes - montos y/o fechas de pago</option>
                                    </select>
                                </div>
                                <div class="form-group"><label>Número de FE respecto de la cual se emite la Nota de Crédito	</label> <input type="text" class="form-control" required value="{{$facturacion->codigo_fac}}" disabled></div>
                                
                                <div>
                                    <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Enviar</strong></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-6">
                            <div class="div1">
                                <div class="form-group"><label>Motivo o sustento por el cual se emitirá la Nota de Crédito </label> <input type="text" class="form-control" required></div>
                            </div>
                            <div class="div2">
                                <div class="form-group"><label>Número de la Nueva Factura Electrónica </label> <input type="text" class="form-control" required></div>
                            </div>
                            <div class="div3">
                                <div class="form-group"><label>Motivo o sustento por el cual se emitirá la Nota de Crédito </label> <input type="text" class="form-control" required></div>
                                <div class="form-group"><label>Descuento Global </label> <input type="text" class="form-control" required></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    seleccion_motivo();

    function seleccion_motivo(){
        var motivo = $('#motivo').val();
        if(motivo=="0"){
            $('.div1').hide();
            $('.div2').hide();
            $('.div3').hide();
        }else if(motivo=="1" || motivo=="4" || motivo=="5" || motivo=="6" || motivo=="7" || motivo=="8" || motivo=="9"){
            $('.div1').show();
            $('.div2').hide();
            $('.div3').hide();
        }else if(motivo=="2"){
            $('.div1').show();
            $('.div2').show();
            $('.div3').hide();
        }else{
            $('.div1').hide();
            $('.div2').hide();
            $('.div3').show();
        }
    }
</script>

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


@endsection
