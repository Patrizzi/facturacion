<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\SDetalleGuiaIngreso;
use App\ServicioGuia;
use App\ServicioGuiaIngreso;
use App\ServicioGuiaSalida;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class GuiaServicioController extends Controller
{

    public function index() {

        $servicioGuiaIngresos = $this->getGuiaIngreso();
        $servicioGuiaSalidas = $this->getGuiaSalida();

        return view('servicio.guia',[
            'servicioGuiaIngreso' => $servicioGuiaIngresos,
            'servicioGuiaSalidas' => $servicioGuiaSalidas
        ]);

    }

    public function getGuiaIngreso() {

        $sGuiaIngresos = ServicioGuiaIngreso::with(['servicio_guia', 'detalle_guia_ingreso'])->get();

        return $sGuiaIngresos;
    }

    public function getGuiaSalida() {

        $sGuiaSalidas = ServicioGuiaSalida::with(['servicio_guia_ingreso', 'servicio_guia_ingreso']);

        return $sGuiaSalidas;
    }

}

