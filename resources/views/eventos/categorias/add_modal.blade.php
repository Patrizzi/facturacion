<div class="modal fade" id="modal_category">
    <div class="modal-dialog " role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('categorias_eventos.store')}}" method="POST"  style="margin: 5px 2em">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            Título:
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name" id="" autocomplete="off">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            Color:
                        </div>
                        <div class="col-sm-8">
                            <input type="color" class="form-control" id="color" name="color" autocomplete="off">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            Descripcion:
                        </div>
                        <div class="col-sm-8">
                            <textarea name="description" class="form-control" id="" ></textarea>
                        </div>
                    </div>
                </div>
                <span id="event_id"></span>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>