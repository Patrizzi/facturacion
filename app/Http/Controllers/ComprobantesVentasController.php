<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Boleta;
use App\ComprobantesPagos;
use App\Igv;
use App\Nota_Credito;
use App\Nota_Debito;
use Illuminate\Http\Request;

class ComprobantesVentasController extends Controller
{
    public function comprobantes_tabs(){
        
    }

    public function index_boleta() {
        $boletas=Boleta::all();
        if(count($boletas) == 0){
            $nota_credito[0] = null;
            $nota_debito[0] = null;
        }else{
            foreach ($boletas as $key => $boleta) {
                $nota_credito[$key] = Nota_Credito::where('boleta_id', $boleta->id)->first();
                $nota_debito[$key] = Nota_Debito::where('boleta_id', $boleta->id)->first();
                if (!isset($nota_credito[$key])) {
                    $nota_credito[$key] = null;
                }
                if (!isset($nota_debito[$key])) {
                    $nota_debito[$key] = null;
                }
            }
        }
        // return $nota_credito;
        $boletas_enviadas=Boleta::where('b_electronica',1)->get();
        $user_login =auth()->user();
        $conteo_almacen=Almacen::where('estado',0)->count();
        $almacen=Almacen::where('estado',0)->get();
        $almacen_primero=Almacen::where('estado',0)->first();
        $igv = Igv::first();


        $count_all_ventas = ComprobantesPagos::count_day_comprobantes();

        return view('transaccion.comprobantes.boleta.index', compact('boletas','count_all_ventas','boletas_enviadas','user_login','conteo_almacen','almacen','almacen_primero','igv','nota_credito','nota_debito'));
    }



    public function boleta_registers(){
        
    }


}
