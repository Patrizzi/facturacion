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
use PDF;
use Carbon\Carbon;
use DB;
use App\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_TransportException;

class EmailBandejaEnviosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index(){
      // return view('email_html.email_send_layout',compact('empresa'));
      $id_usuario=auth()->user()->id;
      $config_email=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
      // if(count($config_email) == 0){
      //   return view('mailbox.configuracion.index',compact('config_email','user','validacion'));
      // }
      
      $user=User::where('id',$id_usuario)->first();
      $clientes=Cliente::all();
      //* INVOCAR Y CONTAR PARA EL LAYOUT DE MAILBOX
      $mailbox = EmailBandejaEnvios::where('estado','0')->where('estado_borrador','0')->where('id_usuario',$id_usuario)->OrderBy('id','desc')->get();
      $borradores = EmailBandejaEnvios::where('estado','0')->where('estado_borrador','1')->where('id_usuario',$id_usuario)->OrderBy('id','desc')->get();
      $eliminados = EmailBandejaEnvios::where('estado','1')->where('id_usuario',$id_usuario)->OrderBy('id','desc')->get();
      $count_mailbox =  count($mailbox);
      $count_borradores =  count($borradores);
      $count_eliminados =  count($eliminados);
      $mailbox_file =EmailBandejaEnviosArchivos::get();
      // return $mailbox_file;
      
