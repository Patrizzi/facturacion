<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    protected $table = 'boleta';

    protected $guarded = [];
    
    protected $appends = ['estado_pago_text','total_precio','total_precio_sin_forma'];

    protected $with = ['producto', 'cliente'];

    // protected $with = ['cliente'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'id_cotizador');
    }

    public function cotizacion_servicio()
    {
        return $this->belongsTo(Cotizacion_Servicios::class, 'id_cotizador_servicio');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function forma_pago()
    {
        return $this->belongsTo(Forma_pago::class, 'forma_pago_id');
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function tipo_operacion()
    {
        return $this->belongsTo(Tipo_operacion_f::class, 'tipo_operacion_id');
    }

    public function tipo_documento()
    {
        return $this->belongsTo(Tipo_documento_sunat::class,'tipo_documento_id');
    }

    public function registros(){
        return $this->hasMany(Boleta_registro::class,'boleta_id');
    }

    public function cuotas_credito()
    {
        return $this->hasMany(Cuotas_credito::class, 'boleta_id');
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

    public static function revision_cuotas($id)
    {

        $igv = Igv::first();
        $boleta = Boleta::find($id);
        //dato 1 -- multiplicacion de operaciones + igv
        $op_grav = $boleta->op_gravada;
        $sub_tot = ($op_grav * ($igv->igv_total / 100));


        $op_ina = $boleta->op_inafecta;
        $op_exo = $boleta->op_exonerada;
        $op_grat = $boleta->op_gratuita;
        $subtotal = $boleta->op_gravada + $op_exo + $op_ina + $op_grat;
        $final_1 = $subtotal + $sub_tot;

        //dato 2 -- suma de cuotasp
        $cuotas_cre = Cuotas_credito::where('boleta_id', $id)->get();
        $cuota_sum = 0;
        foreach ($cuotas_cre as $key => $cuota) {
            $cuota_sum += $cuota->monto;
        }

        //dato 3 -- suma de registros
        $boleta_reg = Boleta_registro::where('boleta_id', $boleta->id)->get();
        $igv_f = 0;
        $gravada = 0;
        $precio = 0;
        foreach ($boleta_reg as $key => $bol_r) {
            if (isset($bol_r->producto->codigo_producto)) {
                $afec = $bol_r->producto->tipo_afec_i_producto->codigo;
            } else {
                $afec = $bol_r->servicio->tipo_afec_i_serv->codigo;
            }

            if (in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17"))) { // gravada
                $igv_f = ($bol_r->precio * $bol_r->cantidad) * (($igv->igv_total) / 100) + $igv_f;
                $precio = ($bol_r->precio * $bol_r->cantidad)  + $precio;
            } else {
                $precio = ($bol_r->precio * $bol_r->cantidad) + $precio;
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
                $cuotas_cre = Cuotas_credito::where('boleta_id', $id)->latest()->first();

                $cuotas_cre->monto = $cuotas_cre->monto + round($diferencia_2, 2);
                $cuotas_cre->save();
            }else{
                $diferencia =  $cuota_sum - $total;
                $diferencia_2 = round($diferencia, 3);
                $cuotas_cre = Cuotas_credito::where('boleta_id', $id)->latest()->first();
                $nuevoMonto = $cuotas_cre->monto - round($diferencia_2, 2);
                $cuotas_cre->update([
                    'monto' => $nuevoMonto
                ]);
            }

        }
    }
    // public static function search_motivo_nc($id){
    //     $boleta = Boleta::find($id);
    //     $nota_credito = Nota_Credito::where('boleta_id',$boleta->id)->first();
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

    public static function search_motivo_nc($id) {
        $boleta = Boleta::findOrFail($id);
        $notaCredito = Nota_Credito::where('boleta_id', $boleta->id)->first();

        $motivos = [
            '01' => 'Anulacion de la operacion',
            '02' => 'Anulacion por error en el ruc',
            '03' => 'Correcion por error en la descripcion',
            '06' => 'Devolucion total',
            '07' => 'Devolucion por Item',
            '08' => '01',
        ];

        $key = $notaCredito->motivo;

        return $motivos[$key] ?? 'Motivo desconocido';
    }

     public static function nota_credito_id($id){
        $boleta = Boleta::find($id);
        $nota_credito = Nota_Credito::where('boleta_id',$boleta->id)->first();
        if($nota_credito){
            return $nota_credito->id;        }
    }

    public static function total_sum_datatable($request, $startDate, $endDate)
    {
        // Data
        $igv = Igv::first()->renta;
        // FILTRADO
        $filter = $request->get('value');
        // Busqueda en DB
        $query = Boleta::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        //  Filtro
        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function ($q) use ($filter) {
                $q->where('cod_boleta', 'like', '%' . $filter . '%');
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
        $cotizaciones = $query->get();

        $total_table = 0;
        // Transformacion a moneda principal
        $cotizaciones->transform(function ($cotizacion) use ($igv, &$total_table) {
            $subtotal = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
            $total = round($subtotal + ($cotizacion->op_gravada * $igv) / 100, 2);
            // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
            $cotizacion->total_conv = Ventas_registro::moneda_principal_convert($cotizacion->moneda_id, $total);
            // Sumar el total convertido a la suma acumulada
            $total_table += $cotizacion->total_conv;
            return $cotizacion;
        });
        return $total_table;
    }

    public static function count_month_comprobantes($fecha)
    {
        //CANTIDAD DE COTIZACIONES Formato = 02-09-2023"
        // $fecha = "02-09-2023";
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $cotizaciones  = Boleta::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
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
        $moneda_total = $moneda->simbolo." ".number_format(round($total_final, 2), 2);
        $mes = array(
            "cantidad" => $cotizaciones->count(),
            "total" => $moneda_total
        );

        return $mes;
    }

    public static function estado_sunat($id)
    {
        $boleta = Boleta::find($id);
        switch ($boleta->b_electronica) {
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
        $boleta = Boleta::find($id);
        $nota_credito = Nota_Credito::where('boleta_id', $boleta->id)->first();
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
        $boleta = Boleta::find($id);
        $nota_debito = Nota_Debito::where('boleta_id', $boleta->id)->first();
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

    public function getFechaEmisionAttribute(){
        $new_emision = Carbon::parse($this->attributes['fecha_emision'])->format('d-m-Y');
        return $new_emision;
    }
    public function getFechaVencimientoAttribute(){
        $new_vencimiento = Carbon::parse($this->attributes['fecha_vencimiento'])->format('d-m-Y');
        return $new_vencimiento;
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

    public function getTotalPrecioAttribute(){
        // $boleta = Boleta::find($this->attributes['id']);
         $igv = Igv::first()->renta;
        // $boleta_reg = Boleta_registro::where('boleta_id', $boleta->id)->get();
        $subtotal = $this->attributes['op_gravada'] + $this->attributes['op_inafecta'] + $this->attributes['op_exonerada'];

        $total = round($subtotal + ($this->attributes['op_gravada'] * $igv) / 100, 2);

        // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
        // $total_conv = ComprobantesVentas::moneda_principal_convert($this->attributes['id']->moneda_id, $total);

        $total_igv = $this->moneda->simbolo.' '.number_format($total, 2);
        return $total_igv;
    }
    public function getTotalPrecioDescSinFormaAttribute()
    {
        // $boleta = Boleta::find($this->attributes['id']);
        $igv = Igv::first()->renta;
        // $boleta_reg = Boleta_registro::where('boleta_id', $boleta->id)->get();
        $subtotal = $this->attributes['op_gravada'] + $this->attributes['op_inafecta'] + $this->attributes['op_exonerada'];

        $total = round($subtotal + ($this->attributes['op_gravada'] * $igv) / 100, 2);

        // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
        // $total_conv = ComprobantesVentas::moneda_principal_convert($this->attributes['id']->moneda_id, $total);

        $total_igv = $total;
        return $total_igv;
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

        $total_igv = $total;
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
        $suma_cuota = $this->total_precio_sin_forma;
        if ($this->forma_pago_id == 2) { // credito
            $saldo_pendiente = 0;
            $cuotas_total = 0;
            // Falta sacar el monto por la cantidad de pago o adelanto que se ha realizado
            $cuotas = Cuotas_credito::where('boleta_id', $this->id)->where('estado', '!=',  0)->get();
            foreach ($cuotas as $cuota) {
                // if ($cuota->estado == 2 ) {
                $suma_cuota = $suma_cuota - $cuota->monto;
                // }
            }
            $cuotas_total += $suma_cuota;
            $saldo_pendiente = $this->moneda->simbolo . '' . number_format($cuotas_total, 2);
        } else {
            if ($this->estado_pago == 0) {
                $saldo_pendiente = $this->moneda->simbolo . '' . number_format($suma_cuota, 2);
            } else {
                // Sumatoria para los pagos
                $totalPagado = ComprobantesPagos::where('boleta_id', $this->id)
                    ->sum('monto_pago');
                $saldo_pendiente = $this->moneda->simbolo . '' . number_format(max(0, $this->importe_total - $totalPagado), 2);
                // $saldo_pendiente = 0;
            }
        }

        // $last_stand = $this->moneda->simbolo.''.$saldo_pendiente;
        return $saldo_pendiente;
    }

    public function getUltimaFechaPagoAttribute()
    {
        $ultimo_pago =  ComprobantesPagos::where('boleta_id', $this->id)->latest()->first();
        return Carbon::parse($ultimo_pago->fecha_registro)->format('d-m-Y');
    }
}
