<?php

namespace App\Http\Controllers;
use App\Renovacion;
use Illuminate\Http\Request;
use App\ComprobantesVentas;
use Carbon\Carbon;

use App\RenovacionVentas;
use App\Almacen;
use App\Igv;
use App\CotizacionManual_registros;
use App\Banco;
use App\Empresa;
use PDF;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use ZipArchive;
class RenovacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


public function index()
{
    $mes_año = Carbon::now()->format('d-m-Y');
    $count_month_ventas = ComprobantesVentas::count_month_ventas($mes_año);
    $almacen = Almacen::get(); // Si lo necesitas
    $count_all_ventas = ComprobantesVentas::count_day_ventas();

    return view('transaccion.venta.renovacion.index', compact('count_month_ventas', 'almacen', 'count_all_ventas'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function printMultiple(Request $request)
    {
        try {
            $renovacionIds = $request->input('renovacion_ids', []);

            if (empty($renovacionIds) || !is_array($renovacionIds)) {
                return back()->withErrors(['No se seleccionaron renovaciones para imprimir.']);
            }

            // OBTENER LAS RENOVACIONES Y SUS COTIZACIONES
            $renovaciones = RenovacionVentas::with('cotizacionManual')
                ->whereIn('id', $renovacionIds)
                ->get();

            if ($renovaciones->count() !== count($renovacionIds)) {
                return back()->withErrors(['Algunas renovaciones seleccionadas no existen.']);
            }

            // EXTRAER LAS COTIZACIONES DE LAS RENOVACIONES
            $cotizaciones = $renovaciones->pluck('cotizacionManual');

            // Recopilar datos para múltiples cotizaciones manuales
            $cotizacionesData = [];
            $igvModel = Igv::first();

            foreach ($cotizaciones as $cotizacion) {
                if (!$cotizacion) continue;

                $cotizacion_m_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();

                // Calcular subtotales
                $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;

                // IGV
                $igv = round($cotizacion->op_gravada, 2) * $igvModel->igv_total / 100;

                // TOTAL
                $end = round($sub_total, 2) + round($igv, 2);

                // OBTENER LA RENOVACIÓN CORRESPONDIENTE
                $renovacion = $renovaciones->firstWhere('cotizacion_manual_id', $cotizacion->id);

                $fecha_vencimiento = null;
                $dias_restantes_texto = null;
                $dias_restantes_numero = null;

                if ($renovacion) {
                    $fecha_actual = Carbon::now();
                    $fecha_emision = Carbon::parse($cotizacion->fecha_emision);

                    // CALCULAR FECHA DE VENCIMIENTO
                    if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                        $dias_acumulados = (int) $renovacion->dia_mensual;
                        $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);

                        while ($fecha_vencimiento->isPast()) {
                            $fecha_vencimiento->addDays($dias_acumulados);
                        }

                    } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                        $dia_vencimiento = (int) $renovacion->dia_anual;
                        $mes_vencimiento = (int) $renovacion->mes_anual;
                        $anio_vencimiento = $renovacion->anio_anual ?? $fecha_actual->year;

                        try {
                            $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, $dia_vencimiento);
                        } catch (\Exception $e) {
                            $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, 1)->endOfMonth();
                        }

                        if ($fecha_vencimiento->isPast()) {
                            $fecha_vencimiento->addYear();
                        }
                    }

                    // CALCULAR DÍAS RESTANTES
                    if ($fecha_vencimiento) {
                        $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                        $dias_restantes_numero = $dias_diferencia;

                        if ($dias_diferencia < 0) {
                            $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                        } elseif ($dias_diferencia == 0) {
                            $dias_restantes_texto = 'Vence hoy';
                        } elseif ($dias_diferencia == 1) {
                            $dias_restantes_texto = $dias_diferencia . ' día';
                        } else {
                            $dias_restantes_texto = $dias_diferencia . ' días';
                        }
                    }
                }

                $cotizacionesData[] = [
                    'cotizacion' => $cotizacion,
                    'cotizacion_m_reg' => $cotizacion_m_reg,
                    'sub_total' => $sub_total,
                    'igv' => $igv,
                    'end' => $end,
                    'renovacion' => $renovacion,
                    'fecha_vencimiento' => $fecha_vencimiento,
                    'dias_restantes_texto' => $dias_restantes_texto,
                    'dias_restantes_numero' => $dias_restantes_numero
                ];
            }

            // Datos comunes
            $banco = Banco::where('estado', '0')->get();
            $banco_count = Banco::where('estado', '0')->count();
            $empresa = Empresa::first();
            $j = 1;

            return view('transaccion.venta.cotizacion.manual.print_multiple', compact(
                'cotizacionesData',
                'empresa',
                'banco',
                'banco_count',
                'j'
            ));

        } catch (\Exception $e) {
            return back()->withErrors(['Error al procesar la impresión múltiple: ' . $e->getMessage()]);
        }
    }

    public function exportarRenovaciones(Request $request)
    {
        if (ob_get_contents()) {
            ob_end_clean();
        }

        $renovacionIds = $request->input('renovacion_ids', []);

        if (empty($renovacionIds) || !is_array($renovacionIds)) {
            return back()->withErrors(['No se seleccionaron renovaciones para exportar.']);
        }

        // OBTENER LAS RENOVACIONES CON SUS COTIZACIONES
        $renovaciones = RenovacionVentas::with([
            'cotizacionManual.almacen',
            'cotizacionManual.cliente',
            'cotizacionManual.moneda',
            'cotizacionManual.forma_pago',
            'cotizacionManual.user_personal.personal',
            'cotizacionManual.tipo_operacion',
            'cotizacionManual.tipo_documento'
        ])
        ->whereIn('id', $renovacionIds)
        ->get();

        $headers = [
            'Código cotizacion',
            'Almacén',
            'Cliente',
            'Moneda',
            'Forma de pago',
            'Garantia',
            'Validez',
            'Fecha de emision',
            'Cambio',
            'Observacion',
            'Personal',
            'Estado',
            'Estado vigente',
            'Tipo',
            'Operacion gravada',
            'Operacion inafecta',
            'Operacion Exonerada',
            'Operacion gratuita',
            'Tipo de Operacion',
            'Tipo de Documento',
            'Subtotal',
            'IGV',
            'Importe Total',
            'Tiene Renovación',
            'Frecuencia Renovación',
            'Fecha Vencimiento',
            'Días Restantes'
        ];

        $rows = [$headers];

        $fecha_actual = Carbon::now();

        foreach ($renovaciones as $renovacion) {
            $cotizacionM = $renovacion->cotizacionManual;

            if (!$cotizacionM) continue;

            $almacen = optional($cotizacionM->almacen)->nombre;
            $cliente = optional($cotizacionM->cliente)->nombre;
            $moneda = optional($cotizacionM->moneda)->nombre;
            $formaPago = optional($cotizacionM->forma_pago)->nombre;
            $personal = '';

            if ($cotizacionM->user_personal && $cotizacionM->user_personal->personal) {
                $personal = trim($cotizacionM->user_personal->personal->nombres . ' ' . $cotizacionM->user_personal->personal->apellidos);
            }

            $estado = $cotizacionM->estado ? 'algo' : 'nada';
            $estadoVigente = $cotizacionM->estadoVigente ? 'algo' : 'nada';
            $infoOperacion = optional($cotizacionM->tipo_operacion)->informacion;
            $infoDocumento = optional($cotizacionM->tipo_documento)->informacion;
            $subtotal = ($cotizacionM->op_gravada ?? 0) + ($cotizacionM->op_inafecta ?? 0) + ($cotizacionM->op_exonerada ?? 0);
            $subtotalGravado = ($cotizacionM->op_gravada);
            $igv_p = round(($subtotalGravado ?? 0) * 0.18, 2);
            $importeTotal = round($subtotal + $igv_p, 2);

            $tiene_renovacion = 'Sí';
            $frecuencia_renovacion = $renovacion->frecuencia;

            $fecha_emision = Carbon::parse($cotizacionM->fecha_emision);
            $fecha_vencimiento = null;
            $fecha_vencimiento_texto = '-';
            $dias_restantes_texto = '-';

            // CALCULAR FECHA DE VENCIMIENTO
            if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                $dias_acumulados = (int) $renovacion->dia_mensual;
                $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);

                while ($fecha_vencimiento->isPast()) {
                    $fecha_vencimiento->addDays($dias_acumulados);
                }

            } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                $dia_vencimiento = (int) $renovacion->dia_anual;
                $mes_vencimiento = (int) $renovacion->mes_anual;
                $anio_vencimiento = $renovacion->anio_anual ?? $fecha_actual->year;

                try {
                    $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, $dia_vencimiento);
                } catch (\Exception $e) {
                    $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, 1)->endOfMonth();
                }

                if ($fecha_vencimiento->isPast()) {
                    $fecha_vencimiento->addYear();
                }
            }

            // CALCULAR DÍAS RESTANTES
            if ($fecha_vencimiento) {
                $fecha_vencimiento_texto = $fecha_vencimiento->format('d-m-Y');
                $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);

                if ($dias_diferencia < 0) {
                    $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                } elseif ($dias_diferencia == 0) {
                    $dias_restantes_texto = 'Vence hoy';
                } elseif ($dias_diferencia == 1) {
                    $dias_restantes_texto = $dias_diferencia . ' día';
                } else {
                    $dias_restantes_texto = $dias_diferencia . ' días';
                }
            }

            $row = [
                $cotizacionM->cod_cotizacion,
                $almacen,
                $cliente,
                $moneda,
                $formaPago,
                $cotizacionM->garantia,
                $cotizacionM->validez,
                $cotizacionM->fecha_emision,
                $cotizacionM->cambio,
                $cotizacionM->observacion,
                $personal,
                $estado,
                $estadoVigente,
                $cotizacionM->tipo,
                $cotizacionM->op_gravada,
                $cotizacionM->op_inafecta,
                $cotizacionM->op_exonerada,
                $cotizacionM->op_gratuita,
                $infoOperacion,
                $infoDocumento,
                $subtotal,
                $igv_p,
                $importeTotal,
                $tiene_renovacion,
                $frecuencia_renovacion,
                $fecha_vencimiento_texto,
                $dias_restantes_texto
            ];

            $rows[] = $row;
        }

        $export = new class($rows) implements FromArray, WithEvents {
            private $rows;

            public function __construct($rows) {
                $this->rows = $rows;
            }

            public function array(): array {
                return $this->rows;
            }

            public function registerEvents(): array {
                return [
                    AfterSheet::class => function(AfterSheet $event) {
                        foreach(range('A','Z') as $column) {
                            $event->sheet->getColumnDimension($column)->setAutoSize(true);
                        }
                        foreach(range('A','Z') as $letter1) {
                            foreach(range('A','Z') as $letter2) {
                                $event->sheet->getColumnDimension($letter1.$letter2)->setAutoSize(true);
                            }
                        }
                    },
                ];
            }
        };

        $fecha = now('America/Lima')->format('d-m-Y');
        return Excel::download($export, 'Renovaciones_' . $fecha . '.xlsx');
    }

    public function downloadMultiplePDFs(Request $request)
    {
        try {
            $renovacionIds = $request->input('cotizacion_ids', []); // Mantener el nombre del parámetro por compatibilidad con el JS

            if (empty($renovacionIds) || !is_array($renovacionIds)) {
                return back()->with('error', 'No se seleccionaron renovaciones para descargar.');
            }

            if (count($renovacionIds) === 1) {
                return $this->downloadSinglePDFRenovacion($renovacionIds[0]);
            }

            // OBTENER LAS RENOVACIONES CON SUS COTIZACIONES
            $renovaciones = RenovacionVentas::with('cotizacionManual')
                ->whereIn('id', $renovacionIds)
                ->get();

            if ($renovaciones->count() !== count($renovacionIds)) {
                return back()->with('error', 'Algunas renovaciones seleccionadas no existen.');
            }

            // Limpiar cualquier output previo
            if (ob_get_level()) {
                ob_end_clean();
            }

            // Crear ZIP temporal usando tempnam
            $tempZip = tempnam(sys_get_temp_dir(), 'renovaciones_');
            $zip = new ZipArchive();

            if ($zip->open($tempZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return back()->with('error', 'Error al crear el archivo ZIP');
            }

            $igv_config = Igv::first();
            $empresa = Empresa::first();

            foreach ($renovaciones as $renovacion) {
                try {
                    $cotizacion = $renovacion->cotizacionManual;

                    if (!$cotizacion) continue;

                    $cotizacion_m_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();

                    $sum = 0;
                    $j = 1;
                    $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
                    $igv = round($cotizacion->op_gravada, 2) * $igv_config->igv_total / 100;
                    $end = round($sub_total, 2) + round($igv, 2);
                    $end2 = number_format(round($sub_total, 2) + round($igv, 2), 2);

                    $fecha_vencimiento = null;
                    $dias_restantes_texto = null;
                    $dias_restantes_numero = null;

                    $fecha_actual = Carbon::now();
                    $fecha_emision = Carbon::parse($cotizacion->fecha_emision);

                    // CALCULAR FECHA DE VENCIMIENTO
                    if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                        $dias_acumulados = (int) $renovacion->dia_mensual;
                        $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);

                        while ($fecha_vencimiento->isPast()) {
                            $fecha_vencimiento->addDays($dias_acumulados);
                        }

                    } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                        $dia_vencimiento = (int) $renovacion->dia_anual;
                        $mes_vencimiento = (int) $renovacion->mes_anual;
                        $anio_vencimiento = $renovacion->anio_anual ?? $fecha_actual->year;

                        try {
                            $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, $dia_vencimiento);
                        } catch (\Exception $e) {
                            $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, 1)->endOfMonth();
                        }

                        if ($fecha_vencimiento->isPast()) {
                            $fecha_vencimiento->addYear();
                        }
                    }

                    // CALCULAR DÍAS RESTANTES
                    if ($fecha_vencimiento) {
                        $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                        $dias_restantes_numero = $dias_diferencia;

                        if ($dias_diferencia < 0) {
                            $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                        } elseif ($dias_diferencia == 0) {
                            $dias_restantes_texto = 'Vence hoy';
                        } elseif ($dias_diferencia == 1) {
                            $dias_restantes_texto = $dias_diferencia . ' día';
                        } else {
                            $dias_restantes_texto = $dias_diferencia . ' días';
                        }
                    }

                    // Generar PDF individual
                    $pdf = PDF::loadView('transaccion.venta.cotizacion.manual.pdf', compact(
                        'j',
                        'cotizacion',
                        'empresa',
                        'cotizacion_m_reg',
                        'sum',
                        'igv',
                        'sub_total',
                        'end',
                        'end2',
                        'renovacion',
                        'fecha_vencimiento',
                        'dias_restantes_texto',
                        'dias_restantes_numero'
                    ));

                    $pdfContent = $pdf->output();

                    $codigoCotizacion = preg_replace('/[^a-zA-Z0-9_-]/', '_', $cotizacion->cod_cotizacion);
                    $fileName = 'Renovacion_' . $codigoCotizacion . '.pdf';
                    $zip->addFromString($fileName, $pdfContent);

                } catch (\Exception $e) {
                    continue;
                }
            }

            $zip->close();
            unset($zip);
            clearstatcache(true, $tempZip);
            usleep(100000);

            // Descargar ZIP usando streamDownload
            return response()->streamDownload(
                function () use ($tempZip) {
                    readfile($tempZip);
                    @unlink($tempZip);
                },
                'Renovaciones_' . date('Y-m-d_H-i-s') . '.zip',
                ['Content-Type' => 'application/zip']
            )->send();

            exit(); // CRÍTICO: Detener la ejecución después de enviar

        } catch (\Exception $e) {
            return back()->with('error', 'Error al descargar renovaciones: ' . $e->getMessage());
        }
    }

    private function downloadSinglePDF($renovacionId)
    {
        try {
            $renovacion = RenovacionVentas::with('cotizacionManual')->findOrFail($renovacionId);
            $cotizacion = $renovacion->cotizacionManual;

            if (!$cotizacion) {
                return back()->with('error', 'No se encontró la cotización asociada a esta renovación.');
            }

            $cotizacion_m_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();

            $empresa = Empresa::first();
            $igv_config = Igv::first();
            $sum = 0;
            $j = 1;

            // SUBTOTAL
            $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;

            // IGV
            $igv = round($cotizacion->op_gravada, 2) * $igv_config->igv_total / 100;

            // TOTAL
            $end = round($sub_total, 2) + round($igv, 2);
            $end2 = number_format(round($sub_total, 2) + round($igv, 2), 2);

            $fecha_vencimiento = null;
            $dias_restantes_texto = null;
            $dias_restantes_numero = null;

            $fecha_actual = Carbon::now();
            $fecha_emision = Carbon::parse($cotizacion->fecha_emision);

            // CALCULAR FECHA DE VENCIMIENTO
            if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                $dias_acumulados = (int) $renovacion->dia_mensual;
                $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);

                while ($fecha_vencimiento->isPast()) {
                    $fecha_vencimiento->addDays($dias_acumulados);
                }

            } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                $dia_vencimiento = (int) $renovacion->dia_anual;
                $mes_vencimiento = (int) $renovacion->mes_anual;
                $anio_vencimiento = $renovacion->anio_anual ?? $fecha_actual->year;

                try {
                    $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, $dia_vencimiento);
                } catch (\Exception $e) {
                    $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, 1)->endOfMonth();
                }

                if ($fecha_vencimiento->isPast()) {
                    $fecha_vencimiento->addYear();
                }
            }

            // CALCULAR DÍAS RESTANTES
            if ($fecha_vencimiento) {
                $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                $dias_restantes_numero = $dias_diferencia;

                if ($dias_diferencia < 0) {
                    $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                } elseif ($dias_diferencia == 0) {
                    $dias_restantes_texto = 'Vence hoy';
                } elseif ($dias_diferencia == 1) {
                    $dias_restantes_texto = $dias_diferencia . ' día';
                } else {
                    $dias_restantes_texto = $dias_diferencia . ' días';
                }
            }

            // Generar PDF
            $pdf = PDF::loadView('transaccion.venta.cotizacion.manual.pdf', compact(
                'j',
                'cotizacion',
                'empresa',
                'cotizacion_m_reg',
                'sum',
                'igv',
                'sub_total',
                'end',
                'end2',
                'renovacion',
                'fecha_vencimiento',
                'dias_restantes_texto',
                'dias_restantes_numero'
            ));

            return $pdf->download('Renovacion_' . $cotizacion->cod_cotizacion . '.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al descargar el PDF: ' . $e->getMessage());
        }
    }
}
