 @extends('layout')

 @section('title', 'Familia')
 @section('data-toggle', 'modal')
 @section('href_accion', '#exampleModal')
 @section('value_accion', 'Agregar')
 @section('button2', 'Inicio')
 @section('config',route('Configuracion'))

 @section('content')
 @if($errors->any())
 <div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
    <a class="alert-link" href="#">
        @foreach ($errors->all() as $error)
        <li class="error" style="color: red">{{ $error }}</li>
        @endforeach
    </a>
</div>
@endif
<!-- Modal Create  -->
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
</div>
<!-- / Modal Create  -->
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
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($familias as $familia)
                                <tr class="gradeX">
                                    <td>{{$familia->id}}</td>
                                    <td>{{$familia->codigo}}</td>
                                    <td>{{$familia->descripcion}}</td>
                                    @if($familia->estado == 0)
                                    <td style="width: 20%;"><center><label class="label label-primary" style="font-size: 14px">ACTIVADO</label></center></td>
                                    @else
                                    <td style="width: 20%;"><center><label class="label label-danger" style="font-size: 14px">DESACTIVADO</label></center></td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$familia->id}}"><i class="fa fa-edit"></i></button>
                                        <div class="modal fade" id="exampleModal{{$familia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        {{-- ccccccccccccccccc --}}
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
                                                                            <div class="col-sm-12" align="center" style="padding-top: 10px">
                                                                               <input type="checkbox" class="js-switch_{{$familia->id}}" name="estado"  @if($familia->estado==0) checked="" @endif />
                                                                           </div>
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
                                   </div>
                                   <!-- / Modal Create  -->
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
@foreach($familias as $familia)
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
@endforeach
@endsection
