 @extends('layout')
 @section('title', 'Marcas')
 @section('data-toggle', 'modal')
 @section('href_accion', '#exampleModal')
 @section('value_accion', 'Agregar')
 @section('button2', 'Atras')
 @section('config',route('Configuracion'))
 @section('content')

 <!-- Modal Create  -->

 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('marca.store') }}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <fieldset >
                            <div>
                                <div class="panel-body" >
                                    <div class="row">
                                        <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/marca.svg')}}" width="100px"></div>

                                        <label class="col-sm-2 col-form-label">Nombre:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nombre" required="required">
                                        </div>
                                        <label class="col-sm-2 col-form-label">Abreviatura:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="abreviatura" required="required">
                                        </div>
                                        <label class="col-sm-2 col-form-label">Telefono:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="telefono" >
                                        </div><label class="col-sm-2 col-form-label">Empresa:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nombre_empresa" required="required">
                                        </div><label class="col-sm-2 col-form-label">Descripcion:</label>
                                        <div class="col-sm-10">
                                            <textarea type="text" class="form-control" name="descripcion" placeholder="opcional"></textarea>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Foto:</label>
                                        <div class="col-sm-10">
                                            <input type="file" style="position:absolute;top:0px;left:0px;right:0px;bottom:0px;width:100%;height:100%;opacity: 0  ;" id="archivoInput" name="imagen" onchange="return validarExt()"  />
                                            <span id="visorArchivo">
                                                <!--Aqui se desplegará el fichero-->
                                                <img name="imagen" src="{{asset('img/logos/marca_defecto.png')}}"  width="300px" height="200px" />
                                            </span>
                                        </span>
                                    </div><script type="text/javascript">
                                        {{-- Fotooos --}}
                                        function validarExt()
                                        {
                                            var archivoInput = document.getElementById('archivoInput');
                                            var archivoRuta = archivoInput.value;
                                            var extPermitidas = /(.jpg|.png|.jfif)$/i;
                                            if(!extPermitidas.exec(archivoRuta)){
                                                alert('Asegurese de haber seleccionado una Imagen');
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
                '<img name="imagen" src="'+e.target.result+'"width="300px" height="200px"" />';
            };
            visor.readAsDataURL(archivoInput.files[0]);
        }
    }
}
</script>
</div>
</div>
</div>

</fieldset>
<button class="btn btn-primary" type="submit">Grabar</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</form>
</div>
</div>
</div>
</div>
</div>
<!-- / Modal Create  -->

