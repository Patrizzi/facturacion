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
                    {{-- <div style="position: fixed; z-index: 9999;"> --}}
                    <li class="first-element" style="background-color: white;width: 100% !important;">
                        {{-- <div class="dropdown profile-element" style="transform: translateX(-25px);"> --}}
                        <a href="{{ route('usuario.index') }}" class="head-nav-logo" style=" padding: 20px 0px;">
                            <img alt="image" class="rounded-circle"
                                src="{{ asset('/archivos/imagenes/layout/Leonosoft.png') }}"
                                style="width: 60px; height: 60px;" />
                            <span class="nav-label"
                                style="color: #2641f8; font-size: 18px; font-weight: bold;">LEONO</span><span
                                style="color: gray; font-size: 18px; font-weight: bold;">SOFT</span>
                        </a>
                        {{-- </div> --}}
                        {{-- <div class="dropdown profile-element" style="transform: translateX(-18px);">
                                <a class="nav-label" href="{{ route('usuario.index') }}">
                                    <span class="block m-t-xs font-bold"
                                        style="color:black; font-size: 15px; margin-top: 20px;">@yield('nombre', auth()->user()->nombre)</span>
                                </a>
                            </div> --}}
                    </li>
                    {{-- </div> --}}
                    {{-- INICIO --}}
                    @can('inicio')
                        <li style=""><a href="{{ route('inicio') }}"><i class="fa fa-home fa-lg text-white"></i><span
                                    class="nav-label text-white">Inicio</span></a></li>
                    @endcan

                    {{-- MENU DESPELEGABLE NUEVO --}}

                    @canany(['cotizacion.listar', 'cotizacion_m.listar'])
                    <li><a href="{{ route('ventas.cotizacion') }}"><i class="fa fa-tags fa-lg text-white"></i><span
                                class="nav-label text-white">Ventas</span></a></li>
                    @endcan
                    <li><a href="{{ route('caja_chica.index') }}">
                            <i class="fa fa-money fa-lg text-white"></i><span
                                class="nav-label text-white">Tesorería</span></a></li>

                    {{-- <li><a href="#"><i class="fa fa-shopping-cart fa-lg text-white"></i><span
                                class="nav-label text-white">Compras</span></a></li> --}}

                    <li><a href="{{ route('comprobantes.index_factura') }}"><i
                                class="fa fas fa-file fa-lg text-white"></i><span
                                class="nav-label text-white">Comprobantes</span></a></li>

                    <li><a href="{{ route('garantia_guia_ingreso.index') }}"><i
                                class="fa fa-check fa-lg text-white"></i><span
                                class="nav-label text-white">Garantias</span></a></li>

                    <li>
                        @if (empty($inventario_inicial))
                            <a href="{{ route('kardex-entrada.create') }}"><i
                                    class="fa fa-archive fa-lg text-white"></i>
                                <span class="nav-label">Inventario Inicial</span></a>
                        @elseif($inventario_inicial->estado == 1)
                            <a href="{{ route('kardex-entrada.show', $inventario_inicial->id) }}"><i
                                    class="fa fa-archive fa-lg text-white"></i>
                                <span class="nav-label">Inventario Inicial</span></a>
                        @else
                            @can('inventario')
                        <li>
                            <a href="#"><i class="fa fa-archive fa-lg text-white"></i><span
                                    class="nav-label">Inventario</span></a>
                            <ul class="nav nav-second-level collapse">
                                @can('inventario-productos_kardex')
                                    <li>
                                        <a href="#"><span>Kardex-Producto</span></a>
                                        <ul class="nav nav-third-level">
                                            @can('inventario-productos_kardex-entrada_producto.index')
                                                <li><a href="{{ route('kardex-entrada.index') }}"><span>Entrada
                                                            Producto</span></a></li>
                                            @endcan
                                            <li><a href="{{ route('kardex-entrada-Distribucion.index') }}"><span>Distribución
                                                        Producto</span></a></li>
                                            <li><a href="{{ route('kardex-entrada-Traslado-almacen.index') }}"><span>Traslado
                                                        de Almacén </span></a></li>
                                            @can('inventario-productos_kardex-salida_producto.index')
                                                <li><a href="{{ route('kardex-salida.index') }}"><span>Salida
                                                            Producto</span></a></li>
                                            @endcan

                                        </ul>
                                    </li>
                                    {{-- DEBE IR A OTRO LADO --}}
                                    @can('inventario-toma_de_inventario.index')
                                        <li><a href="{{ route('periodo-consulta.index') }}"><span>Consultas de
                                                    inventario</span></a></li>
                                        <!-- Periodo Consulta -->
                                    @endcan

                                    <li><a href="{{ route('cierre-periodo.index') }}"><span>Cierre Periodo</span></a></li>
                                    <li><a href="{{ route('movimiento-consulta.index') }}"><span>Movimiento
                                                Consulta</span></a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @endif
                    </li>

                    <li><a href="#"><i class="fa fa-credit-card fa-lg text-white"></i><span
                                class="nav-label text-white">Creditos y Cobranzas</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('cobranzas.index_factura') }}">Facturas</a></li>
                            <li><a href="{{ route('cobranzas.index_facturas_m') }}">Facturas M.</a></li>
                            <li><a href="{{ route('cobranzas.index_boletas') }}">Boletas</a></li>
                            <li><a href="{{ route('cobranzas.index_boletas_manual') }}">Boletas M.</a></li>
                            <li><a href="{{ route('cobranzas.index_nota_venta') }}">Nota de Venta</a></li>
                        </ul>
                    </li>

                    {{-- servicio tecnico --}}
                    <li>
                        <a href="{{ route('servicio-guias.index') }}">
                            <i class="fa fa-wrench fa-lg text-white" aria-hidden="true"></i>
                            <span class="nav-label text-white">
                                Servicio Técnico
                            </span>
                        </a>
                        {{-- <a href="{{ route('sGuias.index') }}"><i class="fa fa-credit-card fa-lg text-white"></i><span
                                class="nav-label text-white">Servicio Técnico</span></a> --}}
                        {{-- <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('sGuias.index') }}">Servicios</a></li>
                            <li><a href="{{ route('indexServicio.index') }}">Cotización Orden Servicio</a></li>
                            <li><a href="{{ route('servicio.ordenServicio') }}">Orden de Servicio</a></li>
                        </ul> --}}

                    </li>

                    {{-- <li><a href="#"><i class="fa fa-server fa-lg text-white"></i><span
                                class="nav-label text-white">Sire - Sunat</span></a></li> --}}

                    <li><a href="#"><i class="fa fa-table fa-lg text-white"></i><span
                                class="nav-label text-white">Planilla</span></a>

                        <ul class="nav nav-second-level collapse">
                            @can('planilla-datos_generales.index')
                                <li><a href="{{ route('personal.index') }}"><span>Personal</span></a></li>
                            @endcan
                            @can('planilla-vendedores.index')
                                <li><a href="{{ route('vendedores.index') }}"><span>Vendedores</span></a></li>
                            @endcan
                            <li><a href="{{ route('vehiculo.index') }}"><span>Vehículos</span></a></li>

                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-comments-o fa-lg text-white"></i><span
                                class="nav-label text-white">Consultas</span></a>
                        <ul class="nav nav-second-level collapse">
                            @can('consultas-garantias')
                                <li>
                                    <a href="#"><span>Garantias</span></a>
                                    <ul class="nav nav-third-level">
                                        @can('consultas-garantias-guia_ingreso.index')
                                            <li><a href="{{ route('consultas.garantias.guias_ingreso') }}"><span>Guía
                                                        Ingreso</span></a></li>
                                        @endcan
                                        @can('consultas-garantias-guia_egreso.index')
                                            <li><a href="{{ route('consultas.garantias.guias_egreso') }}"><span>Guía
                                                        Egreso</span></a></li>
                                        @endcan
                                        @can('consultas-garantias-informe_tecnico.index')
                                            <li><a href="{{ route('consultas.garantias.informe_tecnico') }}"><span>Informe
                                                        Técnico</span></a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            {{-- @can('consulta.cantidad_precio.index') --}}
                            <li><a href="{{ route('cantidad_precio.index') }}"><span>Productos</span></a></li>
                            <li><a href="{{ route('cantidad_precio.index_servicio') }}"><span>Servicios</span></a>
                            </li>
                            <li><a href="{{ route('reportes.index') }}"><span>Reportes</span></a></li>
                            {{-- @endcan --}}
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-registered fa-lg text-white"></i><span
                                class="nav-label text-white">Registros Sunat</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('facturacion_electronica.index') }}"><span>Facturas</span></a></li>
                            <li><a href="{{ route('boletas_electronicas.index_boleta') }}"><span>Boletas</span></a>
                            </li>
                            <li><a href="{{ route('guias_electronicas.index_guia_remision') }}"><span>Guía
                                        Remisión</span></a></li>
                            <li><a href="{{ route('facturacion_electronica.index_nota_credito') }}"><span>Nota de
                                        créditos</span></a></li>
                            <li><a href="{{ route('facturacion_electronica.index_nota_debito') }}"><span>Nota de
                                        débitos</span></a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-shopping-bag fa-lg text-white"></i><span
                                class="nav-label text-white">Productos y Servicios</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('productos.index') }}"><span>Productos</span></a></li>
                            <li><a href="{{ route('servicios.index') }}"><span>Servicios</span></a></li>

                        </ul>
                    </li>
                    <li><a href="{{ route('project_managers.index') }}"><i
                                class="fa fa-th-large fa-lg text-white"></i><span
                                class="nav-label text-white">Proyectos PMB</span></a></li>
                    {{-- <li><a href="{{ route('estadisticas.index') }}"><i
                                class="fa fa-database fa-lg text-white"></i><span
                                class="nav-label text-white">Estadistica KPIs</span></a></li> --}}

                    {{-- <li> <a href="{{ route('indexServicio.index') }}"><span
                                        class="nav-label">Cotizacion Orden Servicio</span></a> </li>
                    <li><a href="{{ route('servicio.ordenServicio') }}"><span>Orden de Servicio</span></a></li>
                    <li> <a href="{{ route('sGuias.index') }}">
                                <img src="{{ asset('/archivos/imagenes/layout/servicio_tecnico.png') }}" class="iconos">
                                <span class="nav-label">Servicios</span>
                            </a>
                    </li> --}}

                    {{-- <li>
                            <a href="{{ route('garantia_guia_ingreso.index') }}">
                                <img src="{{ asset('/archivos/imagenes/layout/servicio_tecnico.png') }}" class="iconos">
                                <span class="nav-label">Garantia</span>
                            </a>
                        </li> --}}
                    {{--  FIN MENU DESPELEGABLE NUEVO --}}

                    {{--  MENU DESPELEGABLE ANTIGUO no --}}

                    @can('inicio')
                        {{-- <li><a href="{{ route('inicio') }}"><img
                                    src="{{ asset('/archivos/imagenes/layout/inicio.svg') }}" class="iconos"> <span
                                    class="nav-label">Inicio</span></a></li> --}}
                    @endcan
                    {{-- REGLA PHP PARA LLAMADA DE KARDEX ENTRADA PARA CONDICIONAL PASADO A APPSERVICEPROVIDERS --}}
                    {{-- {{$inventario_inicial->estado}} --}}
                    @can('transacciones')
                        {{-- <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/comercializacion.svg') }}"
                                    class="iconos"> <span class="nav-label">Comercialización</span></a>
                            <ul class="nav nav-second-level collapse">
                                @if (empty($inventario_inicial)) --}}
                        {{-- @if ($conteo_almacen == 1) --}}
                        {{-- <li> <a href="{{ route('cotizacion.index') }}"><span
                                        class="nav-label">Cotizacion</span></a> </li> --}}
                        {{-- @if ($conteo_almacen == 1) --}}

                        {{-- <li> <a href="{{ route('cotizacion.index') }}"><span
                                                class="nav-label">Cotizaciones</span></a> </li>
                                    <li><a href="{{ route('cotizacion_manual.index') }}"><span
                                                class="nav-label">Cotizaciones M.</span></a> </li>
                                    <li><a href="{{ route('indexServicio.index') }}"><span
                                                    class="nav-label">Cotizaciones M. Servicios</span></a> </li>
                                    <li><a href="{{ route('facturacion.index') }}"><span>Facturación</span></a></li>
                                    <li><a href="{{ route('facturacion_manual.index') }}"><span>Facturación M.</span></a>
                                    </li>
                                    <li><a href="{{ route('boleta.index') }}"><span>Boleta</span></a></li>
                                    <li><a href="{{ route('boleta_manual.index') }}"><span>Boleta M.</span></a></li>
                                    <li><a href="{{ route('nota_venta.index') }}"><span>Nota Venta</span></a></li>
                                    <li><a href="{{ route('nota-credito.index') }}"><span>Nota Crédito</span></a></li> --}}


                        {{-- @endif --}}
                        {{-- @elseif($inventario_inicial->estado==1)
                                <li><a href="{{route('facturacion.index')}}">Facturación Servicio</a></li>
                                <li><a href="{{route('boleta.index')}}">Boleta Servicio</a></li> --}}
                        {{-- @else
                                    <li> <a href="{{ route('cotizacion.index') }}"><span
                                                class="nav-label">Cotizaciones</span></a> </li>
                                    <li><a href="{{ route('cotizacion_manual.index') }}"><span
                                                class="nav-label">Cotizaciones M.</span></a> </li>
                                    <li><a href="{{ route('indexServicio.index') }}"><span
                                                    class="nav-label">Cotizaciones M. Servicios</span></a> </li>
                                    <li><a href="{{ route('boleta.index') }}"><span>Boleta</span></a></li>
                                    <li><a href="{{ route('boleta_manual.index') }}"><span>Boleta M.</span></a></li>
                                    <li><a href="{{ route('facturacion.index') }}"><span>Facturación</span></a></li>
                                    <li><a href="{{ route('facturacion_manual.index') }}"><span>Facturación M.</span></a>
                                    </li>
                                    <li><a href="{{ route('guia_remision.index') }}"><span>Guía Remisión</span></a></li>
                                    <li><a href="{{ route('guia_remision_manual.index') }}"><span>Guía Remisión
                                                M.</span></a></li>
                                    <li><a href="{{ route('nota_venta.index') }}"><span>Nota Venta</span></a></li>
                                    <li><a href="{{ route('nota-credito.index') }}"><span>Nota Crédito</span></a></li>
                                    <li><a href="{{ route('nota-debito.index') }}"><span>Nota Débito</span></a></li> --}}
                        {{-- @else --}}
                        {{-- @endif --}}
                        {{-- @endif
                            </ul>
                        </li> --}}
                    @endcan

                    <li>

                        {{-- <a href="{{ route('clientes.index') }}">
                          <img src="{{ asset('/archivos/imagenes/layout/servicio_tecnico.png') }}" class="iconos">
                          <span class="nav-label">Servicio Técnico</span>
                        </a> --}}




                    </li>



                    {{-- <li>
                        @if (empty($inventario_inicial))
                            <a href="{{ route('kardex-entrada.create') }}"><img
                                    src="{{ asset('/archivos/imagenes/layout/inventario.svg') }}" class="iconos">
                                <span class="nav-label">Inventario Inicial</span></a>
                        @elseif($inventario_inicial->estado == 1)
                            <a href="{{ route('kardex-entrada.show', $inventario_inicial->id) }}"><img
                                    src="{{ asset('/archivos/imagenes/layout/inventario.svg') }}" class="iconos">
                                <span class="nav-label">Inventario Inicial</span></a>
                        @else

                            @can('inventario')
                                <li>
                                    <a href="#"><img src="{{ asset('/archivos/imagenes/layout/inventario.svg') }}"
                                            class="iconos"> <span class="nav-label">Inventario</span></a>
                                    <ul class="nav nav-second-level collapse">
                                        @can('inventario-productos_kardex')
                                            <li>
                                                <a href="#"><span>Kardex-Producto</span></a>
                                                <ul class="nav nav-third-level">
                                                    @can('inventario-productos_kardex-entrada_producto.index')
                                                        <li><a href="{{ route('kardex-entrada.index') }}"><span>Entrada
                                                                    Producto</span></a></li>
                                                    @endcan
                                                    <li><a href="{{ route('kardex-entrada-Distribucion.index') }}"><span>Distribución
                                                                Producto</span></a></li>
                                                    <li><a href="{{ route('kardex-entrada-Traslado-almacen.index') }}"><span>Traslado
                                                                de Almacén </span></a></li>
                                                    @can('inventario-productos_kardex-salida_producto.index')
                                                        <li><a href="{{ route('kardex-salida.index') }}"><span>Salida
                                                                    Producto</span></a></li>
                                                    @endcan

                                                </ul>
                                            </li>
                                            @can('inventario-toma_de_inventario.index')
                                                <li><a href="{{ route('periodo-consulta.index') }}"><span>Consultas de inventario</span></a></li>
                                                <!-- Periodo Consulta -->
                                            @endcan

                                            <li><a href="{{ route('cierre-periodo.index') }}"><span>Cierre Periodo</span></a></li>
                                            <li><a href="{{ route('movimiento-consulta.index') }}"><span>Movimiento Consulta</span></a></li>
                                            @endcan
                                    </ul>
                                </li>
                            @endcan

                        @endif
                    </li> --}}

                    {{-- <li>
                        <a href="#"><img src="{{ asset('/archivos/imagenes/layout/payment.png') }}"
                                class="iconos"> <span class="nav-label">Créditos</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('pagos.view_facturas') }}">Facturas</a></li>
                            <li><a href="{{ route('pagos.view_facturas_m') }}">Facturas M.</a></li>
                            <li><a href="{{ route('pagos.view_boletas') }}">Boletas</a></li>
                            <li><a href="{{ route('pagos.view_boletas_m') }}">Boletas M.</a></li>
                            <li><a href="{{ route('pagos.view_nota_venta') }}">Nota de Venta</a></li>
                        </ul>
                    </li> --}}

                    @can('planilla')
                        {{-- <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/planilla.svg') }}"
                                    class="iconos"> <span class="nav-label">Planilla</span></a>
                            <ul class="nav nav-second-level collapse">
                                @can('planilla-datos_generales.index')
                                    <li><a href="{{ route('personal.index') }}"><span>Personal</span></a></li>
                                @endcan
                                @can('planilla-vendedores.index')
                                    <li><a href="{{ route('vendedores.index') }}"><span>Vendedores</span></a></li>
                                @endcan
                                <li><a href="{{ route('vehiculo.index') }}"><span>Vehículos</span></a></li>

                    </ul>
                </li>
                @endcan
                @can('consultas')
                <li>
                    <a href="#"><img src="{{ asset('/archivos/imagenes/layout/consultas.svg')}}" class="iconos"><span class="nav-label">Consultas</span></a>
                    <ul class="nav nav-second-level collapse">
                        @can('consultas-garantias')
                        <li>
                            <a href="#"><span>Garantias</span></a>
                            <ul class="nav nav-third-level">
                                @can('consultas-garantias-guia_ingreso.index')
                                <li><a href="{{route('consultas.garantias.guias_ingreso')}}"><span>Guía Ingreso</span></a></li>
                                @endcan
                                @can('consultas-garantias-guia_egreso.index')
                                <li><a href="{{route('consultas.garantias.guias_egreso')}}"><span>Guía Egreso</span></a></li>
                                @endcan
                                @can('consultas-garantias-informe_tecnico.index')
                                <li><a href="{{route('consultas.garantias.informe_tecnico')}}"><span>Informe Técnico</span></a></li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        {{-- @can('consulta.cantidad_precio.index') --}}
                        {{-- <li><a href="{{route('cantidad_precio.index')}}"><span>Productos</span></a></li>
                        <li><a href="{{route('cantidad_precio.index_servicio')}}"><span>Servicios</span></a></li> --}}

                        {{-- @endcan --}}
                        {{-- </ul>
                </li> --}}
                    @endcan
                    <li>
                        {{-- <a href="#"><img src="{{ asset('/archivos/imagenes/layout/logo_sunat.png')}}" class="iconos"> <span class="nav-label">Registros Sunat</span></a> --}}
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('facturacion_electronica.index') }}"><span>Facturas</span></a></li>
                            <li><a href="{{ route('facturacion_electronica.index_boleta') }}"><span>Boletas</span></a>
                            </li>
                            <li><a href="{{ route('facturacion_electronica.index_guia_remision') }}"><span>Guía
                                        Remisión</span></a></li>
                            <li><a href="{{ route('facturacion_electronica.index_nota_credito') }}"><span>Nota de
                                        créditos</span></a></li>
                            <li><a href="{{ route('facturacion_electronica.index_nota_debito') }}"><span>Nota de
                                        débitos</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><img src="{{ asset('/archivos/imagenes/layout/correo.svg') }}"
                                class="iconos"> <span class="nav-label">Correo </span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('email.index') }}"><span>Bandeja de Entrada</span></a></li>
                            <li><a href="{{ route('configuracion_email.index') }}"><span>Configuración</span></a></li>
                            <li><a href="{{ route('email.trash') }}"><span>Papelera</span></a></li>

                        </ul>
                    </li>
                    {{-- <li><a href="{{ route('eventos.user_indes') }}">
                            <img src="{{ asset('/archivos/imagenes/layout/calendario.png') }}" class="iconos"> <span
                                class="nav-label">Calendario&nbsp;&nbsp;&nbsp;</span>
                            @if ($count_eventos > 0)
                                <span class="label label-warning">{{ $count_eventos }}</span>
                            @endif

                        </a>
                    </li> --}}
                    @can('auxiliares')
                        <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/auxiliar.svg') }}"
                                    class="iconos"><span class="nav-label">Auxiliares</span></a>
                            <ul class="nav nav-second-level collapse">
                                @can('auxiliares-clientes.index')
                                    <li><a href="{{ route('ventas.clientes') }}"><span>Clientes</span></a></li>
                                @endcan
                                @can('auxiliares-provedores.index')
                                    <li><a href="{{ route('provedor.index') }}"><span>Proveedores</span></a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    {{-- @can('consulta.cantidad_precio.index') --}}
                    {{-- @endcan --}}

                    </li>
                    {{-- <li>
                    <a href="#"><img src="{{ asset('/archivos/imagenes/layout/logo_sunat.png')}}" class="iconos"> <span class="nav-label">Registros Sunat</span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{route('facturacion_electronica.index')}}"><span>Facturas</span></a></li>
                        <li><a href="{{route('boletas_electronicas.index_boleta')}}"><span>Boletas</span></a></li>
                        <li><a href="{{route('guias_electronicas.index_guia_remision')}}"><span>Guía Remisión</span></a></li>
                        <li><a href="{{route('facturacion_electronica.index_nota_credito')}}"><span>Nota de créditos</span></a></li>
                        <li><a href="{{route('facturacion_electronica.index_nota_debito')}}"><span>Nota de débitos</span></a></li>
                    </ul>
                </li> --}}
                    <li>
                        @can('maestro')
                            {{-- <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/productos.svg') }}"
                                    class="iconos"><span class="nav-label">Productos y Servicios</span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="{{ route('productos.index') }}"><span>Productos</span></a></li>
                                <li><a href="{{ route('servicios.index') }}"><span>Servicios</span></a></li>
                            </ul>
                        </li> --}}
                            {{-- <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/configuracion.svg') }}"
                                    class="iconos"><span class="nav-label">Configuración </span></a>
                            <ul class="nav nav-second-level collapse">
                                @can('maestro-catalogo-clasificacion')
                                    <li><a href="{{ route('Configuracion') }}"><span>Configuración del Sistema</span></a>
                                    </li>
                                @endcan
                                @can('maestro-configuracion_general.mi_empresa.index')
                                    <li><a href="{{ route('empresa.index') }}"><span>Mi Empresa</span></a></li>
                                @endcan
                            </ul>
                        </li> --}}
                            {{-- <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="{{ asset('/archivos/imagenes/layout/logout.png') }}" class="iconos">
                                <span class="nav-label"> Cerrar Sección
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                            </a>
                        </li> --}}
                        @endcan

                        {{-- FIN MENU DESPELEGABLE ANTIGUO --}}
                </ul>
                <style>
                    /* .nav-last-footer:active img {
                        transform: translateY(-20px);
                    } */
                </style>
                <div style="padding:15px; position: fixed; bottom: 0px; height: 10vh;" class="nav-last-footer">
                    <div style="display: flex; align-items: center; margin-bottom: 1rem;height: 100%;"
                        class="nav-footer-user">
                        <a class="nav-label" style="display: flex; align-items: center;" {{-- href="{{route('usuario.index')}}" --}}>
                            <img alt="image" class="rounded-circle"
                                src="{{ asset('/profile/images/') }}/@yield('foto', auth()->user()->avatar)"
                                style="width: 46px; height: 46px; border: 1px solid black;background-color: white" />
                            <div class="nav-label" style="margin-left: 20px;">
                                <span class="block m-t-xs font-bold spans"
                                    style="font-size: 14px;color: white">{{$empresa->nombre}}</span>
                                <span class="block m-t-xs text-white font-bold mr-3">@yield('area', auth()->user()->name)</span>
                            </div>
                            <div class="nav-label" style="margin-left: 10px; position: relative;">
                                <i class="fa fa-ellipsis-v" id="menuIcon"
                                    style="color: white; font-size: 19px; margin-right: 15px; cursor: pointer;"></i>

                                <!-- Menú desplegable -->
                                <div id="dropdownMenu"
                                    style="display: none; position: absolute; bottom: 50px; right: 0; background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius: 5px; padding: 10px; width: 150px;">
                                    <a href="{{ route('usuario.perfil') }}" class="dropdown-item"
                                        style="display: block; color: black; padding: 8px; text-decoration: none;">
                                        <i class="fa fa-user-circle-o fa-lg"></i> Mi perfil</a>
                                    <a href="{{ route('empresa.index') }}" class="dropdown-item"
                                        style="display: block; color: black; padding: 8px; text-decoration: none;">
                                        <i class="fa fa-university "></i> Mi Empresa</a>
                                    <a href="{{ route('Configuracion') }}" class="dropdown-item"
                                        style="display: block; color: black; padding: 8px; text-decoration: none;">
                                        <i class="fa fa-cog fa-lg"></i> Configuración</a>
                                    <a href="{{ route('logout') }}" class="dropdown-item"
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
                        </a>
                    </div>
                </div>

            </div>
        </nav>
        {{-- Menu Superior --}}
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top bg-white" role="navigation" style="margin-bottom: 0">
                    <div class="container-fluid">
                        <div class="start-header">
                            <div class="navbar-center">
                                <div class="col-lg-12">
                                        <div class="row tipo_cambio">
                                            @if (isset($tipo_cambio->fecha))
                                                <div class="col-sm-4">
                                                    <div style="color: black" class="text-center">
                                                        <strong>Compra:</strong>
                                                        <div><span>{{ $tipo_cambio->compra }}</span></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div style="color: black" class="text-center">
                                                        <strong>Venta:</strong>
                                                        <div><span>{{ $tipo_cambio->venta }}</span></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div style="color: black" class="text-center">
                                                        <strong>Paralelo:</strong>
                                                        <div><span id="tc_paralelo">{{ $tipo_cambio->paralelo }}</span></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="mensajes1">
                            @php $mostrar = false; @endphp
                            <div class="custom-container">
                                <div class="left-side left">
                                    <i class="fa fa-bell mx-3"></i>
                                    <div class="left-side-slider">
                                        @once @php $x = 0; @endphp @endonce
                                        <div class="slides">
                                            @if ($fact_view_count > 0 || $fact_m_view_count > 0)
                                                <span class="span_slide" style="--i:{{ $x }}">{{ (int) $fact_view_count + (int) $fact_m_view_count ?? '0' }}
                                                    &nbsp; &nbsp;Facturas</span>
                                                @php $x++ @endphp
                                                @php $mostrar = true; @endphp
                                            @endif
                                            @if ($bol_view_count > 0 || $bol_m_view_count > 0)
                                                <span class="span_slide" style="--i:{{ $x }}">{{ (int) $bol_view_count + (int) $bol_m_view_count ?? '0' }}
                                                    &nbsp; &nbsp;Boletas</span>
                                                @php $x++ @endphp
                                                @php $mostrar = true; @endphp
                                            @endif
                                            @if ($guia_view_count > 0 || $guia_m_view_count > 0)
                                                <span class="span_slide" style="--i:{{ $x }}">{{ (int) $guia_view_count + (int) $guia_m_view_count ?? '0' }}
                                                    &nbsp; &nbsp;Guías R.</span>
                                                @php $x++ @endphp
                                                @php $mostrar = true; @endphp
                                            @endif
                                            @if ($n_credito_view_count > 0)
                                                <span class="span_slide" style="--i:{{ $x }}">{{ $n_credito_view_count ?? '0' }} &nbsp; &nbsp;Nota C.</span>
                                                @php $x++ @endphp
                                                @php $mostrar = true; @endphp
                                            @endif
                                            @if ($n_debito_view_count > 0)
                                                <span class="span_slide" style="--i:{{ $x }}">{{ $n_debito_view_count ?? '0' }} &nbsp; &nbsp; Nota D.</span>
                                                @php $x++ @endphp
                                                @php $mostrar = true; @endphp
                                            @endif
                                            @if (! $mostrar)
                                                <span class="span_slide" style="--i:{{ $x }}">Ningún doc.</span>
                                                @php $x++ @endphp
                                            @endif
                                        </div>
                                        <style>
                                            :root {
                                                --top_marg: {{$x}};
                                                }

                                        </style>
                                        @if($x > 0)
                                        <style>
                                            .left-side.left > i {
                                                animation: scalePulse 1.2s ease-in-out infinite;
                                                will-change: transform;         /* sugiere al navegador optimizar */
                                                backface-visibility: hidden;    /* evita parpadeo */
                                                transform-origin: center center;
                                            }

                                        </style>
                                        @endif
                                    </div>

                                </div>
                                <div class="right-side">
                                    {{-- <i class="fa fa-bell mx-3"></i> --}}
                                    <div class="left-side-slider">
                                        <div class="slides2">

                                            @if ($fact_view_count > 0 || $fact_m_view_count > 0)
                                                <a class="link span_slide2" href="{{route('facturacion_electronica.index')}}">Enviar a Sunat</a>

                                            @endif
                                            @if ($bol_view_count > 0 || $bol_m_view_count > 0)
                                                <a class="link span_slide2" href="{{route('facturacion_electronica.index_boleta')}}">Enviar a Sunat</a>

                                            @endif
                                            @if ($guia_view_count > 0 || $guia_m_view_count > 0)
                                                <a class="link span_slide2" href="{{route('facturacion_electronica.index_guia_remision')}}">Enviar a Sunat</a>

                                            @endif
                                            @if ($n_credito_view_count > 0)
                                                <a class="link span_slide2" href="{{route('facturacion_electronica.index_nota_credito')}}">Enviar a Sunat</a>

                                            @endif
                                            @if ($n_debito_view_count > 0)
                                                <a class="link span_slide2" href="{{route('facturacion_electronica.index_nota_debito')}}">Enviar a Sunat</a>

                                            @endif
                                            @if (! $mostrar)
                                                <a class="link span_slide2 disabled" href="javascript:void(0)">Enviar a Sunat</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mensajes2">
                            <div class="custom-container">
                                <div class="left-side">
                                    <i class="fa fa-exclamation-circle fa-2x mx-3"></i>
                                    <span>0 de 0</span>
                                </div>
                                <div class="right-side">
                                    <a class="link">Mensajes</a>
                                </div>
                            </div>
                        </div>
                        <div class="mensajes2-mobile">
                            <li>
                                <a href=""  class="count-info">
                                    <i class="fa fa-bell fa-lg fa-3x" style="color: #1a3bb3;"></i><span class="label label-warning">0</span>
                                </a>
                            </li>
                        </div>

                        <div class="calendar-none">
                            <li class="">
                                <a href="{{ route('eventos.user_indes') }}" class="count-info">
                                    <i class="fa fa-calendar fa-lg fa-3x " style="color: #1a3bb3"></i>
                                    {{-- @if ($count_eventos != 0) --}}
                                        <span class="label label-warning">{{ $count_eventos }}</span>
                                    {{-- @endif --}}
                                </a>
                            </li>
                        </div>
                        <div>
                            <li class="">
                                <a href="{{ route('email.index') }}" class="count-info">
                                    <i class="fa fa-envelope fa-lg fa-3x " style="color: #1a3bb3"></i>
                                </a>
                            </li>
                        </div>

                    </div>
            </div>

            {{-- <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>@yield('title', 'Inicio')</h2>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        <a style="visibility:@yield('visibility', 'hidden')"href="@yield('ruta', '')"
                            class="btn btn-primary">@yield('name', '')</a>

                        @yield('boton_opcional')

                        <a data-toggle="@yield('data-toggle', '')" onclick="@yield('onclick1', '')" href="@yield('href_accion', '#')"
                            class="btn btn-primary" @yield('atributo_1', '')>@yield('value_accion', '#')</a>

                        <a id="actualizar" data-toggle="@yield('data-config', '')" onclick="@yield('onclick', '')"
                            href="@yield('config', '')" class="@yield('class', 'btn btn-primary')"
                            @yield('atributo_actu', '')>@yield('button2', 'Actualizar')</a>
                    </div>
                </div>
            </div> --}}

            @yield('content')


            <div class="footer">
                <div class="float-right">
                    Visitanos: &nbsp;&nbsp; <a href="https://www.facebook.com/JYPPERIFERICOSSAC" target="_blank"><i
                            class="fa fa-facebook-square" aria-hidden="true"></i></a>&nbsp;
                    <a href="https://api.whatsapp.com/send?phone=51946201443&text=Hola!%20Necesito%20Ayuda%20con%20el%20sistema%20de%20Facturación,%20Gracias!%20"
                        target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                </div>
                <div>
                    <strong>Copyright </strong> &nbsp;<a href="http://www.jypsac.com" target="_blank"> JyP
                        Periféricos</a>&nbsp; &copy; 2019-{{ date('Y') }}
                </div>

            </div>


            {{-- <ul class="nav navbar-top-links navbar-right" >
                    <li class="dropdown" style="margin: 0px 50px" @if ($fact_view_count > 0 || $fact_m_view_count > 0 || $bol_view_count > 0 || $bol_m_view_count > 0 || $n_credito_view_count || $n_debito_view_count)  data-toggle="popover" data-placement="left" data-content="Tiene documentos pendientes de enviar a SUNAT"  @endif  id="btn_popover">
                        <a class="dropdown-toggle count-info " data-toggle="dropdown" href="#" style="">
                            <i class="fa fa-bell " style="font-size: 18px; @if ($fact_view_count > 0 || $fact_m_view_count > 0 || $bol_view_count > 0 || $bol_m_view_count > 0 || $n_credito_view_count || $n_debito_view_count) color: red @endif"></i>
                        </a> --}}
            {{-- SI HAY PARA ENVIAR --}}
            {{-- <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i> <span class="label label-primary">Cantidad de Facturas</span>
                        </a> --}}
            {{-- <ul class="dropdown-menu dropdown-alerts" style="padding: 1px">
                            @if ($fact_view_count > 0 || $fact_m_view_count > 0)
                            <li>
                                <a href="{{route('facturacion_electronica.index')}}" class="dropdown-item">
                                    <div>
                                        Tiene @if ($fact_view_count > 0) <strong>{{$fact_view_count}} Facturas</strong>  @endif @if ($fact_m_view_count > 0 && $fact_view_count > 0) y @endif  @if ($fact_m_view_count > 0) <strong>{{$fact_m_view_count}} Facturas Manuales</strong> @endif pendientes de enviar a SUNAT
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if ($bol_view_count > 0 || $bol_m_view_count > 0)
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('boletas_electronicas.index_boleta')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if ($bol_view_count > 0) <strong>{{$bol_view_count}} Boletas</strong>  @endif @if ($bol_m_view_count > 0 && $bol_view_count > 0) y @endif  @if ($bol_m_view_count > 0) <strong>{{$bol_m_view_count}} Boletas Manuales</strong> @endif pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if ($guia_view_count > 0 || $guia_m_view_count > 0)
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('guias_electronicas.index_guia_remision')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if ($guia_view_count > 0) <strong>{{$guia_view_count}} Guia R.</strong>  @endif @if ($guia_m_view_count > 0 && $guia_view_count > 0) y @endif  @if ($guia_m_view_count > 0) <strong>{{$guia_m_view_count}} Guias R. Manuales</strong> @endif pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if ($n_credito_view_count > 0)
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('facturacion_electronica.index_nota_credito')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if ($n_credito_view_count > 0) <strong>{{$n_credito_view_count}} Nota Credito</strong>  @endif pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if ($n_debito_view_count > 0)
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('facturacion_electronica.index_nota_debito')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if ($n_debito_view_count > 0) <strong>{{$n_debito_view_count}} Nota Debito</strong>  @endif   pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if ($fact_view_count == 0 && $fact_m_view_count == 0 && $bol_view_count == 0 && $bol_m_view_count == 0 && $n_credito_view_count == 0 && $n_credito_view_count == 0)
                                <li>
                                    <a href="#">
                                        <div>
                                            Sin envios Pendientes a SUNAT
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                </div>
            </ul> --}}
            {{-- <div class="hide-on2">
                                <div class="dropdown profile-element d-flex align-items-center justify-content-center" style="padding: 0;">
                                    <a href="{{ route('usuario.index') }}" class="d-flex align-items-center text-center">
                                        <span class="block m-t-xs text-black font-bold mr-3 ">@yield('area', auth()->user()->name)</span>
                                        <img alt="image" class="rounded-circle " src="{{ asset('/profile/images/') }}/@yield('foto', auth()->user()->avatar)" style="width: 70px; height: 70px; border: 3px solid black;" />
                                    </a>
                                </div>
                            </div> --}}

            {{-- <div>
                            <li class=" mr-5" >
                                    <a href="{{ route('logout') }}" class="logout-btn"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                    <i class="fa fa-sign-out fa-lg"></i> Cerrar Sesión
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>

                                    </a>
                            </li>
                        </div> --}}
        </div>
        </nav>
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

</html>
