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

<style>
    /*estilos para el div de guia servicio y el boton agregar*/
    .Div-agregar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%; /* Ajusta según el ancho deseado */
}

    #titulo-guia-servicio{
        margin-left: 8px;
    }
    #btn-agregar-guia {
    background-color: #1538A0;
    color: white; /* Color del texto */
    border: none; /* Quitar borde */
    padding: 10px 20px; /* Espaciado interno */
    font-size: 14px; /* Tamaño del texto */
    font-weight: bold; /* Texto en negrita */
    border-radius: 4px; /* Bordes redondeados */
    transition: all 0.3s ease; /* Animación suave */
    display: flex;
    align-items: center;
    gap: 10px;
    margin-right: 8px;
    }

    #btn-agregar-guia:hover {
    background-color: #09267b; /* Cambio de color al pasar el mouse */
    color: white;
}

</style>

{{--  <button id="filtrarGuias" class="btn btn-primary mb-4">Mostrar solo clientes con guía</button> --}}

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

