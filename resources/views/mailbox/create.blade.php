{{-- Para el envio de facturas, boletas, etc --}}
@extends('layout')

@section('title','Enviar - '.$archivo )
@section('breadcrumb', 'Ver Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index'))
@section('value_accion', 'Atras')

@section('content')
<br/>
<div class="col-lg-10 container animated fadeInRight" >
    <div class="mail-box">
        <form action ="{{route('email.send')}}" method="POST" enctype="multipart/form-data" onsubmit="return valida(this)" >
            <input type="text" hidden  name="dates" value="{{$date}}" id="">
            <input type="text" hidden  name="id" value="{{$id}}" id="">
            <input type="text" hidden  name="retorno" value="{{$ruta_retorno}}" id="">
            @csrf
            <div class="mail-body">
                <center><h2>Enviar Correos</h2></center>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <span>De:</span>
                        <input type="text" class="form-control" value="{{$config_email->email}}" disabled id="">
                    </div>
                    <div class="col-sm-6">
                        <span>Para:</span>
                        <input type="email" required="" class="form-control" name="remitente" value="{{$clientes}}" autocomplete="off" id="clientes_cc">
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
                        <input type="text" required="" class="form-control" name="asunto" id="asunto" >
                    </div>
                </div>
            </div>
            <div class="mail-text h-200">
                <textarea name="mensaje" required="" class="summernote" id="contents" >
                </textarea>
            </div>
            <br/>
            <div class="form-group row container">
                <div class="col-sm-3">
                    <div class="file" >
                        <a href="{{asset('/archivos/'.$date.$archivo)}}" download="{{$archivo}}" >
                        <div class="file-name" style="background-color: white">
                            <center>
                                <i class="fa fa-file" style="font-size:  60px"></i>
                            </center>
                        </div>
                        <div class="file-name">
                            <input type="text" name="redict" hidden="hidden" value="{{$redic}}">
                            <input type="text" name="pdf" hidden="" value="{{$archivo}}">
                            {{$archivo}}
                            <br/>
                            <small>{{ date('Y-m-d H:i:s') }} </small>
                        </div>
                        </a>
                    </div>
                </div>
                @if(isset($xml_file))  {{-- XML --}}
                    <div class="col-sm-3" id="file_r_xml1">
                        <div class="file"  >
                            <button type="button" class="close" id="eliminar_archivo_reenvio" onclick="archivo_reenvio_close('xml1')">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <a href="{{ asset('facturas_electronicas/')}}/{{$xml_file}}" download >
                                <div class="file-name" style="background-color: white">
                                    <center>
                                        <i class="fa fa-file" style="font-size:  60px"></i>
                                    </center>
                                </div>
                                <div class="file-name">
                                    {{$xml_file}}
                                    <input type="hidden" id="nombre_xml1" value="{{$xml_file}}" name="archivo_nombre">
                                    <br>
                                    <small>{{ date('Y-m-d H:i:s') }} </small>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn btn-default btn-file" style="left: 20px !important;">
                            <span class="fileinput-new">Seleccionar</span>
                            <span class="fileinput-exists">Cambiar</span>
                            <input  type="file" name="archivos[]" multiple="" />
                        </span>
                        <span class="fileinput-filename" style="padding-left: 30px"></span>
                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                    </div>
                </div>
            </div>
            <div class="mail-body text-right tooltip-demo">
                <button type="submit" class="btn  btn-primary ladda-button" name="boton_send" value="boton_send">
                    <i class="fa fa-reply"></i> Enviar
                </button>
                <button type="submit" class="btn btn-secondary ladda-button" id="cancelar" name="boton_cancelar" value="boton_cancelar"  formnovalidate >Cancelar</button>
            </div>
        </form>
    </div>
</div>
<br/>
<style>
    .file{
        margin: 0%;
    }
    .close{
        margin: 6px;
        z-index: 9999;
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
<script type="text/javascript">
    $(function() {
        $('.summernote').summernote({
            height: 200,
        });
    });
    function archivo_reenvio_close(value){
        document.getElementById('file_r_'+value+'').style.display = 'none';
        document.getElementById('nombre_'+value+'').value = '';
        // document.getElementById('nombre_'+value+'').value = '';
        console.log(value);
    }
    Ladda.bind('button[type=submit]', {timeout: 20000});
</script>
<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">

<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
@endsection