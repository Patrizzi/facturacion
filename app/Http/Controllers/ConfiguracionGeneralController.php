<?php

namespace App\Http\Controllers;

use App\Personal;
use App\TipoCambio;
use Illuminate\Http\Request;

class ConfiguracionGeneralController extends Controller
{
    public function configuracion_general()
    {
        $tipo_cambio_estaditica = TipoCambio::get_statics();
        $personal = Personal::where('estado', 1)->get();

        return view('configuracion_general.configuracion_general', compact('tipo_cambio_estaditica','personal'));
    }
}
