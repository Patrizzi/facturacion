{{-- COTIZACIONES --}}
@if (isset($cotizacion))
    <div class="">
        <table>
            <tr>
                @if ($cotizacion->user_personal->nombre != null)
                    <td style="border: none">
                        <p><u><strong>Atendido por:</strong></u></p>
                        @if($empresa->telefono != "0") <span><strong>Teléfono:</strong> {{ $empresa->telefono }}</span><br> @endif
                        <span><strong>Celular:</strong> {{ $cotizacion->user_personal->celular }}</span><br>
                        <span><strong>Email:</strong> {{ $cotizacion->user_personal->email_user }}</span><br>
                        <span><strong>Web:</strong> {{ $empresa->pagina_web }}</span><br>
                    </td>
                    <td style="border: none">
                        <br>
                        <br>
                        <br>
                        <br>
                        @if ($cotizacion->user_personal->config->cotizacion_firma == 0)
                            @if (!empty($firma))
                                <center><img src="{{ asset('archivos/imagenes/firma_digital/' . $firma) }}" style=""
                                        width="150px" height="100px"></center>
                            @endif
                            <hr style="width: 60%;">
                            <center>{{ $cotizacion->user_personal->nombre }}</center>
                        @endif
                    </td>
                @else
                    <td style="border: none">
                        <p><u><strong>Atendido por:</strong></u></p>
                        @if($empresa->telefono != "0") <span><strong>Teléfono:</strong> {{ $empresa->telefono }}</span><br> @endif
                        <span><strong>Celular:</strong> {{ $cotizacion->user_personal->personal->celular }}</span><br>
                        <span><strong>Email:</strong> {{ $cotizacion->user_personal->personal->email }}</span><br>
                        <span><strong>Web:</strong> {{ $empresa->pagina_web }}</span><br>
                    </td>
                    <td style="border: none">
                        <br>
                        <br>
                        <br>
                        <br>
                        @if ($cotizacion->user_personal->config->cotizacion_firma == 0)
                            @if (!empty($firma))
                                <center><img src="{{ asset('archivos/imagenes/firma_digital/' . $firma) }}" style=""
                                        width="150px" height="100px"></center>
                            @endif
                            <hr style="width: 60%;">
                            <center>{{ $cotizacion->user_personal->personal->nombres }}
                                {{ $cotizacion->user_personal->personal->apellidos }}</center>
                        @endif
                    </td>
                @endif
            </tr>
        </table>
    </div>
@endif
{{-- NOTA VENTA --}}
@if (isset($nota_venta))
    <div class="">
        <table>
            <tr>
                @if ($nota_venta->user->nombre != null)
                    <td style="border: none">
                        <p><u><strong>Atendido por:</strong></u></p>
                        <span><strong>Teléfono:</strong> {{ $empresa->telefono }}</span><br>
                        <span><strong>Celular:</strong> {{ $nota_venta->user->celular }}</span><br>
                        <span><strong>Email:</strong> {{ $nota_venta->user->email_user }}</span><br>
                        <span><strong>Web:</strong> {{ $empresa->pagina_web }}</span><br>
                    </td>
                    <td style="border: none">
                        <br>
                        <br>
                        <br>
                        <br>
                        @if ($nota_venta->user->config->nventa_firma == 0)
                            @if (!empty($firma))
                                <center><img src="{{ asset('archivos/imagenes/firma_digital/' . $firma) }}" style=""
                                        width="150px" height="100px"></center>
                            @endif
                            <hr style="width: 60%;">
                            <center>{{ $nota_venta->user->nombre }}</center>
                        @endif
                    </td>
                @else
                    <td style="border: none">
                        <p><u><strong>Atendido por:</strong></u></p>
                        <span><strong>Teléfono:</strong> {{ $empresa->telefono }}</span><br>
                        <span><strong>Celular:</strong> {{ $nota_venta->user->personal->celular }}</span><br>
                        <span><strong>Email:</strong> {{ $nota_venta->user->personal->email }}</span><br>
                        <span><strong>Web:</strong> {{ $empresa->pagina_web }}</span><br>
                    </td>
                    <td style="border: none">
                        <br>
                        <br>
                        <br>
                        <br>
                        @if ($nota_venta->user->config->nventa_firma == 0)
                            @if (!empty($firma))
                                <center><img src="{{ asset('archivos/imagenes/firma_digital/' . $firma) }}" style=""
                                        width="150px" height="100px"></center>
                            @endif
                            <hr style="width: 60%;">
                            <center>{{ $nota_venta->user->personal->nombres }}
                                {{ $nota_venta->user->personal->apellidos }}</center>
                        @endif
                    </td>
                @endif
            </tr>
        </table>
    </div>
@endif
