@extends('layout')

@section('title', 'Guia Remision')
@section('breadcrumb', 'Guia Remision')
@section('breadcrumb2', 'Guia Remision')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')

@section('content')
<style>
    /* Ajustes para el popover de la nota informativa */
    .popover {
        max-width: 400px;
    }
    .popover-body {
        font-weight: normal !important;
        white-space: pre-wrap;
        word-wrap: break-word;
        color: #333;
    }
    .info-icon {
        background-color: transparent;
        border: none;
        padding: 0;
        transition: none;
        color: inherit;
    }
</style>
<!-- modal -->
@if($valor_error == 1)
<div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
    <a class="alert-link" href="{{route('vehiculo.index')}}">
        <li class="error" style="color: red">{!!$message!!}</li>
    </a>
</div>
@endif
@if(count($personal_conductor) == 0 )
<div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
    <a class="alert-link" href="{{route('personal.index')}}">
        <li class="error" style="color: red">No hay Personal con licencia alguna para el Transporte Privado</li>
    </a>
</div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div id="modal-form" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row" align="center">
                            <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Crear Guía Remisión</h3>
                            </div>
                            <!-- <div class="col-sm-12"> -->
                               <!--  <a href="{{route('guia_remision.seleccionar') }}"><button class="btn btn-sm btn-info" type="submit"><strong>Ver Aprobadas</strong></button></a> -->
                            <!-- </div> -->
                            <div class="col-sm-12">
                                @if($conteo_almacen==1 and $user_login->name=='Administrador' )
                                <form action="{{ route('guia_remision.create')}}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <input type="text" value="{{$almacen_primero->id}}" hidden="hidden" name="almacen">
                                    <input class="btn btn-sm btn-info"  type="submit" value="Crear una nueva Guia" >
                                </form>
                                @elseif($conteo_almacen==1 and $user_login->almacen->estado==1 and $user_login->name=='Colaborador' )
                                <input id="auto" onclick="divAuto()" type="submit" class="btn btn-sm btn-info"  value="Crear una Nueva Guia">
                                <div id="div-mostrar" style="color: black">
                                    <div id="texto" style="opacity:0;transition: .4s ;text-align: center;padding-top: 10px;" >Almacén asignado está desactivado, actívelo o cambie de almacén.</div>
                                </div>
                                @elseif($conteo_almacen==1 and $user_login->almacen->estado==0 and $user_login->name=='Colaborador' )
                                <form action="{{ route('guia_remision.create')}}" enctype="multipart/form-data"  method="post">
                                    @csrf
                                    <input type="text" value="{{$user_login->almacen_id}}" hidden="hidden" name="almacen">
                                    <input class="btn btn-sm btn-info"  type="submit" value="Crear una nueva Guia" >
                                </form>

                                @elseif($conteo_almacen > 1 and $user_login->name =='Administrador')
                                <div class="dropdown">
                                  <button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Crear una Nueva Guía</button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <form action="{{ route('guia_remision.create')}}"enctype="multipart/form-data"  method="post">
                                        @csrf
                                        @foreach($almacen as $almacens)
                                        <input type="submit" class="dropdown-item" name="almacen"  value="{{$almacens->id}} - {{$almacens->nombre}}">
                                        @endforeach
                                    </form>
                                </div>
                            </div>
                            @elseif($conteo_almacen > 1 and $user_login->name=='Colaborador')
                            @elseif($conteo_almacen > 1 )
                            @if($user_login->almacen->estado==1  )
                            <input id="auto" onclick="divAuto()" type="submit" class="btn btn-sm btn-info"  value="Crear una Nueva Guia">
                            <div id="div-mostrar" style="color: black">
                                <div id="texto" style="opacity:0;transition: .4s ;text-align: center;padding-top: 10px;" >Almacén asignado está desactivado, actívelo o cambie de almacén.</div>
                            </div>
                            @elseif($user_login->almacen->estado==0 )
                            <form action="{{ route('guia_remision.create')}}" enctype="multipart/form-data" >
                                @csrf
                                <input type="text" value="{{$user_login->almacen_id}}" hidden="hidden" name="almacen">
                                <input class="btn btn-sm btn-info"  type="submit" value="Crear una nueva Guia" >
                            </form>

                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
{{-- fimodal --}}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Lista de Guias R.</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código de Guía</th>
                                    <th>Cliente</th>
                                    <th>Ruc/DNI</th>
                                    <th>Fecha emisión</th>
                                    <th>Ver</th>
                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guia_remision as $guias_remision)
                                <tr class="gradeX">
                                    <td>{{$guias_remision->id}}</td>
                                    @php
                                        $tieneNota = $guias_remision->nota_informativa !== null && trim($guias_remision->nota_informativa) !== '';
                                        // Escapamos conillas y saltos de linea para atributos HTML y JS
                                        $escapedNotaHTML = htmlspecialchars($guias_remision->nota_informativa, ENT_QUOTES, 'UTF-8');
                                        $jsEscapedNota = str_replace(["'", "\r\n", "\n", "\r"], ["\\'", "\\n", "\\n", "\\n"], $guias_remision->nota_informativa);
                                    @endphp
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="mr-2 text-secondary-emphasis">
                                                {{$guias_remision->cod_guia}}
                                            </span>
                                            @if($tieneNota)
                                                <button type="button" class="btn btn-sm info-icon"
                                                        data-trigger="hover"
                                                        data-placement="top"
                                                        data-toggle="popover"
                                                        title="Nota Informativa"
                                                        data-content="{{$escapedNotaHTML}}"
                                                        onclick="gestionarNota({{$guias_remision->id}}, '{{$jsEscapedNota}}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-square-fill" viewBox="0 0 16 16">
                                                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm8.93 4.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                                    </svg>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm info-icon text-muted"
                                                        title="Añadir Nota"
                                                        onclick="gestionarNota({{$guias_remision->id}}, '')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-dotted" viewBox="0 0 16 16">
                                                        <path d="M2.5 0c-.166 0-.33.016-.487.048l.194.98A1.51 1.51 0 0 1 2.5 1h.458V0zm2.292 0h-.917v1h.917zm1.833 0h-.917v1h.917zm1.833 0h-.916v1h.916zm1.834 0h-.917v1h.917zm1.833 0h-.917v1h.917zM13.5 0h-.458v1h.458c.1 0 .199.01.293.029l.194-.981A2.51 2.51 0 0 0 13.5 0m2.079 1.11a2.5 2.5 0 0 0-.69-.689l-.556.831c.164.11.305.251.415.415l.83-.556zM1 2.292V3.21h-1v-.917h1zm14 0v.917h1v-.917zM1 4.125v.917h-1v-.917h1zm14 0v.917h1v-.917zM1 5.958v.917h-1v-.917zm14 0v.917h1v-.917zM1 7.792v.916h-1v-.916zm14 0v.916h1v-.916zM1 9.625v.917h-1v-.917zm14 0v.917h1v-.917zM1 11.458v.917h-1v-.917zm14 0v.917h1v-.917zM1 13.292v.917h-1v-.917zm14 0v.917h1v-.917zM1.531 15.348a2.5 2.5 0 0 0 .69.689l.556-.831a1.5 1.5 0 0 1-.415-.415l-.83.556zM2.5 16h.458v-1h-.458a1.5 1.5 0 0 1-.293-.029l-.194.981c.157.032.321.048.487.048m2.292 0h.917v-1h-.917zm1.833 0h.917v-1h-.917zm1.833 0h.916v-1h-.916zm1.834 0h.917v-1h-.917zm1.833 0h.917v-1h-.917zM13.5 16c.166 0 .33-.016.487-.048l-.194-.98A1.51 1.51 0 0 1 13.5 15h-.458v1zM8 4.5a.5.5 0 0 1 .5.5v2.5H11a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V8.5H5a.5.5 0 0 1 0-1h2.5V5a.5.5 0 0 1 .5-.5"/>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{$guias_remision->cliente->nombre}}</td>
                                    <td>{{$guias_remision->cliente->numero_documento}}</td>
                                    <td>{{$guias_remision->fecha_emision}}</td>
                                    <td><center><a href="{{route('guia_remision.show' , $guias_remision->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center></td>
                                    <td style="text-align:center;">
                                        @if($guias_remision->g_electronica==1) <!-- Nombre del cliente -->
                                            <button class="btn btn-info btn-circle btn-ls"  data-toggle="tooltip" data-placement="bottom" title="Aceptada"><i class="fa fa-check-circle"></i></button>
                                            <span hidden>Aceptada</span>
                                        @elseif($guias_remision->g_electronica==2)
                                            <button class="btn btn-danger btn-circle btn-ls" data-toggle="tooltip" data-placement="bottom" title="Anulada"><i class="fa fa-times-circle"></i></button>
                                            <span hidden>Anulada</span>
                                        @else
                                            <button class="btn btn-warning btn-circle btn-ls" data-toggle="tooltip" data-placement="bottom" title="En Espera"><i class="fa fa-check-circle"></i></button>
                                            <span hidden>En Espera</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
