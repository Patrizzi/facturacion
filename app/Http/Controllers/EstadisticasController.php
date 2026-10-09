<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstadisticasController extends Controller
{
    public function index()
    {
        return view('estadisticas.index');
    }
    public function servicios()
    {
        return view('estadisticas.servicios');
    }
    public function clientes()
    {
        return view('estadisticas.clientes');
    }
    public function empleados()
    {
        return view('estadisticas.empleados');
    }
}
