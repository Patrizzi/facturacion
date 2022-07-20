@extends('layout')

@section('title', 'Ver Correo')
@section('breadcrumb', 'Ver Correo')
@section('breadcrumb2', 'Ver Correo')

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
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#reenviar"><i class="fa fa-reply"></i> Reenviar</button>
                                    @if($mail->estado == 0)
                                        <form action="{{route('email.delete')}}" method="post" style="display: inline-flex">
                                            @csrf
                                            <input type="hidden" name="check_input[]" value="{{$mail->id}}">
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    @else
                                        <form action="{{route('email.destroy')}}" method="post" style="display: inline-flex">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$mail->id}}">
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar permanentemente"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    @endif
                                </div>
                                <h2>
                                    Ver Correo
                                </h2>
                                <div class="mail-tools tooltip-demo m-t-md">
                                    <h3>
                                        <span class="font-normal">Asunto: </span>{{$mail->asunto}}
                                    </h3>
                                    <h5>
                                        <span class="float-right font-normal">{{$mail->fecha_hora}}</span>
                                        <span>
                                            <span class="font-normal">De: </span>
                                            {{$mail->destinatario}}
                                        </span>
                                        <br>
                                        </span>
                                            <span class="font-normal">Para: </span>
                                            @if(substr($mail->remitente, -1) == ']')
                                                @foreach (json_decode($mail->remitente) as $key => $value)
                                                    {{ $value }},    
                                                @endforeach
                                            @else
                                                {{$mail->remitente}}
                                            @endif
                                        </span>
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
                                    <div class="mail-attachment" style="display: flow-root"> 
                                        <div class="file-box">
                                            @foreach ($archivos as $archivo)
                                                <div class="file archivo_flex ">
                                                    @if(substr($archivo->archivo, -3) == 'xml')
                                                        <a href="{{asset('/facturas_electronicas/'.$archivo->archivo)}}" download="{{$archivo->archivo}}">
                                                    @else   
                                                        <a href="{{asset('/archivos/'.$archivo->fecha_hora.$archivo->archivo)}}" download="{{$archivo->archivo}}">
                                                    @endif
                                                    <div class="icon">
                                                        <span class="corner"></span>
                                                        <i class="fa fa-file"></i>
                                                    </div>
                                                    <div class="file-name" style="overflow-wrap: break-word;">
                                                        {{$archivo->archivo}}
                                                        <br/>
                                                        <small>{{$archivo->created_at}}</small>
                                                    </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                        {{-- <div class="clearfix"></div> --}}
                                    </div>
                                @endif
                                    
                                <div class="mail-body text-right tooltip-demo">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#reenviar"><i class="fa fa-reply"></i> Reenviar</button>
                                    <form action="{{route('email.delete')}}" method="post" style="display: inline-flex">
                                        @csrf
                                        <input type="hidden" name="check_input[]" value="{{$mail->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash-o"></i></button>
                                    </form>
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
<!-- Modal Create Redactar  -->
<div class="modal fade bd-example-modal-lg" id="reenviar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-lg-12 container animated fadeInRight" >
                    <div class="mail-box">
                        {{-- @foreach($config_email as $config_emails) --}}
                        <form action ="{{route('email.store')}}" method="POST" enctype="multipart/form-data" onsubmit="return valida(this)">
                            @csrf
                            <div class="mail-body">
                                <div class=" row">
                                    <div class="col-sm-6">
                                        <span>De:</span>
                                        <input type="text" class="form-control" value="{{$config_email->email}}" disabled id="">
                                    </div>
                                    <div class="col-sm-6">
                                        <span>Para:</span>
                                        <input type="email" required="" class="form-control" name="remitente" list="browsers" autocomplete="off" >
                                        <datalist id="browsers">
                                            @foreach($clientes as $cliente )
                                                <option value="{{$cliente->email}}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    @if(isset($config_email->email_backup))
                                        <div class="col-sm-6">
                                            <span>CC:</span>
                                            <input type="email" class="form-control" name="cc_email" id="cc">
                                        </div>
                                        <div class="col-sm-6">
                                            <span>BCC:</span>
                                            <input type="text" class="form-control" value="{{$config_email->email_backup}}" disabled id="email_backup">
                                        </div>
                                    @else
                                        <div class="col-sm-12">
                                            <span>CC:</span>
                                            <input type="text" class="form-control" name="cc_email" id="cc">
                                        </div>
                                    @endif
                                        <div class="col-sm-12">
                                            <span>Asunto:</span>
                                            <input type="text" required="" class="form-control" name="asunto" value="{{$mail->asunto}}" >
                                        </div>
                                </div>
                            </div>
                            <div class="mail-text h-200">
                                {{-- Mensaje --}}
                                <textarea name="mensaje" required="" class="summernote" id="contents" >
                                    <span><br></span>
                                    <strong>---------- Mensaje reenviado ---------</strong><br>
                                    De: {{$mail->destinatario}}<br>
                                    Date: {{$mail->fecha_hora}}<br>
                                    Asunto: {{$mail->asunto}}<br><br>
                                    Para: {{$mail->remitente}} <br>
                                    {{$mail->mensaje}}
                                </textarea>
                            </div>
                            <br/>
                            @if(count($archivos) > 0 )
                                <div style="display: flow-root">
                                    <div class="file-box reenvio-box" style="display: flex">
                                        @foreach ($archivos as $archivo)
                                            <div class="file archivo_flex reenvio-flex reenvio_file" id="file_r_{{$archivo->id}}">
                                                <div class="file-name" style="">
                                                <button type="button" class="close" id="eliminar_archivo_reenvio" onclick="archivo_reenvio_close({{$archivo->id}})">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                    {{$archivo->archivo}}
                                                    <input type="hidden" id="archivo_{{$archivo->id}}" value="{{$archivo->fecha_hora}}{{$archivo->archivo}}" name="archivo_reenvio[]">
                                                    <input type="hidden" id="nombre_{{$archivo->id}}" value="{{$archivo->archivo}}" name="archivo_nombre[]">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <br>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-default btn-file" style="left: 20px !important;">
                                    <span class="fileinput-new">Seleccionar</span>
                                    <span class="fileinput-exists">Cambiar</span>
                                    <input  type="file" name="archivos[]" multiple="" value="[]" />
                                </span>
                                <span class="fileinput-filename" style="padding-left: 30px"></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                            </div>
                            <hr style="margin-bottom: 0px">
                            <div class="row" style="padding: 1em">
                                <div class="col-sm-6" align="left">
                                    <button type="submit" class="btn  btn-warning ladda-button" name="boton_draft" value="boton_draft">
                                        <i class="fa fa-pencil"></i> Borrador
                                    </button>
                                </div>
                                <div class="col-sm-6" align="right"> 
                                    <button type="submit" class="btn  btn-primary ladda-button" name="boton_send" value="boton_send">
                                        <i class="fa fa-reply"></i> Enviar
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" > Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    {{-- @endforeach --}}
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
    .mail-body{
        display: flow-root;
    }
    .file-box{
        display: flex;
        flex-flow: row wrap;
        width: auto;
    }
    .archivo_flex{
        flex: 0 0 calc(  (100% - 5em ) / 4);   
        margin: 0.5em;
    }
    .close{
        padding: 0;
        margin: 0;
        background-color: rgb(248 248 248);
    }
    .reenvio_file{
        background-color: rgb(248 248 248);
        width: 90%;
        overflow-wrap: break-word;
    }
    .file-box.reenvio-box{
        display: flex;
        flex-flow: row wrap;
        width: auto;
    }
    .archivo_flex.reenvio-flex{
        flex: 0 0 calc(  (100% - 3em ) / 3);   
        margin: 0.5em;
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
<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
<!-- Jasny -->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">

<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
<script type="text/javascript">
    $(function() {
        $('.summernote').summernote({
            height: 200,
        });
    });
    function archivo_reenvio_close(value){
        document.getElementById('file_r_'+value+'').style.display = 'none';
        document.getElementById('archivo_'+value+'').value = '';
        document.getElementById('nombre_'+value+'').value = '';
        console.log(value);
    }
    Ladda.bind('button[type=submit]', {timeout: 20000});
</script>
@if($mail->estado == 0)
    <script>
        document.getElementById('index_mail').style.fontWeight = '800';
    </script>
@else
    <script>
        document.getElementById('papelera_mail').style.fontWeight = '800';
    </script>
@endif

@endsection