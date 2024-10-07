<!-- Primer Círculo -->
<div class="col-md-3">
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <div
            style="border: 2px solid green; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
            <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
        </div>
        <h4 style="font-weight: bold; margin-top: 15px;">Cotización</h4>
        <p style="margin: 5px 0;">{{ $cotizacion_mes['cantidad'] }} Documentos</p>
        <p style="color: green; font-weight: bold;">S/. {{ $cotizacion_mes['total'] }}</p>
    </div>
</div>
<!-- Segundo Círculo -->
<div class="col-md-3">
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <div
            style="border: 2px solid orange; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
            <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
        </div>
        <h4 style="font-weight: bold; margin-top: 15px;">Cotización Manual</h4>
        <p style="margin: 5px 0;">{{ $cotizacionM_mes['cantidad'] }} Documentos</p>
        <p style="color: orange; font-weight: bold;">S/. {{ $cotizacionM_mes['total'] }}</p>
    </div>
</div>
<!-- Tercer Círculo -->
<div class="col-md-3">
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <div
            style="border: 2px solid red; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
            <i class="fa fa-file-o" style="font-size: 50px; color: black;"></i>
        </div>
        <h4 style="font-weight: bold; margin-top: 15px;">Nota de Venta</h4>
        <p style="margin: 5px 0;">{{ $nota_venta_mes['cantidad'] }} Documentos</p>
        <p style="color: red; font-weight: bold;">S/. {{ $nota_venta_mes['total'] }}</p>
    </div>
</div>
<!-- Cuarto Círculo -->
<div class="col-md-3">
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <div
            style="border: 2px solid blue; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
            <i class="fa fa-user-o" style="font-size: 50px; color: black;"></i>
        </div>
        <h4 style="font-weight: bold; margin-top: 15px;">Clientes</h4>
        <p style="margin: 5px 0;">5 Clientes</p>
    </div>
</div>
