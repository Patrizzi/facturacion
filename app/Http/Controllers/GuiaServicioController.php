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
}


