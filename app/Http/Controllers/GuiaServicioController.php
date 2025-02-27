<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\GarantiaGuiaIngreso;

class GuiaServicioController extends Controller
{
    public function mostrarGuia($id)
    {
        // Obtener el cliente por su ID
        $cliente = Cliente::findOrFail($id);

        // Obtener las garantías del cliente que tienen egresado = 0
        $guias = GarantiaGuiaIngreso::where('cliente_id', $id)
            ->where('egresado', 0)
            ->select(
                'id as ITEM',
                'numero_serie as Serie',
                'nombre_equipo as Descripción',
                'descripcion_problema as Observación'
            )
            ->get();

        // Si no hay guías con egresado = 0, mostrar solo el cliente sin datos
        return view('servicio.guia', compact('cliente', 'guias'));
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


