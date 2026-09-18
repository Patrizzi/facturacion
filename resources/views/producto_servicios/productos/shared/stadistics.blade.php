<div class="col-4 pie-md">
    <div class="d-flex align-items-center justify-content-center">
        <div id="pie"></div><!--Azul, plomo y blanco-->
    </div>
    <br>
    <a href="{{ route('productos.index') }}">
        <h4 class="text-center">Productos: {{ $p_statics['total'] }}</h4>
    </a>
    {{-- <p class="text-danger"><b>Total</b></p> --}}
</div>

<div class="col-8" id="mi_grafico" style="width: 6%; height: 200px;">
    <div class="d-flex align-items-center justify-content-center">
        <div id="flot-bar-chart" style="width: 100%; height: 300px;">
            <div class="flot-chart-content" id="flot-producto"></div>
            <br>
            <h4 class="text-center">Macas con más productos</h4>
        </div>
    </div>
    <br>
</div>
