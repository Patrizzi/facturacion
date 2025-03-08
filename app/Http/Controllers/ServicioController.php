<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\GarantiaGuiaIngreso;

class ServicioController extends Controller
{
    public function index()
    {
        return view('servicio.index');
    }
    public function guia_salida()
    {
        return view('servicio.guia_salida');
    }
    public function informe_tecnico()
    {
        return view('servicio.informe_tecnico');
    }
    public function solicitud_servicio()
    {
        return view('servicio.solicitud_servicio');
    }

    public function mostrarGuiaSalida()
    {
        $id=5;

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

    public function clientes()
    {
        $clientes = Cliente::all();
        $clientesConGuias = GarantiaGuiaIngreso::pluck('cliente_id')->toArray();

        return view('servicio.clientes', compact('clientes', 'clientesConGuias'));
    }


    public function garantiaGuias()
    {
        return $this->hasMany(GarantiaGuiaIngreso::class, 'cliente_id');
    }

    public function mostrarGuia($id)
{
    $cliente = Cliente::findOrFail($id);

    $guias = GarantiaGuiaIngreso::where('cliente_id', $id)->get();

    return view('servicio.guia', compact('cliente', 'guias'));
}

    public function guias()
{
    $clientes = Cliente::whereHas('garantiaGuias')->get();

    return view('servicio.clientes', compact('clientes'));
}

    public function guia()
    {
        return view('servicio.guia');
    }

}

