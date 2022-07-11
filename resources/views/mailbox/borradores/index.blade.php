@extends('layout')
@section('title', 'Borradores Email')
@section('breadcrumb', 'Borradores Email')
@section('breadcrumb2', 'Borradores Email')

@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')
{{-- @section('content') --}}

@if (session('error_email'))
<div style="padding-top: 10px">
    <div class="alert alert-danger">
        <a class="alert-link" href="#">
            <li style="color: red">{{ session('error_email') }}</li>
        </a>
    </div>
</div>
@endif

@if($errors->any())
<div style="padding-top: 10px">
      <div class="alert alert-danger">
            <a class="alert-link" href="#">
              @foreach ($errors->all() as $error)
              <li style="color: red">{{ $error }}</li>
              @endforeach
            </a>
      </div>
 </div>
@endif

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="">
					{{-- 2 Columnas --}}
					<div class="row">
						@include('layout_mail')
                        <div class="col-lg-9">
                            <div class="ibox-content" style="padding: 1em 1em">
                                <div class="mail-box-header ">
                                    <h2>
                                        Borradores ({{$count_borradores}})
                                    </h2>
                                    <div class="mail-tools tooltip-demo m-t-md" align="right">
                                        {{-- <div class="btn-group float-left"> --}}
                                            <button class="btn btn-primary " data-toggle="tooltip" data-placement="left" title="Recargar" ><i class="fa fa-refresh"></i> Recargar</button>
                                            <button class="btn btn-danger " id="click_eliminar" data-toggle="tooltip" data-placement="top" title="Mover a la papelera" ><i class="fa fa-trash-o"></i></button>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                                @if($count_borradores > 0)
                                    <div class="mail-box  tabs-container">
                                        <form action="{{route('email.delete')}}" method="post">
                                        @csrf 
                                            <table class="table table-hover table-mail dataTables-example" style="width: 100%;margin-bottom: 0px;font-size: 90%;padding-right: 0px">
                                                <thead style="display: none">
                                                    <tr>
                                                        <td>a</td>
                                                        <td>cb</td>
                                                        <td>c</td>
                                                        <td>d</td>
                                                        <td>r</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($borradores as $borrador)
                                                    <tr class="read" >
                                                        <td class="check-mail" >
                                                            <input type="checkbox" class="select_id" id="{{$borrador->id}}" value="{{$borrador->id}}" name="check_input[]">
                                                        </td>
                                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                                        <td class="mail-contact" style="width: 40%;cursor: pointer;" onclick="location.href='{{route('borradores_email.show', $borrador->id)}}'" >
                                                            {{$borrador->remitente}}
                                                        </td>
                                                        <td class="mail-subject" style="cursor: pointer;" onclick="location.href='{{route('borradores_email.show', $borrador->id)}}'">
                                                            @if(strlen($borrador->asunto) > 34)
                                                                {{substr($borrador->asunto, 0, 35)}}...
                                                            @else
                                                                {{$borrador->asunto}}
                                                            @endif
                                                        </td>
                                                        <td style="cursor: pointer;" onclick="location.href='{{route('borradores_email.show', $borrador->id)}}'">
                                                            @if( count($mailbox_file->where('id_bandeja_envios', $borrador->id )) > 0 )
                                                                <i class="fa fa-paperclip"></i>
                                                            @endif
                                                        </td>
                                                        <td style="width: 10%" class="text-right mail-date" style="cursor: pointer;" onclick="location.href='{{route('borradores_email.show', $borrador->id)}}'">
                                                            <span hidden="hidden">{{$dias =  date('d/m/y',strtotime($borrador->fecha_hora))}}</span>
                                                            <span hidden="hidden">{{$hoy =  date("d/m/y")}}</span>
                                                            <span hidden="hidden">{{$hora =  date('H:i:s', strtotime($borrador->fecha_hora))}}</span>
                                                            @if($hoy > $dias)
                                                                {{ date('d/m/y',strtotime($borrador->fecha_hora))}}
                                                            @else
                                                               {{date('H:i:s', strtotime($borrador->fecha_hora) )}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <button type="submit" style="display: none" id="submit_eliminar"></button>
                                        </form>
                                    </div>
                                    <br>
                                @else
                                    <div class="mail-box  tabs-container">
                                        <div  style="padding-bottom: 1em">
                                            <center>No hay elementos enviados</center>
                                        </div>
                                    </div>
                                @endif
                            </div>
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
<!-- Jasny -->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>

<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
<script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200,
       
    });
  });
</script>
@endsection