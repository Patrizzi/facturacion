@extends('layout')
@section('title', 'Cotizacion Manual')
@section('atributo_actu', 'hidden')
@section('href_accion', route('manual.create'))
@section('value_accion', 'Agregar')
@section('content')

@if($errors->any())
<div style="padding-top: 20px;">
    <div class="alert alert-danger">
        <a class="alert-link" href="#">
            @foreach ($errors->all() as $error)
            <li style="color: red">{{ $error }}</li>
            @endforeach
        </a>
    </div>
</div>
@endif

{{-- obtener errores --}}
@if (Session::has('successMsg'))
<div style="padding-top: 20px;">
    <div class="alert alert-warning">
        <a class="alert-link" href="#">
            <li style="color: black">{{ Session::get('successMsg') }}</li>
        </a>
    </div>
</div>
@endif
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Codigo de Cotizacion</th>
                                    <th>Cliente</th>
                                    <th>N°Documento</th>
                                    <th>Fecha </th>
                                    <th>Ver</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($cotizacion as $cotizaciones)
                                <tr class="gradeX">
                                    <td>{{$cotizaciones->id}}</td>
                                    <td>{{$cotizaciones->cod_cotizacion}}</td>
                                    <td>{{$cotizaciones->cliente->nombre}}</td>
                                    <td>{{$cotizaciones->cliente->numero_documento}}</td>
                                    <td>{{$cotizaciones->fecha_emision }}</td>
                                    {{-- Ver --}}
                                    <td align="center">
                                        <a href="{{route('manual.show',$cotizaciones->id)}}">
                                            <button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button>
                                        </a>
                                    </td>
                                    {{-- Envio a Sunat --}}
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