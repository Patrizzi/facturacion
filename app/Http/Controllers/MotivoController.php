<?php

namespace App\Http\Controllers;

use App\Motivo;
use Illuminate\Http\Request;

class MotivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motivos=Motivo::where('estado',0)->get();
        $id_compras = 1;
        $id_salida = 1;
        // Compras
        foreach($motivos as $motv){
            if($motv->tipo == "Sin Asignar"){
                $str_moti = explode(' ',$motv->nombre);
                if($str_moti[0] == "Compras"){
                    $motivos_compra[] = Motivo::where('id',$motv->id)->first(); 
                }elseif($str_moti[0] == "Devolucion"){
                    $motivos_dev[] = Motivo::where('id',$motv->id)->first(); 
                }
            }else{
                if($motv->tipo == "Compras"){
                    $motivos_compra[] = Motivo::where('id',$motv->id)->first(); 
                }else{
                    $motivos_dev[] = Motivo::where('id',$motv->id)->first(); 
                    
                }
            }
        }
        return view('configuracion_general.motivo.index',compact('motivos_compra','motivos_dev','id_compras','id_salida'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('configuracion_general.motivo.create');
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
        $motivo=new Motivo;
        $motivo->nombre=$request->get('nombre');
        $motivo->tipo=$request->get('tipo');
        $motivo->estado = 0;
        $motivo->save();

        return redirect()->route('motivo.index');
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
        $motivo=Motivo::find($id);
        return view('configuracion_general.motivo.edit',compact('motivo'));
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
        $motivo=Motivo::find($id);
        $motivo->nombre=$request->get('nombre');
        $motivo->tipo=$request->get('tipo');
        if($request->get('estado') == "on"){
            $motivo->estado=0;
        }else{
            $motivo->estado= 1;
        }
        $motivo->save();
        return redirect()->route('motivo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $motivo=Motivo::findOrFail($id);
        $motivo->delete();

        return redirect()->route('motivo.index');
    }
}
