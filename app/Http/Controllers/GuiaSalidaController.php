<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\GarantiaGuiaEgreso;
use App\GarantiaGuiaIngreso;
use App\Personal;

class GuiaSalidaController extends Controller
{
    public function index()
    {
        $id=3;
        $cliente = Cliente::find($id);
        $datos_ingreso = GarantiaGuiaIngreso::where('cliente_id', $id)->first();
        
        if ($datos_ingreso) {
            $personal = Personal::where('id', $datos_ingreso->personal_lab_id)->first();
            $datos_salida = GarantiaGuiaEgreso::where('garantia_ingreso_id', $datos_ingreso->id)->first();
        } else {
            $datos_salida = null;
            $personal = null;
        }
        return view('servicio.guiasalida', compact('cliente', 'datos_ingreso', 'datos_salida', 'personal'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }
}
