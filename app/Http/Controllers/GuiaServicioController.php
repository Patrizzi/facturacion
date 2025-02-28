<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\GarantiaGuiaIngreso;
use Illuminate\Support\Facades\DB;

class GuiaServicioController extends Controller
{

    public function Guia($id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('servicio.guia', [
            'cliente' => $cliente,
            'guiasIngreso' => $this->mostrarGuia($id),
            'guiasSalida' => $this->mostrarGuiaSalida($id)
        ]);
    }

    public function mostrarGuia($id)
    {
        $cliente = Cliente::findOrFail($id);

        $fechaIngreso = GarantiaGuiaIngreso::where('cliente_id', $id)
            ->where('egresado', 0)
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        $personalLabId = GarantiaGuiaIngreso::where('cliente_id', $id)
            ->where('egresado', 0)
            ->orderBy('created_at', 'desc')
            ->value('personal_lab_id');

        $recepcionista = $this->obtenerNombreRecepcionista($personalLabId);

        $ordenesServicio = GarantiaGuiaIngreso::where('cliente_id', $id)
            ->where('egresado', 0)
            ->orderBy('orden_servicio', 'asc')
            ->get()
            ->groupBy('orden_servicio');

        $registros = GarantiaGuiaIngreso::with([
            'garantia_egreso_i',
            'clientes_i',
            'personal_laborales'
        ])
        ->where('cliente_id', $id)
        ->get();

        $datos_generales = $registros->isNotEmpty() ? $registros->first() : null;

        return view('servicio.guia', compact('cliente', 'ordenesServicio', 'fechaIngreso', 'recepcionista', 'registros', 'datos_generales'));
    }

    private function obtenerNombreRecepcionista($id)
    {
        if (!$id) {
            return 'No asignado';
        }

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

