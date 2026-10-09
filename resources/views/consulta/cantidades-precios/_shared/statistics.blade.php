{{-- <div class="wrapper wrapper-content animated fadeInRight pb-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                </div>
                <div class="ibox-content">
                    <div class="row pt-3 d-flex justify-content-around align-content-center text-center">
                        <div class="">
                            <div style="width: 50%">
                                 <div id="pie"></div>
                            </div>
                            <br><br>
                            <h4 class="text-danger">Productos: 34</h4>
                            <p>Stock mín: 10<br>Stock máx: 3</p>
                        </div>
                        <div class="">
                            <div><span id="sparkline6"></span></div>
                            <br><br>
                            <h4 class="text-warning">Servicios: 27</h4>
                            <p>Activos: 23<br>Inactivos: 4</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="wrapper wrapper-content animated fadeInRight pb-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-6 pie-md">
                            <div class="d-flex align-items-center justify-content-center">
                                <div id="pie"></div><!--Azul, plomo y blanco-->
                            </div>
                            <br>
                            <a href="{{route('cantidad_precio.index')}}">
                                <h4 class="text-center">Productos: {{ $p_statics['total'] }}</h4>
                            </a>
                            {{-- <p class="text-danger"><b>Total</b></p> --}}
                        </div>

                        <div class="col-6" id="mi_grafico" style="width: 6%; height: 200px;">
                            <div class="d-flex align-items-center justify-content-center">
                                <div id="pie2"></div><!--Azul, plomo y blanco-->
                            </div>
                            <br>
                            <a href="{{route('cantidad_precio.index_servicio')}}">
                                <h4 class="text-center">Servicios: {{ $s_statics['total'] }}</h4>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
