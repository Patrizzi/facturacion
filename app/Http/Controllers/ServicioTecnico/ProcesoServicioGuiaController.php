<?php

namespace App\Http\Controllers\ServicioTecnico;

use App\Http\Controllers\Controller;
use App\ServicioGuia;
use App\ServicioGuiaEgreso;
use App\ServicioGuiaIngreso;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcesoServicioGuiaController extends Controller
{
    public function redirectProcesoServicioGuia($servicio_g_id) {
        $servicioGuia = ServicioGuia::findOrFail($servicio_g_id);

        $servIngresoEquipos = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)->orderBy('id', 'desc')->get();
        $servEgresosEquipos = ServicioGuiaEgreso::whereIn('servicio_g_ingreso_id', $servIngresoEquipos->pluck('id'))->orderBy('id', 'desc')->get();

        foreach($servEgresosEquipos as $servEgrEquipo){
            $servEgrEquipo->equipo = $servEgrEquipo->servicioGuiaIngreso->nombre_equipo;
            $servEgrEquipo->serie = $servEgrEquipo->servicioGuiaIngreso->nro_serie;
            $servEgrEquipo->tecnico = $servEgrEquipo->user->name;
        }

        return view('servicio_tecnico.servicios.servicio-guia.index', [
            'servicioGuia' => $servicioGuia,
            'servIngresoEquipos' => $servIngresoEquipos,
            'servEgresosEquipos' => $servEgresosEquipos
        ]);
    }

    public function agregarEquipos(Request $request) {
        try {

            $servicioGuia = ServicioGuia::findOrFail($request->servicio_guia_id);

            // si el servicio está en estado 2(cotizado), ya no podrá agregar más equipos
            if($servicioGuia->estado == 2) {
                return redirect()->route('servicio-guias.proceso', $servicioGuia->id)->with('warning', 'Este servicio ya ha sido cotizado. No se puede agregar más equipos.');
            }

            DB::beginTransaction();
            foreach($request->nombre_equipo as $key => $nombre) {
                ServicioGuiaIngreso::create([
                    'servicio_guia_id' => $servicioGuia->id,
                    'nombre_equipo' => $nombre,
                    'nro_serie' => $request->nro_serie[$key],
                    'observacion' => $request->observacion[$key],
                    'fecha_agregada' => Carbon::now()
                ]);
            }

            DB::commit();
            return redirect()->route('servicio-guias.proceso', $servicioGuia->id)->with('success', 'Equipo agregado');

        } catch(Exception $e) {

            DB::rollBack();
            // return $e;
            return redirect()->back()->with('error', 'Hubo un error al agregar el equipo');

        }
    }

    public function storeServicioEgreso(Request $request) {
        try {

            $servicioGuia = ServicioGuia::findOrFail($request->servicio_g_id);

            DB::beginTransaction();
            ServicioGuiaEgreso::create([
                'servicio_g_ingreso_id' => $request->servicio_g_ingreso_id,
                'fecha_inicio_reparacion' => Carbon::now(),
                'diagnostico' => $request->diagnostico,
                'user_id' => Auth()->user()->id
            ]);

            // cantidad total de equipos registrados
            $totalIngresosEquipo = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)->count();
            $idsIngresos = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)->pluck('id');
            // cantidad total de equipos diagnosticados
            $totalEgresosEquipo = ServicioGuiaEgreso::whereIn('servicio_g_ingreso_id', $idsIngresos)->count();
            // si equipos diagnosticados alcanza la cantidad de equipos registrados totales, cambia estado ServicioGuia a 1(diagnosticado)
            if($totalIngresosEquipo == $totalEgresosEquipo && $servicioGuia->estado == 0) {
                $servicioGuia->update([
                    'estado' => 1
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Equipo diagnosticado');

        } catch(Exception $e) {

            DB::rollBack();
            // return $e;
            return redirect()->back()->with('error', 'Hubo un error al registrar el diagnóstico');

        }
    }

    // se ejecuta cuando todos los productos esten diagnosticados y el servicioGuia en estado cotizado(2)
    public function repararEquipo(Request $request) {
        try {

            $servicioGuia = ServicioGuia::findOrFail($request->servicio_g_id);
            

        } catch(Exception $e) {



        }
    }
}
