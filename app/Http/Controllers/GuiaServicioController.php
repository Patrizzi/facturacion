<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;

class GuiaServicioController extends Controller
{
    public function GuiaIngreso($cliente_id)
    {
        // Filtrar las garantías del cliente con egresado = 0
        $garantias = GarantiaGuiaIngreso::where('cliente_id', $cliente_id)
            ->where('egresado', 0)
            ->select('id as ITEM', 'numero_serie as Serie', 'nombre_equipo as Descripción', 'descripcion_problema as Observación')
            ->get();

        // Retornar la vista con los datos
        return view('servicio.garantias_guias_ingresos', compact('garantias'));
    }
}
