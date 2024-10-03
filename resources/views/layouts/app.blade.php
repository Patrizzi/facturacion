<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Titulo')</title>
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
    ]) !!}
    @stack('css')
    <style>
        .iconos {
            width: 20px;
            border-radius: 0px;
            margin-right: 10px
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <x-side-menu />
        <div id="page-wrapper">
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
