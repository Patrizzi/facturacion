@extends('layout')
@section('title', 'Email')
@section('breadcrumb', 'Email')
@section('breadcrumb2', 'Email')

@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">
                    <h2><strong> Correo</strong></h2>
                    </div>
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <ul class="nav nav-tabs" role="tablist">
                                @include('mailbox\nuevo\tabs')
                                </ul>
                                <a href="#crear" data-toggle="modal">
                                    <button class="btn btn-success mr-2" style="background-color: blue; border-color:blue;">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </a>
                            </div>

                            <div class="tab-content">
                                <!-- Contenido de Tab 1 -->
                                <div role="tabpanel" id="tab-1" class="tab-pane ">
                                </div>

                                <!-- Contenido de Tab 2 -->
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                </div>

                                <!-- Contenido de Tab 3 -->
                                <div role="tabpanel" id="tab-3" class="tab-pane active show">
                                    <div class="panel-body">
                                        <form action="">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group  row">
                                                        <label class="col-sm-5 col-form-label">Periodo de cancelación de envío:</label>
                                                        <div class="col-sm-7">
                                                            <select class="form-control m-b" name="account">
                                                                <option>6 segundos</option>
                                                                <option>10 segundos</option>
                                                                <option>3 segundos</option>
                                                                <option>8 segundos</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row d-flex justify-content-center align-content-center text-center">
                                                        <div class="border border-dark p-3">
                                                            <img src="{{ asset('img/logos/categoria.svg')}}" width="150px" alt="">
                                                        </div>
                                                        <div class="custom-file m-1">
                                                            <a href="" id="logo" class="">Firma Virtual (150 - 300px)</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <!--Email-->
                                                    <div class="form-group  row">
                                                        <label class="col-sm-2 col-form-label">Email:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" placeholder="desarrollo@jypsac.com" disabled>
                                                        </div>
                                                    </div>
                                                    <!--Contraseña-->
                                                    <div class="form-group  row">
                                                        <label class="col-sm-2 col-form-label">Contraseña:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <!--SMTP-->
                                                    <div class="form-group  row">
                                                        <label class="col-sm-2 col-form-label">SMTP:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" placeholder="mail.jypsac.com">
                                                        </div>
                                                    </div>
                                                    <!--Port-->
                                                    <div class="form-group  row">
                                                        <label class="col-sm-2 col-form-label">Port:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" placeholder="25">
                                                        </div>
                                                    </div>
                                                    <!--Cifrado-->
                                                    <div class="form-group  row">
                                                        <label class="col-sm-2 col-form-label">Cifrado:</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control m-b" name="account">
                                                                <option>SSL</option>
                                                                <option>2 </option>
                                                                <option>3 </option>
                                                                <option>4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload"></i> Guardar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Contenido de Tab 4 -->
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fin -->
@include('mailbox\nuevo\crear')

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- check -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>

<!-- SUMMERNOTE -->
<script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>
<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
<!-- Jasny -->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">

<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">

<!-- Switchery -->
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

    });
</script>

<script>
    $(document).ready(function(){
        $('.summernote').summernote();
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
   });

   $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>

<style>
    #DataTables_Table_0_length{
        display:none;
    }
    #DataTables_Table_0_filter{
        display: none;
    }
    div.dt-buttons{
        display: none;
    }
</style>

<script>
    $(document).ready(function () {
        $('#tab-3').addClass('active show');

    });
</script>

<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
    });
</script>


@endsection
