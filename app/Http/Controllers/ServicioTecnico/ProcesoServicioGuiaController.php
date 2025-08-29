<?php

namespace App\Http\Controllers\ServicioTecnico;

use App\Http\Controllers\Controller;
use App\ServicioGuia;
use App\ServicioGuiaIngreso;
use Exception;
use Illuminate\Http\Request;

class ProcesoServicioGuiaController extends Controller
{
    public function index() {

    }

    public function store(Request $request) {
        try {

            $servicioGuia = ServicioGuia::findOrFail($request->servicio_guia_id);

            if($servicioGuia->estado == 2) {
                return redirect()->route('servicio-guias.proceso', $servicioGuia->id)->with('warning', 'Este servicio ya ha sido cotizado. No se puede agregar más equipos.');
            }

            ServicioGuiaIngreso::create([
                'servicio_guia_id' => $servicioGuia->id,
            ]);

        } catch(Exception $e) {

        }
    }
}
