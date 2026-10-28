<!DOCTYPE html>
<html lang="es">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ asset('/archivos/imagenes/servicios/') }}/@yield('3', auth()->user()->config->foto_icono)" rel="shortcut icon" />
        <title>@yield('title', 'Inicio')/@yield('3', auth()->user()->name)</title>

        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

        <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        {{-- <script src="@yield('vue_js', '#')" defer></script> --}}

        <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/blueimp/css/blueimp-gallery.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/slick/slick.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/slick/slick-theme.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
        {{-- <link href="{{ asset('css/plugins/c3/c3.min.css') }}" rel="stylesheet"> --}}
        <link href="{{ asset('main.css') }}" rel="stylesheet">
        <link rel="icon" type="image/svg+xml" href="{{ asset('img/icono.svg') }}" sizes="any">
        <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/side-bar/side-bar.css') }}">
        @yield('styles')
        <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

    </head>


    {{-- <body class="mini-navbar"> --}}

    <body class="" style="margin: 0px !important;">
        <div id="wrapper" style="">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu"
                        style="height:90vh !important; overflow-y: auto;  display: block; top: 0px">
                        <li class="first-element" style="background-color: white;width: 100% !important;">
                            <a href="{{ route('usuario.index') }}" class="head-nav-logo" style=" padding: 20px 0px;">
                                <img alt="image" class="rounded-circle"
                                    src="{{ asset('/archivos/imagenes/layout/Leonosoft.png') }}"
                                    style="width: 60px; height: 60px;" />
                                <span class="nav-label"
                                    style="color: #2641f8; font-size: 18px; font-weight: bold;">LEONO</span><span
                                    style="color: gray; font-size: 18px; font-weight: bold;">SOFT</span>
                            </a>
                        </li>
                        @foreach ($menus as $menu)
                            @if ($menu['type'] === 'single')
                                <li>
                                    <a href="{{ $menu['route'] }}">
                                        <i class="{{ $menu['icon'] }} fa-lg text-white"></i>
                                        <span class="nav-label">{{ $menu['label'] }}</span>
                                    </a>
                                </li>
                            @endif

                            @if ($menu['type'] === 'tree')
                                <li>
                                    <a href="#">
                                        <i class="{{ $menu['icon'] }}"></i>
                                        <span class="nav-label">{{ $menu['label'] }}</span>
                                    </a>

                                    <ul class="nav nav-second-level">
                                        @foreach ($menu['children'] as $child)
                                            @if (isset($child['children']))
                                                <li>
                                                    <a href="#">{{ $child['label'] }}</a>
                                                    <ul class="nav nav-third-level">
                                                        @foreach ($child['children'] as $sub)
                                                            <li>
                                                                <a href="{{ $sub['route'] }}">
                                                                    {{ $sub['label'] }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{{ $child['route'] }}">
                                                        {{ $child['label'] }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <div style="max-height: 70px;" class="nav-last-footer">
                        <div class="" style="width: 100%">
                            <div class="nav-label"
                                style="display: flex;flex-direction: row;align-items: center;white-space: initial !important;justify-content: space-between;">
                                <a href="{{ route('usuario.perfil') }}"
                                    style="display: flex;flex-direction: row;align-items: center;">
                                    <img alt="image" class="rounded-circle"
                                        src="{{ asset('/profile/images/') }}/@yield('foto', auth()->user()->avatar)"
                                        style="border: 1px solid black;background-color: white;height:45px;width: 45px" />
                                    <div class="nav-label" style="margin-left: 10px;">
                                        <span class="block m-t-xs font-bold spans"
                                            style="font-size: 14px;color: white">{{ $empresa->nombre }}</span>
                                        <span class="block m-t-xs text-white font-bold mr-3">@yield('area', auth()->user()->name)</span>
                                    </div>
                                </a>
                                <div class="nav-label" style="">
                                    <i class="fa fa-ellipsis-v" id="menuIcon"
                                        style="color: white; font-size: 19px; margin-right: 15px; cursor: pointer;"></i>
                                    <!-- Menú desplegable -->
                                    <div id="dropdownMenu"
                                        style="display: none; position: absolute; bottom: 50px; right: 0; background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius: 5px; padding: 10px; width: 150px;">
                                        @canany(['perfil_usuario.ver', 'perfil_usuario.editar'])
                                            <a href="{{ route('usuario.perfil') }}" class="dropdown-item"
                                                style="display: block; color: black; padding: 8px; text-decoration: none;">
                                                <i class="fa fa-user-circle-o fa-lg"></i> Mi perfil</a>
                                        @endcan
                                        @canany(['empresa.ver', 'empresa.editar'])
                                            <a href="{{ route('empresa.index') }}" class="dropdown-item"
                                                style="display: block; color: black; padding: 8px; text-decoration: none;">
                                                <i class="fa fa-university "></i> Mi Empresa</a>
                                        @endcan
                                        @canany(['almacen.listar', 'apariencia.ver', 'familia.listar', 'subfamilia.ver',
                                            'garantia_doc.listar', 'marcas.listar', 'motivos.listar', 'tipo_cambio.listar',
                                            'unidad_m.listar', 'usuarios.listar', 'roles.listar', 'validez.listar',
                                            'validez.crear', 'alarma.listar'])
                                            <a href="{{ route('configuracion.general') }}" class="dropdown-item"
                                                style="display: block; color: black; padding: 8px; text-decoration: none;">
                                                <i class="fa fa-cog fa-lg"></i> Configuración</a>
                                        @endcan
                                        <a href="#" class="dropdown-item"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            style="display: block; color: black; padding: 8px; text-decoration: none;">
                                            <i class="fa fa-sign-out fa-lg"></i> Cerrar Sesión
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </nav>
          {{-- Menu Superior Estilo Gesener (Adaptado para Leonosoft) --}}
        <div id="page-wrapper" class="gray-bg">
            
            @php
                // 1. Cálculo del total de comprobantes pendientes de envío a SUNAT
                $total_pendientes_sunat = (int)($fact_view_count ?? 0) + (int)($fact_m_view_count ?? 0)
                    + (int)($bol_view_count ?? 0) + (int)($bol_m_view_count ?? 0)
                    + (int)($guia_view_count ?? 0) + (int)($guia_m_view_count ?? 0)
                    + (int)($n_credito_view_count ?? 0)
                    + (int)($n_debito_view_count ?? 0);

                // 2. Ruta directa de envío según el comprobante con prioridad
                $ruta_envio_directo = route('facturacion_electronica.index');
                if (($fact_view_count ?? 0) + ($fact_m_view_count ?? 0) > 0) {
                    $ruta_envio_directo = route('facturacion_electronica.index');
                } elseif (($bol_view_count ?? 0) + ($bol_m_view_count ?? 0) > 0) {
                    $ruta_envio_directo = route('facturacion_electronica.index_boleta');
                } elseif (($guia_view_count ?? 0) + ($guia_m_view_count ?? 0) > 0) {
                    $ruta_envio_directo = route('facturacion_electronica.index_guia_remision');
                } elseif (($n_credito_view_count ?? 0) > 0) {
                    $ruta_envio_directo = route('facturacion_electronica.index_nota_credito');
                } elseif (($n_debito_view_count ?? 0) > 0) {
                    $ruta_envio_directo = route('facturacion_electronica.index_nota_debito');
                }
            @endphp

            <nav class="navbar navbar-static-top bg-white border-bottom" role="navigation" style="margin-bottom: 0; min-height: 60px; display: flex; align-items: center; justify-content: space-between; padding: 8px 20px; flex-wrap: wrap; gap: 15px; border-bottom: 1px solid #e7eaec;">
                
                <!-- SECCIÓN IZQUIERDA: Tipo de Cambio Compacto Gesener -->
                <div style="display: flex; align-items: center; gap: 15px;">
                    @if (isset($tipo_cambio->fecha))
                        <div style="display: flex; align-items: center; gap: 15px; font-family: monospace, sans-serif; font-size: 0.85rem;">
                            <div style="text-align: center; line-height: 1.2;">
                                <span style="display: block; font-size: 0.7rem; font-weight: bold; color: #888; text-transform: uppercase;">Compra:</span>
                                <strong style="color: #222; font-size: 0.95rem;">{{ $tipo_cambio->compra }}</strong>
                            </div>
                            <div style="text-align: center; line-height: 1.2; border-left: 1px solid #e7eaec; padding-left: 15px;">
                                <span style="display: block; font-size: 0.7rem; font-weight: bold; color: #888; text-transform: uppercase;">Venta:</span>
                                <strong style="color: #222; font-size: 0.95rem;">{{ $tipo_cambio->venta }}</strong>
                            </div>
                            <div style="text-align: center; line-height: 1.2; border-left: 1px solid #e7eaec; padding-left: 15px;">
                                <span style="display: block; font-size: 0.7rem; font-weight: bold; color: #888; text-transform: uppercase;">Paralelo:</span>
                                <strong style="color: #222; font-size: 0.95rem;" id="tc_paralelo">{{ $tipo_cambio->paralelo }}</strong>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- SECCIÓN DERECHA: Botón Compuesto SUNAT + Usuario (Omitidos Mensajes y Calendario) -->
                <div style="display: flex; align-items: center; gap: 15px;">
                    
                    <!-- BOTÓN COMPUESTO SUNAT (ESTILO GESENER CON DROPDOWN) -->
                    <div class="btn-group" role="group" style="box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 4px; overflow: visible;">
                        <!-- Botón Contador / Desplegable -->
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #1a4da0; border-color: #1a4da0; color: #ffffff; font-weight: 600; padding: 6px 14px; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fa fa-bell"></i>
                            <span>{{ $total_pendientes_sunat }} {{ $total_pendientes_sunat === 1 ? 'Pendiente' : 'Pendientes' }}</span>
                            <span class="caret" style="margin-left: 4px;"></span>
                        </button>

                        <!-- Menú Desplegable con detalle por tipo de documento -->
                        <ul class="dropdown-menu dropdown-menu-right" style="min-width: 270px; padding: 6px 0; border: 1px solid #e7eaec; box-shadow: 0 6px 12px rgba(0,0,0,0.15); border-radius: 4px;">
                            <li class="dropdown-header" style="font-size: 0.75rem; font-weight: bold; color: #676a6c; text-transform: uppercase; padding: 8px 16px; border-bottom: 1px solid #f3f3f4; display: flex; justify-content: space-between; align-items: center;">
                               <span>Pendientes SUNAT</span>
                                <span class="badge {{ $total_pendientes_sunat > 0 ? 'badge-danger' : 'badge-primary' }}">{{ $total_pendientes_sunat }}</span>
                            </li>

                            @canany(['factura.emitir', 'factura_m.emitir'])
                                @if (($fact_view_count ?? 0) + ($fact_m_view_count ?? 0) > 0)
                                    <li>
                                        <a href="{{ route('facturacion_electronica.index') }}" style="display: flex; justify-content: space-between; align-items: center; padding: 7px 16px; color: #333;">
                                            <span><i class="fa fa-file-text-o text-primary" style="margin-right: 8px;"></i> Facturas</span>
                                            <span class="label label-primary">{{ (int)$fact_view_count + (int)$fact_m_view_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endcanany

                            @canany(['boleta.emitir', 'boleta_m.emitir'])
                                @if (($bol_view_count ?? 0) + ($bol_m_view_count ?? 0) > 0)
                                    <li>
                                        <a href="{{ route('facturacion_electronica.index_boleta') }}" style="display: flex; justify-content: space-between; align-items: center; padding: 7px 16px; color: #333;">
                                            <span><i class="fa fa-file-o text-info" style="margin-right: 8px;"></i> Boletas</span>
                                            <span class="label label-info">{{ (int)$bol_view_count + (int)$bol_m_view_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endcanany

                            @canany(['guia_remision.emitir', 'guia_remision_m.emitir'])
                                @if (($guia_view_count ?? 0) + ($guia_m_view_count ?? 0) > 0)
                                    <li>
                                        <a href="{{ route('facturacion_electronica.index_guia_remision') }}" style="display: flex; justify-content: space-between; align-items: center; padding: 7px 16px; color: #333;">
                                            <span><i class="fa fa-truck text-warning" style="margin-right: 8px;"></i> Guías Remisión</span>
                                            <span class="label label-warning">{{ (int)$guia_view_count + (int)$guia_m_view_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endcanany

                            @can('nota_credito.emitir')
                                @if (($n_credito_view_count ?? 0) > 0)
                                    <li>
                                        <a href="{{ route('facturacion_electronica.index_nota_credito') }}" style="display: flex; justify-content: space-between; align-items: center; padding: 7px 16px; color: #333;">
                                            <span><i class="fa fa-minus-circle text-danger" style="margin-right: 8px;"></i> Notas Crédito</span>
                                            <span class="label label-danger">{{ $n_credito_view_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endcan

                            @can('nota_debito.emitir')
                                @if (($n_debito_view_count ?? 0) > 0)
                                    <li>
                                        <a href="{{ route('facturacion_electronica.index_nota_debito') }}" style="display: flex; justify-content: space-between; align-items: center; padding: 7px 16px; color: #333;">
                                            <span><i class="fa fa-plus-circle text-success" style="margin-right: 8px;"></i> Notas Débito</span>
                                            <span class="label label-success">{{ $n_debito_view_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endcan

                            @if ($total_pendientes_sunat === 0)
                                <li style="padding: 10px 16px; text-align: center; color: #888; font-size: 0.8rem;">
                                    <i class="fa fa-check-circle text-success" style="margin-right: 4px;"></i> Todos los comprobantes al día
                                </li>
                            @endif
                        </ul>

                        <!-- Botón Acción Directa -->
                        <a href="{{ $ruta_envio_directo }}" class="btn btn-dark btn-sm" style="background-color: #0d2346; border-color: #0d2346; color: #ffffff; font-weight: 600; padding: 6px 14px; display: inline-flex; align-items: center; gap: 5px;">
                            <span>Enviar a Sunat</span>
                            <i class="fa fa-arrow-right" style="font-size: 0.8rem;"></i>
                        </a>
                    </div>

                    <!-- USUARIO Y CERRAR SESIÓN ESTILO GESENER -->
                    <div style="display: flex; align-items: center; gap: 10px; padding-left: 15px; border-left: 1px solid #e7eaec;">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=64&h=64" alt="Avatar" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 1px solid #d2d6de;">
                        <span style="font-weight: 600; font-size: 0.85rem; color: #333;">{{ auth()->user()->name ?? 'Administrador' }}</span>

                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-topbar').submit();" style="color: #ed5565; margin-left: 8px; text-decoration: none;" title="Cerrar Sesión">
                            <i class="fa fa-sign-out fa-lg"></i>
                        </a>
                        <form id="logout-form-topbar" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>

                </div>
            </nav>

            {{-- Bloque opcional de cabecera/breadcrumbs de vistas internas --}}
            <div class="row wrapper border-bottom white-bg page-heading" style="margin-bottom: 20px;">
                <div class="col-sm-4">
                    <h2>@yield('title', 'Inicio')</h2>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        <a style="visibility:@yield('visibility', 'hidden')" href="@yield('ruta', '')" class="btn btn-primary">@yield('name', '')</a>

                        @yield('boton_opcional')

                        <a data-toggle="@yield('data-toggle', '')" onclick="@yield('onclick1', '')" href="@yield('href_accion', '#')" class="btn btn-primary" @yield('atributo_1', '')>{{ trim($__env->yieldContent('value_accion')) !== '' ? $__env->yieldContent('value_accion') : '#' }}</a>

                        <a id="actualizar" data-toggle="@yield('data-config', '')" onclick="@yield('onclick', '')" href="@yield('config', '')" class="@yield('class', 'btn btn-primary')" @yield('atributo_actu', '')>@yield('button2', 'Actualizar')</a>
                    </div>
                </div>
            </div>

            @yield('content')

            <div class="footer">
                <div class="float-right">
                    Visitanos: &nbsp;&nbsp; <a href="https://www.facebook.com/JYPPERIFERICOSSAC" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>&nbsp;
                    <a href="https://api.whatsapp.com/send?phone=51946201443&text=Hola!%20Necesito%20Ayuda%20con%20el%20sistema%20de%20Facturación,%20Gracias!%20" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                </div>
                <div>
                    <strong>Copyright </strong> &nbsp;<a href="http://www.jypsac.com" target="_blank"> JyP Periféricos</a>&nbsp; &copy; 2019-{{ date('Y') }}
                </div>
            </div>
        </div>
        </div>
    </body>

    <!-- Ladda -->
    <script src="{{ asset('js/plugins/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>

    <!-- Ladda style -->
    <link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
    <!-- Toastr script -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const slides = document.querySelector(".slides");
            const items = slides.querySelectorAll(".span_slide");

            if (items.length > 1) {
                const itemHeight = items[0].offsetHeight;
                console.log(itemHeight);
                const totalItems = items.length;

                slides.style.setProperty("--items", totalItems);
                slides.style.setProperty("--move", `${itemHeight * totalItems}px`);
                slides.style.setProperty("--duration", `${totalItems * 2}s`); // 2s por item
            }

            const slides2 = document.querySelector(".slides2");
            const items2 = slides2.querySelectorAll(".span_slide2");

            if (items2.length > 1) {
                const itemHeight2 = items2[0].offsetHeight;
                const totalItems2 = items2.length;

                slides2.style.setProperty("--items2", totalItems2);
                slides2.style.setProperty("--move2", `${itemHeight2 * totalItems2}px`);
                slides2.style.setProperty("--duration2", `${totalItems2 * 2}s`); // 2s por item
            }
        });
        $(document).ready(function() {
            Ladda.bind('.ladda-button', {
                timeout: 8000
            });
            $('#btn_popover').click();

            setTimeout(function() {
                $('#btn_popover').popover('hide');
            }, 10);

            function applyMenuBehavior() {
                if (window.matchMedia("(min-width: 768px)").matches) {

                    $('body').addClass('mini-navbar');
                    $('.navbar-minimalize').off('click');

                    $('.navbar-static-side').hover(
                        function() {
                            $('body').removeClass('mini-navbar');
                        },
                        function() {
                            $('body').addClass('mini-navbar');
                        }
                    );
                } else {
                    $('body').addClass('mini-navbar');
                    $('.navbar-static-side').off('mouseenter mouseleave click');
                }
            }

            applyMenuBehavior();

            $(window).resize(function() {
                applyMenuBehavior();
            });
        });
        // Mostrar/ocultar menú desplegable
        document.getElementById("menuIcon").addEventListener("click", function(event) {
            event.stopPropagation(); // Evita que el evento se propague al hacer clic en otros lugares
            const menu = document.getElementById("dropdownMenu");
            menu.style.display = menu.style.display === "none" ? "block" : "none";
        });

        // Cerrar el menú si se hace clic fuera de él
        document.addEventListener("click", function(event) {
            const menu = document.getElementById("dropdownMenu");
            const menuIcon = document.getElementById("menuIcon");
            if (menu.style.display === "block" && !menu.contains(event.target) && event.target !== menuIcon) {
                menu.style.display = "none";
            }
        });
    </script>
    @yield('scripts')
    @if (!request()->routeIs('inicio') && !isset($tipo_cambio->fecha))
        <script>
            // cargar esto en el layout principal, no solo en la vista de espera
            setInterval(function() {
                $.get('{{ route("tipo_cambio.busqueda_tipo_cambio") }}', { fecha: '{{ now()->format("Y-m-d") }}' })
                    .fail(function(xhr) {
                        if (xhr.status === 404) {
                            window.location.href = '{{ route("inicio") }}';
                        }
                    });
            }, 1000); // cada 1 minuto, ajusta según necesidad
        </script>
    @endif
</html>
