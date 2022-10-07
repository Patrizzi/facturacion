<?php

namespace App\Http\Controllers;

use App\Subfamilia;
use App\Familia;
use Illuminate\Http\Request;

class SubfamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store($id,Request $request)
    {
        $sub_familia_cantidad = Subfamilia::all()->count();
        $sub_familia_cantidad ++;
        $cien=1000+$sub_familia_cantidad;
        $contador=substr($cien,1);

        $familia = Familia::where('id',$id)->first();
        
        $ubicacion_padre = $familia->ubicacion;

        $subfamilia = new Subfamilia();
        $subfamilia->id_familia = $id;
        $subfamilia->codigo = $contador;
        $subfamilia->descripcion = $request->get('descripcion');
        $subfamilia->ubicacion = $ubicacion_padre.$sub_familia_cantidad;
        $subfamilia->estado = 0;
        $subfamilia->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subfamilia  $subfamilia
     * @return \Illuminate\Http\Response
     */
    public function show(Subfamilia $subfamilia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subfamilia  $subfamilia
     * @return \Illuminate\Http\Response
     */
    public function edit(Subfamilia $subfamilia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subfamilia  $subfamilia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subfamilia $subfamilia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subfamilia  $subfamilia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subfamilia $subfamilia)
    {
        //
    }
}
