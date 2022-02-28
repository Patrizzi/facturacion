@extends('layout')
@section('title', auth()->user()->personal->nombres)
@section('atributo_actu', 'hidden')
@section('atributo_1', 'hidden')

@section('content')
@if($errors->any())
<div style="padding-top: 20px;">
 <div class="alert alert-danger">
    <a class="alert-link" href="#">
      @foreach ($errors->all() as $error)
      <li class="error">{{ $error }}</li>
      @endforeach
  </a>
</div>
</div>
@endif
<div class="wrapper wrapper-content">
    <div class="animated fadeInRight">
        <div class="row">
            <div class="col-md-12">
               <div class="ibox ">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Correo:</h5>
                            <p class="form-control">{{auth()->user()->email}}</p>
                        </div>
                        <div class="col-md-6">
                           <h5>Almacén Asignado:</h5>
                           <p class="form-control">{{auth()->user()->almacen->nombre}}</p>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <form action="{{ route('usuario.update',auth()->user()->id) }}"  enctype="multipart/form-data" method="post">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-md-4">
            <div class="ibox ">
                <div>
                    <div class="ibox-content no-padding border-left-right">
                       {{-- <img  class="img-fluid" src="{{ asset('/profile/images/')}}/{{auth()->user()->avatar}}" > --}}

                       <input type="file" id="archivoInput" name="avatar" onchange="return validarExt()"  />
                       <input name="avatar_respaldo" value="{{auth()->user()->avatar}}" hidden/>
                       <div id="visorArchivo">
                        <img style="padding: 51px;" class="img-fluid" src="{{ asset('/profile/images/')}}/{{auth()->user()->avatar}}" >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        input#archivoInput{
          position:absolute;
          top:0px;
          left:0px;
          right:0px;
          bottom:0px;
          width:100%;
          opacity:0;
      }
  </style>
  <div class="col-md-8">
    <div class="ibox ">
        <div class="ibox-title"><h5>Datos Usuario</h5></div>
        <div class="ibox-content">
          <div class="ibox-content profile-content">
              <h5>Nombre:</h5>
              <h4><input type="text" class="form-control" value="{{auth()->user()->nombre}}" name="nombre"></h4>
              <h5>Correo:</h5>
              <h4><input type="text" class="form-control" value="{{auth()->user()->email_user}}" name="email_user"></h4>
              <h5>Celular:</h5>
              <h4><input type="text" class="form-control" value="{{auth()->user()->celular}}" name="celular"></h4>
              <h5>Contraseña:</h5>
              <h4><input type="password" class="form-control" id="div" name="password" readonly placeholder="************"></h4>
          </div>
          <button class="btn btn-primary">Guardar</button>
      </div>
  </div>
</div>
</div>
</form>

</div>
</div>
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
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}

<script>
 $(document).ready(function(){
    $("#div").dblclick(function(){
        var readonly = document.getElementById("div").hasAttribute("readonly");
        // alert(readonly);
        if (readonly==true) {document.getElementById("div").removeAttribute("readonly");}
        if (readonly==false){
              document.getElementById("div").value ="";
              document.getElementById("div").setAttribute("readonly","");}
    });
});
</script>
<script type="text/javascript">
  function validarExt()
  {
    var archivoInput = document.getElementById('archivoInput');
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.jpg|.png|.jfif)$/i;
    if(!extPermitidas.exec(archivoRuta)){
      alert('Asegúrese de haber seleccionado una Imagen');
      archivoInput.value = '';
      return false;
  }

  else
  {
            //PRevio del PDF
            if (archivoInput.files && archivoInput.files[0])
            {
              var visor = new FileReader();
              visor.onload = function(e)
              {
                document.getElementById('visorArchivo').innerHTML =
                '<center><img class="img-fluid" style="padding: 51px;" name="avatar" src="'+e.target.result+'" /></center>';
            };
            visor.readAsDataURL(archivoInput.files[0]);
        }
    }
}
</script>
<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });

</script>
@endsection