<div class="wrapper wrapper-content animated fadeInRight">
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
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead align="center">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Abreviatura</th>
                                <th>Descripcion</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($marcas as $marca)
                            <tr class="gradeX">
                                <td>
                                  @if($marca->estado == 0) <i class="fa fa-circle" style="color: green;"></i>@else
                                  <i class="fa fa-circle"></i>
                                  @endif
                                  {{$marca->id}}</td>
                                  <td>{{$marca->nombre}}</td>
                                  <td>{{$marca->abreviatura}}</td>
                                  <td>{{$marca->descripcion}}</td>
                                  <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$marca->id}}"><i  class="fa fa-edit"></i></button>
                                    <div class="modal fade" id="exampleModal{{$marca->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div style="padding-left: 15px;padding-right: 15px;">
                                                    {{-- ccccccccccccccccc --}}
                                                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                        <form action="{{ route('marca.update',$marca->id) }}"  enctype="multipart/form-data" method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <fieldset >
                                                                <div>
                                                                    <div class="panel-body" >
                                                                        <div class="row">
                                                                           <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/marca.svg')}}" width="100px"></div>
                                                                           <label class="col-sm-2 col-form-label">Nombre:</label>
                                                                           <div class="col-sm-10">
                                                                            <input required="required" type="text" class="form-control" value="{{$marca->nombre}}" name="nombre">
                                                                        </div>

                                                                        <label class="col-sm-2 col-form-label">Empresa:</label>
                                                                        <div class="col-sm-10">
                                                                            <input required="required" type="text" class="form-control" value="{{$marca->nombre_empresa}}" name="nombre_empresa">
                                                                        </div>
                                                                        <label class="col-sm-2 col-form-label">Telefono:</label>
                                                                        <div class="col-sm-10">
                                                                            <input  type="text" class="form-control" value="{{$marca->telefono}}" name="telefono">
                                                                        </div><label class="col-sm-2 col-form-label">Descripcion:</label>
                                                                        <div class="col-sm-10">
                                                                            <textarea type="text" class="form-control" placeholder="opcional" name="descripcion"> {{$marca->descripcion}}</textarea>
                                                                        </div>
                                                                        <label class="col-sm-2 col-form-label">Abreviatura:</label>
                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control" value="{{$marca->abreviatura}}"readonly="">
                                                                        </div>

                                                                        @if($conteo > 1 || $marca->estado==1 )
                                                                        <label class="col-sm-2 col-form-label">Estado:</label>
                                                                        <div class="col-sm-4" align="center">
                                                                            <input type="checkbox" class="js-switch_{{$marca->id}}" name="estado"  @if($marca->estado==0) checked="" @endif />
                                                                        </div>
                                                                        @endif
                                                                        <label class="col-sm-12 col-form-label">Foto:</label>
                                                                        <div class="col-sm-12">
                                                                           <input type="file" style="position:absolute;top:0px;left:0px;right:0px;bottom:0px;width:100%;height:100%;opacity: 0  ;" id="archivoInput{{$marca->id}}" name="imagen" onchange="return validarExt{{$marca->id}}()"  />
                                                                           <span id="visorArchivo{{$marca->id}}">
                                                                            <!--Aqui se desplegará el fichero-->

                                                                            @if(isset($marca->imagen))
                                                                            <img name="imagen" src="{{asset('archivos/imagenes/marcas/'.$marca->imagen)}}" width="300px" height="200px"   />
                                                                            @else
                                                                            <img src="{{asset('img/logos/marca_ejemplo.svg')}}" width="300px">
                                                                            @endif

                                                                            <input type="text" name="imagenes" hidden="hidden" value="{{$marca->imagen}}">
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </fieldset>
                                                    <button class="btn btn-primary" type="submit">Grabar</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Modal Create  -->
                        </td>
                    </tr>
                    <script type="text/javascript">
                        {{-- Fotooos --}}
                        function validarExt{{$marca->id}}()
                        {
                            var archivoInput{{$marca->id}} = document.getElementById('archivoInput{{$marca->id}}');
                            var archivoRuta = archivoInput{{$marca->id}}.value;
                            var extPermitidas = /(.jpg|.png|.jfif)$/i;
                            if(!extPermitidas.exec(archivoRuta)){
                                alert('Asegurese de haber seleccionado una Imagen');
                                archivoInput{{$marca->id}}.value = '';
                                return false;
                            }

                            else
                            {
        //PRevio del PDF
        if (archivoInput{{$marca->id}}.files && archivoInput{{$marca->id}}.files[0])
        {
            var visor = new FileReader();
            visor.onload = function(e)
            {
                document.getElementById('visorArchivo{{$marca->id}}').innerHTML =
                '<img name="imagen" src="'+e.target.result+'"width="300px"  />';
            };
            visor.readAsDataURL(archivoInput{{$marca->id}}.files[0]);
        }
    }
}
</script>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<style>
    .col-sm-10{padding-bottom: 5px;padding-top: 5px;}
    .form-control{border-radius: 5px}
</style>




<body>

{{--Base para agregar el tab para el los contenidos--}}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1"><span style="color: green;">&#9632; </span> MARCAS
                                    {{-- link del tab 1 --}}
                                </a>
                            </li>
                            <li class="ml-auto">
                                <div class="btn-group mx-2">
                                    <div class="col-auto">
                                        <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                    <!-- Botón para abrir el modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarmarcanueva">
                                        Agregar
                                    </button>
                                </div>
                            </li></ul>

