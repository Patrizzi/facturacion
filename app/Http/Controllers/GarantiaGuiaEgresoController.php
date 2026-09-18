<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;
use App\GarantiaGuiaEgreso;
use App\Exports\GarantiaGEgresoExport;
use PDF;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Marca;
use App\Contacto;
use App\Empresa;
use App\Cliente;
use App\GuiasServicioTecnico;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Swift_Attachment;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Auth;
use App\EmailConfiguraciones;
use App\EmailBandejaEnviosArchivos;
use App\EmailBandejaEnvios;

class GarantiaGuiaEgresoController extends Controller
{
    public function index()
    {
        $garantias_guias_egresos=GarantiaGuiaEgreso::all();
        $count_day = GuiasServicioTecnico::count_day_comprobantes();
        $count_mounth = GuiasServicioTecnico::count_month_ventas(Carbon::now());
        $marcas=Marca::where('estado',0)->get();
        return view('transaccion.garantias.guia_egreso.index',compact('garantias_guias_egresos','count_day','count_mounth','marcas'));
    }

    public function guias()
    {
        $marcas=Marca::all();
        $garantias_guias_ingresos=GarantiaGuiaIngreso::where('estado',1)->where('egresado',0)->get();
        return view('transaccion.garantias.guia_egreso.ingresos',compact('marcas','garantias_guias_ingresos'));
    }

    public function store(Request $request)
    {
        $id=$request->get('id');
        $guia_ingreso=GarantiaGuiaIngreso::where('id',$id)->first();

        if (empty($guia_ingreso)){return redirect()->route('garantia_guia_egreso.guias')->withErrors(['Numero de Guia no existe en Registro.']);}
        if ($guia_ingreso->egresado==1){return redirect()->route('garantia_guia_egreso.guias')->withErrors(['Guia de Ingreso ya fue Egresada.']);}
        if ($guia_ingreso->estado==0){return redirect()->route('garantia_guia_egreso.guias')->withErrors(['Guia de Ingreso a sido anulada. por ello no puede ser Egresada.']);}

        $garantia_guia_egreso=new GarantiaGuiaEgreso;
        $garantia_guia_egreso->garantia_ingreso_id=$guia_ingreso->id;
        $garantia_guia_egreso->estado=1;
        $garantia_guia_egreso->egresado=1;
        $garantia_guia_egreso->informe_tecnico=0;
        $garantia_guia_egreso->orden_servicio=$guia_ingreso->orden_servicio;
        $garantia_guia_egreso->fecha=date('Y-m-d');
        $garantia_guia_egreso->descripcion_problema=$request->get('descripcion_problema');
        $garantia_guia_egreso->diagnostico_solucion=$request->get('diagnostico_solucion');
        $garantia_guia_egreso->recomendaciones=$request->get('recomendaciones');
        $garantia_guia_egreso->save();

        $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
        $garantia_guia_ingreso->egresado=1;
        $garantia_guia_ingreso->save();

        return redirect()->route('garantia_guia_egreso.show',$garantia_guia_egreso->id);
    }

    public function show($id)
    {
        $contacto = Contacto::all();
        $empresa = Empresa::first();
        $garantias_guias_egreso = GarantiaGuiaEgreso::find($id);

        if (!$garantias_guias_egreso) {
            return redirect()->route('garantia_guia_egreso.index')
                ->withErrors(['Guía de egreso no encontrada.']);
        }

        $usuario = null;
        if ($garantias_guias_egreso->garantia_ingreso_i &&
            $garantias_guias_egreso->garantia_ingreso_i->personal_lab_id) {
            $usuario = User::where('personal_id', $garantias_guias_egreso->garantia_ingreso_i->personal_lab_id)->first();
        }

        return view('transaccion.garantias.guia_egreso.show',compact('garantias_guias_egreso','empresa','contacto','usuario'));
    }

    public function create_egreso($id)
    {
        $empresa=Empresa::first();
        $garantias_guias_ingresos=GarantiaGuiaIngreso::find($id);
        if(empty($garantias_guias_ingresos)){return redirect()->route('garantia_guia_egreso.guias');}
        if($garantias_guias_ingresos->egresado!=0 or $garantias_guias_ingresos->estado==0){return redirect()->route('garantia_guia_egreso.guias');}
        return view('transaccion.garantias.guia_egreso.create_egreso',compact('garantias_guias_ingresos','empresa','id'));
    }

