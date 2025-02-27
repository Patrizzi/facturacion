<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\GarantiaGuiaIngreso;
use Illuminate\Support\Facades\DB;

class GuiaServicioController extends Controller
{
    /**
     * Mostrar la guía de servicio de un cliente específico.
     */
    public function mostrarGuia($id)
    {
        // Obtener el cliente por su ID
        $cliente = Cliente::findOrFail($id);

        // Obtener la última fecha de ingreso del cliente (solo fecha, sin hora)
        $fechaIngreso = GarantiaGuiaIngreso::where('cliente_id', $id)
            ->where('egresado', 0)
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        // Obtener el ID del recepcionista (personal_lab_id) de la última garantía
        $personalLabId = GarantiaGuiaIngreso::where('cliente_id', $id)
            ->where('egresado', 0)
            ->orderBy('created_at', 'desc')
            ->value('personal_lab_id');

        // Obtener el nombre completo del recepcionista desde la base de datos sin usar un modelo
        $recepcionista = $this->obtenerNombreRecepcionista($personalLabId);

        // Obtener las garantías agrupadas por `orden_servicio`
        $ordenesServicio = GarantiaGuiaIngreso::where('cliente_id', $id)
            ->where('egresado', 0)
            ->orderBy('orden_servicio', 'asc')
            ->get()
            ->groupBy('orden_servicio'); // Agrupar por orden de servicio

        return view('servicio.guia', compact('cliente', 'ordenesServicio', 'fechaIngreso', 'recepcionista'));
    }


    /**
     * Obtener el nombre completo del recepcionista desde la base de datos sin usar un modelo.
     */
    private function obtenerNombreRecepcionista($id)
    {
        if (!$id) {
            return 'No asignado';
        }

        // Hacer la consulta directa a la base de datos
        $nombreCompleto = DB::table('personal')
            ->where('id', $id)
            ->selectRaw("CONCAT(nombres, ' ', apellidos) as nombre_completo")
            ->value('nombre_completo');

        return $nombreCompleto ?? 'No encontrado';
    }

    public function mostrarGuiaSalida($id)
    {

        $cliente = Cliente::find($id);
        if (!$cliente) {
            abort(404, 'Cliente no encontrado');
        }

        $registros = GarantiaGuiaIngreso::with([
            'garantia_egreso_i',
            'clientes_i',
            'personal_laborales'
        ])
        ->where('cliente_id', $id)
        ->get();

        $datos_generales = $registros->isNotEmpty() ? $registros->first() : null;

        return view('servicio.guia', compact('registros', 'cliente', 'datos_generales'))
            ->with('warning', $registros->isEmpty() ? 'No se encontraron registros de garantía para este cliente.' : null);
    }
}

