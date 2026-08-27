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
use App\Exports\RenovacionExport;
use ZipArchive;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;
use App\Moneda;
use Exception;
use Illuminate\Support\Facades\Storage;

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
        $moneda = Moneda::get();
        $count_all_ventas = ComprobantesVentas::count_day_ventas();

        return view('transaccion.venta.renovacion.index', compact('count_month_ventas', 'almacen', 'count_all_ventas','moneda'));
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
            $banco      = Banco::where('estado', '0')->get();
            $banco_count = Banco::where('estado', '0')->count();
            $banco      = Banco::where('estado', '0')->get();
            $banco_count = Banco::where('estado', '0')->count();
            $fecha_actual = Carbon::now()->startOfDay();

            foreach ($renovaciones as $renovacion) {
                try {
                    $cotizacion = $renovacion->cotizacionManual ?? $renovacion->cotizacion;
                    if (!$cotizacion) continue;

                    if ($renovacion->cotizacionManual) {
                        $cotizacion_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();
                        $vista_pdf = 'transaccion.venta.cotizacion.pdf2';
                    } else {
                        $cotizacion_reg = Cotizacion_factura_registro::where('cotizacion_id', $cotizacion->id)->get(); // ✅
                        $vista_pdf = 'transaccion.venta.cotizacion.pdf2';
                    }

                    $sum       = 0;
                    $j         = 1;
                    $i         = 1;
                    $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
                    $igv       = round($cotizacion->op_gravada, 2) * $igv_config->igv_total / 100;
                    $igv_p     = $igv;
                    $end       = round($sub_total, 2) + round($igv, 2);
                    $end2      = number_format(round($sub_total, 2) + round($igv_p, 2), 2);

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
                        'i'                    => $i,
                        'cotizacion'           => $cotizacion,
                        'empresa'              => $empresa,
                        'cotizacion_m_reg'     => $cotizacion_reg,
                        'cotizacion_registro'  => $cotizacion_reg,
                        'sum'                  => $sum,
                        'igv'                  => $igv,
                        'igv_p'                => $igv_p,
                        'sub_total'            => $sub_total,
                        'banco'                => $banco,
                        'banco_count'          => $banco_count,
                        'end'                  => $end,
                        'igv_p'               => $igv_p,
                        'banco_count'          => $banco_count,
                        'end2'                 => $end2,
                        'renovacion'           => $renovacion,
                        'fecha_vencimiento'    => $fecha_vencimiento,
                        'dias_restantes_texto' => $dias_restantes_texto,
                        'dias_restantes_numero' => $dias_restantes_numero
                    ]);

                    $codigoCotizacion = preg_replace('/[^a-zA-Z0-9_-]/', '_', $cotizacion->cod_cotizacion);
                    $zip->addFromString('Cotizacion' . $codigoCotizacion . '.pdf', $pdf->output());
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
                $cotizacion_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();
                $vista_pdf = 'transaccion.venta.cotizacion.pdf2';
            } else {
                $cotizacion_reg = Cotizacion_factura_registro::where('cotizacion_id', $cotizacion->id)->get(); // ✅
                        $vista_pdf = 'transaccion.venta.cotizacion.pdf2';
            }

            $empresa    = Empresa::first();
            $banco      = Banco::where('estado', '0')->get();
            $banco_count = Banco::where('estado', '0')->count();
            $igv_config = Igv::first();
            $sum        = 0;
            $j          = 1;
            $i          = 1;
            $sub_total  = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
            $igv        = round($cotizacion->op_gravada, 2) * $igv_config->igv_total / 100;
            $igv_p      = $igv;
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
                'i'                     => $i,
                'cotizacion'            => $cotizacion,
                'empresa'               => $empresa,
                'cotizacion_m_reg'      => $cotizacion_reg,
                'cotizacion_registro'   => $cotizacion_reg,
                'sum'                   => $sum,
                'igv'                   => $igv,
                'igv_p'                 => $igv_p,
                'sub_total'             => $sub_total,
                'banco'                 => $banco,
                'banco_count'           => $banco_count,
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
            $renovacion_ids = $request->get('cotizacion_ids', []);
            if (empty($renovacion_ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron renovaciones para enviar.'
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

            $yourEmail   = $config_email->email;
            $firma       = $config_email->firma_digital;
            $firma_email = $config_email->firma;
            $alto        = $config_email->alto_firma;
            $ancho       = $config_email->ancho_firma;

            $titulo       = "Cotizaciones - " . count($renovacion_ids) . " documento(s)";
            $mensaje_html = "Estimado cliente, adjuntamos las cotizaciones con renovaciones solicitadas.";
            $mensaje      = view('email_html.email_send_layout', compact('empresa', 'mensaje_html', 'firma_email', 'alto', 'ancho', 'firma'));

            $correos_envios = [$email, $config_email->email_backup];
            $mails_array    = array_filter($correos_envios);

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

            foreach ($renovacion_ids as $renovacion_id) {
                $renovacion = RenovacionVentas::find($renovacion_id);
                if (!$renovacion) continue;
                $cotizacion = $renovacion->cotizacion ?? $renovacion->cotizacionManual;
                if (!$cotizacion) continue;
                $cotizacion_id = $cotizacion->id;
                $cotizacion_registro = Cotizacion_factura_registro::where('cotizacion_id', $cotizacion_id)->get();

                $sub_total = $cotizacion->op_gravada + $cotizacion->op_exonerada + $cotizacion->op_inafecta;
                $igv_p     = round($cotizacion->op_gravada, 2) * $igv->igv_total / 100;
                $end       = round($sub_total, 2) + round($igv_p, 2);
                $end2      = number_format($end, 2);

                $firma = EmailConfiguraciones::where('id_usuario', $cotizacion->user_id)->pluck('firma_digital')->first();
                $sum   = 0;
                $i     = 1;
                $regla = $cotizacion->tipo;

                $fecha_inicio          = Carbon::parse($renovacion->fecha_inicio)->format('d/m/Y');
                $fecha_actual          = Carbon::now()->startOfDay();
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

            if ($mailer->send($message)) {
                $texto = strip_tags($mensaje_html);
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
                    $archivo_pdf                    = new EmailBandejaEnviosArchivos;
                    $archivo_pdf->id_bandeja_envios = $mail->id;
                    $archivo_pdf->archivo           = $archivo_temp;
                    $archivo_pdf->fecha_hora        = $date;
                    $archivo_pdf->save();
                }
                $this->limpiarArchivosViejos(2880);
                return response()->json([
                    'success' => true,
                    'message' => 'Se enviaron ' . count($renovacion_ids) . ' renovación(es) exitosamente a: ' . $email
                ]);
            }
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

    private function prepararDatosPdfRenovacion(RenovacionVentas $renovacion)
    {
        $cotizacion = $renovacion->cotizacionManual ?? $renovacion->cotizacion;

        if (!$cotizacion) {
            throw new \Exception('No se encontró la cotización asociada a esta renovación.');
        }

        $empresa = Empresa::first();
        $banco = Banco::where('estado', '0')->get();
        $banco_count = Banco::where('estado', '0')->count();
        $igv_config = Igv::first();

        $fecha_actual = Carbon::now()->startOfDay();
        $fecha_vencimiento = null;
        $dias_restantes_texto = null;
        $dias_restantes_numero = null;

        if ($renovacion->fecha_vencimiento) {
            $fecha_vencimiento = Carbon::parse($renovacion->fecha_vencimiento)->startOfDay();
            $diff = $fecha_actual->diffInDays($fecha_vencimiento, false);
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

        $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
        $igv = round($cotizacion->op_gravada, 2) * $igv_config->igv_total / 100;
        $end = round($sub_total, 2) + round($igv, 2);
        $end2 = number_format($end, 2);

        $firma = null;
        if (
            isset($cotizacion->user_personal) &&
            isset($cotizacion->user_personal->personal) &&
            isset($cotizacion->user_personal->personal->firma_digital)
        ) {
            $firma = $cotizacion->user_personal->personal->firma_digital;
        }

        if ($renovacion->cotizacionManual) {
            $vista_pdf = 'transaccion.venta.cotizacion.manual.pdf';
            $cotizacion_m_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();

            return [
                'vista_pdf'              => $vista_pdf,
                'empresa'                => $empresa,
                'banco'                  => $banco,
                'banco_count'            => $banco_count,
                'cotizacion'             => $cotizacion,
                'cotizacion_m_reg'       => $cotizacion_m_reg,
                'cotizacion_registro'    => $cotizacion_m_reg,
                'j'                      => 1,
                'i'                      => 1,
                'igv'                    => $igv,
                'igv_p'                  => $igv,
                'sub_total'              => $sub_total,
                'end'                    => $end,
                'end2'                   => $end2,
                'renovacion'             => $renovacion,
                'fecha_vencimiento'      => $fecha_vencimiento,
                'dias_restantes_texto'   => $dias_restantes_texto,
                'dias_restantes_numero'  => $dias_restantes_numero,
                'firma'                  => $firma,
            ];
        }

        $vista_pdf = 'transaccion.venta.cotizacion.pdf2';
        $cotizacion_registro = Cotizacion_factura_registro::where('cotizacion_id', $cotizacion->id)->get();

        return [
            'vista_pdf'              => $vista_pdf,
            'empresa'                => $empresa,
            'banco'                  => $banco,
            'banco_count'            => $banco_count,
            'cotizacion'             => $cotizacion,
            'cotizacion_registro'    => $cotizacion_registro,
            'i'                      => 1,
            'j'                      => 1,
            'cotizacion_m_reg'       => $cotizacion_registro,
            'igv'                    => $igv,
            'sub_total'              => $sub_total,
            'igv_p'                  => $igv,
            'end'                    => $end,
            'end2'                   => $end2,
            'renovacion'             => $renovacion,
            'fecha_vencimiento'      => $fecha_vencimiento,
            'dias_restantes_texto'   => $dias_restantes_texto,
            'dias_restantes_numero'  => $dias_restantes_numero,
            'firma'                  => $firma,
        ];
    }

    public function pdf($id, $descargar = false)
    {
        try {
            $renovacion = RenovacionVentas::with([
                'cotizacion.cliente',
                'cotizacion.forma_pago',
                'cotizacion.moneda',
                'cotizacion.user_personal.personal',
                'cotizacionManual.cliente',
                'cotizacionManual.forma_pago',
                'cotizacionManual.moneda',
                'cotizacionManual.user_personal.personal',
            ])->findOrFail($id);

            $data = $this->prepararDatosPdfRenovacion($renovacion);
            $vista_pdf = $data['vista_pdf'];
            unset($data['vista_pdf']);

            $pdf = PDF::loadView($vista_pdf, $data);

            $cotizacion = $renovacion->cotizacionManual ?? $renovacion->cotizacion;

            $tipoDocumento = $renovacion->cotizacionManual
                ? 'Cotizacion_Manual_'
                : 'Cotizacion_';

            $nombreArchivo = $tipoDocumento . $cotizacion->cod_cotizacion . '.pdf';

            if ($descargar) {
                return $pdf->download($nombreArchivo);
            }

            return $pdf->stream($nombreArchivo);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    public function descargarPorCodigo($codigo)
    {
        try {
            $renovaciones = RenovacionVentas::with(['cotizacion', 'cotizacionManual'])->get();

            foreach ($renovaciones as $renovacion) {
                $codigoGenerado = substr(md5($renovacion->id . env('APP_KEY') . 'renovacion'), 0, 22);

                if ($codigoGenerado === $codigo) {
                    return $this->pdf($renovacion->id, true);
                }
            }

            abort(404, 'El enlace compartido no es válido.');
        } catch (\Exception $e) {
            abort(500, 'Error al procesar el enlace compartido.');
        }
    }

    public function whatsappSendMultiple(Request $request)
    {
        $numero = $request->numero;
        $renovacionIds = $request->renovacion_ids ?? $request->cotizacion_ids ?? [];

        $mensaje = '';

        foreach ($renovacionIds as $id) {
            $renovacion = RenovacionVentas::find($id);
            if ($renovacion) {
                $codigo = substr(md5($id . env('APP_KEY') . 'renovacion'), 0, 22);
                $esManual = $renovacion->cotizacionManual ? true : false;
                if ($esManual) {
                    $pdfUrl = url("cotizacion-manual/share/{$codigo}");
                } else {
                    $pdfUrl = url("cotizacion/share/{$codigo}");
                }
                $mensaje .= "{$pdfUrl}\n";
            }
        }

        $mensajeCodificado = urlencode($mensaje);
        $whatsappUrl = "https://wa.me/{$numero}?text={$mensajeCodificado}";

        return redirect()->away($whatsappUrl);
    }

    public function enviarCorreoDirecto(Request $request, $id)
    {
        try {
            $request->validate([
                'emails'   => 'required|array|min:1',
                'emails.*' => 'required|email'
            ]);

            $id_usuario = auth()->user()->id;
            $config_email = EmailConfiguraciones::where('id_usuario', $id_usuario)->first();

            if (!$config_email) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes configuración de email. Ve a configuración.'
                ], 400);
            }

            $renovacion = RenovacionVentas::with([
                'cotizacion.cliente',
                'cotizacion.forma_pago',
                'cotizacion.moneda',
                'cotizacion.user_personal.personal',
                'cotizacionManual.cliente',
                'cotizacionManual.forma_pago',
                'cotizacionManual.moneda',
                'cotizacionManual.user_personal.personal',
            ])->findOrFail($id);

            $cotizacion = $renovacion->cotizacionManual ?? $renovacion->cotizacion;

            if (!$cotizacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró la cotización asociada a esta renovación.'
                ], 404);
            }

            $fecha = Carbon::now();
            $data_g = str_replace(' ', '_', $fecha);
            $date = str_replace(':', '-', $data_g);

            $empresa = Empresa::first();

            $yourEmail   = $config_email->email;
            $firma       = $config_email->firma_digital ?? null;
            $firma_email = $config_email->firma ?? null;
            $alto        = $config_email->alto_firma ?? null;
            $ancho       = $config_email->ancho_firma ?? null;

            $emails = collect($request->emails)
                ->filter(fn ($email) => !empty(trim($email)))
                ->unique()
                ->values()
                ->toArray();

            $tipoDocumento = $renovacion->cotizacionManual
                ? 'Cotizacion Manual'
                : 'Cotizacion';

            $tipoArchivo = $renovacion->cotizacionManual
                ? 'Cotizacion_Manual_'
                : 'Cotizacion_';

            $titulo = $tipoDocumento . ' ' . $cotizacion->cod_cotizacion;

            $mensaje_html = 'Estimado cliente, adjuntamos el documento correspondiente.';
            $texto = strip_tags($mensaje_html);

            $mensaje = view('email_html.email_send_layout', compact(
                'empresa',
                'mensaje_html',
                'firma_email',
                'firma',
                'alto',
                'ancho'
            ))->render();

            $data = $this->prepararDatosPdfRenovacion($renovacion);
            $vista_pdf = $data['vista_pdf'];
            unset($data['vista_pdf']);

            $pdf = PDF::loadView($vista_pdf, $data);

            $archivo = $tipoArchivo . $cotizacion->cod_cotizacion . '.pdf';
            $especif = $date . '_' . $archivo;

            Storage::disk('mailbox')->put($especif, $pdf->output());

            $correos_envios = array_merge($emails, [$config_email->email_backup]);
            $mails_array = array_filter($correos_envios);
            $pdfile = public_path() . '/archivos/' . $especif;

            $transport = (new \Swift_SmtpTransport($config_email->smtp, $config_email->port, $config_email->encryption))
                ->setUsername($config_email->email)
                ->setPassword($config_email->password);

            $mailer = new \Swift_Mailer($transport);
            $mailer->getTransport()->start();

            $message = (new \Swift_Message($yourEmail))
                ->setFrom([$yourEmail => $titulo])
                ->setTo($mails_array)
                ->setBody($mensaje, 'text/html');

            $message->attach(\Swift_Attachment::fromPath($pdfile));

            if (!$mailer->send($message)) {
                Storage::disk('mailbox')->delete($especif);

                return response()->json([
                    'success' => false,
                    'message' => 'Error al enviar el correo. Verifica tu configuración.'
                ], 500);
            }

            $mail = new EmailBandejaEnvios;
            $mail->id_usuario = auth()->user()->id;
            $mail->destinatario = $yourEmail;
            $mail->remitente = implode(', ', $emails);
            $mail->asunto = $titulo;
            $mail->mensaje = $mensaje_html;
            $mail->mensaje_sin_html = $texto;
            $mail->estado = '0';
            $mail->fecha_hora = Carbon::now();
            $mail->save();

            $archivo_pdf = new EmailBandejaEnviosArchivos;
            $archivo_pdf->id_bandeja_envios = $mail->id;
            $archivo_pdf->archivo = $archivo;
            $archivo_pdf->fecha_hora = $especif;
            $archivo_pdf->save();

            $this->limpiarArchivosViejos(2880);

            return response()->json([
                'success' => true,
                'message' => 'Correo enviado exitosamente a: ' . implode(', ', $emails)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Verifica los correos ingresados.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            if (isset($especif)) {
                Storage::disk('mailbox')->delete($especif);
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
