<!-- Primer Círculo -->
<div class="col-lg-3 col-md-6 col-sm-12">
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
<div class="col-lg-3 col-md-6 col-sm-12">
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
<!-- Tercer Círculo -->
<div class="col-lg-3 col-md-6 col-sm-12">
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
<div class="col-lg-3 col-md-6 col-sm-12">
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <div
            style="border: 2px solid blue; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
            <i class="fa fa-user-o" style="font-size: 50px; color: black;"></i>
        </div>
        <h4 style="font-weight: bold; margin-top: 15px;">Clientes</h4>
        <p style="margin: 5px 0;">5 Clientes</p>
    </div>
</div>
