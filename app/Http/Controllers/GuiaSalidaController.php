<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\GarantiaGuiaEgreso;
use App\GarantiaGuiaIngreso;
use App\Personal;
use Illuminate\Support\Facades\DB;


class GuiaSalidaController extends Controller
{
    public function index()
    {
        $id = 12;

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






