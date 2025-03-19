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
    public function index($guia_id)
    {
        try {
            $guia = ServicioGuia::findOrFail($guia_id);

            // Obtener detalles de ingreso y salida
            $servicioGuiaIngresos = $this->getGuiaIngreso($guia_id);
            $servicioGuiaSalidas = $this->getGuiaSalida($guia_id);

            // Obtener detalles de guía con el nombre del técnico
            $detalleGuiaSalidas = SDetalleGuiaSalida::with(['user', 'tecnico'])
                ->where('s_g_salida_id', $guia_id)
                ->get();

            // Obtener la lista de técnicos (usuarios con relación a personal)
            $tecnicos = Personal::join('users', 'users.personal_id', '=', 'personal.id')
                ->select('users.id', 'personal.nombres', 'personal.apellidos')
                ->get();

            return view('servicio.guia', [
                'guia' => $guia,
                'servicioGuiaIngresos' => $servicioGuiaIngresos,
                'servicioGuiaSalidas' => $servicioGuiaSalidas,
                'detalleGuiaSalidas' => $detalleGuiaSalidas,
                'tecnicos' => $tecnicos, // 🔹 Se envía la lista de técnicos a la vista
                'usuario_autenticado' => Auth::user()
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors([
                'error' => 'No se encontró la guía solicitada.'
            ]);
        }
    }

    private function getGuiaIngreso($guia_id)
    {
        return ServicioGuiaIngreso::with(['servicio_guia', 'detalle_guia_ingreso'])
            ->where('s_guia_id', $guia_id)
            ->get();
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
            // Validación de los datos recibidos
            $validated = $request->validate([
                'id' => 'required|exists:s_detalle_guia_salida,id',
                'estado' => 'required|in:rechazado,en_revision,reparado',
                'recomendaciones' => 'nullable|string',
                'diagnostico' => 'nullable|string',
            ]);

            // Definir los valores a actualizar
            $datosActualizar = [];

            if ($validated['estado'] === 'rechazado') {
                $datosActualizar = [
                    'estado' => 'rechazado',
                    'recomendaciones' => null,
                ];
            } else {
                $datosActualizar = [
                    'user_id' => Auth::id(), // Se asigna el usuario autenticado
                    'diagnostico'=> $validated['diagnostico'],
                    'estado' => $validated['estado'],
                    'recomendaciones' => $validated['recomendaciones'],
                    'fecha_reparacion' => now(),
                ];
            }

            // Actualizar el registro en la base de datos
            SDetalleGuiaSalida::where('id', $validated['id'])->update($datosActualizar);

            return response()->json([
                'message' => 'Datos actualizados correctamente',
                'updated_at' => now()->toDateTimeString()
            ], 200);

        } catch (Exception $e) {
            Log::error("Error en actualizarGuiaSalida: " . $e->getMessage());

            return response()->json([
                'message' => 'Ocurrió un error al actualizar los datos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

