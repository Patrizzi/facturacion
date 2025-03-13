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

<link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">
<h2>Clientes</h2>

{{--<button id="filtrarGuias" class="btn btn-primary mb-4">Mostrar solo clientes con guía</button>--}}

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
    /*$("#filtrarGuias").click(function () {
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
    });*/
});
</script>
@endsection

