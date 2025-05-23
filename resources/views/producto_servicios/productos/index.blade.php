@extends('layout')
@section('title', 'productos')
@section('atributo_actu', 'hidden')
@section('value_accion', 'Agregar')
@section('href_accion', route('productos.create'))
@section('content')

    @if (session('anulacion'))
        <div class="alert alert-danger">
            {{ session('anulacion') }}
        </div>
    @endif
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox">
    <div class="ibox-content">
      <!-- Encabezado -->
      <div class="d-flex justify-content-between  mb-3">
        <div class="nav nav-tabs border-0">
          <a href="#" class="btn btn-link text-dark font-weight-bold">Productos</a>
          <a href="#" class="btn btn-link text-muted">Paquetes</a>
          <a href="#" class="btn btn-link text-muted">Familia</a>
          <a href="#" class="btn btn-link text-muted">Subfamilia</a>
        </div>
        <div>
          <button class="btn btn-primary">Nuevo Producto</button>
        <i class="fa fa-plus text-secondary mx-2" style="cursor: pointer;"></i>
        <i class="fa fa-upload text-secondary mx-2" style="cursor: pointer;"></i>
        <i class="fa fa-download text-secondary mx-2" style="cursor: pointer;"></i>
        <i class="fa fa-user text-secondary mx-2" style="cursor: pointer;"></i>
        </div>
      </div>
      <div class="table-responsive" >
        <table class="table table-striped table-hover dataTables-productoNuevo">
            <tr>
              <th><input type="radio" ></th>
              <th>Código <i class="fa fa-search"></i></th>
              <th>Nombre <i class="fa fa-search"></i></th>
              <th>Marca <i class="fa fa-search"></i></th>
              <th>Unidad <i class="fa fa-filter"></i></th>
              <th>Precio <i class="fa fa-search"></i></th>
              <th>Stock <i class="fa fa-search"></i></th>
              <th><i class="fa fa-sliders"></i></th>
            </tr>
          <tbody>
            <tr>
                <td><input type="radio" name="product"></td>
                <td>LN-000001</td>
                <td>Laptop Asus TUF Gaming</td>
                <td>ASUS</td>
                <td>UNIDAD</td>
                <td>S/. 2800.00</td>
                <td>10</td>
                <td class="position-relative">
                    <i class="fa fa-book text-secondary me-3" style="cursor:pointer;"></i>
                    <div class="dropdown d-inline">
                    <i class="fa fa-ellipsis-h text-secondary" style="cursor:pointer;" id="dropdownMenuIcon1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuIcon1">
                        <a class="dropdown-item" href="#">Editar</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ajusteStockModal">Ajustar Stock</a>
                        <a class="dropdown-item" href="#">Historial de Ventas</a>
                        <a class="dropdown-item" href="#">Historial de Compras</a>
                        <a class="dropdown-item text-danger" href="#">Eliminar</a>
                    </div>
                    </div>
                </td>
            </tr>
            <tr>
              <td><input type="radio" name="product"></td>
              <td>LN-000002</td>
              <td>TECLADO INALÁMBRICO</td>
              <td>LENOVO</td>
              <td>BOLSA</td>
              <td>S/. 140.50</td>
              <td>20</td>
              <td><i class="fa fa-ellipsis-h"></i></td>
            </tr>
            <tr>
              <td><input type="radio" name="product"></td>
              <td>ID-000001</td>
              <td>CABLE IDECO THW</td>
              <td>IDECO</td>
              <td>PAQUETE</td>
              <td>S/. 20.00</td>
              <td>5</td>
              <td><i class="fa fa-ellipsis-h"></i></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ajusteStockModal" tabindex="-1" role="dialog" aria-labelledby="ajusteStockModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow rounded">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title font-weight-bold">Ajuste de Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="font-weight-semibold">Nombre del Producto</span>
          <span class="text-muted">x <strong>99 NIU</strong></span>
        </div>

        <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
          <label class="btn btn-outline-primary active">
            <input type="radio" name="stockOption" value="incrementar" checked> Incrementar
          </label>
          <label class="btn btn-outline-primary">
            <input type="radio" name="stockOption" value="igualar"> Igualar a
          </label>
          <label class="btn btn-outline-primary">
            <input type="radio" name="stockOption" value="disminuir"> Disminuir
          </label>
        </div>

        <div class="input-group mb-3" style="max-width: 200px;">
          <input type="number" class="form-control border-primary" value="30" min="0">
          <div class="input-group-append">
            <span class="input-group-text border-primary">NIU</span>
          </div>
        </div>

        <p class="font-weight-semibold">Cantidad final: <strong>129 NIU</strong></p>

      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Ajustar</button>
      </div>
    </div>
  </div>
