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

            // Llamar a la función BloAct() para obtener el estado del botón
            $buttonDisabled = ServicioGuia::where('id', $guia->id)->where('orden_s_creado', 1)->first();

            // Pasar solo el ID, no todo el objeto $guia
            $servicioGuiaIngresos = $this->getGuiaIngreso($guia_id);
            $servicioGuiaSalidas = $this->getGuiaSalida();

            return view('servicio.guia', [
                'guia' => $guia,
                'servicioGuiaIngresos' => $servicioGuiaIngresos,
                'buttonDisabled' => $buttonDisabled
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

        // Agregar el contador consecutivo a los detalles
        foreach ($sGuiaIngresos as $ingreso) {
            $contador = 1; // Inicializar el contador
            foreach ($ingreso->detalle_guia_ingreso as $detalle) {
                // Asignar el contador a cada detalle
                $detalle->contador = $contador++;
            }
        }

        return $sGuiaIngresos;
    }

    // public function BloAct(Request $request, $guia) {
    //     // Verificar si 'orden_servicio' está vacío o no asignado
    //     if (is_null($guia->orden_servicio) || $guia->orden_servicio == 'No asignado') {
    //         return false; // Si no está asignado, el botón sigue habilitado
    //     }

    //     // Si se realiza una solicitud POST (cuando se agregan los productos)
    //     if ($request->isMethod('post')) {
    //         // Validación de los datos de los productos
    //         $request->validate([
    //             'sDetalleGuiaIngreso.*.producto' => 'required|string|max:255', // Asegura que el nombre del producto esté presente
    //             'sDetalleGuiaIngreso.*.serie' => 'required|string|max:255', // Asegura que la serie esté presente
    //         ]);

    //         // Obtener los productos del formulario
    //         $productos = $request->input('sDetalleGuiaIngreso', []);

    //         // Comprobar si hay productos para agregar
    //         if (count($productos) > 0) {
    //             // Insertar cada producto en la tabla 's_detalle_guia_ingreso'
    //             foreach ($productos as $producto) {
    //                 DB::table('s_detalle_guia_ingreso')->insert([
    //                     's_g_ingreso_id' => $guia->id, // Asociar el producto con la guía actual
    //                     'producto' => $producto['producto'],
    //                     'serie' => $producto['serie'],
    //                     'observacion' => $producto['observacion'] ?? null, // Si no tiene observación, se asigna null
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //             }

    //             // Redirigir a la vista de la guía del cliente con un mensaje de éxito
    //             return redirect()->route('servicio.guia', ['cliente_id' => $guia->cliente_id, 'guia_id' => $guia->id])
    //                              ->with('success', 'Productos agregados exitosamente');
    //         } else {
    //             return back()->withErrors('Debe agregar al menos un producto');
    //         }
    //     }

    //     // Si no es una solicitud POST, retornar true (mantenemos la lógica de deshabilitar el botón)
    //     return true;
    // }





    public function getGuiaSalida() {

        $sGuiaSalidas = ServicioGuiaSalida::with(['servicio_guia_ingreso']);

        return $sGuiaSalidas;
    }
};
