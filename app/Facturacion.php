<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model
{
    protected $table = 'facturacion';

    protected $guarded = [];

    protected $appends = ['estado_pago_text', 'total_precio', 'total_precio_sin_forma'];

    protected $with = ['producto', 'cliente'];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'id_cotizador');
    }

    public function cotizacion_servicio()
    {
        return $this->belongsTo(Cotizacion_Servicios::class, 'id_cotizador_servicio');
    }

    public function forma_pago()
    {
        return $this->belongsTo(Forma_pago::class, 'forma_pago_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }

    public function cuotas_credito()
    {
        return $this->hasMany(Cuotas_credito::class, 'facturacion_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function tipo_operacion()
    {
        return $this->belongsTo(Tipo_operacion_f::class, 'tipo_operacion_id');
    }
    public function tipo_documento()
    {
        return $this->belongsTo(Tipo_documento_sunat::class, 'tipo_documento_id');
    }

    public function registros()
    {
        return $this->hasMany(Facturacion_registro::class, 'facturacion_id');
    }

    public function detracciones()
    {
        return $this->hasOne(Detracciones::class, 'factura_id');
    }

    public function nota_credito_register(){
        return $this->hasOne(Nota_Credito::class , 'facturacion_id');
    }


    public function getSelectComisionistaAttribute()
    {
        $raw = trim((string) $this->getAttribute('comisionista'));

        if ($raw === '' || $raw === '0') {
            return null;
        }

        if (!ctype_digit($raw)) {
            return null;
        }

        return Personal_venta::with('personal.personal_l')->find((int) $raw);
    }

    public function getFechaEmisionAttribute()
    {
        $new_emision = Carbon::parse($this->attributes['fecha_emision'])->format('d-m-Y');
        return $new_emision;
    }
    public function getFechaVencimientoAttribute()
    {
        $new_vencimiento = Carbon::parse($this->attributes['fecha_vencimiento'])->format('d-m-Y');
        return $new_vencimiento;
    }
    public function getFechaEmisionEditAttribute()
    {
        $edit_emision = Carbon::parse($this->attributes['fecha_emision'])->format('yyyy-mm-dd');
        return $edit_emision;
    }
    public function getFechaVencimientoEditAttribute()
    {
        $edit_vencimiento = Carbon::parse($this->attributes['fecha_vencimiento'])->format('Y-m-d');
        return $edit_vencimiento;
    }

    public static function revision_cuotas($id)
    {

        $igv = Igv::first();
        $factura = Facturacion::find($id);
        //dato 1 -- multiplicacion de operaciones + igv
        $op_grav = $factura->op_gravada;
        $sub_tot = ($op_grav * ($igv->igv_total / 100));

        $op_ina = $factura->op_inafecta;
        $op_exo = $factura->op_exonerada;
        $op_grat = $factura->op_gratuita;
        $subtotal = $factura->op_gravada + $op_exo + $op_ina + $op_grat;
        $final_1 = $subtotal + $sub_tot;

        //dato 2 -- suma de cuotas
        $cuotas_cre = Cuotas_credito::where('facturacion_id', $id)->get();
        $cuota_sum = 0;
        foreach ($cuotas_cre as $key => $cuota) {
            $cuota_sum += $cuota->monto;
        }

        //dato 3 -- suma de registros
        $factura_reg = Facturacion_registro::where('facturacion_id', $factura->id)->get();
        $igv_f = 0;
        $gravada = 0;
        $precio = 0;
        foreach ($factura_reg as $key => $f_reg) {
            if (isset($f_reg->producto->codigo_producto)) {
                $afec = $f_reg->producto->tipo_afec_i_producto->codigo;
            } else {
                $afec = $f_reg->servicio->tipo_afec_i_serv->codigo;
            }

            if (in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17"))) { // gravada
                $igv_f = ($f_reg->precio_unitario_comi * $f_reg->cantidad) * (($igv->igv_total) / 100) + $igv_f;
                $precio = ($f_reg->precio_unitario_comi * $f_reg->cantidad)  + $precio;
            } else {
                $precio = ($f_reg->precio_unitario_comi * $f_reg->cantidad) + $precio;
            }
            $total = round(($igv_f + $precio), 2);
        }
        // return $total;
        //VALORES DE LSO 3
        // return $final_1; // -> cabecera
        // return $cuota_sum; //  -> cuotas
        // return $total; //  -> array

        if ($cuota_sum != $total) {
            if ($total > $cuota_sum) {
                $diferencia = $total - $cuota_sum;
                $diferencia_2 = round($diferencia, 3);
                //cambio de la ultima cuota en centesimas para 2 decimales
                $cuotas_cre = Cuotas_credito::where('facturacion_id', $id)->latest()->first();

                $nuevoMonto = $cuotas_cre->monto + round($diferencia_2, 2);
                $cuotas_cre->update([
                    'monto' => $nuevoMonto
                ]);
            } else {
                $diferencia =  $cuota_sum - $total;
                $diferencia_2 = round($diferencia, 3);
                $cuotas_cre = Cuotas_credito::where('facturacion_id', $id)->latest()->first();
                $nuevoMonto = $cuotas_cre->monto - round($diferencia_2, 2);
                $cuotas_cre->update([
                    'monto' => $nuevoMonto
                ]);
            }
        }
    }

    // public static function search_motivo_nc($id){
    //     $factura = Facturacion::find($id);
    //     $nota_credito = Nota_Credito::where('facturacion_id',$factura->id)->first();
    //     switch($nota_credito->motivo){
    //         case(01):
    //             $motivo_desc = 'Anulacion de la operacion';
    //             break;
    //         case(02):
    //             $motivo_desc = 'Anulacion por error en el ruc';
    //             break;
    //         case(03):
    //             $motivo_desc = 'Correcion por error en la descripcion';
    //             break;
    //         case(06):
    //             $motivo_desc = 'Devolucion total';
    //             break;
    //         case(07):
    //             $motivo_desc = 'Devolucion por Item';
    //             break;
    //     }
    //     return $motivo_desc;
    //  }
    public static function search_motivo_nc($id)
    {
        $factura = Facturacion::find($id);

        $nota_credito = Nota_Credito::where('facturacion_id', $factura->id)->first();

        $motivos = [
            '01' => 'Anulacion de la operacion',
            '02' => 'Anulacion por error en el ruc',
            '03' => 'Correcion por error en la descripcion',
            '06' => 'Devolucion total',
            '07' => 'Devolucion por Item',
            '08' => '01',
        ];

        $key = $nota_credito->motivo;

        return $motivos[$key] ?? 'Motivo desconocido';
    }
    public static function nota_credito_id($id)
    {
        $factura = Facturacion::find($id);
        $nota_credito = Nota_Credito::where('facturacion_id', $factura->id)->first();
        if ($nota_credito) {
            return $nota_credito->id;
        }
    }

    public static function count_month_comprobantes($fecha)
    {
        //CANTIDAD DE COTIZACIONES Formato = 02-09-2023"
        // $fecha = "02-09-2023";
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $cotizaciones  = Facturacion::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $moneda = Moneda::where('principal', '1')->first();
        $igv = Igv::first();
        // return $moneda;
        $total_final = 0;
        // PRECIOS DE COTIZACIONES X MES
        foreach ($cotizaciones as $coti) {
            // condicional soles
            if ($moneda->id == "1") { //Si es soles retorno soles
                if ($coti->moneda->id == "1") { //soles
                    $subtotal = $coti->op_gravada + $coti->op_inafecta + $coti->op_exonerada;
                    $total =  $subtotal + ($coti->op_gravada * ($igv->igv_total / 100));
                } else {  //dolares
                    $subtotal_sin = $coti->op_gravada + $coti->op_inafecta + $coti->op_exonerada;
                    $subtotal = $subtotal_sin * $coti->cambio;
                    $subtotal_dol = $coti->op_gravada * $coti->cambio;
                    $total =  $subtotal + ($subtotal_dol * ($igv->igv_total / 100));
                }
            } else { // Si no retorno Dolares

                if ($coti->moneda->id == "1") { //dolares
                    $subtotal_sin = $coti->op_gravada + $coti->op_inafecta + $coti->op_exonerada;
                    $subtotal = $subtotal_sin / $coti->cambio;
                    $subtotal_dol = $coti->op_gravada / $coti->cambio;
                    $total =  $subtotal + ($coti->op_gravada * ($igv->igv_total / 100));
                } else {  //soels
                    $subtotal = $coti->op_gravada + $coti->op_inafecta + $coti->op_exonerada;
                    $total =  $subtotal + ($coti->op_gravada * ($igv->igv_total / 100));
                }
            }
            $total_final += $total;
        }
        $moneda_total = $moneda->simbolo . " " . number_format(round($total_final, 2), 2);
        $mes = array(
            "cantidad" => $cotizaciones->count(),
            "total" => $moneda_total
        );

        return $mes;
    }

    public static function estado_sunat($id)
    {
        $boleta = Facturacion::find($id);
        switch ($boleta->f_electronica) {
            case '1':
                // $estado_sunat = "Enviado";
                $estado_sunat = 1;
                break;
            case '2':
                // $estado_sunat = "Anulado";
                $estado_sunat = 2;
                break;
            default:
                // $estado_sunat = "Sin enviar";
                $estado_sunat = 0;
                break;
        }
        return $estado_sunat;
    }

    public static function estado_nota_credito($id)
    {
        $factura = Facturacion::find($id);
        $nota_credito = Nota_Credito::where('facturacion_id', $factura->id)->first();
        if (!$nota_credito) {
            return 99;
        }
        switch ($nota_credito->n_electronica) {
            case '1':
                // $estado_sunat = "Enviado";
                $estado_sunat = 1;
                break;
            case '2':
                // $estado_sunat = "Anulado";
                $estado_sunat = 2;
                break;
            default:
                // $estado_sunat = "Sin enviar";
                $estado_sunat = 0;
                break;
        }
        return $estado_sunat;
    }
    public static function estado_nota_debito($id)
    {
        $factura = Facturacion::find($id);
        $nota_debito = Nota_Debito::where('facturacion_id', $factura->id)->first();
        if (!$nota_debito) {
            return 99;
        }
        switch ($nota_debito->n_electronica) {
            case '1':
                // $estado_sunat = "Enviado";
                $estado_sunat = 1;
                break;
            case '2':
                // $estado_sunat = "Anulado";
                $estado_sunat = 2;
                break;
            default:
                // $estado_sunat = "Sin enviar";
                $estado_sunat = 0;
                break;
        }
        return $estado_sunat;
    }
    public static function total_sum_datatable($request, $startDate, $endDate)
    {
        // Data
        $igv = Igv::first()->renta;
        // FILTRADO
        $filter = $request->get('value');
        // Busqueda en DB
        $query = Facturacion::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        //  Filtro
        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function ($q) use ($filter) {
                $q->where('codigo_fac', 'like', '%' . $filter . '%');
                $q->orWhereHas('cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
                $q->orWhereHas('forma_pago', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%');
                });
            });
        }
        $facturas = $query->get();

        $total_table = 0;
        // Transformacion a moneda principal
        $facturas->transform(function ($facturas) use ($igv, &$total_table) {
            $subtotal = $facturas->op_gravada + $facturas->op_inafecta + $facturas->op_exonerada;
            $total = round($subtotal + ($facturas->op_gravada * $igv) / 100, 2);
            // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
            $facturas->total_conv = Ventas_registro::moneda_principal_convert($facturas->moneda_id, $total);
            // Sumar el total convertido a la suma acumulada
            $total_table += $facturas->total_conv;
            return $facturas;
        });
        return $total_table;
    }

    public function getTotalPrecioAttribute()
    {
        // $boleta = Boleta::find($this->attributes['id']);
        $igv = Igv::first()->renta;
        // $boleta_reg = Boleta_registro::where('boleta_id', $boleta->id)->get();
        $subtotal = $this->attributes['op_gravada'] + $this->attributes['op_inafecta'] + $this->attributes['op_exonerada'];

        $total = round($subtotal + ($this->attributes['op_gravada'] * $igv) / 100, 2);
        if($this->attributes['nota_credito'] == 2){
            // Reduccion por nota de crédito
            $motivo = Facturacion::search_motivo_nc($this->attributes['id']);
                // dd($motivo);
            if($motivo == "Devolucion por Item"){
               $nota_c = Nota_Credito::where('facturacion_id', $this->attributes['id'])->first();
            //    dd($nota_c);
               $total = $total - $nota_c->total_precio_number;
            //    return $nota_c;
            }
        }

        // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
        // $total_conv = ComprobantesVentas::moneda_principal_convert($this->attributes['id']->moneda_id, $total);

        $total_igv = $this->moneda->simbolo . ' ' . number_format($total, 2);
        return $total_igv;
    }

    public function getSubTotalSinFormaAttribute()
    {
        $subtotal = ($this->attributes['op_gravada'] + $this->attributes['op_inafecta'] + $this->attributes['op_exonerada']);
        return round($subtotal, 2);
    }

    public function getIgvSinFormaAttribute()
    {
        $igv = Igv::first()->renta;
        $sub_igv = ($this->attributes['op_gravada'] * $igv) / 100;

        return round($sub_igv, 2);
    }

    public function getTotalPrecioSinFormaAttribute()
    {
        // $boleta = Boleta::find($this->attributes['id']);
        $igv = Igv::first()->renta;
        // $boleta_reg = Boleta_registro::where('boleta_id', $boleta->id)->get();
        $subtotal = $this->attributes['op_gravada'] + $this->attributes['op_inafecta'] + $this->attributes['op_exonerada'];

        $total = round($subtotal + ($this->attributes['op_gravada'] * $igv) / 100, 2);

        // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
        // $total_conv = ComprobantesVentas::moneda_principal_convert($this->attributes['id']->moneda_id, $total);

        $total_igv = round($total, 2);
        return $total_igv;
    }

    public function getTotalPrecioDescSinFormaAttribute()
    {
        // $boleta = Boleta::find($this->attributes['id']);
        $igv = Igv::first()->renta;
        // $boleta_reg = Boleta_registro::where('boleta_id', $boleta->id)->get();
        $subtotal = $this->attributes['op_gravada'] + $this->attributes['op_inafecta'] + $this->attributes['op_exonerada'];

        $total = round($subtotal + ($this->attributes['op_gravada'] * $igv) / 100, 2);

        // return $this->attributes['nota_credito'];
        if($this->attributes['nota_credito'] == 2){
            // Reduccion por nota de crédito
            $motivo = Facturacion::search_motivo_nc($this->attributes['id']);
                // dd($motivo);
            if($motivo == "Devolucion por Item"){
               $nota_c = Nota_Credito::where('facturacion_id', $this->attributes['id'])->first();
            //    dd($nota_c);
               $total = $total - $nota_c->total_precio_number;
            //    return $nota_c;
            }
        }
        // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
        // $total_conv = ComprobantesVentas::moneda_principal_convert($this->attributes['id']->moneda_id, $total);

        $total_igv = round($total, 2);
        return $total_igv;
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
        $suma_cuota = $this->total_precio_desc_sin_forma;
        if ($this->forma_pago_id == 2) { // credito
            $saldo_pendiente = 0;
            $cuotas_total = 0;
            // Falta sacar el monto por la cantidad de pago o adelanto que se ha realizado
            $cuotas = Cuotas_credito::where('facturacion_id', $this->id)->where('estado', '!=',  0)->get();
            foreach ($cuotas as $cuota) {
                // if ($cuota->estado == 2 ) {
                $suma_cuota = $suma_cuota - $cuota->nuevo_monto;
                // }
            }
            $cuotas_total += $suma_cuota;
            $saldo_pendiente = $this->moneda->simbolo . '' . number_format($cuotas_total, 2);
        } else {
            if ($this->estado_pago == 0) {
                $saldo_pendiente = $this->moneda->simbolo . '' . number_format($suma_cuota, 2);
            } else {
                // Sumatoria para los pagos
                $totalPagado = ComprobantesPagos::where('factuacion_id', $this->id)
                    ->sum('monto_pago');
                $saldo_pendiente = $this->moneda->simbolo . '' . number_format(max(0, $this->importe_total - $totalPagado), 2);
                // $saldo_pendiente = 0;
            }
        }

        // $last_stand = $this->moneda->simbolo.''.$saldo_pendiente;
        return $saldo_pendiente;
    }

    public function getSaldoPendienteSinFormaAttribute()
    {
        // return $this->forma_pago_id;
        $suma_cuota = $this->total_precio_sin_forma;
        if ($this->forma_pago_id == 2) { // credito
            $saldo_pendiente = 0;
            $cuotas_total = 0;
            // Falta sacar el monto por la cantidad de pago o adelanto que se ha realizado
            $cuotas = Cuotas_credito::where('facturacion_id', $this->id)->where('estado', '!=',  0)->get();
            foreach ($cuotas as $cuota) {
                // if ($cuota->estado == 2 ) {
                $suma_cuota = $suma_cuota - $cuota->monto_nuevo;
                // }
            }
            $cuotas_total += $suma_cuota;
            $saldo_pendiente = number_format($cuotas_total, 2);
        } else {
            if ($this->estado_pago == 0) {
                $saldo_pendiente = number_format($suma_cuota, 2);
            } else {
                // Sumatoria para los pagos
                $totalPagado = ComprobantesPagos::where('factuacion_id', $this->id)
                    ->sum('monto_pago');
                $saldo_pendiente = number_format(max(0, $this->importe_total - $totalPagado), 2);
                // $saldo_pendiente = 0;
            }
        }

        // $last_stand = $this->moneda->simbolo.''.$saldo_pendiente;
        return $saldo_pendiente;
    }
    
    public function getUltimaMontoPagoAttribute()
    {
        $ultimo_pago =  ComprobantesPagos::where('factuacion_id', $this->id)->latest()->first();
        return $ultimo_pago->monto_pago ?? 0.00;
    }

    public function getUltimaFechaPagoAttribute()
    {
        $ultimo_pago =  ComprobantesPagos::where('factuacion_id', $this->id)->latest()->first();
        return $ultimo_pago ? Carbon::parse($ultimo_pago->fecha_registro)->format('d-m-Y') : "Sin Pago Asociado";
    }

    public function getUltimoTipoPagoAttribute(){
        $ultimo_tipo =  ComprobantesPagos::where('factuacion_id', $this->id)->latest()->first();
        return $ultimo_tipo ? $ultimo_tipo->tipo_pago : "Sin Pago Asociado";
    }

    public function getUltimoDatoPagoAttribute(){
        $ultimo_pago =  ComprobantesPagos::where('factuacion_id', $this->id)->latest()->first();

        $registro = ComprobantesPagosDetalle::where('comprobante_pago_id', $ultimo_pago->id)->latest()->first();
        // dd($registrol);
        switch ($ultimo_pago->tipo_pago) {
            case 'cheque':
                $registro_data = $registro->numero_input ?? "Sin N° Asignado";
                break;
            case 'tarjeta':
                $registro_data = $registro->persona_input ?? "Sin Titular";
                break;
            case 'efectivo':
                $registro_data = $registro->persona_input ?? "Sin Persona";
                break;
            case  'transferencia':
                $registro_data = $registro->numero_input ??  "Sin N° Operación";
                break;
        }
        return $registro_data;
    }

    public static function cambio_estado_facturas()
    {
        return Facturacion::where('estado', 0)
            // ->whereDate('created_at', Carbon::today())
            // ->limit(5)
            ->update([
                'estado' => 1,
                // 'updated_at' => now(),
            ]);
    }
}
