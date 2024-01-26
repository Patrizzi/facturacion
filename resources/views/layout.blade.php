<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('/archivos/imagenes/servicios/')}}/@yield('3', auth()->user()->config->foto_icono)" rel="shortcut icon" />
    <title>@yield('title', 'Inicio')/@yield('3', auth()->user()->name)</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">


    {{-- <script src="@yield('vue_js', '#')" defer></script> --}}
    <link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/footable/footable.core.css')}}" rel="stylesheet">
    
    <link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('main.css') }}" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/icono.svg') }}" sizes="any">
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

</head>

{{--  --}}
<style>.iconos{width: 20px;border-radius: 0px;margin-right: 10px}</style>
<style type="text/css">
    body {
        @if(auth()->user()->config->letra != 'none') font-family: @yield('Letra', auth()->user()->config->letra) !important; @endif 
        @if(auth()->user()->config->tamano_letra != '') font-size: @yield('tamano_letra', auth()->user()->config->tamano_letra) !important; @endif
    }
    .form-control , table , span{
        @if(auth()->user()->config->letra != 'none') font-family: @yield('Letra', auth()->user()->config->letra) !important; @endif 
        @if(auth()->user()->config->tamano_letra != '') font-size: @yield('tamano_letra', auth()->user()->config->tamano_letra) !important; @endif
    }
    span.select2-selection__placeholder {
        @if(auth()->user()->config->tamano_letra == '' || auth()->user()->config->tamano_letra == null || auth()->user()->config->tamano_letra == 'smaller' ) font-size: small !important; @else  font-size: @yield('tamano_letra', auth()->user()->config->tamano_letra) !important ;  @endif 
    }
    .spans{
        color:@yield('color_nombre', auth()->user()->config->color_nombre) !important;
        font-size: @yield('tamano_letra_perfil', auth()->user()->config->tamano_letra_perfil);
        text-shadow: 2px  2px 2px @yield('color_sombra', auth()->user()->config->color_sombra_nombre);
    }

    .nav-header {
        background-image: url("{{ asset('/css/patterns/')}}/@yield('1', auth()->user()->config->fondo_perfil)");
      }

      .btn-primary {
        color: #fff;
        background-color: #1a5eb3;
        border-color: #1a3bb3;
    }
    .btn-primary:hover {
        color: #fff;
        background-color: #1a3bb3;
        border-color: #1a5eb3;
    }
    .page-item.active .page-link {
        background-color: #1a5eb3;
        border-color: #1a3bb3;
    }
    .dataTables_filter{
        text-align: right;
    }
    .dataTables_filter > label{
        text-align: left;
    }
    .rounded-circle{width: 120px; height: auto; border:@yield('2', auth()->user()->config->borde_foto) solid @yield('2', auth()->user()->config->color_borde_foto);}
    .posta_a {
        border: none;
        outline: none;
        background: none;
        cursor: pointer;
        color: #a7b1c2;
        padding: 7px 10px 7px 10px;
        padding-left: 52px;
        font-weight: 600;
    }
    .posta_a:hover{
        color: white;
    }
    @keyframes beat{
        to { transform: scale(1.4); }
    }
    .link_alert{
        animation: beat .45s infinite alternate;
        transform-origin: center;
        /* border: 1px solid red;  */
        /* min-width: 0px !important;
        width: 25px !important; 
        min-height: 0px !important;
        height: 25px !important; */
        /* padding: 5px 5px !important; */
        /* margin: 10px 0px; */
        align-self: center;
    }
    .popover-body{
        color:#721c24;
        background-color: #f8d7da;
        font-weight: bold;
        text-align: center;
    }
