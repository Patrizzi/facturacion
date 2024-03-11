{{-- COTIZACIONES --}}
@if (isset($cotizacion))
    <div class="row" style="align-items: flex-end;">
        @if ($cotizacion->user_personal->nombre != null)
            <div class="col-sm-3">
                <p><u><strong>Atendido por:</strong></u></p>
                <span><strong>Teléfono:</strong> {{ $empresa->telefono }}</span><br>
                <span><strong>Celular:</strong> {{ $cotizacion->user_personal->celular }}</span><br>
                <span><strong>Email:</strong> {{ $cotizacion->user_personal->email_user }}</span><br>
                <span><strong>Web:</strong> {{ $empresa->pagina_web }}</span><br>
            </div>
            <div class="col-sm-6">
            </div>
            <div class="col-sm-3">
                @if ($cotizacion->user_personal->config->cotizacion_firma == 0)
                    @if (!empty($firma))
                        <center><img src="{{ asset('archivos/imagenes/firma_digital/' . $firma) }}" style=""
                                width="150px" height="100px"></center>
                    @endif
                    <hr>
                    <center>{{ $cotizacion->user_personal->nombre }}</center>
                @endif
            </div>
        @else
            <div class="col-sm-3">
                <p><u><strong>Atendido por:</strong></u></p>
                <span><strong>Teléfono:</strong> {{ $empresa->telefono }}</span><br>
                <span><strong>Celular:</strong> {{ $cotizacion->user_personal->personal->celular }}</span><br>
                <span><strong>Email:</strong> {{ $cotizacion->user_personal->personal->email }}</span><br>
                <span><strong>Web:</strong> {{ $empresa->pagina_web }}</span><br>
            </div>
            <div class="col-sm-6">
            </div>
            <div class="col-sm-3">
                @if ($cotizacion->user_personal->config->cotizacion_firma == 0)
                    @if (!empty($firma))
                        <center><img src="{{ asset('archivos/imagenes/firma_digital/' . $firma) }}" style=""
                                width="150px" height="100px"></center>
                    @endif
                    <hr>
                    <center>{{ $cotizacion->user_personal->personal->nombres }}
                        {{ $cotizacion->user_personal->personal->apellidos }}</center>
                @endif
            </div>
        @endif
    </div>
@endif
{{-- NOTA DE VENTA --}}
@if (isset($nota_venta))
    <div class="row" style="align-items: flex-end;">
        @if ($nota_venta->user->nombre != null)
            <div class="col-sm-3">
                <p><u><strong>Atendido por:</strong></u></p>
                <span><strong>Teléfono:</strong> {{ $empresa->telefono }}</span><br>
                <span><strong>Celular:</strong> {{ $nota_venta->user->celular }}</span><br>
                <span><strong>Email:</strong> {{ $nota_venta->user->email_user }}</span><br>
                <span><strong>Web:</strong> {{ $empresa->pagina_web }}</span><br>
            </div>
            <div class="col-sm-6">
            </div>
            <div class="col-sm-3">
                @if ($nota_venta->user->config->nventa_firma == 0)
                    @if (!empty($firma))
                        <center><img src="{{ asset('archivos/imagenes/firma_digital/' . $firma) }}" style=""
                                width="150px" height="100px"></center>
                    @endif
                    <hr>
                    <center>{{ $nota_venta->user->nombre }}</center>
                @endif
            </div>
        @else
            <div class="col-sm-3">
                <p><u><strong>Atendido por:</strong></u></p>
                <span><strong>Teléfono:</strong> {{ $empresa->telefono }}</span><br>
                <span><strong>Celular:</strong> {{ $nota_venta->user->personal->celular }}</span><br>
                <span><strong>Email:</strong> {{ $nota_venta->user->personal->email }}</span><br>
                <span><strong>Web:</strong> {{ $empresa->pagina_web }}</span><br>
            </div>
            <div class="col-sm-6">
            </div>
            <div class="col-sm-3">
                @if ($nota_venta->user->config->nventa_firma == 0)
                    @if (!empty($firma))
                        <center><img src="{{ asset('archivos/imagenes/firma_digital/' . $firma) }}" style=""
                                width="150px" height="100px"></center>
                    @endif
                    <hr>
                    <center>{{ $nota_venta->user->personal->nombres }}
                        {{ $nota_venta->user->personal->apellidos }}</center>
                @endif
            </div>
        @endif
    </div>
@endif