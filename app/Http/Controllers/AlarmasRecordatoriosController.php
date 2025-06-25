<?php

namespace App\Http\Controllers;

use App\AlarmasRecordatorios;
use Illuminate\Http\Request;

class AlarmasRecordatoriosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alarma = AlarmasRecordatorios::all();
        $conteo = AlarmasRecordatorios::where('estado', 0)->count();
        return view('configuracion_general.alarma.index', compact('alarma', 'conteo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $alarma = new AlarmasRecordatorios;
        $alarma->descripcion = $request->get('descripcion');
        $alarma->tipo = $request->get('tipo');
        $alarma->alarma = $request->get('alarma');
        $alarma->estado = '0';
        $alarma->save();

        return redirect()->route('alarma.index');
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
     * @param  \App\AlarmasRecordatorios  $alarmasRecordatorios
     * @return \Illuminate\Http\Response
     */
    public function show(AlarmasRecordatorios $alarmasRecordatorios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AlarmasRecordatorios  $alarmasRecordatorios
     * @return \Illuminate\Http\Response
     */
    public function edit(AlarmasRecordatorios $alarmasRecordatorios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AlarmasRecordatorios  $alarmasRecordatorios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlarmasRecordatorios $alarmasRecordatorios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AlarmasRecordatorios  $alarmasRecordatorios
     * @return \Illuminate\Http\Response
     */
    public function destroy(AlarmasRecordatorios $alarmasRecordatorios)
    {
        //
    }
    public function create_with_ajax(Request $request)
    {
        // Obtener el contador de manera eficiente
        $contador = (AlarmasRecordatorios::max('id') ?? 0) + 1;
        $id = str_pad($contador, 2, '0', STR_PAD_LEFT);

        // Crear la Garantia
        AlarmasRecordatorios::create([
            'id'         => $id,
            'descripcion'    => $request->get('descripcion_alarma') ?? 'Sin descripción',
            'tipo' => $request->get('tipo_alarma') ?? 'Sin tipo',
            'alarma' => $request->get('alarma_alarma'),
            'estado'         => '0',
        ]);

        return response()->json(['success' => true, 'message' => 'Alarma creada correctamente']);
    }
    public function change_state(Request $request)
    {

        $alarma = AlarmasRecordatorios::find($request->get('id'));
        if ($alarma->estado == 0) {
            $alarma->estado = 1;
        } else {
            $alarma->estado = 0;
        }
        $alarma->save();

        return response()->json(['success' => true, 'message' => 'Estado de la alarma actualizado correctamente']);
    }

    public function edit_ajax(Request $request)
    {

        $id = $request->get('alarma_edit_id');
        $alarma = AlarmasRecordatorios::find($id);
        $cant_activo = AlarmasRecordatorios::where('estado', 0)->count();
        $unico = AlarmasRecordatorios::where('id', $id)->where('estado', 0)->first();
        if ($cant_activo == 1 && isset($unico)) {
            $estado_alarma = 0;
        }
        $alarma->descripcion = strtoupper($request->get('descripcion_alarma'));
        $alarma->tipo = strtoupper($request->get('tipo_alarma'));
        $alarma->save();
        return response()->json(['success' => true, 'alarma' => $alarma]);
    }
}
