@if (isset($typeChange->fecha))
    <div class="navbar navbar-expand-lg text-center justify-content-between" style="width: 15rem;">
        <div>
            <h4>Compras</h4>
            <h5>{{ $buys }}</h5>
        </div>
        <div>
            <h4>Ventas</h4>
            <h5>{{ $sale }}</h5>
        </div>
        <div>
            <h4>Paralelo</h4>
            <h5>{{ $parallel }}</h5>
        </div>
    </div>
@endif
