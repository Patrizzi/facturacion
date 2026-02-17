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
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        cursor: pointer;
    }

    .img-container {
        width: 100%;
        height: 160px; /* Altura fija para que todas sean iguales */
        overflow: hidden;
        background-color: #f9f9f9;
        position: relative;
    }

    .img-container .img-bg {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Recorta la imagen para llenar el espacio sin deformar */
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
        transform: scale(1.1); /* Zoom suave al pasar el mouse */
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

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            
            <div class="card h-100 card-hover shadow-sm">
                    <a href=" {{ route('almacen.index') }} ">
                    <div class="img-container">
                        <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="Almacen" class="img-bg">
                        <img src="https://png.pngtree.com/png-vector/20240314/ourmid/pngtree-warehouse-flat-composition-png-image_11961969.png" alt="Icono Almacen" class="img-overlay">
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="card-title-custom">Almacen</h6>
                    </div>
                </a>
                </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 card-hover shadow-sm">
                <a href="{{ route('apariencia.index') }}">
                    <div class="img-container">
                        <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="Apariencia" class="img-bg">
                        <img src="https://www.gsmarketing.com/hubfs/New%20Website%20Images/illustrations%20/digital%20solutions-display.png"  alt="Icono Apariencia" class="img-overlay">
                    </div>
                    <div class="card-body text-center p-3">
                        
                        <h6 class="card-title-custom">Apariencia</h6>
                    </div>
                </a>
            </div>
        </div>

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

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 card-hover shadow-sm">
                <div class="card h-100 card-hover shadow-sm" id="familia_button" style="cursor: pointer;">
                    <div class="img-container">
                        <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="Familias" class="img-bg">
                        <img src="https://cdn3d.iconscout.com/3d/premium/thumb/producto-10808619-8687861.png" alt="Icono Familias" class="img-overlay">
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="card-title-custom">Familias</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 card-hover shadow-sm">
                <div class="card h-100 card-hover shadow-sm" id="garantia_button" style="cursor: pointer;">
                    <div class="img-container">
                        <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="Garantia" class="img-bg">
                        <img src="https://static.vecteezy.com/system/resources/previews/047/649/375/original/3d-golden-shield-icon-isolated-on-transparent-background-png.png" alt="Icono Garantia" class="img-overlay">
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="card-title-custom">Garantia</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 card-hover shadow-sm">
                <div class="card h-100 card-hover shadow-sm" id="marcas_button" style="cursor: pointer;">
                    <div class="img-container">
                        <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="Marcas" class="img-bg">
                        <img src="https://static.vecteezy.com/system/resources/previews/015/329/405/original/brand-3d-illustration-icon-png.png" alt="Icono Marcas" class="img-overlay">
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="card-title-custom">Marcas</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 card-hover shadow-sm">                
                <div class="card h-100 card-hover shadow-sm" id="motivos_button" style="cursor: pointer;">
                    <div class="img-container">
                        <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="Motivos" class="img-bg">
                        <img src="https://static.vecteezy.com/system/resources/previews/028/272/877/original/puzzle-3d-rendering-isometric-icon-png.png" alt="Icono Motivos" class="img-overlay">
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="card-title-custom">Motivos</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 card-hover shadow-sm">
                <a href="{{ route('tipo_cambio.index') }}">
                <div class="img-container">
                    <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="Tipo de cambio" class="img-bg">
                    <img src="https://cdn3d.iconscout.com/3d/premium/thumb/tipo-de-cambio-8578991-6805151.png" alt="Icono Tipo de cambio" class="img-overlay">
                </div>
                <div class="card-body text-center p-3">
                    <h6 class="card-title-custom">Tipo de cambio</h6>
                </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 card-hover shadow-sm" id="medida_button" style="cursor: pointer;">
                <div class="img-container">
                    <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="U. de medida" class="img-bg">
                    <img src="https://cdn3d.iconscout.com/3d/premium/thumb/measuring-3d-icon-download-in-png-blend-fbx-gltf-file-formats--rulerbow-compass-navigation-office-pack-tools-equipment-icons-10967888.png" alt="Icono U. de medida" class="img-overlay">
                </div>
                <div class="card-body text-center p-3">
                    <h6 class="card-title-custom">U. de medida</h6>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 card-hover shadow-sm">
                <a href="{{ route('usuarios.index') }}">
                    <div class="img-container">
                        <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="Usuarios" class="img-bg">
                        <img src="https://static.vecteezy.com/system/resources/previews/060/498/831/non_2x/fascinating-acclaimed-facial-recognition-software-icon-with-transparent-background-free-png.png" alt="Icono Usuarios" class="img-overlay">
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="card-title-custom">Usuarios</h6>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 card-hover shadow-sm" id="validez_button" style="cursor: pointer;">
                <div class="img-container">
                    <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="Validez" class="img-bg">
                    <img src="https://static.vecteezy.com/system/resources/thumbnails/048/721/469/small_2x/a-green-check-mark-the-check-mark-is-a-symbol-of-approval-or-satisfaction-png.png" alt="Icono Validez" class="img-overlay">
                </div>
                <div class="card-body text-center p-3">
                    <h6 class="card-title-custom">Validez</h6>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 card-hover shadow-sm" id="alarma_button" style="cursor: pointer;">
                <div class="img-container">
                    <img src="https://img.freepik.com/fotos-premium/abstract-background-images-wallpaper-ai-generated_643360-68582.jpg" alt="Alarma" class="img-bg">
                    <img src="https://static.vecteezy.com/system/resources/previews/049/886/531/non_2x/distinctive-3d-bell-icon-with-fine-rendering-and-transparent-background-tailored-for-high-end-digital-design-projects-free-png.png" alt="Icono Alarma" class="img-overlay">
                </div>
                <div class="card-body text-center p-3">
                    <h6 class="card-title-custom">Alarma</h6>
                </div>
            </div>
        </div>

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
                                    <a href="{{ route('usuarios.index') }}">
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
                                <!-- ELEMENTO FANTASMA - RELLENO
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
-->

    @include('configuracion_general.tipo_cambio.modal_create')

    @include('configuracion_general.unidad-de-medida.modal_create')

    @include('configuracion_general.motivo.modal_create')

    @include('configuracion_general.garantia.modal_create')

    @include('configuracion_general.categoria.modal_create')

    @include('configuracion_general.familia.modal_create')

    @include('configuracion_general.marca.modal_create')

    @include('configuracion_general.validez.modal_create')

    @include('configuracion_general.alarma.modal_create')

    <div id="blueimp-gallery" class="blueimp-gallery">
        <div class="slides"></div>
    </div>
    <!-- fin código Gaby-->
    <style>


    /* 1. Contenedor de la imagen: Define la altura fija */


    /* 2. La imagen en sí: Se ajusta para cubrir el hueco */
    /* 1. Definir un tamaño fijo para el contenedor de la imagen */
.img-wrap {
    height: 200px; /* Ajusta este valor según qué tan altas quieras las fotos */
    overflow: hidden; /* Corta lo que sobresalga */
    background-color: #f8f9fa; /* Color de fondo por si la imagen tarda en cargar */
}

.img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Mantiene la proporción recortando los bordes */
    object-position: center;
    transition: transform 0.5s ease;
}

