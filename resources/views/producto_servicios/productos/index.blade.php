@extends('layout')
@section('title', 'Productos')
@section('atributo_actu', 'hidden')
@section('value_accion', 'Agregar')
@section('href_accion', route('productos.create'))
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <form action="{{ route('productos.importar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="excel">Subir archivo Excel:</label>
            <input type="file" name="excel" id="excel" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Subir</button>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning">
            {!! session('warning') !!}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#importarModal">
        📂 Importar Productos desde Excel
    </button>

    <!-- Modal para importar productos -->
    <div class="modal fade" id="importarModal" tabindex="-1" aria-labelledby="importarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h3 class="modal-title fw-semibold" id="importarModalLabel">📂 Importar Productos desde Excel</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('productos.importar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="archivo" class="form-label fw-semibold">Selecciona un archivo Excel:</label>
                            <input type="file" name="archivo" class="form-control" accept=".xlsx,.xls,.csv" required>
                            <small class="text-muted">Formatos permitidos: .xlsx, .xls, .csv</small>
                        </div>
                        <button type="submit" class="btn btn-success w-100">📤 Importar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito y error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <!-- Estilos para el modal -->
    <style>
    .modal-content {
        border-radius: 15px;
        box-shadow: 0px 10px 40px rgba(0, 0, 0, 0.2);
    }
    .modal-header {
        border-bottom: 0;
    }
    .modal-body {
        padding: 30px;
    }
    .btn-close-white {
        filter: invert(1);
    }
    .modal-lg {
        max-width: 900px;
    }
    </style> --}}


    @if (session('anulacion'))
    <div class="alert alert-danger">
        {{ session('anulacion') }}
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example " id="table_prod">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Nombre</th>
                                    <th>Código Producto</th>
                                    <th>Código Original</th>
                                    {{-- <th>Familia</th> --}}
                                    <th>Marca</th>
                                    <th>Estado</th>
                                    <th>Afectación</th>
                                    <th>Foto</th>
                                    <th>Ver</th>
                                    <th>Anular</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

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
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#table_prod').DataTable({
                "serverSide":true,
                "ajax":"{{url('api/productos')}}",
                "columns":[
                {data : 'prod_id'},
                {data : 'prod_nomnre'},
                {data : 'codigo_producto'},
                {data : 'codigo_original'},
                // {data : 'familia_desc'},
                {data : 'nombre_marca'},
                {data : 'estado_nom'},
                {data : 'afectacion_info'},
                {
                    name: '',
                    data: null,
                    sortable: false,
                    searchable: false,
                    render: function (data) {
                        var imagen_act = '';
                        imagen_act += '<img src="{{ asset('/archivos/imagenes/productos/')}}/:foto" style="width: 45px;" />';
                        return imagen_act.replace(/:foto/g, data.foto);
                    }
                },
                {
                    name: '',
                    data: null,
                    sortable: false,
                    searchable: false,
                    render: function (data) {
                        var actions = '';
                        actions += '<a href="{{ route('productos.show',':id') }}" target="_blank"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a>';
                        return actions.replace(/:id/g, data.prod_id);
                    }
                },
                {
                    data: null,
                    name: '',
                    sortable: false,
                    searchable: false,
                    render: function (data) {
                        if(data.estado_anular == 1){
                            data: null;
                            var actions = '';
                            actions +=
                            '<button type="button" class="btn btn-s-m btn-danger" data-toggle="modal" data-target="#:id"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'+
                            '<div class="modal fade" id=":id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
                            '<div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">'+
                            '<div class="modal-content" >'+
                            '<div class="modal-body" style="padding: 0px;">'+
                            '<div class="ibox-content float-e-margins">'+
                            '<h3 class="font-bold col-lg-12" align="center">'+
                            '¿Esta Seguro que Deseas Anular el Producto: :id".?<br>'+
                            '<h4 align="center"> <strong>Nota: Una vez Anulado no hay opción de devolver la acción </strong></h4>'+
                            '</h3><p align="center"><form action="{{ route('productos.destroy',':id')}}" method="POST">'+
                            '@csrf @method('delete')'+

                            '<center><button type="submit" class="btn btn-w-m btn-primary">Anular</button></form>'+
                            '</p></div></div></div></div></div>';
                            return actions.replace(/:id/g, data.prod_id);
                        }else{
                            var actions2 = '';
                            data: 'id';
                            actions2 += '<a href="#"><span class="btn btn-secondary" ><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>';
                            return actions2.replace(/:id/g, data.prod_id);
                        }

                    }
                }
                ]
            });
        });

    </script>





    <!-- Page-Level Scripts


    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({

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

-->

@endsection
