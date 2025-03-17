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
                'tecnicos' => $tecnicos // 🔹 Se envía la lista de técnicos a la vista
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

    public function actualizarTecnico(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:s_detalle_guia_salida,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $detalleGuia = SDetalleGuiaSalida::findOrFail($request->id);
        $detalleGuia->user_id = $request->user_id;
        $detalleGuia->save();

        return response()->json([
            'message' => 'Técnico actualizado correctamente',
            'updated_at' => $detalleGuia->updated_at
        ]);
    }

    public function actualizarGuiaSalida(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:s_detalle_guia_salida,id',
            'user_id' => 'required|exists:users,id',
            'estado' => 'required|in:rechazado,en_revision,reparado',
            'recomendaciones' => 'nullable|string'
            // No se envía la fecha; se actualiza automáticamente.
        ]);

        $detalle = SDetalleGuiaSalida::findOrFail($validated['id']);
        $detalle->user_id = $validated['user_id'];
        $detalle->estado = $validated['estado'];
        $detalle->recomendaciones = $validated['recomendaciones'];
        // Si se requiriese actualizar otro campo de texto, lo agregas aquí.
        $detalle->save();

        return response()->json([
            'message' => 'Datos actualizados correctamente',
            'updated_at' => $detalle->updated_at
        ]);
    }

}

