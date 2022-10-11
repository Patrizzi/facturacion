@extends('layout')

@section('title', 'Subfamilias')
@section('button2', 'Atras')
@section('config',route('familia.index'))

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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            {{-- <h2><strong>SubFamilias de "{{$familia->descripcion}}"</strong></h2> --}}
                        </div>
                    </div>
                    <div class="form-control" style="margin: 1em 0px 1em 0px">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="row" style="margin: auto">
                                    <div class="col-sm-12" style="padding-bottom: 15px;text-align: center">
                                        <img src="{{asset('img/logos/familia.svg')}}" width="100px">
                                        <h3>{{$familia->descripcion}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9" style="vertical-align: middle;margin: auto">
                                <form action="{{ route('familia.update',$familia->id) }}"  enctype="multipart/form-data" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row" style="text-align: center">
                                        <div class="col-sm-3">
                                            <strong><label for="">Codigo:</label></strong>
                                            <label class="form-control " readonly="" id="view_codigo" >{{$familia->codigo}}</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <strong><label for="">Descripcion:</label></strong>
                                            <label class="form-control input_read " style="text-align: justify" readonly="" id="view_descripcion">{{$familia->descripcion}}</label>
                                            <input type="text" class="form-control input_edit input_form" name="descripcion" id="descripcion" value="{{$familia->descripcion}}" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <strong><label >Ubicacion:</label></strong>
                                            <label class="form-control" readonly="" id="view_ubicacion">{{$familia->ubicacion}}</label>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <strong><label for="">Estado</label></strong>
                                                <div class="" align="center" >
                                                <input type="checkbox" class="switch_estado check_edit disabled" name="estado"  @if($familia->estado==0) checked="" @endif />
                                                </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" id="guardar_inputs" style="display: none;"> 
                                        <div class="col-sm-6">
                                            <button class="btn btn-warning" type="button" onclick="recharge();">Cancelar</button>
                                        </div>
                                        <div class="col-sm-6" style="text-align: right">
                                            
                                            <button class="btn btn-primary">Guardar</button>
                                        </div>
                                    </div>
                                    <div class="row" id="editar_inputs">
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-sm-6" style="text-align: right">
                                            <button class="btn btn-primary" type="button" id="editar" onclick="button_editar()">Editar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th style="width: 50px">
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#create_subfamilia" ><i class="fa fa-plus"></i></button>
                                        </th>
                                        <th>Descripcion</th>
                                        <th>Ubicacion</th>
                                        <th>Estado</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subfamilias as $subfamilia)
                                        <tr class="gradeX">
                                            <form action="{{ route('subfamilia.update',$subfamilia->id) }}"  enctype="multipart/form-data" method="post">
                                                @csrf
                                                <td>
                                                    @if($subfamilia->estado==0) 
                                                        <i class="fa fa-circle" style="color: green;"></i>
                                                    @else
                                                        <i class="fa fa-circle"></i>
                                                    @endif 
                                                </td>
                                                <td>
                                                    <label id="lbl_{{$subfamilia->id}}">{{$subfamilia->descripcion}}</label>
                                                    <input value="{{$subfamilia->descripcion}}" type="text" class="form-control" name="descripcion" id="subf_desc{{$subfamilia->id}}" style="display: none" >
                                                </td>
                                                <td>{{$subfamilia->ubicacion}}</td>
                                                <td>
                                                    <input type="checkbox" class="switch_sub_estado{{$subfamilia->id}} check_edit disabled" name="sub_familia estado"  @if($subfamilia->estado==0) checked="" @endif />
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn_edit_all edit_btn_{{$subfamilia->id}}" onclick="edit_subfamilia({{$subfamilia->id}}),enable_switch{{$subfamilia->id}}()"><i class="fa fa-pencil"></i></button>
                                                    <button type="submit" class="btn btn-primary save_btn_{{$subfamilia->id}}"  style="display: none"><i class="fa fa-save"></i></button>
                                                    <button type="button" class="btn btn-warning cancel_btn_{{$subfamilia->id}}" style="display: none" onclick="recharge()"><i class="fa fa-times"></i></button>
                                                </td>
                                            </form>        
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
<!-- Modal -->
<div class="modal fade" id="create_subfamilia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Agregar Subfamilia</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('subfamilia.store',$familia->id) }}"  enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <div class="row">
                        
                            @csrf
                            <div class="col-sm-12">
                                <center><h3>Descripcion</h3></center>
                                <input type="text" class="form-control" name="descripcion" id="">
                            </div>
                            {{-- <div class="col-sm-6"> --}}
        
                            {{-- </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .form-control{border-radius: 5px}
    .input_edit{
        display: none;
    }
    .input_read{
        display: block;
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
</script>
@foreach($subfamilias as $sf)
<script>
    var swObjs{{$sf->id}} = {};
    $(document).ready(function(){
        var elem_sub{{$sf->id}} = document.querySelector('.switch_sub_estado{{$sf->id}}');
        var switch_sub{{$sf->id}} = new Switchery(elem_sub{{$sf->id}}, { color: 'skyblue' });
        switch_sub{{$sf->id}}.disable();
        swObjs{{$sf->id}}[elem_sub{{$sf->id}}.id] = switch_sub{{$sf->id}};
    });
    function enable_switch{{$sf->id}}(){
        var fake_sw = document.querySelector('.switch_sub_estado{{$sf->id}}');
        swObjs{{$sf->id}}[fake_sw.id].enable();
        console.log('delete');
    }

</script>
@endforeach
<script>
    // checkbox estilo
    var elem_2 = document.querySelector('.switch_estado');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

    
    //tabla
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
        switchery_2.disable();
        
    });
    

    //input para editar
    function button_editar(){
        //agregar el display none en label
        $(".input_read").css("display",'none');

        //quitar el display none en input
        $(".input_form").css("display",'flex');        
        switchery_2.enable();
        $("#editar_inputs").css("display",'none');
        $("#guardar_inputs").css("display",'flex');
        
    }
    function recharge(){
        location.reload();
    }
    function edit_subfamilia(a){
        $(`#lbl_${a}`).css("display",'none');
        $(`#subf_desc${a}`).css("display",'flex');

        $(`.edit_btn_${a}`).css("display",'none');
        $(`.save_btn_${a}`).css("display",'inline');
        $(`.cancel_btn_${a}`).css("display",'inline');
        $(`.btn_edit_all`).prop('disabled',true);
        
        // var i_switch = 'switch_sub'+`${a}`;

    }
</script>

@endsection