.a{width: 200px}

#auto{
    /*padding: -100px;*/
    /*background: orange;*/
    /*width: 95px;*/
    cursor: pointer;
    /*margin-top: 10px;*/
    /*margin-bottom: 10px;*/
    box-shadow: 0px 0px 1px #000;
    display: inline-block;
}

#auto:hover{
    opacity: .8;
}

#div-mostrar{
    /*width: 50%;*/
    margin: auto;
    height: 0px;
    /*margin-top: -5px*/
    /*background: #000;*/
    /*box-shadow: 10px 10px 3px #D8D8D8;*/
    transition: height .4s;
    color:white;
    text-align: right;
}
#auto:hover{
    opacity: .8;
}
.url_def{
    text-decoration: underline;
}
</style>



<!-- Mainly scripts -->
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

<!-- Page-Level Scripts -->
<script>
    var clic = 1;
    function divAuto(){
       if(clic==1){
           document.getElementById("div-mostrar").style.height = "50px";
           document.getElementById("texto").style.opacity = "1";
           clic = clic + 1;
       } else{
        document.getElementById("div-mostrar").style.height = "0px";
        document.getElementById("texto").style.opacity = "0";

        clic = 1;
    }
}
</script>
<script>
    //Cerrar el popover al hacer click fuera
    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    function gestionarNota(id, notaActual) {
        $('[data-toggle="popover"]').popover('hide');
        $('#modalGestionarNota').remove();

        let title = notaActual ? 'Editar Nota Informativa' : 'Agregar Nota Informativa';
        let deleteBtn = notaActual ? `<button type="button" class="btn btn-danger" style="border-radius: 4px;" onclick="confirmarEliminarNota(${id})"><i class="fa fa-trash"></i> Eliminar</button>` : '';
        let saveBtnText = notaActual ? 'Actualizar' : 'Guardar';
        let iconHeader = notaActual ? 'fa-pencil-square-o' : 'fa-plus-circle';

        let modalHTML = `
        <div class="modal fade" id="modalGestionarNota" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow" style="border-radius: 6px; overflow: hidden;">
                    <div class="modal-header d-flex justify-content-between align-items-center" style="background-color: #1a3bb3; color: white; border-bottom: none; padding: 15px 20px;">
                        <h5 class="modal-title" style="margin: 0; font-weight: 500; font-size: 16px;"><i class="fa ${iconHeader} mr-2"></i>${title}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8; padding: 10px; margin: -10px -10px -10px auto; outline: none; text-shadow: none;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light" style="padding: 20px;">
                        <label class="font-weight-bold text-muted mb-2">Contenido de la nota:</label>
                        <textarea id="input-modal-nota" class="form-control" rows="4" placeholder="Escriba aquí..." style="border-radius: 4px; resize: none;"></textarea>
                    </div>
                    <div class="modal-footer bg-white border-top-0 d-flex justify-content-between" style="padding: 15px 20px;">
                        <div>${deleteBtn}</div>
                        <div>
                            <button type="button" class="btn btn-white text-muted" data-dismiss="modal" style="border-radius: 4px; border-color: #e5e6e7;">Cancelar</button>
                            <button type="button" class="btn btn-primary" style="background-color: #1a3bb3; border-color: #1a3bb3; border-radius: 4px;" onclick="guardarDesdeModal(${id})">${saveBtnText}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        $('body').append(modalHTML);

        if (notaActual) {
            $('#input-modal-nota').val(notaActual);
        }

        $('#modalGestionarNota').on('shown.bs.modal', function () {
            $('#input-modal-nota').focus();
        });

        $('#modalGestionarNota').modal('show');
    }

    function guardarDesdeModal(id) {
        let nota = $('#input-modal-nota').val().trim();
        if (!nota) {
            toastr.warning('La nota no puede estar vacía al guardar. Si desea borrarla, use el botón rojo de "Eliminar".');
            $('#input-modal-nota').focus();
            return;
        }
        enviarNotaAjax(id, nota, false);
    }

    function confirmarEliminarNota(id) {
        $('#modalGestionarNota').modal('hide');
        setTimeout(function() {
            swal({
                title: "¿Eliminar nota?",
                text: "Esta acción no se puede deshacer.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function () {
                enviarNotaAjax(id, null, true);
            });
        }, 400);
    }

    function enviarNotaAjax(id, nota, isDelete) {
        $.ajax({
            url: "{{ route('guia_remision.guardar_nota', ':id') }}".replace(':id', id),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                nota_informativa: nota
            },
            success: function(response) {
                if(response.success){
                    $('#modalGestionarNota').modal('hide');
                    if (isDelete) {
                        swal.close();
                        toastr.success('Nota eliminada permanentemente.');
                    } else {
                        toastr.success('Nota guardada correctamente.');
                    }
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error('Ocurrió un error al procesar la solicitud.');
                }
            },
            error: function() {
                toastr.error('Error de comunicación con el servidor.');
            }
        });
    }
</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
        $('[data-toggle="tooltip"]').tooltip();
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            order: [[0, "desc"]],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []

        });

    });

</script>
@endsection
