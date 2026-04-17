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
use App\Cotizacion;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;
use App\Empresa;
use PDF;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Exports\RenovacionExport;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Exception;
use Illuminate\Support\Facades\Storage;
use mikehaertl\wkhtmlto\Pdf as WkhtmltoPdf;
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
        $ids = $request->input('renovacion_ids', []);

        if (empty($ids) || !is_array($ids)) {
            return back()->withErrors(['No se seleccionaron renovaciones para exportar.']);
        }

        return Excel::download(
            new RenovacionExport($ids),
            'Renovaciones_' . now('America/Lima')->format('d-m-Y') . '.xlsx'
        );
    }

    public function downloadMultiplePDFs(Request $request)
    {
        try {
            $renovacionIds = $request->input('cotizacion_ids', []);

            if (empty($renovacionIds) || !is_array($renovacionIds)) {
                return back()->with('error', 'No se seleccionaron renovaciones para descargar.');
            }

            if (count($renovacionIds) === 1) {
                return $this->downloadSinglePDF($renovacionIds[0]);
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
                'cotizacion_m_reg'      => $cotizacion_reg,
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

    public function enviarCorreoMultiple(Request $request)
    {
        try {
            $email = $request->get('email');
            $cotizacion_ids = $request->get('cotizacion_ids', []);

            if (empty($cotizacion_ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron cotizaciones para enviar.'
                ], 400);
            }

            if (empty($email)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El correo electrónico es requerido.'
                ], 400);
            }

            $id_usuario   = auth()->user()->id;
            $config_email = EmailConfiguraciones::where('id_usuario', $id_usuario)->first();

            if (!$config_email) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes configuración de email. Ve a configuración.'
                ], 400);
            }

            $fecha  = Carbon::now();
            $data_g = str_replace(' ', '_', $fecha);
            $date   = str_replace(':', '-', $data_g);

            $banco       = Banco::where('estado', '0')->get();
            $banco_count = Banco::where('estado', '0')->count();
            $empresa     = Empresa::first();
            $igv         = Igv::first();

            // Configuración de email
            $yourEmail  = $config_email->email;
            $firma      = $config_email->firma_digital;
            $firma_email = $config_email->firma;
            $alto       = $config_email->alto_firma;
            $ancho      = $config_email->ancho_firma;

            $titulo       = "Cotizaciones - " . count($cotizacion_ids) . " documento(s)";
            $mensaje_html = "Estimado cliente, adjuntamos las cotizaciones solicitadas.";
            $mensaje      = view('email_html.email_send_layout', compact('empresa', 'mensaje_html', 'firma_email', 'alto', 'ancho', 'firma'));

            // Agregar email backup si existe
            $correos_envios = [$email, $config_email->email_backup];
            $mails_array    = array_filter($correos_envios);

            // Configurar transporte de email
            $transport = (new \Swift_SmtpTransport($config_email->smtp, $config_email->port, $config_email->encryption))
                ->setUsername($config_email->email)
                ->setPassword($config_email->password);

            $mailer = new \Swift_Mailer($transport);
            $mailer->getTransport()->start();

            $message = (new \Swift_Message($yourEmail))
                ->setFrom([$yourEmail => $titulo])
                ->setTo($mails_array)
                ->setBody($mensaje, 'text/html');

            $archivos_temporales = [];

            foreach ($cotizacion_ids as $cotizacion_id) {

                $cotizacion = Cotizacion::find($cotizacion_id);
                if (!$cotizacion) continue;

                // Trae el detalle de la cotización
                $cotizacion_registro = Cotizacion_factura_registro::where('cotizacion_id', $cotizacion_id)->get();

                // Calcular totales
                $sub_total = $cotizacion->op_gravada + $cotizacion->op_exonerada + $cotizacion->op_inafecta;
                $igv_p     = round($cotizacion->op_gravada, 2) * $igv->igv_total / 100;
                $end       = round($sub_total, 2) + round($igv_p, 2);
                $end2      = number_format($end, 2);

                $firma  = EmailConfiguraciones::where('id_usuario', $cotizacion->user_id)->pluck('firma_digital')->first();
                $sum    = 0;
                $i      = 1;
                $regla  = $cotizacion->tipo;

                // Verificar si existe renovación
                $renovacion = RenovacionVentas::where('cotizacion_id', $cotizacion_id)
                                            ->where('estado', 1)
                                            ->first();

                $fecha_inicio          = null;
                $fecha_vencimiento     = null;
                $dias_restantes_texto  = null;
                $dias_restantes_numero = null;

                if ($renovacion) {
                    $fecha_inicio      = Carbon::parse($renovacion->fecha_inicio)->format('d/m/Y');
                    $fecha_actual      = Carbon::now()->startOfDay();
                    $fecha_vencimiento = Carbon::parse($renovacion->fecha_vencimiento)->startOfDay();
                    $diff              = $fecha_actual->diffInDays($fecha_vencimiento, false);

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

                // Generar PDF
                $archivo = 'PDF-DOC-' . $cotizacion->cod_cotizacion . '-' . $empresa->ruc . ".pdf";
                $pdf = PDF::loadView('transaccion.venta.cotizacion.pdf2', compact(
                    'cotizacion',
                    'cotizacion_registro',
                    'empresa',
                    'regla',
                    'sum',
                    'igv',
                    'sub_total',
                    'banco',
                    'i',
                    'end',
                    'igv_p',
                    'banco_count',
                    'firma',
                    'end2',
                    'renovacion',
                    'fecha_inicio',
                    'fecha_vencimiento',
                    'dias_restantes_texto',
                    'dias_restantes_numero'
                ));

                $content = $pdf->download();
                $especif = $date . $archivo;
                Storage::disk('mailbox')->put($especif, $content);

                $pdfile = public_path() . '/archivos/' . $especif;
                $message->attach(\Swift_Attachment::fromPath($pdfile));

                $archivos_temporales[] = $especif;
            }

            // Enviar correo
            if ($mailer->send($message)) {
                $texto = strip_tags($mensaje_html);

                // Guardar en bandeja de envíos
                $mail                   = new EmailBandejaEnvios;
                $mail->id_usuario       = auth()->user()->id;
                $mail->destinatario     = $yourEmail;
                $mail->remitente        = $email;
                $mail->asunto           = $titulo;
                $mail->mensaje          = $mensaje_html;
                $mail->mensaje_sin_html = $texto;
                $mail->estado           = '0';
                $mail->fecha_hora       = Carbon::now();
                $mail->save();

                foreach ($archivos_temporales as $archivo_temp) {
                    $archivo_pdf                  = new EmailBandejaEnviosArchivos;
                    $archivo_pdf->id_bandeja_envios = $mail->id;
                    $archivo_pdf->archivo         = $archivo_temp;
                    $archivo_pdf->fecha_hora      = $date;
                    $archivo_pdf->save();
                }

                $this->limpiarArchivosViejos(2880);

                return response()->json([
                    'success' => true,
                    'message' => 'Se enviaron ' . count($cotizacion_ids) . ' cotización(es) exitosamente a: ' . $email
                ]);
            }

            // Si falla el envío, limpiar archivos
            foreach ($archivos_temporales as $archivo_temp) {
                Storage::disk('mailbox')->delete($archivo_temp);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el correo. Verifica tu configuración.'
            ], 500);

        } catch (\Exception $e) {
            if (isset($archivos_temporales) && !empty($archivos_temporales)) {
                foreach ($archivos_temporales as $archivo_temp) {
                    Storage::disk('mailbox')->delete($archivo_temp);
                }
            }
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    private function limpiarArchivosViejos($minutos = 2880)
    {
        try {
            $disk = Storage::disk('mailbox');
            $archivos = $disk->allFiles();

            foreach ($archivos as $file) {
                if (preg_match('/^\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}/', $file)) {
                    $lastModified = $disk->lastModified($file);
                    $tiempoTranscurrido = now()->timestamp - $lastModified;

                    if ($tiempoTranscurrido > ($minutos * 60)) {
                        $disk->delete($file);
                    }
                }
            }

        } catch (\Exception $e) {
        }
    }
}
