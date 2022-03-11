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
                             <div class="table-responsive">
                                 <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
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
                                        @foreach($facturacion as $facturaciones)
                                        <tr class="gradeX">
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
                                                    <form action="{{route('facturacion_electronica.factura_sunat')}}" method="POST">@csrf
                                                        <input type="hidden" name="factura_id" value="{{$facturaciones->id}}">
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
                    <!-- Mod1 -->


                    <!-- Mod2 -->
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div class="panel-body">
                         <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr align="center">
                                        <th>Item</th>
                                        <th>Codigo</th>
                                        <th>Cliente</th>
                                        <th>N°Documento</th>
                                        <th>Fecha Vencimiento</th>
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

                                        <td>{{$facturaciones->fecha_vencimiento }}</td>
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

             <!-- Mod3 -->
             <div role="tabpanel" id="tab-3" class="tab-pane">
                <div class="panel-body">
                 <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
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
                                      <form action="{{route('facturacion_manual.f_e')}}" method="POST" enctype="multipart/form-data">@csrf
                                        <input type="text" style="display: none" value="{{$facturaciones_m->id}}" name="id">
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
                        <th>Fecha Vencimiento</th>
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
                        <td>{{$facturaciones_m->fecha_vencimiento }}</td>
                        <td align="center">
                            <button type="button" class="btn btn-info btn-circle btn-ls" ><i class="fa fa-check-circle"></i></button>
                        </td>
                        <td align="center">
                         <a href="{{ asset('facturas_electronicas/')}}/{{$empresa->ruc}}-01-{{$facturaciones_m->codigo_fac}}.xml" download><img src="{{asset('xml.png')}}" width="25px"></a>
                     </td>
                     <td align="center"><a href="{{ asset('facturas_electronicas/')}}/R-{{$empresa->ruc}}-01-{{$facturaciones_m->codigo_fac}}.zip" download><img src="{{asset('zip.png')}}" width="25px"></a></td>
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
            order: [[0, "desc"]],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>
@endsection
