<?php

namespace App\Http\Controllers\ServicioTecnico;

use App\Http\Controllers\Controller;
use App\ServicioGuia;
use App\ServicioGuiaEgreso;
use App\ServicioGuiaIngreso;
use App\ServicioInformeTecnico;
use App\Contacto;
use App\Empresa;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicioGuiaInformeTecnicoController extends Controller
{

    public function showConCambios($informeTecnico_id) {
        // Primero obtener el informe solicitado para conseguir el servicio_g_id
        $informeOriginal = ServicioInformeTecnico::findOrFail($informeTecnico_id);

        // Luego obtener el informe técnico más reciente de ese mismo servicio
        $informeTecnico = ServicioInformeTecnico::with('servicioGuia')
            ->where('servicio_g_id', $informeOriginal->servicio_g_id)
            ->orderBy('id', 'desc')
            ->get()
            ->last(); // Obtiene la última versión

        // Retornar a la vista SHOW del informe técnico
        return view('servicio_tecnico.servicios.servicio-guia.servicio_informe_tecnico', [
            'informeTecnico' => $informeTecnico,
            'mostrandoUltimaVersion' => true
        ]);
    }

    // Función para el proceso completo (la que ya tenías)
    public function redirectProcesoServicioGuiaConCambios($servicio_g_id) {
        $servicioGuia = ServicioGuia::findOrFail($servicio_g_id);

        $servIngresoEquipos = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)
            ->orderBy('id', 'desc')
            ->get();

        $servEgresosEquipos = ServicioGuiaEgreso::whereIn('servicio_g_ingreso_id', $servIngresoEquipos->pluck('id'))
            ->orderBy('id', 'desc')
            ->get();

        $informeTecnico = ServicioInformeTecnico::with('servicioGuia')
            ->where('servicio_g_id', $servicioGuia->id)
            ->orderBy('id', 'desc')
            ->get()
            ->last();

        foreach($servEgresosEquipos as $servEgrEquipo){
            $servEgrEquipo->equipo = $servEgrEquipo->servicioGuiaIngreso->nombre_equipo;
            $servEgrEquipo->serie = $servEgrEquipo->servicioGuiaIngreso->nro_serie;
            $servEgrEquipo->tecnico = $servEgrEquipo->user->name;
        }

        return view('servicio_tecnico.servicios.servicio-guia.index', [
            'servicioGuia' => $servicioGuia,
            'servIngresoEquipos' => $servIngresoEquipos,
            'servEgresosEquipos' => $servEgresosEquipos,
            'informeTecnico' => $informeTecnico,
            'mostrandoDatosActualizados' => true
        ]);
    }
}