</style>
<body class="">
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element" style="left: 10% ">
                            <a href="{{route('usuario.index')}}">
                                <img alt="image" class="rounded-circle" src=" {{ asset('/profile/images/')}}/@yield('foto', auth()->user()->avatar)" style="width: 150px;height: 150px" />
                                <span class="block m-t-xs font-bold spans">@yield('nombre',auth()->user()->nombre)</span>
                                <span class="block m-t-xs  spans ">@yield('area',auth()->user()->name) </span>
                            </a>
                        </div>
                        <div class="logo-element">

                        </div>
                    </li>
                    {{-- MENU DESPELEGABLE --}}
                    @can('inicio')
                    <li><a href="{{route('inicio')}}"><img src="{{ asset('/archivos/imagenes/layout/inicio.svg')}}" class="iconos"> <span class="nav-label">Inicio</span></a></li>
                    @endcan
                    {{-- REGLA PHP PARA LLAMADA DE KARDEX ENTRADA PARA CONDICIONAL PASADO A APPSERVICEPROVIDERS --}}
                    {{-- {{$inventario_inicial->estado}} --}}
                    @can('transacciones')
                    <li>
                        <a href="#"><img src="{{ asset('/archivos/imagenes/layout/comercializacion.svg')}}" class="iconos"> <span class="nav-label">Comercialización</span></a>
                        <ul class="nav nav-second-level collapse">
                            @if(empty($inventario_inicial))
                                {{-- @if($conteo_almacen==1) --}}
                                    <li> <a href="{{route('cotizacion.index')}}"><span  class="nav-label">Cotizaciones</span></a> </li>
                                    <li><a href="{{route('cotizacion_manual.index')}}"><span  class="nav-label">Cotizaciones M.</span></a> </li>
                                    <li><a href="{{route('facturacion.index')}}"><span>Facturación</span></a></li>
                                    <li><a href="{{route('facturacion_manual.index')}}"><span>Facturación M.</span></a></li>
                                    <li><a href="{{route('boleta.index')}}"><span>Boleta</span></a></li>
                                    <li><a href="{{route('boleta_manual.index')}}"><span>Boleta M.</span></a></li>    
                                    <li><a href="{{route('nota_venta.index')}}"><span>Nota Venta</span></a></li>
                                    <li><a href="{{route('nota-credito.index')}}"><span>Nota Crédito</span></a></li>
                                {{-- @endif --}}
                            {{-- @elseif($inventario_inicial->estado==1)
                                <li><a href="{{route('facturacion.index')}}">Facturación Servicio</a></li>
                                <li><a href="{{route('boleta.index')}}">Boleta Servicio</a></li> --}}
                                
                            @else
                                {{-- @if($inventario_inicial->estado) --}}
                                    <li> <a href="{{route('cotizacion.index')}}"><span  class="nav-label">Cotizaciones</span></a> </li>
                                    <li><a href="{{route('cotizacion_manual.index')}}"><span  class="nav-label">Cotizaciones M.</span></a> </li>
                                    <li><a href="{{route('boleta.index')}}"><span>Boleta</span></a></li>
                                    <li><a href="{{route('boleta_manual.index')}}"><span>Boleta M.</span></a></li>
                                    <li><a href="{{route('facturacion.index')}}"><span>Facturación</span></a></li>
                                    <li><a href="{{route('facturacion_manual.index')}}"><span>Facturación M.</span></a></li>
                                    <li><a href="{{route('guia_remision.index')}}"><span>Guía Remisión</span></a></li>
                                    <li><a href="{{route('guia_remision_manual.index')}}"><span>Guía Remisión M.</span></a></li>
                                    <li><a href="{{route('nota_venta.index')}}"><span>Nota Venta</span></a></li>
                                    <li><a href="{{route('nota-credito.index')}}"><span>Nota Crédito</span></a></li>
                                    <li><a href="{{route('nota-debito.index')}}"><span>Nota Débito</span></a></li>
                                {{-- @else --}}
                                {{-- @endif --}}
                            @endif
                        </ul>
                    </li>
                    <li>
                        <a href="#"><img src="{{ asset('/archivos/imagenes/layout/servicio_tecnico.png')}}" class="iconos"> <span class="nav-label">Servicio Técnico</span></a>
                        <ul class="nav nav-second-level collapse">
                         @can('transacciones-garantias-guias_ingreso.index')
                         <li><a href="{{route('garantia_guia_ingreso.index')}}"><span>Guía Ingreso</span></a></li>
                         @endcan
                         @can('transacciones-garantias-guias_egreso.index')
                         <li><a href="{{route('garantia_guia_egreso.index')}}"><span>Guía Egreso</span></a></li>
                         @endcan
                         @can('transacciones-garantias-informe_tecnico.index')
                         <li><a href="{{route('garantia_informe_tecnico.index')}}"><span>Informe Técnico</span></a></li>
                         @endcan

                     </ul>
                 </li>
                 @if(empty($inventario_inicial))
                 <li>
                    <a href="{{route('kardex-entrada.create')}}"><img src="{{ asset('/archivos/imagenes/layout/inventario.svg')}}" class="iconos">  <span class="nav-label">Inventario Inicial</span></a>
                    @elseif($inventario_inicial->estado==1)
                    <li>
                        <a href="{{route('kardex-entrada.show',$inventario_inicial->id)}}"><img src="{{ asset('/archivos/imagenes/layout/inventario.svg')}}" class="iconos">  <span class="nav-label">Inventario Inicial</span></a>
                        @else


                        @can('inventario')
                        <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/inventario.svg')}}" class="iconos">  <span class="nav-label">Inventario</span></a>
                            <ul class="nav nav-second-level collapse">
                                @can('inventario-productos_kardex')
                                <li>
                                    <a href="#"><span>Kardex-Producto</span></a>
                                    <ul class="nav nav-third-level">
                                        @can('inventario-productos_kardex-entrada_producto.index')
                                        <li><a href="{{route('kardex-entrada.index')}}"><span>Entrada Producto</span></a></li>
                                        @endcan
                                        <li><a href="{{route('kardex-entrada-Distribucion.index')}}"><span>Distribución Producto</span></a></li>
                                        <li><a href="{{route('kardex-entrada-Traslado-almacen.index')}}"><span>Traslado de Almacén </span></a></li>
                                        @can('inventario-productos_kardex-salida_producto.index')
                                        <li><a href="{{route('kardex-salida.index')}}"><span>Salida Producto</span></a></li>
                                        @endcan

                                    </ul>
                                </li>
                                @endcan
                                @endif

                                {{-- <li><a href="{{route('pagados.index')}}">Pagados</a></li> --}}
                        {{-- @can('inventario-productos-inventario_inicial.index')
                        <li><a href="{{route('inventario-inicial.index')}}">Inventario Inicial</a></li>
                        @endcan --}}
                        @can('inventario-toma_de_inventario.index')
                        <li><a href="{{route('periodo-consulta.index')}}"><span>Consultas de inventario</span></a></li><!-- Periodo Consulta -->
                        @endcan
                        <li><a href="{{route('cierre-periodo.index')}}"><span>Cierre Periodo</span></a></li>
                        <li><a href="{{route('movimiento-consulta.index')}}"><span>Movimiento Consulta</span></a></li>
                    </ul>
                </li>
                @endif
                @endcan
                <li>
                    <a href="#"><img src="{{ asset('/archivos/imagenes/layout/.svg')}}" class="iconos">  <span class="nav-label">Créditos</span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            {{-- <a href="#">Pagos</a>
                            <ul class="nav nav-third-level"> --}}
                                <li><a href="{{route('pagos.view_facturas')}}">Facturas</a></li>
                                <li><a href="{{route('pagos.view_facturas_m')}}">Facturas M.</a></li>
                                <li><a href="{{route('pagos.view_boletas')}}">Boletas</a></li>
                                <li><a href="{{route('pagos.view_boletas_m')}}">Boletas M.</a></li>
                                <li><a href="{{route('pagos.view_facturas')}}">Nota de Venta</a></li>
                                {{-- <li><a href="">Cobrar</a></li> --}}
                            {{-- </ul> --}}
                        </li>
                        {{-- <li><a href="#">Registro de Cuotas</a></li>
                        <li><a href="#">Recibos</a></li> --}}
                    </ul>
                </li>

                @can('planilla')
                <li>
                    <a href="#"><img src="{{ asset('/archivos/imagenes/layout/planilla.svg')}}" class="iconos"> <span class="nav-label">Planilla</span></a>
                    <ul class="nav nav-second-level collapse">
                        @can('planilla-datos_generales.index')
                        <li><a href="{{route('personal.index')}}"><span>Personal</span></a></li>
                        @endcan
                        @can('planilla-vendedores.index')
                        <li><a href="{{route('vendedores.index')}}"><span>Vendedores</span></a></li>
                        @endcan
                        <li><a href="{{route('vehiculo.index')}}"><span>Vehículos</span></a></li>

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
                        <li><a href="{{route('cantidad_precio.index')}}"><span>Productos</span></a></li>
                        <li><a href="{{route('cantidad_precio.index_servicio')}}"><span>Servicios</span></a></li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                @endcan
                <li>
                    <a href="#"><img src="{{ asset('/archivos/imagenes/layout/logo_sunat.png')}}" class="iconos"> <span class="nav-label">Registros Sunat</span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{route('facturacion_electronica.index')}}"><span>Facturas</span></a></li>
                        <li><a href="{{route('facturacion_electronica.index_boleta')}}"><span>Boletas</span></a></li>
                        <li><a href="{{route('facturacion_electronica.index_guia_remision')}}"><span>Guía Remisión</span></a></li>
                        <li><a href="{{route('facturacion_electronica.index_nota_credito')}}"><span>Nota de créditos</span></a></li>
                        <li><a href="{{route('facturacion_electronica.index_nota_debito')}}"><span>Nota de débitos</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><img src="{{ asset('/archivos/imagenes/layout/correo.svg')}}" class="iconos"> <span class="nav-label">Correo </span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{route('email.index')}}"><span>Bandeja de Entrada</span></a></li>
                        <li><a href="{{route('configuracion_email.index')}}"><span>Configuración</span></a></li>
                        <li><a href="{{route('email.trash')}}"><span>Papelera</span></a></li>

                    </ul>
                </li>
                <li><a href="{{route('eventos.user_indes')}}">
                        <img src="{{ asset('/archivos/imagenes/layout/calendario.png')}}" class="iconos"> <span class="nav-label">Calendario&nbsp;&nbsp;&nbsp;</span>
                        @if ($count_eventos > 0)
                            <span class="label label-warning">{{$count_eventos}}</span>    
                        @endif
                        
                    </a>
                </li>
                @can('auxiliares')
                <li>
                    <a href="#"><img src="{{ asset('/archivos/imagenes/layout/auxiliar.svg')}}" class="iconos"><span class="nav-label">Auxiliares</span></a>
                    <ul class="nav nav-second-level collapse">
                        @can('auxiliares-clientes.index')
                        <li><a href="{{route('cliente.index')}}"><span>Clientes</span></a></li>
                        @endcan
                        @can('auxiliares-provedores.index')
                        <li><a href="{{route('provedor.index')}}"><span>Proveedores</span></a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('maestro')
                <li>
                    <a href="#"><img src="{{ asset('/archivos/imagenes/layout/productos.svg')}}" class="iconos"><span class="nav-label">Productos y Servicios</span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{route('productos.index')}}"><span>Productos</span></a></li>
                        <li><a href="{{route('servicios.index')}}"><span>Servicios</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><img src="{{ asset('/archivos/imagenes/layout/configuracion.svg')}}" class="iconos"><span class="nav-label">Configuración </span></a>
                    <ul class="nav nav-second-level collapse">
                        @can('maestro-catalogo-clasificacion')
                        <li><a href="{{route('Configuracion')}}"><span>Configuración del Sistema</span></a></li>
                        @endcan
                        @can('maestro-configuracion_general.mi_empresa.index')
                        <li><a href="{{route('empresa.index')}}"><span>Mi Empresa</span></a></li>
                        @endcan
                    </ul>
                </li>
                <li>
                  <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();"><img src="{{ asset('/archivos/imagenes/layout/logout.png')}}" class="iconos"><span class="nav-label">
                    Cerrar Sección
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>
            </li>

            @endcan

            {{-- MENU DESPELEGABLE --}}
        </ul>
    </div>
