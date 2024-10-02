 @extends('layout')

 @section('title', 'Tiempo de Validez')
 @section('data-toggle', 'modal')
 @section('href_accion', '#exampleModal')
 @section('value_accion', 'Agregar')
 @section('button2', 'Atras')
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




<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>








<!-- Modal Create  -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('validez.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                        @csrf
                        <div>
                            <div class="panel-body" >
                                <div class="row">
                                    <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/validez.png')}}" width="100px"></div>
                                    <label class="col-sm-2 col-form-label">Descripcion:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="descripcion" required  autocomplete="off">
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
                                    <th>Item</th>
                                    <th>Descripcion</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <span hidden="hidden">{{$i=1}}</span>
                                @foreach($validez as $validezz)
                                <tr class="gradeX">
                                    <td>@if($validezz->estado==0) <i class="fa fa-circle" style="color: green;"></i>@else
                                    <i class="fa fa-circle"></i>@endif {{$i++}}</td>
                                    {{-- <td>{{$validezz->id}}</td> --}}
                                    <td>{{$validezz->descripcion}}</td>
                                    <td align="center">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$validezz->id}}"><i class="fa fa-edit"></i></button>
                                        <div class="modal fade" id="exampleModal{{$validezz->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        {{-- ccccccccccccccccc --}}
                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                            <form action="{{ route('validez.update',$validezz->id) }}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <fieldset >
                                                                    <div>
                                                                        <div class="panel-body" >

                                                                            <div class="row">
                                                                                <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/validez.png')}}" width="100px"></div>
                                                                             <label class="col-sm-2 col-form-label">Descripcion:</label>
                                                                             <div class="col-sm-10">
                                                                                <input type="text" required class="form-control" name="descripcion" value="{{$validezz->descripcion}}">
                                                                            </div>
                                                                            @if($conteo > 1 || $validezz->estado==1 )
                                                                            <div class="col-sm-12" align="center" style="padding-top: 10px">
                                                                                <input type="checkbox" class="js-switch_{{$validezz->id}}" name="estado"  @if($validezz->estado==0) checked="" @endif />
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
                                   </div>
                                   <!-- / Modal Create  -->
                               </td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>



                   <!-- --------------------------------------------------------------------------------------------------------------------------------- -->
                   <div class="parent" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-template-rows: repeat(2, 1fr); gap: 80px; align-items: center; text-align: center;">
                       <div class="div1" style="grid-column-start: 1; grid-row-start: 1; color: white; background-color: blue; font-size: 20px; font-weight: bold; width: 60%; height: 180px; padding: 15px;">
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-edit"></i></button>
                           <p>Item 1</p>
                           <p>1 DIA</p>
                           <div style="display: flex; justify-content: center">
                               <div style="width: 80%; border-bottom: 1px solid white; height: 1px;"></div>
                           </div>
                           <div class="form-check form-switch">
                               <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                               <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                           </div>
                       </div>
                       <div class="div2" style="grid-column-start: 2; grid-row-start: 1; color: white; background-color: blue; font-size: 20px; font-weight: bold;  width: 60%; height: 180px; padding: 15px;">
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-edit"></i></button>
                           <p>Item 2</p>
                           <p>7 DIAS</p>
                           <div style="display: flex; justify-content: center">
                               <div style="width: 80%; border-bottom: 1px solid white; height: 1px;"></div>
                           </div>
                           <div class="form-check form-switch">
                               <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                               <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                           </div>
                       </div>
                       <div class="div3" style="grid-column-start: 3; grid-row-start: 1; color: white; background-color: blue; font-size: 20px; font-weight: bold;  width: 60%; height: 180px; padding: 15px;">
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-edit"></i></button>
                           <p>Item 3</p>
                           <p>15 DIAS</p>
                           <div style="display: flex; justify-content: center">
                               <div style="width: 80%; border-bottom: 1px solid white; height: 1px;"></div>
                           </div>
                           <div class="form-check form-switch">
                               <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                               <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                           </div>
                       </div>
                       <div class="div4" style="grid-column-start: 1; grid-row-start: 2; color: white; background-color: blue; font-size: 20px; font-weight: bold;  width: 60%; height: 180px; padding: 15px;">
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-edit"></i></button>
                           <p>Item 4</p>
                           <p>6 MESES</p>
                           <div style="display: flex; justify-content: center">
                               <div style="width: 80%; border-bottom: 1px solid white; height: 1px;"></div>
                           </div>
                           <div class="form-check form-switch">
                               <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                               <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                           </div>
                       </div>
                       <div class="div5" style="grid-column-start: 2; grid-row-start: 2; color: white; background-color: blue; font-size: 20px; font-weight: bold;  width: 60%; height: 180px; padding: 15px;">
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-edit"></i></button>
                           <p>Item 5</p>
                           <p>1 AÑO</p>
                           <div style="display: flex; justify-content: center">
                               <div style="width: 80%; border-bottom: 1px solid white; height: 1px;"></div>
                           </div>
                           <div class="form-check form-switch">
                               <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                               <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                           </div>
                       </div>
                       <div class="div6" style="grid-row-start: 2; color: white; background-color: blue; font-size: 20px; font-weight: bold; width: 60%; height: 180px; padding: 15px;">
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-edit"></i></button>
                           <p>Item 6</p>
                           <p>3 AÑOS</p>
                           <div style="display: flex; justify-content: center">
                               <div style="width: 80%; border-bottom: 1px solid white; height: 1px;"></div>
                           </div>
                           <div class="form-check form-switch">
                               <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                               <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                           </div>
                       </div>
                   </div>
                   <!-- --------------------------------------------------------------------------------------------------------------------------------- -->


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
@foreach($validez as $validezz)
<script>
    var elem_2 = document.querySelector('.js-switch_{{$validezz->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach
@foreach($validez as $validezz)
<script>
    var elem_2 = document.querySelector('.js-switch_vehiculo{{$validezz->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach
@endsection


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
