<div class="ibox">
    <div class="ibox-title" style="display: flex; align-items: center;">
        <span><strong>RESUMEN DE {{ strtoupper(strftime('%B')) }} DEL {{ strtoupper(strftime('%Y')) }}</strong></span>
    </div>
    <div class="ibox-content">
        <div class="card-group">
            <div class="card p-3" style="border: none;">
                <div class="d-flex justify-content-center align-items-center card-img-top">
                    <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 80px; height: 80px; font-size: 2.5rem;">
                        <i class="fa fa-envelope-open text-white"></i>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title" style="font-size: 18px">Facturas</h5>
                    <p class="card-text" style="font-size: 14px">{{ $resumen_mes['facturas'] }} Documentos</p>
                    <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Ultima actualización
                            {{ $resumen_mes['factura_last_update'] }}</small></p>
                </div>
            </div>
            <div class="card p-3" style="border: none;">
                <div class="d-flex justify-content-center align-items-center card-img-top">
                    <div class="bg-success rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 80px; height: 80px; font-size: 2.5rem;">
                        <i class="fa fa-file-archive-o text-white"></i>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title" style="font-size: 18px">Facturación Manual</h5>
                    <p class="card-text" style="font-size: 14px">{{ $resumen_mes['factura_m'] }} Documentos</p>
                    <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Ultima actualización
                            {{ $resumen_mes['factura_m_last_update'] }}</small></p>
                </div>
            </div>
            <div class="card p-3" style="border: none;">
                <div class="d-flex justify-content-center align-items-center card-img-top">
                    <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 80px; height: 80px; font-size: 3rem;">
                        <i class="fa fa-joomla text-white"></i>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title" style="font-size: 18px">Detracciones</h5>
                    <p class="card-text" style="font-size: 14px">{{ $resumen_mes['detracciones'] }} Documentos</p>
                    <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Ultima actualización
                            {{ $resumen_mes['d_last_update'] }}</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
