@extends('layout')

@section('title', 'Guia de remision')
@section('breadcrumb', 'Guia de remision')
@section('breadcrumb2', 'Guia de remision')

@extends('layout_comunicado')
@section('content')
<span hidden="">{{$i=1}}{{$a=1}}{{$j=1}}{{$x=1}}{{$y=1}}{{$o=1}}</span>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                @if(Session::has('successMsg'))
                <div class="ibox-content">
                    <div class="alert alert-success">
                     <b> {{ session('successMsg') }}.</b>
                    </div>
                </div>
                @endif
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li>
                            <a href="#" class="nav link  guia_remi" style="font-weight: bold" >Guia Remision:</a>
                        </li>
                        <li><a class="nav-link active show" data-toggle="tab" href="#tab-1">Por Enviar</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Enviados</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">Anulados</a></li>
                        <li>
                            <a href="#" class="nav link guia_m" style="font-weight: bold" >G. Remision Manual:</a>
                        </li>
                        <li><a class="nav-link " data-toggle="tab" href="#tab-4">Por Enviar</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-5">Enviados</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-6">Anulados</a></li>
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
                                                <th><input class='check_all_remi' type='checkbox' onclick="select_all_remision()" /></th>
                                                <th>ID</th>
                                                <th>Codigo de Guia</th>
                                                <th>Fecha emision</th>
                                                <th>Fecha entrega</th>
                                                <th>Tipo Transporte</th>
                                                <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                            </tr>
                                        </thead>
                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                        <tbody>
                                            @foreach($guia_remisiones as $guia_remision)
                                            <tr class="gradeX">
                                                <td><input type='checkbox' class='case' value="{{$guia_remision->cod_guia}}" /></td>
                                                <td>{{$a++}}</td>
                                                <td>{{$guia_remision->cod_guia}}</td>
                                                <td>{{$guia_remision->fecha_emision}}</td>
                                                <td>{{$guia_remision->fecha_entrega}}</td>
    
                                                @if($guia_remision->tipo_transporte==0)
                                                <td>Sin Trasporte</td>
                                                @elseif($guia_remision->tipo_transporte==1)
                                                <td>Trasporte Publico</td>
                                                @else
                                                <td>Trasporte Privado</td>
                                                @endif
                                                <td>
                                                    <center>
                                                        <form action="{{route('facturacion_electronica.guia_remision_sunat')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="factura_id" value="{{$guia_remision->id}}">
                                                            {{-- <button type="" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button> --}}
                                                            <span class="btn btn-secondary btn-circle btn-ls disabled">
                                                                <i class="fa fa-cloud-upload"></i>
                                                            </span>
                                                        </form>
                                                    </center>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfooter >
                                            <td colspan="6" align="right" style="padding-right: 2em"></td>
                                            <td align="center">
                                                {{-- <button type="" class="btn btn-primary" id="remision_elec_all">Enviar</button> --}}
                                                <span class="btn btn-primary btn-ls disabled">
                                                    Enviar
                                                </span>
                                            </td>
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
                                            <th>ID</th>
                                            <th>Codigo de Guia</th>
                                            <th>Fecha emision</th>
                                            <th>Fecha entrega</th>
                                            <th>Tipo Transporte</th>
                                            <th>XML</th>
                                            <th>ZIP</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($guia_remision_enviados as $guia_remision)
                                        <tr class="gradeX">
                                            <td>{{$i++}}</td>
                                            <td>{{$guia_remision->cod_guia}}</td>
                                            <td>{{$guia_remision->fecha_emision}}</td>
                                            <td>{{$guia_remision->fecha_entrega}}</td>

                                            @if($guia_remision->tipo_transporte==0)
                                            <td>Sin Trasporte</td>
                                            @elseif($guia_remision->tipo_transporte==1)
                                            <td>Trasporte Publico</td>
                                            @else
                                            <td>Trasporte Privado</td>
                                            @endif
                                            <td align="center">
                                                <a href="{{ asset('facturas_electronicas/')}}/{{$empresa->ruc}}-09-{{$guia_remision->cod_guia}}.xml" download><img src="{{asset('xml.png')}}" width="25px"></a>
                                            </td>
                                            <td align="center">
                                                <a href="{{ asset('facturas_electronicas/')}}/R-{{$empresa->ruc}}-09-{{$guia_remision->cod_guia}}.zip" download><img src="{{asset('zip.png')}}" width="25px"></a>
                                            </td>
                                            <td>
                                                <center>
                                                    <form action="{{route('facturacion_electronica.guia_remision_baja_sunat')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="factura_id" value="{{$guia_remision->id}}">
                                                        {{-- <button type="" class="btn btn-w-m btn-danger">Anular</button> --}}
                                                        <span class="btn btn-w-m btn-danger disabled">Anular</span>
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
                    <div role="tabpanel" id="tab-3" class="tab-pane">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Codigo de Guia</th>
                                            <th>Fecha emision</th>
                                            <th>Fecha entrega</th>
                                            <th>Tipo Transporte</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($guia_remision_anulado as $guia_remision)
                                        <tr class="gradeX">
                                            <td>{{$o++}}</td>
                                            <td>{{$guia_remision->cod_guia}}</td>
                                            <td>{{$guia_remision->fecha_emision}}</td>
                                            <td>{{$guia_remision->fecha_entrega}}</td>
                                            @if($guia_remision->tipo_transporte==0)
                                            <td>Sin Trasporte</td>
                                            @elseif($guia_remision->tipo_transporte==1)
                                            <td>Trasporte Publico</td>
                                            @else
                                            <td>Trasporte Privado</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-4" class="tab-pane">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th><input class='check_all_remision_m' type='checkbox' onclick="select_all_remision_m()" /></th>
                                                <th>ID</th>
                                                <th>Codigo de Guia</th>
                                                <th>Fecha emision</th>
                                                <th>Fecha Entrega</th>
                                                <th>Tipo Transporte</th>
                                                <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($remision_m as $remision_manuals)
                                                <tr>
                                                    <td><input type="checkbox" class="case_m" value="{{$remision_manuals->id}}"></td>
                                                    <td>{{$j++}}</td>
                                                    <td>{{$remision_manuals->cod_guia}}</td>
                                                    <td>{{$remision_manuals->fecha_emision}}</td>
                                                    <td>{{$remision_manuals->fecha_entrega}}</td>
                                                    <td>
                                                        @if($remision_manuals->tipo_transporte==0)
                                                            Sin Trasporte
                                                        @elseif($remision_manuals->tipo_transporte==1)
                                                            Trasporte Publico
                                                        @else
                                                        @endif
                                                    </td>
                                                    
                                                    <td>
                                                        <center>
                                                            <form action="{{route('facturacion_electronica.guia_remision_m_sunat')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="remision_id" value="{{$remision_manuals->id}}">
                                                                {{-- <button type="" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button> --}}
                                                                <span class="btn btn-secondary btn-circle btn-ls disabled">
                                                                    <i class="fa fa-cloud-upload"></i>
                                                                </span>

                                                            </form>
                                                        </center>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <td colspan="6" align="right" style="padding-right: 2em"></td>
                                                <td align="center">
                                                    {{-- <button type="" class="btn btn-primary" id="remision_m_elec_all">Enviar</button> --}}
                                                    <span class="btn btn-primary btn-ls disabled">
                                                        Enviar
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-5" class="tab-pane">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Codigo de Guia</th>
                                            <th>Fecha emision</th>
                                            <th>Fecha entrega</th>
                                            <th>Tipo Transporte</th>
                                            <th>XML</th>
                                            <th>ZIP</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($remision_m_enviados as $guia_remision_m)
                                        <tr class="gradeX">
                                            <td>{{$y++}}</td>
                                            <td>{{$guia_remision_m->cod_guia}}</td>
                                            <td>{{$guia_remision_m->fecha_emision}}</td>
                                            <td>{{$guia_remision_m->fecha_entrega}}</td>

                                            @if($guia_remision_m->tipo_transporte==0)
                                            <td>Sin Trasporte</td>
                                            @elseif($guia_remision_m->tipo_transporte==1)
                                            <td>Trasporte Publico</td>
                                            @else
                                            <td>Trasporte Privado</td>
                                            @endif
                                            <td align="center">
                                                <a href="{{ asset('facturas_electronicas/')}}/{{$empresa->ruc}}-09-{{$guia_remision_m->cod_guia}}.xml" download><img src="{{asset('xml.png')}}" width="25px"></a>
                                            </td>
                                            <td align="center">
                                                <a href="{{ asset('facturas_electronicas/')}}/R-{{$empresa->ruc}}-09-{{$guia_remision_m->cod_guia}}.zip" download><img src="{{asset('zip.png')}}" width="25px"></a>
                                            </td>
                                            <td>
                                                <center>
                                                    <form action="{{route('facturacion_electronica.guia_remision_m_baja_sunat')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="guia_m_id" value="{{$guia_remision_m->id}}">
                                                        {{-- <button type="" class="btn btn-w-m btn-danger">Anular</button> --}}
                                                        <span class="btn btn-w-m btn-danger disabled">Anular</span>
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
                    <div role="tabpanel" id="tab-6" class="tab-pane">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Codigo de Guia</th>
                                            <th>Fecha emision</th>
                                            <th>Fecha entrega</th>
                                            <th>Tipo Transporte</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($remision_m_anulado as $guia_remision)
                                        <tr class="gradeX">
                                            <td>{{$x++}}</td>
                                            <td>{{$guia_remision->cod_guia}}</td>
                                            <td>{{$guia_remision->fecha_emision}}</td>
                                            <td>{{$guia_remision->fecha_entrega}}</td>
                                            @if($guia_remision->tipo_transporte==0)
                                            <td>Sin Trasporte</td>
                                            @elseif($guia_remision->tipo_transporte==1)
                                            <td>Trasporte Publico</td>
                                            @else
                                            <td>Trasporte Privado</td>
                                            @endif
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
<!-- Modal para Guia de Remision  -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviando Guias a Sunat</h5>
            </div>
            <div class="modal-body">
                <div id="msg_remision_el">
                    {{-- Contenido del ajax --}}
                </div>
            </div>
            <div class="modal-footer" style="display: none;">
                <div class="row">
                    <div class="col-sm-6" >
                        *En caso de algún error al enviar la Guia de Remision, por favor comunicarse de manera inmediata.
                    </div>
                    <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                        <button type="button" class="btn btn-primary" id="cerrar">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para Guia de Remision Manual -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="exampleModal_M">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviando Guias a Sunat</h5>
            </div>
            <div class="modal-body">
                <div id="msg_remision_el_m">
                    {{-- Contenido del ajax --}}
                </div>
            </div>
            <div class="modal-footer" style="display: none;">
                <div class="row">
                    <div class="col-sm-6" >
                        *En caso de algún error al enviar la Guia de Remision Manual,  por favor comunicarse de manera inmediata.
                    </div>
                    <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                        <button type="button" class="btn btn-primary" id="cerrar_m">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ESTILOS --}}
