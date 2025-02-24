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
        $id = 35;

        $cliente = Cliente::find($id);
        if (!$cliente) {
            abort(404, 'Cliente no encontrado');
        }

        $registros = GarantiaGuiaIngreso::with([
            'garantia_egreso_i:id,garantia_ingreso_id,descripcion_problema,diagnostico_solucion,recomendaciones,estado,egresado',
            'clientes_i:id,nombre,direccion,email,telefono,celular,empresa,numero_documento',
            'personal_laborales:id,nombres,apellidos'
        ])
        ->where('cliente_id', $id)
        ->get();

        if ($registros->isEmpty()) {
            return view('servicio.guia', compact('cliente'))
                ->with('warning', 'No se encontraron registros de garantía para este cliente.');
        }

        return view('servicio.guia', compact('registros', 'cliente'));
    }
}



