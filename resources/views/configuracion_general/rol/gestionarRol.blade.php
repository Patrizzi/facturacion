@extends('layout')
@section('title', 'Rol '.$rol->name)
{{-- @section('href_accion', route('usuario.lista'))
@section('value_accion', 'actualizar') --}}
@section('button2', 'Atras')
@section('config',route('usuario.index'))
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
                <div class="ibox-heading d-flex justify-content-between align-items-center px-2">
                    <div>
                        <h2 class="font-bold">Permisos del Rol <span
                                class="text-success">({{$rol->permisosCount}})</span></h2>
                    </div>
                    <div>
                        <div style="gap: 10px" class="d-flex justify-content-around align-items-center">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#AgregarPermisosModal">Agregar</button>
                            <form id="remove-permissions-form" action="{{ route('roles.removerPermisos', $rol->id) }}"
                                method="POST">
                                @csrf
                                @method('put')
                                <input type="hidden" name="permisos_id" id="permisos_remover_id">
                                <button type="submit" class="btn btn-danger" id="remove-permissions-button"
                                    disabled>Remover Permisos</button>
                            </form>
                        </div>
                        <div class="modal fade" id="AgregarPermisosModal">
                            <div class="modal-dialog">
                                <div class="modal-content p-3">
                                    <h2>Agregar Permisos</h2>
                                    <form method="POST" role="form"
                                        action="{{route('roles.asignarPermisos', $rol->id)}}">
                                        @csrf
                                        @method('put')
                                        <div style="gap: 10px" class="d-flex flex-column justify-content-center p-2">
                                            <div>
                                                <select class="form-control multiple_permisos_select" multiple required
                                                    name="permisos_id[]" id="">
                                                    @foreach($permisos as $key => $permiso)
                                                    <option value="{{$permiso->id}}">{{$permiso->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit"
                                                    class="btn btn-outline-primary w-75 font-bold">Guardar <i
                                                        class="fa fa-save"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Quitar Permiso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $count = 1;
                                @endphp
                                @foreach($rol->permisos as $permiso)
                                <tr class="gradeX" data-permiso-id="{{ $permiso['permiso']['id'] }}">
                                    <td class="d-flex justify-content-between">
                                        {{ $count }}
                                        @if($permiso['hasSubPermisos'])
                                        <button class="btn btn-sm bg-transparent toggle-subpermisos"
                                            data-permiso-id="{{ $permiso['permiso']['id'] }}">
                                            <i style="font-size: 10px" class="fa fa-arrow-right"></i>
                                        </button>
                                        @endif
                                    </td>
                                    <td>{{ $permiso['permiso']['name'] }}</td>
                                    <td>{{ $permiso['permiso']['name'] }}</td>
                                    <td style="cursor: pointer" onclick="toggleCheckBox({{$permiso['permiso']['id']}})"
                                        class="d-flex justify-content-around w-100">
                                        <form method="POST" action="{{route('roles.removerPermiso', ["rol_id"=> $rol->id, "permiso_id" => $permiso['permiso']['id']])}}">
                                            @csrf
                                            @method('put')
                                            <button type="submit"
                                                class="text-decoration-none btn btn-outline-danger">Remover <i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                        <input onchange="handleCheckboxChange()" class="checkboxesDelete"
                                            id="checkboxDelete{{ $permiso['permiso']['id'] }}" type="checkbox"
                                            value="{{ $permiso['permiso']['id'] }}">
                                    </td>
                                </tr>
                                @php
                                $count++
                                @endphp
                                @if($permiso['hasSubPermisos'])
                                @foreach($permiso['sub_permisos'] as $subPermiso)
                                <tr class="gradeX subpermiso-{{ $permiso['permiso']['id'] }}" style="display: none;">
                                    <td>{{ $count }}</td>
                                    <td>{{ $subPermiso['name'] }}</td>
                                    <td>{{ $permiso['permiso']['name'] }}</td>
                                    <td style="cursor: pointer" onclick="toggleCheckBox({{$subPermiso['id']}})"
                                        class="d-flex justify-content-around w-100">
                                        <form method="POST" action="{{route('roles.removerPermiso', ["rol_id"=> $rol->id, "permiso_id" => $subPermiso['id']])}}">
                                            @csrf
                                            @method('put')
                                            <button type="submit"
                                                class="text-decoration-none btn btn-outline-danger">Remover <i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                        <input onchange="handleCheckboxChange()" class="checkboxesDelete" id="checkboxDelete{{$subPermiso['id']}}"
                                            type="checkbox" value="{{ $subPermiso['id'] }}">

                                    </td>
                                </tr>
                                @php
                                $count++
                                @endphp
                                @endforeach
                                @endif

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

    
    // $(document).ready(function(){
    //     $('.dataTables-example').DataTable({
    //         pageLength: 25,
    //         responsive: true,
    //         dom: '<"html5buttons"B>lTfgitp',
    //         buttons: []
    // });
    // });
    
    // $(document).ready(function(){
    //     $('.rolTable-example').DataTable({
    //         pageLength: 25,
    //         responsive: true,
    //         dom: '<"html5buttons"B>lTfgitp',
    //         buttons: []
    // });
    // });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-subpermisos');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const permisoId = this.getAttribute('data-permiso-id');
                const subPermisos = document.querySelectorAll('.subpermiso-' + permisoId);

                subPermisos.forEach(subPermiso => {
                    // Alternar la visibilidad de los subpermisos
                    if (subPermiso.style.display === 'none') {
                        subPermiso.style.display = 'table-row';
                        this.innerHTML = '<i style="font-size: 10px" class="fa fa-arrow-down"></i>';
                    } else {
                        subPermiso.style.display = 'none';
                        this.innerHTML = '<i style="font-size: 10px" class="fa fa-arrow-right"></i>';
                    }
                });
            });
        });
    });

</script>

<script>
    $(document).ready(function() {
            $('.multiple_permisos_select').select2();
        });
        
</script>

<script>
    const handleCheckboxChange = () => {
        const checkboxes = document.querySelectorAll('.checkboxesDelete');
        const removeButton = document.getElementById('remove-permissions-button');
        const permisosInput = document.getElementById('permisos_remover_id');

        const selectedIds = Array.from(checkboxes).filter(checkbox => checkbox.checked).map(i => i.value);
                
        console.log(selectedIds)
        
        if (selectedIds.length > 0) {
            removeButton.disabled = false;
            permisosInput.value = JSON.stringify(selectedIds);
            // permisosInput.value = selectedIds.join(',');
        } else {
            removeButton.disabled = true;
            permisosInput.value = '';
        }
    }

    const toggleCheckBox = (id) => {
        let checkbox = document.getElementById(`checkboxDelete${id}`);
        if(checkbox){
            console.log(checkbox);
            checkbox.checked = !checkbox.checked;
            handleCheckboxChange();
        }
    }
</script>


@endsection