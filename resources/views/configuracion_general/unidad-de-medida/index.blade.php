@extends('layout')

@section('title', 'Unidad de Medida')
@section('breadcrumb', 'Unidad de Medida')
@section('breadcrumb2', 'Unidad de Medida')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('button2', 'Inicio')
@section('config',route('Configuracion'))

@section('content')
<div class="wrapper wrapper-content animated fadeInRight align-content-center">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox"><!--
                <div class="ibox-title">
                     Input seleccionar fecha inicio y fin, y Botón agregar y Descargar
                    <div class="py-2 d-flex align-items-center row-cols-12">
                        <div class="col-md-7 d-flex justify-content-md-start row-cols-12 py-2 me-5">
                            <div class="col-md-auto">
                                <label for="inputBuscar" class="col-form-label">Buscar:</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                            </div>
                        </div>

                        <div class="col-md-5 d-flex justify-content-end ms-4">
                            <div class="btn-group">
                                <button data-toggle="dropdown" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>
                                <ul class="dropdown-menu">
                                    <p class="pl-3"><b>Almacenes:</b></p>
                                    <li><a class="dropdown-item" href="#">Oficina Arequipa</a></li>
                                    <li><a class="dropdown-item" href="#">Galería Centro Lima</a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button data-toggle="dropdown" type="button" class="btn btn-primary btn-sm mx-3"><i class="fa fa-cloud-download"></i></button>
                                <ul class="dropdown-menu p-1">
                                    <li><a class="dropdown-item" href="#">PDF</a></li>
                                    <li><a class="dropdown-item" href="#">Excel</a></li>
                                    <li><a class="dropdown-item" href="#">Word</a></li>
                                    <li><a class="dropdown-item" href="#">CSV</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>-->
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="align-content-center">
                                <div class="col-md-12 d-flex justify-content-md-start row-cols-12 py-2 me-5">
                                    <div class="col-md-auto">
                                        <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                </div>
                            </li>
                            <li class="ml-auto align-content-center">
                                <div class="btn-group">
                                    <button data-toggle="dropdown" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>
                                    <ul class="dropdown-menu p-2">
                                        <p class="pl-3"><b>Almacenes:</b></p>
                                        <li><a class="dropdown-item" href="#">Oficina Arequipa</a></li>
                                        <li><a class="dropdown-item" href="#">Galería Centro Lima</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="align-content-center">
                                <div class="btn-group">
                                    <button data-toggle="dropdown" type="button" class="btn btn-primary btn-sm mx-3"><i class="fa fa-cloud-download"></i></button>
                                    <ul class="dropdown-menu p-1">
                                        <li><a class="dropdown-item" href="#">PDF</a></li>
                                        <li><a class="dropdown-item" href="#">Excel</a></li>
                                        <li><a class="dropdown-item" href="#">Word</a></li>
                                        <li><a class="dropdown-item" href="#">CSV</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>


                        <!-- Tablas y su contenido -->
                        <div class="tab-content">

                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB - Boleta manual -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" checked class="i-checks" name="input[]"></th>
                                                <th>ID</th>
                                                <th>Símbolo</th>
                                                <th>Medida</th>
                                                <th>Unidad</th>
                                                <th>Fecha Creación</th>
                                                <th>Fecha Actualización</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>1</td>
                                                <td>BOL</td>
                                                <td>Bolsa</td>
                                                <td>12.00</td>
                                                <td>Abril 25, 1987</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="" class="fs-5"><i class="fa fa-edit text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>2</td>
                                                <td>BOL</td>
                                                <td>Bolsa</td>
                                                <td>12.00</td>
                                                <td>Abril 25, 1987</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="" class="fs-5"><i class="fa fa-edit text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>3</td>
                                                <td>BOL</td>
                                                <td>Bolsa</td>
                                                <td>12.00</td>
                                                <td>Abril 25, 1987</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="" class="fs-5"><i class="fa fa-edit text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>4</td>
                                                <td>BOL</td>
                                                <td>Bolsa</td>
                                                <td>12.00</td>
                                                <td>Abril 25, 1987</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="" class="fs-5"><i class="fa fa-edit text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>5</td>
                                                <td>BOL</td>
                                                <td>Bolsa</td>
                                                <td>12.00</td>
                                                <td>Abril 25, 1987</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="" class="fs-5"><i class="fa fa-edit text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>6</td>
                                                <td>BOL</td>
                                                <td>Bolsa</td>
                                                <td>12.00</td>
                                                <td>Abril 25, 1987</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="" class="fs-5"><i class="fa fa-edit text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>7</td>
                                                <td>BOL</td>
                                                <td>Bolsa</td>
                                                <td>12.00</td>
                                                <td>Abril 25, 1987</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="" class="fs-5"><i class="fa fa-edit text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>8</td>
                                                <td>BOL</td>
                                                <td>Bolsa</td>
                                                <td>12.00</td>
                                                <td>Abril 25, 1987</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="" class="fs-5"><i class="fa fa-edit text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>9</td>
                                                <td>BOL</td>
                                                <td>Bolsa</td>
                                                <td>12.00</td>
                                                <td>Abril 25, 1987</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="" class="fs-5"><i class="fa fa-edit text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>10</td>
                                                <td>BOL</td>
                                                <td>Bolsa</td>
                                                <td>12.00</td>
                                                <td>Abril 25, 1987</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="" class="fs-5"><i class="fa fa-edit text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>11</td>
                                                <td>BOL</td>
                                                <td>Bolsa</td>
                                                <td>12.00</td>
                                                <td>Abril 25, 1987</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="" class="fs-5"><i class="fa fa-edit text-navy"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <!--
                            <div role="tabpanel" id="tab-2" class="tab-pane active show">
                                <div class="panel-body table-responsive">
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" checked class="i-checks" name="input[]"></th>
                                                <th>ID</th>
                                                <th>Símbolo</th>
                                                <th>Medida</th>
                                                <th>Unidad</th>
                                                <th>Fecha Creación</th>
                                                <th>Fecha Actualización</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>1</td>
                                                <td>CTO</td>
                                                <td>Ciento</td>
                                                <td>12.00</td>
                                                <td>Febr 09, 1897</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>2</td>
                                                <td>CTO</td>
                                                <td>Ciento</td>
                                                <td>12.00</td>
                                                <td>Febr 09, 1897</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>3</td>
                                                <td>CTO</td>
                                                <td>Ciento</td>
                                                <td>12.00</td>
                                                <td>Febr 09, 1897</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                <td>4</td>
                                                <td>CTO</td>
                                                <td>Ciento</td>
                                                <td>12.00</td>
                                                <td>Febr 09, 1897</td>
                                                <td>Jul 14, 2013</td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            -->

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




