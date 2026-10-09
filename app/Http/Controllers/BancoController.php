<?php

namespace App\Http\Controllers;

use App\Banco;
use App\BancoRegistro;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    public function search_registros(Request $request){
        $id_banco = $request->get('id_bancos');
        $banco_reg = BancoRegistro::where('banco_id', $id_banco)->get();
        return $banco_reg;
    }
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
        $banco = Banco::find($id);
        return view('configuracion_general.empresa.banco_edit', compact('banco'));
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
        $creado_id = $request->input('creadas_id');
        
        $banco_registro_all = BancoRegistro::where('banco_id', $id)->get();

        //ELIMINACION DE REGISTROS
        $value_el = $request->get('value_eliminar');
        // return count($value_el);
        if ($value_el != null) {
            foreach ($value_el as $key => $delete) {
                if ($delete != 0) {
                    $banco_registro = BancoRegistro::find($delete);
                    $banco_registro->delete();
                }
            }
        }
        
        //EDITAR REGISTROS EXISTENTES
        foreach ($banco_registro_all as $key => $b_reg) {
            foreach ($creado_id as $key2 => $create_i) {
                if ($b_reg->id == $create_i && $b_reg->id != $value_el[$key]) {
                    $contador_r_creados = count($creado_id);
                    $descripcion1_creadas = $request->input('descripcion1_creadas')[$key2];
                    $descripcion2_creadas = $request->input('descripcion2_creadas')[$key2];
                    $moneda_creada = $request->input('moneda_creada')[$key2];
                    $detraccion = $request->input('det_creada')[$key2];
                    if($detraccion == "on"){ 
                        $detra =  '1'; 
                    }else{ 
                        $detra =  '0'; 
                    }
                    $banco_registro = BancoRegistro::find($create_i);
                    $banco_registro->tipo_cuenta = $descripcion1_creadas;
                    $banco_registro->nombre_cuenta = $descripcion2_creadas;
                    $banco_registro->moneda_id = $moneda_creada;
                    $banco_registro->estado_detraccion = $detra;
                    $banco_registro->save();
                }
            }
        }
        //CREACION DE NUEVOS REGISTROS
        // foreach ($variable as $key => $value) {

        $descripcion1 = $request->input('descripcion1');
        if (isset($descripcion1)) {
            $contador_new = count($descripcion1);
            $descripcion2 = $request->input('descripcion2');
            $moneda = $request->input('moneda');
            $detrac = $request->input('detrac');
            if($detrac == "on"){ 
                $detra2 =  '1'; 
            }else{ 
                $detra2 =  '0'; 
            }
            for ($c = 0; $c < $contador_new; $c++) {
                if ($descripcion1[$c] or $descripcion2[$c]) {
                    $banco_registro = new BancoRegistro;
                    $banco_registro->banco_id = $id;
                    $banco_registro->tipo_cuenta = $descripcion1[$c];
                    $banco_registro->nombre_cuenta = $descripcion2[$c];
                    $banco_registro->moneda_id = $moneda[$c];
                    $banco_registro->estado_detraccion = $detra2;
                    $banco_registro->save();
                }
            }
        }

        // GUARDADO DE CONFIGURACION DE BANCO CABECERA
        if ($request->hasfile('foto')) {
            $image1 = $request->file('foto');
            $name = time() . $image1->getClientOriginalName();
            $destinationPath = public_path('/img/logos/');
            $image1->move($destinationPath, $name);
        } else {
            $name = $request->get('ori_foto');
        }
        $estado = $request->get('estado');
        if ($estado == 'on') {
            $estado_numero = '0';
        } else {
            $estado_numero = '1';
        }

        $banco = Banco::find($id);
        $banco->foto = $name;
        $banco->nombre_banco = $request->get('nombre_banco');
        $banco->titular = $request->get('titular');
        $banco->estado = $estado_numero;
        $banco->save();

        return redirect()->route('empresa.index');
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
