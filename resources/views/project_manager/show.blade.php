{{-- @extends('layouts.app') --}}
@extends('layout')
@section('title', 'Proyectos')
@section('href_accion', route('inicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')


@section('content')
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
    {!! push_asset_once(['css/project_managers/project_managers.css']) !!}

    <x-content-app title="Lista de proyectos" :buttons="$buttons">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link" href="{{ route('project_managers.index') }}">Proyectos</a></li>
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Actividades</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2">Tarjetas</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-3">Reporte</a></li>
                    <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                        <a data-toggle="modal" data-target="#formModal" data-url="{{ route("project_managers.cards.create", $id)  }}" class="btn btn-sm btn-primary "><i
                                class="fa fa-plus" style="color: white"></i></a>
                    </ul>
                </ul>
                <div class="modals">
                    <div class="modal" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <!-- Contenido del modal -->
                        </div>
                    </div>
                    <div class="modal" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">

                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            @if ($activities->isNotEmpty())
                                <x-project-manager.gantt-activities-view :collection="$activities" type="manyActivities" />
                            @else
                                <h5>No hay actividades en este proyecto.</h5>
                            @endif
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            @if ($activities->isNotEmpty())
                                <x-project-manager.card-activities-view :collection="$activities" />
                            @else
                                <h5>No hay Tarjetas en este proyecto.</h5>
                            @endif
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-3" class="tab-pane">
                        <div class="panel-body">
                            @if ($activities->isNotEmpty())
                                <x-project-manager.report-activities-view :pagActivities="$activities" :allActivities="$allActivities" />
                            @else
                                <h5>No hay actividades para generar el reporte.</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-content-app>


    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    {{-- <script src="{{ asset('js/plugins/select2/select2.min.js') }}"></script> --}}
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script>
        // Funcion para morar errores de validación
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        // Funciones para manejar los modales
        $(document).on('click', '[data-toggle="modal"]', function() {
            abrirModal($(this));
        });

        var lastUrls = {};
        var modalStack = [];

        function abrirModal(button) {
            var modalTarget = button.data('target');
            var url = button.data('url');

            if (!modalTarget || !url) {
                console.error("Modal target o URL no definido.");
                return;
            }

            var modal = $(modalTarget);
            var currentModal = button.closest('.modal');

            if (currentModal.length > 0 && !modalStack.includes(currentModal.attr('id'))) {
                modalStack.push(currentModal.attr('id'));
                currentModal.modal('hide');
            }

            modal.attr('data-modal-parent', modalStack.length > 0 ? '#' + modalStack[modalStack.length - 1] : '');

            cargarModal(modal, url);
        }

        function cargarModal(modal, url) {
            var modalTarget = modal.selector;

            if (!modal.length) {
                console.error("Modal no encontrado: " + modalTarget);
                return;
            }

            if (url !== lastUrls[modalTarget]) {
                modal.find('.modal-dialog').load(url, function(response, status, xhr) {
                    if (status === "error") {
                        console.error("Error al cargar el contenido del modal.");
                    } else {
                        lastUrls[modalTarget] = url;
                    }
                });
            }
        }

        $('.modal').on('hidden.bs.modal', function() {
            if (modalStack.length <= 0) return;

            var modalParent = $(this).attr('data-modal-parent');
            var lastModalId = modalStack[modalStack.length - 1];

            if (modalParent !== '#' + lastModalId) return;

            modalStack.pop();
            $(modalParent).modal('show');
        });

        // Mostrar confirmación del delete
        function deleteItem(id) {
            const form = document.getElementById(`delete-item-form-${id}`);

            swal({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, borrar',
                    cancelButtonText: 'Cancelar'
                },
                function(isConfirm) {
                    if (isConfirm) {
                        form.submit();
                    }
                }
            );
        }
    </script>

@endsection
