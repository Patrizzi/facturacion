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

    <body class="">
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="first-element">
                            <a href="{{ route('usuario.index') }}" class="head-nav-logo">
                                <img alt="image" class="head-nav-logo-img"
                                    src="{{ asset('/archivos/imagenes/layout/Leonosoft.png') }}" />
                                <span class="nav-label head-nav-brand-text">
                                    <span class="head-nav-brand-primary">LEONO</span><span class="head-nav-brand-secondary">SOFT</span>
                                </span>
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
                    <div class="nav-last-footer">
                        <div class="gesener-sidebar-user-row">
                            <a href="{{ route('usuario.perfil') }}" class="gesener-sidebar-user-link">
                                <img alt="image" class="gesener-sidebar-user-avatar"
                                    src="{{ asset('/profile/images/') }}/@yield('foto', auth()->user()->avatar)" />
                                <div class="nav-label gesener-sidebar-user-info">
                                    <span class="gesener-sidebar-user-empresa">{{ $empresa->nombre }}</span>
                                    <span class="gesener-sidebar-user-name">@yield('area', auth()->user()->name)</span>
                                </div>
                            </a>
                            <div class="nav-label gesener-sidebar-user-actions">
                                <i class="fa fa-ellipsis-v gesener-sidebar-menu-icon" id="menuIcon"></i>
                                <!-- Menú desplegable -->
                                <div id="dropdownMenu" style="display: none;">
                                    @canany(['perfil_usuario.ver', 'perfil_usuario.editar'])
                                        <a href="{{ route('usuario.perfil') }}" class="dropdown-item">
                                            <i class="fa fa-user-circle-o fa-lg"></i> Mi perfil</a>
                                    @endcan
                                    @canany(['empresa.ver', 'empresa.editar'])
                                        <a href="{{ route('empresa.index') }}" class="dropdown-item">
                                            <i class="fa fa-university"></i> Mi Empresa</a>
                                    @endcan
                                    @canany(['almacen.listar', 'apariencia.ver', 'familia.listar', 'subfamilia.ver',
                                        'garantia_doc.listar', 'marcas.listar', 'motivos.listar', 'tipo_cambio.listar',
                                        'unidad_m.listar', 'usuarios.listar', 'roles.listar', 'validez.listar',
                                        'validez.crear', 'alarma.listar'])
                                        <a href="{{ route('configuracion.general') }}" class="dropdown-item">
                                            <i class="fa fa-cog fa-lg"></i> Configuración</a>
                                    @endcan
                                    <a href="#" class="dropdown-item"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

            <nav class="navbar navbar-static-top gesener-topbar" role="navigation">
                
                <!-- SECCIÓN IZQUIERDA: Tipo de Cambio Compacto Gesener -->
                <div class="gesener-topbar-left">
                    <div class="gesener-tc-strip">
                        <div class="gesener-tc-item">
                            <span class="gesener-tc-label">Compra:</span>
                            <strong class="gesener-tc-value">{{ $tipo_cambio->compra ?? '--' }}</strong>
                        </div>
                        <div class="gesener-tc-item">
                            <span class="gesener-tc-label">Venta:</span>
                            <strong class="gesener-tc-value">{{ $tipo_cambio->venta ?? '--' }}</strong>
                        </div>
                        <div class="gesener-tc-item">
                            <span class="gesener-tc-label">Paralelo:</span>
                            <strong class="gesener-tc-value" id="tc_paralelo">{{ $tipo_cambio->paralelo ?? '--' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN DERECHA: Botón Compuesto SUNAT + Usuario (Omitidos Mensajes y Calendario) -->
                <div class="gesener-topbar-right">
                    
                    <!-- BOTÓN COMPUESTO SUNAT (ESTILO GESENER CON DROPDOWN) -->
                    <div class="btn-group gesener-sunat-group" role="group">
                        <!-- Botón Contador / Desplegable -->
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle gesener-btn-sunat-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span>{{ $total_pendientes_sunat }} {{ $total_pendientes_sunat === 1 ? 'Pendiente' : 'Pendientes' }}</span>
                            <span class="caret"></span>
                        </button>

                        <!-- Menú Desplegable con detalle por tipo de documento -->
                        <ul class="dropdown-menu dropdown-menu-right gesener-sunat-dropdown">
                            <li class="dropdown-header gesener-sunat-dropdown-header">
                                <span>Pendientes SUNAT</span>
                                <span class="badge {{ $total_pendientes_sunat > 0 ? 'badge-danger' : 'badge-primary' }}">{{ $total_pendientes_sunat }}</span>
                            </li>

                            @canany(['factura.emitir', 'factura_m.emitir'])
                                @if (($fact_view_count ?? 0) + ($fact_m_view_count ?? 0) > 0)
                                    <li>
                                        <a href="{{ route('facturacion_electronica.index') }}" class="gesener-sunat-item">
                                            <span><i class="fa fa-file-text-o text-primary"></i> Facturas</span>
                                            <span class="label label-primary">{{ (int)$fact_view_count + (int)$fact_m_view_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endcanany

                            @canany(['boleta.emitir', 'boleta_m.emitir'])
                                @if (($bol_view_count ?? 0) + ($bol_m_view_count ?? 0) > 0)
                                    <li>
                                        <a href="{{ route('facturacion_electronica.index_boleta') }}" class="gesener-sunat-item">
                                            <span><i class="fa fa-file-o text-info"></i> Boletas</span>
                                            <span class="label label-info">{{ (int)$bol_view_count + (int)$bol_m_view_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endcanany

                            @canany(['guia_remision.emitir', 'guia_remision_m.emitir'])
                                @if (($guia_view_count ?? 0) + ($guia_m_view_count ?? 0) > 0)
                                    <li>
                                        <a href="{{ route('facturacion_electronica.index_guia_remision') }}" class="gesener-sunat-item">
                                            <span><i class="fa fa-truck text-warning"></i> Guías Remisión</span>
                                            <span class="label label-warning">{{ (int)$guia_view_count + (int)$guia_m_view_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endcanany

                            @can('nota_credito.emitir')
                                @if (($n_credito_view_count ?? 0) > 0)
                                    <li>
                                        <a href="{{ route('facturacion_electronica.index_nota_credito') }}" class="gesener-sunat-item">
                                            <span><i class="fa fa-minus-circle text-danger"></i> Notas Crédito</span>
                                            <span class="label label-danger">{{ $n_credito_view_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endcan

                            @can('nota_debito.emitir')
                                @if (($n_debito_view_count ?? 0) > 0)
                                    <li>
                                        <a href="{{ route('facturacion_electronica.index_nota_debito') }}" class="gesener-sunat-item">
                                            <span><i class="fa fa-plus-circle text-success"></i> Notas Débito</span>
                                            <span class="label label-success">{{ $n_debito_view_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endcan

                            @if ($total_pendientes_sunat === 0)
                                <li class="gesener-sunat-empty">
                                    <i class="fa fa-check-circle text-success"></i> Todos los comprobantes al día
                                </li>
                            @endif
                        </ul>

                        <!-- Botón Acción Directa -->
                        <a href="{{ $ruta_envio_directo }}" class="btn btn-dark btn-sm gesener-btn-sunat-send">
                            <span>Enviar a Sunat</span>
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- USUARIO Y CERRAR SESIÓN ESTILO GESENER -->
                    <div class="gesener-topbar-user">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=64&h=64" alt="Avatar" class="gesener-topbar-avatar">
                        <span class="gesener-topbar-username">{{ auth()->user()->name ?? 'Administrador' }}</span>

                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-topbar').submit();" class="gesener-topbar-logout" title="Cerrar Sesión">
                            <i class="fa fa-sign-out fa-lg"></i>
                        </a>
                        <form id="logout-form-topbar" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>

                </div>
            </nav>

            {{-- Bloque opcional de cabecera/breadcrumbs de vistas internas
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
            --}}

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
