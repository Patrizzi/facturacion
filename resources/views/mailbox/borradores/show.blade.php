@extends('layout')
@section('title', 'Ver Borrador Correo')
@section('breadcrumb', 'Ver Borrador Correo')
@section('breadcrumb2', 'Ver Borrador Correo')

@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')
 
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="">
					{{-- 2 Columnas --}}
					<div class="row">
						@include('layout_mail')
                        <div class="col-lg-9">
                            <div class="mail-box-header">
                                <div class="float-right tooltip-demo">
                                    <a href="mail_compose.html" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Reply"><i class="fa fa-reply"></i> Enviar</a>
                                    <a href="mailbox.html" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash-o"></i> </a>
                                </div>
                                <h2>
                                    Ver Borrador 
                                </h2>
                                <div class="mail-tools tooltip-demo m-t-md">
                                    <h3>
                                        <span class="font-normal">Asunto: </span>{{$mail->asunto}}
                                    </h3>
                                    <h5>
                                        <span class="float-right font-normal">{{$mail->fecha_hora}}</span>
                                        <span class="font-normal">Para: </span>{{$mail->destinatario}}
                                    </h5>
                                </div>
                            </div>
                            <div class="mail-box">
                                <div class="mail-body">
                                    <p>
                                        {!!$mail->mensaje!!}
                                    <p>
                                </div>
                                @if (count($archivos) > 0)
                                    <div class="mail-attachment">
                                        <div class="file-box">
                                            @foreach ($archivos as $archivo)
                                                <div class="file">
                                                    {{-- <a href="{{$archivo->archivo}}" download=""> --}}
                                                        {{-- {{storage_path('app/public/'.$mailbox_files->archivo)}} --}}
                                                        <a href="{{asset('/archivos/'.$mail->fecha_hora.$archivo->archivo)}}" download="{{$archivo->archivo}}">
                                                        <div class="icon">
                                                            <span class="corner"></span>                                                    
                                                            <i class="fa fa-file"></i>
                                                        </div>
                                                        <div class="file-name">
                                                            {{$archivo->archivo}}
                                                            <br/>
                                                            <small>{{$archivo->created_at}}</small>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                @else
                                    {{-- <p>Hola</p> --}}
                                @endif
                                    
                                <div class="mail-body text-right tooltip-demo">
                                    <a href="mail_compose.html" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Reply"><i class="fa fa-reply"></i> Enviar</a>
                                    <a href="mailbox.html" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash-o"></i> </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .file .icon, .file .image{
        overflow: visible;
    }
    .icon:hover{
        box-shadow: none;   
    }
</style>
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
<!-- Jasny -->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>

<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
<script>
    function doAction(ele, param1, param2) {
      var a = document.getElementById(param1).innerHTML;
      var b = document.getElementById(param2).innerHTML;
      ele.innerHTML = a + " " + b;
  }</script>
  <script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200,
       
    });

  });
</script>

@endsection