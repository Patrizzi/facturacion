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

    <!-- <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <ul class="navbar-nav ml-auto">

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                {{-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li> --}}
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> -->

        <main class="py-4">
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
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
</body>

</html>
