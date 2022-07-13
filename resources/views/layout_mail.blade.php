<div class="col-lg-3">
    <div class="mail-box-header" >
        
        <div class="ibox-content mailbox-content">
            <div class="file-manager">
                <button type="button" class="btn btn-block btn-primary compose-mail" data-toggle="modal" data-target="#redactar">
                    Redactar
                </button>
                <div class="space-25"></div>
                <h5>Folders</h5>
                <ul class="folder-list m-b-md" style="padding: 0">
                    <li>
                        <a href="{{route('email.index')}}" id="index_mail">
                            <i class="fa fa-inbox"></i>Enviados
                            <span class="label label-primary float-right">{{$count_mailbox}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('borradores_email.index')}}" id="borradores_mail">
                            <i class="fa fa-envelope-o"></i>Borradores
                            <span class="label label-warning float-right">{{$count_borradores}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('configuracion_email.index')}}" id="configuracion_mail">
                            <i class="fa fa-gear"></i>Configuracion
                            {{-- <span class="label label-primary float-right"></span> --}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('email.trash')}}" id="papelera_mail">
                            <i class="fa fa-trash-o"></i>Papelera
                            <span class="label label-danger float-right">{{$count_eliminados}}</span>
                        </a>
                    </li>
                    {{-- <li><a href="mailbox.html"> <i class="fa fa-inbox "></i> Inbox <span class="label label-warning float-right">16</span> </a></li>
                    <li><a href="mailbox.html"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                    <li><a href="mailbox.html"> <i class="fa fa-certificate"></i> Important</a></li>
                    <li><a href="mailbox.html"> <i class="fa fa-file-text-o"></i> Drafts <span class="label label-danger float-right">2</span></a></li>
                    <li><a href="mailbox.html"> <i class="fa fa-trash-o"></i> Trash</a></li> --}}
                </ul>
                {{-- <h5>Categories</h5>
                <ul class="category-list" style="padding: 0">
                    <li><a href="#"> <i class="fa fa-circle text-navy"></i> Work </a></li>
                    <li><a href="#"> <i class="fa fa-circle text-danger"></i> Documents</a></li>
                    <li><a href="#"> <i class="fa fa-circle text-primary"></i> Social</a></li>
                    <li><a href="#"> <i class="fa fa-circle text-info"></i> Advertising</a></li>
                    <li><a href="#"> <i class="fa fa-circle text-warning"></i> Clients</a></li>
                </ul>

                <h5 class="tag-title">Labels</h5>
                <ul class="tag-list" style="padding: 0">
                    <li><a href=""><i class="fa fa-tag"></i> Family</a></li>
                    <li><a href=""><i class="fa fa-tag"></i> Work</a></li>
                    <li><a href=""><i class="fa fa-tag"></i> Home</a></li>
                    <li><a href=""><i class="fa fa-tag"></i> Children</a></li>
                    <li><a href=""><i class="fa fa-tag"></i> Holidays</a></li>
                    <li><a href=""><i class="fa fa-tag"></i> Music</a></li>
                    <li><a href=""><i class="fa fa-tag"></i> Photography</a></li>
                    <li><a href=""><i class="fa fa-tag"></i> Film</a></li>
                </ul> --}}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@if(isset($config_email->email))
    <!-- Modal Create Redactar  -->
    <div class="modal fade bd-example-modal-lg" id="redactar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <input type="email" required="" class="form-control" name="remitente" list="browsers" autocomplete="off" id="clientes_cc">
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
                                                <input type="text" required="" class="form-control" name="asunto" id="asunto" >
                                            </div>
                                    </div>
                                </div>
                                <div class="mail-text h-200">
                                    <textarea name="mensaje" required="" class="summernote" id="contents" ></textarea>
                                </div>
                                <br/>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-default btn-file" style="left: 20px !important;">
                                        <span class="fileinput-new">Seleccionar</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input  type="file" name="archivos[]" multiple="" id="file_input"/>
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
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar_modal()">Limpiar</button>
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
    <script>
        function limpiar_modal(){
            $('#clientes_cc').val('');
            $('#cc').val('');
            $('#asunto').val('');
            $('.summernote').summernote('code', '');
            $(".fileinput-exists").fileinput("clear");
            
        }
    </script>
@else
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script>
        $( ".compose-mail" ).click(function() {
            location.href = '{{route('configuracion_email.index')}}';
        });
    </script>
@endif
<style>
    .form-control{margin-top: 5px; border-radius: 5px}
</style>