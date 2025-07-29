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

        $guiasCotizadas = ServicioGuia::with(['cliente', 'cotizacion_manual'])->where('cotizado', 1)->where('orden_s_creado', 0)->latest()->get();
        $guiasConOs = ServicioGuia::with(['cliente', 'cotizacion_manual'])->where('orden_s_creado', 1)->latest()->get();

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

            $mensaje = 'Orden de servicio creada correctamente';

            if ($guia->orden_s_creado == 1) {
                $mensaje = 'Orden de servicio actualizada correctamente';
            }


            if (!$guia->servicio_guia_salida) {
                return redirect()->back()->with('error', 'No existe una guía de salida asociada.');
            }

            $detallesIngreso = $guia->servicio_guia_ingreso->detalle_guia_ingreso()->where('cotizado', 1)->get();

            if ($detallesIngreso->isEmpty()) {
                return redirect()->back()->with('warning', 'No hay productos cotizados para crear la orden de servicio.');
            }

            $productosSinDescripcion = [];

            foreach ($detallesIngreso as $detalleIngreso) {
                $detalleSalida = SDetalleGuiaSalida::where('s_d_g_ingreso_id', $detalleIngreso->id)->first();

                if (!$detalleSalida || empty($detalleSalida->descripcion_os)) {
                    $productosSinDescripcion[] = $detalleIngreso->producto . ' - ' . $detalleIngreso->serie;
                }
            }

            if (!empty($productosSinDescripcion)) {
                $mensajeError = 'Debe ingresar primero la descripción de los siguientes productos: ' .
                                implode(', ', $productosSinDescripcion);
                return redirect()->back()->with('warning', $mensajeError);
            }

            $ultimaOrden = ServicioGuia::where('orden_s_creado', 1)->max('orden_servicio');
            $nuevoNumero = $ultimaOrden ? $ultimaOrden + 1 : 1;

            $guia->update([
                'orden_servicio' => $guia->orden_servicio ?? $nuevoNumero,
                'orden_s_creado' => 1
            ]);


            DB::commit();
            return redirect()->back()->with('success', $mensaje);


        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al crear la orden de servicio: ' . $e->getMessage());
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
