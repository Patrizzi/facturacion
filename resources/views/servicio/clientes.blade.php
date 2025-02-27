@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<style>
    .search-container {
        justify-content: center;
        display: flex;
    }

    .custom-search {
        max-width: 500px;
        width: 100%;
    }

    .search-form {
        width: 580px;
    }

    .search-input {
        border-radius: 20px 0 0 20px;
        border: 1px solid #ccc;
        padding: 8px 12px;
        font-size: 14px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .search-btn {
        border-radius: 0 20px 20px 0;
        border: none;
        padding: 8px 15px;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-btn i {
        font-size: 16px;
    }

    .table thead {
        background-color: white;
        color: #15338a;
        text-align: center;
    }

    .table {
        border: 2px solid black;
    }

    .table th, .table td {
        border: 1px solid black !important;
        padding: 10px;
        text-align: center;
    }

    .btn-estado {
        background-color: #15338a;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn-estado:hover {
        background-color: black;
    }
</style>

<h2>CLIENTES</h2>

<!-- Nuevo botón para filtrar -->
<button id="filtrarGuias" class="btn btn-primary mb-3">Mostrar solo clientes con guía</button>

<table id="clientesTabla" class="table table-bordered dataTables-example">
    <thead>
        <tr>
            <th>ID</th>
            <th>CLIENTE</th>
            <th>EMAIL</th>
            <th>TELEFONO</th>
            <th>CELULAR</th>
            <th>DNI</th>
            <th>TIPO DE CLIENTE</th>
            <th>FECHA DE REGISTRO</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
            <tr>
                <td>{{ $cliente->id }}</td>
                <td>{{ $cliente->nombre }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td>{{ $cliente->celular }}</td>
                <td>{{ $cliente->documento_identificacion }}</td>
                <td>{{ $cliente->tipo_cliente }}</td>
                <td>{{ $cliente->fecha_registro }}</td>
                <td class="text-center">
                    @if(in_array($cliente->id, $clientesConGuias))
                        <a href="{{ route('cliente.guia', $cliente->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-file-alt"></i> Guía
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<style>

.dataTables_wrapper .dataTables_paginate {
    display: flex;
    justify-content: center;
}

</style>
<script>
    $(document).ready(function () {
    $('.dataTables-example').DataTable({
        dom: '<"top"lf>rt<"bottom"ip><"clear">',
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Todo"]
        ],
        pageLength: 10,
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            paginate: {
                previous: "Anterior",
                next: "Siguiente"
            }
        }
    });
    $("#filtrarGuias").click(function () {
    let mostrarSoloConGuias = $(this).data("filtrando") !== true;

    $("#clientesTabla tbody tr").each(function () {
        let tieneGuia = $(this).find(".btn-info").length > 0;
        if (mostrarSoloConGuias) {
            if (!tieneGuia) {
                $(this).hide();
            }
        } else {
            $(this).show();
        }
    });

    $(this).data("filtrando", mostrarSoloConGuias);
    $(this).text(mostrarSoloConGuias ? "Mostrar todos los clientes" : "Mostrar solo clientes con guía");
    });
});
</script>
@endsection

