<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\SDetalleGuiaIngreso;
use App\SDetalleGuiaSalida;
use App\ServicioGuia;
use App\ServicioGuiaIngreso;
use Carbouse;
use App\ServicioGuiaSalida;
use Carbon\Carbon;
use App\Personal;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GuiaServicioController extends Controller
{
    public function index($guia_id) {
        try {
            $guia = ServicioGuia::findOrFail($guia_id);

            $buttonDisabled = ServicioGuia::where('id', $guia->id)->where('orden_s_creado', 1)->first();

            // Pasar solo el ID, no todo el objeto $guia
            $servicioGuiaIngresos = $this->getGuiaIngreso($guia_id);
            $servicioGuiaSalidas = $this->getGuiaSalida($guia_id);

            return view('servicio.guia', [
                'guia' => $guia,
                'servicioGuiaIngresos' => $servicioGuiaIngresos,
                'buttonDisabled' => $buttonDisabled
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors([
                'error' => 'No se encontró la guía solicitada.'
            ]);
        }
    }


    public function getGuiaIngreso($guia_id) {
        // Filtrar las guías de ingreso por el ID de la guía
        $sGuiaIngresos = ServicioGuiaIngreso::with(['servicio_guia', 'detalle_guia_ingreso'])
            ->where('s_guia_id', $guia_id)
            ->get();

        // Agregar el contador consecutivo a los detalles
        foreach ($sGuiaIngresos as $ingreso) {
            $contador = 1; // Inicializar el contador
            foreach ($ingreso->detalle_guia_ingreso as $detalle) {
                // Asignar el contador a cada detalle
                $detalle->contador = $contador++;
            }
        }

        return $sGuiaIngresos;
    }

    public function BloAct(Request $request, $guia_id)
    {
        try {
            // Obtener la guía y el servicio correspondiente
            $guia = ServicioGuia::findOrFail($guia_id);

            // Obtener los productos enviados en la solicitud
            $productos = $request->input('productos', []);

            // Validar que se hayan enviado productos
            if (empty($productos['producto'])) {
                return redirect()->back()->withErrors('No se enviaron productos.');
            }

            // Obtener o crear el ServicioGuiaIngreso
            $servicioGuiaIngreso = ServicioGuiaIngreso::firstOrCreate(['s_guia_id' => $guia_id]);

            // Preparar los datos para insertar
            $insertData = array_map(function($producto, $key) use ($productos) {
                return [
                    'producto' => $producto,
                    'serie' => $productos['serie'][$key],
                    'observacion' => $productos['observacion'][$key] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }, $productos['producto'], array_keys($productos['producto']));

            // Insertar los productos relacionados con el ServicioGuiaIngreso
            $servicioGuiaIngreso->detalle_guia_ingreso()->createMany($insertData);

            // Redirigir con mensaje de éxito
            return redirect()->route('sGuia.show', ['guia_id' => $guia_id])->with('success', 'Productos agregados correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error: ' . $e->getMessage());
        }
    }










    public function getGuiaSalida() {

        $sGuiaSalidas = ServicioGuiaSalida::with(['servicio_guia_ingreso']);

        return $sGuiaSalidas;
    }
}

