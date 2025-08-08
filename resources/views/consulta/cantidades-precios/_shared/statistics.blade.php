<div class="wrapper wrapper-content animated fadeInRight pb-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                </div>
                <div class="ibox-content">
                    <div class="row pt-3 d-flex justify-content-around align-content-center text-center">
                        <div class="col-auto">
                            <div><span id="sparkline5"></span></div>
                            <br><br>
                            <h4 class="text-danger">Productos: 34</h4>
                            <p>Stock mín: 10<br>Stock máx: 3</p>
                        </div>
                        <div class="col-auto">
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
</div>
