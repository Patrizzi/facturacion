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
                        @if(isset($facturacion->codigo_fac))
                            {{-- FACTURA Y FACTURA MANUAL --}}
                            <form method="POST" action="{{route('nota-credito.create_nota_credito')}}">
                            @csrf
                                <div class="form-group"><label>Fecha de emisión</label><input type="date"  class="form-control" name="fecha_emision" id="fecha_emision" required></div>
                                <input type="hidden" name="tipo" id="" value="factura_origi">
                                <div class="form-group"><label>Tipo de nota de credito</label> 
                                    <select class="form-control" name="tipo_nota_credito" id="tipo_nota_credito" onchange="seleccion_motivo()" required>
                                        <option></option>
                                        <option value="01">Anulacion de la operacion</option>
                                        <option value="02">Anulacion por error en el RUC</option>
                                        <option value="03">Correcion por error en la descripcion</option>
                                        <option value="06">Devolucion Total</option>
                                        <option value="07">Devolucion por Item</option>

                                        {{-- <option value="8">Otros conceptos</option>
                                        <option value="9">Ajustes - montos y/o fechas de pago</option> --}}
                                    </select>
                                </div>
                                <div class="form-group"><label>Número de FE respecto de la cual se emite la Nota de Crédito	</label> <input type="text" class="form-control" name="factura_id" id="factura_id" required value="{{$facturacion->codigo_fac}}" readonly></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="div1">
                                    <div class="form-group"><label>Motivo o sustento por el cual se emitirá la Nota de Crédito </label> <input type="text" class="form-control" name="sustento" id="sustento"></div>
                                </div>
                                <div class="div2">
                                    <div class="form-group"><label>Número de la Nueva Factura Electrónica </label> <input type="text" class="form-control" name="nueva_factura" id="nueva_factura"></div>
                                </div>
                                <div class="div3">
                                    <div class="form-group"><label>Descuento Global </label> <input type="text" class="form-control" name="descuento_global" id="descuento_global"></div>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Enviar</strong></button>
                                </div>
                            </form>
                        @else
                            {{-- BOLETA --}}
                            <form method="POST" action="{{route('nota-credito.create_nota_credito')}}">
                            @csrf
                                <input type="hidden" name="tipo" id="" value="factura_manual">
                                <div class="form-group"><label>Fecha de emisión</label><input type="date"  class="form-control" required name="fecha_emision"  id="fecha_emision"></div>
                                <div class="form-group"><label>Tipo de nota de credito</label> 
                                    <select class="form-control" name="tipo_nota_credito" id="tipo_nota_credito" onchange="seleccion_motivo()" required >
                                        <option></option>
                                        <option value="01">Anulacion de la operacion</option>
                                        <option value="02">Anulacion por error en el RUC</option>
                                        <option value="03">Correcion por error en la descripcion</option>
                                        <option value="06">Devolucion Total</option>

                                        {{-- <option value="8">Otros conceptos</option>
                                        <option value="9">Ajustes - montos y/o fechas de pago</option> --}}
                                    </select>
                                </div>
                                <div class="form-group"><label>Número de FE respecto de la cual se emite la Nota de Crédito	</label> <input type="text" class="form-control" name="factura_id" id="factura_id" required value="{{$facturacion_m->codigo_fac}}" readonly></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="div1">
                                    <div class="form-group"><label>Motivo o sustento por el cual se emitirá la Nota de Crédito </label> <input type="text" class="form-control" name="sustento" id="sustento"></div>
                                </div>
                                <div class="div2">
                                    <div class="form-group"><label>Número de la Nueva Factura Electrónica </label> <input type="text" class="form-control" name="nueva_factura" id="nueva_factura"></div>
                                </div>
                                <div class="div3">
                                    <div class="form-group"><label>Descuento Global </label> <input type="text" class="form-control" name="descuento_global" id="descuento_global"></div>
                                </div>
                                <div class="">
                                    <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Enviar</strong></button>
                                </div>
                            </form>
                        @endif
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
        var motivo = $('#tipo_nota_credito').val();
        if(motivo== ""){
            $('.div1').hide();
            $('.div2').hide();
            $('.div3').hide();
        }else if(motivo=="01" || motivo=="04" || motivo=="05" || motivo=="06" || motivo=="07" || motivo=="08" || motivo=="03"){
            $('.div1').show();
            $('.div2').hide();
            $('.div3').hide();
        }else if(motivo=="02"){
            $('.div1').show();
            $('.div2').show();
            $('.div3').hide();
        }
    }
    $( document ).ready(function() {
        document.getElementById('fecha_emision').max = new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60000).toISOString().split("T")[0];
        // var f = new Date().toISOString().split("T")[0];
        var today = new Date();
        var dd = today.getDate() - 2;
        var mm = today.getMonth(); //January is 0 so need to add 1 to make it 1!
        var new_m = parseInt(mm)+1;
        var n_m = '0'+ new_m;
        var yyyy = today.getFullYear();
        var min = yyyy+'-'+n_m+'-'+dd;

        document.getElementById('fecha_emision').min = min;
    });
        // $('.fecha_emision').max = new Date().toISOString().split("T")[0];
    window.onload = function(){
        var today = new Date();
        var dd = today.getDate();
        if(dd < 10){
            var dd = '0'+dd;
        }else{
            var dd = dd;
        }
        var mm = today.getMonth(); //January is 0 so need to add 1 to make it 1!
        var new_m = parseInt(mm)+1;
        if(new_m < 10){
            var n_m = '0'+ new_m;
        }else{
            var n_m = new_m;
        }
        var yyyy = today.getFullYear();
        var hoy = yyyy+'-'+n_m+'-'+dd;
        document.getElementById('fecha_emision').value = hoy;
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
