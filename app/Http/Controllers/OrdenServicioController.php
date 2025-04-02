<?php

namespace App\Http\Controllers;

use App\SDetalleGuiaSalida;
use App\ServicioGuia;
use Illuminate\Http\Request;

class OrdenServicioController extends Controller
{
    public function index() {

        $guias = ServicioGuia::whereHas('servicio_guia_salida', function ($query) {
            $query->whereHas('detalle_guia_salida', function ($subQuery) {
                $subQuery->where('estado_os', 1) // Solo detalles con estado "revisado"
                         ->whereNotNull('diagnostico'); // Y que diagnostico NO sea null
            });
        })->whereDoesntHave('servicio_guia_salida.detalle_guia_salida', function ($query) {
            $query->whereNull('diagnostico'); // Excluye guías con detalles donde diagnostico es NULL
        })->with([
            'servicio_guia_salida.detalle_guia_salida',
            'cliente'
        ])->get();

        // return $guias;
        return view('servicio.orden_de_servicio', [
            'guias' => $guias
        ]);

    }

    public function create() {
        return view('servicio.orden_de_servicioinfocliente');
    }
    public function update() {

    }

}
