@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.ordenServicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/guia.css') }}">
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/ordenservicioinfocliente.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

    <!-- Mensajes de alerta -->
    @if(session('success') || session('error'))
    <div id="toast" class="toast {{ session('success') ? 'success' : 'error' }}">
        <p>{{ session('success') ?? session('error') }}</p>
    </div>

    <script>
        window.onload = function() {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 4000); // Se cierra a los 4 segundos
            }
        };
    </script>
    @endif

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
                {{ $guia->orden_servicio ? str_pad($guia->orden_servicio, 4, '0', STR_PAD_LEFT) : 'No asignada' }}
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
                <p class="short-description">{{ $producto->descripcion_os ?? 'Información breve...' }}</p>
            </li>
            @endforeach
        </ul>
    </div>

    <form action="{{ route('OrdenServicio.OSupdate') }}" method="POST">
        @csrf
        @method('PATCH')
        <input type="hidden" name="guia_id" value="{{ $guia->id }}">
        <button type="submit" class="button">Crear Orden</button>
    </form>
    </div>

    <!-- Modal de Producto -->
    <div id="productModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-right">
                <h2 class="ST" id="modalTitle">Producto</h2>
                <p class="SD"><strong>Serie:</strong> <span id="modalSeries"></span></p>
                <p class="SD"><strong>Diagnóstico:</strong> <span id="modalDiagnosis"></span></p>

                <form id="updateDescriptionForm" action="{{ route('detalle.updateDescripcion') }}" method="POST">
                    @csrf
                    <input type="hidden" id="detalle_id" name="detalle_id" value="">
                    <label class="SD" for="descripcion_os">Descripción:</label>
                    <textarea class ="textarea-orden-servicio"id="descripcion_os" name="descripcion_os" rows="4" placeholder="Escribe la descripción aquí..."></textarea>
                    <button class="btoninfocliente" type="submit">Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>

@endsection
@section('scripts')
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function openModal(productName, productSeries, productDiagnosis, productId, descripcion) {
            document.getElementById('modalTitle').innerText = productName;
            document.getElementById('modalSeries').innerText = productSeries;
            document.getElementById('modalDiagnosis').innerText = productDiagnosis;
            document.getElementById('detalle_id').value = productId;
            document.getElementById('descripcion_os').value = descripcion;
            document.getElementById('productModal').style.display = "block";
            setTimeout(() => {
                document.getElementById('productModal').classList.add('show');
            }, 10);
        }

        function closeModal() {
            document.getElementById('productModal').classList.remove('show');
            setTimeout(() => {
                document.getElementById('productModal').style.display = "none";
            }, 300);
        }
    </script>

    <script>
            document.getElementById('orden-servicio-text').addEventListener('click', function() {
            document.getElementById('orden-servicio-text').style.display = 'none';
            document.getElementById('orden-servicio-input').style.display = 'inline';
            document.getElementById('orden-servicio-input').focus();
        });

        function saveOrdenServicio() {
            var newOrden = document.getElementById('orden-servicio-input').value;

            console.log("Nuevo valor de Orden de servicio: " + newOrden);
            document.getElementById('orden-servicio-text').style.display = 'inline';
            document.getElementById('orden-servicio-input').style.display = 'none';
            document.getElementById('orden-servicio-text').textContent = newOrden || 'No asignada';
        }
    </script>
    <script>
        // Función para ocultar las alertas después de cierto tiempo
        function hideAlerts() {
            const alerts = document.querySelectorAll('.alert');

            if (alerts.length > 0) {
                setTimeout(function() {
                    alerts.forEach(function(alert) {
                        alert.style.opacity = '0';
                        alert.style.transition = 'opacity 0.5s';

                        setTimeout(function() {
                            alert.style.display = 'none';
                        }, 500);
                    });
                }, 5000);
            }
        }

        document.addEventListener('DOMContentLoaded', hideAlerts);
    </script>
@endsection
