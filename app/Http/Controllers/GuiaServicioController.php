<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GarantiaGuiaIngreso;

class GuiaServicioController extends Controller
{
    public function index($cliente_id)
    {
        // Obtener solo los registros que correspondan al cliente y que tengan egresado = 0
        $garantias = GarantiaGuiaIngreso::where('cliente_id', $cliente_id)
            ->where('egresado', 0)
            ->select('id as ITEM', 'numero_serie as Serie', 'nombre_equipo as Descripción', 'descripcion_problema as Observación')
            ->get();

        // Enviar los datos a la vista
        return view('garantias_guias_ingresos', compact('garantias'));
    }
}

