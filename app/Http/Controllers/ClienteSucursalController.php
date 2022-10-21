<?php

namespace App\Http\Controllers;

use App\Cliente_sucursal;
use App\Cliente;
use Illuminate\Http\Request;

class ClienteSucursalController extends Controller
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
    
    // public function ajax_dep(){
    // }
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
    public function store(Request $request, $id)
    {
        // return "store"; 
        // return $request;
        $nombre = $request->get('nombre');
        $sucursal_cli = Cliente_sucursal::where('cliente_id',$id)->get()->count();
        return $sucursal_cli;
        if($nombre == null){
            $nombre_suc = 'Sucursal '.intval($sucursal_cli); 
        }else{
            $nombre_suc = $nombre;
        }
        if($request->get('estado_id')){
            $estado = 0;
        }else{
            $estado = 1;
        }
        $cliente_sucursal = new Cliente_sucursal();
        $cliente_sucursal->cliente_id = $id; 
        $cliente_sucursal->nombre = $nombre_suc;
        $cliente_sucursal->pais = $request->get('pais');
        $cliente_sucursal->direccion = $request->get('direccion');
        $cliente_sucursal->departamento = $request->get('departamento');
        $cliente_sucursal->provincia = $request->get('provincia');
        $cliente_sucursal->distrito = $request->get('distrito');
        $cliente_sucursal->cod_postal = $request->get('cod_postal');
        $cliente_sucursal->estado = $estado;
        $cliente_sucursal->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente_sucursal  $cliente_sucursal
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente_sucursal $cliente_sucursal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente_sucursal  $cliente_sucursal
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente_sucursal $cliente_sucursal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente_sucursal  $cliente_sucursal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // return $request;
        $nombre = $request->get('nombre');
        // $sucursal_cli = Cliente_sucursal::where('cliente_id',$id)->get()->count();
        $sucursal_cli = Cliente_sucursal::where('id',$id)->first();
        // return $sucursal_cli;
        if($nombre == null){
            $nombre_suc = 'Sucursal '.$sucursal_cli->id; 
        }else{
            $nombre_suc = $sucursal_cli->nombre;
        }
        if($request->get('estado_id')){
            $estado = 1;
        }else{
            $estado = 0;
        }
        $cliente_sucursal = new Cliente_sucursal();
        $cliente_sucursal->cliente_id = $id; 
        $cliente_sucursal->nombre = $nombre_suc;
        $cliente_sucursal->pais = $request->get('pais');
        $cliente_sucursal->direccion = $request->get('direccion');
        $cliente_sucursal->departamento = $request->get('departamento');
        $cliente_sucursal->provincia = $request->get('provincia');
        $cliente_sucursal->distrito = $request->get('distrito');
        $cliente_sucursal->cod_postal = $request->get('cod_postal');
        $cliente_sucursal->estado = $estado;
        $cliente_sucursal->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente_sucursal  $cliente_sucursal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente_sucursal $cliente_sucursal)
    {
        //
    }
}
