
<div class="wrapper wrapper-content animated fadeInRight pb-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title" style="display: flex; align-items: center;">
                    <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                </div>

                <div class="ibox-content">
                    {{-- Acá iria el tema del contenido --}}
                    <div class="card-group">
                        <div class="card p-3" style="border: none;">
                            <div class="d-flex justify-content-center align-items-center card-img-top">
                                <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 3rem;">
                                    <i class="bi bi-cloud-arrow-down-fill text-white"></i>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title" style="font-size: 18px">Guía de Ingreso</h5>
                                <p class="card-text" style="font-size: 14px">{{$count_mounth['g_ingreso_month_count']}} Documentos</p>
                                <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Ultima actualización: <strong>{{$count_mounth['g_ingreso_last_update']}}</strong></small></p>
                            </div>
                        </div>
                        <div class="card p-3" style="border: none;">
                            <div class="d-flex justify-content-center align-items-center card-img-top">
                                <div class="bg-success rounded-circle d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 3rem;">
                                    <i class="bi bi-cloud-check-fill text-white"></i>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title" style="font-size: 18px">Guía de Egreso</h5>
                                <p class="card-text" style="font-size: 14px">{{$count_mounth['g_egreso_month_count']}} Documentos</p>
                                <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Ultima actualización: <strong>{{$count_mounth['g_egreso_last_update']}}</strong></small></p>
                            </div>
                        </div>
                        <div class="card p-3" style="border: none;">
                            <div class="d-flex justify-content-center align-items-center card-img-top">
                                <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 3rem;">
                                    <i class="bi bi-clipboard2-data-fill text-white"></i>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title" style="font-size: 18px">Guía de Informe Técnico</h5>
                                <p class="card-text" style="font-size: 14px">{{$count_mounth['i_tecnico_month_count']}} Documentos</p>
                                <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Ultima actualización: <strong>{{$count_mounth['i_tecnico_last_update']}}</strong></small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
