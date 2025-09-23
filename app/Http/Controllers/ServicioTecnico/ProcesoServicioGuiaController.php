<?php

namespace App\Http\Controllers\ServicioTecnico;

use App\Http\Controllers\Controller;
use App\ServicioGuia;
use App\ServicioGuiaEgreso;
use App\ServicioGuiaIngreso;
use App\ServicioInformeTecnico;
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
        $informeTecnico = ServicioInformeTecnico::with('servicioGuia')->where('servicio_g_id', $servicioGuia->id)->orderBy('id', 'desc')->first();

        foreach($servEgresosEquipos as $servEgrEquipo){
            $servEgrEquipo->equipo = $servEgrEquipo->servicioGuiaIngreso->nombre_equipo;
            $servEgrEquipo->serie = $servEgrEquipo->servicioGuiaIngreso->nro_serie;
            $servEgrEquipo->tecnico = $servEgrEquipo->user->name;
        }

        return view('servicio_tecnico.servicios.servicio-guia.index', [
            'servicioGuia' => $servicioGuia,
            'servIngresoEquipos' => $servIngresoEquipos,
            'servEgresosEquipos' => $servEgresosEquipos,
            'informeTecnico' => $informeTecnico
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

            $totalEquiposIngresos = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)->count();
            $idsIngresos = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)->pluck("id");
            $totalEquiposEgresos = ServicioGuiaEgreso::whereIn('servicio_g_ingreso_id', $idsIngresos)->count();

            // si todos los equipos estan diagnosticados(ServicioGuia => estado = 1), pero al final se agregan unos equipos mas, servicioGuia vuelve a su estado falta diagnosticar(0)
            if($totalEquiposIngresos > $totalEquiposEgresos) {
                $servicioGuia->update([
                    'estado' => 0
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

            // encontrar el servicioGuia
            $servicioGuia = ServicioGuia::findOrFail($request->servicio_g_id);
            $equipoEgreso = ServicioGuiaEgreso::where('id', $request->servicio_g_egreso_id)->first();

            $datosActualizar = [];
            if($request->has('descripcion_os')) {
                $datosActualizar['descripcion_os'] = $request->descripcion_os;
            }
            if($request->has('fecha_fin_reparacion')) {
                $datosActualizar['fecha_fin_reparacion'] = $request->fecha_fin_reparacion;
            }
            if($request->has('estado')) {
                $datosActualizar['estado'] = $request->estado;
            }

            DB::beginTransaction();
            $equipoEgreso->update($datosActualizar);

            // trae la cantidad de equipos ingresos de los que fueron cotizados
            $totalEquiposIngresos = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)->where('estado', 1)->count();
            $equiposIngresosIds = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)->where('estado', 1)->pluck('id');
            // trae la cantidad de los equipos egresos que fueron cotizados($totalEquiposIngresos) y reparados
            $totalEquiposEgresos = ServicioGuiaEgreso::whereIn('servicio_g_ingreso_id', $equiposIngresosIds)->where('estado', 1)->count();

            // si el total de equipos ingresados que fueron cotizados es igual a la cantidad del total de equipos egresados que fueron reparados, cambiar el estado de servicioGuia a reparado todo(4)
            if($totalEquiposEgresos == $totalEquiposIngresos && $servicioGuia->estado == 3) {
                $servicioGuia->update([
                    'estado' => 4
                ]);
            }

            DB::commit();
            return redirect()->route('servicio-guias.proceso', $servicioGuia->id)->with('success', 'Equipo reparado');

        } catch(Exception $e) {

            DB::rollBack();
            // return $e;
            return redirect()->back()->with('error', 'Hubo un error al registrar el diagnóstico');

        }
    }

    public function storeInformeTecnico(Request $request) {
        try {

            // recoger el id del servicioGuia
            $servicioGuia = ServicioGuia::findOrFail($request->servicio_g_id);

            DB::beginTransaction();
            ServicioInformeTecnico::create([
                'servicio_g_id' => $servicioGuia->id,
                'fecha_creacion' => Carbon::now()
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Informe técnico creado');

        } catch(Exception $e) {

            DB::rollBack();
            return $e;
            // return redirect()->back()->with('error', 'Hubo un error al registrar el diagnóstico');

        }
    }
}
