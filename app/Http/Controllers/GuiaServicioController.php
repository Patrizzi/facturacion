<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\SDetalleGuiaIngreso;
use App\SDetalleGuiaSalida;
use App\ServicioGuia;
use App\ServicioGuiaIngreso;
use Carbouse;
use App\ServicioGuiaSalida;
use Carbon\Carbon;
use App\Personal;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GuiaServicioController extends Controller
{
    public function index($guia_id) {
        try {


            $guia = ServicioGuia::findOrFail($guia_id);

            $buttonDisabled = ServicioGuia::where('id', $guia->id)->where('orden_s_creado', 1)->first();

            // Pasar solo el ID, no todo el objeto $guia
            $servicioGuiaIngresos = $this->getGuiaIngreso($guia_id);
            $servicioGuiaSalidas = $this->getGuiaSalida($guia_id);

            // Obtener la lista de técnicos (usuarios con relación a personal)
            $tecnicos = Personal::join('users', 'users.personal_id', '=', 'personal.id')
                ->select('users.id', 'personal.nombres', 'personal.apellidos')
                ->get();

            return view('servicio.guia', [
                'guia' => $guia,
                'servicioGuiaIngresos' => $servicioGuiaIngresos,
                'servicioGuiaSalidas' => $servicioGuiaSalidas,
                // 'detalleGuiaSalidas' => $detalleGuiaSalidas,
                'tecnicos' => $tecnicos,
                'usuario_autenticado' => Auth::user(),
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

    public function BloAct(Request $request, $guia_id)
    {
        try {
            // Verificar que la guía exista
            $guia = ServicioGuia::findOrFail($guia_id);

            // Obtener los productos del request
            $productos = $request->input('productos', []);

            // Validar que haya productos
            if (empty($productos) || empty($productos['producto'])) {
                return redirect()->back()->withErrors('No se enviaron productos.');
            }

            // Crear o encontrar las guías de ingreso y salida asociadas
            $servicioGuiaIngreso = ServicioGuiaIngreso::firstOrCreate(['s_guia_id' => $guia_id]);
            $servicioGuiaSalida = ServicioGuiaSalida::firstOrCreate(['s_guia_id' => $guia_id]);

            // Iterar sobre los productos y guardarlos en la base de datos
            foreach ($productos['producto'] as $key => $producto) {
                // Validar datos individuales
                if (empty($producto) || empty($productos['serie'][$key])) {
                    continue; // Omitir productos inválidos
                }

                // Crear registro en la tabla de ingreso
                $detalleIngreso = $servicioGuiaIngreso->detalle_guia_ingreso()->create([
                    'producto' => $producto,
                    'serie' => $productos['serie'][$key],
                    'observacion' => $productos['observacion'][$key] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Verificar si se creó correctamente el detalle de ingreso
                if (!$detalleIngreso) {
                    return redirect()->back()->withErrors('Error al registrar detalle de ingreso.');
                }

                // Crear registro en la tabla de salida
                $servicioGuiaSalida->detalle_guia_salida()->create([
                    's_d_g_ingreso_id' => $detalleIngreso->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return redirect()->route('sGuia.show', ['guia_id' => $guia_id])
                ->with('success', 'Productos agregados correctamente en ingreso y salida.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error: ' . $e->getMessage());
        }
    }



    private function getGuiaSalida($guia_id)
    {
        return ServicioGuiaSalida::with(['detalle_guia_salida', 'servicio_guia'])
            ->where('s_guia_id', $guia_id)
            ->get();
    }

    public function actualizarGuiaSalida(Request $request)
    {
        try {
            // Validar los datos recibidos
            $validated = $request->validate([
                'id' => 'required|exists:s_detalle_guia_salida,id',
                'estado' => 'required|in:rechazado,revisado,en_revision,reparado',
                'recomendaciones' => 'nullable|string',
                // 'diagnostico' => 'nullable|string',
            ]);

            // Preparar los datos a actualizar según el estado
            if ($validated['estado'] === 'rechazado') {
                $datosActualizar = [
                    'fecha_reparacion' => now(),
                    'recomendaciones' => null,
                    'estado' => 'rechazado',
                    'user_id' => Auth::id(),
                    // 'diagnostico' => $validated['diagnostico'],

                ];
            } else {
                $datosActualizar = [
                    'fecha_reparacion' => now(),
                    'recomendaciones' => $validated['recomendaciones'],
                    'estado' => $validated['estado'],
                    'user_id' => Auth::id()
                    // 'diagnostico' => $validated['diagnostico'],
                ];
            }

            // Realizar la actualización en la base de datos
            SDetalleGuiaSalida::where('id', $validated['id'])->update($datosActualizar);

            return response()->json([
                'message' => 'Datos actualizados correctamente',
                'updated_at' => now()->toDateTimeString()
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'messages' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error en el servidor',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}

