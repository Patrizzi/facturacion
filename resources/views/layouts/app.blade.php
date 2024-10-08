<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Titulo')</title>
    @php
        $config = auth()->user()->config;
    @endphp

    <style>
        :root {
            --config-color-nombre: {{ $config->color_nombre }};
            --config-color-sombra-nombre: {{ $config->color_sombra_nombre }};
            --config-fondo-perfil: url("{{ asset('/css/patterns/') . '/' . $config->fondo_perfil }}");
            --config-color-border-foto: {{ $config->color_borde_foto }};
            --config-border-foto: {{ $config->borde_foto }};
        }

        body {
            font-family: {{ $config->letra !== 'none' ? $config->letra : 'inherit' }};
            font-size: {{ !empty($config->tamano_letra) ? $config->tamano_letra : 'inherit' }};
        }

        .form-control,
        table,
        span {
            font-family: {{ $config->letra !== 'none' ? $config->letra : 'inherit' }};
            font-size: {{ !empty($config->tamano_letra) ? $config->tamano_letra : 'inherit' }};
        }

        span.select2-selection__placeholder {
            font-size: {{ !$config->tamano_letra || $config->tamano_letra == 'smaller' ? 'small' : $config->tamano_letra }};
        }
        li.nav-header > div.dropdown.profile-element > a > span:nth-child(3) {
            font-size: {{ $config->tamano_letra_perfil ?? "12px" }}
        }
    </style>

    {!! push_asset_once([
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
        asset('css/plugins/toastr/toastr.min.css'),
        asset('css/layout/app.css'),
        asset('css/plugins/ladda/ladda-themeless.min.css'),
        asset('main.css'),
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
        asset('js/plugins/ladda/ladda.min.js'),
        asset('js/plugins/ladda/ladda.jquery.min.js'),
        asset('js/plugins/pace/pace.min.js'),
        asset('js/plugins/ladda/spin.min.js'),
        asset('js/plugins/toastr/toastr.min.js'),
    ]) !!}
    @stack('js')
</body>

</html>
