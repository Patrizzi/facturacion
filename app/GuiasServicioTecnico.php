<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuiasServicioTecnico extends Model
{
    public function count_month_ventas($mes_año)
	{
		$guia_ingreso = GarantiaGuiaIngreso::count_month_comprobantes($mes_año);
		// $guia_ingreso = GarantiaGuiaIngreso::count_month_comprobantes($mes_año);
		// $guia_ingreso = GarantiaGuiaIngreso::count_month_comprobantes($mes_año);
	}
}
