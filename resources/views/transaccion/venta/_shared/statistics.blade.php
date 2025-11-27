<!-- Primer Círculo -->
<div class="col-lg-3 col-md-6 col-sm-6">
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <div
            style="border: 2px solid green; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
            <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
        </div>
        <h4 style="font-weight: bold; margin-top: 15px;">Cotización</h4>
        <p style="margin: 5px 0;">{{ $count_month_ventas['cotizacion_month_count']['cantidad'] }} Documentos</p>
        <p style="color: green; font-weight: bold;">{{ $count_month_ventas['cotizacion_month_count']['total'] }}</p>
    </div>
</div>
<!-- Segundo Círculo -->
{{--<div class="col-lg-3 col-md-6 col-sm-6">
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <div
            style="border: 2px solid orange; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
            <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
        </div>
        <h4 style="font-weight: bold; margin-top: 15px;">Cotización Manual</h4>
        <p style="margin: 5px 0;">{{ $count_month_ventas['cotizacion_m_month_count']['cantidad'] }} Documentos</p>
        <p style="color: orange; font-weight: bold;">{{ $count_month_ventas['cotizacion_m_month_count']['total'] }}</p>
    </div>
</div>--}}

<div class="col-lg-3 col-md-6 col-sm-6 slick_demo_1">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                    <div
                        style="border: 2px solid orange; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                        <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
                    </div>
                    <h4 style="font-weight: bold; margin-top: 15px;">Cotización Manual</h4>
                    <p style="margin: 5px 0;">{{ $count_month_ventas['cotizacion_m_month_count']['cantidad'] }} Documentos</p>
                    <p style="color: orange; font-weight: bold;">{{ $count_month_ventas['cotizacion_m_month_count']['total'] }}</p>
                </div>
            </div>
            <div class="carousel-item">
                <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                    <div
                        style="border: 2px solid gray; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                        <i class="fa fa-refresh" style="font-size: 50px; color: black;"></i>
                    </div>
                    <h4 style="font-weight: bold; margin-top: 15px;">Renovación</h4>
                    <p style="margin: 5px 0;">{{ $count_month_ventas['renovacion_month_count']['cantidad'] ?? 0 }} Documentos</p>
                    <p style="color: gray; font-weight: bold;">{{ $count_month_ventas['renovacion_month_count']['total'] ?? 'S/ 0.00' }}</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<!-- Tercer Círculo -->
<div class="col-lg-3 col-md-6 col-sm-6">
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <div
            style="border: 2px solid red; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
            <i class="fa fa-file-o" style="font-size: 50px; color: black;"></i>
        </div>
        <h4 style="font-weight: bold; margin-top: 15px;">Nota de Venta</h4>
        <p style="margin: 5px 0;">{{ $count_month_ventas['nota_venta_month_count']['cantidad'] }} Documentos</p>
        <p style="color: red; font-weight: bold;">{{ $count_month_ventas['nota_venta_month_count']['total'] }}</p>
    </div>
</div>
<!-- Cuarto Círculo -->
<div class="col-lg-3 col-md-6 col-sm-6">
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <div
            style="border: 2px solid blue; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
            <i class="fa fa-user-o" style="font-size: 50px; color: black;"></i>
        </div>
        <h4 style="font-weight: bold; margin-top: 15px;">Clientes</h4>
        <p style="margin: 5px 0;">{{ $count_month_ventas['clientes_month_count'] }} @if($count_month_ventas['clientes_month_count'] == 1) Cliente @else Clientes @endif</p>
    </div>
</div>+

<style>
.carousel-control-next-icon, .carousel-control-prev-icon{
    background-color: #2f4050;
    border-radius: 50%;
    /* padding: 5px; */
}
</style>
