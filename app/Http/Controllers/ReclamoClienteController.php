<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\ArchivoEvidenciaGarantia;
use App\Cliente;
use App\GarantiaProveedor;
use App\Http\Requests\ReclamoClienteRequest;
use App\Jobs\NotificarProveedorReclamoB2B;
use App\OrdenServicio;
use App\ReclamoGarantia;
use App\SerieProducto;
use App\Services\GarantiaRulesEngineService;
use App\ValueObjects\VeredictoGarantia;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReclamoClienteController extends Controller
{
    private GarantiaRulesEngineService $garantiaRulesEngineService;

    public function __construct(GarantiaRulesEngineService $garantiaRulesEngineService)
    {
        $this->garantiaRulesEngineService = $garantiaRulesEngineService;
    }

    public function store(ReclamoClienteRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request): JsonResponse {
            $serie = SerieProducto::with([
                'facturacionRegistro.factura_ids',
                'boletaRegistro.boleta_i',
                'lote'
            ])
                ->where('numero_serie', $request->input('numero_serie'))
                ->firstOrFail();

            // Identificar cliente vinculado a la venta
            $clienteId = $request->input('cliente_id');
            if (!$clienteId) {
                if ($serie->facturacionRegistro && $serie->facturacionRegistro->factura_ids) {
                    $clienteId = $serie->facturacionRegistro->factura_ids->cliente_id;
                } elseif ($serie->boletaRegistro && $serie->boletaRegistro->boleta_i) {
                    $clienteId = $serie->boletaRegistro->boleta_i->cliente_id;
                }
            }

            if (!$clienteId) {
                $clienteId = Cliente::first()->id ?? 1; // Fallback a cliente general
            }

            // 1. Persistir Reclamo Principal
            $reclamo = ReclamoGarantia::create([
                'serie_id'          => $serie->id,
                'cliente_id'        => $clienteId,
                'descripcion_falla' => (string) $request->input('descripcion'),
                'estado'            => 'Pendiente',
            ]);

            // 2. Subida física y persistencia de evidencias
            $rutasEvidencias = [];
            foreach ($request->file('evidencias', []) as $archivo) {
                $rutaDestino = 'reclamos/' . $serie->id . '/' . date('Y-m-d');
                $extension = $archivo->getClientOriginalExtension();
                $nombreArchivo = Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME), '-')
                    . '-' . Str::random(10) . '.' . $extension;

                $ruta = $archivo->storeAs($rutaDestino, $nombreArchivo, 'public');
                $rutasEvidencias[] = $ruta;

                ArchivoEvidenciaGarantia::create([
                    'reclamo_garantia_id' => $reclamo->id,
                    'ruta_archivo'        => $ruta,
                    'tipo_archivo'        => substr($extension, 0, 10),
                ]);
            }

            // 3. Evaluación con Motor de Reglas
            $veredicto = $this->garantiaRulesEngineService->evaluarCobertura(
                $serie,
                (string) $request->input('tipo_falla', 'defecto de fabrica'),
                (array) $request->input('condiciones_uso', [])
            );

            // 4. Consecuencias del Veredicto en el Modelo ER Multi-Actor
            if ($veredicto->estado() === VeredictoGarantia::APROBADO_AUTOMATICO) {
                $reclamo->update(['estado' => 'Aprobado']);

                $proveedorId = $serie->lote ? $serie->lote->proveedor_id : null;
                if ($proveedorId) {
                    GarantiaProveedor::create([
                        'reclamo_garantia_id' => $reclamo->id,
                        'proveedor_id'        => $proveedorId,
                        'estado_solicitud'    => 'Enviado',
                        'resolucion'          => 'Aprobación automática por defecto de fábrica.',
                    ]);
                }

                NotificarProveedorReclamoB2B::dispatch($serie, [
                    'reclamo_id'   => $reclamo->id,
                    'descripcion'  => $request->input('descripcion'),
                    'tipo_falla'   => $request->input('tipo_falla'),
                    'evidencias'   => $rutasEvidencias,
                ]);
            } elseif ($veredicto->estado() === VeredictoGarantia::ESCALAR_TECNICO) {
                $reclamo->update(['estado' => 'En Revision Tecnica']);

                OrdenServicio::create([
                    'reclamo_garantia_id' => $reclamo->id,
                    'tecnico_id'          => null, // Asignable por el supervisor
                    'diagnostico_tecnico' => 'Escalado automáticamente: requiere peritaje técnico de evidencia.',
                    'estado'              => 'Pendiente',
                    'fecha_inicio'        => Carbon::today()->toDateString(),
                ]);
            } else {
                $reclamo->update(['estado' => 'Rechazado']);
            }

            return response()->json([
                'success'    => true,
                'reclamo_id' => $reclamo->id,
                'estado'     => $veredicto->estado(),
                'mensaje'    => $veredicto->mensaje(),
                'evidencias' => $rutasEvidencias,
            ], 201);
        });
    }
}
