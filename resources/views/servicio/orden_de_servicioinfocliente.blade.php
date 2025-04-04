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
    <p>{{ $guia->cliente->nombre }}</p>
</div>

<!-- Sección de Guía (Inicio - Fin) -->
<div class="guide">
    <h3>Guía Nro: {{ $guia->nro_guia }}</h3>
    <p>
        <strong>Orden de servicio N°:</strong>
        <span id="orden-servicio-text">
            {{ $guia->orden_servicio ?? 'No asignada' }}
        </span>
        <input type="text" id="orden-servicio-input" value="{{ $guia->orden_servicio ?? '' }}" style="display: none;" onblur="saveOrdenServicio()" />
    </p>
    <p><strong>Fecha de Creación:</strong> {{ \Carbon\Carbon::parse($guia->created_at)->format('d-m-Y H:i') }}</p>
</div>

<!-- Sección de Productos -->
<div class="products">
    <h3>Productos</h3>
    <ul class="product-list">
        @foreach($guia->servicio_guia_salida->detalle_guia_salida as $producto)
        <li class="product-item" onclick="openModal(
            '{{ $producto->s_detalle_guia_ingreso->producto }}',
            '{{ $producto->s_detalle_guia_ingreso->serie }}',
            '{{ $producto->diagnostico }}',
            '{{ $producto->id }}',
            '{{ $producto->descripcion_os ?? '' }}')">
            <h4>{{ $producto->s_detalle_guia_ingreso->producto }}</h4>
            <p class="short-description">Información breve..</p>
        </li>
        @endforeach
    </ul>
</div>

            <button type="submit" class="button">Crear Orden</button>
    </div>

    <!-- Modal de Producto -->
    <div id="productModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-right">
                <h2 class="ST" id="modalTitle">Producto</h2>
                <p class="SD"><strong>Serie:</strong> <span id="modalSeries"></span></p>
                <p class="SD"><strong>Diagnóstico:</strong> <span id="modalDiagnosis"></span></p>
                <label class="SD" for="description">Descripción:</label>
                <!-- Este es el textarea único que se generará dinámicamente para cada producto -->
                <textarea id="description" rows="4" placeholder="Escribe la descripción aquí..."></textarea>
                <button class="btoninfocliente">Guardar</button>
            </div>
        </div>
    </div>

    <script>
        // Función para abrir el modal con la información específica de un producto
        function openModal(productName, productSeries, productDiagnosis, productId, descripcion) {
            // Cambiar el contenido del modal con la información del producto
            document.getElementById('modalTitle').innerText = productName;
            document.getElementById('modalSeries').innerText = productSeries;
            document.getElementById('modalDiagnosis').innerText = productDiagnosis;

            // Establecer el ID del producto en el modal para saber a qué producto pertenece la descripción
            document.getElementById('productModal').setAttribute('data-product-id', productId);

            // Si la descripción existe, usarla; si no, poner el valor por defecto
            document.getElementById('description').value = descripcion;

            // Mostrar el modal
            document.getElementById('productModal').style.display = "block";
            setTimeout(() => {
                document.getElementById('productModal').classList.add('show');
            }, 10); // Para que se ejecute la animación
        }

        // Función para cerrar el modal
        function closeModal() {
            // Cerrar el modal con transición
            document.getElementById('productModal').classList.remove('show');
            setTimeout(() => {
                document.getElementById('productModal').style.display = "none";
            }, 300); // Duración de la animación
        }

        // Función para guardar la descripción del producto
        function saveDescription() {
            var productId = document.getElementById('productModal').getAttribute('data-product-id');
            var description = document.getElementById('description').value;

            // Guardar la descripción (este paso es opcional, puede ser en backend o en el navegador)
            localStorage.setItem('description_' + productId, description);

            // Llamada al backend para guardar la descripción permanentemente (si lo deseas)
            fetch(`/guardar-descripcion/${productId}`, {
                method: 'POST',
                body: JSON.stringify({ descripcion_os: description }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Descripción guardada correctamente.");
                    closeModal(); // Cerrar el modal después de guardar
                } else {
                    alert("Hubo un error al guardar la descripción.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Hubo un error al guardar la descripción.");
            });
        }
    </script>






<script>
    // Función para hacer el campo de entrada editable cuando se haga clic en el texto
    document.getElementById('orden-servicio-text').addEventListener('click', function() {
        document.getElementById('orden-servicio-text').style.display = 'none';
        document.getElementById('orden-servicio-input').style.display = 'inline';
        document.getElementById('orden-servicio-input').focus();
    });

    // Función para guardar el nuevo valor cuando el input pierde el foco
    function saveOrdenServicio() {
        var newOrden = document.getElementById('orden-servicio-input').value;

        // Aquí podrías hacer una solicitud AJAX o algún otro método para guardar el nuevo valor.
        // Por ejemplo, usando Fetch API o Laravel AJAX:
        console.log("Nuevo valor de Orden de servicio: " + newOrden);

        // Volver a mostrar el texto y ocultar el input
        document.getElementById('orden-servicio-text').style.display = 'inline';
        document.getElementById('orden-servicio-input').style.display = 'none';

        // Actualizar el texto con el nuevo valor
        document.getElementById('orden-servicio-text').textContent = newOrden || 'No asignada';
    }
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
