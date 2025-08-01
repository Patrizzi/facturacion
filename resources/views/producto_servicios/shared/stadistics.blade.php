<div class="col-6 pie-md">
    <div class="d-flex align-items-center justify-content-center">
        <div id="pie"></div><!--Azul, plomo y blanco-->
    </div>
    <br>
    <a href="{{ route('productos.index') }}">
        <h4 class="text-center">Productos: {{ $p_statics['total'] }}</h4>
    </a>
    {{-- <p class="text-danger"><b>Total</b></p> --}}
</div>

<div class="col-6 pie-md">
    {{-- <div class="d-flex align-items-center justify-content-center">
                                <div id="pie2"></div>
                            </div>
                            <br>
                            <a href="#">
                                <h4>Servicios:  {{$s_statics['total']}}</h4>
                            </a> --}}
    {{-- <p class="text-danger"><b>Total</b></p> --}}
</div>
