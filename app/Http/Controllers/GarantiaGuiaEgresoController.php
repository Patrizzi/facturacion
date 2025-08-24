<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;
use App\GarantiaGuiaEgreso;
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
use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Swift_Attachment;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Auth;

class GarantiaGuiaEgresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //consulta
        $guia_ingreso=GarantiaGuiaIngreso::where('id',$id)->first();

        //Validacion
        if (empty($guia_ingreso)){return redirect()->route('garantia_guia_egreso.guias')->withErrors(['Numero de Guia no existe en Registro.']);}
        if ($guia_ingreso->egresado==1){return redirect()->route('garantia_guia_egreso.guias')->withErrors(['Guia de Ingreso ya fue Egresada.']);}
        if ($guia_ingreso->estado==0){return redirect()->route('garantia_guia_egreso.guias')->withErrors(['Guia de Ingreso a sido anulada. por ello no puede ser Egresada.']);}
        //Validacion

        //GUIA EGRESO
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
        //GUIA INGRESO
        $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
        $garantia_guia_ingreso->egresado=1;
        $garantia_guia_ingreso->save();

        return redirect()->route('garantia_guia_egreso.show',$garantia_guia_egreso->id);
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
     $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
     $usuario = User::where('personal_id',$garantias_guias_egreso->garantia_ingreso_i->personal_lab_id)->first();
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $guia_egreso=GarantiaGuiaEgreso::find($id);
        $guia_egreso->descripcion_problema=$request->get('descripcion_problema');
        $guia_egreso->diagnostico_solucion=$request->get('diagnostico_solucion');
        $guia_egreso->recomendaciones=$request->get('recomendaciones');
        $guia_egreso->save();
        return redirect()->route('garantia_guia_egreso.show',$guia_egreso->id);
    }

    public function print($id){
        $contacto = Contacto::all();
        $mi_empresa=Empresa::first();
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        $usuario = User::where('personal_id',$garantias_guias_egreso->garantia_ingreso_i->personal_lab_id)->first();
        return view('transaccion.garantias.guia_egreso.show_print',compact('garantias_guias_egreso','mi_empresa','contacto','usuario'));
    }

    public function pdf(Request $request,$id){
        $contacto = Contacto::all();
        $mi_empresa=Empresa::first();
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        $usuario = User::where('personal_id',$garantias_guias_egreso->garantia_ingreso_i->personal_lab_id)->first();
        $archivo=$request->get('archivo');

        // return view('transaccion.garantias.guia_egreso.show_pdf',compact('garantias_guias_egreso','mi_empresa','contacto'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome');
        $pdf=PDF::loadView('transaccion.garantias.guia_egreso.show_pdf',compact('garantias_guias_egreso','mi_empresa','contacto'));
    //     return $pdf->download();
        return $pdf->download('Guia Egreso - '.$archivo.' .pdf');
    }
    function email($id){
        $mi_empresa=Empresa::first();
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        // return view('transaccion.garantias.guia_egreso.show_print',compact('garantia_guia_egreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome').;
        $archivo=$id.".pdf";
        $pdf=PDF::loadView('transaccion.garantias.guia_egreso.show_pdf',compact('garantias_guias_egreso','mi_empresa'));
        $content=$pdf->download();
        Storage::disk('garantias_guias_egreso')->put($archivo,$content);

        return view('transaccion.garantias.guia_egreso.correo',compact('id'));
    }

    public function enviar(Request $request){
       $smtpAddress = 'smtp.gmail.com'; // = $request->smtp
       $port = 465;
       $encryption = 'ssl';
        $yourEmail = 'danielrberru@gmail.com'; // = $request->yourmail
        $yourPassword = 'digimonheroes@1'; //colocar el password,


        //Envio del mail al corre
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

        // Obtener los mismos parámetros que usa la vista
        $marca = $request->marca;
        $daterange = $request->daterange;
        $filter = $request->get('value'); // Para la búsqueda general

        // Aplicar los mismos filtros que en getGarantiaEgresoTable
        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $daterange)[1])->endOfDay();

        $query = GarantiaGuiaEgreso::with([
            'garantia_ingreso_i'
        ])->whereBetween('created_at', [$startDate, $endDate])
        ->orderBy('created_at', 'desc');

        // Aplicar filtro de búsqueda general si existe
        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->orWhereHas('garantia_ingreso_i', function ($sub) use ($filter) {
                    $sub->where('orden_servicio', 'like', '%' . $filter . '%');
                    $sub->orWhere('motivo', 'like', '%' . $filter . '%');
                    $sub->orWhere('asunto', 'like', '%' . $filter . '%');
                    $sub->orWhereHas('clientes_i', function ($q2) use ($filter) {
                        $q2->where('nombre', 'like', '%' . $filter . '%');
                    });
                    $sub->orWhereHas('marcas_i', function ($q3) use ($filter) {
                        $q3->where('nombre', 'like', '%' . $filter . '%');
                    });
                });
            });
        }

        // Aplicar filtro de marca si existe
        if ($marca !== null && $marca !== '') {
            $query->whereHas('garantia_ingreso_i', function ($q) use ($marca) {
                $q->where('marca_id', $marca);
            });
        }

        // Obtener los datos filtrados
        $garantia_egresos = $query->get();

        $headers = [
            'Fecha',
            'Orden de Servicio',
            'Estado',
            'Egresado',
            'Informe técnico',
            'Descripcion del problema',
            'Solucion',
            'Recomendaciones',
            'Garantia Ingreso'
        ];

        $rows = [$headers];

        foreach ($garantia_egresos as $garantia_egreso) {
            $estado = $garantia_egreso->estado == 0 ? 'anulado' : ($garantia_egreso->estado == 1 ? 'No anulado' : 'No anulado');
            $egresado = $garantia_egreso->egresado ? 'Si' : 'No';
            $informeTecnico = $garantia_egreso->informe_tecnico ? 'Si' : 'No';
            $garantiaIngreso = optional($garantia_egreso->garantia_ingreso_i)->orden_servicio;

            $row = [
                $garantia_egreso->fecha,
                $garantia_egreso->orden_servicio,
                $estado,
                $egresado,
                $informeTecnico,
                $garantia_egreso->descripcion_problema,
                $garantia_egreso->diagnostico_solucion,
                $garantia_egreso->recomendaciones,
                $garantiaIngreso
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
        return Excel::download($export, 'Garantia Guias Egresos ' . $fecha . '.xlsx');
    }

    public function printMultiple(Request $request)
    {
        try {
            $guiaIds = $request->input('guia_ids', []);

            if (empty($guiaIds) || !is_array($guiaIds)) {
                return back()->withErrors(['No se seleccionaron guías de egreso para imprimir.']);
            }

            $guias = GarantiaGuiaEgreso::whereIn('id', $guiaIds)->get();

            if ($guias->count() !== count($guiaIds)) {
                return back()->withErrors(['Algunas guías de egreso seleccionadas no existen.']);
            }

            $guiasData = [];
            $mi_empresa = Empresa::first();
            $contacto = Contacto::all();
            $empresa = Empresa::first();

            foreach ($guias as $guia) {
                $usuario = User::where('personal_id', $guia->garantia_ingreso_i->personal_lab_id)->first();

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
            return back()->withErrors(['Error al procesar la impresión múltiple: ' . $e->getMessage()]);
        }
    }
}