    public function update(Request $request, $id)
    {
        $guia_egreso=GarantiaGuiaEgreso::find($id);
        $guia_egreso->descripcion_problema=$request->get('descripcion_problema');
        $guia_egreso->diagnostico_solucion=$request->get('diagnostico_solucion');
        $guia_egreso->recomendaciones=$request->get('recomendaciones');
        $guia_egreso->save();
        return redirect()->route('garantia_guia_egreso.show',$guia_egreso->id);
    }

    public function anular_guia_egreso(Request $request, $id){
        $guia_egreso = GarantiaGuiaEgreso::find($id);
        $guia_egreso->estado = 0;
        $guia_egreso->save();
        return redirect()->back()->with('success', 'Guia de Egreso anulada correctamente');
    }

    public function print($id){
        $contacto = Contacto::all();
        $mi_empresa = Empresa::first();
        $garantias_guias_egreso = GarantiaGuiaEgreso::find($id);

        if (!$garantias_guias_egreso) {
            return redirect()->route('garantia_guia_egreso.index')
                ->withErrors(['Guía de egreso no encontrada.']);
        }

        $usuario = null;
        if ($garantias_guias_egreso->garantia_ingreso_i &&
            $garantias_guias_egreso->garantia_ingreso_i->personal_lab_id) {
            $usuario = User::where('personal_id', $garantias_guias_egreso->garantia_ingreso_i->personal_lab_id)->first();
        }

        return view('transaccion.garantias.guia_egreso.show_print',compact('garantias_guias_egreso','mi_empresa','contacto','usuario'));
    }

    public function pdf(Request $request,$id){
        $contacto = Contacto::all();
        $mi_empresa = Empresa::first();
        $garantias_guias_egreso = GarantiaGuiaEgreso::find($id);

        if (!$garantias_guias_egreso) {
            return redirect()->route('garantia_guia_egreso.index')
                ->withErrors(['Guía de egreso no encontrada.']);
        }

        $usuario = null;
        if ($garantias_guias_egreso->garantia_ingreso_i &&
            $garantias_guias_egreso->garantia_ingreso_i->personal_lab_id) {
            $usuario = User::where('personal_id', $garantias_guias_egreso->garantia_ingreso_i->personal_lab_id)->first();
        }

        $archivo = $request->get('archivo');

        $pdf = PDF::loadView('transaccion.garantias.guia_egreso.show_pdf',compact('garantias_guias_egreso','mi_empresa','contacto','usuario'));
        return $pdf->download('Guia Egreso - '.$archivo.' .pdf');
    }

    function email($id){
        $mi_empresa=Empresa::first();
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        $archivo=$id.".pdf";
        $pdf=PDF::loadView('transaccion.garantias.guia_egreso.show_pdf',compact('garantias_guias_egreso','mi_empresa'));
        $content=$pdf->download();
        Storage::disk('garantias_guias_egreso')->put($archivo,$content);
        return view('transaccion.garantias.guia_egreso.correo',compact('id'));
    }

