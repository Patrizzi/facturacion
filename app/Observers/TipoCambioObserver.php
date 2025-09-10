<?php

namespace App\Observers;

use App\Cliente;
use App\GarantiaGuiaEgreso;
use App\TipoCambio;
use App\Servicios;
use App\Moneda;
use App\Nota_Credito;
use App\Tipo_operacion_f;
use Carbon\Carbon;

class TipoCambioObserver
{
    /**
     * Handle the TipoCambio "created" event.
     *
     * @param  \App\TipoCambio  $tipoCambio
     * @return void
     */
    public function created(TipoCambio $tipoCambio)
    {
        // Tipo de cambio -------------------------------------------------------------------------------------
        $cambio=TipoCambio::latest('created_at')->first();

        //  Moneda --------------------------------------------------------------------------------------------
        $moneda_principal=Moneda::where('tipo','nacional')->first();
        $moneda_principal_id=$moneda_principal->id;

        $servicios=servicios::get();
        foreach ($servicios as $servicio) {
            $servicio_id=$servicio->id;
            $servicio=servicios::find($servicio_id);
            // obtencion de la moneda en el servicio
            $moneda_id=$servicio->moneda_id;
            // Generar Cambio para precio nacional y precio extranjero ----------------------------------------------
            if($moneda_principal_id==$moneda_id){
                $precio_nacional=$servicio->precio_nacional;
                $precio_extranjero=$precio_nacional/$cambio->paralelo;
                $servicio->precio_extranjero=round($precio_extranjero,2);
                $servicio->save();
            }else{
                $precio_extranjero=$servicio->precio_extranjero;
                $precio_nacional=$precio_extranjero*$cambio->paralelo;
                $servicio->precio_nacional=round($precio_nacional,2);
                $servicio->save();
            }
        }
        //* Buscar notas de credito de hace 30 dias?
        // Nota_Credito::nota_credito_month();
        Tipo_operacion_f::add_new_items();

        // fecha actual - 30 dias
        $fecha_limite = Carbon::now()->subDays(30);

        // encontrar todos los registros GarantiasIngresos menores e iguales que el resultado de $fecha_limite, que son estado 1 para actualizarlo a estado 2
        GarantiaGuiaEgreso::where('created_at', '<=', $fecha_limite)->where('estado', 1)->update(['estado' => 2]);

    }

    /**
     * Handle the TipoCambio "updated" event.
     *
     * @param  \App\TipoCambio  $tipoCambio
     * @return void
     */
    public function updated(TipoCambio $tipoCambio)
    {
        return $tipoCambio;
    }

    /**
     * Handle the TipoCambio "deleted" event.
     *
     * @param  \App\TipoCambio  $tipoCambio
     * @return void
     */
    public function deleted(TipoCambio $tipoCambio)
    {

    }

    /**
     * Handle the TipoCambio "restored" event.
     *
     * @param  \App\TipoCambio  $tipoCambio
     * @return void
     */
    public function restored(TipoCambio $tipoCambio)
    {
        //
    }

    /**
     * Handle the TipoCambio "force deleted" event.
     *
     * @param  \App\TipoCambio  $tipoCambio
     * @return void
     */
    public function forceDeleted(TipoCambio $tipoCambio)
    {
        //
    }
}
