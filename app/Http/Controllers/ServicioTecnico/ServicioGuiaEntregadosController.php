<?php

namespace App\Http\Controllers\ServicioTecnico;

use App\Http\Controllers\Controller;
use App\ServicioGuia;
use Illuminate\Http\Request;

class ServicioGuiaEntregadosController extends Controller
{
    public function index() {
        $servicioGuias = ServicioGuia::where('estado', 5)->get();

        foreach($servicioGuias as $guia) {
            $guia->cliente_nombre = $guia->cliente->nombre;
        }

        return view('servicio_tecnico.servicios_entregados.index', [
            'servicioGuias' => $servicioGuias
        ]);
    }
}
