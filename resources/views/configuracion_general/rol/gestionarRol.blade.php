@extends('layout')
@section('title', 'Rol')
{{-- @section('href_accion', route('usuario.lista'))
@section('value_accion', 'actualizar') --}}
@section('button2', 'Atras')
@section('config',route('usuarios.index'))
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    @if($errors->any())
    <div style="padding-top: 20px;">
        <div class="alert alert-danger">
            <a class="alert-link" href="#">
                @foreach ($errors->all() as $error)
                <li class="error">{{ $error }}</li>
                @endforeach
            </a>
        </div>
    </div>
    @endif
    @if(isset($errores))
    <div>
        <div class="alert alert-danger">
            <div class="alert-link" href="#">
                <li style="color: red;">{{ $errores }}</li>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">

            <div class="ibox">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Administrar Rol</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach($roles as $rol)
                                <tr class="gradeX">
                                    <td>{{$rol->id}}</td>
                                    <td>{{$rol->name}}</td>
                                    <td><a href="{{route('roles.gestRol', $rol->id)}}"
                                            class="text-decoration-none btn btn-success">Administrar <i
                                                class="fa fa-edit"></i></a></td>
                                </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<style>
    .select2-container.select2-container--default.select2-container--open {
        z-index: 9999 !important;
        width: 100% !important;
    }


    .select2-container {
        display: inline !important;
    }
</style>

<style>
    .reenviar {
        transition: 0.2s;
        color: #f72f2f
    }

    .reenviar:hover {
        color: #676a6c
    }

    .col-sm-9 {
        padding-bottom: 15px
    }

    .form-control {
        border-radius: 5px
    }

    :root {
        --color-button: #fdffff;
    }

    .switch-button {
        display: inline-block;
        /* padding-top: 9px;
        padding-right: 30px; */
        padding: 9px 40px;
    }

    .switch-button .switch-button__checkbox {
        display: none;
    }

    .switch-button .switch-button__label {
        background-color: #1f1f1f66;
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

    .switch-button .switch-button__checkbox:checked+.switch-button__label {
        background-color: #1c84c6;

    }

    .switch-button .switch-button__checkbox:checked+.switch-button__label:before {
        transform: translateX(1rem);
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
<script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>

<script>
    //Select2
    $(document).ready(function() {
            $('.multiple_permisos_select').select2();
        });

    
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
    });
    });
    
    // $(document).ready(function(){
    //     $('.rolTable-example').DataTable({
    //         pageLength: 25,
    //         responsive: true,
    //         dom: '<"html5buttons"B>lTfgitp',
    //         buttons: []
    // });
    // });

</script>
@endsection