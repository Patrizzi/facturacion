<?php

namespace App\Http\Controllers;

use App\Boleta;
use App\Facturacion;
use App\Moneda;
use App\TipoCambio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function home()
    {
      setlocale(LC_ALL, 'spanish');
// return strftime('%B');
      $moneda_nacional=Moneda::where('id',1)->first();
      $moneda_extranjera=Moneda::where('id',2)->first();
      $coun_fac_hoy=Facturacion::where('fecha_emision',date('d-m-Y'))->get()->count();
      $coun_bol_hoy=Boleta::where('fecha_emision',date('d-m-Y'))->get()->count();

      $fac_mes=Facturacion::where('created_at','>=',Carbon::now()->format('Y-m-01 00:00:00'))->get();
      $bol_mes=Boleta::where('created_at','>=',Carbon::now()->format('Y-m-01 00:00:00'))->get();
      $coun_fac_mes=$fac_mes->count();
      $coun_bol_mes=$bol_mes->count();


      $sum_fac_mes1= $fac_mes->where('moneda_id',1)->where('f_electronica',1)->sum('op_gravada');
      $sum_fac_mes2= $fac_mes->where('moneda_id',1)->where('f_electronica',1)->sum('op_inafecta');
      $sum_fac_mes3= $fac_mes->where('moneda_id',1)->where('f_electronica',1)->sum('op_exonerada');
      $igv_nacional1=($sum_fac_mes1+$sum_fac_mes2+$sum_fac_mes3)*0.18;//IGV en Soles

      $prec_mes_nacional=$moneda_nacional->simbolo.' '.($sum_fac_mes1+$sum_fac_mes2+$sum_fac_mes3);

// return $igv_nacional1;
      $sum_fac_mes1= $fac_mes->where('moneda_id',2)->where('f_electronica',1)->sum('op_gravada');
      $sum_fac_mes2= $fac_mes->where('moneda_id',2)->where('f_electronica',1)->sum('op_inafecta');
      $sum_fac_mes3= $fac_mes->where('moneda_id',2)->where('f_electronica',1)->sum('op_exonerada');

      $tipo_cambio_suma= $fac_mes->where('moneda_id',2)->sum('cambio');//Cambio a soles
      $count_mo_extranjera=$fac_mes->where('moneda_id',2)->count();if ($count_mo_extranjera==0) {$count_mo_extranjera=1;}
      $tipo_cambio_promedio=$tipo_cambio_suma/$count_mo_extranjera;
      $igv_nacional2=(($sum_fac_mes1+$sum_fac_mes2+$sum_fac_mes3)*$tipo_cambio_promedio)*0.18;

      $prec_mes_extranjero=$moneda_extranjera->simbolo.' '.($sum_fac_mes1+$sum_fac_mes2+$sum_fac_mes3);
      // return $prec_mes_extranjero;

      $igv_nacional= $igv_nacional1+ $igv_nacional2;
      $consulta=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();

      return view('home',compact('consulta','coun_fac_hoy','coun_fac_mes','coun_bol_hoy','prec_mes_nacional','prec_mes_extranjero','igv_nacional','moneda_nacional','moneda_extranjera','coun_bol_mes'));
  }


}
