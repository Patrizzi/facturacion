@extends('layout')

@section('title', 'Ver Correo')
@section('breadcrumb', 'Ver Correo')
@section('breadcrumb2', 'Ver Correo')

@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')

<a href="#ver" data-toggle="modal"><button type="button" class="btn btn-success">Ver</button></a>

<!--Modal ver correo-->
<div class="modal fade bd-example-modal-lg" id="ver" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="min-width:60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Ver Correo</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">
                        CORREO
                    </div>
                    <div class="panel-body">
                        <div class="">
                            <h3><strong>Asunto: </strong>Oferta de respostería Almitas</h3>
                        </div>
                        <hr>
                        <p class="d-flex justify-content-end">10/03/2023 15:35h</p>
                        <div class="row">
                            <div class="col-1 text-secondary">
                                <strong>De: </strong>
                            </div>
                            <div class="col-11">
                                desarrollo@jypsac.com
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1 text-secondary">
                                <strong>Para: </strong>
                            </div>
                            <div class="col-11">
                                info@jypsac.com
                            </div>
                        </div>
                        <hr>
                        <div class="scroll_content">
                            <p>Nuestros productos se derriten fácilmente,permiten varios calentammientos y no se quiebran. Nuestros chocolates para repostería y pastelería son ideales para tu negocio.Nuestros productos se derriten fácilmente,permiten varios calentammientos y no se quiebran. Nuestros chocolates para repostería y pastelería son ideales para tu negocio.</p>
                            <p>Nuestros productos se derriten fácilmente,permiten varios calentammientos y no se quiebran. Nuestros chocolates para repostería y pastelería son ideales para tu negocio.Nuestros productos se derriten fácilmente,permiten varios calentammientos y no se quiebran. Nuestros chocolates para repostería y pastelería son ideales para tu negocio.</p>
                            <p>Nuestros productos se derriten fácilmente,permiten varios calentammientos y no se quiebran. Nuestros chocolates para repostería y pastelería son ideales para tu negocio.Nuestros productos se derriten fácilmente,permiten varios calentammientos y no se quiebran. Nuestros chocolates para repostería y pastelería son ideales para tu negocio.</p>
                            <p>Nuestros productos se derriten fácilmente,permiten varios calentammientos y no se quiebran. Nuestros chocolates para repostería y pastelería son ideales para tu negocio.Nuestros productos se derriten fácilmente,permiten varios calentammientos y no se quiebran. Nuestros chocolates para repostería y pastelería son ideales para tu negocio.</p>
                            <p>Nuestros productos se derriten fácilmente,permiten varios calentammientos y no se quiebran. Nuestros chocolates para repostería y pastelería son ideales para tu negocio.Nuestros productos se derriten fácilmente,permiten varios calentammientos y no se quiebran. Nuestros chocolates para repostería y pastelería son ideales para tu negocio.</p>
                            <br>
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('img/logos/familia.svg') }}" alt="">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-success mr-2" type="button"><i class="fa fa-upload"></i> Reenviar</button>
                            <button class="btn btn-danger" type="button"><i class="fa fa-trash"></i> Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- iCheck -->
<script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

<!-- SUMMERNOTE -->
<script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>
<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
<!-- Jasny -->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">

<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">


<script>

    $(document).ready(function () {

        // Add slimscroll to element
        $('.scroll_content').slimscroll({
            height: '200px'
        })

    });

</script>


@endsection
