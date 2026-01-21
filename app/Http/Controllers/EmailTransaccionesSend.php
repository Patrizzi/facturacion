<?php

namespace App\Http\Controllers;
use App;
use App\Boleta_registro;
use App\Boleta;
use App\Boleta_m;
use App\Boleta_registros_m;
use App\Cliente;
use App\Cotizacion;
use App\Contacto;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;
use App\Empresa;
use App\Banco;
use App\Moneda;
use App\Facturacion;
use App\Facturacion_registro;
use App\Facturacion_m;
use App\Facturacion_registro_m;
use App\Cotizacion_Servicios;
use App\Cotizacion_factura_registro;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_Servicios_factura_registro;
use App\Cotizacion_Servicios_boleta_registro;
use App\CotizacionManual;
use App\CotizacionManual_registros;
use App\kardex_entrada_registro;
use App\Guia_remision;
use App\g_remision_registro;
use App\GuiaRemisionManual;
use App\GuiaRemisionMRegistros;
use App\GarantiaGuiaIngreso;
use App\GarantiaGuiaEgreso;
use App\GarantiaInformeTecnico;
use App\Igv;
use App\NotaVenta;
use App\Nota_Credito;
use App\Nota_Credito_registro;
use App\RenovacionVentas;
use App\NotaVentaRegistro;
use App\GarantiaInformeTecnicoArchivos;
use App\User;
use PDF;
use Carbon\Carbon;
use DB;
use App\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_TransportException;


class EmailTransaccionesSend extends Controller
{
    public function cotizacion(Request $request, $id)
    {
        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "cotizacion_factura";
        // Fecha conversion
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);
        $banco=Banco::where('estado','0')->get();
        $banco_count=Banco::where('estado','0')->count();
        $empresa=Empresa::first();
        $igv=Igv::first();

        $cotizacion=Cotizacion::find($id);
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
        $id = $cotizacion->id;
        $ruta_retorno = 'cotizacion.show';
        $clientes = $cotizacion->cliente->email;  

        //* SUBTOTALES CONVERTIDOS
        $sub_total = $cotizacion->op_gravada+$cotizacion->op_exonerada+$cotizacion->op_inafecta;
        $igv_p=round($cotizacion->op_gravada, 2)*$igv->igv_total/100;
        $end=round($sub_total, 2)+round($igv_p, 2);
        $end2=number_format(round($sub_total, 2)+round($igv_p, 2),2);

        /* Finde numeros a Letras*/
        $firma = EmailConfiguraciones::where('id_usuario',$cotizacion->user_id)->pluck('firma_digital')->first();
        $sum=0;
        $i=1;
        $regla=$cotizacion->tipo;

        // VERIFICAR SI EXISTE RENOVACIÓN
        $renovacion = RenovacionVentas::where('cotizacion_id', $id)
            ->where('estado', 1)
            ->with('cotizacion')
            ->first();

        $fecha_vencimiento = null;
        $dias_restantes_texto = null;
        $dias_restantes_numero = null;

        if ($renovacion && $renovacion->cotizacion) {
            $fecha_actual = Carbon::now()->startOfDay();
            $fecha_emision = Carbon::parse($renovacion->cotizacion->fecha_emision)->startOfDay();

            if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                $dia_renovacion = (int) $renovacion->dia_mensual;

                $fecha_vencimiento = Carbon::create(
                    $fecha_emision->year,
                    $fecha_emision->month,
                    min($dia_renovacion, $fecha_emision->daysInMonth)
                )->startOfDay();

                if ($fecha_vencimiento->lt($fecha_emision)) {
                    $fecha_vencimiento->addMonth();
                    $fecha_vencimiento->day = min($dia_renovacion, $fecha_vencimiento->daysInMonth);
                }

                while ($fecha_vencimiento->lte($fecha_actual)) {
                    $fecha_vencimiento->addMonth();
                    $fecha_vencimiento->day = min($dia_renovacion, $fecha_vencimiento->daysInMonth);
                }
            }
            elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                $dia_vencimiento = (int) $renovacion->dia_anual;
                $mes_vencimiento = (int) $renovacion->mes_anual;
                $anio_base = $renovacion->anio_anual ?? $fecha_actual->year;