</div>




    <!--Código actual 14/11/2024-->
    @include('producto_servicios.shared.stadistics')

    <!--Modal para anular producto-->
    @include('producto_servicios.productos.shared.modal_anular')
    
    <!--Base para agregar el tab para el los contenidos-->

    <div class="wrapper wrapper-content animated fadeInRight pt-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                @include('producto_servicios.productos.shared.tabs2')
                            </ul>


                            <!-- Tablas y su contenido -->
                            <div class="tab-content">

                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                    <div class="panel-body table-responsive">
                                        <div class="row">
                                            <div class="col-md-5">
                                                {{-- ACA PUEDE IR OTRO FILTRO DE BUSQUEDA --}}
                                            </div>
                                            <div class="col-md-5 ">
                                                <div class="input-group">
                                                    <label for="inputBuscar"
                                                        class="col-lg-2 col-form-label "><strong>Buscar:</strong></label>
                                                    <input type="text" id="inputBuscar" class="form-control"
                                                        aria-describedby="passwordHelpInline">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-primary btn-block" id="producto_buscar"
                                                    type="button">Buscar</button>
                                            </div>
                                        </div>
                                        <br>
                                        <!-- CONTENIDO DENTRO DEL TAB -->
                                        <table class="table table-striped" id="table_prodac">
                                            <thead class="text-md-center">
                                                <tr>
                                                    <!--<th><input type="checkbox" checked class="i-checks" name="input[]"></th>-->
                                                    <th>Item</th>
                                                    <th>Nombre</th>
                                                    <th>Código producto</th>
                                                    <th>Código original</th>
                                                    <th>Familia</th>
                                                    <th>Marca</th>
                                                    <th>Afectación</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Fin del Código Gaby-->
    <style>
        .pie-md {
            max-width: 17%; //270
            max-height: 50%; //400
        }

        div.dataTables_length {
            display: none;
        }

        /* El Buscar */
        div.dataTables_filter {
            display: none;
        }

        /* CSV, Excel, PDF, Print */
        div.dt-buttons {
            display: none;
        }

        /* Tamaño de los botones del index */
        .tam {
            min-width: 150px;
            min-height: 150px;
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

    <!-- d3 and c3 charts -->
    <script src="{{ asset('js/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('js/plugins/c3/c3.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#tab-1-tab').addClass('active show');
            $('#table_prodac').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_productos') }}",
                    method: "get",
                    data: function(d) {
                        d.estado = 1;
                        d.value = $('#inputBuscar').val();
                    },
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                "pageLength": 15,
                "order": [
                    [0, "desc"]
                ],
                "columnDefs": [{
                    'targets': [0]
                }, {
                    'targets': [1]
                }, {
                    'targets': [2]
                }, {
                    'targets': [3],
                    'render': function(data, type, full, meta) {
                        return "<input type='hidden' id='producto_nombre_" + full[0] +
                            "' value='" + full[1] + "' >" + full[3] + "";
                    }
                }, {
                    'targets': [4]
                }, {
                    'targets': [7],
                    'render': function(data, type, full, meta) {

                        return "<a href='{{ route('productos.show', '') }}/" + full[0] +
                            "'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i></button></a> <button type='button' class='btn btn-danger btn-sm' onclick='abrir_modal(" +
                            full[0] +
                            ")'> <i class='fa fa-trash-o' aria-hidden='true'></i></button> ";
                    }
                }]
            });
        });
        $('#producto_buscar').on('click', function() {
            $('#table_prodac').DataTable().ajax.reload();
        });

        function abrir_modal(a) {
            var nombre = document.getElementById(`producto_nombre_${a}`).value;
            document.getElementById(`prod_nombre`).innerHTML = nombre;
            document.getElementById(`prod_id_form`).value = a;
            $('#producto_modal').modal('show');
        }
    </script>
    <script>
        $(document).ready(function(){
            $('.dataTables-productoNuevo').DataTable({
                pageLength: 25,
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

    @include('producto_servicios.shared.pie')
@endsection
