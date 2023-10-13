@extends('layout')

@section('title', 'Cobros')
@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active show" data-toggle="tab" href="#tab-1">Sin procesar</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Moras</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">Cliente</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active show">
                            <div class="panel-body">
                                <div class="row">
                                    {{-- <div class="col-sm-6">
                                        logo.png
                                    </div>
                                    <div class="col-sm-6">

                                    </div> --}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>N° Factura</th>
                                                <th>Cliente</th>
                                                <th>Cuotas Por Pagar</th>
                                                <th>Cuotas Pagadas</th>
                                                <th>Total a Pagar</th>
                                                <th>Ultima Fecha de Pago</th>
                                                <th>Pago en Lote</th>
                                                <th>Detalles</th>
                                                <th>Pagar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($facturas_sp as $index => $f_sp)
                                                <tr>
                                                    <td>{{$f_sp->id}}</td>
                                                    <td>{{$f_sp->codigo_fac}}</td>
                                                    <td>{{$f_sp->cliente->nombre}}</td>
                                                    <td>{{$cuotas_all->where('facturacion_id',$f_sp->id)->where('estado', 0)->count()}}</td>
                                                    <td>{{$cuotas_all->where('facturacion_id',$f_sp->id)->where('estado', 1)->count()}}</td>
                                                    <td>{{$f_sp->moneda->simbolo }} {{ number_format($cuotas_all->where('facturacion_id', $f_sp->id)->sum('monto'), 2) }}</td>
                                                    <td>
                                                        @if ($cuotas_all->where('facturacion_id',$f_sp->id)->where('estado', 1)->count() != 0)
                                                            {{date('d-m-Y', strtotime($cuotas_all->where('facturacion_id',$f_sp->id)->where('estado', 1)->pluck('fecha_pago')->first())) }}
                                                        @else
                                                            <strong>Pendiente</strong>
                                                        @endif
                                                    </td>
                                                    <td><input type="checkbox" name="" id=""></td>
                                                    <td>
                                                        <a class="btn btn-primary" href="{{route('pagos.edit_mora',$f_sp->codigo_fac)}}">Detalles</a>
                                                        {{-- <button class="btn btn-primary">Detalles</button> --}}
                                                    </td>
                                                    <td><button class="btn btn-primary">Pagar</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <strong>Donec quam felis</strong>
                                <p>Thousand unknown plants are noticed by me: when I hear the buzz of the little world among
                                    the stalks, and grow familiar with the countless indescribable forms of the insects
                                    and flies, then I feel the presence of the Almighty, who formed us in his own image, and
                                    the breath </p>
                                <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss
                                    of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite
                                    sense of mere tranquil existence, that I neglect my talents. I should be incapable of
                                    drawing a single stroke at the present moment; and yet.</p>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-3" class="tab-pane">
                            <div class="panel-body">
                                <strong>Donec quam felis</strong>
                                <p>Thousand unknown plants are noticed by me: when I hear the buzz of the little world among
                                    the stalks, and grow familiar with the countless indescribable forms of the insects
                                    and flies, then I feel the presence of the Almighty, who formed us in his own image, and
                                    the breath </p>
                                <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss
                                    of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite
                                    sense of mere tranquil existence, that I neglect my talents. I should be incapable of
                                    drawing a single stroke at the present moment; and yet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .nav.nav-tabs {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            flex-wrap: nowrap;
        }
    </style>
    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            table = $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
        });
    </script>
@endsection
