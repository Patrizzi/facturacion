<div class="col-lg-3">
    <div class="mail-box-header" >
        
        <div class="ibox-content mailbox-content">
            <div class="file-manager">
                <a class="btn btn-block btn-primary compose-mail" href="mail_compose.html">Redactar</a>
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