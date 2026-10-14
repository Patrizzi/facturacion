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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ReclamoClienteController extends Controller
{
    private GarantiaRulesEngineService $garantiaRulesEngineService;

    public function __construct(GarantiaRulesEngineService $garantiaRulesEngineService)
    {
        $this->garantiaRulesEngineService = $garantiaRulesEngineService;
    }

    public function store(ReclamoClienteRequest $request)
    {
        $rutasEvidencias = [];

        try {
            $resultado = DB::transaction(function () use ($request, &$rutasEvidencias): array {
                $serie = SerieProducto::with([
                    'facturacionRegistro.factura_ids',
                    'boletaRegistro.boleta_i',
                    'notaVentaRegistro.notaVenta',
                    'garantiaActual',
                    'lote',
                ])
                    ->where('numero_serie', $request->input('numero_serie'))
                    ->firstOrFail();

                // 1. Identificar cliente vinculado a la venta (explícito, o derivado de Factura / Boleta / Nota de Venta)
                $clienteId = $request->input('cliente_id');
                if (!$clienteId) {
                    if ($serie->facturacionRegistro && $serie->facturacionRegistro->factura_ids) {
                        $clienteId = $serie->facturacionRegistro->factura_ids->cliente_id;
                    } elseif ($serie->boletaRegistro && $serie->boletaRegistro->boleta_i) {
                        $clienteId = $serie->boletaRegistro->boleta_i->cliente_id;
                    } elseif ($serie->notaVentaRegistro && $serie->notaVentaRegistro->notaVenta) {
                        $clienteId = $serie->notaVentaRegistro->notaVenta->cliente_id;
                    }
                }

                if (!$clienteId) {
                    $clienteId = Cliente::first()->id ?? null;
                }

                if (!$clienteId) {
                    throw ValidationException::withMessages([
                        'numero_serie' => 'No se pudo identificar el cliente asociado a la venta de esta serie.',
                    ]);
                }

                $reclamo = ReclamoGarantia::create([
                    'serie_id'          => $serie->id,
                    'cliente_id'        => $clienteId,
                    'descripcion_falla' => (string) $request->input('descripcion'),
                    'estado'            => 'Pendiente',
                ]);

                foreach ($request->file('evidencias', []) as $archivo) {
                    $ruta = $archivo->store(
                        'reclamos/' . $serie->id . '/' . Carbon::today()->toDateString(),
                        'public'
                    );

                    if (!$ruta) {
                        throw new \RuntimeException('No fue posible guardar una de las evidencias del reclamo.');
                    }

                    $rutasEvidencias[] = $ruta;
                    $extension = strtolower($archivo->getClientOriginalExtension());

                    ArchivoEvidenciaGarantia::create([
                        'reclamo_garantia_id' => $reclamo->id,
                        'ruta_archivo'        => $ruta,
                        'tipo_archivo'        => substr($extension, 0, 10),
                    ]);
                }

                $veredicto = $this->garantiaRulesEngineService->evaluarCobertura(
                    $serie,
                    (string) $request->input('tipo_falla', 'defecto de fabrica'),
                    (array) $request->input('condiciones_uso', [])
                );
                $notificacionProveedor = null;

                if ($veredicto->estado() === VeredictoGarantia::APROBADO_AUTOMATICO) {
                    $reclamo->update(['estado' => 'Aprobado']);

                    $proveedorId = $serie->lote ? $serie->lote->proveedor_id : null;
                    if ($proveedorId) {
                        GarantiaProveedor::create([
                            'reclamo_garantia_id' => $reclamo->id,
                            'proveedor_id'        => $proveedorId,
                            'estado_solicitud'    => 'Enviado',
                            'resolucion'          => $veredicto->mensaje(),
                        ]);

                        $notificacionProveedor = [
                            'serie' => $serie,
                            'datos' => [
                                'reclamo_id'  => $reclamo->id,
                                'descripcion' => $request->input('descripcion'),
                                'tipo_falla'  => $request->input('tipo_falla'),
                                'evidencias'  => $rutasEvidencias,
                            ],
                        ];
                    }
                } elseif ($veredicto->estado() === VeredictoGarantia::ESCALAR_TECNICO) {
                    $reclamo->update(['estado' => 'En Revision Tecnica']);

                    OrdenServicio::create([
                        'reclamo_garantia_id' => $reclamo->id,
                        'tecnico_id'          => null,
                        'diagnostico_tecnico' => $veredicto->mensaje(),
                        'estado'              => 'Pendiente',
                        'fecha_inicio'        => Carbon::today()->toDateString(),
                    ]);
                } else {
                    $reclamo->update(['estado' => 'Rechazado']);
                }

                return [
                    'reclamo_id'             => $reclamo->id,
                    'estado'                 => $veredicto->estado(),
                    'mensaje'                => $veredicto->mensaje(),
                    'codigo_producto'        => $serie->codigo_producto,
                    'notificacion_proveedor' => $notificacionProveedor,
                ];
            });
        } catch (\Throwable $exception) {
            if ($rutasEvidencias) {
                Storage::disk('public')->delete($rutasEvidencias);
            }

            throw $exception;
        }

        if ($resultado['notificacion_proveedor']) {
            NotificarProveedorReclamoB2B::dispatch(
                $resultado['notificacion_proveedor']['serie'],
                $resultado['notificacion_proveedor']['datos']
            );
        }

        $mensaje = 'Reclamo registrado: ' . $resultado['mensaje'];
        if ($request->expectsJson() || $request->is('api/*') || $request->is('api/reclamo-cliente')) {
            return response()->json([
                'success'    => true,
                'reclamo_id' => $resultado['reclamo_id'],
                'estado'     => $resultado['estado'],
                'mensaje'    => $mensaje,
                'evidencias' => $rutasEvidencias,
            ], 201);
        }

        return redirect()
            ->route('lotes-garantias.reclamo-cliente', ['codigo_producto' => $resultado['codigo_producto']])
            ->with('success', $mensaje);
    }
}
