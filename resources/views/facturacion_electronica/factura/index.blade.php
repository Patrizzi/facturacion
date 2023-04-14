@extends('layout')
@section('title', 'Facturacion Electronica')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                @if(Session::has('successMsg'))
                <div class="alert alert-success">
                    <a class="alert-link" href="#">{{ session('successMsg') }}</a>
                </div>
                @endif
                {{-- MENSAJE DEL AJAX PARA LAS FACTURAS INDIVIDUALES --}}
                <div id="msg_individual" class="">

                </div>
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active show" data-toggle="tab" href="#tab-1">Facturas</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Enviados</a></li>
                        <li><a class="nav-link" style="color:#0a0a0a;" data-toggle="tab" href="#tab-3">Facturacion Manual</a></li>
                        <li><a class="nav-link" style="color:#0a0a0a;" data-toggle="tab" href="#tab-4">Enviados</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- Mod1 -->
                        <div role="tabpanel" id="tab-1" class="tab-pane active show">
                            <div class="panel-body">
                                <div class="table-responsive" id="ibox1">
                                    <div class="ibox-content">
                                        <div class="sk-spinner sk-spinner-double-bounce">
                                            <div class="sk-double-bounce1"></div>
                                            <div class="sk-double-bounce2"></div>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover dataTables-example ibox-content">
                                            <thead>
                                                <tr>
                                                    {{-- Seleccion all --}}
                                                    <th><input class='check_all' type='checkbox' onclick="select_all_fact()" /></th>
                                                    <th>Item</th>
                                                    <th>Codigo</th>
                                                    <th>Cliente</th>
                                                    <th>N°Documento</th>
                                                    <th>Fecha Vencimiento</th>
                                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                </tr>
                                            </thead>
                                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                            <tbody>
                                                <span hidden>{{$a=1}}</span>
                                                @foreach($facturacion as $facturaciones)
                                                <tr class="gradeX" >
                                                    <td><input type='checkbox' class='case' value="{{$facturaciones->codigo_fac}}" /></td>
                                                    <td>{{$a++}}</td>
                                                    <td>{{$facturaciones->codigo_fac}}</td>
                                                    @if(isset($facturaciones->cliente_id))
                                                    <td>{{$facturaciones->cliente->nombre}}</td>
                                                    <td>{{$facturaciones->cliente->numero_documento}}</td>
                                                    @else
                                                    <td>{{$facturaciones->cotizacion->cliente->nombre}}</td>
                                                    <td>{{$facturaciones->cotizacion->cliente->numero_documento}}</td>
                                                    @endif
                                                    <td>{{$facturaciones->fecha_vencimiento }}</td>
                                                    <td>
                                                        <center>
                                                            {{-- <form action="{{route('facturacion_electronica.factura_elec_all')}}" method="POST">@csrf --}}
                                                                {{-- <input type="hidden" name="codigo_fac" value="{{$facturaciones->codigo_fac}}"> --}}
                                                                <button type="button" class="btn btn-success btn-circle btn-ls factura_ind" id="factura_ind" value="{{$facturaciones->codigo_fac}}" onclick="envio_factura(this)"><i class="fa fa-cloud-upload" ></i></button>
                                                            {{-- </form> --}}
                                                        </center>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfooter >
                                                <td colspan="6" align="right" style="padding-right: 2em"></td>
                                                <td align="center"><button type="button" class="btn btn-primary" id="fac_elec_all">Enviar</button></td>
                                            </tfooter>
                                        </table> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Mod1 -->

                        <!-- Mod2 FACTURAS ENVIADAS -->
                        <div role="tabpanel" id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr align="center">
                                                <th>Item</th>
                                                <th>Codigo</th>
                                                <th>Cliente</th>
                                                <th>N° Doc</th>
                                                <th>Fecha de Emision</th>
                                                <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                <th>XML</th>
                                                <th>ZIP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span hidden>{{$a=1}}</span>
                                            @foreach($facturacion_enviada as $facturaciones)
                                            <tr class="gradeX">
                                                <td>{{$a++}}</td>
                                                <td>{{$facturaciones->codigo_fac}}</td>

                                                @if(isset($facturaciones->cliente_id)) <!-- Nombre del cliente -->
                                                <td>{{$facturaciones->cliente->nombre}}</td>
                                                <td>{{$facturaciones->cliente->numero_documento}}</td>
                                                @else
                                                <td>{{$facturaciones->cotizacion->cliente->nombre}}</td>
                                                <td>{{$facturaciones->cotizacion->cliente->numero_documento}}</td>
                                                @endif

                                                <td>{{$facturaciones->created_at}}</td>
                                                <td align="center">
                                                    <button type="button" class="btn btn-info btn-circle btn-ls" ><i class="fa fa-check-circle"></i></button>
                                                </td>
                                                <td align="center">
                                                    <a href="{{ asset('facturas_electronicas/')}}/{{$empresa->ruc}}-01-{{$facturaciones->codigo_fac}}.xml" download><img src="{{asset('xml.png')}}" width="25px"></a>
                                                </td>
                                                <td align="center"><a href="{{ asset('facturas_electronicas/')}}/R-{{$empresa->ruc}}-01-{{$facturaciones->codigo_fac}}.zip" download><img src="{{asset('zip.png')}}" width="25px"></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Mod2 -->

                        <!-- Mod3 FACTURA MANUAL-->
                        <div role="tabpanel" id="tab-3" class="tab-pane">
                            <div class="panel-body">
                                <div class="table-responsive" id="ibox2">
                                    <div class="ibox-content">
                                        <div class="sk-spinner sk-spinner-double-bounce">
                                            <div class="sk-double-bounce1"></div>
                                            <div class="sk-double-bounce2"></div>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th><input class='check_all_fac_m' type='checkbox' onclick="select_all_fact_man()" /></th>
                                                    <th>Item</th>
                                                    <th>Codigo</th>
                                                    <th>Cliente</th>
                                                    <th>N°Documento</th>
                                                    <th>Fecha Vencimiento</th>
                                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <span hidden>{{$a=1}}</span>
                                                @foreach($facturacion_m as $facturaciones_m)
                                                <tr class="gradeX">
                                                    <td><input type='checkbox' class='case_m' value="{{$facturaciones_m->codigo_fac}}" /></td>
                                                    <td>{{$a++}}</td>
                                                    <td>{{$facturaciones_m->codigo_fac}}</td>
                                                    @if(isset($facturaciones_m->cliente_id)) <!-- Nombre del cliente -->
                                                    <td>{{$facturaciones_m->cliente->nombre}}</td>
                                                    <td>{{$facturaciones_m->cliente->numero_documento}}</td>
                                                    @else
                                                    <td>{{$facturaciones_m->cotizacion->cliente->nombre}}</td>
                                                    <td>{{$facturaciones_m->cotizacion->cliente->numero_documento}}</td>
                                                    @endif
                                                    <td>{{$facturaciones_m->fecha_vencimiento }}</td>
                                                    <td>
                                                        <center>
                                                        {{-- <form action="{{route('facturacion_electronica.facturacion_m_e')}}" method="POST" enctype="multipart/form-data">@csrf
                                                            <input type="text" style="display: none" value="{{$facturaciones_m->id}}" name="id">
                                                            <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button> --}}
                                                            <button type="button" class="btn btn-success btn-circle btn-ls factura_ind" id="factura_ind" value="{{$facturaciones_m->codigo_fac}}" onclick="envio_factura_manual(this)"><i class="fa fa-cloud-upload" ></i></button>
                                                            {{-- </form> --}}
                                                        </center>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfooter >
                                                <td colspan="6" align="right" style="padding-right: 2em"></td>
                                                <td align="center"><button type="button" class="btn btn-primary" id="fac_m_elec_all">Enviar</button></td>
                                            </tfooter>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Mod3 -->

                        <!-- Mod4 -->
                        <div role="tabpanel" id="tab-4" class="tab-pane">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Codigo</th>
                                                <th>Cliente</th>
                                                <th>N°Documento</th>
                                                <th>Fecha de Emision</th>
                                                <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                                <th>XML</th>
                                                <th>ZIP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span hidden>{{$a=1}}</span>
                                            @foreach($facturacion_enviada_m as $facturaciones_m)
                                            <tr class="gradeX">
                                                <td>{{$a++}}</td>
                                                <td>{{$facturaciones_m->codigo_fac}}</td>
                                                @if(isset($facturaciones_m->cliente_id)) <!-- Nombre del cliente -->
                                                <td>{{$facturaciones_m->cliente->nombre}}</td>
                                                <td>{{$facturaciones_m->cliente->numero_documento}}</td>
                                                @else
                                                <td>{{$facturaciones_m->cotizacion->cliente->nombre}}</td>
                                                <td>{{$facturaciones_m->cotizacion->cliente->numero_documento}}</td>
                                                @endif
                                                <td>{{$facturaciones_m->created_at }}</td>
                                                <td align="center">
                                                    <button type="button" class="btn btn-info btn-circle btn-ls" ><i class="fa fa-check-circle"></i></button>
                                                </td>
                                                <td align="center">
                                                    <a href="{{ asset('facturas_electronicas/')}}/{{$empresa->ruc}}-01-{{$facturaciones_m->codigo_fac}}.xml" download><img src="{{asset('xml.png')}}" width="25px"></a>
                                                </td>
                                                <td align="center">
                                                    <a href="{{ asset('facturas_electronicas/')}}/R-{{$empresa->ruc}}-01-{{$facturaciones_m->codigo_fac}}.zip" download><img src="{{asset('zip.png')}}" width="25px"></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Mod4 -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para Factura  -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviando Facturas a Sunat</h5>
            </div>
            <div class="modal-body">
                <div id="msg_c_bol">
                    {{-- Contenido del ajax --}}
                </div>
            </div>
            <div class="modal-footer" style="display: none;">
                <div class="row">
                    <div class="col-sm-6" >
                        *En caso de algún error al enviar la Factura, por favor comunicarse de manera inmediata.
                    </div>
                    <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                        <button type="button" class="btn btn-primary" id="cerrar_factura">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Factura Manual -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="exampleModalManual">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviando Facturas Manuales a Sunat</h5>
            </div>
            <div class="modal-body">
                <div id="msg_c_fac_m">
                    {{-- Contenido del ajax --}}
                </div>
            </div>
            <div class="modal-footer" style="display: none;">
                <div class="row">
                    <div class="col-sm-6" >
                        *En caso de algún error al enviar la Factura, por favor comunicarse de manera inmediata.
                    </div>
                    <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                        <button type="button" class="btn btn-primary" id="cerrar_factura_m">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

