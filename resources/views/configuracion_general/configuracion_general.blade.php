@extends('layout')

@section('title', 'Configuración Sistema')
@section('atributo_actu', 'hidden')
@section('atributo_1', 'hidden')

@section('content')

    <style>
        /* Estilos globales para asegurar el comportamiento */
        .card-hover {
            transition: all 0.3s ease-in-out;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eee !important;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            cursor: pointer;
        }

        .img-container {
            width: 100%;
            height: 160px;
            /* Altura fija para que todas sean iguales */
            overflow: hidden;
            background-color: #f9f9f9;
            position: relative;
        }

        .img-container .img-bg {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Recorta la imagen para llenar el espacio sin deformar */
            transition: transform 0.5s ease;
        }

        .img-container .img-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;

            z-index: 2;
        }

        .card-hover:hover .img-container .img-bg {
            transform: scale(1.1);
            /* Zoom suave al pasar el mouse */
        }

        .card-title-custom {
            font-size: 14px;
            font-weight: 500;
            color: #555;
            margin: 0;
            text-transform: capitalize;
        }
    </style>

    <div class="container my-5">
        <div class="row">

            @can('almacen.listar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm" id="almacen_button" style="cursor: pointer">
                        <div class="img-container">
                            <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                alt="Almacen" class="img-bg">
                            <img src="https://png.pngtree.com/png-vector/20240314/ourmid/pngtree-warehouse-flat-composition-png-image_11961969.png"
                                alt="Icono Almacen" class="img-overlay">
                        </div>
                        <div class="card-body text-center p-3">
                            <h6 class="card-title-custom">Almacen</h6>
                        </div>
                    </div>
                </div>
            @endcan

            @can('almacen.listar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm">
                        <a href=" {{ route('almacen.index') }} ">
                            <div class="img-container">
                                <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                    alt="Almacen" class="img-bg">
                                <img src="https://png.pngtree.com/png-vector/20240314/ourmid/pngtree-warehouse-flat-composition-png-image_11961969.png"
                                    alt="Icono Almacen" class="img-overlay">
                            </div>
                            <div class="card-body text-center p-3">
                                <h6 class="card-title-custom">Almacen</h6>
                            </div>
                        </a>
                    </div>
                </div>
            @endcan

            @can('apariencia.ver')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm">
                        <a href="{{ route('apariencia.index') }}">
                            <div class="img-container">
                                <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                    alt="Apariencia" class="img-bg">
                                <img src="https://www.gsmarketing.com/hubfs/New%20Website%20Images/illustrations%20/digital%20solutions-display.png"
                                    alt="Icono Apariencia" class="img-overlay">
                            </div>
                            <div class="card-body text-center p-3">

                                <h6 class="card-title-custom">Apariencia</h6>
                            </div>
                        </a>
                    </div>
                </div>
            @endcan

            {{-- Esto no deberia, pero no se puede eliminar para saber cual llama a cual --}}
            {{-- <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 card-hover shadow-sm">
                <div class="card h-100 card-hover shadow-sm" id="categorias_button" style="cursor: pointer;">
                    <div class="img-container">
                        <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="Categoria" class="img-bg">
                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/jerarquia-4721274-3927987.png" alt="Icono Categoria" class="img-overlay">
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="card-title-custom">Categoria</h6>
                    </div>
                </div>
            </div>
        </div> --}}

            @can('familia.listar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm">
                        <div class="card h-100 card-hover shadow-sm" id="familia_button" style="cursor: pointer;">
                            <div class="img-container">
                                <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                    alt="Familias" class="img-bg">
                                <img src="https://cdn3d.iconscout.com/3d/premium/thumb/producto-10808619-8687861.png"
                                    alt="Icono Familias" class="img-overlay">
                            </div>
                            <div class="card-body text-center p-3">
                                <h6 class="card-title-custom">Familias</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('garantia_doc.listar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm">
                        <div class="card h-100 card-hover shadow-sm" id="garantia_button" style="cursor: pointer;">
                            <div class="img-container">
                                <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                    alt="Garantia" class="img-bg">
                                <img src="https://static.vecteezy.com/system/resources/previews/047/649/375/original/3d-golden-shield-icon-isolated-on-transparent-background-png.png"
                                    alt="Icono Garantia" class="img-overlay">
                            </div>
                            <div class="card-body text-center p-3">
                                <h6 class="card-title-custom">Garantia</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('marcas.listar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm">
                        <div class="card h-100 card-hover shadow-sm" id="marcas_button" style="cursor: pointer;">
                            <div class="img-container">
                                <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                    alt="Marcas" class="img-bg">
                                <img src="https://static.vecteezy.com/system/resources/previews/015/329/405/original/brand-3d-illustration-icon-png.png"
                                    alt="Icono Marcas" class="img-overlay">
                            </div>
                            <div class="card-body text-center p-3">
                                <h6 class="card-title-custom">Marcas</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('motivos.listar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm">
                        <div class="card h-100 card-hover shadow-sm" id="motivos_button" style="cursor: pointer;">
                            <div class="img-container">
                                <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                    alt="Motivos" class="img-bg">
                                <img src="https://static.vecteezy.com/system/resources/previews/028/272/877/original/puzzle-3d-rendering-isometric-icon-png.png"
                                    alt="Icono Motivos" class="img-overlay">
                            </div>
                            <div class="card-body text-center p-3">
                                <h6 class="card-title-custom">Motivos</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- @can('tipo_cambio.listar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm">
                        <a href="{{ route('tipo_cambio.index') }}">
                            <div class="img-container">
                                <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                    alt="Tipo de cambio" class="img-bg">
                                <img src="https://cdn3d.iconscout.com/3d/premium/thumb/tipo-de-cambio-8578991-6805151.png"
                                    alt="Icono Tipo de cambio" class="img-overlay">
                            </div>
                            <div class="card-body text-center p-3">
                                <h6 class="card-title-custom">Tipo de cambio</h6>
                            </div>
                        </a>
                    </div>
                </div>
            @endcan --}}

            @can('tipo_cambio.listar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm" id="tipo_cambio_button" style="cursor: pointer;">
                        {{-- <a href="{{ route('tipo_cambio.index') }}"> --}}
                        <div class="img-container">
                            <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                alt="Tipo de cambio" class="img-bg">
                            <img src="https://cdn3d.iconscout.com/3d/premium/thumb/tipo-de-cambio-8578991-6805151.png"
                                alt="Icono Tipo de cambio" class="img-overlay">
                        </div>
                        <div class="card-body text-center p-3">
                            <h6 class="card-title-custom">Tipo de cambio</h6>
                        </div>
                        {{-- </a> --}}
                    </div>
                </div>
            @endcan

            @can('unidad_m.listar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm" id="medida_button" style="cursor: pointer;">
                        <div class="img-container">
                            <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                alt="U. de medida" class="img-bg">
                            <img src="https://cdn3d.iconscout.com/3d/premium/thumb/measuring-3d-icon-download-in-png-blend-fbx-gltf-file-formats--rulerbow-compass-navigation-office-pack-tools-equipment-icons-10967888.png"
                                alt="Icono U. de medida" class="img-overlay">
                        </div>
                        <div class="card-body text-center p-3">
                            <h6 class="card-title-custom">U. de medida</h6>
                        </div>
                    </div>
                </div>
            @endcan

            @can('usuarios.listar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm">
                        <a href="{{ route('usuario.index') }}">
                            <div class="img-container">
                                <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                    alt="Usuarios" class="img-bg">
                                <img src="https://static.vecteezy.com/system/resources/previews/060/498/831/non_2x/fascinating-acclaimed-facial-recognition-software-icon-with-transparent-background-free-png.png"
                                    alt="Icono Usuarios" class="img-overlay">
                            </div>
                            <div class="card-body text-center p-3">
                                <h6 class="card-title-custom">Usuarios</h6>
                            </div>
                        </a>
                    </div>
                </div>
            @endcan

            @can('validez.listar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm" id="validez_button" style="cursor: pointer;">
                        <div class="img-container">
                            <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                alt="Validez" class="img-bg">
                            <img src="https://static.vecteezy.com/system/resources/thumbnails/048/721/469/small_2x/a-green-check-mark-the-check-mark-is-a-symbol-of-approval-or-satisfaction-png.png"
                                alt="Icono Validez" class="img-overlay">
                        </div>
                        <div class="card-body text-center p-3">
                            <h6 class="card-title-custom">Validez</h6>
                        </div>
                    </div>
                </div>
            @endcan

            @can('alarma.istar')
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 card-hover shadow-sm" id="alarma_button" style="cursor: pointer;">
                        <div class="img-container">
                            <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg"
                                alt="Alarma" class="img-bg">
                            <img src="https://static.vecteezy.com/system/resources/previews/049/886/531/non_2x/distinctive-3d-bell-icon-with-fine-rendering-and-transparent-background-tailored-for-high-end-digital-design-projects-free-png.png"
                                alt="Icono Alarma" class="img-overlay">
                        </div>
                        <div class="card-body text-center p-3">
                            <h6 class="card-title-custom">Alarma</h6>
                        </div>
                    </div>
                </div>
            @endcan

        </div>
    </div>


    <!--
              <div class="wrapper wrapper-content animated fadeInRight">
                <div class="col">
                    <div class="col-lg-4">
                        <div class="ibox">
                            <div class="">
                                <div class="">
                                     Elementos de la fila -->
    <!-- <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                       <button class="btn btn-success dim tam pt-4" type="button">
                                            <a href="{{ route('almacen.index') }}">
                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/almacen.svg') }}"
                                                    width="50px" alt="">
                                                <p class="pt-md-3 display-6 fs-4 text-white">ALMACÉN</p>
                                            </a>
                                        </button>-->



    <!--
                                        <a href="{{ route('almacen.index') }}">
                                        <div class="card" style="width: 18rem;">
                                            <img  src="https://www.scmlogistica.es/wp-content/uploads/como-poner-en-marcha-un-pequeno-almacen.jpg" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h1 class="card-title">Almacen</h1>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-3 col-md-6 d-flex     justify-content-center my-md-4">
                                        <button class="btn btn-success dim tam pt-4" type="button">
                                            <a href="{{ route('apariencia.index') }}">
                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/apariencia.svg') }}"
                                                    width="50px" alt="">
                                                <p class="pt-md-3 display-6 fs-4 text-white">APARIENCIA</p>
                                            </a>
                                        </button>
                                    </div>

                                    <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                       <button class="btn btn-success dim tam pt-4" type="button" id="categorias_button">
                                           <a data-toggle="modal" href="#modal-forms7">
                                               <img class="rounded bg-white p-2" src="{{ asset('img/logos/categoria.svg') }}"
                                                   width="50px" alt="">
                                               <p class="pt-md-3 display-6 fs-4 text-white">CATEGORIAS</p>
                                           </a>
                                       </button>
                                   </div>

                                     <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                        <button class="btn btn-success dim tam pt-4" type="button"> </a>
                                             <a data-toggle="modal" href="#modal-forms5">
                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/categoria.svg') }}"
                                                    width="50px" alt="">
                                                <p class="pt-md-3 display-6 fs-4 text-white">CATEGORÍAS</p>
                                            </a>
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                        <button class="btn btn-success dim tam pt-4" type="button" id="familia_button">
                                            <a data-toggle="modal" href="">
                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/familia.svg') }}"
                                                    width="50px" alt="">
                                                <p class="pt-md-3 display-6 fs-4 text-white">FAMILIAS</p>
                                            </a>
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                        <button class="btn btn-success dim tam pt-4" type="button" id="garantia_button">
                                            <a data-toggle="modal" href="">
                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/garantia.png') }}"
                                                    width="50px" alt="">
                                                <p class="pt-md-3 display-6 fs-4 text-white">GARANTÍA</p>
                                            </a>
                                        </button>
                                    </div>

                                    <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                        <button class="btn btn-success dim tam pt-4" type="button" id="marcas_button">
                                            <a data-toggle="modal" href="#modal-forms7">
                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/marca.svg') }}"
                                                    width="50px" alt="">
                                                <p class="pt-md-3 display-6 fs-4 text-white">MARCAS</p>
                                            </a>
                                        </button>
                                    </div>

                                    <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                        <button class="btn btn-success dim tam pt-4" type="button" id="motivos_button">
                                            <a data-toggle="modal" href="#modal-forms3">
                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/motivo.svg') }}"
                                                    width="50px" alt="">
                                                <p class="pt-md-3 display-6 fs-4 text-white">MOTIVOS</p>
                                            </a>
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                        <button class="btn btn-success dim tam pt-4" type="button" id="tipo_cambio_button">                                                                                                                                                                     </a>
                                            <a data-toggle="modal" href="#modal-forms">
                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/tipo-cambio.svg') }}"
                                                    width="50px" alt="">
                                                <p class="pt-md-3 display-6 fs-4 text-white">TIPO CAMBIO</p>
                                            </a>
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                        <button class="btn btn-success dim tam pt-4" type="button" id="medida_button">-->
    </a>-->

    <!--                                                                                                                                                <a data-toggle="modal" href="">
                                                <img class="rounded bg-white p-2"
                                                    src="{{ asset('img/logos/unidad_medida.svg') }}" width="50px"
                                                    alt="">
                                                <p class="pt-md-3 display-6 fs-4 text-white">U.DE MEDIDA</p>
                                            </a>
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                        <button class="btn btn-success dim tam pt-4" type="button">
                                            <a href="{{ route('usuario.index') }}">
                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/usuarios.svg') }}"
                                                    width="50px" alt="">
                                                <p class="pt-md-3 display-6 fs-4 text-white">USUARIOS</p>
                                            </a>
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                       <button class="btn btn-success dim tam pt-4" type="button" id="validez_button">
                                           <a data-toggle="modal" href="">
                                               <img class="rounded bg-white p-2" src="{{ asset('img/logos/validez.png') }}"
                                                   width="50px" alt="">
                                               <p class="pt-md-3 display-6 fs-4 text-white">VALIDEZ</p>
                                           </a>
                                       </button>
                                   </div>
                                   <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                       <button class="btn btn-success dim tam pt-4" type="button" id="alarma_button">
                                           <a data-toggle="modal" href="">
                                               <img class="rounded bg-white p-2" src="{{ asset('img/logos/moneda.svg') }}"
                                                   width="50px" alt="">
                                               <p class="pt-md-3 display-6 fs-4 text-white">ALARMA</p>
                                           </a>
                                       </button>
                                   </div></a>
                                    <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        -->

    @include('configuracion_general.almacen.modal_list')

    @include('configuracion_general.tipo_cambio.modal_list')

    @include('configuracion_general.unidad-de-medida.modal_create')

    @include('configuracion_general.motivo.modal_create')

    @include('configuracion_general.garantia.modal_create')

    @include('configuracion_general.categoria.modal_create')

    @include('configuracion_general.familia.modal_create')

    @include('configuracion_general.marca.modal_create')

    @include('configuracion_general.validez.modal_create')

    @include('configuracion_general.alarma.modal_create')

    {{-- @include('configuracion_general.tipo_cambio.modal_create') --}}

    <div id="blueimp-gallery" class="blueimp-gallery">
        <div class="slides"></div>
    </div>

    <style>
        .img-wrap {
            height: 200px;
            /* Ajusta este valor según qué tan altas quieras las fotos */
            overflow: hidden;
            /* Corta lo que sobresalga */
            background-color: #f8f9fa;
            /* Color de fondo por si la imagen tarda en cargar */
        }

        .img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Mantiene la proporción recortando los bordes */
            object-position: center;
            transition: transform 0.5s ease;
        }

        /* 2. La tarjeta completa */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            /* Evita que la imagen se salga de las esquinas redondeadas */
        }

        .card-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            z-index: 10;
            cursor: pointer;
        }

        .card-body {
            text-align: center;
            padding: 15px;
        }

        .card-title {
            font-size: 1.1rem;
            /* Usar rem es mejor para diseño responsivo */
            margin: 0;
            font-weight: 400;
            text-transform: capitalize;
            /* Opcional: Primera letra en mayúscula */
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

        .familia_descripcion {
            text-align: left;
        }

        .modal.fade.modal-xl-manual.show {
            /* left: 18%; */
        }

        .modal-xl-manual {
            margin: auto;
            max-width: 1140px !important;
            /* width: 1140px !important; */
        }

        .img_marcas {
            height: 100%;
            width: 100%;
        }

        td {
            vertical-align: middle !important;
        }

        .button_estado_marca,
        .button_estado_familia {
            text-align: center
        }

        .custom-file-label>* {
            text-overflow: ellipsis;
        }

        .dataTables-marcas,
        .dataTables-garantia,
        .dataTables-validez,
        .dataTables-categorias,
        .dataTables-familias,
        .dataTables-medidas,
        .dataTables-motivos tbody tr {
            cursor: pointer;
        }

        .tooltip.fade.show {
            z-index: 999999;
        }
    </style>

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>

    <!-- Data picker -->
    <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script src="{{ asset('js/plugins/jqueryMask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jsKnob/jquery.knob.js') }}"></script>
    <script src="{{ asset('js/plugins/nouslider/jquery.nouislider.min.js') }}"></script>
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    <script src="{{ asset('js/plugins/ionRangeSlider/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/clockpicker/clockpicker.js') }}"></script>
    <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('js/plugins/dualListbox/jquery.bootstrap-duallistbox.js') }}"></script>
    <script src="{{ asset('js/plugins/cropper/cropper.min.js') }}"></script>

    <script src="{{ asset('js/plugins/blueimp/jquery.blueimp-gallery.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!--Unidad de medida-->

    @include('configuracion_general.almacen.scripts')

    @include('configuracion_general.unidad-de-medida.scripts')

    @include('configuracion_general.familia.scripts')

    @include('configuracion_general.marca.scripts')

    @include('configuracion_general.categoria.scripts')
    
    @include('configuracion_general.garantia.scripts')

    @include('configuracion_general.validez.scripts')

    @include('configuracion_general.tipo_cambio.scripts')

    @include('configuracion_general.motivo.scripts')
    


    <script>
        $(document).ready(function() {
            table4 = $('.dataTables-medida').DataTable({
                pageLength: 12,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'ExampleFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'ExampleFile'
                    },

                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]

            });
            $('input[name="daterangemedida"]').daterangepicker({

                    "locale": {
                        "separator": " | ",
                        "applyLabel": "Guardar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Custom",
                        "daysOfWeek": [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    }
                },
                function(start, end, label) {
                    var dates = [];
                    var currentDate = new Date(start);
                    while (currentDate <= end) {
                        var day = ('0' + currentDate.getDate()).slice(-2);
                        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                        var year = currentDate.getFullYear();

                        var formattedDate = day + '-' + month + '-' + year;
                        dates.push(formattedDate);

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    var dateRangeString = dates.join('|');
                    console.log(dateRangeString);
                    table4.column(5).search(dateRangeString, true, false).draw();
                }
            );
        });

        function limpiar_select() {
            table4.column(5).search("").draw();
        }

        function revert_select() {
            table4.column(5).search(`{{ date('m-Y') }}`).draw();
        }
    </script>

    <style>
        .dropdown-menu {
            left: 70px;
            padding: 20px 0;
        }

        #DataTables_Table_0_wrapper {
            padding-right: 0px;
            padding-left: 0px;
        }

        .table {
            width: 100% !important;
        }

        .ibox-content>.row {
            margin: auto;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

        });
    </script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            table = $('.dataTables-example-facturacion').DataTable({
                pageLength: 10,
                order: [
                    [0, "desc"]
                ],
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                footerCallback: function(tr, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(5)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total filtered rows on the selected column (code part added)
                    var sumCol4Filtered = display.map(el => data[el][5]).reduce((a, b) => intVal(a) +
                        intVal(b), 0);

                    // Update footer
                    $(api.column(5).footer()).html(
                        'S/ ' + Math.round(sumCol4Filtered * 100) / 100
                    );
                },
                buttons: []
            });

            revert_select();

            $(document).on('change', '#select_tipo_coti', function(event) {
                var nombre = $("#select_tipo_coti option:selected").val();
                // console.log(nombre);
                table.column(11).search(nombre).draw();
            });
            $('input[name="daterange"]').daterangepicker({
                    "locale": {
                        "separator": " | ",
                        "applyLabel": "Guardar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Custom",
                        "daysOfWeek": [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    }
                },
                function(start, end, label) {
                    var dates = [];
                    var currentDate = new Date(start);
                    while (currentDate <= end) {
                        var day = ('0' + currentDate.getDate()).slice(-2);
                        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                        var year = currentDate.getFullYear();

                        var formattedDate = day + '-' + month + '-' + year;
                        dates.push(formattedDate);

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    var dateRangeString = dates.join('|');
                    console.log(dateRangeString);
                    table.column(4).search(dateRangeString, true, false).draw();
                }
            );
        });

        $(".select2_demo_1").select2();
        $(".select2_demo_2").select2();
        $(".select2_demo_3").select2({
            placeholder: "Tipo",
            allowClear: true
        });

        function limpiar_select() {
            table.column(4).search("").draw();
        }

        function revert_select() {
            table.column(4).search(`{{ date('m-Y') }}`).draw();
        }
    </script>
@stop
