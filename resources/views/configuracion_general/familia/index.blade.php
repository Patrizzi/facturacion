@extends('layout')

@section('title', 'Familia')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('button2', 'Atras')
@section('config',route('Configuracion'))

 @section('content')
    <!--
    @if($errors->any())
    <div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
        <a class="alert-link" href="#">
            @foreach ($errors->all() as $error)
            <li class="error" style="color: red">{{ $error }}</li>
            @endforeach
        </a>
    </div>
    @endif-->
    <!-- Modal Create--><!--
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div style="padding-left: 15px;padding-right: 15px;">
                    {{-- ccccccccccccccccc --}}
                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                        <form action="{{ route('familia.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                            @csrf
                            <div>
                                <div class="panel-body" >
                                    <div class="row">
                                        <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/familia.svg')}}" width="100px"></div>
                                        <label class="col-sm-2 col-form-label">Descripcion:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="descripcion" required>
                                        </div>
                                        <br>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <button class="ladda-button btn btn-primary" type="submit" id="boton"> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <!-- / Modal Create--><!--
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>codigo</th>
                                        <th>Descripcion</th>
                                        <th>Ubicacion</th>
                                        <th>Ver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <span hidden="hidden">{{$i=1}}</span>
                                    @foreach($familias as $familia)
                                    <tr class="gradeX">
                                        <td>
                                            @if($familia->estado==0)
                                                <i class="fa fa-circle" style="color: green;"></i>
                                            @else
                                                <i class="fa fa-circle"></i>
                                            @endif
                                            {{$i++}}
                                        </td>
                                        {{-- <td>{{$familia->id}}</td> --}}
                                        <td>{{$familia->codigo}}</td>
                                        <td>{{$familia->descripcion}}</td>
                                        <td>
                                            @if($familia->ubicacion != null)
                                                {{$familia->ubicacion}}
                                            @else
                                                Sin Ubicacion
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$familia->id}}"><i class="fa fa-edit"></i></button> --}}
                                            <a href="{{route('familia.show',$familia->id)}}">
                                                <button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button>
                                            </a>

                                            {{-- <div class="modal fade" id="exampleModal{{$familia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div style="padding-left: 15px;padding-right: 15px;">
                                                            <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                                                                <form action="{{ route('familia.update',$familia->id) }}"  enctype="multipart/form-data" method="post">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <fieldset >
                                                                        <div>
                                                                            <div class="panel-body" >
                                                                                <div class="row">
                                                                                <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/familia.svg')}}" width="100px"></div>
                                                                                    <label class="col-sm-2 col-form-label">Descripcion:</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" required class="form-control" name="descripcion" value="{{$familia->descripcion}}">
                                                                                    </div>
                                                                                    @if($conteo > 1 || $familia->estado==1 )
                                                                                        <div class="col-sm-12" align="center" style="padding-top: 10px">
                                                                                        <input type="checkbox" class="js-switch_{{$familia->id}}" name="estado"  @if($familia->estado==0) checked=""    @endif />
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                    <button class="ladda-button btn btn-primary" type="submit">Guardar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  --}}-->
                                            <!-- / Modal Create--><!--
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
    <style>
        .col-sm-10{padding-bottom: 5px;padding-top: 5px;}
        .form-control{border-radius: 5px}
    </style>-->


