<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\SDetalleGuiaIngreso;
use App\ServicioGuia;
use App\ServicioGuiaIngreso;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class GuiaServicioController extends Controller
{

    public function getGuiaIngreso() {

        $servicioGuiaIngresos = ServicioGuiaIngreso::with(['servicio_guia', 'detalle_guia_ingreso'])->get();


        return view('servicio.guia',[
            'servicioGuiaIngreso' => $servicioGuiaIngresos
        ]);

    }

}

