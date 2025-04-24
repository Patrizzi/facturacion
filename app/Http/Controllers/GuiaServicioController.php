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
use App\Services\CotizacionManualService;
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

    public function actualizarGuiaSalida(Request $request) {
        try {
            // Validar datos del request
            $validated = $request->validate([
                'id' => 'required|exists:s_detalle_guia_salida,id',
                'estado_reparacion' => 'nullable|in:0,1',
                'estado_os' => 'required|in:0,1',
                'diagnostico' => 'nullable|string',
            ]);

            // Obtener el detalle a actualizar
            $detalle = SDetalleGuiaSalida::findOrFail($validated['id']);

            // Verificar si la orden de servicio está creada
            $servicioGuia = ServicioGuia::where('id', $detalle->servicio_guia_salida->s_guia_id)
                ->where('orden_s_creado', 1)
                ->first();
            $buttonDisabled = $servicioGuia !== null;

            // Preparar datos para actualizar
            $datosActualizar = [
                'estado_os' => $validated['estado_os'],
            ];

            if ($buttonDisabled) {
                $datosActualizar['estado_reparacion'] = $validated['estado_reparacion'] ?? null;
                $datosActualizar['fecha_fin'] = now();
            } else {
                $datosActualizar['diagnostico'] = $validated['diagnostico'];

                if (is_null($detalle->fecha_inicio)) {
                    $datosActualizar['fecha_inicio'] = now();
                }
                if (is_null($detalle->user_id)) {
                    $datosActualizar['user_id'] = Auth::id();
                }
            }

            // Actualizar el registro
            $detalle->update($datosActualizar);

            return response()->json([
                'message' => 'Datos actualizados correctamente',
                'updated_at' => now()->toDateTimeString(),
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejo de errores de validación
            return response()->json([
                'error' => 'Error de validación',
                'messages' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            // Manejo de errores generales
            return response()->json([
                'error' => 'Error en el servidor',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function subirImagen(Request $request, $detalleId) {
        // Validación con mensajes personalizados
        $request->validate([
            'foto'        => 'required|mimes:jpeg,jpg,png,webp|max:2048',
            'descripcion' => 'required|string|max:255',
        ], [
            'foto.mimes'        => 'Solo se permiten archivos .jpg, .jpeg, .png o .webp.',
            'descripcion.required' => 'La descripción es obligatoria.',
        ]);

        $detalle = SDetalleGuiaSalida::findOrFail($detalleId);

        $foto      = $request->file('foto');
        $extension = strtolower($foto->getClientOriginalExtension());
        $filename  = uniqid() . '.' . $extension;

        // Carpeta destino
        $folder = public_path('archivos/imagenes/ImagenGuia');
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        // Mover el archivo y construir ruta relativa
        $foto->move($folder, $filename);
        $rutaRelativa = "archivos/imagenes/ImagenGuia/{$filename}";

        // Guardar en BD
        SImagenProducto::create([
            's_d_g_salida_id' => $detalle->id,
            'descripcion'     => $request->descripcion,
            'foto'            => $rutaRelativa,
        ]);

        return back()->with('success', 'Imagen subida exitosamente.');
    }

    public function verPDF($guia_id, $accion = 'stream')
    {
        $detallesSalida = SDetalleGuiaSalida::with(['servicio_guia_salida', 's_detalle_guia_ingreso', 'user', 'tecnico'])
            ->whereHas('servicio_guia_salida', function($query) use ($guia_id) {
                $query->where('s_guia_id', $guia_id);
            })
            ->get();

        // Obtener las imágenes para cada detalle de salida
        $imagenesProducto = [];
        foreach ($detallesSalida as $detalle) {
            // Usar el nombre correcto de la columna: s_d_g_salida_id
            $imagen = SImagenProducto::where('s_d_g_salida_id', $detalle->id)->first();
            if ($imagen) {
                $imagenesProducto[$detalle->id] = $imagen;
            }
        }

        $salida = $detallesSalida;

        $pdf = Pdf::loadView('servicio.pdf_informe_tecnico', [
            'salida' => $salida,
            'imagenesProducto' => $imagenesProducto
        ]);

        switch ($accion) {
            case 'download':
                return $pdf->download("Informe tecnico de la guia {$guia_id}.pdf");
            case 'print':
                $pdf->setOption('javascript-delay', 1000);
                $pdf->setOption('enable-javascript', true);
                $pdf->setOption('no-stop-slow-scripts', true);
                $pdf->setOption('page-size', 'A4');

                $script = "window.onload = function(){ window.print(); }";
                $pdf->setOption('footer-html', '<script>' . $script . '</script>');

                return $pdf->stream('informe_tecnico.pdf');
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

            // Fecha y hora actual
            $now = now();

            // Si ya existe, se actualiza la fecha y updated_at; si no, se crea con created_at y updated_at
            DB::table('s_informe_tecnico')->updateOrInsert(
                ['s_g_salida_id' => $guia->servicio_guia_salida->id],
                [
                    'fecha' => $now,
                    'updated_at' => $now,
                    'created_at' => $now // Esto solo se aplicará si el registro no existe
                ]
            );

            return redirect()->back()->with('success', 'Informe técnico registrado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el informe técnico.');
        }
    }

    public function crearCotizacion($guia_id) {

        $datos = CotizacionManualService::getCreateData();
        if (isset($datos['error'])) {
            return back()->withErrors([$datos['error']]);
        }

        $guia = ServicioGuia::with(['cliente', 'servicio_guia_ingreso.detalle_guia_ingreso'])->findOrFail($guia_id);

        // return $guia;
        return view('transaccion.venta.cotizacion.manual.create', array_merge($datos, [
            'guia' => $guia
        ]));
    }

}
