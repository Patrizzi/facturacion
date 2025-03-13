<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\GarantiaGuiaEgreso;
use App\GarantiaGuiaIngreso;
use App\SDetalleGuiaIngreso;
use App\ServicioGuia;
use App\ServicioGuiaIngreso;
use App\ServicioGuiaSalida;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class GuiaServicioController extends Controller
{

    public function index() {

        $servicioGuias = ServicioGuia::orderBy('fecha', 'asc')->with('cliente')->get();
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

            foreach($request->sDetalleGuiaIngreso as $detalle) {
                SDetalleGuiaIngreso::create([
                    's_g_ingreso_id' => $servicioGuiaIngreso->id,
                    'producto' => $detalle['producto'],
                    'serie' => $detalle['serie'],
                    'observacion' => $detalle['observacion']
                ]);
            }

            // $servicioGuiaSalida = ServicioGuiaSalida::create([
            //     's_g_ingreso_id' => $servicioGuiaIngreso->id,
            // ]);
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

