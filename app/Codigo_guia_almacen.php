<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codigo_guia_almacen extends Model
{
  protected $table = 'cod_guia_almacen';

  protected $guarded = [];

  public function id_almacen()
  {
    return $this->belongsTo(Almacen::class);
  }

  public static function new_series($request)
  {
    // facturas
    if ($request->serie_factura == null || $request->serie_factura == "") {
      $last_fact = Codigo_guia_almacen::max('serie_factura');
      $new_fact = $last_fact + 1;
    } else {
      $new_fact = $request->serie_factura;
    }
    // boletas
    if ($request->serie_boleta == null || $request->serie_boleta == "") {
      $last_bol = Codigo_guia_almacen::max('serie_boleta');
      $new_bol = $last_bol + 1;
    } else {
      $new_bol = $request->serie_boleta;
    }
    // remision
    if ($request->serie_remision == null || $request->serie_remision == "") {
      $last_remi = Codigo_guia_almacen::max('serie_remision');
      $new_remi = $last_remi + 1;
    } else {
      $new_remi = $request->serie_remision;
    }
    // facturas_manual
    if ($request->serie_factura_m == null || $request->serie_factura_m == "") {
      $last_fact_m = Codigo_guia_almacen::max('serie_factura_m');
      $new_fact_m = $last_fact_m + 1;
    } else {
      $new_fact_m = $request->serie_factura_m;
    }
    // boletas_manual
    if ($request->serie_boleta_m == null || $request->serie_boleta_m == "") {
      $last_bol_m = Codigo_guia_almacen::max('serie_boleta_m');
      $new_bol_m = $last_bol_m + 1;
    } else {
      $new_bol_m = $request->serie_boleta_m;
    }
    // remision_manual
    if ($request->serie_remision_m == null || $request->serie_remision_m == "") {
      $last_remi_m = Codigo_guia_almacen::max('serie_remision_m');
      $new_remi_m = $last_remi_m + 1;
    } else {
      $new_remi_m = $request->serie_remision_m;
    }
    // credito factura
    if ($request->serie_credito == null || $request->serie_credito == "") {
      $last_credito = Codigo_guia_almacen::max('serie_nota_credito');
      $new_cred_fact = $last_credito + 1;
    } else {
      $new_cred_fact = $request->serie_credito;
    }
    // credito boleta
    if ($request->serie_credito_b == null || $request->serie_credito_b == "") {
      $last_credito_b = Codigo_guia_almacen::max('serie_nota_credito_b');
      $new_cred_bol = $last_credito_b + 1;
    } else {
      $new_cred_bol = $request->serie_credito_b;
    }
    // debito
    if ($request->serie_debito == null || $request->serie_debito == "") {
      $last_debito = Codigo_guia_almacen::max('serie_nota_debito');
      $new_debito = $last_debito + 1;
    } else {
      $new_debito = $request->serie_debito;
    }

    // return
    $data = [
      "factura" => $new_fact,
      "boleta" => $new_bol,
      "remision" => $new_remi,
      "factura_m" => $new_fact_m,
      "boleta_m" => $new_bol_m,
      "remision_m" => $new_remi_m,
      "credito_fact" => $new_cred_fact,
      "credito_bol" => $new_cred_bol,
      "debito" => $new_debito
    ];
    return $data;
  }

  public static function new_correlative($request)
  {
    // facturas
    if ($request->cod_fac == null || $request->cod_fac == "") {
      $last_fact = Codigo_guia_almacen::max('cod_factura');
      $new_fact = $last_fact + 1;
    } else {
      $new_fact = $request->cod_fac;
    }
    // boletas
    if ($request->cod_bol == null || $request->cod_bol == "") {
      $last_bol = Codigo_guia_almacen::max('cod_bol');
      $new_bol = $last_bol + 1;
    } else {
      $new_bol = $request->cod_bol;
    }
    // remision
    if ($request->cod_guia == null || $request->cod_guia == "") {
      $last_remi = Codigo_guia_almacen::max('cod_remision');
      $new_remi = $last_remi + 1;
    } else {
      $new_remi = $request->cod_guia;
    }
    // facturas_manual
    if ($request->cod_factura_m == null || $request->cod_factura_m == "") {
      $last_fact_m = Codigo_guia_almacen::max('cod_factura_m');
      $new_fact_m = $last_fact_m + 1;
    } else {
      $new_fact_m = $request->cod_factura_m;
    }
    // boletas_manual
    if ($request->cod_boleta_m == null || $request->cod_boleta_m == "") {
      $last_bol_m = Codigo_guia_almacen::max('cod_boleta_m');
      $new_bol_m = $last_bol_m + 1;
    } else {
      $new_bol_m = $request->cod_boleta_m;
    }
    // remision_manual
    if ($request->cod_remision_m == null || $request->cod_remision_m == "") {
      $last_remi_m = Codigo_guia_almacen::max('cod_remision_m');
      $new_remi_m = $last_remi_m + 1;
    } else {
      $new_remi_m = $request->cod_remision_m;
    }
    // credito factura
    if ($request->cod_credito == null || $request->cod_credito == "") {
      $last_credito = Codigo_guia_almacen::max('cod_nota_credito');
      $new_cred_fact = $last_credito + 1;
    } else {
      $new_cred_fact = $request->cod_credito;
    }
    // credito boleta
    if ($request->cod_credito_b == null || $request->cod_credito_b == "") {
      $last_credito_b = Codigo_guia_almacen::max('cod_nota_credito_b');
      $new_cred_bol = $last_credito_b + 1;
    } else {
      $new_cred_bol = $request->cod_credito_b;
    }
    // debito
    if ($request->cod_debito == null || $request->cod_debito == "") {
      $last_debito = Codigo_guia_almacen::max('cod_nota_debito');
      $new_debito = $last_debito + 1;
    } else {
      $new_debito = $request->cod_debito;
    }

    // return
    $data_correlativo = [
      "factura" => $new_fact,
      "boleta" => $new_bol,
      "remision" => $new_remi,
      "factura_m" => $new_fact_m,
      "boleta_m" => $new_bol_m,
      "remision_m" => $new_remi_m,
      "credito_fact" => $new_cred_fact,
      "credito_bol" => $new_cred_bol,
      "debito" => $new_debito
    ];
    return $data_correlativo;
  }

  public static function search_last_fact($id_almacen)
  {
    $factura = Facturacion::where('almacen_id', $id_almacen)->latest()->first();
    $factura_num_string_porcion = explode("-", $factura->codigo_fac);
    $last_fact = [
       "serie" => mb_substr($factura_num_string_porcion[0], 1),
       "correlativo" => $factura_num_string_porcion[1]
    ];
    return  $last_fact;
  }
  public static function search_last_bol($id_almacen)
  {
    $boleta = Boleta::where('almacen_id', $id_almacen)->latest()->first();
    $boleta_num_string_porcion = explode("-", $boleta->codigo_boleta);
    $last_bol = [
       "serie" => mb_substr($boleta_num_string_porcion[0], 1),
       "correlativo" => $boleta_num_string_porcion[1]
    ];
    return  $last_bol;
  }
  public static function search_last_remision($id_almacen)
  {
    $remision = Guia_remision::where('almacen_id', $id_almacen)->latest()->first();
    $remision_num_string_porcion = explode("-", $remision->cod_guia);
    $last_remision = [
       "serie" => mb_substr($remision_num_string_porcion[0], 1),
       "correlativo" => $remision_num_string_porcion[1]
    ];
    return  $last_remision;
  }

  public static function search_last_factura_m($id_almacen)
  {
    $factura_m = Facturacion_m::where('almacen_id', $id_almacen)->latest()->first();
    $factura_m_num_string_porcion = explode("-", $factura_m->codigo_fac);
    $last_factura_m = [
       "serie" => mb_substr($factura_m_num_string_porcion[0], 2),
       "correlativo" => $factura_m_num_string_porcion[1]
    ];
    return  $last_factura_m;
  }
  
  public static function search_last_boleta_m($id_almacen)
  {
    $boleta_m = Boleta_m::where('almacen_id', $id_almacen)->latest()->first();
    $boleta_m_num_string_porcion = explode("-", $boleta_m->codigo_boleta);
    $last_boleta_m = [
       "serie" => mb_substr($boleta_m_num_string_porcion[0], 2),
       "correlativo" => $boleta_m_num_string_porcion[1]
    ];
    return  $last_boleta_m;
  }

  public static function search_last_remision_m($id_almacen)
  {
    $remision_m = GuiaRemisionManual::where('almacen_id', $id_almacen)->latest()->first();
    $remision_m_num_string_porcion = explode("-", $remision_m->cod_guia);
    $last_remision_m = [
       "serie" => mb_substr($remision_m_num_string_porcion[0], 2),
       "correlativo" => $remision_m_num_string_porcion[1]
    ];
    return  $last_remision_m;
  }

  public static function search_last_credito_f($id_almacen)
  {
    $credito_fact = Nota_Credito::where('almacen_id', $id_almacen)
      ->where(function ($query) {
          $query->whereNotNull('facturacion_id')
                ->orWhereNotNull('facturacion_m_id');
      })->latest()->first();
    $credito_fact_num_string_porcion = explode("-", $credito_fact->codigo_n_c);
    $last_credito_f = [
       "serie" => mb_substr($credito_fact_num_string_porcion[0], 2),
       "correlativo" => $credito_fact_num_string_porcion[1]
    ];
    return  $last_credito_f;
  }
  public static function search_last_credito_b($id_almacen)
  {
    $credito_bol = Nota_Credito::where('almacen_id', $id_almacen)
      ->where(function ($query) {
          $query->whereNotNull('boleta_id')
                ->orWhereNotNull('boleta_m_id');
      })->latest()->first();
    $credito_bol_num_string_porcion = explode("-", $credito_bol->codigo_n_c);
    $last_credito_b = [
       "serie" => mb_substr($credito_bol_num_string_porcion[0], 2),
       "correlativo" => $credito_bol_num_string_porcion[1]
    ];
    return  $last_credito_b;
  }
  public static function search_last_debito($id_almacen)
  {
    $debito = Nota_Debito::where('almacen_id', $id_almacen)->latest()->first();
    $debito_num_string_porcion = explode("-", $debito->codigo_n_d);
    $last_debito = [
       "serie" => mb_substr($debito_num_string_porcion[0], 2),
       "correlativo" => $debito_num_string_porcion[1]
    ];
    return  $last_debito;
  }

}
