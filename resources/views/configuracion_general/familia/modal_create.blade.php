<!-- modal - Familias -->
<div id="modal-familia" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel6">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel6">Familias</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--Contenido de modal-->
                <div class="row">
                    <div class="col-12 row">
                        <div class="col-4">
                            <input type="text" disabled placeholder="Código: 003" class="form-control m-b" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <input type="text" placeholder="Padre: Utencilios" class="form-control m-b" autocomplete="off">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button"
                                style="background-color:blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" type="button"
                                style="background-color:blue; border-color:blue;"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                    <div class="col-4">
                        <input type="text" placeholder="Ubicación: A12" class="form-control" autocomplete="off">
                    </div>
                    <div class="col-8">
                        <input type="text" placeholder="Descripción: Sartén Antiaderente" class="form-control" autocomplete="off">
                    </div>
                </div>
                <hr>
                <!--Fecha, Buscar y tabla-->
                <div class="row mb-3">
                    <div class="col-12 input-group">
                        <label class="col-md-2 col-sm-3 col-form-label">Buscar:</label>
                        <input type="text" class="form-control col-md-8 col-sm-8" autocomplete="off">
                    </div>
                </div><!--
                <div class="row">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Buscar:</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="" class="form-control m-b">
                        </div>
                    </div>
                </div>-->
                <div class="row px-2 py-3 bg-light m-1 table-responsive">
                    <!--Tabla-->
                    <table class="table table-striped text-md-center dataTables-familias">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Código</th>
                                <th style="width: 35%;">Descripción</th>
                                <th style="width: 15%;">Ubicación</th>
                                <th style="width: 20%;">Cantidad de SubFamilias</th>
                                <th style="width: 10%;">Acción</th>
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
