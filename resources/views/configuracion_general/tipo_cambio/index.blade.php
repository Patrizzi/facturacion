@extends('layout')
@section('title', 'Tipo de cambio')


@if($consulta)
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@else
@section('atributo_actu', 'hidden')
@section('href_accion', route('tipo_cambio.create'))
@section('value_accion', 'Agregar')
@endif


@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    @if(isset($error))
    <div>
      <div class="alert alert-danger">
        <div class="alert-link" href="#">
          <li style="color: red;">{{ $error }}</li>
      </div>
  </div>
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Compra</th>
                                <th>Venta</th>
                                <th>Paralelo</th>
                                <th>Fecha de creacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <span hidden>{{$i=1}}</span>
                            @foreach($tipo_cambio as $tipo_cambios)
                            <tr class="gradeX">
                                <td>{{$i++}}</td>
                                <td>{{$tipo_cambios->compra}}</td>
                                <td>{{$tipo_cambios->venta}}</td>
                                <td>{{$tipo_cambios->paralelo}}</td>
                                <td>{{$tipo_cambios->created_at}}</td>
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
            buttons: [  ]
    });
    });
</script>
@endsection