    public function enviar(Request $request){
       $smtpAddress = 'smtp.gmail.com';
       $port = 465;
       $encryption = 'ssl';
        $yourEmail = 'danielrberru@gmail.com';
        $yourPassword = 'digimonheroes@1';

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

        $sendto = $request->sendto;
        $titulo = $request->titulo;
        $mensaje = $request->mensaje;
        $file = $request->id;

        $pdfile = storage_path().'/app/public/guia_egreso/'.$file.'.pdf';

        $newfile = $request->file('archivo');

        if($request->hasfile('archivo')){
            foreach ($newfile as $dofile) {
                $nombre =  $dofile->getClientOriginalName();
                \Storage::disk('mailbox')->put($nombre,  \File::get($dofile));
                $news[] = storage_path().'/app/public/'.$nombre;
                $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto ])->setBody($mensaje, 'text/html');
                $message->attach(\Swift_Attachment::fromPath($pdfile));
                foreach ($news as $attachment) {
                    $message->attach(\Swift_Attachment::fromPath($attachment));
                }
            }
        }else{
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto ])->setBody($mensaje, 'text/html');
            $message->attach(\Swift_Attachment::fromPath($pdfile));
        }

        if($mailer->send($message)){
           return redirect()->route('garantia_guia_egreso.index');
       }
       return "Something went wrong :(";
   }

    public function exportar_garantia_egreso(Request $request)
    {
        if (ob_get_contents()) {
            ob_end_clean();
        }

        $ids = $request->json('guia_ids') ?? $request->input('guia_ids');

        if (!empty($ids)) {
            $export = new GarantiaGEgresoExport($ids);
        } else {
            $request->validate([
                'daterange' => 'required|string'
            ]);

            [$start, $end] = explode(' - ', $request->daterange);

            $export = new GarantiaGEgresoExport(null, [
                'start'  => Carbon::createFromFormat('d/m/Y', $start)->startOfDay(),
                'end'    => Carbon::createFromFormat('d/m/Y', $end)->endOfDay(),
                'filter' => $request->input('value'),
                'marca'  => $request->input('marca'),
            ]);
        }

        return Excel::download(
            $export,
            'Garantia Guias Egresos ' . now('America/Lima')->format('d-m-Y') . '.xlsx'
        );
    }


    // ============================================
    // MÉTODO PRINTMULTIPLE CORREGIDO
    // ============================================
    public function printMultiple(Request $request)
    {
        try {
            $guiaIds = $request->input('guia_ids', []);

            if (empty($guiaIds) || !is_array($guiaIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron guías de egreso para imprimir.'
                ], 400);
            }

            $guiaIds = array_filter(array_unique($guiaIds), function($id) {
                return !empty($id) && is_numeric($id);
            });

            if (empty($guiaIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron IDs válidos para imprimir.'
                ], 400);
            }

            $guias = GarantiaGuiaEgreso::with(['garantia_ingreso_i'])->whereIn('id', $guiaIds)->get();

            if ($guias->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron guías de egreso con los IDs seleccionados.'
                ], 404);
            }

            \Log::info('Imprimiendo guías de egreso:', ['ids' => $guiaIds, 'found' => $guias->count()]);

            $guiasData = [];
            $mi_empresa = Empresa::first();
            $contacto = Contacto::all();
            $empresa = Empresa::first();

            foreach ($guias as $guia) {
                $usuario = null;
                if ($guia->garantia_ingreso_i && $guia->garantia_ingreso_i->personal_lab_id) {
                    $usuario = User::where('personal_id', $guia->garantia_ingreso_i->personal_lab_id)->first();
                }

                $guiasData[] = [
                    'guia' => $guia,
                    'usuario' => $usuario
                ];
            }

            return view('transaccion.garantias.guia_egreso.print_multiple', compact(
                'guiasData',
                'mi_empresa',
                'contacto',
                'empresa'
            ));

        } catch (\Exception $e) {
            \Log::error('Error en printMultiple (egreso):', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la impresión múltiple: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadMultiplePDFs(Request $request)
    {
        try {
            $guiaIds = $request->input('guia_ids', []);

            if (empty($guiaIds) || !is_array($guiaIds)) {
                return back()->with('error', 'No se seleccionaron guías de egreso.');
            }

            $guiaIds = array_filter($guiaIds, function($id) {
                return is_numeric($id) && $id > 0;
            });

            if (count($guiaIds) === 1) {
                return $this->downloadSinglePDF($guiaIds[0]);
            }

            $guias = GarantiaGuiaEgreso::with([
                'garantia_ingreso_i.clientes_i',
                'garantia_ingreso_i.personal_laborales',
                'garantia_ingreso_i.marcas_i',
                'garantia_ingreso_i.contactos'
            ])->whereIn('id', $guiaIds)->get();

            if ($guias->count() !== count($guiaIds)) {
                return back()->with('error', 'Algunas guías de egreso seleccionadas no existen.');
            }

            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $zipName = 'Guias_Egreso_' . date('Y-m-d_H-i-s') . '.zip';
            $tempZip = $tempDir . DIRECTORY_SEPARATOR . $zipName;

            if (file_exists($tempZip)) {
                @unlink($tempZip);
            }

            $zip = new ZipArchive();

            if ($zip->open($tempZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return back()->with('error', 'Error al crear el archivo ZIP');
            }

            $mi_empresa = Empresa::first();
            $contacto = Contacto::all();
            $empresa = Empresa::first();

            $pdfsGenerados = 0;

            foreach ($guias as $guia) {
                try {
                    $usuario = null;
                    if ($guia->garantia_ingreso_i && $guia->garantia_ingreso_i->personal_lab_id) {
                        $usuario = User::where('personal_id', $guia->garantia_ingreso_i->personal_lab_id)->first();
                    }

                    $pdf = PDF::loadView('transaccion.garantias.guia_egreso.show_pdf', [
                        'garantias_guias_egreso' => $guia,
                        'mi_empresa' => $mi_empresa,
                        'contacto' => $contacto,
                        'usuario' => $usuario,
                        'empresa' => $empresa
                    ]);

                    $pdf->setPaper('a4', 'portrait');
                    $pdf->setOption('dpi', 96);
                    $pdf->setOption('isHtml5ParserEnabled', true);
                    $pdf->setOption('isRemoteEnabled', true);

                    $pdfContent = $pdf->output();

                    if (empty($pdfContent)) {
                        continue;
                    }

                    $ordenServicio = $guia->orden_servicio ?? 'guia_egreso_' . $guia->id;
                    $fileName = 'Guia_Egreso_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $ordenServicio) . '.pdf';

                    if ($zip->addFromString($fileName, $pdfContent)) {
                        $pdfsGenerados++;
                    }

                } catch (\Exception $e) {
                    continue;
                }
            }

            $zip->close();
            unset($zip);
            clearstatcache(true, $tempZip);
            usleep(100000);

            if ($pdfsGenerados === 0) {
                @unlink($tempZip);
                return back()->with('error', 'No se pudo generar ningún PDF de egreso.');
            }

            if (!file_exists($tempZip) || filesize($tempZip) === 0) {
                @unlink($tempZip);
                return back()->with('error', 'El archivo ZIP está vacío.');
            }

            while (ob_get_level()) {
                ob_end_clean();
            }

            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipName . '"');
            header('Content-Length: ' . filesize($tempZip));
            header('Cache-Control: no-cache, must-revalidate');
            header('Pragma: public');

            readfile($tempZip);
            @unlink($tempZip);

            exit;

        } catch (\Exception $e) {
            return back()->with('error', 'Error al descargar guías de egreso: ' . $e->getMessage());
        }
    }

    private function downloadSinglePDF($id)
    {
        try {
            $guia = GarantiaGuiaEgreso::with([
                'garantia_ingreso_i.clientes_i',
                'garantia_ingreso_i.personal_laborales',
                'garantia_ingreso_i.marcas_i',
                'garantia_ingreso_i.contactos'
            ])->find($id);

            if (!$guia) {
                return back()->with('error', 'Guía de egreso no encontrada.');
            }

            $mi_empresa = Empresa::first();
            $contacto = Contacto::all();
            $empresa = Empresa::first();

            $usuario = null;
            if ($guia->garantia_ingreso_i && $guia->garantia_ingreso_i->personal_lab_id) {
                $usuario = User::where('personal_id', $guia->garantia_ingreso_i->personal_lab_id)->first();
            }

            $pdf = PDF::loadView('transaccion.garantias.guia_egreso.show_pdf', [
                'garantias_guias_egreso' => $guia,
                'mi_empresa' => $mi_empresa,
                'contacto' => $contacto,
                'usuario' => $usuario,
                'empresa' => $empresa
            ]);

            $ordenServicio = $guia->orden_servicio ?? 'sin_orden';
            $ordenServicio = preg_replace('/[^a-zA-Z0-9_-]/', '_', $ordenServicio);

            return $pdf->download('Guia_Egreso_' . $ordenServicio . '.pdf');

        } catch (\Exception $e) {
            \Log::error('Error al generar PDF de egreso: ' . $e->getMessage());
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    public function whatsappSendMultiple(Request $request)
    {
        $numero = $request->numero;
        $garantiaEgresoIds = $request->guia_ids;

        $mensaje = "";

        foreach ($garantiaEgresoIds as $id) {
            $garantia_guia_egreso = GarantiaGuiaEgreso::find($id);
            if ($garantia_guia_egreso) {
                $codigo = substr(md5($id . env('APP_KEY') . 'garantia_guia_egreso'), 0, 22);

                $pdfUrl = url("garantia_guia_egreso/share/{$codigo}");

                $mensaje .= "{$pdfUrl}\n";
            }
        }

        $mensajeCodificado = urlencode($mensaje);
        $whatsappUrl = "https://wa.me/{$numero}?text={$mensajeCodificado}";

        return redirect()->away($whatsappUrl);
    }

    public function descargarPorCodigo($codigo)
    {
        $garantias = GarantiaGuiaEgreso::all();

        foreach ($garantias as $gar) {
            if (substr(md5($gar->id . env('APP_KEY') . 'garantia_guia_egreso'), 0, 22) === $codigo) {
                return redirect()->route('pdf_egreso', $gar->id);
            }
        }

        abort(404);
    }

    public function enviarCorreoMultiple(Request $request)
    {
        try {
            $email = $request->get('email');
            $guia_ids = $request->get('guia_ids', []);

            if (empty($guia_ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron guías de egreso para enviar.'
                ], 400);
            }

            if (empty($email)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El correo electrónico es requerido.'
                ], 400);
            }

            $id_usuario = auth()->user()->id;
            $config_email = EmailConfiguraciones::where('id_usuario', $id_usuario)->first();

            if (!$config_email) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes configuración de email. Ve a configuración.'
                ], 400);
            }

            $fecha = Carbon::now();
            $data_g = str_replace(' ', '_', $fecha);
            $date = str_replace(':', '-', $data_g);

            $mi_empresa = Empresa::first();
            $contacto = Contacto::all();

            // Configuración de email
            $yourEmail = $config_email->email;
            $firma = $config_email->firma;
            $alto = $config_email->alto_firma;
            $ancho = $config_email->ancho_firma;

            $titulo = "Guías de Egreso - " . count($guia_ids) . " documento(s)";
            $mensaje_html = "Estimado cliente, adjuntamos las guías de egreso solicitadas.";
            $mensaje = view('email_html.email_send_layout', compact('mi_empresa', 'mensaje_html', 'firma', 'alto', 'ancho'));

            // Agregar email backup si existe
            $correos_envios = [$email, $config_email->email_backup];
            $mails_array = array_filter($correos_envios);

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

            // Generar y adjuntar cada PDF
            foreach ($guia_ids as $guia_id) {
                $garantias_guias_egreso = GarantiaGuiaEgreso::find($guia_id);
                if (!$garantias_guias_egreso) continue;

                $name = 'PDF-DOC-' . $garantias_guias_egreso->orden_servicio . '-' . $mi_empresa->ruc;
                $archivo = $name . ".pdf";

                $pdf = PDF::loadView('transaccion.garantias.guia_egreso.show_pdf', compact('garantias_guias_egreso', 'mi_empresa', 'contacto'));
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
                $mail = new EmailBandejaEnvios;
                $mail->id_usuario = auth()->user()->id;
                $mail->destinatario = $yourEmail;
                $mail->remitente = $email;
                $mail->asunto = $titulo;
                $mail->mensaje = $mensaje_html;
                $mail->mensaje_sin_html = $texto;
                $mail->estado = '0';
                $mail->fecha_hora = Carbon::now();
                $mail->save();

                foreach ($archivos_temporales as $archivo_temp) {
                    $archivo_pdf = new EmailBandejaEnviosArchivos;
                    $archivo_pdf->id_bandeja_envios = $mail->id;
                    $archivo_pdf->archivo = $archivo_temp;
                    $archivo_pdf->fecha_hora = $date;
                    $archivo_pdf->save();
                }

                $this->limpiarArchivosViejos(2880);

                return response()->json([
                    'success' => true,
                    'message' => 'Se enviaron ' . count($guia_ids) . ' guía(s) de egreso exitosamente a: ' . $email
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
