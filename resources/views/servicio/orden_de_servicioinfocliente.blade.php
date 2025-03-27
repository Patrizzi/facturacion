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
            </div>
        </div>
    </div>


    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }


        .section-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .client-info, .guide, .products {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
        }

        .client-info h3, .guide h3, .products h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 15px;
        }

        .client-info , .guide , .products  {
            font-size: 16px;
            color: #555;
        }

        .product-list {
            list-style-type: none;
            padding: 0;
        }

        .product-item {
            background-color: #fff;
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 5px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .product-item h4 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .short-description {
            font-size: 14px;
            color: #777;
        }

        .button {
            padding: 12px 20px;
            background-color:#1538A0;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            text-align: center;
            width: 100%;
            font-weight: bold;
        }

        .button:hover {
            background-color: #0056b3;
        }

        /* Modal */
        .modal {
            display: none;  /* Hidden by default */
            position: fixed;
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4); /* Black with transparency */
            opacity: 0;
            transition: opacity 0.3s ease; /* Suaviza la transición de aparición */

        }

        .modal.show {
            opacity: 1;

        }

        .modal-content {
            background: #dbdbdb;
            margin: 15% auto;
            padding: 10px;
            border: 1px solid #888;
            width: 65%;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            animation: modalFadeIn 0.5s ease-out;
            display: flex;
        }

        @keyframes modalFadeIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        .SD{
            font-size: 20px;
        }
        .ST{
            font-size: 40px;
            font-weight: bold;

        }

        .modal-left {
            width: 100%;
            padding-right: 20px;
        }

        .modal-right {
            width: 100%;
        }

        .product-image {
            width: 100%;
            height: 200px;
            background-color: #ddd;
        }

        .modal .close {
            color: #000000;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 30px;
            cursor: pointer;
        }

        .modal .close:hover,
        .modal .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

    </style>



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
