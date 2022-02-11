<?php

namespace App\Http\Controllers;

use App\Banco;
use App\BancoRegistro;
use Illuminate\Http\Request;

class BancoController extends Controller
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
       $banco=Banco::find($id);
       return view('configuracion_general.empresa.banco_edit',compact('banco'));
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

      $creado_id = $request->input('creadas_id');
      if (isset($creado_id)) {
          $contador_r_creados = count($creado_id);
          $descripcion1_creadas = $request->input('descripcion1_creadas');
          $descripcion2_creadas = $request->input('descripcion2_creadas');
          for($c = 0; $c<$contador_r_creados;$c++ )
          {
            if ( empty($descripcion1_creadas[$c])  or empty($descripcion2_creadas[$c])) {
             $banco_registro=BancoRegistro::find($creado_id[$c]);
             $banco_registro->delete();
         }else{
             $banco_registro=BancoRegistro::find($creado_id[$c]);
             $banco_registro->descripcion1 = $descripcion1_creadas[$c];
             $banco_registro->descripcion2 = $descripcion2_creadas[$c];
             $banco_registro->save();
         }
     }
 }

 $descripcion1 = $request->input('descripcion1');
 if (isset($descripcion1)) {
  $contador_new = count($descripcion1);
  $descripcion2 = $request->input('descripcion2');

  for($c = 0; $c<$contador_new;$c++ )
  {
      if ($descripcion1[$c] or $descripcion2[$c] ) {
        $banco_registro = new BancoRegistro;
        $banco_registro->banco_id = $id;
        $banco_registro->descripcion1 = $descripcion1[$c];
        $banco_registro->descripcion2 = $descripcion2[$c];
        $banco_registro->save();
    }
}
}

if($request->hasfile('foto')){
    $image1 =$request->file('foto');
    $name =time().$image1->getClientOriginalName();
    $destinationPath = public_path('/img/logos/');
    $image1->move($destinationPath,$name);
}else{
    $name=$request->get('ori_foto');
}
$estado=$request->get('estado');
if ($estado=='on') { $estado_numero='0'; }
else{ $estado_numero='1';}

$banco=Banco::find($id);
        // $banco->tipo_cuenta=$request->get('tipo_cuenta');
        // $banco->numero_soles=$request->get('numero_soles');
        // $banco->numero_dolares=$request->get('numero_dolares');
$banco->foto=$name;
$banco->estado=$estado_numero;
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
