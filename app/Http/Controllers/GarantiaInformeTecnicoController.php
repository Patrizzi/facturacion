<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaInformeTecnico;
use App\GarantiaGuiaEgreso;
use PDF;
use App\Cliente;
use App\User;
use App\Contacto;
use App\Empresa;
use App\GarantiaInformeTecnicoArchivos;
use App\GuiasServicioTecnico;
use App\Marca;
use Carbon\Carbon;
use ZipArchive;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Illuminate\Support\Facades\Storage;
use App\EmailConfiguraciones;
use App\EmailBandejaEnviosArchivos;
use App\EmailBandejaEnvios;

class GarantiaInformeTecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $garantias_informe_tecnicos=GarantiaInformeTecnico::all();
        $marcas=Marca::where('estado',0)->get();
        $count_day = GuiasServicioTecnico::count_day_comprobantes();
        $count_mounth = GuiasServicioTecnico::count_month_ventas(Carbon::now());
        return view('transaccion.garantias.informe_tecnico.index',compact('garantias_informe_tecnicos','marcas','count_day','count_mounth'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_tecnico($id)
    {
     $empresa = Empresa::first();
     $garantia_guia_egreso=GarantiaGuiaEgreso::find($id);
     return view('transaccion.garantias.informe_tecnico.create_tecnico',compact('garantia_guia_egreso','empresa','id'));
 }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_egreso=$request->get('id_egreso');
        //consulta
        $egreso=GarantiaGuiaEgreso::where('id',$id_egreso)->first();
        if (empty($egreso)){return redirect()->route('garantia_informe_tecnico.guias')->withErrors(['Numero de Guia no existe en Registro.']);}
        if ($egreso->informe_tecnico==1){return redirect()->route('garantia_informe_tecnico.guias')->withErrors(['Numero de Guia Ya fue Registrada en Informe Tecnico.']);}
        // return $egreso->informe_tecnico;

        $garantia_informe_tecnico= new GarantiaInformeTecnico;
        $garantia_informe_tecnico->garantia_egreso_id=$egreso->id;
        $garantia_informe_tecnico->orden_servicio=$egreso->orden_servicio;
        $garantia_informe_tecnico->estado=1;
        $garantia_informe_tecnico->egresado=0;
        $garantia_informe_tecnico->informe_tecnico=0;
        $garantia_informe_tecnico->fecha=date('Y-m-d');
        $garantia_informe_tecnico->estetica=$request->get('estetica');
        $garantia_informe_tecnico->revision_diagnostico=$request->get('revision_diagnostico');
        $garantia_informe_tecnico->causas_del_problema=$request->get('causas_del_problema');
        $garantia_informe_tecnico->solucion=$request->get('solucion');
        $garantia_informe_tecnico->save();

         // //GUIA EGRESO
        $garantia_guia_egreso=GarantiaGuiaEgreso::find($id_egreso);
        $garantia_guia_egreso->informe_tecnico=1;
        $garantia_guia_egreso->save();

        /*new*/
        $newfile = $request->file('files');
        if($request->hasfile('files')){
            $orden_servicio=$request->get('orden_servicio');
            // $date = Carbon::now();
            // $hora = $date->toTimeString();
            foreach ($newfile as $file) {
                $nombre =  $orden_servicio.'_'.$file->getClientOriginalName();
                \Storage::disk('informe_tecnico_imagenes')->put($nombre,  \File::get($file));
                // $news[] = public_path().'/app/public/'.$nombre;
            }
            foreach ($newfile as $files) {
                $archivo_tecnico = new GarantiaInformeTecnicoArchivos;
                $archivo_tecnico->id_informe_tecnico = $garantia_informe_tecnico->id;
                $archivo_tecnico->archivos = $orden_servicio.'_'.$files->getClientOriginalName();
                $archivo_tecnico->save();
            }
        }
        /* /
        new*/
      return redirect()->route('garantia_informe_tecnico.show',$garantia_informe_tecnico->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contacto = Contacto::all();
        $empresa=Empresa::first();
        $garantias_informe_tecnico=GarantiaInformeTecnico::find($id);
        $archivo_informe_tecnico  = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico',$id)->get();
        $usuario = User::where('personal_id',$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_lab_id)->first();
        return view('transaccion.garantias.informe_tecnico.show',compact('garantias_informe_tecnico','empresa','archivo_informe_tecnico','contacto','usuario'));
        // return $archivo_informe_tecnico;
    }
    public function update(Request $request, $id)
    {
        $garantia_informe_tecnico=GarantiaInformeTecnico::find($id);
        $garantia_informe_tecnico->estetica=$request->get('estetica');
        $garantia_informe_tecnico->revision_diagnostico=$request->get('revision_diagnostico');
        $garantia_informe_tecnico->causas_del_problema=$request->get('causas_del_problema');
        $garantia_informe_tecnico->solucion=$request->get('solucion');
        $garantia_informe_tecnico->save();

        // $id_archivos_db = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $id)->get();

        // $id_archivo = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $id)->pluck('id');
        // $nombre_archivo = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $id)->pluck('archivos');
        // $orden_servicio=$request->get('orden_servicio');

        // foreach ($id_archivo as $ids) {
        //     $nombre_orig = $request->get('original');
        //     if ($request->hasfile("nombre$ids")) {
        //         $archivo_input = $request->file("nombre$ids");
        //             //Eliminar
        //         $nombre =  $orden_servicio.'_'.$archivo_input->getClientOriginalName();
        //             //         \Storage::disk('informe_tecnico_imagenes')->delete($nombre_archivo);
        //             // Guardar base de datos
        //         $archivo_informe_tecnico = GarantiaInformeTecnicoArchivos::find($ids);
        //         $archivo_informe_tecnico->archivos = $nombre;
        //         $archivo_informe_tecnico->save();
        //             //Guardar en disk
        //         \Storage::disk('informe_tecnico_imagenes')->put($nombre,  \File::get($archivo_input));
        //              // $archivo_storage = \Storage::disk('informe_tecnico_imagenes')->allFiles();
        //         $archivo_base = GarantiaInformeTecnicoArchivos::pluck('archivos');
        //             //ELIMINAR ARCHIVO (?)
        //             // foreach ($archivo_base as $base) {
        //             //     $original = $request->get('original');

        //             //      // foreach ($archivo_storage as $storage) {
        //             //         if( $base != $original  ){
        //             //             // $delete = $storage;
        //             //            \Storage::disk('informe_tecnico_imagenes')->delete($original);
        //             //             // return $delete;
        //             //         }else{
        //             //              // \Storage::disk('informe_tecnico_imagenes')->delete($delete);
        //             //              // return 'nohay';
        //             //         }
        //             //     // }

        //             // }
        //              //
        //     }

        // }
        // $newfile = $request->file('files');
        // if($request->hasfile('files')){
        //     $orden_servicio=$request->get('orden_servicio');
        //         // $date = Carbon::now();
        //         // $hora = $date->toTimeString();
        //     foreach ($newfile as $file) {
        //         $nombre =  $orden_servicio.'_'.$file->getClientOriginalName();
        //         \Storage::disk('informe_tecnico_imagenes')->put($nombre,  \File::get($file));
        //             // $news[] = public_path().'/app/public/'.$nombre;
        //     }
        //     foreach ($newfile as $files) {
        //         $archivo_tecnico = new GarantiaInformeTecnicoArchivos;
        //         $archivo_tecnico->id_informe_tecnico = $id;
        //         $archivo_tecnico->archivos = $orden_servicio.'_'.$files->getClientOriginalName();
        //         $archivo_tecnico->save();
        //     }
        // }
      return redirect()->route('garantia_informe_tecnico.show',$garantia_informe_tecnico->id);
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

    public function guias()
    {
        $garantias_guias_egresos=GarantiaGuiaEgreso::where('estado',1)->where('informe_tecnico',0)->get();
        return view('transaccion.garantias.informe_tecnico.guias',compact('garantias_guias_egresos'));
    }

    public function actualizar($id)
    {
        $contacto = Contacto::all();
        $garantia_informe_tecnico=GarantiaInformeTecnico::find($id);
        $archivo_informe_tecnico = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico',$id)->get();
        return view('transaccion.garantias.informe_tecnico.actualizar',compact('garantia_informe_tecnico','archivo_informe_tecnico','contacto'));
    }
    public function print($id){
        $contacto = Contacto::all();
        $mi_empresa=Empresa::first();
        $garantias_informe_tecnico=GarantiaInformeTecnico::find($id);
        $archivo_informe_tecnico  = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico',$id)->get();
        $usuario = User::where('personal_id',$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_lab_id)->first();
        return view('transaccion.garantias.informe_tecnico.show_print',compact('garantias_informe_tecnico','mi_empresa','archivo_informe_tecnico','contacto','usuario'));
    }

    public function pdf(Request $request,$id){
        $contacto = Contacto::all();
        $mi_empresa=Empresa::first();
        $garantias_informe_tecnico=GarantiaInformeTecnico::find($id);
        $archivo_informe_tecnico  = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico',$id)->get();
        $archivo=$request->get('archivo');
        // return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome');
        $pdf=PDF::loadView('transaccion.garantias.informe_tecnico.show_pdf',compact('garantias_informe_tecnico','mi_empresa','archivo_informe_tecnico','contacto'));
    //     return $pdf->download();
        return $pdf->download('Guia Informe Tecnico - '.$archivo.' .pdf');

    }

    public function exportGarantiaInformeTecnico(Request $request)
    {
        if (ob_get_contents()) {
            ob_end_clean();
        }

        if ($request->has('informe_ids') && !empty($request->input('informe_ids'))) {
            $informeIds = $request->input('informe_ids');

            $garantias = GarantiaInformeTecnico::with([
                'garantia_egreso_i'
            ])
            ->whereIn('id', $informeIds)
            ->orderBy('created_at', 'desc')
            ->get();
        } else {

            $daterange = $request->get('daterange', date('01/m/Y') . ' - ' . date('t/m/Y'));
            $filter = $request->get('value');
            $tipo = $request->get('tipo_coti');

            $starDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $daterange)[1])->endOfDay();

            $query = GarantiaInformeTecnico::with(['garantia_egreso_i'])
            ->whereBetween('created_at', [$starDate, $endDate])
            ->orderBy('created_at', 'desc');

            if (!empty($filter)) {
                $query->where(function ($q) use ($filter) {
                    $q->where('codigo_fac', 'like', '%' . $filter . '%');
                    $q->orWhereHas('cliente', function ($q) use ($filter) {
                        $q->where('nombre', 'like', '%' . $filter . '%')
                            ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                    });
                    $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
                    $q->orWhereHas('forma_pago', function ($q) use ($filter) {
                        $q->where('nombre', 'like', '%' . $filter . '%');
                    });
                });
            }

            if ($tipo !== null) {
                $query->where('tipo' , $tipo);
            }

            $garantias = $query->get();
        }

        if (ob_get_contents()) {
            ob_end_clean();
        }

        $headers = [
            'Orden de Servicio',
            'Estado',
            'Fecha',
            'Egresado',
            'Informe técnico',
            'Estética',
            'Revisión del diagnóstico',
            'Causas del problema',
            'Solución',
            'Garantía de egresado'
        ];

        $rows = [$headers];

        foreach ($garantias as $garantia) {

            $garantiaEgresado = optional($garantia->garantia_egreso_i)->orden_servicio ?? '';
            $estado = $garantia->estado == 1 ? 'Activo' : 'Inactivo';

            $rows[] = [
                $garantia->orden_servicio,
                $estado,
                $garantia->fecha,
                $garantia->egresado,
                $garantia->informe_tecnico,
                $garantia->estetica,
                $garantia->revision_diagnostico,
                $garantia->causa_del_problema,
                $garantia->solucion,
                $garantiaEgresado,
            ];
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

        return Excel::download($export, 'garantia_informe_tecnico.xlsx');
    }

// Método para agregar a tu GarantiaInformeTecnicoController

    public function printMultiple(Request $request)
    {
        try {
            $informeIds = $request->input('informe_ids', []);

            if (empty($informeIds) || !is_array($informeIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron informes técnicos para imprimir.'
                ], 400);
            }

            $informeIds = array_filter(array_unique($informeIds), function($id) {
                return !empty($id) && is_numeric($id);
            });

            if (empty($informeIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron IDs válidos para imprimir.'
                ], 400);
            }

            $informes = GarantiaInformeTecnico::whereIn('id', $informeIds)->get();

            if ($informes->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron informes técnicos con los IDs seleccionados.'
                ], 404);
            }

            // \Log::info('Imprimiendo informes técnicos:', ['ids' => $informeIds, 'found' => $informes->count()]);

            $informesData = [];
            $mi_empresa = Empresa::first();
            $contacto = Contacto::all();
            $empresa = Empresa::first();

            foreach ($informes as $informe) {
                $usuario = User::where('personal_id', $informe->personal_lab_id)->first();

                $informesData[] = [
                    'informe' => $informe,
                    'usuario' => $usuario
                ];
            }

            return view('transaccion.garantias.informe_tecnico.print_multiple', compact(
                'informesData',
                'mi_empresa',
                'contacto',
                'empresa'
            ));

        } catch (Exception $e) {
            // \Log::error('Error en printMultipleInforme:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la impresión múltiple: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadMultiplePDFs(Request $request)
    {
        try {
            $informeIds = $request->input('informe_ids', []);

            if (empty($informeIds) || !is_array($informeIds)) {
                return back()->with('error', 'No se seleccionaron informes técnicos.');
            }

            $informeIds = array_values(array_unique(array_filter($informeIds, fn ($id) =>
                is_numeric($id) && (int)$id > 0
            )));

            if (count($informeIds) === 0) {
                return back()->with('error', 'No hay IDs válidos para descargar.');
            }

            if (count($informeIds) === 1) {
                return $this->downloadSinglePDF((int)$informeIds[0]);
            }

            $informes = GarantiaInformeTecnico::with([
                'garantia_egreso_i.garantia_ingreso_i.marcas_i',
                'garantia_egreso_i.garantia_ingreso_i.clientes_i',
                'garantia_egreso_i.garantia_ingreso_i.personal_laborales',
            ])->whereIn('id', $informeIds)->get();

            if ($informes->count() !== count($informeIds)) {
                return back()->with('error', 'Algunos informes seleccionados no existen.');
            }

            $mi_empresa = Empresa::first();
            $empresa    = $mi_empresa;
            $contacto   = Contacto::all();

            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $zipName = 'Informes_Tecnicos_' . date('Y-m-d_H-i-s') . '.zip';
            $tempZip = $tempDir . DIRECTORY_SEPARATOR . $zipName;

            if (file_exists($tempZip)) {
                @unlink($tempZip);
            }

            $zip = new ZipArchive();

            if ($zip->open($tempZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return back()->with('error', 'No se pudo crear el archivo ZIP.');
            }

            $agregados = 0;

            foreach ($informes as $inf) {
                try {
                    $archivo_informe_tecnico = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $inf->id)->get();

                    $usuario = optional($inf->garantia_egreso_i?->garantia_ingreso_i)->personal_lab_id
                        ? User::where('personal_id', $inf->garantia_egreso_i->garantia_ingreso_i->personal_lab_id)->first()
                        : null;

                    $pdf = PDF::loadView('transaccion.garantias.informe_tecnico.show_pdf', [
                        'garantias_informe_tecnico' => $inf,
                        'mi_empresa' => $mi_empresa,
                        'empresa' => $empresa,
                        'contacto' => $contacto,
                        'archivo_informe_tecnico' => $archivo_informe_tecnico,
                        'usuario' => $usuario,
                    ])->setOptions([
                        'dpi' => 96,
                        'isHtml5ParserEnabled' => true,
                        'isRemoteEnabled' => true,
                    ]);

                    $pdfContent = $pdf->output();
                    if (empty($pdfContent)) {
                        continue;
                    }

                    $orden = $inf->orden_servicio ?: ('informe_'.$inf->id);
                    $base  = 'Informe_Tecnico_'.Str::slug($orden, '_');
                    $file  = "{$base}_ID{$inf->id}.pdf";

                    if ($zip->addFromString($file, $pdfContent)) {
                        $agregados++;
                    }
                } catch (\Throwable $e) {
                    continue;
                }
            }

            $zip->close();
            unset($zip);
            clearstatcache(true, $tempZip);

            usleep(100000);

            if ($agregados === 0 || !file_exists($tempZip) || filesize($tempZip) === 0) {
                @unlink($tempZip);
                return back()->with('error', 'No se pudo generar ningún PDF.');
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

        } catch (\Throwable $e) {
            return back()->with('error', 'Error al descargar informes: '.$e->getMessage());
        }
    }

    private function downloadSinglePDF(int $id)
    {
        try {
            $inf = GarantiaInformeTecnico::with([
                'garantia_egreso_i.garantia_ingreso_i.marcas_i',
                'garantia_egreso_i.garantia_ingreso_i.clientes_i',
                'garantia_egreso_i.garantia_ingreso_i.personal_laborales',
            ])->find($id);

            if (!$inf) {
                return back()->with('error', 'Informe técnico no encontrado.');
            }

            $mi_empresa = Empresa::first();
            $empresa    = $mi_empresa;
            $contacto   = Contacto::all();
            $archivo_informe_tecnico = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $inf->id)->get();

            $usuario = optional($inf->garantia_egreso_i?->garantia_ingreso_i)->personal_lab_id
                ? User::where('personal_id', $inf->garantia_egreso_i->garantia_ingreso_i->personal_lab_id)->first()
                : null;

            $pdf = PDF::loadView('transaccion.garantias.informe_tecnico.show_pdf', [
                'garantias_informe_tecnico' => $inf,
                'mi_empresa' => $mi_empresa,
                'empresa' => $empresa,
                'contacto' => $contacto,
                'archivo_informe_tecnico' => $archivo_informe_tecnico,
                'usuario' => $usuario,
            ])->setOptions([
                'dpi' => 96,
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

            $orden = $inf->orden_servicio ?: ('informe_'.$inf->id);
            $name  = 'Informe_Tecnico_'.Str::slug($orden, '_').'.pdf';

            return $pdf->download($name);
        } catch (\Throwable $e) {
            \Log::error('downloadSinglePDF IT: '.$e->getMessage());
            return back()->with('error', 'Error al generar el PDF: '.$e->getMessage());
        }
    }

    public function whatsappSendMultiple(Request $request)
    {
        $numero = $request->numero;
        $informeTecnicoIds = $request->guia_ids;

        $mensaje = "";

        foreach ($informeTecnicoIds as $id) {
            $garantia_informe_tecnico = GarantiaInformeTecnico::find($id);
            if ($garantia_informe_tecnico) {
                $codigo = substr(md5($id . env('APP_KEY') . 'garantia_informe_tecnico'), 0, 22);

                $pdfUrl = url("garantia_informe_tecnico/share/{$codigo}");

                $mensaje .= "{$pdfUrl}\n";
            }
        }

        $mensajeCodificado = urlencode($mensaje);
        $whatsappUrl = "https://wa.me/{$numero}?text={$mensajeCodificado}";

        return redirect()->away($whatsappUrl);
    }

    public function descargarPorCodigo($codigo)
    {
        $garantiasI = GarantiaInformeTecnico::all();

        foreach ($garantiasI as $gar) {
            if (substr(md5($gar->id . env('APP_KEY') . 'garantia_informe_tecnico'), 0, 22) === $codigo) {
                return redirect()->route('pdf_informe', $gar->id);
            }
        }

        abort(404);
    }

    public function enviarCorreoMultiple(Request $request)
    {
        try {
            $email = $request->get('email');
            $informe_ids = $request->get('informe_ids', []);

            if (empty($informe_ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron informes técnicos para enviar.'
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

            $titulo = "Informes Técnicos - " . count($informe_ids) . " documento(s)";
            $mensaje_html = "Estimado cliente, adjuntamos los informes técnicos solicitados.";
            $mensaje = view('email_html.email_send_layout', compact('mi_empresa', 'mensaje_html', 'firma', 'alto', 'ancho'));

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
            foreach ($informe_ids as $informe_id) {
                $garantias_informe_tecnico = GarantiaInformeTecnico::find($informe_id);
                if (!$garantias_informe_tecnico) continue;

                $archivo_informe_tecnico = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico', $garantias_informe_tecnico->id)->get();

                $name = 'PDF-DOC-' . $garantias_informe_tecnico->orden_servicio . '-' . $mi_empresa->ruc;
                $archivo = $name . ".pdf";

                $pdf = PDF::loadView('transaccion.garantias.informe_tecnico.show_pdf', compact('garantias_informe_tecnico', 'mi_empresa', 'contacto', 'archivo_informe_tecnico'));
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

                // ⭐ Guardar archivos CON LA FECHA COMPLETA (no usar basename)
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
                    'message' => 'Se enviaron ' . count($informe_ids) . ' informe(s) técnico(s) exitosamente a: ' . $email
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
