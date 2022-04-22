@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Nota de credito Electronica')
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
                                            <th>Codigo de NC</th>
                                            <th>Cliente</th>
                                            <th>Ruc/DNI</th>
                                            <th>Tipo</th>
                                            <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <span hidden>{{$i=1}}</span>
                                        @foreach($n_creditos as $n_credito)
                                        <tr class="gradeX">
                                            <td>{{$i++}}</td>
                                            @if($n_credito->facturacion_id !=NULL)
                                                <td>{{$n_credito->codigo_n_c}}</td>
                                                <td>{{$n_credito->nota_i_facturacion->cliente->nombre}}</td>
                                                <td>{{$n_credito->nota_i_facturacion->cliente->numero_documento}}</td>
                                            @elseif($n_credito->boleta_id !=NULL)
                                                <td>{{$n_credito->codigo_n_c}}</td>
                                                <td>{{$n_credito->nota_i_boleta->cliente->nombre}}</td>
                                                <td>{{$n_credito->nota_i_boleta->cliente->numero_documento}}</td>
                                            @else
                                                <td>{{$n_credito->codigo_n_c}}</td>
                                                <td>{{$n_credito->nota_i_fac_manual->cliente->nombre}}</td>
                                                <td>{{$n_credito->nota_i_fac_manual->cliente->numero_documento}}</td>
                                            @endif
                                            <td>
                                                @if($n_credito->facturacion_id !=NULL)
                                                    Factura
                                                @elseif($n_credito->boleta_id !=NULL)
                                                    Boleta
                                                @else
                                                    Factura Manual
                                                @endif
                                            </td>
                                            <td>
                                                <center>
                                                    @if($n_credito->facturacion_id !=NULL)
                                                        <form action="{{route('facturacion_electronica.nota_credito')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$n_credito->id}}">
                                                            <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                        </form>
                                                    @elseif($n_credito->boleta_id !=NULL)
                                                        <form action="{{route('facturacion_electronica.nota_credito_bol')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$n_credito->id}}">
                                                            <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                        </form>
                                                    @else
                                                        <form action="{{route('facturacion_electronica.nota_credito')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$n_credito->id}}">
                                                            <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                        </form>
                                                    @endif
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
                                        <th>Codigo de NC</th>
                                        <th>Cliente</th>
                                        <th>Ruc/DNI</th>
                                        <th>Tipo</th>
                                        <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <span hidden>{{$i=1}}</span>
                                    @foreach($n_creditos_enviados as $n_credito_enviado)
                                    <tr class="gradeX">
                                        <td>{{$i++}}</td>
                                        @if($n_credito_enviado->facturacion_id !=NULL)
                                            <td>{{$n_credito_enviado->codigo_n_c}}</td>
                                            <td>{{$n_credito_enviado->nota_i_facturacion->cliente->nombre}}</td>
                                            <td>{{$n_credito_enviado->nota_i_facturacion->cliente->numero_documento}}</td>
                                        @elseif($n_credito_enviado->boleta_id !=NULL)
                                            <td>{{$n_credito_enviado->codigo_n_c}}</td>
                                            <td>{{$n_credito_enviado->nota_i_boleta->cliente->nombre}}</td>
                                            <td>{{$n_credito_enviado->nota_i_boleta->cliente->numero_documento}}</td>
                                            
                                        @else
                                            <td>{{$n_credito_enviado->codigo_n_c}}</td>
                                            <td>{{$n_credito_enviado->nota_i_fac_manual->cliente->nombre}}</td>
                                            <td>{{$n_credito_enviado->nota_i_fac_manual->cliente->numero_documento}}</td>
                                        @endif
                                        <td>
                                            @if($n_credito_enviado->facturacion_id !=NULL)
                                                Factura
                                            @elseif($n_credito_enviado->boleta_id !=NULL)
                                                Boleta
                                            @else
                                                Factura Manual
                                            @endif
                                        </td>
                                        <td>
                                            <center>
                                                <form action="{{route('facturacion_electronica.nota_credito_bol')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="factura_id" value="{{$n_credito_enviado->id}}">
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
            order: [[0, "desc"]],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [ ]
        });
    });
</script>
@endsection
