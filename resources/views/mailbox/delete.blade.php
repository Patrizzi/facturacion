@extends('layout')
@section('title', 'Papelera Email')
@section('breadcrumb', 'Papelera')
@section('breadcrumb2', 'Papelera')

@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')
@section('content')
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
                            <div class="ibox-content" style="padding: 1em 1em">
                                <div class="mail-box-header ">
                                    <h2>
                                        Papelera ({{$count_eliminados}})
                                    </h2>
                                    <div class="row">
                                        <div class="col-sm-6 mail-tools tooltip-demo m-t-md" align="left" style="align-self: self-end">
                                            <input type="checkbox" class="check_all" data-toggle="tooltip" data-placement="top" title="Seleccionar todo"  onclick="select_all_mail()">
                                        </div>
                                        <div class="col-sm-6 mail-tools  tooltip-demo m-t-md" align="right" style="margin-top: 0px">
                                            <button class="btn btn-primary " onclick=" location.reload();"><i class="fa fa-refresh"></i> Recargar</button>
                                            <button class="btn btn-danger " id="click_eliminar" data-toggle="tooltip" data-placement="top" title="Mover a la papelera" ><i class="fa fa-trash-o"></i></button>
                                        </div>
                                    </div>
                                </div>
                                @if($count_eliminados > 0)
                                    <div class="mail-box  tabs-container">
                                        <form action="{{route('email.destroy')}}" method="post">
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
                                                    @foreach($eliminados as $mailboxs)
                                                    <tr class="read">
                                                        <td class="check-mail " >
                                                            <input type="checkbox" class="select_id" id="{{$mailboxs->id}}" value="{{$mailboxs->id}}" name="check_input[]">
                                                        </td>
                                                        <td class="mail-contact" style="width: 40%;cursor: pointer;" onclick="location.href='{{route('email.show', $mailboxs->id)}}'">
                                                            @if(substr($mailboxs->remitente, -1) == ']')
                                                                {{json_decode($mailboxs->remitente)[0]}}...
                                                            @else
                                                                {{$mailboxs->remitente}}
                                                            @endif
                                                        </td>
                                                        <td class="mail-subject" style="cursor: pointer;" onclick="location.href='{{route('email.show', $mailboxs->id)}}'">
                                                            {{substr($mailboxs->asunto, 0, 25)}}...
                                                        </td>
                                                        @if( count($mailbox_file->where('id_bandeja_envios', $mailboxs->id )) > 0 )
                                                            <td class=""><i class="fa fa-paperclip"></i></td>
                                                        @else
                                                            <td class=""></td>
                                                        @endif
                                                        <td style="width: 10%" class="text-right mail-date" style="cursor: pointer;" onclick="location.href='{{route('email.show', $mailboxs->id)}}'">
                                                            <span hidden="hidden">{{$dias =  date('d/m/y',strtotime($mailboxs->fecha_hora))}}</span>
                                                            <span hidden="hidden">{{$hoy =  date("d/m/y")}}</span>
                                                            <span hidden="hidden">{{$hora =  date('H:i:s', strtotime($mailboxs->fecha_hora))}}</span>
                                                            @if($hoy > $dias)
                                                                {{ date('d/m/y',strtotime($mailboxs->fecha_hora))}}
                                                            @else
                                                               {{date('H:i:s', strtotime($mailboxs->fecha_hora) )}}
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
                                    {{-- TABS PARA QUE SE ABRAN LOS MAILS --}}
                                    <div class="tab-content">
                                        @foreach($mailbox as $row)
                                        <div id="tab-{{$row->id}}" class="tab-pane">
                                            <div class="panel-body">
                                                {{$row->id}}
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <br>
                                @else
                                    <div class="mail-box tabs-container">
                                        <div class="table-mail">
                                            <h3><center>No hay elementos eliminados</center></h3>
                                            <br>
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
{{-- 
<div class="fh-breadcrumb">
    @if($count == 0)
    <div class="fh-column">        
    </div>
     <div class="full-height">
        <div class="full-height-scroll white-bg border-left">
        <h2 style="align-content: center;"><center>No hay elementos en la Papelera</center></h2>
        </div>
     </div>
    @else
    <div class="fh-column">
        <div class="full-height-scroll">
            <ul class="list-group elements-list">
                  @foreach($mailbox as $row)
                <li class="list-group-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-{{$row->id}}" style="padding-top: 5px;padding-bottom: 5px;">
                        <span hidden="hidden">{{$mensaje_limitado=$row->mensaje_sin_html}}
                        {{$cate = substr($mensaje_limitado, 0, 10)}}</span>
                        <strong style="font-size: 10px">{{$row->remitente}}</strong>
                        <div class="small m-t-xs">
                            <p class="m-b-xs">
                              {{$cate}}...
                            </p>
                            <p class="m-b-none">
                                <i class="fa fa-map-marker"></i> Lima,Perú <span class="float-right text-muted">{{$row->fecha_hora}}</span>
                            </p>
                        </div>
                    </a>
                </li>
                @endforeach     
            </ul>
        </div>
    </div> --}}
        
            
    {{-- <div class="full-height">
        <div class="full-height-scroll white-bg border-left">
            <div class="element-detail-box">
                <div class="tab-content">
                    @foreach($mailbox as $row)
                    <div id="tab-{{$row->id}}" class="tab-pane">
                        <div class="float-right">
                            <div class="tooltip-demo"> --}}
                            {{-- <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="left" title="Plug this message"><i class="fa fa-plug"></i> Plug it</button>
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="Mark as read"><i class="fa fa-eye"></i> </button>
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mark as important"><i class="fa fa-exclamation"></i> </button> --}}
                            {{-- <form action="{{route('email.destroy')}}" method="post">    
                                @csrf
                                <input type="hidden" name="id" value="{{$row->id}}" /> 
                                <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Move to trash"><i class="fa fa-trash-o"></i> </button>
                            </form>
                            </div>
                        </div>
                        <div class="small text-muted">
                            <i class="fa fa-clock-o"></i> {{$row->fecha_hora}}
                        </div>
                        <span hidden="hidden">{{$remitente_limi=$row->remitente}}
                        {{$remi = substr($remitente_limi, 0, 1)}}</span>
                        <h1><div class="row">
                            <div class="col-sm-1" style=" padding-right: 0px;">
                            <div  class="rounded-circle" style="background: #8D8D8D; width: 50px; height: 50px ;color: white" align="center">{{$str = strtoupper($remi)}}</div>
                            </div>
                            <div class="col-sm-3" style="padding-left: 0px">
                               {{$row->asunto}}
                           </div>

                        </div></h1> --}}
                   {{-- <img alt="image" class="rounded-circle" src=" {{ asset('/profile/images/')}}/@yield('foto', auth()->user()->personal->foto)" style="width: 50px" /> --}}
                   {{-- <h5>to: {{$row->remitente}}</h5>
                   <hr> --}}
                   {{-- {!!$row->mensaje!!}
                   <p class="small"> --}}
                    {{-- Firma --}}
                    {{-- <strong>Best regards, Anthony Smith </strong> --}}
                    {{-- </p>
                    <div class="m-t-lg">
                            <span><i class="fa fa-paperclip"></i> Archivos </span> --}}
                                {{-- <a href="#">Download all</a>
                                |
                                <a href="#">View all images</a> --}}
                            {{-- <div class="attachment">
                                @foreach($mailbox_file as $mailbox_files)
                                @if($mailbox_files->id_bandeja_envios ==  $row->id)
                                @if( isset($mailbox_files->archivo) )
                                <div class="file-box">
                                    <div class="file">
                                        <a href="" download="{{$mailbox_files->archivo}}">
                                            <span class="corner"></span>
                                            <div class="icon">
                                                <i class="fa fa-file-pdf-o"></i>
                                            </div>
                                            <div class="file-name">
                                                {{$mailbox_files->archivo}}
                                                <br>
                                                <small>Añadido: {{$mailbox_files->fecha_hora}}</small>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                                @endif
                                @endif
                                @endforeach

                                @foreach($mailbox_file as $mailbox_files)
                                    @if($mailbox_files->id_bandeja_envios ==  $row->id)
                                        @if( isset($mailbox_files->imagen) )
                                        <div class="file-box">
                                            <div class="file">
                                                <a href="#">
                                                    <span class="corner"></span>

                                                    <div class="icon">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </div>
                                                    <div class="file-name">
                                                       {{$mailbox_files->imagen}}
                                                        <br>
                                                            <small>Añadido: {{$mailbox_files->fecha_hora}}</small>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                        @endif
                                    @endif
                                @endforeach
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div> --}}
<!-- Mainly scripts -->

<style>
    .dataTables_wrapper.container-fluid.dt-bootstrap4.no-footer{
        padding: 0px;
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
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 15,
            order: [[0, "desc"]],
            responsive: true,
            // dom: '<"html5buttons"B>lTfgitp',
            buttons: [],
            bFilter: false,
            bInfo: false,
            bLengthChange : false,
            aoColumnDefs : [ { 'bSortable' : false} ]
        });
        
    });
</script>
<script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200,
       
    });

  });
</script>
<script>
    function select_all_mail() {
        $('input[class=select_id]:checkbox').each(function () {
            // console.log($('input[class=check_all]:checkbox:checked'));
            if ($('input[class=check_all]:checkbox:checked').length == 0) {
                // console.log("a");
                $(this).prop("checked", false);
            } else {
                // console.log("b");
                $(this).prop("checked", true);
            }
        });
    }
    $('#click_eliminar').on('click', function(){
        // var check = ;
        // return check;
        if($('.select_id').is(':checked')){
            $('#submit_eliminar').click();
        }
    });
</script>
<script>
    document.getElementById('papelera_mail').style.fontWeight = '800';
</script>
@endsection
