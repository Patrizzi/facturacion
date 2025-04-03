<?php

namespace App\Http\Controllers;

use App\SDetalleGuiaSalida;
use App\ServicioGuia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenServicioController extends Controller
{
    public function index() {

        $guias = ServicioGuia::whereHas('servicio_guia_salida', function ($query) {
            $query->whereHas('detalle_guia_salida', function ($subQuery) {
                $subQuery->where('estado_os', 1) // Solo detalles con estado "revisado"
                         ->whereNotNull('diagnostico'); // Y que diagnostico NO sea null
            });
        })->whereDoesntHave('servicio_guia_salida.detalle_guia_salida', function ($query) {
            $query->whereNull('diagnostico'); // Excluye guías con detalles donde diagnostico es NULL
        })->with([
            'servicio_guia_salida.detalle_guia_salida',
            'cliente'
        ])->get();

        // return $guias;
        return view('servicio.orden_de_servicio', [
            'guias' => $guias
        ]);

    }

    public function create($guia_id) {
        $guia = ServicioGuia::with(['cliente', 'servicio_guia_salida.detalle_guia_salida'])->find($guia_id);

        // return $guia;
        return view('servicio.orden_de_servicioinfocliente', [
            'guia' => $guia
        ]);
    }
    public function updateGuiaOS($guia_id) {
        DB::beginTransaction();
        try {

            $guia = ServicioGuia::find($guia_id);

            $ultimoOs = ServicioGuia::max('orden_servicio');
            $nuevoNumeroOs = $ultimoOs ? intval($ultimoOs) + 1 : 1;
            $numeroOsFormateado = str_pad($nuevoNumeroOs, 4, '0', STR_PAD_LEFT);

            $guia->update([
                'orden_servicio' => $numeroOsFormateado
            ]);

        } catch (Exception $e) {

            return $e;

        }

    }

}
