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

    public function create($guia_id) {
        $guia = ServicioGuia::with(['cliente', 'servicio_guia_salida.detalle_guia_salida.s_detalle_guia_ingreso'])->find($guia_id);

        // return $guia;
        return view('servicio.orden_de_servicioinfocliente', [
            'guia' => $guia
        ]);
    }


    public function updateGuiaOS(Request $request) {
        DB::beginTransaction();
        try {
            $guia = ServicioGuia::findOrFail($request->guia_id);

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
            return redirect()->back()->with('error', 'Error al crear la orden de servicio') ;

        }
    }

    public function updateDescripcion(Request $request){
        DB::beginTransaction();
        try {
            // Encontrar el detalle específico por ID
            $detalle = SDetalleGuiaSalida::findOrFail($request->detalle_id);

            // Actualizar solo el campo descripcion_os
            $detalle->update([
                'descripcion_os' => $request->descripcion_os
            ]);

            DB::commit();

            // Redirigir de vuelta a la página anterior con un mensaje de éxito
            return redirect()->back()->with('success', 'Descripción actualizada correctamente');

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al actualizar la descripción') ;
        }
    }



}
