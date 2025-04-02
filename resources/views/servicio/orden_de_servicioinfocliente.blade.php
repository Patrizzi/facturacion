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
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/guia.css') }}">
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/ordenservicioinfocliente.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <div class="container">
        <h1 class="section-title">Información del Cliente</h1>

        <!-- Sección de Información del Cliente -->
        <div class="client-info">
            <h3>Nombre del Cliente</h3>
            <p>Juan Pérez</p>
        </div>

        <!-- Sección de Guía (Inicio - Fin) -->
        <div class="guide">
            <h3>Guía Nro1</h3>
            <p>Orden de servicio N°: 123456</p>
            <p>Fecha de Creación: 27 de marzo, 2025</p>
        </div>

        <!-- Sección de Productos -->
        <div class="products">
            <h3>Productos</h3>
            <ul class="product-list">
                <li class="product-item" onclick="openModal('Laptop', 'A12345', 'Funcionando bien')">
                    <h4>Producto 1</h4>
                    <p class="short-description">Información breve..</p>
                </li>
                <li class="product-item" onclick="openModal('Celular', 'B67890', 'Reparación pendiente')">
                    <h4>Producto 2</h4>
                    <p class="short-description">Información breve..</p>
                </li>
                <li class="product-item" onclick="openModal('PC', 'C11223', 'Necesita actualizacion ')">
                    <h4>Producto 3</h4>
                    <p class="short-description">Información breve...</p>
                </li>
            </ul>
        </div>
            <button type="submit" class="button">Crear Orden</button>
    </div>

    <!-- Modal de Producto -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-right">
                <h2 class="ST" id="modalTitle"></h2>
                <p class="SD"><strong>Serie:</strong> <span id="modalSeries"></span></p>
                <p class="SD"><strong>Diagnóstico:</strong> <span id="modalDiagnosis"></span></p>
                <label class="SD" for="description">Descripción:</label>
            <textarea id="description" rows="4" placeholder="Escribe la descripción aquí..."></textarea>
            <button class="btoninfocliente">Guardar</button>
            </div>
        </div>
    </div>




<script>
    function openModal(productName, productSeries, productDiagnosis) {
        // Cambia el contenido del modal
        document.getElementById('modalTitle').innerText = productName;
        document.getElementById('modalSeries').innerText = productSeries;
        document.getElementById('modalDiagnosis').innerText = productDiagnosis;

        // Muestra el modal con transición
        document.getElementById('productModal').style.display = "block";
        setTimeout(() => {
            document.getElementById('productModal').classList.add('show');
        }, 10); // Para que se ejecute la animación
    }

    function closeModal() {
        // Cierra el modal con transición
        document.getElementById('productModal').classList.remove('show');
        setTimeout(() => {
            document.getElementById('productModal').style.display = "none";
        }, 300); // Duración de la animación
    }
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
