<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                <div class="ibox-tools custom">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row" style="justify-content: center">
                    {{-- @include('transaccion.comprobantes._shared.statistics') --}}
                </div>
            </div>
        </div>
    </div>
</div>
