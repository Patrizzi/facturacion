<!-- modal - Familias -->
<div id="modal-familia" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel6">
    <div class="modal-dialog modal-dialog-centered modal-xl-manual">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel6">Familias</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="form-familia">
                    <!--Contenido de modal-->
                    @csrf
                    <input type="hidden" value="" name="familia_edit_id" id="id_familia_edit">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <input type="text" placeholder="Descripción: Sartén Antiaderente" name="descripcion_familia" id="descripcion_familia" class="form-control" required autocomplete="off">
                        </div>
                        <div class="col-12 row">
                            <div class="col-6">
                                <input type="text" placeholder="Ubicación: A12" name="ubicacion_familia" id="ubicacion_familia" class="form-control" required autocomplete="off">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-success " type="button" id="add_new_familia"
                                    style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i> Agregar</button>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-success " type="button" id="update_familia"
                                    style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i> Editar</button>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-danger " type="button" id="cancel_familia"><i class="fa fa-pencil"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                    

                    <hr>
                    <!--Fecha, Buscar y tabla-->
                    <div class="row mb-3">
                        <div class="col-12 input-group">
                            <label class="col-md-2 col-sm-3 col-form-label">Buscar:</label>
                            <input type="text" class="form-control col-md-8 col-sm-8" name="" id="search_familia" autocomplete="off">
                        </div>
                    </div>
                    <div class=" table-responsive">
                        <!--Tabla-->
                        <table class="table table-striped text-md-center table-bordered dataTables-familias">
                            <thead>
                                <tr>
                                    <th style="width: 35%;">Descripción</th>
                                    <th style="width: 15%;">Ubicación</th>
                                    <th style="width: 20%;">Cantidad de SubFamilias</th>
                                    <th style="width: 20%;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php
                                    use App\Subfamilia;
                                @endphp
                                <span hidden="hidden">{{ $i = 1 }}</span>
                                @foreach ($familias as $familia)
                                    <tr>
                                        <td>{{ $familia->codigo }}</td>
                                        <td>{{ $familia->descripcion }}</td>
                                        <td>
                                            @if ($familia->ubicacion != null)
                                                {{ $familia->ubicacion }}
                                            @else
                                                Sin Ubicacion
                                            @endif
                                        </td>
                                        <td>{{ $count_sub = Subfamilia::where('id_familia', $familia->id)->count() }}</td>
                                        <td>
                                            <a href="{{ route('familia.show', $familia->id) }}">
                                                <button type="button" class="btn btn-success"><i
                                                        class="fa fa-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
