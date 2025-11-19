<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Facturacion_m extends Model
{
    protected $table = 'facturacion_m';

    protected $guarded = [];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function cotizacionM()
    {
        return $this->belongsTo(CotizacionManual::class, 'cotizador_id');
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

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function tipo_documento()
    {
        return $this->belongsTo(Tipo_documento_sunat::class, 'tipo_documento_id');
    }


    public function tipo_operacion()
    {
        return $this->belongsTo(Tipo_operacion_f::class, 'tipo_operacion_id');
    }

    public function registros_m()
    {
        return $this->hasMany(Facturacion_registro_m::class, 'facturacion_m_id');
    }

    public function getFechaEmisionAttribute()
    {
        $new_emision = Carbon::parse($this->attributes['fecha_emision'])->format('d-m-Y');
        return $new_emision;
    }

    public static function revision_cuotas($id)
    {

        $igv = Igv::first();
        $factura_m = Facturacion_m::find($id);
        //dato 1 -- multiplicacion de operaciones + igv
        $op_grav = $factura_m->op_gravada;
        $sub_tot = ($op_grav * ($igv->igv_total / 100));


        $op_ina = $factura_m->op_inafecta;
        $op_exo = $factura_m->op_exonerada;
        $op_grat = $factura_m->op_gratuita;
        $subtotal = $factura_m->op_gravada + $op_exo + $op_ina + $op_grat;
        $final_1 = $subtotal + $sub_tot;

        //dato 2 -- suma de cuotas
        $cuotas_cre = Cuotas_credito::where('facturacion_m_id', $id)->get();
        $cuota_sum = 0;
        foreach ($cuotas_cre as $key => $cuota) {
            $cuota_sum += $cuota->monto;
        }

        //dato 3 -- suma de registros
        $factura_reg = Facturacion_registro_m::where('facturacion_m_id', $factura_m->id)->get();
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
                $igv_f = ($f_reg->precio * $f_reg->cantidad) * (($igv->igv_total) / 100) + $igv_f;
                $precio = ($f_reg->precio * $f_reg->cantidad)  + $precio;
            } else {
                $precio = ($f_reg->precio * $f_reg->cantidad) + $precio;
            }
            $total = round(($igv_f + $precio), 2);
        }
        //VALORES DE LSO 3
        // return $final_1; // -> cabecera
        // return $cuota_sum; //  -> cuotas
        // return $total; //  -> array
        // return $total;
        if ($cuota_sum != $total) {
            if ($total > $cuota_sum) {
                $diferencia = $total - $cuota_sum;
                $diferencia_2 = round($diferencia, 3);
                //cambio de la ultima cuota en centesimas para 2 decimales\
                $cuotas_cre = Cuotas_credito::where('facturacion_m_id', $id)->latest()->first();

                $cuotas_cre->monto = $cuotas_cre->monto + round($diferencia_2, 2);
                $cuotas_cre->save();
            } else {
                $diferencia =  $cuota_sum - $total;
                $diferencia_2 = round($diferencia, 3);
                $cuotas_cre = Cuotas_credito::where('facturacion_m_id', $id)->latest()->first();
                $nuevoMonto = $cuotas_cre->monto - round($diferencia_2, 2);
                // return $diferencia_2;
                // $cuotas_cre->monto = $cuotas_cre->monto - round($diferencia_2, 2);
                $cuotas_cre->update([
                    'monto' => $nuevoMonto
                ]);
            }
        }
    }
    // public static function search_motivo_nc($id){
    //     $factura = Facturacion_m::find($id);
    //     $nota_credito = Nota_Credito::where('facturacion_m_id',$factura->id)->first();
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
    //           case(06):
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
        $factura_m = Facturacion_m::findOrFail($id);
        $nota_credito = Nota_Credito::where('facturacion_m_id', $factura_m->id)->first();

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
        $factura = Facturacion_m::find($id);
        $nota_credito = Nota_Credito::where('facturacion_m_id', $factura->id)->first();
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
        $facturas_m  = Facturacion_m::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();

        $moneda = Moneda::where('principal', '1')->first();
        $igv = Igv::first();
        // return $moneda;
        $total_final = 0;
        // PRECIOS DE facturas_m X MES
        foreach ($facturas_m as $index => $fact) {
            // condicional soles
            if ($moneda->id == "1") { //Si es soles retorno soles
                if ($fact->moneda->id == "1") { //soles
                    $subtotal = $fact->op_gravada + $fact->op_inafecta + $fact->op_exonerada;
                    $total =  $subtotal + ($fact->op_gravada * ($igv->igv_total / 100));
                } else {  //dolares
                    $subtotal_sin = $fact->op_gravada + $fact->op_inafecta + $fact->op_exonerada;
                    $subtotal = $subtotal_sin * $fact->cambio;
                    $subtotal_dol = $fact->op_gravada * $fact->cambio;
                    $total =  $subtotal + ($subtotal_dol * ($igv->igv_total / 100));
                }
            } else { // Si no retorno Dolares

                if ($fact->moneda->id == "1") { //dolares
                    $subtotal_sin = $fact->op_gravada + $fact->op_inafecta + $fact->op_exonerada;
                    $subtotal = $subtotal_sin / $fact->cambio;
                    $subtotal_dol = $fact->op_gravada / $fact->cambio;
                    $total =  $subtotal + ($fact->op_gravada * ($igv->igv_total / 100));
                } else {  //soels
                    $subtotal = $fact->op_gravada + $fact->op_inafecta + $fact->op_exonerada;
                    $total =  $subtotal + ($fact->op_gravada * ($igv->igv_total / 100));
                }
            }
            $total_final += $total;
        }
        // dd($total_final);
        $moneda_total = $moneda->simbolo . " " . number_format(round($total_final, 2), 2);
        $mes = array(
            "cantidad" => $facturas_m->count(),
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
        $query = Facturacion_m::with(['cliente', 'moneda', 'forma_pago'])
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

    public static function estado_sunat($id)
    {
        $factura = Facturacion_m::find($id);
        switch ($factura->f_electronica) {
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
        $factura = Facturacion_m::find($id);
        $nota_credito = Nota_Credito::where('facturacion_m_id', $factura->id)->first();
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
        $factura = Facturacion_m::find($id);
        $nota_debito = Nota_Debito::where('facturacion_m_id', $factura->id)->first();
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

    public function getTotalPrecioAttribute()
    {
        // $boleta = Boleta::find($this->attributes['id']);
        $igv = Igv::first()->renta;
        // $boleta_reg = Boleta_registro::where('boleta_id', $boleta->id)->get();
        $subtotal = $this->attributes['op_gravada'] + $this->attributes['op_inafecta'] + $this->attributes['op_exonerada'];

        $total = round($subtotal + ($this->attributes['op_gravada'] * $igv) / 100, 2);

        // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
        // $total_conv = ComprobantesVentas::moneda_principal_convert($this->attributes['id']->moneda_id, $total);

        $total_igv = $this->moneda->simbolo . ' ' . number_format($total, 2);
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
    return $this->forma_pago_id;
        if ($this->forma_pago_id == 2) { // credito
            $saldo_pendiente = 0;
            $cuotas = Cuotas_credito::where('facturacion_m_id', $this->id)->get();
            $suma_cuota = 0;

            foreach ($cuotas as $cuota) {
                if ($cuota->estado == 1) {
                    $suma_cuota += $suma_cuota + $cuota->monto;
                }

            }
            $saldo_pendiente += $suma_cuota;
        }else{
            $saldo_pendiente = $this->total_precio;
        }

        // $last_stand = $this->moneda->simbolo.''.$saldo_pendiente;
        return $saldo_pendiente;
    }
}
