<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditosAdelantos extends Model
{
    protected $table = 'creditos_adelantos';

    protected $guarded = [];

    public function factura_ids(){
        return $this->belongsTo(Facturacion::class,'factura_id');
    }
    public function factura_m_ids(){
        return $this->belongsTo(Facturacion_m::class,'factura_m_id');
    }
    public function boleta_ids(){
        return $this->belongsTo(Boleta::class,'boleta_id');
    }
    public function boleta_m_ids(){
        return $this->belongsTo(Boleta_m::class,'boleta_m_id');
    }
    public function nota_venta_id(){
        return $this->belongsTo(NotaVenta::class,'nota_ven_id');
    }

    public static function cambio_estado_adl($id_cuota){
        $cuota_change = Cuotas_credito::find($id_cuota);
        $cuota_change->estado = 1;
        $cuota_change->save;
    }

    public static function cambio_estado_facturas_adl   ($id_factura, $tipo){
        if ($tipo == "factura") {
            $factura = Facturacion::find($id_factura);
            $factura->estado_pago = 1;
            $factura->save();
        }else{
            $factura = Facturacion_m::find($id_factura);
            $factura->estado_pago = 1;
            $factura->save();
        }
    }
}
