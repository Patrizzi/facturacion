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

        $servicioGuias = ServicioGuia::with('cliente')->orderBy('id', 'DESC')->get();
        // return $servicioGuias;
        $clientes = Cliente::get();

        return view('servicio.clientes', [
            'servicioGuias' => $servicioGuias,
            'clientes' => $clientes
        ]);

    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {

            $nuevoNumeroGuia = $this->generateNroServicioGuia();

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

    private function generateNroServicioGuia() {
        try {

            $lastNroSG = ServicioGuia::orderBy('id', 'desc')->first();
            if($lastNroSG) {
                $ultimoNum = (int) substr($lastNroSG->nro_guia, 5);
                $nuevoNum = $ultimoNum + 1;
            } else {
                $nuevoNum = 1;
            }

            $nroSGuia = 'STEC-' . str_pad($nuevoNum, 8, '0', STR_PAD_LEFT);
            return $nroSGuia;

        } catch(Exception $e) {

            throw new Exception('Hubo un error al generar código');

        }
    }

}