<style type="text/css">
    .table{
        font-size: 13px;
    }
    .a{width: 200px}
    .ibox-content{
        padding: 0px;
        border: none;
    }
    .model-footer{
        > :not(:last-child) { margin-right: .0rem; }
    }
    .guia_m{
        color:black !important;
        text-decoration: underline !important;
    }
    .guia_remi{
        color:blue !important;
        text-decoration: underline !important;
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
        $('#comunicado_modal').modal({backdrop: 'static', keyboard: false});
        $('#comunicado_modal').modal('show');
        
        $('.dataTables-example').DataTable({
            pageLength: 15,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
    function select_all_remision() {
        $('input[class=case]:checkbox').each(function () {
            // console.log($('input[class=check_all]:checkbox:checked'));
            if ($('input[class=check_all_remi]:checkbox:checked').length == 0) {
                // console.log("a");
                $(this).prop("checked", false);
            } else {
                // console.log("b");
                $(this).prop("checked", true);
            }
        });
    }
    function submit_remision_click(repetir,maximo)
    {
        if ( repetir < maximo ){
            var value_check =  $('input[class=case]:checkbox:checked')[repetir].value;
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.guia_remision_elec_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_remision': value_check,
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
                    $('#msg_remision_el').append( data );
                    repetir++;
                    submit_remision_click(repetir, maximo);
                }    
            });
        }else{
            $('.modal-footer').removeAttr( 'style' );
        }
    }
    $('#remision_elec_all').on('click', function(){
        var cant_checks =  $('input[class=case]:checkbox:checked').length;
        console.log(cant_checks)
        // var max_menos = cant_checks -1;
        if(cant_checks == 0){
            console.log("ninguno marcado");
        }else{
            $('#exampleModal').modal({backdrop: 'static', keyboard: false});
            $("#exampleModal").modal("show");
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            submit_remision_click(0,cant_checks);
        }
        
    });
    $('#cerrar').on('click', function(){
        location.reload();
    });
    //* REMISION MANUAL 
    function select_all_remision_m() {
        $('input[class=case_m]:checkbox').each(function () {
            // console.log($('input[class=check_all]:checkbox:checked'));
            if ($('input[class=check_all_remision_m]:checkbox:checked').length == 0) {
                // console.log("a");
                $(this).prop("checked", false);
            } else {
                // console.log("b");
                $(this).prop("checked", true);
            }
        });
    }
    function submit_remision_m_click(repetir,maximo)
    {
        if ( repetir < maximo ){
            var value_check =  $('input[class=case_m]:checkbox:checked')[repetir].value;
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.guia_remision_m_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_remision': value_check,
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
                    $('#msg_remision_el_m').append( data );
                    repetir++;
                    submit_remision_m_click(repetir, maximo);
                }    
            });
        }else{
            $('.modal-footer').removeAttr( 'style' );
        }
    }

    $('#remision_m_elec_all').on('click', function(){
        var cant_checks =  $('input[class=case_m]:checkbox:checked').length;
        console.log(cant_checks)
        // var max_menos = cant_checks -1;
        if(cant_checks == 0){
            console.log("ninguno marcado");
        }else{
            $('#exampleModal_M').modal({backdrop: 'static', keyboard: false});
            $("#exampleModal_M").modal("show");
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            submit_remision_m_click(0,cant_checks);
        }
        
    });
    $('#cerrar_m').on('click', function(){
        location.reload();
    });
</script>
@endsection