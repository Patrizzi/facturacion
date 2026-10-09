<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GuiasServicioTecnico extends Model
{

	public static function count_day_comprobantes()
	{
		$fecha_conv = Carbon::now()->format('Y-m-d');
		$guia_ingreso = GarantiaGuiaIngreso::whereDate('created_at', '=', $fecha_conv)->count();
		$guia_egreso = GarantiaGuiaEgreso::whereDate('created_at', '=', $fecha_conv)->count();
		$informe_tecnico = GarantiaInformeTecnico::whereDate('created_at', '=', $fecha_conv)->count();

		$count_mes = array(
			"g_ingreso_day_count" => $guia_ingreso,
			"g_egreso_day_count" => $guia_egreso,
			"i_tecnico_day_count" => $informe_tecnico
		);

		return $count_mes;
	}

	public static function count_month_ventas($mes_año)
	{
		$guia_ingreso = GarantiaGuiaIngreso::count_month_comprobantes($mes_año);
		$guia_egreso = GarantiaGuiaEgreso::count_month_comprobantes($mes_año);
		$informe_tecnico = GarantiaInformeTecnico::count_month_comprobantes($mes_año);

		$ingreso_last_update = GarantiaGuiaIngreso::latest()->first();
        $egreso_last_update = GarantiaGuiaEgreso::latest()->first();
        $tecnico_last_update = GarantiaInformeTecnico::latest()->first();

        $g_ingreso_last_update = optional($ingreso_last_update)->updated_at ? $ingreso_last_update->updated_at->diffForHumans() : "sin registros";
        $g_egreso_last_update = optional($egreso_last_update)->updated_at ? $egreso_last_update->updated_at->diffForHumans() : "sin registros";
        $i_tecnico_last_update = optional($tecnico_last_update)->updated_at ? $tecnico_last_update->updated_at->diffForHumans() : "sin registros";



		$count_mes = array(
            "g_ingreso_month_count" => $guia_ingreso,
            "g_ingreso_last_update" => $g_ingreso_last_update,
            "g_egreso_month_count" => $guia_egreso,
            "g_egreso_last_update" => $g_egreso_last_update,
            "i_tecnico_month_count" => $informe_tecnico,
            "i_tecnico_last_update" => $i_tecnico_last_update
		);
		return $count_mes;
	}
}
