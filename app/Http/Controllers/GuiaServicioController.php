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
use App\SImagenProducto;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PDF;

class GuiaServicioController extends Controller
{
    public function index($guia_id) {
        try {


            $guia = ServicioGuia::findOrFail($guia_id);

            $buttonDisabled = ServicioGuia::where('id', $guia->id)->where('orden_s_creado', 1)->first();

            // Pasar solo el ID, no todo el objeto $guia
            $servicioGuiaIngresos = $this->getGuiaIngreso($guia_id);
            $servicioGuiaSalidas = $this->getGuiaSalida($guia_id);


            // Obtener la lista de técnicos (usuarios con relación a personal)
            $tecnicos = Personal::join('users', 'users.personal_id', '=', 'personal.id')
                ->select('users.id', 'personal.nombres', 'personal.apellidos')
                ->get();


            $imagenesProducto = SImagenProducto::whereNotNull('foto')->whereNotNull('descripcion')->get()->keyBy('s_d_g_salida_id');

            $informeTecnicoExistente = DB::table('s_informe_tecnico')
            ->where('s_g_salida_id', optional($guia->servicio_guia_salida)->id)
            ->exists();


        return view('servicio.guia', [
            'guia' => $guia,
            'servicioGuiaIngresos' => $servicioGuiaIngresos,
            'servicioGuiaSalidas' => $servicioGuiaSalidas,
            'tecnicos' => $tecnicos,
            'usuario_autenticado' => Auth::user(),
            'buttonDisabled' => $buttonDisabled,
            'imagenesProducto' => $imagenesProducto,
            'informeTecnicoExistente' => $informeTecnicoExistente,

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
            // Verificar que la guía exista
            $guia = ServicioGuia::findOrFail($guia_id);

            // Obtener los productos del request
            $productos = $request->input('productos', []);

            // Validar que haya productos
            if (empty($productos) || empty($productos['producto'])) {
                return redirect()->back()->withErrors('No se enviaron productos.');
            }

            // Crear o encontrar las guías de ingreso y salida asociadas
            $servicioGuiaIngreso = ServicioGuiaIngreso::firstOrCreate(['s_guia_id' => $guia_id]);
            $servicioGuiaSalida = ServicioGuiaSalida::firstOrCreate(['s_guia_id' => $guia_id]);

            // Iterar sobre los productos y guardarlos en la base de datos
            foreach ($productos['producto'] as $key => $producto) {
                // Validar datos individuales
                if (empty($producto) || empty($productos['serie'][$key])) {
                    continue; // Omitir productos inválidos
                }

                // Crear registro en la tabla de ingreso
                $detalleIngreso = $servicioGuiaIngreso->detalle_guia_ingreso()->create([
                    'producto' => $producto,
                    'serie' => $productos['serie'][$key],
                    'observacion' => $productos['observacion'][$key] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Verificar si se creó correctamente el detalle de ingreso
                if (!$detalleIngreso) {
                    return redirect()->back()->withErrors('Error al registrar detalle de ingreso.');
                }

                // Crear registro en la tabla de salida
                $servicioGuiaSalida->detalle_guia_salida()->create([
                    's_d_g_ingreso_id' => $detalleIngreso->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return redirect()->route('sGuia.show', ['guia_id' => $guia_id])
                ->with('success', 'Productos agregados correctamente en ingreso y salida.');

        } catch (Exception $e) {
            return redirect()->back()->withErrors('Error: ' . $e->getMessage());
        }
    }

    private function getGuiaSalida($guia_id)
    {
        return ServicioGuiaSalida::with(['detalle_guia_salida', 'servicio_guia'])
            ->where('s_guia_id', $guia_id)
            ->get();
    }

    public function actualizarGuiaSalida(Request $request){
        try {
            $validated = $request->validate([
                'id' => 'required|exists:s_detalle_guia_salida,id',
                'estado_reparacion' => 'nullable|in:0,1',
                'estado_os' => 'required|in:0,1',
                'diagnostico' => 'nullable|string',
            ]);

            $detalle = SDetalleGuiaSalida::findOrFail($validated['id']);

            // Verifica si la orden de servicio ya fue creada
            $servicioGuia = ServicioGuia::where('id', $detalle->servicio_guia_salida->s_guia_id)
                ->where('orden_s_creado', 1)
                ->first();

            $buttonDisabled = $servicioGuia !== null;

            // Arreglo base
            $datosActualizar = [
                'estado_os' => $validated['estado_os'],
            ];

            if ($buttonDisabled) {
                $datosActualizar['estado_reparacion'] = $validated['estado_reparacion'] ?? null;
                $datosActualizar['fecha_fin'] = now();

            } else {
                // $datosActualizar['diagnostico'] = ($validated['estado_os'] == 0) ? null : $validated['diagnostico'];
                $datosActualizar['diagnostico'] = $validated['diagnostico'];

                if (is_null($detalle->fecha_inicio)) {
                    $datosActualizar['fecha_inicio'] = now();
                }

                if (is_null($detalle->user_id)) {
                    $datosActualizar['user_id'] = Auth::id();
                }
            }

            $detalle->update($datosActualizar);

            return response()->json([
                'message' => 'Datos actualizados correctamente',
                'updated_at' => now()->toDateTimeString(),
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Error de validación',
                'messages' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error en el servidor',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function subirImagen(Request $request, $detalleId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'foto' => 'required|image|max:2048',
                'descripcion' => 'nullable|string|max:255'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $detalle = SDetalleGuiaSalida::findOrFail($detalleId);

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');

                $nombreArchivo = uniqid() . '.' . $foto->getClientOriginalExtension();
                $rutaImagen = $foto->storeAs('servicio_tecnico_imagen_salida', $nombreArchivo, 'public');

                SImagenProducto::create([
                    's_d_g_salida_id' => $detalle->id,
                    'descripcion' => $request->descripcion,
                    'foto' => $rutaImagen
                ]);
            }

            return redirect()->back()->with('success', 'Imagen subida exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al subir imagen: ' . $e->getMessage());
        }
    }
    public function verPDF($guia_id, $accion = 'stream')
    {
        $detallesSalida = SDetalleGuiaSalida::with(['servicio_guia_salida', 's_detalle_guia_ingreso', 'user', 'tecnico'])
            ->whereHas('servicio_guia_salida', function($query) use ($guia_id) {
                $query->where('s_guia_id', $guia_id);
            })
            ->get();

        $salida = $detallesSalida;

        $pdf = Pdf::loadView('servicio.pdf_informe_tecnico', [
            'salida' => $salida
        ]);

        // Determinar qué acción realizar con el PDF
        switch ($accion) {
            case 'download':
                return $pdf->download('informe_tecnico.pdf');
            case 'print':
                // Añadir script de impresión automática
                $pdf->setOption('javascript-delay', 1000);
                $pdf->setOption('enable-javascript', true);
                $pdf->setOption('no-stop-slow-scripts', true);
                $pdf->setOption('page-size', 'A4');

                // Agregar script JavaScript para imprimir automáticamente
                $script = "window.onload = function(){ window.print(); }";
                $pdf->setOption('footer-html', '<script>' . $script . '</script>');

                return $pdf->stream('informe_tecnico_para_imprimir.pdf');
            default:
                return $pdf->stream('informe_tecnico.pdf');
        }
    }
    public function crear(Request $request)
{
    try {
        $guia = ServicioGuia::findOrFail($request->input('guia_id'));

        if (!$guia->servicio_guia_salida) {
            return redirect()->back()->with('error', 'La guía no tiene una salida asociada.');
        }

        // Si ya existe, se actualiza la fecha. Si no, se crea.
        DB::table('s_informe_tecnico')->updateOrInsert(
            ['s_g_salida_id' => $guia->servicio_guia_salida->id],
            ['fecha' => now()]
        );

        return redirect()->back()->with('success', 'Informe técnico registrado correctamente.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Ocurrió un error al registrar el informe técnico.');
    }
}




}
