<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\GarantiaGuiaIngreso;

class ServicioController extends Controller
{
    public function index()
    {
        return view('servicio.index');
    }
    public function guia_salida()
    {
        return view('servicio.guia_salida');
    }
    public function informe_tecnico()
    {
        return view('servicio.informe_tecnico');
    }
    public function solicitud_servicio()
    {
        return view('servicio.solicitud_servicio');
    }
}

