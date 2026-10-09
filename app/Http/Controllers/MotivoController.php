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
            if($motv->tipo != "Compras" || $motv->tipo != "Salidas"){
                $str_moti = explode(' ',$motv->nombre);
                if($str_moti[0] == "Compras"){
                    $motivo_ed = Motivo::where('id',$motv->id)->first();
                    $motivo_ed->tipo = "Compras";
                    $motivo_ed->save();
                }elseif($str_moti[0] == "Devolucion"){
                    $motivo_ed = Motivo::where('id',$motv->id)->first();
                    $motivo_ed->tipo = "Salidas";
                    $motivo_ed->save();
                }
            }
        }
        $motivos_compra=Motivo::where('estado',0)->where('tipo', 'Compras')->get();
        $motivos_dev=Motivo::where('estado',0)->where('tipo', 'Salidas')->get();

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

    public function create_with_ajax(Request $request){

        // Obtener el contador de manera eficiente
        $contador = (Motivo::max('id') ?? 0) + 1;
        $codigo = str_pad($contador, 5, '0', STR_PAD_LEFT);

        // Crear la motivo
        Motivo::create([
            'nombre'        => $request->get('nombre_motivos') ?? '',
            'tipo'          => $request->get('select_motivos') ?? '',
            'estado'        => '0',
        ]);

        return response()->json(['success' => true, 'message' => 'Motivo creada correctamente']);
    }

    public function change_state(Request $request){

        $marca = Motivo::find($request->get('id'));
        if($marca->estado == 0){
            $marca->estado = 1;
        }else{
            $marca->estado = 0;
        }
        $marca->save();

        return response()->json(['success' => true, 'message' => 'Estado de la motivo actualizado correctamente']);
    }

    public function edit_ajax(Request $request){

        $id = $request->get('motivos_edit_id');
        $motivo=Motivo::find($id);

        $cant_activo=Motivo::where('estado',0)->count();
        $unico=Motivo::where('id',$id)->where('estado',0)->first();
        if ($cant_activo==1 && isset($unico)) {
          $estado_marca = 0;
      }

        $motivo->nombre=$request->get('nombre_motivos');
        $motivo->tipo=$request->get('select_motivos');
        $motivo->save();
        return response()->json(['success' => true, 'motivos' => $motivo]);
    }
}
