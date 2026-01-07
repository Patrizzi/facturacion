<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class NotaVenta extends Model
{
    protected $table = 'nota_venta';

    protected $guarded = [];

    protected $appends = ['estado_pago_text','total_precio','total_precio_sin_forma'];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_registrado');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function forma_pago()
    {
        return $this->belongsTo(Forma_pago::class, 'forma_pago');
    }
    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }

    public function notaventa_registros()
    {
        return $this->hasMany(NotaVentaRegistro::class, 'nota_venta_id');
    }

    public function getFechaEmisionAttribute(){
        $new_emision = Carbon::parse($this->attributes['fecha_emision'])->format('d-m-Y');
        return $new_emision;
    }

    public function getFormaPagoAttribute(){
        $forma_pago = Forma_pago::find($this->attributes['forma_pago']);
        return $forma_pago->nombre;

    }

    public function total_nota_venta(){
        $nota_venta = NotaVenta::find($this->attributes['id']);
        $nota_registros = NotaVentaRegistro::where('nota_venta_id', $nota_venta->id)->get();
        $precio_tot = 0;
        foreach ($nota_registros as $n_reg) {
            $precio_tot += round($n_reg->cantidad * $n_reg->precio_nacional, 2);
        }
        return $precio_tot;
    }
    public function getTotalPrecioAttribute(){
        // $nota_venta = NotaVenta::find($this->attributes['id']);
        $nota_registros = $this->notaventa_registros;
        $precio_tot = 0;
        foreach ($nota_registros as $n_reg) {
            $precio_tot += round($n_reg->cantidad * $n_reg->precio_nacional, 2);
        }
        return $this->moneda->simbolo.' '.number_format(round($precio_tot, 2), 2);
    }
    public function getTotalPrecioSinFormaAttribute(){
        // $nota_venta = NotaVenta::find($this->attributes['id']);
        $nota_registros = $this->notaventa_registros;
        $precio_tot = 0;
        foreach ($nota_registros as $n_reg) {
            $precio_tot += round($n_reg->cantidad * $n_reg->precio_nacional, 2);
        }
        return $precio_tot;
    }

    public function getEstadoPagoTextAttribute()
    {
        return match ($this->estado_pago) {
            0 => "Sin pago",
            1 => "Pago Parcial",
            2 => "Pago Total",
            default => "Desconocido",
        };
    }

    public function getSaldoPendienteAttribute()
    {
        // return $this->forma_pago_id;
        $suma_cuota = $this->total_precio_sin_forma;
        if ($this->estado_pago == 0) {
            $saldo_pendiente = $this->moneda->simbolo . '' . number_format($suma_cuota, 2);
        } else {
            // Sumatoria para los pagos
            $totalPagado = ComprobantesPagos::where('nota_venta_id', $this->id)
                ->sum('monto_pago');
            $saldo_pendiente = $this->moneda->simbolo . '' . number_format(max(0, $this->total_precio - $totalPagado), 2);
            // $saldo_pendiente = 0;
        }

        // $last_stand = $this->moneda->simbolo.''.$saldo_pendiente;
        return $saldo_pendiente;
    }
    public function getSaldoPendienteSecAttribute()
    {
        $moneda_principal = Moneda::where('principal', '1')->first();
        $moneda_sec = Moneda::where('principal', '!=', '1')->first();
        $tipo_cambio_emision = TipoCambio::where('fecha', $this->fecha_emision)->first();
        $tipo_cambio_hoy = TipoCambio::latest()->first();
        $tipo_cambio = $tipo_cambio_emision->paralelo ?? $tipo_cambio_hoy->paralelo;
        
        // return $this->forma_pago_id;
        $suma_cuota = $this->total_precio_sin_forma;
        if ($this->estado_pago == 0) {
            if($moneda_principal->simbolo == "$"){ //Si es dolar
                // transformar a sol
                $monto_convertido = $suma_cuota * $tipo_cambio;
                $saldo_pendiente = $moneda_sec->simbolo . '' .number_format($monto_convertido, 2);
            }else{
                // Sumatoria para los pagos
                $totalPagado = ComprobantesPagos::where('nota_venta_id', $this->id)
                    ->sum('monto_pago');
                $total_pag_convertido = $totalPagado / $tipo_cambio;
                $total_convertido = $suma_cuota / $tipo_cambio;
                $saldo_pendiente = $moneda_sec->simbolo . '' . number_format(max(0, $total_convertido - $total_pag_convertido), 2);
                // $saldo_pendiente = 0;       
            }
        }else{
            // transformar a dolar
        }
            

        // $last_stand = $this->moneda->simbolo.''.$saldo_pendiente;
        return $saldo_pendiente;
    }
    
    public static function monto_pagado_convertido($id_nota_venta, $moneda_pago, $tipo_cambio)
    {
        $comprobanteIds = ComprobantesPagos::where('nota_venta_id', $id_nota_venta)->pluck('id');
        $detalles = ComprobantesPagosDetalle::whereIn( 'comprobante_pago_id', $comprobanteIds )->get();

        $moneda_comprobante = Moneda::find($moneda_pago);
        $moneda_no_comprobante = Moneda::where('id', '!=', $moneda_comprobante->id)->first();
        $restante = [
            'prin' => 0,
            'sec' => 0,
            'simbolo' => '',
            'simbolo_2' => '',
        ];
        // if(){}
        foreach ($detalles as $det) {
            $moneda_detalle = $det->moneda_id ?? $moneda_comprobante->id;
            $restante["simbolo"] = $moneda_comprobante->simbolo;
            $restante["simbolo_2"] = $moneda_no_comprobante->simbolo;
            // Si la moneda es igual al del comprobante
            if ($moneda_comprobante->id == $moneda_detalle) {
                $restante["prin"] += $det->comprobante_pago_registros->monto_pago;
            } else {
                if ($det->moneda->simbolo == "$") { //Si es dolar conversion de sol a dolar
                    $restante["sec"] += round($det->comprobante_pago_registros->monto_pago / $det->tipo_cambio, 2);
                } else {
                    $restante["sec"] += round($det->comprobante_pago_registros->monto_pago * $det->tipo_cambio, 2);
                }
            }
        }
        // dd($restante);
        // Colocar el simbolo y formato
        $no_moneda = Moneda::where('id', '!=', $moneda_comprobante->id)->first();
        $data = [
            "prin" => (trim($restante['simbolo'] ?? '') ? $restante["simbolo"] : $moneda_comprobante->simbolo) . ' ' . number_format($restante["prin"] ?? 0, 2),
            "sec" => (trim($restante['simbolo_2'] ?? '') ? $restante["simbolo_2"] : $no_moneda->simbolo) . ' ' . number_format($restante["sec"] ?? 0, 2)
        ];

        return $data;
    }

    public static function restante_pago_convertido_cuota($id_comprobante, $moneda_pago)
    {
        $nota_venta = NotaVenta::find($id_comprobante);
        $monedaBase = Moneda::findOrFail($moneda_pago);
        $comprobanteIds = ComprobantesPagos::where('nota_venta_id', $id_comprobante)->pluck('id');
        $detalles = ComprobantesPagosDetalle::whereIn( 'comprobante_pago_id', $comprobanteIds )->get();
        $totalPagado = 0.0;

        foreach ($detalles as $det) {
            $monto = $det->comprobante_pago_registros->monto_pago;
            // dd($monto);
            if ($det->moneda_id == $monedaBase->id) {
                $totalPagado += $monto;
                continue;
            }
            if (!$det->tipo_cambio || $det->tipo_cambio <= 0) {
                continue;
            }
            if (($monedaBase->simbolo === '$' && $det->moneda->simbolo === 'S/') || ($monedaBase->simbolo !== '$' && $det->moneda->simbolo !== 'S/')) {
                $totalPagado += round($monto * $det->tipo_cambio, 2);
            } else {
                $totalPagado += round($monto / $det->tipo_cambio, 2);
            }
        }
        $saldoPendiente = round($nota_venta->total_precio_sin_forma - $totalPagado, 2);

        return [
            'total_cuota'     => round($nota_venta->total_precio_sin_forma, 2),
            'total_pagado'    => round($totalPagado, 2),
            'saldo_pendiente' => max($saldoPendiente, 0),
            'moneda'          => $monedaBase->simbolo,
        ];
    }

    public static function count_mes($fecha)
    {
        // CANTIDAD DE COTIZACIONES Formato = "02-09-2023"
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $nota_venta  = NotaVenta::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $moneda = Moneda::where('principal', '1')->first();
        $igv = Igv::first();
        $suma = 0;
        //$total = 0;
        foreach ($nota_venta as $notaV) {

            $nota_venta_reg = NotaVentaRegistro::where('nota_venta_id', $notaV->id)->get();

            foreach ($nota_venta_reg as $nota_venta_regs) {
                // Condicional para soles
                if ($moneda->id == "1") { // Si es soles
                    if ($notaV->moneda->id == "1") { // Soles
                        $total = $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
                    } else { // Dólares
                        $subtotal = $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
                        $total = $subtotal * $notaV->cambio;
                    }
                } else { // Si no, retorno dólares
                    if ($notaV->moneda->id == "1") { // Soles
                        $subtotal = $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
                        $total = $subtotal / $notaV->cambio;
                    } else { // Dólares
                        $total = $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
                    }
                }
                // return $total;
            }
            $suma += $total; // Mueve la suma aquí para acumular los totales
        }
        $moneda_total = $moneda->simbolo . " " . number_format(round($suma, 2), 2);
        $mes = array(
            "cantidad" => $nota_venta->count(),
            "total" => $moneda_total    
        );

        return $mes;
    }
    public static function total_sum_datatable($request, $startDate, $endDate)
    {
        // Data
        $igv = Igv::first()->renta;
        // FILTRADO
        $filter = $request->get('value');
        // Busqueda en DB
        $query = NotaVenta::with(['cliente', 'moneda'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        //  Filtro
        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function ($q) use ($filter) {
                $q->where('cod_nota_venta', 'like', '%' . $filter . '%');
                $q->orWhereHas('cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
            });
        }
        if ($request->get('tipo_coti') !== null) {
            $query->where('tipo', $request->get('tipo_coti'));
        }

        $nota_venta = $query->get();

        $total_table = 0;
        // Transformacion a moneda principal
        $nota_venta->transform(function ($nota_venta) use ($igv, &$total_table) {
            // CALCULO PARA EL TOTAL
            $nota_venta_reg = NotaVentaRegistro::where('nota_venta_id', $nota_venta->id)->get();
            $total = 0;
            $suma = 0;
            foreach ($nota_venta_reg as $index => $nota_reg) {
                $total += $nota_reg->precio_nacional * $nota_reg->cantidad;
            }
            $suma += $total;

            // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
            $nota_venta->total_conv = Ventas_registro::moneda_principal_convert($nota_venta->moneda_id, $total);
            $total_table += $nota_venta->total_conv;
            return $nota_venta;
        });
        return $total_table;
    }

    public function getUltimaFechaPagoAttribute()
    {
        $ultimo_pago =  ComprobantesPagos::where('nota_venta_id', $this->id)->latest()->first();
        return Carbon::parse($ultimo_pago->fecha_registro)->format('d-m-Y');
    }
}