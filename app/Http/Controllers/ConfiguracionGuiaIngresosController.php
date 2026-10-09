<?php

namespace App\Http\Controllers;

use App\Banco;
use App\BancoRegistro;
use App\ConfiguracionGuiaIngresos;
use Illuminate\Http\Request;

class ConfiguracionGuiaIngresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        $tipo_configuracion=$request->get('tipo_configuracion');
        $configuracion_buscar=ConfiguracionGuiaIngresos::where('nombre',$tipo_configuracion.'_create')->where('tipo_guia','cotizacion')->first();

        if ($configuracion_buscar){
            $configuracion_edicion= ConfiguracionGuiaIngresos::find($configuracion_buscar->id);
            if ($configuracion_buscar->estado=='1'){$configuracion_edicion->estado='0';}
            else{$configuracion_edicion->estado='1';}
            $configuracion_edicion->save();
        }




        return $tipo_configuracion;
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


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
