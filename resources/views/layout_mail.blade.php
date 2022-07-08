<div class="col-lg-3">
    <div class="mail-box-header" >
        
        <div class="ibox-content mailbox-content">
            <div class="file-manager">
                {{-- <a class=" href="mail_compose.html">Redactar</a> --}}
                <button type="button" class="btn btn-block btn-primary compose-mail" data-toggle="modal" data-target="#redactar">
                    Redactar
                  </button>
                <div class="space-25"></div>
                <h5>Folders</h5>
                <ul class="folder-list m-b-md" style="padding: 0">
                    <li>
                        <a href="{{route('email.index')}}">
                            <i class="fa fa-inbox"></i>Enviados
                            <span class="label label-primary float-right">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('email.index')}}">
                            <i class="fa fa-envelope-o"></i>Borrador
                            <span class="label label-primary float-right">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('configuracion_email.index')}}">
                            <i class="fa fa-gear"></i>Configuracion
                            <span class="label label-primary float-right">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('email.trash')}}">
                            <i class="fa fa-trash-o"></i>Papelera
                            <span class="label label-danger float-right">2</span>
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
<!-- Modal Create Redactar  -->
<div class="modal fade" id="redactar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 700px;margin-left: 400px;">
        <div class="modal-content" style="width: 702px;">
            <div class="modal-header" style="width: 700px;padding-left: 0px;padding-right: 0px;">
                <div class="col-lg-10 container animated fadeInRight" style="width: 600px;padding-left: 0px;padding-right: 0px;margin-right: 30px;margin-left: 60px;">
                    <div class="mail-box">
                        {{-- @foreach($config_email as $config_emails) --}}
                        <form action ="{{route('email.store')}}" method="POST" enctype="multipart/form-data" onsubmit="return valida(this)">
                            @csrf
                            <div class="mail-body">
                                <div class=" row">
                                    {{-- <label class="col-sm-2 col-form-label">Para:</label>
                                    <div class="col-sm-10">
                                        <input type="email" required="" class="form-control" name="remitente" list="browsers" autocomplete="off" >
                                        <datalist id="browsers">
                                            @foreach($clientes as $cliente )
                                                <option value="{{$cliente->email}}"></option>
                                            @endforeach
                                        </datalist>
                                    </div> --}}
                                    {{-- <div class="col-sm-12"> --}}
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
                                            <input type="text" class="form-control" name="cc_email" id="">
                                        </div>
                                        <div class="col-sm-6">
                                            <span>BCC:</span>
                                            <input type="text" class="form-control" value="{{$config_email->email_backup}}" disabled id="">
                                        </div>
                                    @else
                                        <div class="col-sm-12">
                                            <span>CC:</span>
                                            <input type="text" class="form-control" name="cc_email" id="">
                                        </div>
                                    @endif
                                        <div class="col-sm-12">
                                            <span>Asunto:</span>
                                            <input type="text" required="" class="form-control" name="asunto" >
                                        </div>
                                </div>
                                {{-- <div class="form-group row"><label class="col-sm-2 col-form-label">Asunto:</label>
                                    
                                </div> --}}
                            </div>
                            <div class="mail-text h-200">
                                <textarea name="mensaje" required="" class="summernote" id="contents" ></textarea>
                            </div>
                            <br/>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-default btn-file" style="left: 20px !important;">
                                    <span class="fileinput-new">Seleccionar</span>
                                    <span class="fileinput-exists">Cambiar</span>
                                    <input  type="file" name="archivos[]" multiple="" />
                                    <input type="file" name="archivo">
                                </span>
                                <span class="fileinput-filename" style="padding-left: 30px"></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                            </div>
                            <div class="mail-body text-right tooltip-demo">
                                <button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top"   onclick="doAction(this, 'i', 'Loading')" id="boton">
                                    <i class="fa fa-reply"></i> Enviar
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <span id="i" hidden="" ><i  class="fa fa-spinner fa-pulse fa-2x fa-fw"  ></i></span>
                                <span id="Loading" hidden=""><span style="width: 20px" class="sr-only">Loading...</span></span>
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
    .form-control{margin-top: 5px; border-radius: 5px}
</style>