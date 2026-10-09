<?php

namespace App\Observers;

use App\Boleta;
use App\Cuotas_credito;
use App\Facturacion;
use App\Facturacion_m;

class CuotasCreditosObserver
{
    /**
     * Handle the cuotas_credito "created" event.
     *
     * @param  \App\Cuotas_credito  $cuotas
     * @return void
     */
    public function created(Cuotas_credito $cuotas)
    {
        //
    }

    /**
     * Handle the cuotas_credito "updated" event.
     *
     * @param  \App\Cuotas_credito  $cuotas
     * @return void
     */
    public function updated(Cuotas_credito $cuotas)
    {
        // dd($cuotas);
        if (!$cuotas->wasChanged('estado')) {
            return;
        }
        if ($cuotas->factura_id != null) {
            // factura
            $factura  = Facturacion::find($cuotas->factura_id);
            $cuotas_totales = Cuotas_credito::where('facturacion_id', $factura->id)->count();
            $cuotas_canceladas = Cuotas_credito::where('facturacion_id', $factura->id)->where('estado', 2)->count();
            if ($cuotas_totales == $cuotas_canceladas) { //Si todo es pagado
                $factura->estado_pago =  2;
                $factura->save();
            } else {
                if ($cuotas_canceladas > 0) { //Si solo se paga 1 cuota 
                    $factura->estado_pago =  1;
                    $factura->save();
                }
            }
        } elseif ($cuotas->facturacion_m_id) {
            $factura_m  = Facturacion_m::find($cuotas->facturacion_m_id);
            $cuotas_totales = Cuotas_credito::where('facturacion_m_id', $factura_m->id)->count();
            $cuotas_canceladas = Cuotas_credito::where('facturacion_m_id', $factura_m->id)->where('estado', 2)->count();
            if ($cuotas_totales == $cuotas_canceladas) { //Si todo es pagado
                $factura_m->estado_pago =  2;
                $factura_m->save();
            } else {
                if ($cuotas_canceladas > 0) { //Si solo se paga 1 cuota 
                    $factura_m->estado_pago =  1;
                    $factura_m->save();
                }
            }
        } elseif ($cuotas->boleta_id) {
            $boleta  = Boleta::find($cuotas->boleta_id);
            $cuotas_totales = Cuotas_credito::where('boleta_id', $boleta->id)->count();
            $cuotas_canceladas = Cuotas_credito::where('boleta_id', $boleta->id)->where('estado', 2)->count();
            if ($cuotas_totales == $cuotas_canceladas) { //Si todo es pagado
                $boleta->estado_pago =  2;
                $boleta->save();
            } else {
                if ($cuotas_canceladas > 0) {  //Si solo se paga 1 cuota 
                    $boleta->estado_pago =  1;
                    $boleta->save();
                }
            }
        } elseif ($cuotas->boleta_m_id) {
            $boleta_m  = Boleta::find($cuotas->boleta_m_id);
            $cuotas_totales = Cuotas_credito::where('boleta_m_id', $boleta_m->id)->count();
            $cuotas_canceladas = Cuotas_credito::where('boleta_m_id', $boleta_m->id)->where('estado', 2)->count();
            if ($cuotas_totales == $cuotas_canceladas) { //Si todo es pagado
                $boleta_m->estado_pago =  2;
                $boleta_m->save();
            } else {
                if ($cuotas_canceladas > 0) { //Si solo se paga 1 cuota 
                    $boleta_m->estado_pago =  1;
                    $boleta_m->save();
                }
            }
        }
    }

    /**
     * Handle the cuotas_credito "deleted" event.
     *
     * @param  \App\Cuotas_credito  $cuotas
     * @return void
     */
    public function deleted(Cuotas_credito $cuotas)
    {
        //
    }

    /**
     * Handle the cuotas_credito "restored" event.
     *
     * @param  \App\Cuotas_credito  $cuotas
     * @return void
     */
    public function restored(Cuotas_credito $cuotas)
    {
        //
    }

    /**
     * Handle the cuotas_credito "force deleted" event.
     *
     * @param  \App\Cuotas_credito  $cuotas
     * @return void
     */
    public function forceDeleted(Cuotas_credito $cuotas)
    {
        //
    }
}
