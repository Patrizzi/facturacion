<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=auth()->user()->id;
        $config=Config::where('id',$user)->get();
        return view('configuracion_general.apariencia.index',compact('config'));
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

        // return $request;
        $apariencia=Config::find($id);
        $apariencia->fondo_perfil=$request->get('fondo_perfil');
        $apariencia->borde_foto=$request->get('borde_foto');
        $apariencia->color_borde_foto=$request->get('color_borde_foto');
        $apariencia->foto_icono=$request->get('foto_icono');
        $apariencia->letra=$request->get('letra');
        $apariencia->tamano_letra=$request->get('tamano_letra');
        $apariencia->color_sombra_nombre=$request->get('color_sombra_nombre');
        $apariencia->color_nombre=$request->get('color_nombre');
        $apariencia->tamano_letra_perfil=$request->get('tamano_letra_perfil');
        if ($request->get('remision_firma') == 'on') {
            $apariencia->guia_remision_firma = 0;
        }else{
            $apariencia->guia_remision_firma = 1;
        }
        if ($request->get('coti_firma') == 'on') {
            $apariencia->cotizacion_firma = 0;
        }else{
            $apariencia->cotizacion_firma = 1;
        }
        if ($request->get('nventa_firma') == 'on') {
            $apariencia->nventa_firma = 0;
        }else{
            $apariencia->nventa_firma = 1;
        }
        $apariencia->save();

        return redirect()->route('apariencia.index');
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
}