</nav>
{{-- Menu Superior --}}
<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>
                
                        {{-- <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                        <input type="text" placeholder="Buscar..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form> --}}
                    
                </div>
                <div class="nav-bar navbar-center">
                    <div class=" minimalize-style-3 " style="vertical-align: middle;width: 21em">
                        <div class="col-lg-12" style="padding: 5px">
                            <div class="row">
                                @if (isset($tipo_cambio->fecha))
                                    <div class="col-sm-4">
                                        <div style="color: black" class="text-center">
                                            <span><strong>Compra :</strong><br>{{$tipo_cambio->compra}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div style="color: black" class="text-center">
                                            <span><strong>Venta :</strong><br>{{$tipo_cambio->venta}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div style="color: black" class="text-center">
                                            <span><strong>Paralelo :</strong><br>{{$tipo_cambio->paralelo}}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>  
                </div>
                <ul class="nav navbar-top-links navbar-right" >
                    <li class="dropdown" style="margin: 0px 50px" @if ($fact_view_count > 0 || $fact_m_view_count > 0 || $bol_view_count > 0 || $bol_m_view_count > 0 || $n_credito_view_count || $n_debito_view_count)  data-toggle="popover" data-placement="left" data-content="Tiene documentos pendientes de enviar a SUNAT"  @endif  id="btn_popover">
                        {{-- SI NO HAY NADA PARA ENVIAR --}}
                        <a class="dropdown-toggle count-info " data-toggle="dropdown" href="#" style="">
                            <i class="fa fa-bell " style="font-size: 18px; @if($fact_view_count > 0 || $fact_m_view_count > 0 || $bol_view_count > 0 || $bol_m_view_count > 0 || $n_credito_view_count || $n_debito_view_count) color: red @endif"></i> 
                            {{-- <span class="label label-danger link_alert">Enviar a Sunat</span> --}}
                        </a>
                        {{-- SI HAY PARA ENVIAR --}}
                        {{-- <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i> <span class="label label-primary">Cantidad de Facturas</span>
                        </a> --}}
                        <ul class="dropdown-menu dropdown-alerts" style="padding: 1px">
                            @if ($fact_view_count > 0 || $fact_m_view_count > 0)
                            <li>
                                <a href="{{route('facturacion_electronica.index')}}" class="dropdown-item">
                                    <div>
                                        Tiene @if($fact_view_count > 0) <strong>{{$fact_view_count}} Facturas</strong>  @endif @if($fact_m_view_count > 0 && $fact_view_count > 0) y @endif  @if($fact_m_view_count > 0) <strong>{{$fact_m_view_count}} Facturas Manuales</strong> @endif pendientes de enviar a SUNAT
                                    </div>
                                </a>    
                            </li>
                            @endif
                            @if ($bol_view_count > 0 || $bol_m_view_count > 0)
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('facturacion_electronica.index_boleta')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if($bol_view_count > 0) <strong>{{$bol_view_count}} Boletas</strong>  @endif @if($bol_m_view_count > 0 && $bol_view_count > 0) y @endif  @if($bol_m_view_count > 0) <strong>{{$bol_m_view_count}} Boletas Manuales</strong> @endif pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>    
                            @endif
                            @if ($guia_view_count > 0 || $guia_m_view_count > 0)
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('facturacion_electronica.index_guia_remision')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if($guia_view_count > 0) <strong>{{$guia_view_count}} Guia R.</strong>  @endif @if($guia_m_view_count > 0 && $guia_view_count > 0) y @endif  @if($guia_m_view_count > 0) <strong>{{$guia_m_view_count}} Guias R. Manuales</strong> @endif pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>    
                            @endif
                            @if ($n_credito_view_count > 0)
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('facturacion_electronica.index_nota_credito')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if($n_credito_view_count > 0) <strong>{{$n_credito_view_count}} Nota Credito</strong>  @endif pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>    
                            @endif
                            @if ($n_debito_view_count > 0 )
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('facturacion_electronica.index_nota_debito')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if($n_debito_view_count > 0) <strong>{{$n_debito_view_count}} Nota Debito</strong>  @endif   pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>    
                            @endif
                            @if($fact_view_count == 0 && $fact_m_view_count == 0 && $bol_view_count == 0 && $bol_m_view_count == 0 && $n_credito_view_count == 0 && $n_credito_view_count == 0)
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
                    
                    <li style="width: 20px">
                        <span></span>
                    </li>
                    <li>
                        <span class="m-r-sm text-muted welcome-message" ><img src="{{asset('img/logos/'.$empresa->foto)}}" height="50px"></span>
                    </li>
                </ul>
                
            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>@yield('title', 'Inicio')</h2>
                        <!-- <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                        <a>@yield('breadcrumb', '')</a>
                        </li>
                        <li class="breadcrumb-item active">
                        <strong>@yield('breadcrumb2', '')</strong>
                        </li>
                    </ol> -->
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        <a style="visibility:@yield('visibility', 'hidden')" {{-- data-toggle="@yield('a', '')" --}}  href="@yield('ruta', '')" class="btn btn-primary">@yield('name', '')</a>

                        @yield('boton_opcional')

                        <a data-toggle="@yield('data-toggle', '')" onclick="@yield('onclick1', '')" href="@yield('href_accion', '#')" class="btn btn-primary" @yield('atributo_1', '')>@yield('value_accion', '#')</a>

                        <a id="actualizar" data-toggle="@yield('data-config', '')" onclick="@yield('onclick', '')"   href="@yield('config', '')"  class="@yield('class', 'btn btn-primary')" @yield('atributo_actu', '') >@yield('button2', 'Actualizar')</a>
                        </div><!--
                            @yield('div', '') -->



                        </div>

                    </div>

                    @yield('content')




                    <div class="footer">
                        <div class="float-right">
                            Visitanos: &nbsp;&nbsp; <a href="https://www.facebook.com/JYPPERIFERICOSSAC" target="_blank" ><i class="fa fa-facebook-square" aria-hidden="true"></i></a>&nbsp;
                            <a href="https://api.whatsapp.com/send?phone=51946201443&text=Hola!%20Necesito%20Ayuda%20con%20el%20sistema%20de%20Facturación,%20Gracias!%20" target="_blank" ><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                        </div>
                        <div>
                            <strong>Copyright </strong> &nbsp;<a href="http://www.jypsac.com" target="_blank" > JyP Periféricos</a>&nbsp;  &copy; 2019-2022
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
            $(document).ready(function (){
                // Bind normal buttons
                Ladda.bind( '.ladda-button',{ timeout: 8000 });
                $('#btn_popover').click();
            });
            
        </script>
</html>
