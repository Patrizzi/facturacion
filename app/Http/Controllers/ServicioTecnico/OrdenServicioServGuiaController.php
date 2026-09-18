<?php

namespace App\Http\Controllers\ServicioTecnico;

use App\Http\Controllers\Controller;
use App\ServicioGuia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenServicioServGuiaController extends Controller
{
    public function index() {

        // traer solamente a los servicios que ya están cotizados
        $servicioGuias = ServicioGuia::where('estado', 2)->orderBy('id', 'desc')->get();

        foreach($servicioGuias as $guia) {
            $guia->cliente_nombre = $guia->cliente->nombre;

        }

        return view('servicio_tecnico.orden_servicio.index', [
            'servicioGuias' => $servicioGuias
        ]);
    }

    public function crearOrdenServicioGuia($servicio_g_id) {
        try {

            $servicioGuia = ServicioGuia::findOrFail($servicio_g_id);
            $nroOS = $this->generateNroOrdenServicio();

            $servicioGuia->update([
                'orden_servicio' => $nroOS,
                'estado' => 3
            ]);

            DB::commit();
            return redirect()->route('servicio-guias-os.index')->with('success', 'Orden de Servicio creado');

        } catch(Exception $e) {

            return redirect()->route('servicio-guias-os.index')->with('error', 'Hubo un error al crear el Orden de Servicio');

        }
    }

    private function generateNroOrdenServicio() {
        try {

            $lastOrdenServ = ServicioGuia::whereNotNull('orden_servicio')->orderBy('id', 'desc')->first();
            if($lastOrdenServ) {
                $utimoNum = (int) substr($lastOrdenServ->orden_servicio, 3);
                $newNum = $utimoNum + 1;
            } else {
                $newNum = 1;
            }

            $nroOS = 'OS-' . str_pad($newNum, 7, '0', STR_PAD_LEFT);
            return $nroOS;

        } catch(Exception $e) {

            throw new Exception('Hubo un error al generar el Nro. Orden Servicio');

        }
    }
}
