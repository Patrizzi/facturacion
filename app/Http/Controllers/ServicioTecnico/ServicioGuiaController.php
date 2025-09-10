<?php

namespace App\Http\Controllers\ServicioTecnico;

use App\Http\Controllers\Controller;
use App\ServicioGuia;
use App\ServicioGuiaEgreso;
use App\ServicioGuiaIngreso;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServicioGuiaController extends Controller
{
    public function index() {
        $servicioGuias = ServicioGuia::where('estado', '!=' , 5)->get();

        foreach($servicioGuias as $guia) {
            $guia->cliente_nombre = $guia->cliente->nombre;
        }

        return view('servicio_tecnico.servicios.index', [
            'servicioGuias' => $servicioGuias
        ]);
    }

    public function create() {

        $newNroGuia = $this->generateNroServicioGuia();
        $currentUser = Auth()->user()->name;

        return view('servicio_tecnico.servicios.create', [
            'newNroGuia' => $newNroGuia,
            'currentUser' => $currentUser
        ]);
    }

    public function store(Request $request) {
        try {

            $nroGuia = $this->generateNroServicioGuia();

            DB::beginTransaction();
            $servicioGuia = ServicioGuia::create([
                'nro_servicio_guia' => $nroGuia,
                'cliente_id' => $request->cliente_id,
                'fecha_creacion' => Carbon::now(),
                'user_id' => Auth()->user()->id
            ]);

            foreach($request->nombre_equipo as $key => $nombre) {
                ServicioGuiaIngreso::create([
                    'servicio_guia_id' => $servicioGuia->id,
                    'nombre_equipo' => $nombre,
                    'nro_serie' => $request->nro_serie[$key],
                    'observacion' => $request->observacion[$key],
                    'fecha_agregada' => Carbon::now()
                ]);
            }

            DB::commit();
            return redirect()->route('servicio-guias.index')->with('success', 'Servicio guia creado');

        }catch(Exception $e) {

            DB::rollBack();
            // return $e;
            return redirect()->route('servicio-guias.create')->with('error', 'Hubo un error al crear el servicio guia');

        }
    }

    private function generateNroServicioGuia() {
        try {

            $lastServicioGuia = ServicioGuia::orderBy('id', 'desc')->first();

            if($lastServicioGuia) {
                $lastNum = (int) substr($lastServicioGuia->nro_servicio_guia, 5);
                $newNum = $lastNum + 1;
            } else {
                $newNum = 1;
            }

            $nroSGuia = 'STEC-' . str_pad($newNum, 7, '0', STR_PAD_LEFT);
            return $nroSGuia;

        } catch(Exception $e) {

            throw new Exception('Hubo un error al generar el Nro. Servicio Guía');

        }
    }

    public function entregarServicioGuia($servicio_g_id) {
        try {

            $servicioGuia = ServicioGuia::findOrFail($servicio_g_id);

            if($servicioGuia->estado != 4) {
                return redirect()->route('servicio-guias.index')->with('warning', 'Este servicio técnico no está listo para entregar');
            }

            $servicioGuia->update([
                'estado' => 5
            ]);

            DB::commit();
            return redirect()->route('servicio-guias.index')->with('success', 'Servicio guia entregado');

        } catch(Exception $e) {

            DB::rollBack();
            // return $e;
            return redirect()->route('servicio-guias.index')->with('error', 'Hubo un error al entregar el servicio guia');

        }
    }
}
    