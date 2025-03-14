<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\SDetalleGuiaIngreso;
use App\ServicioGuia;
use App\ServicioGuiaIngreso;
use Carbouse;
use App\ServicioGuiaSalida;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class GuiaServicioController extends Controller
{

    public function index($guia_id) {
        try {
            $guia = ServicioGuia::findOrFail($guia_id);

            // Pasar solo el ID, no todo el objeto $guia
            $servicioGuiaIngresos = $this->getGuiaIngreso($guia_id);
            $servicioGuiaSalidas = $this->getGuiaSalida();

            // return $servicioGuiaIngresos;
            return view('servicio.guia', [
                'guia' => $guia,    
                'servicioGuiaIngresos' => $servicioGuiaIngresos
            ]);

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors([
                'error' => 'No se encontró la guía solicitada.'
            ]);
        }
    }

    public function getGuiaIngreso($guia_id) {
        // Filtrar las guías de ingreso por el ID de la guía
        $sGuiaIngresos = ServicioGuiaIngreso::with(['servicio_guia', 'detalle_guia_ingreso'])
            ->where('s_guia_id', $guia_id)
            ->get();
        return $sGuiaIngresos;
    }


    public function getGuiaSalida() {

        $sGuiaSalidas = ServicioGuiaSalida::with(['servicio_guia_ingreso']);

        return $sGuiaSalidas;
    }
};
