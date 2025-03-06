<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\GarantiaGuiaEgreso;
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

        // $ordenesServicio = GarantiaGuiaIngreso::where('cliente_id', $id)
        //     ->where('egresado', 0)
        //     ->orderBy('orden_servicio', 'asc')
        //     ->get()
        //     ->groupBy('orden_servicio');

        // $registros = GarantiaGuiaIngreso::with([
        //     'garantia_egreso_i',
        //     'clientes_i',
        //     'personal_laborales'
        // ])
        // ->where('cliente_id', $id)
        // ->get();

        // $datos_generales = $registros->isNotEmpty() ? $registros->first() : null;

        $guia_ingreso = $this->guiaIngreso($id);
        $guia_egreso = $this->guiaSalida($id);

        return view('servicio.guia', compact('cliente', 'guia_ingreso', 'fechaIngreso', 'recepcionista', 'guia_egreso'));
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

    // public function mostrarGuiaSalida($id)
    // {

    //     $cliente = Cliente::find($id);
    //     if (!$cliente) {
    //         abort(404, 'Cliente no encontrado');
    //     }

    //     $registros = GarantiaGuiaIngreso::with([
    //         'garantia_egreso_i',
    //         'clientes_i',
    //         'personal_laborales'
    //     ])
    //     ->where('cliente_id', $id)
    //     ->get();

    //     $datos_generales = $registros->isNotEmpty() ? $registros->first() : null;

    //     return view('servicio.guia', compact('registros', 'cliente', 'datos_generales'))
    //         ->with('warning', $registros->isEmpty() ? 'No se encontraron registros de garantía para este cliente.' : null);
    // }

    public function guiaIngreso($id) {
        $guia_ingreso = GarantiaGuiaIngreso::where('cliente_id', $id)->where('egresado', 0)->get();

        return $guia_ingreso;

    }

    public function guiaSalida($id) {

        $ingresosIds = GarantiaGuiaIngreso::where('cliente_id', $id)
            ->pluck('id');

        // Buscar los egresos relacionados con esos ingresos
        $guia_egreso = GarantiaGuiaEgreso::whereIn('garantia_ingreso_id', $ingresosIds)
            ->where('egresado', 1)
            ->get();

        return $guia_egreso;

    }


    public function informeTecnico($id) {

    }
}

