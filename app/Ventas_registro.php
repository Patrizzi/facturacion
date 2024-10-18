<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ventas_registro extends Model
{
	protected $table = 'ventas_registro';

	protected $guarded = [];

	// public function facturacion(){
	// 	return $this->belongsTo(Facturacion::class,'id_facturacion');
	// }

	public function cotizacion_pro(){
		return $this->belongsTo(Cotizacion::class,'id_coti_produc');
	}
	public function cotizacion_servi(){
		return $this->belongsTo(Cotizacion_Servicios::class,'id_coti_servicio');
	}
	public function id_facturacion(){
		return $this->belongsTo(Facturacion::class,'id_fac');
	}
	public function id_boleta(){
		return $this->belongsTo(Boleta::class,'id_bol');
	}
	public function moneda(){
		return $this->belongsTo(Moneda::class,'tipo_moneda');
	}
 //    public function forma_pago(){
 //        return $this->belongsTo(forma_pago::class,'forma_pago_id');
 //    }
 //    public function personal(){
 //        return $this->belongsTo(Personal::class,'personal_id');
 //    }

	public static function count_day_ventas(){
		// Fecha de Hoy
		$fecha_conv = Carbon::now()->format('Y-m-d');
		$cotizacion_dia = Cotizacion::whereDate('created_at', '=', $fecha_conv )->count();

		$cotizacion_manual_dia = CotizacionManual::whereDate('created_at', '=', $fecha_conv )->count();

		$nota_venta_dia = NotaVenta::whereDate('created_at', '=', $fecha_conv )->count();

		$count_mes = array(
            "cotizacion_day_count" => $cotizacion_dia,
            "cotizacion_m_day_count" => $cotizacion_manual_dia,
            "nota_venta_day_count" => $nota_venta_dia
            
        );

		return $count_mes;
	}

}
