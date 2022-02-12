@extends('layout')

@section('title', 'Categoría')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('content')
@section('button2', 'Atrás')
@section('config',route('Configuracion'))

<!-- Modal Create  -->
@if($errors->any())
<div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
    <a class="alert-link" href="#">
        @foreach ($errors->all() as $error)
        <li class="error" style="color: red">{{ $error }}</li>
        @endforeach
    </a>
</div>
@endif
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('categoria.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                        @csrf
                        <div>
                            <div class="panel-body" >
                                <div class="row">
                                    <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/categoria.svg')}}" width="100px"></div>
                                    <label class="col-sm-2 col-form-label">Descripción:</label>
                                    <div class="col-sm-10"> <input type="text" class="form-control" name="descripcion" required> </div>
                                </div>
                            </div>
                        </div>
                        <button class="ladda-button btn btn-primary" type="submit" id="boton">Guardar</button>
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
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $categoria)
                                <tr class="gradeX">
                                    <td>{{$categoria->id}}</td>
                                    <td>{{$categoria->codigo}}</td>
                                    <td>{{$categoria->descripcion}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$categoria->id}}"><i class="fa fa-edit"></i></button>
                                        <div class="modal fade" id="exampleModal{{$categoria->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        {{-- ccccccccccccccccc --}}
                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                            <form action="{{ route('categoria.update',$categoria->id) }}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <fieldset >
                                                                    <div>
                                                                        <div class="panel-body" >
                                                                            <div class="row">
                                                                               <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/categoria.svg')}}" width="100px"></div>
                                                                               <label class="col-sm-3 col-form-label">Descripcion:</label>
                                                                               <div class="col-sm-9">
                                                                                <input type="text" class="form-control" readonly="readonly" value="{{$categoria->descripcion}}">
                                                                            </div>
                                                                            <label class="col-sm-3 col-form-label">Activo/desactivo:</label>
                                                                            <div class="col-sm-3">
                                                                               @if($categoria->estado == 0)
                                                                               @if($conteo == 1)
                                                                               <div class="switch-button">
                                                                                <input type="text" name="estado" value="on" hidden="hidden">
                                                                                <input type="checkbox" name="estado" id="switch-label{{$categoria->id}}" class="switch-button__checkbox" checked="" disabled="disabled" >
                                                                                <label for="switch-label{{$categoria->id}} " class="switch-button__label " ></label>
                                                                            </div>
                                                                            @elseif($conteo >1)
                                                                            <div class="switch-button">
                                                                                <input type="checkbox" name="estado" id="switch-label{{$categoria->id}}" class="switch-button__checkbox" checked="" >
                                                                                <label for="switch-label{{$categoria->id}}" class="switch-button__label"></label>
                                                                            </div>
                                                                            @endif

                                                                            @elseif($categoria->estado == 1)
                                                                            <div class="switch-button">
                                                                                <input type="checkbox" name="estado" id="aswitch-label{{$categoria->id}}" class="switch-button__checkbox" >
                                                                                <label for="aswitch-label{{$categoria->id}}" class="switch-button__label"></label>
                                                                            </div>
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </fieldset>
                                                        <button class="ladda-button btn btn-primary" type="submit" >Grabar</button>
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
<style>
    .form-control{border-radius: 5px}
    .col-sm-4{padding-bottom: 10px}
    :root {
        --color-button: #fdffff;
    }
    .switch-button {
        display: inline-block;
        padding-top: 9px;
        padding-right: 30px;
    }
    .switch-button .switch-button__checkbox {
        display: none;
    }
    .switch-button .switch-button__label {
        background-color:#1f1f1f66;
        width: 2rem;
        height: 1rem;
        border-radius: 3rem;
        display: inline-block;
        position: relative;
    }
    .switch-button .switch-button__label:before {
        transition: .6s;
        display: block;
        position: absolute;
        width: 1rem;
        height: 1rem;
        background-color: var(--color-button);
        content: '';
        border-radius: 50%;
        box-shadow: inset 0px 0px 0px 1px black;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label {
        background-color: #1c84c6;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
        transform: translateX(1rem);
    }
</style>
@endsection

