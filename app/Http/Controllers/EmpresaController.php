<?php

namespace App\Http\Controllers;

use App\Banco;
use App\BancoRegistro;
use App\Empresa;
use App\Moneda;
use App\Pais;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $mi_empresa=Empresa::first();
        $banco=Banco::all();
        $moneda=Moneda::all();
        $banco_registro=BancoRegistro::all();
        //CONFIGURACION ADICINAL
        foreach ($banco as $key => $bn) {
            $bn_reg = BancoRegistro::where('banco_id',$bn->id)->get();
            if(count($bn_reg) == 0){
                $bn->estado = 1;
                $bn->save();
            }
        }
        $paises = Pais::get();
        return view('configuracion_general.empresa.index',compact('mi_empresa','banco','banco_registro','moneda','paises'));
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
        //
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
        $empresa = Empresa::find($id);
        if($request->hasfile('ori_foto')){
            $image1 = $request->file('ori_foto');
            $name = $image1->getClientOriginalName();
            $destinationPath = public_path('/img/logos/');
            $image1->move($destinationPath,$name);
        }else{
            $name = $empresa->foto;
        }
        $empresa = Empresa::find($id);
        $empresa->telefono = $request->get('telefono');
        $empresa->movil = $request->get('movil');
        $empresa->correo = $request->get('correo');
        $empresa->pais = $request->get('pais');
        $empresa->region_provincia = $request->get('region_provincia');
        $empresa->ciudad = $request->get('ciudad');
        $empresa->calle = $request->get('calle');
        $empresa->codigo_postal = $request->get('codigo_postal');
        $empresa->rubro = $request->get('rubro');
        $empresa->descripcion = $request->get('descripcion');
        $empresa->pagina_web = $request->get('pagina_web');
        $empresa->foto = $name;
        $empresa->save();
        return back();
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