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

<!--Inicio código - Gaby-->
<div class="wrapper wrapper-content animated fadeInRight pb-0">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <!-- Acá iria el titulo -->
                    <h4>Tipo de Cambio</h4>
                </div>
                <div class="ibox-content align-content-center">
                    <div class="row d-flex justify-content-around px-4 text-center">

                        <div class="col-auto">
                            <div class="border border-primary rounded-circle d-flex justify-content-center align-items-center circle-size">
                                <p class="m-0 p-4" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                            </div><br>
                            <h4>Subida de valor</h4>
                            <p>4 documentos</p>
                            <p class="text-primary"><b>S/***.**</b></p>
                        </div>
                        <div class="col-auto">
                            <div class="border border-success rounded-circle d-flex justify-content-center align-items-center circle-size">
                                <p class="m-0 p-4" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                            </div><br>
                            <h4>Bajada de valor</h4>
                            <p>4 documentos</p>
                            <p class="text-success"><b>S/***.**</b></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Base para agregar el tab para el los contenidos-->

<div class="wrapper wrapper-content animated fadeInRight pt-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-1"><span style="color: white; background-color: blue;" class="px-1">4</span> Subida de valor

                                </a>
                            </li>
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-2"><span style="color: white; background-color: green;" class="px-1">4</span> Bajada de valor

                                </a>
                            </li>
                        </ul>

                        <!-- Buscar y Botón agregar -->
                        <div class="py-2 d-flex align-items-center row-cols-12 pt-4 border-left border-right border-secondary-subtle" style="margin-left: 0.1px; margin-right: 0.1px;">
                            <div class="col-md-7 d-flex justify-content-md-start row-cols-12 py-2">
                                <div class="col-md-auto">
                                    <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                                </div>
                            </div>

                            <div class="col-md-5 d-flex justify-content-end">
                                <div class="col-md-2 d-flex justify-content-end align-content-center align-items-md-center ms-5">
                                    <div class="btn-group">
                                        {{-- <button data-toggle="dropdown" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button> --}}
                                        <a data-toggle="modal" data-toggle="dropdown" class="btn btn-primary btn-sm" href="#modal-form"><i class="fa fa-plus"></i></a>
                                        {{-- modal - agregar Tipo de cambio --}}
                                        <div id="modal-form" class="modal fade" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Agregar</h3>

                                                                <p>Sign in today for more expirience.</p>

                                                                <form role="form">
                                                                    <div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control"></div>
                                                                    <div class="form-group"><label>Password</label> <input type="password" placeholder="Password" class="form-control"></div>
                                                                    <div>
                                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Log in</strong></button>
                                                                        <label> <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> Remember me </label>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="col-sm-6"><h4>Not a member?</h4>
                                                                <p>You can create an account:</p>
                                                                <p class="text-center">
                                                                    <a href=""><i class="fa fa-sign-in big-icon"></i></a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- /modal --}}
                                    </div>
                                </div>
                            </div>

                        </div>


                        <!-- Tablas y su contenido -->
                        <div class="tab-content">

                            <div role="tabpanel" id="tab-1" class="tab-pane">
                                <div class="panel-body table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB - Boleta manual -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <!--<th><input type="checkbox" checked class="i-checks" name="input[]"></th>-->
                                                <th>Item</th>
                                                <th>Mondeda</th>
                                                <th>Compra</th>
                                                <th>Venta</th>
                                                <th>Paralelo C. <i class="fa fa-circle text-danger"></i></th>
                                                <th>Paralelo V.</th>
                                                <th>Fecha Actualización</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>1</td>
                                                <td>Soles</td>
                                                <td>3.74</td>
                                                <td>3.75</td>
                                                <td>3.69</td>
                                                <td>3.75</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" data-toggle="dropdown" class="fs-5" href="#modal-form1"><i class="fa fa-edit text-primary"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>2</td>
                                                <td>Soles</td>
                                                <td>3.74</td>
                                                <td>3.75</td>
                                                <td>3.69</td>
                                                <td>3.75</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" data-toggle="dropdown" class="fs-5" href="#modal-form1"><i class="fa fa-edit text-primary"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>3</td>
                                                <td>Soles</td>
                                                <td>3.74</td>
                                                <td>3.75</td>
                                                <td>3.69</td>
                                                <td>3.75</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" data-toggle="dropdown" class="fs-5" href="#modal-form1"><i class="fa fa-edit text-primary"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>4</td>
                                                <td>Soles</td>
                                                <td>3.74</td>
                                                <td>3.75</td>
                                                <td>3.69</td>
                                                <td>3.75</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" data-toggle="dropdown" class="fs-5" href="#modal-form1"><i class="fa fa-edit text-primary"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane active show">
                                <div class="panel-body table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 - Factura manual -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <!--<th><input type="checkbox" checked class="i-checks" name="input[]"></th>-->
                                                <th>Item</th>
                                                <th>Mondeda</th>
                                                <th>Compra</th>
                                                <th>Venta</th>
                                                <th>Paralelo C. <i class="fa fa-circle text-danger"></i></th>
                                                <th>Paralelo V.</th><!---->
                                                <th>Fecha Actualización</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>1</td>
                                                <td>Dolar</td>
                                                <td>3.74</td>
                                                <td>3.75</td>
                                                <td>3.69</td>
                                                <td>3.75</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" data-toggle="dropdown" class="fs-5" href="#modal-form1"><i class="fa fa-edit text-primary"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>2</td>
                                                <td>Dolar</td>
                                                <td>3.74</td>
                                                <td>3.75</td>
                                                <td>3.69</td>
                                                <td>3.75</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" data-toggle="dropdown" class="fs-5" href="#modal-form1"><i class="fa fa-edit text-primary"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>3</td>
                                                <td>Dolar</td>
                                                <td>3.74</td>
                                                <td>3.75</td>
                                                <td>3.69</td>
                                                <td>3.75</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" data-toggle="dropdown" class="fs-5" href="#modal-form1"><i class="fa fa-edit text-primary"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>4</td>
                                                <td>Dolar</td>
                                                <td>3.74</td>
                                                <td>3.75</td>
                                                <td>3.69</td>
                                                <td>3.75</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a data-toggle="modal" data-toggle="dropdown" class="fs-5" href="#modal-form1"><i class="fa fa-edit text-primary"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- modal - Editar Tipo de cambio --}}
                            <div id="modal-form1" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Editar ---</h3>

                                                    <p>Sign in today for more expirience.</p>

                                                    <form role="form">
                                                        <div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control"></div>
                                                        <div class="form-group"><label>Password</label> <input type="password" placeholder="Password" class="form-control"></div>
                                                        <div>
                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Log in</strong></button>
                                                            <label> <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> Remember me </label>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-sm-6"><h4>Not a member?</h4>
                                                    <p>You can create an account:</p>
                                                    <p class="text-center">
                                                        <a href=""><i class="fa fa-sign-in big-icon"></i></a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- /modal --}}

                        </div>

                        <div class="btn-group btn-group-toggle mt-4" data-toggle="buttons">
                            <label class="btn btn-sm btn-white ">
                                <input type="radio" name="options" id="option1" autocomplete="off" checked> Anterior
                            </label>
                            <label class="btn btn-sm btn-white active">
                                <input type="radio" name="options" id="option2" autocomplete="off"> 1
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option3" autocomplete="off"> 2
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option4" autocomplete="off"> 3
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option5" autocomplete="off"> 4
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option6" autocomplete="off"> Siguiente
                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .circle-size{
        min-height: 105px;
        min-width: 105px;
    }
</style>




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