<!-- Modal -->
<div class="modal fade" id="agregarmarcanueva" tabindex="-1" aria-labelledby="agregarmarcanuevaLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: calc(800px - 30px); width: calc(100% - 30px);">
    <div class="modal-content" style="border-radius: 25px; padding: 10px;"> <!-- Ajusta el padding para hacer el modal más corto -->
            <div class="modal-header" style="background-color: #1E50AE; text-align: center; color: white; position: relative; padding: 10px 50px;"> <!-- Aumenta el padding lateral -->
                <h5 class="modal-title" id="agregarmarcanuevaLabel" style="flex-grow: 1; margin: 0; font-size: 2rem; text-align: center;">AGREGAR MARCA</h5>
            </div>
            <div class="modal-body" style="padding: 10px;"> <!-- Ajusta el padding para hacer el modal más corto -->
                <form>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <div style="flex: 1; display: flex; align-items: center;">
                            <label for="nombre" style="margin-right: 20px; color: black; font-weight: bold; font-size: 14px;">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" style="flex: 0 0 250px; height: 30px; background-color: #F0F0F0; border: none; outline: none;"> <!-- Ajusta el width, height y color aquí -->  
                        </div>
                        <div style="flex: 1; display: flex; align-items: center;">
                            <label for="telefono" style="margin-right: 10px; color: black; font-weight: bold; font-size: 14px;">Teléfono:</label>
                            <input type="text" id="telefono" name="telefono" style="flex: 0 0 250px; height: 30px; background-color: #F0F0F0; border: none; outline: none;"> <!-- Ajusta el width, height y color aquí -->  
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <div style="flex: 1; display: flex; align-items: center;">
                            <label for="abreviatura" style="margin-right: 10px; color: black; font-weight: bold; font-size: 14px;">Abreviatura:</label>
                            <input type="text" id="abreviatura" name="abreviatura" style="flex: 0 0 233px; height: 30px; background-color: #F0F0F0; border: none; outline: none;"> <!-- Ajusta el width, height y color aquí -->  
                        </div>
                        <div style="flex: 1; display: flex; align-items: center;">
                            <label for="empresa" style="margin-right: 10px; color: black; font-weight: bold; font-size: 14px;">Empresa:</label>
                            <input type="text" id="empresa" name="empresa" style="flex: 0 0 250px; height: 30px; background-color: #F0F0F0; border: none; outline: none;"> <!-- Ajusta el width, height y color aquí -->  
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <div style="flex: 1; display: flex; align-items: center;">
                            <label for="descripcion" style="margin-right: 10px; color: black; font-weight: bold; font-size: 14px;">Descripción:</label>
                            <input type="text" id="descripcion" name="descripcion" placeholder="Opcional" style="flex: 0 0 233px; height: 30px; background-color: #F0F0F0; border: none; outline: none;"> <!-- Ajusta el width, height y color aquí -->  
                        </div>
                        <div style="flex: 1; display: flex; align-items: center;">
                            <label for="foto" style="margin-right: 10px; color: black; font-weight: bold; font-size: 14px;">Foto:</label>
                            <input type="file" id="foto" name="foto" style="flex: 0 0 100px; height: 40px;"> <!-- Ajusta el width y height aquí -->
                        </div>
                    </div>

                    <div class="modal-footer" style="display:flex; justify-content:center; align-items:center;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-size: 1rem; padding: 10px 20px;">Cerrar</button>
                        <button type="button" class="btn btn-primary" style="font-size: 1rem; padding: 10px 20px; margin-left:10px;">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th >ID</th>
                                                <th >Nombre</th>
                                                <th >Abreviatura</th>
                                                <th>Descripción</th>
                                                <th>IMG</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>EPSON</td>
                                            <td>EP</td>
                                            <td>Descripción del Producto</td>
                                            <td><img src="https://www.manualweb.net/img/logos/html.png" alt="" width="30" height="30"></td>
                                                <td>
                                                <button style="display:inline-block; padding:10px; background-color:green; border-radius:5px; margin-right:2px; border:none;">
                                                    <i class="fa fa-eye" style="color:white;"></i>
                                                </button>
                                            <button style="display:inline-block; padding:10px; background-color:green; border-radius:66px; margin-right:2px; border:none;">
                                                <i class="fa fa-check" style="color:white;"></i>
                                            </button>
                                            <a href="#" style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;"
                                            data-bs-toggle="modal" data-bs-target="#editarmarcanueva"> <!-- Cambié modaluno a editarmarcanueva -->
                                                <i class="fa fa-edit" style="color:white;"></i>
                                            </a>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editarmarcanueva" tabindex="-1" aria-labelledby="editarmarcanuevaLabel" aria-hidden="true">
                                            <div class="modal-dialog" style="max-width: calc(800px - 30px); width: calc(100% - 30px);">
                                                        <div class="modal-content" style="border-radius: 25px; padding: 10px;"> <!-- Ajusta el padding para hacer el modal más corto -->
                                                    <div class="modal-header" style="background-color: #1E50AE; text-align: center; color: white; position: relative; padding: 10px 50px;"> <!-- Aumenta el padding lateral -->
                                                        <h5 class="modal-title" id="editarmarcanuevaLabel" style="flex-grow: 1; margin: 0; font-size: 2rem; text-align: center;">INFORMACIÓN GENERAL</h5>
                                                    </div>
                                                    <div class="modal-body" style="padding: 10px;"> <!-- Ajusta el padding para hacer el modal más corto -->
                                                        <form>
                                                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                                                <div style="flex: 1; display: flex; align-items: center;">
                                                                    <label for="nombre" style="margin-right: 20px; color: black; font-weight: bold; font-size: 14px;">Nombre:</label>
                                                                    <input type="text" id="nombre" name="nombre" style="flex: 0 0 250px; height: 30px; background-color: #F0F0F0; border: none; outline: none;"> <!-- Ajusta el width, height y color aquí -->                        
                                                                </div>
                                                                <div style="flex: 1; display: flex; align-items: center;">
                                                                    <label for="telefono" style="margin-right: 10px; color: black; font-weight: bold; font-size: 14px;">Teléfono:</label>
                                                                    <input type="text" id="telefono" name="telefono" style="flex: 0 0 230px; height: 30px; background-color: #F0F0F0; border: none; outline: none;"> <!-- Ajusta el width, height y color aquí -->   
                                                                </div>
                                                            </div>

                                                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                                                <div style="flex: 1; display: flex; align-items: center;">
                                                                    <label for="abreviatura" style="margin-right: 10px; color: black; font-weight: bold; font-size: 14px;">Abreviatura:</label>
                                                                    <input type="text" id="abreviatura" name="abreviatura" style="flex: 0 0 233px; height: 30px; background-color: #F0F0F0; border: none; outline: none;"> <!-- Ajusta el width, height y color aquí -->               
                                                                </div>
                                                                <div style="flex: 1; display: flex; align-items: center;">
                                                                    <label for="empresa" style="margin-right: 10px; color: black; font-weight: bold; font-size: 14px;">Empresa:</label>
                                                                    <input type="text" id="empresa" name="empresa" style="flex: 0 0 230px; height: 30px; background-color: #F0F0F0; border: none; outline: none;"> <!-- Ajusta el width, height y color aquí -->               
                                                                </div>
                                                            </div>

                                                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                                                <div style="flex: 1; display: flex; align-items: center;">
                                                                    <label for="descripcion" style="margin-right: 10px; color: black; font-weight: bold; font-size: 14px;">Descripción:</label>
                                                                    <input type="text" id="descripcion" name="descripcion" placeholder="Opcional" style="flex: 0 0 233px; height: 30px; background-color: #F0F0F0; border: none; outline: none;"> <!-- Ajusta el width, height y color aquí -->               
                                                                </div>
                                                                <div style="flex: 1; display: flex; align-items: center;">
                                                                    <label for="foto" style="margin-right: 10px; color: black; font-weight: bold; font-size: 14px;">Foto:</label>
                                                                    <input type="file" id="foto" name="foto" style="flex: 0 0 100px; height: 40px;"> <!-- Ajusta el width y height aquí -->
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer" style="display:flex; justify-content:center; align-items:center;">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-size: 1rem; padding: 10px 20px;">Cerrar</button>
                                                                <button type="button" class="btn btn-primary" style="font-size: 1rem; padding: 10px 20px; margin-left:10px;">Guardar Cambios</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <tr>
                                            <td>2</td>
                                            <td>CANON</td>
                                            <td>CA</td>
                                            <td>Sin descripción</td>
                                            <td><img src="https://www.manualweb.net/img/logos/html.png" alt="" width="30" height="30"></td>
                                            <td>
                                                <button style="display:inline-block; padding:10px; background-color:green; border-radius:5px; margin-right:2px; border:none;">
                                                    <i class="fa fa-eye" style="color:white;"></i>
                                                </button>
                                                <button style="display:inline-block; padding:10px; background-color:green; border-radius:66px; margin-right:2px; border:none;">
                                                    <i class="fa fa-check" style="color:white;"></i>
                                                </button>
                                                <a href="#"style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;"
                                            data-bs-toggle="modal" data-bs-target="#modaluno"> <i class="fa fa-edit" style="color:white;"></i>
                                            </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>COMPATIBLE</td>
                                            <td>CP</td>
                                            <td>Sin descripción</td>
                                            <td><img src="https://www.manualweb.net/img/logos/html.png" alt="" width="30" height="30"></td>
                                            <td>
                                                <button style="display:inline-block; padding:10px; background-color:red; border-radius:5px; margin-right:2px; border:none;">
                                                    <i class="fa fa-eye-slash" style="color:white;"></i>
                                                </button>
                                            <button style="display:inline-block; padding:10px; background-color:green; border-radius:66px; margin-right:2px; border:none;">
                                                <i class="fa fa-check" style="color:white;"></i>
                                            </button>
                                            <a href="#"style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;"
                                            data-bs-toggle="modal" data-bs-target="#modaluno"> <i class="fa fa-edit" style="color:white;"></i>
                                            </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>HP</td>
                                            <td>HP</td>
                                            <td>Sin descripción</td>
                                            <td><img src="https://www.manualweb.net/img/logos/html.png" alt="" width="30" height="30"></td>
                                            <td>
                                                <button style="display:inline-block; padding:10px; background-color:green; border-radius:5px; margin-right:2px; border:none;">
                                                    <i class="fa fa-eye" style="color:white;"></i>
                                                </button>
                                                <button style="display:inline-block; padding:10px; background-color:green; border-radius:66px; margin-right:2px; border:none;">
                                                    <i class="fa fa-check" style="color:white;"></i>
                                                </button>
                                            <a href="#"style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;"
                                            data-bs-toggle="modal" data-bs-target="#modaluno"> <i class="fa fa-edit" style="color:white;"></i>
                                            </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>DELL</td>
                                            <td>DELL</td>
                                            <td>Sin descripción</td>
                                            <td><img src="https://www.manualweb.net/img/logos/html.png" alt="" width="30" height="30"></td>
                                            <td>
                                                <button style="display:inline-block; padding:10px; background-color:green; border-radius:5px; margin-right:2px; border:none;">
                                                    <i class="fa fa-eye" style="color:white;"></i>
                                                </button>
                                                <button style="display:inline-block; padding:10px; background-color:red; border-radius:66px; margin-right:2px; border:none;">
                                                    <i class="fa fa-arrows-alt" style="color:white;"></i>
                                                </button>
                                            <a href="#"style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;"
                                            data-bs-toggle="modal" data-bs-target="#modaluno"> <i class="fa fa-edit" style="color:white;"></i>
                                            </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>



















































<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<!-- Switchery -->
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
<!-- Switchery -->
<script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>
<script>
    function reemplaza_imagen(imagen) {
        imagen.onerror = "";
        imagen.src = "{{asset('img/logos/marca_defecto.png')}}";
        return true;
    }
</script>
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [  ]
        });
    });

</script>
@foreach($marcas as $marca)
<script>
    var elem_2 = document.querySelector('.js-switch_{{$marca->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
{{-- </script>
@endforeach
@foreach($marcas as $marca)
<script> --}}
    var elem_2 = document.querySelector('.js-switch_vehiculo{{$marca->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach
@endsection
