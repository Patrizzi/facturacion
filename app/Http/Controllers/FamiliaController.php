<?php

namespace App\Http\Controllers;

use App\Familia;
use App\Subfamilia;

use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $familias=Familia::all();
        $conteo=Familia::where('estado','0')->count();
        return view('configuracion_general.familia.index',compact('familias','conteo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('configuracion_general.familia.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $suma=Familia::all()->count();
        $suma ++;
        $cien=1000+$suma;
        $contador=substr($cien,1);
        $nombre=$request->get('descripcion');

        if (empty($nombre)) {
            return redirect()->route('familia.index')->withErrors(['Descripción Vacía, Debe ingresar Registros']);
        }

        $nombre=strtoupper($nombre);

        //obtener la letra
        // return $suma;
        if($suma > 0){
            $fami = Familia::latest()->first();
            $letra_ubicacion = preg_replace('/[^a-z áéíóúÁÉÍÓÚñÑ ]/iu', '', $fami->ubicacion); // letra
            
            // letra aumentado
            for ($e=0; $e<1; $e++) {
                $letra2 =  ++$letra_ubicacion;
            }
            
            // Numero aumentado
            for ($e=0; $e<1; $e++) {
                $num =  ++$fami->id;
            }
            $ubicacion = intval($num).$letra2;
        }else{
            $ubicacion= '1A';
        }
        // return var_dump($letra2);
        // Suma de Numero
        // for ($n=0; $n<1; $n++) {
        //     $var1 =  ++$suma . PHP_EOL;
        // }
        // Suma de Letras
        // for ($e=0; $e<1; $e++) {
        //     $letra2 =  ++$letra_ubicacion . PHP_EOL;
        // }
        // $var3 = intval($var1).$letra2;

        // $letraAleatoria = rand(ord($init_letra), ord($fin_letra));
        $familia=new Familia;
        $familia->codigo=$contador;
        $familia->descripcion=$nombre;
        $familia->ubicacion=$ubicacion;
        $familia->estado='0';
        $familia->save();

        return redirect()->route('familia.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $familia = Familia::find($id);
        $subfamilias = Subfamilia::where('id_familia', $familia->id)->get();
        
        // $subfamilias = Su
        return view('configuracion_general.familia.show',compact('familia','subfamilias'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $familia=Familia::find($id);
        return view('configuracion_general.familia.edit',compact('familia'));
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
        //ESTADO
        $estado = $request->get('estado');
        $nombre=$request->get('descripcion');

        if($estado == "on" ){
            $estado_familia = 0;
        }else{
            $estado_familia = 1;
        }
        if (empty($nombre)) {
            return redirect()->route('familia.index')->withErrors(['Descripción Vacía, Debe ingresar Registros']);

        }

        $cant_activo=Familia::where('estado',0)->count();
        $unico=Familia::where('id',$id)->where('estado',0)->first();
        if ($cant_activo==1 && isset($unico)) {
            $estado_familia = 0;
      }

      $nombre=strtoupper($nombre);
      $familia=Familia::find($id);
      $familia->descripcion=$nombre;
      $familia->estado=$estado_familia;
      $familia->save();

      return redirect()->back();

  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $familia=Familia::findOrFail($id);
        $familia->delete();

        return redirect()->route('familia.index');
    }
}
