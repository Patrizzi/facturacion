<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizacion';

    protected $guarded = [];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function forma_pago()
    {
        return $this->belongsTo(Forma_pago::class, 'forma_pago_id');
    }
    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function comisionista()
    {
        return $this->belongsTo(Personal_venta::class, 'comisionista_id');
    }

    public function user_personal()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function aprobado()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }
    public static function count_mes($fecha)
    {
        //CANTIDAD DE COTIZACIONES Formato = 02-09-2023"
        // $fecha = "02-09-2023";
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $cotizaciones  = Cotizacion::whereDate('created_at', '=', $fecha_conv)->get();
        $moneda = Moneda::where('principal', '1')->first();
        $igv = Igv::first();
        // return $moneda;
        $total = 0;
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
        }

        $mes = array(
            "cantidad" => $cotizaciones->count(),
            "total" => $total
        );

        return $mes;
    }
    public static function estado_proceso($id)
    {
        $cotizacion = Cotizacion::find($id);
        //Estado
        if ($cotizacion->estado == 0) {
            $estado_actual = "Sin Proceso";
        } else {
            // Separar factura boleta y nota venta
            switch ($cotizacion->tipo) {
                case 'factura':
                    $estado_actual = "Facturado";
                    break;
                case 'boleta':
                    $estado_actual = "Boleteado";
                    break;
                case 'nota_venta':
                    $estado_actual = "Nota de Venta Registrada";
                    break;
                default:
                    $estado_actual = "Sin Proceso";
                    break;
            }
        }
        return $estado_actual;
    }
}
