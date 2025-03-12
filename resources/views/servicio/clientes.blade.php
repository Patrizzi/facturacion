@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atras')
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
<div class= "Div-agregar">
    <h2 id= "titulo-guia-servicio">Guias servicio</h2>
    <button id="btn-agregar-guia">Agregar</button>
</div>
<table id="clientesTabla" class="table table-bordered dataTables-example">
    <thead>
        <tr>
            <th>NRO GUIA</th>
            <th>CLIENTE</th>
            <th>ORDEN DE SERVICIO</th>
            <th>CELULAR</th>
            <th>FECHA</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        {{--  @foreach ($ as $)
            <tr>
                <td>{{ $-> }}</td>
                <td>{{ $->}}</td>
                <td>{{ $-> }}</td>
                <td>{{ $-> }}</td>
                <td>{{ $-> }}</td>
                <td>{{ $-> }}</td>
                <td>{{ $-> }}</td>
                <td class="text-center">
                    @if(in_array($->id, $clientesConGuias))
                        <a href="{{ route('cliente.guia', $->) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-file-alt"></i> Guía
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach--}}
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
});
</script>
@endsection

