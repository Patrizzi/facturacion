<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\SDetalleGuiaIngreso;
use App\SDetalleGuiaSalida;
use App\ServicioGuia;
use App\ServicioGuiaIngreso;
use App\ServicioGuiaSalida;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class GuiaServicioClienteController extends Controller
{
    public function index() {

        $servicioGuias = ServicioGuia::orderBy('created_at', 'desc')->with('cliente')->get();
        $clientes = Cliente::get();

        return view('servicio.clientes', [
            'servicioGuias' => $servicioGuias,
            'clientes' => $clientes
        ]);

    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {


            $ultimaGuia = ServicioGuia::max('nro_guia');
            $nuevoNumeroGuia = $ultimaGuia ? intval($ultimaGuia) + 1 : 1;

            $servicioGuia = ServicioGuia::create([
                'nro_guia' => $nuevoNumeroGuia,
                'cliente_id' => $request->cliente_id,
                'fecha' => Carbon::now()
            ]);

            $servicioGuiaIngreso = ServicioGuiaIngreso::create([
                's_guia_id' => $servicioGuia->id
            ]);

            $servicioGuiaSalida = ServicioGuiaSalida::create([
                's_guia_id' => $servicioGuia->id,
            ]);

            foreach($request->sDetalleGuiaIngreso as $detalle) {
                $detalleIngreso = SDetalleGuiaIngreso::create([
                    's_g_ingreso_id' => $servicioGuiaIngreso->id,
                    'producto' => $detalle['producto'],
                    'serie' => $detalle['serie'],
                    'observacion' => $detalle['observacion']
                ]);

                SDetalleGuiaSalida::create([
                    's_g_salida_id' => $servicioGuiaSalida->id,
                    's_d_g_ingreso_id' => $detalleIngreso->id,
                    'recomendaciones' => null,
                    'fecha_reparacion' => null,
                    'aprobado' => null,
                    'estado' => null,
                    'user_id' => null
                ]);
            }


            DB::commit();
            return redirect()->route('sGuias.index')->with('success', 'Se guardó el registro exitosamente');

        } catch (Exception $e) {

            // return $e;
            return redirect()->back()->withErrors([
                'error' => 'Ocurrió un error al guardar los datos'
            ]);

        }
    }

}
