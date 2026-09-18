<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Moneda;
use App\Pais;
use App\TipoCambio;
use Illuminate\Http\Request;

class MonedaController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
       $id_mone_principal=$request->get('id_moneda');

       $buscar_principal=Moneda::where('principal',1)->first();

       $cambio_moneda_secundario=Moneda::find($buscar_principal->id); /*Cambio de moneda de empresa*/
       $cambio_moneda_secundario->principal=0;
       $cambio_moneda_secundario->save();

       $cambio_moneda_primario=Moneda::find($id_mone_principal);
       $cambio_moneda_primario->principal=1;
       $cambio_moneda_primario->save();

       $empresa=Empresa::find(1); /*Cambio de moneda de empresa*/
       $empresa->moneda_principal=$id_mone_principal;
       $empresa->save();

       $tipo_cambio=TipoCambio::latest('created_at')->first();
       $tipo_cambio_delete=TipoCambio::findOrFail($tipo_cambio->id);
       $tipo_cambio_delete->delete();
       return redirect()->route('empresa.index');
   }

   public function principal($id)
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
