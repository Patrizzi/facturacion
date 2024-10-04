<div class="form-group">
    <div class="form-cell"> 
        <label for="name">Nombre:</label>
        <input type="text" placeholder="Ingrese el Nombre" name="nombre" value="{{old('nombre',$data->nombre ?? '')}}" required>
    </div>
    <div class="form-cell"> 
        <label for="centro_costo">Centro de Costo:</label>
        <input type="text" placeholder="Ingrese el Centro de Costo" name="centro_costo" value="{{old('centro_costo',$data->centro_costo ?? '')}}" required>
    </div>
    <div class="form-cell"> 
        <label for="ruc">Ruc:</label>
        <input type="text" placeholder="Ingrese el Ruc" name="ruc" value="{{old('ruc',$data->ruc ?? '')}}" required>
    </div>
    <div class="form-cell"> 
        <label for="administrador_id">Administrador:</label>
        <input type="number" placeholder="Ingrese al Administrador" name="administrador_id" value="{{old('administrador_id',$data->administrador_id ?? '')}}" required>
    </div>
    <div class="form-cell"> 
        <label for="responsable_id">Responsable:</label>
        <input type="number" placeholder="Ingrese al Responsable" name="responsable_id" value="{{old('responsable_id',$data->responsable_id ?? '')}}" required>
    </div>
    <div class="form-cell"> 
        <label for="project_service_id">Servicio:</label>
        <input type="number" placeholder="Ingrese el Servicio" name="project_service_id" value="{{old('project_service_id',$data->project_service_id ?? '')}}" required>
    </div>
    <div class="form-cell"> 
        <label for="cliente_id">Cliente:</label>
        <input type="number" placeholder="Ingrese el Cliente" name="cliente_id" value="{{old('cliente_id',$data->cliente_id ?? '')}}" required>
    </div>
    <div class="form-cell"> 
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="datetime-local" placeholder="Ingrese la Fecha de Inicio" name="fecha_inicio" value="{{old('fecha_inicio',$data->fecha_inicio ?? '')}}" required>
    </div>
    <div class="form-cell"> 
        <label for="fecha_cierre">Fecha de Cierre:</label>
        <input type="datetime-local" placeholder="Ingrese la Fecha de Cierre" name="fecha_cierre" value="{{old('fecha_cierre',$data->fecha_cierre ?? '')}}" required>
    </div>
    <div class="form-cell"> 
        <label for="prioridad">Prioridad:</label>
        <input type="prioridad" placeholder="Ingrese la Prioridad" name="prioridad" value="{{old('prioridad',$data->prioridad ?? '')}}" required>
    </div>
</div>


