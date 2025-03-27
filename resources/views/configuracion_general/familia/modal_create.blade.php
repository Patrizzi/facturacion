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
                <form action="" method="post" enctype="" id="form_familia">
                    @csrf
                    <input type="hidden" value="" name="familia_edit_id" id="id_familia_edit">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" placeholder="Descripción:" name="descripcion_familia" id="descripcion_familia" class="form-control m-b" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <input type="text" placeholder="Ubicación:" name="ubicacion_familia" id="ubicacion_familia" class="form-control m-b" required autocomplete="off">
                        </div>
                        <div class="col-sm-3" style="text-align: center;">
                            <button class="btn btn-success " type="button" id="add_new_familia"
                                style="background-color:blue; border-color:blue; width: 49%"><i class="fa fa-plus"></i> Guardar</button>
                            <button class="btn btn-success " type="button" id="update_familia"
                            style="background-color:blue; border-color:blue; display: none; margin-top: 0px; width: 49%"><i class="fa fa-pencil"></i> Actualizar</button>
                            <button class="btn btn-danger " type="button" id="cancel_familia" style="width: 49%"><i
                                class="fa fa-pencil"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
                <hr>
                <!--Fecha, Buscar y tabla-->
                <div class="input-group row">
                    <label class="col-sm-2 col-form-label text-center">Buscar:</label>
                    <input type="text" class="form-control col-sm-10" name="" id="search_familia">
                </div>
                <br>
                <div class=" table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center table-bordered dataTables-familias">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Código</th>
                                <th style="width: 30%;">Descripción</th>
                                <th style="width: 20%;">Ubicación</th>
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
            </div>
        </div>
    </div>
</div>
