<?php

namespace App\Http\Controllers;
use App;
use App\Boleta_registro;
use App\Boleta;
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
use App\facturacion_registro;
use App\Cotizacion_Servicios;
use App\Cotizacion_factura_registro;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_Servicios_factura_registro;
use App\Cotizacion_Servicios_boleta_registro;
use App\kardex_entrada_registro;
use App\Guia_remision;
use App\g_remision_registro;
use App\Igv;
use App\NotaVenta;
use App\NotaVentaRegistro;
use App\GarantiaInformeTecnicoArchivos;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
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
    public function cotizacion(Request $request, $id){

        // $id_usuario = auth()->user()->id;
        return $request;
        $date_sp = Carbon::now();
        $data_g = str_replace(' ', '_',$date_sp);
        $carbon_sp = str_replace(':','-',$data_g);
        $tipo = $request->get('tipo');
        $id =$request->get('id');
        $redic=$request->get('redict');
        $clientes=$request->get('cliente');

        $rutapdf = 'transaccion.venta.cotizacion.pdf2';
        $name = 'Cotizacion_Producto_';
        $banco=Banco::where('estado','0')->get();
        $banco_count=Banco::where('estado','0')->count();
        $cotizacion=Cotizacion::find($id);
        $regla=$cotizacion->tipo;
        $sub_total=0;
        $igv=Igv::first();
        /*registros boleta y factura*/
        // if($regla=='factura'){
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
        // }elseif($regla=='boleta'){
        // $cotizacion_registro=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
        // }
        /* FIN registros boleta y factura*/

        /*de numeros a Letras*/
        $sub_total = $cotizacion->op_gravada+$cotizacion->op_exonerada+$cotizacion->op_inafecta;
        $igv_p=round($cotizacion->op_gravada, 2)*$igv->igv_total/100;
        if ($regla=='factura') {
        $end=round($sub_total, 2)+round($igv_p, 2);
        $end2=number_format(round($sub_total, 2)+round($igv_p, 2),2);
        }elseif ($regla=='boleta'){
        $end=round($sub_total, 2);
        $end2=number_format(round($sub_total, 2),2);

        }
        /* Finde numeros a Letras*/
        $firma = EmailConfiguraciones::where('id_usuario',$cotizacion->user_id)->pluck('firma_digital')->first();
        $empresa=Empresa::first();
        $sum=0;
        $i=1;
        $regla=$cotizacion->tipo;
        $cotizacion_factura = ' ';
        // return $cotizacion;
        // $archivo=$cotizacion->cod_cotizacion.
        $archivo='PDF-DOC-'.$cotizacion->cod_cotizacion.'-'.$empresa->ruc.".pdf";
        $pdf=PDF::loadView($rutapdf,compact($redic,'cotizacion','empresa','cotizacion_registro','regla','sum','igv','sub_total','banco','i','end','igv_p','banco_count','firma','end2'));
        $content = $pdf->download();
        $especif = $carbon_sp.$archivo;
        Storage::disk('mailbox')->put($especif,$content);
        $date = $carbon_sp;
      
        return view('mailbox.create',compact('archivo','clientes','redic','date'));
    }
}