/* 2. La tarjeta completa */
.card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    overflow: hidden; /* Evita que la imagen se salga de las esquinas redondeadas */
}

.card-hover:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    z-index: 10;
    cursor: pointer;
}

.card-body {
    text-align: center;
    padding: 15px;
}

.card-title {
    font-size: 1.1rem; /* Usar rem es mejor para diseño responsivo */
    margin: 0;
    font-weight: 400;
    text-transform: capitalize; /* Opcional: Primera letra en mayúscula */
}



        /* OCULTANDO LO DE ORGANIZAR*/
        /* Ver (números) */
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

        .button_estado_marca, .button_estado_familia {
            text-align: center
        }

        .custom-file-label>* {
            text-overflow: ellipsis;
        }

        .dataTables-marcas, .dataTables-garantia, .dataTables-validez ,.dataTables-categorias, .dataTables-familias, .dataTables-medidas, .dataTables-motivos tbody tr {
            cursor: pointer;
        }
        .tooltip.fade.show{
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
    <script>
       // MOSTRAR MODAL DE UNIDAD MEDIDA
       $('#medida_button').on('click', function() {
            $('#modal-medida').modal('show');
            if (!$.fn.DataTable.isDataTable('.dataTables-medidas')) {
                datatable_medida();
            } else {
                $('.dataTables-medidas').DataTable().ajax.reload();
            }
        });

        //FUNCION PARA CARGAR DATATABLE DE UNIDAD MEDIDA
        function datatable_medida() {
           let table = $('.dataTables-medidas').DataTable({
               "serverSide": true,
               "ajax": {
                   url: "{{ route('api.get_unidad_medida') }}",
                   method: "get",
                   data: function(d) {
                       d.value = $('#search_medida').val();
                   },
                   dataSrc: function(json) {
                       return json.data;
                   }
               },
               "pageLength": 8,
               "columnDefs": [{
                   sortable: false,
                   'targets': "_all"
               }]
            });
            table.on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
            });
        }
        //BUSQUEDA DE UNIDAD MEDIDA
        $('#search_medida').keyup(function() {
           $('.dataTables-medidas').DataTable().ajax.reload();
        });

        //  FUNCION PARA AGREGAR UNA NUEVA UNIDAD MEDIDA
        $('#add_new_medida').on('click', function() {
            let form = document.getElementById('form_medida');
            if (!form.checkValidity()) {
                form.reportValidity(); // Muestra los mensajes nativos del navegador
                return; // Detiene la ejecución si hay errores
            }
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('unidad_medida.save_ajax') }}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.dataTables-medidas').DataTable().ajax.reload();
                    $('#form_medida')[0].reset();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        //  EDITAR UNIDAD MEDIDA CON UN CLCIK EN EL ROW DEL DATATABLE
        $(document).on('click', '.dataTables-medidas tbody tr', function() {
            $('#form_medida')[0].reset();
            let table = $('.dataTables-medidas').DataTable();
            let data = table.row(this).data();
            let lastTd = $(this).find('td:last'); // Último td
            let secondLastTd = lastTd.prev(); // Penúltimo td

            /*if ($(event.target).is(lastTd) || $(event.target).is(secondLastTd) ||
                $(event.target).closest('td').is(lastTd) || $(event.target).closest('td').is(secondLastTd)) {
                return;
            }*/
            $('#update_medida').css('display', 'inline-block');
            $('#add_new_medida').css('display', 'none');
            //  PASAR DATA AL FORMULARIO
            $('#id_medida_edit').val(data[3]);
            $('#nombre_medida').val(data[1]);
            $('#simbolo_medida').val(data[0]);
            $('#unidad_medida').val(data[2]);
        });
        //  ACTUALIZAR UNIDAD MEDIDA
        $('#update_medida').on('click', function(event) {
            let table = $('.dataTables-medidas').DataTable();
            let data = table.row(this).data();

            var id_medida = $('#id_medida_edit').val();
            edit_medida(id_medida);
        })

        //  FUNCION PARA EDITAR UNIDAD MEDIDA
        function edit_medida(id) {
            let form = document.getElementById('form_medida');
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('unidad_medida.edit_ajax') }}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.dataTables-medidas').DataTable().ajax.reload();
                    $('#form_medida')[0].reset();
                    $('#update_medida').css('display', 'none');
                    $('#add_new_medida').css('display', 'inline-block');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
        //  CANCELAR EDICION DE UNIDAD MEDIDA  Y RESETEAR FORMULARIO
        $('#cancel_medida').on('click', function() {
            $('#form_medida')[0].reset();
            if ($('#add_new_medida').css('display') == 'inline-block') {
                console.log('si');
                $('#add_new_medida').css('display', 'inline-block');
                $('#update_medida').css('display', 'none');
            } else {
                $('#update_medida').css('display', 'none');
                $('#add_new_medida').css('display', 'inline-block');
            }
        });
    </script>

    <script>
       // MOSTRAR MODAL DE FAMILIAS
       $('#familia_button').on('click', function() {
            $('#modal-familia').modal('show');
            if (!$.fn.DataTable.isDataTable('.dataTables-familias')) {
                datatable_familias();
            } else {
                $('.dataTables-familias').DataTable().ajax.reload();
            }
        });

        //FUNCION PARA CARGAR DATATABLE DE FAMILIA
        function datatable_familias() {
            let table = $('.dataTables-familias').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_familias') }}",
                    method: "get",
                    data: function(d) {
                        d.value = $('#search_familia').val();
                    },
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                "pageLength": 8,
                "columnDefs": [
                    {
                        sortable: false,
                        'targets': "_all"
                    },
                    {
                        'targets': [4],
                        'render': function(data, type, full, meta) {
                            const url = `{{ route('familia.show', '__ID__') }}`.replace('__ID__', data);
                            return `
                                <a href="${url}" class="btn btn-success btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>`;
                        }
                    },
                    {
                        'targets': [5],
                        'className': 'button_estado_familia',
                        'render': function(data, type, full, meta) {
                            if (data == 0) {
                                return `
                                    <div class="tooltip-demo">
                                        <button class="btn btn-info btn-circle change_status_familia"
                                            data-toggle="tooltip" data-placement="left"
                                            title="Click para desactivar" value="${full[4]}" type="button">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </div>`;
                            }
                            return `
                                <div class="tooltip-demo">
                                    <button class="btn btn-danger btn-circle change_status_familia"
                                        value="${full[4]}" type="button"
                                        data-toggle="tooltip" data-placement="left"
                                        title="Click para activar">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>`;
                        }
                    }
                ]
            });

            table.on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
            });
        }

        //BUSQUEDA DE FAMILIA
        $('#search_familia').keyup(function() {
           $('.dataTables-familias').DataTable().ajax.reload();
        });
        // CAMBIAR ESTADO DE FAMILIA CON CLIC EN BOTON
        $(document).on('click', '.change_status_familia', function(event) {
            let id = $(this).val();
            $.ajax({
                url: "{{ route('familias.change_state') }}",
                method: "post",
                data: {
                    '_token': $('input[name=_token]').val(),
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('.dataTables-familias').DataTable().ajax.reload();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        //  FUNCION PARA AGREGAR UNA NUEVA FAMILIA
        $('#add_new_familia').on('click', function() {
            let form = document.getElementById('form_familia');
            if (!form.checkValidity()) {
                form.reportValidity(); // Muestra los mensajes nativos del navegador
                return; // Detiene la ejecución si hay errores
            }
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('familias.save_ajax') }}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.dataTables-familias').DataTable().ajax.reload();
                    $('#form_familia')[0].reset();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        //  EDITAR FAMILIA CON UN CLCIK EN EL ROW DEL DATATABLE
        $(document).on('click', '.dataTables-familias tbody tr', function() {
            $('#form_familia')[0].reset();
            let table = $('.dataTables-familias').DataTable();
            let data = table.row(this).data();
            let lastTd = $(this).find('td:last'); // Último td
            let secondLastTd = lastTd.prev(); // Penúltimo td

            if ($(event.target).is(lastTd) || $(event.target).is(secondLastTd) ||
                $(event.target).closest('td').is(lastTd) || $(event.target).closest('td').is(secondLastTd)) {
                return;
            }
            $('#update_familia').css('display', 'inline-block');
            $('#add_new_familia').css('display', 'none');
            //  PASAR DATA AL FORMULARIO
            $('#id_familia_edit').val(data[4]);
            $('#descripcion_familia').val(data[1]);
            $('#ubicacion_familia').val(data[2]);
        });
        //  ACTUALIZAR FAMILIA
        $('#update_familia').on('click', function(event) {
            let table = $('.dataTables-familias').DataTable();
            let data = table.row(this).data();

            var id_familia = $('#id_familia_edit').val();
            edit_familia(id_familia);
        })

        //  FUNCION PARA EDITAR FAMILIA
        function edit_familia(id) {
            let form = document.getElementById('form_familia');
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('familias.edit_ajax') }}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.dataTables-familias').DataTable().ajax.reload();
                    $('#form_familia')[0].reset();
                    $('#update_familia').css('display', 'none');
                    $('#add_new_familia').css('display', 'inline-block');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
        //  CANCELAR EDICION DE FAMILIA  Y RESETEAR FORMULARIO
        $('#cancel_familia').on('click', function() {
            $('#form_familia')[0].reset();
            if ($('#add_new_familia').css('display') == 'inline-block') {
                console.log('si');
                $('#add_new_familia').css('display', 'inline-block');
                $('#update_familia').css('display', 'none');
            } else {
                $('#update_familia').css('display', 'none');
                $('#add_new_familia').css('display', 'inline-block');
            }
        });
    </script>
    <script>/*
        $('#familia_button').on('click', function() {
            $('#modal-familia').modal('show');
            if (!$.fn.DataTable.isDataTable('.dataTables-familias')) {
                $('.dataTables-familias').DataTable({
                    "serverSide": true,
                    "ajax": {
                        url: "{{ route('api.get_familias') }}",
                        method: "get",
                        data: function(d) {},
                        dataSrc: function(json) {
                            return json.data;
                        }
                    },
                    "pageLength": 10,
                    "columnDefs": [{
                        'targets': [0]
                    }, {
                        'targets': [1],
                        'className': 'familia_descripcion'
                    }, {
                        'targets': [2]
                    }, {
                        'targets': [3]
                    }, {
                        'targets': [4],
                        'render': function(data, type, full, meta) {
                            return "<a href='{{ route('familia.show', '') }}/" + full[0] +
                                "'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i></button></a>";
                        }
                    }]
                });
            } else {
                // Si ya está inicializado, solo recarga los datos
                $('.dataTables-familias').DataTable().ajax.reload();
            }
        });*/

       //  $('#garantia_button').on('click', function() {
       //      $('#modal-garantia').modal('show');
       //      if (!$.fn.DataTable.isDataTable('.dataTables-garantia')) {
       //          $('.dataTables-garantia').DataTable({
       //              "serverSide": true,
       //              "ajax": {
       //                  url: "{{ route('api.get_garantias') }}",
       //                  method: "get",
       //                  data: function(d) {},
       //                  dataSrc: function(json) {
       //                      return json.data;
       //                  }
       //              },
       //              "pageLength": 10,
       //              "columnDefs": [{
       //                  'targets': [0]
       //              }, {
       //                  'targets': [1],
       //                  'className': 'garantia_descripcion'
       //              }, {
       //                  'targets': [2],
       //                  'render': function(data, type, full, meta) {
       //                      return "<a href='{{ route('garantia.show', '') }}/" + full[0] +
       //                          "'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i></button></a>";
       //                  }
       //              }]
       //          });
       //      } else {
       //          // Si ya está inicializado, solo recarga los datos
       //          $('.dataTables-garantia').DataTable().ajax.reload();
       //      }
       //  });

        //*  MOSTRAR MODAL DE MARCAS
        $('#marcas_button').on('click', function() {
            $('#modal-marcas').modal('show');
            if (!$.fn.DataTable.isDataTable('.dataTables-marcas')) {
                datatable_marcas();
            } else {
                $('.dataTables-marcas').DataTable().ajax.reload();
            }
        });
       //  FUNCION PARA CARGAR DATATABLE DE MARCAS
        function datatable_marcas() {
           let table = $('.dataTables-marcas').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_marcas') }}",
                    method: "get",
                    data: function(d) {
                        d.value = $('#search_marca').val();
                    },
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                "pageLength": 8,
                "columnDefs": [{
                    sortable: false,
                    'targets': "_all"
                }, {
                    'targets': [4],
                    'render': function(data, type, full, meta) {
                        if (!data || data.trim() === "") {
                            return `<center><i>Sin Imagen</i></center>`;
                        }
                        return `<div class="lightBoxGallery">
                                   <a href="{{ asset('archivos/imagenes/marcas/') }}/${data}" data-gallery=""><button class="btn btn-primary btn-sm "><i class="fa fa-eye"></i></button></a></div>`;
                    }
                }, {
                    'targets': [5],
                    'className': 'button_estado_marca',
                    'render': function(data, type, full, meta) {
                        if (data == 0) {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_marca" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[6]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                        }
                        return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_marca" value="${full[6]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
                    }
                }]
            });
            table.on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
            });
        }
       //  BUSQUEDA DE MARCA
        $('#search_marca').keyup(function() {
            $('.dataTables-marcas').DataTable().ajax.reload();
        });
       // AGREGAR IMAGEN A INPUT FILE DE MARCA
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
       //  FUNCION PARA AGREGAR UNA NUEVA MARCA
        $('#add_new_marca').on('click', function() {
            let form = document.getElementById('form_marca');
            if (!form.checkValidity()) {
                form.reportValidity(); // Muestra los mensajes nativos del navegador
                return; // Detiene la ejecución si hay errores
            }
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('marcas.save_ajax') }}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.dataTables-marcas').DataTable().ajax.reload();
                    $('#form_marca')[0].reset();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
       //  CAMBIAR ESTADO DE MARCA CON CLIC EN BOTON
        $(document).on('click', '.change_status_marca', function(event) {
            let id = $(this).val();
            $.ajax({
                url: "{{ route('marcas.change_state') }}",
                method: "post",
                data: {
                    '_token': $('input[name=_token]').val(),
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('.dataTables-marcas').DataTable().ajax.reload();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
       //  EDITAR MARCA CON UN CLCIK EN EL ROW DEL DATATABLE
        $(document).on('click', '.dataTables-marcas tbody tr', function() {
            $('#form_marca')[0].reset();
            let table = $('.dataTables-marcas').DataTable();
            let data = table.row(this).data();
            let lastTd = $(this).find('td:last'); // Último td
            let secondLastTd = lastTd.prev(); // Penúltimo td

            if ($(event.target).is(lastTd) || $(event.target).is(secondLastTd) ||
                $(event.target).closest('td').is(lastTd) || $(event.target).closest('td').is(secondLastTd)) {
                return;
            }
            $('#update_marca').css('display', 'inline-block');
            $('#add_new_marca').css('display', 'none');
            //  PASAR DATA AL FORMULARIO
            $('#abreviatura_marca').prop('disabled', true);
            $('#id_marca_edit').val(data[6]);
            $('#nombre_marca').val(data[0]);
            $('#abreviatura_marca').val(data[1]);
            $('#telefono_marca').val(data[2]);
            $('#descripcion_marca').val(data[3]);
            $('#file_marca').val(data[4]);
            $('#empresa_marca').val(data[7]);
            if (data[4] != null) {
                $('.custom-file-label').html('Cambiar Foto');
            } else {
                $('.custom-file-label').html('Agregar Foto');
            }
        });
       //  ACTUALIZAR MARCA
        $('#update_marca').on('click', function(event) {
            let table = $('.dataTables-marcas').DataTable();
            let data = table.row(this).data();

            var id_marca = $('#id_marca_edit').val();
            edit_marca(id_marca);
        })
       //  FUNCION PARA EDITAR MARCA
        function edit_marca(id) {
            let form = document.getElementById('form_marca');
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('marcas.edit_ajax') }}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.dataTables-marcas').DataTable().ajax.reload();
                    $('#form_marca')[0].reset();
                    $('#abreviatura_marca').prop('disabled', false);
                    $('#update_marca').css('display', 'none');
                    $('#add_new_marca').css('display', 'inline-block');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
       //  CANCELAR EDICION DE MARCA Y RESETEAR FORMULARIO
        $('#cancel_marca').on('click', function() {
            $('#form_marca')[0].reset();
            $('#abreviatura_marca').prop('disabled', false);
            if ($('#add_new_marca').css('display') == 'inline-block') {
                console.log('si');
                $('#add_new_marca').css('display', 'inline-block');
                $('#update_marca').css('display', 'none');
            } else {
                $('#update_marca').css('display', 'none');
                $('#add_new_marca').css('display', 'inline-block');
            }
        });

        //*  MOSTRAR MODAL DE CATEGORIAS
        $('#categorias_button').on('click', function() {
            $('#modal-categorias').modal('show');
            if (!$.fn.DataTable.isDataTable('.dataTables-categorias')) {
               datatable_categorias();
            } else {
                $('.dataTables-categorias').DataTable().ajax.reload();
            }
        });
        //  FUNCION PARA CARGAR DATATABLE DE CATEGORIAS
        function datatable_categorias() {
           let table = $('.dataTables-categorias').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_categorias') }}",
                    method: "get",
                    data: function(d) {
                        d.value = $('#search_categoria').val();
                    },
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                "pageLength": 8,
                "columnDefs": [{
                    sortable: false,
                    'targets': "_all"
                }, {
                    'targets': [2],
                    'className': 'button_estado_categoria',
                    'render': function(data, type, full, meta) {
                        if (data == 0) {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_categoria" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[3]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                        }
                        return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_categoria" value="${full[3]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
                    }
                }]
            });
            table.on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
            });
        }
             //  BUSQUEDA DE CATEGORIA
           $('#search_categoria').keyup(function() {
               $('.dataTables-categorias').DataTable().ajax.reload();
           });
           //  FUNCION PARA AGREGAR UNA NUEVA CATEGORIA
        $('#add_new_categoria').on('click', function() {
            let form = document.getElementById('form_categoria');
            if (!form.checkValidity()) {
                form.reportValidity(); // Muestra los mensajes nativos del navegador
                return; // Detiene la ejecución si hay errores
            }
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('categorias.save_ajax') }}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.dataTables-categorias').DataTable().ajax.reload();
                    $('#form_categoria')[0].reset();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
           //  CAMBIAR ESTADO DE CATEGORIA CON CLIC EN BOTON
           $(document).on('click', '.change_status_categoria', function(event) {
               let id = $(this).val();
               $.ajax({
                   url: "{{ route('categorias.change_state') }}",
                   method: "post",
                   data: {
                       '_token': $('input[name=_token]').val(),
                       id: id
                   },
                   success: function(data) {
                       console.log(data);
                       $('.dataTables-categorias').DataTable().ajax.reload();
                   },
                   error: function(data) {
                       console.log(data);
                   }
               });
           });
           //  EDITAR CATEGORIA CON UN CLCIK EN EL ROW DEL DATATABLE
           $(document).on('click', '.dataTables-categorias tbody tr', function() {
               $('#form_categoria')[0].reset();
               let table = $('.dataTables-categorias').DataTable();
               let data = table.row(this).data();
               let lastTd = $(this).find('td:last'); // Último td
               let secondLastTd = lastTd.prev(); // Penúltimo td

               if ($(event.target).is(lastTd) ||
                   $(event.target).closest('td').is(lastTd) ){
                   return;
               }
               $('#update_categoria').css('display', 'inline-block');
               $('#add_new_categoria').css('display', 'none');
               //  PASAR DATA AL FORMULARIO
               $('#codigo_categoria_edit').val(data[0]);
               $('#descripcion_categoria').val(data[1]);
               $('#id_categoria_edit').val(data[3]);

           });
           //  ACTUALIZAR CATEGORIA
           $('#update_categoria').on('click', function(event) {
               let table = $('.dataTables-categorias').DataTable();
               let data = table.row(this).data();

               var id_categoria = $('#codigo_categoria_edit').val();
               edit_categoria(id_categoria);
           })
           //  FUNCION PARA EDITAR CATEGORIA
           function edit_categoria(id) {
               let form = document.getElementById('form_categoria');
               let formData = new FormData(form);
               $.ajax({
                   url: "{{ route('categorias.edit_ajax') }}",
                   method: "post",
                   data: formData,
                   contentType: false,
                   processData: false,
                   success: function(data) {
                       console.log(data);
                       $('.dataTables-categorias').DataTable().ajax.reload();
                       $('#form_categoria')[0].reset();
                       $('#update_categoria').css('display', 'none');
                       $('#add_new_categoria').css('display', 'inline-block');
                   },
                   error: function(data) {
                       console.log(data);
                   }
               });
           }
           //  CANCELAR EDICION DE CATEGORIA Y RESETEAR FORMULARIO
           $('#cancel_categoria').on('click', function() {
               $('#form_categoria')[0].reset();
               if ($('#add_new_categoria').css('display') == 'inline-block') {
                   console.log('si');
                   $('#add_new_categoria').css('display', 'inline-block');
                   $('#update_categoria').css('display', 'none');
               } else {
                   $('#update_categoria').css('display', 'none');
                   $('#add_new_categoria').css('display', 'inline-block');
               }
           });

           //*  MOSTRAR MODAL DE GARANTIA
           $('#garantia_button').on('click', function() {
               $('#modal-garantia').modal('show');
               if (!$.fn.DataTable.isDataTable('.dataTables-garantia')) {
                   datatable_garantia();
               } else {
                   $('.dataTables-garantia').DataTable().ajax.reload();
               }
           });

           //  FUNCION PARA CARGAR DATATABLE DE GARANTIA
           function datatable_garantia() {
               let table = $('.dataTables-garantia').DataTable({
                   "serverSide": true,
                   "ajax": {
                       url: "{{ route('api.get_garantias') }}",
                       method: "get",
                       data: function(d) {
                           d.value = $('#search_garantia').val();
                       },
                       dataSrc: function(json) {
                           return json.data;
                       }
                   },
                   "pageLength": 8,
                   "columnDefs": [{
                       sortable: false,
                       'targets': "_all"
                   }, {
                       'targets': [1],
                       'className': 'button_estado_garantia',
                       'render': function(data, type, full, meta) {
                           if (data == 0) {
                               return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_garantia" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[2]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                           }
                           return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_garantia" value="${full[2]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
                       }
                   }]
               });
               table.on('draw.dt', function() {
                   $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
               });
           }
               //  BUSQUEDA DE GARANTIA
               $('#search_garantia').keyup(function() {
                   $('.dataTables-garantia').DataTable().ajax.reload();
               });
                //  FUNCION PARA AGREGAR UNA NUEVA GARANTIA
               $('#add_new_garantia').on('click', function() {
                   let form = document.getElementById('form_garantia');
                   if (!form.checkValidity()) {
                       form.reportValidity(); // Muestra los mensajes nativos del navegador
                       return; // Detiene la ejecución si hay errores
                   }
                   let formData = new FormData(form);
                   $.ajax({
                       url: "{{ route('garantia.save_ajax') }}",
                       method: "post",
                       data: formData,
                       contentType: false,
                       processData: false,
                       success: function(data) {
                           console.log(data);
                           $('.dataTables-garantia').DataTable().ajax.reload();
                           $('#form_garantia')[0].reset();
                       },
                       error: function(data) {
                           console.log(data);
                       }
                   });
               });
                //  CAMBIAR ESTADO DE GARANTIA CON CLIC EN BOTON
               $(document).on('click', '.change_status_garantia', function(event) {
                   let id = $(this).val();
                   $.ajax({
                       url: "{{ route('garantia.change_state') }}",
                       method: "post",
                       data: {
                           '_token': $('input[name=_token]').val(),
                           id: id
                       },
                       success: function(data) {
                           console.log(data);
                           $('.dataTables-garantia').DataTable().ajax.reload();
                       },
                       error: function(data) {
                           console.log(data);
                       }
                   });
               });
               //  EDITAR GARANTIA CON UN CLICK EN EL ROW DEL DATATABLE
               $(document).on('click', '.dataTables-garantia tbody tr', function() {
                   $('#form_garantia')[0].reset();
                   let table = $('.dataTables-garantia').DataTable();
                   let data = table.row(this).data();
                   let lastTd = $(this).find('td:last'); // Último td
                   let secondLastTd = lastTd.prev(); // Penúltimo td

                   if ($(event.target).is(lastTd) ||
                       $(event.target).closest('td').is(lastTd) ){
                       return;
                   }
                   $('#update_garantia').css('display', 'inline-block');
                   $('#add_new_garantia').css('display', 'none');
                   //  PASAR DATA AL FORMULARIO
                   $('#descripcion_garantia').val(data[0]);
                   $('#id_garantia_edit').val(data[2]);

               });
               //  ACTUALIZAR GARANTIA
               $('#update_garantia').on('click', function(event) {
                   let table = $('.dataTables-garantia').DataTable();
                   let data = table.row(this).data();

                   var id_garantia = $('#id_garantia_edit').val();
                   edit_garantia(id_garantia);
               })
               //  FUNCION PARA EDITAR GARANTIA
               function edit_garantia(id) {
                   let form = document.getElementById('form_garantia');
                   let formData = new FormData(form);
                   $.ajax({
                       url: "{{ route('garantia.edit_ajax') }}",
                       method: "post",
                       data: formData,
                       contentType: false,
                       processData: false,
                       success: function(data) {
                           console.log(data);
                           $('.dataTables-garantia').DataTable().ajax.reload();
                           $('#form_garantia')[0].reset();
                           $('#update_garantia').css('display', 'none');
                           $('#add_new_garantia').css('display', 'inline-block');
                       },
                       error: function(data) {
                           console.log(data);
                       }
                   });
               }
                //  CANCELAR EDICION DE GARANTIA Y RESETEAR FORMULARIO
               $('#cancel_garantia').on('click', function() {
                   $('#form_garantia')[0].reset();
                   if ($('#add_new_garantia').css('display') == 'inline-block') {
                       console.log('si');
                       $('#add_new_garantia').css('display', 'inline-block');
                       $('#update_garantia').css('display', 'none');
                   } else {
                       $('#update_garantia').css('display', 'none');
                       $('#add_new_garantia').css('display', 'inline-block');
                   }
               });


               //*  MOSTRAR MODAL DE VALIDEZ
               $('#validez_button').on('click', function() {
                   $('#modal-validez').modal('show');
                   if (!$.fn.DataTable.isDataTable('.dataTables-validez')) {
                       datatable_validez();
                   } else {
                       $('.dataTables-validez').DataTable().ajax.reload();
                   }
               });
               //  FUNCION PARA CARGAR DATATABLE DE VALIDEZ
               function datatable_validez() {
                   let table = $('.dataTables-validez').DataTable({
                       "serverSide": true,
                       "ajax": {
                           url: "{{ route('api.get_validez') }}",
                           method: "get",
                           data: function(d) {
                               d.value = $('#search_validez').val();
                           },
                           dataSrc: function(json) {
                               return json.data;
                           }
                       },
                       "pageLength": 8,
                       "columnDefs": [{
                           sortable: false,
                           'targets': "_all"
                       }, {
                           'targets': [1],
                           'className': 'button_estado_validez',
                           'render': function(data, type, full, meta) {
                               if (data == 0) {
                                   return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_validez" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[2]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                               }
                               return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_validez" value="${full[2]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
                           }
                       }]
                   });
                   table.on('draw.dt', function() {
                       $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
                   });
               }
                   //  BUSQUEDA DE VALIDEZ
                   $('#search_validez').keyup(function() {
                       $('.dataTables-validez').DataTable().ajax.reload();
                   });
                    //  FUNCION PARA AGREGAR UNA NUEVA VALIDEZ
                   $('#add_new_validez').on('click', function() {
                       let form = document.getElementById('form_validez');
                       if (!form.checkValidity()) {
                           form.reportValidity(); // Muestra los mensajes nativos del navegador
                           return; // Detiene la ejecución si hay errores
                       }
                       let formData = new FormData(form);
                       $.ajax({
                           url: "{{ route('validez.save_ajax') }}",
                           method: "post",
                           data: formData,
                           contentType: false,
                           processData: false,
                           success: function(data) {
                               console.log(data);
                               $('.dataTables-validez').DataTable().ajax.reload();
                               $('#form_validez')[0].reset();
                           },
                           error: function(data) {
                               console.log(data);
                           }
                       });
                   });
                    //  CAMBIAR ESTADO DE VALIDEZ CON CLIC EN BOTON
                   $(document).on('click', '.change_status_validez', function(event) {
                       let id = $(this).val();
                       $.ajax({
                           url: "{{ route('validez.change_state') }}",
                           method: "post",
                           data: {
                               '_token': $('input[name=_token]').val(),
                               id: id
                           },
                           success: function(data) {
                               console.log(data);
                               $('.dataTables-validez').DataTable().ajax.reload();
                           },
                           error: function(data) {
                               console.log(data);
                           }
                       });
                   });
                   //  EDITAR VALIDEZ CON UN CLICK EN EL ROW DEL DATATABLE
                   $(document).on('click', '.dataTables-validez tbody tr', function() {
                       $('#form_validez')[0].reset();
                       let table = $('.dataTables-validez').DataTable();
                       let data = table.row(this).data();
                       let lastTd = $(this).find('td:last'); // Último td
                       let secondLastTd = lastTd.prev(); // Penúltimo td

                       if ($(event.target).is(lastTd) ||
                           $(event.target).closest('td').is(lastTd) ){
                           return;
                       }
                       $('#update_validez').css('display', 'inline-block');
                       $('#add_new_validez').css('display', 'none');
                       //  PASAR DATA AL FORMULARIO
                       $('#descripcion_validez').val(data[0]);
                       $('#id_validez_edit').val(data[2]);

                   });
                    //  ACTUALIZAR VALIDEZ
                   $('#update_validez').on('click', function(event) {
                       let table = $('.dataTables-validez').DataTable();
                       let data = table.row(this).data();

                       var id_validez = $('#id_validez_edit').val();
                       edit_validez(id_validez);
                   })
                   //  FUNCION PARA EDITAR VALIDEZ
                   function edit_validez(id) {
                       let form = document.getElementById('form_validez');
                       let formData = new FormData(form);
                       $.ajax({
                           url: "{{ route('validez.edit_ajax') }}",
                           method: "post",
                           data: formData,
                           contentType: false,
                           processData: false,
                           success: function(data) {
                               console.log(data);
                               $('.dataTables-validez').DataTable().ajax.reload();
                               $('#form_validez')[0].reset();
                               $('#update_validez').css('display', 'none');
                               $('#add_new_validez').css('display', 'inline-block');
                           },
                           error: function(data) {
                               console.log(data);
                           }
                       });
                   }
                    //  CANCELAR EDICION DE VALIDEZ Y RESETEAR FORMULARIO
                   $('#cancel_validez').on('click', function() {
                       $('#form_validez')[0].reset();
                       if ($('#add_new_validez').css('display') == 'inline-block') {
                           console.log('si');
                           $('#add_new_validez').css('display', 'inline-block');
                           $('#update_validez').css('display', 'none');
                       } else {
                           $('#update_validez').css('display', 'none');
                           $('#add_new_validez').css('display', 'inline-block');
                       }
                   });


                   // MOSTRAR MODAL DE TIPO_CAMBIO
                   $('#tipo_cambio_button').on('click', function() {
                       $('#modal-tipo_cambio').modal('show');
                       if (!$.fn.DataTable.isDataTable('.dataTables-tipo_cambio')) {
                           datatable_tipo_cambio();
                       } else {
                           $('.dataTables-tipo_cambio').DataTable().ajax.reload();
                       }
                   });
                   let tabletc;
                   //  FUNCION PARA CARGAR DATATABLE DE TIPO_CAMBIO
                   function datatable_tipo_cambio() {
                        tabletc = $('.dataTables-tipo_cambio').DataTable({
                           "serverSide": true,
                           "ajax": {
                               url: "{{ route('api.get_tipo_cambio') }}",
                               method: "get",
                               data: function(d) {
                                   d.date_filter = $('#search_tipo_cambio').val();
                               },
                               dataSrc: function(json) {
                                   return json.data;
                               }
                           },
                           "pageLength": 15,
                           "columnDefs": [{
                               sortable: false,
                               'targets': "_all"
                           },{
                               'targets': [0],
                               'render': function(data, type, full, meta) {
                                   return `${full[4]}`;
                               }
                           }
                        ]
                       });

                       // Activar tooltips de Bootstrap después de dibujar la tabla
                       tabletc.on('draw.dt', function() {
                           $('[data-toggle="tooltip"]').tooltip();
                       });

                       // Configuración del rango de fechas
                    //    $('input[name="daterange_tipo_cambio"]').daterangepicker();
                       $('input[name="daterange_tipo_cambio"]').daterangepicker({
                           "locale": {
                               "separator": " | ",
                               "applyLabel": "Guardar",
                               "cancelLabel": "Cancelar",
                               "fromLabel": "Desde",
                               "toLabel": "Hasta",
                               "customRangeLabel": "Personalizado",
                               "daysOfWeek": ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                               "monthNames": [
                                   "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                                   "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                               ],
                               "firstDay": 1
                           }
                       }, function(start, end) {
                           var dates = [];
                           var currentDate = new Date(start);
                           var dateRangeString = dates.join('|');
                           $('.dataTables-tipo_cambio').DataTable().ajax.reload();
                        //    tabletc.column(3).search(dateRangeString, true, false).draw();
                       });
                   }
                   // Función para restaurar el filtro de fecha al mes actual
                   function limpiar_select_tc() {
                    $('input[name="daterange_tipo_cambio"]').val(`{{ date('01/m/Y') }} - {{ date('t/m/Y') }}`);
                    $('.dataTables-tipo_cambio').DataTable().ajax.reload();
                   }


                    // MOSTRAR MODAL DE MOTIVOS
                    $('#motivos_button').on('click', function() {
                       $('#modal-motivos').modal('show');
                       if (!$.fn.DataTable.isDataTable('.dataTables-motivos')) {
                           datatable_motivos();
                       } else {
                           $('.dataTables-motivos').DataTable().ajax.reload();
                       }
                   });
                   //  FUNCION PARA CARGAR DATATABLE DE MOTIVOS
                   function datatable_motivos() {
                       let table = $('.dataTables-motivos').DataTable({
                           "serverSide": true,
                           "ajax": {
                               url: "{{ route('api.get_motivos') }}",
                               method: "get",
                               data: function(d) {
                                   d.value = $('#search_motivos').val();
                               },
                               dataSrc: function(json) {
                                   return json.data;
                               }
                           },
                           "pageLength": 8,
                           "columnDefs": [{
                               sortable: false,
                               'targets': "_all"
                           }, {
                               'targets': [2],
                               'className': 'button_estado_motivos',
                               'render': function(data, type, full, meta) {
                                   if (data == 0) {
                                       return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_motivos" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[3]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                                   }
                                   return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_motivos" value="${full[3]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
                               }
                           }]
                       });
                       table.on('draw.dt', function() {
                           $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
                       });
                   }
                   //  BUSQUEDA DE MOTIVOS
                   $('#search_motivos').keyup(function() {
                       $('.dataTables-motivos').DataTable().ajax.reload();
                   });
                   //  FUNCION PARA AGREGAR UN NUEVO MOTIVO
                   $('#add_new_motivos').on('click', function() {
                       let form = document.getElementById('form_motivos');
                       if (!form.checkValidity()) {
                           form.reportValidity(); // Muestra los mensajes nativos del navegador
                           return; // Detiene la ejecución si hay errores
                       }
                       let formData = new FormData(form);
                       $.ajax({
                           url: "{{ route('motivos.save_ajax') }}",
                           method: "post",
                           data: formData,
                           contentType: false,
                           processData: false,
                           success: function(data) {
                               console.log(data);
                               $('.dataTables-motivos').DataTable().ajax.reload();
                               $('#form_motivos')[0].reset();
                           },
                           error: function(data) {
                               console.log(data);
                           }
                       });
                   });
                   //  CAMBIAR ESTADO DE MOTIVOS CON CLIC EN BOTON
                   $(document).on('click', '.change_status_motivos', function(event) {
                       let id = $(this).val();
                       $.ajax({
                           url: "{{ route('motivos.change_state') }}",
                           method: "post",
                           data: {
                               '_token': $('input[name=_token]').val(),
                               id: id
                           },
                           success: function(data) {
                               console.log(data);
                               $('.dataTables-motivos').DataTable().ajax.reload();
                           },
                           error: function(data) {
                               console.log(data);
                           }
                       });
                   });

                   //  EDITAR MARCA CON UN CLCIK EN EL ROW DEL DATATABLE
                   $(document).on('click', '.dataTables-motivos tbody tr', function() {
                       $('#form_motivos')[0].reset();
                       let table = $('.dataTables-motivos').DataTable();
                       let data = table.row(this).data();
                       let lastTd = $(this).find('td:last'); // Último td
                       let secondLastTd = lastTd.prev(); // Penúltimo td

                       if ($(event.target).is(lastTd)  ||
                           $(event.target).closest('td').is(lastTd)) {
                           return;
                       }
                       $('#update_motivos').css('display', 'inline-block');
                       $('#add_new_motivos').css('display', 'none');
                       //  PASAR DATA AL FORMULARIO
                       $('#id_motivos_edit').val(data[3]);
                       $('#nombre_motivos_edit').val(data[0]);
                       $('#select_motivos').val(data[1]);
                   });
                   //  ACTUALIZAR MOTIVOS
                   $('#update_motivos').on('click', function(event) {
                       let table = $('.dataTables-motivos').DataTable();
                       let data = table.row(this).data();

                       var id_motivo = $('#id_motivos_edit').val();
                       edit_motivos(id_motivo);
                   })
                   //  FUNCION PARA EDITAR MOTIVOS
                   function edit_motivos(id) {
                       let form = document.getElementById('form_motivos');
                       let formData = new FormData(form);
                       $.ajax({
                           url: "{{ route('motivos.edit_ajax') }}",
                           method: "post",
                           data: formData,
                           contentType: false,
                           processData: false,
                           success: function(data) {
                               console.log(data);
                               $('.dataTables-motivos').DataTable().ajax.reload();
                               $('#form_motivos')[0].reset();
                               $('#update_motivos').css('display', 'none');
                               $('#add_new_motivos').css('display', 'inline-block');
                           },
                           error: function(data) {
                               console.log(data);
                           }
                       });
                   }

                   //  CANCELAR EDICION DE MOTIVOS Y RESETEAR FORMULARIO
                   $('#cancel_motivos').on('click', function() {
                       $('#form_motivos')[0].reset();
                       if ($('#add_new_motivos').css('display') == 'inline-block') {
                           console.log('si');
                           $('#add_new_motivos').css('display', 'inline-block');
                           $('#update_motivos').css('display', 'none');
                       } else {
                           $('#update_motivos').css('display', 'none');
                           $('#add_new_motivos').css('display', 'inline-block');
                       }
                   });


                   // MOSTRAR MODAL DE ALARMA
                   $('#alarma_button').on('click', function() {
                       $('#modal-alarma').modal('show');
                       if (!$.fn.DataTable.isDataTable('.dataTables-alarma')) {
                           datatable_alarma();
                       } else {
                           $('.dataTables-alarma').DataTable().ajax.reload();
                       }
                   });
                   //  FUNCION PARA CARGAR DATATABLE DE ALARMA
                   function datatable_alarma() {
                       let table = $('.dataTables-alarma').DataTable({
                           "serverSide": true,
                           "ajax": {
                               url: "{{ route('api.get_alarma') }}",
                               method: "get",
                               data: function(d) {
                                   d.value = $('#search_alarma').val();
                               },
                               dataSrc: function(json) {
                                   return json.data;
                               }
                           },
                           "pageLength": 8,
                           "columnDefs": [{
                               sortable: false,
                               'targets': "_all"
                           }, {
                               'targets': [1],
                               'className': 'button_estado_alarma',
                               'render': function(data, type, full, meta) {
                                   if (data == 0) {
                                       return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_alarma" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[3]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                                   }
                                   return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_alarma" value="${full[3]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
                               }
                           }]
                       });
                       table.on('draw.dt', function() {
                           $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
                       });
                   }
                   //  BUSQUEDA DE ALARMA
                   $('#search_alarma').keyup(function() {
                       $('.dataTables-alarma').DataTable().ajax.reload();
                   });
                    //  FUNCION PARA AGREGAR UNA NUEVA ALARMA
                    $('#add_new_alarma').on('click', function() {
                       let form = document.getElementById('form_alarma');
                       if (!form.checkValidity()) {
                           form.reportValidity(); // Muestra los mensajes nativos del navegador
                           return; // Detiene la ejecución si hay errores
                       }
                       let formData = new FormData(form);
                       $.ajax({
                           url: "{{ route('alarma.save_ajax') }}",
                           method: "post",
                           data: formData,
                           contentType: false,
                           processData: false,
                           success: function(data) {
                               console.log(data);
                               $('.dataTables-alarma').DataTable().ajax.reload();
                               $('#form_alarma')[0].reset();
                           },
                           error: function(data) {
                               console.log(data);
                           }
                       });
                   });
                    //  CAMBIAR ESTADO DE ALARMA CON CLIC EN BOTON
                    $(document).on('click', '.change_status_alarma', function(event) {
                       let id = $(this).val();
                       $.ajax({
                           url: "{{ route('alarma.change_state') }}",
                           method: "post",
                           data: {
                               '_token': $('input[name=_token]').val(),
                               id: id
                           },
                           success: function(data) {
                               console.log(data);
                               $('.dataTables-alarma').DataTable().ajax.reload();
                           },
                           error: function(data) {
                               console.log(data);
                           }
                       });
                   });
                   //  EDITAR ALARMA CON UN CLICK EN EL ROW DEL DATATABLE
                   $(document).on('click', '.dataTables-alarma tbody tr', function() {
                       $('#form_alarma')[0].reset();
                       let table = $('.dataTables-alarma').DataTable();
                       let data = table.row(this).data();
                       let lastTd = $(this).find('td:last'); // Último td
                       let secondLastTd = lastTd.prev(); // Penúltimo td

                       if ($(event.target).is(lastTd) ||
                           $(event.target).closest('td').is(lastTd) ){
                           return;
                       }
                       $('#update_alarma').css('display', 'inline-block');
                       $('#add_new_alarma').css('display', 'none');
                       //  PASAR DATA AL FORMULARIO
                       $('#descripcion_alarma').val(data[0]);
                       $('#tipo').val(data[1]);
                       $('#alarma').val(data[2]);
                       $('#alarma').val(data[2]);
                       $('#id_alarma_edit').val(data[5]);

                   });
                    //  ACTUALIZAR ALARMA
                    $('#update_alarma').on('click', function(event) {
                       let table = $('.dataTables-alarma').DataTable();
                       let data = table.row(this).data();

                       var id_alarma = $('#id_alarma_edit').val();
                       edit_alarma(id_alarma);
                   })
                   //  FUNCION PARA EDITAR ALARMA
                   function edit_alarma(id) {
                       let form = document.getElementById('form_alarma');
                       let formData = new FormData(form);
                       $.ajax({
                           url: "{{ route('alarma.edit_ajax') }}",
                           method: "post",
                           data: formData,
                           contentType: false,
                           processData: false,
                           success: function(data) {
                               console.log(data);
                               $('.dataTables-alarma').DataTable().ajax.reload();
                               $('#form_alarma')[0].reset();
                               $('#update_alarma').css('display', 'none');
                               $('#add_new_alarma').css('display', 'inline-block');
                           },
                           error: function(data) {
                               console.log(data);
                           }
                       });
                   }
                    //  CANCELAR EDICION DE ALARMA Y RESETEAR FORMULARIO
                    $('#cancel_alarma').on('click', function() {
                       $('#form_alarma')[0].reset();
                       if ($('#add_new_alarma').css('display') == 'inline-block') {
                           console.log('si');
                           $('#add_new_alarma').css('display', 'inline-block');
                           $('#update_alarma').css('display', 'none');
                       } else {
                           $('#update_alarma').css('display', 'none');
                           $('#add_new_alarma').css('display', 'inline-block');
                       }
                   });
    </script>

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
