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
    public function store(Request $request)
    {
        // return $request;
        $id_familia = $request->get('familia_id');
        $sub_familia_cantidad = Subfamilia::where('id_familia', $id_familia)->count();
        $sub_familia_cantidad ++;
        $cien=1000+$sub_familia_cantidad;
        $contador=substr($cien,1);

        $familia = Familia::where('id',$id_familia)->first();
        
        $ubicacion_padre = strval($familia->ubicacion).intval($sub_familia_cantidad);

        $subfamilia = new Subfamilia();
        $subfamilia->id_familia = $id_familia;
        $subfamilia->codigo = $contador;
        $subfamilia->descripcion = $request->get('descripcion');
        $subfamilia->ubicacion = $familia->ubicacion.$sub_familia_cantidad;
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
    public function update($id,Request $request)
    {
        // return $request;
        if($request->get('sub_familia_estado')){
            $estado = 0;
        }else{
            $estado = 1;
        }
        $subfamilia = Subfamilia::find($id);
        $subfamilia->descripcion= $request->get('descripcion');
        $subfamilia->estado = $estado;
        $subfamilia->save();
        return redirect()->back();
    }
    public function search_ajax(Request $request)
    {
        // return $request;
        $subfamilia = Subfamilia::where('id_familia', $request->familia_id)->where('estado', 0)->get();
        $response = array();
        foreach($subfamilia as $familias){
           $response[] = array(
                "id"=>$familias->id,
                "descripcion"=>$familias->descripcion
           );
        }
        return $response;
        // $familia = $request->familia_id;

        // $subfamilia = Subfamilia
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
