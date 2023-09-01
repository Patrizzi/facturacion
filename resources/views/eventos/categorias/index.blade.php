@extends('layout')
@section('title', 'Inicio')
@section('atributo_actu', 'hidden')
@section('atributo_1', 'hidden')

@section('foto', auth()->user()->avatar)
@section('nombre', auth()->user()->personal->nombres)
@section('area', auth()->user()->name)
@section('content')

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 style="color:#0073c1">Control de Eventos</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-3">
                                @include('eventos.menu')
                            </div>
                            <div class="col-lg-9">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Titulo</th>
                                                <th>Color</th>
                                                <th>Descripcion:</th>
                                                <th>Creado por:</th>
                                                <th>Editar</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $categ)
                                                <tr>
                                                    <th>{{ $categ->id }}</th>
                                                    <th>{{ $categ->titulo }}</th>
                                                    <th>
                                                        <div class="ibox-title"
                                                            style="background-color: transparent;border: none;padding: 0px;min-height: 35px">
                                                            <h5>{{ $categ->color }}</h5>
                                                            <div class="ibox-tools" style="top: 0px">
                                                                <span class="label label-warning-light float-right"
                                                                    style="background-color: {{ $categ->color }}">&nbsp;</span>
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th>{{ $categ->descripcion }}</th>
                                                    <th>{{ $categ->user->name }}</th>
                                                    <th style="width: 8%" class="text-center">
                                                        <a class="btn btn-warning" data-bs-effect="effect-scale"
                                                            data-toggle="modal" data-target="#modal_edit_categorie"
                                                            onclick="button_edit({{ $categ->id }})"><i
                                                                class="fa fa-pencil" style="color: white"></i></a>
                                                    </th>
                                                    <th style="width: 8%" class="text-center">
                                                        @if ($categ->estado == 0)
                                                            <i class="fa fa-check"
                                                                style="color: green;font-size: 20px !important"></i>
                                                        @else
                                                            <i class="fa fa-times"
                                                                style="color: red;font-size: 20px !important"></i>
                                                        @endif
                                                    </th>
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
    </div>

    {{-- MODAL DE EDITAR  --}}
    <div class="modal fade" id="modal_edit_categorie">
        <div class="modal-dialog " role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form style="margin: 5px 2em" id="form_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                Título:
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="titulo_edit"
                                    autocomplete="off">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                Color:
                            </div>
                            <div class="col-sm-8">
                                <input type="color" class="form-control" id="color_edit" name="color"
                                    autocomplete="off">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                Descripcion:
                            </div>
                            <div class="col-sm-8">
                                <textarea name="description" class="form-control" id="descripcion_edit"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                Estado:
                            </div>
                            <div class="col-sm-8 text-center" id="dic_check">

                            </div>
                        </div>
                        <input type="hidden" name="id" value="" id="value_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button button_display" class="btn btn-primary"
                            onclick="save_edit_category()">Guardar</button>
                        <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                pageLength: 15,
                order: [
                    [0, "desc"]
                ],
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [],
                aoColumnDefs: [{
                    'bSortable': false,
                    'aTargets': [0]
                }]
            });
            $('#cat_menu_eventos').click();
        });

        function button_edit(valor) {
            var data = valor;
            $.ajax({
                type: "post",
                url: "{{ route('category.search') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'categoria': data,
                },
                success: function(params) {
                    $('#dic_check').empty();
                    $("#estado_select").children().removeAttr("selected");
                    $('#value_id').val(params.id);
                    $('#titulo_edit').val(params.titulo);
                    $('#color_edit').val(params.color);
                    $('#descripcion_edit').val(params.descripcion);
                    console.log(params.estado);
                    if (params.estado == 0) {
                        var html = `<input type="checkbox" name="estado" class="js-switch"  checked />`;
                        $('#dic_check').append(html);
                        var elem = document.querySelector('.js-switch');
                        var switchery = new Switchery(elem, {
                            color: '#1AB394'
                        });
                    } else {
                        var html = `<input type="checkbox" name="estado" class="js-switch"  />`;
                        $('#dic_check').append(html);
                        var elem = document.querySelector('.js-switch');
                        var switchery = new Switchery(elem, {
                            color: '#1AB394'
                        });
                    }

                }
            });
        }

        function save_edit_category() {
            var form_data = $('#form_edit').serialize();
            // console.log(form_data);
            $.ajax({
                type: "post",
                url: "{{ route('category.update') }}",
                data: form_data,
                success: function(data) {
                    location.reload();
                },
                error: function(error) {
                    alert(error);
                }
            });
        }
        $(".button_display").on("submit", function() {
            this.prop('disabled', true);
            setTimeout(() => {
                this.prop('disabled', false);
            }, 5000);
        });
    </script>
@endsection