                try {
                    $fecha_vencimiento = Carbon::create($anio_base, $mes_vencimiento, $dia_vencimiento)->startOfDay();
                } catch (\Exception $e) {
                    $fecha_vencimiento = Carbon::create($anio_base, $mes_vencimiento, 1)
                        ->endOfMonth()
                        ->startOfDay();
                }

                while ($fecha_vencimiento->lte($fecha_actual)) {
                    $fecha_vencimiento->addYear();
                }
            }

            if ($fecha_vencimiento) {
                $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                $dias_restantes_numero = $dias_diferencia;

                if ($dias_diferencia < 0) {
                    $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                } elseif ($dias_diferencia == 0) {
                    $dias_restantes_texto = 'Vence hoy';
                } elseif ($dias_diferencia == 1) {
                    $dias_restantes_texto = '1 día';
                } else {
                    $dias_restantes_texto = $dias_diferencia . ' días';
                }
            }
        }

        //* Generacioon de archivos PDF
        $archivo='PDF-DOC-'.$cotizacion->cod_cotizacion.'-'.$empresa->ruc.".pdf";
        $pdf=PDF::loadView('transaccion.venta.cotizacion.pdf2',compact('cotizacion','empresa','cotizacion_registro','regla','sum','igv','sub_total','banco','i','end','igv_p','banco_count','firma','end2','renovacion','fecha_vencimiento','dias_restantes_texto','dias_restantes_numero'));
        $content = $pdf->download();

        $especif = $date.$archivo;
        Storage::disk('mailbox')->put($especif,$content);
    
        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id'));
    }
    //*
    public function cotizacion_manual(Request $request, $id)
    {
        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "cotizacion_manual";
        // Fecha conversion
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);
        $banco=Banco::where('estado','0')->get();
        $banco_count=Banco::where('estado','0')->count();
        $empresa=Empresa::first();

        $cotizacion=CotizacionManual::find($id);
        $cotizacion_m_reg=CotizacionManual_registros::where('cotizacion_m_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $j = 1;

        $id = $cotizacion->id;
        $ruta_retorno = 'cotizacion_manual.show';
        $clientes = $cotizacion->cliente->email;  

        //SUBTOTAL
        $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
        //IGV
        $igv = round($cotizacion->op_gravada, 2) * $igv->igv_total/100;
        //TOTAL 
        $end = round($sub_total, 2) + round($igv, 2);
        $end2 = number_format(round($sub_total, 2) + round($igv, 2), 2);

        // VERIFICAR SI EXISTE RENOVACIÓN
        $renovacion = RenovacionVentas::where('cotizacion_manual_id', $id)
            ->where('estado', 1)
            ->with('cotizacionManual')
            ->first();

        $fecha_vencimiento = null;
        $dias_restantes_texto = null;
        $dias_restantes_numero = null;

        if ($renovacion && $renovacion->cotizacionManual) {
            $fecha_actual = Carbon::now()->startOfDay();
            $fecha_emision = Carbon::parse($renovacion->cotizacionManual->fecha_emision)->startOfDay();

            if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                $dia_renovacion = (int) $renovacion->dia_mensual;

                $fecha_vencimiento = Carbon::create(
                    $fecha_emision->year,
                    $fecha_emision->month,
                    min($dia_renovacion, $fecha_emision->daysInMonth)
                )->startOfDay();

                if ($fecha_vencimiento->lt($fecha_emision)) {
                    $fecha_vencimiento->addMonth();
                    $fecha_vencimiento->day = min($dia_renovacion, $fecha_vencimiento->daysInMonth);
                }

                while ($fecha_vencimiento->lte($fecha_actual)) {
                    $fecha_vencimiento->addMonth();
                    $fecha_vencimiento->day = min($dia_renovacion, $fecha_vencimiento->daysInMonth);
                }
            }
            elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                $dia_vencimiento = (int) $renovacion->dia_anual;
                $mes_vencimiento = (int) $renovacion->mes_anual;
                $anio_base = $renovacion->anio_anual ?? $fecha_actual->year;

                try {
                    $fecha_vencimiento = Carbon::create($anio_base, $mes_vencimiento, $dia_vencimiento)->startOfDay();
                } catch (\Exception $e) {
                    $fecha_vencimiento = Carbon::create($anio_base, $mes_vencimiento, 1)
                        ->endOfMonth()
                        ->startOfDay();
                }

                while ($fecha_vencimiento->lte($fecha_actual)) {
                    $fecha_vencimiento->addYear();
                }
            }

            if ($fecha_vencimiento) {
                $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                $dias_restantes_numero = $dias_diferencia;

                if ($dias_diferencia < 0) {
                    $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                } elseif ($dias_diferencia == 0) {
                    $dias_restantes_texto = 'Vence hoy';
                } elseif ($dias_diferencia == 1) {
                    $dias_restantes_texto = '1 día';
                } else {
                    $dias_restantes_texto = $dias_diferencia . ' días';
                }
            }
        }
        
        $archivo='PDF-DOC-'.$cotizacion->cod_cotizacion.'-'.$empresa->ruc.".pdf";
        
        $pdf=PDF::loadView('transaccion.venta.cotizacion.manual.pdf', compact('j','cotizacion','empresa','cotizacion_m_reg','sum','igv','sub_total','banco','banco_count','end','end2','renovacion','fecha_vencimiento','dias_restantes_texto','dias_restantes_numero'));
        $content = $pdf->download();

        $especif = $date.$archivo;
        Storage::disk('mailbox')->put($especif,$content);
    
        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id'));
    }
    //*
    public function guia_remision(Request $request, $id)
    {

        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "guia_remision";
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);

        $banco_count=Banco::where('estado','0')->count();
        $guia_remision=Guia_remision::find($id);
        $guia_registro=G_remision_registro::where('guia_remision_id',$guia_remision->id)->get();
        $id = $guia_remision->id;
        $ruta_retorno = 'guia_remision.show';
        
        $clientes = $guia_remision->cliente->email;  
        $banco=Banco::where('estado','0')->get();
        $empresa=Empresa::first();

        // $archivo=$guia_remision->cod_guia.".pdf";
        $archivo='PDF-DOC-'.$guia_remision->cod_guia.'-'.$empresa->ruc.".pdf";
        //* xml
        if($guia_remision->g_electronica == 1){
            $xml_file = ''.$empresa->ruc.'-09-'.$guia_remision->cod_guia.'.xml';
        }else{
            $xml_file = null;
        }

        $pdf=PDF::loadView('transaccion.venta.guia_remision.pdf',compact('guia_remision','guia_registro','banco','empresa','banco_count'));
        $content = $pdf->download();
        $especif = $date.$archivo;
        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id','xml_file'));
    }
    //*
    public function guia_remision_m(Request $request, $id){
        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "cotizacion_manual";
        // Fecha conversion
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);
        // $banco=Banco::where('estado','0')->get();
        // $banco_count=Banco::where('estado','0')->count();
        $empresa = Empresa::first();
        $guia_remision_m = GuiaRemisionManual::find($id);
        $guia_remision_m_reg = GuiaRemisionMRegistros::where('guia_remision_m_id', $guia_remision_m->id)->get();
        $i = 1;
        
        $id = $guia_remision_m->id;
        $ruta_retorno = 'guia_remision_m.show';
        $clientes = $guia_remision_m->cliente->email;  

        $archivo='PDF-DOC-'.$guia_remision_m->cod_guia.'-'.$empresa->ruc.".pdf";

        //* xml
        if($guia_remision_m->g_electronica == 1){
            $xml_file = ''.$empresa->ruc.'-09-'.$guia_remision_m->cod_guia.'.xml';
        }else{
            $xml_file = null;
        }

        $pdf=PDF::loadView('transaccion.venta.guia_remision.guia_manual.pdf',compact('guia_remision_m','guia_remision_m_reg','empresa','i'));
        $content = $pdf->download();
        $especif = $date.$archivo;
        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id','xml_file'));
    }
    //*
    public function factura(Request $request, $id)
    {

        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "facturacion";
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);
        // return $request;

        $name = 'Factura';
        $empresa=Empresa::first();
        $facturacion=Facturacion::find($id);
        $facturacion_registro=Facturacion_registro::where('facturacion_id',$id)->get();

        $id = $facturacion->id;
        $ruta_retorno = 'facturacion.show';
        $clientes = $facturacion->cliente->email;  
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $banco_count=Banco::where('estado','0')->count();
        $i = 1;
        if($facturacion->f_electronica == 1){
            $xml_file = ''.$empresa->ruc.'-01-'.$facturacion->codigo_fac.'.xml';
        }else{
            $xml_file = null;
        }
        // $archivo=$facturacion->codigo_fac.".pdf";
        $archivo='PDF-DOC-'.$facturacion->codigo_fac.'-'.$empresa->ruc.".pdf";

        $pdf=PDF::loadView('transaccion.venta.facturacion.pdf', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','banco_count','i'));
        $content = $pdf->download();
        $especif = $date.$archivo;

        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id','xml_file'));
    }    
    //*
    public function factura_manual(Request $request, $id)
    {
        // return $request;
        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "facturacion_manual";
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);
        
        $empresa=Empresa::first();
        $facturacion=Facturacion_m::find($id);
        $facturacion_registro=Facturacion_registro_m::where('facturacion_m_id',$id)->get();
        $id = $facturacion->id;
        $ruta_retorno = 'facturacion_manual.show';
        $clientes = $facturacion->cliente->email;  
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $banco_count=Banco::where('estado','0')->count();
        $i = 1;

        if($facturacion->f_electronica == 1){
            $xml_file = ''.$empresa->ruc.'-01-'.$facturacion->codigo_fac.'.xml';
        }else{
            $xml_file = null;
        }
        // $archivo=$facturacion->codigo_fac.".pdf";
        $archivo='PDF-DOC-'.$facturacion->codigo_fac.'-'.$empresa->ruc.".pdf";
        
        $pdf = PDF::loadView('transaccion.venta.facturacion.facturacion_manual.pdf',compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','banco_count','i'));
        $content = $pdf->download();
        $especif = $date.$archivo;

        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id','xml_file'));
    }
    //*
    public function boleta( Request $request, $id)
    {
        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "boleta";
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);

        $boleta=Boleta::find($id);
        $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        $igv=Igv::first();
        $banco=Banco::all();
        $banco_count=Banco::where('estado','0')->count();
        $empresa=Empresa::first();

        $id = $boleta->id;
        $ruta_retorno = 'boleta.show';
        $clientes = $boleta->cliente->email;  
        
        $sub_total=0;
        
        $i = 1;
        //* XML
        if($boleta->b_electronica == 1){
            $xml_file = ''.$empresa->ruc.'-03-'.$boleta->codigo_boleta.'.xml'; 
        }else{
            $xml_file = null;
        }
        // $archivo=$boleta->codigo_boleta.".pdf";
        $archivo='PDF-DOC-'.$boleta->codigo_boleta.'-'.$empresa->ruc.".pdf";

        $pdf=PDF::loadView('transaccion.venta.boleta.pdf', compact('boleta','empresa','banco','boleta_registro','igv','sub_total','banco_count','i'));
        $content = $pdf->download();
        $especif = $date.$archivo;
        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id','xml_file'));
    }
    //*
    public function boleta_manual(Request $request, $id)
    {
        // return $request;
        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "boleta_manual";
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);

        $empresa=Empresa::first();
        $boleta=Boleta_m::find($id);
        $boleta_registro=Boleta_registros_m::where('boleta_m_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $j = 1;
        $id = $boleta->id;
        $ruta_retorno = 'boleta_manual.show';
        $clientes = $boleta->cliente->email;  

        if($boleta->b_electronica == 1){
            $xml_file = ''.$empresa->ruc.'-03-'.$boleta->codigo_boleta.'.xml'; 
        }else{
            $xml_file = null;
        }
        $archivo='PDF-DOC-'.$boleta->codigo_boleta.'-'.$empresa->ruc.".pdf";

        $pdf=PDF::loadView('transaccion.venta.boleta.boleta_manual.pdf', compact('j','boleta','empresa','boleta_registro','sum','igv','sub_total','banco'));
        $content = $pdf->download();
        $especif = $date.$archivo;
        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id','xml_file'));
    }
    //*
    
    public function nota_venta(Request $request, $id)
    {
        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "nota_venta";
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);

        $empresa=Empresa::first();
        $nota_venta = NotaVenta::where('id',$id)->first();
        $nota_venta_re = NotaVentaRegistro::where('nota_venta_id',$id)->get();
        $banco=Banco::where('estado',0)->get();
        $banco_count=$banco->count();

        $id = $nota_venta->id;
        $ruta_retorno = 'boleta.show';
        $clientes = $nota_venta->cliente->email;  

        $archivo = 'PDF-DOC-'.$nota_venta->cod_nota_venta.'-'.$empresa->ruc.'.pdf';

        $pdf = PDF::loadView('transaccion.venta.nota_venta.pdf',compact('empresa','nota_venta','nota_venta_re','banco','banco_count'));
        $content = $pdf->download();
        $especif = $date.$archivo;
        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id'));
    }
    //*
    public function nota_credito(Request $request, $id){
        // return $request;
        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "nota_credito";
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);

        $notas_credito=Nota_Credito::where('id',$id)->first();
        $notas_credito_registros=Nota_Credito_registro::where('nota_credito_id',$id)->get();

        $empresa=Empresa::first();
        //* FACTURA 0 - BOLETA  1 - FAC MANUAL 2 -  BOL MANUAL 3
        if($notas_credito->facturacion_id != NULL){
            $document = Facturacion::where('id',$notas_credito->facturacion_id)->first();
            $doc_reg = Facturacion_registro::where('facturacion_id',$document->id)->get();
            $estado=0;
            
            
        }elseif($notas_credito->boleta_id != NULL){
            $document=Boleta::where('id',$notas_credito->boleta_id)->first();
            $doc_reg=Boleta_registro::where('boleta_id',$document->id)->get();
            $estado=1;
            
        }elseif($notas_credito->boleta_m_id != NULL){
            $document=Boleta_m::where('id',$notas_credito->boleta_m_id)->first();
            $doc_reg=Boleta_registros_m::where('boleta_m_id',$document->id)->get();
            $estado=3;
            
        }else{
            $document = Facturacion_m::where('id',$notas_credito->facturacion_m_id)->first();
            $doc_reg = Facturacion_registro_m::where('facturacion_m_id',$document->id)->get();
            $estado=2;
            
        }
        $id = $notas_credito->id;
        $ruta_retorno = 'nota-credito.show';
        $clientes = $document->cliente->email;  
        // return  $document;
        if($notas_credito->n_electronica == 1){
            $xml_file = ''.$empresa->ruc.'-07-'.$notas_credito->codigo_n_c.'.xml'; 
        }else{
            $xml_file = null;
        }
        
        $archivo='PDF-DOC-'.$notas_credito->codigo_n_c.'-'.$empresa->ruc.".pdf";

        $u=1;
        $igv=Igv::first();
        $pdf=PDF::loadView('transaccion.venta.nota_credito.pdf',compact('notas_credito','notas_credito_registros','empresa','estado','igv','document','doc_reg','u'));
        $content = $pdf->download();
        $especif = $date.$archivo;
        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id','xml_file'));
    }
    //*
    public function guia_ingreso(Request $request, $id)
    {
        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "guia_ingreso";
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);
        
        
        // $rutapdf= '';
        $mi_empresa=Empresa::first();
        $garantia_guia_ingreso = GarantiaGuiaIngreso::find($id);
        $id = $garantia_guia_ingreso->id;
        $ruta_retorno = 'garantia_guia_ingreso.show';
        $clientes = $garantia_guia_ingreso->clientes_i->email;  

        // return $garantia_guia_ingreso;
        $name = 'PDF-DOC-'.$garantia_guia_ingreso->orden_servicio.'-'.$mi_empresa->ruc;
        
        $contacto = Contacto::all();
        $archivo = $name.".pdf";
        $pdf = PDF::loadView('transaccion.garantias.guia_ingreso.show_pdf',compact('garantia_guia_ingreso','mi_empresa','contacto'));
        $content = $pdf->download();

        $especif = $date.$archivo;
        // $archivo=$especif;
        // \Storage::disk('mailbox')->put( $especif ,  \File::get($file));
        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id'));
    }

    public function guia_egreso(Request $request, $id)
    {
        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "guia_egreso";
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);
        
        
        // $rutapdf= '';
        $mi_empresa=Empresa::first();
        $garantias_guias_egreso = GarantiaGuiaEgreso::find($id);
        $id = $garantias_guias_egreso->id;
        $ruta_retorno = 'garantia_guia_egreso.show';
        $clientes = $garantias_guias_egreso->garantia_ingreso_i->clientes_i->email;  

        $name = 'PDF-DOC-'.$garantias_guias_egreso->orden_servicio.'-'.$mi_empresa->ruc;
        
        $contacto = Contacto::all();
        $archivo = $name.".pdf";
        $pdf = PDF::loadView('transaccion.garantias.guia_egreso.show_pdf',compact('garantias_guias_egreso','mi_empresa','contacto'));
        $content = $pdf->download();

        $especif = $date.$archivo;
        // $archivo=$especif;
        // \Storage::disk('mailbox')->put( $especif ,  \File::get($file));
        Storage::disk('mailbox')->put($especif,$content);

        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id'));
    }
    public function informe_tecnico(Request $request, $id)
    {
        $id_usuario = auth()->user()->id;
        $config_email = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
        $redic = "informe_tecnico";
        $fecha = Carbon::now();
        $data_g = str_replace(' ', '_',$fecha);
        $date = str_replace(':','-',$data_g);

        $mi_empresa=Empresa::first();
        $garantias_informe_tecnico = GarantiaInformeTecnico::find($id);
        $archivo_informe_tecnico  = GarantiaInformeTecnicoArchivos::where('id_informe_tecnico',$garantias_informe_tecnico)->get();
        // $name = 'Informe_Tecnico_';
        $name = 'PDF-DOC-'.$garantias_informe_tecnico->orden_servicio.'-'.$mi_empresa->ruc;
        
        $contacto = Contacto::all();
        $id = $garantias_informe_tecnico->id;
        $ruta_retorno = 'informe_tecnico.show';
        $clientes = $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email;  
        
        $archivo=$name.".pdf";
        $pdf=PDF::loadView('transaccion.garantias.informe_tecnico.show_pdf',compact('garantias_informe_tecnico','mi_empresa','contacto','archivo_informe_tecnico'));
        $content=$pdf->download();

        $especif = $date.$archivo;
        Storage::disk('mailbox')->put($especif,$content);
        // $date = $carbon_sp;
        return view('mailbox.create',compact('archivo','clientes','redic','date','config_email','ruta_retorno','id'));
    }
}
