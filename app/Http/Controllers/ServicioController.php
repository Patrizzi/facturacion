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

    public function guiasalida(){
        return view('servicio.guiasalida');
    }

    public function vistaclientes()
    {
        // Obtener todos los clientes
        $clientes = Cliente::all();
        // Obtener los IDs de clientes que tienen al menos una guía en garantia_guia_ingreso
        $clientesConGuias = GarantiaGuiaIngreso::pluck('cliente_id')->toArray();

        // Asegurar que la variable existe antes de pasarla a la vista
        return view('servicio.vistaclientes', compact('clientes', 'clientesConGuias'));
    }


    public function garantiaGuias()
    {
        return $this->hasMany(GarantiaGuiaIngreso::class, 'cliente_id');
    }

    public function mostrarGuia($id)
{
    // Obtener el cliente por su ID
    $cliente = Cliente::findOrFail($id);

    // Obtener las guías asociadas a ese cliente
    $guias = GarantiaGuiaIngreso::where('cliente_id', $id)->get();

    // Retornar la vista 'guia' con los datos
    return view('servicio.guia', compact('cliente', 'guias'));
}

    public function guias()
{
    // Obtener clientes que tengan al menos una guía en garantia_guia_ingreso
    $clientes = Cliente::whereHas('garantiaGuias')->get();

    return view('servicio.vistaclientes', compact('clientes'));
}

    public function guia()
    {
        return view('servicio.guia');
    }

}

