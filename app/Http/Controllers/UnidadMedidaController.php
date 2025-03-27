<?php

namespace App\Http\Controllers;

use App\Unidad_medida;
use Illuminate\Http\Request;

class UnidadMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidad_de_medida=Unidad_medida::all();
        return view('configuracion_general.unidad-de-medida.index',compact('unidad_de_medida'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('configuracion_generall.unidad-de-medida.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Unidad_medida::create(request()->only('simbolo','medida','unidad'));

        return redirect()->route('unidad-medida.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unidad_de_medida=Unidad_medida::find($id);
        return view('configuracion_general.unidad-de-medida.edit',compact('unidad_de_medida'));
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
        $unidad_medida=Unidad_medida::find($id);
        $unidad_medida->simbolo=$request->get('simbolo');
        $unidad_medida->medida=$request->get('medida');
        $unidad_medida->unidad=$request->get('unidad');
        $unidad_medida->save();

        return redirect()->route('unidad-medida.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Unidad_medida::Destroy($id);
        return redirect()->route('unidad-medida.index');
    }

    public function create_with_ajax(Request $request){
        // Obtener el contador de manera eficiente
        $contador = (Unidad_medida::max('id') ?? 0) + 1;
        $codigo = str_pad($contador, 3, '0', STR_PAD_LEFT);


        // Crear la familia
        Unidad_medida::create([
            'simbolo'   => $request->get('simbolo_medida') ?? '',
            'nombre'    => $request->get('nombre_medida') ?? '',
            'codigo'    => $codigo,
            'unidad'    => $request->get('unidad_medida') ?? '',
        ]);

        return response()->json(['success' => true, 'message' => 'Unidad de medida creada correctamente']);
    }

    public function edit_ajax(Request $request){

        $id = $request->get('medida_edit_id');
        $medida=Unidad_medida::find($id);

        $medida->simbolo=strtoupper($request->get('simbolo_medida'));
        $medida->nombre=strtoupper($request->get('nombre_medida'));
        $medida->unidad=strtoupper($request->get('unidad_medida'));
        $medida->save();
        return response()->json(['success' => true, 'familia' => $medida]);
    }

}