      return view('mailbox.index',compact('mailbox','user','clientes','mailbox_file','config_email','count_mailbox','count_borradores','count_eliminados'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create(){
      return view('mailbox.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request){
      // return $request;
      // *  Estados 0 = enviado; 1 = Eliminado 2 = borrador
      $date_sp = Carbon::now();
      $data_g = str_replace(' ', '_',$date_sp);
      $carbon_sp = str_replace(':','-',$data_g);
      $empresa = Empresa::first();

      $id_usuario=auth()->user()->id;
      $correo_busqueda=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
      $correo=$correo_busqueda->email;

      $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
      $port = $correo_busqueda->port;
      $encryption = $correo_busqueda->encryption;
      $yourEmail = $correo;
      $yourPassword = $correo_busqueda->password;
      $firma=$correo_busqueda->firma;
      $ancho= $correo_busqueda->ancho_firma;
      $alto = $correo_busqueda->alto_firma;
      $sendto = $request->get('remitente');
      $cc_email = $request->get('cc_email');
      $titulo = $request->get('asunto');
      $mensaje_html = $request->get('mensaje');
      $mensaje = view('email_html.email_send_layout',compact('empresa','mensaje_html','firma','alto','ancho'));
      $correos_envios = [$sendto, $cc_email,$correo_busqueda->email_backup];
      //* FILTRO PARA ELIMINAR LOS VACIOS EN ARRAY
      $mails_array = array_filter($correos_envios);
      //* Archivos
      $newfile = $request->file('archivos');
      //* Cuando se reenvia
      $reenvios = $request->get('archivo_reenvio');
      if(isset($reenvios)){
          // return $old_file;
        foreach($reenvios as $name){
          $var = str_replace(':', '-',$name);
          $old_file[] = substr_replace($var,'_',10,1);
        }
        // return $old_file;
      }
      
      if ( $request->get('boton_send') == true) {
        // * VALIDACION PARA VERIFICAR LA CONFIGURACION 
        $transport = (new Swift_SmtpTransport($smtpAddress, $port, $encryption)) 
          ->setUsername($yourEmail) 
          ->setPassword($yourPassword);
        $mailer = new Swift_Mailer($transport);
        $mailer->getTransport()->start();
        
        $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo($mails_array)->setBody($mensaje, 'text/html');
        
        if($request->hasfile('archivos')){
          foreach ($newfile as $file) {
            $nombre =  $file->getClientOriginalName();
            $especif = $carbon_sp.$nombre;
            \Storage::disk('mailbox')->put( $especif ,  \File::get($file));
            $news = public_path().'/archivos/'.$especif;
            $message->attach(\Swift_Attachment::fromPath($news));
          }
        }
        //* Archivos que se reenvian
        if($request->get('archivo_reenvio')){
          foreach ($old_file as $file_old) {
            $news2 = public_path().'/archivos/'.$file_old;
            $message->attach(\Swift_Attachment::fromPath($news2));
          }
        }
        if($mailer->send($message)){
          $mensaje = $request->get('mensaje') ;
          $texto = strip_tags($mensaje);
          $mail = new EmailBandejaEnvios;
          $mail->id_usuario = auth()->user()->id;
          $mail->destinatario = $correo;
          $mail->remitente = json_encode($mails_array) ;
          $mail->asunto = $request->get('asunto') ;
          $mail->mensaje = $mensaje;
          $mail->mensaje_sin_html =$texto ;
          $mail->estado = '0';
          $mail->fecha_hora =Carbon::now() ;
          $mail-> save();
          
          // $newfile2 = $request->file('archivos');
          if($request->hasfile('archivos')){
            foreach ($newfile as $file2) {
              $guardar_email_archivo= new EmailBandejaEnviosArchivos;
              $guardar_email_archivo->id_bandeja_envios = $mail->id;
              $guardar_email_archivo->archivo = $file2->getClientOriginalName();
              $guardar_email_archivo->fecha_hora = $carbon_sp;
              $guardar_email_archivo->save();
            }
          }
          if($request->get('archivo_nombre')){
            foreach ($old_file as $file2) {
              $guardar_email_archivo= new EmailBandejaEnviosArchivos;
              $guardar_email_archivo->id_bandeja_envios = $mail->id;
              $guardar_email_archivo->archivo = $file2;
              $guardar_email_archivo->fecha_hora = $carbon_sp;
              $guardar_email_archivo->save();
            }
          }
          return redirect()->route('email.index');
        }
      }else{ //* GUARDAR COMO BORRADOR
        $mensaje =$request->get('mensaje') ;
        $texto= strip_tags($mensaje);
        $mail = new EmailBandejaEnvios;
        $mail->id_usuario = auth()->user()->id;
        $mail->destinatario = $correo;
        $mail->remitente = json_encode($mails_array) ;
        $mail->asunto = $request->get('asunto') ;
        $mail->mensaje = $mensaje;
        $mail->mensaje_sin_html = $texto ;
        $mail->estado = '0';
        $mail->estado_borrador = '1';
        $mail->fecha_hora =Carbon::now() ;
        $mail-> save();
        
        if($request->hasfile('archivos')){
          foreach ($newfile as $file2) {
            $guardar_email_archivo=new EmailBandejaEnviosArchivos;
            $guardar_email_archivo->id_bandeja_envios=$mail->id;
            $guardar_email_archivo->archivo= $file2->getClientOriginalName();
            $guardar_email_archivo->fecha_hora = $carbon_sp;
            $guardar_email_archivo->save();
          }
        }
        if($request->get('archivo_nombre')){
          foreach ($old_file as $file2) {
            $guardar_email_archivo=new EmailBandejaEnviosArchivos;
            $guardar_email_archivo->id_bandeja_envios=$mail->id;
            $guardar_email_archivo->archivo= $file2;
            $guardar_email_archivo->fecha_hora = $carbon_sp;
            $guardar_email_archivo->save();
          }
        }
      }
      return redirect()->route('email.index');
    }

   
    public function send(Request $request){
      // return $request;
      $cancelar = $request->get('boton_cancelar');
      $pdf = $request->get('pdf');
      $dates = $request->get('dates');
      // return $pdf;
      if(isset($cancelar)){
        $retorno = $request->get('retorno');
        $id = $request->get('id');
        Storage::disk('mailbox')->delete($dates.$pdf);
        return redirect()->route(''.$retorno.'',$id);
        // return redirect()->route('cotizacion.show',$cotizacion->id);
      }
      // return $request;
      $id_usuario=auth()->user()->id;
      $date_sp = Carbon::now();
      $data_g = str_replace(' ', '_',$date_sp);
      $carbon_sp = str_replace(':','-',$data_g);
      $empresa = Empresa::first();
      
      $config_mail = EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
      $yourEmail = $config_mail->email;
      $cc_email  = $request->get('cc_email');

      $firma=$config_mail->firma;
      $alto = $config_mail->alto_firma;
      $ancho = $config_mail->ancho_firma;
      $mensaje_html = $request->get('mensaje');
      /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL

      $sendto = $request->get('remitente');
      $titulo = $request->get('asunto');
      $mensaje = view('email_html.email_send_layout',compact('empresa','mensaje_html','firma','alto','ancho'));
      //* ARRAY PARA ENVIOS CON MULTIPLES CC
      $correos_envios = [$sendto , $cc_email , $config_mail->email_backup];
      $mails_array = array_filter($correos_envios);
      
      //* ARCHIVOS
      $pdf = $request->get('pdf');
      
      $pdfile = public_path().'/archivos/'.$dates.$pdf;
      $newfile = $request->file('archivos');
      
      //* VALIDACION PARA EL ENVIO
      $transport = (new \Swift_SmtpTransport($config_mail->smtp, $config_mail->port, $config_mail->encryption)) 
        -> setUsername($config_mail->email) 
        -> setPassword($config_mail->password);
      $mailer = new \Swift_Mailer($transport);
      $mailer->getTransport()->start();
      
      $message = (new \Swift_Message($yourEmail)) -> setFrom([ $yourEmail => $titulo]) -> setTo($mails_array) -> setBody($mensaje, 'text/html');
      
      $message->attach(\Swift_Attachment::fromPath($pdfile));
      
      if($request->hasfile('archivos')){
        foreach ($newfile as $file) {
          $nombre =  $file->getClientOriginalName();
          $especif = $carbon_sp.$nombre;
          \Storage::disk('mailbox')->put( $especif ,  \File::get($file));
          $news = public_path().'/archivos/'.$especif;
          $message->attach(\Swift_Attachment::fromPath($news));
        }
      }
      //*xml
      if($request->get('archivo_nombre')){
        $xml = $request->get('archivo_nombre');
        $news2 = public_path().'/facturas_electronicas/'.$xml;
        $message->attach(\Swift_Attachment::fromPath($news2));
      }
      if($mailer->send($message)){
        $mensaje =$request->get('mensaje') ;
        $texto= strip_tags($mensaje);
        $mail = new EmailBandejaEnvios;
        $mail->id_usuario = auth()->user()->id;
        $mail->destinatario = $yourEmail;
        $mail->remitente = $request->get('remitente') ;
        $mail->asunto = $request->get('asunto') ;
        $mail->mensaje = $mensaje;
        $mail->mensaje_sin_html = $texto ;
        $mail->estado= '0';
        $mail->fecha_hora =Carbon::now();
        $mail->save();

        $newfile2 = $request->file('archivos');
        if($request->hasfile('archivos')){
          foreach ($newfile2 as $file2) {
            $guardar_email_archivo=new EmailBandejaEnviosArchivos;
            $guardar_email_archivo->id_bandeja_envios=$mail->id;
            $guardar_email_archivo->archivo= $file2->getClientOriginalName();
            $guardar_email_archivo->fecha_hora= $carbon_sp;
            $guardar_email_archivo->save();
          }
        }
        if($request->get('archivo_nombre')){
          $guardar_email_archivo=new EmailBandejaEnviosArchivos;
          $guardar_email_archivo->id_bandeja_envios=$mail->id;
          $guardar_email_archivo->archivo= $xml;
          $guardar_email_archivo->fecha_hora = $carbon_sp;
          $guardar_email_archivo->save();
        }
        $archivo_pdf = new EmailBandejaEnviosArchivos;
        $archivo_pdf->id_bandeja_envios=$mail->id;
        $archivo_pdf->archivo=$pdf;
        $archivo_pdf->fecha_hora= $dates;
        $archivo_pdf->save();

        return redirect()->route('email.index');
      }
      return "Something went wrong :(";
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // * Vista de enviar a a la papelera
    public function trash()
    {
      $id_usuario=auth()->user()->id;
      $user=User::where('id',$id_usuario)->first();
      $clientes=Cliente::all();
      $config_email=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
      // $verificacion_mail=EmailConfiguraciones::where('id_usuario',$user->id)->first();
      if(isset($verificacion_mail)){
          $validacion = 'MAIL';
          // $config_email = EmailConfiguraciones::where('id_usuario',$user->id)->first();
      }else{
          $validacion = 'DISMAIL';
      }
      //* INVOCAR Y CONTAR PARA EL LAYOUT DE MAILBOX
      $mailbox = EmailBandejaEnvios::where('estado','0')->where('estado_borrador','0')->where('id_usuario',$id_usuario)->OrderBy('id','desc')->get();
      $borradores = EmailBandejaEnvios::where('estado','0')->where('estado_borrador','1')->where('id_usuario',$id_usuario)->OrderBy('id','desc')->get();
      $eliminados = EmailBandejaEnvios::where('estado','1')->where('id_usuario',$id_usuario)->OrderBy('id','desc')->get();
      $count_mailbox = count($mailbox);
      $count_borradores = count($borradores);
      $count_eliminados = count($eliminados);
      $mailbox_file =EmailBandejaEnviosArchivos::get();
      return view('mailbox.delete',compact('mailbox','mailbox_file','count_mailbox','config_email','user','validacion','clientes','count_borradores','count_eliminados','eliminados'));

    }

    public function delete(Request $request){
      // return $request;
      $check_ids =  $request->get('check_input'); 
      // * Estado '1' = Papelera
      foreach($check_ids as $ids){
        $mail = EmailBandejaEnvios::find($ids);
        $mail->estado = '1';
        $mail->save();
      }
      
      return redirect()->route('email.index');
    }
    

    public function show($id)
    {
      // return $id;
      $id_usuario=auth()->user()->id;
      $mail=EmailBandejaEnvios::find($id);
      $clientes=Cliente::all();
      $archivos=EmailBandejaEnviosArchivos::where('id_bandeja_envios', $mail->id)->get();
      $config_email=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
      //* INVOCAR Y CONTAR PARA EL LAYOUT DE MAILBOX
      $mailbox = EmailBandejaEnvios::where('estado','0')->where('estado_borrador','0')->where('id_usuario',$id_usuario)->OrderBy('id','desc')->get();
      $borradores = EmailBandejaEnvios::where('estado','0')->where('estado_borrador','1')->where('id_usuario',$id_usuario)->OrderBy('id','desc')->get();
      $eliminados = EmailBandejaEnvios::where('estado','1')->where('id_usuario',$id_usuario)->OrderBy('id','desc')->get();
      $count_mailbox =  count($mailbox);
      $count_borradores =  count($borradores);
      $count_eliminados =  count($eliminados);
      $mailbox_file =EmailBandejaEnviosArchivos::get();
      // return $mailbox_file;
      
      // return view('mailbox.index',compact('mailbox','user','clientes','mailbox_file','config_email','count_mailbox','count_borradores','count_eliminados'));
      return view('mailbox.show',compact('mail','archivos','clientes','mailbox_file','config_email','count_mailbox','count_borradores','count_eliminados'));
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
    public function destroy(Request $request)
    {
      // return $request;
      $check_ids = $request->get('check_input');

      foreach($check_ids as $ids){
        $email_busq=EmailBandejaEnvios::find($ids);
        $email_files=EmailBandejaEnviosArchivos::where('id_bandeja_envios',$email_busq->id)->get();
        //* ELIMNAR ARCHIVOS DE LA CARPETA PUBLIC
        foreach($email_files as $files ){
          Storage::disk('mailbox')->delete($files->fecha_hora.$files->archivo);
        }
        $email=EmailBandejaEnvios::findOrFail($email_busq->id);
        $email->delete();
      }
      return redirect()->route('email.trash');
    }

    public function configstore(Request $request){
        $this->validate($request,[
            'email' => ['required','email','unique:email_configuraciones,email'],
        ],[
            'email.unique' => 'El correo ya existe',
        ]);

        $correo = $request->get('email');
        // firna para outlook
        if($request->hasfile('firma')){
            $image1 =$request->file('firma');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/firmas/');
            $image1->move($destinationPath,$name);
        }else{
            $name="";
        }

        $ancho=$request->get('ancho_firma');
        $alto =$request->get('alto_firma');

        if( $ancho == "" || $alto  == ""){
            $ancho = '150';
            $alto = '100';

        }

        if($request->hasfile('firma_digital')){
            $image2 =$request->file('firma_digital');
            $firma_d=time().$image2->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/firma_digital/');
            $image2->move($destinationPath,$firma_d);
        }else{
            $firma_d="";
        }

        $id_usuario=auth()->user()->id;
        $configmail = new EmailConfiguraciones;
        $configmail->id_usuario =auth()->user()->id;
        $configmail->email =$correo ;
        $configmail->password = $request->get('password') ;
        $configmail->email_backup = 'desarrollo@jypsac.com';
        $configmail->smtp =$request->get('smtp') ;
        $configmail->port = $request->get('port');
        $configmail->firma = $name;
        $configmail->ancho_firma= $ancho;
        $configmail->alto_firma= $alto;
        $configmail->encryption= $request->get('encryp') ;
        $configmail->firma_digital = $firma_d;
        $configmail-> save();

        $user=User::find($id_usuario);
        $user->email_creado='1';
        $user->save();
        return back();
    }


    public function configupdate(Request $request,$id){
      $this->validate($request,[
            'email' => ['required','email','unique:email_configuraciones,email,'.$id],
        ],[
            'email.unique' => 'El correo ya existe',
        ]);


        $correo = $request->get('email');
         if($request->hasfile('firma')){
            $image1 =$request->file('firma');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/firmas/');
            $image1->move($destinationPath,$name);
        }else{
            $name=$request->get('firma_nombre') ;
        }
        if($request->hasfile('firma_digital')){
            $image2 =$request->file('firma_digital');
            $firma_d =time().$image2->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/firma_digital/');
            $image2->move($destinationPath,$firma_d);
        }else{
            $firma_d=$request->file('firma_digital');;
        }

        $configmail=EmailConfiguraciones::find($id);
        $configmail->email = $correo ;
        $configmail->password = $request->get('password') ;
        $configmail->smtp =$request->get('smtp') ;
        $configmail->port = $request->get('port');
        $configmail->encryption= $request->get('encryp') ;
        $configmail->firma = $name;
        $configmail->ancho_firma=$request->get('ancho_firma');
        $configmail->alto_firma =$request->get('alto_firma');
        $configmail->firma_digital = $firma_d;
        $configmail->save();
        return redirect()->route('email.index');
    }
}

