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
    if ($request->sunat_factura_create == null || $request->sunat_factura_create == "") {
      $last_fact = Codigo_guia_almacen::max('serie_factura');
      $new_fact = $last_fact + 1;
    } else {
      $new_fact = $request->sunat_factura_create;
    }
    // boletas
    if ($request->sunat_boleta_create == null || $request->sunat_boleta_create == "") {
      $last_bol = Codigo_guia_almacen::max('serie_boleta');
      $new_bol = $last_bol + 1;
    } else {
      $new_bol = $request->sunat_boleta_create;
    }
    // remision
    if ($request->sunat_remision_create == null || $request->sunat_remision_create == "") {
      $last_remi = Codigo_guia_almacen::max('serie_remision');
      $new_remi = $last_remi + 1;
    } else {
      $new_remi = $request->sunat_remision_create;
    }
    // facturas_manual
    if ($request->sunat_factura_m_create == null || $request->sunat_factura_m_create == "") {
      $last_fact_m = Codigo_guia_almacen::max('serie_factura_m');
      $new_fact_m = $last_fact_m + 1;
    } else {
      $new_fact_m = $request->sunat_factura_m_create;
    }
    // boletas_manual
    if ($request->sunat_boleta_m_create == null || $request->sunat_boleta_m_create == "") {
      $last_bol_m = Codigo_guia_almacen::max('serie_boleta_m');
      $new_bol_m = $last_bol_m + 1;
    } else {
      $new_bol_m = $request->sunat_boleta_m_create;
    }
    // remision_manual
    if ($request->sunat_remision_m_create == null || $request->sunat_remision_m_create == "") {
      $last_remi_m = Codigo_guia_almacen::max('serie_remision_m');
      $new_remi_m = $last_remi_m + 1;
    } else {
      $new_remi_m = $request->sunat_remision_m_create;
    }
    // credito factura
    if ($request->sunat_credit_fact_create == null || $request->sunat_credit_fact_create == "") {
      $last_credito = Codigo_guia_almacen::max('serie_nota_credito');
      $new_cred_fact = $last_credito + 1;
    } else {
      $new_cred_fact = $request->sunat_credit_fact_create;
    }
    // credito boleta
    if ($request->sunat_credit_bol_create == null || $request->sunat_credit_bol_create == "") {
      $last_credito_b = Codigo_guia_almacen::max('serie_nota_credito_b');
      $new_cred_bol = $last_credito_b + 1;
    } else {
      $new_cred_bol = $request->sunat_credit_bol_create;
    }
    // debito
    if ($request->sunat_debito_create == null || $request->sunat_debito_create == "") {
      $last_debito = Codigo_guia_almacen::max('serie_nota_debito');
      $new_debito = $last_debito + 1;
    } else {
      $new_debito = $request->sunat_debito_create;
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
      $new_fact = 1;
    } else {
      $new_fact = $request->cod_fac;
    }
    // boletas
    if ($request->cod_bol == null || $request->cod_bol == "") {
      $new_bol = 1;
    } else {
      $new_bol = $request->cod_bol;
    }
    // remision
    if ($request->cod_guia == null || $request->cod_guia == "") {
      $new_remi = 1;
    } else {
      $new_remi = $request->cod_guia;
    }
    // facturas_manual
    if ($request->cod_factura_m == null || $request->cod_factura_m == "") {
      $new_fact_m = 1;
    } else {
      $new_fact_m = $request->cod_factura_m;
    }
    // boletas_manual
    if ($request->cod_boleta_m == null || $request->cod_boleta_m == "") {
      $new_bol_m = 1;
    } else {
      $new_bol_m = $request->cod_boleta_m;
    }
    // remision_manual
    if ($request->cod_remision_m == null || $request->cod_remision_m == "") {
      $new_remi_m = 1;
    } else {
      $new_remi_m = $request->cod_remision_m;
    }
    // credito factura
    if ($request->cod_credito == null || $request->cod_credito == "") {
      $new_cred_fact = 1;
    } else {
      $new_cred_fact = $request->cod_credito;
    }
    // credito boleta
    if ($request->cod_credito_b == null || $request->cod_credito_b == "") {
      $new_cred_bol = 1;
    } else {
      $new_cred_bol = $request->cod_credito_b;
    }
    // debito
    if ($request->cod_debito == null || $request->cod_debito == "") {
      $new_debito = 1;
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
    if (!$factura) {
      return [
        'serie' => null,
        'correlativo' => null,
      ];
    }
    $factura_num_string_porcion = explode("-", $factura->codigo_fac);
    $last_fact = [
      "serie" => $factura_num_string_porcion[0],
      "correlativo" => $factura_num_string_porcion[1]
    ];
    return  $last_fact;
  }
  public static function search_last_bol($id_almacen)
  {
    $boleta = Boleta::where('almacen_id', $id_almacen)->latest()->first();
    if (!$boleta) {
      return [
        'serie' => null,
        'correlativo' => null,
      ];
    }
    $boleta_num_string_porcion = explode("-", $boleta->codigo_boleta);
    $last_bol = [
      "serie" => $boleta_num_string_porcion[0],
      "correlativo" => $boleta_num_string_porcion[1]
    ];
    return  $last_bol;
  }
  public static function search_last_remision($id_almacen)
  {
    $remision = Guia_remision::where('almacen_id', $id_almacen)->latest()->first();
    if (!$remision) {
      return [
        'serie' => null,
        'correlativo' => null,
      ];
    }
    $remision_num_string_porcion = explode("-", $remision->cod_guia);
    $last_remision = [
      "serie" => $remision_num_string_porcion[0],
      "correlativo" => $remision_num_string_porcion[1]
    ];
    return  $last_remision;
  }

  public static function search_last_factura_m($id_almacen)
  {
    $factura_m = Facturacion_m::where('almacen_id', $id_almacen)->latest()->first();
    if (!$factura_m) {
      return [
        'serie' => null,
        'correlativo' => null,
      ];
    }
    $factura_m_num_string_porcion = explode("-", $factura_m->codigo_fac);
    $last_factura_m = [
      "serie" => $factura_m_num_string_porcion[0],
      "correlativo" => $factura_m_num_string_porcion[1]
    ];
    return  $last_factura_m;
  }

  public static function search_last_boleta_m($id_almacen)
  {
    $boleta_m = Boleta_m::where('almacen_id', $id_almacen)->latest()->first();
    if (!$boleta_m) {
      return [
        'serie' => null,
        'correlativo' => null,
      ];
    }
    $boleta_m_num_string_porcion = explode("-", $boleta_m->codigo_boleta);
    $last_boleta_m = [
      "serie" => $boleta_m_num_string_porcion[0],
      "correlativo" => $boleta_m_num_string_porcion[1]
    ];
    return  $last_boleta_m;
  }

  public static function search_last_remision_m($id_almacen)
  {
    $remision_m = GuiaRemisionManual::where('almacen_id', $id_almacen)->latest()->first();
    if (!$remision_m) {
      return [
        'serie' => null,
        'correlativo' => null,
      ];
    }
    $remision_m_num_string_porcion = explode("-", $remision_m->cod_guia);
    $last_remision_m = [
      "serie" => $remision_m_num_string_porcion[0],
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
    if (!$credito_fact) {
      return [
        'serie' => null,
        'correlativo' => null,
      ];
    }
    $credito_fact_num_string_porcion = explode("-", $credito_fact->codigo_n_c);
    $last_credito_f = [
      "serie" => $credito_fact_num_string_porcion[0],
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
    if (!$credito_bol) {
      return [
        'serie' => null,
        'correlativo' => null,
      ];
    }
    $credito_bol_num_string_porcion = explode("-", $credito_bol->codigo_n_c);
    $last_credito_b = [
      "serie" => $credito_bol_num_string_porcion[0],
      "correlativo" => $credito_bol_num_string_porcion[1]
    ];
    return  $last_credito_b;
  }
  public static function search_last_debito($id_almacen)
  {
    $debito = Nota_Debito::where('almacen_id', $id_almacen)->latest()->first();
    if (!$debito) {
      return [
        'serie' => null,
        'correlativo' => null,
      ];
    }
    $debito_num_string_porcion = explode("-", $debito->codigo_n_d);
    $last_debito = [
      "serie" => $debito_num_string_porcion[0],
      "correlativo" => $debito_num_string_porcion[1]
    ];
    return  $last_debito;
  }
}
