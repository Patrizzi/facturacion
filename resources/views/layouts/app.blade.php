<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Titulo')</title>
    <style type="text/css">

        :root {
            --font-family: {{ auth()->user()->config->letra != 'none' ?? 'inherit' }};
            --font-size: {{ auth()->user()->config->tamano_letra != '' ? auth()->user()->config->tamano_letra : 'inherit' }};
            --font-size-span-select2: @if (empty(auth()->user()->config->tamano_letra) || auth()->user()->config->tamano_letra == 'smaller' ) font-size: small @else font-size: @yield('tamano_letra', auth()->user()->config->tamano_letra) @endif;
            --nombre-color: {{ auth()->user()->config->color_nombre }};
            --tamano-letra-perfil: {{ auth()->user()->config->tamano_letra_perfil }};
            --color-sombra-nombre: {{ auth()->user()->config->color_sombra_nombre }};
            --fondo-perfil: url("{{ asset('/css/patterns/') }}/{{ auth()->user()->config->fondo_perfil }}");
            --borde-foto: {{ auth()->user()->config->borde_foto }};
            --color-borde-foto: {{ auth()->user()->config->color_borde_foto }};
        }
    </style>
    {!! push_asset_once([
        asset('css/plugins/ladda/ladda-themeless.min.css'),
        asset('css/bootstrap.min.css'),
        asset('font-awesome/css/font-awesome.css'),
        asset('css/animate.css'),
        asset('css/style.css'),
        asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'),
        asset('css/plugins/iCheck/custom.css'),
        asset('css/plugins/steps/jquery.steps.css'),
        asset('css/plugins/footable/footable.core.css'),
        asset('css/plugins/switchery/switchery.css'),
        asset('css/plugins/select2/select2.min.css'),
        asset('css/plugins/daterangepicker/daterangepicker-bs3.css'),
        asset('main.css'),
        asset('css/plugins/toastr/toastr.min.css'),
        asset('css/layout/app.css'),
    ]) !!}
    @stack('css')
    
</head>

<body>
    <div id="wrapper">
        <x-side-menu />
        <div id="page-wrapper" class="gray-bg">
            <x-nav-bar />
            @yield('content')
            <x-footer />
        </div>
    </div>
    {!! push_asset_once([
        asset('js/jquery-3.1.1.min.js'),
        asset('js/popper.min.js'),
        asset('js/bootstrap.js'),
        asset('js/plugins/metisMenu/jquery.metisMenu.js'),
        asset('js/plugins/slimscroll/jquery.slimscroll.min.js'),
        asset('js/inspinia.js'),
        asset('js/plugins/pace/pace.min.js'),
        asset('js/plugins/ladda/spin.min.js'),
        asset('js/plugins/ladda/ladda.min.js'),
        asset('js/plugins/ladda/ladda.jquery.min.js'),
        asset('js/plugins/toastr/toastr.min.js'),
    ]) !!}
    @stack('js')
</body>

</html>