<!-- Inicio código - Gaby -->
    <div class="wrapper wrapper-content animated fadeInRight pb-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <!-- Acá iria el titulo -->
                        <h4>Familias</h4>
                    </div>
                    <div class="ibox-content align-content-center">
                        <div class="row d-flex justify-content-around px-4 text-center">

                            <div class="col-auto">
                                <div class="border border-primary rounded-circle d-flex justify-content-center align-items-center circle-size">
                                    <p class="m-0 p-4" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                                </div><br>
                                <h4> Activas </h4>
                                <p>4 documentos</p>
                                <p class="text-danger"><b>Total</b></p>
                            </div>
                            <div class="col-auto">
                                <div class="border border-success rounded-circle d-flex justify-content-center align-items-center circle-size">
                                    <p class="m-0 p-4" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                                </div><br>
                                <h4> Inactivas </h4>
                                <p>4 documentos</p>
                                <p class="text-danger"><b>Total</b></p>
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
                                    <a class="nav-link active show" data-toggle="tab" href="#tab-1"><span style="color: white; background-color: blue;" class="px-1">4</span> Activas

                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" data-toggle="tab" href="#tab-2"><span style="color: white; background-color: green;" class="px-1">4</span> Inactivas

                                    </a>
                                </li>
                            </ul>

                            <!-- Buscar y Agregar -->
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
                                    <div class="col-md-2 d-flex justify-content-end align-content-center align-items-md-center">
                                        <a data-toggle="modal" class="btn btn-primary btn-sm ms-5" href="#modal-form"><i class="fa fa-plus"></i></a>
                                        <div id="modal-form" class="modal fade align-content-center" style="display: none;" aria-modal="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <!--Contenido de modal-->
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="ibox collapsed border-bottom">
                                                                    <div class="ibox-title">
                                                                        <h3><i class="fa fa-user-circle-o" aria-hidden="true"></i>  AGREGAR FAMILIA</h3>

                                                                    </div>
                                                                    <!--Contenido-->
                                                                    <div class="ibox-content px-2" style="display: block;">
                                                                        <div class="form-group row my-lg-3">
                                                                            <div class="col-lg-12">
                                                                                <input type="text" placeholder="Descripción:" class="form-control pb-4 m-b ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row d-flex justify-content-between">
                                                                            <div class="col-md-6">
                                                                                <input type="text" placeholder="Padre:" class="form-control pb-4 m-b">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <input type="text" placeholder="Ubicación:" class="form-control pb-4 m-b">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row d-flex justify-content-between mt-lg-3">
                                                                            <div class="col-md-6">
                                                                                <input type="text" placeholder="Código:" class="form-control pb-4 m-b">
                                                                            </div>
                                                                            <div class="col-md-6 ">
                                                                                <button type="button" class="btn btn-block btn-success py-3"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Guardar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Tablas y su contenido -->
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                    <div class="panel-body table-responsive">
                                        <!-- CONTENIDO DENTRO DEL TAB - Boleta manual -->
                                        <table class="table table-striped text-md-center">
                                            <thead>
                                                <tr>
                                                    <!--<th><input type="checkbox" checked class="i-checks" name="input[]"></th>-->
                                                    <th>ID</th>
                                                    <th>Código</th>
                                                    <th>Descripción</th>
                                                    <th>Padre</th>
                                                    <th>Ubicación</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                    <td>1</td>
                                                    <td>001</td>
                                                    <td>Tablets</td>
                                                    <td>Tecnología</td>
                                                    <td>1A</td>
                                                    <td>
                                                        <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                        <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                    <td>2</td>
                                                    <td>002</td>
                                                    <td>Deportiva</td>
                                                    <td>Ropa</td>
                                                    <td>1A</td>
                                                    <td>
                                                        <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                        <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                    <td>3</td>
                                                    <td>003</td>
                                                    <td>Mouses</td>
                                                    <td>Periféricos</td>
                                                    <td>3A</td>
                                                    <td>
                                                        <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                        <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                    <td>4</td>
                                                    <td>004</td>
                                                    <td>Teclados</td>
                                                    <td>Periféricos</td>
                                                    <td>2B</td>
                                                    <td>
                                                        <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                        <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body table-responsive">
                                        <!-- CONTENIDO DENTRO DEL TAB  2 - Factura manual -->
                                        <table class="table table-striped text-md-center">
                                            <thead>
                                                <tr>
                                                    <!--<th><input type="checkbox" checked class="i-checks" name="input[]"></th>-->
                                                    <th>ID</th>
                                                    <th>Código</th>
                                                    <th>Descripción</th>
                                                    <th>Padre</th>
                                                    <th>Ubicación</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                    <td>5</td>
                                                    <td>001</td>
                                                    <td>Deportiva</td>
                                                    <td>Ropa</td>
                                                    <td>1A</td>
                                                    <td>
                                                        <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                        <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                    <td>8</td>
                                                    <td>002</td>
                                                    <td>Deportiva</td>
                                                    <td>Ropa</td>
                                                    <td>1A</td>
                                                    <td>
                                                        <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                        <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                    <td>3</td>
                                                    <td>003</td>
                                                    <td>Deportiva</td>
                                                    <td>Ropa</td>
                                                    <td>3A</td>
                                                    <td>
                                                        <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                        <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                    <td>4</td>
                                                    <td>004</td>
                                                    <td>Deportiva</td>
                                                    <td>Ropa</td>
                                                    <td>2B</td>
                                                    <td>
                                                        <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                        <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

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
            min-height: 100px;
            min-width: 100px;
        }
    </style>


<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
<!-- Switchery -->
<script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>

{{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
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
{{-- @foreach($familias as $familia)
<script>
    var elem_2 = document.querySelector('.js-switch_{{$familia->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach
@foreach($familias as $familia)
<script>
    var elem_2 = document.querySelector('.js-switch_vehiculo{{$familia->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach --}}
@endsection
