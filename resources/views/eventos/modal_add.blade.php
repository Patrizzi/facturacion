<div class="modal" id="modal_event">
    <div class="modal-dialog modal-lg  text-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('eventos.store') }}" method="POST" style="margin: 5px 2em">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Titulo <span class="text-red">*</span></label></label>
                                <input type="text" class="form-control title-input" name="title" id=""
                                    placeholder="Titulo del Evento" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <label class="form-label">Cliente <span class="text-red">*</span></label>
                            <select class="form-control form-select select2" name="cliente_id" id="cliente_id"
                                data-bs-placeholder="Seleccionar Cliente" required>
                                <option value="">Seleccionar Cliente</option>
                                @foreach ($clientes as $clie)
                                    <option value="{{ $clie->id }}">{{ $clie->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <label class="form-label">Tipo de Atención<span
                                    class="text-red">*</span></label></label>
                            <div class="form-control" id="form-all">
                                <div id="todo_el_dia">
                                    <input type="checkbox" name="all_day" id="all_day" onclick="check_day()">Todo
                                    el día
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="form-label">Categoría<span class="text-red">*</span></label></label>
                            <div class="row">
                                <div class="col-sm-8">
                                    <select class="form-control select2" name="categoria" id="select_cat"
                                        onchange="color_select()" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-control category-color">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <label class="form-label">Fecha de Inicio <span
                                    class="text-red">*</span></label></label>
                            <div class="row">
                                <div class="col-sm-7 col-md-7">
                                    <input type="date" name="fecha_inicio" id="inicio_date" class="form-control"
                                        required>
                                </div>
                                <div class="col-sm-5 col-md-5">
                                    <input type="time" name="hora_inicio" id="hora_inicio" required
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="form-label">Fecha de Finalizacion <span
                                    class="text-red">*</span></label></label>
                            <div class="row">
                                <div class="col-sm-7 col-md-7">
                                    <input type="date" name="fecha_fin" id="fin_date" class="form-control"
                                        required>
                                </div>
                                <div class="col-sm-5 col-md-5">
                                    <input type="time" name="hora_fin" id="hora_fin" required
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <label class="form-label">Asignar Usuario<span class="text-red">*</span></label></label>
                            <select class="form-control select2" name="usuario" id="user_asig">
                                <option value="all_user">Todos los Usuarios</option>
                                @foreach ($user as $users)
                                    <option value="{{ $users->id }}">{{ $users->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-sm-6 col-md-6">

                    </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label">Descripcion del Evento</label>
                            <textarea class="form-control" name="description" id="" placeholder="Descripcion del Evento"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .form-label {
        text-align: left;
    }
</style>
