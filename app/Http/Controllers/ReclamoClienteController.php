<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ReclamoClienteRequest;
use App\Jobs\NotificarProveedorReclamoB2B;
use App\SerieProducto;
use App\Services\GarantiaRulesEngineService;
use App\ValueObjects\VeredictoGarantia;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReclamoClienteController extends Controller
{
    /**
     * @var GarantiaRulesEngineService
     */
    private $garantiaRulesEngineService;

    public function __construct(GarantiaRulesEngineService $garantiaRulesEngineService)
    {
        $this->garantiaRulesEngineService = $garantiaRulesEngineService;
    }

    public function store(ReclamoClienteRequest $request): JsonResponse
    {
        try {
            $serie = SerieProducto::where('numero_serie', $request->input('numero_serie'))->firstOrFail();

            $evidencias = [];
            foreach ($request->file('evidencias', []) as $archivo) {
                $rutaDestino = 'reclamos/' . $serie->id . '/' . date('Y-m-d');
                $nombreArchivo = Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME), '-')
                    . '-' . Str::random(10)
                    . '.' . $archivo->getClientOriginalExtension();

                $ruta = Storage::disk('public')->putFileAs($rutaDestino, $archivo, $nombreArchivo);
                $evidencias[] = $ruta;
            }

            $veredicto = $this->garantiaRulesEngineService->evaluarCobertura(
                $serie,
                (string) $request->input('tipo_falla', 'defecto de fabrica'),
                (array) $request->input('condiciones_uso', [])
            );

            if ($veredicto->estado() === VeredictoGarantia::APROBADO_AUTOMATICO) {
                NotificarProveedorReclamoB2B::dispatch($serie, [
                    'descripcion' => $request->input('descripcion'),
                    'tipo_falla' => $request->input('tipo_falla'),
                    'evidencias' => $evidencias,
                ]);
            }

            return response()->json([
                'success' => true,
                'estado' => $veredicto->estado(),
                'mensaje' => $veredicto->mensaje(),
                'evidencias' => $evidencias,
            ], 201);
        } catch (\Throwable $exception) {
            Log::error('No se pudo procesar el reclamo del cliente.', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'No se pudo registrar el reclamo. Inténtelo nuevamente.',
            ], 500);
        }
    }
}
