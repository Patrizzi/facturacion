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

    public function showInformeTecnicoConCambios($informeTecnico_id) {
        // Obtener el informe técnico original para conseguir el servicio_g_id
        $informeOriginal = ServicioInformeTecnico::findOrFail($informeTecnico_id);

        // Usar el servicio_g_id para obtener la ServicioGuia
        $servicioGuia = ServicioGuia::findOrFail($informeOriginal->servicio_g_id);

        // Exactamente igual que tu función original
        $servIngresoEquipos = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)->orderBy('id', 'desc')->get();
        $servEgresosEquipos = ServicioGuiaEgreso::whereIn('servicio_g_ingreso_id', $servIngresoEquipos->pluck('id'))->orderBy('id', 'desc')->get();

        // CAMBIO: obtener el informe técnico MÁS RECIENTE por fecha de creación/actualización
        $informeTecnico = ServicioInformeTecnico::with('servicioGuia')
            ->where('servicio_g_id', $servicioGuia->id)
            ->latest('created_at') // Ordenar por fecha de creación más reciente
            ->first(); // El más reciente

        // Exactamente igual que tu función original
        foreach($servEgresosEquipos as $servEgrEquipo){
            $servEgrEquipo->equipo = $servEgrEquipo->servicioGuiaIngreso->nombre_equipo;
            $servEgrEquipo->serie = $servEgrEquipo->servicioGuiaIngreso->nro_serie;
            $servEgrEquipo->tecnico = $servEgrEquipo->user->name;
        }

        // Retornar a la vista correcta que me indicaste
        return view('servicio_tecnico.servicios.servicio-guia.informe_tecnico_show', [
            'servicioGuia' => $servicioGuia,
            'servIngresoEquipos' => $servIngresoEquipos,
            'servEgresosEquipos' => $servEgresosEquipos,
            'informeTecnico' => $informeTecnico
        ]);
    }
    public function print(Request $request,$id) {
        // Obtener el informe técnico original para conseguir el servicio_g_id
        $informeOriginal = ServicioInformeTecnico::findOrFail($informeTecnico_id);

        // Usar el servicio_g_id para obtener la ServicioGuia
        $servicioGuia = ServicioGuia::findOrFail($informeOriginal->servicio_g_id);

        // Exactamente igual que tu función original
        $servIngresoEquipos = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)->orderBy('id', 'desc')->get();
        $servEgresosEquipos = ServicioGuiaEgreso::whereIn('servicio_g_ingreso_id', $servIngresoEquipos->pluck('id'))->orderBy('id', 'desc')->get();

        // CAMBIO: obtener el informe técnico MÁS RECIENTE por fecha de creación/actualización
        $informeTecnico = ServicioInformeTecnico::with('servicioGuia')
            ->where('servicio_g_id', $servicioGuia->id)
            ->latest('created_at') // Ordenar por fecha de creación más reciente
            ->first(); // El más reciente

        // Exactamente igual que tu función original
        foreach($servEgresosEquipos as $servEgrEquipo){
            $servEgrEquipo->equipo = $servEgrEquipo->servicioGuiaIngreso->nombre_equipo;
            $servEgrEquipo->serie = $servEgrEquipo->servicioGuiaIngreso->nro_serie;
            $servEgrEquipo->tecnico = $servEgrEquipo->user->name;
        }

        // Retornar a la vista correcta que me indicaste
        return view('servicio_tecnico.servicios.servicio-guia.informe_tecnico_show', [
            'servicioGuia' => $servicioGuia,
            'servIngresoEquipos' => $servIngresoEquipos,
            'servEgresosEquipos' => $servEgresosEquipos,
            'informeTecnico' => $informeTecnico
        ]);
    }
}
