<?php

namespace App\Http\Controllers;

use App\Almacen;
use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;
use App\GarantiaGuiaEgreso;
use App\GarantiaInformeTecnico;
use App\Marca;
use App\Cliente;
use App\Contacto;
use App\Empresa;
use App\Personal_datos_laborales;
use App\Personal;
use App\CreateMail;
use App\Familia;
use App\GuiasServicioTecnico;
use App\Mailbox;
use App\Pais;
use App\User;
use App\Producto;
use App\Servicios;
use App\Subfamilia;
use App\Tipo_afectacion;
use App\Unidad_medida;
use App\Exports\GarantiaGIngresoExport;
use PDF;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Swift_Attachment;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use ZipArchive;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Auth;
use COM;
use App\EmailConfiguraciones;
use App\EmailBandejaEnviosArchivos;
use App\EmailBandejaEnvios;

class GarantiaGuiaIngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mes_año = Carbon::now()->format('d-m-Y');
        // 0=Anulado
        // 1=Activo
        // 2=Fuera Funcion
        $marcas = Marca::where('estado', 0)->get();
        $garantias_guias_ingresos = GarantiaGuiaIngreso::all();
        $garantias_guias = GarantiaGuiaIngreso::where('estado', 1)->get();
        foreach ($garantias_guias as $ingreso) {
            $date = $ingreso->created_at . "+ 2 days";
            $datework = Carbon::createFromDate($date);
            $now = Carbon::now();
            if ($datework < $now) {
                $garantia_guia_ingreso = GarantiaGuiaIngreso::find($ingreso->id);
                $garantia_guia_ingreso->estado = 2;
                $garantia_guia_ingreso->save();
            }
        }
        $count_day = GuiasServicioTecnico::count_day_comprobantes();
        $count_mounth = GuiasServicioTecnico::count_month_ventas(Carbon::now());

        return view('transaccion.garantias.guia_ingreso.index', compact('marcas', 'garantias_guias_ingresos', 'count_day', 'count_mounth'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $clientes = Cliente::all();
        $empresa = Empresa::first();
        $tiempo_actual = Carbon::now();
        $tiempo_actual = $tiempo_actual->format('d-m-Y');

        // Cod-Guia
        $marca_id = $request->input('marca');
        $marca_cantidad = GarantiaGuiaIngreso::where("marca_id", "=", $marca_id)->count();

        $marca_t = Marca::where("id", $marca_id)->first();
        $marca_cantidad++;
        $contador = 1000000;
        $marca_cantidad = $contador + $marca_cantidad;
        $marca_cantidad = (string)$marca_cantidad;
        $marca_cantidad = substr($marca_cantidad, 1);
        $orden_servicio = $marca_t->abreviatura . '-' . $marca_cantidad;
        // Cod-Guia
        // para crear productos reutilizando el modal de crear productos
        $familias = Familia::all();
        $subfamilias = Subfamilia::all();
        $marcas = Marca::all();
        $tipo_afectacion = Tipo_afectacion::all();
        $unidad_medidas = Unidad_medida::all();
        $codigoProdGenerado = null;

        $productos = Producto::where('estado_anular', 1)->where('marca_id', $marca_t->id)->get();
        //SERVIOS ANULAR ESTA AL REVEZ 0 = SIN ANULAR / 1 = ANULADO
        $servicios = Servicios::where('estado_anular', 0)->get();
        if (count($productos) == 0) {
            return redirect()->route('garantia_guia_ingreso.index')->with('repite', 'La marca escogida no cuenta con productos relacionados');
        }
        return view('transaccion.garantias.guia_ingreso.create', compact('marca_id', 'orden_servicio', 'tiempo_actual', 'clientes', 'productos', 'empresa', 'servicios', 'marca_t', 'familias', 'subfamilias', 'marcas', 'tipo_afectacion', 'unidad_medidas', 'codigoProdGenerado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contacto_cliente(Request $request)
    {
        $output = NULL;
        if ($request->ajax()) {
            $cliente = $request->get('cliente_id');
            $contacto = Contacto::where('clientes_id', $cliente)->get();

            if ($contacto) {
                foreach ($contacto as $key => $contactos) {
                    $output .= '<option value="' . $contactos->id . '">' . $contactos->nombre . '</option>';
                }
                return Response($output);
            }
        }
    }

    public function store(Request $request)
    {
        // Cod-Guia
        $marca_id = $request->input('marca_id');
        $marca_cantidad = GarantiaGuiaIngreso::where("marca_id", "=", $marca_id)->count();

        $marca_t = Marca::where("id", $marca_id)->first();
        $marca_cantidad++;
        $contador = 1000000;
        $marca_cantidad = $contador + $marca_cantidad;
        $marca_cantidad = (string)$marca_cantidad;
        $marca_cantidad = substr($marca_cantidad, 1);
        $orden_servicio = $marca_t->abreviatura . '-' . $marca_cantidad;
        // Cod-Guia

        $cliente = $request->get('cliente_id');
        $buscador_cli = Cliente::where('id', $cliente)->first();
        /*Validando Existencia del Cliente*/
        if (empty($buscador_cli)) {
            return redirect()->route('garantia_guia_ingreso.index')->withErrors(['Cliente no encontrado en los Registros.']);
        }

        $contacto = $request->get('contacto_cliente');
        if (empty($contacto)) {
            $contacto = null;
        } else {
            $buscador_contact = Contacto::where('id', $contacto)->where('clientes_id', $cliente)->first();
            if (empty($buscador_contact)) {
                $contacto = null;
            } //Validar si Existe y si es su cliente REspectivo
        }
        // Almacen
        $almacen = Almacen::first();
        //TRAANSFORMNADO CON VALUE DE MARCA A UN ID
        $garantia_guia_ingreso = new GarantiaGuiaIngreso;
        $garantia_guia_ingreso->motivo = $request->get('motivo');
        $garantia_guia_ingreso->fecha = date('Y-m-d');
        $garantia_guia_ingreso->orden_servicio = $orden_servicio;
        $garantia_guia_ingreso->estado = 1;
        $garantia_guia_ingreso->egresado = 0;
        $garantia_guia_ingreso->asunto = $request->get('asunto');
        $garantia_guia_ingreso->nombre_equipo = $request->get('nombre_equipos');
        $garantia_guia_ingreso->numero_serie = $request->get('numero_serie');
        $garantia_guia_ingreso->codigo_interno = $request->get('codigo_interno');
        $garantia_guia_ingreso->fecha_compra = $request->get('fecha_compra');
        $garantia_guia_ingreso->descripcion_problema = $request->get('descripcion_problema');
        $garantia_guia_ingreso->revision_diagnostico = $request->get('revision_diagnostico');
        $garantia_guia_ingreso->estetica = $request->get('estetica');
        $garantia_guia_ingreso->almacen_id = auth()->user()->almacen_id ?? $almacen->id;
        $garantia_guia_ingreso->marca_id = $marca_id;
        $garantia_guia_ingreso->cliente_id = $cliente;
        $garantia_guia_ingreso->personal_lab_id = Auth::user()->personal->id;
        $garantia_guia_ingreso->contacto_cliente_id = $contacto;
        $garantia_guia_ingreso->save();

        return redirect()->route('garantia_guia_ingreso.show', $garantia_guia_ingreso->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // ============================================
    public function show($id)
    {
        $contacto = Contacto::all();
        $empresa = Empresa::first();
        $garantia_guia_ingreso = GarantiaGuiaIngreso::find($id);

        // Validar que existe la guía
        if (!$garantia_guia_ingreso) {
            return redirect()->route('garantia_guia_ingreso.index')
                ->withErrors(['Guía de ingreso no encontrada.']);
        }

        $marcas = Marca::where('estado', 0)->get();
        //   $usuario=User::where('personal_id',$garantia_guia_ingreso->personal_lab_id)->first();
        // Manejar personal_lab_id null
        $usuario = null;
        if ($garantia_guia_ingreso->personal_lab_id) {
            $usuario = User::where('personal_id', $garantia_guia_ingreso->personal_lab_id)->first();
        }

        return view('transaccion.garantias.guia_ingreso.show', compact('garantia_guia_ingreso', 'empresa', 'contacto', 'marcas', 'usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $garantia_guia_ingreso = GarantiaGuiaIngreso::find($id);

        //Validacion
        if (empty($garantia_guia_ingreso)) {
            return redirect()->route('garantia_guia_ingreso.index');
        }
        if ($garantia_guia_ingreso->estado == 2 or $garantia_guia_ingreso->estado == 0 or $garantia_guia_ingreso->egresado == 1) {
            return redirect()->route('garantia_guia_ingreso.index');
            //Validacion
        }

        $empresa = Empresa::first();
        $contacto = Contacto::all();
        $contactos_cli = Contacto::where('clientes_id', $garantia_guia_ingreso->cliente_id)->get();
        $clientes = Cliente::all();
        $personales = DB::table('personal_datos_laborales')->join("personal", "personal.id", "=", "personal_datos_laborales.personal_id")->get();
        return view('transaccion.garantias.guia_ingreso.edit', compact('garantia_guia_ingreso', 'clientes', 'personales', 'contacto', 'empresa', 'contactos_cli'));
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
        // ACTUALIZACION DE ESTADO - ANULADO
        $guia_ingreso = GarantiaGuiaIngreso::where('id', $id)->first();
        if ($guia_ingreso->egresado == 1) {
            return redirect()->back()->with('success','Guia no se puede anular porque ya fue Egresada.');
        }
        $garantia_guia_ingreso = GarantiaGuiaIngreso::find($id);
        $garantia_guia_ingreso->estado = 0;
        $garantia_guia_ingreso->save();

        return redirect()->back()->with('success','Guia Anulada correctamente');
    }
    public function contacto_cliente_actualizar(Request $request)
    {
        // $output="";
        // if($request->ajax()){

        //   $cliente=$request->get('cliente_id');
        //   // $nombre = strstr($cliente, '-',true);
        //   $cliente_id_nombre = Cliente::where("nombre","=",$cliente)->pluck('id');
        //   $contacto = Contacto::where('clientes_id','=',$cliente_id_nombre)->get();

        //   if($contacto){
        //     foreach ($contacto as $key => $contactos) {
        //       $output.='<option>'.$contactos->nombre.'</option>';
        //     }
        //     return Response($output);
        //   }
        // }
    }
    public function actualizar(Request $request, $id)
    {
        $ga_ingreso = GarantiaGuiaIngreso::where('id', $id)->first();
        $contacto = $request->get('contacto');
        if (empty($contacto)) {
            $contacto = NULL;
        }

        $garantia_guia_ingreso = GarantiaGuiaIngreso::find($id);
        $garantia_guia_ingreso->numero_serie = $request->get('numero_serie');
        $garantia_guia_ingreso->codigo_interno = $request->get('codigo_interno');
        $garantia_guia_ingreso->descripcion_problema = $request->get('descripcion_problema');
        $garantia_guia_ingreso->revision_diagnostico = $request->get('revision_diagnostico');
        $garantia_guia_ingreso->estetica = $request->get('estetica');
        if (empty($ga_ingreso->contacto_cliente_id)) {
            $garantia_guia_ingreso->contacto_cliente_id = $contacto;
        }

        //si no esta egresado y si no esta anulado
        if ($ga_ingreso->egresado == 0 and $ga_ingreso->estado == 1) {
            $garantia_guia_ingreso->save();
            return redirect()->route('garantia_guia_ingreso.show', $garantia_guia_ingreso->id);
        }
        //si esta egresado
        elseif ($ga_ingreso->egresado == 1 or $ga_ingreso->estado != 1) {
            return redirect()->route('garantia_guia_ingreso.show', $ga_ingreso->id)->withErrors(['Esta guia no puede ser Modificada.']);
        }
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
    public function print($id)
    {
        $mi_empresa = Empresa::first();
        $contacto = Contacto::all();
        $garantia_guia_ingreso = GarantiaGuiaIngreso::find($id);

        if (!$garantia_guia_ingreso) {
            return redirect()->route('garantia_guia_ingreso.index')
                ->withErrors(['Guía de ingreso no encontrada.']);
        }

        $usuario = null;
        if ($garantia_guia_ingreso->personal_lab_id) {
            $usuario = User::where('personal_id', $garantia_guia_ingreso->personal_lab_id)->first();
        }

        $empresa = Empresa::first();
        return view('transaccion.garantias.guia_ingreso.show_print', compact('garantia_guia_ingreso', 'mi_empresa', 'contacto', 'usuario', 'empresa'));
    }

    public function pdf(Request $request, $id)
    {
        $contacto = Contacto::all();
        $mi_empresa = Empresa::first();
        $garantia_guia_ingreso = GarantiaGuiaIngreso::find($id);

        if (!$garantia_guia_ingreso) {
            return redirect()->route('garantia_guia_ingreso.index')
                ->withErrors(['Guía de ingreso no encontrada.']);
        }

        $archivo = $request->get('archivo');

        $usuario = null;
        if ($garantia_guia_ingreso->personal_lab_id) {
            $usuario = User::where('personal_id', $garantia_guia_ingreso->personal_lab_id)->first();
        }

        $empresa = Empresa::first();
        $pdf = PDF::loadView('transaccion.garantias.guia_ingreso.show_pdf', compact('garantia_guia_ingreso', 'mi_empresa', 'contacto', 'usuario', 'empresa'));
        return $pdf->download('Guia Ingreso - ' . $archivo . ' .pdf');
    }

    function email($id)
    {
        $mi_empresa = Empresa::first();
        $garantia_guia_ingreso = GarantiaGuiaIngreso::find($id);
        $archivo = $id . ".pdf";
        $pdf = PDF::loadView('transaccion.garantias.guia_ingreso.show_pdf', compact('garantia_guia_ingreso', 'mi_empresa'));
        $content = $pdf->download();
        Storage::disk('garantia_guia_ingreso')->put($archivo, $content);
        return view('transaccion.garantias.guia_ingreso.correo', compact('id'));
    }

    public function enviar(Request $request)
    {
        $id_usuario = auth()->user()->id;
        $correo_busqueda = CreateMail::where('id_usuario', $id_usuario)->first();
        $correo = $correo_busqueda->email;

        $smtpAddress = $correo_busqueda->smtp;
        $port = $correo_busqueda->port;
        $encryption = $correo_busqueda->encryption;
        $yourEmail = $correo;
        $yourPassword = $correo_busqueda->password;
        $sendto = $request->get('sendto');
        $titulo = $request->get('titulo');
        $mensaje = $request->get('mensaje');
        $bakcup = $correo_busqueda->email_backup;

        $file = $request->id;
        $pdfile = storage_path() . '/app/public/guia_ingreso/' . $file . '.pdf';

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption))->setUsername($yourEmail)->setPassword($yourPassword);
        $mailer = new \Swift_Mailer($transport);

        $newfile = $request->file('archivo');
        if ($request->hasfile('archivo')) {
            foreach ($newfile as $file) {
                $nombre =  $file->getClientOriginalName();
                \Storage::disk('mailbox')->put($nombre,  \File::get($file));

                $news[] = storage_path() . '/app/public/' . $nombre;
                $message = (new \Swift_Message($yourEmail))->setFrom([$yourEmail => $titulo])->setTo([$sendto, $bakcup])->setBody($mensaje, 'text/html');
                $message->attach(\Swift_Attachment::fromPath($pdfile));
                foreach ($news as $attachment) {
                    $message->attach(\Swift_Attachment::fromPath($attachment));
                }
            }
        } else {
            $message = (new \Swift_Message($yourEmail))->setFrom([$yourEmail => $titulo])->setTo([$sendto, $bakcup])->setBody($mensaje, 'text/html');
            $message->attach(\Swift_Attachment::fromPath($pdfile));
        }
        if ($mailer->send($message)) {
            $mail = new Mailbox;
            $mail->id_usuario = auth()->user()->id;
            $mail->destinatario = $correo;
            $mail->remitente = $request->get('sendto');
            $mail->asunto = $request->get('titulo');
            $mail->mensaje = $request->get('mensaje');
            $mail->mensaje_sin_html = $request->get('mensaje_sin_html');
            $mail->archivo = $request->get('archivo');
            $mail->pdf = $pdfile;
            $mail->fecha_hora = $request->get('fecha_hora');
            $mail->save();
            return redirect()->route('garantia_guia_ingreso.index');
        }
        return "Something went wrong :(";
    }

    public function ticket_guia_ingreso(Request $request)
    {
        $ids = $request->get('id');
        $garantia_ingreso = GarantiaGuiaIngreso::find($ids);
        $empresa = Empresa::first();

        $nombre_impresora = "EPSONTICKET";

        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        echo 1;

        $empresa = Empresa::first();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->text("GUIA DE INGRESO\n");
        $printer->text($garantia_ingreso->orden_servicio . "\n");
        $printer->text("===============================\n");
        $printer->text($garantia_ingreso->created_at . "\n");
        $printer->text($empresa->nombre . "\n");
        $printer->setEmphasis(true);
        $printer->text("RUC: " . $empresa->ruc . "\n");
        $printer->text($empresa->calle . " - " . $empresa->ciudad . " - " . $empresa->region_provincia . "\n");
        $printer->text("Telefono: " . $empresa->telefono);
        $printer->setEmphasis(false);
        $printer->text("\n===============================\n");
        $cliente_dato = sprintf('%-15.15s %-2.2s %-21.21s', "Cliente", ':', $garantia_ingreso->clientes_i->nombre);
        $printer->text($cliente_dato . "\n");
        $cliente_id = sprintf('%-15.20s %-2.2s %-21.21s', $garantia_ingreso->clientes_i->documento_identificacion, ':', $garantia_ingreso->clientes_i->numero_documento);
        $printer->text($cliente_id);
        $printer->text("\n===============================\n");
        $trabajador_dato = sprintf('%-15.15s %-2.2s %-21.21s', "Ing. Asignado", ':', $garantia_ingreso->personal_laborales->nombres);
        $printer->text($trabajador_dato . "\n");
        $motivo = sprintf('%-15.15s %-2.2s %-21.21s', "Motivo", ':', $garantia_ingreso->motivo);
        $printer->text($motivo . "\n");
        $marca = sprintf('%-15.15s %-2.2s %-21.21s', "Marca", ':', $garantia_ingreso->marcas_i->nombre);
        $printer->text($marca . "\n");
        $asunto = sprintf('%-15.15s %-2.2s %-21.21s', "Asunto", ':', $garantia_ingreso->asunto);
        $printer->text($asunto);
        $printer->text("\n===============================\n");
        $modelo = sprintf('%-15.15s %-2.2s %-21.21s', "Modelo", ':', $garantia_ingreso->nombre_equipo);
        $printer->text($modelo . "\n");
        $n_serie = sprintf('%-15.15s %-2.2s %-21.21s', "Nro.  Serie", ':', $garantia_ingreso->numero_serie);
        $printer->text($n_serie . "\n");
        $codigo_int = sprintf('%-15.15s %-2.2s %-21.21s', "Codigo Interno", ':', $garantia_ingreso->codigo_interno);
        $printer->text($codigo_int . "\n");
        $fecha_compra = sprintf('%-15.15s %-2.2s %-21.21s', "Fecha Compra", ':', $garantia_ingreso->fecha_compra);
        $printer->text($fecha_compra);

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("\n===============================\n");

        $printer->feed(3);
        $printer->cut();
        $printer->pulse();
        $printer->close();
    }

    public function index2()
    {
        $garantias_guias_ingresos = GarantiaGuiaIngreso::all();
        $garantias_guias_egresos = GarantiaGuiaEgreso::all();
        $garantias_informe_tecnicos = GarantiaInformeTecnico::all();
        return view('transaccion.garantias.index', compact('garantias_guias_ingresos', 'garantias_guias_egresos', 'garantias_informe_tecnicos'));
    }

    public function exportar_garantia_ingreso(Request $request)
    {
        if (ob_get_contents()) {
            ob_end_clean();
        }

        $guiaIds = $request->json('guia_ids') ?? $request->input('guia_ids');

        if (!empty($guiaIds)) {
            $export = new GarantiaGIngresoExport($guiaIds);
        } else {
            $request->validate(['daterange' => 'required|string']);

            [$start, $end] = explode(' - ', $request->daterange);

            $export = new GarantiaGIngresoExport(null, [
                'start'  => Carbon::createFromFormat('d/m/Y', $start)->startOfDay(),
                'end'    => Carbon::createFromFormat('d/m/Y', $end)->endOfDay(),
                'filter' => $request->input('value'),
                'marca'  => $request->input('marca'),
            ]);
        }

        return Excel::download(
            $export,
            'Garantia Guias Ingresos ' . now('America/Lima')->format('d-m-Y') . '.xlsx'
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
                    'message' => 'No se seleccionaron guías de ingreso para imprimir.'
                ], 400);
            }

            $guiaIds = array_filter(array_unique($guiaIds), function ($id) {
                return !empty($id) && is_numeric($id);
            });

            if (empty($guiaIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron IDs válidos para imprimir.'
                ], 400);
            }

            $guias = GarantiaGuiaIngreso::whereIn('id', $guiaIds)->get();

            if ($guias->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron guías de ingreso con los IDs seleccionados.'
                ], 404);
            }

            \Log::info('Imprimiendo guías de ingreso:', ['ids' => $guiaIds, 'found' => $guias->count()]);

            $guiasData = [];
            $mi_empresa = Empresa::first();
            $contacto = Contacto::all();
            $empresa = Empresa::first();

            foreach ($guias as $guia) {
                $usuario = null;
                if ($guia->personal_lab_id) {
                    $usuario = User::where('personal_id', $guia->personal_lab_id)->first();
                }

                $guiasData[] = [
                    'guia' => $guia,
                    'usuario' => $usuario
                ];
            }

            return view('transaccion.garantias.guia_ingreso.print_multiple', compact(
                'guiasData',
                'mi_empresa',
                'contacto',
                'empresa'
            ));
        } catch (\Exception $e) {
            \Log::error('Error en printMultiple (ingreso):', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

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
                return back()->with('error', 'No se seleccionaron guías.');
            }

            $guiaIds = array_filter($guiaIds, function ($id) {
                return is_numeric($id) && $id > 0;
            });

            if (count($guiaIds) === 1) {
                return $this->downloadSinglePDF($guiaIds[0]);
            }

            $guias = GarantiaGuiaIngreso::with(['marcas_i', 'personal_laborales', 'clientes_i', 'contactos'])
                ->whereIn('id', $guiaIds)
                ->get();

            if ($guias->count() !== count($guiaIds)) {
                return back()->with('error', 'Algunas guías seleccionadas no existen.');
            }

            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $zipName = 'Guias_Ingreso_' . date('Y-m-d_H-i-s') . '.zip';
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
                    $usuario = $guia->personal_lab_id ?
                        User::where('personal_id', $guia->personal_lab_id)->first() : null;

                    $pdf = PDF::loadView('transaccion.garantias.guia_ingreso.show_pdf', [
                        'garantia_guia_ingreso' => $guia,
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

                    $ordenServicio = $guia->orden_servicio ?? 'guia_' . $guia->id;
                    $fileName = 'Guia_Ingreso_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $ordenServicio) . '.pdf';

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
                return back()->with('error', 'No se pudo generar ningún PDF.');
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
            return back()->with('error', 'Error al descargar guías: ' . $e->getMessage());
        }
    }

    private function downloadSinglePDF($id)
    {
        try {
            $garantia_guia_ingreso = GarantiaGuiaIngreso::find($id);

            if (!$garantia_guia_ingreso) {
                return back()->with('error', 'Guía de ingreso no encontrada.');
            }

            $mi_empresa = Empresa::first();
            $contacto = Contacto::all();
            $empresa = Empresa::first();

            // CORRECCIÓN: Agregar ->first() que faltaba
            $usuario = null;
            if ($garantia_guia_ingreso->personal_lab_id) {
                $usuario = User::where('personal_id', $garantia_guia_ingreso->personal_lab_id)->first();
            }

            $pdf = PDF::loadView('transaccion.garantias.guia_ingreso.show_pdf', compact(
                'garantia_guia_ingreso',
                'mi_empresa',
                'contacto',
                'usuario',
                'empresa'
            ));

            $ordenServicio = $garantia_guia_ingreso->orden_servicio ?? 'sin_orden';
            $ordenServicio = preg_replace('/[^a-zA-Z0-9_-]/', '_', $ordenServicio);

            return $pdf->download('Guia_Ingreso_' . $ordenServicio . '.pdf');
        } catch (\Exception $e) {
            \Log::error('Error al generar PDF: ' . $e->getMessage());
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    public function whatsappSendMultiple(Request $request)
    {
        $numero = $request->numero;
        $garantiaIngresoIds = $request->guia_ids;

        $mensaje = "";

        foreach ($garantiaIngresoIds as $id) {
            $garantia_guia_ingreso = GarantiaGuiaIngreso::find($id);
            if ($garantia_guia_ingreso) {
                $codigo = substr(md5($id . env('APP_KEY') . 'garantia_guia_ingreso'), 0, 22);

                $pdfUrl = url("garantia_guia_ingreso/share/{$codigo}");

                $mensaje .= "{$pdfUrl}\n";
            }
        }

        $mensajeCodificado = urlencode($mensaje);
        $whatsappUrl = "https://wa.me/{$numero}?text={$mensajeCodificado}";

        return redirect()->away($whatsappUrl);
    }

    public function descargarPorCodigo($codigo)
    {
        $garantias = GarantiaGuiaIngreso::all();

        foreach ($garantias as $gar) {
            if (substr(md5($gar->id . env('APP_KEY') . 'garantia_guia_ingreso'), 0, 22) === $codigo) {
                return redirect()->route('pdf_ingreso', $gar->id);
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
                    'message' => 'No se seleccionaron guías de ingreso para enviar.'
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

            $titulo = "Guías de Ingreso - " . count($guia_ids) . " documento(s)";
            $mensaje_html = "Estimado cliente, adjuntamos las guías de ingreso solicitadas.";
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
                $garantia_guia_ingreso = GarantiaGuiaIngreso::find($guia_id);
                if (!$garantia_guia_ingreso) continue;

                $name = 'PDF-DOC-' . $garantia_guia_ingreso->orden_servicio . '-' . $mi_empresa->ruc;
                $archivo = $name . ".pdf";

                $pdf = PDF::loadView('transaccion.garantias.guia_ingreso.show_pdf', compact('garantia_guia_ingreso', 'mi_empresa', 'contacto'));
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

                // ⭐ Guardar archivos CON LA FECHA COMPLETA (no usar basename)
                foreach ($archivos_temporales as $archivo_temp) {
                    $archivo_pdf = new EmailBandejaEnviosArchivos;
                    $archivo_pdf->id_bandeja_envios = $mail->id;
                    $archivo_pdf->archivo = $archivo_temp; // ⭐ Guardamos con fecha completa
                    $archivo_pdf->fecha_hora = $date;
                    $archivo_pdf->save();
                }

                $this->limpiarArchivosViejos(2880);

                return response()->json([
                    'success' => true,
                    'message' => 'Se enviaron ' . count($guia_ids) . ' guía(s) de ingreso exitosamente a: ' . $email
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
