<?php

namespace App\Http\Controllers;

use App\SDetalleGuiaSalida;
use App\ServicioGuia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenServicioController extends Controller
{
    public function index() {

        $guiasCotizadas = ServicioGuia::with(['cliente', 'cotizacion_manual'])->where('cotizado', 1)->where('orden_s_creado', 0)->get();
        $guiasConOs = ServicioGuia::with(['cliente', 'cotizacion_manual'])->where('orden_s_creado', 1)->get();

        return view('servicio.orden_de_servicio', [
            'guiasCotizadas' => $guiasCotizadas,
            'guiasConOs' => $guiasConOs
        ]);

    }

    public function create($guia_id) {
        $guia = ServicioGuia::with(['cliente', 'servicio_guia_salida.detalle_guia_salida.s_detalle_guia_ingreso', 'cotizacion_manual'])->find($guia_id);

        // return $guia;
        return view('servicio.orden_de_servicioinfocliente', [
            'guia' => $guia
        ]);
    }


    public function updateGuiaOS(Request $request) {
        DB::beginTransaction();
        try {
            $guia = ServicioGuia::findOrFail($request->guia_id);

            if ($guia->orden_s_creado == 1) {
                return redirect()->back()->with('error', 'La orden de servicio ya fue creada anteriormente.');
            }
            // Modificado para que verifique que todas las descripciones de cada producto hallan sido rellenadas.
            $detalles = $guia->servicio_guia_salida->detalle_guia_salida;
            $faltanDescripciones = false;

            foreach ($detalles as $detalle) {
                if (empty($detalle->descripcion_os)) {
                    $faltanDescripciones = true;
                    break;
                }
            }

            if ($faltanDescripciones) {
                return redirect()->back()->with('error', 'Debe ingresar primero la descripción de cada producto.');
            }

            $ultimaOrden = ServicioGuia::where('orden_s_creado', 1)->max('orden_servicio');
            $nuevoNumero = $ultimaOrden ? $ultimaOrden + 1 : 1;

            $guia->update([
                'orden_servicio' => $nuevoNumero,
                'orden_s_creado' => 1
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Orden de servicio creada correctamente');

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al crear la orden de servicio');
        }
    }

    public function updateDescripcion(Request $request){
        DB::beginTransaction();
        try {

            $detalle = SDetalleGuiaSalida::findOrFail($request->detalle_id);

            $detalle->update([
                'descripcion_os' => $request->descripcion_os
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Descripción actualizada correctamente');

        } catch (Exception $e) {

            DB::rollback();
            return redirect()->back()->with('error', 'Error al actualizar la descripción') ;
        }
    }
}