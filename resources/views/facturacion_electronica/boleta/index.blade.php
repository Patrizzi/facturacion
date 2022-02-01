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
                                   <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Codigo de Boleta</th>
                                            <th>Cliente</th>
                                            <th>Ruc/DNI</th>
                                            <th>Fecha Vencimiento</th>
                                            <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <span hidden>{{$i=1}}</span>
                                        @foreach($boletas as $boleta)
                                        <tr class="gradeX">
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
                                </table>
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

{{-- ESTILOS --}}
<style type="text/css">
    .a{width: 200px}
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
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [ ]
        });
    });
</script>
@endsection