<style>
    .ibox-content{
        padding: 0px;
        border: none;
    }
    .model-footer{
        > :not(:last-child) { margin-right: .0rem; }
    }
</style>
<!-- Page Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 15,
            order: [[0, "desc"]],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [],
            aoColumnDefs : [ { 'bSortable' : false, 'aTargets' : [ 0 ] } ]
        });
    });
    $(function () {
        $('[data-toggle="popover"]').popover()
    })

    function toggle(){
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    }
</script>
<script>
    //FUNCIONES PARA FACTURA NORMAL
        //FACTURAS INDIVIVUALES
    function inv_close(){
        $(document).ready(function(){
            $("#myAlert").bind('closed.bs.alert', function(){
                location.reload();
            })
        });  
        $('[data-toggle="popover"]').popover();
        const myTimeout = setTimeout(click, 5000);
    }

    function click(){
        console.log("click");
        $('[data-toggle="popover"]').popover();
        $('#cerrar_popup').trigger('click');
    }
    function envio_factura(codigo){
        // console.log(codigo.val());
        $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
        $('.nav-link').addClass('disabled');
        var value_check =  codigo.value;
        console.log(value_check);
        $.ajax({
            type: "post",
            url: "{{ route('facturacion_electronica.factura_elec_all') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'codigo_fac': value_check,
            },
            success: function (response) {
                var salt = response.replace(/(\r\n|\n|\r)/gm, "") 
                var result = salt.substr(0,13);
                // console.log(result);
                if(result  == "Codigo Error:"){
                    var data = `
                        <div id="myAlert" class="alert alert-danger"> 
                            <a href="#" class="close" data-dismiss="alert"  data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">&times;</a> 
                            <span class="alert-link" id="`+value_check+`">Error N°  `+value_check+' <br> '+response+`</span>
                        </div>
                    `;
                }else{
                    var data = `
                        <div id="myAlert" class=" alert alert-success" > 
                            <a id="cerrar_popup" class="close"  data-container="body" data-trigger="click" data-toggle="popover"  data-placement="bottom" data-content="Haga click para cerrar esta notificación." style="color:#d4edda;width: 0">&times;</a>
                            <a class="close" data-dismiss="alert">&times;</a>
                            <span class="alert-link" id="`+value_check+`">`+response+`</span>
                        </div>
                    `;
                }
                revision(value_check, response, 'factura');
                inv_close();
                $('#msg_individual').append( data );
                $("#success-alert").show();
            }    
        });
    }
    
    function envio_factura_manual(codigo){
        // console.log(codigo.val());
        $('#ibox2').children('.ibox-content').toggleClass('sk-loading');
        $('.nav-link').addClass('disabled');
        var value_check =  codigo.value;
        console.log(value_check);
        $.ajax({
            type: "post",
            url: "{{ route('facturacion_electronica.fac_elec_man_all') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'codigo_fac': value_check,
            },
            success: function (response) {
                var salt = response.replace(/(\r\n|\n|\r)/gm, "") 
                var result = salt.substr(0,13);
                // console.log(result);
                if(result  == "Codigo Error:"){
                    var data = `
                        <div id="myAlert" class="alert alert-danger"> 
                            <a href="#" class="close" data-dismiss="alert"  data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">&times;</a> 
                            <span class="alert-link" id="`+value_check+`">Error N°  `+value_check+' <br> '+response+`</span>
                        </div>
                    `;
                }else{
                    var data = `
                        <div id="myAlert" class=" alert alert-success" > 
                            <a id="cerrar_popup" class="close"  data-container="body" data-trigger="click" data-toggle="popover"  data-placement="bottom" data-content="Haga click para cerrar esta notificación." style="color:#d4edda;width: 0">&times;</a>
                            <a class="close" data-dismiss="alert">&times;</a>
                            <span class="alert-link" id="`+value_check+`">`+response+`</span>
                        </div>
                    `;
                }
                revision(value_check, response, 'factura_manual');
                inv_close();
                $('#msg_individual').append( data );
                $("#success-alert").show();
            }    
        });
    }
    //  FUNCION PARASELECCION MUILTIPLE 
    function select_all_fact() {
        $('input[class=case]:checkbox').each(function () {
            // console.log($('input[class=check_all]:checkbox:checked'));
            if ($('input[class=check_all]:checkbox:checked').length == 0) {
                // console.log("a");
                $(this).prop("checked", false);
            } else {
                // console.log("b");
                $(this).prop("checked", true);
            }
        });
    }
        //Facturas masivas
    function submit_factura_click(repetir,maximo)
    {
        if ( repetir < maximo ){
            var value_check =  $('input[class=case]:checkbox:checked')[repetir].value;
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.factura_elec_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_fac': value_check,
                },
                success: function (response) {
                    var salt = response. replace(/(\r\n|\n|\r)/gm, "") 
                    var result = salt.substr(0,13);
                    // console.log(result);
                    if(result  == "Codigo Error:"){
                        var data = `
                            <div class="alert alert-danger">
                                <a class="alert-link" href="#" id="`+value_check+`">Error N°  `+value_check+' <br> '+response+`</a>
                            </div>`;
                    }else{
                        var data = `
                            <div class="alert alert-success">
                                <a class="alert-link" href="#" id="`+value_check+`">`+response+`</a>
                            </div>`;
                    }
                    revision(value_check, response, 'factura');
                    $('#msg_c_bol').append( data );
                    repetir++;
                    submit_factura_click(repetir, maximo);
                }    
            });
        }else{
            $('.modal-footer').removeAttr( 'style' );
        }
    }
    
    $('#fac_elec_all').on('click', function(){
        var cant_checks =  $('input[class=case]:checkbox:checked').length;
        console.log(cant_checks)
        // var max_menos = cant_checks -1;
        if(cant_checks == 0){
            console.log("ninguno marcado");
        }else{
            $('#exampleModal').modal({backdrop: 'static', keyboard: false});
            $("#exampleModal").modal("show");
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            submit_factura_click(0,cant_checks);
        }
    });

    $('#cerrar_factura').on('click', function(){
        location.reload();
    });
    
    function revision(codigo, msg, tipo){
        $.ajax({
            type: "post",
            url: "{{ route('facturacion_electronica.validacion_sunat') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'tipo': tipo,
                'codigo_fac': codigo,
                'msg': msg,
            },
            success: function (response) {
                // console.log(response);
                var data2 = `<p style="margin-bottom: 0px">`+response+`</p>`
                $(`#`+codigo+``).append( data2 );
            }    
        });
    }
    //

    //FUNCIONES PARA FACTURA MANUAL
    function select_all_fact_man() {
        $('input[class=case_m]:checkbox').each(function () {
            // console.log($('input[class=check_all]:checkbox:checked'));
            if ($('input[class=check_all_fac_m]:checkbox:checked').length == 0) {
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
            var value_check =  $('input[class=case_m]:checkbox:checked')[repetir].value;
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.fac_elec_man_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_fac': value_check,
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
                    revision(value_check, response, 'factura_manual');
                    $('#msg_c_fac_m').append( data );
                    repetir++;
                    submit_factura_manual_click(repetir, maximo);
                }    
            });
        }else{
            $('.modal-footer').removeAttr( 'style' );
        }
    }
    $('#fac_m_elec_all').on('click', function(){
        var cant_checks =  $('input[class=case_m]:checkbox:checked').length;
        console.log(cant_checks)
        // var max_menos = cant_checks -1;
        if(cant_checks == 0){
            console.log("ninguno marcado");
        }else{
            $('#exampleModalManual').modal({backdrop: 'static', keyboard: false});
            $("#exampleModalManual").modal("show");
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            submit_factura_manual_click(0,cant_checks);
        }
        
    });
    $('#cerrar_factura_m').on('click', function(){
        location.reload();
    });
    // Mensaje para que cierre x
</script>


@endsection
