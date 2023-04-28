<?php

namespace App\Http\Controllers;

use App\Boleta;
use App\Boleta_m;
use App\Empresa;
use App\Producto;
use App\Igv;
use App\Facturacion;
use App\Facturacion_m;
use App\Facturacion_registro;
use App\Facturacion_registro_m;
use App\Kardex_entrada;
use App\kardex_entrada_registro;
use App\Moneda;
use App\Stock_almacen;
use App\Stock_producto;
use App\Nota_Credito;
use App\Nota_Credito_registro;
use App\TipoCambio;
use Carbon\Carbon;
use Doctrine\DBAL\Types\ObjectType;
use Illuminate\Http\Request;
use KardexEntradaRegistroSeeder;

class ViewController extends Controller
{
  
  public function home()
  {
    setlocale(LC_ALL, 'spanish');

    $moneda_nacional=Moneda::where('nombre','soles')->first();
    $moneda_ext=Moneda::where('nombre','Dolares')->first();

    $igv = Igv::first();
    $igv_total = $igv->igv_total;
    $consulta = TipoCambio::where('fecha', Carbon::now()->format('Y-m-d'))->first();
    $empresa = Empresa::first();

    /* CALCULO PARA COMPRAS*/
    $all_kardex = Kardex_entrada::where('estado',1)->where('created_at','>=',Carbon::now()->format('Y-m-01 00:00:00'))->get();
    //* Moneda Nacional SOL
    $tot_sum_kardex = $all_kardex->sum('precio_nacional_total');
    $return_kardex = $moneda_nacional->simbolo.' '.number_format($tot_sum_kardex,2);
    //* Moneda EXTRANJERA Dollar
    $tot_sum_kardex_ext = $all_kardex->sum('precio_extranjero_total');
    $return_kardex_ext = $moneda_ext->simbolo.' '.number_format($tot_sum_kardex_ext,2);
    // return $return_kardex_ext;
    // $fac_ma_mes = [];
    /* Caclulo de Compras Facturas */
    $fac_mes=Facturacion::where('created_at','>=',Carbon::now()->format('Y-m-01 00:00:00'))->where('f_electronica',1)->where('nota_credito', 0)->get();
    $fac_ma_mes=Facturacion_m::where('created_at','>=',Carbon::now()->format('Y-m-01 00:00:00'))->where('f_electronica',1)->where('nota_credito', 0)->get();
    // return count($fac_ma_mes);
    $all_fact = 0;
    $all_fact_m2 = 0;    
    // if(count($fac_mes) > 0){
    
    foreach ($fac_mes as $value) {
      if($value->moneda->nombre == "soles"){
        $sub_op = $value->op_gravada + $value->op_inafecta + $value->op_exonerada;
        $all_fact += round($sub_op + ($sub_op * ($igv_total/100)),2);
      }else{
        $op_grav_m2 = $value->op_gravada*$value->cambio;
        $op_ina_m2 = $value->op_inafecta*$value->cambio;
        $op_exo_m2 = $value->op_exonerada*$value->cambio;
        $sum_op_m2 = $op_grav_m2 + $op_ina_m2 + $op_exo_m2;
        $all_fact_m2 += round($sum_op_m2 + ($sum_op_m2 * ($igv_total/100)),2);
      }
      //* Intento de 2 monedas *//
      
    }
    // }
    $all_m_fact = 0;
    $all_m_fact_m2 = 0;
    // return count($fac_ma_mes);
    // if(count($fac_ma_mes) > 0){  
    foreach ($fac_ma_mes as $value_m) {
      if($value_m->moneda->nombre == "soles"){
        $sub_op_m = $value_m->op_gravada + $value_m->op_inafecta + $value_m->op_exonerada;
        $all_m_fact += round($sub_op_m + ($sub_op_m * ($igv_total/100)),2);
      }else{
        $op_grav_m_2 = $value_m->op_gravada*$value_m->cambio;
        $op_ina_m_2 = $value_m->op_inafecta*$value_m->cambio;
        $op_exo_m_2 = $value_m->op_exonerada*$value_m->cambio;
        $sum_op_m_2 = $op_grav_m_2 + $op_ina_m_2 + $op_exo_m_2;
        $all_m_fact_m2 += round($sum_op_m_2 + ($sum_op_m_2 * ($igv_total/100)),2);
      }      
    }
    // return "a";
      /* Calculo de Ventas FACTURA NORMAL + MANUAL */
      $tot_fact = $all_fact + $all_fact_m2;
      $tot_fact_2 = $all_m_fact + $all_m_fact_m2;

      $total_fac_nac = round($tot_fact + $tot_fact_2,2);
      $return_tot_fact = $moneda_nacional->simbolo.' '.number_format($total_fac_nac,2);
    
    // return $return_tot_fact;
    /* Caclulo de Compras Boletas */
    
    $bol_mes=Boleta::where('created_at','>=',Carbon::now()->format('Y-m-01 00:00:00'))->where('b_electronica',1)->get();
    $bol_ma_mes=Boleta_m::where('created_at','>=',Carbon::now()->format('Y-m-01 00:00:00'))->where('b_electronica',1)->get();
    // if(coiu){

    // }else{

    // }
    $all_bol = 0;
    $all_bol_m2 = 0;
    foreach ($bol_mes as $value_bol) {
      if($value_bol->moneda->nombre == "soles" ){
        $b_sub_op = $value_bol->op_gravada + $value_bol->op_exonerada + $value_bol->op_inafecta;
        $all_bol += round($b_sub_op + ($b_sub_op * ($igv_total/100)),2);
      }else{
        $b_op_grav_m2 = $value_bol->op_gravada*$value_bol->cambio;
        $b_op_ina_m2 = $value_bol->op_inafecta*$value_bol->cambio;
        $b_op_exo_m2 = $value_bol->op_exonerada*$value_bol->cambio;
        $b_sum_op_m2 = $b_op_grav_m2 + $b_op_ina_m2 + $b_op_exo_m2;
        $all_bol_m2 += round($b_sum_op_m2 + ($b_sum_op_m2 * ($igv_total/100)),2);
      }
    }
    $all_m_bol = 0;
    $all_m_bol_m2 = 0;
    foreach ($bol_ma_mes as $value_bol_m) {
      if($value_bol_m->moneda->nombre == "soles" ){
        $b_sub_m_op = $value_bol_m->op_gravada + $value_bol_m->op_exonerada + $value_bol_m->op_inafecta;
        $all_m_bol += round($b_sub_m_op + ($b_sub_m_op * ($igv_total/100)),2);
      }else{
        $b_op_grav_m_2 = $value_bol_m->op_gravada*$value_bol_m->cambio;
        $b_op_ina_m_2 = $value_bol_m->op_inafecta*$value_bol_m->cambio;
        $b_op_exo_m_2 = $value_bol_m->op_exonerada*$value_bol_m->cambio;
        $b_sum_op_m_2 = $b_op_grav_m_2 + $b_op_ina_m_2 + $b_op_exo_m_2;
        $all_m_bol_m2 += round($b_sum_op_m_2 + ($b_sum_op_m_2 * ($igv_total/100)),2);
      }
    }
    $tot_bol = $all_bol + $all_bol_m2;
    $tot_bol_2 = $all_m_bol + $all_m_bol_m2;

    /* Calculo de Ventas BOLETA NORMAL + MANUAL */
    $total_bol_nac = round($tot_bol + $tot_bol_2,2);
    $return_tot_bol = $moneda_nacional->simbolo.' '.number_format($total_bol_nac,2);
    
    /* Retorno*/

    /* Producto mas Vendido */

    if(count($fac_mes) > 0){
      foreach ($fac_mes as $fac_id) {
        $id_factura[] = $fac_id->id;
      }
      //*FACTURA NORMAL
      $max_stock_prod = Facturacion_registro::selectRaw('producto_id, SUM(cantidad) as Total')->whereIn('facturacion_id',$id_factura)->groupBy('producto_id')->orderby('Total','desc')->limit(5)->get();
      foreach ($max_stock_prod as $key => $prod_id) {
        $product_id[] = $max_stock_prod[$key]->producto_id;
      }
    }else{
      $id_factura = array(null);
      $product_id = array(null);
    }

    if(count($fac_ma_mes) > 0){
      foreach ($fac_ma_mes as $fac_m_id) {
        $id_factura_m[] = $fac_m_id->id;
      }
      //*FACTURA MANUAL
      $max_man_stock_prod = Facturacion_registro_m::selectRaw('producto_id, SUM(cantidad) as Total')->whereIn('facturacion_m_id',$id_factura_m)->groupBy('producto_id')->orderby('Total','desc')->limit(5)->get();
      foreach ($max_man_stock_prod as $key => $prod_m_id) {
        $product_m_id[] = $max_man_stock_prod[$key]->producto_id;
      }
    }else{
      $id_factura_m = array(null);
      $product_m_id = array(null);
    }
        
    $var = array_unique(array_merge(array_filter($product_id) ,array_filter($product_m_id)));
    // $array_prod_all = [];
    foreach ($var as $item => $reg_ka ) {
      $tot_pre_pro = 0;
      $cantidad = 0;
      // return $reg_ka->factura_ids->moneda->nombre;
      $producto = Producto::where('id',$reg_ka)->first();
      // $var[] = $registro->where('producto_id',$producto->id)->get();
      // $p_id[] = $reg_ka->producto_id;
      if(count($fac_mes) > 0){
        $registro = Facturacion_registro::whereIn('facturacion_id',$id_factura)->where('producto_id',$producto->id)->orderby('cantidad','desc')->get();
        foreach ($registro as $key => $reg) {
          $cantidad += $reg->cantidad;
          if($reg->factura_ids->moneda == 'soles'){
            $precio_c = $reg->precio_unitario_comi; 
          }else{
            $precio_c = $reg->precio_unitario_comi; 
          }
          $tot_pre_pro += $precio_c;
        }
      }
      if(count($fac_ma_mes) > 0){
        $registro_m = Facturacion_registro_m::whereIn('facturacion_m_id',$id_factura_m)->where('producto_id',$producto->id)->orderby('cantidad','desc')->get();
        foreach ($registro_m as $key => $reg_m) {
          $cantidad += $reg_m->cantidad;
          if($reg_m->factura_ids->moneda == 'soles'){
            $precio_c = $reg_m->precio; 
          }else{
            $precio_c = $reg_m->precio; 
          }
          $tot_pre_pro += $precio_c;
        }
      }
      // return $registro_m;
      // $gol[] = $tot_pre_pro;
      if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
        $total = number_format($tot_pre_pro + ( $tot_pre_pro * ($igv_total/100) ),2);
      }else{
        $total = number_format($tot_pre_pro);
      }
      $array_prod_all[] = array("nombre" => $producto->nombre,"imagen"=> $producto->foto, "precio" => $moneda_nacional->simbolo.' '.$total, "cantidad" => $cantidad);
      $tot_pre_pro = 0;
      $cantidad = 0;
    }
    
    if(count($fac_mes) == 0 && count($fac_ma_mes) == 0 || count($var) == 0 ){
      $array_prod_all[] = array("cantidad" => 0);
    }else{
      array_multisort(array_column($array_prod_all, "cantidad"), SORT_DESC, $array_prod_all);
    }
    // return $array_prod_all;
    return view('home', compact('empresa','return_tot_fact','return_tot_bol','return_kardex','return_kardex_ext','array_prod_all'));
  }
}
