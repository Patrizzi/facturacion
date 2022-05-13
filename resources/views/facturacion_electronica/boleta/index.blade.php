@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Boleta Electronica')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                @if(Session::has('successMsg'))
                <div class="alert alert-success">
                    <a class="alert-link" href="#">{{ session('successMsg') }}</a>.
                </div>
                @endif
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active show" data-toggle="tab" href="#tab-1">Por Enviar</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Enviados</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active show">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <div class="ibox-content">
                                        <div class="sk-spinner sk-spinner-double-bounce">
                                            <div class="sk-double-bounce1"></div>
                                            <div class="sk-double-bounce2"></div>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th><input class='check_all_boleta' type='checkbox' onclick="select_all_boleta()" /></th>
                                                    <th>Item</th>
                                                    <th>Codigo de Boleta</th>
                                                    <th>Cliente</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Fecha Vencimiento</th>
                                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                </tr>
                                            </thead>
                                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                            <tbody>
                                                <span hidden>{{$i=1}}</span>
                                                @foreach($boletas as $boleta)
                                                <tr class="gradeX">
                                                    <td><input type='checkbox' class='case' value="{{$boleta->codigo_boleta}}" /></td>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$boleta->codigo_boleta}}</td>
                                                    @if(isset($boleta->cliente_id)) <!-- Nombre del cliente -->
                                                    <td>{{$boleta->cliente->nombre}}</td>
                                                    <td>{{$boleta->cliente->numero_documento}}</td>
                                                    @else
                                                    <td>{{$boleta->cotizacion->cliente->nombre}}</td>
                                                    <td>{{$boleta->cotizacion->cliente->numero_documento}}</td>
                                                    @endif
                                                    <td>{{$boleta->fecha_vencimiento }}</td>
                                                    <td>
                                                        <center>
                                                            <form action="{{route('facturacion_electronica.boleta_sunat')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="factura_id" value="{{$boleta->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </center>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfooter >
                                                <td colspan="6" align="right" style="padding-right: 2em"></td>
                                                <td align="center"><button type="button" class="btn btn-primary" id="boleta_elec_all">Enviar</button></td>
                                            </tfooter>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Codigo de Factura</th>
                                                <th>Cliente</th>
                                                <th>Ruc/DNI</th>
                                                <th>Fecha Vencimiento</th>
                                                <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span hidden>{{$i=1}}</span>
                                            @foreach($boletas_enviadas as $boleta_env)
                                            <tr class="gradeX">
                                                <td>{{$i++}}</td>
                                                <td>{{$boleta_env->codigo_boleta}}</td>
                                                @if(isset($boleta_env->cliente_id)) <!-- Nombre del cliente -->
                                                <td>{{$boleta_env->cliente->nombre}}</td>
                                                <td>{{$boleta_env->cliente->numero_documento}}</td>
                                                @else
                                                <td>{{$boleta_env->cotizacion->cliente->nombre}}</td>
                                                <td>{{$boleta_env->cotizacion->cliente->numero_documento}}</td>
                                                @endif
                                                <td>{{$boleta_env->fecha_vencimiento }}</td>
                                                <td>
                                                    <center>
                                                        <form action="{{route('facturacion_electronica.boleta_sunat')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="factura_id" value="{{$boleta_env->id}}">
                                                            <button type="button" class="btn btn-info btn-circle btn-ls" ><i class="fa fa-check-circle"></i></button>
                                                        </form>
                                                    </center>
                                                </td>
                                            </tr>
                                            @endforeach
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
<!-- Modal para BOLETA  -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviando Boletas a Sunat</h5>
            </div>
            <div class="modal-body">
                <div id="msg_bole_el">
                    {{-- Contenido del ajax --}}
                </div>
            </div>
            <div class="modal-footer" style="display: none;">
                <div class="row">
                    <div class="col-sm-6" >
                        *En caso de algún error al enviar la Factura, por favor comunicarse de manera inmediata.
                    </div>
                    <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                        <button type="button" class="btn btn-primary" id="cerrar_modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ESTILOS --}}
<style type="text/css">
    .a{width: 200px}
    .ibox-content{
        padding: 0px;
        border: none;
    }
    .model-footer{
        > :not(:last-child) { margin-right: .0rem; }
    }
</style>

<!-- scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Page Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 20,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [ ]
        });
    });
    function select_all_boleta() {
        $('input[class=case]:checkbox').each(function () {
            // console.log($('input[class=check_all]:checkbox:checked'));
            if ($('input[class=check_all_boleta]:checkbox:checked').length == 0) {
                // console.log("a");
                $(this).prop("checked", false);
            } else {
                // console.log("b");
                $(this).prop("checked", true);
            }
        });
    }
    function submit_factura_manual_click(repetir,maximo)
    {
        if ( repetir < maximo ){
            var value_check =  $('input[class=case]:checkbox:checked')[repetir].value;
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.boleta_elec_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_bol': value_check,
                },
                success: function (response) {
                    var salt = response. replace(/(\r\n|\n|\r)/gm, "") 
                    var result = salt.substr(0,13);
                    console.log(result);
                    if(result  == "Codigo Error:"){
                        var data = `
                            <div class="alert alert-danger">
                                <a class="alert-link" href="#">Error N°  `+value_check+' <br> '+response+`</a>
                            </div>
                        `;
                    }else{
                        var data = `
                            <div class="alert alert-success">
                                <a class="alert-link" href="#">`+response+`</a>
                            </div>
                        `;
                    }
                    $('#msg_bole_el').append( data );
                    repetir++;
                    submit_factura_manual_click(repetir, maximo);
                }    
            });
        }else{
            $('.modal-footer').removeAttr( 'style' );
        }
    }
    $('#boleta_elec_all').on('click', function(){
        var cant_checks =  $('input[class=case]:checkbox:checked').length;
        console.log(cant_checks)
        // var max_menos = cant_checks -1;
        if(cant_checks == 0){
            console.log("ninguno marcado");
        }else{
            $('#exampleModal').modal({backdrop: 'static', keyboard: false});
            $("#exampleModal").modal("show");
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            submit_factura_manual_click(0,cant_checks);
        }
        
    });
    $('#cerrar_modal').on('click', function(){
        location.reload();
    });
</script>
@endsection
