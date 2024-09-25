<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Crear Registro</h1>
    <form action="{{ route('project_managers.destroy',$data->id)}}" method="POST">
        @method('DELETE')
        @csrf
        <button type="submit">Eliminar</button>
    </form>

    <form action="{{ route('project_managers.update', $data->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="{{ $data->nombre }}">
            <label for="ruc">Ruc:</label>
            <input type="text" name="ruc" value="{{$data->ruc}}">
            <label for="centro_costo">Centro de Costo:</label>
            <input type="text" name="centro_costo" value="{{$data->centro_costo}}">
            <label for="administrador_id">Administrador:</label>
            <input type="number" name="administrador_id" value="{{$data->administrador_id}}">
            <label for="responsable_id">Responsable:</label>
            <input type="number" name="responsable_id" value="{{$data->responsable_id}}">
            <label for="cliente_id">Cliente:</label>
            <input type="number" name="cliente_id" value="{{$data->cliente_id}}">
            <label for="project_service_id">Servicio:</label>
            <input type="number" name="project_service_id" value="{{$data->project_service_id}}">
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="datetime-local" name="fecha_inicio" value="{{$data->fecha_inicio}}">
            <label for="fecha_cierre">Fecha de Cierre:</label>
            <input type="datetime-local" name="fecha_cierre" value="{{$data->fecha_cierre}}">
            <label for="prioridad">Prioridad:</label>
            <input type="number" name="prioridad" value="{{$data->prioridad}}">
        </div>
        <button type="submit">Actualizar Proyecto</button>
        <a href="{{ route('project_managers.index') }}">Cancelar</a>
    </form>
</body>
</html>