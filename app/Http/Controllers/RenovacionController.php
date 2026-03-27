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
use App\Cotizacion_factura_registro;
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

            $renovaciones = RenovacionVentas::with(['cotizacionManual', 'cotizacion'])
                ->whereIn('id', $renovacionIds)
                ->get();

            if ($renovaciones->count() !== count($renovacionIds)) {
                return back()->withErrors(['Algunas renovaciones seleccionadas no existen.']);
            }

            $igvModel  = Igv::first();
            $banco     = Banco::where('estado', '0')->get();
            $banco_count = Banco::where('estado', '0')->count();
            $empresa   = Empresa::first();
            $j         = 1;

            $cotizacionesData = [];

            foreach ($renovaciones as $renovacion) {
                $cotizacion = $renovacion->cotizacionManual ?? $renovacion->cotizacion;

                if (!$cotizacion) continue;

                if ($renovacion->cotizacionManual) {
                    $cotizacion_m_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();
                } else {
                    $cotizacion_m_reg = Cotizacion_factura_registro::where('cotizacion_id', $cotizacion->id)->get();
                }

                $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
                $igv       = round($cotizacion->op_gravada, 2) * $igvModel->igv_total / 100;
                $end       = round($sub_total, 2) + round($igv, 2);

                $fecha_actual      = Carbon::now()->startOfDay();
                $fecha_vencimiento = Carbon::parse($renovacion->fecha_vencimiento)->startOfDay();
                $diff              = $fecha_actual->diffInDays($fecha_vencimiento, false);

                if ($diff < 0) {
                    $dias_restantes_texto = abs($diff) . ' días vencido';
                } elseif ($diff == 0) {
                    $dias_restantes_texto = 'Vence hoy';
                } elseif ($diff == 1) {
                    $dias_restantes_texto = '1 día';
                } else {
                    $dias_restantes_texto = $diff . ' días';
                }

                $cotizacionesData[] = [
                    'cotizacion'            => $cotizacion,
                    'cotizacion_m_reg'      => $cotizacion_m_reg,
                    'sub_total'             => $sub_total,
                    'igv'                   => $igv,
                    'end'                   => $end,
                    'renovacion'            => $renovacion,
                    'fecha_vencimiento'     => $fecha_vencimiento,
                    'dias_restantes_texto'  => $dias_restantes_texto,
                    'dias_restantes_numero' => $diff
                ];
            } // ← foreach cierra aquí correctamente

            return view('transaccion.venta.cotizacion.manual.print_multiple', compact(
                'cotizacionesData',
                'empresa',
                'banco',
                'banco_count',
                'j',
                'igvModel'
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

        $renovaciones = RenovacionVentas::with([
            'cotizacionManual.almacen',
            'cotizacionManual.cliente',
            'cotizacionManual.moneda',
            'cotizacionManual.forma_pago',
            'cotizacionManual.user_personal.personal',
            'cotizacionManual.tipo_operacion',
            'cotizacionManual.tipo_documento',
            'cotizacion.almacen',
            'cotizacion.cliente',
            'cotizacion.moneda',
            'cotizacion.forma_pago',
            'cotizacion.user_personal.personal',
            'cotizacion.tipo_operacion',
            'cotizacion.tipo_documento'
        ])
        ->whereIn('id', $renovacionIds)
        ->get();

        $headers = [
            'Código cotizacion', 'Almacén', 'Cliente', 'Moneda', 'Forma de pago',
            'Garantia', 'Validez', 'Fecha de emision', 'Cambio', 'Observacion',
            'Personal', 'Estado', 'Estado vigente', 'Tipo', 'Operacion gravada',
            'Operacion inafecta', 'Operacion Exonerada', 'Operacion gratuita',
            'Tipo de Operacion', 'Tipo de Documento', 'Subtotal', 'IGV',
            'Importe Total', 'Tiene Renovación', 'Fecha Vencimiento', 'Días Restantes'
        ];

        $rows = [$headers];
        $fecha_actual = Carbon::now()->startOfDay();

        foreach ($renovaciones as $renovacion) {
            $cotizacion = $renovacion->cotizacionManual ?? $renovacion->cotizacion;
            if (!$cotizacion) continue;

            $personal = '';
            if ($cotizacion->user_personal && $cotizacion->user_personal->personal) {
                $personal = trim(
                    $cotizacion->user_personal->personal->nombres . ' ' .
                    $cotizacion->user_personal->personal->apellidos
                );
            }

            $subtotal      = ($cotizacion->op_gravada ?? 0) + ($cotizacion->op_inafecta ?? 0) + ($cotizacion->op_exonerada ?? 0);
            $igv_p         = round(($cotizacion->op_gravada ?? 0) * 0.18, 2);
            $importeTotal  = round($subtotal + $igv_p, 2);

            // ✅ Usar fecha_vencimiento guardada en BD, no recalcular
            $fecha_vencimiento_texto = '-';
            $dias_restantes_texto    = '-';

            if ($renovacion->fecha_vencimiento) {
                $fecha_vencimiento       = Carbon::parse($renovacion->fecha_vencimiento)->startOfDay();
                $fecha_vencimiento_texto = $fecha_vencimiento->format('d-m-Y');
                $diff                    = $fecha_actual->diffInDays($fecha_vencimiento, false);

                if ($diff < 0) {
                    $dias_restantes_texto = abs($diff) . ' días vencido';
                } elseif ($diff == 0) {
                    $dias_restantes_texto = 'Vence hoy';
                } elseif ($diff == 1) {
                    $dias_restantes_texto = '1 día';
                } else {
                    $dias_restantes_texto = $diff . ' días';
                }
            }

            $rows[] = [
                $cotizacion->cod_cotizacion,
                optional($cotizacion->almacen)->nombre,
                optional($cotizacion->cliente)->nombre,
                optional($cotizacion->moneda)->nombre,
                optional($cotizacion->forma_pago)->nombre,
                $cotizacion->garantia,
                $cotizacion->validez,
                $cotizacion->fecha_emision,
                $cotizacion->cambio,
                $cotizacion->observacion,
                $personal,
                $cotizacion->estado ? 'Activo' : 'Inactivo',
                $cotizacion->estadoVigente ? 'Vigente' : 'No vigente',
                $cotizacion->tipo,
                $cotizacion->op_gravada,
                $cotizacion->op_inafecta,
                $cotizacion->op_exonerada,
                $cotizacion->op_gratuita,
                optional($cotizacion->tipo_operacion)->informacion,
                optional($cotizacion->tipo_documento)->informacion,
                $subtotal,
                $igv_p,
                $importeTotal,
                'Sí',
                $fecha_vencimiento_texto,
                $dias_restantes_texto
            ];
        }

        $export = new class($rows) implements FromArray, WithEvents {
            private $rows;
            public function __construct($rows) { $this->rows = $rows; }
            public function array(): array { return $this->rows; }
            public function registerEvents(): array {
                return [
                    AfterSheet::class => function(AfterSheet $event) {
                        foreach (range('A', 'Z') as $col) {
                            $event->sheet->getColumnDimension($col)->setAutoSize(true);
                        }
                    },
                ];
            }
        };

        return Excel::download($export, 'Renovaciones_' . now('America/Lima')->format('d-m-Y') . '.xlsx');
    }

    public function downloadMultiplePDFs(Request $request)
    {
        try {
            $renovacionIds = $request->input('cotizacion_ids', []);

            if (empty($renovacionIds) || !is_array($renovacionIds)) {
                return back()->with('error', 'No se seleccionaron renovaciones para descargar.');
            }

            if (count($renovacionIds) === 1) {
                return $this->downloadSinglePDF($renovacionIds[0]); // ✅ nombre correcto
            }

            $renovaciones = RenovacionVentas::with(['cotizacionManual', 'cotizacion'])
                ->whereIn('id', $renovacionIds)
                ->get();

            if ($renovaciones->count() !== count($renovacionIds)) {
                return back()->with('error', 'Algunas renovaciones seleccionadas no existen.');
            }

            if (ob_get_level()) ob_end_clean();

            $tempZip = tempnam(sys_get_temp_dir(), 'renovaciones_');
            $zip = new ZipArchive();

            if ($zip->open($tempZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return back()->with('error', 'Error al crear el archivo ZIP');
            }

            $igv_config = Igv::first();
            $empresa    = Empresa::first();
            $fecha_actual = Carbon::now()->startOfDay();

            foreach ($renovaciones as $renovacion) {
                try {
                    $cotizacion = $renovacion->cotizacionManual ?? $renovacion->cotizacion;
                    if (!$cotizacion) continue;

                    if ($renovacion->cotizacionManual) {
                        $cotizacion_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get(); // ✅
                        $vista_pdf = 'transaccion.venta.cotizacion.manual.pdf';
                    } else {
                        $cotizacion_reg = Cotizacion_factura_registro::where('cotizacion_id', $cotizacion->id)->get(); // ✅
                        $vista_pdf = 'transaccion.venta.cotizacion.pdf';
                    }

                    $sum       = 0;
                    $j         = 1;
                    $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
                    $igv       = round($cotizacion->op_gravada, 2) * $igv_config->igv_total / 100;
                    $end       = round($sub_total, 2) + round($igv, 2);
                    $end2      = number_format($end, 2);

                    $fecha_vencimiento       = null;
                    $dias_restantes_texto    = null;
                    $dias_restantes_numero   = null;

                    if ($renovacion->fecha_vencimiento) {
                        $fecha_vencimiento     = Carbon::parse($renovacion->fecha_vencimiento)->startOfDay();
                        $diff                  = $fecha_actual->diffInDays($fecha_vencimiento, false);
                        $dias_restantes_numero = $diff;

                        if ($diff < 0) {
                            $dias_restantes_texto = abs($diff) . ' días vencido';
                        } elseif ($diff == 0) {
                            $dias_restantes_texto = 'Vence hoy';
                        } elseif ($diff == 1) {
                            $dias_restantes_texto = '1 día';
                        } else {
                            $dias_restantes_texto = $diff . ' días';
                        }
                    }

                    $pdf = PDF::loadView($vista_pdf, [
                        'j'                    => $j,
                        'cotizacion'           => $cotizacion,
                        'empresa'              => $empresa,
                        'cotizacion_m_reg'     => $cotizacion_reg,
                        'sum'                  => $sum,
                        'igv'                  => $igv,
                        'sub_total'            => $sub_total,
                        'end'                  => $end,
                        'end2'                 => $end2,
                        'renovacion'           => $renovacion,
                        'fecha_vencimiento'    => $fecha_vencimiento,
                        'dias_restantes_texto' => $dias_restantes_texto,
                        'dias_restantes_numero'=> $dias_restantes_numero
                    ]);

                    $codigoCotizacion = preg_replace('/[^a-zA-Z0-9_-]/', '_', $cotizacion->cod_cotizacion);
                    $zip->addFromString('Renovacion_' . $codigoCotizacion . '.pdf', $pdf->output());

                } catch (\Exception $e) {
                    continue;
                }
            }

            $zip->close();
            unset($zip);
            clearstatcache(true, $tempZip);
            usleep(100000);

            return response()->streamDownload(
                function () use ($tempZip) {
                    readfile($tempZip);
                    @unlink($tempZip);
                },
                'Renovaciones_' . date('Y-m-d_H-i-s') . '.zip',
                ['Content-Type' => 'application/zip']
            );

        } catch (\Exception $e) {
            return back()->with('error', 'Error al descargar renovaciones: ' . $e->getMessage());
        }
    }

    private function downloadSinglePDF($renovacionId)
    {
        try {
            $renovacion = RenovacionVentas::with(['cotizacionManual', 'cotizacion'])->findOrFail($renovacionId);
            $cotizacion = $renovacion->cotizacionManual ?? $renovacion->cotizacion;

            if (!$cotizacion) {
                return back()->with('error', 'No se encontró la cotización asociada a esta renovación.');
            }

            if ($renovacion->cotizacionManual) {
                $cotizacion_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get(); // ✅
                $vista_pdf = 'transaccion.venta.cotizacion.manual.pdf';
            } else {
                $cotizacion_reg = Cotizacion_factura_registro::where('cotizacion_id', $cotizacion->id)->get(); // ✅
                $vista_pdf = 'transaccion.venta.cotizacion.pdf';
            }

            $empresa    = Empresa::first();
            $igv_config = Igv::first();
            $sum        = 0;
            $j          = 1;
            $sub_total  = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
            $igv        = round($cotizacion->op_gravada, 2) * $igv_config->igv_total / 100;
            $end        = round($sub_total, 2) + round($igv, 2);
            $end2       = number_format($end, 2);

            $fecha_vencimiento       = null;
            $dias_restantes_texto    = null;
            $dias_restantes_numero   = null;
            $fecha_actual            = Carbon::now()->startOfDay();

            if ($renovacion->fecha_vencimiento) {
                $fecha_vencimiento     = Carbon::parse($renovacion->fecha_vencimiento)->startOfDay();
                $diff                  = $fecha_actual->diffInDays($fecha_vencimiento, false);
                $dias_restantes_numero = $diff;

                if ($diff < 0) {
                    $dias_restantes_texto = abs($diff) . ' días vencido';
                } elseif ($diff == 0) {
                    $dias_restantes_texto = 'Vence hoy';
                } elseif ($diff == 1) {
                    $dias_restantes_texto = '1 día';
                } else {
                    $dias_restantes_texto = $diff . ' días';
                }
            }

            $pdf = PDF::loadView($vista_pdf, [
                'j'                     => $j,
                'cotizacion'            => $cotizacion,
                'empresa'               => $empresa,
                'cotizacion_m_reg'      => $cotizacion_reg, // ✅ nombre correcto para la vista
                'sum'                   => $sum,
                'igv'                   => $igv,
                'sub_total'             => $sub_total,
                'end'                   => $end,
                'end2'                  => $end2,
                'renovacion'            => $renovacion,
                'fecha_vencimiento'     => $fecha_vencimiento,
                'dias_restantes_texto'  => $dias_restantes_texto,
                'dias_restantes_numero' => $dias_restantes_numero
            ]);

            return $pdf->download('Renovacion_' . $cotizacion->cod_cotizacion . '.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al descargar el PDF: ' . $e->getMessage());
        }
    }
}
