@extends('layout')

@section('title', 'Nota Credito Boleta - lista')
@section('breadcrumb', 'Nota Credito Boleta - lista')
@section('breadcrumb2', 'Nota Credito Boleta - lista')
@section('href_accion', route('nota-credito.index'))
@section('value_accion', 'Atras')

@section('content')
 
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist"> 
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Boleta</a></li>
                        <li><a class="nav-link " data-toggle="tab" href="#tab-2">Boleta Manual</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Codigo de Guia</th>
                                                <th>Cliente</th>
                                                <th>Ruc/DNI</th>
                                                <th>Fecha emision</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($boletas as $boleta)
                                            <tr class="gradeX">
                                                <td>{{$boleta->id}}</td>
                                                <td>{{$boleta->codigo_boleta}}</td>
                                                <td>{{$boleta->cliente->nombre}}</td>
                                                <td>{{$boleta->cliente->numero_documento}}</td>
                                                <td>{{$boleta->fecha_emision}}</td>
                                                <td>
                                                    <form method="POST" action="{{route('nota-credito.motivo')}}">
                                                      @csrf
                                                      <input type="hidden" name="boleta_id" value="{{$boleta->id}}">
                                                      <button type="submit" class="btn btn-sm btn-primary">Aplicar</button>
                                                    </form>
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
                                                <th>ID</th>
                                                <th>Codigo de Guia</th>
                                                <th>Cliente</th>
                                                <th>Ruc/DNI</th>
                                                <th>Fecha emision</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($boletas_manuales as $boletas_manuale)
                                            <tr class="gradeX">
                                                <td>{{$boletas_manuale->id}}</td>
                                                <td>{{$boletas_manuale->codigo_boleta}}</td>
                                                <td>{{$boletas_manuale->cliente->nombre}}</td>
                                                <td>{{$boletas_manuale->cliente->numero_documento}}</td>
                                                <td>{{$boletas_manuale->fecha_emision}}</td>
                                                <td>
                                                    <form method="POST" action="{{route('nota-credito.motivo')}}">
                                                      @csrf
                                                      <input type="hidden" name="boleta_manual_id" value="{{$boletas_manuale->id}}">
                                                      <button type="submit" class="btn btn-sm btn-primary">Aplicar</button>
                                                    </form>
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

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []

        });

    });

</script>
@endsection
