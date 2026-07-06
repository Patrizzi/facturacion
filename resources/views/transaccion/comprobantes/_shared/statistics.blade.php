@canany(['boleta.listar','boleta_m.listar'])
    <!-- Primer Círculo -->
    @php $activeSet = false; @endphp
    <div class="col-lg-3 col-md-6 col-sm-6 slick_demo_1">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @can('boleta.listar')
                    <div class="carousel-item {{ !$activeSet ? 'active' : '' }}">
                        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                            <div
                                style="border: 2px solid green; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
                            </div>
                            <h4 style="font-weight: bold; margin-top: 15px;">Boleta</h4>
                            <p style="margin: 5px 0;">{{$count_month_comprobantes['boleta_month_count']['cantidad'] }} Documentos</p>
                            <p style="color: green; font-weight: bold;">{{$count_month_comprobantes['boleta_month_count']['total'] }}</p>
                        </div>
                    </div>
                    @php $activeSet = true; @endphp
                @endcan
                @can('boleta_m.listar')
                    <div class="carousel-item {{ !$activeSet ? 'active' : '' }}">
                        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                            <div
                                style="border: 2px solid green; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
                            </div>
                            <h4 style="font-weight: bold; margin-top: 15px;">Boleta Manual</h4>
                            <p style="margin: 5px 0;">{{$count_month_comprobantes['boleta_m_month_count']['cantidad'] }} Documentos</p>
                            <p style="color: green; font-weight: bold;">{{$count_month_comprobantes['boleta_m_month_count']['total'] }}</p>
                        </div>
                    </div>
                    @php $activeSet = true; @endphp
                @endcan
            </div>
            @can('boleta.listar')
                @can('boleta_m.listar')
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                @endcan
            @endcan
            </a>
        </div>
    </div>
@endcan
@canany(['factura.listar','factura_m.listar'])
    @php $activeSet = false; @endphp
    <!-- Segundo Círculo -->
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div id="carouselExampleControls2" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @can('factura.listar')
                    <div class="carousel-item {{ !$activeSet ? 'active' : '' }}">
                        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                            <div
                                style="border: 2px solid orange; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
                            </div>
                            <h4 style="font-weight: bold; margin-top: 15px;">Factura</h4>
                            <p style="margin: 5px 0;">{{$count_month_comprobantes['factura_month_count']['cantidad'] }} Documentos</p>
                            <p style="color: orange; font-weight: bold;">{{$count_month_comprobantes['factura_month_count']['total'] }}</p>
                        </div>
                    </div>
                    @php $activeSet = true; @endphp
                @endcan
                @can('factura_m.listar')
                    <div class="carousel-item {{ !$activeSet ? 'active' : '' }}">
                        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                            <div
                                style="border: 2px solid orange; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
                            </div>
                            <h4 style="font-weight: bold; margin-top: 15px;">Factura Manual</h4>
                            <p style="margin: 5px 0;">{{$count_month_comprobantes['factura_m_month_count']['cantidad'] }} Documentos</p>
                            <p style="color: orange; font-weight: bold;">{{$count_month_comprobantes['factura_m_month_count']['total'] }}</p>
                        </div>
                    </div>
                    @php $activeSet = true; @endphp
                @endcan
            </div>
            @can('factura.listar')
                @can('factura_m.listar')
                    <a class="carousel-control-prev" href="#carouselExampleControls2" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls2" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                @endcan
            @endcan
            </a>
        </div>
    </div>
@endcan
@canany(['nota_credito.listar','nota_debito.listar'])
    @php $activeSet = false; @endphp
    <!-- Tercer Círculo -->
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div id="carouselExampleControls3" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @can('nota_credito.listar')
                    <div class="carousel-item {{ !$activeSet ? 'active' : '' }}">
                        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                            <div
                                style="border: 2px solid red; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                <i class="fa fa-file-o" style="font-size: 50px; color: black;"></i>
                            </div>
                            <h4 style="font-weight: bold; margin-top: 15px;">Notas Crédito</h4>
                            <p style="margin: 5px 0;">{{$count_month_comprobantes['nota_credito_month_count']['cantidad'] }} Documentos</p>
                            <p>&nbsp;</p>
                            {{-- <p style="color: red; font-weight: bold;">{{$count_month_comprobantes['nota_credito_month_count']['total'] }}</p> --}}
                        </div>
                    </div>
                    @php $activeSet = true; @endphp
                @endcan
                @can('nota_debito.listar')
                    <div class="carousel-item {{ !$activeSet ? 'active' : '' }}">
                        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                            <div
                                style="border: 2px solid red; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                <i class="fa fa-file-o" style="font-size: 50px; color: black;"></i>
                            </div>
                            <h4 style="font-weight: bold; margin-top: 15px;">Notas Débito</h4>
                            <p style="margin: 5px 0;">{{$count_month_comprobantes['nota_debito_month_count']['cantidad'] }}  Documentos</p>
                            <p>&nbsp;</p>
                            {{-- <p style="color: red; font-weight: bold;">{{$count_month_comprobantes['nota_debito_month_count']['total'] }}</p> --}}
                        </div>
                    </div>
                    @php $activeSet = true; @endphp
                @endcan
            </div>
            @can('nota_credito.listar')
                @can('nota_debito.listar')
                    <a class="carousel-control-prev" href="#carouselExampleControls3" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls3" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                @endcan
            @endcan
        </div>

    </div>
@endcan
@canany(['guia_remision.listar','guia_remision_m.listar'])
    @php $activeSet = false; @endphp
    <!-- Cuarto Círculo -->
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div id="carouselExampleControls4" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @can('guia_remision.listar')
                    <div class="carousel-item {{ !$activeSet ? 'active' : '' }}">
                        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                            <div
                                style="border: 2px solid blue; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                <i class="fa fa-user-o" style="font-size: 50px; color: black;"></i>
                            </div>
                            <h4 style="font-weight: bold; margin-top: 15px;">Guia Remisión</h4>
                            <p style="margin: 5px 0;">{{$count_month_comprobantes['guia_remision_month_count']['cantidad'] }} Documentos</p>
                            {{-- <p style="font-weight: bold;">{{$cli0_tot = $count_month_comprobantes['guia_remisionM_month_count']['clientes'] }} @if($cli0_tot == 1) Cliente @else  Clientes @endif</p> --}}
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    @php $activeSet = true; @endphp
                @endcan
                @can('guia_remision_m.listar')
                    <div class="carousel-item {{ !$activeSet ? 'active' : '' }}">
                        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                            <div
                                style="border: 2px solid blue; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                <i class="fa fa-user-o" style="font-size: 50px; color: black;"></i>
                            </div>
                            <h4 style="font-weight: bold; margin-top: 15px;">Guia Remisión Manual</h4>
                            <p style="margin: 5px 0;">{{$count_month_comprobantes['guia_remisionM_month_count']['cantidad'] }} Documentos</p>
                            {{-- <p style="font-weight: bold;">{{$cli_tot = $count_month_comprobantes['guia_remisionM_month_count']['clientes'] }} @if($cli_tot == 1) Cliente @else  Clientes @endif</p> --}}
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    @php $activeSet = true; @endphp
                @endcan
            </div>
            @can('guia_remision.listar')
                @can('guia_remision_m.listar')
                    <a class="carousel-control-prev" href="#carouselExampleControls4" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls4" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                @endcan
            @endcan
            </a>
        </div>
    </div>
@endcan
<style>
.carousel-control-next-icon, .carousel-control-prev-icon{
    background-color: #2f4050;
    border-radius: 50%;
    /* padding: 5px; */
}
</style>
