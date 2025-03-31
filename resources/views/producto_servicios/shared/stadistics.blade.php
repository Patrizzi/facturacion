<div class="wrapper wrapper-content animated fadeInRight pb-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">

                <div class="ibox-content align-content-center">
                    <div class="row d-flex justify-content-around text-center">

                        <div class="col-6 pie-md">
                            <div class="d-flex align-items-center justify-content-center">
                                <div id="pie"></div><!--Azul, plomo y blanco-->
                            </div>
                            <br>
                            <a href="{{ route('productos.index') }}">
                                <h4>Productos:</h4>
                            </a>
                            {{-- <p class="text-danger"><b>Total</b></p> --}}
                        </div>

                        <div class="col-6 pie-md">
                            <div class="d-flex align-items-center justify-content-center">
                                <div id="pie2"></div>
                            </div>
                            <br>
                            <a href="#">
                                <h4>Servicios:  {{$statics['total']}}</h4>
                            </a>
                            {{-- <p class="text-danger"><b>Total</b></p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