<!-- Modal Create

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Unidad de Medida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('unidad-medida.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                        @csrf
                        <fieldset >
                            <div>
                                <div class="panel-body" >
                                    <div class="row">
                                          <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/unidad_medida.svg')}}" width="100px"></div>
                                        <label class="col-sm-2 col-form-label">Simbolo:</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="simbolo">
                                        </div>
                                        <label class="col-sm-2 col-form-label">Medida:</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="medida"  >
                                        </div>
                                        <label class="col-sm-2 col-form-label">Unidad:</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="unidad" placeholder="12.00">
                                        </div>
                                        <div class="col-sm-3">
                                         <button class="btn btn-primary" type="submit" id="boton">Grabar</button>
                                     </div>
                                     <div class="col-sm-2">
                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </fieldset>
                       {{--  <button class="btn btn-primary" type="submit">Grabar</button>
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                   </form>
               </div>
           </div>
       </div>
   </div>
</div>-->
<!-- / Modal Create
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Unidad de Medida</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Simbolo</th>
                                    <th>Medida</th>
                                    <th>Unidad</th>
                                    <th>Fecha Creada</th>
                                    <th>Fecha Actualizada</th>
                                    <th>Edidar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($unidad_de_medida as $u_medida)
                                <tr class="gradeX">
                                    <td>{{$u_medida->id}}</td>
                                    <td>{{$u_medida->simbolo}}</td>
                                    <td>{{$u_medida->medida}}</td>
                                    <td>{{$u_medida->unidad}}</td>
                                    <td>{{$u_medida->created_at}}</td>
                                    <td>{{$u_medida->updated_at}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$u_medida->id}}">Editar</button>
                                        <div class="modal fade" id="exampleModal{{$u_medida->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> Edit Categoría</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        {{-- ccccccccccccccccc --}}
                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                            <form action="{{ route('unidad-medida.update',$u_medida->id) }}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <fieldset >
                                                                    <div>
                                                                       <div class="panel-body" >
                                                                        <div class="row">
                                                                             <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/unidad_medida.svg')}}" width="100px"></div>
                                                                            <label class="col-sm-2 col-form-label">Simbolo:</label>
                                                                            <div class="col-sm-4">
                                                                                <input type="text" class="form-control" name="simbolo" value="{{$u_medida->simbolo}}">
                                                                            </div>
                                                                            <label class="col-sm-2 col-form-label">Medida:</label>
                                                                            <div class="col-sm-4">
                                                                                <input type="text" class="form-control" name="medida" value="{{$u_medida->medida}}"  >
                                                                            </div>
                                                                            <label class="col-sm-2 col-form-label">Unidad:</label>
                                                                            <div class="col-sm-4">
                                                                                <input type="text" class="form-control" name="unidad" value="{{$u_medida->unidad}}" placeholder="12.00">
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                             <button class="btn btn-primary" type="submit">Grabar</button>
                                                                         </div>
                                                                         <div class="col-sm-2">
                                                                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                         </div>
                                                                     </div>
                                                                 </div>

                                                             </fieldset>

                                                         </form>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- / Modal Create
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
</div>-->
<style>
    .form-control{border-radius: 5px;margin-top: 5px;margin-bottom: 5px;}
    .col-sm-2{ margin-top:8px;}
    .col-sm-3{ margin-top:8px;}

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

<!-- iCheck -->
<script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">


<script>
    $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
</script>


<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'ExampleFile'},
            {extend: 'pdf', title: 'ExampleFile'},

            {extend: 'print',
            customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');

                $(win.document.body).find('table')
                .addClass('compact')
                .css('font-size', 'inherit');
            }
        }
        ]

    });

    });

</script>
{{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<script>
    function valida(f) {
        var boton=document.getElementById("boton");
        var completo = true;
        var incompleto = false;
        if( f.elements[0].value == "" )
           { alert(incompleto); }
       else{boton.type = 'button';}
   }
</script>
{{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
@endsection
