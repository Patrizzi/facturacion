<?php

namespace App\Http\Controllers;
use App\EmailBandejaEnvios;
use App\EmailConfiguraciones;
use App\Cliente;
use App\EmailBandejaEnviosArchivos;
use App\User;
// use App\

use Illuminate\Http\Request;

class EmailBorradoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        
        return view('mailbox.borradores.index',compact('mailbox','user','clientes','mailbox_file','config_email','count_mailbox','borradores','count_borradores','count_eliminados'));
        // return view('');
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
        return view('mailbox.borradores.show',compact('mail','archivos','clientes','config_email','mailbox_file','count_mailbox','borradores','count_borradores','count_eliminados'));
        // return view('mailbox.borradores.show',compact('mail','archivos','clientes'));
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

    public function index2()
    {
        return view('mailbox.nuevo.borrador');
    }
}
